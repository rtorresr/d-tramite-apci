<?php
include_once("../../conexion/conexion.php");
session_start();

switch ($_POST['Evento']) {
    case 'ListarTrabajadoresPorOficina':
        $params = array(
            $_POST['idOficina']
        );
        $sql = "{ call UP_LISTAR_TRABAJADORES_POR_OFICINA (?) }";
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

        case 'ListarTrabajadoresPorOficinaCG':
            $params = array(
                $_POST['idOficina'],
                $_POST['query']['term']
            );
            $sql = "{ call UP_LISTAR_TRABAJADORES_POR_OFICINA_CG (?,?) }";
            
            $rs = sqlsrv_query($cnx, $sql, $params);

            if ($rs === false){
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $datos = [];
            while ($Rs = sqlsrv_fetch_array($rs)){
                //$con = "<option value='" . $Rs['idTrabajador'] . "' >" . trim($RsOfi['nomTrabajador']) . "</option>";
                    array_push($datos, ["id" => trim($Rs['idTrabajador']), "text" => trim($Rs['nomTrabajador'])]);
            }
            echo json_encode($datos);
        break;  
        
        case 'ListarJefePorOficinaCG':
            $params = array(
                $_POST['idOficina'],
                $_POST['query']['term']??''
            );
            $sql = "{ call UP_LISTAR_TRABAJADORES_POR_OFICINA_CG (?,?) }";
            
            $rs = sqlsrv_query($cnx, $sql, $params);

            if ($rs === false){
                http_response_code(500);
                die(print_r(sqlsrv_errors()));
            }
            $datos = [];
            while ($Rs = sqlsrv_fetch_array($rs)){  
                if($Rs['iCodPerfil']==3){
                //$con = "<option value='" . $Rs['idTrabajador'] . "' >" . trim($RsOfi['nomTrabajador']) . "</option>";
                    array_push($datos, ["id" => trim($Rs['idTrabajador']), "text" => trim($Rs['nomTrabajador'])]);
                }
            }
            echo json_encode($datos);
        break; 

    default:
        echo "No se encontro";
        break;
}