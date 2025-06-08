<?php
/**
 * Created by PhpStorm.
 * User: acachay
 * Date: 14/11/2018
 * Time: 15:14
 */
include_once "../../conexion/conexion.php";
session_start();
include("coreTable.php");

//tipo de consulta
$request=$_GET;

//columnas de busqueda y ordenamiento
$columnas=array(
    0   =>  'iCodMovimiento',
    1   =>  'nCud',
    2   =>  'TipoDocumento',
    3   =>  'cAsunto',
    4   =>  'Destinatario',
    5   =>  'fFecMovimiento',
    6   =>  'fFecRecepcion',
    7   =>  'iCodOficinaOrigen',
    8   =>  'iCodTrabajadorRegistro',
);

if ($_SESSION['iCodPerfilLogin'] == 3 || $_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20){
    $sqlCon = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '$_SESSION[iCodOficinaLogin]' AND iCodPerfil = 3";
    $rsCon = sqlsrv_query($cnx,$sqlCon);
    $RsCon = sqlsrv_fetch_array($rsCon);

    //$where = " AND iCodOficinaOrigen = ".$_SESSION['iCodOficinaLogin']." AND ( iCodTrabajadorRegistro = ".$_SESSION['CODIGO_TRABAJADOR']." OR iCodTrabajadorRegistro = ".$RsCon['iCodTrabajador']." )" ;
    $where = " AND iCodOficinaOrigen = '".$_SESSION['iCodOficinaLogin']."'";
} else {
    $where = " AND iCodOficinaOrigen = ".$_SESSION['iCodOficinaLogin']." AND iCodTrabajadorRegistro = ".$_SESSION['CODIGO_TRABAJADOR'] ;
}

$ct = new coreTable($cnx);
$thing = $ct->datos($request, $columnas, 'vw_bandeja_derivados', $where,5);

$data=array();
while($Rs=sqlsrv_fetch_array($thing["data"])){
    $subdata=array();
    $subdata[]=$Rs['iCodMovimiento'];
    $subdata[]=$Rs['nCud'];
    $subdata[]=$Rs['TipoDocumento'];
    $subdata[]=$Rs['cAsunto'];
    $subdata[]=$Rs['Destinatario'];
    $subdata[]=$Rs['fFecMovimiento'] != null ? $Rs['fFecMovimiento']->format( 'Y-m-d H:i:s') : '';
    if ($Rs['fFecRecepcion'] == null){
        $subdata[]="Sin aceptar";
    } else {
        $subdata[]="Pendiente";
    }
    $data[]=$subdata;
}
$thing["data"] = $data;

echo json_encode($thing);