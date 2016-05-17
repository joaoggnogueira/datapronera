<?php
    $this->session->set_userdata('curr_content', 'producao8c');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_autor_producao_artigo').'/'; ?>" + id;

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
                    'name'    : 'rartigo_tipo',
                    'message' : 'Informe o tipo da produção',
                    'next'    : false,
                    'extra'   : null
                },

                {
                    'id'      : 'tipo_nome',
                    'ni'      : !$('#rartigo_tipo_02').prop('checked'),
                    'message' : 'Informe o evento',
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
                    'id'      : 'disponivel',
                    'message' : 'Informe onde a produção está disponível',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    titulo : $('#titulo').val().toUpperCase(),
    				rartigo_tipo : $("input:radio[name=rartigo_tipo]:checked").val(),
    				tipo_nome: $('#tipo_nome').val().toUpperCase(),
    				local : $('#local').val().toUpperCase(),
    				ano : $('#ano').val().toUpperCase(),
    				rformato : $("input:radio[name=rformato]:checked").val(),
    				disponivel : $('#disponivel').val().toUpperCase(),
    				pagina_web : $('#pagina_web').val().toUpperCase(),
                    autores : table.getAll(),
                    autor_excluidos: table.getDeletedRows(1)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao8c/add/'); if ($operacao == 'update') echo site_url('producao8c/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao8c/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>
<form>
  	<fieldset>
	    <legend>Caracterização da Produção Bibliográfica/Artística/Tecnológica do PRONERA<br /><br />
        	 	Artigo elaborado pelo(a)(s) educandos(as) durante o curso</legend>

        <div class="form-group controles">
            <?php
                if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

        <div class="table-box table-box-small">
    	    <div class="form-group">
    	      	<label>1. Autor(a)(es)(as)</label>

    			<ul id="author_controls" class="nav nav-pills buttons">
    		      	<li><input type="text" class="form-control tamanho negacao" id="autor" name="autor"></li>
    				<li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
    				<li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row"> Remover Selecionado </button></li>
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
	      	<label>2. Título</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="titulo" name="titulo"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo ?>">
                <label class="control-label form bold" for="titulo"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>3. Tipo</label>
	      	<div class="radio form-group">

				<div class="radio"> <label> <input type="radio" name="rartigo_tipo" id="rartigo_tipo_01" value="PERIÓDICO"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'PERIÓDICO') echo "checked"; ?> > Periódico </label> </div>

				<div class="radio"> <label> <input type="radio" name="rartigo_tipo" id="rartigo_tipo_02" value="EVENTO"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'EVENTO') echo "checked"; ?> > Evento </label> </div>

                <div>
                   <input type="text" class="form-control tamanho-lg" id="tipo_nome" name="tipo_nome" placeHolder="Informe o periódico / evento" value="<?php if($operacao != 'add') echo $dados[0]->tipo_descricao; ?>">
                    <p class="text-danger"><label for="rartigo_tipo"><label></p>
                    <label class="control-label form bold" for="tipo_nome"></label>
                </div>
			</div>
	    </div>

	    <div class="form-group">
	      	<label>4. Local</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local" name="local"
                    value="<?php if($operacao != 'add') echo $dados[0]->local_producao ?>">
                <label class="control-label form bold" for="local"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>5. Ano</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="ano" name="ano"
                    value="<?php if($operacao != 'add') echo $dados[0]->ano ?>">
                <label class="control-label form bold" for="ano"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>6. Formato</label>

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
	      	<label>7. Onde está disponível</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="disponivel" name="disponivel"
                    value="<?php if($operacao != 'add') echo $dados[0]->disponibilidade ?>">
                <label class="control-label form bold" for="disponivel"></label>
            </div>
		</div>

  	</fieldset>
</form>