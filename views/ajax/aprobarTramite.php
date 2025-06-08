<?php session_start();
	include_once("../../conexion/conexion.php");
	date_default_timezone_set('America/Lima');

	/*
		Estados
			0 (Pendiente)
			1 (Aprobado)
			2 (Observaado)
	*/
	
	$iCodTramite       = $_GET['iCodTramite'];
	// LCP
	//$fechaDeAprobacion = date("Ymd")." ".date("G:i:s");
	// PRO INVERSION
	$fechaDeAprobacion = date("Ydm")." ".date("G:i:s");
	$iCodJefe 				 = $_GET['iCodJefe'];

	$sqlTrabajador = "SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$iCodJefe;
	$rsTrabajador  = sqlsrv_query($cnx,$sqlTrabajador);
	$RsTrabajador  = sqlsrv_fetch_array($rsTrabajador);

	$cNomJefe = trim($RsTrabajador['cNombresTrabajador'])." ".trim($RsTrabajador['cApellidosTrabajador']);

	$sqlUpdate = "UPDATE Tra_M_Tramite
								SET nFlgEnvio = 1,
										FECHA_DOCUMENTO = getdate(),
										iCodJefe = '$iCodJefe',
										cNomJefe = '$cNomJefe'
								WHERE iCodTramite = ".$iCodTramite;

	$rsUpdate = sqlsrv_query($cnx,$sqlUpdate);

	header("Location: ../documentosPorAprobar.php");
?>