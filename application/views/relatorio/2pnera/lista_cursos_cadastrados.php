<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>CÓDIGO</th>
			<th style="text-align:left">CURSO</th>
			<th style="text-align:left">MODALIDADE</th>
			<th style="text-align:left">SUPERINTENDENCIA</th>
			<th style="text-align:left">N° PROCESSO</th>
			<th style="text-align:left">N° INSTRUMENTO</th>
			<th style="text-align:left">TIPO DE INSTRUMENTO</th>
			<th style="text-align:left">INICIO REALIZADO</th>
			<th style="text-align:left">TERMINO REALIZADO</th>

		</tr>
		<?php
		foreach ($result as $row) {
			?>
			<tr>
				<td><?php echo $row['id_curso']; ?></td>
				<td style="text-align:left"><?php echo $row['curso']; ?></td>
				<td style="text-align:left"><?php echo $row['modalidade']; ?></td>
				<td style="text-align:left"><?php echo $row['superintendencia']; ?></td>
				<td style="text-align:left"><?php echo $row['nprocesso']; ?></td>
				<td style="text-align:left"><?php echo $row['ninstrumento']; ?></td>
				<td style="text-align:left"><?php echo $row['tinstrumento']; ?></td>
				<td style="text-align:left"><?php echo $row['inicio_realizado']; ?></td>
				<td style="text-align:left"><?php echo $row['termino_realizado']; ?></td>

			</tr>
		<?php
		}
		?>
	</table>
</div>