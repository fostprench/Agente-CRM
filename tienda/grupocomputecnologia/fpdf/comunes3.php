<?php
require_once("fpdf.php");
class PDF extends FPDF
{

//Cabecera de pgina
function Header()
{
	$this->SetFont('Courier','',9);
	$this->SetY(10);
	$this->SetX(10);
	//$this->Cell(WIDTH , HIGHT , TEXTO , border , ln , align , fill , link)
	$this->Cell(40,4,"Computecnologia",0,0,'C',false);
	$this->SetY(14);
	$this->SetX(10);
	$this->Cell(40,4,"Av. Cajamarca Sur 620",0,1,'C',false);
	$this->SetY(18);
	$this->SetX(10);
	$this->Cell(50,4,"Cel. 950821963 RPM. #950821963",0,1,'C',false);
	$this->SetY(22);
	$this->SetX(10);
	$this->Cell(50,4,"Tel. 042-796546 - Nueva Cajamarca",0,1,'C',false);

	
	$this->SetFont('Courier','',10);
	$this->SetY(16);
	$this->SetX(75);
	$this->Cell(70,4,"RECIBO PROVISIONAL DE PAGO",0,1,'C',false);
	$this->SetY(20);
	$this->SetX(82);
	$this->Cell(56,0,"",1,1,'C',false);
	
	
	
    $this->Ln(30);	
}

//Pie de pgina
function Footer()
{
    
   
}

}

?>
