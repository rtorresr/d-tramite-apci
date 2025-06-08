<?php
include_once("../../conexion/conexion.php");
include_once("../../conexion/srv-Nginx.php");

$params = array(
    $_POST['tipoDoc'],
    $_POST['cud'],
    $_POST['clave']
);
$sql = "{call UP_OBTENER_DOC_VERIFICA (?,?,?) }";
$rs = sqlsrv_query($cnx, $sql, $params);
if($rs === false) {
    http_response_code(500);
    die(sqlsrv_errors());
}
$datos = new stdClass();
if(sqlsrv_has_rows($rs)){
    $row = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
    $datos->success = true;
    
    $documento = new stdClass();
    $documento->idP = $row['idP'];
    if(count(json_decode($row['JidA'])) > 0){
        $documento->flgAnexos = true;
        $documento->JidA = $row['JidA'];
    }else {
        $documento->flgAnexos = false;
    }
    
    $datos->datosD = base64_encode(json_encode($documento));
} else {
    $datos->success = false;
}
echo base64_encode(json_encode($datos));