
<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>CÓDIGO</th>
			<th style="text-align:left">SUPERINTENDÊNCIA</th>
			<th>ACAMPAMENTO</th>
			<th>ASSENTAMENTO</th>
			<th>COMUNIDADE</th>
			<th>COM. RIBEIRINHA</th>
			<th>FLONA</th>
			<th>F. NACIONAL</th>
			<th>QUILOMBOLA</th>
			<th>RDS</th>
			<th>RESEX</th>
			<th>OUTRO</th>
			<th>N.P.</th>
			<th>N.I.</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center">SR - <?php if($row['id'] < 10) echo '0'.$row['id']; else echo $row['id']; ?></td>
				<td><?php echo $row['nome']; ?></td>
				<td style="text-align:center"><?php echo $row['acampamento']; ?></td>
				<td style="text-align:center"><?php echo $row['assentamento']; ?></td>
				<td style="text-align:center"><?php echo $row['comunidade']; ?></td>
				<td style="text-align:center"><?php echo $row['quilombola']; ?></td>
				<td style="text-align:center"><?php echo $row['comunidade_ribeirinha']; ?></td>
				<td style="text-align:center"><?php echo $row['floresta_nacional']; ?></td>
				<td style="text-align:center"><?php echo $row['resex']; ?></td>
				<td style="text-align:center"><?php echo $row['flona']; ?></td>
				<td style="text-align:center"><?php echo $row['rds']; ?></td>
				<td style="text-align:center"><?php echo $row['outro']; ?></td>
				<td style="text-align:center"><?php echo $row['nao_preenchido']; ?></td>
				<td style="text-align:center"><?php echo $row['nao_informado']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>