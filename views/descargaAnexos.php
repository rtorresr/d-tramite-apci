<?php
include_once("../conexion/conexion.php");
include_once("../conexion/parametros.php");
include_once("DocDigital.php");
require_once("clases/Log.php");
require_once('../vendor/autoload.php');

session_start();

$idDocDigital = $_GET['id'];

$docDigital = new DocDigital($cnx,RUTA_REPOSITORIO);
$resultado = $docDigital->descargarDocumento($idDocDigital);
?>