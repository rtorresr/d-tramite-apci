<?php 
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");

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