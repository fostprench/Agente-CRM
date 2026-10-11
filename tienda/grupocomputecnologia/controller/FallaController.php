<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/falla.php';
require_once 'model/Grid.php';

class FallaController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new falla();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_falla');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_falla",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Falla&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(41);
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
		$obj = new falla();
		$columnas=$obj->getHead('v_falla');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_falla");
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
			$data['titulo']="REGISTRAR FALLA";
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>'0'));
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/falla/_frm.php');
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
			$obj = new falla();
			$data = array();
			$view = new View();
			$falla = $obj->edit($_GET['id']);
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>$falla->idtipo));
			$data['obj'] = $falla;
			$data['p']=2;
			$data['titulo']="EDITAR FALLA";
			$view->setData($data);
			$view->setTemplate( 'view/falla/_frm.php' );
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
		$obj = new falla();
		print_r(json_encode($obj->newfalla($_POST)));
    }
   
    public function _delete()
	{  
		if($_SESSION['delete']==1)
		{
			$obj = new falla ();
			$c=$obj->deletefalla ($_GET['id']);
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