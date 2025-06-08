<?php
include_once("../../conexion/conexion.php");
$pg = $_GET['page'] ?? 25;
$query = $_GET['q'] ?? '';

$sql="SELECT TOP ". $pg  ." IdEntidadMRE, NombreEntMRE, CodigoMRE FROM Tra_M_Entidad_MRE WITH (NOLOCK)";
$sql.="WHERE NombreEntMRE LIKE '%".$query."%' OR CodigoMRE LIKE '%".$query."%'";


$sql.="ORDER BY NombreEntMRE ASC";
$rs=sqlsrv_query($cnx,$sql);

$arr = [];

while ($Rs = sqlsrv_fetch_array($rs)){
    array_push($arr, ["id" => trim($Rs['IdEntidadMRE']), "text" => (trim($Rs["NombreEntMRE"]).' | '.$Rs["CodigoMRE"])]);
}

sqlsrv_free_stmt($rs);

echo json_encode($arr);