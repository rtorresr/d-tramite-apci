<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Seleccion remitente
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function sendValue (s){
var selvalue = s.value;
window.opener.document.getElementById('cReferencia').value = selvalue;
window.close();
}
//  End -->
</script>
</head>
<body>
 
<table width="440" height="300" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
<tr>
<td align="left" valign="top">

<!--Main layout-->
 <main class="mx-lg-5">
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-md-12 mb-12">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

<div class="AreaTitulo">
	Seleccione Oficina:
</div>	
		<table width="100%" border="1" cellpadding="0" cellspacing="3">
			<form method="POST" name="formulario" action="registroDataEdicion.php" target="_parent">
			<input name="radioSeleccion" value="2" type="hidden">
			<input name="opcion" value="20" type="hidden">
			<input name="iCodTramite" value="<?=$_GET[iCodTramite]?>" type="hidden">
			<input name="nFlgTipoDoc" value="<?=(isset($_GET['nFlgTipoDoc'])?$_GET['nFlgTipoDoc']:'')?>" type="hidden">
            <input name="iCodTrabajadorRegistro" value="<?=$_GET[iCodTrabajadorRegistro]?>" type="hidden">
            <input name="iCodOficinaRegistro" value="<?=$_GET[iCodOficinaRegistro]?>" type="hidden">
            <input name="iCodTrabajadorSolicitado" value="<?=$_GET[iCodTrabajadorSolicitado]?>" type="hidden">
            <input name="fFecDocumento" value="<?=$_GET['fFecDocumento']?>" type="hidden">
            <input name="fFecRegistro" value="<?=$_GET['fFecRegistro']?>" type="hidden">
			<input name="cCodTipoDoc" value="<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>" type="hidden">
			<input name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" type="hidden">
            <input name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" type="hidden">
			<input name="cObservaciones" value="<?=$_GET[cObservaciones]?>" type="hidden">
            <input name="nNumFolio" value="<?=$_GET[nNumFolio]?>" type="hidden">
			<input name="cReferencia" value="<?=$_GET[cReferencia]?>" type="hidden">
			<input name="iCodTramiteRef" value="<?=$_GET[iCodTramiteRef]?>" type="hidden">
            <input name="cSiglaAutor" value="<?=$_GET[cSiglaAutor]?>" type="hidden">
            <input name="nFlgEnvio" value="<?=$_GET[nFlgEnvio]?>" type="hidden">
			<input name="nFlgRpta" value="<?=$_GET[nFlgRpta]?>" type="hidden">			
			<input name="fFecPlazo" value="<?=$_GET[fFecPlazo]?>" type="hidden">
            <input name="URI" value="<?=$_GET[URI]?>" type="hidden">
           
		<tr>
			<td align="center"    width="360">OFICINA</td>
			<td align="center"    width="80">OPCION</td>
		</tr>
		<?
		include_once("../conexion/conexion.php");
		$sqlOfic="SELECT * FROM Tra_M_Oficinas WHERE iFlgEstado=1 ORDER BY cNomOficina ASC";
    $rsOfic=sqlsrv_query($cnx,$sqlOfic);
    while ($RsOfic=sqlsrv_fetch_array($rsOfic)){
    if ($color == "#e8f3ff"){
			$color = "#FFFFFF";
	  }else{
			$color = "#e8f3ff";
	  }
	  if ($color == ""){
			$color = "#FFFFFF";
	  }
		?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF';" onMouseOut="this.style.backgroundColor='<?=$color?>'">
    <td align=left><?=$RsOfic[cNomOficina]?></td>
		<td align="center">
				<?
				$sqlAct="SELECT * FROM Tra_M_Tramite_Temporal WHERE iCodOficina='$RsOfic['iCodOficina']' AND cCodSession='$_SESSION[cCodSession]'";
    		$rsAct=sqlsrv_query($cnx,$sqlAct);
    		if(sqlsrv_has_rows($rsAct)<1){
				?>
				<input type="checkbox" name="lstOficinasSel[]" value="<?=$RsOfic['iCodOficina']?>">
				<?php } else{?>
				<input type="checkbox" name="none" disabled>
				<?php}?>
		</td>
    </tr>
    <?
    }
    sqlsrv_free_stmt($rsOfic);
		?>
		<tr>
			<td>
					<select name="iCodIndicacion" style="width:220px;" class="FormPropertReg form-control">
					<option value="">Seleccione Indicación:</option>
					<?
					$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
      		$sqlIndic .= "ORDER BY cIndicacion ASC";
      		$rsIndic=sqlsrv_query($cnx,$sqlIndic);
      		while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
      			if($RsIndic[iCodIndicacion]==3){
      				$selecIndi="selected";
      			}Else{
      				$selecIndi="";
      			}              	
      		  echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>\n";
      		}
      		sqlsrv_free_stmt($rsIndic);
					?>
					</select>
					
					<select name="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
          <option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
          <option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
          <option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
          </select>				
			</td>
			<td align="center">
				<input type="submit" value="Enviar" class="btn btn-primary">
			</td>
		</tr>
		</form>
		</table>
<div>		
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