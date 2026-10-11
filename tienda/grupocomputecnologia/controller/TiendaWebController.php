<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/TiendaWeb.php';
require_once 'model/Grid.php';

class TiendaWebController extends Controller 
{
	function index()
	{
        if ($_SERVER['REQUEST_METHOD']=='POST'){
			$obj = new  ProductosWeb();
			$data = array();
			$data['productos'] = $obj->Tipo_producto($_POST['tipo']);
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/productosWeb/'.$_POST['tipo'].'.php');
			echo $view->renderPartial();
        } 
		else
        {
		   print_r(json_encode(array("Error"=>true,"msg"=>"NO PUEDES INGRESAR POR AQUI")));
        }
    }
	
	function producto()
	{
        if ($_SERVER['REQUEST_METHOD']=='POST'){
			$obj = new  ProductosWeb();
			$data = array();
			$data['obj'] = $obj->Info_producto($_POST['id']);
			$data['atras'] = $_POST['_url_'];
			$data['id'] = $_POST['id'];
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/productosWeb/_DetalleProducto.php');
			echo $view->renderPartial();
        } 
		else
        {
		   print_r(json_encode(array("Error"=>true,"msg"=>"NO PUEDES INGRESAR POR AQUI")));
        }
    }

}
?>
