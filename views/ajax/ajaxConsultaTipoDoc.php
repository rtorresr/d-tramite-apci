<?php
include_once("../../conexion/conexion.php");

$params = array(
    $_POST['iCodMovimiento'][0]
);
$sqlConsultaTipoDocumento = "{call SP_CONSULTA_TIPO_DOCUMENTO (?) }";
$rs = sqlsrv_query($cnx, $sqlConsultaTipoDocumento, $params);
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
