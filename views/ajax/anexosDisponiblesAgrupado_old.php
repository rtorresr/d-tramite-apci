<?php
include_once("../../conexion/conexion.php");
include_once("../../conexion/parametros.php");
include_once("../../conexion/srv-Nginx.php");
// include_once("../DocDigital.php");

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

// $configuracion = new stdClass();
// $configuracion->cnxBd = $cnx;
// $configuracion->cnxRepositorio = RUTA_REPOSITORIO;
// $configuracion->visualizador = RUTA_VISOR_REPOSITORIO;
// $configuracion->ngnix = $url_srv;
// $configuracion->descargaAnexo = RUTA_DTRAMITE.RUTA_DESCARGA_ANEXOS;

// $docDigital = new DocDigital($configuracion);

while($res = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
    $datosAnexos = [];
    $datosAnexos['iCodDigital'] = $res['iCodDigital'];
    $datosAnexos['cNombreOriginal'] = $res['cNombreOriginal'];
    // $datosAnexos['cNombreNuevo'] = $docDigital->obtenerRutaDocDigital($res['iCodDigital']);
    $datosAnexos['cNombreNuevo'] = $url_srv.$res['cNombreNuevo'];
    $datos[] = $datosAnexos;
}

echo json_encode($datos);
