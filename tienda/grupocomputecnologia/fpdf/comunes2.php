<?php
require_once("fpdf.php");
class PDF extends FPDF
{

//Cabecera de pgina
function Header()
{
	$this->SetFont('Courier','',9);
	$this->SetY(10);
	$this->SetX(13);
	//$this->Cell(WIDTH , HIGHT , TEXTO , border , ln , align , fill , link)
	$this->Cell(60,4,"Computecnologia",0,0,'C',false);
	$this->SetY(14);
	$this->SetX(13);
	$this->Cell(60,4,"Av. Cajamarca Sur 620",0,1,'C',false);
	$this->SetY(18);
	$this->SetX(13);
	$this->Cell(60,4,"Cel. 950821963 RPM. #950821963",0,1,'C',false);
	$this->SetY(22);
	$this->SetX(13);
	$this->Cell(60,4,"Tel. 042-796546 - Nueva Cajamarca",0,1,'C',false);

	
	$this->SetFont('Courier','',10);
	$this->SetY(16);
	$this->SetX(80);
	$this->Cell(70,4,"ORDEN DE SERVICIO TÉCNICO",0,1,'C',false);
	$this->SetY(20);
	$this->SetX(90);
	$this->Cell(50,0,"",1,1,'C',false);
	
	
	
    $this->Ln(30);	
}

//Pie de pgina
function Footer()
{
    
   
}

}

?>
