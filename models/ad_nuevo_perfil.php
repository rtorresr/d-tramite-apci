<?php
$sql = " SELECT * FROM Tra_M_Perfil WHERE cDescPerfil='".($_POST['cDescPerfil']??'')."'";

$rs = sqlsrv_query($cnx,$sql);

$registro = sqlsrv_has_rows($rs);

if ($registro == 0) {
    $sql = "SP_PERFIL_INSERT '".($_POST['cDescPerfil']??'')."'";

    $rs = sqlsrv_query($cnx,$sql);
    header("Location: ../views/iu_perfil.php");
} else {
    if ($registro != 0) {
        header("Location: ../views/iu_nuevo_perfil.php?cDescPerfil=" . $_POST['cDescPerfil']);
    }
}
?>

