<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_grupo_oficina_detalle.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Oficinas Detalle
  -> Eliminar Registro de Grupo de Oficinas Detalle
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "DELETE FROM Tra_M_Grupo_Oficina_Detalle WHERE iCodGrupoOficina = '" . $iCodGrupo . "' AND iCodOficina = '" . $id . "' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_grupo_oficina_detalle.php?cod=" . $iCodGrupo);
sqlsrv_close($cnx);
?>