<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte General en PDF
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
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
	    $this->Cell(180,5,'REPORTE - DOCUMENTOS',0,1,'C');
	    $this->SetFont('Arial','',10);
	    $this->Ln(3);
	
	   $this->SetFont('Arial','',7);
	   $this->SetFillColor(219,219,219);
	   $this->Cell(20,5,'Nro Documento',1,0,'C',1);
	   $this->Cell(30,5,'Nro Referencia',1,0,'C',1);
	   $this->Cell(35,5,'Remitente',1,0,'C',1);
	   $this->Cell(20,5,'Representante',1,0,'C',1);
	   $this->Cell(20,5,'Fecha Derivo',1,0,'C',1);
	   $this->Cell(50,5,'Asunto',1,1,'C',1);
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
$sql="SELECT [Tra_M_tramite].cCodificacion,[Tra_M_tramite].cNroDocumento,[Tra_M_Remitente].cNombre,[Tra_M_Remitente].cRepresentante,[Tra_M_tramite].fFecDocumento,[Tra_M_tramite].cAsunto ";
$sql.= " FROM [Tra_M_tramite] INNER JOIN [Tra_M_Remitente]  ON ([Tra_M_Remitente].iCodRemitente=[Tra_M_Tramite].iCodRemitente) ";
if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
$sql.=" WHERE [Tra_M_tramite].fFecDocumento BETWEEN  '".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and '".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."' ";
}
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;

$pdf->SetFont('Arial','',6);

while ($Rs=sqlsrv_fetch_array($rs)){
	$pdf->Cell(20,5,$Rs[cCodificacion],0,0,'L');
  $pdf->Cell(30,5,$Rs['cNroDocumento'],0,0,'L');
  $pdf->Cell(35,5,$Rs['cNombre'],0,0,'L');
  $pdf->Cell(20,5,$Rs[cRepresentante],0,0,'L');
  $pdf->Cell(20,5,$Rs['fFecDocumento'],0,0,'L');
  $pdf->Cell(50,5,$Rs['cAsunto'],0,1,'L');
}

$pdf->Ln(3);
	
$pdf->Output();
?>