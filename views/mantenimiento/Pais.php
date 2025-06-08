<?php
require '../../vendor/autoload.php';

include_once("../../conexion/conexion.php");
session_start();

switch ($_POST['Evento']){
    case 'Listar':

        $sql = "{call UP_LISTAR_PAIS}";

        $rs = sqlsrv_query($cnx, $sql);
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
}