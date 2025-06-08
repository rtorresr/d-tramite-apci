<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once("../../core/CURLConection.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');


session_start();

$archivos = $_FILES['fileUpLoadDigital'];
$datos = [];

$docDigital = new DocDigital($cnx);
$docDigital->idTipo = $_POST['IdTipo'];
$docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
$docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
$docDigital->sesion = $_SESSION['IdSesion'];
$docDigital->idTramite = isset($_POST['IdTramite']) ? $_POST['IdTramite'] : null;

for ($i = 0; $i < count($archivos['tmp_name']); $i++) {    
    $datosParcial = [];

    $docDigital->tmp_name = $archivos['tmp_name'][$i];
    $docDigital->name = $archivos['name'][$i];
    $docDigital->type = $archivos['type'][$i];
    $docDigital->size = $archivos['size'][$i];

    if($docDigital->subirDocumentoSecundario()){
        $datosParcial['evento'] = 'REGISTRADO';
        $datosParcial['nombre'] = $docDigital->name;
        $datosParcial['ruta'] = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();
        $datosParcial['codigo'] = $docDigital->idDocDigital;
        $datosParcial['mensaje'] = 'Registrado correctamente';

        $datos[] = $datosParcial;
    }

    
}
echo json_encode($datos);
?>