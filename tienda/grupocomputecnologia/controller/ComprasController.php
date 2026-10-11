<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/compras.php';
require_once 'model/Grid_c.php';
require_once('lib/funciones.php');
class ComprasController extends Controller   
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new compras();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_compras_');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_compras_",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Compras&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(11);
	    $titulo=$_GET['controller'].' registrados';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();
		
    }
	public function search()
    {
		$obj = new compras();
		$columnas=$obj->getHead('v_compras');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_compras");
		$data['num']=$columnas;
		$view->setData( $data );
		$view->setTemplate( 'view/_Json.php' );
		echo $view->renderPartial();
    }
	
	public function create()
    {
		if($_SESSION['insertar']==1)
		{
			$data = array();
			$data['p']=1;
			$data['titulo']="REGISTRO DE COMPRA";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/compras/_frm.php');
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
			$obj = new compras();
			$data = array();
			$_venta = $obj->datos_c($_GET['id']);
			$data['obj'] = $_venta;
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['p']=2;
			$data['titulo']="EDITAR COMPRA";
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/compras/_frmedit.php' );
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
		$obj = new compras();
		print_r(json_encode($obj->regcompra($_POST)));
	}
	
	public function delete_item(){
		$obj = new compras();
		print_r(json_encode($obj->elimina_item($_GET)));
	}
	
	public function devolver_costo(){
		$obj = new compras();
		print_r(json_encode($obj->devolver_costo_producto($_GET['id'])));
	}
	
	public function validar_comprobante(){
		$obj = new compras();
		print_r(json_encode($obj->validar_comprobante_compra($_GET['nro_comp'])));
	}
	
	public function show()
	{
	    if($_SESSION['acceder']==1)
		{
			$obj = new compras();
			$data = array();
			$_venta = $obj->datos_c($_GET['id']);
			$data['obj'] = $_venta;
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['p']=3;
			$data['titulo']="REGISTRO DE COMPRA";
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/compras/_show.php' );
			echo $view->renderPartial();
		}
	}
	
    	
	public function q1()
	{
	 print_r($_POST);
	
	}
   
	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new compras();
			$c=$obj->deletecompra($_GET['id']);
			echo json_encode(array('rep'=>'1','msg'=>'ELIMINADO'));
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para eliminar');
			window.location='index.php';</script>";
		}
    }
	
	public function mostrar_proveedor(){
	
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new compras();
        $data = array();
		$cabecera=$obj->getHead('v_proveedor');
		//$cabecera=array('id_cliente','tipo_cliente','cliente');ok
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_proveedor",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Compras&action=mostrar_proveedor','query'=>$_GET['q']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/compras/_proveedor.php');
        echo $view->renderPartial();
	}
	
	public function mostrar_producto(){
	
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new compras();
        $data = array();
		$cabecera=$obj->getHead('v_producto');
		//$cabecera=array('id_cliente','tipo_cliente','cliente');ok
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_producto",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Compras&action=mostrar_producto','query'=>$_GET['q']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/compras/_producto.php');
        echo $view->renderPartial();
	}

}
?>