<?php 
session_start();
include_once("../conexion/conexion.php");

$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_POST[iCodTramite]'";
$rsRefs=sqlsrv_query($cnx,$sqlRefs);
$result = array();
while($reponsable = sqlsrv_fetch_array($rsRefs)){
    $result[]= $reponsable;
}
echo json_encode($result);
?>