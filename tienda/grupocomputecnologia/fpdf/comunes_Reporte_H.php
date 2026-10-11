<?php
require_once("fpdf.php");
class PDF extends FPDF
{

function Header()
{
    $logo = $_SESSION['logo'];
    $this->Image("web/images/$logo",9,9,50);
	$this->SetFont('Arial','',9);
	$this->SetY(10);
	$this->SetX(60);
	$siglas = $_SESSION['siglas'];
	$this->Cell(140,5,"REPORTES - $siglas",0,0,'C',false);
	$this->SetY(15);
	$this->SetX(60);
	$direccion = $_SESSION['direccion'];
	$this->Cell(140,5,"$direccion",0,1,'C',false);
	$this->SetY(20);
	$this->SetX(60);
	$telefono = $_SESSION['telefono'];
	$this->Cell(140,5,"$telefono",0,1,'C',false);
    $this->Ln(25);	
}

//Pie de pgina
function Footer()
{
    $this->SetFont('Arial','',8);
	$this->SetY(-21);
	$this->Cell(0,10, $_SESSION['siglas'].' © '.date('Y'),0,0,'C'); //TITULO EN EL PIE
	$this->SetY(-18);
	$this->Cell(0,10,html_entity_decode($_SESSION['direccion']),0,0,'C');
	$this->SetY(-15);
	$this->Cell(0,10,html_entity_decode('Perú'),0,0,'C');
	$this->SetY(-12);
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');	   
}

}

?>
