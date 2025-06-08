<?php

$sql = "select * from Tra_M_Perfil ORDER BY 'iCodPerfil' ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
?>