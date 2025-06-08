<?php

$sql = "delete from Tra_M_Dependencias WHERE iCodDependencia=" . $id;
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location:../views/iu_dependencias.php");
sqlsrv_close($cnx);
?>