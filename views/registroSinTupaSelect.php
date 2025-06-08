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
echo "<form method=POST name=form_envio action=registroSinTupa.php#area>";
echo "<input type=hidden name=tipoRemitente value=\"".$_GET[tipoRemitente]."\">";
echo "<input type=hidden name=iCodRemitente value=\"".$_GET[iCodRemitente]."\">";
echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
echo "<input type=hidden name=fFecDocumento value=\"".$_GET['fFecDocumento']."\">";
echo "<input type=hidden name=cNroDocumento value=\"".$_GET['cNroDocumento']."\">";
echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
echo "<input type=hidden name=iCodTupaClase value=\"".$_GET[iCodTupaClase]."\">";
echo "<input type=hidden name=iCodTupa value=\"".$_GET['iCodTupa']."\">";
echo "<input type=hidden name=cReferencia value=\"".$_GET[cReferencia]."\">";
echo "<input type=hidden name=iCodOficinaResponsable value=\"".$_GET[iCodOficinaResponsable]."\">";
echo "<input type=hidden name=iCodTrabajadorResponsable value=\"".(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')."\">";
echo "<input type=hidden name=nNumFolio value=\"".$_GET[nNumFolio]."\">";
echo "<input type=hidden name=iCodIndicacion value=\"".$_GET[iCodIndicacion]."\">";
echo "<input type=hidden name=nFlgEnvio value=\"".$_GET[nFlgEnvio]."\">";
echo "<input type=hidden name=cNomRemite value=\"".$_GET[cNomRemite]."\">";
echo "</form>";
echo "</body>";
echo "</html>";
?>