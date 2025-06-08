<?php
/**
 * Created by PhpStorm.
 * User: acachay
 * Date: 14/11/2018
 * Time: 15:14
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../../conexion/conexion.php";
session_start();
include("../ajaxtablas/coreTable.php");

//tipo de consulta
$request=$_GET;

//columnas de busqueda y ordenamiento
$columnas=array(
    0   =>  'Oficina',
    1   =>  'Entrada',
    2   =>  'Recibidos',
    3   =>  'Derivados',
    4   =>  'Aprobados'
);

$ct = new coreTable($cnx);
$thing = $ct->datos($request, $columnas, 'vw_reporte_bandejas', '', 0);

$data=array();
while($Rs=sqlsrv_fetch_array($thing["data"])){
    $subdata=array();
    $subdata[]=$Rs['Oficina'];
    $subdata[]=$Rs['Entrada'];
    $subdata[]=$Rs['Recibidos'];
    $subdata[]=$Rs['Derivados'];
    $subdata[]=$Rs['Aprobados'];
    $data[]=$subdata;
}

$thing["data"] = $data;
 
echo json_encode($thing);