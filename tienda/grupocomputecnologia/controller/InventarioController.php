<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/inventario.php';
require_once 'model/Grid_inventario.php';

class InventarioController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new inventario();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_inventario_p');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_inventario_p",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Inventario&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(16);
	    $titulo= 'Inventario Registrado';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new inventario();
		$columnas=$obj->getHead('v_inventario_p');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_inventario_p");
		$data['num']=$columnas;
		$view->setData( $data );
		$view->setTemplate( 'view/_Json.php' );
		echo $view->renderPartial();
    }
	public function create()
    {
		echo "<div style='padding:110px 0 300px 0;' class='text-center'>No se puede Registrar un Nuevo Inventario<br/><br/>
		<p><input type='button' class='btn btn-primary' value='Atras' onclick=\"paginacion('controller=Inventario');\"  /></p>
		</div>";
    }
        
	public function _edit() 
	{
		if($_SESSION['editar']==1)
		{
			$obj = new inventario();
			$data = array();
			$view = new View();
			$obj = $obj->edit($_GET['id']);
			$data['obj'] = $obj;
			$data['p']=2;
			$data['titulo'] = "INVENTARIO REGISTRADO";
			$view->setData($data);
			$view->setTemplate( 'view/inventario/_frm.php' );
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
		$obj = new inventario();
		print_r(json_encode($obj->edit_inventario($_POST)));
    }
   
    public function _delete()
	{  
		echo json_encode(array('rep'=>'2','msg'=>'.::No se puede eliminar el Inventario::..'));	
    }
}
?>