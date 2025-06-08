<?php
include_once("../conexion/conexion.php");
date_default_timezone_set('America/Lima');
session_start();
$codTramite = $_POST['codigo'];
$codMov = $_POST['codMovPro'];
$fFecActual = date('Ymd').' '.date('G:i:s');

$sqlCodPro = "SELECT iCodProyecto, iCodTrabajadorRegistro, iCodOficinaOrigen FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$codMov;
$rsCodPro = sqlsrv_query($cnx,$sqlCodPro);
$RsCodPro = sqlsrv_fetch_array($rsCodPro);

$rsMovTra = sqlsrv_query($cnx,"SELECT iCodMovimiento FROM Tra_M_Tramite_Movimientos WHERE iCodTramite = ".$codTramite);
$RsMovTra = sqlsrv_fetch_array($rsMovTra);

//actualizar  tabla tramite estado 2
$rsActTra = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nFlgEstado = 2 WHERE iCodTramite = ".$codTramite);

// CAMBIAR flag envio a 1 en tabla proyecto
$rsCambioPro = sqlsrv_query($cnx,"UPDATE Tra_M_Proyecto SET nFlgEnvio = 1 WHERE iCodProyecto = ".$RsCodPro['iCodProyecto']);

// cambiar estado a derivado 2 tabla derivado del movimiento del proyecto
$rsCambioMov = sqlsrv_query($cnx,"UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento = 4 WHERE iCodMovimiento = ".$codMov);

// inserta nuevo movimiento con el tramite
$sqlNuevoMov = "INSERT INTO Tra_M_Tramite_Movimientos(nFlgTipoDoc, cCodTipoDocDerivar, 
iCodIndicacionDerivar, cAsuntoDerivar, cObservacionesDerivar, cPrioridadDerivar, nEstadoMovimiento, cFlgTipoMovimiento)  
SELECT nFlgTipoDoc, cCodTipoDocDerivar, iCodIndicacionDerivar, cAsuntoDerivar, cObservacionesDerivar, cPrioridadDerivar, nEstadoMovimiento, cFlgTipoMovimiento 
FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento = ".$RsMovTra['iCodMovimiento'];
$rsInsMov = sqlsrv_query($cnx,$sqlNuevoMov);

$rsMovNue = sqlsrv_query($cnx,"SELECT iCodMovimiento FROM Tra_M_Tramite_Movimientos ORDER BY iCodMovimiento DESC");
$RsMovNue = sqlsrv_fetch_array($rsMovNue);

//actualizar movimiento
$sqlActNueMov = "UPDATE Tra_M_Tramite_Movimientos SET iCodtramite = '".$codTramite."' , iCodTrabajadorRegistro = '".$_SESSION['CODIGO_TRABAJADOR']."', iCodOficinaOrigen = '".$_SESSION['iCodOficinaLogin']."' , 
iCodTrabajadorDerivar = '".$RsCodPro['iCodTrabajadorRegistro']."', iCodOficinaDerivar = '".$RsCodPro['iCodOficinaOrigen']."',
fFecDerivar = '".$fFecActual."', fFecMovimiento = '".$fFecActual."' , paraVistar = '1', paraAprobar = '1'  WHERE iCodMovimiento = ".$RsMovNue['iCodMovimiento'];
$rsActNueMov = sqlsrv_query($cnx,$sqlActNueMov);



