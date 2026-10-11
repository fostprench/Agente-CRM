<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/modelo.php';
require_once 'model/Grid.php';

class ModeloController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new modelo();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_modelo');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_modelo",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Modelo&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session($_GET['id']);
	    $titulo=$_GET['controller'].'s Registrados';
	    $data['grilla'] = $grilla->asign($titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new modelo();
		$columnas=$obj->getHead('v_modelo');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_modelo");
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
            $data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>'0'));
			$data['p']=1;
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/modelo/_frm.php');
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
			$obj = new modelo();
			$data = array();
			$obj = $obj->edit($_GET['id']);
			$data['obj'] = $obj;
			$data['p']=2;
            $data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>$obj->idmarca));
			$view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/modelo/_frm.php' );
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
		$obj = new modelo();               
		print_r(json_encode($obj->newmodelo($_POST)));
	}
   
	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new modelo();
			$c=$obj->deletemodelo($_GET['id']);
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
}
?>

