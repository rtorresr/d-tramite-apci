<?php
session_start();
date_default_timezone_set('America/Lima');
if($_SESSION['CODIGO_TRABAJADOR']!=""){
	include_once("../conexion/conexion.php");
	$fFechaHora = date("d-m-Y  G:i");
?>
<!DOCTYPE html>
<html lang="es">
<head>

<?php 
	include("includes/head.php");
	$tramite   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
	$RsTramite = sqlsrv_fetch_object($tramite);

	$sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTramite->cCodTipoDoc'";
	$rsTipDoc  = sqlsrv_query($cnx,$sqlTipDoc);
	$RsTipoDocumento = sqlsrv_fetch_object($rsTipDoc);
	$fFecActual=date("d-m-Y G:i"); 
?>

<script language="Javascript">
	var ventana;
	function crearVentana() {
		ventana = window.open("registroConCluidoPrint.php?iCodTramite=<?=$_GET[iCodTramite]?>&nCodBarra=<?=$RsTramite->nCodBarra?>&cCodificacion=<?=$RsTramite->cCodificacion?>&cPassword=<?=$RsTramite->cPassword?>&fFechaHora=<?=$fFechaHora?>&cDescTipoDoc=<?=$RsTipoDocumento->cDescTipoDoc?>&aprobadoPrint=<?=$RsTramite->nFlgEnvio?>&icodTramite=<?=$_GET[iCodTramite]?>","nuevo","width=370,height=200");
	  setTimeout(cerrarVentana,6000);
	}
	function cerrarVentana(){
	     ventana.close();
	}

</script> 
</head>
<body>

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

<div class="AreaTitulo">Registro - <?php if($RsTramite->nFlgClaseDoc==1) echo "Interno Oficina"?><?php if($RsTramite->nFlgClaseDoc==2) echo "Interno Trabajadores"?><?php if($RsTramite->nFlgClaseDoc==3) echo "SALIDA"?><?php if($RsTramite->nFlgClaseDoc==4) echo "SALIDA ESPECIAL"?>
</div>
	<table class="table">
		<tr>
			<td class="FondoFormRegistro">
				<br><br>
				<table align="center" cellpadding="3" cellspacing="3" border="0">
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial">
							<b>SITDD</b>
						</td>
					</tr>

					<tr>
						<td align="center" 
							style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">
								<?php 
									if ($RsTramite->cCodificacionI != "") {
										echo "TRAMITE INTERNO ".$RsTramite->cCodificacionI;
									}
								?>
						</td>
					</tr>
					
					<tr>
						<td align="center" 
							style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">
								<?php 
									$sql= "select cDescTipoDoc from Tra_M_Tipo_Documento where cCodTipoDoc='".$RsTramite->cCodTipoDoc."'";
									$query=sqlsrv_query($cnx,$sql);
									$rs=sqlsrv_fetch_array($query);
									do{
									   echo $tiempo=$rs['cDescTipoDoc'];
									}while($rs=sqlsrv_fetch_array($query));
								?>
								<br>
								<?php echo $RsTramite->cCodificacion;?>
						</td>
					</tr>
					
					<tr>
						<td align="center" 
							style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">
								<?php 
                                    if($RsTramite->nFlgEnvio==0){
                                    echo "<font color=red>(Por Aprobar)</font>";
                                    }else{
                                    echo "";
                                    }
								?>
						</td>
					</tr>

					<?php 
						if ($_GET['aprobado'] == 1) {
					?>
					<tr>
						<td align="center" 
							style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">
								<?php if($RsTipoDocumento->cDescTipoDoc==""){ echo "REGISTRO"; }else{ echo $RsTipoDocumento->cDescTipoDoc;}?> N&ordm;:&nbsp;	<?=$RsTramite->cCodificacion?></i>
						</td>
					</tr>
					<?php
						}
					?>
					<!-- <tr>
						<td align="center" 
							style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">
								<?php if($RsTipoDocumento->cDescTipoDoc==""){ echo "REGISTRO"; }else{ echo $RsTipoDocumento->cDescTipoDoc;}?> N&ordm;:&nbsp;	<?=$RsTramite->cCodificacion?></i>
						</td>
					</tr> -->
					
					<?php 
						if ($_GET['aprobado'] == 1) {
					?>
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;
							<b><?php echo $RsTramite->FECHA_DOCUMENTO?></b>
						</td>
					</tr>
					<?php
						}else{
					?>
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;
							<b><?=$fFecActual?></b>
						</td>
					</tr>
					<?php
						}
					?>
					
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial">
							<b>sitdd.apci.gob.pe</b>
						</td>
					</tr>
				</table>
				
				<?php
                    // -------------------------------------------------------
                    // Derivar inmediatamente: correo instantaneo  
                    // -------------------------------------------------------
                        $tipodocumento  =   $RsTramite->cCodificacion;
                        $codx           =   $_POST['cCodificacion'];
                        $opc='2';

                        include("email.php");
                    // -------------------------------------------------------
				?> 
			</div>
			 
				<table>
					<tr>
						<td>
							<!---button class="btn btn-primary" style="width:120px" onclick="crearVentana();" onMouseOver="this.style.cursor='hand'">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td style=" font-size:10px"><b>Imprimir Ficha</b>&nbsp;&nbsp;</td>
										<td><img src="images/icon_print.png" width="17" height="17" border="0"></td>
									</tr>
								</table>
							</button-->
						</td>
            <?php 
            	if ($RsTramite->iCodRemitente == 0 AND $RsTramite->nFlgTipoDoc == 3){
								$sqlSal = "SP_DOC_SALIDA_MULTIPLE_DL '$_GET[iCodTramite]' ";
								$rsSal = sqlsrv_query($cnx,$sqlSal);
						 	?>                           
            <td>
            	<button class="btn btn-primary" type="button"
            					onclick="window.open('iu_doc_salidas_multiple.php?cod=<?=$_GET[iCodTramite]?>', '_self');" 
            					onMouseOver="this.style.cursor='hand'">
            		<table cellspacing="0" cellpadding="0">
            			<tr>
            				<td style=" font-size:10px"><b>Agregar Destinatarios</b>&nbsp;&nbsp;</td>

            			</tr>
            		</table>
            	</button>
            </td>
            <?php }  ?> 
						<?php if($RsTramite->nFlgTipoDoc!=3){?>
						<!-- <td>
							<button class="btn btn-primary" style="width:120px height:20px"
								onclick="window.open('registroInternoHojasDeRuta_pdf.php?cCodificacion=<?=trim($RsTramite->cCodificacion)?>&iCodTramite=<?=$RsTramite->iCodTramite?>', '_blank');" 
								onMouseOver="this.style.cursor='hand'">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td style=" font-size:10px"><b>Hoja de TRÁMITE</b>&nbsp;&nbsp;</td>
										<td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
									</tr>
								</table>
							</button>
						</td> -->

							<?php 
								$tramitePDF   = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
					  		$RsTramitePDF = sqlsrv_fetch_object($tramitePDF);
								if (!empty($RsTramitePDF->descripcion) 
										AND $RsTramitePDF->descripcion !=NULL 
										AND $RsTramitePDF->descripcion !=' ') {				
							?>
							<!-- <td>
								<button class="btn btn-primary" style="width:120px"
												onclick="window.open('registroInternoDocumento_pdf.php?iCodTramite=<?=$_GET[iCodTramite]?>','_blank');" onMouseOver="this.style.cursor='hand'">
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td style=" font-size:10px"><b>Documento</b>&nbsp;&nbsp;</td>
											<td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
										</tr>
									</table>
								</button>
							</td> -->
							<?php 
								}  
							?>

							<?php } else if($RsTramite->nFlgTipoDoc==3){?>
                            <td>
                    </td>
                             <?php } ?>
						</tr></table>
								<?php if($_POST[nFlgRestricUp]==1){?>
								<div style="font-family:arial;font-size:12px;color:#ff0000">
									<br>
									El archivo seleccionado "<b><?=$_POST[cNombreOriginal]?></b>" para "Adjuntar Archivo" <br>
									no ha sido registrado debido a una restricción en la extensión.
								</div>
								<?php}?>						

</div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>