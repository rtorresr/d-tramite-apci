<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_ubicacion_oficina.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Ubicaci�n de Oficinas
  -> Actualizar Registro de Ubicaci�n de Oficina
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
//echo $id;
$sql = "SP_UBICACION_OFICINA_UPDATE '$_POST[cNomUbicacion]','$_POST[nFlagEstado]' ,'$_POST[iCodUbicacion]'";
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_ubicacion_oficina.php");
?>