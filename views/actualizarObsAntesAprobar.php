<?php
	require_once("../conexion/conexion.php");
	date_default_timezone_set('America/Lima');

	$iCodTramite  = $_POST['iCodTramite'];
	$cObservacion = $_POST['cObservacion'];
	$pag          = $_POST['pag'];
	$fechaDeObs = date("Ymd")." ".date("G:i:s");

	/*
		Estados
			0 (Pendiente)
			1 (Aprobado)
			2 (Observaado)
	*/
	
	$sql = "UPDATE Tra_M_Tramite 
					SET MENSAJE_OBS = '$cObservacion',
							nFlgEnvio = 2,
							FECHA_OBS = '$fechaDeObs'
					WHERE iCodTramite = $iCodTramite";
	$rs  = sqlsrv_query($cnx,$sql);
	sqlsrv_close($cnx);
	if ($pag == 1) {
		header("Location: ../views/documentosPorAprobar.php");
	}else{
		header("Location: ../views/documentosObsPorAprobar.php");
	}
	
?>