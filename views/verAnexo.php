<?php
require_once("../conexion/conexion.php");
require_once("../conexion/parametros.php");
require_once('clases/DocDigital.php');
require_once("clases/Log.php");
require_once('../vendor/autoload.php');

date_default_timezone_set('America/Lima');


if (isset($_POST['iCodMovimiento'])) {
    $idm = $_POST['iCodMovimiento'];

    $sqlMovP = "SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = " . $idm;
    $rsMovP = sqlsrv_query($cnx, $sqlMovP);
    $RsMovP = sqlsrv_fetch_array($rsMovP);

    $sql = "SELECT iCodDigital from Tra_M_Tramite_Digitales where iCodTramite = " . $RsMovP["iCodTramite"] . " AND iCodTipoDigital = '3' ORDER BY iCodDigital ASC";
} else {
    $sql = "SELECT iCodDigital from Tra_M_Tramite_Digitales where iCodTramite = " . $_POST["codigo"] . " AND iCodTipoDigital = '3' ORDER BY iCodDigital ASC";
}
$pros=sqlsrv_query($cnx,$sql);

if($pros === false) {
    $data['tieneAnexos'] = '0';
    echo json_encode($data);
} else {
    if (sqlsrv_has_rows($pros)) {
        $data['tieneAnexos'] = '1';        

        $docDigital = new DocDigital($cnx);        
        
        $anexos = array();
        while ($RsPro = sqlsrv_fetch_array($pros)) {
            $info = array();

            $docDigital->obtenerDocDigitalPorId($RsPro['iCodDigital']);
            $info['nombre'] = $docDigital->name;
            $info['url'] = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
            
            $anexos[] = $info;
        }
        $data['anexos'] = $anexos;

        echo json_encode($data);
    } else {
        $data['tieneAnexos'] = '0';
        echo json_encode($data);
    }
}