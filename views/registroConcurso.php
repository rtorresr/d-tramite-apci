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
  
   	if (document.frmRegistro.nFlgEnvio.value=="")
//  if (document.frmRegistro.nFlgEnvio.value==1)
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
	
  document.frmRegistro.action="concursoData.php";
  document.frmRegistro.submit();
}

//--></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
<body onload="mueveReloj()">

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
				<input type="hidden" name="nFlgEnvio" value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
				<tr>
					<td class="FondoFormRegistro">
						<table border="0">
							<tr>
								<td valign="top" >Archivo F&iacute;sico:</td>
								<td valign="top" colspan="3">
									<input type="text" name="archivoFisico" class="FormPropertReg form-control" style="width:275px" 
												 value="<?php echo $_POST['archivoFisico']; ?>"/>&nbsp;
								</td>
							</tr>
							
							<tr>
								<td valign="top"  width="150">Tipo de Documento:</td>
								<td valign="top">
									<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
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
								<td>
									<input type="text" name="reloj" class="FormPropertReg form-control" style="width:120px" onfocus="window.document.frmRegistro.reloj.blur()">
								</td>
							</tr>

							<tr>
								<td  valign="top">Fecha del Documento:</td>
								<td>
									<input type="text" name="fechaDocumento" value="<?=((isset($_POST['fechaDocumento']))?$_POST['fechaDocumento']:'')?>" style="width:120px" class="FormPropertReg form-control" readonly>
									<div class="boton" style="width:24px;height:20px;display:inline">
										<a href="javascript:;" onclick="displayCalendar(document.forms[0].fechaDocumento,'dd-mm-yyyy hh:ii',this,true)">
											<img src="images/icon_calendar.png" width="22" height="20" border="0">
										</a>
									</div>
								</td>
							</tr>
			
			<tr>
              <?
			if(trim($_POST['cNroDocumento'])!=""){
			$sqlChek ="select cNroDocumento  from Tra_M_tramite where  cNroDocumento = '".$_POST['cNroDocumento']."'";
			$rsChek=sqlsrv_query($cnx,$sqlChek);
						$numChek=sqlsrv_has_rows($rsChek);
			if($numChek>0) {$fondo1 = "style=background-color:#FF3333;color:#000"; $eti="<span class='FormCellRequisito'>El n�mero ingresado ya existe</span>";}
			} 
			 ?>
			<td valign="top"  width="150">N&ordm; del Documento:</td>
			<td valign="top" colspan="3"><input type="text" style="width:250px;text-transform:uppercase;" name="cNroDocumento" <?=((isset($fondo1))?$fondo1:'')?> value="<?php echo stripslashes((isset($_POST['cNroDocumento']))?$_POST['cNroDocumento']:'');?>" class="FormPropertReg form-control"  id="cNroDocumento" />&nbsp;<input name="button" type="button" class="btn btn-primary" value="ChkDoc." onclick="releer();" >&nbsp;<span class="FormCellRequisito">*</span><?=((isset($eti))?$eti:'')?></td>
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
			<td valign="top" >Remite:</td>
			<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNomRemite" value="<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>" class="FormPropertReg form-control" style="width:250px" />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>
			
			<tr>
			<td valign="top" >Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_POST['cAsunto']==""){echo "Concurso P�blico de los Organismos Reguladores - ";}else {echo stripslashes($_POST['cAsunto']);}?></textarea>
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?=((isset($_POST['cObservaciones']))?$_POST['cObservaciones']:'')?></textarea>
			</td>
			</tr>
			
			<tr>
			<td valign="top"  width="150">Referencia:</td>
			<td valign="top" colspan="3"><input type="text" name="cReferencia" style="text-transform:uppercase" value="<?=$_POST[cReferencia]?>" class="FormPropertReg form-control" style="width:250px" /></td>
			</tr>
			
			<tr>
			<td valign="top"  width="150">Oficina:</td>
			<td>
							<select name="iCodOficinaResponsable" style="width:340px;" class="FormPropertReg form-control" onChange="loadResponsables(this.value);">
							<option value="">Seleccione:</option>
							<?
							$sqlDep2=" SP_OFICINA_LISTA_COMBO ";
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
							<select name="iCodTrabajadorResponsable" id="responsable" style="width:340px;" class="FormPropertReg form-control">
							
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
				<td><input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;} else { echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" /></td>
			</tr>

			<tr>
				<td valign="top"  width="150">Adjuntar Archivo:</td>
				<td valign="top"><input type="file" class="FormPropertReg form-control" name="fileUpLoadDigital" style="width:340px;" /></td>
				<td valign="top" >Tiempo para Respuesta:</td>
				<td valign="top" class="CellFormRegOnly"><input type="text" name="nTiempoRespuesta" value="<?php if($_POST[nTiempoRespuesta]==""){ echo "0"; }Else{ echo $_POST[nTiempoRespuesta]; }?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/> d�as</td>
			</tr>			

			<tr>
			<td valign="top" >Mantener Pendiente:</td>
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
<div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

<script>
	function loadResponsables(value)
	{
		var parametros = {
			"iCodOficinaResponsable"    : value
		    };
		var dominio = document.domain;
		$("#responsable > option").remove(); 

	    $.ajax({
	        type: 'POST',
	        url: 'loadResponsable.php', 
	        data: parametros, 
	        dataType: 'json',
	        success: function(list){
	        	console.log(list);
	            var opt = $('<option />'); 
                        opt.val('');
                        opt.text('Seleccione un responsable');
                        $('#responsable').append(opt);
                        $.each(list,function(index,value) 
                        {
                        	console.log(value);
                            var opt = $('<option />'); 
                            opt.val(value.iCodTrabajador);
                            opt.text(value.cNombresTrabajador+" "+value.cApellidosTrabajador);
                            $('#responsable').append(opt); 
                        });
	        },
	        error: function(e){
	        	console.log(e);
	            alert('Error Processing your Request!!');
	        }
	    });
	}
</script>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>