<?php
date_default_timezone_set('America/Lima');
session_start();

include_once("../conexion/conexion.php");

$tramite   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'");
$RsTramite = sqlsrv_fetch_object($tramite);

$sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTramite->cCodTipoDoc'";
$rsTipDoc  = sqlsrv_query($cnx,$sqlTipDoc);
$RsTipDoc  = sqlsrv_fetch_object($rsTipDoc);
$rutaUpload = "../cAlmacenArchivos/";

if($_FILES['documentoElectronicoPDF']['name']!=""){
  	$nombreOriginal1=$_FILES['documentoElectronicoPDF']['name'];
   	$PDF_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'documentos'.DIRECTORY_SEPARATOR;
	//$nuevo_nombre = str_replace(" ","-",trim($RsTipDoc['cDescTipoDoc']))."-".str_replace("/","-",$cCodificacion).".".$extension[$num];
	move_uploaded_file($_FILES['documentoElectronicoPDF']['tmp_name'], "$PDF_DIR$nombreOriginal1");
}
			  
if($_FILES['fileUpLoadDigital']['name'] != ""){
	$extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
  $num = count($extension) - 1;
  $cNombreOriginal = $_FILES['fileUpLoadDigital']['name'];
	
	if($extension[$num] == "exe" OR $extension[$num] == "dll" OR $extension[$num] == "EXE" OR $extension[$num] == "DLL"){
		$nFlgRestricUp = 1;
  }else{
  	$cDescTipoDoc = str_replace(" ","-",trim($RsTipDoc->cDescTipoDoc));


  	$cDescTipoDoc = str_replace("/","-",trim($cDescTipoDoc));
  	$nuevo_nombre = $cDescTipoDoc."-".str_replace("/","-",trim($RsTramite->cCodificacion)).".".trim($extension[$num]);
		// $nuevo_nombre = str_replace(" ","-",trim($RsTipDoc->cDescTipoDoc))."-".str_replace("/","-",trim($RsTramite->cCodificacion)).".".trim($extension[$num]);
		$nuevo_nombre = trim($nuevo_nombre);
		move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
						
		$sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite,cNombreOriginal,cNombreNuevo) VALUES ('$RsTramite->iCodTramite','$cNombreOriginal','$nuevo_nombre')";
   	$rsDigt  = sqlsrv_query($cnx,$sqlDigt);
  }
}
echo json_encode(array('documentoElectronicoPDF' => $nuevo_nombre,'iCodTramite' => $_POST[iCodTramite]));
?>