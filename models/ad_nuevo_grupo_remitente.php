<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevo_grupo_remitente.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupos de Remitentes
  -> Crear Registro de Grupos de Remitentes
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "SP_GRUPO_REMITENTE_INSERT '$_POST[txtgrupo]' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_grupo_remitentes.php");
?>

