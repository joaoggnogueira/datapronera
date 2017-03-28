
<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>NÍVEL</th>
			<th>EDUCADORES</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['nivel']; ?></td>
				<td style="text-align:center"><?php echo $row['educadores']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>