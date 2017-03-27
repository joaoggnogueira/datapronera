<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">ORGANIZACÃO</th>
			<th>CURSOS</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['organizacao']; ?></td>
				<td style="text-align:center"><?php echo $row['cursos']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>