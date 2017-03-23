<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">MODALIDADE</th>
			<th>CÓDIGO</th>
			<th style="text-align:left">CURSO</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['modalidade']; ?></td>
				<td style="text-align:center"><?php echo $row['id_curso']; ?></td>
				<td style="font-size:9px;"><?php echo $row['curso']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>