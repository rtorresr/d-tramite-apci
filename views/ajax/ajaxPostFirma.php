<?php
session_start();
include_once("../../conexion/conexion.php");
date_default_timezone_set('America/Lima');
$fFecActual = date('Ymd').' '.date('G:i:s');

$iCodTramite = $_POST['iCodTramite'];

//CAMBIA TRAMITE A ENVIADO Y PARA BANDEJA DE ENTRADA
sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET nFlgEnvio = 1 , nFlgEstado = 1 WHERE iCodTramite =".$iCodTramite);

// CAMBIA ESTADO DEL MOVIMIENTO PARA FIRMAR  A FIRMADO
$rsPostFirma = sqlsrv_query($cnx, "UPDATE Tra_M_Tramite_Movimientos SET nEstadoMovimiento = 9 
where iCodTramite = ".$iCodTramite." AND iCodTrabajadorDerivar = ".$_SESSION['CODIGO_TRABAJADOR']." AND iCodOficinaDerivar = ".$_SESSION['iCodOficinaLogin']." AND paraAprobar = 1 AND paraFirmar = 1");
