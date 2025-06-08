<?php
require '../../vendor/autoload.php';

include_once("../../conexion/conexion.php");
session_start();

switch ($_POST['Evento']){
    case 'Buscar':
        $parametros = array(
            $_POST['page']??25,
            $_POST['search']??''
        );

        $sql = "{call UP_BUSCAR_DOCUMENTO_GENERADO_SELECT_TWO (?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = [];
        while ($Rs = sqlsrv_fetch_array($rs)){
            array_push($data, ["id" => trim($Rs['id']), "text" => trim($Rs["text"])]);
        }

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
    break;

    case 'Obtener':
        $parametros = array(
            $_POST['IdTramite']
        );

        $sql = "{call UP_OBTERNER_DATOS_DOCUMENTO (?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = sqlsrv_fetch_array($rs, 2);

        echo json_encode($data);
        break;

    case 'Anular':
        $parametros = array(
            $_POST['Id'],
            $_POST['Mensaje'],
            $_SESSION['IdSesion'],
            $_SESSION['CODIGO_TRABAJADOR'],
            $_SESSION['iCodPerfilLogin'],
            $_SESSION['iCodOficinaLogin']  
        );

        $sql = "{call UP_ANULAR_DOCUMENTO_GENERADO (?,?,?,?,?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;

    case 'Desanular':
        $parametros = array(
            $_POST['Id'],
            $_POST['Mensaje'],
            $_SESSION['IdSesion']
        );
    
        $sql = "{call UP_DESANULAR_DOCUMENTO_GENERADO (?,?,?)}";
    
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;

    case 'Retrotraer':
        $parametros = array(
            $_POST['Id'],
            $_SESSION['IdSesion']
        );
        
        $sql = "{call UP_RETROTRAER_PROYECTADO (?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;

    default:
        echo 'Sin acción';
        break;
}


