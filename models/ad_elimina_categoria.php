<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_categoria.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Categor�as
  -> Eliminar Registro de Categor�a
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "SP_CATEGORIA_DELETE " . $id;
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_categoria.php");
sqlsrv_close($cnx);
?>