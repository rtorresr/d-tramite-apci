<?
require('fpdf/fpdf.php');
	$pdf=new FPDF('p','mm','a4');
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(190,10,'Hecho con FPDF.',1,0,'R'); 

	class PDF extends FPDF
	{
	  function Header()
	  {
	   $anho = date("Y");
	   $datomes = date("m");
	   $datomes = $datomes*1;
	   $datodia = date("d");
	   $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");
	   $fecha = "SITD, ".$datodia." ".$meses[$datomes].' del '.$anho;
	   $this->Image('images/pdf_head.jpg',10,10,185);
	   $this->SetFont('Arial','',9);
	   $this->Ln(43);
	   $this->Cell(185,5,$fecha,0,1,'R');
	   $this->Ln(2);
	
	    $this->SetFont('Arial','UB',10);
	    $this->Cell(180,5,'REPORTE - TRABAJADORES',0,1,'C');
	    $this->SetFont('Arial','',10);
	    $this->Ln(3);
	
	   $this->SetFont('Arial','',7);
	   $this->SetFillColor(219,219,219);
	   $this->Cell(15,5,'CODIGO',1,0,'C',1);
	   $this->Cell(25,5,'NOMBRES',1,0,'C',1);
	   $this->Cell(35,5,'APELLIDOS',1,0,'C',1);
	   $this->Cell(20,5,'TIPO DOC ',1,0,'C',1);
	   $this->Cell(20,5,'NRO DOC',1,0,'C',1);
	   $this->Cell(35,5,'DIRECCION',1,0,'C',1);
	   $this->Cell(20,5,'E-MAIL',1,0,'C',1);
	   $this->Cell(15,5,'TELEFONO ',1,0,'C',1);
	   $this->Cell(10,5,'ESTADO',1,1,'C',1);

	  }
	
	  function Footer()
	  {
	  
	    //Posici�n: a 1,5 cm del final
	    $this->SetY(-15);
	    $this->SetFont('Arial','I',8);
	    //N�mero de p�gina
	    $this->Cell(0,10,'P�gina '.$this->PageNo().'/{nb}',0,0,'R');
	  
	  }
	
	}	
	
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
require_once("../conexion/conexion.php");
$sql="select * from Tra_M_Trabajadores ";
$sql.=" WHERE iCodTrabajador>0 ";
if($_GET[cApellidosTrabajador]!=""){
$sql.=" AND cApellidosTrabajador like '%$_GET[cApellidosTrabajador]%' ";
}
if($_GET[cNumDocIdentidad]!=""){
$sql.=" AND cNumDocIdentidad='$_GET[cNumDocIdentidad]' ";
}
$sql.="ORDER BY iCodTrabajador ASC";
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;

$pdf->SetFont('Arial','',6);

while ($Rs=sqlsrv_fetch_array($rs)){
	$pdf->Cell(15,5,$Rs[iCodTrabajador],0,0,'L');
  $pdf->Cell(25,5,$Rs[cNombresTrabajador],0,0,'L');
  $pdf->Cell(35,5,$Rs[cApellidosTrabajador],0,0,'L');
  $pdf->Cell(20,5,$Rs[cTipoDocIdentidad],0,0,'L');
  $pdf->Cell(20,5,$Rs[cNumDocIdentidad],0,0,'L');
  $pdf->Cell(35,5,$Rs[cDireccionTrabajador],0,0,'L');
  $pdf->Cell(20,5,$Rs[cMailTrabajador],0,0,'L');
  $pdf->Cell(15,5,$Rs[cTlfTrabajador1],0,0,'L');
  $pdf->Cell(10,5,$Rs[nFlgEstado],0,1,'L');
}

$pdf->Ln(3);
	
$pdf->Output();
?>