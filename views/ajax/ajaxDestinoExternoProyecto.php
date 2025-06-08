<?php
include_once("../../conexion/conexion.php");

/*$rsProyecto = sqlsrv_query($cnx, "SELECT iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$_GET['codigoMov']);
$RsProyecto = sqlsrv_fetch_array($rsProyecto);

$rsRemitente = sqlsrv_query($cnx, "SELECT iCodRemitente FROM Tra_M_Proyecto WHERE iCodProyecto = ".$RsProyecto['iCodProyecto']);
$RsRemitente = sqlsrv_fetch_array($rsRemitente);*/

$sql = "SELECT iCodRemitente, cNombre FROM Tra_M_Remitente WHERE iCodRemitente = ".$_POST['iCodRemitente'];
$rsRem=sqlsrv_query($cnx,$sql);

$arrRemitentes = [];

while ($RsRem = sqlsrv_fetch_array($rsRem)){
    array_push($arrRemitentes, ["id" => trim($RsRem['iCodRemitente']), "text" => trim($RsRem['cNombre'])]);
}

sqlsrv_free_stmt($rsRem);

echo json_encode($arrRemitentes);