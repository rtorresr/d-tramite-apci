<?php
session_start();
include_once("../../conexion/conexion.php");

$iCodMovimiento = $_POST['iCodMovimiento'][0];

$rsTramite = sqlsrv_query($cnx,"SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$iCodMovimiento);
$RsTramite = sqlsrv_fetch_array($rsTramite);

$rsUrlnoFirmado = sqlsrv_query($cnx, "SELECT cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE iCodTipoDigital = '2' AND iCodTramite = '".$RsTramite['iCodTramite']."'");
$rsUrlVisado = sqlsrv_query($cnx, "SELECT cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE iCodTipoDigital = '4' AND iCodTramite = '".$RsTramite['iCodTramite']."'");

if(sqlsrv_has_rows($rsUrlVisado)){
    $RsUrl = sqlsrv_fetch_array($rsUrlVisado);
} else {
    $RsUrl = sqlsrv_fetch_array($rsUrlnoFirmado);
}

$arr = array(
    'url' => rtrim($RsUrl['cNombreNuevo']),
    'tra' => $RsTramite['iCodTramite']
);
echo json_encode($arr);