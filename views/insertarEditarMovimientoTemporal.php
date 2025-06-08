<?php 
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");
$hoy =date("Y-m-d");

$sqlPerf=" SELECT iCodPerfil FROM Tra_M_Trabajadores WHERE iCodTrabajador = '$_POST[iCodTrabajadorMov]' ";
$rsPerf=sqlsrv_query($cnx,$sqlPerf);
$RsPerf=sqlsrv_fetch_array($rsPerf);

// verificar si es un profesional
if($RsPerf[iCodPerfil]!=4){
	$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos (iCodTramite, iCodTrabajadorRegistro, nFlgTipoDoc,  iCodOficinaOrigen,             iCodOficinaDerivar, iCodTrabajadorDerivar, iCodIndicacionDerivar, cPrioridadDerivar, cAsuntoDerivar, cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento, cFlgTipoMovimiento,cFlgOficina) VALUES ('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2, '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaMov]', '$_POST[iCodTrabajadorMov]', '$_POST[iCodIndicacionMov]', '$_POST[cPrioridadMov]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$hoy', '$hoy',  1, 1, 1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
} else {
	$sqlTJefe=" SELECT TOP 1 * FROM Tra_M_Trabajadores WHERE iCodOficina = '$_POST[iCodOficinaMov]' and nFlgEstado =1 and iCodCategoria =5 ";
	$rsTJefe=sqlsrv_query($cnx,$sqlTJefe);
	$RsTJefe=sqlsrv_fetch_array($rsTJefe);
	$sqlAdMv="INSERT INTO Tra_M_Tramite_Movimientos (iCodTramite, iCodTrabajadorRegistro, nFlgTipoDoc, iCodOficinaOrigen,             iCodOficinaDerivar,   iCodTrabajadorDerivar, iCodTrabajadorDelegado, fFecDelegado, iCodIndicacionDerivar, iCodIndicacionDelegado ,cObservacionesDelegado,   cPrioridadDerivar,   cAsuntoDerivar,    cObservacionesDerivar,     fFecDerivar,  fFecMovimiento, nEstadoMovimiento,cFlgTipoMovimiento,  cFlgOficina) VALUES ('$_POST[iCodTramite]', '".$_SESSION['CODIGO_TRABAJADOR']."',     2,            '".$_SESSION['iCodOficinaLogin']."', '$_POST[iCodOficinaMov]','$RsTJefe[iCodTrabajador]', '$_POST[iCodTrabajadorMov]', '$hoy' , '$_POST[iCodIndicacionMov]', '$_POST[iCodIndicacionMov]', '$_POST[cObservaciones]', '$_POST[cPrioridadMov]', '$_POST['cAsunto']', '$_POST[cObservaciones]', '$hoy', '$hoy', 3, 1,1)";
    $rsAdMv=sqlsrv_query($cnx,$sqlAdMv);
}

$sqlMovs="SELECT Tra_M_Tramite_Movimientos.iCodMovimiento,
			Tra_M_Oficinas.cNomOficina,
			Tra_M_Trabajadores.cNombresTrabajador,
			Tra_M_Trabajadores.cApellidosTrabajador,
			Tra_M_Indicaciones.cIndicacion,
			Tra_M_Tramite_Movimientos.cPrioridadDerivar,
			Tra_M_Tramite_Movimientos.cFlgTipoMovimiento  
		FROM Tra_M_Tramite_Movimientos 
		INNER JOIN Tra_M_Oficinas
		ON Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Movimientos.iCodOficinaDerivar
		INNER JOIN Tra_M_Trabajadores
		ON Tra_M_Trabajadores.iCodTrabajador=Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar
		INNER JOIN Tra_M_Indicaciones
		ON Tra_M_Indicaciones.iCodIndicacion=Tra_M_Tramite_Movimientos.iCodIndicacionDerivar 

		WHERE Tra_M_Tramite_Movimientos.iCodTramite='$_POST[iCodTramite]' AND Tra_M_Tramite_Movimientos.cFlgOficina=1 
		ORDER BY Tra_M_Tramite_Movimientos.iCodMovimiento ASC";
$rsMovs=sqlsrv_query($cnx,$sqlMovs);

$result = array();
while($tramiteTemporal = sqlsrv_fetch_array($rsMovs)){
    $result[]= $tramiteTemporal; 
}

echo json_encode($result);
?>