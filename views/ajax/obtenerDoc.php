<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');

$docDigital = new DocDigital($cnx);
$docDigital->idTramite = $_POST['codigo'];
$docDigital->idTipo = 0;
$docDigital->idEntidad = $_POST['destino'] ?? 0;
$docDigital->obtenerDocMayor();

if($docDigital->idDocDigital > 0){
    $urlDoc = array(
        'url' => RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital(),
        'nombre' => $docDigital::formatearNombre($docDigital->name,true,[' '])
    );
    echo json_encode($urlDoc);
} else {
    $urlDoc = [];
    echo json_encode($urlDoc);
}