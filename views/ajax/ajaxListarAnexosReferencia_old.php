<?php
include_once("../../conexion/conexion.php");
include_once("../../conexion/parametros.php");
include_once("../../conexion/srv-Nginx.php");
include_once("../DocDigital.php");
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');


date_default_timezone_set('America/Lima');

$atributo = $_POST['atributo'];
$codigo = $_POST['codigo'];

$sqlAnexos = "SELECT iCodDigital, cNombreOriginal, '".$url_srv."' + cNombreNuevo AS cNombreNuevo FROM Tra_M_Tramite_Digitales WHERE (iCodTipoDigital = '3' OR iCodTipoDigital = '1' OR iCodTipoDigital = '5') 
              AND ".$atributo." = ".$codigo;
$rsAnexos = sqlsrv_query($cnx,$sqlAnexos);
$datosAnexos = array();

if (sqlsrv_has_rows($rsAnexos)){
    $configuracion = new stdClass();
    $configuracion->cnxBd = $cnx;
    $configuracion->cnxRepositorio = RUTA_REPOSITORIO;
    $configuracion->visualizador = RUTA_VISOR_REPOSITORIO;
    $configuracion->ngnix = $url_srv;
    $configuracion->descargaAnexo = RUTA_DTRAMITE.RUTA_DESCARGA_ANEXOS;

    $docDigital = new DocDigital($configuracion);    

    while($RsAnexos = sqlsrv_fetch_array($rsAnexos)){
        $data = array(
            'iCodDigital' => $RsAnexos['iCodDigital'],
            'cNombreOriginal' => $RsAnexos['cNombreOriginal'],
            'cNombreNuevo' => $docDigital->obtenerRutaDocDigital($RsAnexos['iCodDigital'])
        );
        $datosAnexos[] = $data;
    }

    echo json_encode($datosAnexos);
}