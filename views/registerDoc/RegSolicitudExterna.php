<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

include_once('../../conexion/conexion.php');
include_once("../../conexion/srv-Nginx.php");
session_start();

date_default_timezone_set('America/Lima');
if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    switch ($_POST['Evento']) {
        case 'RegistrarSolicitudExterna':
            $params = array(
                $_POST['nroSolitud'],
                $_POST['IdTipoServicio'],
                $_POST["idEmpresaCustodia"],
                $_POST["observacion"],
                isset($_POST['DataDetalle']) ? json_encode($_POST['DataDetalle']) : '',
                $_SESSION['IdSesion']
            );

            $sql = "{call UP_INSERTAR_SOLICITUD_EXTERNA  (?,?,?,?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'ObtenerDetalleSolicitudExterna':
            $params = array(
                $_POST['IdSolicitudExterna']
            );
            $sql = "{call UP_OBTENER_DETALLE_SOLICITUD_EXTERNA  (?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $data = [];
            while ($Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
                array_push($data,$Rs);
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
                $_POST['IdDetalleSolicitudExterna']
            );
            $sql = "{call UP_OBTENER_DOC_DIGITAL_DETALLE_SOLICITUD_EXTERNA  (?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $Rs = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
            $data['RutaDocDigital'] = $host.":".$port.$path.$Rs['Ruta'];

            echo json_encode($data);
            break;

        case 'ActualizarDatosDetalleSolicitudExterna':
            $params = array(
                $_POST['idDetalleSolicitudExterna'],
                isset($_POST['documentoDigital']) ? json_encode($_POST['documentoDigital']) : '',
                $_SESSION['IdSesion']
            );

            $sql = "{call UP_ACTUALIZAR_DATOS_DETALLE_SOLICITUD_EXTERNA  (?,?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'CambiarListo':
            $params = array(
                $_POST['IdDetalleSolicitudExterna'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_CAMBIAR_SOLICITUD_EXTERNA_DETALLE_LISTO  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'AtenderSolicitudExterna':
            $params = array(
                $_POST['IdSolicitudExterna'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_ATENDER_SOLICITUD_EXTERNA  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

        case 'RegistrarDevolucionItems':
            $params = array(
                $_POST['IdSolicitudExterna'],
                $_SESSION['IdSesion']
            );
            $sql = "{call UP_ATENDER_SOLICITUD_EXTERNA  (?,?) }";
            $rs = sqlsrv_query($cnx, $sql, $params);
            if($rs === false) {
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            break;

    }
}else{
    header("Location: ../../index-b.php?alter=5");
}

?>