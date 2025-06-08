<?php
include_once "../../conexion/conexion.php";
session_start();
$fechainiano = new DateTime('first day of january '. date('Y'));
$fechafinano = new DateTime('last day of december '. date('Y'));

$cAsunto = $_POST['cAsunto']??'';
$cud = $_POST['nCud'] ?? '';
$tipoDoc = $_POST['tipoDoc']??'NULL';
$nroDoc = $_POST['nroDoc']??'';
//$codRemitente = $_POST['codRemitente']??'NULL';
$nomRemitente = $_POST['nomRemitente'] ?? '';
$oficinaOrigen = $_POST['iCodOficinaOrigen']??'NULL';

$oficinaDestino = $_POST['oficinaDestino']??$_SESSION['iCodOficinaLogin'];

$cboTramite =$_POST['cboTramite']??'NULL';
$nEstadoMovimiento = $_POST['nEstadoMovimiento'] ?? 'NULL';

$fechaini = (isset($_POST['fFecInicio']) && $_POST['fFecInicio'] !== '')? date('Ymd',strtotime($_POST['fFecInicio'])) : '';
$fechafin = (isset($_POST['fFecFin']) && $_POST['fFecFin'] !== '') ? date('Ymd',strtotime($_POST['fFecFin'])) : '';

$ordenDireccion = $_POST['order'][0]['dir'];
$ordenColummna = $_POST['columns'][$_POST['order'][0]['column']]['data'];

$sqlConsulta = "execute SP_CONSULTA_GENERAL '".$cboTramite."','".$cud."','".$cAsunto."','".$nomRemitente."','".$oficinaOrigen."',".$oficinaDestino.",'"
                                            .$tipoDoc."','".$nroDoc."','".$fechaini."','".$fechafin."','".$nEstadoMovimiento."','".$ordenDireccion."','".$ordenColummna."',
                                            ".$_POST["start"].",".$_POST["length"];

$rsConsulta = sqlsrv_query($cnx,$sqlConsulta);

if($rsConsulta === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();
while($Rs=sqlsrv_fetch_array($rsConsulta)){
    $subdata=array();
    $subdata['iCodTrabajadorFirmante']=$Rs['iCodTrabajadorFirmante'];
    $subdata['iCodOficinaFirmante']=$Rs['iCodOficinaFirmante'];
    $subdata['iCodMovimiento']=$Rs['iCodMovimiento'];
    $subdata['nCud']=$Rs['nCud'];
    $subdata['cdesctipodoc']=$Rs['cdesctipodoc'].' '.$Rs['cCodificacion'];
    $subdata['cAsunto']=$Rs['cAsunto'];
    $subdata['remitente']=$Rs['remitente'];
    $subdata['origen']=$Rs['cOficinaOrigen'].' | '.$Rs['cTrabajadorRegistro'];
    $subdata['destino']=$Rs['cOficinaDestino'].' | '.$Rs['cTrabajadorDerivar'];
    $subdata['nomEstado']=$Rs['nomEstado'];
    $subdata['fFecMovimiento']=$Rs['fFecMovimiento'] != null ? $Rs['fFecMovimiento']->format( 'd-m-Y H:i:s') : '';
    $subdata['flgEncriptado']=$Rs['flgEncriptado'];  
    $subdata['codigo']=$Rs['iCodTramite']??$Rs['iCodProyecto'];  
    $subdata['ingreso']=$Rs['origen']??$Rs['origen'];  
    $data[]=$subdata;
}
$VO_TOTREG=0;
while($res = sqlsrv_next_result($rsConsulta)){
    if( $res ) {
        while( $row = sqlsrv_fetch_array( $rsConsulta, SQLSRV_FETCH_ASSOC)){
            $VO_TOTREG = $row['VO_TOTREG'];
        }
    } elseif( is_null($res)) {
        echo "No se Pudo Registrar el Proyecto";
        return;
    } else {
        die(print_r(sqlsrv_errors(), true));
    }                    
}     

$recordsTotal=$VO_TOTREG;
$recordsFiltered=$VO_TOTREG;
$json_data = array(
    "draw"            => (int)($_POST['draw']??0),
    "recordsTotal"    => (int) $recordsTotal ,
    "recordsFiltered" => (int) $recordsFiltered ,
    "data"            => $data    
);

echo json_encode($json_data);
