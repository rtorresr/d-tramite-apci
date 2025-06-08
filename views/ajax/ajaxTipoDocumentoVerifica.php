<?php
include_once("../../conexion/conexion.php");

if ($_POST['tipoDoc'] == '2') {
    $busqueda = " nFlgInterno = 1 ";
} else {
    $busqueda = " nFlgSalida = 1 ";
}
$sqlTipo = "SELECT cCodTipoDoc, cDescTipoDoc FROM Tra_M_Tipo_Documento   WHERE nFlgInterno = 1 OR nFlgSalida = 1 ORDER BY cDescTipoDoc ASC";
$rsTipo = sqlsrv_query($cnx,$sqlTipo);
$data = [];
while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
    $info = [];
    $info['codigo'] = rtrim($RsTipo['cCodTipoDoc']);
    $info['nombre'] = rtrim($RsTipo['cDescTipoDoc']);
    $data[]= $info;
}
sqlsrv_free_stmt($rsTipo);
echo json_encode($data);