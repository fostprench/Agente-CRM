<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/cuentasxcobrar.php';
require_once 'model/Grid_vc.php';

class CuentasxcobrarController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new cuentasxcobrar();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_cuentasxcobrar');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_cuentasxcobrar",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Cuentasxcobrar&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session($_GET['id']);
	    $titulo=$_GET['controller'].' registrados';
	    $data['grilla'] = $grilla->asign($titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new cuentasxcobrar();
		$columnas=$obj->getHead('v_cuentasxcobrar');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_cuentasxcobrar");
		$data['num']=$columnas;
		$view->setData( $data );
		$view->setTemplate( 'view/_Json.php' );
		echo $view->renderPartial();
    }
	
	/*public function create()
    {
		if($_SESSION['insertar']==1)
		{
			$data = array();
         	$data['p']=1;
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/cuentasxcobrar/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo 
				"<script>alert('no tiene permiso para insertar');
				window.location='index.php';</script>";
		}
	}*/
	
	public function _edit() 
	{
		if($_SESSION['editar']==1)
		{
				
			$obj = new cuentasxcobrar();
	    $data=array();
		$datos_p=$obj->datos_p($_GET['id']);
		$data['obj']=$datos_p;
		$data['p']=2;
		$objeto = $obj->datos_a($_GET['id']);
		$data['amortizacion'] = $objeto;
		$view = new View();
	    $view->setData($data);
	    $view->setTemplate('view/cuentasxcobrar/edit_amortizaciones.php');
		echo $view->renderPartial();
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para editar');
			window.location='index.php';</script>";
		}
    }

	public function amortizar(){
	        $obj = new cuentasxcobrar();
			$data = array();
			$obj=$obj->entidad($_GET['id']);
		    $data['obj']=$obj;
			$data['p']= 1;
			$data['idprestamo'] = $_GET['id'];
			$data['deuda'] = $_GET['deuda'];
        	$view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/cuentasxcobrar/_frmamortizacion.php' );
			echo $view->renderPartial();
	}
	
	public function save_amortizacion(){
	$obj = new cuentasxcobrar();
	print_r(json_encode($obj->newamortizacion($_GET)));
	}
	
		public function show()
	{		
		$obj = new cuentasxcobrar();
	    $data=array();
		$datos_p=$obj->datos_p($_GET['id']);
		$data['obj']=$datos_p;
		$data['p']=3;
		$objeto = $obj->datos_a($_GET['id']);
		$data['amortizacion'] = $objeto;
		$view = new View();
	    $view->setData($data);
	    $view->setTemplate('view/cuentasxcobrar/edit_amortizaciones.php');
		echo $view->renderPartial();

	}
	
	public function _delete()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new cuentasxcobrar();
			$c=$obj->deleteprestamo($_GET['id']);
			if ($c){echo json_encode(array('rep'=>'1','msg'=>'Eliminado'));} 
			else{echo json_encode(array('rep'=>'2','msg'=>'.::Imposible Eliminar, el Prestamo tiene Registrado Amortizaciones::..'));}
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para eliminar');
			window.location='index.php';</script>";
		}
    }

	public function _delete_amortizacion()
    {  
		if($_SESSION['delete']==1)
		{
			$obj = new cuentasxcobrar();
			$c=$obj->deleteamortizacion($_GET['id']);
			if ($c){echo json_encode(array('rep'=>'1','msg'=>'Amortizacion Eliminada'));} 
			else{echo json_encode(array('rep'=>'2','msg'=>'.::Imposible Eliminar Registrado Amortizacion::..'));}
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para eliminar');
			window.location='index.php';</script>";
		}
    }
	
	public function mostrar()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new cuentasxcobrar();
        $data = array();
		$cabecera=$obj->getHead('sv_cliente');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"sv_cliente",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Cuentasxcobrar&action=mostrar','query'=>$_GET['q']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/cuentasxcobrar/_lista.php');
        //$view->setLayout('template/listas.php');
        echo $view->renderPartial();
    }
	
		public function mostrar_financiera()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new cuentasxcobrar();
        $data = array();
		$cabecera=$obj->getHead('v_financiera_n');
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_financiera_n",$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Cuentasxcobrar&action=mostrar_financiera','query'=>$_GET['q']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/cuentasxcobrar/_frmfinanciera.php');
        echo $view->renderPartial();
		
    }
		
	
}
?>

