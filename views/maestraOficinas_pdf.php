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
	   $this->Ln(22);
	   $this->Cell(185,5,$fecha,0,1,'R');
	   $this->Ln(2);
	
	    $this->SetFont('Arial','UB',10);
	    $this->Cell(180,5,'REPORTE - OFICINAS',0,1,'C');
	    $this->SetFont('Arial','',10);
	    $this->Ln(3);
	
	   $this->SetFont('Arial','',7);
	   $this->SetFillColor(219,219,219);
	   $this->Cell(15,5,'CODIGO',1,0,'C',1);
	   $this->Cell(80,5,'OFICINA',1,0,'C',1);
	   $this->Cell(35,5,'SIGLA',1,1,'C',1);
	   

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
$sql="select * from Tra_M_Oficinas ";
$sql.=" WHERE iCodOficina>0 ";
if($_GET[cNomOficina]!=""){
$sql.=" AND cNomOficina like '%$_GET[cNomOficina]%' ";
}
if($_GET[cSiglaOficina]!=""){
$sql.=" AND cSiglaOficina='$_GET[cSiglaOficina]' ";
}
$sql.="ORDER BY iCodOficina ASC";
$rs=sqlsrv_query($cnx,$sql);	

$pdf->SetFont('Arial','',6);

while ($Rs=sqlsrv_fetch_array($rs)){
	$pdf->Cell(15,5,$Rs['iCodOficina'],0,0,'L');
  $pdf->Cell(80,5,$Rs[cNomOficina],0,0,'L');
  $pdf->Cell(35,5,$Rs[cSiglaOficina],0,1,'L');
  
}
$pdf->Ln(3);
	
$pdf->Output();
?>