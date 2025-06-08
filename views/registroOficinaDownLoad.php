<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registro de documentos con TUPA
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
date_default_timezone_set('America/Lima');
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
		if (!isset($_SESSION["cCodRef"])){ 
		$fecSesRef=date("Ymd-Gis");	
		$_SESSION['cCodRef']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesRef;
		}
		if (!isset($_SESSION["cCodOfi"])){ 
		$fecSesOfi=date("Ymd-Gis");	
		$_SESSION['cCodOfi']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesOfi;
		}	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

<script Language="JavaScript">
<!--
function activaDestino(){
	if (document.frmRegistro.nFlgEnvio.value==1){
			document.frmRegistro.nFlgEnvio.value="";
	} else {
			document.frmRegistro.nFlgEnvio.value=1;
	}
}
function activaDerivar(){
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>#area";
document.frmRegistro.submit();
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmRegistro.submit();
}

function Registrar()
{
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo de Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }

  document.frmRegistro.opcion.value=30;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

function activaOficina()
{
document.frmRegistro.radioMultiple.checked = false;
document.frmRegistro.radioOficina.checked = true;
document.frmRegistro.radioSeleccion.value="1";
muestra('areaOficina');
document.getElementById('areaMultiple').style.display = 'none';
return false;
}

function activaMultiple()
{
document.frmRegistro.radioMultiple.checked = true;
document.frmRegistro.radioOficina.checked = false;
document.frmRegistro.radioSeleccion.value="2";
muestra('areaMultiple');
document.getElementById('areaOficina').style.display = 'none';
return false;
}

function muestra(nombrediv) {
    if(document.getElementById(nombrediv).style.display == '') {
            document.getElementById(nombrediv).style.display = 'none';
    } else {
            document.getElementById(nombrediv).style.display = '';
    }
}

function AddOficina(){
	if (document.frmRegistro.iCodOficinaMov.value.length == "")
  {
    alert("Seleccione Oficina");
    document.frmRegistro.iCodOficinaMov.focus();
    return (false);
  }
	if (document.frmRegistro.iCodTrabajadorMov.value.length == "")
  {
    alert("Seleccione Trabajador");
    document.frmRegistro.iCodTrabajadorMov.focus();
    return (false);
  }
	if (document.frmRegistro.iCodIndicacionMov.value.length == "")
  {
    alert("Seleccione Indicación");
    document.frmRegistro.iCodIndicacionMov.focus();
    return (false);
  }  
  document.frmRegistro.opcion.value=14;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

var miPopup
	function Buscar(){
 miPopup=window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}
	
function AddReferencia(){
  document.frmRegistro.opcion.value=22;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>

	<?php include("includes/menu.php");?>

		<?
		include_once("../conexion/conexion.php");
		
		$cadena="SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'";
		$rs=sqlsrv_query($cnx,$cadena);
		//echo $rs;
		$Rs=sqlsrv_fetch_array($rs);
		?>
<a name="area"></a>
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

<div class="AreaTitulo">Actualizacion - Registro de interno oficina</div>
		<table class="table">
		<tr>
			<form name="frmRegistro" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
			<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
			<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
			<input type="hidden" name="iCodTrabajadorSolicitado" value="<?=$Rs[iCodTrabajadorSolicitado]?>">
            <input type="hidden" name="nFlgRpta" value="">
            <input type="hidden" name="fFecPlazo" value="">
			<?
			if($_POST[tipoRemitente]==1) $ValortipoRemitente=1;
			if($_POST[tipoRemitente]==2) $ValortipoRemitente=2;
			?>
			<input type="hidden" name="tipoRemitente" value="<?=$ValortipoRemitente?>">
			<input type="hidden" name="iCodRemitente" value="<?=$_POST[iCodRemitente]?>">
			<input type="hidden" name="cReferenciaOriginal" value="<?=trim($Rs[cReferencia])?>">
			<input type="hidden" name="radioSeleccion" value="">
		<td class="FondoFormRegistro">
			<table width="1030" border="0">
			<tr>
			<td valign="top"  width="200">N&ordm; Documento:</td>
			<td valign="top" colpsan="3" style="font-size:16px;color:#00468C"><b><?=$Rs[cCodificacion]?></b></td>
			</tr>
			
					
			<tr>
			<td valign="top"  width="200">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 And cCodTipoDoc!=45 ORDER BY cDescTipoDoc ASC";
          $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          	if($_GET[clear]==""){
          			if($RsTipo["cCodTipoDoc"]==$Rs[cCodTipoDoc]){
          				$selecTipo="selected";
          			}Else{
          				$selecTipo="";
          			}
          	}Else{
          			if($RsTipo["cCodTipoDoc"]==$_POST[cCodTipoDoc]){
          				$selecTipo="selected";
          			}Else{
          				$selecTipo="";
          			}          		
          	}
          echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          }
          sqlsrv_free_stmt($rsTipo);
					?>
				</select>&nbsp;<span class="FormCellRequisito">*</span>
			</td>
			<td  width="160">Fecha Registro:</td>
			<td style="padding-top:5px;">
			<td><input type="text" readonly name="fFecRegistro" value="<?php if($Rs['fFecRegistro']!=""){echo date("d-m-Y G:i", strtotime($Rs['fFecRegistro'])); } else {echo $_POST['fFecRegistro'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
				</tr></table>
            <? /*date("d-m-Y H:i", strtotime($Rs['fFecDocumento'])) */?></td>
			</tr>

			<tr>
			<td valign="top"  width="160">Asunto, Asunto:</td>
			<td>
						<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs['cAsunto']); }Else{ echo $_POST['cAsunto'];}?></textarea>&nbsp;<span class="FormCellRequisito"></span>
			</td>
			<td valign="top"  width="160">Observaciones:</td>
			<td valign="top">
				<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs[cObservaciones]); }Else{ echo $_POST[cObservaciones];}?></textarea>
			</td>
			</tr>
			<tr>
			<td valign="top"  width="200">Folios:</td>
			<td valign="top"><input type="text" name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($Rs[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>&nbsp;<span class="FormCellRequisito"></span></td>
			<td valign="top" >Referencia(s):</td>
			<td>
					<table><tr>
					<td align="center"><input type="hidden" readonly="readonly" name="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia]); }Else{ echo trim($_POST[cReferencia]);}?>" class="FormPropertReg form-control" style="width:140px;text-transform:uppercase" />
                    <input type="hidden" name="iCodTramiteRef"  value="<?=$_REQUEST[iCodTramiteRef]?>"  />
                    </td>
					<td align="center"></td>
					<td align="center"><div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="Buscar();">A�adir Referencias</a> </div></td>
					</tr></table>
					
					<table border=0><tr><td>
						<?
						$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$_GET[iCodTramite]'";
          	$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
						?>
						<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?><a href="registroData.php?&iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=20&iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="13" height="13"></a></span>&nbsp;
						<?php}?>
					 	
			</td>
			</tr>
			
			<tr>
				<td valign="top"  width="200">Adjuntar Archivo:</td>
				<td valign="top">
						<?
						$sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          	$rsDig=sqlsrv_query($cnx,$sqlDig);
          	if(sqlsrv_has_rows($rsDig)>0){
          			$RsDig=sqlsrv_fetch_array($rsDig);
          			if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
										echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
										echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=16&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
								}
          	}Else{
          			echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          	}
						?>
				</td>
				<td valign="top" >Sigla Autor:</td>
				<td><input type="text" style="width:60px;text-transform:uppercase" name="cSiglaAutor" value="<?php if($_GET[clear]==""){ echo $Rs[cSiglaAutor]; }Else{ echo $_POST[cSiglaAutor];}?>" class="FormPropertReg form-control"  /></td>
			</tr>
			
			<tr>
			<td valign="top" >Mantener Pendiente:</td>
		<!--	<td valign="top" colspan="3"> -->
					<?
					if($_GET[clear]==""){
							if($Rs[nFlgEnvio]==1){
								
									$marcarEnvio="checked disabled";
									
									//$marcarEnvio="checked";
							}
							else {
								if($_POST[nFlgEnvio]==0){
									$marcarEnvio="checked";
								}								}
					}Else{
							if($_POST[nFlgEnvio]==0){
									//$marcarEnvio="checked";
								//	$marcarEnvio="checked disabled";
							}
							else{
								$marcarEnvio="checked";
								}
					}
					?>
                
         	<?   /*    
					if($_GET[clear]==""){
							if($Rs[nFlgEnvio]==1){
									$marcarEnvio="checked";
							}
							}Else{
								//if($_POST[nFlgEnvio]==1){
									if($_POST[nFlgEnvio]==0){
									$marcarEnvio="checked";
								}
					}
				   /*  */ 	?>
                   
					<? /*if($Rs[nFlgEnvio]==0){?>
						<input type="checkbox" name="nFlgEnvio" value="0" checked disabled>
					<?php } else{?>
						<input type="checkbox" name="nFlgEnvio" value="1" <?=$marcarEnvio?>>
					<?php} */ ?>
                 <!--   &nbsp;<span class="FormCellRequisito">Necesario para Enviar a Oficina</span> -->
			<!-- </td>-->
            <td valign="top" colspan="3"><input type="checkbox" name="nFlgEnvio" value="1" onclick="activaDestino();" <?=$marcarEnvio?>></td>
			</tr>

			<tr>
			<td valign="top" >Destino:</td>
			<td colspan="3" align="left">
				
					<table border=0><tr>
          <td valign="top"><input type="radio" name="radioOficina" onclick="activaOficina();" <?php if($_POST[radioSeleccion]==1) echo "checked"?> onChange="releer();">Un Destino</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td valign="top"><input type="radio" name="radioMultiple" onclick="activaMultiple();" <?php if($_POST[radioSeleccion]==2) echo "checked"?> onChange="releer();">M�ltiple</td>
					</tr></table>
				
					<div style="display:none" id="areaOficina">				
					<table border=0>
					<tr>
					<td>
							<select name="iCodOficinaMov" style="width:260px;" class="FormPropertReg form-control" onChange="releer();">
							<option value="">Seleccione Oficina:</option>
							<?
							$sqlDep2="SP_OFICINA_LISTA_COMBO";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
              	if($RsDep2['iCodOficina']==$_POST[iCodOficinaMov]){
              		$selecOfi="selected";
              	}Else{
              		$selecOfi="";
              	}
                echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
              }
              mysql_free_result($rsDep2);
							?>
							</select>
					</td>
					<td>
							<select name="iCodTrabajadorMov" style="width:200px;" class="FormPropertReg form-control">
							<?php if($_POST[iCodOficinaMov]==""){?>
							<option value="">Seleccione Trabajador:</option>
							<?php}?>
							<?
							$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$_POST[iCodOficinaMov]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
              $rsTrb=sqlsrv_query($cnx,$sqlTrb);
              while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorMov]){
              		$selecTrab="selected";
              	}Else{
              		$selecTrab="";
              	}
                echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
              }
              sqlsrv_free_stmt($rsTrb);
							?>
							</select>
					</td>
					<td>
							<select name="iCodIndicacionMov" style="width:180px;" class="FormPropertReg form-control">
							<option value="">Seleccione Indicación:</option>
							<?
							$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
              $sqlIndic .= "ORDER BY cIndicacion ASC";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
              	if($RsIndic[iCodIndicacion]==$_POST[iCodIndicacionMov]){
              		$selecIndi="selected";
              	}Else{
              		$selecIndi="";
              	}              	
                echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
              }
              sqlsrv_free_stmt($rsIndic);
							?>
							</select>
					</td>
					<td>
							<select name="cPrioridadMov" class="size9" style="width:100;background-color:#FBF9F4">
              <option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
              <option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
              <option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
              </select>
					</td>
					<td>
							<input name="button" type="button" class="btn btn-primary" value="A�adir" onclick="AddOficina();">
					</td>
					</tr>
					</table>
					</div>
					
					<div style="display:none" id="areaMultiple">
							<table><tr>
							<td align="center"><div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="registroOficinaEditLs.php?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&iCodTrabajadorSolicitado=<?=$_POST[iCodTrabajadorSolicitado]?>&cReferencia=<?=$_POST[cReferencia]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nFlgRpta=<?=$_POST[nFlgRpta]?>&nNumFolio=<?=$_POST[nNumFolio]?>&fFecPlazo=<?=$_POST[fFecPlazo]?>" rel="lyteframe" title="Lista de Oficinas" rev="width: 500px; height: 550px; scrolling: auto; border:no">Seleccionar Oficinas</a> </div></td>
							</tr></table>
					</div>					

				<?php if($_POST[radioSeleccion]==1){?>
					 <script language="javascript" type="text/javascript">
					 	activaOficina();
					 </script>
				<?php}?>
				<?php if($_POST[radioSeleccion]==2){?>
					 <script language="javascript" type="text/javascript">
					 	activaMultiple();
					 </script>
				<?php}?>
					
			</td>
			</tr>

			<tr>
			<td colspan="4" align="left">
					
					<table border=1 width="100%">
					<tr>
					<td class="headColumnas" width="300">Oficina</td>
					<td class="headColumnas" width="300">Trabajador</td>
					<td class="headColumnas" width="140">Indicación</td>
					<td class="headColumnas" width="100">Prioridad</td>
                    <td class="headColumnas" width="100">Copia</td>
					<td class="headColumnas" width="60">Opción</td>
					</tr>
					<?
					$sqlMovs="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]' AND cFlgOficina=1 ORDER BY iCodMovimiento ASC";
          $rsMovs=sqlsrv_query($cnx,$sqlMovs);
          $ContarMov=1;
          while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
					?>
					<tr <?php if($ContarMov>1) echo "bgcolor=#FFE8E8"?>>
					<td align="left">
					<?
					$sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs[iCodOficinaDerivar]'";
          $rsOfc=sqlsrv_query($cnx,$sqlOfc);
          $RsOfc=sqlsrv_fetch_array($rsOfc);
          echo $RsOfc["cNomOficina"];
					?>
					</td>
					<td align="left">
						<?
						$sqlTra="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMovs[iCodTrabajadorDerivar]' ";
            $rsTra=sqlsrv_query($cnx,$sqlTra);
						$RsTra=sqlsrv_fetch_array($rsTra);
            echo $RsTra["cNombresTrabajador"]." ".$RsTra["cApellidosTrabajador"];
						?>
					</td>
					<td align="left">
						<?
						$sqlInd="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsMovs[iCodIndicacionDerivar]'";
            $rsInd=sqlsrv_query($cnx,$sqlInd);
            $RsInd=sqlsrv_fetch_array($rsInd);
            echo $RsInd["cIndicacion"];
						?>
					</td>
					<td align="left">
						<?=$RsMovs[cPrioridadDerivar]?>
					</td>
                    <td>
                     <input type="checkbox" 	name="Copia[]"  value="<?=$RsMovs[iCodMovimiento]?>" <?php if($RsMovs[cFlgTipoMovimiento]==4){echo "checked";}?>/>
                    </td>
					<td align="center">
						<a href="registroData.php?iCodMovimiento=<?=$RsMovs[iCodMovimiento]?>&iCodTramite=<?=$_GET[iCodTramite]?>&opcion=7&cCodTipoDoc=<?php if($_GET[clear]==""){ echo $Rs[cCodTipoDoc]; }Else{ echo $_POST[cCodTipoDoc];}?>&iCodTrabajadorSolicitado=<?php if($_GET[clear]==""){ echo $Rs[iCodTrabajadorSolicitado]; }Else{ echo $_POST[iCodTrabajadorSolicitado]; }?>&cReferencia=<?php if($_GET[clear]==""){ echo $Rs[cReferencia]; }Else{ echo $_POST[cReferencia];}?>&cAsunto=<?php if($_GET[clear]==""){ echo $Rs['cAsunto']; }Else{ echo $_POST['cAsunto']; }?>&cObservaciones=<?php if($_GET[clear]==""){ echo $Rs[cObservaciones]; }Else{ echo $_POST[cObservaciones]; }?>&iCodIndicacion=<?php if($_GET[clear]==""){ echo $Rs[iCodIndicacion]; }Else{ echo $_POST[iCodIndicacion];}?>&nFlgRpta=<?php if($_GET[clear]==""){ echo $Rs[nFlgRpta]; }Else{ echo $_POST[nFlgRpta];}?>&nNumFolio=<?php if($_GET[clear]==""){ echo $Rs[nNumFolio]; }Else{ echo $_POST[nNumFolio];}?>&fFecPlazo=<?php if($_GET[clear]==""){ echo $Rs[fFecPlazo]; }Else{ echo $_POST[fFecPlazo]; }?>&nFlgEnvio=<?php if($_GET[clear]==""){ echo $Rs[nFlgEnvio]; }Else{ echo $_POST[nFlgEnvio]; }?>&URI=<?=$_GET[URI]?>"><img src="images/icon_del.png" border="0" width="16" height="16"></a>
					</td>
					</tr>
					<?
					$ContarMov++;
          }
					?>
					</table>
					
			</td>
			</tr>	

			
			<tr>
			<td colspan="4">
					<input name="button" type="button" class="btn btn-primary" value="Actualizar" onclick="Registrar();">
					<input type="button" class="btn btn-primary" value="Cancelar" name="inicio" onClick="window.open('<?=$_GET[URI]?>', '_self');">
			</td>
			</tr>
			</table>
			

		</form>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>