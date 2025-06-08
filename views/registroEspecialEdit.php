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
function activaRemitente()
{
document.frmRegistro.radioMultiple.checked = false;
document.frmRegistro.radioRemitente.checked = true;
document.frmRegistro.iCodRemitente.value=document.frmRegistro.Remitente.value;
document.getElementById('areaRemitente').style.display = '';
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

function Registrar(){
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  if (document.frmRegistro.iCodRemitente.value.length == "")
  {
    document.frmRegistro.iCodRemitente.value=-1;
  }  
  document.frmRegistro.opcion.value=18;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
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
  document.frmRegistro.opcion.value=24;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}
function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmRegistro.submit();
}

var miPopup
function Buscar(){
miPopup= window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
}

function infoRemitente() {
var w = document.frmRegistro.txtdirec_remitente.value;
var x = document.frmRegistro.cCodDepartamento.value;
var y = document.frmRegistro.cCodProvincia.value;
var z = document.frmRegistro.cCodDistrito.value ;
var t = document.frmRegistro.iCodRemitente.value;

window.open('registroRemitenteDetalle.php?iCodRemitente='+t+'&txtdirec_remitentex='+w+'&cCodDepartamentox='+x+'&cCodProvinciax='+y+'&cCodDistritox='+z,'popuppage','width=590,height=240,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');
}

function AddReferencia(){
	if (document.frmRegistro.cReferencia.value.length == "")
  {
    alert("Ingrese Referencia");
    document.frmRegistro.cReferencia.focus();
    return (false);
  }
  document.frmRegistro.opcion.value=22;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}
//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
<body>

	<?php include("includes/menu.php");?>
	<a name="area"></a>


		<?
		include_once("../conexion/conexion.php");
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs=sqlsrv_fetch_array($rs);
		?>
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

<div class="AreaTitulo">Actualizacion - Registro Salida Especial</div>	
		<table class="table">
			<form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
            <input type="hidden" name="Especial" value="Especial">
			<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
			<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
			<input type="hidden" name="cReferenciaOriginal" value="<?=trim($Rs[cReferencia])?>">	
            <input type="hidden" name="sal" value="4">		
		<tr>
		<td class="FondoFormRegistro">
			<table border=0>
			<tr>
			<td valign="top"  width="160">Tramite:</td>
			<td valign="top" colpsan="3" style="font-size:16px;color:#00468C"><b><?=$Rs[cCodificacion]?></b></td>
			</tr>
			
					
			<tr>
			<td valign="top"  width="160">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgSalida=1 ORDER BY cDescTipoDoc ASC";
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
			<td style="padding-top:5px;"><b><?=date("d-m-Y H:i", strtotime($Rs['fFecDocumento']))?></td>
			</tr>
			
			<tr>
			<td valign="top"  width="160">Oficina Solicitante:</td>
			<td>
							<select name="iCodOficinaSolicitado" style="width:300px;" class="FormPropertReg form-control">
							<option value="">Seleccione Oficina:</option>
							<?
							$sqlDep2="SELECT * FROM Tra_M_Oficinas ORDER BY cNomOficina ASC";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
              	if($_GET[clear]==""){
              			if($RsDep2['iCodOficina']==$Rs[iCodOficinaSolicitado]){
              				$selecOfi="selected";
              			}Else{
              				$selecOfi="";
              			}
              	}Else{
              			if($RsDep2['iCodOficina']==$_POST[iCodOficinaSolicitado]){
              				$selecOfi="selected";
              			}Else{
              				$selecOfi="";
              			}
								}
                echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
              }
							?>
							</select>
			</td>
			<td valign="top"  width="160">Referencia:</td>
			<td valign="top">
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
						<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?><a href="registroData.php?iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=20&iCodTramite=<?=$_GET[iCodTramite]?>&sal=4&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="13" height="13"></a></span>&nbsp;
						<?php}?>

			</td>
			</tr>
			
			<tr>
			<td valign="top" >Asunto, Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs['cAsunto']); }Else{ echo trim($_POST['cAsunto']);}?></textarea>&nbsp;<span class="FormCellRequisito"></span>
					&nbsp;&nbsp;
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs[cObservaciones]); }Else{ echo trim($_POST[cObservaciones]);}?></textarea>
			</td>
			</tr>	

			<tr>

				<td valign="top" >Requiere Respuesta:</td>
				<td>
					<?
					if($_GET[clear]==""){
							$nFlgRpta=$Rs[nFlgRpta];
					}Else{
							$nFlgRpta=$_POST[nFlgRpta];
					}
					?>
					Si<input type="radio" name="nFlgRpta" value="1" <?php if($nFlgRpta==1) echo "checked"?> /> &nbsp;
					No<input type="radio" name="nFlgRpta" value="" <?php if($nFlgRpta=="") echo "checked"?> />
				</td>
			</tr>
			
			<tr>
				<td valign="top" >Folios:</td>
				<td><input type="text" name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($Rs[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" />&nbsp;<span class="FormCellRequisito"></span></td>
				<td valign="top"  width="160">Fecha Plazo:</td>
				<td valign="top">
							<?
							if($_GET[clear]==""){
								if($Rs[fFecPlazo]!=""){
											$fFecPlazo=date("d-m-Y", strtotime($Rs[fFecPlazo]));
								}
							}Else{
								$fFecPlazo=$_POST[fFecPlazo];
							}
							?>

							<td><input type="text" readonly name="fFecPlazo" value="<?=$fFecPlazo?>" style="width:75px" class="FormPropertReg form-control"></td>
							<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecPlazo,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito"></span></div></td>
							</tr></table>
				</td>
			</tr>			
			<tr>
				<td valign="top" >Adjuntar Archivo:</td>
				<td valign="top">
						<?
						$sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          	$rsDig=sqlsrv_query($cnx,$sqlDig);
          	if(sqlsrv_has_rows($rsDig)>0){
          			$RsDig=sqlsrv_fetch_array($rsDig);
          			if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
										echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
										echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=18&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
								}
          	}Else{
          			echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          	}
						?>					
				</td>
				<td valign="top" >Sigla Autor:</td>
				<td><input type="text" style="width:60px;text-transform:uppercase" name="cSiglaAutor" value="<?php if($_GET[clear]==""){ echo $Rs[cSiglaAutor]; }Else{ echo $_POST[cSiglaAutor];}?>" class="FormPropertReg form-control" /></td>
			</tr>
			
			<tr>
			<td valign="top" >Destino:</td>
			<td valign="top" colspan="3">
					<table><tr>
          <td valign="top"><input type="radio" name="radioMultiple" onclick="activaMultiple();" <?php if($Rs[iCodRemitente]=="") echo "checked"; ?>>
          M&uacute;ltiple</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td valign="top"><input type="radio" name="radioRemitente" onclick="activaRemitente();" <?php if($Rs[iCodRemitente]!="") echo "checked"; ?>>Un Destino</td>
					<td valign="top">
							<div <?php if($Rs[iCodRemitente]=="") echo "style=\"display:none\""; ?> id="areaRemitente">
									<?
									if($Rs[iCodRemitente]!=""){
											$sqlRem="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
          						$rsRem=sqlsrv_query($cnx,$sqlRem);
          						$RsRem=sqlsrv_fetch_array($rsRem);
          						$iCodRemitente=$Rs[iCodRemitente];
			$sqlCarg="SELECT cDireccion, cDepartamento, cProvincia, cDistrito FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite ='$Rs[iCodTramite]'";
		$rsCarg=sqlsrv_query($cnx,$sqlCarg);
        $RsCarg=sqlsrv_fetch_array($rsCarg);
							$remi=
			 				$dir=$RsCarg[cDireccion]; $dep=$RsCarg[cDepartamento]; $pro=$RsCarg[cProvincia]; $dis=$RsCarg[cDistrito];						
          				}
									?>
									<table cellpadding="0" cellspacing="2" border="0">
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Instituci&oacute;n:&nbsp;</td>
									<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?=$RsRem['cNombre']?>" style="width:300px" readonly></td>
									<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
									<td align="center"></td>
									</tr>
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Destinatario:&nbsp;</td>
									<td ><input id="cNomRemite" name="cNomRemite" value="<?=$Rs[cNomRemite]?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:300px" ></td>
                                    <td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;text-align:center"><a style=" text-decoration:none" href="javascript:;"  onClick="infoRemitente(this);">+ Datos</a> </div></td>
									
									</tr>
									</table>
									
							</div>
                            <input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$iCodRemitente?>">
                            <input id="Remitente" name="Remitente" type="hidden" value="<?php if(empty($_POST[iCodRemitente])){echo $iCodRemitente;}else{echo $_POST[iCodRemitente];}?>">
                            <input id="txtdirec_remitente" name="txtdirec_remitente" type="hidden" value="<?=$dir?>">
                            <input id="cCodDepartamento" name="cCodDepartamento" type="hidden" value="<?=$dep?>">
                            <input id="cCodProvincia" name="cCodProvincia" type="hidden" value="<?=$pro?>">
                            <input id="cCodDistrito" name="cCodDistrito" type="hidden" value="<?=$dis?>">	
					</td>
					</tr></table>
			</td>
			</tr>			
			          
			<tr>
			<td colspan="4"> 
					<input name="button" type="button" class="btn btn-primary" value="Actualizar" onclick="Registrar();">
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