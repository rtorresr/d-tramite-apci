<?php

//echo $_POST[txtcod_tupa];
//echo $id;
$sql = "insert into Tra_M_Tupa_Req (cCodTupa,cDesDetTupa,nFlgObligatorio)
VALUES ('$_POST[txtcod_tupa]','$_POST[txtrequisito]','$_POST[sltrec_obligatorio]')";
$rs = sqlsrv_query($cnx,$sql, $cnx);

$sql = "select * from Tra_M_Tupa  where cCodTupa='$_POST[txtcod_tupa]'";
$rs = sqlsrv_query($cnx,$sql, $cnx);
$Rs = sqlsrv_fetch_array($rs);
header("Location:../views/iu_detalle_tupa.php?id=" . $Rs[cCodTupa] . "&cont=" . $Rs[cDesTupa]);
sqlsrv_close($cnx);
?>