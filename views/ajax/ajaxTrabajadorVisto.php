<?php
session_start();
include_once("../../conexion/conexion.php");
date_default_timezone_set('America/Lima');

$params = array(
    $_POST['codOficina'],
    $_SESSION['iCodOficinaLogin'],
    $_SESSION['CODIGO_TRABAJADOR']
);
$sqlTrabajadoresVisado = "{call SP_CONSULTA_TRABAJADORES_VISADO (?,?,?) }";

$rs = sqlsrv_query($cnx, $sqlTrabajadoresVisado, $params);
// print_r($params);
// die();
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$data = [];
while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
    array_push($data,$Rs);
}
echo json_encode($data);





