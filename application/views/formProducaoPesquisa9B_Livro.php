<?php
    $this->session->set_userdata('curr_content', 'producao9b-livro');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_pesquisa_livro_autor').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#author_table'),
            controls : $('#author_controls')
        });

        table.hideColumns([0,1]);

        /* Init the table */
        //$('#autor_table').tableInit(url);

        /* Add a click handler to select the rows
        $("#autor_table tbody").click(function(event) {
            $(oTable.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('active');
            });
            $(event.target.parentNode).addClass('active');
        });*/

        /* Máscara para inputs */
        $('#ano').mask("9999");

        /* Opções complementares */
        $('input:radio[name=rformato]').optionCheck({
            'id' : ['pagina_web']

        }, "ON-LINE");

        $('#botao_add').click(function () {

            var form = Array(
                {
                    'name'    : 'rtipo',
                    'message' : 'Informe o tipo do elaborador da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'autor',
                    'message' : "Informe o nome do(a) autor(a) / organizador(a)",
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#autor').val().toUpperCase();
                var tipo = $('input:radio[name=rtipo]:checked').val();

                var node = ['A', null, nome, tipo];

                if (! table.nodeExists(node)) {

                    //$('#autor_table').dataTable().fnAddData(node);
                    table.addData(node);

                    $('#autor').val('');
                    $('input:radio[name=rtipo]').prop('checked', false);

                } else {
                    var error = tipo.charAt(0).toUpperCase() + tipo.slice(1).toLowerCase();

                    $('#autor').showErrorMessage(error +' já cadastrado(a)');
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
                    'name'    : 'rformato',
                    'message' : 'Informe o formato da produção',
                    'next'    : false,
                    'extra'   : null
                },

                {
                    'id'      : 'pagina_web',
                    'ni'      : !$('#rformato_03').prop('checked'),
                    'message' : 'Informe o endereço web da produção',
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
                    editora : $('#editora').val().toUpperCase(),
                    ano : $('#ano').val().toUpperCase(),
                    rformato : $("input:radio[name=rformato]:checked").val(),
                    disponibilidade : $('#disponibilidade').val().toUpperCase(),
                    pagina_web : $('#pagina_web').val().toUpperCase(),
                    autores : table.getAll()
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao9b_livro/add/'); if ($operacao != 'add') echo site_url('producao9b_livro/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao9b_livro/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>
<form>
    <fieldset>
        <legend>Caracteriza&ccedil;&atilde;o da Produ&ccedil;&atilde;o Bibliogr&aacute;fica sobre o PRONERA <br><br>
                LIVRO</legend>

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
                <label>1.1. Autor(a)(es)(as) / Organizador(a)(es)(as)</label>

                <div class="radio form-group">
                    <div class="radio radio-inline" style="margin-top:0;"> <label> <input type="radio" name="rtipo" id="rtipo_02" value="AUTOR(A)"> Autor(a) </label> </div>
                    <div class="radio radio-inline"> <label> <input type="radio" name="rtipo" id="rtipo_03" value="ORGANIZADOR(A)"> Organizador(a) </label> </div>

                    <p class="text-danger"><label for="rtipo"><label></p>
                </div>
            </div>
            <div class="form-group">
                <ul id="author_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control negacao" id="autor" name="autor" placeHolder="Nome"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row"> Remover Selecionado </button></li>
                    <li><label class="control-label form" for="autor"></label></li>
                </ul>
            </div>

            <div class="table-size">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="author_table">
                    <thead>
                        <tr>
                            <th style="width:   0px"> RECOVERED </th>
                            <th style="width:   0px"> ID </th>
                            <th style="width: 200px"> NOME </th>
                            <th style="width: 100px"> TIPO </th>
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
            <label>10. Formato</label>

            <div class="radio form-group">
                <div class="radio"> <label> <input type="radio" name="rformato" id="rformato_01" value="DIGITAL / CD"
                <?php if($operacao != 'add' && $dados[0]->formato == 'DIGITAL / CD') echo "checked"; ?> > Digital / CD </label> </div>

                <div class="radio"> <label> <input type="radio" name="rformato" id="rformato_02" value="IMPRESSO"
                <?php if($operacao != 'add' && $dados[0]->formato == 'IMPRESSO') echo "checked"; ?> > Impresso </label> </div>

                <div class="radio"> <label> <input type="radio" name="rformato" id="rformato_03" value="ON-LINE"
                <?php if($operacao != 'add' && $dados[0]->formato == 'ON-LINE') echo "checked"; ?> > On-line </label> </div>

               <div>
                   <input type="text" class="form-control tamanho-lg url" id="pagina_web" name="pagina_web" placeHolder="Informe o endereço web"
                        <?php
                            if ($operacao != 'add' && $dados[0]->formato != 'IMPRESSAO' && $dados[0]->formato != 'DIGITAL / CD') {
                                echo 'value="'.$dados[0]->formato.'"';

                            } else {
                                echo "style=\"display:none\";";
                            }
                        ?>
                    >
                    <p class="text-danger"><label for="rformato"><label></p>
                    <label class="control-label form bold" for="pagina_web"></label>
               </div>
            </div>
        </div>

        <div class="form-group">
            <label>1.7. Onde está disponível</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="disponibilidade" name="disponibilidade"
                    value="<?php if ($operacao != 'add') echo $dados[0]->disponibilidade; ?>" >
                <label class="control-label form bold" for="disponibilidade"></label>
            </div>
        </div>

    </fieldset>
</form>