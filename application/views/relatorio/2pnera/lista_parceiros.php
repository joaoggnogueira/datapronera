<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">PARCEIROS</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['parceiro']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>