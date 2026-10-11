<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'lib/funciones.php';
require_once 'model/reporte.php';

require_once 'Excel/PHPExcel.php';

if($_GET['action']=='inventario_pdf' || $_GET['action']=='ventas_margenbruto_pdf' || ($_GET['action']=='reporte_general_negocio' && $_GET['tipo_r']==1) 
|| ($_GET['action']=='compras_pdf')	
){
	require_once('fpdf/comunes_Reporte_H.php');
}else{
	require_once('fpdf/comunes_Reporte_W.php');
}

//ini_set ('error_reporting', E_ALL);
class ReporteController extends Controller 
{
	public function caja()
    {
		$obj = new reporte();
		$combo_caja = $obj->apertura_caja();
		$data = array();
		$data['combo_mes'] = $combo_caja;
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/caja/_frm.php');
        echo $view->renderPartial();
    }
	
	public function reporte_negocio()
    {
		$obj = new reporte();
		$combo_caja = $obj->apertura_caja();
		$data = array();
		$data['combo_mes'] = $combo_caja;
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/reporte_negocio/_frm.php');
        echo $view->renderPartial();
    }
	
	public function caja_apertura(){
	
			$obj = new reporte();
			$apertura_caja_data  = $obj->CAJA_AL($_GET['id']);
			$ingresos  = $obj->ingreso_idcaja($_GET['id']);
			$total_ingresos  = $obj->total_ingreso_caja($_GET['id']);
			$egresos = $obj->egreso_idcaja($_GET['id']);
			$total_egresos = $obj->total_egreso_caja($_GET['id']);
			
		
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(60);
			$pdf->Cell(220,5,'REPORTE DE CAJA DEL: '.fecha_venta($apertura_caja_data->fecha),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(113,5,'DETALLE DE INGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);
			$pdf->Cell(113,5,'DETALLE DE EGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);

			$pdf -> ln();
			
			$pdf->Cell(113,5,'APERTURA DE CAJA ',1, 0 , 'R' , 1);
			$pdf->Cell(25,5,$apertura_caja_data->monto_a.' ',1, 0 , 'R' , 1);
			$pdf->Cell(138,5,'',1, 0 , 'C' , 1);
			
			
			$cont_ingresos = count($ingresos);
			$cont_egresos = count($egresos);
			
			$pdf -> ln();
			
			if($cont_ingresos >= $cont_egresos){
				foreach($ingresos as $key => $val){
					
					$pdf->Cell(113,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
					$pdf->Cell(25,4, utf8_decode($val[1]).' ',1, 0 , 'R' , 1);
					
					if($key<$cont_egresos){
					
						$pdf->Cell(113,4, strtoupper(utf8_decode($egresos[$key][0])),1, 0 , 'L' , 1);
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
					
						$pdf->Cell(113,4, strtoupper(utf8_decode($ingresos[$key][0])),1, 0 , 'L' , 1);
						$pdf->Cell(25,4, utf8_decode($ingresos[$key][1]).' ',1, 0 , 'R' , 1);
						
					}else{
					
						$pdf->Cell(113,4, ' ' ,1, 0 , 'L' , 1);
						$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
						
					}
					
					$pdf->Cell(113,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
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
			$ingreso_caja = $total_ingresos->total + $apertura_caja_data->monto_a;
			$pdf->Cell(25,4, number_format(($ingreso_caja), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(113,4, ' TOTAL EGRESOS: ',1, 0 , 'R' , 1);
			$pdf->Cell(25,4,number_format(($total_egresos->total), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			$saldo_caja_apertura = $ingreso_caja - $total_egresos->total;
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(276,6,' SALDO DE CAJA DEL '.fecha_venta($apertura_caja_data->fecha).' :   S/. '.number_format(($saldo_caja_apertura), 2, '.', '') ,1, 0 , 'L' , 1);			
			
			$pdf->Output();
			exit;
    
	}
	
	public function caja_rango(){
	
			$obj = new reporte();
			$ingresos  = $obj->ingreso_rango($_GET['fecha_inicio'],$_GET['fecha_fin']);
			$total_ingresos  = $obj->total_ingreso_rango($_GET['fecha_inicio'],$_GET['fecha_fin']);
			$egresos = $obj->egreso_rango($_GET['fecha_inicio'],$_GET['fecha_fin']);
			$total_egresos = $obj->total_egreso_rango($_GET['fecha_inicio'],$_GET['fecha_fin']);
			$saldo_caja = $obj->saldo_caja_inicio_fecha($_GET['fecha_inicio']);//saldo caja inicio fecha

			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(60);
			$pdf->Cell(220,5,'REPORTE DE CAJA DESDE: '.fecha_venta($_GET['fecha_inicio']).' HASTA '.fecha_venta($_GET['fecha_fin']),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(113,5,'DETALLE DE INGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);
			$pdf->Cell(113,5,'DETALLE DE EGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);
			
			$pdf -> ln();
			$pdf->Cell(113,5,'MONTO DE APERTURA DE CAJA AL '.$saldo_caja->fecha_a,1, 0 , 'R' , 1);
			$pdf->Cell(25,5,$saldo_caja->monto_a,1, 0 , 'R' , 1);
			$pdf->Cell(138,5,'',1, 0 , 'C' , 1);

		
			$cont_ingresos = count($ingresos);
			$cont_egresos = count($egresos);
			
			$pdf -> ln();
			
			if($cont_ingresos >= $cont_egresos){
				foreach($ingresos as $key => $val){
					
					$pdf->Cell(113,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
					$pdf->Cell(25,4, utf8_decode($val[1]).' ',1, 0 , 'R' , 1);
					
					if($key<$cont_egresos){
					
						$pdf->Cell(113,4, strtoupper(utf8_decode($egresos[$key][0])),1, 0 , 'L' , 1);
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
					
						$pdf->Cell(113,4, strtoupper(utf8_decode($ingresos[$key][0])),1, 0 , 'L' , 1);
						$pdf->Cell(25,4, utf8_decode($ingresos[$key][1]).' ',1, 0 , 'R' , 1);
						
					}else{
					
						$pdf->Cell(113,4, ' ' ,1, 0 , 'L' , 1);
						$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
						
					}
					
					$pdf->Cell(113,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
					$pdf->Cell(25,4, utf8_decode($val[1]).' ',1, 0 , 'R' , 1);
					
					
					$pdf -> ln();
										
				}
			}
			
			$pdf->Cell(113,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(113,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			$caja_ingresos = $saldo_caja->monto_a + $total_ingresos->total;
			$pdf->Cell(113,4,' TOTAL INGRESOS: ',1, 0 , 'R' , 1);
			$pdf->Cell(25,4, number_format(($caja_ingresos), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(113,4, ' TOTAL EGRESOS: ',1, 0 , 'R' , 1);
			$pdf->Cell(25,4,number_format(($total_egresos->total), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			$saldo_caja = $caja_ingresos - $total_egresos->total;
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(276,6,' SALDO DE CAJA DESDE '.fecha_venta($_GET['fecha_inicio']).' HASTA '.fecha_venta($_GET['fecha_fin']).' :  S/. '.number_format(($saldo_caja), 2, '.', '') ,1, 0 , 'L' , 1);
			
			
			$pdf->Output();
    
	}
	
	public function caja_hoy(){
	
			$obj = new reporte();
			list($y,$m,$d) = explode('-', $_GET['fecha']);
			$like = "%$y/%$m/%$d";
			$ingresos  = $obj->ingreso($like);
			$total_ingresos  = $obj->total_ingreso($like);
			$egresos = $obj->egreso($like);
			$total_egresos = $obj->total_egreso($like);
			$saldo_caja_hoy = $obj->saldo_caja_inicio_fecha($_GET['fecha']);//saldo caja inicio fecha
		
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(60);
			$pdf->Cell(220,5,'REPORTE DE CAJA DEL: '.fecha_venta($_GET['fecha']),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(113,5,'DETALLE DE INGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);
			$pdf->Cell(113,5,'DETALLE DE EGRESO',1, 0 , 'C' , 1);
			$pdf->Cell(25,5,'MONTO',1, 0 , 'C' , 1);
			
			$pdf -> ln();
			$pdf->Cell(113,5,'MONTO DE APERTURA DE CAJA AL '.$saldo_caja_hoy->fecha_a,1, 0 , 'R' , 1);
			$pdf->Cell(25,5,$saldo_caja_hoy->monto_a,1, 0 , 'R' , 1);
			$pdf->Cell(138,5,'',1, 0 , 'C' , 1);
		
			$cont_ingresos = count($ingresos);
			$cont_egresos = count($egresos);
			
			$pdf -> ln();
			
			if($cont_ingresos >= $cont_egresos){
				foreach($ingresos as $key => $val){
					
					$pdf->Cell(113,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
					$pdf->Cell(25,4, utf8_decode($val[1]).' ',1, 0 , 'R' , 1);
					
					if($key<$cont_egresos){
					
						$pdf->Cell(113,4, strtoupper(utf8_decode($egresos[$key][0])),1, 0 , 'L' , 1);
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
					
						$pdf->Cell(113,4, strtoupper(utf8_decode($ingresos[$key][0])),1, 0 , 'L' , 1);
						$pdf->Cell(25,4, utf8_decode($ingresos[$key][1]).' ',1, 0 , 'R' , 1);
						
					}else{
					
						$pdf->Cell(113,4, ' ' ,1, 0 , 'L' , 1);
						$pdf->Cell(25,4, ' ',1, 0 , 'R' , 1);
						
					}
					
					$pdf->Cell(113,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
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
			$INGRESOS_MAS_CAJA = $saldo_caja_hoy->monto_a + $total_ingresos->total;
			$pdf->Cell(25,4, number_format(($INGRESOS_MAS_CAJA), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(113,4, ' TOTAL EGRESOS: ',1, 0 , 'R' , 1);
			$pdf->Cell(25,4,number_format(($total_egresos->total), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			$saldo_total_caja = $INGRESOS_MAS_CAJA - $total_egresos->total;
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(276,6,' SALDO DE CAJA DEL '.fecha_venta($_GET['fecha']).' :   '.number_format(($saldo_total_caja), 2, '.', '') ,1, 0 , 'L' , 1);
			
			
			$pdf->Output();
    
	}
	
	public function inventario()
    {
        $view = new View();
        $view->setTemplate('view/reporte/inventario/_frm.php');
        echo $view->renderPartial();
    }
	
	public function ventas()
    {
		$obj = new reporte();
		$combo_caja = $obj->apertura_caja();
		$data = array();
		$data['cajas_aperturadas'] = $combo_caja;
		$data['cajas_aperturadas'] = $combo_caja;
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/ventas/_frm.php');
        echo $view->renderPartial();
    }
	
	public function soporte()
    {
        $obj = new reporte();
		$combo_caja = $obj->apertura_caja();
		$data = array();
		$data['cajas_aperturadas'] = $combo_caja;
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/soporte_tecnico/_frm.php');
        echo $view->renderPartial();
    }
	
	
	public function inventario_pdf(){
			
			$obj = new reporte();
			$inventario  = $obj->inventario($_GET['order']);
		
			$pdf = new PDF('P','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(60);
			$pdf->Cell(140,5, 'REPORTE DE INVENTARIO DE PRODUCTOS' ,0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			
			$pdf->SetXY(10, $fila + 8 );
			
			if($_GET['check']==0){
				$tamanio = 110;				
			}else{
				$tamanio = 140;		
			}
			
			
			$pdf->Cell(10,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell($tamanio,5,'PRODUCTO',1, 0 , 'C' , 1);
			$pdf->Cell(10,5,'STOCK',1, 0 , 'C' , 1);
			$pdf->Cell(15,5,'P.COMP',1, 0 , 'C' , 1);
			if($_GET['check']==0){$pdf->Cell(15,5,'P.VENT',1, 0 , 'C' , 1);}
			$pdf->Cell(15,5,'PTC',1, 0 , 'C' , 1);
			if($_GET['check']==0){$pdf->Cell(15,5,'PTV',1, 0 , 'C' , 1);}

			$pdf -> ln();
			
			// $precio_c = 0;
			$precio_v = 0;
			$precio_tc = 0;
			$precio_tv = 0;
			$cont_inv = 0;
			foreach($inventario as $key => $val){ // $precio_c = $precio_c + $val[3];
				$precio_v = $precio_v + $val[4];	$cont_inv ++;			
				$pdf->Cell(10,4, $cont_inv ,1, 0 , 'C' , 1);
				$pdf->Cell($tamanio,4, strtoupper(utf8_decode(substr(trim($val[1]), 0, 80))),1, 0 , 'L' , 1);
				$pdf->Cell(10,4, utf8_decode($val[2]),1, 0 , 'R' , 1);
				$pdf->Cell(15,4, ($val[3]),1, 0 , 'R' , 1);
				if($_GET['check']==0){$pdf->Cell(15,4, ($val[4]),1, 0 , 'R' , 1);}
				$precio_tc = $precio_tc + ($val[2]*$val[3]);
				$precio_tv = $precio_tv + ($val[2]*$val[4]);
				$pdf->Cell(15,4, number_format(($val[2]*$val[3]), 2, '.', ''),1, 0 , 'R' , 1);
				if($_GET['check']==0){$pdf->Cell(15,4, number_format(($val[2]*$val[4]), 2, '.', ''),1, 0 , 'R' , 1);}
				$pdf -> ln();					
			}
			
			$pdf->Cell(10,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell($tamanio,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(10,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(15,4, ' ',1, 0 , 'R' , 1);
			if($_GET['check']==0){$pdf->Cell(15,4, ' ',1, 0 , 'R' , 1);}
			$pdf->Cell(15,4, ' ',1, 0 , 'R' , 1);
			if($_GET['check']==0){$pdf->Cell(15,4, ' ',1, 0 , 'R' , 1);}
			$pdf -> ln();
			
			$sum_t = $tamanio + 10;
			$pdf->Cell($sum_t,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(25,5,'' ,1, 0 , 'R' , 1);
			if($_GET['check']==0){$pdf->Cell(15,5,'',1, 0 , 'R' , 1);}
			$pdf->Cell(15,5,number_format(($precio_tc), 2, '.', '') ,1, 0 , 'R' , 1);
			if($_GET['check']==0){$pdf->Cell(15,5,number_format(($precio_tv), 2, '.', '') ,1, 0 , 'R' , 1);}
			$pdf -> ln();
			
			if($_GET['check']==0){
			$pdf->Cell($sum_t,5,' GANANCIA APROXIMADA DE PRODUCTOS: ',1, 0 , 'R' , 1);
			$pdf->Cell(70,5,number_format(($precio_tv - $precio_tc), 2, '.', '') ,1, 0 , 'C' , 1);
			}
			
			$pdf->Output();
    
	}
	
	public function soporte_pdf(){
			
			$obj = new reporte();
			
			$CAJA_AL  = $obj->CAJA_AL($_GET['id']);
			if($CAJA_AL->fecha_c=='0000-00-00'){$fecha_fin = date('Y-m-d');}else{$fecha_fin=$CAJA_AL->fecha_c;}
			$ingreso_soporte  = $obj->ingreso_soporte_rango($CAJA_AL->fecha,$fecha_fin);
			
			$egresos_soporte = $obj->data_egresos_soporte($_GET['id']);
		
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(0);
			$pdf->Cell(297,5, 'REPORTE INGRESO SOPORTE TECNICO - CAJA AL: '.fecha_venta($CAJA_AL->fecha),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ITEM',1, 0 , 'C' , 1);
			$pdf->Cell(60,5,'SERVICIO',1, 0 , 'C' , 1);
			$pdf->Cell(80,5,'DESCRIPCION',1, 0 , 'C' , 1);
			$pdf->Cell(80,5,'CLIENTE',1, 0 , 'C' , 1);
			$pdf->Cell(15,5,'TOTAL',1, 0 , 'C' , 1);
			$pdf->Cell(22,5,'FECHA',1, 0 , 'C' , 1);

			$pdf -> ln();
			
			$Cont = 1; $TOTAL = 0;
			
			//$pdf->SetXY(20, $fila + 13);
			foreach($ingreso_soporte as $key => $val){	
				if($val[4]==1){ $cliente = ""; }else{ $cliente = $val[1];}
				$pdf->SetX(10);
				$pdf->Cell(14,4, $Cont ,1, 0 , 'C' , 1);
				$pdf->Cell(60,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
				$pdf->Cell(80,4, strtoupper(utf8_decode($val[5])),1, 0 , 'L' , 1);
				$pdf->Cell(80,4, strtoupper(utf8_decode(substr($cliente, 0, 60) )),1, 0 , 'L' , 1);
				$pdf->Cell(15,4, $val[2],1, 0 , 'R' , 1);
				$pdf->Cell(22,4, fecha_es($val[3]),1, 0 , 'C' , 1);
				$pdf -> ln();	
				$Cont++;	
				$TOTAL = $TOTAL + $val[2];			
			}
			
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(60,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(15,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(22,4, ' ',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(257,4,' EGRESOS SOPORTE',1, 0 , 'L' , 1);
			$pdf -> ln();
			
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(60,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(15,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(22,4, ' ',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			foreach($egresos_soporte as $key => $val2){	
				$pdf->SetX(10);
				$pdf->Cell(14,4, $Cont ,1, 0 , 'C' , 1);
				$pdf->Cell(220,4, strtoupper(utf8_decode($val2[0])),1, 0 , 'L' , 1);
				$pdf->Cell(15,4, '-'.$val2[1],1, 0 , 'R' , 1);
				$pdf->Cell(22,4, fecha_es($val2[2]),1, 0 , 'C' , 1);
				$pdf->Cell(22,4, "",0, 0 , 'C' , 1);
				$pdf -> ln();	
				$Cont++;	
				$TOTAL = $TOTAL - $val2[1];			
			}
			
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(60,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(15,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(22,4, ' ',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			$pdf->SetX(10);
			$pdf->Cell(234,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(15,5,number_format(($TOTAL), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(22,5,'',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			$pdf->Output();
    
	}
	
	public function soporte_pdf_rango(){
			
			$obj = new reporte();
			$ingreso_soporte  = $obj->ingreso_soporte_rango($_GET['fecha_inicio'],$_GET['fecha_fin']);
			$egresos_soporte = $obj->data_egresos_soporte_rango($_GET['fecha_inicio'],$_GET['fecha_fin']);
			
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(0);
			$pdf->Cell(297,5, 'REPORTE INGRESO SOPORTE TECNICO - DESDE '.fecha_venta($_GET['fecha_inicio']).' HASTA '.fecha_venta($_GET['fecha_fin']),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ITEM',1, 0 , 'C' , 1);
			$pdf->Cell(60,5,'SERVICIO',1, 0 , 'C' , 1);
			$pdf->Cell(80,5,'DESCRIPCION',1, 0 , 'C' , 1);
			$pdf->Cell(80,5,'CLIENTE',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'TOTAL',1, 0 , 'C' , 1);
			$pdf->Cell(22,5,'FECHA',1, 0 , 'C' , 1);

			$pdf -> ln();
			
			$Cont = 1; $TOTAL = 0;
			
			//$pdf->SetXY(20, $fila + 13);
			foreach($ingreso_soporte as $key => $val){	
				if($val[4]==1){ $cliente = ""; }else{ $cliente = $val[1];}
				$pdf->SetX(10);
				$pdf->Cell(14,4, $Cont ,1, 0 , 'C' , 1);
				$pdf->Cell(60,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
				$pdf->Cell(80,4, strtoupper(utf8_decode($val[5])),1, 0 , 'L' , 1);
				$pdf->Cell(80,4, strtoupper(utf8_decode($cliente)),1, 0 , 'L' , 1);
				$pdf->Cell(20,4, $val[2] ,1, 0 , 'R' , 1);
				$pdf->Cell(22,4, fecha_es($val[3]),1, 0 , 'C' , 1);
				$pdf -> ln();	
				$Cont++;	
				$TOTAL = $TOTAL + $val[2];			
			}
			
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(60,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(22,4, ' ',1, 0 , 'C' , 1);
			$pdf -> ln();
		
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(262,4,' EGRESOS SOPORTE',1, 0 , 'L' , 1);
			$pdf -> ln();
			
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(60,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(22,4, ' ',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			foreach($egresos_soporte as $key => $val2){	
				$pdf->SetX(10);
				$pdf->Cell(14,4, $Cont ,1, 0 , 'C' , 1);
				$pdf->Cell(220,4, strtoupper(utf8_decode($val2[0])),1, 0 , 'L' , 1);
				$pdf->Cell(20,4, '-'.$val2[1],1, 0 , 'R' , 1);
				$pdf->Cell(22,4, fecha_es($val2[2]),1, 0 , 'C' , 1);
				$pdf -> ln();	
				$Cont++;	
				$TOTAL = $TOTAL - $val2[1];			
			}
			
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(60,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(22,4, ' ',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			
			$pdf->SetX(10);
			$pdf->Cell(234,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(20,5,number_format(($TOTAL), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(22,5,'',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			$pdf->Output();
    
	}
	
	public function soporte_pdf_dia(){
			
			$obj = new reporte();
			$ingreso_soporte  = $obj->ingreso_soporte_dia($_GET['fecha_d']);
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(0);
			$pdf->Cell(297,5, 'REPORTE INGRESO SOPORTE TECNICO - '.fecha_venta($_GET['fecha_d']),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ITEM',1, 0 , 'C' , 1);
			$pdf->Cell(60,5,'SERVICIO',1, 0 , 'C' , 1);
			$pdf->Cell(80,5,'DESCRIPCION',1, 0 , 'C' , 1);
			$pdf->Cell(80,5,'CLIENTE',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'TOTAL',1, 0 , 'C' , 1);
			$pdf->Cell(22,5,'FECHA',1, 0 , 'C' , 1);

			$pdf -> ln();
			
			$Cont = 1; $TOTAL = 0;
			
			//$pdf->SetXY(20, $fila + 13);
			foreach($ingreso_soporte as $key => $val){
				if($val[4]==1){ $cliente = ""; }else{ $cliente = $val[1];}
				$pdf->SetX(10);
				$pdf->Cell(14,4, $Cont ,1, 0 , 'C' , 1);
				$pdf->Cell(60,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
				$pdf->Cell(80,4, strtoupper(utf8_decode($val[5])),1, 0 , 'L' , 1);
				$pdf->Cell(80,4, strtoupper(utf8_decode($cliente)),1, 0 , 'L' , 1);
				$pdf->Cell(20,4, utf8_decode($val[2]),1, 0 , 'R' , 1);
				$pdf->Cell(22,4, fecha_es($val[3]),1, 0 , 'C' , 1);
				$pdf -> ln();	
				$Cont++;	
				$TOTAL = $TOTAL + $val[2];			
			}
			$pdf->SetX(10);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(60,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(22,4, ' ',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			$pdf->SetX(10);
			$pdf->Cell(234,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(20,5,number_format(($TOTAL), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(22,5,'',1, 0 , 'C' , 1);
			$pdf -> ln();
			
			$pdf->Output();
    
	}
	
	
	
	public function ventas_c_pdf(){
			
			$obj = new reporte();
			$apertura_caja_  = $obj->Saldo_Apertura_caja($_GET['id']);
			$data_venta  = $obj->data_venta_c($_GET['id']);
			
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(60);
			$pdf->Cell(220,5, 'REPORTE GENERAL DE VENTAS' ,0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(140,5,'CLIENTE',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'TIPO',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'NRO. COMPROBANTE',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'FECHA VENTA',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'MONTO',1, 0 , 'C' , 1);
			
			$pdf->SetXY(10, $fila +12);
			$pdf->Cell(234,5,'APERTURA DE CAJA: ',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,$apertura_caja_,1, 0 , 'R' , 1);

			$pdf -> ln();
			$TOTAL = 0;	
			foreach($data_venta as $key => $val){	$TOTAL = $TOTAL + $val[4];
				if($val[1]=='ANONIMO'){ $cliente = ""; }else{ $cliente = $val[1];}
				if($val[6]=='0'){ $TIPO = "MC"; }elseIF($val[6]=='1'){ $TIPO = "BOL";}elseIF($val[6]=='2'){$TIPO = "FACT";}elseIF($val[6]=='3'){$TIPO = "SC";}
				$pdf->Cell(14,4, utf8_decode($val[0]),1, 0 , 'C' , 1);
				$pdf->Cell(140,4, strtoupper(utf8_decode($cliente)),1, 0 , 'L' , 1);
				$pdf->Cell(20,4, $TIPO,1, 0 , 'C' , 1);
				$pdf->Cell(30,4, utf8_decode($val[2]),1, 0 , 'C' , 1);
				$pdf->Cell(30,4, fecha_es($val[3]),1, 0 , 'R' , 1);
				$pdf->Cell(30,4, utf8_decode($val[4]),1, 0 , 'R' , 1);
				$pdf -> ln();					
			}
			
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(140,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(234,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(30,5,number_format(($TOTAL+$apertura_caja_), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			
			$pdf->Output();
    
	}
	
	
	public function ventas_margenbruto_pdf(){
			
			$obj = new reporte();
			$caja = $obj->CAJA_AL($_GET['id']);
			$data_venta  = $obj->data_venta_margenbruto($_GET['id']);
		
			
			$pdf = new PDF('P','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 26;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(15);
			$pdf->Cell(180,5, 'REPORTE DE VENTAS CAJA AL '.fecha_es($caja->fecha).' - MARGEN BRUTO DE GANACIA' ,0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(15, $fila + 8);
			$pdf->Cell(14,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'FECHA',1, 0 , 'C' , 1);
			$pdf->Cell(80,5,'PRODUCTO',1, 0 , 'C' , 1);
			$pdf->Cell(10,5,'CANT',1, 0 , 'C' , 1);
			$pdf->Cell(15,5,'P VENTA',1, 0 , 'C' , 1);
			$pdf->Cell(15,5,'P COSTO',1, 0 , 'C' , 1);
			$pdf->Cell(15,5,'GANANCIA',1, 0 , 'C' , 1);
			$pdf->Cell(10,5,'T',1, 0 , 'C' , 1);
			
			
			$pdf -> ln();
			$TOTAL_V = 0;	//total ventas
			$TOTAL_C = 0;	//total de costo
			$TOTAL_G = 0;	//total de ganancia
			$ITEM = 1;
			
			foreach($data_venta as $key => $val){	
				$TOTAL_V = $TOTAL_V + $val[2];	
				$SUB = $val[3]*$val[1];
				$TOTAL_C = $TOTAL_C + $SUB;	 
				$TOTAL_G = $TOTAL_G + $val[4];	 
				if($val[5]==1){$tipo = "C";}elseif($val[5]==2){$tipo = "VXC";}elseif($val[5]==3){$tipo = "VXP";}
				$pdf->SetX(15);
				$pdf->Cell(14,4,$ITEM,1, 0 , 'C' , 1);
				$pdf->Cell(20,4,fecha_es($val[6]),1, 0 , 'C' , 1);
				$pdf->Cell(80,4, strtoupper(utf8_decode($val[0])),1, 0 , 'L' , 1);
				$pdf->Cell(10,4,$val[1],1, 0 , 'C' , 1);
				$pdf->Cell(15,4,$val[2],1, 0 , 'R' , 1);
				$pdf->Cell(15,4,number_format(($SUB), 2, '.', ''),1, 0 , 'R' , 1);
				$pdf->Cell(15,4,$val[4],1, 0 , 'R' , 1);
				$pdf->Cell(10,4,$tipo,1, 0 , 'C' , 1);
				
				$pdf -> ln();	$ITEM++;				
			}
			$pdf->SetX(15);
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(80,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(10,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(15,4, 'P VENTA',1, 0 , 'R' , 1);
			$pdf->Cell(15,4, 'P COSTO',1, 0 , 'R' , 1);
			$pdf->Cell(15,4, 'GANANCIA',1, 0 , 'R' , 1);
			$pdf->Cell(10,4, ' ',1, 0 , 'R' , 1);
			
			$pdf -> ln();
			$pdf->SetX(15);
			$pdf->Cell(124,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(15,5,number_format(($TOTAL_V), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(15,5,number_format(($TOTAL_C), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(15,5,number_format(($TOTAL_G), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(10,5,'',1, 0 , 'R' , 1);
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
			$pdf->SetX(60);
			$pdf->Cell(220,5, 'REPORTE DE VENTAS POR COBRAR '.$title ,0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(10, $fila + 8);
			$pdf->Cell(14,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(100,5,'CLIENTE',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'NRO. COMPROBANTE',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'FECHA VENTA',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'MONTO',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'AMORT',1, 0 , 'C' , 1);
			$pdf->Cell(30,5,'SALDO',1, 0 , 'C' , 1);

			$pdf -> ln();
			$TOTAL = 0;	
			foreach($data_venta as $key => $val){	

				$subtotal = $val[4]-$val[5];
				$TOTAL = $TOTAL + $subtotal;	
				
				$pdf->Cell(14,4, utf8_decode($val[0]),1, 0 , 'C' , 1);
				$pdf->Cell(100,4, strtoupper(utf8_decode($val[1])),1, 0 , 'L' , 1);
				$pdf->Cell(30,4, utf8_decode($val[2]),1, 0 , 'C' , 1);
				$pdf->Cell(30,4, fecha_es($val[3]),1, 0 , 'R' , 1);
				$pdf->Cell(30,4, utf8_decode($val[4]),1, 0 , 'R' , 1);
				$pdf->Cell(30,4, number_format(($val[5]), 2, '.', ''),1, 0 , 'R' , 1);
				$pdf->Cell(30,4, number_format(($subtotal), 2, '.', ''),1, 0 , 'R' , 1);
				$pdf -> ln();					
			}
			
			$pdf->Cell(14,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(100,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(30,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(234,5,' TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(30,5,number_format(($TOTAL), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			
			$pdf->Output();
    
	}
	
	public function reporte_general_negocio(){
			
			$obj = new reporte();
			$caja = $obj->CAJA_AL($_GET['id']);
			
			IF($_GET['tipo_r']==1){$title='RESUMIDO';
						
			$control_caja  = $obj->reporte_general();
			
			$pdf = new PDF('P','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 29;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(40);
			$pdf->Cell(140,5, 'REPORTE '.$title.' DEL NEGOCIO - CAJA AL '.fecha_es($caja->fecha),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(50, $fila + 15 );
			$pdf->Cell(14,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(60,5,'DETALLE',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'INGRESOS',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'EGRESOS',1, 0 , 'C' , 1);

			$pdf -> ln();
			
			$total_i = $caja->monto_a;
			$total_e = 0;
			$idcaja = $_GET['id'];
			
			$pdf->SetX(50);
			$pdf->Cell(74,5,'INGRESO DE CAJA: ',1, 0 , 'R' , 1);
			$pdf->Cell(20,5,$caja->monto_a,1, 0 , 'R' , 1);
			$pdf->Cell(20,5,'',1, 0 , 'C' , 1);
			$pdf -> ln();
			$c = 1;
			foreach($control_caja as $key => $val){ 
				//$sumaXidcontrol = 0;
				$sumaXidcontrol = $obj->suma_total_movimientos($idcaja,$val[0]); //suma de movimientos activos x tipo de control
				$pdf->SetX(50);
				$pdf->Cell(14,4, $c,1, 0 , 'C' , 1);
				$pdf->Cell(60,4, $val[1],1, 0 , 'L' , 1);
				if($val[2]==1){
					$pdf->Cell(20,4, $sumaXidcontrol,1, 0 , 'R' , 1);
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$total_i = $total_i + $sumaXidcontrol;
				}else{
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$pdf->Cell(20,4, $sumaXidcontrol,1, 0 , 'R' , 1);
					$total_e = $total_e + $sumaXidcontrol;
				}
				$pdf -> ln();	
				$c++;
				
			}
			
			$pdf->SetX(50);
			$pdf->Cell(74,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			
			$pdf->SetX(50);
			$pdf->Cell(74,5,'SUB TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(20,5,number_format(($total_i), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(20,5,number_format(($total_e), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			$pdf->SetX(50);
			$pdf->Cell(74,5,'TOTAL CAJA: ',1, 0 , 'R' , 1);
			$pdf->Cell(40,5,number_format(($total_i - $total_e), 2, '.', '') ,1, 0 , 'C' , 1);
			
			}else{$title='DETALLADO';
			
			$control_caja  = $obj->reporte_general();
			
			$pdf = new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			
			$fila = 29;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(20);
			$pdf->Cell(244,5, 'REPORTE '.$title.' DEL NEGOCIO - CAJA AL '.fecha_es($caja->fecha),0,0,'C', 1);
			$pdf->SetFont('Courier', '', 8);
			
			$pdf->SetXY(20, $fila + 15 );
			$pdf->Cell(18,5,'ID',1, 0 , 'C' , 1);
			$pdf->Cell(150,5,'DETALLE',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'MONTO',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'INGRESOS',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'MONTO',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'EGRESOS',1, 0 , 'C' , 1);

			$pdf -> ln();
			
			$total_i = $caja->monto_a;
			$total_e = 0;
			$idcaja = $_GET['id'];
			
			$pdf->SetX(20);
			$pdf->Cell(168,5,'INGRESO DE CAJA: ',1, 0 , 'R' , 1);
			$pdf->Cell(20,5,'',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,$caja->monto_a,1, 0 , 'R' , 1);
			$pdf->Cell(20,5,'',1, 0 , 'C' , 1);
			$pdf->Cell(20,5,'',1, 0 , 'C' , 1);
			$pdf -> ln();
			$c = 1;
			foreach($control_caja as $key => $val){ 
				//$sumaXidcontrol = 0;
				$pdf->SetFillColor(227,233,236); 
				$pdf->SetTextColor(91,98,160);
				$sumaXidcontrol = $obj->suma_total_movimientos($idcaja,$val[0]); //suma de movimientos activos x tipo de control
				$pdf->SetX(20);
				$pdf->Cell(18,4, $c,1, 0 , 'C' , 1);
				$pdf->Cell(150,4, $val[1],1, 0 , 'L' , 1);
				if($val[2]==1){
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$pdf->Cell(20,4, $sumaXidcontrol,1, 0 , 'R' , 1);
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$total_i = $total_i + $sumaXidcontrol;
				}else{
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
					$pdf->Cell(20,4, $sumaXidcontrol,1, 0 , 'R' , 1);
					$total_e = $total_e + $sumaXidcontrol;
				}
				$pdf -> ln();	
				$c++;
				
	
				$movimientosXidcontrol = $obj->detalle_movimientoXidcontrol($idcaja,$val[0]);
				
				foreach($movimientosXidcontrol as $indice => $valor){ 
					$pdf->SetFillColor(255,255,255); 
					$pdf->SetTextColor(0,0,0);
					$pdf->SetX(20);
					$pdf->Cell(18,4,fecha_es($valor[2]),1, 0 , 'C' , 1);
					$pdf->Cell(150,4,strtoupper(utf8_decode($valor[0])),1, 0 , 'L' , 1);
					
					if($val[2]==1){					
						$pdf->Cell(20,4,$valor[1],1, 0 , 'R' , 1);
						$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
						$pdf->Cell(20,4, '',1, 0 , 'R' , 1);
						$pdf->Cell(20,4, '',1, 0 , 'R' , 1);					
					}else{
						$pdf->Cell(20,4,'',1, 0 , 'R' , 1);
						$pdf->Cell(20,4,'',1, 0 , 'R' , 1);
						$pdf->Cell(20,4,$valor[1],1, 0 , 'R' , 1);	
						$pdf->Cell(20,4,'',1, 0 , 'R' , 1);											
					}
					$pdf -> ln();
				}
				
				$pdf->SetX(20);
				$pdf->Cell(248,5,'',1, 0 , 'C' , 1);
				$pdf -> ln();
				
			}
			
			$pdf->SetX(20);
			$pdf->Cell(168,4,' ',1, 0 , 'L' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'L' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf->Cell(20,4, ' ',1, 0 , 'R' , 1);
			$pdf -> ln();
			
			$pdf->SetX(20);
			$pdf->Cell(168,5,'SUB TOTAL: ',1, 0 , 'R' , 1);
			$pdf->Cell(20,5,'' ,1, 0 , 'R' , 1);
			$pdf->Cell(20,5,number_format(($total_i), 2, '.', '') ,1, 0 , 'R' , 1);
			$pdf->Cell(20,5,'' ,1, 0 , 'R' , 1);
			$pdf->Cell(20,5,number_format(($total_e), 2, '.', ' ') ,1, 0 , 'R' , 1);
			$pdf -> ln();
			$pdf->SetX(20);
			$pdf->Cell(168,5,'TOTAL CAJA: ',1, 0 , 'R' , 1);
			$pdf->Cell(80,5,number_format(($total_i - $total_e), 2, '.', '') ,1, 0 , 'C' , 1);
			
	
			}
		
			$pdf->Output();
    
	}
	
	public function compras()
    {
		$obj = new reporte();
		$combo_caja = $obj->apertura_caja();
		$data = array();
		$data['combo_mes'] = $combo_caja;
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/reporte/compras/_frm.php');
        echo $view->renderPartial();
    }
	
	public function compras_pdf(){
		
		$desde = $_GET['fecha_inicio'];
		$hasta = $_GET['fecha_fin'];
		
		$valoresF1 = explode('-', $desde);
		$valoresF2 = explode('-', $desde);
		
		$validacionFecha = false;
		if(count($valoresF1) == 3){
			if(checkdate($valoresF1[1], $valoresF1[2], $valoresF1[0])){
				$validacionFecha = true;
			}
		}
		if(!$validacionFecha){
			echo "<script>alert('Error de Validación de fecha.');</script>"; 
			session_destroy();
			echo "<script>window.location='home.php';</script>";
			return;
		}
		if(count($valoresF2) == 3){
			if(checkdate($valoresF2[1], $valoresF2[2], $valoresF2[0])){
				$validacionFecha = true;
			}
		}
		if(!$validacionFecha){
			echo "<script>alert('Error de Validación de fecha.');</script>"; 
			session_destroy();
			echo"<script>window.location='home.php';</script>";
			return;
		}

		$obj = new reporte();
		$lista_compras  = $obj->reporte_compras($desde, $hasta);
		
		$pdf = new PDF('L','mm','A4');
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		
		$fila = 26;
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($fila);
		$pdf->SetX(60);
		$pdf->Cell(140,5, 'REPORTE DE COMPRAS DESDE '.fecha_venta($desde).' HASTA '.fecha_venta($hasta) ,0,0,'C', 1);
		$pdf->SetFont('Courier', '', 8);
		
		
		$pdf->SetXY(10, $fila + 8 );		

		$pdf->Cell(25,5,'RUC',1, 0 , 'C' , 1);
		$pdf->Cell(100,5,'PROVEEDOR',1, 0 , 'C' , 1);
		$pdf->Cell(30,5,'NRO.FACTURA',1, 0 , 'C' , 1);
		$pdf->Cell(20,5,'FECHA',1, 0 , 'C' , 1);
		$pdf->Cell(20,5,'MONEDA',1, 0 , 'C' , 1);
		$pdf->Cell(25,5,'TIPO CAMBIO',1, 0 , 'C' , 1);
		$pdf->Cell(25,5,'TOTAL FACT.',1, 0 , 'C' , 1);
		$pdf->Cell(25,5,'MONTO SOLES',1, 0 , 'C' , 1);

		$pdf -> ln();
		
		$total_factura = 0;
		$total_soles = 0;
		foreach($lista_compras as $key => $val){ 
			$total_factura = $total_factura + $val[7];
			$total_soles   = $total_soles   + $val[8];
			$pdf->Cell(25,5,$val[1],1, 0 , 'C' , 1);
			$pdf->Cell(100,5,strtoupper(utf8_decode($val[2])),1, 0 , 'L' , 1);
			$pdf->Cell(30,5,strtoupper(utf8_decode($val[3])),1, 0 , 'C' , 1);
			$pdf->Cell(20,5,fecha_venta($val[4]),1, 0 , 'C' , 1);
			$pdf->Cell(20,5,$val[5],1, 0 , 'C' , 1);
			$pdf->Cell(25,5,number_format(($val[6]), 2, '.', ','),1, 0 , 'R' , 1);
			
			$pdf->Cell(25,5,number_format(($val[7]), 2, '.', ','),1, 0 , 'R' , 1);
			$pdf->Cell(25,5,number_format(($val[8]), 2, '.', ','),1, 0 , 'R' , 1);
			$pdf -> ln();					
		}
		
		$pdf->SetFont('Courier', 'B', 8);
		
		$pdf->Cell(220,5,' TOTAL GENERAL: ',1, 0 , 'R' , 1);
		$pdf->Cell(25,5, number_format(($total_factura), 2, '.', ','),1, 0 , 'R' , 1);
		$pdf->Cell(25,5, number_format(($total_soles), 2, '.', ','),1, 0 , 'R' , 1);
		$pdf -> ln();
		
		$pdf->Output();
    
	}
	

	public function Style_Fila_EXCEL($BACKGROUND,$COLOR){
		$styleArray_excel = array(
							'font' => array(
								'bold' => true,
								'color'     => array(
									 'rgb' => $COLOR, 
								 ),
							),
							'alignment' => array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
								'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							),
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb' => $BACKGROUND),
							),
		);

		return $styleArray_excel;
	}

	public function compras_excel(){


		$desde = $_GET['fecha_inicio'];
		$hasta = $_GET['fecha_fin'];
		
		$valoresF1 = explode('-', $desde);
		$valoresF2 = explode('-', $desde);
		
		$validacionFecha = false;
		if(count($valoresF1) == 3){
			if(checkdate($valoresF1[1], $valoresF1[2], $valoresF1[0])){
				$validacionFecha = true;
			}
		}
		if(!$validacionFecha){
			echo "<script>alert('Error de Validación de fecha.');</script>"; 
			session_destroy();
			echo "<script>window.location='home.php';</script>";
			return;
		}
		if(count($valoresF2) == 3){
			if(checkdate($valoresF2[1], $valoresF2[2], $valoresF2[0])){
				$validacionFecha = true;
			}
		}
		if(!$validacionFecha){
			echo "<script>alert('Error de Validación de fecha.');</script>"; 
			session_destroy();
			echo"<script>window.location='home.php';</script>";
			return;
		}

		$obj = new reporte();
		$lista_compras  = $obj->reporte_compras($desde, $hasta);
		

		
		$Background = array("F2DEDE","DFF0D8","F9D6EE","D9EDF7","FCF8E3");
		$colores =    array("A94442","3C763D","DC6EB9","31708F",'8A6D3B');

		$TITLE = "REPORTE DE COMPRAS DESDE ".validar_fecha($desde)." HASTA ".validar_fecha($hasta);
		
	
		$objPHPExcel = new PHPExcel();
 
		$objPHPExcel->getActiveSheet()->setTitle('Reporte de Compras');
									 
		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);

		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		
		// Combinar celdar y dar fomato !centrado!
		$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// background a la celda combinada
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
																	->getStartColor()
																	->setRGB('1f5caa');
		// color al texto de la celda combinada															
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)
																//->setName('Verdana')
																->setSize(14)
																->getColor()->setRGB('FFFFFF');

		$objPHPExcel->getActiveSheet()->getCell('A1')->setValue($TITLE);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);


		$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setSize(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

		$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray(
				array(
					'font'    => array(
						'bold'      => true,
						'color' => array(
							'argb' => 'FFFFFF'
						),
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'borders' => array(
						'allborders'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)
					),
					'fill' => array(
						'type'       => PHPExcel_Style_Fill::FILL_SOLID,
						'rotation'   => 90,
						'color' => array(
							'argb' => '8E9E3C'
						),
					)
				)
		);
  
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'RUC');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'PROVEEDOR');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'NRO.FACTURA');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'FECHA');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'MONEDA');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'TIPO CAMBIO');
		$objPHPExcel->getActiveSheet()->setCellValue('G2', 'TOTAL FACT.');
		$objPHPExcel->getActiveSheet()->setCellValue('H2', 'MONTO SOLES');
		
		
		$CELL_FILA = 2;

		$total_factura = 0;
		$total_soles   = 0;
		foreach ($lista_compras as $key => $value) { 

			$CELL_FILA++;

			$total_factura = $total_factura + $value[7];
			$total_soles   = $total_soles   + $value[8];  

			$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", strtoupper(($value[1])));
			$objPHPExcel->getActiveSheet()->setCellValue("B$CELL_FILA", strtoupper(($value[2])));
			$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", strtoupper(($value[3])));
			$objPHPExcel->getActiveSheet()->setCellValue("D$CELL_FILA", fecha_venta($value[4]));
			$objPHPExcel->getActiveSheet()->setCellValue("E$CELL_FILA", $value[5]);
			$objPHPExcel->getActiveSheet()->setCellValue("F$CELL_FILA", $value[6]);
			$objPHPExcel->getActiveSheet()->setCellValue("G$CELL_FILA", number_format(($value[7]), 2, '.', ''));
			$objPHPExcel->getActiveSheet()->setCellValue("H$CELL_FILA", number_format(($value[8]), 2, '.', ''));
			
			
		}	

		
		$CELL_FILA++;// ?
		
		$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:F$CELL_FILA");
		$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", "TOTAL DE COMPRAS: ");
		$objPHPExcel->getActiveSheet()->setCellValue("G$CELL_FILA", $total_factura);
		$objPHPExcel->getActiveSheet()->setCellValue("H$CELL_FILA", $total_soles);
		$objPHPExcel->getActiveSheet()->getStyle("I$CELL_FILA:J$CELL_FILA")->getFont()->setSize(15);//celda ancha
		

		$objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->setAuthor("PHPExcel");
		$objPHPExcel->getActiveSheet()->getStyle("A$CELL_FILA:H$CELL_FILA")->applyFromArray(
				array(
					'font'    => array(
						'bold'      => true,
						'size'      => 9,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					)
				)
		);
		

		$BORDE = $CELL_FILA - 1;	
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				//outline
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle("A5:H$BORDE")->applyFromArray($styleThinBlackBorderOutline);
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace(__FILE__,'REPORTE.xlsx',__FILE__)); 

		
		// header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		$TITLE = "REPORTE DE COMPRAS DESDE ".validar_fecha($desde)." HASTA ".validar_fecha($hasta). ".xlsX";
		header("Content-Disposition: attachment;filename=$TITLE");
		header('Cache-Control: max-age=0');
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	}
	
	

}
?>