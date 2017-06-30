<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>CÓDIGO</th>
			<th style="text-align:left">CURSO</th>
			<th style="text-align:left">EDUCANDO</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align: center;"><?php echo $row['id_curso']; ?></td>
				<td style="font-size: 9px;"><?php echo $row['curso']; ?></td>
				<td><?php echo $row['educando']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>