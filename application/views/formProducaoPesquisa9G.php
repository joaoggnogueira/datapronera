<?php
    $this->session->set_userdata('curr_content', 'producao9g');
?>

<script type="text/javascript">

    //var oTable, oTable2;
    var id = "<?php echo $producao['id']; ?>";

    var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";
    var urlEstados = "<?php echo site_url('requisicao/get_estados'); ?>";
    var urlRetrivial = "<?php echo site_url('producao9g/get_estado').'/'; ?>" + id;

    // recupera estados e municipios selecionando oque está no banco de dados
    $.get(urlEstados, function(estados) {
        $('#sel_est').html(estados);
        $('#sel_mun').html('<option> Selecione o Estado </option>');

        if (id != 0) {
            $.get(urlRetrivial, function(estado) {
                $('#sel_est option[value="'+estado+'"]').attr("selected", true);

                $.get(urlMunicipios + "/" + estado, function(cidades) {
                    $('#sel_mun').html(cidades);

                    urlRetrivial = "<?php echo site_url('producao9g/get_cidade').'/'; ?>" + id;

                    $.get(urlRetrivial, function(municipio) {
                        $('#sel_mun option[value="'+municipio+'"]').attr("selected", true);
                    });
                });
            });
        }
    });

    $(document).ready(function() {

        // Lista de Municípios
        $('#sel_est').listCities(urlMunicipios, 'sel_mun');

        var urlOrganizadores = "<?php echo site_url('request/get_pesquisa_evento_organizador').'/'; ?>" + id;
        var urlOrganizacoes = "<?php echo site_url('request/get_pesquisa_evento_organizacao').'/'; ?>" + id;

        var tableOrganizadores = new Table({
            url      : urlOrganizadores,
            table    : $('#organizer_table'),
            controls : $('#organizer_controls')
        });

        var tableOrganizacoes = new Table({
            url      : urlOrganizacoes,
            table    : $('#organization_table'),
            controls : $('#organization_controls')
        });

        tableOrganizadores.hideColumns([0,1]);
        tableOrganizacoes.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#data').mask("99/99/9999");

        /* Não informados */
        $('#ck_nao').niCheck({
            'id' : [
                'ck_memoria', 'memoria_descricao',
                'ck_carta', 'carta_descricao',
                'ck_relatorio', 'relatorio_descricao',
                'ck_anais', 'anais_descricao',
                'ck_video', 'video_descricao'
            ]
        });

        /* Opções complementares */
        $('#ck_memoria').optionCheck({
            'id' : ['memoria_descricao']
        });

        $('#ck_carta').optionCheck({
            'id' : ['carta_descricao']
        });

        $('#ck_relatorio').optionCheck({
            'id' : ['relatorio_descricao']
        });

        $('#ck_anais').optionCheck({
            'id' : ['anais_descricao']
        });

        $('#ck_video').optionCheck({
            'id' : ['video_descricao']
        });

        $('#organizador_add').click(function () {

            var form = Array(
                {
                    'id'      : 'organizador',
                    'message' : 'Informe o nome do(a) organizador(a)',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#organizador').val().toUpperCase();
                var node = ['N', 0, nome];

                if (! tableOrganizadores.nodeExists(node)) {

                    tableOrganizadores.addData(node);

                    $('#organizador').val('');

                } else {
                    $('#organizador').showErrorMessage('Organizador(a) já cadastrado(a)');
                }
            }
        });

        $('#organizacao_add').click(function () {

            var form = Array(
                {
                    'id'      : 'organizacao',
                    'message' : 'Informe o nome da organização',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#organizacao').val().toUpperCase();
                var node = ['N', 0, nome];

                if (! tableOrganizacoes.nodeExists(node)) {

                    tableOrganizacoes.addData(node);

                    $('#organizacao').val('');

                } else {
                    $('#organizacao').showErrorMessage('Organização já cadastrada');
                }
            }
        });

        $('#salvar').click(function () {

            var form  = Array(
                {
                    'id'      : 'titulo',
                    'message' : 'Informe o título do evento',
                    'extra'   : null
                },

                {
                    'id'      : 'local',
                    'message' : 'Informe o local do evento',
                    'extra'   : null
                },

                {
                    'id'      : 'sel_est',
                    'message' : 'Selecione o estado',
                    'extra'   : null
                },

                {
                    'id'      : 'sel_mun',
                    'message' : 'Selecione o município',
                    'extra'   : null
                },

                {
                    'id'      : 'data',
                    'message' : 'Informe a data do evento',
                    'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
                },

                {
                    'name'    : 'revento',
                    'message' : 'Informe a abrangência do evento',
                    'extra'   : null
                },

                {
                    'id'      : 'participante',
                    'message' : 'Informe o número de participantes do evento',
                    'extra'   : null
                },

                {
                    'name'    : 'ck_doc_final',
                    'message' : 'Informe se o evento produziu algum documento final',
                    'ignore'  : 5,
                    'extra'   : null
                },

                {
                    'id'      : 'memoria_descricao',
                    'ni'      : !$('#ck_memoria').prop('checked'),
                    'message' : 'Informe onde está disponível o documento',
                    'extra'   : null
                },

                {
                    'id'      : 'carta_descricao',
                    'ni'      : !$('#ck_carta').prop('checked'),
                    'message' : 'Informe onde está disponível o documento',
                    'extra'   : null
                },

                {
                    'id'      : 'relatorio_descricao',
                    'ni'      : !$('#ck_relatorio').prop('checked'),
                    'message' : 'Informe onde está disponível o documento',
                    'extra'   : null
                },

                {
                    'id'      : 'anais_descricao',
                    'ni'      : !$('#ck_anais').prop('checked'),
                    'message' : 'Informe onde está disponível o documento',
                    'extra'   : null
                },

                {
                    'id'      : 'video_descricao',
                    'ni'      : !$('#ck_video').prop('checked'),
                    'message' : 'Informe onde está disponível o documento',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    titulo : $('#titulo').val().toUpperCase(),
                    local : $('#local').val().toUpperCase(),
                    sel_mun : $('#sel_mun').val().toUpperCase(),
                    data : $('#data').val().toUpperCase(),
                    revento : $("input:radio[name=revento]:checked").val(),
                    participante : $('#participante').val().toUpperCase(),
                    ck_nao : ($('#ck_nao').is(':checked') ? 1 : 0),
                    ck_memoria : ($('#ck_memoria').is(':checked') ? 1 : 0),
                    memoria_descricao : $('#memoria_descricao').val().toUpperCase(),
                    ck_carta : ($('#ck_carta').is(':checked') ? 1: 0),
                    carta_descricao : $('#carta_descricao').val().toUpperCase(),
                    ck_relatorio : ($('#ck_relatorio').is(':checked') ? 1 : 0),
                    relatorio_descricao : $('#relatorio_descricao').val().toUpperCase(),
                    ck_anais : ($('#ck_anais').is(':checked') ? 1 : 0),
                    anais_descricao : $('#anais_descricao').val().toUpperCase(),
                    ck_video : ($('#ck_video').is(':checked') ? 1 : 0),
                    video_descricao : $('#video_descricao').val().toUpperCase(),
                    organizadores : tableOrganizadores.getAll(),
                    organizador_excluidos: tableOrganizadores.getDeletedRows(1),
                    organizacoes : tableOrganizacoes.getAll(),
                    organizacao_excluidos: tableOrganizacoes.getDeletedRows(1)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9g/add/'); if ($operacao == 'update') echo site_url('producao9g/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao9g/index/'); ?>";

            request(urlRequest, null, 'hide');
        });
        
        $("#participante").keypress(function (e) {
            preventChar(e);
        });

    });

</script>
<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA <br><br>
                    EVENTO</legend>

        <div class="form-group controles">
            <?php
                if ($operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="table-box table-box-small">
            <div class="form-group">
                <label>1.1 Organizador(a)(es)(as)</label>
                <ul id="organizer_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control tamanho negacao" id="organizador" name="organizador"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="organizador_add" name="organizador_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar"> Remover Selecionado </button></li>
                    <li><label class="control-label form bold" for="organizador"></label></li>
                </ul>
            </div>

            <div class="box-size">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="organizer_table">
                    <thead>
                        <tr>
                            <th style="width: 10px"> FLAG </th>
                            <th style="width: 10px"> ID </th>
                            <th style="width: 200px"> NOME </th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label>1.2. Titulo</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="titulo" name="titulo"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo; ?>" >
                <label class="control-label form bold" for="titulo"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.4. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local" name="local"
                    value="<?php if ($operacao != 'add') echo $dados[0]->local_producao; ?>" >
                <label class="control-label form bold" for="local"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.3. Munic&iacute;pio</label>
            <div>
                <div class="negacao">
                    <select class="form-control select_estado" id="sel_est" name="sel_est"></select>
                    <p class="text-danger select"><label for="sel_est"><label></p>
                </div>
                <div class="negacao">
                    <select class="form-control select_municipio" id="sel_mun" name="sel_mun"></select>
                    <p class="text-danger select"><label for="sel_mun"><label></p>
                </div>
            </div>
        </div>

        <br />
        <div class="form-group"></div>

        <div class="form-group">
            <label>1.4. Data</label>
            <div>
                <input type="text" class="form-control tamanho-small" id="data" name="data"
                    value="<?php if($operacao != 'add') echo $dados[0]->data_producao; ?>" >
                <label class="control-label form bold" for="data"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.5. Abrang&ecirc;ncia</label>

            <div class="radio form-group">
                <div class="radio"> <label> <input type="radio" name="revento" id="revento_01" value="LOCAL"
                    <?php if ($operacao != 'add' && $dados[0]->abrangencia == 'LOCAL') echo 'checked'; ?> > Local </label> </div>
                <div class="radio"> <label> <input type="radio" name="revento" id="revento_02" value="REGIONAL"
                    <?php if ($operacao != 'add' && $dados[0]->abrangencia == 'REGIONAL') echo 'checked'; ?> > Regional </label> </div>
                <div class="radio"> <label> <input type="radio" name="revento" id="revento_03" value="ESTADUAL"
                    <?php if ($operacao != 'add' && $dados[0]->abrangencia == 'ESTADUAL') echo 'checked'; ?> > Estadual </label> </div>
                <div class="radio"> <label> <input type="radio" name="revento" id="revento_04" value="MACRORREGIONAL"
                    <?php if ($operacao != 'add' && $dados[0]->abrangencia == 'MACRORREGIONAL') echo 'checked'; ?> > Macrorregional </label> </div>
                <div class="radio"> <label> <input type="radio" name="revento" id="revento_05" value="NACIONAL"
                    <?php if ($operacao != 'add' && $dados[0]->abrangencia == 'NACIONAL') echo 'checked'; ?> > Nacional </label> </div>
                <div class="radio"> <label> <input type="radio" name="revento" id="revento_06" value="INTERNACIONAL"
                    <?php if ($operacao != 'add' && $dados[0]->abrangencia == 'INTERNACIONAL') echo 'checked'; ?> > Internacional </label> </div>

                <p class="text-danger"><label for="revento"><label></p>
            </div>
        </div>

        <div class="table-box table-box-small">
            <div class="form-group">
                <label>1.6. Organiza&ccedil;&otilde;es respons&aacute;veis pela realiza&ccedil;&atilde;o</label>
                <ul id="organization_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control tamanho negacao" id="organizacao" name="organizacao"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="organizacao_add" name="organizacao_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar"> Remover Selecionado </button></li>
                    <li><label class="control-label form bold" for="organizacao"></label></li>
                </ul>
            </div>

            <div class="table-size">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="organization_table">
                    <thead>
                        <tr>
                            <th style="width: 10px"> FLAG </th>
                            <th style="width: 10px"> ID </th>
                            <th style="width: 200px"> NOME </th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label>1.7. N&uacute;mero de participantes</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="participante" name="participante" maxlength="6"
                    value="<?php if ($operacao != 'add') echo $dados[0]->participantes; ?>" >
                <label class="control-label form bold" for="participante"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.8. O evento produziu algum documento final?</label>

            <div class="checkbox">
                <div class="checkbox"> <label> <input type="checkbox" name="ck_doc_final" id="ck_nao"
                    <?php if ($operacao != 'add' && $dados[0]->op_nao == '1') echo 'checked'; ?> >
                    N&atilde;o </label> </div>

                <div class="form-group">
                    <div class="checkbox"> <label> <input type="checkbox" name="ck_doc_final" id="ck_memoria"
                        <?php if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->memoria == '1') echo 'checked'; ?> >
                        Mem&oacute;ria </label> </div>

                    <div>
                        <input type="text" class="form-control tamanho-lg" id="memoria_descricao" name="memoria_descricao" placeHolder="Disponível em:"
                            <?php
                                if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->memoria == '1') {
                                    echo 'value="'.$dados[0]->memoria_descricao.'"';

                                } else {
                                    echo "style=\"display:none\";";
                                }
                            ?>
                        />
                        <label class="control-label form bold" for="memoria_descricao"></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox"> <label> <input type="checkbox" name="ck_doc_final" id="ck_carta"
                        <?php if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->carta == '1') echo 'checked'; ?> >
                        Carta </label> </div>

                    <div>
                        <input type="text" class="form-control tamanho-lg" id="carta_descricao" name="carta_descricao" placeHolder="Disponível em:"
                            <?php
                                if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->carta == '1') {
                                    echo 'value="'.$dados[0]->carta_descricao.'"';

                                } else {
                                    echo "style=\"display:none\";";
                                }
                            ?>
                        />
                        <label class="control-label form bold" for="carta_descricao"></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox"> <label> <input type="checkbox" name="ck_doc_final" id="ck_relatorio"
                        <?php if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->relatorio == '1') echo 'checked'; ?> >
                        Relat&oacute;rio </label> </div>

                    <div>
                        <input type="text" class="form-control tamanho-lg" id="relatorio_descricao" name="relatorio_descricao" placeHolder="Disponível em:"
                            <?php
                                if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->relatorio == '1') {
                                    echo 'value="'.$dados[0]->relatorio_descricao.'"';

                                } else {
                                    echo "style=\"display:none\";";
                                }
                            ?>
                        />
                        <label class="control-label form bold" for="relatorio_descricao"></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox"> <label> <input type="checkbox" name="ck_doc_final" id="ck_anais"
                        <?php if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->anais == '1') echo 'checked'; ?> >
                        Anais </label> </div>

                    <div>
                        <input type="text" class="form-control tamanho-lg" id="anais_descricao" name="anais_descricao" placeHolder="Disponível em:"
                            <?php
                                if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->anais == '1') {
                                    echo 'value="'.$dados[0]->anais_descricao.'"';

                                } else {
                                    echo "style=\"display:none\";";
                                }
                            ?>
                        />
                        <label class="control-label form bold" for="anais_descricao"></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox"> <label> <input type="checkbox" name="ck_doc_final" id="ck_video"
                        <?php if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->video == '1') echo 'checked'; ?> >
                        V&iacute;deo </label> </div>

                    <div>
                        <input type="text" class="form-control tamanho-lg" id="video_descricao" name="video_descricao" placeHolder="Disponível em:"
                            <?php
                                if ($operacao != 'add' && $dados[0]->op_nao != '1' && $dados[0]->video == '1') {
                                    echo 'value="'.$dados[0]->video_descricao.'"';

                                } else {
                                    echo "style=\"display:none\";";
                                }
                            ?>
                        />
                        <label class="control-label form bold" for="video_descricao"></label>
                    </div>
                </div>

                <p class="text-danger"><label for="ck_doc_final"><label></p>
            </div>
        </div>

    </fieldset>
</form>