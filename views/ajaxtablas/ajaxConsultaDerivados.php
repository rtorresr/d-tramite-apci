<?php
include_once "../../conexion/conexion.php";
session_start();
$fechainiano = new DateTime('first day of january '. date('Y'));
$fechafinano = new DateTime('last day of december '. date('Y'));


$cboTramite =$_POST['cboTramite']??'';
$cud = $_POST['cud'] ?? '';
$tipoDoc = $_POST['tipoDoc']??0;
$cAsunto = $_POST['cAsunto']??'';
//$remitente = $_POST['remitente']??'';
$nroDoc = $_POST['nroDoc']??'';
//$oficinaOrigen = $_POST['oficinaOrigen']??$_SESSION['iCodOficinaLogin'];
$oficinaDestino = $_POST['iCodOficinaDerivar']??0;

$nEstadoMovimiento = $_POST['nEstadoMovimiento'] ?? '';
//$iCodOficinaOrigen = (isset($_POST['iCodOficinaOrigen']) and $_POST['iCodOficinaOrigen'] !== '') ? $_POST['iCodOficinaOrigen'] : $_SESSION['iCodOficinaLogin'];

$fechaini = $_POST['fFecInicio'] != '' ? date("Y-m-d", strtotime($_POST['fFecInicio'])) : '';
$fechafin = $_POST['fFecFin'] != '' ? date("Y-m-d", strtotime($_POST['fFecFin'])) : '';

if (isset($_POST['order'][0])){
    $ordenDireccion = $_POST['order'][0]['dir']??'';
    $ordenColummna = $_POST['columns'][$_POST['order'][0]['column']]['data']??'';
}else{
    $ordenDireccion = NULL;
    $ordenColummna = NULL;
}

$paramentros = array(
    $cboTramite,
    $cud,
    $tipoDoc,
    $cAsunto,
    $nroDoc,
    $oficinaDestino,
    $nEstadoMovimiento,
    $fechaini,
    $fechafin,
    $ordenDireccion,
    $ordenColummna,
    $_POST["start"],
    $_POST["length"],
    $_SESSION['IdSesion']
);
/*$sqlConsulta = "execute SP_CONSULTA_GENERAL '".$cboTramite."','".$cud."','".$cAsunto."','".$remitente."',".$oficinaOrigen.",".$oficinaDestino.",'"
                                            .$tipoDoc."','".$nroDoc."','".$fechaini."','".$fechafin."','".$nEstadoMovimiento."','".$ordenDireccion."','".$ordenColummna."',".$_POST["start"].",".
                                            $_POST["length"];*/

$sqlConsulta = "{call UP_CONSULTA_DERIVADOS (?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";

$rsConsulta = sqlsrv_query($cnx, $sqlConsulta, $paramentros);
if($rsConsulta === false) {
    http_response_code(500);
    die(print_r(sqlsrv_errors()));
}

/*$rsConsulta = sqlsrv_query($cnx,$sqlConsulta);

if($rsConsulta === false) {
    die(print_r(sqlsrv_errors(), true));
}*/

$data = array();
$contador = 0;
while($Rs=sqlsrv_fetch_array($rsConsulta)){
    $subdata=array();
    $subdata['rowId'] = $contador;
    $subdata['iCodTrabajadorFirmante']=$Rs['iCodTrabajadorFirmante'];
    $subdata['iCodOficinaFirmante']=$Rs['iCodOficinaFirmante'];
    $subdata['iCodMovimiento']=$Rs['iCodMovimiento'];
    $subdata['nCud']=$Rs['nCud'];
    $subdata['cdesctipodoc']=$Rs['cdesctipodoc'].' '.$Rs['cCodificacion'];
    $subdata['cAsunto']=$Rs['cAsunto'];
    $subdata['remitente']=$Rs['remitente'];
    $subdata['origen']=$Rs['cOficinaOrigen'].' | '.$Rs['cTrabajadorRegistro'];
    $subdata['OficinaDestino'] = $Rs['cOficinaDestino'];
    $subdata['TrabajadorDestino'] = $Rs['cTrabajadorDerivar'];
    //$subdata['destino']=$Rs['cOficinaDestino'].' | '.$Rs['cTrabajadorDerivar'];
    $subdata['nomEstado']=$Rs['nomEstado'];
    $subdata['fFecMovimiento']=$Rs['fFecMovimiento'] != null ? $Rs['fFecMovimiento']->format( 'd-m-Y H:i:s') : '';
    $subdata['flgEncriptado']=$Rs['flgEncriptado'];
    $subdata['origen']=$Rs['origen'];
    $data[]=$subdata;
    $contador ++;
}
$VO_TOTREG=0;
while($res = sqlsrv_next_result($rsConsulta)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rsConsulta, SQLSRV_FETCH_ASSOC)){
            $VO_TOTREG=$row['VO_TOTREG'];
            //echo $VO_TOTREG;
        }
    } elseif( is_null($res)) {
        echo "No se Pudo Registrar el Proyecto";
        return;
    } else {
        die(print_r(sqlsrv_errors(), true));
    }                    
}     

$recordsTotal=$VO_TOTREG;//sqlsrv_num_rows($rsConsulta);
$recordsFiltered=$VO_TOTREG;//sqlsrv_num_rows($rsConsulta);
$json_data = array(
    "draw"            => (int)($_POST['draw']??0),
    "recordsTotal"    => (int) $recordsTotal ,
    "recordsFiltered" => (int) $recordsFiltered ,
    "data"            => $data    
);

echo json_encode($json_data);
