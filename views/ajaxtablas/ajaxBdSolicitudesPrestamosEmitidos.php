<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_POST['IdEstadoSolicitudPrestamo']
    ,$_SESSION['IdSesion']
];

$sql = "{call UP_SOLICITUDES_PRESTAMOS_EMITIDOS (?,?)}";

$rs = sqlsrv_query($cnx,$sql,$params);

if($rs === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['IdSolicitudPrestamo']=$Rs['IdSolicitudPrestamo'];
    $subdata['IdOficinaSolicitante']=$Rs['IdOficinaSolicitante'];
    $subdata['oficinaOrigen']=$Rs['oficinaOrigen'];
    $subdata['IdTrabajadorSolicitante']=$Rs['IdTrabajadorSolicitante'];
    $subdata['trabajadorOrigen']=$Rs['trabajadorOrigen'];
    $subdata['IdOficinaRequerida']=$Rs['IdOficinaRequerida'];
    $subdata['oficinaDestino']=$Rs['oficinaDestino'];
    $subdata['documento']=$Rs['documento'];
    $subdata['IdEstadoSolicitudPrestamo'] = $Rs['IdEstadoSolicitudPrestamo'];
    $subdata['estado'] = $Rs['estado'];
    $subdata['fechaEnvio'] = $Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'Y-m-d H:i:s') : '';
    $subdata['fechaNotificacion'] = $Rs['FecNotificacionEntrega'] != null ? $Rs['FecNotificacionEntrega']->format( 'Y-m-d H:i:s') : '';
    $subdata['cantidadNotificaciones'] = $Rs['CantidadNotificaciones'];
    $subdata['ultimaFecNotificacion'] = $Rs['UltimaFecNotificacion'] != null ? $Rs['UltimaFecNotificacion']->format( 'Y-m-d H:i:s') : '';
    $subdata['fechaRecepcion'] = $Rs['FecEntrega'] != null ? $Rs['FecEntrega']->format( 'Y-m-d H:i:s') : '';
    $subdata['cantidadAmpliaciones'] = $Rs['CantAmpliacionesPlazo'];
    $subdata['fechaPlazo'] = $Rs['FecPlazoDevolucion'] != null ? $Rs['FecPlazoDevolucion']->format( 'Y-m-d H:i:s') : '';
    $subdata['flgRequiereAmpliacion'] = $Rs['FlgRequiereAmpliacion'];
    $subdata['flgFueraDePlazo'] = $Rs['FlgFueraDePlazo'];
    $subdata['fechaDevolucion'] = $Rs['FecDevolucion'] != null ? $Rs['FecDevolucion']->format( 'Y-m-d H:i:s') : '';
    $subdata['observacion'] = $Rs['Observacion'] != null ? $Rs['Observacion'] : "" ;
    $subdata['fecPlazoAtencion'] = $Rs['FecPlazoAtencion'] != null ? $Rs['FecPlazoAtencion']->format( 'Y-m-d H:i:s') : '';
    
    $data[]=$subdata;
    $contador++;
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