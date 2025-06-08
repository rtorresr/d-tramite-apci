<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');

$parametros = array(
    $_POST['codigo']
);
$sql = "{call SP_OBTENER_CARGO_ID_INTEROPERABILIDAD (?) }";
$rs = sqlsrv_query($cnx, $sql, $parametros);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}

$Rs = sqlsrv_fetch_array($rs);

$docDigital = new DocDigital($cnx);
$docDigital->obtenerDocDigitalPorId($Rs['IdDocDigital'], 1);

if ($docDigital->idDocDigital != null && $docDigital->idDocDigital != 0){
    $urlDoc = array(
        'url' => RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario(),
        'nombre' => $docDigital::formatearNombre($docDigital->name,true,[' '])
    );
    echo json_encode($urlDoc);
}