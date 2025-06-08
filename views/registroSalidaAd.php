<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registro de documentos para Oficinas
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
			if (!isset($_SESSION["cCodSession3"])){ 
			  $max_chars=round(rand(10,15));  
				$chars=array();
				for($i="a";$i<"z";$i++){
  				$chars[]=$i;
  				$chars[]="z";
				}
				for ($i=0; $i<$max_chars; $i++){
  				$letra=round(rand(0, 1));
  				if ($letra){ 
 						$clave.= $chars[round(rand(0,count($chars)-1))];
  				}else{ 
 						$clave.= round(rand(0, 9));
  				}
				}
    	$_SESSION["cCodSession3"]=$clave;
		}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

<script Language="JavaScript">
<!--

function activaRemitente()
{
document.frmRegistro.radioMultiple.checked = false;
document.frmRegistro.radioRemitente.checked = true;
document.frmRegistro.iCodRemitente.value="";
muestra('areaRemitente');
return false;
}

function activaMultiple()
{
document.frmRegistro.radioMultiple.checked = true;
document.frmRegistro.radioRemitente.checked = false;
document.frmRegistro.iCodRemitente.value=0;
document.getElementById('areaRemitente').style.display = 'none';
return false;
}

function muestra(nombrediv) {
    if(document.getElementById(nombrediv).style.display == '') {
            document.getElementById(nombrediv).style.display = 'none';
    } else {
            document.getElementById(nombrediv).style.display = '';
    }
}

function Registrar(){
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  
  if (document.frmRegistro.nNumFolio.value.length == "")
  {
    alert("Ingrese N�mero de Folios");
    document.frmRegistro.nNumFolio.focus();
    return (false);
  }  
  
  if (document.frmRegistro.iCodRemitente.value.length == "")
  {
    document.frmRegistro.iCodRemitente.value=-1;
  }  
  
  document.frmRegistro.opcion.value=5;
  document.frmRegistro.action="registroDataEdicion.php";
  document.frmRegistro.submit();
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
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

<div class="AreaTitulo">Registro - Salida</div>	
		<table class="table">
			<form name="frmRegistro" method="POST" action="registroDataEdicion.php" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
		<tr>
		<td class="FondoFormRegistro">
			<table border=0>
			<tr>
			<td valign="top"  width="149">Tipo de Documento:</td>
			<td width="351" valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
					<option value="">Seleccione:</option>
					<?
					include_once("../conexion/conexion.php");
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgSalida=1";
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
			<td  width="172">Fecha Registro:</td>
			<td>
			<td><input type="text" readonly name="fFecRegistro" value="<?php if($Rs['fFecRegistro']!=""){echo date("d-m-Y h:i", strtotime($Rs['fFecRegistro'])); } else {echo $_POST['fFecRegistro'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
				</tr></table></td>
			</tr>	
            <tr>
			    <td valign="top" >&nbsp;</td>
			  <td valign="top" >
			    </td>
              <td  width="172">Fecha del Documento:</td>
			<td>
			<td><input type="text" readonly name="fFecDocumento" value="<?php if($Rs['fFecDocumento']!=""){echo date("d-m-Y h:i", strtotime($Rs['fFecDocumento'])); } else {echo $_POST['fFecDocumento'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDocumento,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
				</tr></table></td>
			  </tr>	
              <tr>
			<td valign="top"  width="149">N&ordm; del Tramite:</td>
			<td valign="top" ><input type="text" name="cCodificacion" value="<?=$_POST[cCodificacion]?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
            <td width="172" >Trabajador de Registro:&nbsp;</td>
		          <td width="341" align="left"><select name="iCodTrabajadorRegistro" style="width:340px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
					<? $sqlTrb="SELECT * FROM Tra_M_Trabajadores  ";
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
			<td valign="top"  width="149">Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:336px;height:55px" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea>
				&nbsp;&nbsp;&nbsp;</td>
			<td valign="top"  width="172">Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:320px;height:55px" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea>
			</td>
			</tr>

			<tr>
				<td valign="top" >Requiere Respuesta:</td>
				<td>Si<input type="radio" name="nFlgRpta" value="1" <?php if($_POST[nFlgRpta]==1) echo "checked"?> /> &nbsp; No<input type="radio" name="nFlgRpta" value="" <?php if($_POST[nFlgRpta]=="") echo "checked"?> /></td>
                <td valign="top"  width="172">Referencia:</td>
			<td valign="top">
					<table><tr>
					<td align="center"><input type="text" name="cReferencia" value="<?=$_POST[cReferencia]?>" class="FormPropertReg form-control" style="width:200px;text-transform:uppercase" /><input type="hidden" name="iCodTramiteRef"  value="<?=$_POST[iCodTramiteRef]?>"  /></td>
					<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
					</tr></table>
					
			</td>
			</tr>
			
			<tr>
				<td valign="top" >Folios:</td>
				<td><input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;} else { echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/></td>
				<td valign="top"  width="172">Fecha Plazo:</td>
				<td valign="top">

							<td><input type="text" readonly name="fFecPlazo" value="<?=$_POST[fFecPlazo]?>" style="width:75px" class="FormPropertReg form-control" ></td>
							<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecPlazo,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
							</tr></table>
				</td>
			</tr>			
			<tr>
				<td valign="top" >Adjuntar Archivo:</td>
				<td valign="top"><input type="file" name="fileUpLoadDigital" class="FormPropertReg form-control" style="width:335px;" /></td>
				<td valign="top" >Sigla Autor:</td>
				<td><input type="text" name="cSiglaAutor" value="<?=$_POST[cSiglaAutor]?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:60px;" /></td>
			</tr>
			
			<tr>
			<td valign="top" >Destino:</td>
			<td valign="top" colspan="3">
					<table border=0><tr>
          <td valign="top"><input type="radio" name="radioMultiple" onclick="activaMultiple();">M�ltiple</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td valign="top"><input type="radio" name="radioRemitente" onclick="activaRemitente();" >Un Destino</td>
					<td>
							<div style="display:none" id="areaRemitente">
									<table cellpadding="0" cellspacing="2" border="0">
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Institución:&nbsp;</td>
									<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?=$_POST[cNombreRemitente]?>" style="width:300px" readonly></td>
									<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
									<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a> </div></td>
									</tr>
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Destinatario:&nbsp;</td>
									<td colspan="3"><input id="cNomRemite" name="cNomRemite" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg form-control" style="width:300px" ></td>
									</tr>
									</table>
									<input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">
							</div>
					</td>
					</tr></table>
			</td>
			</tr>
			<tr>
			<td valign="top" >Copias a Oficina:</td>
			<td colspan="3" align="left">
							<table border=0>
							<tr>
							<td>
									<select name="iCodOficinaMov" style="width:280px;" class="FormPropertReg form-control" onChange="releer();">
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
          		    sqlsrv_free_stmt($rsDep2);
									?>
									</select>
							</td>
							<td>
									<select name="iCodTrabajadorMov" style="width:220px;" class="FormPropertReg form-control">
									<?php if($_POST[iCodOficinaMov]==""){?>
									<option value="">Seleccione Trabajador:</option>
									<?php}?>
									<?
									$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$_POST[iCodOficinaMov]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
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
							<td>
									<select name="iCodIndicacionMov" style="width:200px;" class="FormPropertReg form-control">
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
									<select name="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
          		    <option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
          		    <option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
          		    <option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
          		    </select>
							</td>
							<td>
									<input name="button" type="button" class="btn btn-primary" value="A�adir" onclick="AddOficina();">
							</td>
							</tr>
							
							<tr>
							<td class="headColumnas">Oficina</td>
							<td class="headColumnas">Trabajador</td>
							<td class="headColumnas">Indicacion</td>
							<td class="headColumnas">Prioridad</td>
							<td class="headColumnas">Opcion</td>
							</tr>
							
							
							<?
							$sqlMovs="SELECT * FROM Tra_M_Tramite_Temporal WHERE cCodSession='$_SESSION[cCodSession3]' ORDER BY iCodTemp ASC";
          		$rsMovs=sqlsrv_query($cnx,$sqlMovs);
          		while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
							?>
							<tr>
							<td align="left">
							<?
							$sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs['iCodOficina']'";
          		$rsOfc=sqlsrv_query($cnx,$sqlOfc);
          		$RsOfc=sqlsrv_fetch_array($rsOfc);
          		echo $RsOfc["cNomOficina"];
							?>
							</td>
							<td align="left">
								<?
								$sqlTra="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMovs[iCodTrabajador]' ";
          		  $rsTra=sqlsrv_query($cnx,$sqlTra);
								$RsTra=sqlsrv_fetch_array($rsTra);
          		  echo $RsTra["cNombresTrabajador"]." ".$RsTra["cApellidosTrabajador"];
								?>
							</td>
							<td align="left">
								<?
								$sqlInd="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsMovs[iCodIndicacion]'";
          		  $rsInd=sqlsrv_query($cnx,$sqlInd);
          		  $RsInd=sqlsrv_fetch_array($rsInd);
          		  echo $RsInd["cIndicacion"];
								?>
							</td>
							<td align="left">
								<?=$RsMovs[cPrioridad]?>
							</td>
							<td align="center">
								<a href="registroData.php?iCodTemp=<?=$RsMovs[iCodTemp]?>&opcion=21&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cCodificacion=<?=$_POST[cCodificacion]?>&fFecDocumento=<?=$_POST['fFecDocumento']?>&fFecRegistro=<?=$_POST['fFecRegistro']?>&iCodTrabajadorRegistro=<?=$_POST[iCodTrabajadorRegistro]?>&iCodTrabajadorSolicitado=<?=$_POST[iCodTrabajadorSolicitado]?>&cReferencia=<?=$_POST[cReferencia]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nFlgRpta=<?=$_POST[nFlgRpta]?>&nNumFolio=<?=$_POST[nNumFolio]?>&fFecPlazo=<?=$_POST[fFecPlazo]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>"><img src="images/icon_del.png" border="0" width="16" height="16"></a>
							</td>
							</tr>
                   		<?
          		}
							?>
							
							</table>
			</td>
			</tr>         
			<tr>
			<td colspan="4">
					<input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="Registrar();">
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