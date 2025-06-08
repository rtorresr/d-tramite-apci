<?php
include_once("../../conexion/conexion.php");
date_default_timezone_set('America/Lima');

$codigo = $_POST['cAgrupado'];

$params = array(
    $codigo
);

$sqlReferenciaAgrupado = "{call SP_REFERENCIA_DISPONIBLE_AGRUPADO (?) }";
$rs = sqlsrv_query($cnx, $sqlReferenciaAgrupado, $params);
if($rs === false) {
    die(print_r(sqlsrv_errors(), true));
}
$datos = [];
while($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
    array_push($datos, ["id" => $Rs['iCodTramite'], "text" => $Rs['texto']]);
}
echo json_encode($datos);