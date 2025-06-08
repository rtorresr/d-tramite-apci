<?PHP
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
	include_once("../conexion/conexion.php");
	require("core.php");
$p_bcType = 1;
$p_text = $_POST[nCodBarra];
$p_textEnc = $_POST[nCodBarra];
$p_xDim = 1;
$p_w2n = 3;
$p_charHeight = 50;
$p_charGap = $p_xDim;
$p_type = 2;
$p_label = "Y";
$p_checkDigit = "N";
$p_rotAngle = 0;
$fFechaHora=$_POST[fFecActual];
//$fFechaHora=date("d-m-Y  G:i");
$dest = "wrapper.php?p_bcType=$p_bcType&p_text=$p_textEnc" . 
				"&p_xDim=$p_xDim&p_w2n=$p_w2n&p_charGap=$p_charGap&p_invert=$p_invert&p_charHeight=$p_charHeight" .
				"&p_type=$p_type&p_label=$p_label&p_rotAngle=$p_rotAngle&p_checkDigit=$p_checkDigit"
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script language="Javascript">
var ventana;
function crearVentana() {
     ventana = window.open("registroAnexoConCluidoPrint.php?nCodBarra=<?=$_POST[nCodBarra]?>&cCodificacion=<?=$_POST[cCodificacion]?>&cPassword=<?=$_POST[cPassword]?>&fFechaHora=<?=$fFechaHora?>","nuevo","width=330,height=240");
     setTimeout(cerrarVentana,6000);
}

function cerrarVentana(){
     ventana.close();
}
</script> 
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
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

<div class="AreaTitulo">ANEXO N&ordm;: <?=$_POST[cCodificacion]?> - actualizado</div>	
<table cellpadding="0" cellspacing="0" border="0" width="1030"><tr><td class="FondoFormRegistro">
		<br><br>
					<div id="registroBarr">
						

	
					<table align="center" cellpadding="3" cellspacing="3" border="0">
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;"><img src="<?php echo $dest;?>" ALT="<?php echo strtoupper($p_text); ?>" width="260"></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">ANEXO N&ordm;:&nbsp;<?=$_POST[cCodificacion]?></i></td>
					<!-- I MAX -->	
					<?php 
						$codigo = substr($_POST['cCodificacion'],0,10);
	        	$sqlRefcnt = "SELECT clave FROM Tra_M_Tramite WHERE cCodificacion = '".$codigo."'";
	        	$rsCnT1 = sqlsrv_query($cnx,$sqlRefcnt);
	        	$RsCnT2 = sqlsrv_fetch_array($rsCnT1);
	        	$clave  = $RsCnT2[0];
					?>
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">CLAVE:&nbsp;<?php echo $clave; ?></i>
						</td>
					</tr>
					<!-- F MAX -->
					</tr>
					<tr>
						<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;
							<b>
								<?php 
									$fFecActual = $fFechaHora;
									if (!empty($fFecActual)) {
										$date = date_create($fFecActual);
										echo $date->format("Y-m-d H:i:s");
									}
								?>
							</b>
							</td>
						</tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b></td></tr>
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
							<button class="btn btn-primary" style="width:120px" onclick="window.open('consultaEntradaPersonal.php', '_self');" onMouseOver="this.style.cursor='hand'">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td style=" font-size:10px"><b>Retornar</b>&nbsp;&nbsp;</td>
										<td><img src="images/icon_retornar.png" width="17" height="17" border="0"></td>
									</tr>
								</table>
							</button>
						</td>
						<td><div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;" align="center"><a style=" text-decoration:none" onClick="crearVentana();" href="javascript:;">Imprimir Ficha</a></div></td>
						<!-- <td>
							<button class="btn btn-primary" style="width:120px"
									onclick="window.open('registroAnexoHojaRuta.php?cCodificacion=<?=$_POST[cCodificacion]?>&iCodTramite=<?=$_POST[iCodTramite]?>', '_blank');" onMouseOver="this.style.cursor='hand'">
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
									no ha sido registrado debido a una restricci�n en la extensi�n.
								</div>
								<?php}?>						


<?

include("includes/userinfo.php");
?>
</table>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>