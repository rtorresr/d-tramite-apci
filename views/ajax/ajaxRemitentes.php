<?php
    include_once("../../conexion/conexion.php");
    $pg = $_GET['page'] ?? 25;
    $query = $_GET['q'] ?? '';

    $sqlRem="SELECT TOP ". $pg  ." iCodRemitente, cNombre FROM Tra_M_Remitente WITH (NOLOCK)";
    $sqlRem.="WHERE cNombre LIKE '%".$query."%'";


    $sqlRem.="ORDER BY cNombre ASC";
    $rsRem=sqlsrv_query($cnx,$sqlRem);

    $arrRemitentes = [];

    while ($RsRem = sqlsrv_fetch_array($rsRem)){
        array_push($arrRemitentes, ["id" => trim($RsRem['iCodRemitente']), "text" => trim($RsRem["cNombre"])]);
    }

    sqlsrv_free_stmt($rsRem);

    echo json_encode($arrRemitentes);