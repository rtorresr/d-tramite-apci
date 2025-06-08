<?php
include_once("../../conexion/conexion.php");

//Establishes the connection
$cnx = sqlsrv_connect($serverName, $connectionOptions);

$pg = $_GET['page'] ?? 25;
$query = $_GET['q'] ?? '';

$sqlRem="SELECT TOP ". $pg  ." iCodTramite, nCud, cCodificacion, cDescTipoDoc, cNroDocumento FROM Tra_M_Tramite AS t LEFT JOIN Tra_M_Tipo_Documento AS d ON t.cCodTipoDoc = D.cCodTipoDoc ";

$sqlRem.="WHERE cFirma = 1 AND (cCodificacion LIKE '%".$query."%' OR cDescTipoDoc LIKE '%".$query."%' OR cNroDocumento LIKE '%".$query."%' OR nCud LIKE '%".$query."%' ) ";

$sqlRem.="ORDER BY cCodificacion ASC";
$rsRem=sqlsrv_query($cnx,$sqlRem);

$arrRemitentes = [];

while ($RsRem = sqlsrv_fetch_array($rsRem)){
    $texto = trim($RsRem['nCud'])." | ".trim($RsRem['cDescTipoDoc']);
    if(is_null($RsRem['cNroDocumento'])){
        $texto.= " ".trim($RsRem['cCodificacion']);
    } else {
        $texto.= " ".trim($RsRem['cNroDocumento']);
    }

    array_push($arrRemitentes, ["id" => trim($RsRem['iCodTramite']), "text" => $texto]);
}

sqlsrv_free_stmt($rsRem);

echo json_encode($arrRemitentes);