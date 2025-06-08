<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: buscarTramiteEdit.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Buscar el tipo de Documento
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   Larry Ortiz       24/01/2011    Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/

session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
   	$sqlBusq="SELECT nFlgTipoDoc,iCodTramite  FROM Tra_M_Tramite WHERE iCodTramite=".$_POST[iCodTramite];
	$rsBusq=sqlsrv_query($cnx,$sqlBusq);
	$RsBusq=sqlsrv_fetch_array($rsBusq);
	switch ($RsBusq[nFlgTipoDoc]){
  				case 1: $ScriptPHP="registroTramiteEdit_Entrada.php"; break;
  				case 2: $ScriptPHP="registroTramiteEdit_Interno.php"; break;
  				case 3: $ScriptPHP="registroTramiteEdit_Salida.php"; break;
				case 4: $ScriptPHP="registroTramiteEdit_Anexo.php"; break;
  	}
		echo "<html>";
		echo "<head>";
		echo "</head>";
		echo "<body OnLoad=\"document.form_envio.submit();\">";
		echo "<form method=POST name=form_envio action=$ScriptPHP>";
		echo "<input type=hidden name=iCodTramite value=\"".$RsBusq[iCodTramite]."\">";
		echo "</form>";
		echo "</body>";
		echo "</html>";
}else{
   header("Location: ../index-b.php?alter=5");
}
?>
