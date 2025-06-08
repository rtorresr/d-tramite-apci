<?php 
session_start();
include_once("../conexion/conexion.php");

for ($i=0;$i<count($lstOficinasSel);$i++){
	$lstOficinasSel=$_POST['lstOficinasSel'];
   		
   	$sqlTrb="SELECT TOP 1 * FROM Tra_M_Trabajadores WHERE iCodOficina='".$lstOficinasSel[$i]."' and iCodCategoria=5";
    $rsTrb=sqlsrv_query($cnx,$sqlTrb);
    $RsTrb=sqlsrv_fetch_array($rsTrb);
			
	$sqlAdd="INSERT INTO Tra_M_Tramite_Temporal (iCodOficina, iCodTrabajador, iCodIndicacion, cPrioridad, cCodSession) VALUES ('".$lstOficinasSel[$i]."', '".$RsTrb['iCodTrabajador']."', '".$_POST['iCodIndicacion']."', '".$_POST['cPrioridad']."', '".$_SESSION['cCodOfi']."')";
	echo $sqlAdd;
    //$rs=sqlsrv_query($cnx,$sqlAdd);
}

$sqlMovs="SELECT 
			Tra_M_Tramite_Temporal.iCodTemp,
			Tra_M_Trabajadores.encargado,
			Tra_M_Oficinas.cNomOficina,
			Tra_M_Trabajadores.cNombresTrabajador,
			Tra_M_Trabajadores.cApellidosTrabajador,
			Tra_M_Indicaciones.cIndicacion,
			Tra_M_Tramite_Temporal.cPrioridad 
		FROM Tra_M_Tramite_Temporal
			INNER JOIN Tra_M_Oficinas
			ON Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Temporal.iCodOficina
			INNER JOIN Tra_M_Trabajadores
			ON Tra_M_Trabajadores.iCodTrabajador=Tra_M_Tramite_Temporal.iCodTrabajador
			INNER JOIN Tra_M_Indicaciones
			ON Tra_M_Indicaciones.iCodIndicacion=Tra_M_Tramite_Temporal.iCodIndicacion 
		WHERE Tra_M_Tramite_Temporal.cCodSession='".$_SESSION['cCodOfi']."' 
		ORDER BY Tra_M_Tramite_Temporal.iCodTemp ASC";
$rsMovs=sqlsrv_query($cnx,$sqlMovs);

$result = array();
while($tramiteTemporal = sqlsrv_fetch_array($rsMovs)){
    $result[]= array_map("utf8_encode",$tramiteTemporal);
}
echo json_encode($result);
?>