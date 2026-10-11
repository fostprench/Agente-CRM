<?php
require_once 'controller/TiendaWebController.php';
if($_POST['option']==1){
TiendaWebController::index();
}elseif($_POST['option']==2){
TiendaWebController::producto();
}else{
print_r(json_encode(array("ERROR: NO PUEDES INGRESAR POR AQUI")));
}
?>
