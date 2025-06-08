<?php

$sql = "select * from Tra_M_Doc_Identidad ORDER BY 'cTipoDocIdentidad' ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
?>
