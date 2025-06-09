<?php
session_start();
include_once("../conexion/conexion.php");
    
switch ($_POST['opcion']){
    case 1: // derivar movimiento
        /*$params = array(
            $_SESSION['CODIGO_TRABAJADOR'],
            $_SESSION['iCodOficinaLogin'],
            $_POST['iCodMovimiento'][0],
            json_encode($_POST['datos'])
        );

        $sqlDer = "{call SP_DERIVACION_MULTIPLE (?,?,?,?) }";
        $rs = sqlsrv_query($cnx, $sqlDer, $params);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        break;*/
        
        if(is_array($_POST['iCodMovimiento'])):
            foreach($_POST['iCodMovimiento'] as $value):
                $params = array(
                    $_SESSION['CODIGO_TRABAJADOR'],
                    $_SESSION['iCodOficinaLogin'],
                    $value,
                    json_encode($_POST['datos'])
                );
                $sqlDer = "{call SP_DERIVACION_MULTIPLE (?,?,?,?) }";
                $rs = sqlsrv_query($cnx, $sqlDer, $params);
                if($rs === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
    
              endforeach;
              endif;
            
            break;


    case 3: // archivar movimiento
        try{
            for ($h=0;$h<count($_POST['iCodMovimiento']);$h++){
                $params = array(
                    $_SESSION['CODIGO_TRABAJADOR'],
                    $_SESSION['iCodOficinaLogin'],
                    $_POST['iCodMovimiento'][$h],
                    $_POST['cObservacionesFinalizar'],
                    isset($_POST['anexos']) ? $_POST['anexos'] : null
                );
                $sqlArchivar = "{call SP_ARCHIVAR_DOCUMENTO (?,?,?,?,?) }";
                $rs = sqlsrv_query($cnx, $sqlArchivar, $params);
                if($rs === false) {
                    http_response_code(500);
                    die(print_r(sqlsrv_errors()));
                }
            }
            echo json_encode(1);
    } catch (Exception $e) {
        echo json_encode($e);
    }
        break;

    
}
?>