<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css" />

<div style="margin: 30px 0px 0px 35px; width: 1050px;">

	<div style="margin: 10px 0px 10px 450px; font-size: 20px;"><p> <b>Educando(s)</b></p></div>
	<table class="table table-bordered table-striped" style="font-size: 15px;">
		<tr>
			<th align="center" width="190px;"> Código Município </th>
			<th align="center" width="490px;"> Município </th>
			<th align="center" width="190px;"> Nùmero de Educandos </th>
		</tr>
		<?php
			foreach ($dados as $item){
				echo '<tr>';
					echo '<td align="center"> '.$item->cod_municipio.'</td>';
					echo '<td align="center"> '.$item->municipio.'</td>';
					echo '<td align="center"> '.$item->educandos.'</td>';
				echo '</tr>';
			}
		?>
		<tr></tr>
	</table>
	<table class="table table-bordered table-striped" style="font-size: 15px;">
		<tr>
			<th align="center" style="width:100px;"> Número de Educandos Sem Registro de Município(s)</th>';
			<td align="center" width="208px;"> <?php echo $sem[0]->educandos; ?> </td>
		</tr>
	</table>
	<table class="table table-bordered table-striped" style="font-size: 15px;">
		<tr>
			<th align="center"> Total de Educandos</th>';
			<td align="center" width="238px;"> <?php echo $total[0]->total; ?> </td>
		</tr>
	</table>
	<br>
	<p align="right"> <b>Observação: </b> A somatória dos valores pode não ser igual ao total de educandos informados, pois um educando pode estar relacionado a mais de um município</p>
</div>
