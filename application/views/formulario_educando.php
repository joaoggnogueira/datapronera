<?php
    $this->session->set_userdata('curr_content', 'educando');
?>
<script type="text/javascript">
    var id = "<?php echo $educando['id']; ?>";
    var urlEstados = "<?php echo site_url('requisicao/get_estados'); ?>";
    var urlAcampamentos = "<?php echo site_url('educando/get_tipo_acamp').'/'; ?>" + id;

    //var oTable;
    $(document).ready(function() {

        // recupera estados e municipios selecionando oque está no banco de dados
        $.get(urlEstados, function(estados) {
            $('#educando_sel_est').html(estados);
            $('#educando_sel_mun').html('<option> Selecione o Estado </option>');
        }).done(function() {
            //Deixa selecionado o estado atual se caso for update
            var idEstado = <?php if(array_key_exists(0, $municipio_estado)) echo $municipio_estado[0]->estado; else echo 0;?>;
            if(idEstado > 0){
                $('#educando_sel_est option[value="'+idEstado+'"]').attr('selected', true);
                var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";
                //função adaptada do listCities(); localizado em functions.js
                $('#educando_sel_est').change(function () {
                    var idEstado = $('#educando_sel_est').val();
                    $('#educando_sel_mun').html("<option>Aguarde...</option>");
                    $.get(urlMunicipios + '/' + idEstado, function (cities) {
                            $('#educando_sel_mun').html(cities);
                    }).done(function() {
                        var idMunicipio = <?php if(array_key_exists(0, $municipio_estado)) echo $municipio_estado[0]->cidade; else echo 0; ?>;
                        $('#educando_sel_mun option[value="'+idMunicipio+'"]').attr('selected', true);
                    });
                }).change();

            }else{
                var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";
                $("#educando_sel_est").listCities(urlMunicipios, 'educando_sel_mun');
            }
        });
        //Lista Municipios
        $.get(urlAcampamentos, function(response) {
            $('#educando_tipo_terr option[value="'+response+'"]').attr("selected", true);
        });

        var url = "<?php echo site_url('request/get_educando_mun').'/'; ?>" + id;

        /* -IMPLEMENTAÇÃO COM WEBSERVICE. NÃO DELETAR -
        // Dados do WebService
        var assentamentos = <?php echo $assentamentos; ?>;
            assentamentos = $.unique(assentamentos);

        //ORDENA JSON DOS ASSENTAMENTOS
        function sortJSON(data, key, way) {
            return data.sort(function(a, b) {
                var x = a[key]; var y = b[key];
                if (way === '123' ) { return ((x < y) ? -1 : ((x > y) ? 1 : 0)); }
                if (way === '321') { return ((x > y) ? -1 : ((x < y) ? 1 : 0)); }
            });
        }
        assentamentos = sortJSON(assentamentos,'Nome', '123'); // 123 or 321
        var nome_assentamentos = '';
        $.each( assentamentos, function( key, value ) {
          nome_assentamentos  += '<option value="'+assentamentos[key].Nome+'">'+assentamentos[key].Nome+'</option>';
        });
        //CASO FOR ASSENTAMENTO, CRIA SELECTBOX
        $( "#educando_tipo_terr" ).change(function() {
            console.log(assentamentos);
            if($(this).val() == "ASSENTAMENTO"){
                $("#educando_nome_terr").remove();
                $("#educando_territorio").append(
                    $('<select class="form-control" name="educando_nome_terr" id="educando_nome_terr">')
                        .append('<option selected disabled value="">Selecione</option>')
                        .append(nome_assentamentos)
                )
                $('#educando_nome_terr').select2();
            }else{
                $("#educando_nome_terr").select2('destroy'); 
                $("#educando_nome_terr").remove();
                $("#educando_territorio").append('<input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr">')
            }
        });
        */
        //ATUALIZA ASSENTAMENTOS CONFORME ESTADO
        $( "#educando_sel_est" ).change(function() {
            var urlAssentamentos = "<?php echo site_url('requisicao/get_assentamentos').'/'; ?>" + $('#educando_sel_est option:selected').text();
            if($("#educando_tipo_terr").val() == "ASSENTAMENTO"){
                $.get(urlAssentamentos, function(assentamentos) {
                    $("#educando_nome_terr").select2('destroy');
                    $("#educando_nome_terr").remove();
                    $("#educando_territorio").append(
                        $('<select class="form-control" name="educando_nome_terr" id="educando_nome_terr">')
                            .append('<option selected disabled value="">Selecione</option>')
                            .append(assentamentos)
                    )
                    $('#educando_nome_terr').select2();
                });
            }
        });
        //CASO FOR ASSENTAMENTO, CRIA SELECTBOX
        $( "#educando_tipo_terr" ).change(function() {
            var urlAssentamentos = "<?php echo site_url('requisicao/get_assentamentos').'/'; ?>" + $('#educando_sel_est option:selected').text();
            if($(this).val() == "ASSENTAMENTO"){
                $.get(urlAssentamentos, function(assentamentos) {
                    $("#educando_nome_terr").remove();
                    $("#educando_territorio").append(
                        $('<select class="form-control" name="educando_nome_terr" id="educando_nome_terr">')
                            .append('<option selected disabled value="">Selecione</option>')
                            .append(assentamentos)
                    )
                    $('#educando_nome_terr').select2();
                });
            }else{
                $("#educando_nome_terr").select2('destroy');
                $("#educando_nome_terr").remove();
                $("#educando_territorio").append('<input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr">')
            }
        });
        /*
        var table = new Table({
            url      : url,
            table    : $('#cities_table'),
            controls : $('#cities_controls')
        });

        table.hideColumns([0,1,3]);
        */
        /* Masking Inputs */
        $('#educando_data_nasc').mask('99/99/9999');
        $('#inicio_curso').mask('99/9999');

        // Não informados
        $('#ckCPF_ni').niCheck({
            'id' : ['educando_cpf', 'ckCPF_na']
        });

        $('#ckCPF_na').niCheck({
            'id' : ['educando_cpf', 'ckCPF_ni']
        });

        $('#ckRg_ni').niCheck({
            'id' : ['educando_rg', 'ckRg_na']
        });

        $('#ckRg_na').niCheck({
            'id' : ['educando_rg', 'ckRg_ni']
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
                            'id'      : 'inicio_curso',
                            'message' : 'Informe mês e ano do início da realização do curso',
                            'extra'   : {
                                'operation' : 'date',
                                'message'   : 'A data informada é inválida'
                            }
                        }
                    );

                    if (isFormComplete(form)) {
                        $('#atualizar_ic').val(1);
                        $('#inicio_curso_hidden').val($('#inicio_curso').val());
                        $('#educando_data_nasc').focusout();

                        return true;
                    }

                }, [370,550]);
            }
        });
        /* FUNÇÃO ADD MUNICIO TABELA
        $('#educando_botao_mun').click(function () {
            var form = Array(
                {
                    'id'      : 'educando_sel_est',
                    'message' : 'Selecione o estado',
                    'extra'   : null
                },

                {
                    'id'      : 'educando_sel_mun',
                    'message' : 'Selecione o município',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {
                cod_estado = $('#educando_sel_est').val();
                cod_municipio = $('#educando_sel_mun').val();
                estado = $('#educando_sel_est option:selected').text();
                municipio = $('#educando_sel_mun option:selected').text();

                var node = ['N', cod_municipio, municipio, cod_estado, estado];

                if (! table.nodeExists(node)) {

                    //$('#municipios_table').dataTable().fnAddData(node);
                    table.addData(node);

                    $('#educando_sel_est').val(0);
                    $('#educando_sel_mun').val(0);

                } else {
                    $('#educando_sel_mun').showErrorMessage('Município já cadastrado');
                }
            }
        });
        */
        /* Add a click handler for the delete row
        $('#deletar').click( function() {
            var anSelected = fnGetSelected( oTable );
            if ( anSelected.length !== 0 ) {
                oTable.fnDeleteRow( anSelected[0] );
            }
        } );*/


        /* NÃO INFROMADOS */
        $('#ckSexo_ni').niCheck({
            'name' : ['reducando_sexo']
        });

        $('#ckEducando_data_nasc').niCheck({
            'id' : ['educando_data_nasc']
        });

        $('#ckEducando_idade').niCheck({
            'id' : ['educando_idade']
        });

        $('#ckEducandoConcluinte_ni').niCheck({
            'name' : ['reducando_concluinte']
        });

        $('#salvar').click(function () {

            var form = Array(
                {
                    'id'      : 'educando_nome',
                    'message' : 'Informe o nome do(a) educando(a)',
                    'extra'   : null
                },

                {
                    'name'    : 'reducando_sexo',
                    'ni'      : $('#ckSexo_ni').prop('checked'),
                    'message' : 'Informe o sexo do(a) educando(a)',
                    'extra'   : null
                },

                {
                    'id'      : 'educando_cpf',
                    'ni'      : ($('#ckCPF_ni').prop('checked') ||
                                  $('#ckCPF_na').prop('checked')),
                    'message' : 'Informe o CPF do(a) educando(a)',
                    'extra'   : null
                },

                {
                    'id'      : 'educando_rg',
                    'ni'      : ($('#ckRg_ni').prop('checked') ||
                                  $('#ckRg_na').prop('checked')),
                    'message' : 'Informe o RG do(a) educando(a)',
                    'extra'   : null
                },

                {
                    'id'      : 'educando_data_nasc',
                    'ni'      : $('#ckEducando_data_nasc').prop('checked'),
                    'message' : 'Informe a data de nascimento do(a) educando(a)',
                    'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
                },

                {
                    'id'      : 'educando_idade',
                    'ni'      : $('#ckEducando_idade').prop('checked'),
                    'message' : 'A idade do(a) educando(a) é calculada automaticamente a partir da informação preenchida <br />' +
                                'no campo 14.A (inicío da realização do curso) do formulário de Caracterização do curso. <br />' +
                                'Caso não possua tal informação selecione a opção "Não informado".',
                    'extra'   : null
                },

                {
                    'id'      : 'educando_tipo_terr',
                    'message' : 'Informe o tipo de território onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                    'extra'   : null
                },

                {
                    'id'      : 'educando_nome_terr',
                    'message' : 'Informe o nome do território onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                    'extra'   : null
                },
                {
                    'id'      : 'educando_sel_est',
                    'message' : 'Informe o nome o Estado onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso',
                    'extra'   : null
                },
                {
                    'name'    : 'reducando_concluinte',
                    'ni'      : $('#ckEducandoConcluinte_ni').prop('checked'),
                    'message' : 'Informe se o(a) educando(a) concluiu o curso',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {
                var formData = {
                    id : id,
                    educando_nome : $('#educando_nome').val().toUpperCase(),
                    ckSexo_ni : $('#ckSexo_ni').prop('checked'),
                    reducando_sexo : $("input:radio[name=reducando_sexo]:checked").val(),
                    ckCPF_ni : $('#ckCPF_ni').prop('checked'),
                    ckCPF_na : $('#ckCPF_na').prop('checked'),
                    educando_cpf : $('#educando_cpf').val().toUpperCase(),
                    ckRg_ni : $('#ckRg_ni').prop('checked'),
                    ckRg_na : $('#ckRg_na').prop('checked'),
                    educando_rg : $('#educando_rg').val().toUpperCase(),
                    ckEducando_data_nasc : $('#ckEducando_data_nasc').prop('checked'),
                    educando_data_nasc : $('#educando_data_nasc').val(),
                    ckEducando_idade : $('#ckEducando_idade').prop('checked'),
                    educando_idade : $('#educando_idade').val(),
                    educando_tipo_terr : $('#educando_tipo_terr').val(),
                    educando_nome_terr : $('#educando_nome_terr').val().toUpperCase(),
                    ckEducandoConcluinte_ni : $('#ckEducandoConcluinte_ni').prop('checked'),
                    reducando_concluinte : $("input:radio[name=reducando_concluinte]:checked").val(),
                    municipios : $('#educando_sel_mun').val(),
                    //mun_excluidos: table.getDeletedRows(1),
                    inicio_curso : $('#inicio_curso_hidden').val(),
                    atualizar_ic : $('#atualizar_ic').val()
                };

                console.log(formData);

                var urlRequest = "<?php if ($operacao == 'add') echo site_url('educando/add/'); if ($operacao == 'update') echo site_url('educando/update/'); ?>";

                // Faz requisição de login ao servidor (retorna um objeto JSON)
                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('educando/index/'); ?>";

            // Faz requisição de login ao servidor (retorna um objeto JSON)
            request(urlRequest, null, 'hide');
        });

    });

</script>

<?php
    if ($operacao == 'add')
        $retrivial = false;
    else
        $retrivial = true;
?>

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
                <p class="text-danger"><label for="reducando_sexo"><label></p>
            </div>
        </div>
    </div>

    <div class="form-group">
      <label class="negacao">3. CPF (somente n&uacute;meros)</label>

        <div class="checkbox">
            <label class="negacao-sm"> <input type="checkbox" name="ckCPF_ni" id="ckCPF_ni"  value="NAOINFORMADO" <?php if ($retrivial && $dados[0]->cpf == "NAOINFORMADO") echo "checked"; ?>> N&atilde;o encontrado </label>
            <label class="negacao-sm"> <input type="checkbox" name="ckCPF_na" id="ckCPF_na"  value="NAOAPLICA" <?php if ($retrivial && $dados[0]->cpf == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
        </div>
        <div>
            <input type="text" class="form-control tamanho-small" id="educando_cpf" name="educando_cpf" onkeypress="return preventChar('A')" maxlength="11"
                value="<?php if ($retrivial &&  $dados[0]->cpf != "NAOAPLICA" && $dados[0]->cpf != "NAOINFORMADO") echo $dados[0]->cpf; ?>">
            <label class="control-label form" for="educando_cpf"></label>
        </div>
    </div>

    <div class="form-group">
      <label class="negacao">4. R.G.</label>

        <div class="checkbox">
            <label class="negacao-sm"> <input type="checkbox" name="ckRg_ni" id="ckRg_ni"  value="NAOINFORMADO" <?php if ($retrivial && $dados[0]->rg == "NAOINFORMADO") echo "checked"; ?>> N&atilde;o encontrado </label>
            <label class="negacao-sm"> <input type="checkbox" name="ckRg_na" id="ckRg_na"  value="NAOAPLICA" <?php if ($retrivial && $dados[0]->rg == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
        </div>
        <div>
            <input type="text" class="form-control tamanho-small" id="educando_rg" name="educando_rg"  maxlength="25"
                value="<?php if ($retrivial  &&  $dados[0]->rg != "NAOAPLICA" && $dados[0]->rg != "NAOINFORMADO") echo $dados[0]->rg; ?>">
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
                <p class="text-danger select estado"><label for="educando_sel_est"><label></p>
            </div>
        </div>
        <div class="form-group interno">
            <label>b. Município do educando</label>
            <div>
                <select class="form-control select_municipio" id="educando_sel_mun" name="educando_sel_mun"></select>
                <p class="text-danger select municipio"><label for="educando_sel_mun"><label></p>
            </div>
        </div>
        <div class="form-group interno">
            <label>c. Tipo do territ&oacute;rio</label>
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
                <p class="text-danger select"><label for="educando_tipo_terr"><label></p>
            </div>
        </div>

        <div class="form-group interno">
            <label>d. Nome do territ&oacute;rio</label>
            <div id="educando_territorio">
                <input type="text" class="form-control tamanho-n" id="educando_nome_terr" name="educando_nome_terr" value="<?php if ($retrivial) echo $dados[0]->nome_territorio; ?>">
                <label class="control-label form" for="educando_nome_terr"></label>
            </div>
        </div>
    </div>
    <!--
    <div class="table-box table-box-lg">
        <label>8. Munic&iacute;pio(s) do territ&oacute;rio onde o(a) educando(a) vivia e/ou trabalhava quando ingressou no curso</label>
        <div class="form-group">
            <ul id="cities_controls" class="nav nav-pills buttons">
                <li>
                    <select class="form-control select_estado" id="educando_sel_est" name="educando_sel_est"></select>
                    <p class="text-danger select estado"><label for="educando_sel_est"><label></p>
                </li>
                <li>
                    <select class="form-control select_municipio" id="educando_sel_mun" name="educando_sel_mun"></select>
                    <p class="text-danger select municipio"><label for="educando_sel_mun"><label></p>
                </li>
                <li class="buttons"><button type="button" class="btn btn-default" id="educando_botao_mun" name="educando_botao_mun">Adicionar</button></li>
                <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar"> Remover Selecionado </button></li>
            </ul>
        </div>

        <div class="table-size">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="cities_table">
                <thead>
                    <tr>
                        <th style="width:  10px;"> FLAG </th>
                        <th style="width:  10px;"> CÓDIGO MUNICIPIO</th>
                        <th style="width: 250px;"> MUNICÍPIO </th>
                        <th style="width:  10px;"> CÓDIGO ESTADO </th>
                        <th style="width: 250px;"> ESTADO </th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    -->
    <div class="form-group">
        <label class="negacao">8. O(A) educando(a) concluiu o curso ?</label>

        <div class="checkbox negacao-smaller">
            <label> <input type="checkbox" name="ckEducandoConcluinte_ni" id="ckEducandoConcluinte_ni" <?php if ($retrivial && $dados[0]->concluinte == 'I') echo "checked"; ?>> N&atilde;o informado </label>
        </div>

        <div class="radio form-group">
            <div>
                <div class="radio"> <label> <input type="radio" name="reducando_concluinte" id="reducando_concluinte_02" value="S" <?php if ($retrivial && $dados[0]->concluinte == 'S') echo "checked"; ?>> Sim  </label> </div>
                <div class="radio"> <label> <input type="radio" name="reducando_concluinte" id="reducando_concluinte_01" value="N" <?php if ($retrivial && $dados[0]->concluinte == 'N') echo "checked"; ?>> N&atilde;o </label> </div>
                <p class="text-danger"><label for="reducando_concluinte"><label></p>
            </div>
        </div>
    </div>
    <!--<input type="text" id="municipios_objeto" name="municipios_objeto" hidden/>-->

    <input type="hidden" id="inicio_curso_hidden" name="inicio_curso_hidden" value="<?php echo $dados[0]->inicio_curso; ?>"/>
    <input type="hidden" id="atualizar_ic" name="atualizar_ic" value="0"/>

    <div id="dialog_inicio_curso" class="dialog" title="Cadastro do período de início do curso">
        <br />
        <h5>
            Para que seja realizado o cálculo da idade do educando
            é necessário que seja preenchido o campo 14.A
            (inicío da realização do curso) do fomulário de Caracterização do curso

            <br /><br />

            <strong>Para realizar o cadastro informe o dado no campo abaixo (Mês/Ano)</strong>
        <h5>
        <div class="form-group">
            <div>
                <input type="text" class="form-control tamanho-sm2" id="inicio_curso" name="inicio_curso" palceholder="MM/AAAA">
                <label class="control-label form" for="inicio_curso"></label>
            </div>
        </div>

        <h4>Efetuar cadastro?</h4>
    </div>

  </fieldset>

<?php echo form_close(); ?>
