<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<?php include("includes/head.php");?>
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
			<form method="POST" name="formulario" action="registroData.php" target="_parent">
			<input name="radioSeleccion" id="radioSeleccion" value="2" type="hidden">
			<input name="opcion" value="20" type="hidden">
			<input name="iCodTramite" id="iCodTramite" value="<?=$_GET[iCodTramite]?>" type="hidden">
			<input name="URI" value="<?=$_GET[URI]?>" type="hidden">
			<input name="cCodTipoDoc" id="cCodTipoDoc" value="<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>" type="hidden">
			<input name="iCodTrabajadorSolicitado" id="iCodTrabajadorSolicitado" value="<?=$_GET[iCodTrabajadorSolicitado]?>" type="hidden">
			<input name="cReferencia" id="cReferencia" value="<?=$_GET[cReferencia]?>" type="hidden">
			<input name="cAsunto" id="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" type="hidden">
			<input name="cObservaciones" id="cObservaciones"  value="<?=$_GET[cObservaciones]?>" type="hidden">
			<input name="nFlgRpta" id="nFlgRpta" value="<?=$_GET[nFlgRpta]?>" type="hidden">
			<input name="nNumFolio" id="nNumFolio" value="<?=$_GET[nNumFolio]?>" type="hidden">
			<input name="fFecPlazo" id="fFecPlazo" value="<?=$_GET[fFecPlazo]?>" type="hidden">
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
					<select name="iCodIndicacion" id="iCodIndicacion" style="width:220px;" class="FormPropertReg form-control">
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
					
					<select name="cPrioridad" id="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
          <option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
          <option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
          <option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
          </select>				
			</td>
			<td align="center">
				<input type="submit" value="Enviar" class="btn btn-primary" onclick="enviarVariasOficinasMovimientoTemporal()">
			</td>
		</tr>
		</form>
		</table>
<div>		
</td>
</tr>

</table>
<script language="JavaScript">
	function enviarVariasOficinasMovimientoTemporal() {
        var parameters = {
        	iCodTramite: window.opener.document.getElementById('iCodTramite').value,
        	iCodIndicacion: $("#iCodIndicacion").val(),
        	cPrioridad: $("#cPrioridad").val(),
        	cAsunto: $("#cAsunto").val(),
        	cObservaciones: $("#cObservaciones").val(),
            'lstOficinasSel[]' : []
        }

        $("input[name='lstOficinasSel[]']:checked").each(function() {
		   parameters['lstOficinasSel[]'].push($(this).val());
		});
        
		window.opener.insertarVariasOficinasMovimientoTemporal(parameters); 
		window.opener.focus() ;
		window.close();
    }
</script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>