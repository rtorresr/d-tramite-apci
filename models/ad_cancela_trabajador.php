<?php

$sql = "delete from Tra_M_Trabajadores WHERE cCodTrabajador=" . $cod;
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_trabajador.php");
sqlsrv_close($cnx);
?>