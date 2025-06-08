<?php
include_once("../../conexion/conexion.php");
include_once("../../conexion/parametros.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../DocDigital.php");
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

date_default_timezone_set('America/Lima');

$params = array(
    $_POST['iCodDigital']
);
$sql = "{call SP_DATOS_CODIGO_DIGITAL (?) }";
$rs = sqlsrv_query($cnx, $sql, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}

if (sqlsrv_has_rows($rs)){
    $configuracion = new stdClass();
    $configuracion->cnxBd = $cnx;
    $configuracion->cnxRepositorio = RUTA_REPOSITORIO;
    $configuracion->visualizador = RUTA_VISOR_REPOSITORIO;
    $configuracion->ngnix = $url_srv;
    $configuracion->descargaAnexo = RUTA_DTRAMITE.RUTA_DESCARGA_ANEXOS;

    $docDigital = new DocDigital($configuracion);

    $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
    $datosAnexos = [];

    $datosAnexos['iCodDigital'] = $Rs['iCodDigital'];
    $datosAnexos['cNombreOriginal'] = $Rs['cNombreOriginal'];
    $datosAnexos['cNombreNuevo'] = $docDigital->obtenerRutaDocDigital($Rs['iCodDigital']);

    echo json_encode($datosAnexos);
}