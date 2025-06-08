<?php 
session_start();
ob_start();
include_once("../conexion/conexion.php");
$sqlTupaReq="SELECT * FROM Tra_M_Tupa_Requisitos ";
$sqlTupaReq.="WHERE iCodTupa='$_POST['iCodTupa']'";
$sqlTupaReq.="ORDER BY iCodTupaRequisito ASC";
$rsTupaReq=sqlsrv_query($cnx,$sqlTupaReq);
$result = array();
while($requisito = sqlsrv_fetch_array($rsTupaReq)){
    $result[]= $requisito;
}
echo json_encode($result);				              
?>