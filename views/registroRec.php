<?php
include_once("../conexion/conexion.php");
$rsRemit=sqlsrv_query($cnx,"SELECT iCodRemitente,cNombre FROM Tra_M_Remitente WHERE cNombre LIKE '".$_POST[remitenteNombre]."%'");
$RsRemit=sqlsrv_fetch_array($rsRemit);
echo "iCodRemtente: ".$RsRemit[iCodRemitente];
?>