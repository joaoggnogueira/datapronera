<?php
    $this->session->set_userdata('curr_content', 'producao9c');
?>
<script type="text/javascript">

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";

        var urlAutores = "<?php echo site_url('request/get_pesquisa_capitulo_livro_autor').'/'; ?>" + id;
        var urlOrganizadores = "<?php echo site_url('request/get_pesquisa_capitulo_livro_organizador').'/'; ?>" + id;

        var tableAutores = new Table({
            url      : urlAutores,
            table    : $('#author_table'),
            controls : $('#author_controls')
        });

        var tableOrganizadores = new Table({
            url      : urlOrganizadores,
            table    : $('#organizer_table'),
            controls : $('#organizer_controls')
        });

        tableAutores.hideColumns([0,1]);
        tableOrganizadores.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#ano').mask("9999");

        $('#autor_add').click(function () {

            var form = Array(
                {
                    'id'      : 'autor',
                    'message' : 'Informe o nome da autor(a)',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#autor').val().toUpperCase();
                var node = ['N', 0, nome];

                if (! tableAutores.nodeExists(node)) {

                    tableAutores.addData(node);

                    $('#autor').val('');

                } else {
                    $('#autor').showErrorMessage('Autor(a) já cadastrado(a)');
                }
            }
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

        $('#salvar').click(function () {

            var form = Array(
                {
                    'id'      : 'tituloCap',
                    'message' : 'Informe o título do capítulo',
                    'extra'   : null
                },

                {
                    'id'      : 'tituloLivro',
                    'message' : 'Informe o título do livro',
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
                    tituloCap : $('#tituloCap').val().toUpperCase(),
                    tituloLivro : $('#tituloLivro').val().toUpperCase(),
                    local : $('#local').val().toUpperCase(),
                    editora : $('#editora').val().toUpperCase(),
                    ano : $('#ano').val().toUpperCase(),
                    disponibilidade : $('#disponibilidade').val().toUpperCase(),
                    autores : tableAutores.getAll(),
                    autor_excluidos: tableAutores.getDeletedRows(1),
                    organizadores : tableOrganizadores.getAll(),
                    organizador_excluidos: tableOrganizadores.getDeletedRows(1)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9c/add/'); if ($operacao != 'add') echo site_url('producao9c/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao9c/index/'); ?>";

            request(urlRequest, null, 'hide');
        });
    });

</script>
<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA<br><br>
                    CAP&Iacute;TULO DE LIVRO</legend>

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
                <label>1.1 Autor(a)(es)(as)</label>
                <ul id="author_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control tamanho negacao" id="autor" name="autor"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="autor_add" name="autor_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar"> Remover Selecionado </button></li>
                    <li><label class="control-label form bold" for="autor"></label></li>
                </ul>
            </div>

            <div class="table-size">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="author_table">
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
            <label>1.2. Titulo do Cap&iacute;tulo</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="tituloCap" name="tituloCap"
                    value="<?php if ($operacao != 'add') echo $dados[0]->titulo_capitulo; ?>">
                <label class="control-label form bold" for="tituloCap"></label>
            </div>
        </div>

        <div class="table-box table-box-small">
            <div class="form-group">
                <label>1.3 Organizador(a)(es)(as) do livro</label>
                <ul id="organizer_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control tamanho negacao" id="organizador" name="organizador"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="organizador_add" name="organizador_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar"> Remover Selecionado </button></li>
                    <li><label class="control-label form" for="organizador"></label></li>
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
            <label>1.4. Titulo do Livro</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="tituloLivro" name="tituloLivro"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo_livro; ?>" >
                <label class="control-label form bold" for="tituloLivro"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.5. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local" name="local"
                    value="<?php if ($operacao != 'add') echo $dados[0]->local_producao; ?>" >
                <label class="control-label form bold" for="local"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.6. Editora</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="editora" name="editora"
                    value="<?php if ($operacao != 'add') echo $dados[0]->editora; ?>">
                <label class="control-label form bold" for="editora"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.7. Ano</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="ano" name="ano"
                    value="<?php if ($operacao != 'add') echo $dados[0]->ano; ?>" >
                <label class="control-label form bold" for="ano"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.8. Onde está disponível</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="disponibilidade" name="disponibilidade"
                    value="<?php if ($operacao != 'add') echo $dados[0]->disponibilidade; ?>" >
                <label class="control-label form bold" for="disponibilidade"></label>
            </div>
        </div>

    </fieldset>
</form>