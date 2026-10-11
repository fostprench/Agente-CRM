<?php
require_once("fpdf.php");
class PDF extends FPDF
{

function Header()
{
    $logo = $_SESSION['logo'];
    $this->Image("web/images/$logo",10,8,55);
	$this->SetFont('Arial','B',8);

 
	
	$this->SetXY(10,28);
	$this->Cell(50,6,html_entity_decode("RUC: ".$_SESSION['ruc']),0,0,'C',false);
 
	
	$this->SetXY(70,10);
	//$this->Cell(WIDTH , HIGHT , TEXTO , border , ln , align , fill , link)
	$this->SetFont('Arial','',8);
	$this->Cell(120,5,html_entity_decode("Venta de Computadoras, Laptops, Servidores, Impresoras, Suministros, Accesoios, Redes,"),0,0,'C',false);
	$this->SetY(15);
	$this->SetX(70);
	$this->Cell(120,5,html_entity_decode(" Cámaras de Video Vigilancia, Servicio Técnico y Papeleria."),0,1,'C',false);
	$this->SetY(20);
	$this->SetX(70);
	$this->SetFont('Times','I',9);
	$this->Cell(120,5,$_SESSION['sitio_web'],0,1,'C',false);
	$this->SetX(70);
	$this->Cell(120,0,'',1,1,'C',false);
    $this->Ln(50);	
}

//Pie de pgina
function Footer()
{
    $this->SetFont('Arial','',8);
	$this->SetY(-22);
	$this->Cell(0,0,'',1,0,'C');
	$this->SetY(-24);
	$this->Cell(0,10,html_entity_decode('Av. Cajamarca Sur Nº 620 - Nueva Cajamarca - Rioja – San Martín'),0,0,'C');
	$this->SetY(-20);
	$this->Cell(0,10,html_entity_decode('Tel: 042-796546 Cel: 950821963'),0,0,'C');
	$this->SetY(-12);
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');	   
}

}

?>
