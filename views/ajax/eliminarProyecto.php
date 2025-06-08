<?php
include_once("../../conexion/conexion.php");
date_default_timezone_set('America/Lima');

$iCodMovimiento = $_POST['iCodMovimiento'][0];

$sqlMov = "SELECT iCodProyecto FROM Tra_M_Tramite_Movimientos WHERE iCodProyecto IS NOT NULL AND iCodMovimiento=".$iCodMovimiento;
$rsMov = sqlsrv_query($cnx,$sqlMov);
$RsMov = sqlsrv_fetch_array($rsMov);

if(sqlsrv_has_rows($rsMov)){
    $sqlPro = "UPDATE Tra_M_Proyecto SET nFlgEnvio = 2 WHERE iCodProyecto = ".$RsMov['iCodProyecto'];
    $rsPro = sqlsrv_query($cnx,$sqlPro);
    $data['esProyecto'] = '1';
    echo json_encode($data);
}else{
    $data['esProyecto'] = '0';
    echo json_encode($data);
}