<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>ESTADO</th>
			<th>COD. MUNICÍPIO</th>
			<th style="text-align:left;">MUNICÍPIO</th>
			<th style="text-align:left;">LOCALIZAÇÃO</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center"><?php echo $row['estado']; ?></td>
				<td style="text-align:center"><?php echo $row['cod_municipio']; ?></td>
				<td><?php echo $row['municipio']; ?></td>
				<td><?php echo $row['parceiro']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>