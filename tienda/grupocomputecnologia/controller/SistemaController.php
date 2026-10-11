<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/Sistema.php';
class SistemaController extends Controller {

    public function Menu()
    {
        $objsistema = new Sistema();
        print_r(json_encode($objsistema->menu()));
    }
}

?>