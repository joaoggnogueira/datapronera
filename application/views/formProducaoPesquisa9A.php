<?php
    $this->session->set_userdata('curr_content', 'producao9a');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_pesquisa_academico_autor').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#author_table'),
            controls : $('#author_controls')
        });

        table.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#ano').mask("9999");

        $('#botao_add').click(function () {

            var form = Array(
                {
                    'id'      : 'autor',
                    'message' : 'Informe o nome do(a) autor(a)',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#autor').val().toUpperCase();
                var node = ['N', 0, nome];

                if (! table.nodeExists(node)) {

                    //$('#autor_table').dataTable().fnAddData(node);
                    table.addData(node);

                    $('#autor').val('');

                } else {
                    $('#autor').showErrorMessage('Autor(a) já cadastrado(a)');
                }
            }
        });

        $('#salvar').click(function () {

            var form = Array(
                {
                    'name'    : 'rtipo',
                    'message' : 'Informe a natureza da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'titulo',
                    'message' : 'Informe o título da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'programa',
                    'message' : 'Informe o curso em que foi desenvolvida a produção',
                    'extra'   : null
                },

                {
                    'id'      : 'instituicao',
                    'message' : 'Informe a instituição em que foi desenvolvida a produção',
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
                    'id'      : 'orientador',
                    'message' : 'Informe o nome do orientador da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'disponivel',
                    'message' : 'Informe onde a produção está disponível',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    rtipo : $("input:radio[name=rtipo]:checked").val(),
                    titulo  : $('#titulo').val().toUpperCase(),
                    programa  : $('#programa').val().toUpperCase(),
                    instituicao  : $('#instituicao').val().toUpperCase(),
                    local  : $('#local').val().toUpperCase(),
                    ano  : $('#ano').val().toUpperCase(),
                    orientador  : $('#orientador').val().toUpperCase(),
                    disponivel  : $('#disponivel').val().toUpperCase(),
                    autores : table.getAll(),
                    autor_excluidos: table.getDeletedRows(1)
                };

                var urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9a/add/'); if ($operacao != 'add') echo site_url('producao9a/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            var urlRequest = "<?php echo site_url('producao9a/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>
<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA <br><br>
                Monografia / TCC / Disserta&ccedil;&atilde;o / Tese</legend>

        <div class="form-group controles">
            <?php
                if ($operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="form-group">
            <label>1. Natureza da Produ&ccedil;&atilde;o</label>

            <div class="radio form-group">
                <div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_01" value="MONOGRAFIA / TCC" <?php if ($operacao != 'add' && $dados[0]->natureza_producao == 'MONOGRAFIA / TCC') echo 'checked'; ?>> Monografia / TCC </label> </div>
                <div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_02" value="DISSERTAÇÃO" <?php if ($operacao != 'add' && $dados[0]->natureza_producao == 'DISSERTAÇÃO') echo 'checked'; ?>> Disserta&ccedil;&atilde;o </label> </div>
                <div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_03" value="TESE" <?php if ($operacao != 'add' && $dados[0]->natureza_producao == 'TESE') echo 'checked'; ?>> Tese </label> </div>

                <p class="text-danger"><label for="rtipo"><label></p>
            </div>
        </div>

        <div class="table-box table-box-small">
            <div class="form-group">
                <label>1.1 Autor (a)(es)(as)</label>
                <ul id="author_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control tamanho negacao" id="autor" name="autor"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="botao_add"> Remover Selecionado </button></li>
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
            <label>1.2. Titulo</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="titulo" name="titulo"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo; ?>" >
                <label class="control-label form bold" for="titulo"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.3. Curso</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="programa" name="programa"
                    value="<?php if($operacao != 'add') echo $dados[0]->programa_curso; ?>" >
                <label class="control-label form bold" for="programa"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.4. Institui&ccedil;&atilde;o</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="instituicao" name="instituicao"
                    value="<?php if($operacao != 'add') echo $dados[0]->instituicao; ?>" >
                <label class="control-label form bold" for="instituicao"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.5. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local" name="local"
                    value="<?php if($operacao != 'add') echo $dados[0]->local_producao; ?>" >
                <label class="control-label form bold" for="local"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.6. Ano </label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="ano" name="ano"
                    value="<?php if($operacao != 'add') echo $dados[0]->ano; ?>" >
                <label class="control-label form bold" for="ano"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.7. Orientador(a)</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="orientador" name="orientador"
                    value="<?php if($operacao != 'add') echo $dados[0]->orientador; ?>" >
                <label class="control-label form bold" for="orientador"></label>
            </div>
        </div>

        <div class="form-group">
            <label>1.8. Onde est&aacute; dispon&iacute;vel</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="disponivel" name="disponivel"
                    value="<?php if($operacao != 'add') echo $dados[0]->disponibilidade; ?>" >
                <label class="control-label form bold" for="disponivel"></label>
            </div>
        </div>

    </fieldset>
</form>