<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

date_default_timezone_set('America/Lima');

$atributo = $_POST['atributo'];
$codigo = $_POST['codigo'];

$sqlAnexos = "SELECT iCodDigital FROM Tra_M_Tramite_Digitales WHERE (iCodTipoDigital = '3' OR iCodTipoDigital = '1' OR iCodTipoDigital = '5') 
              AND ".$atributo." = ".$codigo;
$rsAnexos = sqlsrv_query($cnx,$sqlAnexos);

$datosAnexos = array();

$docDigital = new DocDigital($cnx);

if (sqlsrv_has_rows($rsAnexos)){
    while($RsAnexos = sqlsrv_fetch_array($rsAnexos)){
        $docDigital->obtenerDocDigitalPorId($RsAnexos['iCodDigital']);

        $data = array(
            'iCodDigital' => $docDigital->idDocDigital,
            'cNombreOriginal' => $docDigital->name,
            'cNombreNuevo' => RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital()
        );
        $datosAnexos[] = $data;
    }

    echo json_encode($datosAnexos);
}