<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

require_once('../../conexion/conexion.php');
require_once("../../conexion/srv-Nginx.php");
require_once("../../conexion/parametros.php");
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");


session_start();

date_default_timezone_set('America/Lima');
if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    switch ($_POST['Evento']) {
        case 'RegistroSolicitud':
            #1. Registro de solicitud
            $params = array(
                $_POST['IdOficinaRequerida'],
                json_encode($_POST['DataDetalle']),
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_INSERTAR_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            #2. Generacion de la solicitud
            $datos = $Rs;
            include("../solicitud_prestamo_pdf.php");

            $flgSegundoPdf = 1;    
            $idDocDigital = 0;        
            include("../solicitud_prestamo_pdf.php");

            unset($flgSegundoPdf);

            #3. Envio de correo
            $nombres = $Rs['NOMBRE_COMPLETO'];
            $correo = $Rs['CORREO'];
            $nombre_doc = $Rs['NOMBRE_DOC'];

            $asunto = 'Solicitud de préstamo '.$nombre_doc;
            $cuerpo = '<p>Estimado(a) '.$nombres.', usted a recibido la solicitud de préstamo '.$nombre_doc.', el cual cuenta con 5 días de atención apartir de la presente fecha.';

            $correos = [];
            array_push($correos,$correo);

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
                $mail->Password = MAIL_PASSWORD;                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                //$mail->addAddress('jatayauri@apci.gob.pe', 'Joe User');     // Add a recipient
                for ($e = 0; $e < count($correos); $e++){
                    $mail->addAddress($correos[$e]);
                }

                //Content
                $mail->isHTML(true);// Set email format to HTML
                $mail->Subject = $asunto;
                $mail->Body = $cuerpo;
                $mail->CharSet = 'UTF-8';
                $mail->AltBody = 'No responder';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            #4. Retorno de archivo para firma
            
            break;

        case 'ObtenerDetalleSolicitud':
            $params = array(
                $_POST['IdSolicitudPrestamo']
            );
            $sql = "{call UP_OBTENER_DETALLE_SOLICITUD_PRESTAMO  (?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $data = [];
            while ($Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
                $datos = [];
                $datos = $Rs;
                $datos['dominio'] = $host.":".$port.$path;
                array_push($data,$datos);
            }

            $recordsTotal=sqlsrv_num_rows($rs);
            $recordsFiltered=sqlsrv_num_rows($rs);

            $json_data = array(
                "draw"            => (int)($request['draw']??0),
                "recordsTotal"    => (int) $recordsTotal ,
                "recordsFiltered" => (int) $recordsFiltered ,
                "data"            => $data
            );

            echo json_encode($json_data);
            break;

        case 'VerDocumentoPrestamoDetalle':
            $params = array(
                $_POST['IdDetallePrestamo']
            );
            $sql = "{call UP_OBTENER_DOC_DIGITAL_DETALLE_SOLICITUD_PRESTAMO  (?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            $docDigital = new DocDigital($cnx);
            $docDigital->obtenerDocDigitalPorId($Rs['IdDocDigital'], 1);
            $data['RutaDocDigital'] = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();

            echo json_encode($data);
            break;

        case 'ActualizarDatosDetallePrestamo':
            $params = array(
                $_POST['codDetalleSolicitud'],
                $_POST['FlgTipoDocumento']??1,
                $_POST['idTipoServicioOfrecido'],
                $_POST['idTipoUbicacion']??NULL,
                $_POST['idSolicitudExternaDetalle']??NULL,
                isset($_POST['documentoDigital']) ? json_encode($_POST['documentoDigital']) : '',
                $_SESSION['IdSesion']
            );

            $sql = "{call UP_ACTUALIZAR_DATOS_PRESTAMO_DETALLE  (?,?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'EditarDatosDetallePrestamo':
            $params = array(
                $_POST['codSolicitudPrestamo'],
                $_POST['codDetalleSolicitud'],
                $_POST['NroExpediente'],
                $_POST['DescripcionDocumento'],
                $_POST['FlgTipoDocumento']??0,
                ($_POST['FlgTipoDocumento']??0) == 1 ? $_POST['idTipoServicioOfrecido'] : 0,
                $_SESSION['IdSesion']
            );
            print_r($params);

            $sql = "{call UP_EDITAR_DATOS_PRESTAMO_DETALLE  (?,?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;     
            
        case 'EnviarSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_ENVIAR_SOLICITUD (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }

            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            $nombres = $Rs['NOMBRE_COMPLETO'];
            $correo = $Rs['CORREO'];
            $nombre_doc = $Rs['NOMBRE_DOC'];

            $asunto = 'Reitero de la Solicitud de préstamo '.$nombre_doc.' - Subsanado';
            $cuerpo = '<p>Estimado(a) '.$nombres.', usted a recibido la solicitud de préstamo '.$nombre_doc.' subsanda, el cual cuenta con 5 días de atención apartir de la presente fecha.';

            $correos = [];
            array_push($correos,$correo);

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
                $mail->Password = MAIL_PASSWORD;                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                //$mail->addAddress('jatayauri@apci.gob.pe', 'Joe User');     // Add a recipient
                for ($e = 0; $e < count($correos); $e++){
                    $mail->addAddress($correos[$e]);
                }

                //Content
                $mail->isHTML(true);// Set email format to HTML
                $mail->Subject = $asunto;
                $mail->Body = $cuerpo;
                $mail->CharSet = 'UTF-8';
                $mail->AltBody = 'No responder';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'CambiarListo':
            $params = array(
                $_POST['IdDetallePrestamo'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_CAMBIAR_SOLICITUD_DETALLE_LISTO  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'EliminarDetalle':
            $params = array(
                $_POST['IdDetallePrestamo'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_ELIMINAR_SOLICITUD_DETALLE  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'NotificarSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_NOTIFICAR_SOLICITUD_PRESTAMO  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC);
            $nombres = $Rs['NOMBRE_COMPLETO'];
            $correo = $Rs['CORREO'];
            $nombre_doc = $Rs['NOMBRE_DOC'];

            $asunto = 'Solicitud de préstamo '.$nombre_doc;
            $cuerpo = '<p>Estimado(a) '.$nombres.', su solicitud de préstamo '.$nombre_doc.' ya esta lista por favor revisar.';

            $correos = [];
            array_push($correos,$correo);

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
                $mail->Password = MAIL_PASSWORD;                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                //$mail->addAddress('jatayauri@apci.gob.pe', 'Joe User');     // Add a recipient
                for ($e = 0; $e < count($correos); $e++){
                    $mail->addAddress($correos[$e]);
                }

                //Content
                $mail->isHTML(true);// Set email format to HTML
                $mail->Subject = $asunto;
                $mail->Body = $cuerpo;
                $mail->CharSet = 'UTF-8';
                $mail->AltBody = 'No responder';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'ReNotificarSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_RE_NOTIFICAR_SOLICITUD_PRESTAMO  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC);
            $nombres = $Rs['NOMBRE_COMPLETO'];
            $correo = $Rs['CORREO'];
            $nombre_doc = $Rs['NOMBRE_DOC'];

            $asunto = 'Solicitud de préstamo '.$nombre_doc;
            $cuerpo = '<p>Estimado(a) '.$nombres.', su solicitud de préstamo '.$nombre_doc.' ya esta lista por favor revisar.';

            $correos = [];
            array_push($correos,$correo);

            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
                $mail->Password = MAIL_PASSWORD;                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                //$mail->addAddress('jatayauri@apci.gob.pe', 'Joe User');     // Add a recipient
                for ($e = 0; $e < count($correos); $e++){
                    $mail->addAddress($correos[$e]);
                }

                //Content
                $mail->isHTML(true);// Set email format to HTML
                $mail->Subject = $asunto;
                $mail->Body = $cuerpo;
                $mail->CharSet = 'UTF-8';
                $mail->AltBody = 'No responder';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'DerivarArchivoCentral':
                $params = array(
                    $_POST['IdSolicitudPrestamo'],
                    $_SESSION['IdSesion']
                );
                $sql = "{call UP_DERIVAR_ARCHIVO_CENTRAL_SOLICITUD_PRESTAMO  (?,?) }";
                $rs = sqlsrv_query($cnx, $sql, $params);
                if($rs === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
                $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
               
                $data = [];
                $data['COMENTARIO'] = $Rs['COMENTARIO'];
                echo json_encode($data);
                break;

        case 'AnularSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_POST['Observacion'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_ANULAR_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
            IF ($Rs['ANULADO'] === 0){
                $asunto = 'Solicitud de préstamo '.$Rs['NOMBRE_DOC'];
                $cuerpo = '<p>Estimado(a) '.$Rs['NOMBRE_COMPLETO'].', su solicitud de préstamo '.$Rs['NOMBRE_DOC'].' fue anulado con la siguiente observación: '.$Rs['OBSERVACION'];

                $correos = [];
                array_push($correos,$Rs['CORREO']);

                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'd-tramite@apci.gob.pe';                 // SMTP username
                    $mail->Password = MAIL_PASSWORD;                           // SMTP password
                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('no-reply@apci.gob.pe', 'D-Trámite');
                    //$mail->addAddress('jatayauri@apci.gob.pe', 'Joe User');     // Add a recipient
                    for ($e = 0; $e < count($correos); $e++){
                        $mail->addAddress($correos[$e]);
                    }

                    //Content
                    $mail->isHTML(true);// Set email format to HTML
                    $mail->Subject = $asunto;
                    $mail->Body = $cuerpo;
                    $mail->CharSet = 'UTF-8';
                    $mail->AltBody = 'No responder';

                    $mail->send();
                    //echo 'Message has been sent';
                } catch (Exception $e) {
                    //echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
            }
            $data = [];
            $data['ANULADO'] = $Rs['ANULADO'];
            echo json_encode($data);
            break;

        case 'ObservarSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_POST['Observacion'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_OBSERVAR_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            $data = [];
            $data['OBSERVADO'] = $Rs['OBSERVADO'];
            echo json_encode($data);
            break;

        case 'DevolverFaltaDatosSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_POST['Observacion'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_DEVOLVER_FALTA_DATOS_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            $data = [];
            $data['DEVUELTO'] = $Rs['DEVUELTO'];
            echo json_encode($data);
            break;

        case 'DevolverNoObrarArchivoSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_POST['Observacion'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_DEVOLVER_NO_OBRAR_ARCHIVO_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            $data = [];
            $data['DEVUELTO'] = $Rs['DEVUELTO'];
            echo json_encode($data);
            break;

        case 'AmpliarPLazoAtencionSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_POST['Observacion'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_AMPLIAR_PLAZO_ATENCION_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            $data = [];
            $data['AMPLIADO'] = $Rs['AMPLIADO'];
            echo json_encode($data);
            break;

        case 'ArchivarSolicitudPrestamo':
            $params = array(
                $_POST['IdSolicitudPrestamo'],
                $_POST['Observacion'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_ARCHIVAR_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);

            $data = [];
            $data['ARCHIVADO'] = $Rs['ARCHIVADO'];
            echo json_encode($data);
            break;

        case 'RecibirDocumentos':
            foreach ($_POST['IdPrestamoDetalle'] AS $i => $value){
                $params = array(
                    $_POST['IdPrestamoDetalle'][$i],
                    $_SESSION['IdSesion']
                );
                $sql = "{call UP_RECIBIR_DOCUMENTOS_SOLICITUD_PRESTAMO  (?,?) }";
                $rs = sqlsrv_query($cnx, $sql, $params);
                if($rs === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
            };

            break;

        case 'SolicitarAmpliacionPlazo':
            $params = array(
                $_POST['IdPrestamoDetalle'],
                $_POST['Observacion'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_SOLICITAR_AMPLIACION_PLAZO_SOLICITUD_PRESTAMO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'AmpliarPlazoSolicitud':
            $params = array(
                $_POST['IdDetallePrestamo'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_AMPLIAR_PLAZO_DETALLE  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'RegistrarDevolucion':
            $params = array(
                $_POST['codDetalleSolicitudDevolver'],
                isset($_POST['documentoDigitalDevolver']) ? json_encode($_POST['documentoDigitalDevolver']) : '',
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_REGISTRAR_DEVOLUCION_DOCUMENTO  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'ObtenerDatosSolicitudExternaDetalle':
            $params = array(
                $_POST['CodigoSolicitudExternaDetalle']
            );
            $sql = "{call UP_OBTENER_DATOS_SOLICITUD_EXTERNA_DETALLE  (?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
            echo json_encode($Rs);
            break;

        case 'ObtenerHistorico':
            $params = [
                $_POST['IdSolicitudPrestamo']
            ];
            
            $sql = "{call UP_LISTAR_SOLICITUD_PRESTAMO_HISTORICO (?)}";
            
            $rs = sqlsrv_query($cnx,$sql,$params);
            
            if($rs === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            
            $data = array();
            
            while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
                $subdata=array();
                $subdata = $Rs;
                $subdata['FecRegistro'] = $Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'Y-m-d H:i:s') : '';
                
                $data[]=$subdata;
            }

            echo json_encode($data);            
            break;
    }
}else{
    header("Location: ../../index-b.php?alter=5");
}

?>