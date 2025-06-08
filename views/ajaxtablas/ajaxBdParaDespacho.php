<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_SESSION['IdSesion']
];

$sqlBdParaDespacho = "{call UP_MOVIMIENTOS_PARA_DESPACHO (?)}";

$rsBdParaDespacho = sqlsrv_query($cnx,$sqlBdParaDespacho,$params);

if($rsBdParaDespacho === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rsBdParaDespacho, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['mov']=$Rs['IdMovimiento'];
    $subdata['cud']=$Rs['nCud'];
    $subdata['codigo']=$Rs['CodigoDoc'];
    $subdata['nomTipDocumento']=$Rs['nomTipDocumento'];
    $subdata['documento']=$Rs['TipoDocumento'];
    $subdata['asunto']=$Rs['cAsunto'];
    $subdata['fechaEnvio']=$Rs['FecMovimiento'] != null ? $Rs['FecMovimiento']->format( 'Y-m-d H:i:s') : '';
    $subdata['instruccion']=$Rs['Observacion'] != null ? $Rs['Observacion'] : '';
    $subdata['copia']=$Rs['Copia'] != null ? $Rs['Copia'] : 0;
    $subdata['adjuntos']=$Rs['nDocAdjuntos'];
    $subdata['codIndicacion']=$Rs['iCodIndicacionDerivar'] != null ? $Rs['iCodIndicacionDerivar'] : 1;
    $subdata['nomIndicacion']=$Rs['nomIndicacion'] != null ? $Rs['nomIndicacion'] : '1. Atender';
    $subdata['prioridad']=$Rs['IdPrioridad'] != null ? $Rs['IdPrioridad'] : 'Media';
    $subdata['codDestino'] = $Rs['CodDestino'];
    $subdata['estado'] = $Rs['DescEstado'];
    $subdata['idEstado'] = $Rs['IdEstadoMovimiento'];
    $data[]=$subdata;
    $contador++;
}

$VO_TOTREG = 0;
while($res = sqlsrv_next_result($rsBdParaDespacho)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rsBdParaDespacho, SQLSRV_FETCH_ASSOC)){
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