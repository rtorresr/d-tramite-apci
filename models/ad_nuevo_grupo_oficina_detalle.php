<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_nuevo_grupo_oficina_detalle.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Oficina Detalle
  -> Crear Registro de Oficina Detalle
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
for ($h = 0; $h < count($_POST['iCodOficina']); $h++) {
    $iCodOficina = $_POST['iCodOficina'];
    $sql = "INSERT INTO Tra_M_Grupo_Oficina_Detalle (iCodGrupoOficina,iCodOficina,nFlgEstado) VALUES ('$_POST[iCodGrupoOficina]' ,'$iCodOficina[$h]',1)  ";
    $rs = sqlsrv_query($cnx,$sql, $cnx);
}
header("Location: ../views/iu_grupo_oficina_detalle.php?cod=" . $_POST[iCodGrupoOficina]);
//echo $sql;
?>

