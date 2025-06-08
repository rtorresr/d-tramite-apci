<?php
session_start();
require_once('../conexion/conexion.php');
require_once("../conexion/parametros.php");
require_once('clases/DocDigital.php');
require_once("clases/Log.php");
require_once('../vendor/autoload.php');

require_once("../core/CURLConection.php");

date_default_timezone_set('America/Lima');

if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    switch ($_POST['Evento']) {
        case "SubirDoc":
            $docDigitalMesa = new DocDigital($cnx);
            $docDigitalMesa->obtenerDocDigitalPorId($_POST['IdDigital']);
            $docDigitalMesa->tmp_name = RUTA_DTRAMITE.$docDigitalMesa->obtenerRutaDocDigital();
            $docDigitalMesa->cargarDocumento();
            
            $response = new stdClass();
            $response->success = true;
            $response->entidad = $docDigitalMesa;

            echo json_encode($response);

            break;
    }

}else{
    header("Location: ../../index-b.php?alter=5");
}

?>