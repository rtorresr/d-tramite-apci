<?php

include_once "../../conexion/conexion.php";
session_start();
include("coreTable.php");

//tipo de consulta
$request = $_GET;

//columnas de busqueda y ordenamiento
$columnas = array(
    2   =>  'TipoDocumento',
    3   =>  'cAsunto',
    4   =>  'Remitente',
    5   =>  'fFecDerivar',
    6   =>  'FechaPlazoFinal',
    7   =>  'Plazo',
    8   =>  'cObservacionesDerivar'
);

if ($_SESSION['iCodPerfilLogin'] == 19 ){
    $sqlCon = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '$_SESSION[iCodOficinaLogin]' AND iCodPerfil = 3";
    $rsCon = sqlsrv_query($cnx,$sqlCon);
    $RsCon = sqlsrv_fetch_array($rsCon);

    $where = " AND iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND ( iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR']." OR iCodTrabajadorDerivar = ".$RsCon['iCodTrabajador']." )" ;
} else {
    $where = " AND iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR'] ;
}

$ct = new coreTable($cnx);
$thing = $ct->datos($request, $columnas, 'vw_bandeja_entrada_profesional', $where,5 );

$data=array();
while($Rs=sqlsrv_fetch_array($thing["data"])){
    $subdata=array();
    $subdata[]=$Rs['iCodMovimiento'];
    $subdata[]=$Rs['nCud'];
    $subdata[]=$Rs['TipoDocumento'];
    $subdata[]=$Rs['cAsunto'];
    $subdata[]=$Rs['Remitente'];
    $subdata[]=$Rs['fFecDerivar'] != null ? $Rs['fFecDerivar']->format( 'd-m-Y H:i:s') : '';
    $subdata[]=$Rs['FechaPlazoFinal'] != null ? $Rs['FechaPlazoFinal']->format( 'd-m-Y H:i:s') : '';
    $subdata[]=$Rs['Plazo'];
    $subdata[]=$Rs['cObservacionesDerivar'];
    $data[]=$subdata;
}

$thing["data"] = $data;

echo json_encode($thing);