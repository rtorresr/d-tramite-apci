<?php
include_once("../../conexion/conexion.php");

$params = array(
    $_POST['iCodRemitente'],
);

$sqlConsultaRemitente = "{call SP_REMITENTE_CONSULTA (?) }";
$rs = sqlsrv_query($cnx, $sqlConsultaRemitente, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

echo json_encode($Rs);