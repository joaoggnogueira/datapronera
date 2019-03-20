<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>SUPERINTENDÊNCIA</th>
			<th>% ENSINO FUNDAMENTAL COMPLETO</th>
			<th>% ENSINO FUNDAMENTAL INCOMPLETO</th>
			<th>% ENSINO MÉDIO COMPLETO</th>
			<th>% ENSINO MÉDIO INCOMPLETO</th>
			<th>% GRADUADO(A)</th>
			<th>% ESPECIALISTA</th>
			<th>% MESTRE(A)</th>
			<th>% DOUTOR(A)</th>
			<th>% N/A</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center"><?PHP echo $row['id']; ?></td>
				<td style="text-align:center"><?php echo $row['ensino_fundamental_completo']; ?></td>
				<td style="text-align:center"><?php echo $row['ensino_fundamental_incompleto']; ?></td>
				<td style="text-align:center"><?php echo $row['ensino_medio_completo']; ?></td>
				<td style="text-align:center"><?php echo $row['ensino_medio_incompleto']; ?></td>
				<td style="text-align:center"><?php echo $row['graduado']; ?></td>
				<td style="text-align:center"><?php echo $row['especialista']; ?></td>
				<td style="text-align:center"><?php echo $row['mestre']; ?></td>
				<td style="text-align:center"><?php echo $row['doutor']; ?></td>
				<td style="text-align:center"><?php echo $row['undefined']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>