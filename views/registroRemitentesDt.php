<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
	include_once("../conexion/conexion.php");
	$fFecActual = date("Ymd")." ".date("H:i:s");
	$nNumAno = date("Y");
  switch ($_POST[opcion]) {
	case 1: // nuevo remitente
		$txtnom_remitente=strtoupper($_POST[txtnom_remitente]);
		$sql="INSERT INTO Tra_M_Remitente ";
		$sql.="(cTipoPersona,cNombre,cTipoDocIdentidad,nNumDocumento,cDireccion,cEmail,nTelefono,nFax,cDepartamento,cProvincia,cDistrito,cRepresentante,cFlag,cSiglaRemitente) ";
    $sql.=" VALUES ";
    $sql.="('$_POST[tipoRemitente]', '$txtnom_remitente', '$_POST[cTipoDocIdentidad]', '$_POST[txtnum_documento]', '$_POST[txtdirec_remitente]', '$_POST[txtmail]', '$_POST[txtfono_remitente]', '$_POST[txtfax_remitente]', '$_POST[cCodDepartamento]', '$_POST[cCodProvincia]', '$_POST[cCodDistrito]', '$_POST[txtrep_remitente]','$_POST[txtflg_estado]','$_POST[sigla]') ";
		$rs = sqlsrv_query($cnx,$sql);
		sqlsrv_close($cnx);
		
		$rsUltRem=sqlsrv_query($cnx,"SELECT TOP 1 iCodRemitente FROM Tra_M_Remitente ORDER BY iCodRemitente DESC");
		$RsUltRem=sqlsrv_fetch_array($rsUltRem);
		?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<meta http-equiv="content-type" content="text/html" />
<META NAME="language" CONTENT="ES">
<META content="1 days" name=REVISIT-AFTER>
<META content=ES name=language>
<META scheme=RFC1766 content=Spanish name=DC.Language>
<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function sendValue (s,t){
var selvalue1 = s.value;
var selvalue2 = t.value;
window.opener.document.getElementById('cNombreRemitente').value = selvalue1;
window.opener.document.getElementById('iCodRemitente').value = selvalue2;
window.opener.document.getElementById('Remitente').value = selvalue2;
window.close();
}
//  End -->
</script>
</head>
<body bgcolor="#ffffff">
	<table width="570"><tr>
	<td bgcolor="#ffffff">
			<br><br><br><br><br><br><br><br><br>
			<form name="selectform">
			<input name="iCodRemitente" value="<?=$RsUltRem[iCodRemitente]?>" type="hidden">
			<input name="cNombreRemitente" value="<?=strtoupper($_POST[txtnom_remitente])?>" type="hidden">
			 <span style="font-family:arial;font-size:12px">Los datos del nuevo remitente <br>han sido registrados satisfactoriamente.</span><br><br>
			<input type=button value="Continuar" class="btn btn-primary" style="font-size:10px" onClick="sendValue(this.form.cNombreRemitente,this.form.iCodRemitente,this.form.nNumDocumento);">
			</form>
			<br><br><br><br><br><br><br><br><br>&nbsp;
	</td>
	</tr>
	</table>
	
</body>
</html>
		<?
	break;		
	}
}else{
	header("Location: ../index-b.php?alter=5");
}

?>