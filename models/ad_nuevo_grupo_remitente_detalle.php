<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevo_grupo_remitente_detalle.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Remitentes Detalle
  -> Crear Registro de Remitente Detalle
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
for ($h = 0; $h < count($_POST[iCodRemitente]); $h++) {
    $iCodRemitente = $_POST[iCodRemitente];
    $sql = "INSERT INTO Tra_M_Grupo_Remitente_Detalle (iCodGrupo,iCodRemitente) VALUES ('$_POST[codGrupo]' ,'$iCodRemitente[$h]')  ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
}
header("Location: ../views/iu_grupo_remitentes_detalle.php?cod=" . $_POST[codGrupo]);
//echo $sql;
?>

