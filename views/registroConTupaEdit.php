<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
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
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmRegistro.submit();
}

function seleccionar_todo(){
	for (i=0;i<document.frmRegistro.elements.length;i++)
		if(document.frmRegistro.elements[i].type == "checkbox")	
			document.frmRegistro.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.frmRegistro.elements.length;i++)
		if(document.frmRegistro.elements[i].type == "checkbox")	
			document.frmRegistro.elements[i].checked=0
}

function Registrar()
{
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo de Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  if (document.frmRegistro.cNroDocumento.value.length == "")
  {
    alert("Ingrese N�mero del Documento");
    document.frmRegistro.cNroDocumento.focus();
    return (false);
  }
   if (document.frmRegistro.iCodTupaClase.value.length == "")
  {
    alert("Seleccione una Clase de Procedimiento TUPA");
    return (false);
  }
   if (document.frmRegistro.iCodTupa.value.length == "")
  {
    alert("Seleccione un Procedimiento TUPA");
    return (false);
  }
  if (document.frmRegistro.nFlgEnvio.value==1)
  {
  		if (document.frmRegistro.iCodOficinaResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Oficina");
  		  document.frmRegistro.iCodOficinaResponsable.focus();
  		  return (false);
  		}
  		if (document.frmRegistro.iCodTrabajadorResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Responsable");
  		  document.frmRegistro.iCodTrabajadorResponsable.focus();
  		  return (false);
  		}
	}
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

	<?php
		include_once("../conexion/conexion.php");
		$rs = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs = sqlsrv_fetch_array($rs);
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

<div class="AreaTitulo">Actualizacion - Registro de entrada con tupa</div>
		<table class="table">
		<tr>
			<form name="frmRegistro" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="8">
			<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
			<input type="hidden" name="tupa" value="1">
			<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
			<input type="hidden" name="nFlgEnvio" value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
		<td class="FondoFormRegistro">
			<table width="1030" border="0">
			<tr>
			<td valign="top"  width="300">Tramite:</td>
			<td valign="top" colpsan="3" style="font-size:16px;color:#00468C"><b><?=$Rs[cCodificacion]?></b></td>
			</tr>
			
					
			<tr>
			<td valign="top"  width="300">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
          $sqlTipo.="ORDER BY cDescTipoDoc ASC";
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
     	<td>
				<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>
				<input type="text" readonly name="fFecRegistro" value="<?php if($Rs['fFecRegistro']!=""){echo date("d-m-Y G:i", strtotime($Rs['fFecRegistro'])); } else {echo $_POST['fFecRegistro'];}?>" style="width:105px" class="FormPropertReg form-control" >
			</td>
			<td>
				<div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span>
				</div>
			</td>
		</tr>
	</table>
</td>
			<? /*<td style="padding-top:5px;"><b><?=date("d-m-Y H:i", strtotime($Rs['fFecDocumento']))?></td> */?>
			</tr>
			<tr>
				<td  valign="top">Fecha del Documento:</td>
				<td>
					<input type="text" name="fechaDocumento" value="<?php echo $Rs['FECHA_DOCUMENTO']; ?>" style="width:120px" 
								 class="FormPropertReg form-control" readonly>
					<div class="boton" style="width:24px;height:20px;display:inline">
						<a href="javascript:;" onclick="displayCalendar(document.forms[0].fechaDocumento,'dd-mm-yyyy hh:ii',this,true)">
							<img src="images/icon_calendar.png" width="22" height="20" border="0">
						</a>
					</div>
				</td>
			</tr>

			<tr>
			<td valign="top"  width="300">N&ordm; del Documento:</td>
			<td valign="top" colspan="3"><input type="text" name="cNroDocumento" style="text-transform:uppercase" value="<?php if($_GET[clear]==""){ echo trim($Rs['cNroDocumento']); }Else{ echo stripslashes((isset($_POST['cNroDocumento']))?$_POST['cNroDocumento']:'');}?>" class="FormPropertReg form-control" style="width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
			</tr>

					<?
					$sqlRmt = "SELECT * FROM Tra_M_Remitente WHERE iCodRemitente=$Rs[iCodRemitente]";
          			$rsRmt = sqlsrv_query($cnx,$sqlRmt);
          			$RsRmt = sqlsrv_fetch_array($rsRmt);
					?>
			<tr>
			<td valign="top" >Remitente / Institución:</td>
			<td valign="top" colspan="3">
					<table cellpadding="0" cellspacing="2" border="0">
					<tr>
					
					<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?php if($_GET[clear]==""){ echo trim($RsRmt['cNombre']); }Else{ echo $_POST[cNombreRemitente];}?>" style="width:380px" readonly></td>
					<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
					<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a> </div></td>
					<td>
                    &nbsp;<span class="FormCellRequisito">*</span>
                    </td>
                    </tr>
					</table>
					<input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?php if($_GET[clear]==""){ echo $Rs[iCodRemitente]; }Else{ echo $_POST[iCodRemitente];}?>">
                    <input id="Remitente" name="Remitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
			</td>
			</tr>
			
			
			
			<tr>
			<td valign="top"  width="200">Remite:</td>
			<td valign="top" colspan="3"><input type="text" name="cNomRemite" style="text-transform:uppercase;width:250px;" value="<?php if($_GET[clear]==""){ echo trim($Rs[cNomRemite]); }Else{ echo $_POST[cNomRemite];}?>" class="FormPropertReg form-control" style="width:450px" />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>
			
			
			<tr>
			<td valign="top" >Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs['cAsunto']); }Else{ echo stripslashes($_POST['cAsunto']);}?></textarea>
					&nbsp;&nbsp;
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs[cObservaciones]); }Else{ echo stripslashes($_POST[cObservaciones]);}?></textarea>
			</td>
			</tr>				

			<tr>
			<td valign="top"  width="300">Clase de Procedimiento:</td>
			<td valign="top" colspan="3">
					<select name="iCodTupaClase" class="FormPropertReg form-control" style="width:110px" onChange="releer();" />
					<?
					if($Rs[nFlgEnvio]==1){
						$sqlClas="SELECT * FROM Tra_M_Tupa_Clase WHERE iCodTupaClase='$Rs[iCodTupaClase]'";
					}Else{
						echo "<option value=\"\">Seleccione:</option>";
						$sqlClas="SELECT * FROM Tra_M_Tupa_Clase ORDER BY iCodTupaClase ASC";
					}
          $rsClas=sqlsrv_query($cnx,$sqlClas);
          while ($RsClas=sqlsrv_fetch_array($rsClas)){
          	if($_GET[clear]==""){
          			if($RsClas["iCodTupaClase"]==$Rs[iCodTupaClase]){
          				$selecClas="selected";
          			}Else{
          				$selecClas="";
          			}
          	}Else{
          			if($RsClas["iCodTupaClase"]==$_POST[iCodTupaClase]){
          				$selecClas="selected";
          			}Else{
          				$selecClas="";
          			}          			
          	}
          echo "<option value=".$RsClas["iCodTupaClase"]." ".$selecClas.">".$RsClas["cNomTupaClase"]."</option>";
          }
          sqlsrv_free_stmt($rsClas);
					?>
					</select>
			</td>
			</tr>
					<?
					if($_GET[clear]==""){
							$iCodTupaClase=$Rs[iCodTupaClase];
					}Else{
							$iCodTupaClase=$_POST[iCodTupaClase];
					}
					?>
			<tr>
			<td valign="top"  width="300">Procedimiento:</td>
			<td valign="top" colspan="3">
					<select name="iCodTupa" class="FormPropertReg form-control" style="width:900px" onChange="releer();" <?php if($iCodTupaClase=="") echo "disabled"?> />
					<?
					if($Rs[nFlgEnvio]==1){
						$sqlTupa="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$Rs['iCodTupa']."' ORDER BY iCodTupa ASC";
					}Else{
						echo "<option value=\"\">Seleccione:</option>";
						$sqlTupa="SELECT * FROM Tra_M_Tupa WHERE iCodTupaClase='$iCodTupaClase' ORDER BY iCodTupa ASC";
					}
          $rsTupa=sqlsrv_query($cnx,$sqlTupa);
          while ($RsTupa=sqlsrv_fetch_array($rsTupa)){
          	if($_GET[clear]==""){
          			if($RsTupa["iCodTupa"]==$Rs['iCodTupa']){
          				$selecTupa="selected";
          			}Else{
          				$selecTupa="";
          			}
          	}Else{
          			if($RsTupa["iCodTupa"]==$_POST['iCodTupa']){
          				$selecTupa="selected";
          			}Else{
          				$selecTupa="";
          			}          			
          	}
          echo "<option value=".$RsTupa["iCodTupa"]." ".$selecTupa.">".$RsTupa["cNomTupa"]."</option>";
          }
          sqlsrv_free_stmt($rsTupa);
					?>
					</select>
			</td>
			</tr>

			<tr>
			<td valign="top"  width="300">Requisitos:</td>
			<td valign="top" colspan="3">
					<?
					if($_GET[clear]==""){
							$iCodTupa=$Rs['iCodTupa'];
					}Else{
							$iCodTupa=$_POST['iCodTupa'];
					}
					
					$sqlTupaReq="SELECT * FROM Tra_M_Tupa_Requisitos WHERE iCodTupa='$iCodTupa' ORDER BY iCodTupaRequisito ASC";
          $rsTupaReq=sqlsrv_query($cnx,$sqlTupaReq);
					?>
					<fieldset><legend>
										<?php if(sqlsrv_has_rows($rsTupaReq)>0){?>
										<a href="javascript:seleccionar_todo()">Marcar todos</a> | 
										<a href="javascript:deseleccionar_todo()">Desmarcar</a> 
										<?php}?>
										</legend>
					<table cellpadding="0" cellspacing="2" border="0" width="850">
					<?
					if(sqlsrv_has_rows($rsTupaReq)>0){
						while ($RsTupaReq=sqlsrv_fetch_array($rsTupaReq)){
							if($_GET[clear]==""){
									$sqlReqChk="SELECT * FROM Tra_M_Tramite_Requisitos WHERE iCodTupaRequisito='$RsTupaReq[iCodTupaRequisito]' AND iCodTramite='$_GET[iCodTramite]'";
									//echo $sqlReqChk;
          				$rsReqChk=sqlsrv_query($cnx,$sqlReqChk);
          				if(sqlsrv_has_rows($rsReqChk)>0){
          					$Checkear="checked";
									}
							}else{
									For ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      							$iCodTupaRequisito= $_POST[iCodTupaRequisito];
										if($RsTupaReq[iCodTupaRequisito]==$iCodTupaRequisito[$h]){
   											$Checkear="checked";
										}
									}
							}
          		echo "<tr><td valign=top width=15><input type=\"checkbox\" name=\"iCodTupaRequisito[]\" value=\"".$RsTupaReq["iCodTupaRequisito"]."\" ".$Checkear."></td><td style=\"color:#004080;font-size:11px\">".$RsTupaReq["cNomTupaRequisito"]."</td></tr>";
          		$Checkear="";
          	}
          }Else{
          	echo "&nbsp;";
          }
          sqlsrv_free_stmt($rsTupaReq);
					?>					
					</table>
					</fieldset>
			</td>
			</tr>
			
			<tr>
			<td valign="top"  width="300">Referencia:</td>
			<td>
				<?php
					$sqlRefs = "SELECT * FROM Tra_M_Tramite TT
										  INNER JOIN Tra_M_Tramite_Referencias TR ON TT.iCodTramite = tr.iCodTramite
											WHERE TT.iCodTramite = ".$_GET['iCodTramite'];
				
      		$rsRefs  = sqlsrv_query($cnx,$sqlRefs);
      		while ($RsRefs = sqlsrv_fetch_array($rsRefs)){
				?>
				<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?>
					<!-- <a href="registroData.php?iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=19&iCodTramite=<?=$_GET[iCodTramite]?>&sal=1&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cNombreRemitente=<?=$_POST[cNombreRemitente]?>&iCodTrabajadorResponsable=<?=$_POST[iCodTrabajadorResponsable]?>&iCodOficinaResponsable=<?=$_POST[iCodOficinaResponsable]?>&cNroDocumento=<?=$_POST['cNroDocumento']?>&cNomRemite=<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>&ActivarDestino=<?=$_POST[ActivarDestino]?>&iCodRemitente=<?=$_POST[iCodRemitente]?>&Remitente=<?=$_POST[Remitente]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>">
						<img src="images/icon_del.png" border="0" width="13" height="13">
					</a> -->
				</span>&nbsp;                       	
				<?php}?>
			</td>

			<!-- <td valign="top" colspan="3">
				<input style="text-transform:uppercase" type="text" name="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia]); }else{ echo $_POST[cReferencia];}?>" class="FormPropertReg form-control" style="width:250px" />
			</td> -->
			</tr>
					<?php
						$sqlTupDat="SELECT * FROM Tra_M_Tupa ";
         		$sqlTupDat.="WHERE iCodTupa='$iCodTupa'";
          	$rsTupDat=sqlsrv_query($cnx,$sqlTupDat);
          	$RsTupDat=sqlsrv_fetch_array($rsTupDat);
					?>
			<tr>
			<td valign="top"  width="300">Oficina:</td>
			<td>
				<?php
					$sqlMov = "SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos 
										 WHERE iCodTramite='$_GET[iCodTramite]' And cFlgTipoMovimiento =1 
										 ORDER BY iCodMovimiento ASC";
          $rsMov = sqlsrv_query($cnx,$sqlMov);
			  	$RsMov = sqlsrv_fetch_array($rsMov);
          echo "<input type=hidden name=numMov value=".sqlsrv_has_rows($rsMov).">";
				?>				
				<?php 
          	$sqlEnvio = "SELECT nFlgEnvio FROM Tra_M_Tramite WHERE iCodTramite = ".$_GET['iCodTramite'];
          	$rsEnvio  = sqlsrv_query($cnx,$sqlEnvio);
          	$RsEnvio  = sqlsrv_fetch_array($rsEnvio);
        ?>
							<select name="iCodOficinaResponsable" style="width:340px;" class="FormPropertReg form-control" <?/*if($RsTupDat['iCodOficina']=="") echo "disabled"*/?> <?php if($Rs[nFlgEnvio]==1) echo "disabled"?>>
							<?php
							 $sqlOfi="SP_OFICINA_LISTA_COMBO "; 
                  $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	            	if($RsOfi["iCodOficina"]==$RsMov[iCodOficinaDerivar]){
												$selecClas="selected";
          	        }else{
          		      		$selecClas="";
                   	}

                   	if ($RsEnvio['nFlgEnvio'] == 0) {
          						echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
          					}elseif ($selecClas != "") {
          						echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
          					}
          					// original anterior
                 		//echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                  }
                  sqlsrv_free_stmt($rsOfi);
							
							/*						
							$sqlDep2="SP_OFICINA_LISTA_AR '$RsMov[iCodOficinaDerivar]'";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              $RsDep2=sqlsrv_fetch_array($rsDep2);
                echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
				*/
							?>
							</select>
			</td>
			<td valign="top" >Responsable</td>
			<td>
							<select name="iCodTrabajadorResponsable" style="width:340px;" class="FormPropertReg form-control" <? /*if($RsTupDat['iCodOficina']=="") echo "disabled"*/?> <?php if($Rs[nFlgEnvio]==1) echo "disabled"?>>
							<?
								// $sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$RsMov[iCodOficinaDerivar]' And iCodCategoria = 5 ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
								$sqlTrb = "SELECT * FROM Tra_M_Perfil_Ususario TPU
					 								 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
					 								 WHERE TPU.iCodPerfil = 3 AND TPU.iCodOficina = '$RsMov[iCodOficinaDerivar]'";

              $rsTrb=sqlsrv_query($cnx,$sqlTrb);
              while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorResponsable]){
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
			</tr>
				

			<tr>
			<td valign="top"  width="300">Indicación:</td>
			<td valign="top">
							<select name="iCodIndicacion" style="width:250px;" class="FormPropertReg form-control">
							<option value="">Seleccione:</option>
							<?
							$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
              $sqlIndic .= "ORDER BY cIndicacion ASC";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
              	if($_GET[clear]==""){
              			if($RsIndic[iCodIndicacion]==$Rs[iCodIndicacion] OR $RsIndic[iCodIndicacion]==3){
              				$selecIndi="selected";
              			}Else{
              				$selecIndi="";
              			}
              	}Else{		
              			if($RsIndic[iCodIndicacion]==$_POST[iCodIndicacion]){
              				$selecIndi="selected";
              			}Else{
              				$selecIndi="";
              			}
              	}
              			
                echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
              }
              sqlsrv_free_stmt($rsIndic);
							?>
							</select>
				</td>
				<td valign="top" >Folios:</td>
				<td><input type="number" min=1 name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($Rs[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>

			<tr>
				<td valign="top"  width="300">Adjuntar Archivo:</td>
				<td valign="top">
						<?
						$sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          	$rsDig=sqlsrv_query($cnx,$sqlDig);
          	if(sqlsrv_has_rows($rsDig)>0){
          			$RsDig=sqlsrv_fetch_array($rsDig);
          			if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
										echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
										echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=14&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
								}
          	}Else{
          			echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          	}
						?>
				</td>
			</tr>
					<?php
						if($_GET[clear]==""){
								if($Rs[nFlgEnvio]==1){
									$marcarEnvio="checked disabled";
								}
						}else{
								if($_POST[ActivarDestino]==1){
									$marcarEnvio="checked";
								}
						}
					?>
			<tr>
			<td valign="top" >Derivar inmediatamente:</td>
			<td valign="top" colspan="3">
				<input type="checkbox" name="ActivarDestino" value="1" onclick="activaDestino();" <?=$marcarEnvio?>></td>
			</tr>

			<tr>
				<td valign="top" >Archivo F&iacute;sico:</td>
				<td valign="top" colspan="3">
					<textarea name="archivoFisico" id="archivoFisico" class="FormPropertReg form-control" style="width:33%;height:45px"><?php echo trim($Rs['ARCHIVO_FISICO']); ?></textarea>
				</td>
			</tr>
			<tr>
            <td colspan="4">
              <fieldset id="tfa_FlujoOfi" class="fieldset">
		  	<legend class="legend"><a href="javascript:;" onClick="muestra('zonaCopias')" class="LnkZonas">Copias<img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div  id="zonaCopias">
		    <table border="0" align="center" width="1000">
		    <tr>
		      <td class="headCellColum">Origen</td>
		       <td class="headCellColum">Destino</td>
		       <td class="headCellColum" width="150">Responsable</td>
		       <td class="headCellColum" width="80">Derivado</td>
		       <td class="headCellColum" width="80">Aceptado</td>
		       <td class="headCellColum" width="250">Observaciones</td>
		       <td class="headCellColum" width="120">Indicación</td>
               <td class="headCellColum" width="100">Estado</td>
                <td class="headCellColum" width="100">Opciones</td>
		    </tr>
		   	<? 
		   	$sqlCop="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' AND cFlgTipoMovimiento=4 ORDER BY iCodMovimiento ASC";
		   	$rsCop=sqlsrv_query($cnx,$sqlCop);
		   	//echo $sqlCop;
		    while ($RsCop=sqlsrv_fetch_array($rsCop)){
		      	if ($color == "#CEE7FF"){
			  			$color = "#F9F9F9";
		  			}else{
			  			$color = "#CEE7FF";
		  			}
		  			if ($color == ""){
			  			$color = "#F9F9F9";
		  			}	
				?>
		    <tr bgcolor="<?=$color?>">
		     <td valign="top"> <?
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsCop[iCodOficinaOrigen]'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	 ?>
		       </td>
		     	 <td valign="top"> <?
		     	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsCop[iCodOficinaDerivar]'";
			       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
		     	 		echo "<a href=\"javascript:;\" title=\"".trim($RsOfiD[cNomOficina])."\">".$RsOfiD[cSiglaOficina]."</a>";
		     	 	?>
		     	 </td> 	
		    <td valign="top">
		       	<?
          	$rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsCop[iCodTrabajadorDerivar]'");
          	$RsResp=sqlsrv_fetch_array($rsResp);
          	echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
						sqlsrv_free_stmt($rsResp);
        		?>
		       </td>
		       <td valign="top">
		       		<span><?=date("d-m-Y", strtotime($RsCop['fFecDerivar']))?></span>
		       </td>
		       <td valign="top">
		       		<?
        			if($RsCop[fFecRecepcion]==""){
        					echo "<div style=color:#ff0000>sin aceptar</div>";
        			}Else{
        					echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsCop[fFecRecepcion]))."</div>";
        			}
        			?>
		       </td>
		     	 <td valign="top" align="left"><?=$RsCop[cObservacionesDerivar]?></td>		       
			     <td valign="top" align="left">
			     		<?
			     		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsCop[iCodIndicacionDerivar]'";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              $RsIndic=sqlsrv_fetch_array($rsIndic);
                echo $RsIndic["cIndicacion"];
              sqlsrv_free_stmt($rsIndic);
			     		?>
			     </td>
                 <td valign="top" align="center">
		     	 		<?
		     	 		if($RsCop[fFecRecepcion]==""){
		     	 			switch ($RsCop['nEstadoMovimiento']) {
  							case 1:
									echo "Pendiente";
								break;
								case 2:
									echo "En Proceso"; //movimiento derivado a otra ofi
								break;
								case 3:
									echo "En Proceso"; //por delegar a otro trabajador
								break;
								case 4:
									echo "Respondido";
								break;
								case 5:
									echo "Finalizado";
								break;
								}
  				}Else if($RsCop[fFecRecepcion]!=""){ 
						switch ($RsCop['nEstadoMovimiento']) {
  							case 1:
									echo "En Proceso";
								break;
								case 2:
									echo "En Proceso"; //movimiento derivado a otra ofi
								break;
								case 3:
									echo "En Proceso"; //por delegar a otro trabajador
								break;
								case 4:
									echo "Respondido";
								break;
								case 5:
									echo "Finalizado";
								break;
								}  					
  				}
		     	 		?>
		    </td>
            <td valign="top" align="center">	
                 <a href="registroData.php?id=<?=$RsCop[iCodMovimiento];?>&opcion=27&idt=<?=$RsCop[iCodTramite];?>&URI=<?=$_GET[URI]?>" onClick='return ConfirmarBorrado2();'"><i class="far fa-trash-alt"></i></a>
        </td>
		    </tr> 
		    <?
		    }
		    ?>
		    </table>
		    </div>
		    <img src="images/space.gif" width="0" height="0"> 
		  	</fieldset>
            </td>
            </tr>
			<tr>
			<td colspan="4">
					<input name="button" type="button" class="btn btn-primary" value="Actualizar" onclick="Registrar();">
					&nbsp;&nbsp;
					<input type="button" class="btn btn-primary" value="Cancelar" name="inicio" onClick="window.open('<?=$_GET[URI]?>', '_self');">
			</td>
			</tr>
			</table>

		</form>
<div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>