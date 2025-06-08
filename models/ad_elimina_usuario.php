<?php

$sql = "delete from Tra_M_Usuario WHERE cCodUsuario=" . $id;
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_usuario.php");
sqlsrv_close($cnx);
?>