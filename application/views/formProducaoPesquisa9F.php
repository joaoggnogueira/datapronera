<?php
    $this->session->set_userdata('curr_content', 'producao9f');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_pesquisa_periodico_autor').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#organizer_table'),
            controls : $('#organizer_controls')
        });

        table.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#ano').mask("9999");

        $('#botao_add').click(function () {

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

                if (! table.nodeExists(node)) {

                    //$('#organizador_table').dataTable().fnAddData(node);
                    table.addData(node);

                    $('#organizador').val('');

                } else {
                    $('#organizador').showErrorMessage('Organizador(a) já cadastrado(a)');
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
                    'id'      : 'editora',
                    'message' : 'Informe a editora da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'ano',
                    'message' : 'Informe o ano da produção',
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
                    titulo  : $('#titulo').val().toUpperCase(),
                    local  : $('#local').val().toUpperCase(),
                    ano  : $('#ano').val(),
                    editora : $('#editora').val().toUpperCase(),
                    disponibilidade  : $('#disponibilidade').val().toUpperCase(),
                    organizadores : table.getAll(),
                    organizador_excluidos: table.getDeletedRows(1)
                };

                var urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9f/add/'); if ($operacao != 'add') echo site_url('producao9f/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao9f/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>
<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA <br><br>
                    PERI&Oacute;DICO</legend>

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
                    <li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="botao_add"> Remover Selecionado </button></li>
                    <li><label class="control-label form bold" for="organizador"></label></li>
                </ul>
            </div>

            <div class="table-size">
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
            <label>1.3. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local" name="local"
                    value="<?php if ($operacao != 'add') echo $dados[0]->local_producao; ?>" >
                <label class="control-label form bold" for="local"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.4. Editora</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="editora" name="editora"
                    value="<?php if ($operacao != 'add') echo $dados[0]->editora; ?>">
                <label class="control-label form bold" for="editora"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.5. Ano</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="ano" name="ano"
                    value="<?php if ($operacao != 'add') echo $dados[0]->ano; ?>" >
                <label class="control-label form bold" for="ano"></label>
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