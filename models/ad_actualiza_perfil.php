<?php
$sql1 = " SELECT * FROM Tra_M_Perfil WHERE cDescPerfil='".($_POST['cDescPerfil']??'')."' or cDescPerfil='".($_POST['cDescPerfil2']??'')."' ";

$rs1 = sqlsrv_query($cnx,$sql1);

$registro1 = sqlsrv_has_rows($rs1);

if ($registro1 == 1) {
    $sql = " SP_PERFIL_UPDATE '".($_POST['cDescPerfil']??'')."' ,'".($_POST['iCodPerfil']??'')."' ";
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_perfil.php");
} else {
    if ($registro1 > 1) {
        header("Location: ../views/iu_actualiza_perfil.php?cDescPerfil=" . ($_POST['cDescPerfil']??''));
    }
}
?>
