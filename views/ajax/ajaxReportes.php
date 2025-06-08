<?php
include_once("../../conexion/conexion.php");
session_start();

if ($_POST['FecInicio'] !== ''){
    $fec_inicio = explode('-',$_POST['FecInicio']);
    $fecha_inicio = $fec_inicio[2].'-'.$fec_inicio[1].'-'.$fec_inicio[0];
} else {
    $fecha_inicio = $_POST['FecInicio'];
}

if ($_POST['FecFin'] !== ''){
    $fec_fin = explode('-',$_POST['FecFin']);
    $fecha_fin = $fec_fin[2].'-'.$fec_fin[1].'-'.$fec_fin[0];
} else {
    $fecha_fin = $_POST['FecFin'];
}

if (isset($_POST['TipoReporte']) && $_POST['TipoReporte'] = 'Resumen'){
    $params = array(
        $fecha_inicio
        ,$fecha_fin
        ,$_POST['nivelBusqueda']
        ,$_SESSION['IdSesion']
    );
    $sql = "{call UP_DATOS_REPORTE_DOS (?,?,?,?) }";
    $rs = sqlsrv_query($cnx, $sql, $params);
    if($rs === false) {
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }
    $data = [];
    while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
        array_push($data, $Rs);
    }
    echo json_encode($data);
} else{
    $params = array(
        $_SESSION['IdSesion']
    ,$_POST['tipo']
    );
    $sql = "{call UP_DATOS_REPORTE (?,?) }";
    $rs = sqlsrv_query($cnx, $sql, $params);
    if($rs === false) {
        http_response_code(500);
        die(print_r(sqlsrv_errors()));
    }
    $data = [];
    while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)){
        array_push($data, $Rs);
    }
    echo json_encode($data);
}

