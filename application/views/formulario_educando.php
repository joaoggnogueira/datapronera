<?php
$this->session->set_userdata('curr_content', 'educando');
if ($operacao == 'add')
    $retrivial = false;
else
    $retrivial = true;
?>
<script type="text/javascript">
    var id = "<?php echo $educando['id']; ?>";
    var urlEstados = "<?php echo site_url('requisicao/get_estados'); ?>";
    var urlAcampamentos = "<?php echo site_url('educando/get_tipo_acamp') . '/'; ?>" + id;

    //var oTable;
    $(document).ready(function () {

        // recupera estados e municipios selecionando oque está no banco de dados
        $.get(urlEstados, function (estados) {
            $('#educando_sel_est').html(estados);
            $('#educando_sel_mun').html('<option> Selecione o Estado </option>');
        }).done(function () {
            //Deixa selecionado o estado atual se caso for update
            var idEstado = <?php
            if (array_key_exists(0, $municipio_estado))
                echo $municipio_estado[0]->estado;
            else
                echo 0;
            ?>;
            if (idEstado > 0) {
                $('#educando_sel_est option[value="' + idEstado + '"]').attr('selected', true);
                appendSelectorToASSENTAMENTO();

                var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";
                //função adaptada do listCities(); localizado em functions.js
                $('#educando_sel_est').change(function () {
                    var idEstado = $('#educando_sel_est').val();
                    $('#educando_sel_mun').html("<option>Aguarde...</option>");
                    $.get(urlMunicipios + '/' + idEstado, function (cities) {
                        $('#educando_sel_mun').html(cities);
                    }).done(function () {
                        var idMunicipio = <?php
                        if (array_key_exists(0, $municipio_estado))
                            echo $municipio_estado[0]->cidade;
                        else
                            echo 0;
                        ?>;
                        $('#educando_sel_mun option[value="' + idMunicipio + '"]').attr('selected', true);
                    });
                }).change();

            } else {
                var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";
                $("#educando_sel_est").listCities(urlMunicipios, 'educando_sel_mun');
            }
        });


        var url = "<?php echo site_url('request/get_educando_mun') . '/'; ?>" + id;

        var appendSelectorToASSENTAMENTO = function () {
            if (!$("#ckNome_terr_ni").prop("checked")) {
                var urlAssentamentos = "<?php echo site_url('requisicao/get_assentamentos') . '/'; ?>" + $('#educando_sel_est option:selected').val();
                $.get(urlAssentamentos, function (assentamentos) {
                    try { $("#educando_nome_terr").select2('destroy'); } catch (e) {}
                    $("#educando_nome_terr").remove();
                    $("#educando_territorio").append($('<select class="form-control" name="educando_nome_terr" id="educando_nome_terr">')
                            .append('<option selected disabled value="">Selecione</option>')
                            .append(assentamentos));
                    <?PHP if ($retrivial && $dados[0]->tipo_territorio == "ASSENTAMENTO" && $dados[0]->code_sipra_assentamento): ?>
                        $('#educando_nome_terr option[value="<?= $dados[0]->code_sipra_assentamento ?>"]').attr('selected', true);
                    <?PHP endif; ?>
                    $('#educando_nome_terr').select2();
                });
            }
        };

        var removeSelectorToASSENTAMENTO = function () {
            try {
                $("#educando_nome_terr").select2('destroy');
            } catch (e) {
            }
            $("#educando_nome_terr").remove();
            $("#educando_territorio").append('<input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr">');
        };

        //ATUALIZA ASSENTAMENTOS CONFORME ESTADO
        $("#educando_sel_est").change(function () {
            if ($("#educando_tipo_terr").val() == "ASSENTAMENTO") {
                appendSelectorToASSENTAMENTO();
            }
        });

        //CASO FOR ASSENTAMENTO, CRIA SELECTBOX
        $("#educando_tipo_terr").change(function () {
            if ($(this).val() == "ASSENTAMENTO") {
                appendSelectorToASSENTAMENTO();
            } else {
                removeSelectorToASSENTAMENTO();
                $("#ckNome_terr_ni").change();
            }
        });

        //Lista Municipios
        $.get(urlAcampamentos, function (response) {
            $('#educando_tipo_terr option[value="' + response + '"]').attr("selected", true);
        });

        //INICIALIZA RETREVIAL SIPRA
        <?PHP
        if ($retrivial):
            if ($dados[0]->tipo_territorio == "ASSENTAMENTO"):
                ?>
                <?PHP
                if (!$dados[0]->code_sipra_assentamento):
                    ?>
                            appendSelectorToASSENTAMENTO();
                    <?PHP
                endif;
            endif;
        endif;
        ?>

        /* Masking Inputs */
        $('#educando_data_nasc').mask('99/99/9999');
        $('#inicio_curso').mask('99/9999');

        // Não informados


        $('#ckEst_ni').niCheck({
            'id': ['educando_sel_est','educando_sel_mun','ckMun_ni'],
            'oncheck': function(){
                $("#educando_sel_mun").html("<option value='0'>Selecione o Município</option>");
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO") {
                    appendSelectorToASSENTAMENTO();
                }
            }
        });
        
        $("#ckNome_terr_ni").niCheck({
            'id': ['educando_nome_terr'],
            'onuncheck': function(){
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO") {
                    appendSelectorToASSENTAMENTO();
                }
            },
            'oncheck': function(){
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO") {
                    removeSelectorToASSENTAMENTO();
                    $("#educando_nome_terr").attr("disabled",true);
                }
            }
        });
        
        $("#ckTipo_terr_ni").niCheck({
            'id': ['educando_tipo_terr'],
            'niValue' : [""],
            'beforeoncheck': function(){
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO") {
                    removeSelectorToASSENTAMENTO();
                }
            }
        });

        $('#ckCPF_na').niCheck({
            'id': ['educando_cpf', 'ckCPF_ni']
        });

        $('#ckRg_na').niCheck({
            'id': ['educando_rg', 'ckRg_ni']
        });
        
        $('#ckRg_ni').niCheck({
            'id': ['educando_rg', 'ckRg_na']
        });
        
        $('#ckCPF_ni').niCheck({
            'id': ['educando_cpf', 'ckCPF_na']
        });
        
        $('#educando_data_nasc').focusout(function () {

            var date1 = $(this).val();
            var date2 = $('#inicio_curso_hidden').val();

            if (date2.length > 0) {

                if (dif = subtrDate(date1, date2)) {
                    $('#educando_idade').val(dif);
                    $('#ckEducando_idade').prop('checked', false);
                }

            } else {

                $('#dialog_inicio_curso').dialogInit(function () {
                    var form = Array(
                            {
                                'id': 'inicio_curso',
                                'message': 'Informe mês e ano do início da realização do curso',
                                'extra': {
                                    'operation': 'date',
                                    'message': 'A data informada é inválida'
                                }
                            }
                    );

                    if (isFormComplete(form)) {
                        $('#atualizar_ic').val(1);
                        $('#inicio_curso_hidden').val($('#inicio_curso').val());
                        $('#educando_data_nasc').focusout();

                        return true;
                    }

                }, [370, 550]);
            }
        });

        /* NÃO INFROMADOS */
        $('#ckSexo_ni').niCheck({
            'name': ['reducando_sexo']
        });

        $('#ckEducando_data_nasc').niCheck({
            'id': ['educando_data_nasc']
        });

        $('#ckEducando_idade').niCheck({
            'id': ['educando_idade']
        });

        $('#ckEducandoConcluinte_ni').niCheck({
            'name': ['reducando_concluinte']
        });

        $('#salvar').click(function () {

            var form = Array(
                    {
                        'id': 'educando_nome',
                        'message': 'Informe o nome do(a) educando(a)',
                        'extra': null
                    },
                    {
                        'name': 'reducando_sexo',
                        'ni': $('#ckSexo_ni').prop('checked'),
                        'message': 'Informe o sexo do(a) educando(a)',
                        'extra': null
                    },
                    {
                        'id': 'educando_cpf',
                        'ni': ($('#ckCPF_ni').prop('checked') ||
                                $('#ckCPF_na').prop('checked')),
                        'message': 'Informe o CPF do(a) educando(a)',
                        'extra': null
                    },
                    {
                        'id': 'educando_rg',
                        'ni': ($('#ckRg_ni').prop('checked') ||
                                $('#ckRg_na').prop('checked')),
                        'message': 'Informe o RG do(a) educando(a)',
                        'extra': null
                    },
                    {
                        'id': 'educando_data_nasc',
                        'ni': $('#ckEducando_data_nasc').prop('checked'),
                        'message': 'Informe a data de nascimento do(a) educando(a)',
                        'extra': {
                            'operation': 'date',
                            'message': 'A data informada é inválida'
                        }
                    },
                    {
                        'id': 'educando_idade',
                        'ni': $('#ckEducando_idade').prop('checked'),
                        'message': 'A idade do(a) educando(a) é calculada automaticamente a partir da informação preenchida <br />' +
                                'no campo 14.A (inicío da realização do curso) do formulário de Caracterização do curso. <br />' +
                                'Caso não possua tal informação selecione a opção "Não informado".',
                        'extra': null
                    },
                    {
                        'id': 'educando_tipo_terr',
                        'ni': $('#ckTipo_terr_ni').prop('checked'),
                        'message': 'Informe o tipo de território onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                        'extra': null
                    },
                    {
                        'id': 'educando_nome_terr',
                        'ni': $('#ckNome_terr_ni').prop('checked'),
                        'message': 'Informe o nome do território onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                        'extra': null
                    },
                    {
                        'id': 'educando_sel_est',
                        'ni': $('#ckEst_ni').prop('checked'),
                        'message': 'Informe o nome o Estado onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                        'extra': null
                    },
                    {
                        'name': 'reducando_concluinte',
                        'ni': $('#ckEducandoConcluinte_ni').prop('checked'),
                        'message': 'Informe se o(a) educando(a) concluiu o curso',
                        'extra': null
                    }
            );
    
            if(!$('#ckEst_ni').prop('checked') && $('#educando_sel_est').val()!==0){
                form.push({
                    'id': 'educando_sel_mun',
                    'message': 'Informe o Município de Origem do Educando',
                    'extra': null
                });
            }
                
            if (isFormComplete(form)) {
                var formData = {
                    id: id,
                    educando_nome: $('#educando_nome').val().toUpperCase(),
                    ckSexo_ni: $('#ckSexo_ni').prop('checked'),
                    reducando_sexo: $("input:radio[name=reducando_sexo]:checked").val(),
                    ckCPF_ni: $('#ckCPF_ni').prop('checked'),
                    ckCPF_na: $('#ckCPF_na').prop('checked'),
                    educando_cpf: $('#educando_cpf').val().toUpperCase(),
                    ckRg_ni: $('#ckRg_ni').prop('checked'),
                    ckRg_na: $('#ckRg_na').prop('checked'),
                    educando_rg: $('#educando_rg').val().toUpperCase(),
                    ckEducando_data_nasc: $('#ckEducando_data_nasc').prop('checked'),
                    educando_data_nasc: $('#educando_data_nasc').val(),
                    ckEducando_idade: $('#ckEducando_idade').prop('checked'),
                    educando_idade: $('#educando_idade').val(),
                    ckEducando_tipo_terr: $('#ckTipo_terr_ni').prop('checked'),
                    educando_tipo_terr: $('#educando_tipo_terr').val(),
                    ckEducando_nome_terr: $('#ckNome_terr_ni').prop('checked'),
                    educando_nome_terr: $('#educando_nome_terr').val().toUpperCase(),
                    terr_sipra_code: null,
                    ckEducandoConcluinte_ni: $('#ckEducandoConcluinte_ni').prop('checked'),
                    reducando_concluinte: $("input:radio[name=reducando_concluinte]:checked").val(),
                    ckEst_ni: $("#ckEst_ni").prop('checked'),
                    municipios: $('#educando_sel_mun').val(),
                    //mun_excluidos: table.getDeletedRows(1),
                    inicio_curso: $('#inicio_curso_hidden').val(),
                    atualizar_ic: $('#atualizar_ic').val()
                };
                if (formData.educando_tipo_terr == "ASSENTAMENTO") {
                    formData.educando_nome_terr = $('#educando_nome_terr option:selected').attr('title').toUpperCase();
                    formData.terr_sipra_code = $('#educando_nome_terr').val().toUpperCase();
                }

                var urlRequest = "<?php
                if ($operacao == 'add')
                    echo site_url('educando/add/');
                if ($operacao == 'update')
                    echo site_url('educando/update/');
                ?>";
//                console.log(formData);
//                 Faz requisição de login ao servidor (retorna um objeto JSON)
                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('educando/index/'); ?>";

            // Faz requisição de login ao servidor (retorna um objeto JSON)
            request(urlRequest, null, 'hide');
        });
        
        $("#educando_cpf").keypress(function (e) {
            preventChar(e);
        });

    });

</script>

<fieldset>
    <legend> Caracteriza&ccedil;&atilde;o do(a) Educando(a) </legend>
    <div class="form-group controles">
        <?php
        if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
            echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
        }
        ?>
        <input type="button" id="reset" class="btn btn-default" value="Voltar">
    </div>

    <div class="form-group">
        <label>1. Nome do(a) educando(a)</label>
        <div>
            <input type="text" class="form-control tamanho-lg" id="educando_nome" name="educando_nome" value="<?php if ($retrivial) echo $dados[0]->nome; ?>">
            <label class="control-label form" for="educando_nome"></label>
        </div>
    </div>

    <div class="form-group">
        <label class="negacao">2. G&ecirc;nero</label>

        <div class="checkbox negacao-smaller">
            <label> <input type="checkbox" name="ckSexo_ni" id="ckSexo_ni" <?php if ($retrivial && $dados[0]->genero == 'N') echo "checked"; ?>> N&atilde;o informado </label>
        </div>

        <div class="radio form-group">
            <div>
                <div class="radio"><label> <input type="radio" name="reducando_sexo" id="reducando_sexo_01" value="M" <?php if ($retrivial && $dados[0]->genero == 'M') echo "checked"; ?>> Masculino </label> </div>
                <div class="radio"><label> <input type="radio" name="reducando_sexo" id="reducando_sexo_02" value="F" <?php if ($retrivial && $dados[0]->genero == 'F') echo "checked"; ?>> Feminino</label> </div>
                <p class="text-danger"><label for="reducando_sexo"></label></p>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="negacao">3. CPF (somente n&uacute;meros)</label>

        <div class="checkbox">
            <label class="negacao-sm"> <input type="checkbox" name="ckCPF_ni" id="ckCPF_ni"  value="NAOINFORMADO" <?php if ($retrivial && ($dados[0]->cpf == "NAOINFORMADO" || strlen($dados[0]->rg) == 0)) echo "checked"; ?>> N&atilde;o encontrado </label>
            <label class="negacao-sm"> <input type="checkbox" name="ckCPF_na" id="ckCPF_na"  value="NAOAPLICA" <?php if ($retrivial && $dados[0]->cpf == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
        </div>
        <div>
            <input type="text" class="form-control tamanho-small" id="educando_cpf" name="educando_cpf" maxlength="11"
                   value="<?php if ($retrivial && $dados[0]->cpf != "NAOAPLICA" && $dados[0]->cpf != "NAOINFORMADO") echo $dados[0]->cpf; ?>">
            <label class="control-label form" for="educando_cpf"></label>
        </div>
    </div>

    <div class="form-group">
        <label class="negacao">4. R.G.</label>

        <div class="checkbox">
            <label class="negacao-sm"> <input type="checkbox" name="ckRg_ni" id="ckRg_ni"  value="NAOINFORMADO" <?php if ($retrivial && ($dados[0]->rg == "NAOINFORMADO" || strlen($dados[0]->rg) == 0)) echo "checked"; ?>> N&atilde;o encontrado </label>
            <label class="negacao-sm"> <input type="checkbox" name="ckRg_na" id="ckRg_na"  value="NAOAPLICA" <?php if ($retrivial && $dados[0]->rg == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
        </div>
        <div>
            <input type="text" class="form-control tamanho-small" id="educando_rg" name="educando_rg"  maxlength="25"
                   value="<?php if ($retrivial && $dados[0]->rg != "NAOAPLICA" && $dados[0]->rg != "NAOINFORMADO") echo $dados[0]->rg; ?>">
            <label class="control-label form" for="educando_rg"></label>
        </div>
    </div>

    <div class="form-group">
        <label class="negacao">5. Data de nascimento do(a) educando(a)</label>

        <div class="checkbox negacao-smaller">
            <label> <input type="checkbox" name="ckEducando_data_nasc" id="ckEducando_data_nasc" <?php if ($retrivial && $dados[0]->data_nascimento == '01/01/1900') echo "checked"; ?>> N&atilde;o informado </label>
        </div>

        <div class="form-group">
            <div>
                <input type="text" class="form-control tamanho-sm2" id="educando_data_nasc" name="educando_data_nasc" value="<?php if ($retrivial && $dados[0]->data_nascimento != '01/01/1900' && $dados[0]->data_nascimento != '00/00/0000') echo $dados[0]->data_nascimento; ?>">
                <label class="control-label form" for="educando_data_nasc"></label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="negacao">6. Idade do(a) educando(a) no ingresso do curso</label>

        <div class="checkbox negacao-smaller">
            <label> <input type="checkbox" name="ckEducando_idade" id="ckEducando_idade" <?php if ($retrivial && $dados[0]->idade == '-1') echo "checked"; ?>> N&atilde;o informado </label>
        </div>

        <div class="form-group">
            <div>
                <input type="text" class="form-control tamanho-smaller" id="educando_idade" name="educando_idade" value="<?php if ($retrivial && $dados[0]->idade != '-1') echo $dados[0]->idade; ?>">
                <label class="control-label form" for="educando_idade"></label>
            </div>
        </div>

    </div>

    <div class="form-group">
        <label>7. Tipo e nome do territ&oacute;rio onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso</label>
        <div class="form-group interno">
            <label>a. Estado do educando</label>
            <div>
                <select class="form-control select_estado" id="educando_sel_est" name="educando_sel_est"></select>
                <p class="text-danger select estado"><label for="educando_sel_est"></label></p>
            </div>
        </div>
        <div class="form-group interno">
            <label class="negacao">b. Município do educando</label>
            <div class="checkbox">
                <label class="negacao-sm"> <input <?= ($retrivial && !isset($municipio_estado[0]) ? "checked" : "") ?>  type="checkbox" name="ckEst_ni" id="ckEst_ni"> N&atilde;o informado </label>
            </div>
            <div>
                <select class="form-control select_municipio" id="educando_sel_mun" name="educando_sel_mun"></select>
                <p class="text-danger select municipio"><label for="educando_sel_mun"></label></p>
            </div>
        </div>
        <div class="form-group interno">
            <label class="negacao">c. Tipo do territ&oacute;rio</label>
            <div class="checkbox">
                <label class="negacao-sm"> <input <?= ($retrivial && strlen($dados[0]->tipo_territorio) == 0 ? "checked" : "") ?> type="checkbox" name="ckTipo_terr_ni" id="ckTipo_terr_ni"> N&atilde;o informado </label>
            </div>
            <div>
                <select class="form-control" name="educando_tipo_terr" id="educando_tipo_terr">
                    <option selected disabled value="">Selecione</option>
                    <option value="ACAMPAMENTO">ACAMPAMENTO</option>
                    <option value="ASSENTAMENTO">ASSENTAMENTO</option>
                    <option value="COMUNIDADE">COMUNIDADE</option>
                    <option value="QUILOMBOLA">QUILOMBOLA</option>
                    <option value="COMUNIDADE RIBEIRINHA">COMUNIDADE RIBEIRINHA</option>
                    <option value="FLORESTA NACIONAL">FLORESTA NACIONAL</option>
                    <option value="RESEX">RESEX</option>
                    <option value="FLONA">FLONA</option>
                    <option value="RDS">RDS</option>
                    <option value="OUTRO">OUTRO</option>
                </select>
                <p class="text-danger select"><label for="educando_tipo_terr"></label></p>
            </div>
        </div>

        <div class="form-group interno">
            <label class="negacao">d. Nome do territ&oacute;rio</label>
            <div class="checkbox">
                <label class="negacao-sm"> <input <?= ($retrivial && strlen($dados[0]->nome_territorio) == 0 ? "checked" : "") ?> type="checkbox" name="ckNome_terr_ni" id="ckNome_terr_ni"> N&atilde;o informado </label>
            </div>
            <div id="educando_territorio">
                <input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr" value="<?php if ($retrivial) echo $dados[0]->nome_territorio; ?>">
                <label class="control-label form" for="educando_nome_terr"></label>
            </div>
        </div>
        <?PHP
        if ($retrivial && $dados[0]->tipo_territorio == "ASSENTAMENTO" && !$dados[0]->code_sipra_assentamento):
            ?>
            <div class="form-group interno">
                <label>e. Nome do territ&oacute;rio informado</label>
                <div id="educando_territorio">
                    <input type="text" class="form-control tamanho-n" id="educando_nome_terr_old" name="educando_nome_terr_old" readonly value="<?php if ($retrivial) echo $dados[0]->nome_territorio; ?>">
                    <label class="control-label form" for="educando_nome_terr_old"></label>
                </div>
            </div>
            <?PHP
        endif;
        ?>
    </div>
    <div class="form-group">
        <label class="negacao">8. O(A) educando(a) concluiu o curso ?</label>

        <div class="checkbox negacao-smaller">
            <label> <input type="checkbox" name="ckEducandoConcluinte_ni" id="ckEducandoConcluinte_ni" <?php if ($retrivial && $dados[0]->concluinte == 'I') echo "checked"; ?>> N&atilde;o informado </label>
        </div>

        <div class="radio form-group">
            <div>
                <div class="radio"> <label> <input type="radio" name="reducando_concluinte" id="reducando_concluinte_02" value="S" <?php if ($retrivial && $dados[0]->concluinte == 'S') echo "checked"; ?>> Sim  </label> </div>
                <div class="radio"> <label> <input type="radio" name="reducando_concluinte" id="reducando_concluinte_01" value="N" <?php if ($retrivial && $dados[0]->concluinte == 'N') echo "checked"; ?>> N&atilde;o </label> </div>
                <p class="text-danger"><label for="reducando_concluinte"></label></p>
            </div>
        </div>
    </div>
    <input type="hidden" id="inicio_curso_hidden" name="inicio_curso_hidden" value="<?php echo $dados[0]->inicio_curso; ?>"/>
    <input type="hidden" id="atualizar_ic" name="atualizar_ic" value="0"/>

    <div id="dialog_inicio_curso" class="dialog" title="Cadastro do período de início do curso">
        <br />
        <h5>
            Para que seja realizado o cálculo da idade do educando
            é necessário que seja preenchido o campo 14.A
            (inicío da realização do curso) do fomulário de Caracterização do curso
        </h5>
        <br /><br />

        <strong>Para realizar o cadastro informe o dado no campo abaixo (Mês/Ano)</strong>
        <div class="form-group">
            <div>
                <input type="text" class="form-control tamanho-sm2" id="inicio_curso" name="inicio_curso" placeholder="MM/AAAA"/>
                <label class="control-label form" for="inicio_curso"></label>
            </div>
        </div>

        <h4>Efetuar cadastro?</h4>
    </div>

</fieldset>

<?php echo form_close(); ?>
