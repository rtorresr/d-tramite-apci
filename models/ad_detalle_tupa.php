<?php

$sql = "select * from Tra_M_Tupa_Req where cCodTupa=$id ORDER BY cCodDetTupa ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
//select * from BD_SITD.dbo.Tra_D_Tupa_Req where cCodTupa=4578 order by cCodDetTupa asc
?>