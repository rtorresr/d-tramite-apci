<?php

$sql = "select * from Tra_M_Tipo_Documento ORDER BY 'cCodTipoDoc' ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
?>