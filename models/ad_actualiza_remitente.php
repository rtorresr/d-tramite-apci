<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_actualiza_remitente.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Remitentes
  -> Actualizar Registro de Remitente
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
/* $sql= "update Tra_M_Remitente SET  cTipoPersona='$_POST[tipo_persona]',cNombre='$_POST[txtnom_remitente]',cTipoDocIdentidad='$_POST[cTipoDocIdentidad]',nNumDocumento='$_POST[txtnum_documento]',cDireccion='$_POST[txtdirec_remitente]',
  cEmail='$_POST[txtmail]',nTelefono='$_POST[txtfono_remitente]',nFax='$_POST[txtfax_remitente]',cDepartamento='$_POST[cCodDepartamento]',cProvincia='$_POST[cCodProvincia]',cDistrito='$_POST[cCodDistrito]',cRepresentante='$_POST[txtrep_remitente]',cFlag='$_POST[txtflg_estado]' where iCodRemitente='$_POST[iCodRemitente]'"; */
$sql = "SP_REMITENTE_UPDATE '$_POST[tipo_persona]', '$_POST[txtnom_remitente]','$_POST[cTipoDocIdentidad]','$_POST[txtnum_documento]','$_POST[cDireccion]',
'$_POST[txtmail]','$_POST[txtfono_remitente]','$_POST[txtfax_remitente]','$_POST[cCodDepartamento]','$_POST[cCodProvincia]','$_POST[cCodDistrito]','$_POST[txtrep_remitente]',
'$_POST[txtflg_estado]','$_POST[cSiglaRemitente]' ,'$_POST[iCodRemitente]'  ";
$rs = sqlsrv_query($cnx,$sql, $cnx);
sqlsrv_close($cnx);
header("Location:../views/iu_remitentes.php");
?>