<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nueva_oficina.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Oficinas
  -> Crear Registro de Oficina
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
//echo $id;
$sql1 = " SELECT * FROM Tra_M_Oficinas WHERE cNomOficina='$_POST[cNomOficina]' ";
$sql2 = " SELECT * FROM Tra_M_Oficinas WHERE cSiglaOficina='$_POST[cSiglaOficina]' ";

$rs1 = sqlsrv_query($cnx,$sql1, $cnx);
$rs2 = sqlsrv_query($cnx,$sql2, $cnx);

$registro1 = sqlsrv_has_rows($rs1);
$registro2 = sqlsrv_has_rows($rs2);

if ($registro1 == 0 && $registro2 == 0) {
    /* $sql= "insert into Tra_M_Oficinas (cNomOficina,cSiglaOficina,iCodUbicacion) 
      VALUES ('$_POST[cNomOficina]','$_POST[cSiglaOficina]','$_POST[iCodUbicacion]')"; */
    $sql = "SP_OFICINA_INSERT '$_POST[cNomOficina]','$_POST[cSiglaOficina]','$_POST[iCodUbicacion]' , '$_POST[iFlgEstado]' ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
    header("Location: ../views/iu_oficinas.php");
} else {
    if ($registro1 != 0 && $registro2 == 0) {
        header("Location: ../views/iu_nueva_oficina.php?cNomOficina=" . $_POST[cNomOficina]);
    }

    if ($registro1 == 0 && $registro2 != 0) {
        header("Location: ../views/iu_nueva_oficina.php?cSiglaOficina=" . $_POST[cSiglaOficina]);
    }

    if ($registro1 != 0 && $registro2 != 0) {
        header("Location: ../views/iu_nueva_oficina.php?cSiglaOficina=" . $_POST[cSiglaOficina] . "&cNomOficina=" . $_POST[cNomOficina]);
    }
}
sqlsrv_close($cnx);
?>