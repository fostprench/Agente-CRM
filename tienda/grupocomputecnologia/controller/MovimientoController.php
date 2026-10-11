<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/movimiento.php';
require_once 'model/Grid_Mov_caja.php';

class MovimientoController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new movimiento();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_movimiento');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_movimiento",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Movimiento&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(21);
	    $titulo= 'Movimientos de Caja Registradas';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new movimiento();
		$columnas=$obj->getHead('v_movimiento');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_movimiento");
		$data['num']=$columnas;
		$view->setData( $data );
		$view->setTemplate( 'view/_Json.php' );
		echo $view->renderPartial();
    }
	public function ingreso()
    {
		if($_SESSION['insertar']==1)
		{
			$obj = new movimiento();
			$data = array();
			$idcaja= $obj->idcaja();
			$idcaja = $idcaja->max;
			$data['p']=1;
			$data['responsable']="Responsable: ";
			$data['tipo_mov']=1;
			$data['control_caja']=1;
			$data['titulo']="REGISTRO DE INGRESOS";
			$data['idcaja']=$idcaja;
			$data['mensaje']="Para Registrar un Movimiento de Caja Primero debe Aperturar la Caja";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/movimiento/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para insertar');
			window.location='index.php';</script>";
		}
    }
    
		public function egreso()
    {
		if($_SESSION['insertar']==1)
		{
			$obj = new movimiento();
			$data = array();
			$idcaja= $obj->idcaja();
			$idcaja = $idcaja->max;
			$data['p']=1;
			$data['responsable']="Responsable: ";
			$data['tipo_mov']=2;
			$data['control']=$this->Select(array('id'=>'idcontrolcaja','name'=>'idcontrolcaja','table'=>'v_controlcajaegresos','code'=>'2'));
			$data['titulo']="REGISTRO DE EGRESOS";
			$data['idcaja']=$idcaja;
			$data['mensaje']="Para Registrar un Movimiento de Caja Primero debe Aperturar la Caja";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/movimiento/_frm.php');
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
			$obj = new movimiento();
			$data = array();
			$view = new View();
			$obj = $obj->edit($_GET['id']);
			$data['idventa']=$obj->idventa;
			$data['tipo_mov']=$obj->tipo_movimiento;
			$data['idcaja']=$obj->idcaja;
			$data['obj'] = $obj;
			$data['p']=2;
			if($obj->tipo_movimiento==1){
				$data['titulo']="EDITAR MOVIMIENTO DE CAJA: INGRESO";
			}else{
				$data['titulo']="EDITAR MOVIMIENTO DE CAJA: EGRESO";
				$data['control']=$this->Select(array('id'=>'idcontrolcaja','name'=>'idcontrolcaja','table'=>'v_controlcajaegresos','code'=>$obj->idcontrolcaja));
			}
			$data['responsable']="Registrado por: ";
			$data['mensaje']="No se Puede Editar un Registro de Venta";
			$view->setData($data);
			$view->setTemplate( 'view/movimiento/_frm.php' );
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
		$obj = new movimiento();
		print_r(json_encode($obj->newmovimiento($_POST)));
    }
   
    public function _delete()
	{  
		if($_SESSION['delete']==1)
		{
			$obj = new movimiento ();
			$tipo = $obj->tipo_movimiento($_GET['id']);
			$idCaja = $tipo->idcaja;
			$tipo_mov = $tipo->tipo_movimiento;
			print_r(json_encode($obj->deletemovimiento ($_GET['id'],$idCaja,$tipo_mov)));
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