<?
echo "<html>";
echo "<head>";
echo "</head>";
echo "<body OnLoad=\"document.form_envio.submit();\">";
echo "<form method=POST name=form_envio action=registroExpediente.php>";
echo "<input type=hidden name=tipoRemitente value=\"".$_GET[tipoRemitente]."\">";
echo "<input type=hidden name=iCodRemitente value=\"".$_GET[iCodRemitente]."\">";
echo "<input type=hidden name=iCodTupaClase value=\"".$_GET[iCodTupaClase]."\">";
echo "<input type=hidden name=iCodTupa value=\"".$_GET['iCodTupa']."\">";
echo "<input type=hidden name=cCodTipoDoc value=\"".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."\">";
echo "<input type=hidden name=nFolios value=\"".$_GET[nFolios]."\">";
echo "<input type=hidden name=nIndicativo value=\"".$_GET[nIndicativo]."\">";
echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
echo "<input type=hidden name=nFlgDerivar value=\"".$_GET[nFlgDerivar]."\">";
echo "</form>";
echo "</body>";
echo "</html>";
?>