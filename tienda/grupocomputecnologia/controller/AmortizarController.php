<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/amortizar.php';
require_once 'model/Grid.php';
require_once('lib/funciones.php');
require_once('fpdf/comunes3.php');

class AmortizarController extends Controller
{
	public function save()
    {
		$obj = new amortizar();
		print_r(json_encode($obj->newamortizar($_POST)));
	}
	
	public function show()
	{
	    $obj = new amortizar();
	    $data=array();
		$obj=$obj->edit($_GET['id']);
		$data['obj']=$obj;
		$data['ubigeo'] = $this->Select(array('id'=>'ubigeo','name'=>'ubigeo','table'=>'v_ubigeo_sanmartin','code'=>$obj->ubigeo));
		$data['titulo']="amortizar REGISTRADO";
		$data['p']=3;
		$view = new View();
	    $view->setData($data);
	    $view->setTemplate( 'view/amortizar/_frm.php' );
		echo $view->renderPartial();
	}
	
	public function delete_item()
    {  
			$obj = new amortizar();
			print_r(json_encode($obj->deleteamortizar($_GET)));
    }
	
	public function _prinft(){
		
			$obj = new amortizar();
			$idMovimiento = trim($_GET['idm']);
			$_movimiento = $obj->datos_m($idMovimiento);
			$totalVenta = $obj->datos_v($_movimiento->idventa);
			$saldo = $totalVenta->Total - $totalVenta->Pago;
			$_cliente_venta = $obj->datos_cliente($_movimiento->idventa);
			// $num_orden=$_GET['idm'];
			
			// if($num_orden->total<9){
			// 	$conc = '00000';
			// }elseif($num_orden->total>8 && $num_orden->total<99){
			// 	$conc = '0000';
			// }elseif($num_orden->total>98 && $num_orden->total<999){
			// 	$conc = '000';
			// }elseif($num_orden->total>998 && $num_orden->total<9999){
			// 	$conc = '00';
			// }elseif($num_orden->total>9998 && $num_orden->total<99999){
			// 	$conc = '0';
			// }elseif($num_orden->total>99998 && $num_orden->total<999999){
			// 	$conc = '';
			// }
			
			// $orden = $conc.$num_orden;
			list($f,$time) = explode(" ",$_movimiento->fecha);
			$fecha = fecha_es($f);
			list($n,$pa,$sa) = explode(" ",$_SESSION['usuario']);
			
			// if($_movimiento->idcliente == 1){
				$CLIENTE = " CLIENTE";
			// }else{
			// 	$CLIENTE = $_movimiento->cliente;
			// }
			
			
 
			$pdf = new FPDF('P','mm','A4');
			$pdf->SetAutoPageBreak(false);
			$pdf->AddPage();

			$pdf->Image("web/images/logo2.jpg", 20, 15, 55, '');
			$pdf->SetFont('helvetica','B',6);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetXY(20,36);
			$pdf->Cell(100,4,strtoupper(UTF8_DECODE($_SESSION['empresa'])),0,0,'L'); 
			$pdf->SetFont('helvetica','',6);
			$pdf->SetXY(20,40);
			$pdf->MultiCell(100, 4, strtoupper(UTF8_DECODE($_SESSION['descripcion'])), 0, 'L', 1);   
			$pdf->SetXY(20,44);
			$pdf->MultiCell(100, 4, strtoupper(UTF8_DECODE($_SESSION['direccion'])), 0, 'L', 1);
			$pdf->SetXY(20,48);
			$pdf->MultiCell(100, 4, strtoupper(UTF8_DECODE($_SESSION['telefono'])), 0, 'L', 1);


			// Definir el ancho y alto del rectángulo
			$rectX = 120;
			$rectY = 8;
			$rectWidth = 75;
			$rectHeight = 20;


			// Dibujar una barra en el medio
			$pdf->SetFillColor(0, 102, 204); // Azul
			$pdf->Rect($rectX, $rectY + 15, $rectWidth, 10, 'F'); // Rectángulo azul

			// Configurar la fuente para el texto "PROFORMA"
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetTextColor(255, 255, 255); // Color blanco para la barra
			$pdf->SetXY($rectX, $rectY + 15);
			$pdf->Cell($rectWidth, 10, 'RECIBO DE PAGO', 0, 0, 'C');

			// Restaurar color para el texto siguiente
			$pdf->SetTextColor(0, 0, 0);

			// Configurar la fuente para el código "PRO - 2024 002971"
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetXY($rectX, $rectY + 25); // Ajustar posición
			$pdf->Cell($rectWidth, 10, 'NRO. '.date("Y", strtotime($_movimiento->fecha)).'-'.$idMovimiento, 0, 0, 'C');


			$pdf->SetXY(160,44);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(15,4," Fecha: ",0,1,'R',false);
			$pdf->SetXY(175,44);
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(20,4,$fecha,0,1,'R',false);


			$pdf->SetXY(160,48);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(15,4," Usuario: ",0,1,'R',false);
			$pdf->SetXY(175,48);
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(20,4,$n,0,1,'R',false);


			$pdf->SetXY(20,55);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(20, 5, ('RECIBI DE: '), 0, 0, 'R');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(160, 5, strtoupper(utf8_decode($_cliente_venta->cliente)), 0, 0, 'L');


			$pdf->ln(); 
			$pdf->SetX(20);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(20, 5, ('LA SUMA DE: '), 0, 0, 'R');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(160, 5, $_movimiento->monto." (".converter($_movimiento->monto).")", 0, 0, 'L');

			$pdf->ln(); 
			$pdf->SetX(20);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(20, 5, ('CONCEPTO DE: '), 0, 0, 'R');
			$pdf->SetFont('Arial', '', 7);
			// $pdf->Cell(160, 5, strtoupper(utf8_decode($_movimiento->descripcion)), 1, 0, 'L');
			$pdf->MultiCell(155, 4, strtoupper(utf8_decode($_movimiento->descripcion)), 0, 'J', false);

			$pdf->ln(); 
			$pdf->SetX(20);
			$pdf->SetFont('Arial', 'I', 7);
			// $pdf->Cell(160, 5, strtoupper(utf8_decode($_movimiento->descripcion)), 1, 0, 'L');

			$observacion = strlen($_movimiento->observaciones) > 1 ? strtoupper(utf8_decode($_movimiento->observaciones)).' / SALDO POR PAGAR: '.number_format(($saldo), 2, '.', ' ') : 'SALDO POR PAGAR: '.number_format(($saldo), 2, '.', ' ');
			$pdf->MultiCell(175, 4, $observacion , 0, 'J', false);



			$pdf->SetFont('Arial', '', 8);

			$pdf->ln(18); 
			$pdf->SetX(40);
			$pdf->Cell(60,1,'--------------------------------------------------------',0,0,'C', false);
			$pdf->Cell(15,1,'',0,0,'C', false);
			$pdf->Cell(60,1,'--------------------------------------------------------',0,0,'C', false);


			$pdf->ln(); 
			$pdf->SetX(40);
			$pdf->Cell(60,4,'CLIENTE',0,0,'C', false);
			$pdf->Cell(15,4,'',0,0,'C', false);
			$pdf->Cell(60,4,'COMPUTECNOLOGIA',0,0,'C', false);			

			
			$pdf->Output('Recibo Provional.pdf','I');
			// MODO 'I'-> se entrega al navegador y se activa el plugin para mostrarlo
			// MODO 'D' -> se fuerza la descarga del archivo
	
	}


	public function _prinft_Anterior(){
		
			$obj = new amortizar();
			$_movimiento = $obj->datos_m($_GET['idm']);
			$totalVenta = $obj->datos_v($_movimiento->idventa);
			$saldo = $totalVenta->Total - $totalVenta->Pago;
			$_cliente_venta = $obj->datos_cliente($_movimiento->idventa);
			$num_orden=$_GET['idm'];
			
			if($num_orden->total<9){
				$conc = '00000';
			}elseif($num_orden->total>8 && $num_orden->total<99){
				$conc = '0000';
			}elseif($num_orden->total>98 && $num_orden->total<999){
				$conc = '000';
			}elseif($num_orden->total>998 && $num_orden->total<9999){
				$conc = '00';
			}elseif($num_orden->total>9998 && $num_orden->total<99999){
				$conc = '0';
			}elseif($num_orden->total>99998 && $num_orden->total<999999){
				$conc = '';
			}
			
			$orden = $conc.$num_orden;
			list($f,$time) = explode(" ",$_movimiento->fecha);
			$fecha = fecha_es($f);
			list($n,$pa,$sa) = explode(" ",$_SESSION['usuario']);
			
			if($_movimiento->idcliente == 1){
				$CLIENTE = " CLIENTE ";
			}else{
				$CLIENTE = $_movimiento->cliente;
			}
			
			
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();
			
			
			$pdf->SetFont('Courier','',9);
			$pdf->SetY(10);
			$pdf->SetX(160);
			$pdf->Cell(40,4,"Nº ".$orden,0,0,'C',false);
			$pdf->SetY(14);
			$pdf->SetX(160);
			$pdf->Cell(40,4,"Fecha: ".$fecha,0,0,'C',false);
			$pdf->SetY(18);
			$pdf->SetX(160);
			$pdf->Cell(40,4," Usuario: ".$n,0,1,'C',false);
			$pdf->SetY(22);
			$pdf->SetX(160);
			$pdf->Cell(40,4,"POR S/. ".$_movimiento->monto,0,1,'C',false);
			
			$pdf->SetFont('Courier','',10);
			//$pdf->SetFont('Times','',10);
			$fila = 32;
		
			$pdf->SetFillColor(91,98,160); 
			$pdf->SetTextColor(225,255,225);
			
			$pdf->SetY($fila);
			$pdf->SetX(10);
			$pdf->Cell(30,4,'RECIBÍ DE: ',0,0,'R', 1);
			
			$pdf->SetFillColor(227,233,236); 
			$pdf->SetTextColor(91,98,160);
			
			$pdf->SetY($fila);
			$pdf->SetX(45);
			$pdf->Cell(150,4,strtoupper(utf8_decode($_cliente_venta->cliente)),0,0,'L', true);
			
			$pdf->SetFillColor(91,98,160); 
			$pdf->SetTextColor(225,255,225);
			
			$pdf->SetXY(10,$fila+6);
			$pdf->Cell(30,4,'LA SUMA DE: ',0,0,'R', true);
			
			$pdf->SetFillColor(227,233,236); 
			$pdf->SetTextColor(91,98,160);
			
			$pdf->SetXY(45,$fila+6);
			$pdf->Cell(150,4,converter($_movimiento->monto),0,0,'L', true);
			
			
			
			
			$pdf->SetFillColor(91,98,160); 
			$pdf->SetTextColor(225,255,225);
			
			$pdf->SetXY(10,$fila+12);
			$pdf->Cell(30,4,'POR CONCEPTO DE: ',0,0,'R', true);
			
			$pdf->SetFillColor(227,233,236); 
			$pdf->SetTextColor(91,98,160);
			
			$pdf->SetXY(45,$fila+12);
			$pdf->Cell(150,4,strtoupper($_movimiento->descripcion),0,0,'L', true);
			
			$pdf->SetXY(10,$fila+18);
			$pdf->MultiCell(185,6,strtoupper(utf8_decode($_movimiento->observaciones)).' / SALDO POR PAGAR: '.number_format(($saldo), 2, '.', ' '),0,1,'L',true);
			
			
			$pdf->SetXY(10,$fila+36);
			$pdf->Cell(90,1,'-----------------------------',0,0,'C', false);
			
			$pdf->SetXY(10,$fila+38);
			$pdf->Cell(90,4,'CLIENTE',0,0,'C',false);
			
			$pdf->SetXY(112,$fila+36);
			$pdf->Cell(90,1,'-----------------------------',0,0,'C', false);
			
			$pdf->SetXY(112,$fila+38);
			$pdf->Cell(90,4,'COMPUTECNOLOGIA',0,0,'C',false);
			
			
			$pdf->Output('Recibo Provional.pdf','I');
			// MODO 'I'-> se entrega al navegador y se activa el plugin para mostrarlo
			// MODO 'D' -> se fuerza la descarga del archivo
	
	}

		
}
?>

