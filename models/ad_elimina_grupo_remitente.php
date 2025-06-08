<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_grupo_remitente.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Remitentes
  -> Eliminar Registro de Grupo de Remitentes
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql1 = "DELETE FROM Tra_M_Grupo_Remitente_Detalle WHERE iCodGrupo = " . $id;
$sql2 = "DELETE FROM Tra_M_Grupo_Remitente WHERE iCodGrupo = " . $id;
$rs = sqlsrv_query($cnx,$sql1, $cnx);
$rs = sqlsrv_query($cnx,$sql2, $cnx);
header("Location: ../views/iu_grupo_remitentes.php");
sqlsrv_close($cnx);
?>