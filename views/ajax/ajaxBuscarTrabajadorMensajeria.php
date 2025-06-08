<?php
include_once("../../conexion/conexion.php");
session_start();

$params= array(
     $_GET['page'] ?? 25
    ,$_GET['q'] ?? ''
);

$sql = "{call UP_BUSCAR_TRABAJADOR(?,?) }";

$rs = sqlsrv_query($cnx, $sql,$params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$data = [];
while ($Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
    array_push($data,["id"=> $Rs['codigo'], "text"=> $Rs['nombre']]);
}
echo json_encode($data);