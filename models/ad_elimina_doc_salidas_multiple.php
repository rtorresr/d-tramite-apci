<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_grupo_remitentes_detalle.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Remitentes Detalle
  -> Eliminar Registro de Grupo de Remitentes Detalle
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
for ($h = 0; $h < count($_POST[iCodAuto]); $h++) {
    $iCodTramite = $_POST[iCodAuto];

    $sql = "DELETE FROM Tra_M_Doc_Salidas_Multiples WHERE iCodAuto = '" . $iCodAuto[$h] . "' ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
}
header("Location: ../views/iu_doc_salidas_multiple.php?cod=" . $_POST[cod]);
sqlsrv_close($cnx);
?>