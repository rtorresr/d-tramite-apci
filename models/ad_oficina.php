<?php

$sql = "select * from Tra_M_Dependencias ORDER BY 'cCodOficina' ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
?>