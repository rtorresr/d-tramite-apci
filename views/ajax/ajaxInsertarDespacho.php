<?php
require_once "../../conexion/conexion.php";
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

require_once("../../conexion/srv-Nginx.php");

session_start();

if ($_POST['IdTipoEnvio'] == '72'){
    $docDigital = new DocDigital($cnx);
    $docDigital->idTramite = $_POST['CodTramite'];
    $docDigital->idTipo = 0;
    $docDigital->obtenerDocMayor();

    $base = chunk_split(base64_encode($docDigital->obtenerDocBinario()));
}

$params = array(
     $_POST['CodMovimiento']
    ,$_POST['CodTramite']
    ,$_POST['CodDestinatario']
    ,$_POST['IdTipoEnvio']
    ,$base??''
    ,$_POST['ObservacionesDespacho']??''
    ,$_POST['DireccionDestinatario']??''
    ,$_POST['DepartamentoDestinatario']??0
    ,$_POST['ProvinciaDestinatario']??0
    ,$_POST['DistritoDestinatario']??0
    ,$_POST['FlgReenvio']??0
    ,$_SESSION['IdSesion']
);

$sql = "{call UP_INSERTAR_DESPACHO_DETALLE (?,?,?,?,?,?,?,?,?,?,?,?) }";

$rs = sqlsrv_query($cnx, $sql, $params);
if($rs === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}