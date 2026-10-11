<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/ventasxcobrar.php';
require_once 'model/Grid_fact.php';
require_once('fpdf/fpdf.php');
require_once('lib/funciones.php');

class BoletasController extends Controller   
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new ventasxcobrar();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_boletas');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_boletas",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Boletas&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(48);
	    $titulo=$_GET['controller'].' Registradas';
	    $data['grilla'] = $grilla->asign($titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true,true);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
		$view->setLayout('template/Layout.php');
        echo $view->renderPartial();
       //$view->render();
    }
	public function amortizar(){
		$obj = new ventasxcobrar();
		$data = array();
		$data['mensaje'] = true;
		$data["titulo"] = "DATOS GENERALES DEL COMPROBANTE";
		$data['idventasxcobrar']=$_GET['id'];
		$data['obj'] = $obj->datos_v($_GET['id']);;    
		$data['total_amortizacion'] = $obj->total_amortizacion($_GET['id']); 
		$data['detalle_amortizaciones'] = $obj->datos_amortizaciones($_GET['id']);
		$data['detalle'] = $obj->detalle_amortizaciones($_GET['id']);		
		$data['JS'] = 'boletas_Atras.js';
		$view = new View();
		$view->setData($data);
		$view->setTemplate( 'view/ventasxcobrar/_frmVerAmortizaFact.php' );
		echo $view->renderPartial();
	}
	
	public function show()
	{
	    if($_SESSION['acceder']==1)
		{
			$obj = new ventasxcobrar();
			$data = array();
			$_venta = $obj->datos_v($_GET['id']);
			$data['obj'] = $_venta;
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['p']=2;
			$data['titulo']="VENTA REGISTRADA";
			$data['tipo_c'] = $this->Select(array('id'=>'tipo_c','name'=>'tipo_c','table'=>'tipo_comprobante','code'=>$_venta->tipo_c));
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/venta/_show.php' );
			echo $view->renderPartial();
		}
	}
	
	
		public function _prinft(){
	
		$obj = new ventasxcobrar();
	    $data=array();

		$datos_venta = $obj -> datos_v($_GET['id']);
		
		$detalle_venta = $obj -> datos_d($_GET['id']);
		
		$series = $obj->lista_series($_GET['id']);

		$total = count($detalle_venta);
		
		$pdf = new FPDF('P','mm','A4');
		$pdf->SetAutoPageBreak(false);
		$pdf->AddPage();
		
		if($datos_venta->tipo_c == 2){		
			
		$pdf->SetFont('helvetica','',8);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetXY(15,51);
		$pdf->Cell(170,4,strtoupper(UTF8_DECODE($datos_venta->cliente)),0,'J',false);		
		
		$pdf->SetXY(19,57);
		$pdf->Cell(170,4,strtoupper(UTF8_DECODE($datos_venta->direccion)),0,'J',false);
		
		$pdf->SetXY(16,63);
		$pdf->Cell(120,4,strtoupper(UTF8_DECODE($datos_venta->ruc)),0,'J',false);
		$pdf->Cell(28,4,fecha_venta($datos_venta->fecha),0,0,'C');

		$i = 72;
		foreach($detalle_venta as $key => $val){
		$pdf->SetXY(5,$i);
		
		if($val[3]<=9){$cant="0$val[3]";}else{$cant=$val[3];}
		
		$pdf->Cell(13,5,$cant,0,0,'C');
		$pdf->Cell(119,5,strtoupper(UTF8_DECODE($val[1])),0,0,'L',0);
		$pdf->Cell(18,5,$val[2],0,0,'R',1);
		$pdf->Cell(18,5,$val[4],0,0,'R',1);
		$i = $i+4;
		}
		
		if(count($series)>0){
			$data="";
			foreach($series as $key => $val){
				$data .= $val[0].' ';
			}
			$pdf->SetXY(25,$i);
			$pdf -> MultiCell(135,4,'SERIES. '.strtoupper($data),0,'J',false);
		}
		
		$pdf->SetXY(75,151);
		$pdf->Cell(24,5,fecha_venta($datos_venta->fecha),0,0,'C');
		
		
		$pdf->SetXY(17,134);
		$pdf->Cell(123,5,converter($datos_venta->total),0,0,'L');
		
		$pdf->SetFont('helvetica','B',9);
		
		$pdf->SetXY(155,135);
		$pdf->Cell(20,5,$datos_venta->total,0,0,'C');
		
		$pdf->SetXY(155,142);
		$pdf->Cell(20,5,"0.00",0,0,'C');
		
		$pdf->SetXY(155,149);
		$pdf->Cell(20,5,$datos_venta->total,0,0,'C');
		
		}else{
			
			// $pdf->Image("web/images/fact.jpg",0,0,null,225);
			
			$nro = $datos_venta->nro_comprobante;
			list($a,$b) = explode('-',$nro);
			
			$pdf->SetFillColor(255, 255, 255);
			
			// $pdf->SetXY(152,24);
			// $pdf->Cell(35,8,strtoupper(UTF8_DECODE($b)),0,'J',false);
			
			
			$pdf->SetFont('helvetica','',8);
			$pdf->SetFillColor(255, 255, 255);
			
			
			$pdf->SetXY(19,47);//46
			$pdf->Cell(132,4,strtoupper(UTF8_DECODE($datos_venta->cliente)),0,'J',false);	
			$pdf->Cell(27,4,strtoupper(UTF8_DECODE($datos_venta->ruc)),0,'J',false);			
			
			$pdf->SetXY(22,53);//52
			$pdf->Cell(129,4,strtoupper(UTF8_DECODE($datos_venta->direccion)),0,'J',false);
			$pdf->Cell(27,4,fecha_venta($datos_venta->fecha),0,0,'L');
			

			$i = 63;
			foreach($detalle_venta as $key => $val){
			$pdf->SetXY(6,$i);
			
			if($val[3]<=9){$cant="0$val[3]";}else{$cant=$val[3];}
			
			$pdf->Cell(11,5,$cant,0,0,'C');
			$pdf->Cell(121,5,strtoupper(UTF8_DECODE($val[1])),0,0,'L',0);
			$pdf->Cell(18,5,$val[2],0,0,'R',1);
			$pdf->Cell(15,5,$val[4],0,0,'R',1);
			$i = $i+4;
			}
			$i++;
			if(count($series)>0){
				$data="";
				foreach($series as $key => $val){
					$data .= $val[0].' ';
				}
				$pdf->SetXY(17,$i);
				$pdf -> MultiCell(120,5,'SERIES. '.strtoupper($data),0,'J',false);
			}
			
			$pdf->SetXY(73,154);//166
			$pdf->Cell(22,5,fecha_venta($datos_venta->fecha),0,0,'C');
			
			$pdf->SetFont('helvetica','B',9);
			
			$pdf->SetXY(148,145);//166
			$pdf->Cell(25,5,$datos_venta->total,0,0,'R');
			
		
		
		}

		$pdf->Output();
	
	}

}
?>