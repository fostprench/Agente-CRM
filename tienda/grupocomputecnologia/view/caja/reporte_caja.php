<?php 

//se saca el dia para iniciar en el for desde el dia de apertura de la caja
list($anio,$mes,$dia) = split('-',$fecha_reporte);

$nombre_mes = nombre_mes($mes);

//se saca la maxima fecha de registro con el idcaja para terminar el for
list($anio_max, $mes_max, $dia_max ) = split('-',$fecha_max_movimiento);

$colores = array("warning","danger","info","success");

?>


<style>
.acortarx{
	white-space: nowrap;
	text-overflow: ellipsis;
    width: 280px;
    overflow: hidden;
}
.acortar2x{
	white-space: nowrap;
	text-overflow: ellipsis;
    width: 150px;
    overflow: hidden;
}
.p{
	height:21px;
}
</style>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
function atras()
{
	paginacion('controller=Caja');
}
</script>



		
<div style="overflow:auto">

<div class="table-responsive">
<table class="table table-bordered table-striped">
	<tr>
		<td colspan="8" style="background:#428bca;color:#fff"><label class="col-md-12 control-label " for="selectbasic">COMPUTECNOLOGIA</label></td>
	</tr>
	<tr class="success">
		<td colspan="3" style="width: 40%;color:#3c763d">INGRESOS</td>
		<td colspan="5" style="width: 40%;color:#3c763d">EGRESOS</td>
	</tr>
	<tr>
		<td colspan="3">
			
				<table class="table table-bordered table-striped">
					<tr>
						<td colspan="2" style="background:#428bca;color:#fff">CAJA AL <?PHP echo validar_fecha($fecha_a);?></td>
						<td style="background:#428bca;color:#fff"><?PHP echo $monto_a;?></td>
					</tr>
					<tr>
						<td><label class="col-md-12 control-label " for="selectbasic">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
						<td><label class="col-md-12 control-label" for="selectbasic">DETALLE INGRESO</label></td>
						<td><label class="col-md-12 control-label " for="selectbasic">MONTO</label></td>
					</tr>
					
					<?php
					
						$total= 0; 
						$cont = 0;
						$dia = (int) $dia;
						for($i=$dia;$i<=$dia_max;$i++){
							
							
							//hacer consultado a la bd x cada dia del mes
							//obtener la cantidad de registros x dia
							// preguntar quien es mayor
							
							
							$count_ingresos = 0;
							$count_egresos = 0;
							
							IF($i<10){ $i='0'.$i;}
							
							
							$fecha_generada = "$anio-$mes-$i";
							// echo "$fecha_generada <br/>";					
							
							foreach ($ingresos as $val) {
								if(in_array($fecha_generada,$val)){
									$count_ingresos++;
								}
							}

							foreach ($egresos as $val) {
								if(in_array($fecha_generada,$val)){
									$count_egresos++;
								}
							}

							
							
							if($count_ingresos > $count_egresos){
								//generar normalmente la tabla en orden fecha / detalle / monto
								
								echo "<tr class='".$colores[$cont]."'>";
										echo "<td colspan='3'> $i DE $nombre_mes DEL $anio</td>";
								echo "</tr>";
								
							    
								
								//recorrer los registros por dia consultados
								foreach ($ingresos as $val) {
									if(in_array($fecha_generada,$val)){
										echo "<tr>";
										echo "<td>".validar_fecha($val[0])."</td>";
										echo "<td><p class='acortarx' data-toggle='tooltip' data-placement='top' title='".$val[1]."'>".$val[1]."</p></td>";
										echo "<td>".$val[2]."</td>";
										echo "</tr>";
										$total = $total + $val[2]; 
									}
								}
								
								echo "<tr>";
										echo "<td colspan='3'>&nbsp;</td>";
								echo "</tr>";
								
								$cont++;
								if($cont==4){$cont=0;}

							}else{
								//calcular la diferencia
								$dif = $count_egresos - $count_ingresos;
								//generar la tabla la tabla en orden fecha / detalle / monto
								
								echo "<tr class='".$colores[$cont]."'>";
										echo "<td colspan='3'> $i DE $nombre_mes DEL $anio</td>";
								echo "</tr>";
								
								
								
								
								
								//recorrer los registros por dia consultados
								foreach ($ingresos as $val) {
									if(in_array($fecha_generada,$val)){
										echo "<tr>";
										echo "<td>".validar_fecha($val[0])."</td>";
										echo "<td><p class='acortarx' data-toggle='tooltip' data-placement='top' title='".$val[1]."'>".$val[1]."</p></td>";
										echo "<td>".$val[2]."</td>";
										echo "</tr>";
										$total = $total + $val[2]; 
									}
								}
								//completar con celdas vacias la diferencia
								for($k=0;$k<$dif;$k++){
									echo "<tr>";
										echo "<td>&nbsp;</td>";
										echo "<td><p class='p'></p></td>";
										echo "<td>&nbsp;</td>";
									echo "</tr>";
								}
								
								echo "<tr>";
										echo "<td colspan='3'>&nbsp;</td>";
								echo "</tr>";

								$cont++;
								if($cont==4){$cont=0;}
								
							}
							
						
						}
					?>

				</table>
		</td>
		<td colspan="5">
					<table class="table table-bordered table-striped">
						<tr>
						<td colspan="5" style="background:#428bca;color:#fff">&nbsp;</td>
						</tr>
						<tr>
							<td><label class="col-md-12 control-label " for="selectbasic">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></td>
							<td><label class="col-md-12 control-label " for="selectbasic">DETALLE EGRESO</label></td>
							<td><label class="col-md-12 control-label " for="selectbasic">MONTO</label></td>
							<td><label class="col-md-12 control-label " for="selectbasic">OPERACI&Oacute;N</label></td>
							<td><label class="col-md-12 control-label " for="selectbasic">OBSERVACIONES</label></td>
						</tr>
						
					<?php
						
						$total_=0;
						$cont = 0;
						$dia = (int) $dia;
						
						for($i=$dia;$i<=$dia_max;$i++){
							
							
							
							
							//hacer consultado a la bd x cada dia del mes
							//obtener la cantidad de registros x dia
							// preguntar quien es mayor
							
							$count_ingresos = 0;
							$count_egresos = 0;
							
							IF($i<10){ $i='0'.$i;}
							
							$fecha_generada = "$anio-$mes-$i";
							// echo $fecha_generada.'<br/>';
							
							foreach ($ingresos as $val) {
								if(in_array($fecha_generada,$val)){
									$count_ingresos++;
								}
							}

							foreach ($egresos as $val) {
								if(in_array($fecha_generada,$val)){
									$count_egresos++;
								}
							}

							
							
							if($count_ingresos > $count_egresos){
								
								//calcular la diferencia
								$dif = $count_ingresos - $count_egresos;
								//generar la tabla la tabla en orden fecha / detalle / monto
								
								echo "<tr class='".$colores[$cont]."'>";
										echo "<td colspan='5'> $i DE $nombre_mes DEL $anio</td>";
								echo "</tr>";
								
								
								//recorrer los registros por dia consultados
								foreach ($egresos as $val) {
									if(in_array($fecha_generada,$val)){
										echo "<tr>";
										echo "<td>".validar_fecha($val[0])."</td>";
										echo "<td><p data-toggle='tooltip' data-placement='top' class='acortarx' title='".$val[1]."'>".$val[1]."</p></td>";
										echo "<td>".$val[2]."</td>";
										echo "<td><p class='acortar2x' data-toggle='tooltip' data-placement='top' title='".$val[3]."'>".$val[3]."</p></td>";
										echo "<td><p class='acortarx' data-toggle='tooltip' data-placement='top' title='".$val[4]."'>".$val[4]."</p></td>";
										echo "</tr>";
										 $total_ = $total_ + $val[2];
									}
								}
								//completar con celdas vacias la diferencia
								for($k=0;$k<$dif;$k++){
									echo "<tr>";
										echo "<td>&nbsp;</td>";
										echo "<td><p class='p'></p></td>";
										echo "<td>&nbsp;</td>";
										echo "<td>&nbsp;</td>";
										echo "<td>&nbsp;</td>";
									echo "</tr>";
								}
								
								echo "<tr>";
										echo "<td colspan='5'>&nbsp;</td>";
								echo "</tr>";
								
								$cont++;
								if($cont==4){$cont=0;}

							}else{
								
								//generar normalmente la tabla en orden fecha / detalle / monto
								
								echo "<tr class='".$colores[$cont]."'>";
										echo "<td colspan='5'> $i DE $nombre_mes DEL $anio</td>";
								echo "</tr>";
								
								//recorrer los registros por dia consultados
								foreach ($egresos as $val) {
									if(in_array($fecha_generada,$val)){
										echo "<tr>";
										echo "<td>".validar_fecha($val[0])."</td>";
										echo "<td><p class='acortarx' data-toggle='tooltip' data-placement='top' title='".$val[1]."'>".$val[1]."</p></td>";
										echo "<td>".$val[2]."</td>";
										echo "<td><p class='acortar2' data-toggle='tooltip' data-placement='top' title='".$val[3]."'>".$val[3]."</p></td>";
										echo "<td><p class='acortarx' data-toggle='tooltip' data-placement='top' title='".$val[4]."'>".$val[4]."</p></td>";
										echo "</tr>";
										$total_ = $total_ + $val[2];
									}
								}
								
								echo "<tr>";
										echo "<td colspan='5'>&nbsp;</td>";
								echo "</tr>";
								
								$cont++;
								if($cont==4){$cont=0;}
								
							}
							
							
						}
					?>
						
					</table>
		</td>
	</tr>
	<tr>
		<?php $total = $total + $monto_a; ?>
		<td colspan="2" style="width:390px"><label class="col-md-12 control-label text-right" for="selectbasic">TOTAL DE INGRESOS S/. </label></td>
		<td><?php echo number_format($total, 2, '.', ' ');?></td>
		<td style="width: 410px;"><label class="col-md-12 control-label text-right" for="selectbasic">TOTAL DE EGRESOS S/. </label></td>
		<td style="width: 100px;"><?php echo number_format($total_, 2, '.', ' '); ?></td>
		<td colspan="3"></td>
		
	</tr>
	<tr>
		<td colspan="2" style="width:390px"><label class="col-md-12 control-label text-right" for="selectbasic">TOTAL DE CAJA S/. </label></td>
		<td><?php $total_final = $total-$total_; echo number_format(($total_final), 2, '.', ' ');  ?> </td>
		<td style="width: 410px;"><label class="col-md-12 control-label text-right" for="selectbasic"></label></td>
		<td style="width: 100px;"></td>
		<td colspan="3"></td>
		
	</tr>
</table>

</div>
		<div class="form-group">
			<div class="col-md-12">
					<input type="button" name="regresar" id="regresar" value="Regresar"  onclick="atras();" class="btn btn-warning"/>
			</div>
		</div>
</div>

