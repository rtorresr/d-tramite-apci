<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_grupo_remitentes_detalle.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de tramite Documentario
  -> Eliminar Registro de Grupo de trabajador de Tramite Documentario
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = "DELETE FROM Tra_M_Grupo_Tramite_Detalle WHERE iCodTrabajador = '" . $_GET[id] . "' AND iCodGrupoTramite = '" . $_GET[iCodGrupoTramite] . "' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
header("Location: ../views/iu_grupo_tramite_detalle.php?cod=" . $iCodGrupoTramite);
sqlsrv_close($cnx);
?>