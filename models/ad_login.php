<?php

$cnx = sqlsrv_connect("192.168.1.104","sigi","sigi");
sqlsrv_select_db("DB_STD_PROINVERSION");

$sql = "select * from PERSONA where ID>" . $_POST[txtpara] . " ORDER BY RAZON_SOCIAL ASC";
$rs = sqlsrv_query($cnx,$sql, $cnx);
?>