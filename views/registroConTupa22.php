<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
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
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1#area";
document.frmRegistro.submit();
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>";
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
 miPopup=window.open('registroBuscarDocEnt.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}
	
function AddReferencia(){
  document.frmRegistro.opcion.value=21;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

function Registrar()
{
	  if (document.frmRegistro.nFlgEnvio.value=="")
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
		 //  if (document.frmRegistro.nFlgEnvio.value==1)
	if (document.frmRegistro.nFlgEnvio.value=="")
		{
				if (document.frmRegistro.iCodOficinaResponsable.value.length == "")
			{
			  document.frmRegistro.nFlgEnvio.value=1;
			}
		}
		
		  document.frmRegistro.action="registroData.php";
		  document.frmRegistro.submit();
			
		}
		else if(document.frmRegistro.nFlgEnvio.value==1)
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
		  // if (document.frmRegistro.nFlgEnvio.value==1)
			if (document.frmRegistro.nFlgEnvio.value=="1")
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
		
		  document.frmRegistro.action="registroData.php";
		  document.frmRegistro.submit();
			}
}

function go() {
	 w = new ActiveXObject("WScript.Shell");
	//w.run("c:\\envioSMS.jar", 1, true);
	w.run("G:\\refirma\\1.1.0\\ReFirma-1.1.0.jar", 1, true);//G:\refirma\1.1.0\ReFirma-1.1.0.jar
	return true;
}
//--></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
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

<div class="AreaTitulo">Registro de entrada con tupa</div>
		<table class="table">
		<tr>
			<form name="frmRegistro" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="1">
			<input type="hidden" name="nFlgClaseDoc" value="1">
             <input type="hidden" name="sal" value="2">
			<input type="hidden" name="nFlgEnvio" value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
		<td class="FondoFormRegistro">
			<table width="1030" border="0">
		
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
			<td><input type="text" name="reloj" class="FormPropertReg form-control" style="width:120px" onfocus="window.document.frmRegistro.reloj.blur()"></td>
			</tr>

			<tr>
             <?
			if(trim($_POST['cNroDocumento'])!=""){
			$sqlChek ="select cNroDocumento  from Tra_M_tramite where  cNroDocumento = '".$_POST['cNroDocumento']."'";
			$rsChek=sqlsrv_query($cnx,$sqlChek);
						$numChek=sqlsrv_has_rows($rsChek);
			if($numChek>0) {$fondo1 = "style=background-color:#FF3333;color:#000";$eti="<span class='FormCellRequisito'>El n�mero ingresado ya existe</span>";}
			} 
			 ?>
			<td valign="top"  width="150">N&ordm; del Documento:</td>
			<td valign="top" colspan="3"><input type="text" style="width:250px;text-transform:uppercase;" name="cNroDocumento" <?=((isset($fondo1))?$fondo1:'')?> value="<?=stripslashes((isset($_POST['cNroDocumento']))?$_POST['cNroDocumento']:'')?>" class="FormPropertReg form-control"  id="cNroDocumento" />&nbsp;<input name="button" type="button" class="btn btn-primary" value="ChkDoc." onclick="releer();" >&nbsp;<span class="FormCellRequisito">*</span>&nbsp;<?=((isset($eti))?$eti:'')?></td>
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
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?=((isset($_POST['cAsunto']))?$_POST['cAsunto']:'')?></textarea>
					&nbsp;&nbsp;
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?=((isset($_POST['cObservaciones']))?$_POST['cObservaciones']:'')?></textarea>
			</td>
			</tr>				

			<tr>
			<td valign="top"  width="300">Clase de Procedimiento:</td>
			<td valign="top" colspan="3">
					<select name="iCodTupaClase" class="FormPropertReg form-control" style="width:110px" onChange="loadProcedimientos(this);" >
					<option value="">Seleccione:</option>
					<?
						$sqlClas="SELECT * FROM Tra_M_Tupa_Clase ";
			          $sqlClas.="ORDER BY iCodTupaClase ASC";
			          $rsClas=sqlsrv_query($cnx,$sqlClas);
			          while ($RsClas=sqlsrv_fetch_array($rsClas)){
			          	if($RsClas["iCodTupaClase"]==$_POST[iCodTupaClase]){
			          		$selecClas="selected";
			          	}Else{
			          		$selecClas="";
			          	}
			          echo "<option value=".$RsClas["iCodTupaClase"]." ".$selecClas.">".$RsClas["cNomTupaClase"]."</option>";
			          }
			          sqlsrv_free_stmt($rsClas);
					?>
					</select>
			</td>
			</tr>

			<tr>
			<td valign="top"  width="300">Procedimiento:</td>
			<td valign="top" colspan="3">

					<select name="iCodTupa" id="procedimiento" class="FormPropertReg form-control" onChange="loadRequisitos(this);">
						<option >Seleccione un procedimiento</option>
					</select>
			</td>
			</tr>

			<tr>
			<td valign="top"  width="300">Requisitos:</td>
			<td valign="top" colspan="3">
					<fieldset>
						<legend>
							<a href="javascript:seleccionar_todo()">Marcar todos</a> | 
							<a href="javascript:deseleccionar_todo()">Desmarcar</a> 
						</legend>
						<table cellpadding="0" cellspacing="2" border="0" width="850">				
							<tbody id="requisitos1">
								
							</tbody>
						</table>
					</fieldset>
			</td>
			</tr>
					<tr>
          
            <td valign="top"  wdidth="160">Referencia:</td>
			<td valign="top">
					<table><tr>
					<td align="center"><input type="hidden" readonly="readonly" name="cReferencia2" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia2]); }Else{ echo trim($_POST[cReferencia2]);}?>" class="FormPropertReg form-control" style="width:140px;text-transform:uppercase" />
                    <input type="hidden" name="iCodTramiteRef"  value="<?=$_REQUEST[iCodTramiteRef]?>"  />
                    </td>
					<td align="center"></td>
					<td align="center"><div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="Buscar();">A�adir Referencia</a> </div></td>
					</tr></table>
                    <table border=0><tr><td>
						<?
						$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='$_SESSION[cCodRef]'";
				//		echo $sqlRefs;
          	$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
						?>
						<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?><a href="registroData.php?iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=19&iCodTramite=<?=$_GET[iCodTramite]?>&sal=2&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cNombreRemitente=<?=$_POST[cNombreRemitente]?>&iCodTrabajadorResponsable=<?=$_POST[iCodTrabajadorResponsable]?>&iCodOficinaResponsable=<?=$_POST[iCodOficinaResponsable]?>&cNroDocumento=<?=$_POST['cNroDocumento']?>&cNomRemite=<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>&ActivarDestino=<?=$_POST[ActivarDestino]?>&iCodRemitente=<?=$_POST[iCodRemitente]?>&Remitente=<?=$_POST[Remitente]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&iCodTupaClase=<?=$_POST[iCodTupaClase]?>&iCodTupa=<?=$_POST['iCodTupa']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="13" height="13"></a></span>&nbsp;
                       	
						<?php}?>
					 	
					
			
            </tr>
			<tr>
			<td valign="top"  width="300">Referencia:</td>
			<td valign="top" colspan="3"><input style="text-transform:uppercase" type="text" name="cReferencia" value="<?=$_POST[cReferencia]?>" class="FormPropertReg form-control" style="width:250px" /></td>
			</tr>
			<tr>
			<td valign="top"  width="300">Oficina:</td>
			<td>
				<select name="iCodOficinaResponsable" id="oficina" style="width:340px;" class="FormPropertReg form-control" onChange="loadResponsables(this.value);"></select>
			</td>
			<td valign="top" >Responsable</td>
			<td>
					<select name="iCodTrabajadorResponsable" id="responsable" style="width:340px;" class="FormPropertReg form-control" >
							
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
				<td><input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;} else { echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" /></td>
			</tr>

			<tr>
				<td valign="top"  width="300">Adjuntar Archivo:</td>
				<td valign="top"><input type="file" name="fileUpLoadDigital" class="FormPropertReg form-control" style="width:340px;" /></td>
				<td valign="top" >Abrir Firma Digital:</td>
				<td valign="top" > <input type="button" value="Abrir" onClick="return go()"></td>
			</tr>
				<td valign="top" >Tiempo para Respuesta:</td>
				<td valign="top" class="CellFormRegOnly" colspan=""><input type="text" name="nTiempoRespuesta" value="<?php if($RsTupDat[nDias]==""){echo "0";}else {echo $RsTupDat[nDias];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/> d�as</td>
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

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>
<script type="text/javascript" language="javascript">

	function loadProcedimientos(value)
	{
		var parametros = {'iCodTupaClase': $(value).val()};

		$("#procedimiento > option").remove(); 

	    $.ajax({
	        type: 'POST',
	        url: 'loadProcedimiento.php', 
	        data: parametros, 
	        dataType: 'json',
	        success: function(list){
	        	console.log(list);
	            var opt = $('<option />'); 
                        opt.val('');
                        opt.text('Seleccione un procedimiento');
                        $('#procedimiento').append(opt);
                        $.each(list,function(index,value) 
                        {
                        	console.log(value);
                            var opt = $('<option />'); 
                            opt.val(value.iCodTupa);
                            opt.text(value.cNomTupa);
                            $('#procedimiento').append(opt); 
                        });
	        },
	        error: function(e){
	        	console.log(e);
	            alert('Error Processing your Request!!');
	        }
	    });
	}
	function loadRequisitos(value)
	{
		var parametros = {'iCodTupa': $(value).val()};

	    $.ajax({
	        type: 'POST',
	        url: 'loadRequisito.php', 
	        data: parametros, 
	        dataType: 'json',
	        success: function(result){
            	var items = "";
	            if (result != null && result != "") {
	                $.each(result, function (i, v) {
	                    items += '<tr>'
	                    items += '<td valign=top width=15><input type="checkbox" name="iCodTupaRequisito[]" value="'+v.iCodTupaRequisito+'"></td>'
	                    items += '<td style="color:#004080;font-size:11px">'+v.cNomTupaRequisito+'</td>'
	                    items += '</tr>'
	                })
	            } else {
	                items += '<tr><td colspan="8">Ningón dato disponible en esta tabla.</td></tr>'
	            }
	            $("#requisitos1").html(items);
	        },
	        error: function(e){
	        	console.log(e);
	            alert('Error Processing your Request!!');
	        }
	    });

		$("#oficina > option").remove(); 
	    $.ajax({
	        type: 'POST',
	        url: 'loadOficina.php', 
	        data: parametros, 
	        dataType: 'json',
	        success: function(result){
            	var opt = $('<option />'); 
                    opt.val('');
                    opt.text('Seleccione un oficina');
                    $('#oficina').append(opt);
                    $.each(result,function(index,value) 
                    {
                    	console.log(value);
                        var opt = $('<option />'); 
                        opt.val(value.iCodOficina);
                        opt.text(value.cNomOficina);
                        $('#oficina').append(opt); 
                    });
	        },
	        error: function(e){
	        	console.log(e);
	            alert('Error Processing your Request!!');
	        }
	    });
	}

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