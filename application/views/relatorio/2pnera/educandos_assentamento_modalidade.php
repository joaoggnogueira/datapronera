<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th style="text-align:left">TERRITORIO / ASSENTAMENTO</th>
			<th>EJA ALFABETIZACAO</th>
			<th>EJA A. INICIAIS</th>
			<th>EJA A. FINAIS</th>
			<th>COM. EJA N. MEDIO (MAGISTERIO/FORMAL)</th>
			<th>EJA N. MEDIO (NORMAL)</th>
			<th>N. MEDIO/TECNICO (CONCOMITANTE)</th>
			<th>N. MEDIO/TECNICO (INTEGRADO)</th>
			<th>N. MEDIO PROFISSIONAL (POS-MEDIO)</th>
			<th>GRADUACAO</th>
			<th>ESPECIALIZACAO</th>
			<th>RESID. AGRARIA</th>
			<th>MESTRADO</th>
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
			</tr>
		<?php
			}
		?>
	</table>
</div>