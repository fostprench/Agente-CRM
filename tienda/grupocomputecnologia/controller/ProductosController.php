<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/productos.php';
require_once 'model/Grid_producto.php';

class ProductosController extends Controller
{
	public function Index()
    {
           
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new productos();
        $data = array();
	    $grilla= new  Grilla();
	    $cabecera=$obj->getHead('v_producto');
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_producto",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Productos&action=Index','query'=>$_GET['q'],'order'=>$_GET['order'],'total'=>$data['data']['total'],'consulta'=>$data['data']['consulta']));
	    $obj->session(8);
	    $titulo=$_GET['controller'].' Registrados';
	    $data['grilla'] = $grilla->asign($_GET['q'],$titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],true,false);
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
			$data['proveedor'] = $this->Select(array('id'=>'idproveedor','name'=>'idproveedor','table'=>'v_proveedor','code'=>'0'));
			$data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>'0'));
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>'0'));
			$data['p']=1;
			$data['titulo']="REGISTRAR PRODUCTO";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/productos/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo "<script>alert('no tiene permiso para insertar');
			window.location='index.php?controller=productos';</script>";
		}
	}
	

	
	
	public function _edit() 
	{
		if($_SESSION['editar']==1)
		{
			$obj = new productos();
			$data=array();
			$productos=$obj->editproductos($_GET['id']);
			$marca = $obj->_vermarca($productos->idmarca);
			$data['proveedor'] = $this->Select(array('id'=>'idproveedor','name'=>'idproveedor','table'=>'v_proveedor','code'=>$productos->idproveedor));
			$data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>$marca->idmarca));
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>$productos->idtipo));
			$data['obj']=$productos;
			$data['p']=2;
			$data['titulo']="EDITAR PRODUCTO";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/productos/_frm.php');
			echo $view->renderPartial();
		}
		else
		{
			echo 
			"<script>alert('no tiene permiso para editar');
			window.location='index.php?controller=productos';</script>";
		}	
	}
	
	
	public function show()
	{
			$obj = new productos();
			$data=array();
			$productos=$obj->editproductos($_GET['id']);
			$marca = $obj->_vermarca($productos->idmarca);
			$data['proveedor'] = $this->Select(array('id'=>'idproveedor','name'=>'idproveedor','table'=>'v_proveedor','code'=>$productos->idproveedor));
			$data['marca'] = $this->Select(array('id'=>'idmarca','name'=>'idmarca','table'=>'v_marca','code'=>$marca->idmarca));
			$data['tipo'] = $this->Select(array('id'=>'idtipo','name'=>'idtipo','table'=>'v_tipo','code'=>$productos->idtipo));
			$data['obj']=$productos;
			$data['p']=3;
			$data['titulo']="PRODUCTO REGISTRADO";
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/productos/_frm.php');
			echo $view->renderPartial();
	}
	
	
	public function save()
	{
		$obj = new productos();
        print_r(json_encode($obj->newproducto($_POST))); 
//echo "<script>alert('no tiene permiso para eliminar');</script>";  		
    }
	 


	public function _delete()
    { 
		if($_SESSION['delete']==1)
		{
			$obj = new productos();
			$data=$obj->deleteproducto($_GET['id']);
			echo json_encode($data);
		}
		else
		{
			echo "<script>alert('no tiene permiso para eliminar');window.location='index.php';</script>";
		}
    }
	

	// public function mostrar()
    // {
        // if (!isset($_GET['p'])){$_GET['p']=1;}
        // if(!isset($_GET['q'])){$_GET['q']="";}
		// if(!isset($_GET['order'])){$_GET['order']="";}
        // $obj = new productos();
        // $data = array();
		// $cabecera=$obj->getHead('v_producto');
		// $data['cabecera']=$cabecera;
        // $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_producto",$_GET['order']);
		// $data['rows']=$data['data']['rows'];
        // $data['query'] = $_GET['q'];
        
        // $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Productor&action=mostrar','query'=>$_GET['q']));
        // $view = new View();
        // $view->setData($data);
        // $view->setTemplate('view/productos/_lista.php');
        // echo $view->renderPartial();
    // }	
	
	//mostrar productos por componentes de equipo para las proformas
	//Falt VERIFICAR EL WHERE DE LA CONSULTA
	public function mostrar_p() 
    {
		if($_GET['cat']==1){ $vista = "v_componentes_procesador";
		}elseif($_GET['cat']==2){ $vista = "v_componentes_case";
		}elseif($_GET['cat']==3){ $vista = "v_componentes_placa";
		}elseif($_GET['cat']==4){ $vista = "v_componentes_ram";
		}elseif($_GET['cat']==5){ $vista = "v_componentes_red";
		}elseif($_GET['cat']==6){ $vista = "v_componentes_hdd";
		}elseif($_GET['cat']==7){ $vista = "v_componentes_monitor";
		}elseif($_GET['cat']==8){ $vista = "v_componentes_gravador";
		}elseif($_GET['cat']==9){ $vista = "v_componentes_teclado";
		}elseif($_GET['cat']==10){ $vista = "v_componentes_mouse";
		}elseif($_GET['cat']==11){ $vista = "v_componentes_parlante";
		}elseif($_GET['cat']==12){ $vista = "v_componentes_estabilizador";
		}elseif($_GET['cat']==13){ $vista = "v_componentes_tarjetavideo";
		}elseif($_GET['cat']==14){ $vista = "v_componentes_ups";
		}elseif($_GET['cat']==16){ $vista = "v_componentes_fuentepoder";
		}
		
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new productos();
        $data = array();
		$cabecera=$obj->getHead($vista);
		$data['cabecera']=$cabecera;
        $data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,$vista,$_GET['order']);
		$data['rows']=$data['data']['rows'];
        $data['query'] = $_GET['q'];      
		$data['action']='mostrar_p';		
		$data['cat']=$_GET['cat'];		
        $data['pag'] = $this->Pagination_l(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Productos&action=mostrar_p&cat='.$_GET['cat'],'query'=>$_GET['q']));
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/productos/producto.php');
        echo $view->renderPartial();
    }

	
	
	
}
?>
