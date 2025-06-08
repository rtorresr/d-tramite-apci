<?php
session_start();
include_once("../../conexion/conexion.php");
date_default_timezone_set('America/Lima');

$fFecActual = date('Ymd').' '.date('G:i:s');
$iCodTramite = $_POST['iCodTramite'];

$rsTramite = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite = ".$iCodTramite);
$RsTramite = sqlsrv_fetch_array($rsTramite);

$sqlMov = "INSERT INTO Tra_M_Tramite_Movimientos(iCodTramite, nFlgTipoDoc, iCodTrabajadorRegistro, iCodOficinaOrigen, iCodOficinaDerivar, iCodTrabajadorDerivar, 
 cCodTipoDocDerivar, iCodIndicacionDerivar, cAsuntoDerivar, cObservacionesDerivar, cPrioridadDerivar, nEstadoMovimiento, cFlgTipoMovimiento , fFecDerivar,
 fFecMovimiento, paraAprobar, paraFirmar) VALUES 
(".$iCodTramite.", ".$RsTramite['nFlgTipoDoc']." , ".$_SESSION['CODIGO_TRABAJADOR']." , ".$_SESSION['iCodOficinaLogin']." , ".$_SESSION['iCodOficinaLogin'].", 
 ".$_SESSION['CODIGO_TRABAJADOR']." , ".$RsTramite['cCodTipoDoc']." , 1, '".$RsTramite['cAsunto']."', '".$RsTramite['cObservaciones']."', 'Alta' , 1 , 1,
 '".$fFecActual."', '".$fFecActual."', 1, 1)";

$rsMov = sqlsrv_query($cnx,$sqlMov);

$rsUpTramite = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nFlgEstado = '2' WHERE iCodTramite = '".$iCodTramite."'");


