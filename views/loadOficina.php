<?php 
session_start();
ob_start();
include_once("../conexion/conexion.php");

$sqlTupa="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='$_POST['iCodTupa']'";
$result=sqlsrv_query($cnx,$sqlTupa);
$RsObject=sqlsrv_fetch_object($result);

$sqlOficina="SELECT * FROM Tra_M_Oficinas WHERE iFlgEstado=1 AND iCodOficina='$RsObject->iCodOficina' ORDER BY cNomOficina ASC";
$rsOficina=sqlsrv_query($cnx,$sqlOficina);
$result = array();
while($oficina = sqlsrv_fetch_array($rsOficina)){
    $result[]= $oficina;
}
echo json_encode($result);				              
?>