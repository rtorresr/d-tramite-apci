<?php
include_once "../../conexion/conexion.php";
session_start();

$sqlBdRegularizar = "{call SP_BANDEJA_MESA_PARTES_VIRTUAL }";

$rsBdRegularizar = sqlsrv_query($cnx,$sqlBdRegularizar);

if($rsBdRegularizar === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data=array();
$contador = 0;
while($Rs=sqlsrv_fetch_array($rsBdRegularizar, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata = $Rs;
    $subdata['rowId']=$contador;
    $subdata['FecRegistro']=$Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'Y-m-d H:i:s') : '';
    $data[]=$subdata;
    $contador++;
}

$VO_TOTREG = 0;
while($res = sqlsrv_next_result($rsBdRegularizar)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rsBdRegularizar, SQLSRV_FETCH_ASSOC)){
            $VO_TOTREG = $row['VO_TOTREG'];
        }
    } elseif ( is_null($res)) {
        echo "No se pudo obtener datos!";
        return;
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
}

$recordsTotal = $VO_TOTREG;
$recordsFiltered = $VO_TOTREG;
$json_data = array(
    "draw"            => (int)($_POST['draw']??0),
    "recordsTotal"    => (int) $recordsTotal ,
    "recordsFiltered" => (int) $recordsFiltered ,
    "data"            => $data
);

echo json_encode($json_data);