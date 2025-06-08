<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevoa_doc_identidad.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Documentos de Identidad
  -> Crear Registro de Documento de Identidad
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
//echo $id;
$sql1 = " SELECT * FROM Tra_M_Doc_Identidad WHERE cDescDocIdentidad='$_POST[cDescDocIdentidad]' ";
$rs1 = sqlsrv_query($cnx,$sql1, $cnx);
$registro1 = sqlsrv_has_rows($rs1);

if ($registro1 == 0) {
    $sql = "SP_DOC_IDENTIDAD_INSERT '$_POST[cDescDocIdentidad]' ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
    header("Location: ../views/iu_doc_identidad.php");
} else {
    header("Location: ../views/iu_nuevo_doc_identidad.php?cDescDocIdentidad=" . $_POST[cDescDocIdentidad]);
}
?>