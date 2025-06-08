<?php 
	session_start();
	ob_start();

	include_once("../conexion/conexion.php");

	$sql = "SELECT *, Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
	$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite = Tra_M_Tramite_Movimientos.iCodTramite ";
	$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente = Tra_M_Remitente.iCodRemitente ";
	$sql.=" WHERE Tra_M_Tramite.iCodTramite = '$_GET[iCodTramite]'";

	$rs = sqlsrv_query($cnx,$sql);
	$Rs = sqlsrv_fetch_array($rs);

	header("Content-type:application/pdf");

	echo file_get_contents('documentos/'.$Rs["documentoElectronico"]);
?>
							