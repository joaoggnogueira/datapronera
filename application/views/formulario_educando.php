<?php
$this->session->set_userdata('curr_content', 'educando');
$retrivial = ($operacao != 'add');

if ($retrivial) {
    if ($dados[0]->tipo_territorio == "ASSENTAMENTO" && substr($dados[0]->code_sipra_assentamento, 0, 2) == $dados[0]->uf) {
        $filter = "checked";
    } else {
        $filter = "";
    }
} else {
    $filter = "checked";
}
?>
<style>
    #middle{
        margin-top: 170px;
    }
    .lds-dual-ring {
        display: inline-block;
        width: 32px;
        height: 16px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 23px;
        height: 23px;
        margin: 1px;
        border-radius: 50%;
        border: 5px solid #000;
        border-color: #000 transparent #000 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .panel-search .panel-heading{
        background: rgb(71,164,71);
        color: white !important;
    }
    .controles,#header {
        z-index: 1000;
    }
    .no-margin{
        margin: 0px;
    }
    .flex{
        display: flex;
    } 
    .flex-row{
        flex-direction: row;
    }
    .flex-justify-center{
        justify-content: center;
    }
    .flex-justify-between{
        justify-content: space-between;
    }

    .chips{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .chips .chip{
        display: flex;
        flex-direction: row;
        padding: 5px;
        padding-left: 10px;
        padding-right: 10px;
        cursor: pointer;
        border-radius: 15px;
        margin: 5px;
        color: white;
        line-height: 20px;
    }

    .chips .chip.green{
        background: rgb(71,164,71);
    }
    .chips .chip.green:hover{
        background: rgb(90,184,90);
    }
    .chips .chip.green:active{
        background: rgb(90,154,90);
    }

    .chips .chip.blue{
        background: rgb(71,71,164);
    }
    .chips .chip.blue:hover{
        background: rgb(90,90,184);
    }
    .chips .chip.blue:active{
        background: rgb(90,90,154);
    }

    search_assentamentos_table_content table{
        min-width: 460px;
    }

</style>
<script type="text/javascript">
    var id = "<?php echo $educando['id']; ?>";
    var urlEstados = "<?php echo site_url('requisicao/get_estados'); ?>";
    var urlAcampamentos = "<?php echo site_url('educando/get_tipo_acamp') . '/'; ?>" + id;
    var selected_assentamento = false;

    $(document).ready(function () {

        //ATUALIZA ASSENTAMENTOS CONFORME ESTADO
        $("#educando_sel_est").change(function () {
            if ($("#educando_tipo_terr").val() == "ASSENTAMENTO" && $("#ckFilter_terr")[0].checked) {
                appendSelectorToASSENTAMENTO();
            }
        });

        //ESTADOS E MUNICIPIOS
        $.get(urlEstados, function (estados) {
            $('#educando_sel_est').html(estados);
            $('#educando_sel_mun').html('<option> Selecione o Estado </option>');
        }).done(function () {
            var idEstado = <?= (array_key_exists(0, $municipio_estado) ? $municipio_estado[0]->estado : 0); ?>;
            if (idEstado > 0) {
                $('#educando_sel_est option[value="' + idEstado + '"]').attr('selected', true);
                var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";
                $('#educando_sel_est').change(function () {
                    var idEstado = $('#educando_sel_est').val();
                    $('#educando_sel_mun').html("<option>Aguarde...</option>");
                    $.get(urlMunicipios + '/' + idEstado, function (cities) {
                        $('#educando_sel_mun').html(cities);
                    }).done(function () {
                        var idMunicipio = <?= (array_key_exists(0, $municipio_estado) ? $municipio_estado[0]->cidade : 0); ?>;
                        $('#educando_sel_mun option[value="' + idMunicipio + '"]').attr('selected', true);
                    });
                }).change();
            } else {
                $("#educando_sel_est").listFallbackJson("<?= site_url('requisicao/get_municipios'); ?>", 'educando_sel_mun');
<?PHP if ($operacao == 'add'): ?>
                    $('#educando_sel_est option[value="<?= $dados['sr_uf'] ?>"]').attr('selected', true);
                    $("#educando_sel_est").change();
<?PHP endif; ?>
            }
            //INICIALIZA RETREVIAL SIPRA
<?PHP if ($retrivial && $dados[0]->tipo_territorio == "ASSENTAMENTO" && $dados[0]->code_sipra_assentamento): ?>
                appendSelectorToASSENTAMENTO();
<?PHP endif; ?>

        });

        //SELECTBOX EVENTS
        var get_est_selected_value = function () {
            var estado;
            if ($("#ckFilter_terr")[0].checked) {
                estado = $('#educando_sel_est option:selected').val();
            } else {
                estado = "0";
            }
            return estado;
        };
        var promise_assentamento = false;
        var appendSelectorToASSENTAMENTO = function () {
            if (!$("#ckNome_terr_ni").prop("checked")) {
                var urlAssentamentos = "<?php echo site_url('requisicao/get_assentamentos') . '/'; ?>" + get_est_selected_value();
                $("#loading-assentamentos").show();
                if (promise_assentamento) {
                    promise_assentamento.abort();
                }
                promise_assentamento = $.get(urlAssentamentos, function (assentamentos) {
                    $("#educando_nome_terr").parent().remove();
                    $("#educando_territorio").append($('<div>').append($('<select class="form-control" name="educando_nome_terr" id="educando_nome_terr">')
                            .append('<option selected disabled value="">Selecione</option>')
                            .append(assentamentos)));
<?PHP if ($retrivial && $dados[0]->tipo_territorio == "ASSENTAMENTO" && $dados[0]->code_sipra_assentamento): ?>
                        $('#educando_nome_terr option[value="<?= $dados[0]->code_sipra_assentamento ?>"]').attr('selected', true);
<?PHP endif; ?>
                    if (selected_assentamento) {
                        $('#educando_nome_terr').val(selected_assentamento);
                        selected_assentamento = false;
                    }
                    $("#loading-assentamentos").hide();
                    promise_assentamento = false;
                });
            }
        };

        var removeSelectorToASSENTAMENTO = function () {
            $("#educando_nome_terr").parent().remove();
            $("#educando_territorio").append($("<div>").append('<input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr">'));
        };

        //CASO FOR ASSENTAMENTO, CRIA SELECTBOX
        $("#educando_tipo_terr").change(function () {
            if ($(this).val() == "ASSENTAMENTO") {
                $("#filter-assentamento").show();
                appendSelectorToASSENTAMENTO();
            } else {
                $("#filter-assentamento").hide();
                removeSelectorToASSENTAMENTO();
                $("#ckNome_terr_ni").change();
            }
        });

        $("#ckFilter_terr").click(function () {
            appendSelectorToASSENTAMENTO();
        });

        //RECUPERA O TIPO DE TERRITÓRIO DO EDUCANDO
        $.get(urlAcampamentos, function (response) {
            $('#educando_tipo_terr option[value="' + response + '"]').attr("selected", true);
        });

        //SUGESTÃO DO GENÊRO A PARTIR DO NOME
        $("#educando_nome").blur(function () {
            var value = $("input:radio[name=reducando_sexo]:checked").val();
            if (this.value !== "") {
                $.get("<?php echo site_url('educando/sugestao_genero') ?>/" + this.value, function (response) {
                    if (response == "I") {
                        $('input:radio[name=reducando_sexo][value="M"]')[0].checked = false;
                        $('input:radio[name=reducando_sexo][value="F"]')[0].checked = false;
                    } else {
                        $('input:radio[name=reducando_sexo][value="' + response + '"]')[0].checked = true;
                    }
                });
            }
        });
<?PHP if ($retrivial): ?>
            $("#desc-course").fadeIn(400).find(".navbar-brand").text("Editando educando(a) <?= $dados[0]->nome ?>");
<?PHP endif; ?>

        /* MASCARAS */
        $('#educando_data_nasc').mask('99/99/9999');
        $('#inicio_curso').mask('99/9999');
        $("#educando_cpf").keypress(preventChar);

        /* NÃO APLICAVEL */
        $('#ckCPF_na').niCheck({'id': ['educando_cpf', 'ckCPF_ni']});
        $('#ckRg_na').niCheck({'id': ['educando_rg', 'ckRg_ni']});

        /* NÃO INFROMADOS */
        $('#ckRg_ni').niCheck({'id': ['educando_rg', 'ckRg_na']});
        $('#ckCPF_ni').niCheck({'id': ['educando_cpf', 'ckCPF_na']});
        $('#ckSexo_ni').niCheck({'name': ['reducando_sexo']});
        $('#ckEducando_data_nasc').niCheck({'id': ['educando_data_nasc']});
        $('#ckEducando_idade').niCheck({'id': ['educando_idade']});
        $('#ckEducandoConcluinte_ni').niCheck({'name': ['reducando_concluinte']});
        $("#ckTipo_terr_ni").niCheck({
            'id': ['educando_tipo_terr'],
            'niValue': [""],
            'beforeoncheck': function () {
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO") {
                    removeSelectorToASSENTAMENTO();
                }
            }
        });
        $('#ckEst_ni').niCheck({
            'id': ['educando_sel_est', 'educando_sel_mun', 'ckMun_ni'],
            'oncheck': function () {
                $("#educando_sel_mun").html("<option value='0'>Selecione o Município</option>");
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO" && $("#ckFilter_terr")[0].checked) {
                    appendSelectorToASSENTAMENTO();
                }
            }
        });
        $("#ckNome_terr_ni").niCheck({
            'id': ['educando_nome_terr'],
            'onuncheck': function () {
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO") {
                    appendSelectorToASSENTAMENTO();
                }
            },
            'oncheck': function () {
                if ($("#educando_tipo_terr").val() === "ASSENTAMENTO") {
                    removeSelectorToASSENTAMENTO();
                    $("#educando_nome_terr").attr("disabled", true);
                }
            }
        });

        //RECUPERAR IDADE POR ANO DE NASCIMENTO
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
                    var form = Array({
                        'id': 'inicio_curso',
                        'message': 'Informe mês e ano do início da realização do curso',
                        'extra': {
                            'operation': 'date',
                            'message': 'A data informada é inválida'
                        }
                    });
                    if (isFormComplete(form)) {
                        $('#atualizar_ic').val(1);
                        $('#inicio_curso_hidden').val($('#inicio_curso').val());
                        $('#educando_data_nasc').focusout();
                        return true;
                    }
                }, [370, 550]);
            }
        });

        //SUBMIT
        $('#salvar').click(function () {
            var form = Array({
                'id': 'educando_nome',
                'message': 'Informe o nome do(a) educando(a)',
                'extra': {
                    'operation': 'pattern',
                    'message': 'O nome possui caracteres inválidos'
                }
            }, {
                'name': 'reducando_sexo',
                'ni': $('#ckSexo_ni').prop('checked'),
                'message': 'Informe o sexo do(a) educando(a)',
                'extra': null
            }, {
                'id': 'educando_cpf',
                'ni': ($('#ckCPF_ni').prop('checked') ||
                        $('#ckCPF_na').prop('checked')),
                'message': 'Informe o CPF do(a) educando(a)',
                'extra': null
            }, {
                'id': 'educando_rg',
                'ni': ($('#ckRg_ni').prop('checked') ||
                        $('#ckRg_na').prop('checked')),
                'message': 'Informe o RG do(a) educando(a)',
                'extra': null
            }, {
                'id': 'educando_data_nasc',
                'ni': $('#ckEducando_data_nasc').prop('checked'),
                'message': 'Informe a data de nascimento do(a) educando(a)',
                'extra': {
                    'operation': 'date',
                    'message': 'A data informada é inválida'
                }
            }, {
                'id': 'educando_idade',
                'ni': $('#ckEducando_idade').prop('checked'),
                'message': 'A idade do(a) educando(a) é calculada automaticamente a partir da informação preenchida <br />' +
                        'no campo 14.A (inicío da realização do curso) do formulário de Caracterização do curso. <br />' +
                        'Caso não possua tal informação selecione a opção "Não informado".',
                'extra': null
            }, {
                'id': 'educando_tipo_terr',
                'ni': $('#ckTipo_terr_ni').prop('checked'),
                'message': 'Informe o tipo de território onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                'extra': null
            }, {
                'id': 'educando_nome_terr',
                'ni': $('#ckNome_terr_ni').prop('checked'),
                'message': 'Informe o nome do território onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                'extra': null
            }, {
                'id': 'educando_sel_est',
                'ni': $('#ckEst_ni').prop('checked'),
                'message': 'Informe o nome o Estado onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                'extra': null
            }, {
                'name': 'reducando_concluinte',
                'ni': $('#ckEducandoConcluinte_ni').prop('checked'),
                'message': 'Informe se o(a) educando(a) concluiu o curso',
                'extra': null
            }
            );

            if (!$('#ckEst_ni').prop('checked') && $('#educando_sel_est').val() !== 0) {
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
                request(urlRequest, formData, false, {
                    success: function () {
                        if (!$("#ckNome_terr_ni")[0].checked) {
                            var list = window.localStorage.getItem("assentamentos_recentes");
                            if (list === null) {
                                list = [];
                            } else {
                                try {
                                    list = JSON.parse(list);
                                } catch (e) {
                                    list = [];
                                }
                            }
                            var tipo = $('#educando_tipo_terr').val();
                            var novo = false;
                            if (tipo == "ASSENTAMENTO") {
                                var sipra = $('#educando_nome_terr').val().toUpperCase();
                                var nome = $('#educando_nome_terr option:selected').attr('title').toUpperCase();
                                novo = {tipo: tipo, sipra: sipra, nome: nome};
                            } else {
                                var nome = $('#educando_nome_terr').val().toUpperCase();
                                if (nome == "NÃO ENCONTRADO") {
                                    return;
                                }
                                novo = {tipo: tipo, nome: nome};
                            }
                            for (var i = 0; i < list.length; i++) {
                                if (list[i].nome == novo.nome && list[i].tipo == novo.tipo) {
                                    list.splice(i, 1);
                                    break;
                                }
                            }
                            list.push(novo);
                            if (list.length >= 10) {
                                list.shift();
                            }
                            window.localStorage.setItem("assentamentos_recentes", JSON.stringify(list));
                        }
                    }
                });
            }
        });

        //VOLTAR
        $('#reset').click(function () {
            var urlRequest = "<?php echo site_url('educando/index/'); ?>";
            request(urlRequest, null, 'hide');
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
            <input type="text" pattern="^[^-\s][a-zA-ZÀ-ú ]*" class="form-control tamanho-lg" id="educando_nome" name="educando_nome" value="<?php if ($retrivial) echo $dados[0]->nome; ?>">
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
            <label class="negacao-sm"> <input type="checkbox" name="ckCPF_ni" id="ckCPF_ni"  value="NAOINFORMADO" <?php if ($retrivial && ($dados[0]->cpf == "NAOINFORMADO" || strlen($dados[0]->cpf) == 0)) echo "checked"; ?>> N&atilde;o encontrado </label>
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
            <label class="negacao-sm"> <input type="checkbox" name="ckRg_ni" id="ckRg_ni" value="NAOINFORMADO" <?php if ($retrivial && ($dados[0]->rg == "NAOINFORMADO" || strlen($dados[0]->rg) == 0)) echo "checked"; ?>> N&atilde;o encontrado </label>
            <label class="negacao-sm"> <input type="checkbox" name="ckRg_na" id="ckRg_na" value="NAOAPLICA" <?php if ($retrivial && $dados[0]->rg == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
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
            <label> <input type="checkbox" name="ckEducando_data_nasc" id="ckEducando_data_nasc" <?php if ($retrivial && ($dados[0]->data_nascimento == '01/01/1900' || $dados[0]->data_nascimento == '00/00/0000')) echo "checked"; ?>> N&atilde;o informado </label>
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
            <label>a. Estado (UF) de origem do educando</label>
            <div>
                <select class="form-control select_estado" id="educando_sel_est" name="educando_sel_est"></select>
                <p class="text-danger select estado"><label for="educando_sel_est"></label></p>
            </div>
        </div>
        <div class="form-group interno">
            <label class="negacao">b. Município de origem do educando</label>
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
                    <option value="ASSENTAMENTONONSIPRA">ASSENTAMENTO SEM SIPRA</option>
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
            <div class="checkbox" id="filter-assentamento" style="margin-left: -50px;<?= ($retrivial && $dados[0]->tipo_territorio == "ASSENTAMENTO" ? "" : "display:none;") ?>">
                <label class="negacao-sm"> <input <?= $filter ?> type="checkbox" name="ckFilter_terr" id="ckFilter_terr"> Filtrar lista pelo Estado (UF) de Origem? (Desativado pode levar mais tempo para carregar a lista) </label>
            </div>
            <div id="educando_territorio" style="display: flex; flex-direction: row;">
                <?PHP if ($operacao != 'view'): ?>
                    <button class="btn btn-primary" style="margin-right: 5px" data-toggle="modal" data-target="#busca_assentamento_modal"><i class="fa fa-search"></i></button>
                <?PHP endif; ?>
                <div class="lds-dual-ring" id="loading-assentamentos" style="display: none"></div>
                <div>
                    <input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr" value="<?php if ($retrivial) echo $dados[0]->nome_territorio; ?>">
                    <label class="control-label form" for="educando_nome_terr"></label>
                </div>
            </div>
        </div>
        <?PHP
        if ($retrivial && $dados[0]->tipo_territorio == "ASSENTAMENTO" && !$dados[0]->code_sipra_assentamento):
            ?>
            <div class="form-group interno">
                <label>e. Nome do territ&oacute;rio informado</label>
                <div>
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
<?PHP if ($operacao != 'view'): ?>
    <div class="modal fade" id="busca_assentamento_modal" >
        <div class="modal-dialog" style="width: 1000px" role="document">
            <div class="modal-content panel panel-search">
                <div class="modal-header panel-heading">
                    <i class="fa fa-search"></i> Busca avançada de assentamentos
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="glyphicon glyphicon-remove"></i></span>
                    </button>
                </div>
                <div class="modal-body flex flex-row flex-justify-between">
                    <div style="max-width: 470px;">
                        <div class="row">
                            <div class="form-group no-margin">
                                <div class="flex flex-row flex-justify-center">
                                    <input placeholder="Nome, código sipra do Assentamento" type="text" class="form-control" id="assentamento-input" name="assentamento-input" value=""/>
                                    <button class="btn btn-success" id="buscar_assentamento">Buscar</button>
                                </div>
                                <p class="text-danger" style="margin-left: 20px;" id="rassentamento-input"><label>Necessário no mínimo 3 caracteres</label></p>
                            </div>
                        </div>
                        <br/>
                        <ul class="nav nav-pills" role="tablist" >
                            <h4>Resultado da Pesquisa: </h4>
                            <li id="tab_search_assentamento_sipra" role="presentation"><a data-toggle="tab" href="#sipra">Com Sipra</a></li>
                            <li id="tab_search_assentamento_nonsipra" role="presentation"><a data-toggle="tab" href="#nonsipra">Sem Sipra</a></li>
                            <br/><br/><br/>
                            <h4>Utilizados no mesmo Curso: </h4>
                            <li id="tab_recent_assentamento_sipra" role="presentation" class="active"><a data-toggle="tab" href="#sipra-recent">Com Sipra</a></li>
                            <li id="tab_recent_assentamento_nonsipra" role="presentation"><a data-toggle="tab" href="#nonsipra-recent">Sem Sipra</a></li>
                        </ul>
                        <hr/>
                        <h4>Usados recentemente: </h4>
                        <div id='chips' class='chips'>

                        </div>
                    </div>
                    <div style="max-width: 480px;">
                        <div class="tab-content" id="search_assentamentos_table_content">
                            <div id="sipra" class="tab-pane fade" style="padding: 10px">
                                <table style="width: 460px;" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="assentamento_sipra">
                                    <thead>
                                        <tr>
                                            <th style='width:"80px;"' width='80px'> SIPRA </th>
                                            <th style='width:"270px;"' width='270px'> NOME </th>
                                            <th style='width:"50px;"'  width='50px'> EDUCANDOS </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div id="nonsipra" class="tab-pane fade" style="padding: 10px">
                                <table style="width: 460px;" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="assentamento_nonsipra">
                                    <thead>
                                        <tr>
                                            <th style='width:"250px;"' width='250px'> NOME </th>
                                            <th style='width:"100px;"' width='100px'> TIPO </th>
                                            <th style='width:"50px;"'  width='50px'> EDUCANDOS </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div id="sipra-recent" class="tab-pane fade in active" style="padding: 10px">
                                <table style="width: 460px;" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="assentamento_sipra_recent">
                                    <thead>
                                        <tr>
                                            <th style='width:"80px;"' width='80px'> SIPRA </th>
                                            <th style='width:"270px;"' width='270px'> NOME </th>
                                            <th style='width:"50px;"'  width='50px'> EDUCANDOS </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div id="nonsipra-recent" class="tab-pane fade" style="padding: 10px">
                                <table style="width: 460px;" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="assentamento_nonsipra_recent">
                                    <thead>
                                        <tr>
                                            <th style='width:"250px;"' width='250px'> NOME </th>
                                            <th style='width:"100px;"' width='100px'> TIPO </th>
                                            <th style='width:"50px;"'  width='50px'> EDUCANDOS </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function () {

            var table_sipra = false;
            var table_nonsipra = false;

            function set_data(data) {
                if ($("#ckNome_terr_ni")[0].checked) {
                    $("#ckNome_terr_ni").click();
                }

                if (data.tipo == "ASSENTAMENTO") {
                    if ($("#ckTipo_terr_ni")[0].checked) {
                        $("#ckTipo_terr_ni").click();
                    }

                    if ($("#educando_nome_terr option[value='" + data.sipra + "']").length == 0) {
                        $("#ckFilter_terr")[0].checked = false;
                        selected_assentamento = data.sipra;
                        $("#educando_tipo_terr").val("ASSENTAMENTO").change();
                    } else {
                        $("#educando_nome_terr").val(data.sipra);
                    }
                    $("#busca_assentamento_modal").modal("hide");
                } else {
                    $("#educando_tipo_terr").val(data.tipo).change();
                    if (data.tipo == "") {
                        $("#ckTipo_terr_ni").click();
                    } else if ($("#ckTipo_terr_ni")[0].checked) {
                        $("#ckTipo_terr_ni").click();
                        $("#educando_tipo_terr").val(data.tipo).change();
                    }
                    $("#educando_nome_terr").val(data.nome);
                    $("#busca_assentamento_modal").modal("hide");
                }
            }

            function selected_chip(elem) {
                var target = $(elem.target);
                set_data(target.data("data"));
            }

            function add_recents_chips(text, data) {
                var parent = $("#chips");
                var chip = $("<div/>")
                        .addClass("chip")
                        .data("data", data)
                        .html(text)
                        .addClass((data.sipra ? "green" : "blue"))
                        .click(selected_chip);
                parent.append(chip);
            }

            var list = window.localStorage.getItem("assentamentos_recentes");
            if (list === null) {
                list = [];
            } else {
                try {
                    list = JSON.parse(list);
                    for (var i = list.length - 1; i >= 0; i--) {
                        var item = list[i];
                        if (item.tipo == "ASSENTAMENTO") {
                            add_recents_chips(item.sipra + " - " + item.nome, item);
                        } else {
                            add_recents_chips(item.nome, item);
                        }
                    }
                } catch (e) {
                }
            }
            function list_com_sipra(term) {
                var table = $("#assentamento_sipra").eq(0);
                if (table_sipra) {
                    table_sipra.destroy();
                }
                table_sipra = new Table({
                    data: {},
                    url: "<?= site_url("educando/sugestao_assentamento_sipra/") ?>/" + term,
                    table: table,
                    controls: null
                });

                table_sipra.appendEvent(function (data) {
                    set_data({tipo: "ASSENTAMENTO", nome: data[1], sipra: data[0]});
                });
            }

            function list_sem_sipra(term) {
                var table = $("#assentamento_nonsipra").eq(0);
                if (table_nonsipra) {
                    table_nonsipra.destroy();
                }
                table_nonsipra = new Table({
                    data: {},
                    url: "<?= site_url("educando/sugestao_assentamento_nonsipra/") ?>/" + term,
                    table: table,
                    controls: null
                });

                table_nonsipra.appendEvent(function (data) {
                    if (data[1] == "ASSENTAMENTO") {
                        data[1] = "ASSENTAMENTONONSIPRA";
                    }
                    set_data({tipo: data[1], nome: data[0]});
                });
            }

            function list_recent() {
                var table = $("#assentamento_sipra_recent").eq(0);
                (new Table({
                    data: {},
                    url: "<?= site_url("educando/recent_assentamento_sipra/") ?>/",
                    table: table,
                    controls: null
                })).appendEvent(function (data) {
                    set_data({tipo: "ASSENTAMENTO", nome: data[1], sipra: data[0]});
                });

                var table = $("#assentamento_nonsipra_recent").eq(0);
                (new Table({
                    data: {},
                    url: "<?= site_url("educando/recent_assentamento_nonsipra/") ?>/",
                    table: table,
                    controls: null
                })).appendEvent(function (data) {
                    if (data[1] == "ASSENTAMENTO") {
                        data[1] = "ASSENTAMENTONONSIPRA";
                    }
                    set_data({tipo: data[1], nome: data[0]});
                });
            }
            function search() {
                var term = document.getElementById("assentamento-input").value;
                while (term.length != 0 && term[term.length - 1] === " ") {
                    term = term.substr(0, term.length - 1);
                }
                term = term.replace("'",'0X2019'); //hack para poder pesquisar palavras com aspas simples
                if (term.length >= 3) {
                    if (!$("#tab_search_assentamento_sipra").hasClass("active")) {
                        $("#tab_search_assentamento_sipra a").tab("show");
                    }
                    $("#rassentamento-input").hide();
                    list_com_sipra(term);
                    list_sem_sipra(term);
                } else {
                    $("#rassentamento-input").show();
                }
            }

            $("#assentamento-input").keypress(function (e) {
                e.originalEvent.key == "Enter" && search();
            });
            $("#buscar_assentamento").click(search);
            list_recent();
        })();
    </script>
<?PHP endif; ?>
<?php echo form_close(); ?>
