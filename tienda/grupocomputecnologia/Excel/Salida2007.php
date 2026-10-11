<?php

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
$TITLE = "REPORTE DE CAJA AL ".validar_fecha($saldo_a).".xlsX";
header("Content-Disposition: attachment;filename=$TITLE");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;