<?php
include_once "../../conexion/conexion.php";
session_start();

$cud = $_POST['cud']??'00';
$tipoDoc = $_POST['tipoDoc']??'NULL';
$cAsunto = $_POST['cAsunto']??'';
$remitente = $_POST['remitente']??'';
$nroDoc = $_POST['nroDoc']??'NULL';
$oficinaOrigen = $_POST['oficinaOrigen']??$_SESSION['iCodOficinaLogin'];
$oficinaDestino = $_POST['oficinaDestino']??'NULL';
$fechaini = $_POST['fechaini']??20190101;
$fechafin = $_POST['fechafin']??20191231;

$sqlConsulta = "execute SP_CONSULTA_GENERAL_FIRMADO '".$cud."','".$cAsunto."','".$remitente."',".$oficinaOrigen.",".$oficinaDestino.",".$tipoDoc.",".$nroDoc.",'".$fechaini."','".$fechafin."'";
//$sqlConsulta = "select * from Tra_M_Tramite ";
$rsConsulta = sqlsrv_query($cnx,$sqlConsulta);
$data = array();

while($Rs=sqlsrv_fetch_array($rsConsulta)){
    $subdata=array();
    $subdata[]=$Rs['iCodMovimiento'];
    $subdata[]=$Rs['nCud'];
    $subdata[]=$Rs['cdesctipodoc'].' '.$Rs['cCodificacion'];
    $subdata[]=$Rs['cAsunto'];
    $subdata[]=$Rs['remitente'];
    $subdata[]=$Rs['cOficinaOrigen'];
    $subdata[]=$Rs['cTrabajadorRegistro'];
    $subdata[]=$Rs['cOficinaDestino'];
    $subdata[]=$Rs['nEstadoMovimiento'];
    $subdata[]=$Rs['fFecDerivar'] != null ? $Rs['fFecDerivar']->format( 'd-m-Y H:i:s') : '';
    $subdata[]=$Rs['fFecRecepcion'] != null ? $Rs['fFecRecepcion']->format( 'd-m-Y H:i:s') : '';
    $data[]=$subdata;
}

$recordsTotal=sqlsrv_num_rows($rsConsulta);

$recordsFiltered=sqlsrv_num_rows($rsConsulta);

$json_data = array(
    "draw"            => (int)($request['draw']??0),
    "recordsTotal"    => (int) $recordsTotal ,
    "recordsFiltered" => (int) $recordsFiltered ,
    "data"            => $data
);

echo json_encode($json_data);
