<?php
$sql1 = " SELECT * FROM Tra_M_Indicaciones WHERE cIndicacion='".($_POST['cIndicacion']??'')."' ";

$rs1 = sqlsrv_query($cnx,$sql1);
$registro1 = sqlsrv_has_rows($rs1);

if ($registro1 == 0) {
    $sql = "SP_INDICADORES_INSERT '".($_POST['cIndicacion']??'')."'";
    $rs = sqlsrv_query($cnx,$sql);
    header("Location: ../views/iu_indicadores.php");
} else {
    header("Location: ../views/iu_nuevo_indicador.php?cIndicacion=" . ($_POST['cIndicacion']??''));
}
?>

