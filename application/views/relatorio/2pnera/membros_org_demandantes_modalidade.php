<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">MODALIDADE</th>
			<th>% ESTUDARAM NO PRONERA</th>
			<th>% NÃO ESTUDARAM NO PRONERA</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['modalidade']; ?></td>
				<td style="text-align:center"><?php echo $row['sim']; ?></td>
				<td style="text-align:center"><?php echo $row['nao']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>