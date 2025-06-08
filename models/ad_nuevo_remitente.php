<?php
  $sql = "SP_REMITENTE_INSERT 
        $_POST[tipo_persona]
        ,'$_POST[txtnom_remitente]'
        ,'$_POST[cTipoDocIdentidad]'
        ,'$_POST[txtnum_documento]'
        ,'$_POST[txtdirec_remitente]'
        ,'$_POST[txtmail]'
        ,'$_POST[txtfono_remitente]'
        ,'$_POST[txtfax_remitente]'
        ,'$_POST[cCodDepartamento]'
        ,'$_POST[cCodProvincia]'
        ,'$_POST[cCodDistrito]'
        ,'$_POST[txtrep_remitente]'
        ,'$_POST[txtflg_estado]'
        ,'$_POST[cSiglaRemitente]' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);

if ($_GET["query"] == "cerrar") {
    echo "<script type='text/javascript'>self.close()</script>";
}
header("Location: ../views/iu_remitentes.php");
?>