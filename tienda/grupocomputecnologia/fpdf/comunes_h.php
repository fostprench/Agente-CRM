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
	$this->SetX(100);
	//$this->Cell(WIDTH , HIGHT , TEXTO , border , ln , align , fill , link)
	$this->Cell(120,5,"SISCOMP DEL ORIENTE - Venta de Computadoras , Impresoras, Suministros Informaticos,etc ",0,0,'C',false);
	$this->SetY(15);
	$this->SetX(100);
	$this->Cell(120,5,"Jr. Serafin Filomeno 296 Telef. 509751 Cel.942839302 RPM. *659405  ",0,1,'C',false);
	$this->SetY(20);
	$this->SetX(90);
	$this->Cell(120,5,"Moyobamba-San Martin",0,1,'C',false);
    $this->Ln(25);	
}

//Pie de pgina
function Footer()
{
    $this->SetFont('Arial','',8);
	$this->SetY(-21);
	$this->Cell(0,10,'Siscomp del Oriente © '.date('Y'),0,0,'C'); //TITULO EN EL PIE
	$this->SetY(-18);
	$this->Cell(0,10,html_entity_decode('Moyobamba - San Martín'),0,0,'C');
	$this->SetY(-15);
	$this->Cell(0,10,html_entity_decode('Perú'),0,0,'C');
	$this->SetY(-12);
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');	   
}

}

?>
