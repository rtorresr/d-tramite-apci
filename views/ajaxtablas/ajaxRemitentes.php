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
    0   =>  'iCodRemitente',
    1   =>  'nombre',
    2   =>  'nNumDocumento',
    3   =>  'cDireccion',
    4   =>  'estado'
);

$ct = new coreTable($cnx);
$thing = $ct->datos($request, $columnas, 'vw_bandeja_entrada_profesional', '',1 );

$data=array();
while($Rs=sqlsrv_fetch_array($thing["data"])){
    $subdata=array();
    $subdata[]=$Rs['iCodRemitente'];
    $subdata[]=$Rs['nombre'];
    $subdata[]=$Rs['nNumDocumento'];
    $subdata[]=$Rs['cDireccion'];
    $subdata[]=$Rs['estado'];
    $data[]=$subdata;
}

$thing["data"] = $data;

echo json_encode($thing);