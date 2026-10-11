<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/Ventasxpedir.php';
require_once 'model/Grid_vxc.php';
require_once('fpdf/fpdf.php');
require_once('lib/funciones.php');
class VentasxpedirController extends Controller   
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new Ventasxpedir();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_ventaxpedir');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_ventaxpedir",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Ventasxpedir&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(39);
	    $titulo='Ventas por Pedir Registradas';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true,true);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
		$view->setLayout('template/Layout.php');
        echo $view->renderPartial();
       //$view->render();
    }
	
	public function search()
    {
		$obj = new Ventasxpedir();
		$columnas=$obj->getHead('v_ventaxpedir');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_ventaxpedir");
		$data['num']=$columnas;
		$view->setData( $data );
		$view->setTemplate( 'view/_Json.php' );
		echo $view->renderPartial();
    }
	
	public function create()
    {
		if($_SESSION['insertar']==1)
		{
			$obj = new Ventasxpedir();
			$data = array();
			$caja = $obj->idMax();
			if($caja->max == NULL){
			$data['mensaje'] = false;
			$data['msg']='PARA PODER HACER UN REGISTRO DE VENTA DEBE APERTURAR LA CAJA';
			}else{
			$data['mensaje'] = true;
			}
			$data['p']=1;
			$data['titulo']="REGISTRO DE VENTA POR PEDIR";
			$data['tipo_c'] = $this->Select(array('id'=>'tipo_c','name'=>'tipo_c','table'=>'tipo_comprobante','code'=>'0'));
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/Ventasxpedir/_frm.php');
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
			$obj = new Ventasxpedir();
			$data = array(); // SE PUEDE EDITAR CAJA ABIERTA O CERRADA, VER NO ELIMINAR MOVIMIENTOS(AMORTIZACIONES) DE UNA CAJA CERRADA
			$data['mensaje']=true;
			$_venta = $obj->datos_v($_GET['id']);
			$data['obj'] = $_venta;
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['p']=2;
			$data['titulo']="EDITAR VENTA";
			$data['tipo_c'] = $this->Select(array('id'=>'tipo_c','name'=>'tipo_c','table'=>'tipo_comprobante','code'=>$_venta->tipo_c));
			$view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/Ventasxpedir/_frmedit.php' );
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
		$obj = new Ventasxpedir();
		print_r(json_encode($obj->regventa($_POST)));
	}
	
	public function delete_item(){
		$obj = new Ventasxpedir();
		print_r(json_encode($obj->elimina_item($_GET)));
	}
	
	
	public function amortizar(){
		$obj = new Ventasxpedir();
		$data = array();
		$caja = $obj->idMax();
		if($caja->max == NULL){
		$data['mensaje'] = false;
		$data['msg']='PARA PODER AMORTIZAR DEBE APERTURAR LA CAJA';
		}else{
		$data['mensaje'] = true;
		$data["titulo"] = "DATOS GENERALES DEL COMPROBANTE";
		$data['idventa']=$_GET['id'];
		$data['obj'] = $obj->datos_v($_GET['id']);;    
		$data['total_amortizacion'] = $obj->total_amortizacion($_GET['id']); 
		$data['detalle_amortizaciones'] = $obj->datos_amortizaciones($_GET['id']);
		$data['detalle'] = $obj->detalle_amortizaciones($_GET['id']);		
		}
		$data['JS'] = 'Ventasxpedir_Atras.js';
		$view = new View();
		$view->setData($data);
		$view->setTemplate( 'view/Ventasxpedir/_frmAmortiza.php' );
		echo $view->renderPartial();
	}
	
	public function arqueo_inventario()
	{
			$data = array();
			$data['titulo']="ARQUEO DE INVENTARIO DE COMPROBANTE";
			$data['idventa']=$_GET['id'];
			$view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/Ventasxpedir/arqueo_inventario.php' );
			echo $view->renderPartial();
	}
	
	
	public function actualizar_inventario()
	{
			$obj = new Ventasxpedir();
			$data = array();
			$detalle = $obj->datos_d($_GET['idventa']);
			
			$verificador = $obj->verificar_inv($_GET['idventa']);
			
			if($verificador){
				foreach($detalle as $key=>$val){
					$obj->actualizar_inv($val[0],$val[3]); //(idproducto,cantidad)
				}
				$obj->actualizar_estado($_GET['idventa']); // editar el estado=1 de la venta
				print_r(json_encode(array('rep'=>1,'msg'=>'COMPROBANTE LIBERADO CORRECTAMENTE')));
			}else{
				print_r(json_encode(array('rep'=>0,'msg'=>'NO SE PUEDE LIBERAR COMPROBANTE, REGISTRE EN COMPRAS EL PRODUCTO PARA AUMENTAR EL INVENTARIO')));
			}
			
	}
	
	public function show()
	{
	    if($_SESSION['acceder']==1)
		{
			$obj = new Ventasxpedir();
			$data = array();
			$_venta = $obj->datos_v($_GET['id']);
			$data['obj'] = $_venta;
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['p']=2;
			$data['titulo']="VENTA POR COBRAR REGISTRADA";
			$data['tipo_c'] = $this->Select(array('id'=>'tipo_c','name'=>'tipo_c','table'=>'tipo_comprobante','code'=>$_venta->tipo_c));
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/Ventasxpedir/_show.php' );
			echo $view->renderPartial();
		}
	}
	
	

    public function _prinft(){
	
		$obj = new Ventasxpedir();
	    $data=array();

		$datos_venta = $obj -> datos_v($_GET['id']);
		$detalle_venta = $obj -> datos_d($_GET['id']);

		$total = count($detalle_venta);

		$tamanio = 75+$total*4*2;
		$pdf = new FPDF('P','mm',array(73, $tamanio));
		$pdf->SetAutoPageBreak(false);
		$pdf->AddPage();
		$fila = 6;
		$pdf->SetFont('Courier', '', 8);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'****** COMPUTECNOLOGIA ******',0,0,'C', 1);
		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'AV.CAJAMARCA SUR #620',0,0,'C', 1);
		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'TELEF: 042-500433 - CEL: #950821963',0,0,'C', 1);
		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'NUEVA CAJAMARCA - SAN MARTIN',0,0,'C', 1);
		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'RUC: 10437846575',0,0,'C', 1);
		$fila = $fila + 8;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(73,4,'CLIENTE: '.UTF8_DECODE($datos_venta->cliente),0,0,'L');
		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(73,4,'  FECHA: '.fecha_venta($datos_venta->fecha).'  HORA: '.date('H:m:s'),0,0,'L');
		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(73,4,'USUARIO: '.$_SESSION['user'],0,0,'L');

		$fila = $fila + 6;
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'DETALLE DE VENTA',0,0,'C');

		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(20,4,'CANT',0,0,'L');
		$pdf->Cell(30,4,'PREC.UNIT.',0,0,'L');
		$pdf->Cell(20,4,'SUB-TOTAL',0,0,'L');

		$fila = $fila + 3;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(73,4,'......................................',0,0,'L');


		/*CONTENIDO DEL DETALLE DE VENTA*/
		foreach($detalle_venta as $key => $val){

		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(20,4,$val[3],0,0,'L');
		$pdf->Cell(30,4,$val[2],0,0,'L');
		$pdf->Cell(20,4,$val[4],0,0,'L');

		$fila = $fila + 3;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(73,4,UTF8_DECODE($val[1]),0,0,'L');
		}
		/*CONTENIDO DEL DETALLE DE VENTA*/

		$fila = $fila + 5;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(73,4,'......................................',0,0,'L');

		$fila = $fila + 4;
		$pdf->SetY($fila);
		$pdf->SetX(2);
		$pdf->Cell(50,4,'TOTAL: ',0,0,'R');
		$pdf->Cell(20,4,$datos_venta->total,0,0,'L');

		$fila = $fila + 6;
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'BIENES TRANSF. EN LA AMAZONIA',0,0,'C', 1);

		$fila = $fila + 3;
		$pdf->SetY($fila);
		$pdf->SetX(0);
		$pdf->Cell(73,4,'PARA SER CONSUMIDOS EN LA MISMA',0,0,'C', 1);

		$pdf->Output();
	
	}
	
	
	public function q1()
	{
	 print_r($_POST);
	
	}
   
	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new Ventasxpedir();
			$c=$obj->deleteventa($_GET['id']);
			echo json_encode(array('rep'=>'1','msg'=>'ELIMINADO'));
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para eliminar');
			window.location='index.php';</script>";
		}
    }
	
	public function mostrar_p(){
		$q = trim($_GET['q']);
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($q)){$q="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new Ventasxpedir();
        $data = array();
		$cabecera=$obj->getHead('v_productos_inventario');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($q,$_GET['p'],$cabecera,"v_productos_inventario",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $q;
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Ventasxpedir&action=mostrar_p','query'=>$q));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/Ventasxpedir/producto.php');
        echo $view->renderPartial();
	}
	

}
?>