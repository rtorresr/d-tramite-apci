<?php
date_default_timezone_set('America/Lima');
session_start();
$pageTitle = "Registro Salida";
$activeItem = "registroSalida.php";
$navExtended = true;
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
</head>
<body class="theme-default has-fixed-sidenav" >
    <?php
        include("includes/menu.php");
		include_once("../conexion/conexion.php");

		$sql="SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$_POST['iCodTramite']."'";
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
                             <div class="card-header text-center "> Registro >> doc. de salida oficina</div>
                              <!--Card content-->
                             <div class="card-body">
                                <table>
                                    <tr>
                                        <td class="FondoFormRegistro">
                                            <table border=0>
                                                <tr>
                                                    <td valign="top"  width="160">N&ordm; Documento:</td>
                                                    <td valign="top" colpsan="3" style="font-size:16px;color:#00468C">
                                                        <b>
                                                            <?php
                                                                //if ($tramite->nFlgEnvio == 0) {//PENDIENTE
                                                                    //echo "----------";
                                                                //}else{
                                                                    echo $tramite->cCodificacion;
                                                                //}
                                                            ?>
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"  width="160">Tipo de Documento:</td>
                                                    <td valign="top"><?php echo $tipoDocumento->cDescTipoDoc; ?></td>
                                                    <td  width="160">Fecha Registro:</td>
                                                    <td style="padding-top:5px;"><?php echo date_format($tramite->fFecRegistro,"d-m-Y G:i") ;?></td>
                                                </tr>
                                                <!--tr>
                                                    <td  width="160">Fecha Documento:</td>
                                                    <td><?php //echo date("d-m-Y G:i", strtotime($tramite->fFecDocumento)); ?></td>
                                                    <td valign="top"  width="160"></td>
                                                    <td valign="top">></td>
                                                </tr-->
                                                <tr>
                                                    <td valign="top" >Asunto:</td>
                                                    <td valign="top">
                                                        <textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control" disabled><?php echo $tramite->cAsunto; ?></textarea></td>
                                                    <td valign="top" >Observaciones:</td>
                                                    <td valign="top">
                                                        <textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php echo $tramite->cObservaciones;?></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" >Requiere Respuesta:</td>
                                                    <td><?php echo ($tramite->nFlgRpta ==1) ? 'Si':'No'; ?></td>
                                                    <td valign="top"  width="160">Referencia:</td>
                                                    <td >
                                                        <?php
                                                        $sqlRef = "SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite = ".$tramite->iCodTramite;
                                                        $rsRef = sqlsrv_query($cnx,$sqlRef);
                                                        while ($RsRef = sqlsrv_fetch_array($rsRef)) {
                                                        ?>
                                                            <span><?php echo $RsRef['cReferencia']; ?></span><br>
                                                        <?php
                                                        }
                                                    ?>
                                                    </td>
                                                    <!-- <td valign="top"><div id="listaReferenciaTemporal"></div></td> -->
                                                </tr>
                                                <tr>
                                                    <td valign="top" >Folios:</td>
                                                    <td><?php echo $tramite->nNumFolio;?></td>
                                                    <!--td valign="top"  width="160">Fecha Plazo:</td>
                                                    <td valign="top"><?php echo date("d-m-Y", strtotime($tramite->fFecPlazo));?></td-->
                                                </tr>
                                                <tr>
                                                    <td valign="top" >Destino:</td>
                                                    <td valign="top" colspan="3">
                                                        <table>
                                                            <tr>
                                                                <td valign="top"><input type="radio" name="radioMultiple" <?php if($tramite->iCodRemitente=="") echo "checked"; ?> disabled>M&uacute;ltiple</td>
                                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                                <td valign="top"><input type="radio" name="radioRemitente" <?php if($tramite->iCodRemitente!="") echo "checked"; ?> disabled>Un Destino</td>
                                                                <td valign="top">
                                                                    <div <?php if($tramite->iCodRemitente=="") echo "style=\"display:none\""; ?> id="areaRemitente">
                                                                    <?php
                                                                        if($tramite->iCodRemitente!=""){
                                                                            $sqlRem="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$tramite->iCodRemitente'";
                                                                            $rsRem=sqlsrv_query($cnx,$sqlRem);
                                                                            $RsRem=sqlsrv_fetch_object($rsRem);
                                                                            $iCodRemitente=$tramite->iCodRemitente;
                                                                            $sqlCarg="SELECT cDireccion, cDepartamento, cProvincia, cDistrito FROM Tra_M_Doc_Salidas_Multiples WHERE iCodTramite ='$tramite->iCodTramite'";
                                                                            $rsCarg=sqlsrv_query($cnx,$sqlCarg);
                                                                            $RsCarg=sqlsrv_fetch_object($rsCarg);
                                                                            $remi="";
                                                                            $dir=$RsCarg->cDireccion;
                                                                            $dep=$RsCarg->cDepartamento;
                                                                            $pro=$RsCarg->cProvincia;
                                                                            $dis=$RsCarg->cDistrito;
                                                                        }
                                                                    ?>
                                                                        <table cellpadding="0" cellspacing="2" border="0">
                                                                            <tr>
                                                                                <td align="right" width="70" style="color:#7E7E7E">Institución:&nbsp;</td>
                                                                                <td>
                                                                                    <input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" value="<?php echo $RsRem->cNombre; ?>" style="width:300px" readonly>
                                                                                </td>
                                                                                <td align="center">
                                                                                    <div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;text-align:center">
                                                                                        <a style=" text-decoration:none;cursor:not-allowed" href="javascript:void(0);">Buscar</a>
                                                                                    </div>
                                                                                </td>
                                                                                <td align="center"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="right" width="70" style="color:#7E7E7E">Destinatario:&nbsp;</td>
                                                                                <td>
                                                                                    <input id="cNomRemite" name="cNomRemite" value="<?=trim($tramite->cNomRemite)?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:300px" >
                                                                                </td>
                                                                                <td align="center">
                                                                                    <div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;text-align:center">
                                                                                        <a style=" text-decoration:none;cursor:not-allowed;" href="javascript:void(0);" >+ Datos</a>
                                                                                    </div>
                                                                                </td>
                                                                                <td align="center"></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" >Sigla Autor:</td>
                                                    <td>
                                                    <?php
                                                            $sqlTipo = "select iCodTrabajador, cNombresTrabajador, cApellidosTrabajador from [dbo].[Tra_M_Trabajadores] where iCodTrabajador='$tramite->cSiglaAutor'
                                                            order by cApellidosTrabajador asc";
                                                            $rsTipo = sqlsrv_query($cnx,$sqlTipo);
                                                            while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
                                                                echo $RsTipo["cApellidosTrabajador"].", ".$RsTipo["cNombresTrabajador"];
                                                            }
                                                            sqlsrv_free_stmt($rsTipo);
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="padding-left:15px;"> </td>
                                                    <h3 style="color:#808080">ELABORAR DOCUMENTO ELECTRÓNICO</h3>
                                                    <a href="javascript:void(0);" class="majorpoints btn-info btn" >Documento electrónico</a>
                                                    <div class="hiders" style="display:none;padding:0px 0px 0px 14px; text-align: right" >
                                                        <textarea name="descripcion" id="descripcion" class="FormPropertReg form-control"><?php echo $tramite->descripcion; ?></textarea>
                                                        <br>
                                                        <table width='100%' border="0">
                                                                <tr>
                                                                    <td align='center'>
                                                                        <input type="button" class="btn-info btn" href="javascript:;" onclick="generarDocumentoElectronico();return false;" value="Guardar Documento Eletronico" >
                                                                        <span id="resultado"></span>
                                                                    </td>
                                                                </tr>
                                                        </table>
                                                        <a href="javascript:void(0);" id="descargarDEG"></a>
                                                        <a href="javascript:void(0);" id="imprimir"></a>
                                                    </div>

                                                    <!--h3 style="color:#808080">PASO 2 - ABRIR FIRMA DIGITAL</h3><input type="button" value="Abrir" onClick="return go()">
                                                    <h3 style="color:#808080">PASO 3 - ADJUNTAR DOCUMENTO ELECTRÓNICO</h3>
                                                    <h4 style="color:#808080">Documento electrónico:</h4>
                                                    <input type="file" name="documentoElectronicoPDF" id="documentoElectronicoPDF"-->
                                                    <h4 style="color:#808080">Documento complementario: </h4>
                                                    <input type="file" name="fileUpLoadDigital" id="fileUpLoadDigital"/>

                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                         <input name="button" type="button" class="btn btn-primary" style="font-size: 12px;height: 29px;width: 100px;" value="Generar" onclick="subir_documento_electronico_firmado();">
                                                    <td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
		                    </div>
                         </div>
                    </div>
                </div>
            </div>
        </main>
	
<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>
<script src="ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('descripcion');
    $('.majorpoints').click(function(){
        $('.hiders').toggle("slow");
    });
  
    $( document ).ready(function() {
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
                	items += '&lt;div class="col-sm-11">'
                    items +='&lt;span style="background-color:#EAEAEA;">'+value.cReferencia
					items += '&lt;a href="javascript: void(0)" onClick="eliminarReferenciaTemporal('+value.iCodReferencia+')">'
					items += '&lt;img src="images/icon_del.png" border="0" width="13" height="13">'
					items += '&lt;/a>'
					items += '&lt;/span>' 
                });
                $("#listaReferenciaTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });

        
    });

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
                	items += '&lt;div class="col-sm-11">'
                    items +='&lt;span style="background-color:#EAEAEA;">'+value.cReferencia
					items += '&lt;a href="javascript: void(0)" onClick="eliminarReferenciaTemporal('+value.iCodReferencia+')">'
					items += '&lt;img src="images/icon_del.png" border="0" width="13" height="13">'
					items += '&lt;/a>'
					items += '&lt;/span>' 
                });
                $("#listaReferenciaTemporal").html(items);
            },
            error: function(e){
                alert('Error Processing your Request!!');
            }
        });
    }
    
    function generarDocumentoElecSalida(){
        CKEDITOR.instances.descripcion.updateElement();
            var parametros = {
                        "iCodTramite" : $("#iCodTramite").val(),
                    "descripcion" : $('textarea[name=cAsunto]').val(),
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
				//formData.append("documentoElectronicoPDF", $("#documentoElectronicoPDF")[0].files[0]);
				formData.append("fileUpLoadDigital", $("#fileUpLoadDigital")[0].files[0]);
				formData.append("iCodTramite", $("#iCodTramite").val());
	    	$.ajax({
	            type: 'POST',
	            url: 'subirDocumentoElectronicoFirmado.php', 
	            dataType: 'json',
	            success: function(s){
	            	console.log(s);
	            	$("#imprimir").attr("href", "registroInternoSalidaObsDEG.php?iCodTramite="+s.iCodTramite);
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