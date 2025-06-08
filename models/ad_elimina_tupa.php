<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_tupa.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Tupa
  -> Eliminar Registro de Tupa
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL
  

  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
$sql = " SP_TUPA_DELETE " . $_GET['id'];
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
// art header("Location:../views/iu_tupa.php?iCodTupaClase=" . $iCodTupaClase . "&cNomTupa=" . $cNomTupa . "&txtestado=" . $txtestado . "&pag=" . $pag);
header("Location:../views/iu_tupa.php?iCodTupaClase=" . $_GET['iCodTupaClase'] . "&cNomTupa=" . $_GET['cNomTupa'] . "&txtestado=" . $_GET['txtestado'] . "&pag=" . $_GET['pag']);
?>