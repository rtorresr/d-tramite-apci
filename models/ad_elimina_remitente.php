<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_remitente.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Remitentes
  -> Eliminar Registro de Remitente
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = " SP_REMITENTE_DELETE " . $id;
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
header("Location: ../views/iu_remitentes.php");
?>