<?php 
session_start();
ob_start();
include_once("../conexion/conexion.php");

$sqlTrb = "SELECT TPU.iCodTrabajador, cNombresTrabajador, cApellidosTrabajador,LTRIM(RTRIM(cMailTrabajador))cMailTrabajador FROM Tra_M_Perfil_Ususario AS TPU 
		  INNER JOIN Tra_M_Trabajadores AS TT ON TPU.iCodTrabajador = TT.iCodTrabajador
		  WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '".$_POST['iCodOficinaResponsable']."'";

$rsTrb  = sqlsrv_query($cnx,$sqlTrb);
$result = array();
while($reponsable = sqlsrv_fetch_array($rsTrb, SQLSRV_FETCH_ASSOC)){
    $result[]= $reponsable;
}
echo json_encode($result);