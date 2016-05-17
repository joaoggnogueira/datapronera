<?php
    $this->session->set_userdata('curr_content', 'producao8b');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function() {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_autor_producao_trabalho').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#author_table'),
            controls : $('#author_controls')
        });

        table.hideColumns([0,1]);


        /* Máscara para inputs */
        $('#ano_defesa').mask("9999");

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
                    'id'      : 'programa',
                    'message' : 'Informe o programa / curso da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'instituicao',
                    'message' : 'Informe o nome da instituição',
                    'extra'   : null
                },

                {
                    'id'      : 'local_defesa',
                    'message' : 'Informe o local de defesa / apresentação da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'local_estagio',
                    'message' : 'Informe o local do estágio',
                    'extra'   : null
                },

                {
                    'id'      : 'ano_defesa',
                    'message' : 'Informe o ano de defesa / apresentação da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'orientador',
                    'message' : 'Informe o nome do orientador',
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
                    rtipo : $("input:radio[name=rtipo]:checked").val(),
    				titulo : $('#titulo').val().toUpperCase(),
    				programa : $('#programa').val().toUpperCase(),
    				instituicao : $('#instituicao').val().toUpperCase(),
    				local_defesa : $('#local_defesa').val().toUpperCase(),
    				local_estagio : $('#local_estagio').val().toUpperCase(),
    				ano_defesa : $('#ano_defesa').val().toUpperCase(),
    				orientador : $('#orientador').val().toUpperCase(),
    				rformato : $("input:radio[name=rformato]:checked").val(),
    				pagina_web : $('#pagina_web').val().toUpperCase(),
    				disponivel : $('#disponivel').val().toUpperCase(),
                    autores : table.getAll(),
                    autor_excluidos: table.getDeletedRows(1)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao8b/add/'); if ($operacao == 'update') echo site_url('producao8b/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao8b/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>
<form>
  	<fieldset>
	    <legend>Caracterização da Produção Bibliográfica/Artística/Tecnológica do PRONERA<br><br>
       			TRABALHO dos educandos(as) elaborado durante o curso</legend>

        <div class="form-group controles">
            <?php
                if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

	    <div class="form-group">
	      	<label>1. Tipo de Trabalho</label>

	      	<div class="radio form-group">
				<div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_01" value="MONOGRAFIA / TCC"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'MONOGRAFIA / TCC') echo "checked"; ?> > Monografia / TCC </label> </div>

				<div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_02" value="RELATÓRIO DE ESTÁGIO"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'RELATÓRIO DE ESTÁGIO') echo "checked"; ?> > Relatório de Estágio </label> </div>

				<div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_03" value="DISSERTAÇÃO"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'DISSERTAÇÃO') echo "checked"; ?> > Dissertação </label> </div>

				<div class="radio"> <label> <input type="radio" name="rtipo" id="rtipo_04" value="TESE"
					<?php if($operacao != 'add' && $dados[0]->tipo == 'TESE') echo "checked"; ?> > Tese </label> </div>

                <p class="text-danger"><label for="rtipo"><label></p>
		    </div>
		</div>

        <div class="table-box table-box-small">
    	    <div class="form-group">
    	      	<label>2. Autor(a)(es)(as)</label>

    	      	<ul id="author_controls" class="nav nav-pills buttons">
    		      	<li><input type="text" class="form-control negacao" id="autor" name="autor" placeHolder="Nome"></li>
    				<li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
    				<li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar"> Remover Selecionado </button></li>
                    <li><label class="control-label form bold" for="autor"></label></li>
    			</ul>
    	    </div>

    	    <div class="table-size">
    	    	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="author_table">
    		        <thead>
    		            <tr>
                            <th style="width:  10px"> FLAG </th>
                            <th style="width:  10px"> ID </th>
    		                <th style="width: 200px"> NOME </th>
    		            </tr>
    		        </thead>

    		        <tbody>
    		        </tbody>
    		    </table>
    	    </div>
        </div>

	    <div class="form-group">
	      	<label>3. Título(a)</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="titulo" name="titulo"
                    value="<?php if($operacao != 'add') echo $dados[0]->titulo; ?>">
                <label class="control-label form bold" for="titulo"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>4. Programa / Curso</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="programa" name="programa"
                    value="<?php if($operacao != 'add') echo $dados[0]->programa_curso; ?>">
                <label class="control-label form bold" for="programa"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>5. Instituição</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="instituicao" name="instituicao"
                    value="<?php if($operacao != 'add') echo $dados[0]->instituicao; ?>">
                <label class="control-label form bold" for="instituicao"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>6. Local de Defesa / Apresentação</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="local_defesa" name="local_defesa"
                    value="<?php if($operacao != 'add') echo $dados[0]->local_defesa; ?>">
                <label class="control-label form bold" for="instituicao"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>7. Local de desenvolvimento do estágio</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="local_estagio" name="local_estagio"
                    value="<?php if($operacao != 'add') echo $dados[0]->local_estagio; ?>">
                <label class="control-label form bold" for="local_estagio"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>8. Ano de defesa ou apresentação</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="ano_defesa" name="ano_defesa"
                    value="<?php if($operacao != 'add') echo $dados[0]->ano_defesa; ?>">
                <label class="control-label form bold" for="ano_defesa"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>9. Orientador(a)</label>
            <div>
                <input type="text" class="form-control tamanho-n" id="orientador" name="orientador"
                    value="<?php if($operacao != 'add') echo $dados[0]->orientador; ?>">
                <label class="control-label form bold" for="orientador"></label>
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
	      	<label>11. Onde está disponível</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="disponivel" name="disponivel"
                    value="<?php if($operacao != 'add') echo $dados[0]->disponibilidade; ?>">
                <label class="control-label form bold" for="disponivel"></label>
            </div>
		</div>

  	</fieldset>
</form