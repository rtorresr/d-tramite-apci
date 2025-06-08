<?php

/* * ************************************************************************************
  NOMBRE DEL PROGRAMA: ad_elimina_grupo_oficina.php
  SISTEMA: SISTEMA INTEGRAL DE TR�MITE DOCUMENTARIO
  OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Oficinas
  -> Eliminar Registro de Grupo de Oficina
  PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL


  CONTROL DE VERSIONES:
  Ver      Autor             Fecha        Descripci�n
  ------------------------------------------------------------------------
  1.0   APCI       03/08/2018   Creaci�n del programa.

  ------------------------------------------------------------------------
 * *************************************************************************************** */
if ($op == 1) {
    $sql = "UPDATE Tra_M_Grupo_Oficina SET nFlgEstado=1 WHERE iCodGrupoOficina = " . $cod;
    $rs = sqlsrv_query($cnx,$sql, $cnx);
}
if ($op == 2) {
    $sql = "UPDATE Tra_M_Grupo_Oficina SET nFlgEstado=0 WHERE iCodGrupoOficina = " . $cod;
    $rs = sqlsrv_query($cnx,$sql, $cnx);
}
header("Location: ../views/iu_grupo_oficina.php");
sqlsrv_close($cnx);
?>