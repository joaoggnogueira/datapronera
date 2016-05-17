<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" />

<div style="margin: 30px 0px 0px 35px; width: 1050px;">

	<div style="margin: 10px 0px 10px 400px; font-size: 20px;"><p> <b>Superintendência(s)</b></p></div>
	<table class="table table-bordered table-striped" style="font-size: 15px;">
		<tr>
			<th align="center" width="290px;"> Nome </th>
			<th align="center" width="110px;"> Responsável </th>
			<th align="center" width="110px;"> Caracterização </th>
			<th align="center" width="100px;">  Professor </th>
			<th align="center" width="100px;"> Educando </th>
			<th align="center" width="110px;"> Instituição </th>
			<th align="center" width="110px;"> Organização </th>
			<th align="center" width="100px;">  Parceiro </th>
			<th align="center" width="100px;"> Produção </th>
		</tr>
		<?php
			foreach ($dados as $item){
				echo '<tr>';
					echo '<td> '.$item['nome'].'</td>';
					echo '<td align="center"> '.$item['responsaveis'].'</td>';
					echo '<td align="center"> '.$item['caracterizacoes'].'</td>';
					echo '<td align="center"> '.$item['professor'].'</td>';
					echo '<td align="center"> '.$item['educando'].'</td>';
					echo '<td align="center"> '.$item['instituicao'].'</td>';
					echo '<td align="center"> '.$item['organizacao'].'</td>';
					echo '<td align="center"> '.$item['parceiro'].'</td>';
					echo '<td align="center"> '.$item['producoes'].'</td>';
				echo '</tr>';
			}
		?>
	</table>
</div>

<div style="margin: 30px 0px 0px 35px; width: 1050px;">
<?php if ($cursos != '') { ?>
	<div style="margin: 10px 0px 10px 460px; font-size: 20px;"><p> <b>Curso(s)</b></p></div>
	<table class="table table-bordered table-striped" style="font-size: 15px;">
		<tr>
			<th align="center" width="290px;"> Nome </th>
			<th align="center" width="110px;"> Responsável </th>
			<th align="center" width="110px;"> Caracterização </th>
			<th align="center" width="100px;">  Professor </th>
			<th align="center" width="100px;"> Educando </th>
			<th align="center" width="110px;"> Instituição </th>
			<th align="center" width="110px;"> Organização </th>
			<th align="center" width="100px;">  Parceiro </th>
			<th align="center" width="100px;"> Produção </th>
		</tr>
		<?php
			foreach ($cursos as $item){

				$codigo = "";
				if ($item['super'] < 10) $codigo .= "0";
				$codigo .= $item['super'];
				$codigo .= ".";

				if ($item['id'] < 100) $codigo .= "0";
				if ($item['id'] < 10) $codigo .= "0";
				$codigo .= $item['id'];

				echo '<tr>';
					echo '<td> '.$codigo.'  -  '; if ($item['nome'] != '') echo $item['nome']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['responsaveis'] != '') echo $item['responsaveis']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['caracterizacoes'] != '') echo $item['caracterizacoes']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['professor'] != '') echo $item['professor']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['educando'] != '') echo $item['educando']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['instituicao'] != '') echo $item['instituicao']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['organizacao'] != '') echo $item['organizacao']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['parceiro'] != '') echo $item['parceiro']; else echo '0'; echo '</td>';
					echo '<td align="center">  '; if ($item['producoes'] != '') echo $item['producoes']; else echo '0'; echo '</td>';
				echo '</tr>';
			}
		?>
	</table>
<?php } ?>
</div>
