<?php
    $this->session->set_userdata('curr_content', 'producao9e');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_pesquisa_video_autor').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#producer_table'),
            controls : $('#producer_controls')
        });

        table.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#ano').mask("9999");

        $('#botao_add').click(function () {

            var form = Array(
                {
                    'id'      : 'produtor',
                    'message' : 'Informe o nome do(a) produtor(a)',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#produtor').val().toUpperCase();
                var node = ['N', 0, nome];

                if (! table.nodeExists(node)) {

                    //$('#produtor_table').dataTable().fnAddData(node);
                    table.addData(node);

                    $('#produtor').val('');

                } else {
                    $('#produtor').showErrorMessage('Produtor(a) já cadastrado(a)');
                }
            }
        });

        $('#salvar').click(function () {

            var form = Array(
                {
                    'id'      : 'titulo',
                    'message' : 'Informe o título da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'local',
                    'message' : 'Informe o local da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'ano',
                    'message' : 'Informe o ano da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'duracao',
                    'message' : 'Informe a duração (em minutos) da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'disponibilidade',
                    'message' : 'Informe onde a produção está disponível',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    titulo : $('#titulo').val().toUpperCase(),
                    local : $('#local').val().toUpperCase(),
                    ano : $('#ano').val(),
                    duracao : $('#duracao').val(),
                    disponibilidade : $('#disponibilidade').val().toUpperCase(),
                    produtores : table.getAll(),
                    produtor_excluidos: table.getDeletedRows(1)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9e/add/'); if ($operacao != 'add') echo site_url('producao9e/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao9e/index/'); ?>";

            request(urlRequest, null, 'hide');
        });
                
        $("#duracao").keypress(function (e) {
            preventChar(e);
        });
    });

</script>
<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA <br><br>
                    V&Iacute;DEO / DOCUMENT&Aacute;RIO</legend>

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
                <label>1.1 Produtor(a)(es)(as)</label>
                <ul id="producer_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control tamanho negacao" id="produtor" name="produtor"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="botao_add"> Remover Selecionado </button></li>
                    <li><label class="control-label form bold" for="produtor"></label></li>
                </ul>
            </div>

            <div class="table-size">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="producer_table">
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
            <label>1.3. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local" name="local"
                    value="<?php if ($operacao != 'add') echo $dados[0]->local_producao; ?>" >
                <label class="control-label form bold" for="local"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.4. Ano</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="ano" name="ano"
                    value="<?php if ($operacao != 'add') echo $dados[0]->ano; ?>" >
                <label class="control-label form bold" for="ano"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.5. Dura&ccedil;&atilde;o (em minutos)</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="duracao" name="duracao" maxlength="5"
                    value="<?php if ($operacao != 'add') echo $dados[0]->duracao; ?>" >
                <label class="control-label form bold" for="duracao"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.6. Onde está disponível</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="disponibilidade" name="disponibilidade"
                    value="<?php if ($operacao != 'add') echo $dados[0]->disponibilidade; ?>" >
                <label class="control-label form bold" for="disponibilidade"></label>
            </div>
        </div>

    </fieldset>
</form>