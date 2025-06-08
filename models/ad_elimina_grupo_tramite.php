<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_grupo_tramite.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Tramite Documentario
  -> Eliminar Registro de Grupo de Tramite Documentario
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "SP_GRUPO_TRAMITE_DELETE " . $id;
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_grupo_tramite.php");
sqlsrv_close($cnx);
?>