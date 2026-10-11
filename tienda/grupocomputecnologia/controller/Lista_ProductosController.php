<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/Lista_Productos.php';
require_once 'model/Grid_lista.php';

class Lista_ProductosController extends Controller 
{
	public function Index()
    {		
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new Lista_Productos();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_productos_general');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_productos_general",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Lista_Productos&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(46);
	    $titulo='Lista de Productos Registrados';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	
}
?>