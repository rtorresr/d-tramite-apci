<?php
date_default_timezone_set('America/Lima');
if ($_POST[usuario]=="" OR $_POST[contrasena]==""){
	header("Location: index-b.php?alter=3");
}else{
	include_once("../conexion/conexion.php");
	$usuario = trim($_POST[usuario]);
	$clave   = trim($_POST[contrasena]);
	$contrasena = md5($usuario.$clave);
	error_log('CONTRASEA ==>'.$contrasena);
	
	$ldapconn = ldap_connect("172.16.0.2");
	
	if ($ldapconn) {
		@$ldapbind = ldap_bind($ldapconn, $usuario."@SITDD.gob.pe", $clave);
		if ($ldapbind) {
			//$sql = "SELECT * FROM Tra_M_Trabajadores WHERE cUsuario='$usuario' AND cPassword='$contrasena'";
			$sql = "SELECT * FROM Tra_M_Trabajadores WHERE cUsuario='$usuario'";
			$rs = sqlsrv_query($cnx,$sql);
			if (sqlsrv_has_rows($rs)>0){
				$Rs      = sqlsrv_fetch_array($rs);
				$sqlJefe = "SELECT iCodTrabajador FROM Tra_M_Trabajadores WHERE iCodCategoria=5 And nFlgEstado=1 And iCodOficina='".$Rs["iCodOficina"]."'";
				$rsJefe  = sqlsrv_query($cnx,$sqlJefe);
				$RsJefe  = sqlsrv_fetch_array($rsJefe);
				if($Rs[nFlgEstado]==1){
					session_start();
					$FechaActual=date("Y-m-d")." ".date("G:i:s");
					$Fecha=date("Ymd-Gis");
					$_SESSION['fUltimoAcceso']=$Rs["fUltimoAcceso"];
					$_SESSION['iCodOficinaLogin']=$Rs["iCodOficina"];
					$_SESSION['iCodPerfilLogin']=$Rs["iCodPerfil"];
					$_SESSION['CODIGO_TRABAJADOR']=$Rs["iCodTrabajador"];
					$_SESSION['JEFE']=$RsJefe["iCodTrabajador"];
					$_SESSION['cCodRef']=$Rs["iCodTrabajador"]."-".$Rs["iCodOficina"]."-".$Fecha;
					$_SESSION['cCodOfi']=$Rs["iCodTrabajador"]."-".$Rs["iCodOficina"]."-".$Fecha;
					$_SESSION['cCodDerivo']=$Rs["iCodTrabajador"]."-".$Rs["iCodOficina"]."-".$Fecha;
					$sqlUpd="UPDATE Tra_M_Trabajadores SET ";
					//$sqlUpd.="fUltimoAcceso = '$FechaActual' ";
					$sqlUpd.="fUltimoAcceso = convert(datetime,'$FechaActual',121) ";//CesarAc
					$sqlUpd.="WHERE cUsuario='$usuario' AND cPassword='$contrasena'";
					$rsUpd = sqlsrv_query($cnx,$sqlUpd);
					header("Location: ../index2.php");
				}else{
					header("Location: ../index-b.php?alter=5");
				}
			}else{
				header("Location: ../index-b.php?alter=4");
			}
			sqlsrv_close($cnx);
		} // FIN de if ($ldapbind)
	}// FIN de if ($ldapconn)
}
?>