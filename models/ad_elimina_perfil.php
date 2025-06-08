<?php
$sql = "SP_PERFIL_DELETE " . ($_GET['id']??'');
$rs = sqlsrv_query($cnx,$sql);
header("Location: ../views/iu_perfil.php");
sqlsrv_close($cnx);
?>