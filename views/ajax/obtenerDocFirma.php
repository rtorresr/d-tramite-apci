<?php
require_once("../../conexion/conexion.php");
require_once("../../core/CURLConection.php");
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../clases/Zip.php');
require_once('../../vendor/autoload.php');

session_start();

$response = new stdClass();
$response->ok = false;

$docDigital = new DocDigital($cnx);

$agrupado = $_SESSION['iCodOficinaLogin'].$_SESSION['CODIGO_TRABAJADOR'].date("YmdGis");
$nombreComprimido = $agrupado.'firmaLote';
$rutaTempZip = '../../archivosTemp/'.$nombreComprimido.'.zip';  
$rutaTemp7z = '../../archivosTemp/'.$nombreComprimido.'.7z';

$listado = [];

$flgRequiereFirmaLote = 0;

if($_POST['tipo'] == 2){
    $listado[] = array(
        "id" => $_POST['codigo'],
        "destino" => 0,
        "notificacion" => 0
    );
} else {
    $params = array(
        $_POST['codigo'],
        0
    );
    $sqlAdd = "{call SP_CONSULTA_DATOS_DOCUMENTO_DESTINATARIOS (?,?) }";
    $rs = sqlsrv_query($cnx, $sqlAdd, $params);
    if($rs === false) {
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }

    $cantidadDestinos = 0;   

    while( $row = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
        $cantidadDestinos++;
        $listado[] = array(
            "id" => $_POST['codigo'],
            "destino" => $row['iCodRemitente'],
            "notificacion" => 0
        );
        if($row['idTipoEnvio'] == 98){
            $listado[] = array(
                "id" => $row['idTramiteNotificacion'],
                "destino" => $row['iCodRemitente'],
                "notificacion" => 1
            );
            $flgRequiereFirmaLote = 1;
        }
    }

    if($cantidadDestinos > 1){
        $flgRequiereFirmaLote = 1;
    }
}

if($flgRequiereFirmaLote == 0){
    $i = $listado[0];
    
    $docDigital->idTramite = $i['id'];
    $docDigital->idTipo = 0;
    $docDigital->idEntidad = $i['destino'];
    $docDigital->obtenerDocMayor();

    if($docDigital->idDocDigital > 0){       
        if ($docDigital->idTipo == 2){    
            $docDigital->idTramite = $i['id'];
            $docDigital->idTipo = 8;
            $docDigital->idEntidad = $i['destino'];
            $docDigital->obtenerDocMayor();
        }

        $response->ok = true;
        $response->data = $docDigital->idDocDigital;     
        $response->idEntidad = $i['destino'];   
    }
    
} else {
    foreach ($listado as $i) {
        $docDigital->idTramite = $i['id'];
        $docDigital->idTipo = 0;
        $docDigital->idEntidad = $i['destino'];
        $docDigital->obtenerDocMayor();

        if($docDigital->idDocDigital > 0){
            if ($docDigital->idTipo == 2){    
                $docDigital->idTramite = $i['id'];
                $docDigital->idTipo = 8;
                $docDigital->idEntidad = $i['destino'];
                $docDigital->obtenerDocMayor();
            }

            $result = Zip::agregarArchivo($rutaTempZip,$i['id'].'-'.$i['destino'].'-'.$docDigital->clearName,$docDigital->obtenerDocBinario());
        }
    }

    $command = 'arepack -e -F '.$rutaTemp7z.' '.$rutaTempZip.' 2>&1';
    $execResult = shell_exec($command);

    $comprimido = new DocDigital($cnx);
    $comprimido->idTipo = 14;
    $comprimido->idOficina = $_SESSION['iCodOficinaLogin'];
    $comprimido->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
    $comprimido->grupo = $agrupado;  

    $comprimido->tmp_name = $rutaTemp7z;
    $comprimido->name = $nombreComprimido.'.7z';
    $comprimido->type = "application/x-7z-compressed";

    if($comprimido->subirDocumento()){
        $response->ok = true;
        $response->data = $comprimido->idDocDigital;
    }

    DocDigital::eliminar($rutaTempZip);
    DocDigital::eliminar($rutaTemp7z);

    $response->idEntidad = 0;
}

$response->flgRequireFirmaLote = $flgRequiereFirmaLote;

echo json_encode($response);


// $docDigital = new DocDigital($cnx);
// $docDigital->idTramite = $_POST['codigo'];
// $docDigital->idTipo = 0;
// $docDigital->obtenerDocMayor();

// if($docDigital->idDocDigital > 0){
//     $idDigital = $docDigital->idDocDigital;
    
//     if ($docDigital->idTipo == 2){

//         $docDigital->idTramite = $_POST['codigo'];
//         $docDigital->idTipo = 8;
//         $docDigital->obtenerDocMayor();
        
//         $idDigital = $docDigital->idDocDigital;
//     }

//     $urlDoc = array(
//         'idDigital' => $idDigital
//     );
    
//     echo json_encode($urlDoc);
// }
