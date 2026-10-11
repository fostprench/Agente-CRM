<?php

function formatNumero($num){
$formatNumeroMoneda = number_format((float)$num, 2, '.', '');
return $formatNumeroMoneda;
}

function diasMes($month,$year) {
	$dias  = date("d",mktime(0,0,0,$month+1,0,$year));
	return $dias;
}


function nombre_mes($opc){
	switch($opc){
		case '01': return "ENERO"; break;
		case '02': return "FEBRERO"; break;
		case '03': return "MARZO"; break;
		case '04': return "ABRIL"; break;
		case '05': return "MAYO"; break;
		case '06': return "JUNIO"; break;
		case '07': return "JULIO"; break;
		case '08': return "AGOSTO"; break;
		case '09': return "SEPTIEMBRE"; break;
		case '10': return "OCTUBRE"; break;
		case '11': return "NOVIEMBRE"; break;
		case '12': return "DICIEMBRE"; break;
		default: return "MES NO VALIDO";break;
	}	
}

function fecha_time($fecha){
	list($f,$t) = explode(" ",$fecha);
	$dia=substr($f,8,2);
	$mes=substr($f,5,2);
	$anio=substr($f,0,4);
	return "$dia-$mes-$anio ".$t;
}

function validar_fecha($fecha){
$fecha = strtotime($fecha);
$anio = (date('Y',$fecha));
$mes = (date('m',$fecha));
$dia =(date('d',$fecha));
return $dia.'-'.$mes.'-'.$anio;
}

function fecha_es($fecha)
{
  $dia=substr($fecha,8,2);
  $mes=substr($fecha,5,2);
  $anio=substr($fecha,0,4);
  
  return "$dia/$mes/$anio";
}

function fecha_venta($fecha)
{
  $dia=substr($fecha,8,2);
  $mes=substr($fecha,5,2);
  $anio=substr($fecha,0,4);
  
  return "$dia/$mes/$anio";
}  
  function fecha_en($fecha)
{
  $dia=substr($fecha,0,2);
  $mes=substr($fecha,3,2);
  $anio=substr($fecha,6,4);
  
  return "$anio/$mes/$dia";
}

function dia($fecha){
  $dia=substr($fecha,8,2);
  return "$dia";
}
function mes($fecha){
  $mes=substr($fecha,5,2);
  return "$mes";
}
function anio($fecha){
  $anio=substr($fecha,2,2);
  return "$anio";
}

function anio_completo($fecha){
  $anio=substr($fecha,0,4);
  return "$anio";
}


//convertir un  numero a letras 
function converter($tt){

$tt = $tt+0.009;
$Numero = intval($tt);
$Decimales = $tt - Intval($tt);
$Decimales= $Decimales*100;
$Decimales= Intval($Decimales);
$x=NumerosALetras($Numero);
$letras = $x;
If ($Decimales > 0){

$y=NumerosALetras($Decimales);
$letras = $letras." soles con ".$y." centavos";
}
else {
$letras = $letras."con 00/100 Soles";
}
return $letras;
}

function Centenas($VCentena) { 
$Numeros[0] = "Cero";
$Numeros[1] = "Uno";
$Numeros[2] = "Dos";
$Numeros[3] = "Tres";
$Numeros[4] = "Cuatro";
$Numeros[5] = "Cinco";
$Numeros[6] = "Seis";
$Numeros[7] = "Siete";
$Numeros[8] = "Ocho";
$Numeros[9] = "Nueve";
$Numeros[10] = "Diez";
$Numeros[11] = "Once";
$Numeros[12] = "Doce";
$Numeros[13] = "Trece";
$Numeros[14] = "Catorce";
$Numeros[15] = "Quince";
$Numeros[20] = "Veinte";
$Numeros[30] = "Treinta";
$Numeros[40] = "Cuarenta";
$Numeros[50] = "Cincuenta";
$Numeros[60] = "Sesenta";
$Numeros[70] = "Setenta";
$Numeros[80] = "Ochenta";
$Numeros[90] = "Noventa";
$Numeros[100] = "Ciento";
$Numeros[101] = "Quinientos";
$Numeros[102] = "Setecientos";
$Numeros[103] = "Novecientos";
If ($VCentena == 1) { return $Numeros[100]; }
Else If ($VCentena == 5) { return $Numeros[101];}
Else If ($VCentena == 7 ) {return ( $Numeros[102]); }
Else If ($VCentena == 9) {return ($Numeros[103]);}
Else {return $Numeros[$VCentena];}

}



function Unidades($VUnidad) {
$Numeros[0] = "Cero";
$Numeros[1] = "Un";
$Numeros[2] = "Dos";
$Numeros[3] = "Tres";
$Numeros[4] = "Cuatro";
$Numeros[5] = "Cinco";
$Numeros[6] = "Seis";
$Numeros[7] = "Siete";
$Numeros[8] = "Ocho";
$Numeros[9] = "Nueve";
$Numeros[10] = "Diez";
$Numeros[11] = "Once";
$Numeros[12] = "Doce";
$Numeros[13] = "Trece";
$Numeros[14] = "Catorce";
$Numeros[15] = "Quince";
$Numeros[20] = "Veinte";
$Numeros[30] = "Treinta";
$Numeros[40] = "Cuarenta";
$Numeros[50] = "Cincuenta";
$Numeros[60] = "Sesenta";
$Numeros[70] = "Setenta";
$Numeros[80] = "Ochenta";
$Numeros[90] = "Noventa";
$Numeros[100] = "Ciento";
$Numeros[101] = "Quinientos";
$Numeros[102] = "Setecientos";
$Numeros[103] = "Novecientos";

$tempo=$Numeros[$VUnidad]; 
return $tempo;
}

function Decenas($VDecena) {
$Numeros[0] = "cero";
$Numeros[1] = "uno";
$Numeros[2] = "dos";
$Numeros[3] = "tres";
$Numeros[4] = "cuatro";
$Numeros[5] = "cinco";
$Numeros[6] = "seis";
$Numeros[7] = "siete";
$Numeros[8] = "ocho";
$Numeros[9] = "nueve";
$Numeros[10] = "diez";
$Numeros[11] = "Once";
$Numeros[12] = "Doce";
$Numeros[13] = "Trece";
$Numeros[14] = "Catorce";
$Numeros[15] = "Quince";
$Numeros[20] = "Veinte";
$Numeros[30] = "Treinta";
$Numeros[40] = "Cuarenta";
$Numeros[50] = "Cincuenta";
$Numeros[60] = "Sesenta";
$Numeros[70] = "Setenta";
$Numeros[80] = "Ochenta";
$Numeros[90] = "Noventa";
$Numeros[100] = "Ciento";
$Numeros[101] = "Quinientos";
$Numeros[102] = "Setecientos";
$Numeros[103] = "Novecientos";
$tempo =	($Numeros[$VDecena]);
return $tempo;
}




function NumerosALetras($Numero){ 


$Decimales = 0;
//$Numero = intval($Numero);
$letras = "";

while ($Numero != 0){

// '*---> Validación si se pasa de 100 millones

If ($Numero >= 1000000000) {
$letras = "Error en Conversión a Letras";
$Numero = 0;
$Decimales = 0;
}

// '*---> Centenas de Millón
If (($Numero < 1000000000) And ($Numero >= 100000000)){
If ((Intval($Numero / 100000000) == 1) And (($Numero - (Intval($Numero / 100000000) * 100000000)) < 1000000)){
$letras .= (string) "cien millones ";
}
Else {
$letras = $letras & Centenas(Intval($Numero / 100000000));
If ((Intval($Numero / 100000000) <> 1) And (Intval($Numero / 100000000) <> 5) And (Intval($Numero / 100000000) <> 7) And (Intval($Numero / 100000000) <> 9)) {
$letras .= (string) "cientos ";
}
Else {
$letras .= (string) " ";
} 
}
$Numero = $Numero - (Intval($Numero / 100000000) * 100000000);
}

// '*---> Decenas de Millón
If (($Numero < 100000000) And ($Numero >= 10000000)) {
If (Intval($Numero / 1000000) < 16) {
$tempo = Decenas(Intval($Numero / 1000000));
$letras .= (string) $tempo; 
$letras .= (string) " millones ";
$Numero = $Numero - (Intval($Numero / 1000000) * 1000000);
}
Else {	
$letras = $letras & Decenas(Intval($Numero / 10000000) * 10);
$Numero = $Numero - (Intval($Numero / 10000000) * 10000000);
If ($Numero > 1000000) {
$letras .= $letras & " y ";
}
}
}

// '*---> Unidades de Millón
If (($Numero < 10000000) And ($Numero >= 1000000)) {
$tempo=(Intval($Numero / 1000000));
If ($tempo == 1) {	
$letras .= (string) " un millón ";
}	
Else {
$tempo= Unidades(Intval($Numero / 1000000));
$letras .= (string) $tempo; 
$letras .= (string) " millones ";
}
$Numero = $Numero - (Intval($Numero / 1000000) * 1000000);
}

// '*---> Centenas de Millar
If (($Numero < 1000000) And ($Numero >= 100000)) {
$tempo=(Intval($Numero / 100000));
$tempo2=($Numero - ($tempo * 100000));
If (($tempo == 1) And ($tempo2 < 1000)) {
$letras .= (string) "cien mil ";
}	
Else {
$tempo=Centenas(Intval($Numero / 100000));
$letras .= (string) $tempo;
$tempo=(Intval($Numero / 100000));
If (($tempo <> 1) And ($tempo <> 5) And ($tempo <> 7) And ($tempo <> 9)) {
$letras .= (string) "cientos ";
}	
Else { 
$letras .= (string) " ";
}
}
$Numero = $Numero - (Intval($Numero / 100000) * 100000);
}

// '*---> Decenas de Millar
If (($Numero < 100000) And ($Numero >= 10000)) {
$tempo= (Intval($Numero / 1000));
If ($tempo < 16) {
$tempo = Decenas(Intval($Numero / 1000)); 
$letras .= (string) $tempo;
$letras .= (string) " mil ";
$Numero = $Numero - (Intval($Numero / 1000) * 1000);
}
Else {
$tempo = Decenas(Intval($Numero / 10000) * 10);
$letras .= (string) $tempo;
$Numero = $Numero - (Intval(($Numero / 10000)) * 10000);
If ($Numero > 1000) {
$letras .= (string) " y ";	
}
Else {
$letras .= (string) " mil ";

}
}
}


// '*---> Unidades de Millar
If (($Numero < 10000) And ($Numero >= 1000)) {
$tempo=(Intval($Numero / 1000));
If ($tempo == 1) {
$letras .= (string) "Un";
}	
Else {
$tempo = Unidades(Intval($Numero / 1000));
$letras .= (string) $tempo;
}
$letras .= (string) " Mil ";
$Numero = $Numero - (Intval($Numero / 1000) * 1000);
}

// '*---> Centenas
If (($Numero < 1000) And ($Numero > 99)) {	
If ((Intval($Numero / 100) == 1) And (($Numero - (Intval($Numero / 100) * 100)) < 1)) {	
$letras .=  "Cien";
}	
Else {	
$temp=(Intval($Numero / 100));	
$l2=Centenas($temp);	
$letras .= (string) $l2;	
If ((Intval($Numero / 100) <> 1) And (Intval($Numero / 100) <> 5) And (Intval($Numero / 100) <> 7) And (Intval($Numero / 100) <> 9)) {
$letras .= "cientos";
}	
Else {
$letras .= (string) " ";
}
}

$Numero = $Numero - (Intval($Numero / 100) * 100);

}

// '*---> Decenas
If (($Numero < 100) And ($Numero > 9) ) {
If ($Numero < 16 ) {
$tempo = Decenas(Intval($Numero));
$letras .= $tempo;
$Numero = $Numero - Intval($Numero);
}	
Else {	
$tempo= Decenas(Intval(($Numero / 10)) * 10);
$letras .= (string) $tempo;	
$Numero = $Numero - (Intval(($Numero / 10)) * 10);
If ($Numero > 0.99) {
$letras .=(string) " y ";

}
}
}

// '*---> Unidades
If (($Numero < 10) And ($Numero > 0.99)) {
$tempo=Unidades(Intval($Numero));
$letras .= (string) $tempo;

$Numero = $Numero - Intval($Numero);
}


// '*---> Decimales
If ($Decimales > 0) {

// $letras .=(string) " con ";
//	 $Decimales= $Decimales*100;
//	 echo ("*");	
//	 $Decimales = number_format($Decimales, 2);	
//	 echo ($Decimales);	
//	 $tempo = Decenas(Intval($Decimales));	
//	 $letras .= (string) $tempo;
//	 $letras .= (string) "centavos";
}	
Else {
If (($letras <> "Error en Conversión a Letras") And (strlen(Trim($letras)) > 0)) {
$letras .= (string) " ";

}
}
return $letras;
}
}




?>
