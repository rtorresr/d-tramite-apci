<?php 
session_start();
include_once("../conexion/conexion.php");

$sqlAdMv="INSERT INTO Tra_M_Tramite_Referencias (iCodTramiteRef, iCodTramite, cReferencia,  cCodSession, cDesEstado, iCodTipo) VALUES ('$_POST[iCodTramiteRef]','$_POST[iCodTramite]', '$_POST[cReferencia]','$_SESSION[cCodRef]', 'REGISTRADO', 1)";
$rsAdMv=sqlsrv_query($cnx,$sqlAdMv);

$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_POST[iCodTramite]'";
$rsRefs=sqlsrv_query($cnx,$sqlRefs);
$result = array();
while($reponsable = sqlsrv_fetch_array($rsRefs)){
    $result[]= $reponsable;
}
echo json_encode($result);
?>