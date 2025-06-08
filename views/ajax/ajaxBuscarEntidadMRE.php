<?php
include_once("../../conexion/conexion.php");

$params = array(
    $_POST['IdEntidadMRE'],
    NULL,
    NULL
);

$sql = "{call UP_BUSCAR_ENTIDAD_MRE (?,?,?) }";
$rs = sqlsrv_query($cnx, $sql, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
$datos = array(
    "nombre"    =>  $Rs['NombreEntMRE'],
    "codigo"    =>  $Rs['CodigoMRE']
);

echo json_encode($datos);