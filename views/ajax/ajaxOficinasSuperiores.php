<?php
include_once("../../conexion/conexion.php");
session_start();
$data = [];

$rsOfinasArbolSup = sqlsrv_query($cnx,"SELECT iCodPadre, iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS oficina FROM Tra_M_Oficinas WHere iCodOficina = ".$_SESSION['iCodOficinaLogin']);
$RsOfinasArbolSup = sqlsrv_fetch_array($rsOfinasArbolSup);

array_push($data,"<option value='".$RsOfinasArbolSup['iCodOficina']."'>".TRIM($RsOfinasArbolSup['oficina'])."</option>");

while($RsOfinasArbolSup['iCodPadre'] !== null){
    $rsOfinasArbolSup = sqlsrv_query($cnx,"SELECT iCodPadre, iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS oficina FROM Tra_M_Oficinas WHere iCodOficina = ".$RsOfinasArbolSup['iCodPadre']);
    $RsOfinasArbolSup = sqlsrv_fetch_array($rsOfinasArbolSup);
    array_push($data,"<option value='".$RsOfinasArbolSup['iCodOficina']."'>".TRIM($RsOfinasArbolSup['oficina'])."</option>");
}
echo json_encode($data);
?>