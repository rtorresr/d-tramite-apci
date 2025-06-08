<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_oficina.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Oficinas
  -> Eliminar Registro de Oficina
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "SP_OFICINA_DELETE " . $_GET['id'];
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location:../views/iu_oficinas.php?cNomOficina=" . $cNomOficina . "&cSiglaOficina=" . $cSiglaOficina . "&cTipoUbicacion=" . $cTipoUbicacion . "&iFlgEstado=" . $iFlgEstado . "&pag=" . $pag);
sqlsrv_close($cnx);
?>