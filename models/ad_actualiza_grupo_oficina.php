<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_grupo_oficina.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupos de Oficina
  -> Actualizar Registro de Grupos de Oficina
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.
  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "UPDATE Tra_M_Grupo_Oficina SET cDesGrupoOficina= '$_POST[txtgrupo]' WHERE iCodGrupoOficina='$_POST[txtcod_grupo]' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
header("Location: ../views/iu_grupo_oficina.php");
?>
