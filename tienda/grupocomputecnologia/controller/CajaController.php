<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'lib/funciones.php';
require_once 'model/caja.php';
require_once 'model/Grid_caja.php';

class CajaController extends Controller 
{
	public function Index()
    {
		if (!isset($_GET['p'])){$_GET['p']=1;}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if(!isset($_GET['q'])){$_GET['q']="";}
		if(!isset($_GET['order'])){$_GET['order']="";}
        $obj = new caja();
	    $grilla= new  Grilla();
        $data = array();
	   	$cabecera=$obj->getHead('v_caja');
		$data['data'] = $obj->index_P($_GET['q'],$_GET['p'],$cabecera,"v_caja",$_GET['order']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'controller=Caja&action=Index','query'=>$_GET['q'],'order'=>$_GET['order']));
		$obj->session(20);
	    $titulo= 'Aperturas de Caja Registradas';
	    $data['grilla'] = $grilla->asign($titulo,$_GET['controller'],$cabecera, $data['data']['rows'],$data['pag'],$data['data']['total'],false);
	    $data['controller']=$_GET['controller'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('view/master/grilla.php');
        echo $view->renderPartial();

    }
	public function search()
    {
		$obj = new caja();
		$columnas=$obj->getHead('v_caja');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"],$columnas,"v_caja");
		$data['num']=$columnas;
		$view->setData( $data );
		$view->setTemplate( 'view/_Json.php' );
		echo $view->renderPartial();
    }
	public function create()
    {
		if($_SESSION['insertar']==1)
		{
			$obj = new caja();
			$data = array();
			$max_idcaja = $obj->max_idcaja();
			$verifica= $obj->verifica_caja($max_idcaja->max);
			if($verifica == null){
			$estado = 2;//estado nulo
			}else{
			$estado = $verifica->estado;
			}
			if($estado == 0){
			$saldo = $obj->saldo_caja($max_idcaja->max);
			$data['saldo']=$saldo->saldo;
			$data['p']=1;
			$data['titulo']="REGISTRAR CAJA";
			$data['responsable']="Responsable: ";
			}elseif($estado == 2){
			$data['responsable']="Responsable: ";
			$data['saldo']=0;
			$data['p']=1;
			}else{
			$data['mensaje']="No se puede Aperturar Caja, Existe una Caja Abierta";
			$data['motivo']="Existe una Caja Aperturada";
			$data['p']=3;
			}
			
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/caja/_frm.php');
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
			$obj = new caja();
			$data = array();
			$verifica= $obj->verifica_caja($_GET['id']);
			if($verifica->estado == 0){
				$data['p']=3;
				$data['mensaje']=" No se puede Editar una Caja Cerrada";
			}else{
				$data['p']=2;
				$saldo = $obj->saldo_caja_apertura($_GET['id']);
				$user  = $obj->user_nombre($saldo->idusuario);
				$data['fecha_apertura']= validar_fecha($saldo->fecha_a);
				$data['saldo']=$saldo->monto_a;
				$data['idcaja']=$saldo->idcaja;
				$data['usuario']=$user->nombres;				
				$data['responsable']="Responsable: ";
			}
			
			$data['titulo']="EDITAR CAJA APERTURADA";
			
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/caja/_frm.php');
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
		$obj = new caja();
		print_r(json_encode($obj->Aperturar($_POST)));
    }
	
	public function show()
	{
			$data = array();
			$data['idcaja']=$_GET['id'];
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/caja/_show.php' );
			echo $view->renderPartial();

	}
	
	 public function cerrar_caja()
	{  
			$obj = new caja ();
			$fecha_inicio = $obj->saldo_caja_apertura($_POST['idcaja']);			
			$mes_fecha_inicio = mes($fecha_inicio->fecha_a);
			$anio_fecha_inicio = anio_completo($fecha_inicio->fecha_a);
			$mes_hoy = date('m');
			$year = date('Y');
			
			if($year>$anio_fecha_inicio){
				$dias_mes_activo = diasMes($mes_fecha_inicio,$anio_fecha_inicio);
				$fecha_cierre_caja = $anio_fecha_inicio.'-'.$mes_fecha_inicio.'-'.$dias_mes_activo;
			}else{
				if($mes_hoy>$mes_fecha_inicio){
					$dias_mes_activo = diasMes($mes_fecha_inicio,$anio_fecha_inicio);
					$fecha_cierre_caja = $anio_fecha_inicio.'-'.$mes_fecha_inicio.'-'.$dias_mes_activo;
				}else{ 
					$fecha_cierre_caja = date('Y-m-d');
				}
			}
			
			
			$c=$obj->cerrarcaja($fecha_cierre_caja,$_POST['idcaja']);
			if ($c){echo json_encode(array('rep'=>'1','msg'=>'Caja Cerrada'));} 
    }
	
	 public function reporte_caja(){
			$obj = new caja();
			$data=array();
			$ingresos  = $obj->ingreso($_GET['id']);
			$egresos = $obj->egreso($_GET['id']);
			$fecha_max_movimiento = $obj->fecha_max_mov($_GET['id']);
			$saldo_caja = $obj->saldo_caja_apertura($_GET['id']);
			$data['ingresos']=$ingresos;
			$data['egresos']=$egresos;
			$data['monto_a']=$saldo_caja->monto_a;
			$data['fecha_a']=$saldo_caja->fecha_a;
			$data['fecha_c']=$saldo_caja->fecha_c;
			$data['fecha_reporte']= $_GET['fecha_reporte'];
			$data['idcaja']= $_GET['id'];
			$data['fecha_max_movimiento']= $fecha_max_movimiento->fecha;
            $view = new View();
			$view->setData($data);
			$view->setTemplate( 'view/caja/reporte_caja.php' );
			echo $view->renderPartial();
	}
	
	public function reporte_Grafico_caja()
    {
		$obj = new caja();
		
		$data = array();
		$series = array();
		$title = array();
		$subtitle = array();

		$Caja  = $obj->saldo_caja_apertura($_GET['id']);
		$Ingresos  = $obj->SUM_ingresos($_GET['id']);
		$Egresos  = $obj->SUM_egresos($_GET['id']);
		
		$dia=substr($Caja->fecha_a,8,2);
		$mes=substr($Caja->fecha_a,5,2);
		$anio=substr($Caja->fecha_a,0,4);
		  
		$fecha_caja = " $dia/$mes/$anio";
	
		//$enabled = true;//Acepta grafico 3D(true) o Grafico 2D(false)
		$title['text'] = 'REPORTE GRAFICO DE CAJA AL: '.$fecha_caja;
		$subtitle['text'] = 'Ingresos / Egresos';
		$series['type'] = 'pie';
		$series['name'] = 'Total';
		

			$ingreso_total = ($Ingresos->total+$Caja->monto_a);
			
			//Ingreso
			$array = array();			
			$array[] = 'Ingresos ';
			$array[] = $ingreso_total;
			$series['data'][] = $array;
			
			//Egreso
			$array2 = array();
			$array2[] = 'Egresos';
			$array2[] = $Egresos->total;
			$series['data'][] = $array2;
			
			$ganancia = ($ingreso_total - $Egresos->total);
			//Ganancia
			$array3 = array();
			$array3['name'] = 'Ganancia';
			$array3['y'] = $ganancia;
			$array3['sliced'] = true;
			$array3['selected'] = true;
			$series['data'][] = $array3;
		
		
		//$data['enabled'] = json_encode($enabled, JSON_NUMERIC_CHECK);
		$data['title'] = json_encode($title, JSON_NUMERIC_CHECK);
		$data['subtitle'] = json_encode($subtitle, JSON_NUMERIC_CHECK);
		$data['series'] = json_encode($series, JSON_NUMERIC_CHECK);
		
        $view = new View();
		$view->setData( $data );
        $view->setTemplate('view/caja/grafico_caja_torta.php');
        echo $view->renderPartial();
    }
	
}
?>