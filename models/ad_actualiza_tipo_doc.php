<?php
$sql2 = " SELECT * FROM Tra_M_Tipo_Documento WHERE cDescTipoDoc='".utf8_decode($_POST['cDescTipoDoc']??'')."' or cDescTipoDoc='".utf8_decode(($_POST['cDescTipoDoc2']??''))."' ";

$rs2 = sqlsrv_query($cnx,$sql2);

$registro2 = sqlsrv_has_rows($rs2);

if ($registro2 == 1) {
    $sql = "SP_TIPO_DOCUMENTO_UPDATE '".utf8_decode($_POST['cDescTipoDoc']??'')."'  ,'".($_POST['cCodTipoDoc']??'')."' ";
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
	header("Location: ../views/iu_tipo_doc.php");
} else {
    if ($registro2 > 1) {
        header("Location: ../views/iu_actualiza_tipo_doc.php?cDescTipoDoc=" . utf8_decode($_POST['cDescTipoDoc']??''));
    }
    header("Location: ../views/iu_tipo_doc.php?Entrada=" . ($Entrada??'') . "&Interno=" . ($Interno??'') . "&Salida=" . ($Salida??'') . "&cDescTipoDoc=" . ($cDescTipoDoc??'') . "&pag=" . ($pag??0));
}
?>
