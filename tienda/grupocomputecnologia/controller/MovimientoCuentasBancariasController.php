<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'lib/funciones.php';
require_once 'model/movimientocuentascancarias.php';
require_once 'model/Grid.php';

class MovimientoCuentasBancariasController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new movimientocuentascancarias();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_cuentas_bancarias');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_cuentas_bancarias",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=MovimientoCuentasBancarias&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(45);
	    $titulo= 'MOVIMIENTOS BANCARIOS REGISTRADOS';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }

	public function create()
    {
		if($_SESSION['insertar']==1)
		{
			$data = array();
			$data['p']=1;
			$data['titulo']="REGISTRAR MOVIMIENTO BANCARIO";
			$data['bancos'] = $this->Select(array('id'=>'idcuentas_bancarias','name'=>'idcuentas_bancarias','table'=>'v_listacuentas_bancarias','code'=>'0'));
			$data['motivo'] = $this->Select(array('id'=>'idmotivo_movimiento','name'=>'idmotivo_movimiento','table'=>'v_listamotivo_movimientos','code'=>'0'));
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/movimientocuentascancarias/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para insertar');
			window.location='index.php';</script>";
		}
    }
    
	
	public function saldo_cuenta()
    {
		$obj = new movimientocuentascancarias();
		print_r(json_encode($obj->saldo_banco($_POST)));
    }
	
	public function Updatesaldo_cuenta()
    {
		$obj = new movimientocuentascancarias();
		print_r(json_encode($obj->Updatesaldo_banco($_POST)));
    }
	
	
	public function _edit() 
	{
		if($_SESSION['editar']==1)
		{
			$obj = new movimientocuentascancarias();
			$data = array();
			$view = new View();
			$mov = $obj->edit($_GET['id']);
			$data['p'] = 2;
			$data['obj'] = $mov;
			$data['fecha'] = validar_fecha($mov->fecha);
			$data['titulo']="EDITAR MOVIMIENTO BANCARIO";
			$data['bancos'] = $this->Select(array('id'=>'idcuentas_bancarias','name'=>'idcuentas_bancarias','table'=>'v_listacuentas_bancarias','code'=>$mov->idcuentas_bancarias));
			$data['motivo'] = $this->Select(array('id'=>'idmotivo_movimiento','name'=>'idmotivo_movimiento','table'=>'v_listamotivo_movimientos','code'=>$mov->idmotivo_movimiento));
			$view->setData($data);
			$view->setTemplate('view/movimientocuentascancarias/_frm.php');
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
		$obj = new movimientocuentascancarias();
		print_r(json_encode($obj->newmovimiento($_POST)));
    }
   
    public function _delete()
	{  
		if($_SESSION['delete']==1)
		{
			$obj = new movimientocuentascancarias ();
			$c=$obj->deletemovimiento($_GET['id']);
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