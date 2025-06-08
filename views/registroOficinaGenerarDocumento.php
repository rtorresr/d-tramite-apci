<?php
date_default_timezone_set('America/Lima');
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
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
<script src="ckeditor/ckeditor.js"></script>
<style>
	.btn-info {
	    color: #fff;
	    background-color: #337ab7;
	    border-color: #2e6da4;
	}
	.btn {
	    display: inline-block;
	    padding: 6px 12px;
	    margin-bottom: 0;
	    font-size: 14px;
	    font-weight: 400;
	    line-height: 1.42857143;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: middle;
	    -ms-touch-action: manipulation;
	    touch-action: manipulation;
	    cursor: pointer;
	    -webkit-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	    background-image: none;
	    border: 1px solid transparent;
	    border-radius: 4px;
	    
	}
</style>

<script Language="JavaScript">
   
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

function activaOficina()
{
document.frmRegistro.radioMultiple.checked = false;
document.frmRegistro.radioOficina.checked = true;
document.frmRegistro.radioSeleccion.value="1";
muestra('areaOficina');
document.getElementById('areaMultiple').style.display = 'none';
return false;
}

function activaMultiple()
{
document.frmRegistro.radioMultiple.checked = true;
document.frmRegistro.radioOficina.checked = false;
document.frmRegistro.radioSeleccion.value="2";
muestra('areaMultiple');
document.getElementById('areaOficina').style.display = 'none';
return false;
}

function muestra(nombrediv) {
    if(document.getElementById(nombrediv).style.display == '') {
            document.getElementById(nombrediv).style.display = 'none';
    } else {
            document.getElementById(nombrediv).style.display = '';
    }
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
  document.frmRegistro.opcion.value=3;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

function Registrar(){
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Clase Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  
  if (document.frmRegistro.Jefe.value.length == "0")
  {
    alert("Oficina Sin Jefe Asociado");
    return (false);
  }
  if (document.frmRegistro.Jefe.value.length == "")
  {
    alert("Oficina Sin Jefe Asociado");
    return (false);
  }
  
  document.frmRegistro.opcion.value=2;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

var miPopup
	function Buscar(){
	miPopup=window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}

	function BuscarVariasOficinas(){
		window.open('registroOficinaLs.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}

function AddReferencia(){
  // document.frmRegistro.opcion.value=21;
  // document.frmRegistro.action="registroData.php";
  // document.frmRegistro.submit();
	var parameters = {
        iCodTramiteRef: $("#iCodTramiteRef").val(),
        cReferencia: $("#cReferencia").val(),
        iCodTramite: ""
    }
    var items="";

    $.ajax({
        type: 'POST',
        url: 'insertarReferenciaTemporal.php', 
        data: parameters, 
        dataType: 'json',
        success: function(s){
        	console.log(s);
        	$.each(s,function(index,value) 
                {
                	items += '<div class="col-sm-11">'
                    items +='<span style="background-color:#EAEAEA;">'+value.cReferencia
					items += '<a href="javascript: void(0)" onClick="eliminarReferenciaTemporal('+value.iCodReferencia+')">'
					items += '	<img src="images/icon_del.png" border="0" width="13" height="13">'
					items += '</a>'
					items += '</span>' 
                });
                $("#listaReferenciaTemporal").html(items);
        },
        error: function(e){
            alert('Error Processing your Request!!');
        }
    });
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
  document.frmRegistro.submit();
}

function go() {
	 w = new ActiveXObject("WScript.Shell");
	//w.run("c:\\envioSMS.jar", 1, true);
	w.run("G:\\refirma\\1.1.0\\ReFirma-1.1.0.jar", 1, true);//G:\refirma\1.1.0\ReFirma-1.1.0.jar
	return true;
}
//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
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

<div class="AreaTitulo">Registro >> Doc. Interno Oficina</div>	
		<table class="table">
			<form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
			
			<input type="hidden" name="opcion" value="">
			<input type="hidden" name="radioSeleccion" value="">
            <input type="hidden" name="nFlgRpta" value="">
            <input type="hidden" name="fFecPlazo" value="">
            <input type="hidden" name="Jefe" value="<?=$_SESSION['JEFE']?>">
          
		<tr>
		<td class="FondoFormRegistro">
			<table border=0>
			<tr>
			<td valign="top"  width="160">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:200px" />
						<option value="">Seleccione:</option>
						<?
						include_once("../conexion/conexion.php");
						$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 And cCodTipoDoc!=45 ORDER BY cDescTipoDoc ASC";
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
				<td valign="top"  width="160">Asunto:</td>
				<td>
	            	<textarea name="cAsunto" style="width:100%;height:55px" class="FormPropertReg form-control"><?=$_POST['cAsunto']?></textarea>
	          &nbsp;&nbsp;	
				</td>
				<td valign="top"  width="160">Observaciones:</td>
				<td valign="top"><textarea name="cObservaciones" style="width:290px;height:55px" class="FormPropertReg form-control"><?=$_POST[cObservaciones]?></textarea>
						
				</td>
			</tr>
			</tr>
			<tr>
				<td valign="top" >Folios:</td>
				<td valign="top"><input type="text" name="nNumFolio" value="<?php if($_POST[nNumFolio]==""){echo 1;} else { echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/></td>
				<td valign="top"  width="160">Referencia(s):</td>
				<td valign="top">
					<table border=0><tr>
					<td align="center" style="background:#dedede;">
					<input type="hidden" id="cReferencia" name="cReferencia" readonly="readonly" value="<?=$_POST[cReferencia]?>"  class="FormPropertReg form-control" style="width:130px;text-transform:uppercase" />
						
					<input type="center" id="iCodTramiteRef" name="iCodTramiteRef"  value="<?=$_POST[iCodTramiteRef]?>"  />
					</td>
					<td align="center"></td>
					<td align="center"><div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="Buscar();">A�adir Referencia</a> </div></td>
					</tr></table>
					<table border=0><tr><td>
					<div id="listaReferenciaTemporal"></div>
						

							
				</td>
			</tr>

			<tr>
			<td valign="top" >Mantener Pendiente:</td>
			<td valign="top">
					<input type="checkbox" name="nFlgEnvio" value="1" <?php if($_REQUEST[nFlgEnvio]==1) echo "checked"?>>&nbsp;<span class="FormCellRequisito"></span>
			</td>
			<td valign="top"  >Sigla Autor:</td>
			<td valign="top"><input type="text" style="text-transform:uppercase" name="cSiglaAutor" value="<?=$_POST[cSiglaAutor]?>" class="FormPropertReg form-control" style="width:60px;" /></td>
			</tr>
			
			<tr>
				<td valign="top" >Oficina(s):</td>
				<td colspan="3" align="left">
					<table border=0>
						<tr>
							<td valign="top"><input type="radio" name="radioOficina" onclick="activaOficina();" <?php if($_POST[radioSeleccion]==1) echo "checked"?> >
								Por Oficina
							</td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td valign="top"><input type="radio" name="radioMultiple" onclick="activaMultiple();" <?php if($_POST[radioSeleccion]==2) echo "checked"?> >
								Varias Oficinas
							</td>
						</tr>
					</table>				
				<div style="display:none" id="areaOficina">
					<table border=0>
						<tr>
							<td>
								<select name="iCodOficinaMov" id="iCodOficinaMov"  style="width:280px;" class="FormPropertReg form-control" onChange="loadResponsables(this.value);">
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
								<select name="iCodTrabajadorMov" id="responsable" style="width:220px;" class="FormPropertReg form-control"></select>
							</td>
							<td>
								<select name="iCodIndicacionMov" id="iCodIndicacionMov" style="width:200px;" class="FormPropertReg form-control">
									<option value="">Seleccione Indicación:</option>
									<?
									$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
									$sqlIndic .= "ORDER BY cIndicacion ASC";
									$rsIndic=sqlsrv_query($cnx,$sqlIndic);
									while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
									if($RsIndic[iCodIndicacion]==$_POST[iCodIndicacionMov] or $RsIndic[iCodIndicacion]== 3){
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
								<select name="cPrioridad" id="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
									<option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
									<option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
									<option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
								</select>
							</td>
						<td>
						<input name="button" type="button" class="btn btn-primary" value="A�adir" onclick="insertarMovimientoTemporal();">
						</td>
						</tr>
					</table>
				</div>

				<div style="display:none" id="areaMultiple">
				<table>
					<tr>
						<td align="center"><div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;">
						<a style=" text-decoration:none" href="javascript:void(0);" onClick="BuscarVariasOficinas();">Seleccionar Oficinas</a></div></td>
					</tr>
				</table>
				</div>					
			</td>
			</tr>

				<?php if($_POST[radioSeleccion]==1){?>
					 <script language="javascript" type="text/javascript">
					 	activaOficina();
					 </script>
				<?php}?>
				<?php if($_POST[radioSeleccion]==2){?>
					 <script language="javascript" type="text/javascript">
					 	activaMultiple();
					 </script>
				<?php}?>
		
		<tr>
		<td colspan="4" align="center">	
			<table border="1" width="1000">
				<thead>
					<tr>
						<td class="headColumnas">Oficina</td>
						<td class="headColumnas">Trabajador</td>
						<td class="headColumnas">Indicaci&oacute;n</td>
						<td class="headColumnas">Prioridad</td>
	                    <td class="headColumnas">Copia</td>
						<td class="headColumnas">Opci&oacute;n</td>
					</tr>
				</thead>
				<tbody id="listaMovimientoTemporal">	
				</tbody>
			</table>

			</td>
			</tr>
			<tr style="padding-top:20px;">
				<td valign="top" >Documento complementario:</td>
				<td valign="top" colspan="1"><input type="file" name="fileUpLoadDigital" class="FormPropertReg form-control" style="width:400px;" /></td>
				<!--*<td valign="top" >Abrir Firma Digital:</td>
				<td valign="top" colspan="1"> <input type="button" value="Abrir" onClick="return go()"></td>*/-->
			</tr>
			<tr>
			<td colspan="4">
					<input name="button" type="button" class="btn btn-primary" value="Registrar" onclick="Registrar();">
			</td>
			</tr>
			<tr>
				<td colspan="4">
				<H3 style="color:#808080">PASO 1 - ELABORAR DOCUMENTO ELECTRONICO</H3>
					<p style="padding:0px 0px 0px 14px;">

					<a href="javascript:void(0);" class="majorpoints btn-info btn" >Documento electrónico</a>
				    
				    <div class="hiders" style="display:none;padding:0px 0px 0px 14px;" > 
						<textarea name="descripcion" id="descripcion" class="FormPropertReg form-control"><?=$_POST[descripcion]?></textarea>
								
					</div>
					</p>
					<H3 style="color:#808080">PASO 2 - ABRIR FIRMA DIGITAL</H3><input type="button" value="Abrir" onClick="return go()">
					<H3 style="color:#808080">PASO 3 - ADJUNTAR ARCHIVO FIRMADO</H3><input type="file" name="documentoElectronicoPDF">
					<script>
						CKEDITOR.replace('descripcion');
				  		$('.majorpoints').click(function(){
						    //$(this).find('.hiders').toggle();
						    $('.hiders').toggle("slow");
						});
				  	</script>
				
						&nbsp;&nbsp;	
				</td>
			</tr>			
			
			
			</table>

		</form>

<?php include("includes/userinfo.php");?>
</table>

<script>
    $( document ).ready(function() {
    	var parameters = {}
        var items = "";
    	$.ajax({
            type: 'POST',
            url: 'listarReferenciaTemporal.php', 
            data: parameters, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                {
                	items += '<div class="col-sm-11">'
                    items +='<span style="background-color:#EAEAEA;">'+value.cReferencia
					items += '<a href="javascript: void(0)" onClick="eliminarReferenciaTemporal('+value.iCodReferencia+')">'
					items += '	<img src="images/icon_del.png" border="0" width="13" height="13">'
					items += '</a>'
					items += '</span>' 
                });
                $("#listaReferenciaTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });

        var parameters = {}
        var itemsMT = "";

        $.ajax({
            type: 'POST',
            url: 'listarMovimientoTemporal.php', 
            data: parameters, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                { 
					itemsMT += '<tr>'
					itemsMT += '<td align="left">'+value.cNomOficina+'</td>'
					itemsMT += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
					itemsMT += '<td align="left">'+value.cIndicacion+'</td>'
					itemsMT += '<td align="left">'+value.cPrioridad+'</td>'
                    itemsMT += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
					itemsMT += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
					itemsMT += '</tr>'

                });
                $("#listaMovimientoTemporal").html(itemsMT);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });
    });

    function addReferenciaTemporal() {

        var parameters = {
            iCodTramiteRef: $("#iCodTramiteRef").val(),
            cReferencia: $("#cReferencia").val(),
            iCodTramite: ""
        }
        var items = "";

        $.ajax({
            type: 'POST',
            url: 'insertarReferenciaTemporal.php', 
            data: parameters, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                {
                	items += '<div class="col-sm-11">'
                    items +='<span style="background-color:#EAEAEA;">'+value.cReferencia
					items += '<a href="javascript: void(0)" onClick="eliminarReferenciaTemporal('+value.iCodReferencia+')">'
					items += '	<img src="images/icon_del.png" border="0" width="13" height="13">'
					items += '</a>'
					items += '</span>' 
                });
                $("#listaReferenciaTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });
    }

    function eliminarReferenciaTemporal(argument) {

        var parameters = {iCodTramiteRef: argument}
        var items = "";

        $.ajax({
            type: 'POST',
            url: 'eliminarReferenciaTemporal.php', 
            data: parameters, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                {
                	items += '<div class="col-sm-11">'
                    items +='<span style="background-color:#EAEAEA;">'+value.cReferencia
					items += '<a href="javascript: void(0)" onClick="eliminarReferenciaTemporal('+value.iCodReferencia+')">'
					items += '	<img src="images/icon_del.png" border="0" width="13" height="13">'
					items += '</a>'
					items += '</span>' 
                });
                $("#listaReferenciaTemporal").html(items);
            },
            error: function(e){
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
	        url: 'loadResponsableRIO.php', 
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

	function insertarMovimientoTemporal() {
		
        var parameters = {
            iCodOficinaMov: $("#iCodOficinaMov").val(),
            iCodTrabajadorMov: $("#responsable").val(),
            iCodIndicacionMov: $("#iCodIndicacionMov").val(),
            cPrioridad: $("#cPrioridad").val()
        }
        var items = "";

        $.ajax({
            type: 'POST',
            url: 'insertarMovimientoTemporal.php', 
            data: parameters, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                { 
					items += '<tr>'
					items += '<td align="left">'+value.cNomOficina+'</td>'
					items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
					items += '<td align="left">'+value.cIndicacion+'</td>'
					items += '<td align="left">'+value.cPrioridad+'</td>'
                    items += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
					items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
					items += '</tr>'

                });
                $("#listaMovimientoTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });
    }

    function eliminarMovimientoTemporal(argument) {

        var parameters = {iCodTemp:argument}
        var items = "";

        $.ajax({
            type: 'POST',
            url: 'eliminarMovimientoTemporal.php', 
            data: parameters, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                { 
					items += '<tr>'
					items += '<td align="left">'+value.cNomOficina+'</td>'
					items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
					items += '<td align="left">'+value.cIndicacion+'</td>'
					items += '<td align="left">'+value.cPrioridad+'</td>'
                    items += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
					items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
					items += '</tr>'

                });
                $("#listaMovimientoTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });
    }

    function insertarVariasOficinasMovimientoTemporal(argument) {

        var items = "";

        $.ajax({
            type: 'POST',
            url: 'insertarVariasOficinasMovimientoTemporal.php', 
            data: argument, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                { 
					items += '<tr>'
					items += '<td align="left">'+value.cNomOficina+'</td>'
					items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
					items += '<td align="left">'+value.cIndicacion+'</td>'
					items += '<td align="left">'+value.cPrioridad+'</td>'
                    items += '<td><input type="checkbox" name="Copia[]" value="'+value.iCodTemp+'"/></td>'
					items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodTemp+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
					items += '</tr>'

                });
                $("#listaMovimientoTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });
    }

</script>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>