<?php

define('FPDF_FONTPATH','font/');
include("comunes.php");

require_once '../model/reporte.php';
$reporte=  new reporte();
if(isset($_GET['tabla']))
{
 switch($_GET['tabla'])
 {
  case 'Productos':
	 $r=$reporte->getList("v_producto");
	 $header=$reporte->getHead("v_producto");
	 $title="LISTADO DE PRODUCTOS ";
	 $w=array(12,44,23,113);
	 break;
  
  case 'Marca':
     $r=$reporte->getList("v_marca");
	 $header=$reporte->getHead("v_marca");
	 $title="LISTADO DE MARCAS";
	 $w=array(17,173);
  break; 
  
   case 'Proveedores':
     $r=$reporte->getList("v_proveedor");
	 $header=$reporte->getHead("v_proveedor");
	 $title="LISTADO DE PROVEEDORES";
	 $w=array(12,93,22,24,43);
     break;	 
	 
   case 'Compras':
     $r=$reporte->getList("v_compras_r");
	 $header=$reporte->getHead("v_compras_r");
	 $title="LISTADO DE COMPRAS";
	 $w=array(12,100,34,22,23);
     break;
	 
	case 'Venta':
     $r=$reporte->getList("v_venta");
	 $header=$reporte->getHead("v_venta");
	 $title="LISTADO DE VENTAS";
	 $w=array(12,100,34,22,23);
     break;
	 
	case 'Cliente':
     $r=$reporte->getList("v_cliente");
	 $header=$reporte->getHead("v_cliente");
	 $title="LISTADO DE CLIENTES";
	 $w=array(12,95,25,60);
     break;
	 
	 case 'Inventario':
     $r=$reporte->getList("v_inventario_p");
	 $header=$reporte->getHead("v_inventario_p");
	 $title="LISTADO DE PRODUCTOS - INVENTARIO";
	 $w=array(12,125,15,20,20);
     break;

  default:exit(0);
 }

}else
{
exit(0);
}

$pdf=new PDF();
$pdf->AddPage();

//Nombre del Listado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B','U',16);
$pdf->SetY(30);
$pdf->SetX(10);
$pdf->Cell(190,7,$title,1,1,'C',false);//titulo
$pdf->Cell(0,0.1,'',1,1,'C',false); //Titulo
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,5,'FECHA : '.date('d/m/Y'),0,1,'R',false); //Titulo
$pdf->SetY(37);
$pdf->Ln();    
//Restauracin de colores y fuentes
 $pdf->SetFillColor(224,235,255);
 $pdf->SetTextColor(0);
 $pdf->SetFont('Arial','B',7);
//Ttulos de las columnas
$pdf->SetX(10);
//Colores, ancho de lnea y fuente en negrita
$pdf->SetFillColor(154,228,174);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.2);
$pdf->SetFont('Arial','B',8);
//Cabecera

for($i=0;$i<count($header);$i++)
	$pdf->Cell($w[$i],5,html_entity_decode($header[$i]),1,0,'C',1);
	/* el 5 es para el ancho*/
    $pdf->Ln();
    $pdf->SetFont('Arial','',9);
foreach($r as $val)
 {
 $pdf->SetX(10);
   foreach($header as $key=>$c)
   {
     $pdf->Cell($w[$key],5,$val[$key],'LRTB',0,'L');
   }
  $pdf->Ln();
 }
 
$pdf->Output();

?> 

<?php
include("log.php");
?>


