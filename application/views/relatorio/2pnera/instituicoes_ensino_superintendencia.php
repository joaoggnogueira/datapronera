<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>CÓDIGO</th>
			<th style="text-align:left;">SUPERINTENDÊNCIA</th>
			<th>INSTITUIÇÕES DE ENSINO</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center"><?php echo $row['id']; ?></td>
				<td><?php echo $row['superintendencia']; ?></td>
				<td style="text-align:center"><?php echo $row['instituicoes']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>