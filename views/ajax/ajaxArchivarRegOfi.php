<?php
include_once("../../conexion/conexion.php");
session_start();

$params = array(
    $_POST['iCodAgrupado'],
    $_POST['cObservacionesArchivar'],
    $_SESSION['iCodOficinaLogin'],
    $_SESSION['CODIGO_TRABAJADOR'],
    $_SESSION['iCodPerfilLogin'], 
    $_POST['anexos']
);
$sqlArchivarGrupo = "{call SP_ARCHIVAR_GRUPO (?,?,?,?,?,?) }";

$rs = sqlsrv_query($cnx, $sqlArchivarGrupo, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}

