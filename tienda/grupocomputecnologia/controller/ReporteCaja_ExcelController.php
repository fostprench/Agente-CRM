<?php
// SOLUCIÓN URGENTE: Aumentar memoria significativamente
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', 600);

require_once 'lib/Controller.php';
require_once 'lib/View.php';
require_once 'lib/funciones.php';
require_once 'Excel/PHPExcel.php';
require_once 'model/caja.php';

class ReporteCaja_ExcelController extends Controller
{

	public function reporte_caja_excel()
	{
		if ($_SESSION['insertar'] == 1) {
			$data = array();
			$data['idcaja'] = $_GET['id'];
			$data['fecha'] = $_GET['fecha_'];
			$view = new View();
			$view->setData($data);
			$view->setTemplate('view/caja/_frm_excel.php');
			echo $view->renderPartial();
		} else {
			echo
				"<script>alert('no tiene permiso para obtener reporte en excel');
			window.location='index.php';</script>";
		}
	}

	public function Style_Fila_EXCEL($BACKGROUND, $COLOR)
	{
		$styleArray_excel = array(
			'font' => array(
				'bold' => true,
				'color' => array(
					'rgb' => $COLOR,
				),
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => $BACKGROUND),
			),
		);

		return $styleArray_excel;
	}

	public function genera_reporte_excel()
	{

		$obj = new caja();
		$data = array();
		$ingresos = $obj->ingreso($_GET['id']);
		$egresos = $obj->egreso($_GET['id']);
		$fecha_max_movimiento = $obj->fecha_max_mov($_GET['id']);
		$saldo_caja = $obj->saldo_caja_apertura($_GET['id']);
		$monto_a = $saldo_caja->monto_a;
		$saldo_a = $saldo_caja->fecha_a;
		$fecha_c = $saldo_caja->fecha_c;
		$fecha_max_movimiento = $fecha_max_movimiento->fecha;

		$Background = array("F2DEDE", "DFF0D8", "F9D6EE", "D9EDF7", "FCF8E3");
		$colores = array("A94442", "3C763D", "DC6EB9", "31708F", '8A6D3B');

		list($anio, $mes, $dia) = explode('-', $_GET['fecha_']);
		list($anio_max, $mes_max, $dia_max) = explode('-', $fecha_max_movimiento);
		$nombre_mes = nombre_mes($mes);

		$total = 0;
		$cont = 0;
		$dia = (int) $dia;


		$objPHPExcel = new PHPExcel();

		//echo date('H:i:s') , " Renombrar primera hoja de calculo" , EOL;
		$objPHPExcel->getActiveSheet()->setTitle('Reporte de Caja');

		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
		$objPHPExcel->getDefaultStyle()->getFont()->setSize(8);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		// Combinar celdar y dar fomato !centrado!
		$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		// background a la celda combinada
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setRGB('428BCA');
		// color al texto de la celda combinada
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)
			//->setName('Verdana')
			->setSize(14)
			->getColor()->setRGB('ffffff');

		$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('COMPUTECNOLOGIA');
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);


		// Combinar celdar y dar fomato !centrado!
		$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
		$objPHPExcel->getActiveSheet()->getCell('A2')->setValue('INGRESOS');
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(14);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(17);

		// Combinar celdar y dar fomato !centrado!
		$objPHPExcel->getActiveSheet()->mergeCells('D2:H2');
		$objPHPExcel->getActiveSheet()->getCell('D2')->setValue('EGRESOS');

		$styleArray_A2H2 = array(
			'font' => array(
				'bold' => true,
				'color' => array(
					'rgb' => '3c763d'
				),
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => '3c763d'
					),
				),
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'C8E5BC'),
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArray_A2H2);


		$styleArray_A3H3 = array(
			'font' => array(
				'bold' => true,
				'size' => 10,
				'color' => array(
					'rgb' => 'FFFFFF'
				),
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => '9ACFEA'
					),
				),
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '428BCA'),
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($styleArray_A3H3);

		$objPHPExcel->getActiveSheet()->mergeCells('A3:B3');
		$objPHPExcel->getActiveSheet()->getCell('A3')->setValue('CAJA AL ' . validar_fecha($saldo_a));
		$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(17);

		$objPHPExcel->getActiveSheet()->getCell('C3')->setValue($monto_a);
		$objPHPExcel->getActiveSheet()->mergeCells('D3:H3');

		$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setSize(17);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);

		$objPHPExcel->getActiveSheet()->getStyle('A4:H4')->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'rotation' => 90,
					'color' => array(
						'argb' => 'FFA0A0A0'
					),
				)
			)
		);

		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'FECHA');
		$objPHPExcel->getActiveSheet()->setCellValue('B4', 'DETALLE DE INGRESO');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', 'MONTO');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', 'FECHA');
		$objPHPExcel->getActiveSheet()->setCellValue('E4', 'DETALLE DE EGRESO');
		$objPHPExcel->getActiveSheet()->setCellValue('F4', 'MONTO');
		$objPHPExcel->getActiveSheet()->setCellValue('G4', 'OPERACION');
		$objPHPExcel->getActiveSheet()->setCellValue('H4', 'OBSERVACIONES');

		//CONTADOR DE CELDA -- EL FORMATOEXCEL EMPIEZA A PARTIR DE LA LINEA 5
		$CELL_FILA = 5;

		for ($i = $dia; $i <= $dia_max; $i++) {
			$count_ingresos = 0;
			$count_egresos = 0;

			if ($i < 10) {
				$i = '0' . $i;
			}


			$fecha_generada = "$anio-$mes-$i";

			$data_ingresos = array();
			$data_egresos = array();

			foreach ($ingresos as $val) {
				if (in_array($fecha_generada, $val)) {
					$count_ingresos++;
					array_push($data_ingresos, $val);
				}
			}

			foreach ($egresos as $val) {
				if (in_array($fecha_generada, $val)) {
					$count_egresos++;
					array_push($data_egresos, $val);
				}
			}

			$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:H$CELL_FILA");
			$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", "$i DE $nombre_mes DEL $anio");
			$objPHPExcel->getActiveSheet()->getStyle("I$CELL_FILA")->getFont()->setSize(15);

			$Array_style = $this->Style_Fila_EXCEL($Background[$cont], $colores[$cont]);

			$objPHPExcel->getActiveSheet()->getStyle("A$CELL_FILA:H$CELL_FILA")->applyFromArray($Array_style);


			if ($count_ingresos > $count_egresos) {

				foreach ($data_ingresos as $key => $val) {

					$CELL_FILA++;//6

					$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:B$CELL_FILA");
					$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", $val[1]);
					$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", $val[2]);

					if ($key < $count_egresos) {

						$objPHPExcel->getActiveSheet()->mergeCells("D$CELL_FILA:E$CELL_FILA");
						$objPHPExcel->getActiveSheet()->setCellValue("D$CELL_FILA", $data_egresos[$key][1]);
						$objPHPExcel->getActiveSheet()->setCellValue("F$CELL_FILA", $data_egresos[$key][2]);
						$objPHPExcel->getActiveSheet()->setCellValue("G$CELL_FILA", $data_egresos[$key][3]);
						$objPHPExcel->getActiveSheet()->setCellValue("H$CELL_FILA", $data_egresos[$key][4]);

					} else {
						$objPHPExcel->getActiveSheet()->mergeCells("D$CELL_FILA:E$CELL_FILA");
						$objPHPExcel->getActiveSheet()->setCellValue("D$CELL_FILA", "");
						$objPHPExcel->getActiveSheet()->setCellValue("F$CELL_FILA", "");
						$objPHPExcel->getActiveSheet()->setCellValue("G$CELL_FILA", "");
						$objPHPExcel->getActiveSheet()->setCellValue("H$CELL_FILA", "");
					}

				}

				$CELL_FILA++;

				$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:B$CELL_FILA");
				$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->mergeCells("D$CELL_FILA:E$CELL_FILA");
				$objPHPExcel->getActiveSheet()->setCellValue("D$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("F$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("G$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("H$CELL_FILA", "");


			} else {

				foreach ($data_egresos as $key => $val) {

					$CELL_FILA++;//6

					if ($key < $count_ingresos) {

						$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:B$CELL_FILA");
						$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", $data_ingresos[$key][1]);
						$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", $data_ingresos[$key][2]);

					} else {
						$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:B$CELL_FILA");
						$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", "");
						$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", "");
					}
					$objPHPExcel->getActiveSheet()->mergeCells("D$CELL_FILA:E$CELL_FILA");
					$objPHPExcel->getActiveSheet()->setCellValue("D$CELL_FILA", $val[1]);
					$objPHPExcel->getActiveSheet()->setCellValue("F$CELL_FILA", $val[2]);
					$objPHPExcel->getActiveSheet()->setCellValue("G$CELL_FILA", $val[3]);
					$objPHPExcel->getActiveSheet()->setCellValue("H$CELL_FILA", $val[4]);

				}

				$CELL_FILA++;

				$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:B$CELL_FILA");
				$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->mergeCells("D$CELL_FILA:E$CELL_FILA");
				$objPHPExcel->getActiveSheet()->setCellValue("D$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("F$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("G$CELL_FILA", "");
				$objPHPExcel->getActiveSheet()->setCellValue("H$CELL_FILA", "");
			}

			$CELL_FILA++;
			$cont++;
			if ($cont == 5) {
				$cont = 0;
			}
		}

		$CELL_FILA++;// ?
		$cell_suma = $CELL_FILA - 1;
		$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:B$CELL_FILA");
		$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", "TOTAL INGRESOS: ");
		$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", "=SUM(C5:C$cell_suma) + C3");
		$objPHPExcel->getActiveSheet()->mergeCells("D$CELL_FILA:E$CELL_FILA");
		$objPHPExcel->getActiveSheet()->setCellValue("D$CELL_FILA", "TOTAL EGRESOS: ");
		$objPHPExcel->getActiveSheet()->setCellValue("F$CELL_FILA", "=SUM(F5:F$cell_suma)");
		$objPHPExcel->getActiveSheet()->getStyle("I$CELL_FILA:J$CELL_FILA")->getFont()->setSize(15);//celda ancha
		// Mensaje total ingresos
		$objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->setAuthor("PHPExcel");
		$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->getText()->createTextRun("REPORTE DE CAJA:");
		$objCommentRichText->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->getText()->createTextRun("\r\n");
		$objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->getText()->createTextRun("Monto Total de Ingresos");
		//mnsaje total de egresos
		$objPHPExcel->getActiveSheet()->getComment("F$CELL_FILA")->setAuthor("PHPExcel");
		$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment("F$CELL_FILA")->getText()->createTextRun("REPORTE DE CAJA:");
		$objCommentRichText->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getComment("F$CELL_FILA")->getText()->createTextRun("\r\n");
		$objPHPExcel->getActiveSheet()->getComment("F$CELL_FILA")->getText()->createTextRun("Monto Total de Egresos");

		$cell_total = $CELL_FILA;
		$CELL_FILA++;// ?

		$objPHPExcel->getActiveSheet()->mergeCells("A$CELL_FILA:B$CELL_FILA");
		$objPHPExcel->getActiveSheet()->setCellValue("A$CELL_FILA", "TOTAL DE CAJA: ");
		$objPHPExcel->getActiveSheet()->setCellValue("C$CELL_FILA", "=C$cell_total-F$cell_total");
		$objPHPExcel->getActiveSheet()->getStyle("I$CELL_FILA:J$CELL_FILA")->getFont()->setSize(15);//celda ancha

		$BOLD_TEXT = $CELL_FILA - 1;
		$objPHPExcel->getActiveSheet()->getStyle("A$BOLD_TEXT:H$CELL_FILA")->applyFromArray(
			array(
				'font' => array(
					'bold' => true,
					'size' => 9,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				)
			)
		);

		// mensaje saldo total de caja
		$objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->setAuthor("PHPExcel");
		$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->getText()->createTextRun("REPORTE DE CAJA:");
		$objCommentRichText->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->getText()->createTextRun("\r\n");
		$objPHPExcel->getActiveSheet()->getComment("C$CELL_FILA")->getText()->createTextRun("Saldo de Caja");

		$BORDE = $CELL_FILA - 3;
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				//outline
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
			),
		);
		$objPHPExcel->getActiveSheet()->getStyle("A5:H$BORDE")->applyFromArray($styleThinBlackBorderOutline);

		// SOLUCIÃ“N: Usar PCLZip en lugar de ZipArchive - COMENTADO
// PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

		if ($_GET['v'] == '2003') {
			require_once 'Excel/Salida2003.php';
		} elseif ($_GET['v'] == '2007') {
			require_once 'Excel/Salida2007.php';
		}
	}
}
?>

