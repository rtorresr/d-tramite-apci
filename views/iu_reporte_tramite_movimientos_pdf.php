<?
require('fpdf/fpdf.php');
	$pdf=new FPDF('l','mm','a4');
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
	    $this->Cell(180,5,'REPORTE - HISTORIAL MOVIMIENTOS DE DOCUMENTOS',0,1,'C');
	    $this->SetFont('Arial','',10);
	    $this->Ln(3);
	
	   $this->SetFont('Arial','',7);
	   $this->SetFillColor(219,219,219);
	   $this->Cell(15,5,'Nro Evento',1,0,'C',1);
	   $this->Cell(20,5,'Tipo Evento',1,0,'C',1);
	   $this->Cell(25,5,'Fecha de Ocurrido',1,0,'C',1);
	   $this->Cell(25,5,'Usuario Responsable',1,0,'C',1);
	   $this->Cell(20,5,'Nro Movimiento',1,0,'C',1);
	   $this->Cell(20,5,'iCodTramite',1,0,'C',1);
	   $this->Cell(20,5,'iCodTrabajadorRegistro',1,0,'C',1);
	   $this->Cell(20,5,'nFlgTipoDoc',1,0,'C',1);
	   $this->Cell(25,5,'iCodOficinaOrigen',1,0,'C',1);
	   $this->Cell(20,5,'fFecRecepcion',1,0,'C',1);
	   $this->Cell(20,5,'iCodOficinaDerivar',1,0,'C',1);
	   $this->Cell(50,5,'iCodTrabajadorDerivar',1,0,'C',1);
	   $this->Cell(20,5,'cCodTipoDocDerivar',1,0,'C',1);
	   $this->Cell(30,5,'iCodIndicacionDerivar',1,0,'C',1);
	   $this->Cell(35,5,'cAsuntoDerivar',1,0,'C',1);
	   $this->Cell(20,5,'cObservacionesDerivar',1,0,'C',1);
	   $this->Cell(20,5,'fFecDerivar',1,0,'C',1);
	   $this->Cell(50,5,'iCodTrabajadorDelegado',1,0,'C',1);
	   $this->Cell(50,5,'iCodIndicacionDelegado',1,0,'C',1);
	   $this->Cell(20,5,'cObservacionesDelegado',1,0,'C',1);
	   $this->Cell(30,5,'fFecDelegado',1,0,'C',1);
	   $this->Cell(35,5,'iCodTrabajadorFinalizar',1,0,'C',1);
	   $this->Cell(20,5,'cObservacionesFinalizar',1,0,'C',1);
	   $this->Cell(20,5,'fFecFinalizar',1,0,'C',1);
	   $this->Cell(50,5,'fFecMovimiento',1,0,'C',1);
	   $this->Cell(50,5,'nEstadoMovimiento',1,0,'C',1);
	   $this->Cell(20,5,'nFlgEnvio',1,0,'C',1);
	   $this->Cell(30,5,'cFlgCopia',1,1,'C',1);
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
$sql="SELECT * FROM Tra_M_Audit_Tramite_Movimientos ";

//$sql.= " GROUP BY iCodOficinaResponsable ";
if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
$sql.=" WHERE [Tra_M_Audit_Tramite_Movimientos].fFecEvento BETWEEN  '".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and '".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."' ";
}
$_GET['cTipoEvento'];
if($_GET['cTipoEvento']!=""){
$sql.=" WHERE cTipoEvento='".$_GET['cTipoEvento']."'";
}
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;

$pdf->SetFont('Arial','',6);

while ($Rs=sqlsrv_fetch_array($rs)){
	$pdf->Cell(15,5,$Rs[iCodEventoMovimiento],0,0,'L');
  $pdf->Cell(20,5,$Rs[cTipoEvento],0,0,'L');
  $pdf->Cell(25,5,$Rs[fFecEvento],0,0,'L');
  $pdf->Cell(25,5,$Rs[usuario],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodMovimiento],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodTramite],0,0,'L');  
  $pdf->Cell(20,5,$Rs[iCodTrabajadorRegistro],0,0,'L');
  $pdf->Cell(20,5,$Rs[nFlgTipoDoc],0,0,'L');
  $pdf->Cell(25,5,$Rs[iCodOficinaOrigen],0,0,'L');
  $pdf->Cell(20,5,$Rs[fFecRecepcion],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodOficinaDerivar],0,0,'L');
  $pdf->Cell(50,5,$Rs[iCodTrabajadorDerivar],0,0,'L');  
  $pdf->Cell(20,5,$Rs[cCodTipoDocDerivar],0,0,'L');
  $pdf->Cell(30,5,$Rs[iCodIndicacionDerivar],0,0,'L');
  $pdf->Cell(35,5,$Rs[cAsuntoDerivar],0,0,'L');
  $pdf->Cell(20,5,$Rs[cObservacionesDerivar],0,0,'L');
  $pdf->Cell(20,5,$Rs['fFecDerivar'],0,0,'L');
  $pdf->Cell(50,5,$Rs['iCodTrabajadorDelegado'],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodIndicacionDelegado],0,0,'L');
  $pdf->Cell(30,5,$Rs[cObservacionesDelegado],0,0,'L');
  $pdf->Cell(35,5,$Rs[fFecDelegado],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodTrabajadorFinalizar],0,0,'L');
  $pdf->Cell(20,5,$Rs[cObservacionesFinalizar],0,0,'L');
  $pdf->Cell(50,5,$Rs[fFecFinalizar],0,0,'L');  
  $pdf->Cell(50,5,$Rs[fFecMovimiento],0,0,'L');  
  $pdf->Cell(50,5,$Rs['nEstadoMovimiento'],0,0,'L');  
  $pdf->Cell(50,5,$Rs[nFlgEnvio],0,0,'L');  
  $pdf->Cell(50,5,$Rs[cFlgCopia],0,1,'L');   
}

$pdf->Ln(3);
	
$pdf->Output();
?>