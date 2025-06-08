<?php

require '../../vendor/autoload.php';

require_once("../../conexion/conexion.php");
require_once("../../core/CURLConection.php");
require_once("../../conexion/parametros.php");
require_once("../clases/DocDigital.php");
require_once("../clases/Email.php");
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');


session_start();

switch ($_POST['Evento']) {
    case 'ListarCudsPendientes':
        $params = array(
            $_POST['Cud']
        );
        $sql = "{ call SIGCTI.UP_SUBSANACION_SOLICITUD_TRAMITE_SIN_ENVIAR (?) }";
        $rs = sqlsrv_query($cnx, $sql, $params);
        if ($rs === false){
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $datos = [];
        while ($Rs = sqlsrv_fetch_object($rs)){
            array_push($datos, $Rs);
        }
        echo json_encode($datos);
        break;

    case 'SubsanarCudPendiente':
        $params = array(
            $_POST['Cud']
        );
        $sql = "{ call SIGCTI.UP_OBTENER_DATOS_SOLICITUD_TRAMITE_SIN_ENVIAR (?) }";
        $rs = sqlsrv_query($cnx, $sql, $params);
        if ($rs === false){
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC);

        $docDigital = new DocDigital($cnx);
        $docDigital->obtenerDocDigitalPorId($Rs['IdDigital']);
        $rutaArchivo = 'http://d-tramite.apci.gob.pe/'.$docDigital->obtenerRutaDocDigital();

        $destinatarios = json_decode($Rs['Destinatario']);

        $destinatarios = reset($destinatarios);
        $destinatarios = $destinatarios->nomRemitente;

        $url = "http://sso.apci.gob.pe"."/ApiD-Tramite/Api/Tramite/TRA_GET_0005";
        $data = array(
            "CodInscripcion" => $Rs['IdInscripcion'],
            "CodObservacion" => ($Rs['IdObservacion'] ?? '0'),
            "CodMovimiento" => $Rs['CodMovimiento'],
            "CodTupa" => $Rs['IdTupa'],
            "Denominacion" => urlencode($destinatarios),
            "listArchivo" => [$rutaArchivo],
            "CodUsuario" => $Rs['Usuario']
        );

        $client = curl_init();
        curl_setopt($client, CURLOPT_URL, $url);
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($client, CURLOPT_POST, true);
        curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = json_decode(curl_exec($client));

        $log = new Log($cnx);
        
        $retorno = new stdClass();
        $retorno->success = true;

        if(!$response->Success){
            $datosMail = new stdClass();
            $datosMail->asunto = 'Error en la ejecución';
            $datosMail->correos = array(
                CORREO_SIGCTI
            );
            $datosMail->cuerpo = "No se ha ejecutado el servicio $url con los siguientes parametros:<br/> ".json_encode($data);
            
            $log->logging($datosMail);

            $retorno->success = false;
        }

        $datosDB = new stdClass();
        $datosDB->archivo = 'Documento.php';
        $datosDB->metodo = "DerivarDestino | $url";
        $datosDB->resultado = $response->Success ? 1 : 0;
        $datosDB->mensaje = $response->MessageResult;
        $datosDB->contenido = json_encode($data);             

        $log->logging(false, $datosDB);

        echo json_encode($retorno);
        break;
}