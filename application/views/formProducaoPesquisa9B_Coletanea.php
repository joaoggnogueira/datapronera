<?php
    $this->session->set_userdata('curr_content', 'producao9b-livro');
?>

<script type="text/javascript">
    $(document).ready(function () {

        var id = "<?php echo $producao['id']; ?>";

        var tableStored = new Table({
            url      : "<?php echo site_url('request/get_pesquisa_livro'); ?>",
            table    : $('#stored_books_table'),
            controls : $('#stored_books_controls')
        });

        tableStored.hideColumns([0]);

        var tableAdded = new Table({
            url      : "<?php echo site_url('request/get_pesquisa_coletanea_livro').'/'; ?>" + id,
            table    : $('#added_books_table'),
            controls : $('#added_books_controls')
        });

        tableAdded.hideColumns([0]);

        $('#salvar').click(function () {

            var form = Array(
                {
                    'id'      : 'titulo',
                    'message' : 'Informe o título da coletânea',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    titulo : $('#titulo').val().toUpperCase(),
                    livros : tableAdded.getAllByIndex(0)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9b_col/add/'); if ($operacao != 'add') echo site_url('producao9b_col/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao9b_col/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

        $('#add').click(function () {

            var node = tableStored.getSelectedData();

            if (! tableAdded.nodeExists(node)) {
                tableAdded.addData(node);
                tableStored.deleteSelectedRow();
            }
        });

        $('#delete').click(function () {

            var node = tableAdded.getSelectedData();

            if (! tableStored.nodeExists(node)) {
                tableStored.addData(node);
                tableAdded.deleteSelectedRow();
            }
        });

        // Navigation tabs
        $('#collection-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>

<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA<br><br>
                COLET&Acirc;NEA</legend>

        <div class="form-group controles">
            <?php
                if ($operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="form-group">
            <label>Título da Coletânea</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="titulo" name="titulo"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo; ?>" >
                <label class="control-label form bold" for="titulo"></label>
            </div>
        </div>

        <ul class="nav nav-tabs" id="collection-tab" style="width: 800px;">
            <li class="active"><a href="#added">Livros Adicionados à Coletânea</a></li>
            <li><a href="#stored">Livros Cadastrados no Sistema</a></li>
        </ul>


        <div class="tab-content" style="width: 800px;">

            <div class="tab-pane active" id="added">
                <div id="grid-small">
                    <ul id="added_books_controls" class="nav nav-pills buttons">
                        <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled" id="delete" name="delete"> Remover Selecionado </button></li>
                    </ul>
                    <div class="table-size table-size-lg">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="added_books_table">
                            <thead>
                                <tr>
                                    <th width=" 10px;"> ID </th>
                                    <th width="620px;"> TÍTULO </th>
                                    <th width="150px;"> EDITORA </th>
                                    <th width=" 60px;"> ANO </th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="stored">
                <div id="grid-small">
                    <ul id="stored_books_controls" class="nav nav-pills buttons">
                        <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled" id="add" name="add"> Adicionar à Coletânea </button></li>
                    </ul>
                    <div class="table-size table-size-lg">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="stored_books_table">
                            <thead>
                                <tr>
                                    <th width=" 10px;"> ID </th>
                                    <th width="620px;"> TÍTULO </th>
                                    <th width="150px;"> EDITORA </th>
                                    <th width=" 60px;"> ANO </th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </fieldset>
</form>