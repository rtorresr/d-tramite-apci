<?php
$sql1 = " SELECT * FROM Tra_M_Indicaciones WHERE cIndicacion='".($_POST['cIndicacion']??'')."' or cIndicacion='".($_POST['cIndicacion2']??'')."'";
$rs1 = sqlsrv_query($cnx,$sql1);
$registro1 = sqlsrv_has_rows($rs1);

if ($registro1 == 1) {
    $sql = "SP_INDICADORES_UPDATE '".($_POST['cIndicacion'])."', '".($_POST['iCodIndicacion']??'')."' ";
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_indicadores.php");
} else {
    header("Location: ../views/iu_actualiza_indicador.php?cIndicacion=" . ($_POST['cIndicacion']??''));
}
?>
