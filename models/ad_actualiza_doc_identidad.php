<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_doc_identidad.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Documentos de Identidad
  -> Actualizar Registro de Documento de Identidad
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql1 = " SELECT * FROM  Tra_M_Doc_Identidad WHERE cDescDocIdentidad= '$_POST[cDescDocIdentidad]' OR cDescDocIdentidad= '$_POST[cDescDocIdentidad2]' ";
$rs1 = sqlsrv_query($cnx,$sql1, $cnx);
$registro1 = sqlsrv_has_rows($rs1);

if ($registro1 == 1) {
    $sql = " SP_DOC_IDENTIDAD_UPDATE '$_POST[cDescDocIdentidad]','$_POST[cTipoDocIdentidad]' ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
    header("Location: ../views/iu_doc_identidad.php?cDescDocIdentidad=" . $_POST[cDescDocIdentidadx] . "&pag=" . $_POST[pagx]);
    sqlsrv_close($cnx);
} else {
    header("Location: ../views/iu_actualiza_doc_identidad.php?cDescDocIdentidad=" . $_POST[cDescDocIdentidad]);
}
?>