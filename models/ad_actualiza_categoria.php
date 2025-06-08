<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_categoria.php
  SISTEMA:SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Categor�as
  -> Actualizar Registro de Categor�a
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql1 = " SELECT * FROM Tra_M_Categoria WHERE cDesCategoria = '$_POST[cDesCategoria]' OR cDesCategoria = '$_POST[cDesCategoria2]' ";
$rs1 = sqlsrv_query($cnx,$sql1, $cnx);
$registro1 = sqlsrv_has_rows($rs1);

if ($registro1 == 1) {
    $sql = "SP_CATEGORIA_UPDATE '$_POST[cDesCategoria]','$_POST[iCodCategoria]' ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_categoria.php");
} else {
    header("Location: ../views/iu_actualiza_categoria.php?cDesCategoria=" . $_POST[cDesCategoria]);
}
?>
