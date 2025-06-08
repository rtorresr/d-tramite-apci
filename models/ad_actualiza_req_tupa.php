<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_req_tupa.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Requerimientos de Tupa
  -> Actualizar Registro de Requerimiento de Tupa
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
/* $sql= "update Tra_M_Tupa_Requisitos SET nNumTupaRequisito='$_POST[nNumTupaRequisito]', cNomTupaRequisito='$_POST[cNomTupaRequisito]', nEstadoTupaRequisito='$_POST[txtestado]'    where iCodTupaRequisito='$_POST[iCodTupaRequisito]'"; */
$sql = " SP_REQUISITO_TUPA_UPDATE '$_POST[nNumTupaRequisito]', '$_POST[cNomTupaRequisito]', '$_POST[txtestado]' ,'$_POST[iCodTupaRequisito]' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
header("Location: ../views/iu_req_tupa.php?cod=$_POST['iCodTupa']&sw=8");
?>