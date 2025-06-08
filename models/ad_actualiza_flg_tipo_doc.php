<?php

if ($_GET['Entrada'] == '1') {
    $sql = "update Tra_M_Tipo_Documento SET nFlgEntrada='0'  where cCodTipoDoc=".$_GET['id'];
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_tipo_doc.php");
} else if ($_GET['Entrada'] == '0') {
    $sql = "update Tra_M_Tipo_Documento SET nFlgEntrada='1'  where cCodTipoDoc=".$_GET['id'];
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_tipo_doc.php");
}

if ($_GET['Interno'] == '1') {
    $sql = "update Tra_M_Tipo_Documento SET nFlgInterno='0' where cCodTipoDoc=".$_GET['id'];
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_tipo_doc.php");
} else if ($_GET['Interno'] == '0') {
    $sql = "update Tra_M_Tipo_Documento SET nFlgInterno='1'  where cCodTipoDoc=".$_GET['id'];
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_tipo_doc.php");
}

if ($_GET['Salida'] == '1') {
    $sql = "update Tra_M_Tipo_Documento SET nFlgSalida='0' where cCodTipoDoc=".$_GET['id'];
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_tipo_doc.php");
} else if ($_GET['Salida'] == '0') {
    $sql = "update Tra_M_Tipo_Documento SET nFlgSalida='1' where cCodTipoDoc=".$_GET['id'];
    $rs = sqlsrv_query($cnx,$sql);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_tipo_doc.php");
}

?>
