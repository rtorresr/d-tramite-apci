<?
echo "<html>";
echo "<head>";
echo "</head>";
echo "<body OnLoad=\"document.form_envio.submit();\">";
echo "<form method=POST name=form_envio action=registroExterno.php>";
echo "<input type=hidden name=tipoRemitente value=\"".$_GET[tipoRemitente]."\">";
echo "<input type=hidden name=iCodRemitente value=\"".$_GET[iCodRemitente]."\">";
echo "<input type=hidden name=cAsunto value=\"".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."\">";
echo "<input type=hidden name=cObservaciones value=\"".$_GET[cObservaciones]."\">";
echo "<input type=hidden name=nFlgDerivar value=\"".$_GET[nFlgDerivar]."\">";
echo "</form>";
echo "</body>";
echo "</html>";
?>