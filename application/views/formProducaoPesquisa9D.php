<?php
    $this->session->set_userdata('curr_content', 'producao9d');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_pesquisa_artigo_autor').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#author_table'),
            controls : $('#author_controls')
        });

        table.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#ano').mask("9999");

        /* Opções complementares */
        $('input:radio[name=rtipo]').optionCheck({
            'id' : ['tipo_nome']

        }, "EVENTO");

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
                    'id'      : 'titulo',
                    'message' : 'Informe o título da produção',
                    'extra'   : null
                },

                {
                    'name'    : 'rtipo',
                    'message' : 'Informe o tipo da produção',
                    'next'    : false,
                    'extra'   : null
                },

                {
                    'id'      : 'tipo_nome',
                    'ni'      : !$('#rtipo_02').prop('checked'),
                    'message' : 'Informe o nome do evento',
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
                    'id'      : 'disponibilidade',
                    'message' : 'Informe onde a produção está disponível',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    titulo  : $('#titulo').val().toUpperCase(),
                    rtipo : $("input:radio[name=rtipo]:checked").val(),
                    tipo_nome  : $('#tipo_nome').val().toUpperCase(),
                    local  : $('#local').val().toUpperCase(),
                    ano  : $('#ano').val().toUpperCase(),
                    disponibilidade  : $('#disponibilidade').val().toUpperCase(),
                    autores : table.getAll(),
                    autor_excluidos: table.getDeletedRows(1)
                };

                var urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9d/add/'); if ($operacao != 'add') echo site_url('producao9d/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao9d/index/'); ?>";

            request(urlRequest, null, 'hide');
        });
    });

</script>
<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA<br><br>
                    ARTIGO</legend>

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
            <label>1.3. Tipo</label>

            <div class="radio form-group">
                <div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_01" value="PERIÓDICO"
                    <?php if ($operacao != 'add' && $dados[0]->tipo == 'PERIÓDICO') echo 'checked'; ?>> Periódico </label> </div>
                <div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_02" value="EVENTO"
                    <?php if ($operacao != 'add' && $dados[0]->tipo == 'EVENTO') echo 'checked'; ?>> Evento </label> </div>
                <div>
                    <input type="text" class="form-control tamanho-lg" id="tipo_nome" name="tipo_nome" placeHolder="Descreva"
                        value="<?php if ($operacao != 'add' ) echo $dados[0]->tipo_nome; ?>"
                        <?php
                            if ($operacao != 'add' && $dados[0]->tipo == 'EVENTO') {
                                echo 'value="'.$dados[0]->tipo_nome.'"';

                            } else {
                                echo "style=\"display:none\";";
                            }
                        ?>
                    >
                    <p class="text-danger"><label for="rtipo"><label></p>
                    <label class="control-label form bold" for="tipo_nome"></label>
                </div>
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