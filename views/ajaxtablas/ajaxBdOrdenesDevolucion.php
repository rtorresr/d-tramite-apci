<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_POST['Finalizado']
];

$sqlBdDespacho = "{call UP_LISTAR_DESPACHO_DEVOLUCION (?)}";

$rsBdDespacho = sqlsrv_query($cnx,$sqlBdDespacho,$params);

if($rsBdDespacho === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rsBdDespacho, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['idDespachoDevolucion']= $Rs['IdDespachoDevolucion'];
    $subdata['nroDocDevolucion']= $Rs['NroDocDevolucion'];
    $subdata['empresaResponsable']=$Rs['EmpresaResponsable'];
    $subdata['trabajadorResponsable']= $Rs['TrabajadorResponsable'];
    $subdata['trabajadorValidador'] = $Rs['TrabajadorValidador'];
    $subdata['fecRegistro']= $Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'Y-m-d H:i:s') : '';


    $data[]=$subdata;
    $contador++;
}

$VO_TOTREG = 0;
while($res = sqlsrv_next_result($rsBdDespacho)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rsBdDespacho, SQLSRV_FETCH_ASSOC)){
            $VO_TOTREG = $row['VO_TOTAL_REGISTROS'];
        }
    } elseif ( is_null($res)) {
        echo "No se obtener datos!";
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