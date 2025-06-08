<?php 
session_start();
include_once("../conexion/conexion.php");
if($_SESSION[cCodRef]==""){
  	$Fecha=date("Ymd-Gis");	
  	$_SESSION['cCodRef']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$Fecha;
}
	  
if($_POST[iCodTramite]!=""){
	$sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
   	$sqlAdd.="(iCodTramiteRef,	cReferencia, iCodTramite,         cCodSession, cDesEstado, iCodTipo)";
   	$sqlAdd.=" VALUES ";
   	$sqlAdd.="('$_POST[iCodTramiteRef]','$_POST[cReferencia]', '$_POST[iCodTramite]','$_SESSION[cCodRef]', 'PENDIENTE', 1)";
}else {
	$sqlAdd="INSERT INTO Tra_M_Tramite_Referencias ";
    $sqlAdd.="(iCodTramiteRef,	cReferencia,          cCodSession, cDesEstado, iCodTipo)";
    $sqlAdd.=" VALUES ";
    $sqlAdd.="('$_POST[iCodTramiteRef]','$_POST[cReferencia]', '$_SESSION[cCodRef]', 'PENDIENTE', 1)";
}

$rs=sqlsrv_query($cnx,$sqlAdd);

$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_POST[iCodTramite]'";
$rsRefs=sqlsrv_query($cnx,$sqlRefs);
$result = array();
while($reponsable = sqlsrv_fetch_array($rsRefs)){
    $result[]= $reponsable;
}
echo json_encode($result);
?>