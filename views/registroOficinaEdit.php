<?php
session_start();
date_default_timezone_set('America/Lima');
if($_SESSION['CODIGO_TRABAJADOR']!=""){
	if (!isset($_SESSION["cCodRef"])){ 
		$fecSesRef = date("Ymd-Gis");	
		$_SESSION['cCodRef'] = $_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesRef;
	}
	if (!isset($_SESSION["cCodOfi"])){ 
	$fecSesOfi = date("Ymd-Gis");	
	$_SESSION['cCodOfi'] = $_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesOfi;
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
function activaDestino(){
	if (document.frmRegistro.nFlgEnvio.value==1){
			document.frmRegistro.nFlgEnvio.value="";
	} else {
			document.frmRegistro.nFlgEnvio.value=1;
	}
}
function AddReferencia(){
  // document.frmRegistro.opcion.value=22;
  // document.frmRegistro.action="registroData.php";
  // document.frmRegistro.submit();

  var parameters = {
        iCodTramiteRef: $("#iCodTramiteRef").val(),
        cReferencia: $("#cReferencia").val(),
        iCodTramite: $("#iCodTramite").val()
    }
    var items="";

    $.ajax({
        type: 'POST',
        url: 'insertarEditarReferenciaTemporal.php', 
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


function activaDerivar(){
document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>#area";
document.frmRegistro.submit();
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmRegistro.submit();
}

function Registrar()
{
	var test = [];
	$("input[name='Copia[]']:checked").each(function() {
        test.push($(this).val());
   	});

  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo de Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }

  $("input[name='ListaDeCopias[]']").val(test);

  document.frmRegistro.opcion.value=13;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
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
  document.frmRegistro.opcion.value=14;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

var miPopup
	function Buscar(){
 miPopup=window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}
	function BuscarVariasOficinas(){
		window.open('registroOficinaEditLs.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}
	

//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>

	<?php include("includes/menu.php");?>

		<?
		include_once("../conexion/conexion.php");
		
		$cadena="SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'";
		$rs=sqlsrv_query($cnx,$cadena);
		//echo $rs;
		$Rs=sqlsrv_fetch_array($rs);
		?>
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

<div class="AreaTitulo">Actualizacion - Registro de interno oficina</div>
		<table class="table">
		<tr>
			<form name="frmRegistro" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
			<input type="hidden" name="iCodTramite" id="iCodTramite" value="<?=$_GET[iCodTramite]?>">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
			<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
			<input type="hidden" name="iCodTrabajadorSolicitado" value="<?=$Rs[iCodTrabajadorSolicitado]?>">
      <input type="hidden" name="nFlgRpta" value="">
      <input type="hidden" name="fFecPlazo" value="">
			<?php
				if($_POST[tipoRemitente]==1) $ValortipoRemitente=1;
				if($_POST[tipoRemitente]==2) $ValortipoRemitente=2;
			?>
			<input type="hidden" name="tipoRemitente" value="<?=$ValortipoRemitente?>">
			<input type="hidden" name="iCodRemitente" value="<?=$_POST[iCodRemitente]?>">
			<input type="hidden" name="cReferenciaOriginal" value="<?=trim($Rs[cReferencia])?>">
			<input type="hidden" name="radioSeleccion" value="">
			<input type="hidden" name="ListaDeCopias[]">
		<td class="FondoFormRegistro">
			<table width="1030" border="0">
			<tr>
				<td valign="top"  width="200">N&ordm; Documento:</td>
				<td valign="top" colpsan="3" style="font-size:16px;color:#00468C">
					<b>
						<?php
							echo $Rs['cCodificacion'];
							// if ($Rs['nFlgEnvio'] == 1) {
							// 	echo $Rs['cCodificacion'];
							// }else{
							// 	echo "----------";
							// }
						?>
					</b>
				</td>
			</tr>
					
			<tr>
				<td valign="top"  width="200">Tipo de Documento:</td>
				<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
						<option value="">Seleccione:</option>
							<?php
								$sqlTipo = "SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 And cCodTipoDoc!=45 ORDER BY cDescTipoDoc ASC";
	          		$rsTipo  = sqlsrv_query($cnx,$sqlTipo);
	          		while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
	          			if($_GET[clear]==""){
	          				if($RsTipo["cCodTipoDoc"]==$Rs[cCodTipoDoc]){
	          					$selecTipo = "selected";
	          				}else{
	          					$selecTipo = "";
	          				}
	          			}else{
	          				if($RsTipo["cCodTipoDoc"]==$_POST[cCodTipoDoc]){
	          					$selecTipo = "selected";
	          				}else{
	          					$selecTipo = "";
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

				</tr></table>
            <? /*date("d-m-Y H:i", strtotime($Rs['fFecDocumento'])) */?>
            
            </td>
            
			</tr>
			
			<!--tr>
			    <td  width="160">Fecha Documento:</td>
			<td style="padding-top:5px;">
			<td><input type="text" readonly name="fFecDocumento" value="<?php if($Rs['fFecDocumento']!=""){echo date("d-m-Y G:i", strtotime($Rs['fFecDocumento'])); } else {echo $_POST['fFecDocumento'];}?>" style="width:105px" class="FormPropertReg form-control" ></td>

				</tr></table>
            <? /*date("d-m-Y H:i", strtotime($Rs['fFecDocumento'])) */?>
            
            </td>
            


			</tr-->

			<tr>
			<td valign="top"  width="160">Asunto, Asunto:</td>
			<td>
						<textarea name="cAsunto" id="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs['cAsunto']); }Else{ echo $_POST['cAsunto'];}?></textarea>&nbsp;<span class="FormCellRequisito"></span>
			</td>
			<td valign="top"  width="160">Observaciones:</td>
			<td valign="top">
				<textarea name="cObservaciones" id="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs[cObservaciones]); }Else{ echo $_POST[cObservaciones];}?></textarea>
			</td>
			</tr>
			<tr>
			<td valign="top"  width="200">Folios:</td>
			<td valign="top"><input type="text" name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($Rs[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right"  maxlength="3" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"/>&nbsp;<span class="FormCellRequisito"></span></td>
			<td valign="top" >Referencia(s):</td>
			<td>
					<table><tr>
					<td align="center"><input type="hidden" readonly="readonly" name="cReferencia" id="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia]); }Else{ echo trim($_POST[cReferencia]);}?>" class="FormPropertReg form-control" style="width:140px;text-transform:uppercase" />
                    <input type="hidden" name="iCodTramiteRef" id="iCodTramiteRef" value="<?=$_REQUEST[iCodTramiteRef]?>"  />
                    </td>
					<td align="center"></td>
					<td align="center"><div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="Buscar();">A�adir Referencias</a> </div></td>
					</tr></table>
					
					<table border=0><tr><td>
						<div id="listaReferenciaTemporal"></div>
					 	
			</td>
			</tr>
			
			<tr>
			<td valign="top" ></td>
					<?
					if($_GET[clear]==""){
							if($Rs[nFlgEnvio]==1){		
									$marcarEnvio="checked disabled";
									//$marcarEnvio="checked";
							}
							else {
								if($_POST[nFlgEnvio]==0){
									$marcarEnvio="checked";
								}								}
					}else{
							if($_POST[nFlgEnvio]==0){
									//$marcarEnvio="checked";
								//	$marcarEnvio="checked disabled";
							}
							else{
								$marcarEnvio="checked";
								}
					}
					?>
            <td valign="top" >
            	<input type="checkbox" style="opacity: 0.0;" name="nFlgEnvio" value="1" onclick="activaDestino();" <?=$marcarEnvio?> >
            </td>
            
            <td valign="top" >Sigla Autor:</td>
						<td>
							<?php 
								if($_GET[clear] == ""){ 
									//echo $Rs[cSiglaAutor]; 
									$sqlAutor = "SELECT cNombresTrabajador, cApellidosTrabajador 
															 FROM Tra_M_Trabajadores 
															 WHERE iCodTrabajador = '$Rs[cSiglaAutor]'";
									$rsAutor = sqlsrv_query($cnx,$sqlAutor);
								}else{ 
									//echo $_POST[cSiglaAutor];
									$sqlAutor = "SELECT cNombresTrabajador, cApellidosTrabajador 
															 FROM Tra_M_Trabajadores 
															 WHERE iCodTrabajador = '$_POST[cSiglaAutor]'";
									$rsAutor = sqlsrv_query($cnx,$sqlAutor);
								}
								$RsAutor = sqlsrv_fetch_array($rsAutor);
								$siglaAutor = trim($RsAutor['cNombresTrabajador'])." ".trim($RsAutor['cApellidosTrabajador']);
							?>
							<!-- <input type="text" style="width:60px;text-transform:uppercase" 
										 name="cSiglaAutor" value="<?php if($_GET[clear]==""){ echo $Rs[cSiglaAutor]; }else{ echo $_POST[cSiglaAutor];}?>" class="FormPropertReg form-control"  /> -->
							<input type="hidden" style="width:60px;text-transform:uppercase" 
										 name="cSiglaAutor" value="<?php if($_GET[clear]==""){ echo $Rs[cSiglaAutor]; }else{ echo $_POST[cSiglaAutor];}?>" class="FormPropertReg form-control"  />
							<input type="text" style="width:220px;text-transform:uppercase" 
										 name="cSiglaAutorVisible" value="<?php echo $siglaAutor; ?>" class="FormPropertReg form-control" readonly/>
						</td>
			</tr>

			<tr>
			<td valign="top" >Oficina(s):</td>
			<td colspan="3" align="left">
				
					<table border=0><tr>
          <td valign="top"><input type="radio" name="radioOficina" onclick="activaOficina();" <?php if($_POST[radioSeleccion]==1) echo "checked"?> >Por Oficina</td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td valign="top"><input type="hidden" name="radioMultiple" onclick="activaMultiple();" <?php if($_POST[radioSeleccion]==2) echo "checked"?> ><!-- M�ltiple --></td>
					</tr></table>
				
					<div style="display:none" id="areaOficina">				
					<table border=0>
					<tr>
					<td>
							<select name="iCodOficinaMov" id="iCodOficinaMov" style="width:260px;" class="js-example-basic-single" onChange="loadResponsables(this.value);">
							<option value="">Seleccione una oficina:</option>
							<?php
							$sqlOfVirtual = "SELECT iCodOficina FROM Tra_M_Oficinas WHERE cNomOficina /* LIKE '%VIRTUAL%' */";
							$rsOfVirtual  = sqlsrv_query($cnx,$sqlOfVirtual);
							$RsOfVirtual  = sqlsrv_fetch_array($rsOfVirtual);
							$iCodOficinaVirtual = $RsOfVirtual['iCodOficina'];

							$sqlDep2 = "SELECT * FROM Tra_M_Oficinas 
													WHERE iFlgEstado != 0 
																AND iCodOficina != $iCodOficinaVirtual
													ORDER BY cNomOficina ASC";
							//$sqlDep2 = "SP_OFICINA_LISTA_COMBO";
              $rsDep2  = sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2 = sqlsrv_fetch_array($rsDep2)){
              	if($RsDep2['iCodOficina']==$_POST[iCodOficinaMov]){
              		$selecOfi="selected";
              	}Else{
              		$selecOfi="";
              	}
                echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".trim($RsDep2["cNomOficina"])." | ".trim($RsDep2["cSiglaOficina"])."</option>";
              }
              mysql_free_result($rsDep2);
							?>
							</select>
					</td>
					<td>
							<select name="iCodTrabajadorMov" id="responsable" style="width:220px;" class="FormPropertReg combobox">
								<option value="">Seleccione un responsable:</option>	
							</select>
					</td>
					<td>
							<select name="iCodIndicacionMov" id="iCodIndicacionMov" style="width:180px;" class="FormPropertReg combobox">
							<?php
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
							<select name="cPrioridadMov" id="cPrioridadMov"  class="size9 combobox">
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
							<table><tr>
							<td align="center"><div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="BuscarVariasOficinas();">Seleccionar Oficinas</a></div></td>
							</tr></table>
					</div>					

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
					
			</td>
			</tr>

			<tr>
			<td colspan="4" align="left">
					
					<table border=1 width="100%">
					<thead>
					<tr>
					<td class="headColumnas" width="300">Oficina</td>
					<td class="headColumnas" width="300">Trabajador</td>
					<td class="headColumnas" width="140">Indicación</td>
					<td class="headColumnas" width="100">Prioridad</td>
                    <td class="headColumnas" width="100">Copia</td>
					<td class="headColumnas" width="60">Opción</td>
					</tr>
					</thead>
					<tbody id="listaMovimientoTemporal"></tbody>
					</table>
					
			</td>
			</tr>	

			<tr>
				<!--<td valign="top"  width="200">Documento complementario:</td> Adjuntar archivo-->
				<!--<td valign="top">-->
				<?php/*
					$sqlDig = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          			$rsDig  = sqlsrv_query($cnx,$sqlDig);
          			if (sqlsrv_has_rows($rsDig) > 0){
          				$RsDig = sqlsrv_fetch_array($rsDig);
          				if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
							echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
							echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=16&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
						}
          			}else{
          				echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          			}*/
				?>
				</td>
			</tr>
			<tr>
				<td valign="top"  colspan="4"><br>
				</td>
			</tr>
			<tr>
				<td colspan="4">

					<p style="padding:0px 0px 0px 14px;">
					<?php 
					/*<a href="javascript:void(0);" class="majorpoints btn-info btn" >Documento electrónico</a>
				    
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
				  	</script>	*/
				  	?>
				</td>
			</tr>
			
			<tr><?php 
				/*<td colspan="4">
					<input name="button" type="button" class="btn btn-primary" value="Actualizar" onclick="Registrar();">
					<input type="button" class="btn btn-primary" value="Cancelar" name="inicio" onClick="window.open('<?=$_GET[URI]?>', '_self');">
				</td>
				*/
				?>
			</tr>

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
                        onclick="generarDocumentoElec();return false;" value="Guardar Documento Eletronico"/>
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
					
					<H3 style="color:#808080">PASO 3 - REEMPLAZAR DOCUMENTOS</H3>
					<h4 style="color:#808080;display:inline;">Documento electrónico:</h4-->
					<?php
					$sqlDig = "SELECT documentoElectronico FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'";
          			$rsDig  = sqlsrv_query($cnx,$sqlDig);
          			$RsDig  = sqlsrv_fetch_array($rsDig);
          			if ($RsDig[documentoElectronico] != NULL){
          				if (file_exists("documentos/".trim($RsDig[documentoElectronico]))){
          					echo "<div style=\"display:inline;\">";
							echo "<a href=\"download.php?direccion=documentos/&file=".trim($RsDig[documentoElectronico])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[documentoElectronico])."\"></a>";
							echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=30&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
						echo "</div>";
						}
          			}else{
          				//echo "<input type=\"file\" name=\"documentoElectronicoPDF\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          			}
					?>
					<div></div>
					<!--<input type="file" name="documentoElectronicoPDF">-->
					<br>
					<!--h4 style="color:#808080;display:inline;">Documento complementario:</h4-->
					<?php
					$sqlDig = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          			$rsDig  = sqlsrv_query($cnx,$sqlDig);
          			if (sqlsrv_has_rows($rsDig) > 0){
          				$RsDig = sqlsrv_fetch_array($rsDig);
          				if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
							echo "<div style=\"display:inline;\">";
							echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
							echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=16&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
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
					<input type="button" class="btn btn-primary" value="Cancelar" name="inicio" onClick="window.open('<?=$_GET[URI]?>', '_self');">
				</td>
				<!--<td colspan="4">
					 <input name="button" type="button" class="btn btn-primary" value="Finalizar" disabled style="cursor:not-allowed">
				<td>-->
			</tr>

			</table>
			

		</form>
<div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>
<script>
    $( document ).ready(function() {
        
        $('#listaMovimientoTemporal').append('<tr><td colspan="6" align="center"><img src="images/cargando.gif" width="100px"></td></tr>'); 
        
    	var parameters = {iCodTramite: $("#iCodTramite").val()}
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

        var parametersMT = {iCodTramite: $("#iCodTramite").val()}
        
        var itemsMT = "";

        $.ajax({
            type: 'POST',
            url: 'listarEditarMovimientoTemporal.php', 
            data: parametersMT, 
            dataType: 'json',
            success: function(s){
            	console.log(s);
            	$.each(s,function(index,value) 
                { 
					checked = (value.cFlgTipoMovimiento==4) ?  "checked": "";
					itemsMT += '<tr>'
					itemsMT += '<td align="left">'+value.cNomOficina+'</td>'
					itemsMT += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
					itemsMT += '<td align="left">'+value.cIndicacion+'</td>'
					itemsMT += '<td align="left">'+value.cPrioridadDerivar+'</td>'
                    itemsMT += '<td><input type="checkbox" name="Copia[]"  value="'+value.iCodMovimiento+'" '+checked+'/></td>'
					itemsMT += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodMovimiento+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
					itemsMT += '</tr>'

                });
                $("#listaMovimientoTemporal").html(itemsMT);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });
    });
    
    
    function generarDocumentoElec(){
	    	alert("Se guardo con exito");
        var parametros = {
        			"iCodTramite" : $("#iCodTramite").val(),
            	"descripcion" : CKEDITOR.instances.descripcion.getData(),
            	"opcion"      : 2
          	};
        $.ajax({
        	data:  parametros,
          url:   'generarDocumentoElec.php',
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

    function addReferenciaTemporal() {

        var parameters = {
            iCodTramiteRef: $("#iCodTramiteRef").val(),
            cReferencia: $("#cReferencia").val(),
            iCodTramite: $("#iCodTramite").val()
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

        var parameters = {iCodTramiteRef: argument,iCodTramite: $("#iCodTramite").val()}
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

  function loadResponsables(value)
	{

        $("#responsable > option").remove(); 
        $('#responsable').append('<option value="">Cargando Datos...</option>'); 

		var parametros = {
			"iCodOficinaResponsable" : value
		};

		//$("#responsable > option").remove();
    $.ajax({
        type: 'POST',
        url: 'loadResponsableRIO.php', 
        data: parametros, 
        dataType: 'json',
        success: function(list){
            $('#responsable').append('<option value="">Cargando Datos...</option>');
            $("#responsable > option").remove(); 
        	console.log(list);
          // var opt = $('<option />'); 
          // opt.val('');
          // opt.text('Seleccione un responsable');
          // $('#responsable').append(opt);
          $.each(list,function(index,value) 
          {
              var opt = $('<option />');
              opt.val(value.iCodTrabajador);
              opt.text(value.cNombresTrabajador+" "+value.cApellidosTrabajador);
              $('#responsable').append(opt); 
              var opt = $('<option />');
           });
        },
        error: function(e){
        	console.log(e);
            alert('Error Processing your Request!!');
        }
    });
	}

	function insertarMovimientoTemporal() {
        
  $('#listaMovimientoTemporal').append('<tr><td colspan="6" align="center"><img src="images/cargando.gif" width="100px"></td></tr>'); 
        
		if ($("#iCodOficinaMov").val() == "") {
			alert("Seleccione Oficina");
		}else{
			if ($("#responsable").val() == "" || $("#responsable").val() == null) {
				alert("Seleccione Responsable");
			}else{
				if ($("#iCodIndicacionMov").val() == "") {
					alert("Seleccione Indicación");
				}else{
					if ($("#cPrioridadMov").val() == "") {
						alert("Seleccione Prioridad");
					}else{
						///////////////////////
						var parameters = {
        	iCodTramite: $("#iCodTramite").val(),
          iCodOficinaMov: $("#iCodOficinaMov").val(),
          iCodTrabajadorMov: $("#responsable").val(),
          iCodIndicacionMov: $("#iCodIndicacionMov").val(),
          cPrioridadMov: $("#cPrioridadMov").val(),

          cAsunto: $("#cAsunto").val(),
          cObservaciones: $("#cObservaciones").val()
        }
		    var items = "";
		    var checked ="";

		    $.ajax({
		    	type: 'POST',
		      url: 'insertarEditarMovimientoTemporal.php', 
		      data: parameters, 
		      dataType: 'json',
		      success: function(s){	
		      	$.each(s,function(index,value) 
		        { 
							checked = (value.cFlgTipoMovimiento==4) ?  "checked": "";
							items += '<tr>'
							items += '<td align="left">'+value.cNomOficina+'</td>'
							items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
							items += '<td align="left">'+value.cIndicacion+'</td>'
							items += '<td align="left">'+value.cPrioridadDerivar+'</td>'
		          items += '<td><input type="checkbox" 	name="Copia[]"  value="'+value.iCodMovimiento+'" '+checked+'/></td>'
							items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodMovimiento+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
							items += '</tr>'
		        });
		        $("#listaMovimientoTemporal").html(items);
		     	},
		      error: function(e){
		      	alert('Error Processing your Request!!');
		      }
		    });
						///////////////////////
					}
				}
			}
		}
 }

    function eliminarMovimientoTemporal(argument) {
        
        $('#listaMovimientoTemporal').append('<tr><td colspan="6" align="center"><img src="images/cargando.gif" width="100px"></td></tr>'); 

        var parameters = {iCodMovimiento:argument,iCodTramite: $("#iCodTramite").val()}
        var items = "";
        var checked ="";

        $.ajax({
            type: 'POST',
            url: 'eliminarEditarMovimientoTemporal.php', 
            data: parameters, 
            dataType: 'json',
            success: function(s){
            	$.each(s,function(index,value) 
                { 
					checked = (value.cFlgTipoMovimiento==4) ?  "checked": "";
					items += '<tr>'
					items += '<td align="left">'+value.cNomOficina+'</td>'
					items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
					items += '<td align="left">'+value.cIndicacion+'</td>'
					items += '<td align="left">'+value.cPrioridadDerivar+'</td>'
                    items += '<td><input type="checkbox" 	name="Copia[]"  value="'+value.iCodMovimiento+'" '+checked+'/></td>'
					items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodMovimiento+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
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
    	//argument[iCodTramite: $("#iCodTramite").val()];
        var items = "";
        var checked ="";

        $.ajax({
            type: 'POST',
            url: 'insertarEditarVariasOficinasMovimientoTemporal.php', 
            data: argument, 
            dataType: 'json',
            success: function(s){
            	console.log(s);
            	$.each(s,function(index,value) 
                { 
					checked = (value.cFlgTipoMovimiento==4) ?  "checked": "";
					items += '<tr>'
					items += '<td align="left">'+value.cNomOficina+'</td>'
					items += '<td align="left">'+value.cNombresTrabajador+' '+value.cApellidosTrabajador+'</td>'
					items += '<td align="left">'+value.cIndicacion+'</td>'
					items += '<td align="left">'+value.cPrioridadDerivar+'</td>'
                    items += '<td><input type="checkbox" name="Copia[]"  value="'+value.iCodMovimiento+'" '+checked+'/></td>'
					items += '<td align="center"><a href="javascript: void(0)" onclick="eliminarMovimientoTemporal('+value.iCodMovimiento+')"><img src="images/icon_del.png" border="0" width="16" height="16"></a></td>'
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
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>