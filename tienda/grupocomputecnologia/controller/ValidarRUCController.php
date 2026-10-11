<?php
require_once 'lib/View.php';
class ValidarRUCController  {

     public function Index()
    {
        $data = array();
		$data['titulo']="CONSULTA DE RUC - SUNAT";
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/consultaRUC/_frm.php');
       echo $view->renderPartial();
	}

}
?>

