<?php
include_once("../../conexion/conexion.php");
session_start();
$params = array(
    $_POST['iCodAgrupado'],
    $_SESSION['CODIGO_TRABAJADOR'],
    $_SESSION['iCodOficinaLogin'],
    $_SESSION['iCodPerfilLogin']
);
$sqlConsultaTipoDocumento = "{call SP_RETROCEDER_MOVIMIENTO (?,?,?,?) }";
$rs = sqlsrv_query($cnx, $sqlConsultaTipoDocumento, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}