<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/proveedores.php';
require_once 'model/Grid.php';

class ProveedoresController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new proveedores();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_proveedor');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_proveedor",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Proveedores&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(27);
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
		$obj = new proveedores();
		$columnas=$obj->getHead('v_proveedor');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_proveedor");
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
			$data['titulo']="REGISTRAR PROVEEDOR";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/proveedores/_frm.php');
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
				
			$obj = new proveedores();
			$data = array();
			$obj = $obj->edit($_GET['id']);
			$data['obj'] = $obj;
			$data['p']=2;
			$data['titulo']="EDITAR PROVEEDOR";
			$view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/proveedores/_frm.php' );
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
		$obj = new proveedores();
		print_r(json_encode($obj->newproveedor($_POST)));
	}
	
		public function show()
	{
	    $obj = new proveedores();
	    $data=array();
		$obj=$obj->edit($_GET['id']);
		$data['obj']=$obj;
		$data['p']=3;
		$data['titulo']="PROVEEDOR REGISTRADO";
		$view = new View();
	    $view->setData($data);
	    $view->setTemplate('view/proveedores/_frm.php');
		echo $view->renderPartial();
	}
	

	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new proveedores();
			$c=$obj->deleteproveedor($_GET['id']);
			if ($c){echo json_encode(array('rep'=>'1','msg'=>'Eliminado'));} 
			else{echo json_encode(array('rep'=>'2','msg'=>'.::no se pudo eliminar::..'));}
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
        $obj = new proveedores();
        $data = array();
		$cabecera=$obj->getHead('sv_cliente');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"sv_cliente",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Proveedores&action=mostrar','query'=>$_GET['q']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/proveedores/_lista.php');
        echo $view->renderPartial();
    }
		
	
}
?>

