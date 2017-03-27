<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>ESTADO</th>
			<th>MONOGRAFIAS/ DISSERTAÇÕES</th>
			<th>LIVROS/ COLETÂNEAS</th>
			<th>CAP. LIVROS</th>
			<th>ARTIGOS</th>
			<th>VÍDEOS/ DOCUMENTÁRIOS</th>
			<th>PERIÓDICOS</th>
			<th>EVENTOS</th>
		</tr>
		<?php 
			foreach ($result as $row) {
		?>
			<tr>
				<td style="text-align:center"><?php echo $row['sigla']; ?></td>
				<td style="text-align:center"><?php echo $row['pac']; ?></td>
				<td style="text-align:center"><?php echo $row['plc']; ?></td>
				<td style="text-align:center"><?php echo $row['pcl']; ?></td>
				<td style="text-align:center"><?php echo $row['par']; ?></td>
				<td style="text-align:center"><?php echo $row['pvi']; ?></td>
				<td style="text-align:center"><?php echo $row['ppe']; ?></td>
				<td style="text-align:center"><?php echo $row['pev']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
</div>