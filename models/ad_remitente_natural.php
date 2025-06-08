<?php

$sql = "select * from Tra_M_Remitente where cTipoPersona=" . $_POST['cTipoPersona'] . " ORDER BY nCodRemitente ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
?>