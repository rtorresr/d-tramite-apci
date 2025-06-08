<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_POST["cAsunto"],
    $_POST["txtCUD"],
    $_POST["idOficinaOrigen"],
    $_POST["txtDoc"],
    $_POST["idTipoDoc"],
    $_POST["txtFecIni"],
    $_POST["txtFecFin"],
    $_SESSION['IdSesion'],
    $_POST["start"],
    $_POST["length"]
];

$sql = "{call UP_CONSULTA_RECIBIDOS (?,?,?,?,?,?,?,?,?,?)}";

$rs = sqlsrv_query($cnx,$sql,$params);

if($rs === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['ICODTRAMITE']=$Rs['ICODTRAMITE'];
    $subdata['CUD']=$Rs['CUD'];
    $subdata['DOCUMENTO']=$Rs['DOCUMENTO'];    
    $subdata['ASUNTO']=$Rs['ASUNTO'];
    $subdata['FEC_ENVIO']=$Rs['FEC_ENVIO'] != null ? $Rs['FEC_ENVIO']->format( 'd-m-Y H:i:s') : '';
    $subdata['ORIGEN']=$Rs['ORIGEN'];
    $subdata['ESTADO']=$Rs['ESTADO'];
    $subdata['FEC_ATENCION']=$Rs['FEC_ATENCION'] != null ? $Rs['FEC_ATENCION']->format( 'd-m-Y H:i:s') : '';
    $data[]=$subdata;
    $contador ++;
}

$VO_TOTREG = 0;
while($res = sqlsrv_next_result($rs)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC)){
            $VO_TOTREG = $row['VO_TOTREG'];
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