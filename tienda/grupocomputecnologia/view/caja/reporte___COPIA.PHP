<?php function getMonthDays($Month, $Year)
{
   //Si la extensión que mencioné está instalada, usamos esa.
   if( is_callable("cal_days_in_month"))
   {
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
   }
   else
   {
      //Lo hacemos a mi manera.
      return date("d",mktime(0,0,0,$Month+1,0,$Year));
   }
}
//Obtenemos la cantidad de días que tiene septiembre del 2008
echo getMonthDays(8, 2015);?><?php require_once('lib/funciones.php'); ?>
<?php

header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=REPORTE_CAJA.xls");

?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>exportar a excel</title>
<style>
.title_excel{
font-size:16px;
font-weight:bold;
}
.title_excel2{
font-size:16px;
font-weight:bold;
color:#fff;
}
.title_excel3{
font-size:16px;
font-weight:bold;
}
.tr{
background:#4680df;
}
.cuerpo{
font-size:16px;
}
.total{
text-align:center;font-size:14px;font-weight:bold;
}

.detalle1{
background:#4680df;
}
.detalle2{
background:#33ff55;
}
</style>
</head>

<body>

<TABLE width='100%' cellpadding='3' cellspacing='3' align='center'>
<tr class='tr'>
	<td colspan='5' style='text-align:center' class='title_excel'>SISCOMP MOYOBAMBA <?php echo date('d-m-Y');?></td>
</tr>
<tr>
	<td colspan='5' style='text-align:left' class='title_excel'>De: Marden Delgado Altamirano</td>
</tr>
<tr class='tr'>
	<td style='text-align:center;width:100px;' class='title_excel2'>FECHA</td>
	<td style='text-align:center;width:300px;' class='title_excel2'>DETALLE INGRESO</td>
	<td style='text-align:center;width:150px;' class='title_excel2'>MONTO</td>
</tr>
<tr>
	<td style='text-align:center;width:100px;' class='title_excel3'>&nbsp;</td>
	<td style='text-align:center;width:300px;' class='title_excel3'>CAJA AL <?PHP echo validar_fecha($fecha_a).' '.$monto_a;?></td>
	<td style='text-align:center;width:150px;' class='title_excel3'>&nbsp;</td>
</tr>
</TABLE>
<!---  fecha / descripcion  / precio  --->
<TABLE width='100%' cellpadding='3' cellspacing='3' align='center'>

<tr class='tr'>
	<td colspan='3' style='text-align:left' class='title_excel'>INGRESOS</td>
</tr>
<?php $total= 0;$c=0;foreach ($ingresos as $key=>$val) { $c++; $total = $total + $val[2]; $dia_d = dia($val[0]); if($dia_d==$i){ $class='detalle1';}else{$class='$detalle2';$i++;}?>
<tr>
	<td style='text-align:left' class='cuerpo <?php $class;?>'><?php echo validar_fecha($val[0]);?></td>
	<td class='cuerpo'><?php echo strtoupper($val[1]);?></td>
	<td class='cuerpo'><?php echo $val[2];?></td>
</tr>
<?php } ?>
<tr>
	<td colspan='2'></td>
	<td style='text-align:right' class='total'>Total Ingresos: <?php echo $total;?></td>
</tr>
<tr class='tr'>
	<td colspan='3' style='text-align:left' class='title_excel'>EGRESOS</td>
</tr>
<?php $total_=0;$c=0;foreach ($egresos as $key=>$val) { $c++; $total_ = $total_ + $val[2];?>
<tr>
	<td style='text-align:left' class='cuerpo'><?php echo validar_fecha($val[0]);?></td>
	<td class='cuerpo'><?php echo strtoupper($val[1]);?></td>
	<td class='cuerpo'><?php echo $val[2];?></td>
</tr>
<?php } ?>
<tr>
	<td colspan='2'></td>
	<td style='text-align:right' class='total'>Total Egresos: <?php echo $total_;?></td>
</tr>
<tr>
	<td colspan='3'>&nbsp;</td>
</tr>
<tr>
	<td colspan='3' class='tr title_excel2'>Total Caja: <?php $total_final = $total-$total_; echo ($total_final+$monto_a); ?></td>
</tr>
</TABLE>

</body>

</html>