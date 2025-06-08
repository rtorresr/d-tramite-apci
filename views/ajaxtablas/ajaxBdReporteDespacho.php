<?php
include_once "../../conexion/conexion.php";
session_start();

$params = [
    $_POST["cAsunto"],
    $_POST["txtCUD"],
    $_POST["cCodTipoDoc"],
    $_POST["TipoEnvio"],
    $_POST["EstadoDespacho"],
    $_POST["txtFecIni"],
    $_POST["txtFecFin"],
    $_SESSION['IdSesion'],
    $_POST["start"],
    $_POST["length"]
];

$sql = "{call UP_REPORTE_DESPACHOS (?,?,?,?,?,?,?,?,?,?)}";

$rs = sqlsrv_query($cnx,$sql,$params);

if($rs === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();

$contador = 0;
while($Rs=sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC)){
    $subdata=array();
    $subdata['rowId']= $contador;
    $subdata['IdTramite']=$Rs['IdTramite'];
    $subdata['Cud']=$Rs['Cud'];
    $subdata['TipoDocumento']=$Rs['TipoDocumento'];
    $subdata['NroDoc']=$Rs['NroDoc'];
    $subdata['Documento'] = $Rs['TipoDocumento'].' '.$Rs['NroDoc'];
    $subdata['Asunto']=$Rs['Asunto'];
    $subdata['TipoEnvio']=$Rs['TipoEnvio'];
    $subdata['Observacion']=$Rs['Observacion'];
    $subdata['EstadoDespacho']=$Rs['EstadoDespacho'];
    $subdata['nDocAdjuntos']=$Rs['nDocAdjuntos'];
    $subdata['FecRegistro']=$Rs['FecRegistro'] != null ? $Rs['FecRegistro']->format( 'd-m-Y H:i:s') : '';
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