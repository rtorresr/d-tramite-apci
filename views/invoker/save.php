<?php
require('config.php');
include_once('../../conexion/conexion.php');
include_once('../../conexion/srv-Nginx.php');
include_once("../../conexion/parametros.php");
include('../../core/CURLConection.php');
include_once("../clases/DocDigital.php");
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

session_start();

$response = new stdClass();
$response->ok = false;

$idDigital = $_REQUEST['idDigital'];

$flgRequireFirmaLote = $_REQUEST['flgRequireFirmaLote'];

$docDigitalOriginal = new DocDigital($cnx);
$docDigitalOriginal->obtenerDocDigitalPorId($idDigital);

$tipo = $_REQUEST['tipo'] == 'f' ? 1 : 4;
$codigo = $_REQUEST['idtra'];
$idEntidad = $_REQUEST['idEntidad'];

$ruta = '';

if($flgRequireFirmaLote == 1){
    $nombreFile = $docDigitalOriginal->clearName;

    $arrayExploded = explode('.',$nombreFile);
    $extension = '.'.array_pop($arrayExploded);
    $nuevoNombre = implode('.',$arrayExploded);

    //$nombreFile = urlencode($nuevoNombre."[R]");
    $nombreFile = urlencode($nuevoNombre."[FP]");

    $separa=DIRECTORY_SEPARATOR;
    $tmp = dirname(tempnam (null,''));

    $tmp_name7z = $tmp.$separa."upload".$separa.$nombreFile.'.7z';
    $tmp_nameZip = $tmp.$separa."upload".$separa.$nombreFile.'.zip';

    shell_exec('arepack -e -F '.$tmp_nameZip.' '.$tmp_name7z);

    $fileFirmado = new ZipArchive;            
    if ($fileFirmado->open($tmp_nameZip) === TRUE) 
    {          
        for($i = 0; $i < $fileFirmado->numFiles; $i++) 
        {   
            $nombrei = $fileFirmado->getNameIndex($i);
            $codigoi = explode('-',$nombrei)[0];
            $entidadi = explode('-',$nombrei)[1];
            $contenti = $fileFirmado->getFromIndex($i);
            $tmp_namei = $tmp.$separa."upload".$separa.$nombrei;

         
            //$arrayNameSinR = explode('-',implode('',explode('[R]',$nombrei)));
            $arrayNameSinR = explode('-',implode('',explode('[FP]',$nombrei)));
            array_shift($arrayNameSinR);
            array_shift($arrayNameSinR);
            $clearNamei = implode('-',$arrayNameSinR);

            file_put_contents($tmp_namei,$contenti);

            $docDigitali = new DocDigital($cnx);                    
            $docDigitali->idTipo = $tipo;
            $docDigitali->tmp_name = $tmp_namei;
            $docDigitali->name = $clearNamei;
            $docDigitali->type = 'application/pdf';
            $docDigitali->idTramite = $codigoi;
            $docDigitali->idEntidad = $entidadi;
            $docDigitali->idOficina = $_SESSION['iCodOficinaLogin'];
            $docDigitali->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];

            if($docDigitali->subirDocumento()){
                if($ruta == ''){
                    $ruta = RUTA_DTRAMITE.$docDigitali->obtenerRutaDocDigital();
                }

                if($codigoi != $codigo){
                    $params = array(
                        $_REQUEST['tipo'],
                        $codigoi,
                        $_SESSION['CODIGO_TRABAJADOR']
                    );
        
                    $sqlActualizaEstado = "{call SP_UPDATE_ESTADOS_VISTO_FIRMA (?,?,?) }";
                    $rs = sqlsrv_query($cnx, $sqlActualizaEstado, $params);
                    if($rs === false) {
                        http_response_code(500);
                        die(print_r(sqlsrv_errors()));
                    }
                }            
            }                    
        }
    }
} else {
    $separa=DIRECTORY_SEPARATOR;
    $tmp = dirname(tempnam (null,''));
    $tmp_name = $tmp.$separa."upload".$separa.$docDigitalOriginal->clearName;

    $docDigital = new DocDigital($cnx);
    $docDigital->idTipo = $tipo;
    $docDigital->tmp_name = $tmp_name;
    $docDigital->name = $docDigitalOriginal->name;
    $docDigital->type = 'application/pdf';

    $docDigital->idTramite = $codigo;
    $docDigital->idEntidad = $idEntidad;
    $docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
    $docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];

    if($docDigital->subirDocumento()){
        $ruta = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
    };

/*    
var_dump('tmp_name: ');
var_dump($tmp_name);
var_dump('subirDocumento: ');
var_dump($docDigital->subirDocumento());
var_dump('obtenerRutaDocDigital: ');
var_dump(RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital());
*/
}

echo json_encode(["url" => $ruta]);