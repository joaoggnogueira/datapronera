<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>COD. CURSO</th>
			<th>CURSO</th>
			<th>MODALIDADE</th>
			<th>COD. CIDADE</th>
			<th>CIDADE</th>
			<th>ESTADO</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center"><?php echo $row['id_curso']; ?></td>
				<td style="font-size: 9px;"><?php echo $row['curso']; ?></td>
				<td><?php echo $row['modalidade']; ?></td>
				<td style="text-align:center"><?php echo $row['cod_municipio']; ?></td>
				<td style="text-align:center"><?php echo $row['cidade']; ?></td>
				<td style="text-align:center"><?php echo $row['estado']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>