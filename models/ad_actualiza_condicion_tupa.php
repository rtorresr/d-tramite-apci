<?php

$sql = "update Tra_M_Tupa_Req SET cDesDetTupa='$_POST[cDesDetTupa]',nFlgObligatorio='$_POST[nFlgObligatorio]' where cCodDetTupa='$_POST[cCodDetTupa]'";
$rs = sqlsrv_query($cnx,$sql, $cnx);

$sql = "select * from Tra_M_Tupa  where cCodTupa='$_POST[cCodTupa]'";
$rs = sqlsrv_query($cnx,$sql, $cnx);
$Rs = sqlsrv_fetch_array($rs);
header("Location:../views/iu_detalle_tupa.php?id=" . $_POST[cCodTupa] . "&cont=" . $Rs[cDesTupa]);
//header("Location: ../views/iu_oficina.php");
sqlsrv_close($cnx);
?>
