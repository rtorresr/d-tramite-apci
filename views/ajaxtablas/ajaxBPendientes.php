<?php
include_once "../../conexion/conexion.php";
session_start();
$params = [
    $_SESSION['CODIGO_TRABAJADOR'],
    $_SESSION['iCodOficinaLogin'],
    $_SESSION['iCodPerfilLogin'],
    $_POST['start'],
    $_POST['length'],
    $_POST['search']['value']
];

//$sqlBdRecibidos = "{call SP_BANDEJA_RECIBIDOS (?,?,?)}";
$sqlBdRecibidos = "{call SP_BANDEJA_RECIBIDOS_PAGINADO(?,?,?,?,?,?)}";


$rsBdRecibidos = sqlsrv_query($cnx,$sqlBdRecibidos,$params);

if($rsBdRecibidos === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rsBdRecibidos, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    //$subdata['rowId']= $contador;
    $subdata['rowId'] = $Rs['iCodTramite'];
    $subdata['codigo'] = $Rs['iCodTramite'];
    $subdata['mov']=$Rs['iCodMovimiento'];
    $subdata['cud']=$Rs['nCud'];
    $subdata['documento']=$Rs['TipoDocumento'];
    $subdata['asunto']=$Rs['cAsunto'];
    //$subdata['remitente']=$Rs['remitente'];
    $subdata['entidadExterna']=$Rs['entidadExterna'];
    $subdata['oficinaOrigen']=$Rs['oficinaOrigen'];
    $subdata['fechaEnvio']=$Rs['fFecMovimiento'] != null ? $Rs['fFecMovimiento']->format( 'Y-m-d H:i:s') : '';
    $subdata['fechaPlazo']=$Rs['FechaPlazoFinal'] != null ? $Rs['FechaPlazoFinal']->format( 'Y-m-d H:i:s') : '';
    $subdata['instruccion']=$Rs['cObservacionesDerivar'] != null ? $Rs['cObservacionesDerivar'] : '';
    $subdata['copia']=$Rs['cFlgCopia'] != null ? $Rs['cFlgCopia'] : 0;
    $subdata['adjuntos']=$Rs['nDocAdjuntos'];
    $subdata['proyectos']=$Rs['nProAdjuntos'];
    $subdata['codIndicacion']=$Rs['iCodIndicacionDerivar'] != null ? $Rs['iCodIndicacionDerivar'] : 1;
    $subdata['nomIndicacion']=$Rs['nomIndicacion'] != null ? $Rs['nomIndicacion'] : '1. Atender';
    $subdata['prioridad']=$Rs['cPrioridadDerivar'] != null ? $Rs['cPrioridadDerivar'] : 'Media';
    $subdata['flgEncriptado']=$Rs['flgEncriptado'];
    $subdata['iCodTrabajadorFirmante']=$Rs['iCodTrabajadorFirmante'];
    $subdata['iCodOficinaFirmante']=$Rs['iCodOficinaFirmante'];
    $subdata['origen']=$Rs['origen'];
    $data[]=$subdata;
    $contador ++;
}

$VO_TOTREG = 0;
while($res = sqlsrv_next_result($rsBdRecibidos)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rsBdRecibidos, SQLSRV_FETCH_ASSOC)){
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