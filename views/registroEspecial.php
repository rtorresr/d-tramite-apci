<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroEspecial.php
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
function mueveReloj(){ 
    momentoActual = new Date() 
    anho = momentoActual.getFullYear() 
    mes = (momentoActual.getMonth())+1
    dia = momentoActual.getDate() 
    hora = momentoActual.getHours() 
    minuto = momentoActual.getMinutes() 
    segundo = momentoActual.getSeconds()
    if((mes>=0)&&(mes<=9)){ mes="0"+mes; }
    if((dia>=0)&&(dia<=9)){ dia="0"+dia; }
    if((hora>=0)&&(hora<=9)){ hora="0"+hora; }
    if((minuto>=0)&&(minuto<=9)){ minuto="0"+minuto; }
    if ((segundo>=0)&&(segundo<=9)){ segundo="0"+segundo; }
    horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo 
    document.frmRegistro.reloj.value=horaImprimible 
    setTimeout("mueveReloj()",1000) 
}

function activaRemitente()
{
document.frmRegistro.radioMultiple.checked = false;
document.frmRegistro.radioRemitente.checked = true;
document.frmRegistro.iCodRemitente.value=document.frmRegistro.Remitente.value;
document.frmRegistro.radioSeleccion.value="2";
muestra('areaRemitente');
return false;
}

function activaMultiple()
{
document.frmRegistro.radioMultiple.checked = true;
document.frmRegistro.radioRemitente.checked = false;
document.frmRegistro.iCodRemitente.value=0;
document.frmRegistro.radioSeleccion.value="1";
document.getElementById('areaRemitente').style.display = 'none';
return false;
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
  document.frmRegistro.opcion.value=23;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
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
  if (document.frmRegistro.iCodOficinaSolicitado.value.length == "")
  {
    alert("Seleccione Oficina Solicitante");
    document.frmRegistro.iCodOficinaSolicitado.focus();
    return (false);
  }
  if (document.frmRegistro.iCodRemitente.value.length == "")
  {
    document.frmRegistro.iCodRemitente.value=-1;
  }  
  document.frmRegistro.opcion.value=17;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
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
  document.frmRegistro.opcion.value=21;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}
//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
<body onload="mueveReloj()">

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

<div class="AreaTitulo">Registro - Salida Especial</div>	
		<table class="table">
			<form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
            <input type="hidden" name="Especial" value="Especial">
            <input type="hidden" name="sal" value="4">
            <input type="hidden" name="radioSeleccion" value="">
		<tr>
		<td class="FondoFormRegistro">
			<table border=0>
			<tr>
			<td valign="top"  width="160">Tipo de Documento:</td>
			<td valign="top">
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
			<td  width="160">Fecha Registro:</td>
			<td><input type="text" name="reloj" class="FormPropertReg form-control" style="width:120px" onfocus="window.document.frmRegistro.reloj.blur()"></td>
			</tr>
			
			<tr>
			<td valign="top"  width="160">Oficina Solicitante:</td>
			<td>
							<select name="iCodOficinaSolicitado" style="width:300px;" class="FormPropertReg form-control">
							<option value="">Seleccione Oficina:</option>
							<?
							$sqlDep2="SELECT * FROM Tra_M_Oficinas ";
              $sqlDep2.= "ORDER BY cNomOficina ASC";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
				  if(trim($_POST[iCodOficinaSolicitado])=="" && $RsDep2['iCodOficina']==$_SESSION['iCodOficinaLogin']){
					$selecOfi="selected";
              	}
               else	if(trim($_POST[iCodOficinaSolicitado])!="" && $RsDep2['iCodOficina']==$_POST[iCodOficinaSolicitado]){
              		$selecOfi="selected";
              	}
			   Else{
              		$selecOfi="";
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
						$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodRef]'";
          	$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
						?>
						<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?><a href="registroData.php?iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=19&iCodTramite=<?=$_GET[iCodTramite]?>&sal=4&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&iCodOficinaSolicitado=<?php echo $_POST["iCodOficinaSolicitado"]; ?>&cNombreRemitente=<?=$_POST[cNombreRemitente]?>&cNomRemite=<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>&iCodRemitente=<?=$_POST[iCodRemitente]?>&Remitente=<?=$_POST[Remitente]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="13" height="13"></a></span>&nbsp;
                       	
						<?php}?>

			</td>
			</tr>
			
			<tr>
			<td valign="top"  width="160">Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:336px;height:55px" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea>
					&nbsp;&nbsp;
			</td>
			<td valign="top"  width="160">Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:320px;height:55px" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea>
			</td>
			</tr>

			<tr>
				<td valign="top" >Requiere Respuesta:</td>
				<td>Si<input type="radio" name="nFlgRpta" value="1" <?php if($_POST[nFlgRpta]==1) echo "checked"?> /> &nbsp; No<input type="radio" name="nFlgRpta" value="" <?php if($_POST[nFlgRpta]=="") echo "checked"?> /></td>
			</tr>
			
			<tr>
				<td valign="top" >Folios:</td>
				<td><input type="text" name="nNumFolio" value="<?php if(trim($_POST[nNumFolio])!=""){echo $_POST[nNumFolio];}else{echo 1;}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" />&nbsp;<span class="FormCellRequisito"></span></td>
				<td valign="top"  width="160">Fecha Plazo:</td>
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
				<td><input type="text" style="width:60px;text-transform:uppercase" name="cSiglaAutor" value="<?=$_POST[cSiglaAutor]?>" class="FormPropertReg form-control"  /></td>
			</tr>

			<tr>
			<td valign="top" >Destino:</td>
			<td valign="top" colspan="3">
					<table border=0><tr>
          <td valign="top"><input type="radio" name="radioMultiple" onclick="activaMultiple();">M�ltiple</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td valign="top"><input type="radio" name="radioRemitente" onclick="activaRemitente();">Un Destino</td>
					<td>
							<div style="display:none" id="areaRemitente">
									<table cellpadding="0" cellspacing="2" border="0">
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Institución:&nbsp;</td>
									<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?=$_POST[cNombreRemitente]?>" style="width:300px" readonly></td>
									<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
									<td align="center"></td>
									</tr>
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Destinatario:&nbsp;</td>
									<td colspan="1"><input id="cNomRemite" name="cNomRemite" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:300px" ></td>
                                      <td align="left">
                                    <div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;text-align:center"><a style=" text-decoration:none" href="javascript:;"  onClick="infoRemitente(this);">+ Datos</a> </div></td>
									</tr>
									</table>
							</div>
                            		<input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$_POST[iCodRemitente]?>" />
                   		<input id="Remitente" name="Remitente" type="hidden" value="<?=$_POST[iCodRemitente]?>">	
                        <input id="txtdirec_remitente" name="txtdirec_remitente" type="hidden" value="<?=$_POST[txtdirec_remitente]?>">
                            <input id="cCodDepartamento" name="cCodDepartamento" type="hidden" value="<?=$_POST[cCodDepartamento]?>">
                            <input id="cCodProvincia" name="cCodProvincia" type="hidden" value="<?=$_POST[cCodProvincia]?>">
                            <input id="cCodDistrito" name="cCodDistrito" type="hidden" value="<?=$_POST[cCodDistrito]?>">					</td>
					</tr></table>
			</td>
			</tr>
				<?php if($_POST[radioSeleccion]==1){?>
					 <script language="javascript" type="text/javascript">
					 	activaMultiple();
					 </script>
				<?php}?>
				<?php if($_POST[radioSeleccion]==2){?>
					 <script language="javascript" type="text/javascript">
					 	activaRemitente();
					 </script>
				<?php}?>		
           			           
			<tr>
			<td colspan="4"> 
					<input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="Registrar();">
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