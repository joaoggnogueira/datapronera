<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">PARCEIROS</th>
			<th style="text-align:left">SIGLA</th>
			<th style="text-align:left">ABRANGÊNCIA</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['parceiro']; ?></td>
				<td><?php echo $row['sigla']; ?></td>
				<td><?php echo $row['abrangencia']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>