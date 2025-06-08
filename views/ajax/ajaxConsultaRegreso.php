<?php
include_once("../../conexion/conexion.php");

$params = array(
    $_POST['cAgrupado']
);
$sqlConsultaRegreso = "{call SP_CONSULTA_REGRESO (?) }";
$rs = sqlsrv_query($cnx, $sqlConsultaRegreso, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$data = [];
if(sqlsrv_has_rows($rs)){
    $data['regreso'] = 'si';
} else {
    $data['regreso'] = 'no';
}
echo json_encode($data);
