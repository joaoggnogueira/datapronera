<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">TERRITORIO / ASSENTAMENTO</th>
			<th>EJA ALFABETIZACAO</th>
			<th>EJA ANOS INICIAIS</th>
			<th>EJA ANOS FINAIS</th>
			<th>COM. EJA NIVEL MEDIO (MAGISTERIO/FORMAL)</th>
			<th>EJA NIVEL MEDIO (NORMAL)</th>
			<th>NIVEL MEDIO/TECNICO (CONCOMITANTE)</th>
			<th>NIVEL MEDIO/TECNICO (INTEGRADO)</th>
			<th>NIVEL MEDIO PROFISSIONAL (POS-MEDIO)</th>
			<th>GRADUACAO</th>
			<th>ESPECIALIZACAO</th>
			<th>RESIDENCIA AGRARIA</th>
			<th>MESTRADO</th>
			<th>DOUTORADO</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td><?php echo $row['assent']; ?></td>
				<td style="text-align:center"><?php echo $row['eja_alf']; ?></td>
				<td style="text-align:center"><?php echo $row['eja_anos_inic']; ?></td>
				<td style="text-align:center"><?php echo $row['eja_anos_fin']; ?></td>
				<td style="text-align:center"><?php echo $row['eja_mag_form']; ?></td>
				<td style="text-align:center"><?php echo $row['eja_normal']; ?></td>
				<td style="text-align:center"><?php echo $row['medio_conc']; ?></td>
				<td style="text-align:center"><?php echo $row['medio_int']; ?></td>
				<td style="text-align:center"><?php echo $row['medio_prof_']; ?></td>
				<td style="text-align:center"><?php echo $row['graduacao']; ?></td>
				<td style="text-align:center"><?php echo $row['especializacao']; ?></td>
				<td style="text-align:center"><?php echo $row['res_agraria']; ?></td>
				<td style="text-align:center"><?php echo $row['mestrado']?></td>
				<td style="text-align:center"><?php echo $row['doutorado'] ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>