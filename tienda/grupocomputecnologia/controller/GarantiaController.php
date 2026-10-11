<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/garantia.php';
require_once 'model/Grid.php';

class GarantiaController extends Controller 
{
	
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new garantia();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_garantia');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_garantia",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Garantia&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(40);
	    $titulo=$_GET['controller'].'s Registradas';
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
			$data=array();
			$data['falla'] = $this->Select(array('id'=>'idfalla','name'=>'idfalla','table'=>'v_selectvacio','code'=>'0'));
			$data['p']=1;
			$data['titulo']="REGISTRO DE GARANTIA DE PRODUCTOS";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/garantia/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo "<script>alert('no tiene permiso para insertar');
			window.location='index.php?controller=Garantia';</script>";
		}
	}
	

	
	
	public function buscar_serieproducto() 
	{
		if($_SESSION['insertar']==1)
		{
			$obj = new garantia();
			$data=array();
			$garantia=$obj->buscar_serie($_POST['serie']);
			$informacion = $garantia['obj'];
			$msg = $garantia['msg']; // true o false //depende de la cantidad de filas que devuelve la consulta
			if($msg){
				$data['res'] = 1;	
				$data['text'] = $garantia['text'];
				$data['producto'] = $informacion->producto;
				$data['comprobante'] = $informacion->comprobante;
				$data['f_comprobante'] = $informacion->f_comprobante;
				$data['idventa'] = $informacion->idventa;
				$data['idcliente'] = $informacion->idcliente;
				$data['cliente'] = $informacion->cliente;
				$data['idproducto'] = $informacion->idproducto;
				$consulta = "falla where idtipo=$informacion->tipo";
				$data['select'] = $this->Select(array('id'=>'idfalla','name'=>'idfalla','table'=>$consulta,'code'=>'0'));
			}else{
				$data['res'] = 0;
				$data['text'] = $garantia['text'];
				$data['select'] = $this->Select(array('id'=>'idfalla','name'=>'idfalla','table'=>'v_selectvacio','code'=>'0'));
			}
			$venta ="CONTADO"; 
			$data['tipo_venta'] = $venta;
			echo json_encode($data); 
		}
		else
		{
			echo 
			"<script>alert('Usted no tiene permiso para Insertar');
			window.location='index.php?controller=Garantia';</script>";
		}	
	}
	
	
	public function save()
	{
		$obj = new garantia();
        print_r(json_encode($obj->newgarantia($_POST))); 		
    }
	 


	public function _delete()
    { 
		if($_SESSION['delete']==1)
		{
			$obj = new garantia();
			$data=$obj->deletegarantia($_GET['id']);
			echo json_encode($data);
		}
		else
		{
			echo "<script>alert('no tiene permiso para eliminar');window.location='index.php';</script>";
		}
    }
	
}
?>
