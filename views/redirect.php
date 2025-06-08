<?php 
unset($_SESSION["cCodRef"]);
unset($_SESSION["cCodOfi"]);
$fFecActual=date("d-m-Y G:i"); 
echo "<html>";
echo "<head>";
echo "</head>";
echo "<body OnLoad=\"document.form_envio.submit();\">";
echo "<form method=POST name=form_envio action=registroInternoObs.php>";
echo "<input type=hidden name=iCodTramite value=\"".$RsUltTra[iCodTramite]."\">";
echo "<input type=hidden name=fFecActual value=\"".$fFecActual."\">";
echo "<input type=hidden name=cCodificacion value=\"".$cCodificacion."\">";
echo "<input type=hidden name=cDescTipoDoc value=\"".trim($RsTipDoc['cDescTipoDoc'])."\">";
echo "<input type=hidden name=nFlgClaseDoc value=1>";
echo "</form>";
echo "</body>";
echo "</html>";