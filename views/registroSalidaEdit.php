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
<script src="ckeditor/ckeditor.js"></script>

<script Language="JavaScript">
<!--
function activaRemitente()
{
document.frmRegistro.radioMultiple.checked = false;
document.frmRegistro.radioRemitente.checked = true;
document.frmRegistro.iCodRemitente.value=document.frmRegistro.Remitente.value;
document.frmRegistro.radioSeleccion.value="2";
document.getElementById('areaRemitente').style.display = '';
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

function buscarRemitente(){
window.open('registroRemitentesSalidaLs.php','popuppage','width=735,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');
}

function infoRemitente() {
var w = document.frmRegistro.txtdirec_remitente.value;
var x = document.frmRegistro.cCodDepartamento.value;
var y = document.frmRegistro.cCodProvincia.value;
var z = document.frmRegistro.cCodDistrito.value ;
var t = document.frmRegistro.iCodRemitente.value;

window.open('registroRemitenteDetalle.php?iCodRemitente='+t+'&txtdirec_remitentex='+w+'&cCodDepartamentox='+x+'&cCodProvinciax='+y+'&cCodDistritox='+z,'popuppage','width=590,height=240,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');
}

function generarDocumentoElectronico() {
	    	var parameters = {iCodTramite: $("#iCodTramite").val(),descripcion: CKEDITOR.instances.descripcion.getData()}
	    	//alert(window.location.host);
	    	$.ajax({
	            type: 'POST',
	            url: 'generarDocumentoElectronico.php', 
	            data: parameters, 
	            dataType: 'json',
	            success: function(s){
	            	console.log(s);
	            	alert("El archivo fue creado en: "+s.documentoElectronicoPDF);
	            	//$("#descargarDEG").attr("href", "downloadDG.php?file="+s.documentoElectronicoPDF);
	            	//$('#descargarDEG span').trigger('click');
	            	// $("#descargarDEG").attr("href", "registroInternoDocumento_pdf.php?iCodTramite="+s.iCodTramite);
	            	// $('#descargarDEG span').trigger('click');
	            },
	            error: function(e){
	                alert('Error Processing your Request!!');
	            }
	        });	
	    }


function AddReferencia(){
	if (document.frmRegistro.cReferencia.value.length == "")
	{
	    alert("Ingrese Referencia");
	    document.frmRegistro.cReferencia.focus();
	    return (false);
  	}
	// document.frmRegistro.opcion.value=22;
	// document.frmRegistro.action="registroData.php";
	// document.frmRegistro.submit();

	var parameters = {
        iCodTramiteRef: $("#iCodTramiteRef").val(),
        cReferencia: $("#cReferencia").val(),
        iCodTramite:$("#iCodTramite").val()
    }
    var items="";

    $.ajax({
        type: 'POST',
        url: 'insertarEditReferenciaTemporal.php', 
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
  document.frmRegistro.opcion.value=16;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmRegistro.submit();
}

var miPopup
	function Buscar(){
miPopup=window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}
	

</script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
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

<div class="AreaTitulo">Actualizacion - Registro Salida</div>	
		<table class="table">
			<form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
            <input type="hidden" name="sal" value="3">
			<input type="hidden" name="iCodTramite" id="iCodTramite" value="<?=$_GET[iCodTramite]?>">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
			<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
			<input type="hidden" name="cReferenciaOriginal" value="<?=trim($Rs[cReferencia])?>">
			<input type="hidden" name="iCodTrabajadorSolicitado" value="<?=trim($Rs[iCodTrabajadorSolicitado])?>">
			<input type="hidden" name="radioSeleccion" value="">
		<tr>
		<td class="FondoFormRegistro">
			<table border=0>
			<tr>
			<td valign="top"  width="160">N&ordm; Documento:</td>
			<td valign="top" colpsan="3" style="font-size:16px;color:#00468C">
				<b>
					<?php
						echo $Rs['cCodificacion'];
						// if ($Rs['nFlgEnvio'] == 0) {
						// 	echo $Rs['cCodificacion'];
						// }else{
						// 	echo "----------";
						// }
					?>
				</b>
			</td>
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
			<td style="padding-top:5px;">

			<td><input type="text" readonly name="fFecRegistro" value="<?php if($Rs['fFecRegistro']!=""){echo date("d-m-Y G:i", strtotime($Rs['fFecRegistro'])); } else {echo $_POST['fFecRegistro'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>
			<td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
				</tr></table>
            <? /*date("d-m-Y H:i", strtotime($Rs['fFecDocumento'])) */?></td>
			</tr>			
			<tr>
			<td valign="top" >Asunto, Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs['cAsunto']); }Else{ echo trim($_POST['cAsunto']);}?></textarea>
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
            <td valign="top"  width="160">Referencia:</td>
			<td valign="top">
				<table>
					<tr>
						<td align="center">
							<input type="hidden" readonly="readonly" name="cReferencia" id="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia]); }else{ echo trim($_POST[cReferencia]);}?>" class="FormPropertReg form-control"
										style="width:140px;text-transform:uppercase" />
              <input type="hidden" name="iCodTramiteRef" id="iCodTramiteRef" value="<?=$_REQUEST[iCodTramiteRef]?>"  />
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
        			<div id="listaReferenciaTemporal"></div>
        		</td>
        	</tr>
       	</table>	
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
			$sqlCarg = "SELECT cDireccion, cDepartamento, cProvincia, cDistrito FROM Tra_M_Doc_Salidas_Multiples 
								  WHERE iCodTramite ='$Rs[iCodTramite]'";
			$rsCarg = sqlsrv_query($cnx,$sqlCarg);
      $RsCarg = sqlsrv_fetch_array($rsCarg);
			//$remi=
			// cNombreRemitente cNomRemite
			$dir=$RsCarg[cDireccion]; $dep=$RsCarg[cDepartamento]; $pro=$RsCarg[cProvincia]; $dis=$RsCarg[cDistrito];
          				}
									?>
			<table cellpadding="0" cellspacing="2" border="0">
				<tr>
					<td align="right" width="70" style="color:#7E7E7E">Institución:&nbsp;</td>
					<td>
						<input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control"
									 value="<?=$RsRem['cNombre']?>" style="width:300px" readonly>
					</td>
					<td align="center">
						<div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;text-align:center">
							<a style=" text-decoration:none" href="javascript:;" onClick="buscarRemitente();">Buscar</a>
						</div>
					</td>
					<td align="center"></td>
				</tr>
				<tr>
					<td align="right" width="70" style="color:#7E7E7E">Destinatario:&nbsp;</td>
					<td>
						<input id="cNomRemite" name="cNomRemite" value="<?=trim($Rs[cNomRemite])?>" 
									 class="FormPropertReg form-control" style="text-transform:uppercase;width:300px">
					</td>
                                    <td align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;text-align:center"><a style=" text-decoration:none" href="javascript:;"  onClick="infoRemitente(this);">+ Datos</a> </div></td>
									<td align="center"></td>
									</tr>
									</table>
									
							</div>
                            <input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$iCodRemitente?>">
                            <input id="Remitente" name="Remitente" type="hidden" value="<?=$iCodRemitente?>">
                            <input id="txtdirec_remitente" name="txtdirec_remitente" type="hidden" value="<?=$dir?>">
                            <input id="cCodDepartamento" name="cCodDepartamento" type="hidden" value="<?=$dep?>">
                            <input id="cCodProvincia" name="cCodProvincia" type="hidden" value="<?=$pro?>">
                            <input id="cCodDistrito" name="cCodDistrito" type="hidden" value="<?=$dis?>">	
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
			<tr>
			<?php /*
				<td valign="top" >Documento complementario:</td><!--Adjuntar Archivo-->
				<td valign="top">
						<?php
						$sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          				$rsDig=sqlsrv_query($cnx,$sqlDig);
          				if(sqlsrv_has_rows($rsDig)>0){
          					$RsDig=sqlsrv_fetch_array($rsDig);
          					if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
										echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
										echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=18&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
								}
          	}else{
          			echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          	}
						?>					
				</td>
				<td valign="top" >Sigla Autor:</td>
				<td><input type="text" style="text-transform:uppercase" name="cSiglaAutor" value="<?php if($_GET[clear]==""){ echo $Rs[cSiglaAutor]; }Else{ echo $_POST[cSiglaAutor];}?>" class="FormPropertReg form-control" style="width:60px;" /></td>
				*/
			?>
			</tr>
			<?php 
			/*
			<tr>
				<td colspan="5"  style="padding-left:15%;">
					
					<a href="registroInternoDocumento_pdf.php?iCodTramite=<?php echo $_GET[iCodTramite];?>" target="_blank" title="Documento"><img src="images/1471041812_pdf.png" border="0" height="17" width="17"> Documento Electronico</a>
					<p style="padding:0px 0px 0px 14px;">
					<a href="javascript:void(0);" class="majorpoints btn-info btn" >Documento electrónico</a>
				    
				    <div class="hiders" style="display:none;padding:0px 0px 0px 14px;" > 
						<textarea name="descripcion" id="descripcion" class="FormPropertReg form-control"><?=$Rs[descripcion]?></textarea>
								
					</div>
					</p>

					<script>
						CKEDITOR.replace('descripcion');
				  		$('.majorpoints').click(function(){
						    //$(this).find('.hiders').toggle();
						    $('.hiders').toggle("slow");
						});
				  	</script>	
				</td>
			</tr>	
			*/
			?>
			<tr>
				<td colspan="4" style="padding-left:15px">
					<hr style="color:#ccc">
					<h3 style="color:#808080">ELABORAR DOCUMENTO ELECTRónICO</h3>
					<p style="padding:0px 0px 0px 14px;">
					<a href="javascript:void(0);" class="majorpoints btn-info btn" >Documento electrónico</a>
				    
				    <div class="hiders" style="display:none;padding:0px 0px 0px 14px; text-align:right" > 
						<textarea name="descripcion" id="descripcion" class="FormPropertReg form-control"><?=$Rs[descripcion]?></textarea>
						<br>
                        <input type="button" class="btn-info btn" href="javascript:;" 
                        onclick="generarDocumentoElecSalida();return false;" value="Guardar Documento Eletronico"/>
                        <span id="resultado"></span>
					</div>
					</p>

					<script>
						CKEDITOR.replace('descripcion');
				  		$('.majorpoints').click(function(){
						    //$(this).find('.hiders').toggle();
						    $('.hiders').toggle("slow");
						});
				  	</script>
					</p>
					<!--H3 style="color:#808080">PASO 2 - ABRIR FIRMA DIGITAL</H3><input type="button" value="Abrir" onClick="return go()">
					
					<H3 style="color:#808080">PASO 3 - REEMPLAZAR DOCUMENTOS</H3-->
					<h4 style="color:#808080;display:inline;">Documento electrónico:</h4>
					<?php
					$sqlDig = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'";
          			$rsDig  = sqlsrv_query($cnx,$sqlDig);
          			$RsDig  = sqlsrv_fetch_array($rsDig);
          			if ($RsDig[descripcion] != NULL){
          				if (file_exists("documentos/".trim($RsDig[documentoElectronico]))){
          					echo "<div style=\"display:inline;\">";
							echo "<a href=\"download.php?direccion=documentos/&file=".trim($RsDig[documentoElectronico])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[documentoElectronico])."\"></a>";
							echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=31&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
						echo "</div>";
						}
          			}else{
          				echo "<input type=\"file\" name=\"documentoElectronicoPDF\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          			}
					?>
					<div></div>
					<!--<input type="file" name="documentoElectronicoPDF">-->
					<br>
					<h4 style="color:#808080;display:inline;">Documento complementario:</h4>
					<?php
					$sqlDig = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          			$rsDig  = sqlsrv_query($cnx,$sqlDig);
          			if (sqlsrv_has_rows($rsDig) > 0){
          				$RsDig = sqlsrv_fetch_array($rsDig);
          				if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
							echo "<div style=\"display:inline;\">";
							echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
							echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=32&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
							echo "</div>";
						}
          			}else{
          				echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          			}
					?>
					<br><br>
					<!--<input type="file" name="fileUpLoadDigital"/>-->
						<!--*<td valign="top" >Abrir Firma Digital:</td>
						<td valign="top" colspan="1"> <input type="button" value="Abrir" onClick="return go()"></td>*/-->
					<script>
						CKEDITOR.replace('descripcion');
				  // 		$('.majorpoints').click(function(){
						//     $('.hiders').toggle("slow");
						// });
				  	</script>	
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

<script>
    //CKEDITOR.replace('descripcion');
  
    $(document).ready(function() {
    	var parameters = {iCodTramite:$("#iCodTramite").val()}
      var items = "";
    	$.ajax({
            type: 'POST',
            url: 'listarEditReferenciaTemporal.php', 
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

        
    });
    
     function generarDocumentoElecSalida(){
                alert("Se guardo con exito");
            var parametros = {
                        "iCodTramite" : $("#iCodTramite").val(),
                    "descripcion" : CKEDITOR.instances.descripcion.getData(),
                    "opcion"      : 2
                };
            $.ajax({
                data:  parametros,
              url:   'generarDocumentoElecSalida.php',
              type:  'post',
              beforeSend: function () {
                $("#resultado").html("Procesando, espere por favor...");
              },
              success:  function (response) {
                $("#resultado").html(response);
              },
                error: function(e){
                alert('Error al generar documento.');
              }
            });
        }

    function eliminarReferenciaTemporal(argument) {

        var parameters = {iCodTramiteRef: argument,iCodTramite:$("#iCodTramite").val()}
        var items = "";

        $.ajax({
            type: 'POST',
            url: 'eliminarEditReferenciaTemporal.php', 
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

</script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>