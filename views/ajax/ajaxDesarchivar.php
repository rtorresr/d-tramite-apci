<?php
include_once("../../conexion/conexion.php");
session_start();

$params = array(
    $_POST['iCodMovimiento'],
    $_SESSION['CODIGO_TRABAJADOR']

);
$sqlArchivarGrupo = "{call SP_DESARCHIVAR_MOVIMIENTO (?,?) }";

$rs = sqlsrv_query($cnx, $sqlArchivarGrupo, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
