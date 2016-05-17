<?php
    if (empty($dados)) {
        echo "<script> request('".site_url('caracterizacao/index/')."', null, 'hide'); </script>";
        exit();
    }
?>

<script type="text/javascript">

	// recupera estados e municipios selecionando oque está no banco de dados
 	$.get("<?php echo site_url('requisicao/get_estados'); ?>", function(estados) {
		$('#carac_sel_est').html(estados);

		$('#carac_sel_mun').html('<option> Selecione o Estado </option>');
	});

    // Modalidades
    $.get("<?php echo site_url('requisicao/get_modalidades'); ?>", function (modalidade) {
        $('#modalidade').html(modalidade);

        var modalidade_curso = "<?php echo  $dados[0]->id_modalidade; ?>";

        if (modalidade_curso != 0) {
            $('#modalidade option[value="'+modalidade_curso+'"]').attr("selected", true);
        }
    });

	$(document).ready(function() {

        var table = new Table({
            url      : "<?php echo site_url('request/get_carac_mun'); ?>",
            table    : $('#cities_table'),
            controls : $('#cities_controls')
        });

        table.hideColumns([0,1,3]);
$data = "<?php echo site_url('requisicao/get_data'); ?>";
        var urlMunicipios = "<?php echo site_url('requisicao/get_municipios'); ?>";
        
        $('#carac_sel_est').listCities(urlMunicipios, 'carac_sel_mun');

        /* Máscaras para inputs */
        $('#previsto_inicio').mask("99/9999");
        $('#previsto_termino').mask("99/9999");
        $('#realizado_inicio').mask("99/9999");
        $('#realizado_termino').mask("99/9999");

        /* Não informados */
        $('#ckTitulo_coord_geral_ni').niCheck({
        	'name' : ['rtitulo_coord_geral']
        });

        $('#ckCoord_proj_nome').niCheck({
        	'id' : ['nome_coord']
        });

        $('#ckTitulo_coord_ni').niCheck({
        	'name' : ['rtitulo_coord'],
        	'id'   : ['ckTitulo_coord_na']
        });

		$('#ckTitulo_coord_na').niCheck({
        	'name' : ['rtitulo_coord'],
        	'id'   : ['ckTitulo_coord_ni']
        });

        $('#ckVice_naplica').niCheck({
        	'id' : ['vice_nome']
        });

        $('#ckVice_titulo_ni').niCheck({
        	'name' : ['rvice_titulo'],
        	'id'   : ['ckVice_titulo_naplica']
        });

		$('#ckVice_titulo_naplica').niCheck({
        	'name' : ['rvice_titulo'],
        	'id'   : ['ckVice_titulo_ni']
        });

        $('#ckCoord_ped_naplica').niCheck({
        	'id' : ['nome_coord_pedag']
        });

        $('#ckTit_coord_pedag_ni').niCheck({
        	'name' : ['rTit_coord_pedag'],
        	'id'   : ['ckTit_coord_pedag_naplica']
        });

        $('#ckTit_coord_pedag_naplica').niCheck({
        	'name' : ['rTit_coord_pedag'],
        	'id'   : ['ckTit_coord_pedag_ni']
        });

        $('#ckCurso_duracao').niCheck({
        	'id' : ['duracao']
        });

        $('#ckCurso_previsto_inicio').niCheck({
        	'id' : ['previsto_inicio']
        });

        $('#ckCurso_previsto_termino').niCheck({
        	'id' : ['previsto_termino']
        });

		$('#ckCurso_realizado_inicio').niCheck({
        	'id' : ['realizado_inicio']
        });

        $('#ckCurso_realizado_termino').niCheck({
        	'id' : ['realizado_termino', 'ckCurso_finalizado', 'finalizacao_descrever']
        });

		$('#ckCurso_finalizado').niCheck({
        	'id' : ['realizado_termino', 'ckCurso_realizado_termino']
        });

        $('#ckCurso_numero_turmas').niCheck({
        	'id' : ['numero_turmas']
        });

		$('#ckCurso_num_aluno_ingre').niCheck({
        	'id' : ['num_aluno_ingre']
        });

        $('#ckCurso_num_aluno_concl').niCheck({
        	'id' : ['num_aluno_concl']
        });

        $('#ckImpedimento_ni').niCheck({
        	'name' : ['rimpedimento'],
        	'id'   : ['impedimento_descrever']
        });

        $('#ckReferencia_ni').niCheck({
        	'name' : ['rreferencia']
        });

		$('#ckMatriz_ni').niCheck({
        	'name' : ['ralteracao']
        });

        $('#ckDesdobramento_ni').niCheck({
        	'name' : ['rdesdobramento'],
        	'id'   : ['desdobramento_text_outros']
        });

        $('#ckDocumentos_ni').niCheck({
        	'name' : ['rdoc'],
        	'id'   : ['doc_descrever']
        });

        $('#ckEspaco_ni').niCheck({
        	'name' : ['respaco'],
        	'id'   : ['espaco_descrever']
        });

        $('#ckAvaliacao_ni').niCheck({
        	'name' : ['ravaliacao'],
        	'id'   : ['avaliacao_descrever']
        });

        $('#ckCurso_num_bolsistas_ni').niCheck({
        	'id'   : ['num_bolsistas']
        });

        /* Opções complementares */
        $('#modalidade').change(function (e) {

            if (e.target.value == 'OUTRA') {
                $('#modalidade_descricao').show().focus();

            } else {
                $('#modalidade_descricao').hide();
                $('#modalidade_descricao').hideErrorMessage();
            }
        });

		$('#ckCurso_finalizado').optionCheck({
			'id' : ['finalizacao_descrever']
		});

		$('input[name=rimpedimento]').optionCheck({
			'id' : ['impedimento_descrever']

		}, "SIM");

		$('input[name=rdesdobramento]').optionCheck({
			'id' : ['desdobramento_text_outros']

		}, "OUTROS");

		$('input[name=rdoc]').optionCheck({
			'id' : ['doc_descrever']

		}, "SIM");

		$('input[name=respaco]').optionCheck({
			'id' : ['espaco_descrever']

		}, "SIM");

		$('input[name=ravaliacao]').optionCheck({
			'id' : ['avaliacao_descrever']

		}, "SIM");

        $('#carac_botao_mun').click(function () {

        	var form = Array(
        		{
        			'id'      : 'carac_sel_est',
        			'message' : 'Selecione o estado',
        			'extra'   : null
        		},

        		{
        			'id'      : 'carac_sel_mun',
        			'message' : 'Selecione o município',
        			'extra'   : null
        		}
        	);

        	if (isFormComplete(form)) {

        		cod_estado = $("#carac_sel_est").val();
	        	cod_municipio = $("#carac_sel_mun").val();
	        	estado = $('#carac_sel_est option:selected').text();
	        	municipio = $('#carac_sel_mun option:selected').text();

	        	var node = ['N', cod_municipio, municipio, cod_estado, estado ];

	        	if (! table.nodeExists(node)) {

	        		//$('#municipios_table').dataTable().fnAddData(node);
                    table.addData(node);

	        		$('#carac_sel_est').val(0);
                    $('#carac_sel_mun').val(0);

                } else {
                    $('#carac_sel_mun').showErrorMessage('Município já cadastrado');
                }
        	}
        });

        $('#salvar').click(function () {

        	var form = Array(
        		{
        			'id'      : 'area',
        			'message' : 'Informe a área de conhecimento do curso',
        			'extra'   : null
        		},

        		{
        			'id'      : 'nome_coord_geral',
        			'message' : 'Informe o nome do coordenador geral do curso',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rtitulo_coord_geral',
        			'ni'	  : $('#ckTitulo_coord_geral_ni').prop('checked'),
        			'message' : 'Informe a titulação do coordenador geral do curso',
        			'extra'   : null
        		},

        		{
        			'id'      : 'nome_coord',
        			'ni'	  : $('#ckCoord_proj_nome').prop('checked'),
        			'message' : 'Informe o nome do coordenador do curso',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rtitulo_coord',
        			'ni'	  : ($('#ckTitulo_coord_ni').prop('checked')
        							|| $('#ckTitulo_coord_na').prop('checked')),
        			'message' : 'Informe a titulação do coordenador do curso',
        			'extra'   : null
        		},

        		{
        			'id'      : 'vice_nome',
        			'ni'      : $('#ckVice_naplica').prop('checked'),
        			'message' : 'Informe o nome do vice-coordenador do curso',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rvice_titulo',
        			'ni'	  : ($('#ckVice_titulo_ni').prop('checked')
        							|| $('#ckVice_titulo_naplica').prop('checked')),
        			'message' : 'Informe a titulação do vice-coordenador do curso',
        			'extra'   : null
        		},

        		{
        			'id'      : 'nome_coord_pedag',
        			'ni'	  : $('#ckCoord_ped_naplica').prop('checked'),
        			'message' : 'Informe o nome do coordenador pedagógico do curso',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rTit_coord_pedag',
        			'ni'      : ($('#ckTit_coord_pedag_ni').prop('checked') ||
        							$('#ckTit_coord_pedag_naplica').prop('checked')),
        			'message' : 'Informe a titulação do coordenador pedagógico do curso',
        			'extra'   : null
        		},

        		{
                    'id'      : 'modalidade',
                    'message' : 'Informe a modalidade do curso',
                    'extra'   : null
                },

                {
                    'id'      : 'modalidade_descricao',
                    'ni'      : (($('#modalidade').val() == 'OUTRA') ? false : true),
                    'message' : 'Especifique a modalidade do curso',
                    'extra'   : null
                },

				{
        			'id'      : 'duracao',
        			'ni'      : $('#ckCurso_duracao').prop('checked'),
        			'message' : 'Informe a duração do curso',
        			'extra'   : null
        		},

				{
        			'id'      : 'previsto_inicio',
        			'ni'      : $('#ckCurso_previsto_inicio').prop('checked'),
        			'message' : 'Informe o início previsto para realização do curso',
        			'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
        		},

        		{
        			'id'      : 'previsto_termino',
        			'ni'      : $('#ckCurso_previsto_termino').prop('checked'),
        			'message' : 'Informe o término previsto para realização do curso',
        			'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
        		},

        		{
        			'id'      : 'realizado_inicio',
        			'ni'      : $('#ckCurso_realizado_inicio').prop('checked'),
        			'message' : 'Informe o período de início do curso',
        			'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
        		},

        		{
        			'id'      : 'realizado_termino',
        			'ni'      : ($('#ckCurso_realizado_termino').prop('checked') ||
        							$('#ckCurso_finalizado').prop('checked')),
        			'message' : 'Informe o período de término do curso',
        			'next'    : false,
        			'extra'   : {
                        'operation' : 'date',
                        'message'   : 'A data informada é inválida'
                    }
        		},

        		{
        			'id'      : 'finalizacao_descrever',
        			'ni'      : !$('#ckCurso_finalizado').prop('checked'),
        			'message' : 'Descreva o motivo do curso não ter sido concluído',
        			'extra'   : null
        		},

        		{
        			'id'      : 'numero_turmas',
        			'ni'      : $('#ckCurso_numero_turmas').prop('checked'),
        			'message' : 'Informe o número de turmas do curso',
        			'extra'   : null
        		},

				{
        			'id'      : 'num_aluno_ingre',
        			'ni'      : $('#ckCurso_num_aluno_ingre').prop('checked'),
        			'message' : 'Informe o número de alunos ingressantes do curso',
        			'extra'   : null
        		},

        		{
        			'id'      : 'num_aluno_concl',
        			'ni'      : $('#ckCurso_num_aluno_concl').prop('checked'),
        			'message' : 'Informe o número de alunos concluintes do curso',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rimpedimento',
        			'ni'      : $('#ckImpedimento_ni').prop('checked'),
        			'message' : 'Informe se houve algum impedimento na implementação do curso',
        			'next'    : false,
        			'extra'   : null
        		},

        		{
        			'id'      : 'impedimento_descrever',
        			'ni'      : !$('#rimpedimento_02').prop('checked'),
        			'message' : 'Descreva qual o impedimento na implementação do curso',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rreferencia',
        			'ni'      : $('#ckReferencia_ni').prop('checked'),
        			'message' : 'Informe se o projeto/curso teve como referência um curso regular',
        			'extra'   : null
        		},

        		{
        			'name'    : 'ralteracao',
        			'ni'      : $('#ckMatriz_ni').prop('checked'),
        			'message' : 'Informe se a matriz curricular foi alterada',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rdesdobramento',
        			'ni'      : $('#ckDesdobramento_ni').prop('checked'),
        			'message' : 'Informe se houve desdobramentos no curso',
        			'next'    : false,
        			'extra'   : null
        		},

        		{
        			'id'      : 'desdobramento_text_outros',
        			'ni'      : !$('#rdesdobramento_05').prop('checked'),
        			'message' : 'Descreva o desdobramento do curso',
        			'extra'   : null
        		},

        		{
        			'name'    : 'rdoc',
        			'ni'      : $('#ckDocumentos_ni').prop('checked'),
        			'message' : 'Informe se há documentos normativos',
        			'next'    : false,
        			'extra'   : null
        		},

        		{
        			'id'      : 'doc_descrever',
        			'ni'      : !$('#rdoc_02').prop('checked'),
        			'message' : 'Descreva sobre os documentos normativos',
        			'extra'   : null
        		},

        		{
        			'name'    : 'respaco',
        			'ni'      : $('#ckEspaco_ni').prop('checked'),
        			'message' : 'Informe se houve um espaço específico para o PRONERA',
        			'next'    : false,
        			'extra'   : null
        		},

        		{
        			'id'      : 'espaco_descrever',
        			'ni'      : !$('#respaco_02').prop('checked'),
        			'message' : 'Descreva sobre o espaço disponível',
        			'extra'   : null
        		},

        		{
        			'name'    : 'ravaliacao',
        			'ni'      : $('#ckAvaliacao_ni').prop('checked'),
        			'message' : 'Informe se houve avaliação do curso',
        			'next'    : false,
        			'extra'   : null
        		},

        		{
        			'id'      : 'avaliacao_descrever',
        			'ni'      : !$('#ravaliacao_02').prop('checked'),
        			'message' : 'Descreva quais foram as avaliações do curso',
        			'extra'   : null
        		},

        		{
        			'id'      : 'num_bolsistas',
        			'ni'      : $('#ckCurso_num_bolsistas_ni').prop('checked'),
        			'message' : 'Informe o número de bolsistas que se envolveram no curso',
        			'extra'   : null
        		}
        	);

			//var valor = getmunicipios(oTable);
			//$('#municipios_objeto').val(valor);

			if (isFormComplete(form)) {

	            var formData = {
	            	id : 						$('#caracterizacao_id').val().toUpperCase(),
					area : 						$('#area').val().toUpperCase(),
					nome_coord_geral : 			$('#nome_coord_geral').val().toUpperCase(),
					ckTitulo_coord_geral_ni : 	$('#ckTitulo_coord_geral_ni').prop('checked'),
					rtitulo_coord_geral : 		$("input:radio[name=rtitulo_coord_geral]:checked").val(),
					ckCoord_proj_nome : 		$('#ckCoord_proj_nome').prop('checked'),
					nome_coord : 				$('#nome_coord').val().toUpperCase(),
					ckTitulo_coord_ni : 		$('#ckTitulo_coord_ni').prop('checked'),
					ckTitulo_coord_na : 		$('#ckTitulo_coord_na').prop('checked'),
					rtitulo_coord : 			$("input:radio[name=rtitulo_coord]:checked").val(),
					ckVice_naplica : 			$('#ckVice_naplica').prop('checked'),
					vice_nome : 				$('#vice_nome').val().toUpperCase(),
					ckVice_titulo_ni : 			$('#ckVice_titulo_ni').prop('checked'),
					ckVice_titulo_naplica : 	$('#ckVice_titulo_naplica').prop('checked'),
					rvice_titulo : 				$("input:radio[name=rvice_titulo]:checked").val(),
					ckCoord_ped_naplica : 		$('#ckCoord_ped_naplica').prop('checked'),
					nome_coord_pedag : 			$('#nome_coord_pedag').val().toUpperCase(),
					ckTit_coord_pedag_ni : 		$('#ckTit_coord_pedag_ni').prop('checked'),
					ckTit_coord_pedag_naplica : $('#ckTit_coord_pedag_naplica').prop('checked'),
					rTit_coord_pedag : 			$("input:radio[name=rTit_coord_pedag]:checked").val(),
					//ckModalidade_ni : 			$('#ckModalidade_ni').prop('checked'),
					modalidade : 				$('#modalidade').val(),
					modalidade_descricao : 		$('#modalidade_descricao').val().toUpperCase(),
					ckCurso_duracao : 			$('#ckCurso_duracao').prop('checked'),
					duracao : 					$('#duracao').val(),
					ckCurso_previsto_inicio : 	$('#ckCurso_previsto_inicio').prop('checked'),
					previsto_inicio : 			$('#previsto_inicio').val().toUpperCase(),
					ckCurso_previsto_termino : 	$('#ckCurso_previsto_termino').prop('checked'),
					previsto_termino : 			$('#previsto_termino').val().toUpperCase(),
					ckCurso_realizado_inicio : 	$('#ckCurso_realizado_inicio').prop('checked'),
					realizado_inicio : 			$('#realizado_inicio').val().toUpperCase(),
					ckCurso_realizado_termino : $('#ckCurso_realizado_termino').prop('checked'),
					ckCurso_finalizado : 		$('#ckCurso_finalizado').prop('checked'),
					realizado_termino : 		$('#realizado_termino').val().toUpperCase(),
					finalizacao_descrever : 	$('#finalizacao_descrever').val().toUpperCase(),
					ckCurso_numero_turmas :  	$('#ckCurso_numero_turmas').prop('checked'),
					numero_turmas : 			$('#numero_turmas').val(),
					ckCurso_num_aluno_ingre : 	$('#ckCurso_num_aluno_ingre').prop('checked'),
					num_aluno_ingre : 			$('#num_aluno_ingre').val(),
					ckCurso_num_aluno_concl : 	$('#ckCurso_num_aluno_concl').prop('checked'),
					num_aluno_concl : 			$('#num_aluno_concl').val(),
					ckImpedimento_ni : 			$('#ckImpedimento_ni').prop('checked'),
					rimpedimento : 				$("input:radio[name=rimpedimento]:checked").val(),
					impedimento_descrever : 	$('#impedimento_descrever').val().toUpperCase(),
					ckReferencia_ni : 			$('#ckReferencia_ni').prop('checked'),
					rreferencia : 				$("input:radio[name=rreferencia]:checked").val(),
					ckMatriz_ni : 				$('#ckMatriz_ni').prop('checked'),
					ralteracao : 				$("input:radio[name=ralteracao]:checked").val(),
					ckDesdobramento_ni : 		$('#ckDesdobramento_ni').prop('checked'),
					rdesdobramento : 			$("input:radio[name=rdesdobramento]:checked").val(),
					desdobramento_text_outros : $('#desdobramento_text_outros').val().toUpperCase(),
					ckDocumentos_ni : 			$('#ckDocumentos_ni').prop('checked'),
					rdoc : 						$("input:radio[name=rdoc]:checked").val(),
					doc_descrever : 			$('#doc_descrever').val().toUpperCase(),
					ckEspaco_ni : 				$('#ckEspaco_ni').prop('checked'),
					respaco : 					$("input:radio[name=respaco]:checked").val(),
					espaco_descrever : 			$('#espaco_descrever').val().toUpperCase(),
					ckAvaliacao_ni : 			$('#ckAvaliacao_ni').prop('checked'),
					ravaliacao : 				$("input:radio[name=ravaliacao]:checked").val(),
					avaliacao_descrever : 		$('#avaliacao_descrever').val().toUpperCase(),
					ckCurso_num_bolsistas_ni :  $('#ckCurso_num_bolsistas_ni').prop('checked'),
					num_bolsistas : 			$('#num_bolsistas').val(),
	                municipios : 				table.getAll(),
                    mun_excluidos:              table.getDeletedRows(1)
	            };

	            var urlRequest = "<?php echo site_url('caracterizacao/update/'); ?>";

	            request(urlRequest, formData);
	        }
		});

		$('#reset').click(function () {

            var urlRequest = "<?php echo site_url('caracterizacao/index/'); ?>";

            request(urlRequest, null, 'hide');
		});

    });

</script>

<form>
	<fieldset>
        <legend>Caracteriza&ccedil;&atilde;o do Curso</legend>

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
        
                
        
		<div class="form-group">
			<label>1. Nome do curso</label>
			<textarea class="form-control tamanho-exlg" id="nome" name="nome" readonly><?php echo $dados[0]->nome; ?></textarea>
		</div>
                <div class="form-group">
                    <label>1.1 Data do Curso</label>
                    <p><?php 
                        if($dados[0]->data!=null)
                            echo $dados[0]->data; 
                        else
                            echo 'Não Possui'; ?></p>
                </div>
                <div class="form-group">
                    <label>1.2 Superintendência</label>
                    <p><?php echo $dados[0]->superintendencia; ?></p>
                </div>
		<div class="form-group">
	      	<label>2. &Aacute;rea de conhecimento</label>
	      	<div>
	      		<select class="form-control tamanho-sm" id="area" name="area">
				  	<option disabled value="" <?php if ($dados[0]->area_conhecimento == "") echo "selected"; ?> >Selecione</option>
		    		<option value="CIENCIAS AGRARIAS" <?php if ($dados[0]->area_conhecimento == "CIENCIAS AGRARIAS") echo "selected"; ?> >
		    			Ciências Agrárias </option>
		    		<option value="CIENCIAS EXATAS E DA TERRA" <?php if ($dados[0]->area_conhecimento == "CIENCIAS EXATAS E DA TERRA") echo "selected"; ?> >
		    			Ci&ecirc;ncias Exatas e da Terra </option>
		    		<option value="CIENCIAS BIOLOGICAS" <?php if ($dados[0]->area_conhecimento == "CIENCIAS BIOLOGICAS") echo "selected"; ?> >
		    			Ci&ecirc;ncias Biol&oacute;gicas </option>
		    		<option value="ENGENHARIAS" <?php if ($dados[0]->area_conhecimento == "ENGENHARIAS") echo "selected"; ?> >
		    			Engenharias </option>
		    		<option value="CIENCIAS DA SAUDE" <?php if ($dados[0]->area_conhecimento == "CIENCIAS DA SAUDE") echo "selected"; ?> >
		    			Ci&ecirc;ncias da Sa&uacute;de </option>
		    		<option value="CIENCIAS SOCIAIS APLICADAS" <?php if ($dados[0]->area_conhecimento == "CIENCIAS SOCIAIS APLICADAS") echo "selected"; ?> >
		    			Ci&ecirc;ncias Sociais Aplicadas </option>
		    		<option value="CIENCIAS HUMANAS" <?php if ($dados[0]->area_conhecimento == "CIENCIAS HUMANAS") echo "selected"; ?> >
		    			Ci&ecirc;ncias Humanas </option>
		    		<option value="LINGUISTICAS, LETRAS E ARTES" <?php if ($dados[0]->area_conhecimento == "LINGUISTICAS, LETRAS E ARTES") echo "selected"; ?> >
		    			Lingu&iacute;sticas, Letras e Artes </option>
				</select>
	      		<p class="text-danger select"><label for="area"><label></p>
	      	</div>
	    </div>

		<div class="form-group">
			<label>3. Nome do(a) coordenador(a) geral do curso</label>
			<div>
				<input type="text" class="form-control tamanho-lg" id="nome_coord_geral" name="nome_coord_geral"
					value="<?php echo $dados[0]->nome_coordenador_geral; ?>">
				<label class="control-label form" for="nome_coord_geral"></label>
			</div>
		</div>

	    <div class="form-group">
	      	<label class="negacao">4. Titula&ccedil;&atilde;o do(a) coordenador(a) geral do curso quando o curso foi desenvolvido</label>

			<div class="checkbox negacao-smaller">
				<label> <input type="checkbox" name="ckTitulo_coord_geral_ni" id="ckTitulo_coord_geral_ni" value="NAOINFORMADO" <?php if ($dados[0]->titulacao_coordenador_geral == "NAOINFORMADO") echo "checked"; ?> > N&atilde;o encontrado </label>
			</div>

		    <div class="radio form-group">
		      	<div class="radio">
		      		<label> <input type="radio" name="rtitulo_coord_geral" id="rtitulo_coord_geral_01" value="GRADUADO(A)" <?php if ($dados[0]->titulacao_coordenador_geral == "GRADUADO(A)") echo "checked"; ?>> GRADUADO(A) </label>
		      	</div>
		      	<div class="radio">
		      		<label> <input type="radio" name="rtitulo_coord_geral" id="rtitulo_coord_geral_02" value="ESPECIALISTA" <?php if ($dados[0]->titulacao_coordenador_geral == "ESPECIALISTA") echo "checked"; ?>> ESPECIALISTA </label>
		      	</div>
		      	<div class="radio">
		      		<label> <input type="radio" name="rtitulo_coord_geral" id="rtitulo_coord_geral_03" value="MESTRE(A)" <?php if ($dados[0]->titulacao_coordenador_geral == "MESTRE(A)") echo "checked"; ?>> MESTRE(A) </label>
		      	</div>
		      	<div class="radio">
		      		<label> <input type="radio" name="rtitulo_coord_geral" id="rtitulo_coord_geral_04" value="DOUTOR(A)" <?php if ($dados[0]->titulacao_coordenador_geral == "DOUTOR(A)") echo "checked"; ?>> DOUTOR(A) </label>
		      	</div>
		      	<p class="text-danger"><label for="rtitulo_coord_geral"><label></p>
		    </div>
		</div>

		<div class="form-group">
			<label class="negacao">5. Nome do coordenador(a) do projeto/curso</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckCoord_proj_nome" id="ckCoord_proj_nome" value="NAOAPLICA" <?php if ($dados[0]->nome_coordenador == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
		    </div>

			<div class="form-group">
				<div>
					<input type="text" class="form-control tamanho-lg" id="nome_coord" name="nome_coord"
						value="<?php if ($dados[0]->nome_coordenador != "NAOAPLICA") echo $dados[0]->nome_coordenador; ?>">
					<label class="control-label form" for="nome_coord"></label>
				</div>
			</div>
		</div>

		<div class="form-group">
	      	<label class="negacao">6. Titula&ccedil;&atilde;o do(a) coordenador(a) do curso quando o curso foi desenvolvido</label>

			<div class="checkbox negacao-smaller">
		      	<label class=" negacao-smaller"> <input type="checkbox" name="ckTitulo_coord_ni" id="ckTitulo_coord_ni" value="NAOINFORMADO" <?php if ($dados[0]->titulacao_coordenador == "NAOINFORMADO") echo "checked"; ?> > N&atilde;o encontrado </label>
		      	<label class=" negacao-sm"> <input type="checkbox" name="ckTitulo_coord_na" id="ckTitulo_coord_na" value="NAOAPLICA" <?php if ($dados[0]->titulacao_coordenador == "NAOAPLICA") echo "checked"; ?> > Não se aplica </label>
			</div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="rtitulo_coord" id="rtitulo_coord_01" value="GRADUADO(A)" <?php if ($dados[0]->titulacao_coordenador == "GRADUADO(A)") echo "checked"; ?>> GRADUADO(A) </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rtitulo_coord" id="rtitulo_coord_02" value="ESPECIALISTA" <?php if ($dados[0]->titulacao_coordenador == "ESPECIALISTA") echo "checked"; ?>> ESPECIALISTA </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rtitulo_coord" id="rtitulo_coord_03" value="MESTRE(A)" <?php if ($dados[0]->titulacao_coordenador == "MESTRE(A)") echo "checked"; ?>> MESTRE(A) </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rtitulo_coord" id="rtitulo_coord_04" value="DOUTOR(A)" <?php if ($dados[0]->titulacao_coordenador == "DOUTOR(A)") echo "checked"; ?>> DOUTOR(A) </label> </div>
		      	<p class="text-danger"><label for="rtitulo_coord"><label></p>
		    </div>
		</div>

		<div class="form-group">
			<label class="negacao">7. Nome do vice-coordenador(a) do curso</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckVice_naplica" id="ckVice_naplica" value="NAOAPLICA" <?php if ($dados[0]->nome_vice_coordenador == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
		    </div>

			<div class="form-group">
				<div>
					<input type="text" class="form-control tamanho-lg" id="vice_nome" name="vice_nome"
						value="<?php if ($dados[0]->nome_vice_coordenador != "NAOAPLICA") echo $dados[0]->nome_vice_coordenador; ?>">
					<label class="control-label form" for="nome_coord"></label>
				</div>
			</div>
		</div>

		<div class="form-group">
	      	<label class="negacao">8. Titula&ccedil;&atilde;o do(a) vice-coordenador(a) do curso quando o curso foi desenvolvido</label>

		    <div class="checkbox">
		      	<label class=" negacao-sm"> <input type="checkbox" name="ckVice_titulo_ni" id="ckVice_titulo_ni" value="NAOINFORMADO" <?php if ($dados[0]->titulacao_vice_coordenador == "NAOINFORMADO") echo "checked"; ?>> N&atilde;o encontrado </label>
		      	<label class=" negacao-sm"> <input type="checkbox" name="ckVice_titulo_naplica" id="ckVice_titulo_naplica" value="NAOAPLICA" <?php if ($dados[0]->titulacao_vice_coordenador == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="rvice_titulo" id="rvice_titulo_01" value="GRADUADO(A)" <?php if ($dados[0]->titulacao_vice_coordenador == "GRADUADO(A)") echo "checked"; ?> > GRADUADO(A) </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rvice_titulo" id="rvice_titulo_02" value="ESPECIALISTA" <?php if ($dados[0]->titulacao_vice_coordenador == "ESPECIALISTA") echo "checked"; ?> > ESPECIALISTA </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rvice_titulo" id="rvice_titulo_03" value="MESTRE(A)" <?php if ($dados[0]->titulacao_vice_coordenador == "MESTRE(A)") echo "checked"; ?> > MESTRE(A) </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rvice_titulo" id="rvice_titulo_04" value="DOUTOR(A)" <?php if ($dados[0]->titulacao_vice_coordenador == "DOUTOR(A)") echo "checked"; ?> > DOUTOR(A) </label> </div>
		      	<p class="text-danger"><label for="rvice_titulo"><label></p>
		    </div>
		</div>

		<div class="form-group">
			<label class="negacao">9. Nome do coordenador(a) pedagogico(a) do curso</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckCoord_ped_naplica" id="ckCoord_ped_naplica" value="NAOAPLICA" <?php if ($dados[0]->nome_coordenador_pedagogico == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
		    </div>

			<div class="form-group">
				<div>
					<input type="text" class="form-control tamanho-lg" id="nome_coord_pedag" name="nome_coord_pedag"
						value="<?php if ($dados[0]->nome_coordenador_pedagogico != "NAOAPLICA") echo $dados[0]->nome_coordenador_pedagogico; ?>">
					<label class="control-label form" for="nome_coord_pedag"></label>
		    	</div>
		    </div>
		</div>

		<div class="form-group">
	      	<label class="negacao">10. Titula&ccedil;&atilde;o do(a) coordenador(a) pedagógico(a) do curso quando o curso foi desenvolvido</label>

		    <div class="checkbox">
		      	<label class="negacao-sm"> <input type="checkbox" name="ckTit_coord_pedag_ni" id="ckTit_coord_pedag_ni"  value="NAOINFORMADO" <?php if ($dados[0]->titulacao_coordenador_pedagogico == "NAOINFORMADO") echo "checked"; ?>> N&atilde;o encontrado </label>
		      	<label class="negacao-sm"> <input type="checkbox" name="ckTit_coord_pedag_naplica" id="ckTit_coord_pedag_naplica"  value="NAOAPLICA" <?php if ($dados[0]->titulacao_coordenador_pedagogico == "NAOAPLICA") echo "checked"; ?>> Não se aplica </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="rTit_coord_pedag" id="rTit_coord_pedag_01" value="GRADUADO(A)" <?php if ($dados[0]->titulacao_coordenador_pedagogico == "GRADUADO(A)") echo "checked"; ?>> GRADUADO(A) </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rTit_coord_pedag" id="rTit_coord_pedag_02" value="ESPECIALISTA" <?php if ($dados[0]->titulacao_coordenador_pedagogico == "ESPECIALISTA") echo "checked"; ?>> ESPECIALISTA </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rTit_coord_pedag" id="rTit_coord_pedag_03" value="MESTRE(A)" <?php if ($dados[0]->titulacao_coordenador_pedagogico == "MESTRE(A)") echo "checked"; ?>> MESTRE(A) </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rTit_coord_pedag" id="rTit_coord_pedag_04" value="DOUTOR(A)" <?php if ($dados[0]->titulacao_coordenador_pedagogico == "DOUTOR(A)") echo "checked"; ?>> DOUTOR(A) </label> </div>
		      	<p class="text-danger"><label for="rTit_coord_pedag"><label></p>
		    </div>
		</div>

		<div class="form-group">
            <label>11. Modalidade/nivel do curso</label>
            <div class="form-group">
                <div>
                    <select class="form-control" id="modalidade" name="modalidade"></select>
                    <p class="text-danger select"><label for="modalidade"><label></p>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <input type="text" class="form-control tamanho-lg" id="modalidade_descricao" name="modalidade_descricao" placeHolder="Especifique" style="display: none;">
                    <label class="control-label form bold" for="modalidade_descricao"></label>
                </div>
            </div>
        </div>

		<div class="form-group">
			<label class="negacao">12. Dura&ccedil;&atilde;o do curso (anos)</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckCurso_duracao" id="ckCurso_duracao" value="-1" <?php if ($dados[0]->duracao_curso == "-1") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

			<div class="form-group">
				<div>
					<input type="text" class="form-control tamanho-smaller" id="duracao" name="duracao" onKeyPress="return preventChar()" maxlength="2"
						value="<?php if ($dados[0]->duracao_curso != "-1") echo $dados[0]->duracao_curso; ?>">
					<label class="control-label form" for="duracao"></label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label>13. Período previsto para a realização do curso</label>
				<div class="form-group interno">
					<label class="negacao">a. Início (m&ecirc;s/ano)</label>

					<div class="checkbox negacao-smaller">
				      	<label> <input type="checkbox" name="ckCurso_previsto_inicio" id="ckCurso_previsto_inicio" value="NI" <?php if ($dados[0]->inicio_previsto == "NI") echo "checked"; ?> > N&atilde;o encontrado </label>
				    </div>

					<div class="form-group">
						<div>
							<input type="text" class="form-control tamanho-smaller" id="previsto_inicio" name="previsto_inicio"
								value="<?php if ($dados[0]->inicio_previsto != "NI") echo $dados[0]->inicio_previsto; ?>">
							<label class="control-label form" for="previsto_inicio"></label>
						</div>
					</div>

				</div>
				<div class="form-group interno">
					<label class="negacao">b. Término (m&ecirc;s/ano)</label>

					<div class="checkbox negacao-smaller">
				      	<label> <input type="checkbox" name="ckCurso_previsto_termino" id="ckCurso_previsto_termino" value="NI" <?php if ($dados[0]->termino_previsto == "NI") echo "checked"; ?> > N&atilde;o encontrado </label>
				    </div>

					<div class="form-group">
						<div>
							<input type="text" class="form-control tamanho-smaller" id="previsto_termino" name="previsto_termino"
								value="<?php if ($dados[0]->termino_previsto != "NI") echo $dados[0]->termino_previsto; ?>">
							<label class="control-label form" for="previsto_termino"></label>
						</div>
					</div>

				</div>
		</div>

		<div class="form-group">
			<label>14. Período em que o curso foi de fato realizado</label>
				<div class="form-group interno">
					<label class="negacao">a. Início (m&ecirc;s/ano)</label>

					<div class="checkbox negacao-smaller">
				      	<label> <input type="checkbox" name="ckCurso_realizado_inicio" id="ckCurso_realizado_inicio" value="NI" <?php if ($dados[0]->inicio_realizado == "NI") echo "checked"; ?>> N&atilde;o encontrado </label>
				    </div>
				    <div class="form-group">
				    	<div>
				    		<input type="text" class="form-control tamanho-smaller" id="realizado_inicio" name="realizado_inicio"
				    			value="<?php if ($dados[0]->inicio_realizado != "NI") echo $dados[0]->inicio_realizado; ?>">
				    		<label class="control-label form" for="realizado_inicio"></label>
				    	</div>
					</div>

				</div>
				<div class="form-group interno">
					<label class="negacao">b. Término (m&ecirc;s/ano)</label>

					<div class="checkbox negacao-smaller">
				      	<label class="negacao-smaller"> <input type="checkbox" name="ckCurso_realizado_termino" id="ckCurso_realizado_termino" value="NI" <?php if ($dados[0]->termino_realizado == "NI") echo "checked"; ?>> N&atilde;o encontrado </label>
				      	<label class="negacao-sm"> <input type="checkbox" name="ckCurso_finalizado" id="ckCurso_finalizado" value="NAOCONCLUIDO" <?php if ($dados[0]->curso_descricao != "") echo "checked"; ?>> Curso n&atilde;o conclu&iacute;do </label>
				    </div>
				    <div class="form-group">
				    	<div>
				    		<input type="text" class="form-control  tamanho-smaller" id="realizado_termino" name="realizado_termino"
				    			value="<?php if ($dados[0]->termino_realizado != "NI") echo $dados[0]->termino_realizado; ?>">
				    		<label class="control-label form" for="realizado_termino"></label>
				    	</div>
					</div>

				    <div class="form-group">
				    	<div>
				    		<textarea class="form-control tamanho-lg" rows="5" id="finalizacao_descrever" name="finalizacao_descrever" placeHolder="DESCREVA"><?php if ($dados[0]->curso_descricao != "NAOCONCLUIDO" && $dados[0]->curso_descricao != "NULL") echo $dados[0]->curso_descricao; ?></textarea>
				    		<label class="control-label form" for="finalizacao_descrever"></label>
				    	</div>
				    </div>
				</div>

				<div class="form-group interno">
					<label class="negacao">c. Número de Turmas </label>

					<div class="checkbox negacao-smaller">
				      	<label class="negacao-smaller"> <input type="checkbox" name="ckCurso_numero_turmas" id="ckCurso_numero_turmas" value="-1" <?php if ($dados[0]->numero_turmas == "-1") echo "checked"; ?>> N&atilde;o encontrado </label>
				    </div>
				    <div class="form-group">
				    	<div>
				    		<input type="text" class="form-control  tamanho-smaller" id="numero_turmas" name="numero_turmas" onKeyPress="return preventChar()" maxlength="6"
				    			value="<?php if ($dados[0]->numero_turmas != "-1") echo $dados[0]->numero_turmas; ?>">
				    		<label class="control-label form" for="numero_turmas"></label>
				    	</div>
					</div>
				</div>
		</div>

		<div class="form-group">
			<label class="negacao">15. N&uacute;mero de alunos ingressantes em todas as turmas</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckCurso_num_aluno_ingre" id="ckCurso_num_aluno_ingre" value="-1" <?php if ($dados[0]->numero_ingressantes == -1) echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="form-group">
		    	<div>
		    		<input type="text" class="form-control tamanho-smaller" id="num_aluno_ingre" name="num_aluno_ingre" onKeyPress="return preventChar()" maxlength="6"
		    			value="<?php if ($dados[0]->numero_ingressantes != "-1") echo $dados[0]->numero_ingressantes; ?>">
		    		<label class="control-label form" for="num_aluno_ingre"></label>
		    	</div>
			</div>

		</div>

		<div class="form-group">
			<label class="negacao">16. N&uacute;mero de alunos concluintes em todas as turmas</label>

			<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckCurso_num_aluno_concl" id="ckCurso_num_aluno_concl" value="-1" <?php if ($dados[0]->numero_concluintes == -1) echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="form-group">
		    	<div>
		    		<input type="text" class="form-control tamanho-smaller" id="num_aluno_concl" name="num_aluno_concl" onKeyPress="return preventChar()" maxlength="6"
		    			value="<?php if ($dados[0]->numero_concluintes != "-1") echo $dados[0]->numero_concluintes; ?>">
		    		<label class="control-label form" for="num_aluno_concl"></label>
		    	</div>
			</div>

		</div>

        <div class="table-box table-box-lg">
         	<div class="form-group">
    	      	<label>17. Mun&iacute;cipio(s) onde foi(foram) realizado(s) o curso</label>
    	      	<div class="form-group">

                    <ul id="cities_controls" class="nav nav-pills buttons">
                        <li>
                            <select class="form-control select_estado negacao" id="carac_sel_est" name="carac_sel_est"></select>
                            <p class="text-danger select estado"><label for="carac_sel_est"><label></p>
                        </li>
                        <li>
                            <select class="form-control select_municipio negacao" id="carac_sel_mun" name="carac_sel_mun"></select>
                            <p class="text-danger select municipio"><label for="carac_sel_mun"><label></p>
                        </li>
                        <li class="buttons">
                            <button type="button" class="btn btn-default" id="carac_botao_mun" name="carac_botao_mun">Adicionar</button>
                        </li>
                        <li class="buttons">
                            <button type="button" class="btn btn-default btn-disabled disabled delete-row" id="deletar" name="deletar">Remover Selecionado</button>
                        </li>
                    </ul>
    			</div>

    			<div class="table-size">
    		    	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="cities_table">
    			        <thead>
    			            <tr>
                                <th style="width:   0px;"> FLAG </th>
                                <th style="width:   0px;"> CÓDIGO MUNICIPIO</th>
                                <th style="width: 500px;"> MUNICÍPIO </th>
    			                <th style="width:   0px;"> CÓDIGO ESTADO </th>
    			                <th style="width: 100px;"> ESTADO </th>
    			            </tr>
    			        </thead>

    			        <tbody>
    			        </tbody>
    			    </table>
    		    </div>
    	    </div>
        </div>

		<div class="form-group">
	      	<label class="negacao">18. Houve algum impedimento na implementa&ccedil;&atilde;o do curso ?</label>

		    <div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckImpedimento_ni" id="ckImpedimento_ni" value="NI" <?php if ($dados[0]->impedimento_curso == "NI") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="rimpedimento" id="rimpedimento_01" value="NAO" <?php if ($dados[0]->impedimento_curso == "NAO") echo "checked"; ?> > N&atilde;o </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rimpedimento" id="rimpedimento_02" value="SIM" <?php if ($dados[0]->impedimento_curso != "NI" && $dados[0]->impedimento_curso == "SIM") echo "checked"; ?> > Sim </label>	</div>
		      	<div>
		      		<textarea class="form-control tamanho-lg" rows="5" id="impedimento_descrever" name="impedimento_descrever" placeHolder=" DESCREVA"><?php if ($dados[0]->impedimento_curso != "NI" && $dados[0]->impedimento_curso != "NAO") echo $dados[0]->impedimento_curso_descricao; ?></textarea>
		      		<p class="text-danger"><label for="rimpedimento"><label></p>
		      		<label class="control-label form" for="impedimento_descrever"></label>
		      	</div>
  			</div>
		</div>

		<div class="form-group">
	      	<label class="negacao">19. O projeto/curso teve como refer&ecirc;ncia um curso regular da institui&ccedil;&atilde;o de ensino ?</label>

		    <div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckReferencia_ni" id="ckReferencia_ni" value="-1"  <?php if ($dados[0]->referencia_curso == "-1") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="rreferencia" id="rreferencia_01" value="0" <?php if ($dados[0]->referencia_curso == "0") echo "checked"; ?> > N&atilde;o </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rreferencia" id="rreferencia_02" value="1" <?php if ($dados[0]->referencia_curso == "1") echo "checked"; ?> > Sim  </label> </div>
		      	<p class="text-danger"><label for="rreferencia"><label></p>
   		    </div>
		</div>

		<div class="form-group">
	      	<label class="negacao">20. Em caso afirmativo da quest&atilde;o anterior, a matriz curricular do curso regular foi alterada para o curso do PRONERA ?</label>

	      	<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckMatriz_ni" id="ckMatriz_ni" value="-1" <?php if ($dados[0]->matriz_curricular_curso == "-1") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="ralteracao" id="ralteracao_01" value="0" <?php if ($dados[0]->matriz_curricular_curso == "0") echo "checked"; ?> > N&atilde;o </label> </div>
		      	<div class="radio"><label> <input type="radio" name="ralteracao" id="ralteracao_02" value="1" <?php if ($dados[0]->matriz_curricular_curso == "1") echo "checked"; ?> > Sim  </label>	</div>
		      	<p class="text-danger"><label for="ralteracao"><label></p>
		    </div>
		</div>

		<div class="form-group">
	      	<label class="negacao">21. Houve desdobramentos do curso ?</label>

	      	<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckDesdobramento_ni" id="ckDesdobramento_ni" value="NI" <?php if ($dados[0]->desdobramento == "NI") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="rdesdobramento" id="rdesdobramento_01" value="NAO" <?php if ($dados[0]->desdobramento == "NAO") echo "checked"; ?> > N&atilde;o </label>	</div>
		      	<div class="radio"><label> <input type="radio" name="rdesdobramento" id="rdesdobramento_01" value="ENSINO" <?php if ($dados[0]->desdobramento == "ENSINO") echo "checked"; ?> > Ensino </label>	</div>
		      	<div class="radio"><label> <input type="radio" name="rdesdobramento" id="rdesdobramento_01" value="PESQUISA" <?php if ($dados[0]->desdobramento == "PESQUISA") echo "checked"; ?> > Pesquisa </label>	</div>
		      	<div class="radio"><label> <input type="radio" name="rdesdobramento" id="rdesdobramento_01" value="EXTENSAO" <?php if ($dados[0]->desdobramento == "EXTENSAO") echo "checked"; ?> > Extens&atilde;o </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rdesdobramento" id="rdesdobramento_05" value="OUTROS" <?php if ($dados[0]->desdobramento == "OUTROS") echo "checked"; ?> > Outros </label>	</div>
		      	<div>
		      		<textarea class="form-control tamanho-lg" rows="5" id="desdobramento_text_outros" name="desdobramento_text_outros" placeHolder=" DESCREVA"><?php if ($dados[0]->desdobramento == "OUTROS") echo $dados[0]->desdobramento_descricao; ?></textarea>
		      		<p class="text-danger"><label for="rdesdobramento"><label></p>
		      		<label class="control-label form" for="desdobramento_text_outros"></label>
		      	</div>
		    </div>
		</div>

		<div class="form-group">
	      	<label class="negacao">22. H&aacute; documentos normativos para garantir a Institucionaliza&ccedil;&atilde;o do curso nas instituições de ensino ?
	      	</label>

	      	<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckDocumentos_ni" id="ckDocumentos_ni" value="NI" <?php if ($dados[0]->documentos_normativos == "NI") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="rdoc" id="rdoc_01" value="NAO" <?php if ($dados[0]->documentos_normativos == "NAO") echo "checked"; ?> > N&atilde;o </label> </div>
		      	<div class="radio"><label> <input type="radio" name="rdoc" id="rdoc_02" value="SIM" <?php if ($dados[0]->documentos_normativos == "SIM") echo "checked"; ?>> Sim </label>	</div>
		      	<div>
		      		<textarea class="form-control tamanho-lg" rows="5" id="doc_descrever" name="doc_descrever" placeHolder=" DESCREVA"><?php if ($dados[0]->documentos_normativos == "SIM") echo $dados[0]->documentos_normativos_descricao; ?></textarea>
		      		<p class="text-danger"><label for="rdoc"><label></p>
		      		<label class="control-label form" for="doc_descrever"></label>
		      	</div>
		    </div>
		</div>

		<div class="form-group">
	      	<label class="negacao">23. Houve um espa&ccedil;o espec&iacute;fico para o PRONERA onde o curso foi realizado ?	</label>

	      	<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckEspaco_ni" id="ckEspaco_ni" value="NI" <?php if ($dados[0]->espaco_especifico == "NI") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="respaco" id="respaco_01" value="NAO" <?php if ($dados[0]->espaco_especifico == "NAO") echo "checked"; ?> > N&atilde;o </label> </div>
		      	<div class="radio"><label> <input type="radio" name="respaco" id="respaco_02" value="SIM" <?php if ($dados[0]->espaco_especifico == "SIM") echo "checked"; ?>> Sim </label>	</div>
		      	<div>
		      		<textarea class="form-control tamanho-lg" rows="5" id="espaco_descrever" name="espaco_descrever" placeHolder=" DESCREVA"><?php if ($dados[0]->espaco_especifico == "SIM") echo $dados[0]->espaco_especifico_descricao; ?></textarea>
		      		<p class="text-danger"><label for="respaco"><label></p>
		      		<label class="control-label form" for="espaco_descrever"></label>
		      	</div>
		    </div>
		</div>

		<div class="form-group">
	      	<label class="negacao">24. Houve avalia&ccedil;&atilde;o do curso pelo MEC ou outras instituições ?	</label>

	      	<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckAvaliacao_ni" id="ckAvaliacao_ni" value="NI" <?php if ($dados[0]->avaliacao_mec == "NI") echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="radio form-group">
		      	<div class="radio"><label> <input type="radio" name="ravaliacao" id="ravaliacao_01" value="NAO" <?php if ($dados[0]->avaliacao_mec == "NAO") echo "checked"; ?> > N&atilde;o </label> </div>
		      	<div class="radio"><label> <input type="radio" name="ravaliacao" id="ravaliacao_02" value="SIM" <?php if ($dados[0]->avaliacao_mec == "SIM") echo "checked"; ?>> Sim </label>	</div>
		      	<div>
		      		<textarea class="form-control tamanho-lg" rows="5" id="avaliacao_descrever" name="avaliacao_descrever" placeHolder=" DESCREVA QUAIS FORAM ELAS"><?php if ($dados[0]->avaliacao_mec == "SIM") echo $dados[0]->avaliacao_mec_descricao; ?></textarea>
		      		<p class="text-danger"><label for="ravaliacao"><label></p>
		      		<label class="control-label form" for="avaliacao_descrever"></label>
		      	</div>
		    </div>
		</div>

		<div class="form-group">
			<label class="negacao">25. N&uacute;mero de estudantes universitários (bolsista / monitor) que se envolveram nos cursos do PRONERA </label>

	      	<div class="checkbox negacao-smaller">
		      	<label> <input type="checkbox" name="ckCurso_num_bolsistas_ni" id="ckCurso_num_bolsistas_ni" value="-1" <?php if ($dados[0]->numero_bolsistas == -1) echo "checked"; ?> > N&atilde;o encontrado </label>
		    </div>

		    <div class="form-group">
		    	<div>
		    		<input type="text" class="form-control tamanho-smaller" id="num_bolsistas" name="num_bolsistas" onKeyPress="return preventChar()" maxlength="6"
		    			value="<?php if ($dados[0]->numero_bolsistas != -1) echo $dados[0]->numero_bolsistas; ?>">
		    		<label class="control-label form" for="num_bolsistas"></label>
		    	</div>
			</div>
		</div>
		<!--<input type="text" id="municipios_objeto" name="municipios_objeto" hidden/>-->
		<input type="hidden" id="caracterizacao_id" name="caracterizacao_id" value="<?php echo $dados[0]->id; ?>"/>

	</fieldset>
</form>