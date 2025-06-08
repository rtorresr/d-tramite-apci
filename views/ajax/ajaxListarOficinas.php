<?php
include_once("../../conexion/conexion.php");
session_start();

switch ($_POST['Evento']) {
    case 'ListarOficinasEspecialistasDestino':
        $params = array(
            $_SESSION['IdSesion'],
            $_SESSION['flgEspecialistas']
        );
        $sql = "{ call UP_LISTAR_OFICINAS_ESPECIALISTAS_DESTINO (?,?) }";
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

    case 'ListarOficinasDocumento':
        $params = array(
            $_SESSION['IdSesion'],
            $_POST['IdTipoDocumento']
        );
        $sql = "{ call UP_LISTAR_OFICINAS_POR_DOCUMENTO (?,?) }";
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

    case 'ListarOficinaResponsableFirma':
        $params = array(
            $_SESSION['IdSesion'],
            $_POST['IdTipoDocumento']
        );
        $sql = "{ call UP_LISTAR_OFICINA_RESPONSABLE_FIRMA (?,?) }";
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

    default:
        echo "No se encontro";
        break;
}