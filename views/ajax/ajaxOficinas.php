<?php
include_once("../../conexion/conexion.php");
session_start();

$datos = [];

$esPrestamo = $_POST['esPrestamo'] ?? '0';

if (isset($_POST['esTupa'])) {
    $datos['esTupa'] = $_POST['esTupa'];

    $sqlOfi = "SELECT iCodOficina, cNomOficina, cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0";
    if ($_POST['esTupa'] == 1) {
        $sqlCod = "SELECT iCodOficina FROM Tra_M_Tupa WHERE iCodTupa = " . $_POST['iCodTupa'];
        $rsCod = sqlsrv_query($cnx, $sqlCod);
        $RsCod = sqlsrv_fetch_array($rsCod);

        $datos['oficina'] = $RsCod['iCodOficina'];

        $sqlOfi .= " AND iCodOficina = " . $RsCod['iCodOficina'];
    }
    $sqlOfi .= "ORDER BY cNomOficina ASC";
    $rsOfi = sqlsrv_query($cnx, $sqlOfi);

    $data = [];
    while ($RsOfi = sqlsrv_fetch_array($rsOfi)) {
        if ($esPrestamo == '1'){
            if($_SESSION['iCodPerfilLogin'] != 22){
                if ($_SESSION['iCodOficinaLogin'] == $RsOfi['iCodOficina']){
                    $con = "<option value='" . $RsOfi['iCodOficina'] . "'>" . trim($RsOfi['cNomOficina']) . " | " . trim($RsOfi["cSiglaOficina"]) . "</option>";
                    array_push($data, $con);
                }
            } else {
                $con = "<option value='" . $RsOfi['iCodOficina'] . "'>" . trim($RsOfi['cNomOficina']) . " | " . trim($RsOfi["cSiglaOficina"]) . "</option>";
                array_push($data, $con);
            }
        } else {
            $con = "<option value='" . $RsOfi['iCodOficina'] . "' >" . trim($RsOfi['cNomOficina']) . " | " . trim($RsOfi["cSiglaOficina"]) . "</option>";
            array_push($data, $con);
        }        
    }
    sqlsrv_free_stmt($rsOfi);
    $datos['data'] = $data;

} else {

    $pg = $_GET['page'] ?? 25;
    $query = $_GET['q'] ?? '';

    $sqlRem="SELECT TOP ". $pg  ." iCodOficina, cNomOficina, cSiglaOficina FROM Tra_M_Oficinas ";
    $sqlRem.="WHERE iFlgEstado != 0 AND (cNomOficina LIKE '%".$query."%' OR cSiglaOficina LIKE '%".$query."%' )";

    $sqlRem.="ORDER BY cNomOficina ASC";
    $rsRem=sqlsrv_query($cnx,$sqlRem);

    $datos = [];

    while ($RsRem = sqlsrv_fetch_array($rsRem)){
        array_push($datos, ["id" => trim($RsRem['iCodOficina']), "text" => trim($RsRem['cNomOficina']) . " | " . trim($RsRem["cSiglaOficina"])]);
    }

    sqlsrv_free_stmt($rsRem);
}

echo json_encode($datos);