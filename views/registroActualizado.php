<?php
session_start();
date_default_timezone_set('America/Lima');
if($_SESSION['CODIGO_TRABAJADOR']!=""){
	include_once("../conexion/conexion.php");
	require("core.php");
	$p_bcType     = 1;
	$p_text       = $_POST[nCodBarra];
	$p_textEnc    = $_POST[nCodBarra];
	$p_xDim       = 1;
	$p_w2n        = 3;
	$p_charHeight = 50;
	$p_charGap    = $p_xDim;
	$p_type       = 2;
	$p_label      = "Y";
	$p_checkDigit = "N";
	$p_rotAngle   = 0;
	$fFechaHora   = date("d-m-Y  G:i");
	$cCodificacion = trim($_POST['cCodificacion']);
	$fFechaHora = date("d-m-Y  G:i");
	/* I MAX */
		$dest         = "wrapper.php?p_bcType=$p_bcType&p_text=$cCodificacion" . 
										"&p_xDim=$p_xDim&p_w2n=$p_w2n&p_charGap=$p_charGap&p_invert=$p_invert&p_charHeight=$p_charHeight" .
										"&p_type=$p_type&p_label=$p_label&p_rotAngle=$p_rotAngle&p_checkDigit=$p_checkDigit"
	/* F MAX */
	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script language="Javascript">
var ventana;
function crearVentana(e) {
     ventana = window.open("registroConCluidoPrint.php?iCodTramite="+e+"&nCodBarra=<?=$_POST[nCodBarra]?>&cCodificacion=<?=$_POST[cCodificacion]?>&cPassword=<?=$_POST[cPassword]?>&fFechaHora=<?=$fFechaHora?>","nuevo","width=330,height=240");
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

<div class="AreaTitulo">Registro - Actualizado</div>	
		<table class="table">
		<tr>
		<td class="FondoFormRegistro">
			
					<br><br>
					<table align="center" cellpadding="3" cellspacing="3" border="0">
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b>
						</td>
					</tr>

					<tr>
                        <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;">
                            <?php
                                 //set it to writable location, a place for temp generated PNG files
                        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode\temp'.DIRECTORY_SEPARATOR;

                        //html PNG location prefix
                        $PNG_WEB_DIR = 'phpqrcode/temp/';

                        include "phpqrcode/qrlib.php";    

                        //ofcourse we need rights to create temp dir
                        if (!file_exists('c:/STD_DOCUMENTO'))
                            mkdir('c:/STD_DOCUMENTO', 0777, true);

                        if (!file_exists($PNG_TEMP_DIR))
                            mkdir($PNG_TEMP_DIR);

                        //$filename = $PNG_TEMP_DIR.'test.png';

                        $errorCorrectionLevel = 'L';   
                        $matrixPointSize = 2;
                        //$_REQUEST['data']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 

                        // Falla < ----------------------------------
    
                        // clave
	        	$sqlRefcnt = "SELECT clave FROM Tra_M_Tramite WHERE cCodificacion = '".$_POST[cCodificacion]."'";
	        	$rsCnT1 = sqlsrv_query($cnx,$sqlRefcnt);
	        	$RsCnT2 = sqlsrv_fetch_array($rsCnT1);
	        	$clave  = $RsCnT2[0];
    
                         $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/tramite_DOCUMENTARIO DIGITAL/ver_tramite.php?expediente='.$_POST[cCodificacion];
                        //$_REQUEST['data']='http://sitdd.apci.gob.pe/consulta/ver_tramite.php?expediente='.$_POST[cCodificacion].'&clave='.$clave;

                        //echo $_REQUEST['data'];
                        // user data
                        $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                        $filename = $PNG_TEMP_DIR.$codigoQr;

                        //echo $codigoQr;

                        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
						?>
											
						<?php echo $img_final="<img src=".$PNG_WEB_DIR.basename($filename).">" ?>
                 
                        </td>
                    </tr>

					
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">TRAMITE N&ordm;:&nbsp;<?=$_POST[cCodificacion]?></i>
						</td>
					</tr>

					<!-- I MAX -->	
					<?php
	        	$sqlRefcnt = "SELECT clave FROM Tra_M_Tramite WHERE cCodificacion = '".$_POST[cCodificacion]."'";
	        	$rsCnT1 = sqlsrv_query($cnx,$sqlRefcnt);
	        	$RsCnT2 = sqlsrv_fetch_array($rsCnT1);
	        	$clave  = $RsCnT2[0];
					?>
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">CLAVE:&nbsp;<?php echo $clave; ?></i>
						</td>
					</tr>
					<!-- F MAX -->
					
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$_POST[fFecActual2]?></b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b>
					</td>
				</tr>			
				
				<?php 
            $sqlGenerador = "SELECT cNombresTrabajador, cApellidosTrabajador 
                             FROM Tra_M_Trabajadores 
                             WHERE iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
            $rsGenerador  = sqlsrv_query($cnx,$sqlGenerador);
            $RsGenerador  = sqlsrv_fetch_object($rsGenerador);
          ?>
          
          <tr>
            <td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">
              <?php 
                echo "GENERADO POR :".$RsGenerador->cApellidosTrabajador.", ".$RsGenerador->cNombresTrabajador;
              ?>
            </td>
          </tr>

					</table>
					</div><br>

						<table>
							<tr>
								<td>
									<!-- <button class="btn btn-primary" style="width:120px" onclick="window.open('<?=$_POST[URI]?>', '_self');"
													onMouseOver="this.style.cursor='hand'">
									 -->	<table cellspacing="0" cellpadding="0">
											<tr>
												<td>
								<?php
	                $sql = "select * from Tra_M_Tramite where cCodificacion='".$_POST[cCodificacion]."'";
	                $rsGenerador1  = sqlsrv_query($cnx,$sql);
	                $RsGenerador1  = sqlsrv_fetch_object($rsGenerador1);
                                    
								?>
								<button class="btn btn-primary" style="width:120px" onclick="crearVentana('<?php echo $RsGenerador1->iCodTramite;?>');"
													onMouseOver="this.style.cursor='hand'">
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td style=" font-size:10px"><b>Imprimir Ficha </b>&nbsp;&nbsp;</td>
												<td><img src="images/icon_print.png" width="17" height="17" border="0"></td>
											</tr>
										</table>
									</button>
									<!-- <button class="btn btn-primary" style="width:120px" onclick="window.open('<?=$_POST[URI]?>', '_self');"
													onMouseOver="this.style.cursor='hand'">
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td style=" font-size:10px"><b>Retornar</b>&nbsp;&nbsp;</td>
												<td><img src="images/icon_retornar.png" width="17" height="17" border="0"></td>
											</tr>
										</table>
									</button> -->
								</td>
											</tr>
										</table>
									<!-- </button> -->
								</td>
							
									<!-- <td>
										<button class="btn btn-primary" style="width:120px" onclick="window.open('registroHojaRuta_pdf.php?nCodBarra=<?=$_POST[nCodBarra]?>&cCodificacion=<?=$_POST[cCodificacion]?>', '_blank');" onMouseOver="this.style.cursor='hand'">
											<table cellspacing="0" cellpadding="0">
												<tr>
													<td style=" font-size:10px"><b>Hoja de Ruta</b>&nbsp;&nbsp;</td>
													<td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
												</tr>
											</table>
										</button>
									</td> -->
							</tr>
						</table>
								
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

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>