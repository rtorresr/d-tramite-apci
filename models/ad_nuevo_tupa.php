<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevo_tupa.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Tupas
  -> Crear Registro de Tupa
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
//echo $id;
/* $sql= "insert into Tra_M_Tupa (iCodTupaClase,cNomTupa,nSilencio,nDias,iCodOficina,nEstado)
  VALUES ('$_POST[iCodTupaClase]','$_POST[txtdesc_tupa]','$_POST[txtsilencio]','$_POST[txtdia_tupa]','$_POST['iCodOficina']','$_POST[txtestado]')"; */
$sql = "SP_TUPA_INSERT '$_POST[iCodTupaClase]','$_POST[txtdesc_tupa]','$_POST[txtsilencio]','$_POST[txtdia_tupa]','$_POST[iCodOficina]','$_POST[txtestado]' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
//header("Location: ../views/iu_oficina.php");
header("Location:../views/iu_tupa.php");
?>