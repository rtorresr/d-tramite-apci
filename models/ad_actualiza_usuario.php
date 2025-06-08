<?php

$sql = "update Tra_M_Usuario SET cCodTrabajador='$_POST[txtcod_trabajador]',nCodPerfil='$_POST[txtcod_perfil]',cUsuario='$_POST[txtusuario]',cPassword='$_POST[txtpassword]'
,fFecCreacion='$_POST[txtfech_creacion]',nFlgEstado='$_POST[txtestado]' where cCodUsuario='$_POST[txtcodusuario]'";
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location:../views/iu_usuario.php");
sqlsrv_close($cnx);
?>


