<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once("../../core/CURLConection.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');


session_start();

$agrupado = $_SESSION['iCodOficinaLogin'].$_SESSION['CODIGO_TRABAJADOR'].date("YmdGis");

$archivos = $_FILES['fileUpLoadDigital'];

$resultado = new stdClass();
$datos = [];

$docDigital = new DocDigital($cnx);
$docDigital->idTipo = 5;
$docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
$docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
$docDigital->grupo = $agrupado;

try {
    for ($i = 0; $i < count($archivos['tmp_name']); $i++) {
        $docDigital->idDocDigital = null;
        $docDigital->idTramite = null;
        $docDigital->path = null; 
        
        $docDigital->tmp_name = $archivos['tmp_name'][$i];
        $docDigital->name = $archivos['name'][$i];
        $docDigital->type = $archivos['type'][$i];
        $docDigital->size = $archivos['size'][$i];

        if($docDigital->subirDocumento()){
            $datosParcial = [];
            $datosParcial['codigo'] = $docDigital->idDocDigital;
            $datosParcial['original'] = $archivos['name'][$i];
            $datosParcial['nuevo'] = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
            $datos[] = $datosParcial;
        }
    }
    $resultado->success = true;
    $resultado->mensaje = "Documendos subidos correctamente";
    $resultado->data = $datos;
} catch (\Exception $e){
    $resultado->success = false;
    $resultado->mensaje = $e->getMessage();
    $resultado->data = $datos;
} finally {
    echo json_encode($resultado);
}
?>