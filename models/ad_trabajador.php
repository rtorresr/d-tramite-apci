<?php

$sql = "select * from Tra_M_Trabajadores ORDER BY 'cCodTrabajador' ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
?>