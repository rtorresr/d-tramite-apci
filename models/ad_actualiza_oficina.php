<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_oficina.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Oficinas
  -> Actualizar Registro de Oficina
  -> Validar Ingreso de Valores Repetidos
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql1 = " SP_OFICINA_LISTA_AR3 '$_POST[cNomOficina]' , '$_POST[cNomOficina2]' ";
$sql2 = " SP_OFICINA_LISTA_AR4 '$_POST[cSiglaOficina]' , '$_POST[cSiglaOficina2]' ";

$rs1 = sqlsrv_query($cnx,$sql1, $cnx);
$rs2 = sqlsrv_query($cnx,$sql2, $cnx);

$registro1 = sqlsrv_has_rows($rs1);
$registro2 = sqlsrv_has_rows($rs2);

if ($registro1 == 1 && $registro2 == 1) {
    $sql = "SP_OFICINA_UPDATE '$_POST[cNomOficina]','$_POST[cSiglaOficina]', '$_POST[iFlgEstado]','.$_POST['iCodOficina'].'";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
    sqlsrv_close($cnx);
    header("Location: ../views/iu_oficinas.php?cNomOficina=" . $_POST['cNomOficinax'] . "&cSiglaOficina=" . $_POST['cSiglaOficinax'] .  "&iFlgEstado=" . $_POST['iFlgEstadox'] . "&pag=" . $_POST['pagx']);
} else {
    if ($registro1 > 1 && $registro2 == 1) {
        header("Location: ../views/iu_actualiza_oficina.php?cNomOficina=" . $_POST[cNomOficina]);
    }

    if ($registro1 == 1 && $registro2 > 1) {
        header("Location: ../views/iu_actualiza_oficina.php?cSiglaOficina=" . $_POST[cSiglaOficina]);
    }

    if ($registro1 > 1 && $registro2 > 1) {
        header("Location: ../views/iu_actualiza_oficina.php?cSiglaOficina=" . $_POST[cSiglaOficina] . "&cNomOficina=" . $_POST[cNomOficina]);
    }
}
sqlsrv_close($cnx);
?>