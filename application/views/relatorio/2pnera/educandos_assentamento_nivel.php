<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left;">TERRITÓRIO / ASSENTAMENTO</th>
			<th>EJA FUNDAMENTAL</th>
			<th>ENSINO MÉDIO</th>
			<th>ENSINO SUPERIOR</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['assent']; ?></td>
				<td style="text-align:center"><?php echo $row['eja_fundamental']; ?></td>
				<td style="text-align:center"><?php echo $row['nivel_medio']; ?></td>
				<td style="text-align:center"><?php echo $row['nivel_superior']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>