<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_tema.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Temas
  -> Eliminar Registro de Temas
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "SP_TEMA_DELETE " . $_GET[id];

$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_tema.php?cDesTema=" . $cDesTema . "&iCodOficina=" . $iCodOficina . "&pag=" . $pag);
sqlsrv_close($cnx);
?>