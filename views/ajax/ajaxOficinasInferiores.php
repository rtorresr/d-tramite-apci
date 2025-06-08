<?php
include_once("../../conexion/conexion.php");
session_start();
$params = array(
    $_SESSION['iCodOficinaLogin']
);
$sql = "{call SP_CONSULTA_OFICINA_E_INFERIORES (?) }";
$rs = sqlsrv_query($cnx, $sql, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$data = [];
while ( $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
    array_push($data, $Rs);
}
echo json_encode($data);