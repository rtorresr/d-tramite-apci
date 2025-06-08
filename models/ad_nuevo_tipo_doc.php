<?php
$sql2 = " SELECT * FROM Tra_M_Tipo_Documento WHERE cDescTipoDoc='".$_POST['cDescTipoDoc']."' ";

$rs2 = sqlsrv_query($cnx,$sql2);

$registro2 = sqlsrv_has_rows($rs2);

if ($registro2 == 0) {
    $sql = "SP_TIPO_DOCUMENTO_INSERT '".$_POST['cDescTipoDoc']."','0','0','0','0' ";
    $rs = sqlsrv_query($cnx,$sql);
    header("Location: ../views/iu_tipo_doc.php");
} else {
    if ($registro2 != 0) {
        header("Location: ../views/iu_nuevo_tipo_doc.php?cDescTipoDoc=" . $_POST['cDescTipoDoc']);
    }
}
?>

