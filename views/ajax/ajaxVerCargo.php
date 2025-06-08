<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');


date_default_timezone_set('America/Lima');

$parametros = array(
    $_POST['iCodMovimiento'][0]
);

$sqlCargoDigital = "{call UP_BUSCAR_CARGO (?) }";
$rsCargoDigital = sqlsrv_query($cnx, $sqlCargoDigital, $parametros);
if($rsCargoDigital === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}
$RsCargoDigital = sqlsrv_fetch_array($rsCargoDigital, SQLSRV_FETCH_ASSOC);

$datos = [];
$datos['estado'] = $RsCargoDigital['ESTADO'];

if ($RsCargoDigital['ESTADO'] == 1){
    $docDigital = new DocDigital($cnx);
    $docDigital->obtenerDocDigitalPorId($RsCargoDigital['IDCARGO'], 1);

    $datos['url'] = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();
}

echo json_encode($datos);
?>

