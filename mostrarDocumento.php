<?php
require_once "conexion/conexion.php";
require_once "conexion/parametros.php";
require_once "views/clases/DocDigital.php";
require_once("views/clases/Log.php");
require_once('vendor/autoload.php');

$data = $_GET['d'];
$principal = isset($_GET['p']) ? 0 : 1;

$datos = json_decode(base64_decode($data));

$docDigital = new DocDigital($cnx);
$docDigital->descargarDocumento($datos->idDigital,$principal);
?>