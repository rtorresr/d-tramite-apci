<?php
	require_once("../conexion/conexion.php");
	if ($_POST['opcion'] == 2){
		$sql = "UPDATE Tra_M_Tramite_Movimientos 
					  SET cObservacionesFinalizar = '$_POST[cObservacion]' 
					  WHERE iCodMovimiento='$_POST[iCodMovimiento]' ";
		$rs  = sqlsrv_query($cnx,$sql);
		sqlsrv_close($cnx);
		header("Location: ../views/pendientesFinalizados.php");
	}
?>