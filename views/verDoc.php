<?php
require_once("../conexion/conexion.php");
require_once("../conexion/parametros.php");
require_once('clases/DocDigital.php');
require_once("clases/Log.php");
require_once('../vendor/autoload.php');
date_default_timezone_set('America/Lima');


$idm = $_POST['iCodMovimiento'][0];
$tipo = $_POST["tabla"];

if ($tipo == 't'){
    $atributo = 'iCodTramite';
} else {
    $atributo = 'iCodProyecto';
}
$sqlMovP = "SELECT ".$atributo." AS codigo FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento =".$idm;
$rsMovP = sqlsrv_query($cnx,$sqlMovP);
$RsMovP = sqlsrv_fetch_array($rsMovP);

$sql= "SELECT TOP(1) iCodDigital, ".$atributo." AS codigo from Tra_M_Tramite_Digitales where ".$atributo." = ".$RsMovP["codigo"]." AND iCodTipoDigital NOT IN ('3','7') ORDER BY iCodDigital DESC";

$rspro = sqlsrv_query($cnx,$sql);
if($rspro === false) {
    $arr = array(
        'estado' => 0
    );
    echo json_encode($arr);
} else {
    if(sqlsrv_has_rows($rspro)) {
        $pro = sqlsrv_fetch_array($rspro);

        $docDigital = new DocDigital($cnx);
        $docDigital->obtenerDocDigitalPorId($pro['iCodDigital']);

        $arr = array(
            'url' => RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital(),
            'codigo' => $pro['codigo'],
            'estado' => 1
        );
        echo json_encode($arr);
    } else {
        $arr = array(
            'estado' => 0
        );
        echo json_encode($arr);
    }
}

// // // $arr = array(
// // //         'url' => $ruta,
// // //         'codigo' => $idTramite,
// // //         'estado' => 1
// // //     );
// // // echo json_encode($arr);
?>

