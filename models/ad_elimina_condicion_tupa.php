<?php

$sql = "delete from Tra_M_Tupa_Req WHERE cCodDetTupa=" . $id;
$rs = sqlsrv_query($cnx,$sql, $cnx);

$sql = "select * from Tra_M_Tupa  where cCodTupa='$_GET[codtupa]'";
$rs = sqlsrv_query($cnx,$sql, $cnx);
$Rs = sqlsrv_fetch_array($rs);
echo $Rs[cDesTupa];
echo "Registro eliminado"; //iu_detalle_tupa.php?id=".$_POST[cCodTupa]."&cont=".$Rs[cDesTupa]"echo "<a class='btn btn-primary' href='../views/iu_detalle_tupa.php?id=" . $Rs[cCodTupa] . "&cont=" . $Rs[cDesTupa] . "'>Inicio</a>";
sqlsrv_close($cnx);
?>