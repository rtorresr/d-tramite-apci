<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: ad_elimina_grupo_remitentes_detalle.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Procesamiento de Informaci�n de la Tabla Maestra de Grupo de Remitentes Detalle
          -> Eliminar Registro de Grupo de Remitentes Detalle
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creaci�n del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
$sql= "DELETE FROM Tra_M_Grupo_Remitente_Detalle WHERE iCodRemitente = '".$id."' AND iCodGrupo = '".$iCodGrupo."' " ;
$rs=sqlsrv_query($cnx,$sql);
header("Location: ../views/iu_grupo_remitentes_detalle.php?cod=".$iCodGrupo);
sqlsrv_close($cnx);
?>