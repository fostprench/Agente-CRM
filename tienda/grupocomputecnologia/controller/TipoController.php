<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/tipo.php';
require_once 'model/Grid.php';

class TipoController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new tipo();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_tipo');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_tipo",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Tipo&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(26);
	    $titulo= 'Categorias Registradas';
		$data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new tipo();
		$columnas=$obj->getHead('v_tipo');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_tipo");
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
			$data['titulo']="REGISTRAR CATEGORIA";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/tipo/_frm.php');
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
			$obj = new tipo();
			$data = array();
			$view = new View();
			$obj = $obj->edit($_GET['id']);
			$data['obj'] = $obj;
			$data['p']=2;
			$data['titulo']="EDITAR CATEGORIA";
			$view->setData($data);
			$view->setTemplate( 'view/tipo/_frm.php' );
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
		$obj = new tipo();
		print_r(json_encode($obj->newtipo($_POST)));
    }
   
    public function _delete()
	{  
		if($_SESSION['delete']==1)
		{
			$obj = new tipo ();
			$c=$obj->deletetipo ($_GET['id']);
			if ($c){echo json_encode(array('rep'=>'1','msg'=>'ELIMINADO'));} 
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