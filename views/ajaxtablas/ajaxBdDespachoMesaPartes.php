<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_POST['estado']
];

$sqlBdDespacho = "{call UP_LISTAR_DESPACHO (?)}";

$rsBdDespacho = sqlsrv_query($cnx,$sqlBdDespacho,$params);

if($rsBdDespacho === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rsBdDespacho, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['IdDespachoDetalle']= $Rs['IdDespachoDetalle'];
    $subdata['IdDespachoOrden']= $Rs['IdDespachoOrden'];
    /*$subdata['NroOrden']= $Rs['NroOrden'];

    $subdata['IdTipoMensajeria']= $Rs['IdTipoMensajeria'];
    $subdata['DescTipoMensajeria']= $Rs['DescTipoMensajeria'];*/

    $subdata['IdMovimiento']=$Rs['IdMovimiento'];
    /*$subdata['IdDestinatario']= $Rs['IdDestinatario'];*/
    $subdata['nombreDestinatario']= $Rs['NombreDestinatario'];
    //$subdata['IdTipoEnvio']= $Rs['IdTipoEnvio'];

    $subdata['tipoMensajeria'] = $Rs['DescTipoMensajeria'];
    //$subdata['entrega'] = $Rs['NroOrden'].' | '.$Rs['DescTipoMensajeria'];
    $subdata['docEntrega'] = $Rs['DocEntrega'];
    $subdata['ordenEntrega'] = $Rs['NroOrden'].' - '.$Rs['NroItemOrden'];
    $subdata['fecEntrega']= $Rs['FecEntrega'] != null ? $Rs['FecEntrega']->format( 'Y-m-d H:i:s') : '';

    $subdata['direccion']= $Rs['Direccion'];
    /*$subdata['IdDepartamento']= $Rs['IdDepartamento'];
    $subdata['DescDepartamento']=$Rs['DescDepartamento'];
    $subdata['IdProvincia']= $Rs['IdProvincia'];
    $subdata['DescProvincia']= $Rs['DescProvincia'];
    $subdata['IdDistrito']= $Rs['IdDistrito'];
    $subdata['DescDistrito']= $Rs['DescDistrito'];*/

    //$subdata['direccion']= $Rs['Direccion'].' | '.$Rs['DescDepartamento'].', '.$Rs['DescProvincia'].', '.$Rs['DescDistrito'];
    $subdata['ubigeo']= $Rs['DescDepartamento'].', '.$Rs['DescProvincia'].', '.$Rs['DescDistrito'];

    $subdata['IdZonaEntrega']= $Rs['IdZonaEntrega'];
    $subdata['zonaEntrega'] = $Rs['NomZonaEntrega'];
    //$subdata['FecVencimiento']=$Rs['FecVencimiento'];

    $subdata['plazo']=$Rs['FecVencimiento'] != null ? $Rs['FecVencimiento']->format( 'Y-m-d H:i:s') : '';

    //$subdata['NroGuiaDevolucion']= $Rs['NroGuiaDevolucion'];
    //$subdata['FecDevolucion']= $Rs['FecDevolucion'];
    $subdata['FlgReenvio']= $Rs['FlgReenvio'];
    /*$subdata['IdEstadoDespacho']= $Rs['IdEstadoDespacho'];
    $subdata['DescEstadoDespacho']= $Rs['DescEstadoDespacho'];*/

    $subdata['idEstado']= $Rs['IdEstadoDespacho'];
    $subdata['estado']= $Rs['DescEstadoDespacho'].' | '.$Rs['DescTipoEnvio'];

    $subdata['FecRegistro']=$Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'Y-m-d H:i:s') : '';

    /*$subdata['TipoDocumento']= $Rs['TipoDocumento'];
    $subdata['NroDocumento']= $Rs['NroDocumento'];*/
    $subdata['cud']= $Rs['Cud'];

    $subdata['documento']= $Rs['TipoDocumento'].' '.$Rs['NroDocumento'];
    $subdata['asunto']=$Rs['asunto'];
    $subdata['adjuntos']=$Rs['nDocAdjuntos'];

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