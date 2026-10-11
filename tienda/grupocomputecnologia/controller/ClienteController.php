<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/cliente.php';
require_once 'model/Grid.php';

class ClienteController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new cliente();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_cliente');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_cliente",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Cliente&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(15);
	    $titulo=$_GET['controller'].'s Registrados';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new cliente();
		$columnas=$obj->getHead('v_cliente');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_cliente");
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
			$data['ubigeo'] = $this->Select(array('id'=>'ubigeo','name'=>'ubigeo','table'=>'v_ubigeo_sanmartin','code'=>220804));
			$data['p']=1;
			$data['titulo']="REGISTRAR CLIENTE";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/cliente/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo 
				"<script>alert('no tiene permiso para insertar');
				window.location='index.php';</script>";
		}
	}
	
	public function create_ext()
    {
			$data = array();
			$data['ubigeo'] = $this->Select(array('id'=>'ubigeo','name'=>'ubigeo','table'=>'v_ubigeo_sanmartin','code'=>220804));
			$data['p']=1;
			$data['titulo']="REGISTRAR CLIENTE";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/cliente/_frmext.php');
			echo $view->renderPartial();

	}
	
	public function _edit() 
	{
		if($_SESSION['editar']==1)
		{
				
			$obj = new cliente();
			$data = array();
			$obj = $obj->edit($_GET['id']);
			$data['titulo']="";
			$data['obj'] = $obj;
			$data['p']=2;
			$data['titulo']="EDITAR CLIENTE";
			$data['ubigeo'] = $this->Select(array('id'=>'ubigeo','name'=>'ubigeo','table'=>'v_ubigeo_sanmartin','code'=>$obj->ubigeo));
			$view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/cliente/_frm.php' );
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
		$obj = new cliente();
		print_r(json_encode($obj->newcliente($_POST)));
	}
	
	public function show()
	{
	    $obj = new cliente();
	    $data=array();
		$obj=$obj->edit($_GET['id']);
		$data['obj']=$obj;
		$data['ubigeo'] = $this->Select(array('id'=>'ubigeo','name'=>'ubigeo','table'=>'v_ubigeo_sanmartin','code'=>$obj->ubigeo));
		$data['titulo']="CLIENTE REGISTRADO";
		$data['p']=3;
		$view = new View();
	    $view->setData($data);
	    $view->setTemplate( 'view/cliente/_frm.php' );
		echo $view->renderPartial();
	}
	

	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new cliente();
			$c=$obj->deletecliente($_GET['id']);
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
        $obj = new cliente();
        $data = array();
		$cabecera=$obj->getHead('v_cliente');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_cliente",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Cliente&action=mostrar','query'=>$_GET['q']));
		$view = new View();
        $view->setData($data);
        $view->setTemplate('view/cliente/cliente_ventas.php');
        echo $view->renderPartial();
    }
	
	public function mostrar_orden()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new cliente();
        $data = array();
		$cabecera=$obj->getHead('v_cliente');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_cliente",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Cliente&action=mostrar_orden','query'=>$_GET['q']));
		$view = new View();
        $view->setData($data);
        $view->setTemplate('view/cliente/cliente_orden.php');
        echo $view->renderPartial();
    }
	
	public function mostrar_cliente_proforma()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new cliente();
        $data = array();
		$cabecera=$obj->getHead('v_cliente');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_cliente",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Cliente&action=mostrar','query'=>$_GET['q']));
		$view = new View();
        $view->setData($data);
        $view->setTemplate('view/cliente/cliente_proformas.php');
        echo $view->renderPartial();
    }
		
	
}
?>

