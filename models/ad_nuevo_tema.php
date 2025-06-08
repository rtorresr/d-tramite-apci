<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevo_tema.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Temas
  -> Crear Registro de Temas
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
/* $sql1=" SELECT * FROM Tra_M_Temas WHERE cDesCategoria='$_POST[cDesCategoria]' ";
  $rs1=sqlsrv_query($cnx,$sql1);
  $registro1=sqlsrv_has_rows($rs1);

  if($registro1==0)
  { */
$sql = "SP_TEMA_INSERT '$_POST[cDesTema]' , '$_POST['iCodOficina']' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_tema.php");
/* }
  else
  { header("Location: ../views/iu_nuevo_tema.php?cDesCategoria=".$_POST[cDesCategoria]);
  }
 */
?>

