<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroTramiteEdit_Entrada.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
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
function activaRemitente()
{
document.frmEdicion.radioMultiple.checked = false;
document.frmEdicion.radioRemitente.checked = true;
document.frmEdicion.iCodRemitente.value=document.frmRegistro.Remitente.value;
document.frmEdicion.radioSeleccion.value="2";
muestra('areaRemitente');
return false;
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

function releer(){
  document.frmEdicion.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodTramite=<?=$_GET[iCodTramite]?>&clear=1#area";
  document.frmEdicion.submit();
}

function Registrar()
{
  if(document.frmEdicion.nFlgTipoDocx.value==1){
	  if(document.frmEdicion.nFlgClaseDoc.value==1){
	  document.frmEdicion.opcion.value=8;
	  }
	  else  if(document.frmEdicion.nFlgClaseDoc.value==2){
	  document.frmEdicion.opcion.value=9;
 	 }
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


<td width="1087" height="21" background="images/pcm_5.jpg" align="center">
	<?php include("includes/menu.php");?>
</td>
</tr>

<tr>
<td><img width="1088" height="11" src="images/pcm_6.jpg" border="0"></td>
</tr>

<tr>
<td width="1087" height="300" background="images/pcm_7.jpg" align="left" valign="top">


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
<table cellpadding="0" cellspacing="0" border="0" width="1010" align="center">
 <tr>

<form name="frmEdicion" method="POST" >
  
<?
  $fDesde=date("Ymd G:i", strtotime($_GET['fDesde']));
  $fHasta=date("Ymd G:i", strtotime($_GET['fHasta']));
	
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
    <input type="hidden" name="nFlgEnvio" value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
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
   <table width="1030" border="0" align="center">
	 <tr>
	  <td width="1030">
		<fieldset id="tfa_GeneralDoc" class="fieldset">
		<legend class="LnkZonas"><strong>Documento N&ordm;: <?=$RsCod[cCodificacion]?></strong> </legend>
	      <br>
        <table width="1020" border="0" align="center">
        <tr>
		    <td width="1010">   
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
		      <table width="1011" border="0">
			<tr>
		          <td width="104" >Fecha del Documento:&nbsp;</td>
		          <td width="174" align="left">
                  <input type="txt" name="fFecDocumento" value="<?php echo date('d-m-Y', strtotime($RsCod['fFecDocumento']))." ".date('G:i', strtotime($RsCod['fFecDocumento']));?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="169" align="left"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDocumento,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		          <td width="186"  align="left">Fecha de Registro:&nbsp;</td>
		          <td width="211" align="left" ><input type="txt" name="fFecRegistro" value="<?php echo date("d-m-Y", strtotime($RsCod['fFecRegistro']))." ".date("G:i", strtotime($RsCod['fFecRegistro']));?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="141" align="left" ><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		         
		        
		        </tr>
			<tr>
			<td valign="top"  width="104">Tipo de Documento:</td>
			<td colspan="2" valign="top" align="left">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
          $sqlTipo.="ORDER BY cDescTipoDoc ASC";
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
			<td  width="186">N&ordm; del Tramite:</td>
             <td colspan="2" align="left">

			<td><input type="text" name="cCodificacion" value="<?php if($RsCod[nFlgTipoDoc]==4){
				  $codigo= explode("-",$RsCod[cCodificacion]); echo trim($codigo[0]);}else{echo trim($RsCod[cCodificacion]);}?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:150px" /></td>

				</tr></table>
            </td>
			<? /*<td style="padding-top:5px;"><b><?=date("d-m-Y H:i", strtotime($Rs['fFecDocumento']))?></td> */?>
			</tr>

			<tr>
			<td valign="top"  width="104">N&ordm; del Documento:</td>
			<td valign="top" colspan="5" align="left"><input type="text" name="cNroDocumento" style="width:250px;text-transform:uppercase" value="<?php if($_GET[clear]==""){ echo trim($RsCod['cNroDocumento']); }Else{ echo $_POST['cNroDocumento'];}?>" class="FormPropertReg form-control"  />&nbsp;<span class="FormCellRequisito">*</span></td>
			</tr>

					<?
					$sqlRmt="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente=$RsCod[iCodRemitente]";
          $rsRmt=sqlsrv_query($cnx,$sqlRmt);
          $RsRmt=sqlsrv_fetch_array($rsRmt);
					?>
			<tr>
			<td valign="top" >Remitente / Institución:</td>
			<td valign="top" colspan="5" align="left">
					<table cellpadding="0" cellspacing="2" border="0">
					<tr>
					
					<td align="left"><input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?php if($_GET[clear]==""){ echo trim($RsRmt['cNombre']); }Else{ echo $_POST[cNombreRemitente];}?>" style="width:380px" readonly></td>
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
			<td valign="top"  width="104">Remite:</td>
			<td valign="top" colspan="5" align="left"><input type="text" name="cNomRemite" style="width:450px;text-transform:uppercase;width:250px;" value="<?php if($_GET[clear]==""){ echo trim($Rs[cNomRemite]); }Else{ echo $_POST[cNomRemite];}?>" class="FormPropertReg form-control"  />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>
			
			
			<tr>
			<td valign="top" >Asunto, Asunto:</td>
			<td colspan="2" valign="top" align="left">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsCod['cAsunto']); }Else{ echo $_POST['cAsunto'];}?></textarea>
					&nbsp;&nbsp;
			</td>
			<td valign="top" >Observaciones:</td>
			<td colspan="2" valign="top" align="left">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsCod[cObservaciones]); }Else{ echo $_POST[cObservaciones];}?></textarea>
			</td>
			</tr>				
	<?php if($RsCod[nFlgClaseDoc]==1 ) { ?>
			<tr>
			<td valign="top"  width="104">Clase de Procedimiento:</td>
			<td valign="top" colspan="5" align="left">
					<select name="iCodTupaClase" class="FormPropertReg form-control" style="width:110px" onChange="releer();" />
					<?
					if($RsCod[nFlgEnvio]==1){
						$sqlClas="SELECT * FROM Tra_M_Tupa_Clase WHERE iCodTupaClase='$RsCod[iCodTupaClase]'";
					}Else{
						echo "<option value=\"\">Seleccione:</option>";
						$sqlClas="SELECT * FROM Tra_M_Tupa_Clase ORDER BY iCodTupaClase ASC";
					}
          $rsClas=sqlsrv_query($cnx,$sqlClas);
          while ($RsClas=sqlsrv_fetch_array($rsClas)){
          	if($_GET[clear]==""){
          			if($RsClas["iCodTupaClase"]==$RsCod[iCodTupaClase]){
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
							$iCodTupaClase=$RsCod[iCodTupaClase];
					}Else{
							$iCodTupaClase=$_POST[iCodTupaClase];
					}
					?>
			<tr>
			<td valign="top"  width="104">Procedimiento:</td>
			<td valign="top" colspan="5" align="left">
					<select name="iCodTupa" class="FormPropertReg form-control" style="width:900px" onChange="releer();" <?php if($iCodTupaClase=="") echo "disabled"?> />
					<?
					if($RsCod[nFlgEnvio]==1){
						$sqlTupa="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='$RsCod['iCodTupa']' ORDER BY iCodTupa ASC";
					}Else{
						echo "<option value=\"\">Seleccione:</option>";
						$sqlTupa="SELECT * FROM Tra_M_Tupa WHERE iCodTupaClase='$iCodTupaClase' ORDER BY iCodTupa ASC";
					}
          $rsTupa=sqlsrv_query($cnx,$sqlTupa);
          while ($RsTupa=sqlsrv_fetch_array($rsTupa)){
          	if($_GET[clear]==""){
          			if($RsTupa["iCodTupa"]==$RsCod['iCodTupa']){
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
			<td valign="top"  width="104">Requisitos:</td>
			<td valign="top" colspan="5" align="left">
					<?
					if($_GET[clear]==""){
							$iCodTupa=$RsCod['iCodTupa'];
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
									$sqlReqChk="SELECT * FROM Tra_M_Tramite_Requisitos WHERE iCodTupaRequisito='$RsTupaReq[iCodTupaRequisito]' AND iCodTramite='$RsCod[iCodTramite]'";
									//echo $sqlReqChk;
          				$rsReqChk=sqlsrv_query($cnx,$sqlReqChk);
          				if(sqlsrv_has_rows($rsReqChk)>0){
          					$Checkear="checked";
									}
							}Else{
									For ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      							$iCodTupaRequisito= $_POST[iCodTupaRequisito];
										if($RsTupaReq[iCodTupaRequisito]==$iCodTupaRequisito[$h]){
   											$Checkear="checked";
										}
									}
							}
          		echo "<tr><td valign=top width=15 align=left><input type=\"checkbox\" name=\"iCodTupaRequisito[]\" value=\"".$RsTupaReq["iCodTupaRequisito"]."\" ".$Checkear."></td><td style=\"color:#004080;font-size:11px\">".$RsTupaReq["cNomTupaRequisito"]."</td></tr>";
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
			<?php } ?>
			<tr>
			<td valign="top"  width="104">Referencia:</td>
			<td valign="top" colspan="5" align="left"><input style="width:250px;text-transform:uppercase" type="text" name="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($RsCod[cReferencia]); }Else{ echo $_POST[cReferencia];}?>" class="FormPropertReg form-control"  /></td>
			</tr>
					<?
					$sqlTupDat="SELECT * FROM Tra_M_Tupa ";
          $sqlTupDat.="WHERE iCodTupa='$iCodTupa'";
          $rsTupDat=sqlsrv_query($cnx,$sqlTupDat);
          $RsTupDat=sqlsrv_fetch_array($rsTupDat);
					?>

			<tr>
			<td valign="top"  width="104">Oficina:</td>
			<td colspan="2" align="left">
							<?
							$sqlMov="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsCod[iCodTramite]' And cFlgTipoMovimiento =1 ORDER BY iCodMovimiento ASC";
              $rsMov=sqlsrv_query($cnx,$sqlMov);
			  $RsMov=sqlsrv_fetch_array($rsMov);
              echo "<input type=hidden name=numMov value=".sqlsrv_has_rows($rsMov).">";
			  echo "<input type=hidden name=iCodMovimientox value=".$RsMov[iCodMovimiento].">";
							?>				
							<select name="iCodOficinaResponsable" style="width:340px;" class="FormPropertReg form-control" <?/*if($RsTupDat['iCodOficina']=="") echo "disabled"*/?> <?php if($Rs[nFlgEnvio]==1) echo "disabled"?>>
							<?
							 $sqlOfi="SP_OFICINA_LISTA_COMBO "; 
                  $rsOfi=sqlsrv_query($cnx,$sqlOfi);
	                while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	            	if($RsOfi["iCodOficina"]==$RsMov[iCodOficinaDerivar]){
												$selecClas="selected";
          	        }Else{
          		      		$selecClas="";
                   	}
                 	echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
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
			<td colspan="2" align="left">
							<select name="iCodTrabajadorResponsable" style="width:340px;" class="FormPropertReg form-control" <? /*if($RsTupDat['iCodOficina']=="") echo "disabled"*/?> <?php if($Rs[nFlgEnvio]==1) echo "disabled"?>>
							<?
							$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$RsMov[iCodOficinaDerivar]' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
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
			<td valign="top"  width="104">Indicación:</td>
			<td colspan="2" valign="top" align="left">
							<select name="iCodIndicacion" style="width:250px;" class="FormPropertReg form-control">
							<option value="">Seleccione:</option>
							<?
							$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
              $sqlIndic .= "ORDER BY cIndicacion ASC";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
              	if($_GET[clear]==""){
              			if($RsIndic[iCodIndicacion]==$RsCod[iCodIndicacion] OR $RsIndic[iCodIndicacion]==3){
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
				<td colspan="2" align="left"><input type="text" name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($RsCod[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>

			<tr>
				<td valign="top"  width="104">Adjuntar Archivo:</td>
				<td colspan="2" valign="top" align="left">
						<?
						$sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$RsCod[iCodTramite]'";
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
				<td valign="top" >Tiempo para Respuesta:</td>
				<td colspan="2" valign="top" class="CellFormRegOnly" align="left"><input type="text" name="nTiempoRespuesta" readonly value="<?=$RsTupDat[nDias]?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/> d�as</td>
			</tr>
					<?
					if($_GET[clear]==""){
							if($RsCod[nFlgEnvio]==1){
									$marcarEnvio="checked";
							}
					}Else{
							if($_POST[nFlgEnvio]==1){
									$marcarEnvio="checked";
							}
					}
					?>
			<tr>
			<td valign="top" >Enviar Inmediatamente:</td>
			<td valign="top" colspan="5" align="left"><?php if($RsCod[nFlgEnvio]==1){?>
						<input type="checkbox" name="nFlgEnvio" value="1" <?=$marcarEnvio?> >
					<?php }else{?>
						<input type="checkbox" name="nFlgEnvio" value="1" <?=$marcarEnvio?>>
					<?php }?></td>
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

<?php include("includes/userinfo.php");?>
</table> 

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>