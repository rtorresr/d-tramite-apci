<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Redireccion para seleccion de remitentes
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
echo "<html>";
echo "<head>";
echo "</head>";
echo "<body OnLoad=\"document.form_envio.submit();\">";
if($_GET[nFlgClaseDoc]==1){
		if($_GET[nFlgRegistro]==1){
			echo "<form method=POST name=form_envio action=registroSalida.php#area>";
		}
		if($_GET[nFlgRegistro]==2){
			echo "<form method=POST name=form_envio action=registroSalidaEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."&clear=1#area>";
		}
}
if($_GET[nFlgClaseDoc]==2){
		if($_GET[nFlgRegistro]==1){
			echo "<form method=POST name=form_envio action=registroEspecial.php#area>";
		}
		if($_GET[nFlgRegistro]==2){
			echo "<form method=POST name=form_envio action=registroEspecialEdit.php?iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."&clear=1#area>";
		}
}
echo "<input type=hidden name=tipoRemitente value=\"".$_GET[tipoRemitente]."\">";
echo "<input type=hidden name=iCodRemitente value=\"".$_GET[iCodRemitente]."\">";
echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
echo "<input type=hidden name=fFecDocumento value=\"".$_GET['fFecDocumento']."\">";
echo "<input type=hidden name=iCodTrabajadorSolicitado value=\"".$_GET[iCodTrabajadorSolicitado]."\">";
echo "<input type=hidden name=iCodOficinaSolicitado value=\"".$_GET[iCodOficinaSolicitado]."\">";
echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">";
echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
echo "<input type=hidden name=iCodIndicacion value=\"".$_GET[iCodIndicacion]."\">";
echo "<input type=hidden name=nFlgRpta value=\"".$_GET[nFlgRpta]."\">";
echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
echo "<input type=hidden name=fFecPlazo value=\"".$_GET[fFecPlazo]."\">";
echo "<input type=hidden name=cSiglaAutor value=\"".$_GET[cSiglaAutor]."\">";
echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_GET[iCodOficinaResponsable]."\">";
echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";

echo "</form>";
echo "</body>";
echo "</html>";
?>