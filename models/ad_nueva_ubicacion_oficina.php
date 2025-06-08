<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nueva_ubicacion_oficina.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Ubicaci�n de Oficinas
  -> Crear Registro de Ubicaci�n de Oficina
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
//echo $cod;
$sql1 = " SELECT * FROM Tra_M_Ubicacion_Oficina WHERE cNomUbicacion='$_POST[cNomUbicacion]' ";
$rs1 = sqlsrv_query($cnx,$sql1, $cnx);
$registro1 = sqlsrv_has_rows($rs1);

if ($registro1 == 0) {
    $sql = "SP_UBICACION_OFICINA_INSERT '$_POST[cNomUbicacion]','$_POST[nFlagEstado]' ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
    header("Location: ../views/iu_ubicacion_oficina.php");
} else {
    if ($registro1 != 0) {
        header("Location: ../views/iu_nueva_ubicacion_oficina.php?cNomUbicacion=" . $_POST[cNomUbicacion]);
    }
}
?>