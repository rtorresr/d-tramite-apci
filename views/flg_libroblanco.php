<?php 
	include_once("../conexion/conexion.php");

	$sql = "UPDATE [dbo].[Tra_M_Tramite] 
				  SET flg_libreblanco = '".$_GET['opcion']."' 
				  WHERE iCodTramite = '".$_GET['iCodTramite']."'"; 
	$rsUptr = sqlsrv_query($cnx,$sql);
?>
<?php
	if($_GET['page'] == 1){ 
?>
	<meta http-equiv="refresh" content="0;URL='pendientesControl.php'" /> 
<?php
	}elseif($_GET['page'] == 2){ 
?>
		<meta http-equiv="refresh" content="0;URL='pendientesDerivados.php'" /> 
<?php
	}elseif($_GET['page'] == 3){ 
?>
		<meta http-equiv="refresh" content="0;URL='pendientesFinalizados.php'" /> 
<?php
	} 
?>