<div>
	<table style="width:100%; font-size: 13px;" border="1" cellspacing="0">
		<tr>
			<th>CÓDIGO</th>
			<th style="text-align:left;">SUPERINTENDÊNCIA</th>
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
				<td style="text-align:center">SR - <?php if($row['id'] < 10) echo '0'.$row['id']; else echo $row['id']; ?></td>
				<td><?php echo $row['nome']; ?></td>
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