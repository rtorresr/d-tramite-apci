<?php
include_once("../../conexion/conexion.php");

$sqlDis = "SELECT cCodDistrito, cNomDistrito FROM Tra_U_Distrito WHERE cCodDepartamento = ".$_POST['codDepa']." AND cCodProvincia = ".$_POST['codPro'];
$rsDis = sqlsrv_query($cnx,$sqlDis);
$data = [];
if(sqlsrv_has_rows($rsDis)){
    $data2 = [];
    while ($RsDis = sqlsrv_fetch_array($rsDis)){
        $info = [];
        $info['codigo'] = RTRIM($RsDis['cCodDistrito']);
        $info['nombre'] = RTRIM($RsDis['cNomDistrito']);
        $data2[] = $info;
    }
    $data['info'] = $data2;
    $data['tiene'] = 1;
} else {
    $data['tiene'] = 0;
}
echo json_encode($data);