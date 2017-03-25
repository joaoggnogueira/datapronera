<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">TITULAÇÃO</th>
			<th>% EDUCADORES</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['titulacao']; ?></td>
				<td style="text-align:center"><?php echo $row['educadores']; ?></td>
		<?php
			}
		?>
	</table>
</div>