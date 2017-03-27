<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">TIPO</th>
			<th>PRODUÇÕES</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['natureza_producao']; ?></td>
				<td style="text-align:center"><?php echo $row['producoes']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>