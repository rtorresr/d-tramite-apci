<?php
include_once "../../conexion/conexion.php";
session_start();
$cboTramite =$_POST['cboTramite']??'';
$cud = $_POST['cud'] ?? '';
$tipoDoc = $_POST['tipoDoc']??'';
$cAsunto = $_POST['cAsunto']??'';
$trabajadorFinal = $_POST['trabajadorFinal']??'';
$remitente = $_POST['remitente']??'';
$nroDoc = $_POST['nroDoc']??'';
$oficinaOrigen = $_POST['oficinaOrigen']??$_SESSION['iCodOficinaLogin'];
$oficinaDestino = $_POST['oficinaDestino']??'NULL';
$nEstadoMovimiento = $_POST['nEstadoMovimiento'] ?? '';
$iCodOficinaOrigen = $_POST['iCodOficinaOrigen'] ?? '';
//$fechaIni = $_POST['fecIni']??20190101;
$fechaIni = (isset($_POST['fecIni']) && $_POST['fecIni'] !== '')? date('Ymd',strtotime($_POST['fecIni'])) : '';
//$fechaFin = $_POST['fecFin']??20191231;
$fechaFin = (isset($_POST['fecFin']) && $_POST['fecFin'] !== '')? date('Ymd',strtotime($_POST['fecFin'])) : '';
//echo $_POST["order"][0]."---";
//print_r($_POST["order"]);

$sqlConsulta = "execute SP_CONSULTA_DOCUMENTOS_ARCHIVADOS '".$cboTramite."','".$cud."','".$cAsunto."','".$trabajadorFinal."','".$remitente."',".$oficinaOrigen.",".$oficinaDestino.",'"
                                            .$tipoDoc."','".$nroDoc."','".$fechaIni."','".$fechaFin."','".$nEstadoMovimiento."','".$iCodOficinaOrigen."','',".$_POST["start"].",".
                                            $_POST["length"];


//print_r($sqlConsulta);                                            
//die();
//$sqlConsulta = "select * from Tra_M_Tramite ";
$rsConsulta = sqlsrv_query($cnx,$sqlConsulta);

if($rsConsulta === false) {
    die(print_r(sqlsrv_errors(), true));
}

$data = array();
$contador = 0;
while($Rs=sqlsrv_fetch_array($rsConsulta)){
    $subdata=array();
    $subdata['rowId'] = $contador;
    $subdata['iCodTramite']=$Rs['iCodTramite'];
    $subdata['iCodMovimiento']=$Rs['iCodMovimiento'];
    $subdata['iCodTrabajadorFirmante']=$Rs['iCodTrabajadorFirmante'];
    $subdata['iCodOficinaFirmante']=$Rs['iCodOficinaFirmante'];
    $subdata['nCud']=$Rs['nCud'];
    $subdata['cdesctipodoc']=$Rs['cdesctipodoc'].' '.$Rs['cCodificacion'];
    $subdata['cAsunto']=$Rs['cAsunto'];
    $subdata['remitente']=$Rs['remitente'];
    $subdata['cOficinaOrigen']=$Rs['cOficinaOrigen'];
    $subdata['cTrabajadorRegistro']=$Rs['cTrabajadorRegistro'];
    $subdata['iCodTrabajadorDerivar']=$Rs['iCodTrabajadorDerivar'];
    $subdata['cTrabajadorDerivar']=$Rs['cTrabajadorDerivar'];
    $subdata['cOficinaDestino']=$Rs['cOficinaDestino'];
    $subdata['nEstadoMovimiento']=$Rs['nEstadoMovimiento'];
    $subdata['cObservacionesFinalizar']=$Rs['cObservacionesFinalizar'];
    $subdata['flgTieneCargo']=$Rs['flgTieneCargo'];
    $subdata['fFecDerivar']=$Rs['fFecDerivar'] != null ? $Rs['fFecDerivar']->format( 'd/m/Y H:i:s') : '';
    $subdata['fFecRecepcion']=$Rs['fFecMovimiento'] != null ? $Rs['fFecMovimiento']->format( 'd/m/Y H:i:s') : '';
    $subdata['flgEncriptado']=$Rs['flgEncriptado'];
    $subdata['origen']=$Rs['origen'];
    $contador ++;
    $data[]=$subdata;
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
