<?php
require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'model/venta.php';
require_once 'model/Grid.php';
require_once('fpdf/fpdf.php');
require_once('lib/funciones.php');
define('FPDF_FONTPATH', 'fpdf/font/');
class VentaController extends Controller
{
	public function Index()
	{
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}//envia p=1 para que se habilite la opcion nuevo en el procedimiento almacenado
		if (!isset($_GET['q'])) {
			$_GET['q'] = "";
		}
		if (!isset($_GET['order'])) {
			$_GET['order'] = "";
		}
		$obj = new venta();
		$grilla = new Grilla();
		$data = array();
		$cabecera = $obj->getHead('v_venta');
		$data['data'] = $obj->index_P($_GET['q'], $_GET['p'], $cabecera, "v_venta", $_GET['order']);
		$data['query'] = $_GET['q'];
		$data['pag'] = $this->Pagination(array('rows' => $data['data']['rowspag'], 'url' => 'controller=Venta&action=Index', 'query' => $_GET['q'], 'order' => $_GET['order']));
		$obj->session(14);
		$titulo = $_GET['controller'] . 's Registradas';
		$data['grilla'] = $grilla->asign($_GET['q'], $titulo, $_GET['controller'], $cabecera, $data['data']['rows'], $data['pag'], $data['data']['total'], true, true);
		$data['controller'] = $_GET['controller'];
		$view = new View();
		$view->setData($data);
		$view->setTemplate('view/master/grilla.php');
		$view->setLayout('template/Layout.php');
		echo $view->renderPartial();
		//$view->render();
	}
	public function search()
	{
		$obj = new venta();
		$columnas = $obj->getHead('v_venta');
		$data = array();
		$view = new View();
		$data['value'] = $obj->Search_P($_GET["term"], $columnas, "v_venta");
		$data['num'] = $columnas;
		$view->setData($data);
		$view->setTemplate('view/_Json.php');
		echo $view->renderPartial();
	}

	public function create()
	{
		if ($_SESSION['insertar'] == 1) {
			$obj = new venta();
			$data = array();
			$caja = $obj->idMax();
			if ($caja->max == NULL) {
				$data['mensaje'] = false;
				$data['msg'] = ' PARA PODER HACER UN REGISTRO DE VENTA DEBE APERTURAR LA CAJA';
			} else {
				$data['mensaje'] = true;
			}
			$data['p'] = 1;
			$data['titulo'] = "REGISTRO DE VENTA";
			$data['tipo_c'] = $this->Select(array('id' => 'tipo_c', 'name' => 'tipo_c', 'table' => 'tipo_comprobante', 'code' => '0'));
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/venta/_frm.php');
			echo $view->renderPartial();
		} else {
			echo
				"<script>alert('no tiene permiso para insertar');
				window.location='index.php';</script>";
		}
	}
	public function validar_comprobante()
	{
		$obj = new venta();
		print_r(json_encode($obj->validar_comprobante_venta($_GET['nro_comp'])));
	}

	public function create_servicio()
	{
		if ($_SESSION['insertar'] == 1) {
			$obj = new venta();
			$data = array();
			$caja = $obj->idMax();
			if ($caja->max == NULL) {
				$data['mensaje'] = false;
				$data['msg'] = ' PARA PODER HACER UN REGISTRO DE VENTA DEBE APERTURAR LA CAJA';
			} else {
				$data['mensaje'] = true;
			}
			$data['p'] = 1;
			$data['titulo'] = "REGISTRO DE VENTA DE SERVICIO";
			$data['tipo_c'] = $this->Select(array('id' => 'tipo_c', 'name' => 'tipo_c', 'table' => 'tipo_comprobante', 'code' => '0'));
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/venta/_frm_servicio.php');
			echo $view->renderPartial();
		} else {
			echo
				"<script>alert('no tiene permiso para insertar');
					window.location='index.php';</script>";
		}
	}
	public function _edit() // FALTA VERIFICAR QUE CUANDO ES VENTA X COBRAR O X PEDIR NO EDITAR
	{
		if ($_SESSION['editar'] == 1) {
			$obj = new venta();
			$data = array();
			$verifica_caja = $obj->estado_caja($_GET['id']);
			$tipo_venta = $obj->estado_venta($_GET['id']); //TIPO VENTA: CONTADO,POR COBRAR, POR PEDIR
			if ($verifica_caja->estado == 0) {
				$data['mensaje'] = false;
				$data['msg'] = 'No se puede editar por que la caja ya fue Cerrada';
			} else {

				if ($tipo_venta->tipo_venta == 1) {
					$data['mensaje'] = true;
					$_venta = $obj->datos_v($_GET['id']);
					$data['obj'] = $_venta;
					$detalle = $obj->datos_d($_GET['id']);
					$data['detalle'] = $detalle;
					$data['p'] = 2;
					$data['titulo'] = "EDITAR VENTA";
					$data['tipo_c'] = $this->Select(array('id' => 'tipo_c', 'name' => 'tipo_c', 'table' => 'tipo_comprobante', 'code' => $_venta->tipo_c));
				}
				if ($tipo_venta->tipo_venta == 2) {
					$data['mensaje'] = false;
					$data['msg'] = ' No se puede editar venta por cobrar';
				}
				if ($tipo_venta->tipo_venta == 3) {
					$data['mensaje'] = false;
					$data['msg'] = ' No se puede editar venta por pedir';
				}

			}
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/venta/_frmedit.php');
			echo $view->renderPartial();
		} else {
			echo
				"<script>alert('no tiene permiso para editar');
			window.location='index.php';</script>";
		}
	}

	public function save()
	{
		$obj = new venta();
		print_r(json_encode($obj->regventa($_POST)));
		// print_r(json_encode(($_POST)));
	}
	public function delete_item()
	{
		$obj = new venta();
		print_r(json_encode($obj->elimina_item($_GET)));
	}
	public function show()
	{
		if ($_SESSION['acceder'] == 1) {
			$obj = new venta();
			$data = array();
			$_venta = $obj->datos_v($_GET['id']);
			$data['obj'] = $_venta;
			$detalle = $obj->datos_d($_GET['id']);
			$data['detalle'] = $detalle;
			$data['p'] = 2;
			$data['titulo'] = "VENTA REGISTRADA";
			$data['tipo_c'] = $this->Select(array('id' => 'tipo_c', 'name' => 'tipo_c', 'table' => 'tipo_comprobante', 'code' => $_venta->tipo_c));
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/venta/_show.php');
			echo $view->renderPartial();
		}
	}

	// http://chart.googleapis.com/chart?cht=p3&chd=t:80,20&chs=250x100&chl=Hello|World
	public function _prinft()
	{

		$obj = new venta();
		$data = array();
		$datos_venta = $obj->datos_v($_GET['id']);
		$detalle_venta = $obj->datos_d($_GET['id']);
		$series = $obj->lista_series($_GET['id']);
		$lista_Bancos = $obj->listaBancos();

		$total = count($detalle_venta);


		// print_r($lista_Bancos);
		// return;




		$pdf = new FPDF('P', 'mm', 'A4');
		$pdf->SetAutoPageBreak(false);
		$pdf->AddPage();

		if ($datos_venta->tipo_c == 1) {// BOLETA	

			$nro = $datos_venta->nro_comprobante;
			list($a, $b) = explode('-', $nro);

			// $pdf->SetFont('helvetica','B',20);
			$pdf->SetFillColor(255, 255, 255);

			$pdf->SetXY(152, 24);
			$pdf->Cell(35, 8, strtoupper(UTF8_DECODE($b)), 0, 'J', false);

			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetFillColor(255, 255, 255);

			$pdf->SetXY(19, 47);//46
			$pdf->Cell(132, 4, strtoupper(UTF8_DECODE($datos_venta->cliente)), 0, 'J', false);
			$pdf->Cell(27, 4, strtoupper(UTF8_DECODE($datos_venta->ruc)), 0, 'J', false);

			$pdf->SetXY(22, 53);//52
			$pdf->Cell(129, 4, strtoupper(UTF8_DECODE($datos_venta->direccion)), 0, 'J', false);
			$pdf->Cell(27, 4, fecha_venta($datos_venta->fecha), 0, 0, 'L');

			// $pdf->SetFont('helvetica','',9);
			$i = 63;//64
			foreach ($detalle_venta as $key => $val) {
				$pdf->SetXY(6, $i);

				if ($val[3] <= 9) {
					$cant = "0$val[3]";
				} else {
					$cant = $val[3];
				}

				$pdf->Cell(11, 5, $cant, 0, 0, 'C');
				$pdf->Cell(121, 5, strtoupper(UTF8_DECODE($val[1])), 0, 0, 'L', 0);
				$pdf->Cell(18, 5, $val[2], 0, 0, 'R', 1);
				$pdf->Cell(15, 5, $val[4], 0, 0, 'R', 1);
				$i = $i + 4;
			}
			$i++;
			if (count($series) > 0) {
				$data = "";
				foreach ($series as $key => $val) {
					$data .= $val[0] . ' ';
				}
				$pdf->SetXY(21, $i);
				$pdf->MultiCell(135, 5, 'SERIES. ' . strtoupper($data), 0, 'J', false);
			}

			$pdf->SetXY(73, 154);//166
			$pdf->Cell(22, 5, fecha_venta($datos_venta->fecha), 0, 0, 'C');

			$pdf->SetFont('helvetica', 'B', 9);

			$pdf->SetXY(148, 145);//166
			$pdf->Cell(25, 5, $datos_venta->total, 0, 0, 'R');

		} else if ($datos_venta->tipo_c == 2) {

			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetXY(15, 51);
			$pdf->Cell(170, 4, strtoupper(UTF8_DECODE($datos_venta->cliente)), 0, 'J', false);

			$pdf->SetXY(19, 57);
			$pdf->Cell(170, 4, strtoupper(UTF8_DECODE($datos_venta->direccion)), 0, 'J', false);

			$pdf->SetXY(16, 63);
			$pdf->Cell(120, 4, strtoupper(UTF8_DECODE($datos_venta->ruc)), 0, 'J', false);
			$pdf->Cell(28, 4, fecha_venta($datos_venta->fecha), 0, 0, 'C');

			$i = 72;
			foreach ($detalle_venta as $key => $val) {
				$pdf->SetXY(5, $i);

				if ($val[3] <= 9) {
					$cant = "0$val[3]";
				} else {
					$cant = $val[3];
				}

				$pdf->Cell(13, 5, $cant, 0, 0, 'C');
				$pdf->Cell(119, 5, strtoupper(UTF8_DECODE($val[1])), 0, 0, 'L', 0);
				$pdf->Cell(18, 5, $val[2], 0, 0, 'R', 1);
				$pdf->Cell(18, 5, $val[4], 0, 0, 'R', 1);
				$i = $i + 4;
			}

			if (count($series) > 0) {
				$data = "";
				foreach ($series as $key => $val) {
					$data .= $val[0] . ' ';
				}
				$pdf->SetXY(25, $i);
				$pdf->MultiCell(135, 4, 'SERIES. ' . strtoupper($data), 0, 'J', false);
			}

			$pdf->SetXY(75, 151);
			$pdf->Cell(24, 5, fecha_venta($datos_venta->fecha), 0, 0, 'C');

			$pdf->SetXY(17, 134);
			$pdf->Cell(123, 5, converter($datos_venta->total), 0, 0, 'L');

			$pdf->SetFont('helvetica', 'B', 9);

			$pdf->SetXY(155, 135);
			$pdf->Cell(20, 5, $datos_venta->total, 0, 0, 'C');

			$pdf->SetXY(155, 142);
			$pdf->Cell(20, 5, "0.00", 0, 0, 'C');

			$pdf->SetXY(155, 149);
			$pdf->Cell(20, 5, $datos_venta->total, 0, 0, 'C');

		} else {

			$pdf->Image("web/images/logo2.jpg", 20, 15, 55, '17');
			$pdf->SetFont('helvetica', 'B', 6);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetXY(20, 36);
			$pdf->Cell(100, 4, strtoupper(UTF8_DECODE($_SESSION['empresa'])), 0, 0, 'L');
			$pdf->SetFont('helvetica', '', 6);
			$pdf->SetXY(20, 40);
			$pdf->MultiCell(100, 4, strtoupper(UTF8_DECODE($_SESSION['descripcion'])), 0, 'L', 1);
			$pdf->SetXY(20, 44);
			$pdf->MultiCell(100, 4, strtoupper(UTF8_DECODE($_SESSION['direccion'])), 0, 'L', 1);
			$pdf->SetXY(20, 48);
			$pdf->MultiCell(100, 4, strtoupper(UTF8_DECODE($_SESSION['telefono'])), 0, 'L', 1);

			// Definir el ancho y alto del rectángulo
			$rectX = 120;
			$rectY = 8;
			$rectWidth = 75;
			$rectHeight = 20;

			// Dibujar una barra en el medio
			$pdf->SetFillColor(0, 102, 204); // Azul
			$pdf->Rect($rectX, $rectY + 15, $rectWidth, 10, 'F'); // Rectángulo azul

			// Configurar la fuente para el texto "PROFORMA"
			$pdf->SetFont('Arial', 'B', 14);
			$pdf->SetTextColor(255, 255, 255); // Color blanco para la barra
			$pdf->SetXY($rectX, $rectY + 15);
			$pdf->Cell($rectWidth, 10, 'NOTA DE VENTA', 0, 0, 'C');

			// Restaurar color para el texto siguiente
			$pdf->SetTextColor(0, 0, 0);

			// Configurar la fuente para el código "PRO - 2024 002971"
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetXY($rectX, $rectY + 25); // Ajustar posición
			$pdf->Cell($rectWidth, 10, 'NRO. ' . date("Y", strtotime($datos_venta->fecha)) . '-' . $datos_venta->idventa, 0, 0, 'C');
			$pdf->SetXY(20, 55);
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(20, 5, UTF8_DECODE('SEÑOR(ES): '), 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(160, 5, strtoupper(UTF8_DECODE($datos_venta->cliente)), 0, 0, 'L');

			$pdf->ln();
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->SetX(20);
			$pdf->Cell(20, 5, UTF8_DECODE('DIRECCIÓN: '), 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(160, 5, strtoupper(UTF8_DECODE($datos_venta->direccion)), 0, 0, 'L');

			$pdf->ln();
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->SetX(20);
			$pdf->Cell(20, 5, 'FECHA: ', 0, 0, 'L');
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(160, 5, fecha_venta($datos_venta->fecha), 0, 0, 'L');

			$pdf->ln(8);
			// Encabezado de la tabla
			$pdf->SetFillColor(0, 102, 204); // Color azul
			$pdf->SetTextColor(255, 255, 255); // Texto blanco
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->SetX(20);
			$pdf->Cell(15, 7, 'UM', 1, 0, 'C', true);
			$pdf->Cell(100, 7, UTF8_DECODE('DESCRIPCIÓN'), 1, 0, 'C', true);
			$pdf->Cell(20, 7, 'CANT.', 1, 0, 'C', true);
			$pdf->Cell(20, 7, 'P. UNIT.', 1, 0, 'C', true);
			$pdf->Cell(20, 7, 'IMPORTE', 1, 0, 'C', true);

			// Restaurar color para el texto siguiente
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255); // Color blanco
			$pdf->SetFont('Arial', '', 6);

			$total = 0;
			foreach ($detalle_venta as $key => $val) {
				$pdf->ln();
				$pdf->SetX(20);
				$pdf->Cell(15, 5, 'NIU', 1, 0, 'C', 1);
				$pdf->Cell(100, 5, mb_strtoupper($val['producto'], 'UTF-8'), 1, 0, 'L', 1);
				$pdf->Cell(20, 5, $val['cantidad'], 1, 0, 'C', 1);
				$pdf->Cell(20, 5, $val['precio'], 1, 0, 'R', 1);
				$pdf->Cell(20, 5, $val['subtotal'], 1, 0, 'R', 1);
				$total += $val['subtotal'];
			}

			$pdf->SetFont('Arial', 'B', 8);

			$pdf->ln(10);
			$pdf->SetX(20);
			$pdf->Cell(115, 5, "", 0, 0, 'L', 1);
			$pdf->Cell(20, 5, "TOTAL:", 0, 0, 'C', 1);
			$pdf->Cell(20, 5, "S/", 0, 0, 'R', 1);
			$pdf->Cell(20, 5, number_format($total, 2, '.', ','), 0, 0, 'R', 1);

			if (isset($datos_venta->observacion) && trim($datos_venta->observacion) !== '') {
				$pdf->ln(10);
				$pdf->SetX(20);
				$pdf->Cell(175, 5, "OBSERVACIONES:", 0, 0, 'L', 1);

				$pdf->SetFont('Arial', '', 7);

				$pdf->ln();
				$pdf->SetX(20);
				$pdf->MultiCell(175, 7, mb_strtoupper($datos_venta->observacion, 'UTF-8'), 0, 'L', 0);
			}

			$pdf->SetFont('Arial', 'B', 8);

			$pdf->ln(10);
			$pdf->SetX(20);
			$pdf->Cell(100, 5, "CUENTAS BANCARIAS", 0, 0, 'L', 1);

			$pdf->ln();
			$pdf->SetX(20);
			$pdf->Cell(70, 5, "BANCO", 0, 0, 'L', 1);
			$pdf->Cell(20, 5, "MONEDA", 0, 0, 'L', 1);
			$pdf->Cell(40, 5, "NUMERO CUENTA", 0, 0, 'L', 1);
			$pdf->Cell(40, 5, "CCI", 0, 0, 'L', 1);


			$pdf->SetFont('Arial', '', 7);
			foreach ($lista_Bancos as $key => $val) {
				$pdf->ln();
				$pdf->SetX(20);
				$pdf->Cell(70, 5, mb_strtoupper($val['descripcion'], 'UTF-8'), 0, 0, 'L', 1);
				$pdf->Cell(20, 5, mb_strtoupper($val['moneda'], 'UTF-8'), 0, 0, 'L', 1);
				$pdf->Cell(40, 5, mb_strtoupper($val['numerocuenta'], 'UTF-8'), 0, 0, 'L', 1);
				$pdf->Cell(40, 5, mb_strtoupper($val['cci'], 'UTF-8'), 0, 0, 'L', 1);
			}
		}
		$pdf->Output();

	}
	public function q1()
	{
		print_r($_POST);

	}
	public function _delete()
	{
		if ($_SESSION['delete'] == 1) {
			$obj = new venta();
			print_r(json_encode($obj->deleteventa($_GET['id'])));
		} else {
			echo
				"<script>alert('no tiene permiso para eliminar');
			window.location='index.php';</script>";
		}
	}
	public function mostrar_p()
	{

		$q = trim($_GET['q']);
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}
		if (!isset($q)) {
			$q = "";
		}
		if (!isset($_GET['order'])) {
			$_GET['order'] = "";
		}
		$obj = new venta();
		$data = array();
		$cabecera = $obj->getHead('v_productos_inventario');
		$data['cabecera'] = $cabecera;
		$data['data'] = $obj->index_P($q, $_GET['p'], $cabecera, "v_productos_inventario", $_GET['order']);
		$data['rows'] = $data['data']['rows'];
		$data['consulta'] = $data['data']['consulta'];
		$data['query'] = $q;
		$data['action'] = 'mostrar_p';
		$data['idPerfil'] = $_SESSION['id_perfil'];
		$data['pag'] = $this->Pagination_l(array('rows' => $data['data']['rowspag'], 'url' => 'controller=Venta&action=mostrar_p', 'query' => $q));
		$view = new View();
		$view->setData($data);
		$view->setTemplate('view/venta/producto.php');
		echo $view->renderPartial();
	}
	public function mostrar_p_sin_stock()
	{
		$q = trim($_GET['q']);
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}
		if (!isset($q)) {
			$q = "";
		}
		if (!isset($_GET['order'])) {
			$_GET['order'] = "";
		}
		$obj = new venta();
		$data = array();
		$cabecera = $obj->getHead('v_productos_sininventario');
		$data['cabecera'] = $cabecera;
		$data['data'] = $obj->index_P($q, $_GET['p'], $cabecera, "v_productos_sininventario", $_GET['order']);
		$data['rows'] = $data['data']['rows'];
		$data['consulta'] = $data['data']['consulta'];
		$data['query'] = $q;
		$data['action'] = 'mostrar_p';
		$data['idPerfil'] = $_SESSION['id_perfil'];
		$data['pag'] = $this->Pagination_l(array('rows' => $data['data']['rowspag'], 'url' => 'controller=Venta&action=mostrar_p', 'query' => $q));
		$view = new View();
		$view->setData($data);
		$view->setTemplate('view/venta/producto.php');
		echo $view->renderPartial();
	}
	public function mostrar_p_total()
	{ //LISTA DE PRODUCTOS VENTAS POR PEDIR
		$q = trim($_GET['q']);
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}
		if (!isset($q)) {
			$q = "";
		}
		if (!isset($_GET['order'])) {
			$_GET['order'] = "";
		}
		$obj = new venta();
		$data = array();
		$cabecera = $obj->getHead('v_productos_inventario_agotado');
		$data['cabecera'] = $cabecera;
		$data['data'] = $obj->index_P($q, $_GET['p'], $cabecera, "v_productos_inventario_agotado", $_GET['order']);
		$data['rows'] = $data['data']['rows'];
		$data['consulta'] = $data['data']['consulta'];
		$data['query'] = $q;
		$data['action'] = 'mostrar_p_total';
		$data['pag'] = $this->Pagination_l(array('rows' => $data['data']['rowspag'], 'url' => 'controller=Venta&action=mostrar_p_total', 'query' => $q));
		$view = new View();
		$view->setData($data);
		$view->setTemplate('view/venta/producto.php');
		echo $view->renderPartial();
	}
	public function mostrar_otros_proforma()
	{ //LISTA DE PRODUCTOS CON PRECIO COSTO, PROFORMA OTROS
		$q = trim($_GET['q']);
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}
		if (!isset($q)) {
			$q = "";
		}
		if (!isset($_GET['order'])) {
			$_GET['order'] = "";
		}
		$obj = new venta();
		$data = array();
		$cabecera = $obj->getHead('v_productos_inventario_agotado');
		$data['cabecera'] = $cabecera;
		$data['data'] = $obj->index_P($q, $_GET['p'], $cabecera, "v_productos_inventario_agotado", $_GET['order']);
		$data['rows'] = $data['data']['rows'];
		$data['consulta'] = $data['data']['consulta'];
		$data['query'] = $q;
		$data['action'] = 'mostrar_otros_proforma';
		$data['pag'] = $this->Pagination_l(array('rows' => $data['data']['rowspag'], 'url' => 'controller=Venta&action=mostrar_otros_proforma', 'query' => $q));
		$view = new View();
		$view->setData($data);
		$view->setTemplate('view/venta/producto_otros.php');
		echo $view->renderPartial();
	}
	public function mostrar_p_total_obs()
	{ //LISTA DE PRODUCTOS VENTAS POR PEDIR
		$q = trim($_GET['q']);
		if (!isset($_GET['p'])) {
			$_GET['p'] = 1;
		}
		if (!isset($q)) {
			$q = "";
		}
		if (!isset($_GET['order'])) {
			$_GET['order'] = "";
		}
		$obj = new venta();
		$data = array();
		$cabecera = $obj->getHead('v_productos_inventario_agotado');
		$data['cabecera'] = $cabecera;
		$data['data'] = $obj->index_P($q, $_GET['p'], $cabecera, "v_productos_inventario_agotado", $_GET['order']);
		$data['rows'] = $data['data']['rows'];
		$data['consulta'] = $data['data']['consulta'];
		$data['query'] = $q;
		$data['action'] = 'mostrar_p_total_obs';
		$data['pag'] = $this->Pagination_l(array('rows' => $data['data']['rowspag'], 'url' => 'controller=Venta&action=mostrar_p_total_obs', 'query' => $q));
		$view = new View();
		$view->setData($data);
		$view->setTemplate('view/venta/producto_obsequio.php');
		echo $view->renderPartial();
	}
}
?>