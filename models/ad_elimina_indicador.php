<?php
$sql = "SP_INDICADORES_DELETE " . $_GET['id'];
$rs = sqlsrv_query($cnx,$sql);
sqlsrv_close($cnx);
header("Location: ../views/iu_indicadores.php");

?>