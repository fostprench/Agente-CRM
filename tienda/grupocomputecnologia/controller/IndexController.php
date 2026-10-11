<?php
	require_once 'lib/Controller.php';
	require_once 'lib/View.php';
	require_once 'lib/funciones.php';
	require_once 'model/Index.php';
   //require_once 'model/Sistema.php';
	class IndexController extends Controller 
	{
		public function Index() 
		{
			$Index = new Index();
			$data = array();
			$caja_aperturada = $Index->error_1();
			$fecha_a = $caja_aperturada->fecha_a;
			
			if($fecha_a == null){
				$mes_apertura=date('m');
			}else{
				$mes_apertura = mes($fecha_a);
				$anio_apertura = anio_completo($fecha_a);
			}			
			
			$mes_hoy = date('m');
			$Year = date('Y');
			
			if($Year>$anio_apertura){
				$data['html'] = '<div class="alert alert-danger alert-dismissable text-center">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Cuidado!</strong> La Caja Aperturada el mes anterior aun sigue aperturada en este mes.
				</div>';
			}else{
				if($mes_hoy > $mes_apertura){
					$data['html'] = '<div class="alert alert-danger alert-dismissable text-center">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Cuidado!</strong> La Caja Aperturada el mes anterior aun sigue aperturada en este mes.
					</div>';
				}
				if($mes_hoy < $mes_apertura){
					$data['html'] = '<div class="alert alert-danger alert-dismissable text-center">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Cuidado!</strong> Error en la Fecha del Sistema de Windows.
					</div>';
				}
			}
			
			
			$view = new View();
			$view->setData($data);
			$view->setTemplate('template/Layout.php');
			echo $view->renderPartial();
			
		}
		 
	}
?>
