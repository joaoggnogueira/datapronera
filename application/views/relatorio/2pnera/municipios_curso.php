<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>ESTADO</th>
			<th>COD. MUNICÍPIO</th>
			<th style="text-align:left;">MUNICÍPIO</th>
			<th>CURSOS</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center"><?php echo $row['estado']; ?></td>
				<td style="text-align:center"><?php echo $row['cod_municipio']; ?></td>
				<td><?php echo $row['cidade']; ?></td>
				<td style="text-align:center"><?php echo $row['cursos']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>