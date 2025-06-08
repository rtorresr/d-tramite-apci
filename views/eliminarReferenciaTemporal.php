<?php 
session_start();
include_once("../conexion/conexion.php");

$sqlAdd="DELETE FROM Tra_M_Tramite_Referencias WHERE iCodReferencia='$_POST[iCodTramiteRef]'";    
$rs=sqlsrv_query($cnx,$sqlAdd);

$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodRef]' and identificador='$_POST[id_identificador]'";
$rsRefs=sqlsrv_query($cnx,$sqlRefs);
$result = array();
while($reponsable = sqlsrv_fetch_array($rsRefs)){
    $result[]= $reponsable;
}
echo json_encode($result);
?>