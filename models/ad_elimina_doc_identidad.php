<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_doc_identidad.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Documentos de Identidad
  -> Eliminar Registro de Documento de Identidad
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "SP_DOC_IDENTIDAD_DELETE " . $_GET[id];
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_doc_identidad.php?cDescDocIdentidad=" . $cDescDocIdentidad . "&pag=" . $pag);
sqlsrv_close($cnx);
?>