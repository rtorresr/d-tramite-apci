<?php
include_once("../../conexion/conexion.php");
$sqlTupa = "SELECT iCodTupa,cNomTupa, RutaApp, NomApp FROM Tra_M_Tupa WHERE iCodTupaClase='".$_POST['iCodTupaClase']."' ORDER BY iCodTupa ASC";
$rsTupa  = sqlsrv_query($cnx,$sqlTupa);
$data = [];
while ($RsTupa = sqlsrv_fetch_array($rsTupa)){
    array_push($data,"<option value='".$RsTupa["iCodTupa"]."' ruta='".$RsTupa["RutaApp"]."' nomApp='".$RsTupa["NomApp"]."'>".$RsTupa["cNomTupa"]."</option>");
}
sqlsrv_free_stmt($rsTupa);
echo json_encode($data);