<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/marca.php';
require_once 'model/Grid.php';

class MarcaController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new marca();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_marca');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_marca",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Marca&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(10);
	    $titulo=$_GET['controller'].'s Registradas';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new marca();
		$columnas=$obj->getHead('v_marca');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_marca");
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
			$data['titulo']="REGISTRAR MARCA";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/marca/_frm.php');
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
			$obj = new marca();
			$data = array();
			$view = new View();
			$obj = $obj->edit($_GET['id']);
			$data['obj'] = $obj;
			$data['p']=2;
			$data['titulo']="EDITAR MARCA";
			$view->setData($data);
			$view->setTemplate( 'view/marca/_frm.php' );
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
		$obj = new marca();
		print_r(json_encode($obj->newmarca($_POST)));
    }
   
    public function _delete()
	{  
		if($_SESSION['delete']==1)
		{
			$obj = new marca ();
			$c=$obj->deletemarca ($_GET['id']);
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