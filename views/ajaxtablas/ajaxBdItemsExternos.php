<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_POST['Tipo']
];

$sql = "{call UP_ITEMS_EXTERNOS (?)}";

$rs = sqlsrv_query($cnx,$sql,$params);

if($rs === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['idDetalleSolicitudExterna']=$Rs['IdDetalleSolicitudExterna'];
    $subdata['idSolicitudExternaRecepcion']=$Rs['IdSolicitudExternaRecepcion'];
    $subdata['nroSolicitud']=$Rs['NroSolicitud'];
    $subdata['descripcion']=$Rs['Descripcion'];
    $subdata['codigoExterno']=$Rs['CodigoExterno'];
    $subdata['flgTieneDocDigital']=$Rs['FlgTieneDocDigital'];
    $subdata['flgDentroInstalacion']=$Rs['FlgDentroInstalacion'];
    $subdata['nomDentroIntalacion']=$Rs['NomDentroIntalacion'];
    $subdata['idEstado']=$Rs['IdEstado'];
    $subdata['nomIdEstado']=$Rs['NomIdEstado'];
    $subdata['fechaRegistro'] = $Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'Y-m-d H:i:s') : '';
    $subdata['fechaAtencion'] = $Rs['FecAtencion'] != null ? $Rs['FecAtencion']->format( 'Y-m-d H:i:s') : '';
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