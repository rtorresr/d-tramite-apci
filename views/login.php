<?php

date_default_timezone_set('America/Lima');

If ($_POST['usuario']=="" OR $_POST['contrasena']==""){
	header("Location: index-b.php?alter=3");
}else{
	include_once("../conexion/conexion.php");
    $usuario = strip_tags(trim($_POST["usuario"]));
    $clave = strip_tags(trim($_POST["contrasena"]));
	$contrasena = md5($usuario.$clave);
	error_log('CONTRASEA ==>'.$contrasena);
	$sql = "SELECT * FROM Tra_M_Trabajadores WHERE cUsuario='$usuario' AND cPassword='$contrasena'";
	//$sql = "SELECT * FROM Tra_M_Trabajadores WHERE cUsuario='$usuario'";
	// print_r($contrasena);
	// die();
	$rs = sqlsrv_query($cnx,$sql);
	if (sqlsrv_has_rows($rs)>0){
		$Rs=sqlsrv_fetch_array($rs);
			if($Rs['nFlgEstado']===1){
					session_start();
					$FechaActual=date("Y-m-d")." ".date("G:i:s");
					$Fecha=date("Ymd-Gis");
					$_SESSION['fUltimoAcceso']=$Rs["fUltimoAcceso"];
                    $_SESSION['CODIGO_TRABAJADOR']=$Rs["iCodTrabajador"];
                    $_SESSION['idUsuarioSigcti'] = $Rs["iCodUsuario"];
                    $_SESSION['nombresTrabajador'] = strtoupper(trim($Rs["cNombresTrabajador"])).' '.strtoupper(trim($Rs["cApellidosTrabajador"]));

					$sqlUpd="UPDATE Tra_M_Trabajadores SET ";
					$sqlUpd.="fUltimoAcceso = '$FechaActual' ";
					$sqlUpd.="WHERE cUsuario='$usuario' AND cPassword='$contrasena'";
					$rsUpd = sqlsrv_query($cnx,$sqlUpd);

					$sqlValPerfil = 'SELECT COUNT(iCodPerfilUsuario) AS valor FROM Tra_M_Perfil_Ususario WHERE iCodTrabajador ='.$_SESSION['CODIGO_TRABAJADOR'];
                    $rsValPerfil = sqlsrv_query($cnx,$sqlValPerfil);
                    $RsValPerfil  = sqlsrv_fetch_array($rsValPerfil);
                    $_SESSION['nroPerfiles'] = $RsValPerfil['valor'];

					if($_SESSION['nroPerfiles'] > 1){

                        header("Location: ../index2.php");
                    }
                    else{
                        $sqlPerfilUsu = 'select (select cDescPerfil from Tra_M_Perfil where iCodPerfil=o.iCodPerfil) as cDescPerfil,iCodPerfil,iCodTrabajador,iCodOficina, iCodCargo, firma, visto, flgDelegacion, flgEspecialistas, restricciones, flgEncriptacion
                        from Tra_M_Perfil_Ususario o 
                        where iCodTrabajador='.$_SESSION['CODIGO_TRABAJADOR'];
                        $rsPerfilUsu  = sqlsrv_query($cnx,$sqlPerfilUsu);
                        $RsPerfilUsu  = sqlsrv_fetch_array($rsPerfilUsu);

                        $_SESSION['iCodPerfilLogin'] = $RsPerfilUsu['iCodPerfil'];
                        $_SESSION['iCodOficinaLogin']= $RsPerfilUsu["iCodOficina"];
                        $_SESSION['iCodCargo']=$RsPerfilUsu["iCodCargo"];
                        $_SESSION['firma']=$RsPerfilUsu["firma"];
						$_SESSION['VistoBueno']=$RsPerfilUsu["visto"];
						$_SESSION['flgDelegacion']=$RsPerfilUsu["flgDelegacion"];
                        $_SESSION['flgEspecialistas']=$RsPerfilUsu["flgEspecialistas"];
                        $_SESSION['flgEncriptacion']=$RsPerfilUsu["flgEncriptacion"];

                        
                        $_SESSION['Restricciones'] = $RsPerfilUsu["restricciones"] == null ? [] : json_decode($RsPerfilUsu["restricciones"]);

                        $params = array(
                            $_SESSION['iCodOficinaLogin'],
                            $_SESSION['CODIGO_TRABAJADOR'],
                            $_SESSION['iCodPerfilLogin']
                        );
                        $sqlCrearSesion = "{call UP_INSERTAR_SESION (?,?,?) }";
                        $rs = sqlsrv_query($cnx, $sqlCrearSesion, $params);
                        if($rs === false) {
                            print_r('Error al registrar la sesion.');
                            http_response_code(500);
                            die(print_r(sqlsrv_errors()));
                        }

                        $Rs = sqlsrv_fetch_array( $rs, SQLSRV_FETCH_ASSOC);
                        $_SESSION['IdSesion'] = $Rs['IDENTIDAD'];

                        header('Location: main.php');
                    }
			}else{
					header("Location: ../index-b.php?alter=5");
			}
	}else{
		header("Location: ../index-b.php?alter=4");
	}
	sqlsrv_close($cnx);
}
?>