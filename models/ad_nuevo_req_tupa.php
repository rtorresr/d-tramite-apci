<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevo_req_tupa.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Requerimientos de Tupa
  -> Crear Registro de Requerimiento de Tupa
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
/* $sql= "insert into Tra_M_Tupa_Requisitos (iCodTupa,nNumTupaRequisito,cNomTupaRequisito,nEstadoTupaRequisito) 
  VALUES ('$_POST['iCodTupa']','$_POST[nNumTupaRequisito]','$_POST[cNomTupaRequisito]','$_POST[txtestado]')"; */
$sql = "SP_REQUISITO_TUPA_INSERT '$_POST['iCodTupa']','$_POST[nNumTupaRequisito]','$_POST[cNomTupaRequisito]','$_POST[txtestado]'";
$rs = sqlsrv_query($cnx,$sql, $cnx);
//echo $sql;
sqlsrv_close($cnx);
header("Location: ../views/iu_req_tupa.php?cod=$_POST['iCodTupa']&sw=8");
//?cod=$_POST['iCodTupa']&sw=8"
?>