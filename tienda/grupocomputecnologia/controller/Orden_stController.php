<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/orden.php';
require_once 'model/Grid_orden.php';
require_once('lib/funciones.php');
require_once('fpdf/comunes2.php');
define('FPDF_FONTPATH','fpdf/font/');
class Orden_stController extends Controller   
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new orden();
	    $grilla= new  Grilla();
        $data = array();
		if($_SESSION['perfil']=='su'){$vista = "v_orden";}elseif($_SESSION['perfil']=='VENDEDOR'){$vista = "v_orden_secretaria";}else{$vista = "v_orden_tecnico";}
	   	$cabecera=$obj->getHead($vista);
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,$vista,$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Orden_st&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(34);
	    $titulo= 'ORDEN DE SERVICIO TECNICO REGISTRADOS';
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
			$obj = new orden();
			
			$num_orden=$obj->num_orden();
			
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
			
			$orden = $conc.($num_orden->total+1);
			
			$data = array();
			$data['p']=1;
			$data['num_orden']=$orden;
			$data['titulo']="ORDEN SERVICIO TECNICO";
			$data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>'0'));
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>'0'));
			$data['servicio'] = $this->Select_next(array('id'=>'idservicio','name'=>'idservicio','table'=>'v_servicio','code'=>'0'));
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/orden/_frm.php');
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
			$obj = new orden();
			$data = array();
			$_servicio = $obj->datos_s($_GET['id']);
			
			$num_orden=$_servicio->idorden_st;
			
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
			
			$data['obj'] = $_servicio;
			$data['fecha'] = fecha_time($_servicio->fecha);
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['num_orden']=$orden;
			$data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>$_servicio->idmarca));
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>$_servicio->idtipo));
			$data['servicio'] = $this->Select_next(array('id'=>'idservicio','name'=>'idservicio','table'=>'v_servicio','code'=>'0'));
			$data['p']=2;
			$data['titulo']="EDITAR ORDEN SERVICIO TECNICO";
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/orden/_frmedit.php' );
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
		$obj = new orden();
		print_r(json_encode($obj->regorden($_POST)));
	}
	
	public function delete_item_venta(){
		$obj = new orden();
		print_r(json_encode($obj->elimina_item_venta($_GET['idorden'])));
	}
	
	public function show()
	{
	    if($_SESSION['acceder']==1)
		{
			$obj = new orden();
			$data = array();
			$_servicio = $obj->datos_s($_GET['id']);
			
			$num_orden=$_servicio->idorden_st;
			
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
			
			$data['obj'] = $_servicio;
			$data['fecha'] = fecha_time($_servicio->fecha);
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['num_orden']=$orden;
			$data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>$_servicio->idmarca,'disabled'=>'disabled'));
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>$_servicio->idtipo,'disabled'=>'disabled'));
			$data['servicio'] = $this->Select_next(array('id'=>'idservicio','name'=>'idservicio','table'=>'v_servicio','code'=>'0'));
			$data['p']=2;
			$data['titulo']="ORDEN SERVICIO TECNICO";
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/orden/_show.php' );
			echo $view->renderPartial();
		}
	}
	
	public function orden_venta(){
		$obj = new orden();
		$_servicio = $obj->datos_s($_GET['id']);
		$detalle = $obj->datos_d($_GET['id']);
		$obj->cambia_Estado($_GET['id']);
		$data = array();	
		$data['obj']=$_servicio;
		$data['detalle'] = $detalle;
		print_r(json_encode($data));
	}
	
    	
	public function q1()
	{
	 print_r($_POST);
	
	}
   
	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new orden();
			$c=$obj->deleteorden($_GET['id']);
			echo json_encode(array('rep'=>'1','msg'=>'ELIMINADO'));
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para eliminar');
			window.location='index.php';</script>";
		}
    }
	
	public function mostrar()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new orden();
        $data = array();
		$cabecera=$obj->getHead('v_orden_secretaria');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_orden_secretaria",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Orden&action=mostrar','query'=>$_GET['q']));
		$view = new View();
        $view->setData($data);
        $view->setTemplate('view/orden/orden_ventas.php');
        echo $view->renderPartial();
    }

    public function _prinft(){

    		$obj = new orden();
			$_servicio = $obj->datos_s($_GET['id']);
			$num_orden=$_servicio->idorden_st;
			
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
			list($f,$time) = explode(" ",$_servicio->fecha);
			$fecha = fecha_es($f);
			list($n,$pa,$sa) = explode(" ",$_SESSION['usuario']);
			$detalle = $obj->datos_d($_GET['id']);
			$marca = $obj->marca($_servicio->idmarca);
			$tipo = $obj->tipo($_servicio->idtipo);



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
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor(255, 255, 255); // Color blanco para la barra
			$pdf->SetXY($rectX, $rectY + 15);
			$pdf->Cell($rectWidth, 10, html_entity_decode('ORDEN SERVICIO TÉCNICO'), 0, 0, 'C');

			// Restaurar color para el texto siguiente
			$pdf->SetTextColor(0, 0, 0);

			// Configurar la fuente para el código "PRO - 2024 002971"
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetXY($rectX, $rectY + 25); // Ajustar posición
			$pdf->Cell($rectWidth, 10, 'NRO - '.$orden, 0, 0, 'C');


			$pdf->SetXY(20,55);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(20, 5, html_entity_decode('SEÑOR(ES): '), 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(120, 5, strtoupper(utf8_decode($_servicio->nombres)), 0, 0, 'L');
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(30, 5, "FECHA: ".$fecha." ".$time, 0, 0, 'R');

			$pdf->ln();
	        // $pdf->SetFont('Arial', 'B', 8);
	        $pdf->SetX(20);
	        $pdf->Cell(20, 5, html_entity_decode('DIRECCIÓN: '), 0, 0, 'L');
	        $pdf->SetFont('Arial', '', 7);
	        $pdf->Cell(130, 5, strtoupper(html_entity_decode($_servicio->direccion)), 0, 0, 'L');
	        $pdf->SetFont('Arial', '', 7);
			$pdf->Cell(20, 5, "USUARIO: ".$n, 0, 0, 'R');

	        $pdf->ln();
	        $pdf->SetFont('Arial', 'B', 8);
	        $pdf->SetX(20);
	        $pdf->Cell(20, 5, html_entity_decode('TELEFONO: '), 0, 0, 'L');
	        $pdf->SetFont('Arial', '', 7);
	        $pdf->Cell(160, 5, strtoupper(html_entity_decode($_servicio->telefono)), 0, 0, 'L');



	        // NEXT

	        $pdf->SetFont('Arial','B',8);			
			
			// Encabezado de la tabla
	        $pdf->SetFillColor(0, 102, 204); // Color azul
	        $pdf->SetTextColor(255, 255, 255); // Texto blanco

	        $pdf->ln(7);
			$pdf->SetX(20);
			$pdf->Cell(170,6,html_entity_decode("EQUIPO EN REPARACIÓN: "),0,0,'L', 1);
			$pdf->ln();
			 

			$pdf->SetTextColor(0, 0, 0);
        	$pdf->SetFillColor(255, 255, 255); // Color blanco
			

			$pdf->SetX(20);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,html_entity_decode("CATEGORÍA"),1,0,'L', 1);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(65,5,html_entity_decode(strtoupper($tipo->descripcion)),1,0,'L', 1);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,utf8_decode("MARCA"),1,0,'L', 1);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(65,5,html_entity_decode(strtoupper($marca->descripcion)),1,0,'L', 1);

			$pdf->ln();
			$pdf->SetX(20);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,html_entity_decode("DESCRIPCIÓN"),1,0,'L', 1);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(150,5,html_entity_decode(strtoupper(($_servicio->desc_equipo))),1,0,'L', 1);


			// NEXT

			// Encabezado de la tabla
	        $pdf->SetFillColor(0, 102, 204); // Color azul
	        $pdf->SetTextColor(255, 255, 255); // Texto blanco

	        $pdf->SetFont('Arial','B',8);

	        $pdf->ln(7);
			$pdf->SetX(20);
			$pdf->Cell(170,6,html_entity_decode("OBSERVACIONES"),0,0,'L', 1);		
			 

			$pdf->SetTextColor(0, 0, 0);
        	$pdf->SetFillColor(255, 255, 255); // Color blanco
			
        	$pdf->ln();
			$pdf->SetX(20);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,("FALLA"),1,0,'L', 1);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(150,5,html_entity_decode(strtoupper($_servicio->desc_falla)),1,0,'L', 1);

			$pdf->ln();
			$pdf->SetX(20);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(20,5,("ACCESORIOS"),1,0,'L', 1);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(150,5,html_entity_decode(strtoupper($_servicio->accesorios)),1,0,'L', 1);


			// NEXT

			// Encabezado de la tabla
	        $pdf->SetFillColor(0, 102, 204); // Color azul
	        $pdf->SetTextColor(255, 255, 255); // Texto blanco

	        $pdf->SetFont('Arial','B',8);

	        $pdf->ln(7);
			$pdf->SetX(20);
			$pdf->Cell(170,6,html_entity_decode("SERVICIO"),0,0,'L', 1);
			$pdf->ln();
			 

			$pdf->SetTextColor(0, 0, 0);
        	$pdf->SetFillColor(255, 255, 255); // Color blanco
			

			$pdf->SetX(20);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(155,7,html_entity_decode("DESCRIPCIÓN"),1,0,'L', 1);
			$pdf->Cell(15,7,utf8_decode("PRECIO"),1,0,'C', 1);

			$pdf->SetFont('Arial','',7);

			$totalPagar = 0;	
			foreach($detalle as $key => $val){	$totalPagar = $totalPagar + $val[2]*$val[4];
				$pdf -> ln();	
				$pdf->SetX(20);				
				$pdf->Cell(155,5, html_entity_decode(strtoupper($val[1])),1, 0 , 'L' , 1);
				$pdf->Cell(15,5, number_format(($val[4]*$val[2]), 2, '.', ' '),1, 0 , 'R' , 1);
			}

			$pdf -> ln();
			$pdf->SetX(20);		
			$pdf->SetFont('Arial','B',8);		
			$pdf->Cell(155,5, "TOTAL A PAGAR",1, 0 , 'R' , 1);
			$pdf->Cell(15,5, number_format($totalPagar, 2, '.', ' '),1, 0 , 'R' , 1);

	

			$pdf -> ln(25);
			$pdf->SetX(20);
			$pdf->Cell(80,1,'--------------------------------------------------',0,0,'C', 1);
			$pdf->Cell(10,1,'',0,0,'C', 1);
			$pdf->Cell(80,1,'--------------------------------------------------',0,0,'C', 1);

			// $pdf->SetFont('Arial','',7);

			$pdf -> ln();
			$pdf->SetX(20);
			$pdf->Cell(80,7,'CLIENTE',0,0,'C', 1);
			$pdf->Cell(10,7,'',0,0,'C', 1);
			$pdf->Cell(80,7,'COMPUTECNOLOGIA',0,0,'C', 1);
			



			$pdf->Output();

    }
	
	// public function _prinft_2(){
		
	// 		$obj = new orden();
	// 		$_servicio = $obj->datos_s($_GET['id']);
	// 		$num_orden=$_servicio->idorden_st;
			
	// 		if($num_orden->total<9){
	// 			$conc = '00000';
	// 		}elseif($num_orden->total>8 && $num_orden->total<99){
	// 			$conc = '0000';
	// 		}elseif($num_orden->total>98 && $num_orden->total<999){
	// 			$conc = '000';
	// 		}elseif($num_orden->total>998 && $num_orden->total<9999){
	// 			$conc = '00';
	// 		}elseif($num_orden->total>9998 && $num_orden->total<99999){
	// 			$conc = '0';
	// 		}elseif($num_orden->total>99998 && $num_orden->total<999999){
	// 			$conc = '';
	// 		}
			
	// 		$orden = $conc.$num_orden;
	// 		list($f,$time) = explode(" ",$_servicio->fecha);
	// 		$fecha = fecha_es($f);
	// 		list($n,$pa,$sa) = explode(" ",$_SESSION['usuario']);
	// 		$detalle = $obj->datos_d($_GET['id']);
	// 		$marca = $obj->marca($_servicio->idmarca);
	// 		$tipo = $obj->tipo($_servicio->idtipo);
			
	// 		// if($_servicio->idcliente == 1){
	// 			$CLIENTE = " CLIENTE ";
	// 		// }else{
	// 			//$CLIENTE = $_servicio->nombres;
	// 		//}
			
			
			
	// 		$pdf = new PDF();
	// 		$pdf->AliasNbPages();
	// 		$pdf->AddPage();
			
			
	// 		$pdf->SetFont('Courier','',9);
	// 		$pdf->SetY(10);
	// 		$pdf->SetX(160);
	// 		$pdf->Cell(40,4,"Orden: ".$orden,0,0,'C',false);
	// 		$pdf->SetY(14);
	// 		$pdf->SetX(160);
	// 		$pdf->Cell(40,4,"Fecha: ".$fecha,0,0,'C',false);
	// 		$pdf->SetY(18);
	// 		$pdf->SetX(160);
	// 		$pdf->Cell(40,4,"Hora: ".$time,0,1,'C',false);
	// 		$pdf->SetY(22);
	// 		$pdf->SetX(160);
	// 		$pdf->Cell(40,4,"Usuario: ".$n,0,1,'C',false);
			
	// 		$pdf->SetFont('Courier','',10);
	// 		//$pdf->SetFont('Times','',10);
	// 		$fila = 32;
	// 		$pdf->SetFillColor(255, 255, 255);
	// 		$pdf->SetY($fila);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(100,4,'CLIENTE: '.strtoupper(utf8_decode($_servicio->nombres)),0,0,'L', 1);
			
			
	// 		$pdf->SetY($fila+4);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(100,4,'EQUIPO EN REPARACION: ',0,0,'L', 1);
						
	// 		$pdf->SetY($fila+8);
	// 		$pdf->SetX(11);
	// 		$pdf->Cell(43,0,'',1,0,'L', 1);
			
	// 		$pdf->SetY($fila+9);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(80,4,'Categoria: '.strtoupper($tipo->descripcion),0,0,'L', 1);
			
	// 		$pdf->SetY($fila+9);
	// 		$pdf->SetX(90);
	// 		$pdf->Cell(50,4,'Marca: '.strtoupper($marca->descripcion),0,0,'L', 1);
			
	// 		$pdf->SetY($fila+13);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(180,4,'Descripción: '.strtoupper(utf8_decode($_servicio->desc_equipo)),0,0,'L', 1);
			
	// 		$pdf->SetY($fila+19);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(100,4,'OBSERVACIONES: ',0,0,'L', 1);
						
	// 		$pdf->SetY($fila+23);
	// 		$pdf->SetX(11);
	// 		$pdf->Cell(28,0,'',1,0,'L', 1);
			
	// 		$pdf->SetY($fila+24);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(190,4,'Falla: '.strtoupper(utf8_decode($_servicio->desc_falla)),0,0,'L', 1);
			
	// 		$pdf->SetY($fila+28);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(190,4,'Accesorios: '.strtoupper(utf8_decode($_servicio->accesorios)),0,0,'L', 1);
			
	// 		$pdf->SetY($fila+34);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(100,4,'SERVICIO: ',0,0,'L', 1);
						
	// 		$pdf->SetY($fila+38);
	// 		$pdf->SetX(11);
	// 		$pdf->Cell(18,0,'',1,0,'L', 1);
			
	// 		$pdf->SetY($fila+39);
	// 		$pdf->SetX(11);
	// 		$pdf->Cell(15,1,'',0,0,'L', 1);
			
	// 		$pdf -> ln();
	// 		$TOTAL = 0;	$x=40;
	// 		foreach($detalle as $key => $val){	$TOTAL = $TOTAL + $val[2]*$val[4]; $x=$x+3;
	// 			$pdf->Cell(130,3, utf8_decode($val[1]),0, 0 , 'L' , 1);
	// 			$pdf->Cell(20,3, number_format(($val[4]*$val[2]), 2, '.', ' '),0, 0 , 'R' , 1);
	// 			$pdf -> ln();					
	// 		}

	// 		$x=$x+1;
	// 		$pdf->SetY($fila+$x);
	// 		$pdf->SetX(140);
	// 		$pdf->Cell(20,0,'',1,0,'C', 1);
			
	// 		$x=$x+1;
	// 		$pdf->SetY($fila+$x);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(130,4,'TOTAL:',0,0,'R', 1);
			
	// 		$pdf->SetY($fila+$x);
	// 		$pdf->SetX(140);
	// 		$pdf->Cell(20,4,number_format(($TOTAL), 2, '.', ' '),0,0,'R', 1);
			
			
			


	// 		$x=$x+22;
	// 		$pdf->SetY($fila+$x);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(90,1,'-----------------------------------',0,0,'C', 1);
			
	// 		$pdf->SetY($fila+$x+1);
	// 		$pdf->SetX(10);
	// 		$pdf->Cell(90,4,utf8_decode($CLIENTE),0,0,'C', 1);
			
			
	// 		$pdf->SetY($fila+$x);
	// 		$pdf->SetX(112);
	// 		$pdf->Cell(90,1,'-----------------------------------',0,0,'C', 1);
			
	// 		$pdf->SetY($fila+$x+1);
	// 		$pdf->SetX(112);
	// 		$pdf->Cell(90,4,'COMPUTECNOLOGIA',0,0,'C', 1);
			
	// 		// $pdf -> ln();
	// 		// $pdf->SetFont('Courier','',8);
	// 		// $pdf->Cell(185,3,'IMPORTANTE:',0, 0 , 'L' , 1);
	// 		// $pdf -> ln();
	// 		// $pdf -> MultiCell(185,2,'Los Presupuestos emitidos por Computecnologia, tienen una vigencia de 15 días calendario desde la fecha de emisión. Si durante el proceso de reparación se detectaran nuevas averías, las cuales por imposibilidad técnica no hubieran sido detectadas durante el diagnóstico inicial las mismas podrán ser objeto de presupuesto complementario, requiriendo por lo tanto nueva conformidad del cliente. La no aceptación del presupuesto complementario, no eximirá al cliente del pago de la intervención realizada por el primer presupuesto aceptado.
	// 		// ',0,'J',false);
	// 		// $pdf -> MultiCell(185,2,'Los equipos y componentes recibidos en Computecnologia para su Reparación y/o Diagnóstico, solamente serán guardados por un tiempo máximo de 3 meses, tiempo necesario para que el Cliente recoja su equipo y cancele la prestación del servicio, pasado ese tiempo Computecnologia no se responsabiliza del deterioro o pérdida del mismo, ya que los equipos en desuso guardados en almacén son donados a los centros de enseñanza de los institutos técnicos de la localidad.
	// 		// ',0,'J',false);
	// 		// $pdf -> MultiCell(185,2,'Computecnologia, solamente guarda los datos, el tiempo necesario para cumplir la finalidad del servicio técnico, su recogida o de su procedimiento posterior. Cumplida la prestacion de los servicios los datos personales serán destruidos, al igual que cualquier soporte o documento en que conste algún dato de carácter personal o cualquier tipo de información que se haya generado durante, para y/o por la prestación de servicios.',0,'J',false);
			
			
			
	// 		// $pdf -> ln();
			
	// 		$pdf->Output();
	
	// }

}
?>