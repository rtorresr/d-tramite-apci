<?php
include_once("../../conexion/conexion.php");
$dep = $_POST['departamento'];
$pro = $_POST['provincia'];
$dis = $_POST['distrito'];

$data = [];

// departamento
$sqlDep = "SELECT cNomDepartamento FROM Tra_U_Departamento WHERE cCodDepartamento = ".$dep;
$rsDep = sqlsrv_query($cnx,$sqlDep);
if(sqlsrv_query($cnx,$sqlDep)){
    $RsDep = sqlsrv_fetch_array($rsDep);
    $data['dep'] = $RsDep['cNomDepartamento'];
}else {
    $data['dep']='';
}


//provincia
$sqlPro = "SELECT cNomProvincia FROM Tra_U_Provincia WHERE cCodDepartamento = ".$dep." AND cCodProvincia = ".$pro;
$rsPro = sqlsrv_query($cnx,$sqlPro);
if(sqlsrv_query($cnx,$sqlPro)){
    $RsPro = sqlsrv_fetch_array($rsPro);
    $data['pro'] = $RsPro['cNomProvincia'];
}else {
    $data['pro']='';
}

//distrito
$sqlDis = "SELECT cNomDistrito FROM Tra_U_Distrito WHERE cCodDepartamento = ".$dep." AND cCodProvincia = ".$pro." AND cCodDistrito = ".$dis;
$rsDis = sqlsrv_query($cnx,$sqlDis);
if(sqlsrv_query($cnx,$sqlDis)){
    $RsDis = sqlsrv_fetch_array($rsDis);
    $data['dis'] = $RsDis['cNomDistrito'];
}else {
    $data['dis']='';
}

echo json_encode($data);
?>