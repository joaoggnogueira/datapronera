
<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>CÓDIGO</th>
			<th style="text-align:left">SUPERINTENDÊNCIA</th>
			<th>EJA FUNDAMENTAL</th>
			<th>ENSINO MÉDIO</th>
			<th>ENSINO SUPERIOR</th>
			<th>TOTAL</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center"><?php echo $row['id']; ?></td>
				<td><?php echo $row['nome']; ?></td>
				<td style="text-align:center"><?php echo $row['eja_fundamental']; ?></td>
				<td style="text-align:center"><?php echo $row['ensino_medio']; ?></td>
				<td style="text-align:center"><?php echo $row['ensino_superior']; ?></td>
				<td style="text-align:center"><?php echo $row['total']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>