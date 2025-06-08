<?php
	include_once("../../conexion/conexion.php");
	date_default_timezone_set('America/Lima');

	/*
		Estados
			0 (Pendiente)
			1 (Aprobado)
			2 (Observaado)
	*/
	
	$iCodTramite       = $_POST['iCodTramite'];

	// LCP
	// $fechaDeAceptacion = date("Ymd")." ".date("G:i:s");
	// PRO INVERSION
	// $fechaDeAceptacion = date("Ydm")." ".date("G:i:s");

	// $sqlUpdate = "UPDATE Tra_M_Tramite
	// 								SET FECHA_DOCUMENTO = '$fechaDeAceptacion'
	// 							WHERE iCodTramite = ".$iCodTramite;

	// $sqlUpdate = "UPDATE Tra_M_Tramite
	// 								SET FECHA_DOCUMENTO = getdate()
	// 							WHERE iCodTramite = ".$iCodTramite;

	$sqlUpdate = "UPDATE Tra_M_Tramite
									SET fecha_Acepta_Mensajeria = getdate()
								WHERE iCodTramite = ".$iCodTramite;

	$rsUpdate = sqlsrv_query($cnx,$sqlUpdate);
 ?>