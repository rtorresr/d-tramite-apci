<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_SESSION['CODIGO_TRABAJADOR'],
    $_SESSION['iCodOficinaLogin'],
    $_SESSION['iCodPerfilLogin']
];

$sqlBdRegularizar = "{call SP_BANDEJA_REGULARIZAR (?,?,?)}";

$rsBdRegularizar = sqlsrv_query($cnx,$sqlBdRegularizar,$params);

if($rsBdRegularizar === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data=array();
$contador = 0;
while($Rs=sqlsrv_fetch_array($rsBdRegularizar, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']=$contador;
    $subdata['codTramite']=$Rs['iCodTramite'];
    $subdata['cud']=$Rs['nCud'];
    $subdata['documento']=$Rs['documento'];
    $subdata['esTupa']=$Rs['esTupa'];
    $subdata['codEsTupa']=$Rs['nFlgClaseDoc'];
    $subdata['codTupa']=$Rs['iCodTupa'];
    $subdata['fechaRegistro']=$Rs['fFecRegistro'] != null ? $Rs['fFecRegistro']->format( 'Y-m-d H:i:s') : '';
    $subdata['tiempoPlazo']=$Rs['plazo'];
    $subdata['fechaPlazo']=$Rs['fFecPlazo'] != null ? $Rs['fFecPlazo']->format( 'Y-m-d H:i:s') : '';
    $subdata['fechaDocumento']=$Rs['fFecDocumento'] != null ? $Rs['fFecDocumento']->format( 'Y-m-d H:i:s') : '';
    $subdata['trabajadorRegistro']=$Rs['trabajadorRegistro'];
    $subdata['remitente']=$Rs['remitente'];
    $subdata['tienePdf']=$Rs['documentoPdf'];
    $subdata['requisitosFaltantes']=$Rs['requisitosFaltantes'];
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