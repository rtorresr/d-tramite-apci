<?php
include_once("../../conexion/conexion.php");

$params = array(
    $_GET['page'] ?? 25,
    $_GET['q'] ?? ''
);

$sqlCud = "{call SP_CONSULTA_REINGRESO_CUD (?,?)}";

$rsCud=sqlsrv_query($cnx,$sqlCud,$params);

$data = [];

while ($RsCud = sqlsrv_fetch_array($rsCud, SQLSRV_FETCH_ASSOC)){
    array_push($data, ["id" => trim($RsCud['nCud']), "text" => trim($RsCud['texto'])]);
}

sqlsrv_free_stmt($rsCud);

echo json_encode($data);