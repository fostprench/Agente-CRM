<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/proformas.php';
require_once 'model/Grid.php';
require_once('fpdf/proforma.php');
require_once('fpdf/fpdf.php');
require_once('lib/funciones.php');  
define('FPDF_FONTPATH','fpdf/font/');

class ProformasController extends Controller   
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new proformas();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_proformas');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_proformas",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Proformas&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(43);
	    $titulo=$_GET['controller'].' Registradas';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true,true);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();
		
    }
	
	public function create()
    {
		if($_SESSION['insertar']==1)
		{
			$obj = new proformas();
			$correlativo = $obj->contador_proformas();
			$correlativo++;			
			$num_proforma = $obj->formato_proforma($correlativo);		
			$data = array();
			$data['p']=1;
			$data['titulo']="REGISTRO DE PROFORMA";
			$data['correlativo'] = $num_proforma;
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/proformas/_frm.php');
            echo $view->renderPartial();
		}
		else
		{
			echo 
				"<script>alert('no tiene permiso para insertar');
				window.location='index.php';</script>";
		}
	}
	
	public function _edit() 
	{
		if($_SESSION['editar']==1)
		{	
			$obj = new proformas();
			$data = array();
			$data_proforma = $obj->datos_proforma($_GET['id']);
			$num_proforma = $obj->formato_proforma($data_proforma->idproformas);
			$cliente = $obj->cliente($data_proforma->idcliente);
			$detalle_proforma = $obj->datos_detalle($data_proforma->idproformas);
			$datella_general = $obj->proforma_general(); //FALTA 
			$detalle_otros= $obj->datos_otros($data_proforma->idproformas); 
			$detalle_obsequios= $obj->datos_obsequios($data_proforma->idproformas);
			
			
			$data['correlativo'] = $num_proforma;
			$data['obj'] = $data_proforma;
			$data['cliente'] = $cliente;
			$data['detalle_proforma'] = $detalle_proforma['obj'];
			$data['detalle_otros'] = $detalle_otros;
			$data['detalle_obsequios'] = $detalle_obsequios['obj'];
			$data['p']=2;
			$data['titulo']="EDITAR PROFORMA";
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/proformas/_frmedit.php' );
			echo $view->renderPartial();
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para editar');
			window.location='index.php';</script>";
		}
    }
	
	public function save()
    {
		$obj = new proformas();
		print_r(json_encode($obj->regproforma($_POST)));
	}
	
	public function delete_item(){
		$obj = new proformas();
		print_r(json_encode($obj->elimina_item($_GET)));
	}
	
	public function show()
	{
	    if($_SESSION['acceder']==1)
		{
			$obj = new proformas();
			$data = array();
			$data_proforma = $obj->datos_proforma($_GET['id']);
			$num_proforma = $obj->formato_proforma($data_proforma->idproformas);
			$usuario = $obj->usuario($data_proforma->idusuario);
			$cliente = $obj->cliente($data_proforma->idcliente);
			$datella_general = $obj->proforma_general();
			$detalle_proforma = $obj->datos_detalle($data_proforma->idproformas);			 
			$detalle_otros= $obj->datos_otros($data_proforma->idproformas); 
			$detalle_obsequios= $obj->datos_obsequios($data_proforma->idproformas);			
			
			$data['correlativo'] = $num_proforma;
			$data['obj'] = $data_proforma;
			$data['cliente'] = $cliente;
			$data['detalle_proforma'] = $detalle_proforma['obj'];
			$data['detalle_otros'] = $detalle_otros;
			$data['detalle_obsequios'] = $detalle_obsequios['obj'];
			$data['usuario'] = $usuario->nombres;
			$data['p']=2;
			$data['titulo']="VER PROFORMA";
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/proformas/_show.php' );
			echo $view->renderPartial();
		}
	}
   
	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new proformas();
			$c=$obj->deleteproforma($_GET['id']);
			echo json_encode(array('rep'=>'1','msg'=>'ELIMINADO'));
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para eliminar');
			window.location='index.php';</script>";
		}
    }

    public function devolver_proforma(){
		$obj = new proformas();
		$data_proforma = $obj->datos_proforma($_GET['id']);		
		$cliente = $obj->cliente($data_proforma->idcliente);
		$detalle_proforma = $obj->datos_detalle($data_proforma->idproformas);			 
		$detalle_otros= $obj->datos_otros($data_proforma->idproformas); 
		$detalle_obsequios= $obj->datos_obsequios($data_proforma->idproformas);	
		$data = array();	
		$data['cliente']=$cliente;
		$data['detalle_proforma'] = $detalle_proforma['obj'];
		$data['detalle_otros'] = $detalle_otros;
		$data['detalle_obsequios'] = $detalle_obsequios['obj'];
		$data['descuento_general'] = $data_proforma->descuento_general;
		$data['porcentajeGanancia'] = $data_proforma->descuento;
		print_r(json_encode($data));
	}
	
	
	public function _prinft()
	{
			$obj = new proformas();
			$data=array();
			
			$data_proforma = $obj->datos_proforma($_GET['id']);
			$num_proforma = $obj->formato_proforma($data_proforma->idproformas);
			$cliente = $obj->cliente($data_proforma->idcliente);
			$detalle_proforma = $obj->datos_detalle($data_proforma->idproformas);
			$datella_general = $obj->proforma_general(); //FALTA 
			$datella_otros= $obj->datos_otros($data_proforma->idproformas); 
			$datella_obsequios = $obj->datos_obsequios($data_proforma->idproformas);
			$lista_Bancos = $obj->listaBancos();
			
			$lista_obsequios = $datella_obsequios['obj'];
			$total_obsequios = $datella_obsequios['flag'];
			
			$lista_componentes = $detalle_proforma['obj'];
			$total_componentes = $detalle_proforma['total_pcs'];	
			
			$pdf = new PDF();
			$pdf->AliasNbPages();
			$pdf->AddPage();


			// Definir el ancho y alto del rectángulo
			$rectX = 140;
			$rectY = 8;
			$rectWidth = 50;
			// $rectHeight = 10;


			// Dibujar una barra en el medio
			$pdf->SetFillColor(0, 102, 204); // Azul
			$pdf->Rect($rectX, $rectY + 20, $rectWidth, 5, 'F'); // Rectángulo azul

			// Configurar la fuente para el texto "PROFORMA"
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetTextColor(255, 255, 255); // Color blanco para la barra
			$pdf->SetXY($rectX, $rectY + 20);
			$pdf->Cell($rectWidth, 5, "PRO-".$num_proforma, 0, 0, 'C');

			// Restaurar color para el texto siguiente
			$pdf->SetTextColor(0, 0, 0);

			
			$pdf->SetFont('Arial','B',9);
			$fila = 35;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($fila);
			$pdf->SetX(20);
			$pdf->Cell(50,5,html_entity_decode('SEÑOR(A)(ES): '),0,0,'L', 1);
			// $pdf->Cell(20,5,"PRO-".$num_proforma,0,0,'L', 1);
			$pdf->ln();
			$pdf->SetX(20);
			$pdf->Cell(175,5,strtoupper(utf8_decode($cliente->nombres)),0,0,'L', 1);
			$pdf->ln();
			$pdf->SetFont('Arial','',8);
			$pdf->SetX(20);
			$pdf->Cell(140,5,strtoupper(utf8_decode($cliente->direccion)),0,0,'L', 1);
			$pdf->Cell(20,5,"FECHA: ".fecha_venta($data_proforma->fecha_emision),0,0,'L', 1);
			$pdf->ln();
			$pdf->SetX(20);
			$pdf->Cell(140,5,"TELEFONO: ".$cliente->telefono,0,0,'L', 1);
			
			$pdf->ln();
			$pdf->SetFont('Arial','BIU',12);
			$pdf->ln();
			$pdf->SetX(20);
			$pdf->MultiCell(160,5,strtoupper(utf8_decode($data_proforma->descripcion)),0,'C', false);


			$porcentajeGanancia = $data_proforma->descuento;

			if($data_proforma->moneda=="1"){$moneda='S/';}else{$moneda='$/';}


			if($data_proforma->muestraprecios){

					$pdf->ln();
					$pdf->SetFont('Arial','B',8);
					$pdf->SetX(20);

					// Encabezado de la tabla
			        $pdf->SetFillColor(0, 102, 204); // Color azul
			        $pdf->SetTextColor(255, 255, 255); // Texto blanco

					
					$pdf->SetX(20);
					$pdf->Cell(10,7,"ITEM",1,0,'L', 1);
					$pdf->Cell(110,7,"PRODUCTO",1,0,'L', 1);
					$pdf->Cell(15,7,"CANT",1,0,'L', 1);
					$pdf->Cell(15,7,"P. UNIT",1,0,'L', 1);
					$pdf->Cell(20,7,"SUB TOTAL",1,0,'L', 1);


					$pdf->SetTextColor(0, 0, 0);
		        	$pdf->SetFillColor(255, 255, 255); // Color blanco

		        	/*
TIPO [0] PROCESADORES
DESC [1] PROC AMD ATHLON 3000G 3.50GHZ
INFO [2] Procesador AMD Athlon 3000G, 3.50GHz, 4MB L3 Cache...
IDPR [3] 4045
CANT [4] 1
MONT [5] 295.00
		        	*/


		        	$pdf->SetFont('Arial','',7);
		        	$CONT = 1;		
		        	$SUB_TOTAL = 0;	
					foreach($lista_componentes as $key => $val){

						$pdf->ln();
						$pdf->SetX(20);
						$pdf->Cell(10,4,$CONT,1,0,'C', 1);
						$pdf->Cell(110,4,strtoupper(html_entity_decode($val[1])),1,0,'L');
						$pdf->Cell(15,4,$val[4],1,0,'C', 1);
						$pdf->Cell(15,4,number_format(($val[5] / $val[4])*(1 + $porcentajeGanancia/100), 2, '.', ' '),1,0,'C', 1);
						$subTotal = $val[5]*(1 + $porcentajeGanancia/100);
						$pdf->Cell(20,4,number_format(($subTotal), 2, '.', ' ') ,1,0,'R', 1);
						// $pdf->Cell(20,4,"" ,0,0,'R', 1);
						$CONT++;		
						$SUB_TOTAL += $subTotal;
					
					}


					if(count($datella_otros) > 0){
						foreach($datella_otros as $key => $val){
							$pdf->ln();
							$pdf->SetX(20);
							$pdf->Cell(10,4,$CONT,1,0,'C', 1);
							$pdf->Cell(110,4,strtoupper(html_entity_decode($val[0]." - ".$val[1])),1,0,'L', 1);
							$pdf->Cell(15,4,$val[2],1,0,'C', 1);
							$pdf->Cell(15,4,$val[3],1,0,'C', 1);
							$subTotal = $val[2]*$val[3];
							$pdf->Cell(20,4,number_format(($subTotal), 2, '.', ' ') ,1,0,'R', 1);
							// $pdf->Cell(20,4,"" ,0,0,'R', 1);
							$CONT++;		
							$SUB_TOTAL += $subTotal;
						} 
					}

					$pdf->SetFont('Arial','B',8);
					$pdf->ln();
					$pdf->SetX(20);
					$pdf->Cell(150,5,"TOTAL $moneda" ,1,0,'R', 1);
					$pdf->Cell(20,5,number_format(($SUB_TOTAL), 2) ,1,0,'R', 1);

			}else{

					$pdf->ln();
					$pdf->SetFont('Arial','B',8);
					$pdf->SetX(20);

					// Encabezado de la tabla
			        $pdf->SetFillColor(0, 102, 204); // Color azul
			        $pdf->SetTextColor(255, 255, 255); // Texto blanco

					
					$pdf->SetX(20);
					$pdf->Cell(15,7,"CANT",1,0,'C', 1); 
					$pdf->Cell(150,7,"PRODUCTO",1,0,'C', 1);


					$pdf->SetTextColor(0, 0, 0);
		        	$pdf->SetFillColor(255, 255, 255); // Color blanco


		        	$pdf->SetFont('Arial','',7);	
					foreach($lista_componentes as $key => $val){

						$pdf->ln();
						$pdf->SetX(20);
						$pdf->Cell(15,4,$val[4],1,0,'C', 1);
						$pdf->Cell(150,4,strtoupper(html_entity_decode($val[1])),1,0,'L');					
					}

					if(count($datella_otros) > 0){
						foreach($datella_otros as $key => $val){
							$pdf->ln();
							$pdf->SetX(20);
							$pdf->Cell(15,4,$val[2],1,0,'C', 1); 
							$pdf->Cell(150,4,strtoupper(html_entity_decode($val[0]." - ".$val[1])),1,0,'L', 1);

						} 
					}

			}


			


			$pdf->SetFont('Arial','B',12);
			$pdf->ln();
			$pdf->ln();
			$pdf->SetX(20);

			$TOTAL_GENERAL = number_format($data_proforma->total_general,2);

			$pdf->Cell(160,4,"PRESUPUESTO TOTAL : $moneda $TOTAL_GENERAL",0,0,'L', 1);


			// // desde aqui
			
			
			

			if($total_componentes>0){//validar si existen componentes en la proforma
				
				$pdf->SetFont('Arial','B',9);
				$pdf->ln();
				$pdf->SetX(20);
				$pdf->Cell(160,4,"GARANTIA : ".strtoupper(utf8_decode($datella_general->garantia))." (Mantenimiento Preventivo: $data_proforma->mantenimiento Veces)",0,0,'L', 1);
				$pdf->ln();

			}

			$pdf->ln();

			if($total_obsequios>0){ // validar si se agrego obsequios a la proforma
				$pdf->SetX(20);$pdf->SetFont('Arial','B',8);
				$pdf->Cell(20,3,'OBSEQUIOS',0,0,'L');
				$pdf->Cell(2,3,":",0,0,'L');
				$pdf->SetFont('Arial','',8);
				
				foreach($lista_obsequios as $key => $val){
					if($key!=0){
						$pdf->Cell(32,4,'',0,0,'L');
						$pdf->Cell(150,4,strtoupper(utf8_decode($val[1])),0,0,'L');
					}else{ 
						$pdf->Cell(150,4,strtoupper(utf8_decode($val[1])),0,0,'L');
					}
					$pdf->ln();
				}
			}
			// $pdf->ln(); 


			$pdf->SetFont('Arial', 'B', 8);

			$pdf->ln();		
			$pdf->SetX(20);  
	        $pdf->Cell(100, 5, "CUENTAS BANCARIAS", 0, 0, 'L', 1);

	        $pdf->ln();		
			$pdf->SetX(20);  
	        $pdf->Cell(70, 5, "BANCO", 0, 0, 'L', 1);
	        $pdf->Cell(20, 5, "MONEDA", 0, 0, 'L', 1);
	        $pdf->Cell(40, 5, "NUMERO CUENTA", 0, 0, 'L', 1);
	        $pdf->Cell(40, 5, "CCI", 0, 0, 'L', 1);


			$pdf->SetFont('Arial','',7); 
			foreach($lista_Bancos as $key => $val){				
				$pdf->ln();		
				$pdf->SetX(20);
				$pdf->Cell(70, 5, mb_strtoupper($val['descripcion'], 'UTF-8'), 0, 0, 'L', 1); 
		        $pdf->Cell(20, 5, mb_strtoupper($val['moneda'], 'UTF-8'), 0, 0, 'L', 1);
		        $pdf->Cell(40, 5, mb_strtoupper($val['numerocuenta'], 'UTF-8'), 0, 0, 'L', 1);
		        $pdf->Cell(40, 5, mb_strtoupper($val['cci'], 'UTF-8'), 0, 0, 'L', 1);
			}
			
			
			$pdf->SetFont('Arial','',8);


			$pdf->ln(6);
			$pdf->SetX(20);
			$pdf->Cell(160,4,"PLAZO DE ENTREGA MAX. : ".strtoupper(utf8_decode($datella_general->entrega)),0,0,'L', 1);
			$pdf->ln();
			$pdf->SetX(20);
			$interval = abs((strtotime($data_proforma->fecha_emision) - strtotime($data_proforma->fecha_caducidad))/86400); 
			$pdf->Cell(160,4,"VALIDES DE LA OFERTA : ".$interval.' DIAS',0,0,'L', 1);
			$pdf->ln();
			$pdf->SetX(20);
			$pdf->Cell(160,4,"GARANTIA DE PROCESADOR, MEMORIAS, LCD'S, DISCOS DUROS : ".strtoupper(utf8_decode($datella_general->descripcion)),0,0,'L', 1);
			$pdf->ln(); 
			
			$pdf->SetFont('Arial','I',9);
			$pdf->ln(6);
			$pdf->SetX(20);
			$pdf->Cell(170,4,"!GRACIAS POR SU PREFERENCIA!",0,0,'C', 1);
			
			
			$pdf->Output();
		
	}
	
	public function _prinft_Nuevo()
	{
			$obj = new proformas();
			$data=array();
			
			$data_proforma = $obj->datos_proforma($_GET['id']);
			$num_proforma = $obj->formato_proforma($data_proforma->idproformas);
			$cliente = $obj->cliente($data_proforma->idcliente);
			$detalle_proforma = $obj->datos_detalle($data_proforma->idproformas);
			$datella_general = $obj->proforma_general(); //FALTA 
			$datella_otros= $obj->datos_otros($data_proforma->idproformas); 
			$datella_obsequios = $obj->datos_obsequios($data_proforma->idproformas);
			$lista_Bancos = $obj->listaBancos();
			
			$lista_obsequios = $datella_obsequios['obj'];
			$total_obsequios = $datella_obsequios['flag'];
			
			$lista_componentes = $detalle_proforma['obj'];
			$total_componentes = $detalle_proforma['total_pcs'];	
			
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
			$rectY = 10;
			$rectWidth = 70;
			$rectHeight = 40;

			// Dibujar el rectángulo
			$pdf->Rect($rectX, $rectY, $rectWidth, $rectHeight);

			// Configurar la fuente para el RUC
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetXY($rectX, $rectY + 5); // Ajustar posición
			$pdf->Cell($rectWidth, 10, 'RUC '.$_SESSION['ruc'], 0, 0, 'C');

			// Dibujar una barra en el medio
			$pdf->SetFillColor(0, 102, 204); // Azul
			$pdf->Rect($rectX, $rectY + 15, $rectWidth, 10, 'F'); // Rectángulo azul

			// Configurar la fuente para el texto "PROFORMA"
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetTextColor(255, 255, 255); // Color blanco para la barra
			$pdf->SetXY($rectX, $rectY + 15);
			$pdf->Cell($rectWidth, 10, 'PROFORMA', 0, 0, 'C');

			// Restaurar color para el texto siguiente
			$pdf->SetTextColor(0, 0, 0);

			// Configurar la fuente para el código "PRO - 2024 002971"
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetXY($rectX, $rectY + 25); // Ajustar posición
			$pdf->Cell($rectWidth, 10, 'PRO - '.$num_proforma, 0, 0, 'C');


			$pdf->SetXY(20,55);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(20, 5, html_entity_decode('SEÑOR(ES): '), 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(120, 5, strtoupper(html_entity_decode($cliente->nombres)), 0, 0, 'L');
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(30, 5, "FECHA: ".fecha_venta($data_proforma->fecha_emision), 0, 0, 'R');

			$pdf->ln();
	        // $pdf->SetFont('Arial', 'B', 8);
	        $pdf->SetX(20);
	        $pdf->Cell(20, 5, html_entity_decode('DIRECCIÓN: '), 0, 0, 'L');
	        $pdf->SetFont('Arial', '', 7);
	        $pdf->Cell(160, 5, strtoupper(html_entity_decode($cliente->direccion)), 0, 0, 'L');

	        $pdf->ln();
	        $pdf->SetFont('Arial', 'B', 8);
	        $pdf->SetX(20);
	        $pdf->Cell(20, 5, html_entity_decode('TELEFONO: '), 0, 0, 'L');
	        $pdf->SetFont('Arial', '', 7);
	        $pdf->Cell(160, 5, strtoupper(html_entity_decode($cliente->telefono)), 0, 0, 'L');

 

			// $pdf->SetFont('Arial','B',9);
			// $fila = 38;
			// $pdf->SetFillColor(255, 255, 255);
			// $pdf->SetY($fila);
			// $pdf->SetX(20);
			// $pdf->Cell(140,4,html_entity_decode('SEÑOR(A)(ES): '),0,0,'L', 1);
			// $pdf->Cell(20,4,$num_proforma,0,0,'L', 1);
			// $pdf->ln();
			// $pdf->SetX(20);
			// $pdf->Cell(160,4,strtoupper(utf8_decode($cliente->nombres)),0,0,'L', 1);
			// $pdf->ln();
			// $pdf->SetFont('Arial','',8);
			// $pdf->SetX(20);
			// $pdf->Cell(140,4,strtoupper(utf8_decode($cliente->direccion)),0,0,'L', 1);
			// $pdf->Cell(20,4,"FECHA: ".fecha_venta($data_proforma->fecha_emision),0,0,'L', 1);
			// $pdf->ln();
			// $pdf->SetX(20);
			// $pdf->Cell(140,4,"TELEFONO: ".$cliente->telefono,0,0,'L', 1);


			
			$pdf->ln(8);
			$pdf->SetFont('Arial','BIU',12);
			$pdf->SetX(20);
			$pdf->MultiCell(170,6,strtoupper(utf8_decode($data_proforma->descripcion)),0,'C', false);
			$pdf->ln();
			$pdf->SetFont('Arial','',8);
			$pdf->SetX(20);


			
			foreach($lista_componentes as $key => $val){

				$pdf->ln();
				$pdf->SetX(20);
				if($val[0]!='PROCESADORES'){ $tipo = $val[0];}else{ $tipo = "PROCESADOR"; }
				$pdf->SetFont('Arial','B',8);
				
				if($val[0]!='MOTHERBOARD' || $val[0]!='MOTHERBOARD Y PROCESADOR'){
					$pdf->Cell(40,3,strtoupper(utf8_decode($tipo)),0,0,'L');
					$pdf->Cell(2,3,":",0,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(145,3,strtoupper(utf8_decode($val[1])),0,0,'L');
				}else{
					$pdf->Cell(40,3,strtoupper(utf8_decode($tipo)),0,0,'L');
					$pdf->Cell(2,3,":",0,0,'L');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(145,3,strtoupper(utf8_decode($val[1])),0,0,'L');
					$pdf->ln();
					$pdf->Cell(52,3,'',0,0,'L');
					$pdf->MultiCell(140,3,strtoupper(utf8_decode($val[2])),0,'L', false);
				}
				
				$pdf->ln();			
			}

			$pdf->ln();
			
			// // desde aqui

			$pdf->SetTextColor(0, 0, 0);
	        $pdf->SetFillColor(255, 255, 255); // Color blanco
			
			
			if($data_proforma->moneda=="1"){$moneda='S/';}else{$moneda='$/';}

			if($total_componentes>0){//validar si existen componentes en la proforma
				
				$pdf->SetFont('Arial','B',9);
				$pdf->ln();
				$pdf->SetX(20);
				$pdf->Cell(160,4,"GARANTIA : ".strtoupper(utf8_decode($datella_general->garantia))." (Mantenimiento Preventivo: $data_proforma->mantenimiento Veces)",0,0,'L', 1);
				$pdf->ln();
				$pdf->ln();
				
				

				$pdf->SetFont('Arial','B',10);
				
				$pdf->SetX(20);
				$sum_t = number_format($data_proforma->total_proforma+$data_proforma->total_obsequio,2);
				$pdf->Cell(170,5,"PRECIO TOTAL ($data_proforma->cantidad) PC : $moneda $sum_t",0,0,'C',1);
			
			}
			//hasta aqui


			if(count($datella_otros) > 0){


			

			// 	// Fuente normal
			// $pdf->SetFont('Arial', '', 10);
			// $pdf->SetTextColor(0, 0, 0);
			 

				$pdf->SetFont('Arial','B',8);

				if($total_componentes>0){
			
					$pdf->ln(7);
					$pdf->SetX(20);
					$pdf->Cell(160,4,"OTROS : ",0,0,'L', 1);
					$pdf->ln();
				}

				// Encabezado de la tabla
		        $pdf->SetFillColor(0, 102, 204); // Color azul
		        $pdf->SetTextColor(255, 255, 255); // Texto blanco

				
				$pdf->SetX(20);
				$pdf->Cell(10,7,"ITEM",1,0,'L', 1);
				$pdf->Cell(110,7,"PRODUCTO",1,0,'L', 1);
				$pdf->Cell(15,7,"CANT",1,0,'L', 1);
				$pdf->Cell(15,7,"P. UNIT",1,0,'L', 1);
				$pdf->Cell(20,7,"SUB TOTAL",1,0,'L', 1);


				$pdf->SetTextColor(0, 0, 0);
	        	$pdf->SetFillColor(255, 255, 255); // Color blanco
				
				$pdf->SetFont('Arial','',7);
				$CONT = 1;
				foreach($datella_otros as $key => $val){
					$pdf->ln();$pdf->SetX(20);
					$pdf->Cell(10,4,$CONT,1,0,'C', 1);
					$pdf->Cell(110,4,strtoupper(utf8_decode($val[0]." - ".$val[1])),1,0,'L', 1);
					$pdf->Cell(15,4,$val[2],1,0,'C', 1);
					$pdf->Cell(15,4,$val[3],1,0,'C', 1);
					$pdf->Cell(20,4,number_format(($val[2]*$val[3]), 2, '.', ' ') ,1,0,'R', 1);
					// $pdf->Cell(20,4,"" ,0,0,'R', 1);
					$CONT++;			
				}
				
				$pdf->SetFont('Arial','B',12);
				$pdf->ln();
				$pdf->ln();
				$pdf->SetX(20);

				$TOTAL_GENERAL = number_format($data_proforma->total_general,2);

				$pdf->Cell(160,4,"PRESUPUESTO TOTAL : $moneda $TOTAL_GENERAL",0,0,'L', 1);
				
				$pdf->ln();
				$pdf->ln();
				
				if($total_obsequios>0){ // validar si se agrego obsequios a la proforma
					$pdf->SetX(20);$pdf->SetFont('Arial','B',8);
					$pdf->Cell(40,3,'OBSEQUIOS',0,0,'L');
					$pdf->Cell(2,3,":",0,0,'L');
					$pdf->SetFont('Arial','',8);
					
					foreach($lista_obsequios as $key => $val){
						if($key!=0){
							$pdf->Cell(52,3,'',0,0,'L');
							$pdf->Cell(145,3,strtoupper(utf8_decode($val[1])),0,0,'L');
						}else{
							$pdf->Cell(145,3,strtoupper(utf8_decode($val[1])),0,0,'L');
						}
						$pdf->ln();
					}
				}

			}

			// $pdf->SetFont('Arial','',8);
			// // $pdf->ln();
			// // $pdf->ln();
			// // $pdf->SetX(20);
			// // $pdf->MultiCell(160, 5, strtoupper(utf8_decode($datella_general->cheque)), 0, 'L', 0);

			

			$pdf->SetFont('Arial', 'B', 8);

			$pdf->ln();		
			$pdf->SetX(20);  
	        $pdf->Cell(100, 5, "CUENTAS BANCARIAS", 0, 0, 'L', 1);

	        $pdf->ln();		
			$pdf->SetX(20);  
	        $pdf->Cell(70, 5, "BANCO", 0, 0, 'L', 1);
	        $pdf->Cell(20, 5, "MONEDA", 0, 0, 'L', 1);
	        $pdf->Cell(40, 5, "NUMERO CUENTA", 0, 0, 'L', 1);
	        $pdf->Cell(40, 5, "CCI", 0, 0, 'L', 1);


			$pdf->SetFont('Arial','',7); 
			foreach($lista_Bancos as $key => $val){				
				$pdf->ln();		
				$pdf->SetX(20);
				$pdf->Cell(70, 5, mb_strtoupper($val['descripcion'], 'UTF-8'), 0, 0, 'L', 1); 
		        $pdf->Cell(20, 5, mb_strtoupper($val['moneda'], 'UTF-8'), 0, 0, 'L', 1);
		        $pdf->Cell(40, 5, mb_strtoupper($val['numerocuenta'], 'UTF-8'), 0, 0, 'L', 1);
		        $pdf->Cell(40, 5, mb_strtoupper($val['cci'], 'UTF-8'), 0, 0, 'L', 1);
			}



			$pdf->ln(10); 

 			$pdf->SetFont('Arial', '', 8);

			$pdf->SetX(20);
			$pdf->Cell(160,4,"PLAZO DE ENTREGA MAX. : ".strtoupper(utf8_decode($datella_general->entrega)),0,0,'L', 1);
			$pdf->ln();
			$pdf->SetX(20);
			$interval = abs((strtotime($data_proforma->fecha_emision) - strtotime($data_proforma->fecha_caducidad))/86400); 
			$pdf->Cell(160,4,"VALIDES DE LA OFERTA : ".$interval.' DIAS',0,0,'L', 1);
			$pdf->ln();
			$pdf->SetX(20);
			$pdf->Cell(160,4,"GARANTIA DE PROCESADOR, MEMORIAS, LCD'S, DISCOS DUROS : ".strtoupper(utf8_decode($datella_general->descripcion)),0,0,'L', 1);
			$pdf->ln(); 


		
			$pdf->SetFont('Arial','BI',9);
			$pdf->ln(); 
			$pdf->SetX(20);
			$pdf->Cell(170,4,$_SESSION['empresa'],0,0,'C', 1);
			$pdf->SetFont('Arial','B',8);
			$pdf->ln();
			$pdf->SetX(20);
			$pdf->Cell(170,4,strtoupper(utf8_decode($datella_general->mensaje)),0,0,'C', 1);
			
			
			
			
			$pdf->SetFont('Arial','I',9);
			$pdf->ln(10);
			$pdf->SetX(20);
			$pdf->Cell(170,4,"!GRACIAS POR SU PREFERENCIA!",0,0,'C', 1);
			
			
			
			
			
			$pdf->Output();
		
	}
	
	public function mostrar()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new proformas();
        $data = array();
		$cabecera=$obj->getHead('v_proformas');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_proformas",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Proformas&action=mostrar','query'=>$_GET['q']));
		$view = new View();
        $view->setData($data);
        $view->setTemplate('view/proformas/mostrar_proformas.php');
        echo $view->renderPartial();
    }

}
?>