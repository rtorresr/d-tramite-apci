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

function activaDerivar(){
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
document.frmRegistro.submit();
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
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

var miPopup
function Buscar(){
	miPopup = window.open('registroBuscarDocEnt.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
}

function AddReferencia(){
  document.frmRegistro.opcion.value=21;
  document.frmRegistro.action="registroData.php";
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
  if (document.frmRegistro.cNroDocumento.value.length == "")
  {
    alert("Ingrese N�mero del Documento");
    document.frmRegistro.cNroDocumento.focus();
    return (false);
  }
  if (document.frmRegistro.iCodRemitente.value.length == "")
  {
    alert("Seleccione Remitente");
    return (false);
  }
  if (document.frmRegistro.nFlgEnvio.value==1)
  {
  		if (document.frmRegistro.iCodOficinaResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Oficina");
  		  return (false);
  		}
  		if (document.frmRegistro.iCodTrabajadorResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Responsable");
  		  return (false);
  		}
	}
  document.frmRegistro.action="registroDataEdicion.php";
  document.frmRegistro.submit();
}


//--></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
 
	<?php include("includes/menu.php");?>


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

	<div class="AreaTitulo">Registro de entrada con tupa</div>
		<table class="table">
			<tr>
				<form name="frmRegistro" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="opcion"       value="1">
				<input type="hidden" name="nFlgClaseDoc" value="1">
				<input type="hidden" name="sal"          value="8">
				<input type="hidden" name="nFlgEnvio"    value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
				<td class="FondoFormRegistro">
					<table width="1030" border="0">
						<tr>
							<td valign="top" >Archivo F&iacute;sico:</td>
							<td valign="top" colspan="3">
									<input type="text" name="archivoFisico" class="FormPropertReg form-control" style="width:275px"
								 				 value="<?php echo $_POST['archivoFisico']; ?>"/>&nbsp;
							</td>
						</tr>
			
			<tr>
			<td valign="top"  width="300">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
					include_once("../conexion/conexion.php");
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgEntrada=1 ";
          $sqlTipo.="ORDER BY cDescTipoDoc ASC";
          $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          	if($RsTipo["cCodTipoDoc"]==$_POST[cCodTipoDoc]){
          		$selecTipo="selected";
          	}Else{
          		$selecTipo="";
          	}
          echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          }
          sqlsrv_free_stmt($rsTipo);
					?>
				</select>&nbsp;<span class="FormCellRequisito">*</span>
			</td>
			<td  width="160">Fecha  Registro:</td>
			<td>
			<td><input type="text" readonly name="fFecRegistro" value="<?php if($Rs['fFecRegistro']!=""){echo date("d-m-Y h:i", strtotime($Rs['fFecRegistro'])); } else {echo $_POST['fFecRegistro'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
				</tr></table></td>
			</tr>

			<tr>
			  <td valign="top" >N&ordm; del Tramite:</td>
			  <td valign="top" ><input type="text" name="cCodificacion" value="<?=$_POST[cCodificacion]?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:250px" />&nbsp;<span class="FormCellRequisito">*</span>;</td>
              <td  width="160">Fecha del Documento:</td>
			<td>
			<td><input type="text" readonly name="fFecDocumento" value="<?php if($Rs['fFecDocumento']!=""){echo date("d-m-Y h:i", strtotime($Rs['fFecDocumento'])); } else {echo $_POST['fFecDocumento'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDocumento,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
				</tr></table></td>
			  </tr>
			<tr>
			<td valign="top"  width="150">N&ordm; del Documento:</td>
			<td valign="top" ><input type="text" name="cNroDocumento" value="<?=$_POST['cNroDocumento']?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
            <td width="114" >Trabajador de Registro:&nbsp;</td>
		          <td width="255" align="left"><select name="iCodTrabajadorRegistro" style="width:340px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
					<? $sqlTrb="SELECT * FROM Tra_M_Trabajadores ";
                       $sqlTrb .= "ORDER BY cNombresTrabajador ASC";
                       $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                       while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	       if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorRegistro]){
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
			<td valign="top" >Remitente / Institución:</td>
			<td valign="top" colspan="3">
					<table cellpadding="0" cellspacing="2" border="0">
					<tr>
					
					<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?=$_POST[cNombreRemitente]?>" style="width:380px" readonly></td>
					<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
					<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a> </div></td>
					<td>
                    &nbsp;<span class="FormCellRequisito">*</span>
                    </td>
                    </tr>
					</table>
					<input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
                    <input id="Remitente" name="Remitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
			</td>
			</tr>
			
			<tr>
			<td valign="top"  width="300">Remite:</td>
			<td valign="top" colspan="3"><input type="text" name="cNomRemite" style="text-transform:uppercase" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg form-control" style="width:250px; text-transform:uppercase" />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>
			
			<tr>
			<td valign="top" >Asunto, Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea>
					&nbsp;&nbsp;
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea>
			</td>
			</tr>				

			<tr>
			<td valign="top"  width="300">Clase de Procedimiento:</td>
			<td valign="top" colspan="3">
				<select name="iCodTupaClase" class="FormPropertReg form-control" style="width:110px" onChange="releer();" />
					<option value="">Seleccione:</option>
					<?php 
						$sqlClas = "SELECT * FROM Tra_M_Tupa_Clase ORDER BY iCodTupaClase ASC";
			      $rsClas  = sqlsrv_query($cnx,$sqlClas);
			      while ($RsClas = sqlsrv_fetch_array($rsClas)){
			      	if ($RsClas['iCodTupaClase'] == $_POST['iCodTupaClase']){
			        	$selecClas = "selected";
			        }else{
			        	$selecClas = "";
			        }
			        echo "<option value=".$RsClas['iCodTupaClase']." ".$selecClas.">".$RsClas['cNomTupaClase']."</option>";
			      }
			      sqlsrv_free_stmt($rsClas);
					?>
				</select>
			</td>
			</tr>

			<tr>
			<td valign="top"  width="300">Procedimiento:</td>
			<td valign="top" colspan="3">
				<select name="iCodTupa" class="FormPropertReg form-control" style="width:700px"
								onChange="releer();" <?php if($_POST[iCodTupaClase]=="") echo "disabled"?> />
					<option value="">Seleccione:</option>
						<?php
							$sqlTupa = "SELECT * FROM Tra_M_Tupa ";
          		$sqlTupa.="WHERE iCodTupaClase='$_POST[iCodTupaClase]'";
          		$sqlTupa.="ORDER BY iCodTupa ASC";
          		$rsTupa  = sqlsrv_query($cnx,$sqlTupa);
          		while ($RsTupa = sqlsrv_fetch_array($rsTupa)){
          			if($RsTupa["iCodTupa"] == $_POST['iCodTupa']){
          				$selecTupa = "selected";
          			}else{
          				$selecTupa = "";
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
					$sqlTupaReq="SELECT * FROM Tra_M_Tupa_Requisitos ";
		            $sqlTupaReq.="WHERE iCodTupa='$_POST['iCodTupa']'";
		            $sqlTupaReq.="ORDER BY iCodTupaRequisito ASC";
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
							For ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      					$iCodTupaRequisito= $_POST[iCodTupaRequisito];
								if($RsTupaReq[iCodTupaRequisito]==$iCodTupaRequisito[$h]){
   									$Checkear="checked";
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
				<td valign="top">
					<table>
						<tr>
							<td align="center">
								<input type="hidden" readonly="readonly" name="cReferencia" 
											 value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia]); }else{ echo trim($_POST[cReferencia]);}?>"
											 class="FormPropertReg form-control" style="width:140px;text-transform:uppercase" />
								<input type="hidden" name="iCodTramiteRef" value="<?=$_REQUEST[iCodTramiteRef]?>"  />
              </td>
							<td align="center"></td>
							<td align="center">
								<div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;">
									<a style=" text-decoration:none" href="javascript:;" onClick="Buscar();">A�adir Referencia</a>

								</div>
							</td>
						</tr>
					</table>
					
					<table border=0>
						<tr>
							<td>
								<?php
									$sqlRefs = "SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodRef]'";
									//	echo $sqlRefs;
          				$rsRefs  = sqlsrv_query($cnx,$sqlRefs);
          				while ($RsRefs = sqlsrv_fetch_array($rsRefs)){
								?>
								<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?>
									<a href="registroData.php?iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=19&iCodTramite=<?=$_GET[iCodTramite]?>&sal=2&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cNombreRemitente=<?=$_POST[cNombreRemitente]?>&iCodTrabajadorResponsable=<?=$_POST[iCodTrabajadorResponsable]?>&iCodOficinaResponsable=<?=$_POST[iCodOficinaResponsable]?>&cNroDocumento=<?=$_POST['cNroDocumento']?>&cNomRemite=<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>&ActivarDestino=<?=$_POST[ActivarDestino]?>&iCodRemitente=<?=$_POST[iCodRemitente]?>&Remitente=<?=$_POST[Remitente]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&iCodTupaClase=<?=$_POST[iCodTupaClase]?>&iCodTupa=<?=$_POST['iCodTupa']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>&archivoFisico=<?=$_POST[archivoFisico]?>&fechaDocumento=<?=$_POST[fechaDocumento]?>">
										<img src="images/icon_del.png" border="0" width="13" height="13">
									</a>
								</span>&nbsp;
								<?php 
									}
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
				<?php
					$sqlTupDat="SELECT * FROM Tra_M_Tupa ";
          $sqlTupDat.="WHERE iCodTupa='$_POST['iCodTupa']'";
          $rsTupDat=sqlsrv_query($cnx,$sqlTupDat);
          $RsTupDat=sqlsrv_fetch_array($rsTupDat);
					?>
			<tr>
			<td valign="top"  width="300">Oficina:</td>
			<td>
							<select name="iCodOficinaResponsable" style="width:340px;" class="FormPropertReg form-control" <?php if($RsTupDat['iCodOficina']=="") echo "disabled"?>>
							<?
							$sqlDep2="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsTupDat['iCodOficina']'";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              $RsDep2=sqlsrv_fetch_array($rsDep2);
                echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
							$codoficina=$RsDep2["iCodOficina"];
							?>
							</select>
			</td>
			<td valign="top" >Responsable</td>
			<td>
							<select name="iCodTrabajadorResponsable" style="width:340px;" class="FormPropertReg form-control" <?php if($RsTupDat['iCodOficina']=="") echo "disabled"?>>
							<?
             	$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$codoficina' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
              $rsTrb=sqlsrv_query($cnx,$sqlTrb);
			  			if($codoficina==""){
			  			echo "<option value=\"\">Seleccione:</option>";
			  			}
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
              	if($RsIndic[iCodIndicacion]==$_POST[iCodIndicacion] OR $RsIndic[iCodIndicacion]==3){
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
				<td valign="top" >Folios:</td>
				<td><input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;} else { echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/></td>
			</tr>

			<tr>
				<td valign="top"  width="300">Adjuntar Archivo:</td>
				<td valign="top"><input type="file" name="fileUpLoadDigital" class="FormPropertReg form-control" style="width:340px;" /></td>
				<td valign="top" >Tiempo para Respuesta:</td>
				<td valign="top" class="CellFormRegOnly"><input type="text" name="nTiempoRespuesta" value="<?php if($_POST[nTiempoRespuesta]==""){ echo "0"; }Else{ echo $_POST[nTiempoRespuesta]; }?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/> d�as</td>
			</tr>
			
			<tr>
			<td valign="top" >Enviar Inmediatamente:</td>
			<td valign="top" colspan="3"><input type="checkbox" name="ActivarDestino" value="1" onclick="activaDestino();" <?php if($_POST[ActivarDestino]==1) echo "checked"?>></td>
			</tr>
			
			<tr>
			<td colspan="4"> 
					<input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="Registrar();">
			</td>
			</tr>
			</table>
			&nbsp;<span class="FormCellRequisito">* Campos requeridos</span>

		</form>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>
<script src="scripts/select_ajax.js"></script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>