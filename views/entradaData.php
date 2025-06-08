<?php
session_start();
include_once("../conexion/conexion.php");

switch ($_POST['opcion']){
    case 2:// Rechaza documentos
        try {
            for ($h = 0; $h < count($_POST['iCodMovimiento']); $h++) {
                $params = array(
                    $_POST['iCodMovimiento'][$h],
                    $_POST['motRechazo'],
                    $_SESSION['CODIGO_TRABAJADOR'],
                    $_SESSION['iCodOficinaLogin']
                );
                $sqlEnvioRechazo = "{call SP_RECHAZO_DOCUMENTO (?,?,?,?) }";
                $rs = sqlsrv_query($cnx, $sqlEnvioRechazo, $params);
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