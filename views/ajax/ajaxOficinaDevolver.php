<?php
include_once("../../conexion/conexion.php");
session_start();

$parametros = array(
    $_SESSION['iCodOficinaLogin']
);

$sql = "{call UP_LISTAR_OFICINA_DEVOLVER (?)}";

$rs = sqlsrv_query($cnx, $sql, $parametros);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$data = [];
while ($Rs = sqlsrv_fetch_array($rs)){
    $data[]= $Rs;
}
sqlsrv_free_stmt($rs);
echo json_encode($data);