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
	    $this->Cell(180,5,'REPORTE - HISTORIAL DOCUMENTOS',0,1,'C');
	    $this->SetFont('Arial','',10);
	    $this->Ln(3);
	
	   $this->SetFont('Arial','',7);
	   $this->SetFillColor(219,219,219);
	   $this->Cell(15,5,'Nro Evento',1,0,'C',1);
	   $this->Cell(20,5,'Tipo Evento',1,0,'C',1);
	   $this->Cell(25,5,'Fecha de Ocurrido',1,0,'C',1);
	   $this->Cell(25,5,'Usuario Responsable',1,0,'C',1);
	   $this->Cell(20,5,'iCodTramite',1,0,'C',1);
	   $this->Cell(20,5,'nFlgTipoDoc',1,0,'C',1);
	   $this->Cell(25,5,'cCodificacion',1,0,'C',1);
	   $this->Cell(28,5,'iCodTrabajadorRegistro',1,0,'C',1);
	   $this->Cell(20,5,'cCodTipoDoc',1,0,'C',1);
	   $this->Cell(20,5,'fFecDocumento',1,0,'C',1);
	   $this->Cell(50,5,'cNroDocumento',1,0,'C',1);
	   $this->Cell(20,5,'iCodRemitente',1,0,'C',1);
	   $this->Cell(30,5,'cAsunto',1,0,'C',1);
	   $this->Cell(35,5,'cObservaciones',1,0,'C',1);
	   $this->Cell(20,5,'cReferencia',1,0,'C',1);
	   $this->Cell(20,5,'iCodIndicacion',1,0,'C',1);
	   $this->Cell(50,5,'nNumFolio',1,0,'C',1);
	   $this->Cell(20,5,'nTiempoRespuesta',1,0,'C',1);
	   $this->Cell(30,5,'nFlgEnvio',1,0,'C',1);
	   $this->Cell(35,5,'fFecPlazo',1,0,'C',1);
	   $this->Cell(20,5,'nFlgRespuesta',1,0,'C',1);
	   $this->Cell(20,5,'iCodTupaClase',1,0,'C',1);
	   $this->Cell(15,5,'iCodTupa',1,0,'C',1);
	   $this->Cell(20,5,'fFecRegistro',1,0,'C',1);
	   $this->Cell(15,5,'nCodBarra',1,0,'C',1);
	   $this->Cell(35,5,'cPassword',1,0,'C',1);
	   $this->Cell(10,5,'nFlgEstado',1,0,'C',1);
	   $this->Cell(10,5,'nFlgAnulado',1,1,'C',1);
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

$sql="SELECT * FROM Tra_M_Audit_Tramite ";
if($_GET['fDesde']!="" && $_GET['fHasta']!=""){
$sql.=" WHERE [Tra_M_Audit_Tramite].fFecEvento BETWEEN  '".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."' and '".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."' ";
}
$_GET['cTipoEvento'];
if($_GET['cTipoEvento']!=""){
$sql.=" WHERE cTipoEvento='".$_GET['cTipoEvento']."'";
}
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;

$pdf->SetFont('Arial','',6);

while ($Rs=sqlsrv_fetch_array($rs)){
	$pdf->Cell(15,5,$Rs[iCodEventoTramite],0,0,'L');
  $pdf->Cell(20,5,$Rs[cTipoEvento],0,0,'L');
  $pdf->Cell(25,5,$Rs[fFecEvento],0,0,'L');
  $pdf->Cell(25,5,$Rs[usuario],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodTramite],0,0,'L');
  $pdf->Cell(20,5,$Rs[nFlgTipoDoc],0,0,'L'); 
  $pdf->Cell(25,5,$Rs[cCodificacion],0,0,'L');
  $pdf->Cell(28,5,$Rs[iCodTrabajadorRegistro],0,0,'L');
  $pdf->Cell(20,5,$Rs[cCodTipoDoc],0,0,'L');
  $pdf->Cell(20,5,$Rs['fFecDocumento'],0,0,'L');
  $pdf->Cell(50,5,$Rs['cNroDocumento'],0,0,'L');  
  $pdf->Cell(20,5,$Rs[iCodRemitente],0,0,'L');
  $pdf->Cell(30,5,$Rs['cAsunto'],0,0,'L');
  $pdf->Cell(35,5,$Rs[cObservaciones],0,0,'L');
  $pdf->Cell(20,5,$Rs[cReferencia],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodIndicacion],0,0,'L');
  $pdf->Cell(50,5,$Rs[nNumFolio],0,0,'L');    
  $pdf->Cell(20,5,$Rs[nTiempoRespuesta],0,0,'L');
  $pdf->Cell(30,5,$Rs[nFlgEnvio],0,0,'L');
  $pdf->Cell(35,5,$Rs[fFecPlazo],0,0,'L');
  $pdf->Cell(20,5,$Rs[nFlgRespuesta],0,0,'L');
  $pdf->Cell(20,5,$Rs[iCodTupaClase],0,0,'L');
  $pdf->Cell(15,5,$Rs['iCodTupa'],0,0,'L');
  $pdf->Cell(20,5,$Rs['fFecRegistro'],0,0,'L');
  $pdf->Cell(15,5,$Rs[nCodBarra],0,0,'L');
  $pdf->Cell(35,5,$Rs[cPassword],0,0,'L');
  $pdf->Cell(10,5,$Rs[nFlgEstado],0,0,'L');
  $pdf->Cell(10,5,$Rs[nFlgAnulado],0,1,'L');  
}

$pdf->Ln(3);
	
$pdf->Output();
?>