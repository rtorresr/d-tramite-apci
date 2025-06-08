<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
	$fFechaHora=date("d-m-Y  G:i");
	?>
	<!DOCTYPE html>
	<html lang="es">
	<head>
		<?php include("includes/head.php");?>
		<script src="ckeditor/ckeditor.js"></script>
	</head>
	<body>

	<table cellpadding="0" cellspacing="0" border="0">


		<tr><?php include("includes/menu.php");?></td></tr>
		</tr>
		<tr>

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
						
						<?php 
						$sql="SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'";
						$rs=sqlsrv_query($cnx,$sql);
						$tramite=sqlsrv_fetch_object($rs);

						$sqlTipoDocumento="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$tramite->cCodTipoDoc'";
			          	$rsTipoDocumento=sqlsrv_query($cnx,$sqlTipoDocumento);
			          	$tipoDocumento=sqlsrv_fetch_object($rsTipoDocumento);

			          	$sqlDocComplementario="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$tramite->iCodTramite'";
			          	$rsDocComplementario=sqlsrv_query($cnx,$sqlDocComplementario);
          				$docComplementario=sqlsrv_fetch_object($rsDocComplementario);

						?>
			          	<input type="hidden" name="iCodTramite" id="iCodTramite" value="<?php echo $tramite->iCodTramite?>">
						<table border="0">
						<tr>
							<td valign="top"  width="160">N� Documento:</td>
							<td valign="top" colspan="3">
								<?php 
									//echo "-----------";
									echo $tramite->cCodificacion; 
								?>
							</td>
						</tr>
						<tr>
							<td valign="top"  width="160">Tipo de Documento:</td>
							<td valign="top"><?php echo $tipoDocumento->cDescTipoDoc; ?></td>
							<td  width="160">Fecha Registro:</td>
							<td><?php echo date("d-m-Y G:i", strtotime($tramite->fFecRegistro)); ?></td>
						</tr>
						
						<!--tr>
                            <td  width="160">Fecha Documento:</td>
							<td><?php echo date("d-m-Y G:i", strtotime($tramite->fFecDocumento)); ?></td>
							<td valign="top"  width="160"></td>
							<td valign="top"></td>

						</tr-->
						
						<tr>
							<td valign="top"  width="160">Asunto:</td>
							<td><textarea name="cAsunto" class="FormPropertReg form-control" disabled><?php echo $tramite->cAsunto;?></textarea></td>
							<td valign="top"  width="160">Observaciones:</td>
							<td valign="top"><textarea name="cObservaciones" class="FormPropertReg form-control" disabled><?php echo $tramite->cObservaciones;?></textarea></td>
						</tr>
						<tr>
							<td valign="top" >Folios:</td>
							<td valign="top"><?php echo $tramite->nNumFolio;?></td>
							<td valign="top"  width="160">Referencia(s):</td>
							<td valign="top">
								<div id="listaReferenciaTemporal"></div>
							</td>
						</tr>

						<tr>
							<td valign="top" >Mantener Pendiente:</td>
							<td valign="top"><?php echo $tramite->nFlgEnvio==0? 'Si': 'No'; ?></td>
							<td valign="top" >Autor:</td>
							<td valign="top">
								<?php 
									//echo $tramite->cSiglaAutor;
									$sqlTipo = "select iCodTrabajador, cNombresTrabajador, cApellidosTrabajador from [dbo].[Tra_M_Trabajadores] where iCodTrabajador='$tramite->cSiglaAutor' order by cApellidosTrabajador asc";
            			$rsTipo = sqlsrv_query($cnx,$sqlTipo);
            			while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
                		echo $RsTipo["cApellidosTrabajador"].", ".$RsTipo["cNombresTrabajador"];
            			}
            			sqlsrv_free_stmt($rsTipo);
								?>
							</td>
						</tr>
						<tr>
							<td valign="top" >Oficina(s):</td>
							<td colspan="3" align="left"></td>
						</tr>
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
						<!--<tr style="padding-top:20px;">
							<td valign="top" >Documento complementario:</td>
							<td valign="top" colspan="3">
								<?php
		          				if(sqlsrv_has_rows($rsDocComplementario)>0){
		          					if(file_exists("../cAlmacenArchivos/".trim($docComplementario->cNombreNuevo))){
										echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($docComplementario->cNombreNuevo)."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($docComplementario->cNombreNuevo)."\"></a>";
									}
		          				}
								?>
							</td>
						</tr>-->
						<tr>
							<td colspan="4">
							<h3 style="color:#808080">ELABORAR DOCUMENTO ELECTRónICO</h3>
							<p style="padding:0px 0px 0px 14px;">

							<a href="javascript:void(0);" class="majorpoints btn-info btn" >Documento electrónico</a>
						    
						    <div class="hiders" style="display:none;padding:0px 0px 0px 14px; text-align: right" > 
								<textarea name="descripcion" id="descripcion" class="FormPropertReg form-control"><?php echo $tramite->descripcion; ?></textarea>
								<br>
									<table width='100%' border="0">
										<tr>
											<td align='center'>
												<input type="button" class="btn-info btn" href="javascript:;" 
												       onclick="generarDocumentoElec();return false;" value="Guardar Documento Eletronico"/>
												<span id="resultado"></span>
											</td>
										</tr>
									</table>
								<a href="javascript:void(0);" id="descargarDEG"><span></span></a>
								<a href="javascript:void(0);" id="imprimir"><span></span></a>
							</div>
							</p>
							<!--h3 style="color:#808080">PASO 2 - ABRIR FIRMA DIGITAL</h3><input type="button" value="Abrir" onClick="return go()">
							<h3 style="color:#808080">PASO 3 - ADJUNTAR DOCUMENTO ELECTRónICO</h3>
							<h4 style="color:#808080">Documento electrónico:</h4>
							<input type="file" name="documentoElectronicoPDF" id="documentoElectronicoPDF"-->
							<h4 style="color:#808080">Documento complementario:</h4>
							<input type="file" name="fileUpLoadDigital" id="fileUpLoadDigital"/>
							
							<script>
								CKEDITOR.replace('descripcion');
						  		$('.majorpoints').click(function(){
								    $('.hiders').toggle("slow");
								});
						  	</script>
						  	<td>
						</tr>
						<tr>
							<td colspan="4">
								 <input name="button" type="button" class="btn btn-primary" style="font-size: 12px;height: 29px;width: 100px;" value="Generar" onclick="subir_documento_electronico_firmado();">
						  	<td>
						</tr>
						
						</table>
				</div>		
			</td>
		</tr>
		<tr><td><img width="1088" height="11" src="images/pcm_8.jpg" border="0"></td></tr>

		<?php include("includes/userinfo.php");?>
	</table>

	<?php include("includes/pie.php");?>


	<script>
	    $( document ).ready(function() {
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

	    function subir_documento_electronico_firmado() {
	    	var formData = new FormData(); 
				//formData.append("documentoElectronicoPDF", $("#documentoElectronicoPDF")[0].files[0]);
				formData.append("fileUpLoadDigital", $("#fileUpLoadDigital")[0].files[0]);
				formData.append("iCodTramite", $("#iCodTramite").val());
	    	$.ajax({
	            type: 'POST',
	            url: 'subirDocumentoElectronicoFirmado.php', 
	            dataType: 'json',
	            success: function(s){
	            	console.log(s);
	            	$("#imprimir").attr("href", "registroInternoObsDEG.php?iCodTramite="+s.iCodTramite);
	            	$('#imprimir span').trigger('click');
	            },
	            error: function(e){
	            	console.log(e);
	                alert('Error Processing your Request!!');
	            },
	            data: formData,
                cache: false,
                contentType: false,
                processData: false
	        });
	    }
	    
	</script>
	</body>
	</html>

	<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>