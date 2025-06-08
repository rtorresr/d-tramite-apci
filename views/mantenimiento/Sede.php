<?php
require '../../vendor/autoload.php';

include_once("../../conexion/conexion.php");
session_start();

switch ($_POST['Evento']){
    case 'AgregarSede':
        $parametros = [
            $_POST['idEntidad'],
            $_POST['Datos']['paisSede'],
            $_POST['Datos']['direccionSede'],
            $_POST['Datos']['departamentoSede']??NULL,
            $_POST['Datos']['provinciaSede']??NULL,
            $_POST['Datos']['distritoSede']??NULL,
            $_SESSION["IdSesion"]
        ];
        
        $sql = "{call UP_AGREGAR_SEDE (?,?,?,?,?,?,?)}";        

        $rs = sqlsrv_query($cnx,$sql,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;

    case 'ObternerDatos':
        $parametros = array(
            $_POST["idSede"]
        );

        $sql = "{call UP_OBTENER_DATOS_SEDE (?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($rs);

        echo json_encode($Rs);
        break;

    case 'ObternerSedesEntidad':
        $parametros = array(
            $_POST["idEntidad"]
        );

        $sql = "{call UP_OBTENER_SEDES_ENTIDAD (?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = [];
        while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
            array_push($data,$Rs);
        }        

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;

    case 'RelacionarSedes':

        $sedes = [];
        if(isset($_POST['DataSedeRelacion'])){
            foreach ($_POST['DataSedeRelacion'] as $key => $value) {
                $sedes[$key]['idSede'] = $value;
            }
        }
        $parametros = array(
            $_POST["idEntidad"],
            json_encode($sedes),
            $_SESSION['IdSesion']
        );

        $sql = "{call UP_ACTUALIZAR_SEDES_ENTIDAD (?,?,?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }       

        sqlsrv_free_stmt($rs);
        break;

    case 'ObternerSedesDependencia':
        $parametros = array(
            $_POST["idEntidad"]
        );

        $sql = "{call UP_OBTENER_SEDES_DEPENDENCIA (?)}";
        
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = [];
        while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
            array_push($data,$Rs);
        }        

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;

    case 'EditarSede':
        $parametros = [
            $_POST['Datos']['idSede'],
            $_POST['Datos']['paisSede'],
            $_POST['Datos']['direccionSede'],
            $_POST['Datos']['departamentoSede']??NULL,
            $_POST['Datos']['provinciaSede']??NULL,
            $_POST['Datos']['distritoSede']??NULL,
            $_SESSION["IdSesion"]
        ];
        
        $sql = "{call UP_EDITAR_SEDE (?,?,?,?,?,?,?)}";        

        $rs = sqlsrv_query($cnx,$sql,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $data = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

        sqlsrv_free_stmt($rs);

        echo json_encode($data);
        break;
    
    case 'EliminarSede':
        $parametros = array(
            $_POST["IdSede"],
            $_SESSION["IdSesion"]
        );
    
        $sql = "{call ELIMINAR_SEDE (?,?)}";
            
        $rs = sqlsrv_query($cnx, $sql, $parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;
}