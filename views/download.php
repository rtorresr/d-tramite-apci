<?php
	date_default_timezone_set('America/Lima');
	// Inicio de aceptar el trámite dando click en el mismo
	// actualizar fecha del ÚNICO SELECCIONADO pendiente al momento de aceptarlo.

	// LCP
	$fFecActual = date("Ymd")." ".date("H:i:s");
	// PRO INVERSION
	//$fFecActual = date("Ymd")." ".date("H:i:s");

	$iCodMovimiento = $_GET['iCodMovimiento']??'';
	$nFlgEstado     = $_GET['nFlgEstado']??'';
	
	if ($nFlgEstado == 1) { 
		// La primera vez nFlgEstado está en 1, luego cuando se acepta, cambia a 2, y no ya no se debe volver 
		// a ejecutar el siguiente código, ya que volvería a ctualizar la fecha.
		include_once("../conexion/conexion.php");
		//$iCodMovimiento = $_GET['iCodMovimiento'];
 		$sqlMov = "UPDATE Tra_M_Tramite_Movimientos 
 							 SET fFecRecepcion = '".$fFecActual."' 
 							 WHERE iCodMovimiento = '".$iCodMovimiento."'";
 		$rsUpdMov = sqlsrv_query($cnx,$sqlMov);
 			
		$sqlMovData = "SELECT iCodTramite, iCodMovimiento, iCodTramiteDerivar, nEstadoMovimiento, iCodTrabajadorDelegado 
									 FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = '".$iCodMovimiento."'";
 		$rsMovData  = sqlsrv_query($cnx,$sqlMovData);
		$RsMovData  = sqlsrv_fetch_array($rsMovData);
		
		if ($RsMovData['nEstadoMovimiento'] == 3 && $RsMovData['iCodTrabajadorDelegado'] == $_SESSION['CODIGO_TRABAJADOR'] ){
			$sqlMovDel = "UPDATE Tra_M_Tramite_Movimientos 
										SET fFecDelegadoRecepcion = '$fFecActual' 
										WHERE iCodMovimiento = '$iCodMovimiento'";
 			$rsUpdMovDel = sqlsrv_query($cnx,$sqlMovDel);
		}
		
		if ($RsMovData['iCodTramiteDerivar'] != ""){
			$sqlUpdDev = "UPDATE Tra_M_Tramite_Movimientos 
										SET fFecRecepcion = '$fFecActual' 
										WHERE iCodTramite='".$RsMovData['iCodTramiteDerivar']."'";
			$rsUpdDev  = sqlsrv_query($cnx,$sqlUpdDev);
		}
 		$sqlUpd = "UPDATE Tra_M_Tramite 
 							 SET nFlgEstado = 2 
 							 WHERE iCodTramite = '$RsMovData[iCodTramite]'";
		$rsUpd  = sqlsrv_query($cnx,$sqlUpd);
	}
	// Fin de aceptar el trámite dando click en el mismo

	if ($_GET['direccion'] != "" AND $_GET['file'] != ""){
		$enlace = $_GET['direccion'].$_GET['file'];
		header ("Content-Disposition: attachment; filename='".$_GET['file']."'");
		header ("Content-Type: application/octet-stream");
		header ("Content-Length: ".filesize($enlace));
		readfile($enlace);
	}
?>