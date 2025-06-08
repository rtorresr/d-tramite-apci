<?php
include_once("../../conexion/conexion.php");

$sqlPro = "SELECT cCodProvincia, cNomProvincia FROM Tra_U_Provincia WHERE cCodDepartamento = ".$_POST['codDepa'];
$rsPro = sqlsrv_query($cnx,$sqlPro);
$data = [];
if(sqlsrv_has_rows($rsPro)){
    $data['tiene'] = 1;
    $data2 = [];
    while ($RsPro = sqlsrv_fetch_array($rsPro)){
        $info = [];
        $info['codigo'] = RTRIM($RsPro['cCodProvincia']);
        $info['nombre'] = RTRIM($RsPro['cNomProvincia']);
        $data2[] = $info;
    }
    $data['info'] = $data2;
} else {
    $data['tiene'] = 0;
}
echo json_encode($data);
