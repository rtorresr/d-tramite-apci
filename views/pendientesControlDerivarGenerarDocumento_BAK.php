<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
	if (!isset($_SESSION["cCodSessionDrv"])){ 
		$fecSesDrv=date("Ymd-Gis");	
		$_SESSION['cCodSessionDrv']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesDrv;
	}
if (!isset($_SESSION["cCodRef"])){ 
	$fecSesRef=date("Ymd-Gis");	
	$_SESSION['cCodDerivo']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesRef;
}
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include("includes/head.php");?>
	<script src="ckeditor/ckeditor.js"></script>

	<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
	<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
	<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
	<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
	<script Language="JavaScript">
		// function Derivar()
		// {
		//   if (document.frmConsulta.cCodTipoDoc.value.length == "")
		//   {
		//     alert("Seleccione Tipo Documento");
		//     document.frmConsulta.cCodTipoDoc.focus();
		//     return (false);
		//   }
		//   if (document.frmConsulta.iCodOficinaDerivar.value.length == "")
		//   {
		//     alert("Seleccione Derivar a:");
		//     document.frmConsulta.iCodOficinaDerivar.focus();
		//     return (false);
		//   }  
		//   if (document.frmConsulta.iCodTrabajadorDerivar.value.length == "")
		//   {
		//     alert("Seleccione Responsable");
		//     document.frmConsulta.iCodTrabajadorDerivar.focus();
		//     return (false);
		//   }
		//   if (document.frmConsulta.iCodIndicacionDerivar.value.length == "")
		//   {
		//     alert("Seleccione Indicación");
		//     document.frmConsulta.iCodIndicacionDerivar.focus();
		//     return (false);
		//   }
		   	
		//   document.frmConsulta.action="pendientesData.php";
		//   document.frmConsulta.opcion.value=2;
		//   document.frmConsulta.submit();
		// }
		// function Volver(){
		//   document.frmConsulta.action="registroData.php";
		//   document.frmConsulta.opcion.value=27;
		//   document.frmConsulta.submit();
		// }
	</script>
</head>
<body>

<table cellpadding="0" cellspacing="0" border="0" width="1088">

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

		<?php 
			$sqlDoc = "SELECT * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos 
								 WHERE Tra_M_Tramite.iCodTramite = Tra_M_Tramite_Movimientos.iCodTramite AND Tra_M_Tramite.iCodTramite='$_POST[iCodTramite]'";
			$rsDoc  = sqlsrv_query($cnx,$sqlDoc);
			$RsDoc  = sqlsrv_fetch_object($rsDoc);
	 	?>
	 	<input type="hidden" id="iCodTramite" name="iCodTramite" value="<?php echo $RsDoc->iCodTramite;?>"/>
		<div class="AreaTitulo">Derivar Documento : <?php echo $RsDoc->cCodificacion;?></div>	

		<table class="table">
			<tr>
				<td class="FondoFormListados" >
				<input type="hidden" name="iCodMovimiento" value="<?php echo $RsDoc->iCodMovimientoDerivar;?>" />
				 <fieldset>
	  				<legend class="LnkZonas">Destino de Derivo:</legend>	
      				<table cellpadding="3" cellspacing="3" border="0" >	
                        <tr>
							<td width="120" >Derivar a:</td>
							<td align="left" class="CellFormRegOnly">
								<select name="iCodOficinaDerivar" style="width:400px;" class="FormPropertReg form-control" >
								<?php				
								$sqlDep2="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina!='".$_SESSION['iCodOficinaLogin']."' ORDER BY cNomOficina ASC";
	              				$rsDep2=sqlsrv_query($cnx,$sqlDep2);
	              				while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
	              					if($RsDep2['iCodOficina']==$RsDoc->iCodOficinaDerivar)
	              		  			echo "<option selected>".$RsDep2["cNomOficina"]."</option>";
	              				}
	              				mysql_free_result($rsDep2);
								?>
	                          	</select>                                    
							</td>
						</tr>

						<tr>
							<td >Responsable:</td>
							<td align="left" class="CellFormRegOnly">
								<select name="iCodTrabajadorDerivar" style="width:250px;" class="FormPropertReg form-control">
								<?php

								$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='".$RsDoc->iCodOficinaDerivar."' And nFlgEstado=1 ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
					            $rsTrb=sqlsrv_query($cnx,$sqlTrb);
					            while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
					              	if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorDerivar] or $RsTrb[iCodTrabajador]==$RsDoc->iCodTrabajadorDerivar){
					              		echo "<option selected>".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
					              	}
					            }
					            sqlsrv_free_stmt($rsTrb);
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td width="120" >Indicación:</td>
							<td align="left" class="CellFormRegOnly">
								<select name="iCodIndicacionDerivar" style="width:200px;" class="FormPropertReg form-control">
									<?php
									$sqlIndic="SELECT * FROM Tra_M_Indicaciones where iCodIndicacion='$RsDoc->iCodIndicacionDerivar'";
					             	$rsIndic=sqlsrv_query($cnx,$sqlIndic);
					             	$RsIndic=sqlsrv_fetch_object($rsIndic);
					             	echo "<option selected>".$RsIndic->cIndicacion."</option>";
					             	sqlsrv_free_stmt($rsIndic);
									?>
								</select>
							</td>
						</tr>

						<tr>
							<td�>Prioridad: </td>
							<td�class="CellFormRegOnly">
								<select name="cPrioridad" id="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
									<?php 
										if($RsDoc->cPrioridadDerivar=="Alta"){
											$a1 = "selected";
											$a2 = "";
											$a3 = "";
										}else if($RsDoc->cPrioridadDerivar=="Media"){
											$a2 = "selected";
											$a3 = "";
											$a1 = "";
										}else{
											$a3 = "selected";
											$a2 = "";
											$a1 = "";
										}
									?>
									<option <?php echo $a1;?> value="Alta">Alta</option>
									<option <?php echo $a2;?> value="Media">Media</option>
									<option �<?php echo $a3;?> value="Baja">Baja</option>
								</select>
							</td>
						</tr>
						
					</table> 
                </fieldset>

                <fieldset>
                		<table>
                			<tr>
								<td  >Tipo de Documento:</td>
								<td align="left" class="CellFormRegOnly" colspan="3">
									<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:250px" disabled />
										<?php
										$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento where cCodTipoDoc='$RsDoc->cCodTipoDoc'";
				          				$rsTipo=sqlsrv_query($cnx,$sqlTipo);
				          				$RsTipo=sqlsrv_fetch_object($rsTipo);
				          				echo "<option selected>".$RsTipo->cDescTipoDoc."</option>";
				          				sqlsrv_free_stmt($rsTipo);
										?>
									</select>
								</td>
							</tr>
                           					
							<tr>
								<td   valign="top">Asunto:</td>
								<td align="left">
									<textarea name="cAsuntoDerivar" style="width:250px;height:55px" class="FormPropertReg form-control">
										<?php echo $RsDoc->cAsuntoDerivar;?>
									</textarea>
								</td>
								<td   valign="top">Observaciones:</td>
								<td align="left"><textarea name="cObservacionesDerivar" style="width:250px;height:55px" class="FormPropertReg form-control"><?php echo $RsDoc->cObservacionesDerivar; ?></textarea></td>
							</tr>
                    	</table>
                </fieldset>    							
			 	<fieldset>
	  				<legend class="LnkZonas">Activar otros Destinatarios:</legend>	
      				<table align="left">				
						<tr>
							<td  valign="top">Copias:</td>
							<td align="left">
								<table border=0>
								<tr>
				          			<td align="center">
				          				<div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="#" title="Lista de Oficinas" rev="width: 500px; height: 550px; scrolling: auto; border:no">Seleccione Oficinas</a></div>
				          			</td>
				         	 	</tr>
				          		</table>
				
								<?php
								$sqlMovs="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsDoc->iCodTramite' AND iCodMovimiento!='$_GET[iCodMovimientoDerivar]' AND iCodOficinaOrigen=$_SESSION['iCodOficinaLogin'] ORDER BY iCodMovimiento ASC";
			          			
			          			$rsMovs=sqlsrv_query($cnx,$sqlMovs);
								if(sqlsrv_has_rows($rsMovs)>0){
								?>
								<table border=1 width="100%">
								<tr>
									<td class="headColumnas" width="25">De</td>
									<td class="headColumnas" width="350">Oficina</td>
									<td class="headColumnas" width="350">Responsable</td>
									<td class="headColumnas" width="175">Indicacion</td>
									<td class="headColumnas" width="60">Prioridad</td>
								</tr>
								<?php
	          					while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
								?>
								<tr>
									<td align="center" valign="top">
						    			<?php
						    			$sqlOfO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs[iCodOficinaOrigen]'";
							      		$rsOfO=sqlsrv_query($cnx,$sqlOfO);
							      		$RsOfO=sqlsrv_fetch_array($rsOfO);
						     	 		echo "<a style=text-decoration:none href=javascript:; title=\"".trim($RsOfO[cNomOficina])."\">".trim($RsOfO[cSiglaOficina])."</a>";
						    			?>
					    			</td>
									<td align="left" valign="top">
									<?php
									$sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs[iCodOficinaDerivar]'";
					          		$rsOfc=sqlsrv_query($cnx,$sqlOfc);
					          		$RsOfc=sqlsrv_fetch_array($rsOfc);
					          		echo $RsOfc["cNomOficina"];
									?>
									</td>
									<td align="left" valign="top">
									<?php
									$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMovs[iCodTrabajadorDerivar]' And nFlgEstado=1";
				              		$rsTrb=sqlsrv_query($cnx,$sqlTrb);
				              		$RsTrb=sqlsrv_fetch_object($rsTrb);
				              		echo $RsTrb->cNombresTrabajador." ".$RsTrb->cApellidosTrabajador;
									?>
									</td>
									<td align="center" valign="top">
											<?php
											$sqlInd="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsMovs[iCodIndicacionDerivar]'";
						          		  	$rsInd=sqlsrv_query($cnx,$sqlInd);
						          		  	$RsInd=sqlsrv_fetch_array($rsInd);
						          		  	echo $RsInd["cIndicacion"];
											?>
									</td>
									<td align="left" valign="top">
										<?php echo $RsMovs[cPrioridadDerivar];?>
									</td>
								
								</tr>
								<?php}?>
								</table>
								<?php}?>
							</td>
						</tr>									
         			</table> 
       			</fieldset> 
				
				<table width="100%">
					<tr>
							<td colspan="4">
							<h3 style="color:#808080">PASO 1 - ELABORAR DOCUMENTO ELECTRónICO</h3>
							<p style="padding:0px 0px 0px 14px;">

							<a href="javascript:void(0);" class="majorpoints btn-info btn" >Documento electrónico</a>
						    
						    <div class="hiders" style="display:none;padding:0px 0px 0px 14px; text-align: right" > 
								<textarea name="descripcion" id="descripcion" class="FormPropertReg form-control"><?php echo $tramite->descripcion; ?></textarea>
								<br>
								<button type="button" id="myBtn" onclick="generarDocumentoElectronico()">Generar documento</button>
								<a href="javascript:void(0);" id="descargarDEG"><span></span></a>
								<a href="javascript:void(0);" id="imprimir"><span></span></a>
							</div>
							</p>
							<h3 style="color:#808080">PASO 2 - ABRIR FIRMA DIGITAL</h3><input type="button" value="Abrir" onClick="return go()">
							<h3 style="color:#808080">PASO 3 - ADJUNTAR DOCUMENTO ELECTRónICO</h3>
							<h4 style="color:#808080">Documento electrónico:</h4>
							<input type="file" name="documentoElectronicoPDF" id="documentoElectronicoPDF">
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

									<input name="button" type="button" class="btn btn-primary" style="font-size: 12px;height: 29px;width: 100px;" value="Derivar" onclick="subir_documento_electronico_firmado();">
						  	<td>
						</tr>
				</table>			
			
		</td>
	</tr>

						

					</div>
                  </div>
              </div>
          </div>
      </div>
  </main>
<?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>
<script>
	function generarDocumentoElectronico() {
	    	var parameters = {iCodTramite: $("#iCodTramite").val(),descripcion: CKEDITOR.instances.descripcion.getData()}

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
				formData.append("documentoElectronicoPDF", $("#documentoElectronicoPDF")[0].files[0]);
				formData.append("fileUpLoadDigital", $("#fileUpLoadDigital")[0].files[0]);
				formData.append("iCodTramite", $("#iCodTramite").val());
	    	$.ajax({
	            type: 'POST',
	            url: 'subirDocumentoElectronicoFirmado.php', 
	            dataType: 'json',
	            success: function(s){
	            	console.log(s);
	            	$("#imprimir").attr("href", "registroDerivadoGDE.php?iCodTramite="+s.iCodTramite);
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
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>