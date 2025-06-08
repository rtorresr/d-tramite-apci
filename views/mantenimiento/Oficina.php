<?php
require '../../vendor/autoload.php';

include_once("../../conexion/conexion.php");
session_start();

switch ($_POST['Evento']){
    case 'Listar':
        $parametros = array(
            $_POST['Sigla']??'',
            $_POST['Nombre']??'',
            $_POST['Estado']??1
        );

        $sql = "{call UP_LISTAR_OFICINAS_M (?,?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = array();
        $contador = 0;
        while($Rs=sqlsrv_fetch_array($rs)){
            $subdata=array();
            $subdata['rowId']=$contador;
            $subdata['idOficina']=$Rs['idOficina'];
            $subdata['nombre']=$Rs['nombre'];
            $subdata['siglas']=$Rs['siglas'];
            $subdata['oficinaPadre']=$Rs['siglasPadre'];
            if ($Rs['estado'] == 1){
                $subdata['estado'] = 'Activo';
            } else {
                $subdata['estado'] = 'Inactivo';
            }
            $data[]=$subdata;
            $contador ++;
        }

        $recordsTotal=count($data);
        $recordsFiltered=count($data);
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) $recordsTotal ,
            "recordsFiltered" => (int) $recordsFiltered ,
            "data"            => $data    
        );
        
        echo json_encode($json_data);
    break;

    case 'Eliminar':
        $parametros = array(
            $_POST['id']
        );

        $sql = "{call UP_ELIMINAR_OFICINAS (?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    break;

    case 'Registrar':
        $parametros = array(
            $_POST['siglas'],
            $_POST['nombre'],
            $_POST['oficinaPadre']
        );

        $sql = "{call UP_REGISTRAR_OFICINA (?,?,?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    break;

    case 'Obtener':
        $parametros = array(
            $_POST['id']
        );

        $sql = "{call UP_OBTENER_OFICINA (?)}";

        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $json_data = sqlsrv_fetch_array($rs);
        echo json_encode($json_data);
    break;

    case 'Editar':
        $parametros = array(
            $_POST['id'],
            $_POST['siglas'],
            $_POST['nombre'],
            $_POST['oficinaPadre']
        );

        $sql = "{call UP_EDITAR_OFICINA (?,?,?,?)}";

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


