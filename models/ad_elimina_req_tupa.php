<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_req_tupa.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Requerimientos de Tupa
  -> Eliminar Registro de Requerimiento de Tupa
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
/* $sql= "delete from Tra_M_Tupa_Requisitos WHERE iCodTupaRequisito=".$id; */
$sql = "SP_REQUISITO_TUPA_DELETE " . $id;
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
header("Location:../views/iu_req_tupa.php?cod=" . $cod . "&sw=8");
?>