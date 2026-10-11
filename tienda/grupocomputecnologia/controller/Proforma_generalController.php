<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'lib/funciones.php';
require_once 'model/proformas.php';

class Proforma_generalController extends Controller 
{
	public function index()
    {
		$obj = new proformas();
		$data_proforma = $obj->proforma_general();
		$data = array();
		$data['titulo'] = 'INFORMACI&Oacute;N GENERAL DE PROFORMA';
		$data['obj'] = $data_proforma;
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/proformas/_frmGeneral.php');
        echo $view->renderPartial();
    }
	
	public function save()
    {
		$obj = new proformas();
		print_r(json_encode($obj->newproforma_general($_POST)));
	}
	
}
?>

