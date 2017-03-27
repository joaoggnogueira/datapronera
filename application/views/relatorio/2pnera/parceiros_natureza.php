<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">NATUREZA</th>
			<th>PARCEIROS</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['natureza']; ?></td>
				<td style="text-align:center"><?php echo $row['parceiros']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>