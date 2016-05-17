<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" />
<?

$carac_naoEncontrada =  $caracterizacao['tit_coordgeral_ni'] + $caracterizacao['tit_coordprojeto_ni'] + $caracterizacao['tit_vicecoordprojeto_ni'] +
	$caracterizacao['tit_coordproj_pedag_ni'] + $caracterizacao['modalidade_ni'] + $caracterizacao['duracao_ni'] +
	$caracterizacao['ini_previsto_ni'] + $caracterizacao['ter_previsto_ni'] + $caracterizacao['ini_realizado_ni'] + $caracterizacao['ter_realizado_ni'] +
	$caracterizacao['num_turmas_ni'] + $caracterizacao['num_ingressantes_ni'] + $caracterizacao['num_concluintes_ni'] + $caracterizacao['municipio_ni'] +
	$caracterizacao['impedimento_ni'] + $caracterizacao['referencia_ni'] + $caracterizacao['matriz_curricular_ni'] + $caracterizacao['desdobramento_ni'] +
	$caracterizacao['documento_ni'] + $caracterizacao['espaco_ni'] + $caracterizacao['avaliacao_ni'] + $caracterizacao['num_bolsistas_ni'];

$carac_naoPreenchida =
    $caracterizacao['area_np'] + $caracterizacao['coordgeral_np'] + $caracterizacao['tit_coordgeral_np'] + $caracterizacao['coordproj_np'] +
    $caracterizacao['tit_coordprojeto_np'] + $caracterizacao['vicecoordproj_np'] + $caracterizacao['tit_vicecoordprojeto_np'] +
    $caracterizacao['coordproj_pedag_np'] + $caracterizacao['tit_coordproj_pedag_np'] + $caracterizacao['duracao_np'] +
    $caracterizacao['ini_previsto_np'] + $caracterizacao['ter_previsto_np'] + $caracterizacao['ini_realizado_np'] + $caracterizacao['ter_realizado_np'] +
    $caracterizacao['num_turmas_np'] + $caracterizacao['num_ingressantes_np'] + $caracterizacao['num_concluintes_np'] + $caracterizacao['municipio_np'] +
    $caracterizacao['impedimento_np'] + $caracterizacao['referencia_np'] + $caracterizacao['matriz_curricular_np'] + $caracterizacao['desdobramento_np'] +
    $caracterizacao['documento_np'] + $caracterizacao['espaco_np'] + $caracterizacao['avaliacao_np'] + $caracterizacao['num_bolsistas_np'];

$carac_naoAplica = $caracterizacao['coordproj_na'] + $caracterizacao['tit_coordprojeto_na'] + $caracterizacao['vicecoordproj_na'] +
	$caracterizacao['tit_vicecoordprojeto_na'] + $caracterizacao['coordproj_pedag_na'] + $caracterizacao['tit_coordproj_pedag_na'];

$carac_Encontrada =
    $caracterizacao['area_p'] + $caracterizacao['coordgeral_p'] + $caracterizacao['tit_coordgeral_p'] + $caracterizacao['coordproj_p'] +
    $caracterizacao['tit_coordprojeto_p'] + $caracterizacao['vicecoordproj_p'] + $caracterizacao['tit_vicecoordprojeto_p'] +
    $caracterizacao['coordproj_pedag_p'] + $caracterizacao['tit_coordproj_pedag_p'] +
    $caracterizacao['duracao_p'] + $caracterizacao['ini_previsto_p'] + $caracterizacao['ter_previsto_p'] +
    $caracterizacao['ini_realizado_p'] + $caracterizacao['ter_realizado_p'] + $caracterizacao['num_turmas_p'] +
    $caracterizacao['num_ingressantes_p'] + $caracterizacao['num_concluintes_p'] + $caracterizacao['municipio_p'] +
    $caracterizacao['impedimento_p'] + $caracterizacao['referencia_p'] + $caracterizacao['matriz_curricular_p'] +
    $caracterizacao['desdobramento_p'] + $caracterizacao['documento_p'] + $caracterizacao['espaco_p'] + $caracterizacao['avaliacao_p'] +
    $caracterizacao['num_bolsistas_p'];

$prof_naoEncontrada = $professor['nome_ni'] + $professor['cpf_ni'] + $professor['rg_ni'] + $professor['disciplina_ni'] + $professor['sexo_ni'] + $professor['titulacao_ni'];
$prof_naoPreenchida = $professor['nome_np'] + $professor['cpf_np'] + $professor['rg_np'] + $professor['disciplina_np'] + $professor['sexo_np'] + $professor['titulacao_np'];
$prof_naoAplica = $professor['cpf_na'] + $professor['rg_na'] ;
$prof_Encontrada = $professor['nome_p'] + $professor['cpf_p'] + $professor['rg_p'] + $professor['disciplina_p'] + $professor['sexo_p'] + $professor['titulacao_p'];

$edu_naoEncontrada = $educando['sexo_ni'] + $educando['cpf_ni'] + $educando['rg_ni'] + $educando['datanasc_ni'] + $educando['idade_ni'] + $educando['concluinte_ni'];
$edu_naoPreenchida = $educando['nome_np'] + $educando['cpf_np'] + $educando['rg_np'] + $educando['sexo_np'] + $educando['datanasc_np'] + $educando['idade_np'] + $educando['tipo_as_np'] +
	$educando['nome_territorio_np'] + $educando['municipio_np'] + $educando['concluinte_np'];
$edu_naoAplica = $educando['cpf_na'] + $educando['rg_na'] ;
$edu_Encontrada =$educando['nome_p'] +  $educando['cpf_p'] + $educando['rg_p'] + $educando['sexo_p'] + $educando['datanasc_p'] + $educando['idade_p'] + $educando['tipo_as_p'] +
	$educando['nome_territorio_p'] + $educando['municipio_p'] + $educando['concluinte_p'];

$inst_naoEncontrada = $instituicao['nome_ni'] + $instituicao['campus_ni'];
$inst_naoPreenchida = $instituicao['nome_np'] + $instituicao['sigla_np'] + $instituicao['unidade_np'] + $instituicao['departamento_np'] + $instituicao['rua_np'] +
	$instituicao['numero_np'] + $instituicao['complemento_np'] + $instituicao['bairro_np'] + $instituicao['cep_np'] + $instituicao['cidade_np'] +
	$instituicao['telefone1_np'] + $instituicao['telefone2_np'] + $instituicao['pagina_web_np'] +
	$instituicao['campus_np'] + $instituicao['natureza_np'];
$inst_naoAplica = 0;
$inst_Encontrada = $instituicao['nome_p'] + $instituicao['sigla_p'] + $instituicao['unidade_p'] + $instituicao['departamento_p'] + $instituicao['rua_p'] +
	 $instituicao['numero_p'] + $instituicao['complemento_p'] + $instituicao['bairro_p'] + $instituicao['cep_p'] + $instituicao['cidade_p'] +
	 $instituicao['telefone1_p'] + $instituicao['telefone2_p'] + $instituicao['pagina_web_p'] + $instituicao['campus_p'] +
	 $instituicao['natureza_p'];

$organ_naoEncontrada = $organizacao['numero_acampamentos_ni'] + $organizacao['numero_assentamentos_ni'] + $organizacao['numero_familias_assentadas_ni'] +
	$organizacao['numero_pessoas_ni'];
$organ_naoPreenchida = $organizacao['nome_np'] + $organizacao['abrangencia_np'] + $organizacao['data_fundacao_nacional_np'] + $organizacao['data_fundacao_estadual_np'] +
	$organizacao['numero_acampamentos_np'] + $organizacao['numero_assentamentos_np'] + $organizacao['numero_familias_assentadas_np'] +
	$organizacao['numero_pessoas_np'] + $organizacao['fonte_informacao_np'];
$organ_naoAplica = $organizacao['data_fundacao_nacional_na'];
$organ_Encontrada =  $organizacao['nome_p'] + $organizacao['abrangencia_p'] + $organizacao['data_fundacao_nacional_p'] + $organizacao['data_fundacao_estadual_p'] +
	$organizacao['numero_acampamentos_p'] + $organizacao['numero_assentamentos_p'] + $organizacao['numero_familias_assentadas_p'] +
	$organizacao['numero_pessoas_p'] + $organizacao['fonte_informacao_p'];

$parc_naoEncontrada = 0;
$parc_naoPreenchida = $parceiro['nome_np'] + $parceiro['sigla_np'] + $parceiro['rua_np'] + $parceiro['numero_np'] + $parceiro['complemento_np'] +
	$parceiro['bairro_np'] + $parceiro['cep_np'] + $parceiro['cidade_np'] + $parceiro['telefone1_np'] +
	$parceiro['telefone2_np'] + $parceiro['pagina_web_np'] + $parceiro['abrangencia_np']  + $parceiro['natureza_np']  + $parceiro['tipo_np'];
$parc_naoAplica = 0;
$parc_Encontrada = $parceiro['nome_p'] + $parceiro['sigla_p'] + $parceiro['rua_p'] + $parceiro['numero_p'] + $parceiro['complemento_p'] +
	$parceiro['bairro_p'] + $parceiro['cep_p'] + $parceiro['cidade_p'] + $parceiro['telefone1_p'] +
	$parceiro['telefone2_p'] + $parceiro['pagina_web_p'] + $parceiro['abrangencia_p'] + $parceiro['natureza_p']  + $parceiro['tipo_p'];



// echo '<pre'; print_r($organizacao); echo '</pre>';

?>
<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
		<tr>
			<th align="center"> Nome </th>
			<th align="center"> Registros </th>
			<th align="center"> Total** </th>
			<th align="center" width="150px;"> Não Encontrada </th>
			<th align="center" width="150px;"> Não Preenchida </th>
			<th align="center" width="150px;">  Não Se Aplica </th>
			<th align="center" width="150px;">  Encontrada
		</tr>
		<tr>
			<td>2 - Caracterizações</td>
			<td align="center"><?php echo $caracterizacao['total_ca']; ?></td>
			<td align="center"><?php echo $caracterizacao['total_ca'] * 26; ?></td>
			<td align="center"><?php echo $carac_naoEncontrada; ?> </td>
			<td align="center"><?php echo $carac_naoPreenchida; ?> </td>
			<td align="center"><?php echo $carac_naoAplica; ?> </td>
			<td align="center"><?php echo $carac_Encontrada; ?> </td>
		</tr>
		<tr>
			<td>3 - Professor</td>
			<td align="center"><?php echo $professor['total_p']; ?></td>
			<td align="center"><?php echo $professor['total_p'] * 6; ?></td>
			<td align="center"><?php echo $prof_naoEncontrada; ?> </td>
			<td align="center"><?php echo $prof_naoPreenchida; ?> </td>
			<td align="center"><?php echo $prof_naoAplica; ?> </td>
			<td align="center"><?php echo $prof_Encontrada; ?> </td>
		</tr>
		<tr>
			<td>4 - Educando</td>
			<td align="center"><?php echo $educando['total_p']; ?></td>
			<td align="center"><?php echo $educando['total_p'] * 10; ?></td>
			<td align="center"><?php echo $edu_naoEncontrada; ?> </td>
			<td align="center"><?php echo $edu_naoPreenchida; ?> </td>
			<td align="center"><?php echo $edu_naoAplica; ?> </td>
			<td align="center"><?php echo $edu_Encontrada; ?> </td>
		</tr>
		<tr>
			<td>5 - Instituição de Ensino</td>
			<td align="center"><?php echo $instituicao['total_p']; ?></td>
			<td align="center"><?php echo $instituicao['total_p'] * 15; ?></td>
			<td align="center"><?php echo $inst_naoEncontrada; ?> </td>
			<td align="center"><?php echo $inst_naoPreenchida; ?> </td>
			<td align="center"><?php echo $inst_naoAplica; ?> </td>
			<td align="center"><?php echo $inst_Encontrada; ?> </td>
		</tr>
		<tr>
			<td>6 - Organização Demandante</td>
			<td align="center"><?php echo $organizacao['total_p']; ?></td>
			<td align="center"><?php echo $organizacao['total_p'] * 9; ?></td>
			<td align="center"><?php echo $organ_naoEncontrada; ?> </td>
			<td align="center"><?php echo $organ_naoPreenchida; ?> </td>
			<td align="center"><?php echo $organ_naoAplica; ?> </td>
			<td align="center"><?php echo $organ_Encontrada; ?> </td>
		</tr>
		<tr>
			<td>7 - Parceiro</td>
			<td align="center"><?php echo $parceiro['total_p']; ?></td>
			<td align="center"><?php echo $parceiro['total_p'] * 14; ?></td>
			<td align="center"><?php echo $parc_naoEncontrada; ?> </td>
			<td align="center"><?php echo $parc_naoPreenchida; ?> </td>
			<td align="center"><?php echo $parc_naoAplica; ?> </td>
			<td align="center"><?php echo $parc_Encontrada; ?> </td>
		</tr>
	</table>
</div>
<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
<div align="center" style="font-size: 20px;"> <b> Formulário de Caracterização </b> </div>
<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
		<tr>
			<th align="center"> Nome do Campo</th>
			<th align="center" width="150px;"> Não Encontrada </th>
			<th align="center" width="150px;"> Não Preenchida </th>
			<th align="center" width="150px;">  Não Se Aplica </th>
			<th align="center" width="150px;">  Encontrada
		</tr>
		<tr>
			<td>Área de conhecimento</td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['area_np'] > 0 ) echo number_format($caracterizacao['area_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['area_p'] > 0 ) echo number_format($caracterizacao['area_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Nome do(a) coordenador(a) geral do curso</td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordgeral_np'] > 0 ) echo number_format($caracterizacao['coordgeral_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordgeral_p'] > 0 ) echo number_format($caracterizacao['coordgeral_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Titula&ccedil;&atilde;o do(a) coordenador(a) geral do curso </td>
			<td align="center"><?php if ($caracterizacao['tit_coordgeral_ni'] > 0 ) echo number_format($caracterizacao['tit_coordgeral_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordgeral_np'] > 0 ) echo number_format($caracterizacao['tit_coordgeral_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordgeral_p'] > 0 ) echo number_format($caracterizacao['tit_coordgeral_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Nome do coordenador(a) do projeto/curso</td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordproj_np'] > 0 ) echo number_format($caracterizacao['coordproj_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordproj_na'] > 0 ) echo number_format($caracterizacao['coordproj_na'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordproj_p'] > 0 ) echo number_format($caracterizacao['coordproj_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Titula&ccedil;&atilde;o do(a) coordenador(a) do curso</td>
			<td align="center"><?php if ($caracterizacao['tit_coordprojeto_ni'] > 0 ) echo number_format($caracterizacao['tit_coordprojeto_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordprojeto_np'] > 0 ) echo number_format($caracterizacao['tit_coordprojeto_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordprojeto_na'] > 0 ) echo number_format($caracterizacao['tit_coordprojeto_na'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordprojeto_p'] > 0 ) echo number_format($caracterizacao['tit_coordprojeto_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Nome do vice-coordenador(a) do curso</td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['vicecoordproj_np'] > 0 ) echo number_format($caracterizacao['vicecoordproj_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['vicecoordproj_na'] > 0 ) echo number_format($caracterizacao['vicecoordproj_na'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['vicecoordproj_p'] > 0 ) echo number_format($caracterizacao['vicecoordproj_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Titula&ccedil;&atilde;o do(a) vice-coordenador(a) do curso</td>
			<td align="center"><?php if ($caracterizacao['tit_vicecoordprojeto_ni'] > 0 ) echo number_format($caracterizacao['tit_vicecoordprojeto_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_vicecoordprojeto_np'] > 0 ) echo number_format($caracterizacao['tit_vicecoordprojeto_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_vicecoordprojeto_na'] > 0 ) echo number_format($caracterizacao['tit_vicecoordprojeto_na'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_vicecoordprojeto_p'] > 0 ) echo number_format($caracterizacao['tit_vicecoordprojeto_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Nome do coordenador(a) pedagogico(a) do curso</td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordproj_pedag_np'] > 0 ) echo number_format($caracterizacao['coordproj_pedag_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordproj_pedag_na'] > 0 ) echo number_format($caracterizacao['coordproj_pedag_na'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['coordproj_pedag_p'] > 0 ) echo number_format($caracterizacao['coordproj_pedag_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Titula&ccedil;&atilde;o do(a) coordenador(a) pedagógico(a) do curso</td>
			<td align="center"><?php if ($caracterizacao['tit_coordproj_pedag_ni'] > 0 ) echo number_format($caracterizacao['tit_coordproj_pedag_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordproj_pedag_np'] > 0 ) echo number_format($caracterizacao['tit_coordproj_pedag_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordproj_pedag_na'] > 0 ) echo number_format($caracterizacao['tit_coordproj_pedag_na'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['tit_coordproj_pedag_p'] > 0 ) echo number_format($caracterizacao['tit_coordproj_pedag_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Dura&ccedil;&atilde;o do curso (anos)</td>
			<td align="center"><?php if ($caracterizacao['duracao_ni'] > 0 ) echo number_format($caracterizacao['duracao_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['duracao_np'] > 0 ) echo number_format($caracterizacao['duracao_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['duracao_p'] > 0 ) echo number_format($caracterizacao['duracao_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
        	<td>Início Previsto (m&ecirc;s/ano)</td>
			<td align="center"><?php if ($caracterizacao['ini_previsto_ni'] > 0 ) echo number_format($caracterizacao['ini_previsto_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ini_previsto_np'] > 0 ) echo number_format($caracterizacao['ini_previsto_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ini_previsto_p'] > 0 ) echo number_format($caracterizacao['ini_previsto_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
        	<td>Término Previsto (m&ecirc;s/ano)</td>
			<td align="center"><?php if ($caracterizacao['ter_previsto_ni'] > 0 ) echo number_format($caracterizacao['ter_previsto_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ter_previsto_np'] > 0 ) echo number_format($caracterizacao['ter_previsto_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ter_previsto_p'] > 0 ) echo number_format($caracterizacao['ter_previsto_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
        	<td>Início Realizado (m&ecirc;s/ano)</td>
			<td align="center"><?php if ($caracterizacao['ini_realizado_ni'] > 0 ) echo number_format($caracterizacao['ini_realizado_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ini_realizado_np'] > 0 ) echo number_format($caracterizacao['ini_realizado_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ini_realizado_p'] > 0 ) echo number_format($caracterizacao['ini_realizado_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
        	<td>Término Realizado (m&ecirc;s/ano)</td>
			<td align="center"><?php if ($caracterizacao['ter_realizado_ni'] > 0 ) echo number_format($caracterizacao['ter_realizado_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ter_realizado_np'] > 0 ) echo number_format($caracterizacao['ter_realizado_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['ter_realizado_p'] > 0 ) echo number_format($caracterizacao['ter_realizado_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
        	<td>Número de Turmas</td>
			<td align="center"><?php if ($caracterizacao['num_turmas_ni'] > 0 ) echo number_format($caracterizacao['num_turmas_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['num_turmas_np'] > 0 ) echo number_format($caracterizacao['num_turmas_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['num_turmas_p'] > 0 ) echo number_format($caracterizacao['num_turmas_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>N&uacute;mero de alunos ingressantes em todas as turmas</td>
			<td align="center"><?php if ($caracterizacao['num_ingressantes_ni'] > 0 ) echo number_format($caracterizacao['num_ingressantes_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['num_ingressantes_np'] > 0 ) echo number_format($caracterizacao['num_ingressantes_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['num_ingressantes_p'] > 0 ) echo number_format($caracterizacao['num_ingressantes_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>N&uacute;mero de alunos concluintes em todas as turmas</td>
			<td align="center"><?php if ($caracterizacao['num_concluintes_ni'] > 0 ) echo number_format($caracterizacao['num_concluintes_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['num_concluintes_np'] > 0 ) echo number_format($caracterizacao['num_concluintes_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['num_concluintes_p'] > 0 ) echo number_format($caracterizacao['num_concluintes_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Munic&iacute;pio</td>
			<td align="center"><?php if ($caracterizacao['municipio_ni'] > 0 ) echo number_format($caracterizacao['municipio_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['municipio_np'] > 0 ) echo number_format($caracterizacao['municipio_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['municipio_p'] > 0 ) echo number_format($caracterizacao['municipio_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Houve algum impedimento na implementa&ccedil;&atilde;o do curso ?</td>
			<td align="center"><?php if ($caracterizacao['impedimento_ni'] > 0 ) echo number_format($caracterizacao['impedimento_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['impedimento_np'] > 0 ) echo number_format($caracterizacao['impedimento_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['impedimento_p'] > 0 ) echo number_format($caracterizacao['impedimento_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>O projeto/curso teve como refer&ecirc;ncia um curso regular ?</td>
			<td align="center"><?php if ($caracterizacao['referencia_ni'] > 0 ) echo number_format($caracterizacao['referencia_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['referencia_np'] > 0 ) echo number_format($caracterizacao['referencia_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['referencia_p'] > 0 ) echo number_format($caracterizacao['referencia_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>A matriz curricular do curso regular foi alterada ?</td>
			<td align="center"><?php if ($caracterizacao['matriz_curricular_ni'] > 0 ) echo number_format($caracterizacao['matriz_curricular_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['matriz_curricular_np'] > 0 ) echo number_format($caracterizacao['matriz_curricular_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['matriz_curricular_p'] > 0 ) echo number_format($caracterizacao['matriz_curricular_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Houve desdobramentos do curso ?</td>
			<td align="center"><?php if ($caracterizacao['desdobramento_ni'] > 0 ) echo number_format($caracterizacao['desdobramento_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['desdobramento_np'] > 0 ) echo number_format($caracterizacao['desdobramento_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['desdobramento_p'] > 0 ) echo number_format($caracterizacao['desdobramento_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>H&aacute; documentos normativos para garantir a Institucionaliza&ccedil;&atilde;o  ?</td>
			<td align="center"><?php if ($caracterizacao['documento_ni'] > 0 ) echo number_format($caracterizacao['documento_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['documento_np'] > 0 ) echo number_format($caracterizacao['documento_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['documento_p'] > 0 ) echo number_format($caracterizacao['documento_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Houve um espa&ccedil;o espec&iacute;fico para o PRONERA ?</td>
			<td align="center"><?php if ($caracterizacao['espaco_ni'] > 0 ) echo number_format($caracterizacao['espaco_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['espaco_np'] > 0 ) echo number_format($caracterizacao['espaco_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['espaco_p'] > 0 ) echo number_format($caracterizacao['espaco_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Houve avalia&ccedil;&atilde;o do curso pelo MEC ou outras instituições ?</td>
			<td align="center"><?php if ($caracterizacao['avaliacao_ni'] > 0 ) echo number_format($caracterizacao['avaliacao_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-';?></td>
			<td align="center"><?php if ($caracterizacao['avaliacao_np'] > 0 ) echo number_format($caracterizacao['avaliacao_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-';?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['avaliacao_p'] > 0 ) echo number_format($caracterizacao['avaliacao_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-';?></td>
		</tr>
		<tr>
    		<td>N&uacute;mero de estudantes universitários (bolsista / monitor) </td>
			<td align="center"><?php if ($caracterizacao['num_bolsistas_ni'] > 0 ) echo number_format($caracterizacao['num_bolsistas_ni'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-';?></td>
			<td align="center"><?php if ($caracterizacao['num_bolsistas_np'] > 0 ) echo number_format($caracterizacao['num_bolsistas_np'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-';?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($caracterizacao['num_bolsistas_p'] > 0 ) echo number_format($caracterizacao['num_bolsistas_p'] * 100 / $caracterizacao['total_ca'], 2, ',', ',')."%"; else echo '-';?></td>
		</tr>

	</table>
</div>

<br> <br>
<div align="center" style="font-size: 20px;"> <b> Formulário de Professor(a) </b> </div>
<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
		<tr>
			<th align="center"> Nome do Campo</th>
			<th align="center" width="150px;"> Não Encontrada </th>
			<th align="center" width="150px;"> Não Preenchida </th>
			<th align="center" width="150px;">  Não Se Aplica </th>
			<th align="center" width="150px;">  Encontrada
		</tr>
		<tr>
			<td>Nome do Professor</td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($professor['nome_np'] > 0 ) echo number_format($professor['nome_np'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($professor['nome_p'] > 0 ) echo number_format($professor['nome_p'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>CPF</td>
			<td align="center"><?php if ($professor['cpf_ni'] > 0 ) echo number_format($professor['cpf_ni'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['cpf_np'] > 0 ) echo number_format($professor['cpf_np'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['cpf_na'] > 0 ) echo number_format($professor['cpf_na'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['cpf_p'] > 0 ) echo number_format($professor['cpf_p'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>RG</td>
			<td align="center"><?php if ($professor['rg_ni'] > 0 ) echo number_format($professor['rg_ni'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['rg_np'] > 0 ) echo number_format($professor['rg_np'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['rg_na'] > 0 ) echo number_format($professor['rg_na'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['rg_p'] > 0 ) echo number_format($professor['rg_p'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Disciplina(s) lecionada(s)</td>
			<td align="center"><?php if ($professor['disciplina_ni'] > 0 ) echo number_format($professor['disciplina_ni'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['disciplina_np'] > 0 ) echo number_format($professor['disciplina_np'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($professor['disciplina_p'] > 0 ) echo number_format($professor['disciplina_p'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Gênero </td>
			<td align="center"><?php if ($professor['sexo_ni'] > 0 ) echo number_format($professor['sexo_ni'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['sexo_np'] > 0 ) echo number_format($professor['sexo_np'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($professor['sexo_p'] > 0 ) echo number_format($professor['sexo_p'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Titulação do Professor durante o curso</td>
			<td align="center"><?php if ($professor['titulacao_ni'] > 0 ) echo number_format($professor['titulacao_ni'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($professor['titulacao_np'] > 0 ) echo number_format($professor['titulacao_np'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($professor['titulacao_p'] > 0 ) echo number_format($professor['titulacao_p'] * 100 / $professor['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
	</table>
</div>

<br> <br>
<div align="center" style="font-size: 20px;"> <b> Formulário de Educando(a) </b> </div>
<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
		<tr>
			<th align="center"> Nome do Campo</th>
			<th align="center" width="150px;"> Não Encontrada </th>
			<th align="center" width="150px;"> Não Preenchida </th>
			<th align="center" width="150px;">  Não Se Aplica </th>
			<th align="center" width="150px;">  Encontrada
		</tr>
		<tr>
			<td>Nome do Educando</td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['nome_np'] > 0 ) echo number_format($educando['nome_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['nome_p'] > 0 ) echo number_format($educando['nome_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Gênero </td>
			<td align="center"><?php if ($educando['sexo_ni'] > 0 ) echo number_format($educando['sexo_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['sexo_np'] > 0 ) echo number_format($educando['sexo_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['sexo_p'] > 0 ) echo number_format($educando['sexo_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>CPF</td>
			<td align="center"><?php if ($educando['cpf_ni'] > 0 ) echo number_format($educando['cpf_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['cpf_np'] > 0 ) echo number_format($educando['cpf_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['cpf_na'] > 0 ) echo number_format($educando['cpf_na'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['cpf_p'] > 0 ) echo number_format($educando['cpf_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>RG</td>
			<td align="center"><?php if ($educando['rg_ni'] > 0 ) echo number_format($educando['rg_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['rg_np'] > 0 ) echo number_format($educando['rg_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['rg_na'] > 0 ) echo number_format($educando['rg_na'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['rg_p'] > 0 ) echo number_format($educando['rg_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Data de nascimento do(a) educando(a)</td>
			<td align="center"><?php if ($educando['datanasc_ni'] > 0 ) echo number_format($educando['datanasc_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['datanasc_np'] > 0 ) echo number_format($educando['datanasc_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['datanasc_p'] > 0 ) echo number_format($educando['datanasc_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Idade do(a) educando(a) no ingresso do curso </td>
			<td align="center"><?php if ($educando['idade_ni'] > 0 ) echo number_format($educando['idade_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['idade_np'] > 0 ) echo number_format($educando['idade_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['idade_p'] > 0 ) echo number_format($educando['idade_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Tipo do territ&oacute;rio</td>
			<td align="center"><?php if ($educando['tipo_as_ni'] > 0 ) echo number_format($educando['tipo_as_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['tipo_as_np'] > 0 ) echo number_format($educando['tipo_as_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['tipo_as_p'] > 0 ) echo number_format($educando['tipo_as_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Nome do territ&oacute;rio</td>
			<td align="center"><?php if ($educando['nome_territorio_ni'] > 0 ) echo number_format($educando['nome_territorio_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['nome_territorio_np'] > 0 ) echo number_format($educando['nome_territorio_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['nome_territorio_p'] > 0 ) echo number_format($educando['nome_territorio_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Munic&iacute;pio(s) do territ&oacute;rio </td>
			<td align="center"><?php if ($educando['municipio_ni'] > 0 ) echo number_format($educando['municipio_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['municipio_np'] > 0 ) echo number_format($educando['municipio_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['municipio_p'] > 0 ) echo number_format($educando['municipio_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>O(a) educando(a) concluiu o curso ?</td>
			<td align="center"><?php if ($educando['concluinte_ni'] > 0 ) echo number_format($educando['concluinte_ni'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($educando['concluinte_np'] > 0 ) echo number_format($educando['concluinte_np'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($educando['concluinte_p'] > 0 ) echo number_format($educando['concluinte_p'] * 100 / $educando['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
	</table>
</div>

<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
<div align="center" style="font-size: 20px;"> <b> Formulário de Instituição de Ensino </b> </div>
<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
		<tr>
			<th align="center"> Nome do Campo</th>
			<th align="center" width="150px;"> Não Encontrada </th>
			<th align="center" width="150px;"> Não Preenchida </th>
			<th align="center" width="150px;">  Não Se Aplica </th>
			<th align="center" width="150px;">  Encontrada
		</tr>
		<tr>
    		<td> Nome da Institui&ccedil;&atilde;o de Ensino </td>
			<td align="center"><?php if ($instituicao['nome_ni'] > 0 ) echo number_format($instituicao['nome_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['nome_np'] > 0 ) echo number_format($instituicao['nome_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['nome_p'] > 0 ) echo number_format($instituicao['nome_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Sigla </td>
			<td align="center"><?php if ($instituicao['sigla_ni'] > 0 ) echo number_format($instituicao['sigla_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['sigla_np'] > 0 ) echo number_format($instituicao['sigla_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['sigla_p'] > 0 ) echo number_format($instituicao['sigla_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Unidade: (Pr&oacute;-reitoria, Faculdade, Instituto, Centro, etc) </td>
			<td align="center"><?php if ($instituicao['unidade_ni'] > 0 ) echo number_format($instituicao['unidade_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['unidade_np'] > 0 ) echo number_format($instituicao['unidade_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['unidade_p'] > 0 ) echo number_format($instituicao['unidade_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Departamento, Se&ccedil;&atilde;o, etc </td>
			<td align="center"><?php if ($instituicao['departamento_ni'] > 0 ) echo number_format($instituicao['departamento_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['departamento_np'] > 0 ) echo number_format($instituicao['departamento_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['departamento_p'] > 0 ) echo number_format($instituicao['departamento_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Rua</td>
			<td align="center"><?php if ($instituicao['rua_ni'] > 0 ) echo number_format($instituicao['rua_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['rua_np'] > 0 ) echo number_format($instituicao['rua_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['rua_p'] > 0 ) echo number_format($instituicao['rua_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Número</td>
			<td align="center"><?php if ($instituicao['numero_ni'] > 0 ) echo number_format($instituicao['numero_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['numero_np'] > 0 ) echo number_format($instituicao['numero_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['numero_p'] > 0 ) echo number_format($instituicao['numero_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Complemento </td>
			<td align="center"><?php if ($instituicao['complemento_ni'] > 0 ) echo number_format($instituicao['complemento_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['complemento_np'] > 0 ) echo number_format($instituicao['complemento_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['complemento_p'] > 0 ) echo number_format($instituicao['complemento_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Bairro </td>
			<td align="center"><?php if ($instituicao['bairro_ni'] > 0 ) echo number_format($instituicao['bairro_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['bairro_np'] > 0 ) echo number_format($instituicao['bairro_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['bairro_p'] > 0 ) echo number_format($instituicao['bairro_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> CEP </td>
			<td align="center"><?php if ($instituicao['cep_ni'] > 0 ) echo number_format($instituicao['cep_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['cep_np'] > 0 ) echo number_format($instituicao['cep_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['cep_p'] > 0 ) echo number_format($instituicao['cep_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td> Cidade </td>
			<td align="center"><?php if ($instituicao['cidade_ni'] > 0 ) echo number_format($instituicao['cidade_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['cidade_np'] > 0 ) echo number_format($instituicao['cidade_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['cidade_p'] > 0 ) echo number_format($instituicao['cidade_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Telefone 1 </td>
			<td align="center"><?php if ($instituicao['telefone1_ni'] > 0 ) echo number_format($instituicao['telefone1_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['telefone1_np'] > 0 ) echo number_format($instituicao['telefone1_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['telefone1_p'] > 0 ) echo number_format($instituicao['telefone1_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Telefone 2 </td>
			<td align="center"><?php if ($instituicao['telefone2_ni'] > 0 ) echo number_format($instituicao['telefone2_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['telefone2_np'] > 0 ) echo number_format($instituicao['telefone2_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['telefone2_p'] > 0 ) echo number_format($instituicao['telefone2_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td> Página WEB </td>
			<td align="center"><?php if ($instituicao['pagina_web_ni'] > 0 ) echo number_format($instituicao['pagina_web_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['pagina_web_np'] > 0 ) echo number_format($instituicao['pagina_web_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['pagina_web_p'] > 0 ) echo number_format($instituicao['pagina_web_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Campus </td>
			<td align="center"><?php if ($instituicao['campus_ni'] > 0 ) echo number_format($instituicao['campus_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['campus_np'] > 0 ) echo number_format($instituicao['campus_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['campus_p'] > 0 ) echo number_format($instituicao['campus_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Natureza do Parceiro</td>
			<td align="center"><?php if ($instituicao['natureza_ni'] > 0 ) echo number_format($instituicao['natureza_ni'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['natureza_np'] > 0 ) echo number_format($instituicao['natureza_np'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($instituicao['natureza_p'] > 0 ) echo number_format($instituicao['natureza_p'] * 100 / $instituicao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
	</table>
</div>


<div align="center" style="font-size: 20px;"> <b> Formulário de Organização Demandante </b> </div>
<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
		<tr>
			<th align="center"> Nome do Campo</th>
			<th align="center" width="150px;"> Não Encontrada </th>
			<th align="center" width="150px;"> Não Preenchida </th>
			<th align="center" width="150px;">  Não Se Aplica </th>
			<th align="center" width="150px;">  Encontrada
		</tr>
		<tr>
    		<td> Nome da Organização </td>
			<td align="center"><?php if ($organizacao['nome_ni'] > 0 ) echo number_format($organizacao['nome_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['nome_np'] > 0 ) echo number_format($organizacao['nome_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['nome_p'] > 0 ) echo number_format($organizacao['nome_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Abrangência </td>
			<td align="center"><?php if ($organizacao['abrangencia_ni'] > 0 ) echo number_format($organizacao['abrangencia_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['abrangencia_np'] > 0 ) echo number_format($organizacao['abrangencia_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['abrangencia_p'] > 0 ) echo number_format($organizacao['abrangencia_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Data de Fundação Nacional </td>
			<td align="center"><?php if ($organizacao['data_fundacao_nacional_ni'] > 0 ) echo number_format($organizacao['data_fundacao_nacional_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['data_fundacao_nacional_np'] > 0 ) echo number_format($organizacao['data_fundacao_nacional_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['data_fundacao_nacional_na'] > 0 ) echo number_format($organizacao['data_fundacao_nacional_na'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['data_fundacao_nacional_p'] > 0 ) echo number_format($organizacao['data_fundacao_nacional_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Data de Fundação Estadual </td>
			<td align="center"><?php if ($organizacao['data_fundacao_estadual_ni'] > 0 ) echo number_format($organizacao['data_fundacao_estadual_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['data_fundacao_estadual_np'] > 0 ) echo number_format($organizacao['data_fundacao_estadual_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['data_fundacao_estadual_p'] > 0 ) echo number_format($organizacao['data_fundacao_estadual_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td> Número de Acampamentos (estadual)</td>
			<td align="center"><?php if ($organizacao['numero_acampamentos_ni'] > 0 ) echo number_format($organizacao['numero_acampamentos_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_acampamentos_np'] > 0 ) echo number_format($organizacao['numero_acampamentos_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_acampamentos_p'] > 0 ) echo number_format($organizacao['numero_acampamentos_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Número de Assentamentos ligados ao Movimento no Estado </td>
			<td align="center"><?php if ($organizacao['numero_assentamentos_ni'] > 0 ) echo number_format($organizacao['numero_assentamentos_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_assentamentos_np'] > 0 ) echo number_format($organizacao['numero_assentamentos_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_assentamentos_p'] > 0 ) echo number_format($organizacao['numero_assentamentos_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Número de Famílias Assentadas </td>
			<td align="center"><?php if ($organizacao['numero_familias_assentadas_ni'] > 0 ) echo number_format($organizacao['numero_familias_assentadas_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_familias_assentadas_np'] > 0 ) echo number_format($organizacao['numero_familias_assentadas_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_familias_assentadas_p'] > 0 ) echo number_format($organizacao['numero_familias_assentadas_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Número de Pessoas do Movimento envolvidas </td>
			<td align="center"><?php if ($organizacao['numero_pessoas_ni'] > 0 ) echo number_format($organizacao['numero_pessoas_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_pessoas_np'] > 0 ) echo number_format($organizacao['numero_pessoas_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['numero_pessoas_p'] > 0 ) echo number_format($organizacao['numero_pessoas_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td> Fonte de Informações </td>
			<td align="center"><?php if ($organizacao['fonte_informacao_ni'] > 0 ) echo number_format($organizacao['fonte_informacao_ni'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['fonte_informacao_np'] > 0 ) echo number_format($organizacao['fonte_informacao_np'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($organizacao['fonte_informacao_p'] > 0 ) echo number_format($organizacao['fonte_informacao_p'] * 100 / $organizacao['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
	</table>
</div>


<br>
<div align="center" style="font-size: 20px;"> <b> Formulário de Parceiro </b> </div>
<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
		<tr>
			<th align="center"> Nome do Campo</th>
			<th align="center" width="150px;"> Não Encontrada </th>
			<th align="center" width="150px;"> Não Preenchida </th>
			<th align="center" width="150px;">  Não Se Aplica </th>
			<th align="center" width="150px;">  Encontrada
		</tr>
		<tr>
    		<td> Nome do Parceiro </td>
			<td align="center"><?php if ($parceiro['nome_ni'] > 0 ) echo number_format($parceiro['nome_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['nome_np'] > 0 ) echo number_format($parceiro['nome_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['nome_p'] > 0 ) echo number_format($parceiro['nome_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Sigla </td>
			<td align="center"><?php if ($parceiro['sigla_ni'] > 0 ) echo number_format($parceiro['sigla_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['sigla_np'] > 0 ) echo number_format($parceiro['sigla_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['sigla_p'] > 0 ) echo number_format($parceiro['sigla_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td>Rua</td>
			<td align="center"><?php if ($parceiro['rua_ni'] > 0 ) echo number_format($parceiro['rua_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['rua_np'] > 0 ) echo number_format($parceiro['rua_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['rua_p'] > 0 ) echo number_format($parceiro['rua_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td>Número</td>
			<td align="center"><?php if ($parceiro['numero_ni'] > 0 ) echo number_format($parceiro['numero_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['numero_np'] > 0 ) echo number_format($parceiro['numero_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['numero_p'] > 0 ) echo number_format($parceiro['numero_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Complemento </td>
			<td align="center"><?php if ($parceiro['complemento_ni'] > 0 ) echo number_format($parceiro['complemento_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['complemento_np'] > 0 ) echo number_format($parceiro['complemento_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['complemento_p'] > 0 ) echo number_format($parceiro['complemento_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Bairro </td>
			<td align="center"><?php if ($parceiro['bairro_ni'] > 0 ) echo number_format($parceiro['bairro_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['bairro_np'] > 0 ) echo number_format($parceiro['bairro_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['bairro_p'] > 0 ) echo number_format($parceiro['bairro_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> CEP </td>
			<td align="center"><?php if ($parceiro['cep_ni'] > 0 ) echo number_format($parceiro['cep_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['cep_np'] > 0 ) echo number_format($parceiro['cep_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['cep_p'] > 0 ) echo number_format($parceiro['cep_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td> Cidade </td>
			<td align="center"><?php if ($parceiro['cidade_ni'] > 0 ) echo number_format($parceiro['cidade_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['cidade_np'] > 0 ) echo number_format($parceiro['cidade_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['cidade_p'] > 0 ) echo number_format($parceiro['cidade_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Telefone 1 </td>
			<td align="center"><?php if ($parceiro['telefone1_ni'] > 0 ) echo number_format($parceiro['telefone1_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['telefone1_np'] > 0 ) echo number_format($parceiro['telefone1_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['telefone1_p'] > 0 ) echo number_format($parceiro['telefone1_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Telefone 2 </td>
			<td align="center"><?php if ($parceiro['telefone2_ni'] > 0 ) echo number_format($parceiro['telefone2_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['telefone2_np'] > 0 ) echo number_format($parceiro['telefone2_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['telefone2_p'] > 0 ) echo number_format($parceiro['telefone2_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
			<td> Página WEB </td>
			<td align="center"><?php if ($parceiro['pagina_web_ni'] > 0 ) echo number_format($parceiro['pagina_web_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['pagina_web_np'] > 0 ) echo number_format($parceiro['pagina_web_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['pagina_web_p'] > 0 ) echo number_format($parceiro['pagina_web_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Natureza do Parceiro</td>
			<td align="center"><?php if ($parceiro['natureza_ni'] > 0 ) echo number_format($parceiro['natureza_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['natureza_np'] > 0 ) echo number_format($parceiro['natureza_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['natureza_p'] > 0 ) echo number_format($parceiro['natureza_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Abrangência </td>
			<td align="center"><?php if ($parceiro['abrangencia_ni'] > 0 ) echo number_format($parceiro['abrangencia_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['abrangencia_np'] > 0 ) echo number_format($parceiro['abrangencia_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['abrangencia_p'] > 0 ) echo number_format($parceiro['abrangencia_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
		<tr>
    		<td> Tipo de Parceria </td>
			<td align="center"><?php if ($parceiro['tipo_ni'] > 0 ) echo number_format($parceiro['tipo_ni'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['tipo_np'] > 0 ) echo number_format($parceiro['tipo_np'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
			<td align="center"><?php echo '-'; ?></td>
			<td align="center"><?php if ($parceiro['tipo_p'] > 0 ) echo number_format($parceiro['tipo_p'] * 100 / $parceiro['total_p'], 2, ',', ',')."%"; else echo '-'; ?></td>
		</tr>
	</table>
</div>
