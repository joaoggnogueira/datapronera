<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" />

<div style="margin: 30px 0px 0px 35px; width: 1050px;">
	<table class="table table-bordered" style="font-size: 15px;">
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
				print_r($item);
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
