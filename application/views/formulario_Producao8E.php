<?php
    $this->session->set_userdata('curr_content', 'producao8e');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_autor_producao_livro').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#author_table'),
            controls : $('#author_controls')
        });

        table.hideColumns([0,1]);

        /* Máscara para inputs */
        $('#ano').mask("9999");

        /* Opções complementares */
        $('input:radio[name=rformato]').optionCheck({
            'id' : ['pagina_web']

        }, "ON-LINE");

        $('#botao_add').click(function () {

            var form = Array(
                {
                    'name'    : 'raut_org',
                    'message' : 'Informe o tipo do elaborador da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'autor',
                    'message' : 'Informe o nome do(a) autor(a) / organizador(a)',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#autor').val().toUpperCase();
                var tipo = $('input:radio[name=raut_org]:checked').val();

                var node = ['N', 0, nome, tipo];

                console.log(tipo);

                if (! table.nodeExists(node)) {

                    //$('#autor_table').dataTable().fnAddData(node);
                    table.addData(node);

                    $('#autor').val('');
                    $('input:radio[name=raut_org]').prop('checked', false);

                } else {
                    var error = tipo.charAt(0).toUpperCase() + tipo.slice(1).toLowerCase();

                    $('#autor').showErrorMessage(error +' já cadastrado(a)');
                }
            }
        });

        $('#salvar').click(function () {

            var form = Array(
                {
                    'name'    : 'rtipo',
                    'message' : 'Informe o tipo da produção',
                    'extra'   : null
                },

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
                    rtipo : $("input:radio[name=rtipo]:checked").val(),
    				titulo : $('#titulo').val().toUpperCase(),
    				local : $('#local').val().toUpperCase(),
    				editora : $('#editora').val().toUpperCase(),
    				ano : $('#ano').val().toUpperCase(),
    				rformato : $("input:radio[name=rformato]:checked").val(),
    				pagina_web : $('#pagina_web').val().toUpperCase(),
    				disponibilidade : $('#disponibilidade').val().toUpperCase(),
                    autores : table.getAll(),
                    autor_excluidos: table.getDeletedRows(1)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao8e/add/'); if ($operacao == 'update') echo site_url('producao8e/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao8e/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>
<form>
  	<fieldset>
	    <legend>Caracterização da Produção Bibliográfica/Artística/Tecnológica do PRONERA<br /><br />
       			Livro / Coletânea </legend>

        <div class="form-group controles">
            <?php
                if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

	    <div class="form-group">
	      	<label>1. Tipo</label>

	      	<div class="radio form-group">
				<div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_01" value="INDIVIDUAL"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'INDIVIDUAL') echo "checked"; ?> > Individual </label> </div>

				<div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_02" value="COLETÂNEA"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'COLETÂNEA') echo "checked"; ?> > Coletânea </label> </div>

				<div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_03" value="CAPÍTULO DE LIVRO"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'CAPÍTULO DE LIVRO') echo "checked"; ?> > Capítulo de Livro </label> </div>

                <p class="text-danger"><label for="rtipo"><label></p>
	     	</div>
	    </div>

        <div class="table-box table-box-small">
    	    <div class="form-group">
    	      	<label>2. Autor(a)(es)(as) /  Organizador(a)(es)(as)</label>

    	      	<div class="radio form-group">
    				<div class="radio radio-inline" style="margin-top:0;"> <label> <input type="radio" name="raut_org" id="raut_org_01" value="AUTOR(A)"> Autor(a) </label> </div>
    				<div class="radio radio-inline"> <label> <input type="radio" name="raut_org" id="raut_org_02" value="ORGANIZADOR(A)"> Organizador(a) </label> </div>

                    <p class="text-danger"><label for="raut_org"><label></p>
    	     	</div>
            </div>
 		    <div class="form-group">
                <ul id="author_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control tamanho negacao" id="autor" name="autor"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row"> Remover Selecionado </button></li>
                    <li><label class="control-label form" for="autor"></label></li>
                </ul>
			</div>
    	    <div class="table-size">
    	    	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="author_table">
    		        <thead>
    		            <tr>
                            <th style="width:  10px;"> FLAG </th>
                            <th style="width:  10px;"> ID </th>
                            <th style="width: 260px;"> NOME </th>
                            <th style="width: 140px;"> TIPO </th>
    		            </tr>
    		        </thead>

    		        <tbody>
    		        </tbody>
    		    </table>
    	    </div>
        </div>

	    <div class="form-group">
	      	<label>3. Titulo</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="titulo" name="titulo"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo; ?>">
                <label class="control-label form" for="titulo"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>4. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local" name="local"
                    value="<?php if($operacao != 'add') echo $dados[0]->local_producao; ?>">
                <label class="control-label form" for="local"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>5. Editora</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="editora" name="editora"
                    value="<?php if($operacao != 'add') echo $dados[0]->editora; ?>">
                <label class="control-label form" for="editora"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>6. Ano</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="ano" name="ano"
                    value="<?php if($operacao != 'add') echo $dados[0]->ano; ?>">
                <label class="control-label form" for="ano"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>7. Formato</label>

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
                            if ($operacao != 'add' && $dados[0]->formato == 'ON-LINE') {
                                echo 'value="'.$dados[0]->pagina_web.'"';

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
	      	<label>8. Onde está disponível</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="disponibilidade" name="disponibilidade"
                    value="<?php if($operacao != 'add') echo $dados[0]->disponibilidade ?>">
                <label class="control-label form bold" for="disponibilidade"></label>
            </div>
		</div>

  	</fieldset>
</form