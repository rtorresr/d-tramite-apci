<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevo_grupo_tramite_detalle.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Tramite Documentario Detalle
  -> Crear Registro de trabajador de Tramite Documentario Detalle
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
for ($h = 0; $h < count($_POST[iCodTrabajador]); $h++) {
    $iCodTrabajador = $_POST[iCodTrabajador];
    error_log($_POST[iCodGrupoTramite] . " - " . $iCodTrabajador[$h]);
    $sql = "INSERT INTO Tra_M_Grupo_Tramite_Detalle (iCodGrupoTramite,iCodTrabajador) VALUES ('$_POST[iCodGrupoTramite]' ,'$iCodTrabajador[$h]')  ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
}
header("Location: ../views/iu_grupo_tramite_detalle.php?cod=" . $_POST[iCodGrupoTramite]);
//echo $sql;
?>

