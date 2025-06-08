<?php 
session_start();
ob_start();
include_once("../conexion/conexion.php");
$sqlTupa="SELECT * FROM Tra_M_Tupa ";
$sqlTupa.="WHERE iCodTupaClase='$_POST[iCodTupaClase]'";
$sqlTupa.="ORDER BY iCodTupa ASC";
$rsTupa=sqlsrv_query($cnx,$sqlTupa);
$result = array();
while($reponsable = sqlsrv_fetch_array($rsTupa)){
    $result[]= $reponsable;
}
echo json_encode($result);				              
?>