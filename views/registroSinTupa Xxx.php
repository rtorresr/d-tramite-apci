<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registro de documentos sin TUPA
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
<?php include("includes/head.php");?>

<script Language="JavaScript">
<!--
function fecha(){
 var ahora = new Date() 
 var horas = ahora.getHours()   
 var minutos = ahora.getMinutes()   
 var segundos = ahora.getSeconds() 
 var fecha=new Date();
 var diames=fecha.getDate();
 var mes=fecha.getMonth()+1 
 var anio=fecha.getFullYear();
 document.getElementById("reloj").innerHTML=diames+"/"+mes+"/"+anio +" " + horas+":"+minutos+":"+segundos;
}

function intervalo(){
 var time=setInterval("fecha()",1000);
}

function activaDerivar(){
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
document.frmRegistro.submit();
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
  document.frmRegistro.submit();
}

function Registrar()
{
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Clase Documento");
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
<?php if($_POST[nFlgEnvio]==1){?>
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
<?php}?>
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

//--></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/registroSelect.css">
<script type="text/javascript" src="scripts/registroSelect.js"></script>
</head>
<body onload="intervalo();asignaVariables();">

	<?php include("includes/menu.php");?>



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

<div class="AreaTitulo">Registro de entrada sin tupa</div>	
		<table class="table">
				<form name="frmRegistro" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="opcion" value="1">
				<input type="hidden" name="nFlgClaseDoc" value="2">
				<input type="hidden" name="iCodRemitente" value="<?=$_POST[iCodRemitente]?>">
		<tr>
		<td class="FondoFormRegistro">
			<table border="0">
			<tr>
			<td valign="top"  width="150">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" onChange="releer();" />
					<option value="">Seleccione:</option>
					<?
					include_once("../conexion/conexion.php");
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgEntrada=1";
          $sqlTipo.="ORDER BY cDescTipoDoc ASC  ";
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
			<td><div  id="reloj" style="height:15px;width:115px; border:inset; border-color:#CCFFCC"></div></td>
			</tr>
			
			<tr>
			<td valign="top"  width="150">N&ordm; del Documento:</td>
			<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNroDocumento" value="<?=$_POST['cNroDocumento']?>" class="FormPropertReg form-control" style="width:250px" onchange="releer();" />&nbsp;<span class="FormCellRequisito">*</span></td>
			</tr>			
						
			<tr>
			<td valign="top" >Remitente:</td>
			<td valign="top" colspan="3">
					<table><tr>
					<td>
								<input type="text" id="input_2" class="input" name="remitenteNombre" style="width:450px"
								onfocus="if(document.getElementById('lista').childNodes[0]!=null && this.value!='') { filtraLista(this.value); formateaLista(this.value); reiniciaSeleccion(); document.getElementById('lista').style.display='block'; }" 
								onblur="if(v==1) document.getElementById('lista').style.display='none';" 
								onkeyup="if(navegaTeclado(event)==1){ clearTimeout(ultimoIdentificador); ultimoIdentificador=setTimeout('rellenaLista()', 1000); }">
								<div id="lista" onmouseout="v=2;" onmouseover="v=0;"></div>	
					</td>
					<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="registroRemitenteLista.php?cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cNroDocumento=<?=$_POST['cNroDocumento']?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&cReferencia=<?=$_POST[cReferencia]?>&iCodOficinaResponsable=<?=$_POST[iCodOficinaResponsable]?>&iCodTrabajadorResponsable=<?=$_POST[iCodTrabajadorResponsable]?>&iCodIndicacion=<?=$_POST[iCodIndicacion]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cNomRemite=<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>&nFlgClaseDoc=2" rel="lyteframe" title="Documentos Adjuntos" rev="width: 730px; height: 350px; scrolling: auto; border:no">Buscar</a></div></td>
					<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="registroRemitenteNuevo.php?cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cNroDocumento=<?=$_POST['cNroDocumento']?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&cReferencia=<?=$_POST[cReferencia]?>&iCodIndicacion=<?=$_POST[iCodIndicacion]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cNomRemite=<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>&nFlgClaseDoc=2" rel="lyteframe" title="Nuevo Remitente" rev="width: 583px; height: 453px; scrolling: auto; border:no">Nuevo Remitente</a> </div></td>
					</tr></table>
			</td>
			</tr>
			
			<tr>
			<td valign="top" ></td>
			<td valign="top" colspan="3">
						<?
						if($_GET[clear]==1){
							$iCodRemitente="";
						}Else{
							$iCodRemitente=$_POST[iCodRemitente];
						}
						$sqlRem="SELECT * FROM Tra_M_Remitente ";
          	$sqlRem.="WHERE iCodRemitente='$iCodRemitente'";
          	$rsRem=sqlsrv_query($cnx,$sqlRem);
          	$RsRem=sqlsrv_fetch_array($rsRem);
						?>
					<table cellpadding="0" cellspacing="0" border="0" <?php if($_POST[tipoRemitente]=="") echo "disabled"?>>
					<tr>
					<td align="right" width="70" style="color:#7E7E7E">Nombre:&nbsp;</td>
					<td><b><?=$RsRem['cNombre']?></td>
					</td>
					</tr>
					<tr>
					<td align="right" width="70" style="color:#7E7E7E">
						<?php if($_POST[tipoRemitente]==1) echo "DNI: "?>
						<?php if($_POST[tipoRemitente]==2) echo "RUC: "?>
						<?php if($_POST[tipoRemitente]=="") echo "DOC: "?>
						&nbsp;
					</td>
					<td><b><?=$RsRem['nNumDocumento']?></b></td>
					</tr>
					<tr>
					<td align="right" width="70" style="color:#7E7E7E">Domicilio:&nbsp;</td><td><b><?=$RsRem[cDireccion]?></b></td>
					</tr>
					</table>
			</td>
			</tr>
			
			<tr>
			<td valign="top" >Remite:</td>
			<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNomRemite" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg form-control" style="width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
			</tr>
			
			<tr>
			<td valign="top" >Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea>
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea>
			</td>
			</tr>
			
			<tr>
			<td valign="top"  width="150">Referencia:</td>
			<td valign="top" colspan="3"><input type="text" name="cReferencia" style="text-transform:uppercase" value="<?=$_POST[cReferencia]?>" class="FormPropertReg form-control" style="width:250px" /></td>
			</tr>
			
			<tr>
			<td valign="top"  width="150">Oficina:</td>
			<td>
							<select name="iCodOficinaResponsable" style="width:340px;" class="FormPropertReg form-control" onChange="releer();">
							<option value="">Seleccione:</option>
							<?
							$sqlDep2="SELECT * FROM Tra_M_Oficinas ";
              $sqlDep2.= "ORDER BY cNomOficina ASC";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
              	if($RsDep2['iCodOficina']==$_POST[iCodOficinaResponsable]){
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
			<td valign="top" >Responsable</td>
			<td>
							<select name="iCodTrabajadorResponsable" style="width:340px;" class="FormPropertReg form-control">
							<?
							$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$_POST[iCodOficinaResponsable]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
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
			<td valign="top"  width="150">Indicación:</td>
			<td valign="top">
							<select name="iCodIndicacion" style="width:250px;" class="FormPropertReg form-control">
							<option value="">Seleccione:</option>
							<?
							$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
              $sqlIndic .= "ORDER BY cIndicacion ASC";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
              	if($RsIndic[iCodIndicacion]==$_POST[iCodIndicacion]){
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
				<td><input type="text" name="nNumFolio" value="<?=$_POST[nNumFolio]?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/></td>
			</tr>

			<tr>
				<td valign="top"  width="150">Adjuntar Archivo:</td>
				<td valign="top"><input type="file" class="FormPropertReg form-control" name="fileUpLoadDigital" style="width:340px;" /></td>
				<td valign="top" >Tiempo para Respuesta:</td>
				<td valign="top" class="CellFormRegOnly"><input type="text" name="nTiempoRespuesta" value="<?php if($_POST[nTiempoRespuesta]==""){ echo "0"; }Else{ echo $_POST[nTiempoRespuesta]; }?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/> d�as</td>
			</tr>			

			<tr>
			<td valign="top" >Enviar Inmediatamente:</td>
			<td valign="top" colspan="3">
					<input type="checkbox" name="nFlgEnvio" value="1" <?php if($_POST[nFlgEnvio]==1) echo "checked"?> onclick="releer();">

			</td>
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

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>