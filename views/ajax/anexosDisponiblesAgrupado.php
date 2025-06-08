<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');


date_default_timezone_set('America/Lima');

$codigo = $_POST['cAgrupado'];

$params = array(
    $codigo
);

$sqlAnexosAgrupado = "{call SP_ANEXOS_DISPONIBLES_AGRUPADO (?) }";
$rs = sqlsrv_query($cnx, $sqlAnexosAgrupado, $params);
if($rs === false) {
    die(print_r(sqlsrv_errors(), true));
}
$datos = [];

$docDigital = new DocDigital($cnx);

while($res = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
    $docDigital->obtenerDocDigitalPorId($res['iCodDigital']);

    $datosAnexos = [];
    $datosAnexos['iCodDigital'] = $res['iCodDigital'];
    $datosAnexos['cNombreOriginal'] = $res['cNombreOriginal'];
    $datosAnexos['cNombreNuevo'] = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
    $datos[] = $datosAnexos;
}

echo json_encode($datos);
