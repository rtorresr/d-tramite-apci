<?php

//echo $id;
$sql = "insert into Tra_M_Usuario (cCodTrabajador,nCodPerfil,cUsuario,cPassword
,fFecCreacion,nFlgEstado) 
VALUES ('$_POST[txtcod_trabajador]','$_POST[txtcod_perfil]','$_POST[txtusuario]','$_POST[txtpassword]'
,'$_POST[txtfech_creacion]','$_POST[txtestado]')";
$rs = sqlsrv_query($cnx,$sql, $cnx);
echo "nuevo usuario registrado";echo "<a class='btn btn-primary' href='../views/iu_usuario.php'>Inicio</a>";
?>