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
    4   =>  'Remitente',
    5   =>  'fFecMovimiento',
    6   =>  'cObservacionesDerivar',
    7   =>  'paraAprobar',
    8   =>  'paraVistar',
    9   =>  'paraFirmar',
    10  =>  'tipo',
    11  =>  'codigo',
    12  =>  'cCodTipoDoc',
    13  =>  'tipoDoc',
    14  =>  'IdProyecto'
);

if ($_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20 ){
    $sqlCon = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '".$_SESSION['iCodOficinaLogin']."' AND iCodPerfil = 3";
    $rsCon = sqlsrv_query($cnx,$sqlCon);
    $RsCon = sqlsrv_fetch_array($rsCon);

    $where = " AND iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND ( iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR']." OR iCodTrabajadorDerivar = ".$RsCon['iCodTrabajador']." )" ;
} else {
    $where = " AND iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR'] ;
}

$ct = new coreTable($cnx);
$thing = $ct->datos($request, $columnas, 'vw_bandeja_por_aprobar', $where,5);

$data=array();
$contado =0;
while($Rs=sqlsrv_fetch_array($thing["data"])){
    $subdata=array();
    $subdata['rowId']= $contado;
    $subdata['codigo']=$Rs['codigo'];
    $subdata['cCodTipoDoc']=$Rs['cCodTipoDoc'];
    $subdata['tipoDoc']=$Rs['tipoDoc'];
    
    $subdata['iCodMovimiento']=$Rs['iCodMovimiento'];
    $subdata['nCud']=$Rs['nCud'];
    if ($Rs['tipo'] == 'p'){
        $subdata['tipo']= 'proyecto';
    }else   {
        $subdata['tipo']= 'tramite';
    }

    if ($Rs['tipo'] == 'p'){
        $subdata['Proyecto']='Proyecto';
    } else {
        $subdata['Proyecto']=$Rs['TipoDocumento'];
    }

    $subdata['cAsunto']=$Rs['cAsunto'];
    $subdata['Remitente']=$Rs['Remitente'];
    $subdata['fFecMovimiento']=$Rs['fFecMovimiento'] != null ? $Rs['fFecMovimiento']->format( 'Y-m-d H:i:s') : '';
    if ($Rs['paraAprobar'] == 1 && $Rs['paraVistar'] == 0 && $Rs['paraFirmar'] == 0 ){
        $subdata['estado']="Para Aprobar";
    }else{
        $subdata['estado']="";
    }
    if ($Rs['paraVistar'] == 1 && $Rs['paraFirmar'] == 0){
        $subdata['estado']="Para Vistar";
    }else{
        $subdata['estado']="";
    }
    if ($Rs['paraFirmar'] == 1){
        $subdata['estado']="Para Firmar";
    }else{
        $subdata['estado']="";
    }

    $subdata['cObservacionesDerivar']=$Rs['cObservacionesDerivar'];

    $subdata['IdProyecto']=$Rs['IdProyecto'];
    $data[]=$subdata;
    $contado++;
}

$thing["data"] = $data;

echo json_encode($thing);