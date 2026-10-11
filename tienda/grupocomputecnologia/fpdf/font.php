<?php

define('FPDF_FONTPATH','font/');
include("comunes2.php");


require_once '../model/reporte.php';
$reporte=  new reporte();
if(isset($_GET['tabla']))
{
 switch($_GET['tabla'])
 {
   
  case 'productos':
     $r=$reporte->getList("v_producto");
	 $header=$reporte->getHead("v_producto");
	 $title="LISTADO DE PRODUCTOS";
	 $w=array(15,120,35,18,50,50);
	 
  break;  
	
	case 'venta':
     $r=$reporte->getList("v_prestamo");
	 $header=$reporte->getHead("v_prestamo");
	 $title="LISTADO DE VENTAS";
	 $w=array(20,120,35,18,50,40);
   break; 
   
  case 'PlanCobro':
     $r=$reporte->getList("v_plancobro_d");
	 $header=$reporte->getHead("v_plancobro_d");
	 $title="LISTADO DE PLAN DE COBRO";
	 $w=array(10,120,35,18,50,56);
	 
  break; 

  case 'Tostado':
     $r=$reporte->getList("v_tostado");
	 $header=$reporte->getHead("v_tostado");
	 $title="LISTADO DE TOSTADO";
	 $w=array(15,120,35,18,50,40);
	 
  break;   
  
    case 'parcela':
     $r=$reporte->getList("v_parcela");
	 $header=$reporte->getHead("v_parcela");
	 $title="LISTADO DE REGISTROS DE PARCELAS";
	 $w=array(17,50,75,50,35,20,22);
  break;
  
   case 'productor':
     $r=$reporte->getList("v_productor");
	 $header=$reporte->getHead("v_productor");
	 $title="LISTADO DE PRODUCTORES";
	 $w=array(17,30,50,60,40,60,30);
  break;
 
 case 'historial_campo':
     $r=$reporte->getList("v_historial_campo");
	 $header=$reporte->getHead("v_historial_campo");
	 $title="LISTADO HISTORIAL DE CAMPO";
	 $w=array(20,70,70,65,20,20,20);
  break;
  
   case 'p_actividad':
     $r=$reporte->getList("v_p_actividad");
	 $header=$reporte->getHead("v_p_actividad");
	 $title="LISTADO ACTIVIDADES";
	 $w=array(20,75,55,45,50,20,25);
  break; 

  case 'compra':
     $r=$reporte->getList("v_compra");
	 $header=$reporte->getHead("v_compra");
	 $title="LISTADO COMPRAS";
	 $w=array(30,80,70,35,65);
  break;
  
    case 'acopio':
     $r=$reporte->getList("v_acopio");
	 $header=$reporte->getHead("v_acopio");
	 $title="LISTADO ACOPIO";
	 $w=array(30,105,70,40,40);
  break;  
  
  case 'cliente':
     $r=$reporte->getList("v_cliente");
	 $header=$reporte->getHead("v_cliente");
	 $title="LISTADO CLIENTES";
	 $w=array(30,30,88,88,35);
  break; 
  
   case 'comprainsumo':
     $r=$reporte->getList("v_comprainsumo");
	 $header=$reporte->getHead("v_comprainsumo");
	 $title="LISTADO COMPRA DE INSUMOS";
	 $w=array(30,100,30,20,35);
  break; 
  
    case 'Concepto':
     $r=$reporte->getList("v_cuentas");
	 $header=$reporte->getHead("v_cuentas");
	 $title="LISTADO DE HARINA";
	 $w=array(20,90,20,20,20);
     break;	 
	 
	 
     case 'proveedor':
     $r=$reporte->getList("v_proveedor");
	 $header=$reporte->getHead("v_proveedor");
	 $title="LISTADO DE PROVEEDORES";
	 $w=array(25,60,70,25,35,60);
    break;  

	case 'seleccion':
     $r=$reporte->getList("v_seleccion");
	 $header=$reporte->getHead("v_seleccion");
	 $title="LISTADO DE SELECCION";
	 $w=array(20,100,20,25,25,27,30,30);
    break;
	
	case 'secado':
     $r=$reporte->getList("v_secado");
	 $header=$reporte->getHead("v_secado");
	 $title="LISTADO DE SECADO";
	 $w=array(20,140,20,35,35,27);
    break;
	
	case 'descapsulado':
     $r=$reporte->getList("v_descapsulado");
	 $header=$reporte->getHead("v_descapsulado");
	 $title="LISTADO DE DESCAPSULADO";
	 $w=array(30,115,35,35,35,25);
    break;
	
	case 'destestado':
     $r=$reporte->getList("v_destestado");
	 $header=$reporte->getHead("v_destestado");
	 $title="LISTADO DE DESTESTADO";
	 $w=array(25,110,25,25,25,25,25,30);
     break;		
	 
	 case 'prefiltrado':
     $r=$reporte->getList("v_prefiltrado");
	 $header=$reporte->getHead("v_prefiltrado");
	 $title="LISTADO DE PREFILTRADO";
	 $w=array(25,30,120,35,35,25);
     break;	
	 
	 case 'prensado':
     $r=$reporte->getList("v_prensado");
	 $header=$reporte->getHead("v_prensado");
	 $title="LISTADO DE PRENSADO";
	 $w=array(20,90,20,20,20,20,20,20,20,20,20);
     break;	 	

	 case 'producto':
     $r=$reporte->getList("v_producto");
	 $header=$reporte->getHead("v_producto");
	 $title="LISTADO DE PRODUCTO";
	 $w=array(20,90,80,20,20,20,20);
     break;	 

	 case 'produccion':
     $r=$reporte->getList("v_produccion");
	 $header=$reporte->getHead("v_produccion");
	 $title="LISTADO DE PRODUCCION";
	 $w=array(20,90,80,20,20,20,20);
     break;	 	

	
	 
	 case 'almacen':
     $r=$reporte->getList("v_almacen");
	 $header=$reporte->getHead("v_almacen");
	 $title="LISTADO DE ALMACEN";
	 $w=array(25,150,40,40);
     break;	
	 

}

}else
{
exit(0);
}

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();

//Nombre del Listado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B','U',16);
$pdf->SetY(30);//mover al titulo en orientacion a Y
$pdf->SetX(120);//mover al titulo en orientacion a X
$pdf->MultiCell(100,7,$title,0,1,'C',false);//titulo
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
$pdf->SetX(5);
//Colores, ancho de lnea y fuente en negrita
$pdf->SetFillColor(154,228,174);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.2);
$pdf->SetFont('Arial','B',8);
//Cabecera

for($i=0;$i<count($header);$i++)
	$pdf->Cell($w[$i],5,$header[$i],1,0,'C',1);
	/* el 5 es para el ancho*/
    $pdf->Ln();
    $pdf->SetFont('Arial','',9);
foreach($r as $val)
 {
 $pdf->SetX(5);
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


