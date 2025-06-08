<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script Language="JavaScript">
<!--
function Registrar(){
  if (document.frmRegistro.iCodTema.value.length == "")
  {
    alert("Seleccione un tema");
    document.frmRegistro.iCodTema.focus();
    return (false);
  }
  document.frmRegistro.submit();
}
//--></script>
</head>
<body>
<table width="400" height="350"  cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff" align="center" >
<tr>
<td  align="left" valign="top">

<div class="AreaTitulo">Relacionar Tema</div>
		<table width="351" border="0" cellpadding="0" cellspacing="3" align="center">
		  <form method="POST" name="frmRegistro" action="registroTema.php" target="_parent">
			<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
		<tr><td colspan="2">&nbsp;</td>
		<tr>
			<td width="230" align="right">Seleccione Tema:</td>
			<td width="112">
            <select name="iCodTema" class="FormPropertReg form-control" style="width:180px" />
			<option value="">Seleccione:</option>
		<?
			include_once("../conexion/conexion.php");
			$sqlOfi="SP_TEMA_LISTA_COMBO_AR ".$_GET[iCodOficinaRegistro];
            $rsOfi=sqlsrv_query($cnx,$sqlOfi);
          	while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
            if($RsOfi["iCodTema"]==$_GET['iCodTema']){
          	$selecTipo="selected";
            }Else{
          	$selecTipo="";
            }
          	echo "<option value=".$RsOfi["iCodTema"]." ".$selecTipo.">".$RsOfi["cDesTema"]."</option>";
          	}
          	sqlsrv_free_stmt($rsOfi);
		?>
			</select>
            </td>
		</tr>
    <tr>
			<td height="37" colspan="2"> 
			  <input name="button" type="button" class="btn btn-primary" value="Continuar" onclick="Registrar();">
	
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>