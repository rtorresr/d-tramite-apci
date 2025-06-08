<?php
include_once("../../conexion/conexion.php");

$sqlTipo = "SELECT cCodTipoDoc, cDescTipoDoc FROM Tra_M_Tipo_Documento ORDER BY cDescTipoDoc ASC";
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