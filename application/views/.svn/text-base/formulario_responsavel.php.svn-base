<?php 
    if (empty($data)) {
        echo "<script> request('".site_url('responsavel/index/')."', null, 'hide'); </script>";
        exit();
    }
?>

<script type="text/javascript">

	$(document).ready(function() {

        /*var table = new Table({
            url      : "<?php echo site_url('request/get_asseguradores'); ?>",
            table    : $('#assurers_table'),
            controls : $('#assurers_controls')
        });

        table.hideColumns([0]);*/

        //$('#asseguradores_table').tableInit(url);
        //$('#asseguradores_table').hideColumns([0]);

        /* Opções complementares */
		$('#cResp_fonte_09').optionCheck({
			'id' : ['Resp_outras']
		});

        /*$('#button_add').click(function () {
        	var form = Array(
                {
                    'id'      : 'asseguradores_sel',
                    'message' : 'Selecione o nome do(a) assegurador(a)',
                    'extra'   : null
                }
            );

            if (isFormComplete(form)) {
                cpf = $('#asseguradores_sel').val();
                nome = $('#asseguradores_sel option:selected').text();

                var node = [cpf, nome];

                if (! table.nodeExists(node)) {

                    //$('#asseguradores_table').dataTable().fnAddData(node);
                    table.addData(node);
                    $('#asseguradores_sel').val(0);

                } else {
                    $('#asseguradores_sel').showErrorMessage('Assegurador(a) já cadastrado');
                }
            }
        });*/

        $('#salvar').click(function () {

        	var form = Array(
	        	{
        			'name'    : 'cResp_fonte',
        			'message' : 'Informe a(s) fonte(s) das informações',
        			'next'    : false,
        			'extra'   : null
        		},

        		{
        			'id'      : 'Resp_outras',
        			'ni'	  : !$('#cResp_fonte_09').prop('checked'),
        			'message' : 'Especifique a fonte das informações',
        			'extra'   : null
        		}
        	);

        	if (isFormComplete(form)) {

        		var formData = {
        			superintendencia_incra : ($('#cResp_fonte_01').prop('checked') ? 1 : 0),
        			univ_facul : ($('#cResp_fonte_02').prop('checked') ? 1 : 0),
        			mov_social_sindical : ($('#cResp_fonte_03').prop('checked') ? 1 : 0),
        			secretaria_mun_educacao : ($('#cResp_fonte_04').prop('checked') ? 1 : 0),
        			secretaria_est_educacao : ($('#cResp_fonte_05').prop('checked') ? 1 : 0),
        			inst_federal : ($('#cResp_fonte_06').prop('checked') ? 1 : 0),
        			escola_tec : ($('#cResp_fonte_07').prop('checked') ? 1 : 0),
        			redes_ceffas : ($('#cResp_fonte_08').prop('checked') ? 1 : 0),
        			outras : ($('#cResp_fonte_09').prop('checked') ? 1 : 0),
        			complemento : ($('#cResp_fonte_01').prop('checked') ? $('#Resp_outras').val().toUpperCase() : ""),
        			//asseguradores : table.getAllByIndex(0)
        		}

        		var urlRequest = "<?php echo site_url('responsavel/update'); ?>";

	         	request(urlRequest, formData);
        	}
        });

		$('#reset').click(function () {

			var urlRequest = "<?php echo site_url('responsavel/index'); ?>";

         	request(urlRequest, null, 'hide');
		});
	});
</script>

<form>
  <fieldset>
    <legend>Informa&ccedil;&otilde;es da Pesquisa</legend>

    <div class="form-group controles">

        <?php

            // II PNERA
            if ($this->session->userdata('status_curso') != '2P' &&
                        $this->session->userdata('status_curso') != 'CC') {
                echo '<input type="button" id="salvar" class="btn btn-success" value="Salvar">
                      <hr/>';
            }
            
        ?>

        <input type="button" id="reset" class="btn btn-default" value="Cancelar">
    </div>

    <!--<div class="form-group">
      <label for="resp_nome_supervisor">1. Nome do(a) Pesquisador(a) Estadual</label>
      <input type="text" class="form-control tamanho-lg" id="resp_nome_supervisor" name="resp_nome_supervisor" readonly
      	value="<?php //echo $data->pesquisador; ?>">
    </div>

    <div class="form-group">
      <label for="resp_nome_pesquisador">2. Nome do(a) Auxiliar de Pesquisa</label>
      <input type="text" class="form-control" id="resp_nome_pesquisador" name="resp_nome_pesquisador" readonly
      	value="<?php //echo $data->auxiliar; ?>">
    </div>

    <div class="form-group">
    	<div class="negacao">
		    <label for="resp_super_nome">3. Superintend&ecirc;ncia</label>
		    <input type="text" class="form-control" id="resp_super_nome" name="resp_super_nome" readonly
		      	value="<?php //echo $data->superintendencia; ?>">
		</div>
		<div class="negacao">
			<label for="resp_super_nome" style="padding-left:8px;">UF</label>
      		<input type="text" class="form-control tamanho-smaller" id="resp_super_uf" name="resp_super_uf" readonly
      			value="<?php //echo $data->uf; ?>">
		</div>
    </div>
    <div class="form-group"></div> <!-- CORRIGIR ESPAÇAMENTO DO FLOAT LEFT ACIMA --
    <br />-->

	<!--<div class="table-box table-box-small">
        <div class="form-group">
          	<label>1. Nome do(a)(s) Assegurador(a)(es)(as)</label>
            <ul id="assurers_controls" class="nav nav-pills buttons">        
                <li>
                    <select class="form-control negacao" id="asseguradores_sel" name="asseguradores_sel">
                        <option value="0" disabled selected> Selecione </option>
                        <?php
                            //foreach ($insurers as $insurer) {
                            //   echo "<option value=".$insurer->id.">". $insurer->nome . "</option>";
                            //}
                        ?>
                    </select>
                    <p class="text-danger select"><label for="asseguradores_sel"><label></p>
                </li>
                <li class="buttons">
                    <button type="button" class="btn btn-default" id="button_add" name="button_add">Adicionar</button>
                </li>
                <li class="buttons">
                    <button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar">Remover Selecionado</button>
                </li>
            </ul>
    		<div class="form-group"></div> <!-- CORRIGIR ESPAÇAMENTO DO FLOAT LEFT ACIMA --

    		<div class="table-size">
    	    	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="assurers_table">
    		        <thead>
    		            <tr>
    		                <th style="width:   0px;"> CPF </th>
    		                <th style="width: 600px;"> ASSEGURADORES </th>
    		            </tr>
    		        </thead>

    		        <tbody>
    		        </tbody>
    		    </table>
    	    </div>
        </div>
    </div>-->

    <div class="form-group">
      <label>1. Fonte(s) das informa&ccedil;&otilde;es</label>
	    
	    <div class="checkbox"> 
	      	<div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_01"
	      		<?php if ($informer->superintendencia_incra == 1) { echo "checked"; } ?>
	      	> Superintendencia do INCRA </label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_02"
		    	<?php if ($informer->universidade_faculdade == 1) { echo "checked"; } ?>
		    > Institui&ccedil;&atilde;o de Ensino</label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_03"
		    	<?php if ($informer->movimento_social_sindical == 1) { echo "checked"; } ?>
		    > Movimento Social/Sindical </label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_04"
		    	<?php if ($informer->secretaria_municipal_educacao == 1) { echo "checked"; } ?>
		    > Secretaria Municipal de Educa&ccedil;&atilde;o </label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_05"
		    	<?php if ($informer->secretaria_estadual_educacao == 1) { echo "checked"; } ?>
		    > Secretaria Estadual de Educa&ccedil;&atilde;o </label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_06"
		    	<?php if ($informer->instituto_federal == 1) { echo "checked"; } ?>
	    	> Institutos Federais </label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_07"
		    	<?php if ($informer->escola_tecnica == 1) { echo "checked"; } ?>
		    > Escolas T&eacute;cnicas </label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_08"
		    	<?php if ($informer->redes_ceffas == 1) { echo "checked"; } ?>
		    > Redes CEFAS </label> </div>
		    <div class="checkbox"> <label> <input type="checkbox" name="cResp_fonte" id="cResp_fonte_09"
		    	<?php if ($informer->outras == 1) { echo "checked"; } ?>
		    > Outras </label> </div>
		    	<div>
		    		<input type="text" class="form-control tamanho-lg" id="Resp_outras" name="Resp_outras" placeHolder="Especifique"
						<?php 
							if ($informer->outras == 1) { 
								echo 'value="'.$informer->complemento.'"'; 

							} else {
								echo "style=\"display:none\";";
							}
						?>	
					/>
		    		<p class="text-danger"><label for="cResp_fonte"><label></p>
					<label class="control-label form bold" for="Resp_outras"></label>
		    	</div>
	    </div>
	</div>
    <!-- <button type="submit" class="btn btn-default">Submit</button> -->
  
  </fieldset>
</form>