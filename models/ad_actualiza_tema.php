<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_tema.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Temas
  -> Actualizar Registro de Temas
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
/* $sql1=" SELECT * FROM Tra_M_Categoria WHERE cDesCategoria = '$_POST[cDesCategoria]' OR cDesCategoria = '$_POST[cDesCategoria2]' ";
  $rs1=sqlsrv_query($cnx,$sql1);
  $registro1=sqlsrv_has_rows($rs1);

  if($registro1==1 )
  { */
$sql = "SP_TEMA_UPDATE '$_POST[cDesTema]','$_POST['iCodOficina']','$_POST['iCodTema']' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
header("Location: ../views/iu_tema.php?cDesTema=" . $_POST[cDesTemax] . "&iCodOficina=" . $_POST[iCodOficinax] . "&pag=" . $_POST[pagx]);
/* }
  else
  { header("Location: ../views/iu_actualiza_tema.php?cDesCategoria=".$_POST[cDesCategoria]);
  } */
?>
