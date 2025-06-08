<?php
include_once("../../conexion/conexion.php");
session_start();

$params = array(
    $_POST['IdMovimiento'],
);
$sql = "{call UP_VALIDAR_MOVIMIENTO (?) }";

$rs = sqlsrv_query($cnx, $sql, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
echo json_encode($Rs);
