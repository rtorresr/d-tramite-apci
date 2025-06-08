<?php
include_once("../../conexion/conexion.php");

$sqlTupaReq="SELECT iCodTupaRequisito,cNomTupaRequisito FROM Tra_M_Tupa_Requisitos WHERE iCodTupa='".$_POST['iCodTupa']."' ORDER BY iCodTupaRequisito ASC";
$rsTupaReq = sqlsrv_query($cnx,$sqlTupaReq);

$datos = [];
if (sqlsrv_has_rows($rsTupaReq)){
    while ($RsTupaReq=sqlsrv_fetch_array($rsTupaReq)){
        array_push($datos,$RsTupaReq);
    };
}

sqlsrv_free_stmt($rsTupaReq);
echo json_encode($datos);