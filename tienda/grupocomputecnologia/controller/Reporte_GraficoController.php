<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'lib/funciones.php';
require_once 'model/reporte_grafico.php';

class Reporte_GraficoController extends Controller 
{
	public function index()
    {
        $view = new View();
        $view->setTemplate('view/reporte/grafico/_frm.php');
        echo $view->renderPartial();
    }
	
	public function grafic_barras()
    {
		
		$obj = new reporte_grafico();
		
		$data = array();
		$xAxis = array();
		$series = array();
		$title = array();
		$subtitle = array();
		
		//El id son las opciones del combo para variar la elaboracion de los reportes		
		if($_POST['id']==1){
		
		
			$highcharts  = $obj->data_Caja();
			$combinacion = array();
			$combinacion['type'] = 'spline';
			$combinacion['name'] = 'Inicio Caja';
			//$combinacion['market']['lineWidth'] = 10;
			$enabled = false;//Acepta grafico 3D(true) o Grafico 2D(false)
			$series['name'] = 'Reporte de Caja';
			$title['text'] = 'REPORTE GRAFICO DE CAJA';
			$subtitle['text'] = 'Monto X caja aperturada';
			
			foreach($highcharts as $key => $val){
				$xAxis['categories'][] = fecha_venta($val[0]);
				$series['data'][] = $val[1];
				$combinacion['data'][] = $val[2];
			}
			
		}elseif($_POST['id']==2){
		
		
		//pueden cambiar la data para el proximo reporte X o Y
			$highcharts  = $obj->data_Caja();
			$combinacion = array();
			$combinacion['type'] = 'spline';
			$combinacion['name'] = 'Inicio';
			//$combinacion['market']['lineWidth'] = 10;
			$enabled = false;//Acepta grafico 3D(true) o Grafico 2D(false)
			$series['name'] = 'Ingreso de Soporte Tecnico';
			$title['text'] = 'REPORTE GRAFICO DE SOPORTE TECNICO';
			$subtitle['text'] = 'Total de Ingresos de Servicio de Soporte Tecnico';
			
			
			foreach($highcharts as $key => $val){
				if($val[4]=='0000-00-00'){$fecha_fin = date('Y-m-d');}else{$fecha_fin=$val[4];}
				$xAxis['categories'][] = fecha_venta($val[0]);
				$series['data'][] = $obj->soporte_tecnico($val[0],$fecha_fin);//$val[1];
				$combinacion['data'][] = 0;//$obj->soporte_tecnico($val[3]);
			}
			
			
		}else{
		//pueden cambiar la data para el proximo reporte X o Y
			$highcharts  = $obj->data_Caja();
			$combinacion = array();
			$combinacion['type'] = 'spline';
			$combinacion['name'] = 'Leyenda x';
			//$combinacion['market']['lineWidth'] = 10;
			$enabled = false;//Acepta grafico 3D(true) o Grafico 2D(false)
			$series['name'] = 'Leyenda x';
			$title['text'] = 'REPORTE GRAFICO';
			$subtitle['text'] = 'Cambiar data para el siguiente Reporte 3';
		}

		
		
		
		$data['enabled'] = json_encode($enabled, JSON_NUMERIC_CHECK);
		$data['title'] = json_encode($title, JSON_NUMERIC_CHECK);
		$data['subtitle'] = json_encode($subtitle, JSON_NUMERIC_CHECK);
		$data['xAxis'] = json_encode($xAxis, JSON_NUMERIC_CHECK);
		$data['series'] = json_encode($series, JSON_NUMERIC_CHECK);
		$data['combinacion'] = json_encode($combinacion, JSON_NUMERIC_CHECK);
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/grafico/caja_barras.php');
        echo $view->renderPartial();
    }
	
	public function grafic_torta()
    {
		$obj = new reporte_grafico();
		
		$data = array();
		$series = array();
		$title = array();
		$subtitle = array();
		
		if($_POST['id']==1){
			$highcharts  = $obj->data_Caja();
			//$enabled = true;//Acepta grafico 3D(true) o Grafico 2D(false)
			$title['text'] = 'REPORTE GRAFICO DE CAJA';
			$subtitle['text'] = 'Monto X caja aperturada';
			$series['type'] = 'pie';
			$series['name'] = 'Reporte de Caja';
			
			foreach($highcharts as $key => $val){
				$array = array();
				if($key==0){
				$array['name'] = fecha_venta($val[0]);
				$array['y'] = $val[1];
				$array['sliced'] = true;
				$array['selected'] = true;
				}else{
				$array[] = fecha_venta($val[0]);
				$array[] = $val[1];
				}
				$series['data'][] = $array;
			}
		
		
		}elseif($_POST['id']==2){
		
			$highcharts  = $obj->data_Caja();
			$series['name'] = 'Ingreso Soporte';
			$title['text'] = 'REPORTE GRAFICO DE SOPORTE TECNICO';
			$subtitle['text'] = 'Total de Ingresos de Soporte Tecnico';
			
			foreach($highcharts as $key => $val){
				$array = array();
				if($val[4]=='0000-00-00'){$fecha_fin = date('Y-m-d');}else{$fecha_fin=$val[4];}
				if($key==0){
				$array['name'] = fecha_venta($val[0]);
				$array['y'] = $obj->soporte_tecnico($val[0],$fecha_fin);
				$array['sliced'] = true;
				$array['selected'] = true;
				}else{
				$array[] = fecha_venta($val[0]);
				$array[] = $obj->soporte_tecnico($val[0],$fecha_fin);
				}
				$series['data'][] = $array;
			}
			
		}

		
		
		//$data['enabled'] = json_encode($enabled, JSON_NUMERIC_CHECK);
		$data['title'] = json_encode($title, JSON_NUMERIC_CHECK);
		$data['subtitle'] = json_encode($subtitle, JSON_NUMERIC_CHECK);
		$data['series'] = json_encode($series, JSON_NUMERIC_CHECK);
		
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/grafico/caja_torta.php');
        echo $view->renderPartial();
    }
	
	public function grafic_donus()
    {
		$obj = new reporte_grafico();
		
		$data = array();
		$series = array();
		$title = array();
		$subtitle = array();
		
		if($_POST['id']==1){
			$highcharts  = $obj->data_Caja();
			//$enabled = true;//Acepta grafico 3D(true) o Grafico 2D(false)
			$title['text'] = 'REPORTE GRAFICO DE CAJA';
			$subtitle['text'] = 'Monto por caja aperturada';
			$series['name'] = 'Reporte de Caja';
			
			foreach($highcharts as $key => $val){
				$array = array();
				if($key==0){
				$array['name'] = fecha_venta($val[0]);
				$array['y'] = $val[1];
				$array['sliced'] = true;
				$array['selected'] = true;
				}else{
				$array[] = fecha_venta($val[0]);
				$array[] = $val[1];
				}
				$series['data'][] = $array;
			}
		
		}elseif($_POST['id']==2){
		
			$highcharts  = $obj->data_Caja();
			//$enabled = true;//Acepta grafico 3D(true) o Grafico 2D(false)
			$title['text'] = 'REPORTE GRAFICO DE SOPORTE TECNICO';
			$subtitle['text'] = 'Total de Ingresos de Soporte Tecnico';
			$series['name'] = 'Ingreso Soporte';
			
			foreach($highcharts as $key => $val){
				$array = array();
				if($val[4]=='0000-00-00'){$fecha_fin = date('Y-m-d');}else{$fecha_fin=$val[4];}
				if($key==0){
				$array['name'] = fecha_venta($val[0]);
				$array['y'] = $obj->soporte_tecnico($val[0],$fecha_fin);
				$array['sliced'] = true;
				$array['selected'] = true;
				}else{
				$array[] = fecha_venta($val[0]);
				$array[] = $obj->soporte_tecnico($val[0],$fecha_fin);
				}
				$series['data'][] = $array;
			}
			
		}
		
		
		
        $data['title'] = json_encode($title, JSON_NUMERIC_CHECK);
		$data['subtitle'] = json_encode($subtitle, JSON_NUMERIC_CHECK);
		$data['series'] = json_encode($series, JSON_NUMERIC_CHECK);
		
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/grafico/caja_donus.php');
        echo $view->renderPartial();
    }
	
	
	public function caja_hoy(){
	
			$obj = new reporte();
			list($y,$m,$d) = split('[/.-]', $_GET['fecha']);
			$like = "%$y/%$m/%$d";
			$ingresos  = $obj->ingreso($like);
			$total_ingresos  = $obj->total_ingreso($like);
			$egresos = $obj->egreso($like);
			$total_egresos = $obj->total_egreso($like);
		
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(0);
			$pdf->Cell(297,5,'REPORTE DE CAJA DEL: '.fecha_venta($_GET['fecha']),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(113,5,'DETALLE DE INGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);
			$pdf->Cell(113,5,'DETALLE DE EGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);

		
			$cont_ingresos = count($ingresos);
			$cont_egresos = count($egresos);
			
			$pdf -> ln();
			
			if($cont_ingresos >= $cont_egresos){
				foreach($ingresos as $key => $val){
					
					$pdf->Cell(113,4, utf8_decode($val[0]),1, 0 , 'L' , 1);
					$pdf->Cell(25,4, utf8_decode($val[1]).' ',1, 0 , 'R' , 1);
					
					if($key<$cont_egresos){
					
						$pdf->Cell(113,4, utf8_decode($egresos[$key][0]),1, 0 , 'L' , 1);
						$pdf->Cell(25,4, utf8_decode($egresos[$key][1]).' ',1, 0 , 'R' , 1);
						
					}else{
						$pdf->Cell(113,4, ' ' ,1, 0 , 'L' , 1);
						$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
					}
					
					$pdf -> ln();
					
				}
				
			}else{
				foreach($egresos as $key => $val){
					
					if($key<$cont_ingresos){
					
						$pdf->Cell(113,4, utf8_decode($ingresos[$key][0]),1, 0 , 'L' , 1);
						$pdf->Cell(25,4, utf8_decode($ingresos[$key][1]).' ',1, 0 , 'R' , 1);
						
					}else{
					
						$pdf->Cell(113,4, ' ' ,1, 0 , 'L' , 1);
						$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
						
					}
					
					$pdf->Cell(113,4, utf8_decode($val[0]),1, 0 , 'L' , 1);
					$pdf->Cell(25,4, utf8_decode($val[1]).' ',1, 0 , 'R' , 1);
					
					
					$pdf -> ln();
										
				}
			}
			
			$pdf->Cell(113,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(113,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			$pdf->Cell(113,4,' TOTAL INGRESOS: ',1, 0 , 'R' , 1);
			$pdf->Cell(25,4, number_format(($total_ingresos->total), 2, '.', ' ') ,1, 0 , 'R' , 1);
			$pdf->Cell(113,4, ' TOTAL EGRESOS: ',1, 0 , 'R' , 1);
			$pdf->Cell(25,4,number_format(($total_egresos->total), 2, '.', ' ') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			$saldo_caja = $total_ingresos->total - $total_egresos->total;
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(276,6,' SALDO DE CAJA DEL '.fecha_venta($_GET['fecha']).' :   '.number_format(($saldo_caja), 2, '.', ' ') ,1, 0 , 'L' , 1);
			
			
			$pdf->Output();
    
	}
	
	public function inventario()
    {
        $view = new View();
        $view->setTemplate('view/reporte/inventario/_frm.php');
        echo $view->renderPartial();
    }
	
	public function inventario_pdf(){
			
			$obj = new reporte();
			$inventario  = $obj->inventario($_GET['order']);
		
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(0);
			$pdf->Cell(297,5, 'REPORTE DE INVENTARIO DE PRODUCTOS' ,0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(160,5,'PRODUCTO',1, 0 , 'C' , 1);
			$pdf->Cell(14,5,'STOCK',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'PRECIO COMPRA',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'PRECIO VENTA',1, 0 , 'C' , 1);

			$pdf -> ln();
				
			foreach($inventario as $key => $val){					
				$pdf->Cell(14,4, utf8_decode($val[0]),1, 0 , 'C' , 1);
				$pdf->Cell(160,4, utf8_decode($val[1]),1, 0 , 'L' , 1);
				$pdf->Cell(14,4, utf8_decode($val[2]),1, 0 , 'C' , 1);
				$pdf->Cell(30,4, utf8_decode($val[3]),1, 0 , 'R' , 1);
				$pdf->Cell(30,4, utf8_decode($val[4]),1, 0 , 'R' , 1);
				$pdf -> ln();					
			}
			
			
			$pdf->Output();
    
	}
	
	public function ventas()
    {
		$obj = new reporte();
		$combo_caja = $obj->apertura_caja();
		$data = array();
		$data['cajas_aperturadas'] = $combo_caja;
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/ventas/_frm.php');
        echo $view->renderPartial();
    }
	
	public function ventas_c_pdf(){
			
			$obj = new reporte();
			$data_venta  = $obj->data_venta_c($_GET['id']);
		
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(0);
			$pdf->Cell(297,5, 'REPORTE DE VENTAS AL CONTADO' ,0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(160,5,'CLIENTE',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'NRO. COMPROBANTE',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'FECHA VENTA',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'MONTO',1, 0 , 'C' , 1);

			$pdf -> ln();
			$TOTAL = 0;	
			foreach($data_venta as $key => $val){	$TOTAL = $TOTAL + $val[4];			
				$pdf->Cell(14,4, utf8_decode($val[0]),1, 0 , 'C' , 1);
				$pdf->Cell(160,4, utf8_decode($val[1]),1, 0 , 'L' , 1);
				$pdf->Cell(30,4, utf8_decode($val[2]),1, 0 , 'C' , 1);
				$pdf->Cell(30,4, utf8_decode($val[3]),1, 0 , 'R' , 1);
				$pdf->Cell(30,4, utf8_decode($val[4]),1, 0 , 'R' , 1);
				$pdf -> ln();					
			}
			
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(160,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(234,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(30,5,number_format(($TOTAL), 2, '.', ' ') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			
			$pdf->Output();
    
	}
	
	public function ventas_xc_pdf(){
			
			$obj = new reporte();
			
			if($_GET['id']==1){//facturas por cobrar activas
			$data_venta  = $obj->data_venta_xc();
			$title = "ACTIVAS";
			}else{//Todas las facturas por cobrar en general pagadas y por pagar
			$data_venta  = $obj->data_venta_xc_All();
			$title = "GENERAL PAGADAS Y/O POR PAGAR";
			}
			
		
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(0);
			$pdf->Cell(297,5, 'REPORTE DE VENTAS POR COBRAR '.$title ,0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(160,5,'CLIENTE',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'NRO. COMPROBANTE',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'FECHA VENTA',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'MONTO',1, 0 , 'C' , 1);

			$pdf -> ln();
			$TOTAL = 0;	
			foreach($data_venta as $key => $val){	$TOTAL = $TOTAL + $val[4];			
				$pdf->Cell(14,4, utf8_decode($val[0]),1, 0 , 'C' , 1);
				$pdf->Cell(160,4, utf8_decode($val[1]),1, 0 , 'L' , 1);
				$pdf->Cell(30,4, utf8_decode($val[2]),1, 0 , 'C' , 1);
				$pdf->Cell(30,4, utf8_decode($val[3]),1, 0 , 'R' , 1);
				$pdf->Cell(30,4, utf8_decode($val[4]),1, 0 , 'R' , 1);
				$pdf -> ln();					
			}
			
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(160,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(234,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(30,5,number_format(($TOTAL), 2, '.', ' ') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			
			$pdf->Output();
    
	}
	
	
}
?>

