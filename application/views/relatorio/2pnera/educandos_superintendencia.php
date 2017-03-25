
<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>CÓDIGO</th>
			<th style="text-align:left">SUPERINTENDÊNCIA</th>
			<th>EDUCANDOS</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center">SR - <?php if($row['id'] < 10) echo '0'.$row['id']; else echo $row['id']; ?></td>
				<td><?php echo $row['nome']; ?></td>
				<td style="text-align:center"><?php echo $row['educandos']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>