<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_tupa.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Tupa
  -> Actualizar Registro de Tupa
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
/* $sql= "update Tra_M_Tupa SET iCodTupaClase='$_POST[iCodTupaClase]',cNomTupa='$_POST[txtdesc_tupa]',nSilencio='$_POST[txtsilencio]' ,nDias='$_POST[txtdia_tupa]',iCodOficina='$_POST['iCodOficina']',nEstado='$_POST[txtestado]'       where iCodTupa='$_POST[txtcod_tupa]'"; */
$sql = "SP_TUPA_UPDATE '$_POST[iCodTupaClase]','$_POST[txtdesc_tupa]','$_POST[txtsilencio]' ,'$_POST[txtdia_tupa]','$_POST['iCodOficina']','$_POST[txtestado]' ,'$_POST[txtcod_tupa]' ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
header("Location: ../views/iu_tupa.php?iCodTupaClase=" . $_REQUEST[iCodTupaClasex] . "&cNomTupa=" . $_REQUEST[cNomTupax] . "&txtestado=" . $_REQUEST[txtestadox] . "&pag=" . $_REQUEST[pagx]);
?>
