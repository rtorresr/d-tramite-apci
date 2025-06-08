<?php
include_once("../../conexion/conexion.php");
session_start();

$params = array(
    $_POST['IdTramite'],
    $_POST['IdSerieDocumental'],
    $_SESSION['IdSesion']
);
$sqlMayorDoc = "{call UP_ASIGNAR_SERIE_DOCUMENTAL (?,?,?) }";
$rs = sqlsrv_query($cnx, $sqlMayorDoc, $params);
if($rs === false) {
    http_response_code(500);
    die(sqlsrv_errors());
}