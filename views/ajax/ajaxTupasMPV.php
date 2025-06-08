<?php
include_once("../../conexion/conexion.php");

$params = array(
    $_POST['iCodTupaClase']
);

$sql = "{call UP_TUPA_LISTAR_MPV (?) }";
$rs = sqlsrv_query($cnx, $sql, $params);
$data = [];
while ($RsTupa = sqlsrv_fetch_array($rs)){
    array_push($data,"<option value='".$RsTupa["iCodTupa"]."' ruta='".$RsTupa["RutaApp"]."' nomApp='".$RsTupa["NomApp"]."'>".$RsTupa["cNomTupa"]."</option>");
}
sqlsrv_free_stmt($rs);
echo json_encode($data);