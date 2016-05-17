<?php
    $this->session->set_userdata('curr_content', 'producao8a');
?>

<script type="text/javascript">

    //var oTable;

    $(document).ready(function () {

        var id = "<?php echo $producao['id']; ?>";
        var url = "<?php echo site_url('request/get_autor_producao_geral').'/'; ?>" + id;

        var table = new Table({
            url      : url,
            table    : $('#author_table'),
            controls : $('#author_controls')
        });

        table.hideColumns([0,1]);

        /* Opções complementares */
        $('input:radio[name=rproduzido_natureza]').optionCheck({
            'id' : ['txt_tipo_natureza']

        }, "OUTROS");

        /* Máscara para inputs */
        $('#producao_ano').mask("9999");

        $('#botao_add').click(function () {

            var form = Array(
                {
                    'name'    : 'rproduzido_tipo',
                    'message' : 'Informe o tipo do elaborador da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'producao_aut_nome',
                    'message' : "Informe o nome do(a) autor(a) / produtor(a) / <br />" +
                                    "organizador(a)",
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var nome = $('#producao_aut_nome').val().toUpperCase();
                var tipo = $('input:radio[name=rproduzido_tipo]:checked').val();

                var node = ['N', 0, nome, tipo];

                if (! table.nodeExists(node)) {

                    //$('#autor_table').dataTable().fnAddData(node);
                    table.addData(node);

                    $('#producao_aut_nome').val('');
                    $('input:radio[name=rproduzido_tipo]').prop('checked', false);

                } else {
                    var error = tipo.charAt(0).toUpperCase() + tipo.slice(1).toLowerCase();

                    $('#producao_aut_nome').showErrorMessage(error +' já cadastrado(a)');
                }
            }
        });

        $('#salvar').click(function () {

             var form = Array(
                {
                    'name'    : 'rproduzido_natureza',
                    'message' : 'Informe a natureza da produção',
                    'next'    : false,
                    'extra'   : null
                },

                {
                    'id'      : 'txt_tipo_natureza',
                    'ni'      : !$('#rproduzido_natureza_06').prop('checked'),
                    'message' : 'Especifique a natureza da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'producao_titulo',
                    'message' : 'Informe o titulo da produção',
                    'extra'   : null
                },

                {
                    'name'    : 'rproduzido_autor',
                    'message' : 'Informe sobre o(s) autor(es) / produtor(es)',
                    'extra'   : null
                },

                {
                    'id'      : 'producao_local',
                    'message' : 'Informe o local da produção',
                    'extra'   : null
                },

                {
                    'id'      : 'producao_ano',
                    'message' : 'Informe o ano da produção',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {

                var formData = {
                    id_producao : id,
                    rproduzido_natureza : $("input:radio[name=rproduzido_natureza]:checked").val(),
                    txt_tipo_natureza : $('#txt_tipo_natureza').val().toUpperCase(),
                    producao_titulo : $('#producao_titulo').val().toUpperCase(),
    				rproduzido_autor : $("input:radio[name=rproduzido_autor]:checked").val(),
    				producao_local : $('#producao_local').val(),
    				producao_ano : $('#producao_ano').val(),
                    autores : table.getAll(),
                    autor_excluidos: table.getDeletedRows(1)
                };

                urlRequest = "<?php if ($operacao == 'add') echo site_url('producao8a/add/'); if ($operacao == 'update') echo site_url('producao8a/update/'); ?>";

                request(urlRequest, formData);
            }
        });

        $('#reset').click(function () {

            urlRequest = "<?php echo site_url('producao8a/index/'); ?>";

            request(urlRequest, null, 'hide');
        });

    });

</script>

<form>
  	<fieldset>
	    <legend>Caracterização da Produção Bibliográfica/Artística/Tecnológica do PRONERA<br/><br/>
   			          Vídeo / Cartilha - Apostila / Texto / Música / Caderno / Outros</legend>

        <div class="form-group controles">
            <?php
                if ($this->session->userdata('status_curso') != '2P' && $this->session->userdata('status_curso') != 'CC' && $operacao != 'view') {
                    echo "<input type=\"button\" id=\"salvar\" class=\"btn btn-success\" value=\"Salvar\"> <hr/>";
                }
            ?>
            <input type="button" id="reset" class="btn btn-default" value="Voltar">
        </div>

	    <div class="form-group">
	      	<label>1. Natureza da Produção</label>

	      	<div class="radio form-group">
				<div class="radio"> <label> <input type="radio" name="rproduzido_natureza" id="rproduzido_natureza_01" value="VIDEO"
				<?php if($operacao != 'add' && $dados[0]->natureza_producao == 'VIDEO') echo "checked"; ?> >

				Vídeo </label> </div>

				<div class="radio"> <label> <input type="radio" name="rproduzido_natureza" id="rproduzido_natureza_02" value="CARTILHA / APOSTILA"
				<?php if($operacao != 'add' && $dados[0]->natureza_producao == 'CARTILHA / APOSTILA') echo "checked"; ?> >

				Cartilha / Apostila </label> </div>

				<div class="radio"> <label> <input type="radio" name="rproduzido_natureza" id="rproduzido_natureza_03" value="TEXTO"
				<?php if($operacao != 'add' && $dados[0]->natureza_producao == 'TEXTO') echo "checked"; ?> >

				Texto </label> </div>

				<div class="radio"> <label> <input type="radio" name="rproduzido_natureza" id="rproduzido_natureza_04" value="MUSICA"
				<?php if($operacao != 'add' && $dados[0]->natureza_producao == 'MUSICA') echo "checked"; ?> >

				Música </label> </div>

				<div class="radio"> <label> <input type="radio" name="rproduzido_natureza" id="rproduzido_natureza_05" value="CADERNO"
				<?php if($operacao != 'add' && $dados[0]->natureza_producao == 'CADERNO') echo "checked"; ?> >

				Caderno </label> </div>

				<div class="radio"> <label> <input type="radio" name="rproduzido_natureza" id="rproduzido_natureza_06" value="OUTROS"
				    <?php
                        if ($operacao != 'add' && $dados[0]->natureza_producao != 'VIDEO' && $dados[0]->natureza_producao != 'CARTILHA / APOSTILA'
    	     			       && $dados[0]->natureza_producao != 'TEXTO' && $dados[0]->natureza_producao != 'MUSICA'
    	     			       && $dados[0]->natureza_producao != 'CADERNO'
                            )
                        {
                            echo "checked";
                        }

                    ?>
                >

				Outros </label> </div>

                <div>
                    <input type="text" class="form-control tamanho-lg" id="txt_tipo_natureza" name="txt_tipo_natureza" placeHolder="Especifique"
                        <?php
                            if($operacao != 'add' && $dados[0]->natureza_producao != 'VIDEO' &&
                                $dados[0]->natureza_producao != 'CARTILHA / APOSTILA' && $dados[0]->natureza_producao != 'TEXTO' &&
                                $dados[0]->natureza_producao != 'MUSICA' && $dados[0]->natureza_producao != 'CADERNO')
                            {
                                echo 'value="'.$dados[0]->natureza_producao.'"';

                            } else {
                                echo "style=\"display:none\";";
                            }
                        ?>
                    >

                    <p class="text-danger"><label for="rproduzido_natureza"><label></p>
                    <label class="control-label form bold" for="txt_tipo_natureza"></label>
                </div>
	       </div>
        </div>

	    <div class="form-group">
	      	<label>2. Titulo</label>

            <div>
                <textarea type="text" class="form-control tamanho-lg" id="producao_titulo" name="producao_titulo"><?php if ($operacao != 'add') echo $dados[0]->titulo; ?></textarea>
                <label class="control-label form bold" for="producao_titulo"></label>
            </div>
		</div>

	    <div class="form-group">
	      	<label>3. O(s) autor(a)(es)(as) / produtor(a)(es)(as) é(são)</label>

	      	<div class="radio form-group">
				<div class="radio"> <label> <input type="radio" name="rproduzido_autor" id="rproduzido_autor_01" value="EDUCANDO(A)" <?php if($operacao != 'add' && $dados[0]->autor_classificacao == 'EDUCANDO(A)') echo "checked"; ?> > Educando(a)(os)(as) </label> </div>
				<div class="radio"> <label> <input type="radio" name="rproduzido_autor" id="rproduzido_autor_02" value="EDUCADOR(A)" <?php if($operacao != 'add' && $dados[0]->autor_classificacao == 'EDUCADOR(A)') echo "checked"; ?> > Educador(a)(es)(as) </label> </div>
				<div class="radio"> <label> <input type="radio" name="rproduzido_autor" id="rproduzido_autor_03" value="BOLSISTA" <?php if($operacao != 'add' && $dados[0]->autor_classificacao == 'BOLSISTA') echo "checked"; ?> > Bolsista(s) voluntário(s) </label> </div>
				<div class="radio"> <label> <input type="radio" name="rproduzido_autor" id="rproduzido_autor_04" value="COORDENADOR(A)" <?php if($operacao != 'add' && $dados[0]->autor_classificacao == 'COORDENADOR(A)') echo "checked"; ?> > Coordenador(a)(es)(as) </label> </div>

                <p class="text-danger"><label for="rproduzido_autor"><label></p>
	     	</div>
	    </div>

	    <div class="table-box table-box-small">
            <div class="form-group">
    	      	<label>4. Produtor(a)(es)(as) / Autor(a)(es)(as) / Organizador(a)(es)(as)</label>

    	      	<div class="radio form-group">
    				<div class="radio radio-inline" style="margin-top:0;"> <label> <input type="radio" name="rproduzido_tipo" id="rproduzido_tipo_01" value="PRODUTOR(A)"> Produtor(a) </label> </div>
    				<div class="radio radio-inline"> <label> <input type="radio" name="rproduzido_tipo" id="rproduzido_tipo_02" value="AUTOR(A)"> Autor(a) </label> </div>
    				<div class="radio radio-inline"> <label> <input type="radio" name="rproduzido_tipo" id="rproduzido_tipo_03" value="ORGANIZADOR(A)"> Organizador(a) </label> </div>

                    <p class="text-danger"><label for="rproduzido_tipo"><label></p>
                </div>
            </div>
            <div class="form-group">
                <ul id="author_controls" class="nav nav-pills buttons">
                    <li><input type="text" class="form-control negacao" id="producao_aut_nome" name="producao_aut_nome" placeHolder="Nome"></li>
                    <li class="buttons"><button type="button" class="btn btn-default" id="botao_add" name="botao_add"> Adicionar </button></li>
                    <li class="buttons"><button type="button" class="btn btn-default btn-disabled disabled delete-row"> Remover Selecionado </button></li>
                    <li><label class="control-label form" for="producao_aut_nome"></label></li>
                </ul>
            </div>

            <div class="table-size">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="author_table">
                    <thead>
                        <tr>
                            <th style="width:  10px"> FLAG </th>
                            <th style="width:  10px"> ID </th>
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
		    <label>5. Local</label>
            <div>
                <input type="text" class="form-control tamanho-lg" id="producao_local" name="producao_local"
                    value="<?php if($operacao != 'add') echo $dados[0]->local_producao?>">
                <label class="control-label form bold" for="producao_local"></label>
            </div>
	    </div>

       	<div class="form-group">
		    <label>6. Ano</label>
            <div>
                <input type="text" class="form-control tamanho-smaller" id="producao_ano" name="producao_ano"
                    value="<?php if($operacao != 'add') echo $dados[0]->ano?>" >
                <label class="control-label form bold" for="producao_ano"></label>
            </div>
	    </div>

  	</fieldset>
</form>