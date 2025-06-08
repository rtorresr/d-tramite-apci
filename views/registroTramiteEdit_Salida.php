<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroTramiteEdit.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Modificar el Registro de un Documento y sus Movimientos
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   Larry Ortiz       24/01/2011    Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
?>
<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link rel="stylesheet" href="css/detalle.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
function activaOficinax()
{
document.frmEdicion.radioMultiple.checked = false;
document.frmEdicion.radioOficina.checked = true;
document.frmEdicion.radioSeleccion.value="1";
muestra('areaOficina');
document.getElementById('areaMultiple').style.display = 'none';
return false;
}

function activaMultiplex()
{
document.frmEdicion.radioMultiple.checked = true;
document.frmEdicion.radioOficina.checked = false;
document.frmEdicion.radioSeleccion.value="2";
muestra('areaMultiple');
document.getElementById('areaOficina').style.display = 'none';
return false;
}

function activaRemitente()
{
document.frmEdicion.radioMultiple.checked = false;
document.frmEdicion.radioRemitente.checked = true;
document.frmEdicion.iCodRemitente.value=document.frmRegistro.Remitente.value;
document.frmEdicion.radioSeleccion.value="2";
muestra('areaRemitente');
return false;
}

function activaMultiple()
{
document.frmEdicion.radioMultiple.checked = true;
document.frmEdicion.radioRemitente.checked = false;
document.frmEdicion.iCodRemitente.value=0;
document.frmEdicion.radioSeleccion.value="1";
document.getElementById('areaRemitente').style.display = 'none';
return false;
}

function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}

function muestra(nombrediv) {
   if(document.getElementById(nombrediv).style.display == '') {
      document.getElementById(nombrediv).style.display = 'none';
   } else {
      document.getElementById(nombrediv).style.display = '';
          }
   }
function seleccionar_todo(){
	for (i=0;i<document.frmEdicion.elements.length;i++)
		if(document.frmEdicion.elements[i].type == "checkbox")	
			document.frmEdicion.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.frmEdicion.elements.length;i++)
		if(document.frmEdicion.elements[i].type == "checkbox")	
			document.frmEdicion.elements[i].checked=0
}
function AddOficina(){
	if (document.frmEdicion.iCodOficinaMov.value.length == "")
  {
    alert("Seleccione Oficina");
    document.frmEdicion.iCodOficinaMov.focus();
    return (false);
  }
	if (document.frmEdicion.iCodTrabajadorMov.value.length == "")
  {
    alert("Seleccione Trabajador");
    document.frmEdicion.iCodTrabajadorMov.focus();
    return (false);
  }
	if (document.frmEdicion.iCodIndicacionMov.value.length == "")
  {
    alert("Seleccione Indicación");
    document.frmEdicion.iCodIndicacionMov.focus();
    return (false);
  }  
  document.frmEdicion.opcion.value=14;
  document.frmEdicion.action="registroDataEdicion.php";
  document.frmEdicion.submit();
}
function releer(){
  document.frmEdicion.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodTramite=<?=$_GET[iCodTramite]?>&clear=1#area";
  document.frmEdicion.submit();
}

function Registrar()
{
  if(document.frmEdicion.nFlgTipoDocx.value==3){
	   if (document.frmEdicion.iCodRemitente.value.length == "")
 		 {
   		   document.frmEdicion.iCodRemitenteS.value=-1;
  		 }  
  	  document.frmEdicion.opcion.value=16;	
  }
 
  document.frmEdicion.action="registroDataEdicion.php";
  document.frmEdicion.submit();
}
function ConfirmarBorrado1(){
 if (confirm("Esta seguro de eliminar el Movimiento?")){
  return true; 
 }else{ 
  return false; 
 }
}
function ConfirmarBorrado2(){
 if (confirm("Esta seguro de eliminar esta copia?")){
  return true; 
 }else{ 
  return false; 
 }
}
//--></script>
<meta http-equiv="Content-Type" content="text/html; charset=UFT-8" />
<style type="text/css">
body {
	background-image: url(images/background.jpg);
}
</style>
</head>
<body  >

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

<div class="AreaTitulo">Editar Documento</div>
<table class="table">
 <tr>

<form name="frmEdicion" method="POST" >
  
<?
  $fDesde=date("Ymd H:i", strtotime($_GET['fDesde']));
  $fHasta=date("Ymd H:i", strtotime($_GET['fHasta']));
	
	/*
	$fHasta=date("Y-m-d H:i", strtotime($_GET['fHasta']));
	
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd H:i", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
	}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
	*/
	 
    $sqlCod=" SELECT * FROM Tra_M_Tramite WHERE  Tra_M_Tramite.iCodTramite='$_POST[iCodTramite]' ";
	$rsCod=sqlsrv_query($cnx,$sqlCod);
	$numrows=sqlsrv_has_rows($rsCod);
    if($numrows==0){ 
		echo "No Se Encuentra ese Documento<br>";
    }
	else {
	$RsCod=sqlsrv_fetch_array($rsCod);
	 ?> 
    <input type="hidden" name="iCodTramite" value="<?=trim($RsCod[iCodTramite])?>">
    <input type="hidden" name="nFlgClaseDoc" value="<?=trim($RsCod[nFlgClaseDoc])?>">
    <input type="hidden" name="opcion" value="">
    <input type="hidden" name="tupa" value="1">
    <input type="hidden" name="cCodificacion" value="<?=trim($RsCod[cCodificacion])?>">
    <input type="hidden" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>">
    <input type="hidden" name="nFlgTipoDocx" value="<?php if($_GET[clear]==""){ if($RsCod[nFlgTipoDoc]!="" ){echo trim($RsCod[nFlgTipoDoc]);}} else {echo trim($_POST[nFlgTipoDoc]);} ?>">
    <input type="hidden" name="cReferenciaOriginal" value="<?=trim($RsCod[cReferencia])?>">
    <input type="hidden" name="iCodTrabajadorSolicitado" value="<?=trim($RsCod[iCodTrabajadorSolicitado])?>">
    <input type="hidden" name="radioSeleccion" value="">	
    <input type="hidden" name="nCodBarra" value="<?=trim($RsCod[nCodBarra])?>">
   <?
	$sqlMovx="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsCod[iCodTramite]' ORDER BY iCodMovimiento DESC";
    $rsMovx=sqlsrv_query($cnx,$sqlMovx);
	$RsMovx=sqlsrv_fetch_array($rsMovx);
    echo "<input type=hidden name=iCodOfi value=".$RsMovx[iCodOficinaDerivar].">";
    echo "<input type=hidden name=iCodTra value=".$RsMovx[iCodTrabajadorDerivar].">";
   ?>
	<input type="hidden" name="UpdTrabajador" value="<?=$RsMovx[iCodTrabajadorDerivar]?>">
	<input type="hidden" name="iCodMovimiento" value="<?=$RsMovx[iCodMovimiento]?>"> 
 <?
	// consulta de los datos relacionados del documento
	 $sql=" SELECT   *  ";
	 $sql.=" FROM  Tra_M_Tramite LEFT JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ";
	 $sql.=" LEFT JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite LEFT JOIN ";
	 $sql.=" Tra_M_Oficinas  ON Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Movimientos.iCodOficinaDerivar ";
	 $sql.=" WHERE  Tra_M_Tramite.iCodTramite='$RsCod[iCodTramite]' AND Tra_M_Tramite.cCodificacion='$RsCod[cCodificacion]' ";
     $sql.=" ORDER BY Tra_M_Tramite.iCodTramite DESC";	   
     $rs=sqlsrv_query($cnx,$sql);
	    //echo $sql;
 ?>
     <br>
   <table width="950" border="0" align="center">
	 <tr>
	  <td>
		<fieldset id="tfa_GeneralDoc" class="fieldset">
		<legend class="LnkZonas"><strong>Documento N&ordm;: <?=$RsCod[cCodificacion]?></strong> </legend>
	      <br>
        <table width="950" border="0" align="center">
        <tr>
		    <td>   
            <fieldset id="tfa_GeneralDoc" class="fieldset">
			<legend class="legend"><a href="javascript:;" onClick="muestra('zonaAdicionalDcoumento')" class="LnkZonas">Datos Adicionales del Documento  <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend><div  id="zonaAdicionalDcoumento">
		      <table border="0" width="992">
		        <tr>
		          <td width="122" >Tipo de Registro:&nbsp;</td>
		          <td width="364" align="left">
                    <select name="nFlgTipoDoc" class="FormPropertReg form-control" style="width:180px" onChange="releer();" >
					<option value="">Seleccione:</option>
                    <option <?php if($_GET[clear]==""){ if($RsCod[nFlgTipoDoc]==1 ){echo "selected";}} else {if($_POST[nFlgTipoDoc]==1){echo "selected";}} ?> value="1">Entrada</option>
                    <option <?php if($_GET[clear]==""){ if($RsCod[nFlgTipoDoc]==2 ){echo "selected";}} else {if($_POST[nFlgTipoDoc]==2){echo "selected";}}?> value="2">Interno</option>
                    <option <?php if($_GET[clear]==""){ if($RsCod[nFlgTipoDoc]==3 ){echo "selected";}} else {if($_POST[nFlgTipoDoc]==3){echo "selected";}}?> value="3">Salida</option>
                    <option <?php if($_GET[clear]==""){ if($RsCod[nFlgTipoDoc]==4 ){echo "selected";}} else {if($_POST[nFlgTipoDoc]==4){echo "selected";}}?> value="4">Anexo</option>
                    </select></td>
                  <td width="148" >Trabajador de Registro:&nbsp;</td>
		          <td width="340" align="left"><select name="iCodTrabajadorRegistro" style="width:340px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
					<? $sqlTrb="SP_TRABAJADORES_LISTA_COMBO ";
                       $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                       while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	       if($RsTrb[iCodTrabajador]==$RsCod[iCodTrabajadorRegistro]){
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
		          <td width="122" ></td>
		          <td width="364" align="left">
                    </td>
		          <td width="148" ></td>
		          <td align="left"> 
                    
                  </td>
		        </tr>
		        <tr>
		          <td width="122" >Oficina:</td>
		          <td align="left">
                  <select name="iCodOficinaRegistro" style="width:340px;" class="FormPropertReg form-control" <?/*if($RsTupDat['iCodOficina']=="") echo "disabled"*/?> <?php if($Rs[nFlgEnvio]==1) echo "disabled"?>>
							<?
							 $sqlReg="SP_OFICINA_LISTA_COMBO "; 
                  $rsReg=sqlsrv_query($cnx,$sqlReg);
	                while ($RsReg=sqlsrv_fetch_array($rsReg)){
	  	            	if($RsReg["iCodOficina"]==$RsCod[iCodOficinaRegistro]){
												$selecReg="selected";
          	        }Else{
          		      		$selecReg="";
                   	}
                 	echo "<option value=".$RsReg["iCodOficina"]." ".$selecReg.">".$RsReg["cNomOficina"]."</option>";
                  }
                  sqlsrv_free_stmt($rsReg);
							
					
							?>
							</select>
                    </td>
		          <td width="148" >Jefe de Oficina:&nbsp;</td>
		          <td align="left"><select name="iCodTrabajadorSolicitado" style="width:340px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
				    <? $sqlTrb=" SP_TRABAJADORES_LISTA_COMBO";
                       $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                       while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	       if($RsTrb[iCodTrabajador]==$RsCod[iCodTrabajadorSolicitado]){
              		   $selecTrab="selected";
              	       }Else{
              		   $selecTrab="";
              	       }
                       echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                       }
                       sqlsrv_free_stmt($rsTrb);
					?> </select>
                   </td>
		        </tr>   
                 <tr>
		          <td >&nbsp;</td>
		          <td align="left">&nbsp;</td>
		          <td >Anulado:</td>
		          <td align="left">
				  <?
					if($_GET[clear]==""){
							if($RsCod[nFlgAnulado]==1){
									$marcarEnvioA="checked";
							}
					}Else{
							if($_POST[nFlgAnulado]==1){
									$marcarEnvioA="checked";
							}
					}
					?>
					<?php if($RsCod[nFlgAnulado]==1){?>
						<input type="checkbox" name="nFlgAnulado" value="1" checked >
					<?php } else{?>
						<input type="checkbox" name="nFlgAnulado" value="1" <?=$marcarEnvioA?>>
					<?php}?></td>
		          </tr>          
		      </table>
              </div>
		  	  <img src="images/space.gif" width="0" height="0">
	        </fieldset>
		    </td>
		  </tr>
		 
		  <tr>
		    <td>
			<fieldset id="tfa_GeneralDoc" class="fieldset">
			<legend class="legend"><a href="javascript:;" onClick="muestra('zonaGeneral')" class="LnkZonas">Datos Generales del Documento  <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend><div id="zonaGeneral">
		      <table border=0>
			
			 <tr>
		          <td width="135" >Fecha del Documento:&nbsp;</td>
		          <td width="168" align="left">
                  <input type="txt" name="fFecDocumento" value="<?php echo date('d-m-Y', strtotime($RsCod['fFecDocumento']))." ".date('G:i', strtotime($RsCod['fFecDocumento']));?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="184" align="left"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDocumento,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		          <td width="135"  align="left">Fecha de Registro:&nbsp;</td>
		          <td width="179" align="left" ><input type="txt" name="fFecRegistro" value="<?php echo date("d-m-Y", strtotime($RsCod['fFecRegistro']))." ".date("G:i", strtotime($RsCod['fFecRegistro']));?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="183" align="left" ><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		         
		        
		        </tr> 
			<tr>
			<td valign="top"  width="113">Tipo de Documento:</td>
			<td colspan="2" valign="top" align="left">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgSalida=1 ORDER BY cDescTipoDoc ASC";
          $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          	if($_GET[clear]==""){
          			if($RsTipo["cCodTipoDoc"]==$RsCod[cCodTipoDoc]){
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
			<td  width="101">N&ordm; del Tramite:</td>
			<td colspan="3" style="padding-top:5px;" align="left">

			<td><input type="text" name="cCodificacion" value="<?php if($RsCod[nFlgTipoDoc]==4){
				  $codigo= explode("-",$RsCod[cCodificacion]); echo trim($codigo[0]);}else{echo trim($RsCod[cCodificacion]);}?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:150px" /></td>

				</tr></table>
            <? /*date("d-m-Y H:i", strtotime($Rs['fFecDocumento'])) */?></td>
			</tr>			
			<tr>
			<td valign="top" >Asunto, Asunto:</td>
			<td colspan="2" valign="top" align="left">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsCod['cAsunto']); }Else{ echo trim($_POST['cAsunto']);}?></textarea>
			</td>
			<td valign="top" >Observaciones:</td>
			<td colspan="3" valign="top" align="left">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsCod[cObservaciones]); }Else{ echo trim($_POST[cObservaciones]);}?></textarea>
			</td>
			</tr>	

			<tr>
				<td valign="top" >Requiere Respuesta:</td>
				<td colspan="2" align="left">
					<?
					if($_GET[clear]==""){
							$nFlgRpta=$RsCod[nFlgRpta];
					}Else{
							$nFlgRpta=$_POST[nFlgRpta];
					}
					?>
					Si<input type="radio" name="nFlgRpta" value="1" <?php if($nFlgRpta==1) echo "checked"?> /> &nbsp; 
					No<input type="radio" name="nFlgRpta" value="" <?php if($nFlgRpta=="") echo "checked"?> />					
				</td>
            <td valign="top"  width="101">Referencia:</td>
			<td colspan="3" valign="top" align="left">
						<table><tr>
					<td align="center"><input type="text" readonly="readonly" name="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia]); }Else{ echo trim($_POST[cReferencia]);}?>" class="FormPropertReg form-control" style="width:140px;text-transform:uppercase" />
                    <input type="hidden" name="iCodTramiteRef"  value="<?=$_REQUEST[iCodTramiteRef]?>"  />
                    </td>
					<td align="center"><div class="btn btn-primary" style="width:50px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="AddReferencia();">A�adir</a> </div></td>
					<td align="center"><div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar Registro</a> </div></td>
					</tr></table>
                    <table border=0><tr><td>
						<?
						$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='$RsCod[iCodTramite]'";
          	$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
						?>
						<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?><a href="registroData.php?iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=20&iCodTramite=<?=$_GET[iCodTramite]?>&sal=3&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="13" height="13"></a></span>&nbsp;
						<?php}?>

			</td>    
			</tr>
			
			<tr>
				<td valign="top" >Folios:</td>
				<td colspan="2" align="left"><input type="text" name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($RsCod[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" />&nbsp;<span class="FormCellRequisito"></span></td>
				<td valign="top"  width="101">Fecha Plazo:</td>
				<td colspan="3" valign="top" align="left">
							<?
							if($_GET[clear]==""){
								if($RsCod[fFecPlazo]!=""){
											$fFecPlazo=date("d-m-Y", strtotime($RsCod[fFecPlazo]));
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
				<td colspan="2" valign="top" align="left">
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
				<td colspan="3" align="left"><input type="text" style="width:60px;text-transform:uppercase" name="cSiglaAutor" value="<?php if($_GET[clear]==""){ echo $RsCod[cSiglaAutor]; }Else{ echo $_POST[cSiglaAutor];}?>" class="FormPropertReg form-control" /></td>
			</tr>
			
			<tr>
			<td valign="top" >Destino:</td>
			<td valign="top" colspan="6" align="left">
					<table><tr>
          <td valign="top"><input type="radio" name="radioMultiple" onclick="activaMultiple();" <?php if($RsCod[iCodRemitente]==""){ echo "checked";} ?>>Multiple</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td valign="top"><input type="radio" name="radioRemitente" onclick="activaRemitente();" <?php if($RsCod[iCodRemitente]!=""){ echo "checked";} ?>>Un Destino</td>
					<td valign="top">
							<div <?php if($RsCod[iCodRemitente]=="") echo "style=\"display:none\""; ?> id="areaRemitente">
									<?
									if($RsCod[iCodRemitente]!=""){
											$sqlRem="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$RsCod[iCodRemitente]'";
          						$rsRem=sqlsrv_query($cnx,$sqlRem);
          						$RsRem=sqlsrv_fetch_array($rsRem);
          						$iCodRemitente=$RsCod[iCodRemitente];
          				}
									?>
									<table cellpadding="0" cellspacing="2" border="0">
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Institución:&nbsp;</td>
									<td><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?=$RsRem['cNombre']?>" style="width:300px" readonly></td>
									<td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a> </div></td>
									<td align="center"><div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a> </div></td>
									</tr>
									<tr>
									<td align="right" width="70" style="color:#7E7E7E">Destinatario:&nbsp;</td>
									<td colspan="3"><input id="cNomRemite" name="cNomRemite" value="<?=trim($RsCod[cNomRemite])?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:300px" ></td>
									</tr>
									</table>
									
							</div>
                            <input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$iCodRemitente?>">
                            <input id="Remitente" name="Remitente" type="hidden" value="<?=$_REQUEST[iCodRemitente]?>">	
					</td>
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
			<td valign="top" >Copias:</td>
			<td colspan="6" align="left">
					<table border=1>
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

					<tr>
					<td class="headColumnas" width="200">Oficina</td>
					<td class="headColumnas" width="200">Trabajador</td>
					<td class="headColumnas" width="120">Indicacion</td>
					<td class="headColumnas" width="100">Prioridad</td>
					<td class="headColumnas" width="60">Opcion</td>
					</tr>
					<?
					$sqlMovs="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]' AND cFlgOficina=1 ORDER BY iCodMovimiento ASC";
          $rsMovs=sqlsrv_query($cnx,$sqlMovs);
          $ContarMov=1;
          while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
					?>
					<tr bgcolor="#FFE8E8">
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
					<td align="center">
						<a href="registroData.php?iCodMovimiento=<?=$RsMovs[iCodMovimiento]?>&iCodTramite=<?=$_GET[iCodTramite]?>&opcion=22&cCodTipoDoc=<?php if($_GET[clear]==""){ echo $Rs[cCodTipoDoc]; }Else{ echo $_POST[cCodTipoDoc];}?>&cReferencia=<?php if($_GET[clear]==""){ echo $Rs[cReferencia]; }Else{ echo $_POST[cReferencia];}?>&cAsunto=<?php if($_GET[clear]==""){ echo $Rs['cAsunto']; }Else{ echo $_POST['cAsunto']; }?>&cObservaciones=<?php if($_GET[clear]==""){ echo $Rs[cObservaciones]; }Else{ echo $_POST[cObservaciones]; }?>&iCodIndicacion=<?php if($_GET[clear]==""){ echo $Rs[iCodIndicacion]; }Else{ echo $_POST[iCodIndicacion];}?>&nFlgRpta=<?php if($_GET[clear]==""){ echo $Rs[nFlgRpta]; }Else{ echo $_POST[nFlgRpta];}?>&nNumFolio=<?php if($_GET[clear]==""){ echo $Rs[nNumFolio]; }Else{ echo $_POST[nNumFolio];}?>&fFecPlazo=<?php if($_GET[clear]==""){ echo $Rs[fFecPlazo]; }Else{ echo $_POST[fFecPlazo]; }?>&nFlgEnvio=<?php if($_GET[clear]==""){ echo $Rs[nFlgEnvio]; }Else{ echo $_POST[nFlgEnvio]; }?>&URI=<?=$_GET[URI]?>"><img src="images/icon_del.png" border="0" width="16" height="16"></a>
					</td>
					</tr>
					<?
          }
					?>
		
					</table>
			</td>
			</tr>

			
			</table>
              </div>
		  	  <img src="images/space.gif" width="0" height="0">
	        </fieldset>
		    </td>
		  </tr>
		   <tr>
		    <td>   
	          <fieldset id="tfa_GeneralEmp" class="fieldset">
		      <legend class="legend"><a href="javascript:;" onClick="muestra('zonaAnexo')" class="LnkZonas">Datos de Movimiento del Documento  <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend><div id="zonaAnexo">
                <table  border="0" width="1000" cellpadding="3" cellspacing="3" align="center">
                  <tr>
	           <td class="headCellColum" width="150">Tipo Documento</td>
               <td class="headCellColum" width="75">Fecha</td>
		       <td class="headCellColum" width="260">Asunto</td>
		       <td class="headCellColum" width="140">Observaciones</td>
		       <td class="headCellColum">Origen</td>
		       <td class="headCellColum">Destino</td>
               <td class="headCellColum" width="120">Fecha de Aceptado</td>
               <td class="headCellColum">Estado</td>
               <td class="headCellColum" width="120">Avances</td>
                 <td class="headCellColum" width="30">Opciones</td>
	              </tr>
                <?
					$sqlM="SELECT * FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite='$RsCod[iCodTramite]' OR iCodTramiteRel='$RsCod[iCodTramite]')  AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) ORDER BY iCodMovimiento ASC";
		   	$rsM=sqlsrv_query($cnx,$sqlM);
				$recorrido=1;
                    $numrows=sqlsrv_has_rows($rsM);
                    if($numrows==0){ 
		            echo "";
                    }else{
                    while ($RsM=sqlsrv_fetch_array($rsM)){
        		    if ($color == "#DDEDFF"){
			  			$color = "#F9F9F9";
	    			    }else{
			  			$color = "#DDEDFF";
	    			}
	    			if ($color == ""){
			  			$color = "#F9F9F9";
	    			}	
               ?>
           <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
                <td valign="top">
		       	<?
			      $sqlTpDcM="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsM[cCodTipoDocDerivar]'";
			      $rsTpDcM=sqlsrv_query($cnx,$sqlTpDcM);
				 // echo $sqlTpDcM;
			      $RsTpDcM=sqlsrv_fetch_array($rsTpDcM);
		       	switch ($RsM[cFlgTipoMovimiento]) {
  					case 1: //moviemiento normal
						if($recorrido==1){
							echo "<div style=color:#005EBB><b>".$RsCod[cCodificacion]."<b></div>";	
							echo $RsTpDcM['cDescTipoDoc'];
			      			echo "<div style=color:#808080;text-transform:uppercase>".$RsCod['cNroDocumento']."</div>";
			      		}
						else
						{
						echo $RsTpDcM['cDescTipoDoc'];
						echo "<br>";
			      		//echo "<div>".$Rs[cReferencia]."</div>";
			      		echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$RsM['iCodTramiteDerivar']."\" rel=\"lyteframe\" title=\"Detalle del Documento\" rev=\"width: 850px; height: 370px; scrolling: auto; border:no\">";
							echo $RsM['cNumDocumentoDerivar'];
							echo "</a><br>"; 
							echo "<b>Interno<b>";
							//	echo "<div style=color:#808080>".$RsM['cNumDocumentoDerivar']."</div>";
						}
			     	break;
			     	case 3: //movimiento anexo
				  $sqlAnexo="SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite='$RsM[iCodTramite]' ";
			      $rsAnexo=sqlsrv_query($cnx,$sqlAnexo);
			      $RsAnexo=sqlsrv_fetch_array($rsAnexo);
						    echo "<div style=color:#005EBB><b>".$RsAnexo[cCodificacion]."<b></div>";
			     			echo $RsTpDcM['cDescTipoDoc'];
			     			echo "<div style=color:#008000><b>Anexo<b></div>";
			     	break;
			     	case 5: //movimiento referencia
							//echo $RsM['iCodTramiteDerivar'];
			     			echo $RsTpDcM['cDescTipoDoc'];
			     			echo "<div style=color:#808080><b>".$RsM[cReferenciaDerivar]."<b></div>";
				  $sqlTipo="SELECT nFlgTipoDoc FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='".$RsM['iCodTramiteDerivar']."' ";
			      $rsTipo=sqlsrv_query($cnx,$sqlTipo);
			      $RsTipo=sqlsrv_fetch_array($rsTipo);
						if($RsTipo[nFlgTipoDoc]==3){	
						echo "<b>Referencia : Salida<b>";}
						else if($RsTipo[nFlgTipoDoc]==2){
								echo "<b>Referencia : Interno<b>";
						}
						else if($RsTipo[nFlgTipoDoc]==1){
								echo "<b>Referencia : Entrada<b>";
						}
			     	break;			     	
			     	}
		       	?>
		    </td>
            <td valign="top"> 
		       		<span><?=date("d-m-Y", strtotime($RsM['fFecDerivar']))?></span>
		    </td>
		    <td valign="top" align="left">
		       		<?
						
		       		if($contaMov==0){
		       			echo $RsCod['cAsunto'];
						if(trim($Rs['iCodTupa'])!=""){
    				$sqlTup=" SP_TUPA_LISTA_AR '".$Rs['iCodTupa']."'";
      				$rsTup=sqlsrv_query($cnx,$sqlTup);
      				$RsTup=sqlsrv_fetch_array($rsTup);
					echo "<div style=color:#0154AF>".$RsTup[cNomTupa]."</div>";}
					   }Else{
		       			echo $RsM[cAsuntoDerivar];
					   		}
		       		?>
		    </td>
		    <td valign="top" align="left">
		     	 		<?
		     	 		if($contaMov==0){
		       			echo $RsCod[cObservaciones];
		       		}Else{
		       			echo $RsM[cObservacionesDerivar];
		       		}
		     	 		?>
		     	 </td>
		     	 
		       <td valign="top"> <? 
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaOrigen]'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	 ?>
		       </td>
		     	 <td valign="top"> <?
		     	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaDerivar]'";
			       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
		     	 		echo "<a href=\"javascript:;\" title=\"".trim($RsOfiD[cNomOficina])."\">".$RsOfiD[cSiglaOficina]."</a>";
		     	 	?>
		     	 </td>
                 <td align="center" valign="top">
                 <?
				 if($RsM[cFlgTipoMovimiento]!=6 or $RsM[cFlgTipoMovimiento]!=5){	
        	if($RsM[fFecRecepcion]==""){
				 if($RsM[nFlgTipoDoc]==3){
					 echo "";
					 }
				else{	 
        			echo "<div style=color:#ff0000>sin aceptar</div>";
				}
        	}Else{
        			echo "<div style=color:#0154AF>aceptado</div>";
        			echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsM[fFecRecepcion]))."</div>";
        			echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsM[fFecRecepcion]))."</div>";
        	}
				 }
				 else{echo "";}
        	?>
                 </td>
                 
                 <td valign="top" align="">
                 <?
				  if($RsM[cFlgTipoMovimiento]!=6 or $RsM[cFlgTipoMovimiento]!=5){	
				 if($RsM[fFecRecepcion]!=""){
                 switch ($RsM['nEstadoMovimiento']) {
  						case 1:
  							echo "En Proceso";
  						break;
  						case 2:
  							echo "Derivado";
  						break;
  						case 3:
  							echo "Delegado";
							if($RsM['iCodTrabajadorDelegado']!=""){
  					$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsM['iCodTrabajadorDelegado']'");
          	$RsDelg=sqlsrv_fetch_array($rsDelg);
          	echo "<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>";
						sqlsrv_free_stmt($rsDelg);
					}
  						break;
						case 4:
  							echo "Respondido";
  						break;
  						case 5:
  							echo "Finalizado";
  						break;
  						}
				 }else {
					 if($RsM[nFlgTipoDoc]==3){
					 echo "";
					 }
					 else {echo "Pendiente";}
				 }
				  }else { echo "";}
					?>		
                 
                 </td>
                 
		     	 <td valign="top">
		     	 	<?
		     	 	if($RsM[cFlgTipoMovimiento]==1){
			     			$sqlAvan="SELECT * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento='$RsM[iCodMovimiento]' ORDER BY iCodAvance DESC";
            		$rsAvan=sqlsrv_query($cnx,$sqlAvan);
            		while ($RsAvan=sqlsrv_fetch_array($rsAvan)){
		     	 					$rsTrbA=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsAvan[iCodTrabajadorAvance]'");
          					$RsTrbA=sqlsrv_fetch_array($rsTrbA);
          					echo "<div style=font-size:10px;color:#623100>".$RsTrbA["cApellidosTrabajador"]." ".$RsTrbA["cNombresTrabajador"].":</div>";
										sqlsrv_free_stmt($rsTrbA);
										echo "<div style=font-size:10px;color:#808080>".date("d-m-Y G:i", strtotime($RsAvan[fFecAvance]))."&nbsp;</div>";
		     	 					echo "<div style=font-size:10px>".$RsAvan[cObservacionesAvance]."</div>";
		     	 					echo "<hr>";
		    				}
		    		}
					if($RsM[cFlgTipoMovimiento]==5){
						$sqlRp= " SELECT cRptaOk FROM Tra_M_Tramite WHERE cCodificacion ='$RsM[cReferenciaDerivar]'";
						$rsRp=sqlsrv_query($cnx,$sqlRp);
						$RsRp=sqlsrv_fetch_array($rsRp);
						echo $RsRp[cRptaOk];
					
					}
		     	 	?>
		     	 </td>
		     	 <td valign="top" align="center">	
                <a href="registroDataEdicion.php?id=<?=$RsM[iCodMovimiento];?>&opcion=25&idt=<?=$RsCod[iCodTramite];?>" onClick='return ConfirmarBorrado1();'"><i class="far fa-trash-alt"></i></a>
     	<a style=" text-decoration:none" href="registroTramiteMov.php?idt=<?=$RsCod[iCodTramite];?>&id=<?=$RsM[iCodMovimiento];?>"><i class="fas fa-edit"></i></a>
        
        </td>
                </tr>
              <?
			   $contaMov++;
		    $recorrido++;
				   }
                 }
              ?> 
              </table>
              </div>
		  	  <img src="images/space.gif" width="0" height="0"> 
            </fieldset>
		    </td>
		  </tr>
          <tr>
		<td>   
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
		   	$sqlCop="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsCod[iCodTramite]' AND cFlgTipoMovimiento=4 ORDER BY iCodMovimiento ASC";
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
                 <a href="registroDataEdicion.php?id=<?=$RsCop[iCodMovimiento];?>&opcion=24&idt=<?=$RsCod[iCodTramite];?>" onClick='return ConfirmarBorrado2();'"><i class="far fa-trash-alt"></i></a>
     		<a style=" text-decoration:none" href="registroTramiteCop.php?idt=<?=$RsCod[iCodTramite];?>&id=<?=$RsCop[iCodMovimiento];?>"><i class="fas fa-edit"></i></a>
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
			<td colspan="4" align="center">
					<button class="btn btn-primary"  type="button" id="Actualizar"  onclick="Registrar();" onMouseOver="this.style.cursor='hand'"> <b>Actualizar</b> <img src="images/page_refresh.png" width="17" height="17" border="0"> </button>
             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="btn btn-primary" type="button" onclick="window.open('registroTramiteEsp.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
			</td>
			</tr>
        </table >
        </fieldset>
      

      </td>
    </tr>
    
  </table >
  

     <?  
      }
		 
?>
</form>
</td>
 </tr>
   </table>
<div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>