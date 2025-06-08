<?php
$sql = "SP_TIPO_DOCUMENTO_DELETE " . $_GET['id'];
$rs = sqlsrv_query($cnx,$sql);
sqlsrv_close($cnx);
header("Location: ../views/iu_tipo_doc.php?Entrada=" . ($Entrada??'') . "&Interno=" . ($Interno??'') . "&Salida=" . ($Salida??'') . "&cDescTipoDoc=" . ($cDescTipoDoc??'') . "&pag=" . ($pag??0));
?>