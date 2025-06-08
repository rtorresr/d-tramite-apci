<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != ""){
	include_once("../conexion/conexion.php");
	$fFechaHora = date("d-m-Y  G:i");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php"); ?>
<script language="Javascript">
	var ventana;
	function crearVentana() {
  	ventana = window.open("registroConCluidoPrint.php?nCodBarra=<?=$_POST[nCodBarra]?>&cCodificacion=<?=$_POST[cCodificacion]?>&cPassword=<?=$_POST[cPassword]?>&fFechaHora=<?=$fFechaHora?>&cDescTipoDoc=<?=$_POST['cDescTipoDoc']?>","nuevo","width=330,height=240");
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
			<?php 
				$sql = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite = ".$_POST['iCodTramite'];
				$rs  = sqlsrv_query($cnx,$sql);
				$Rs  = sqlsrv_fetch_object($rs);
			?>
			<br><br>
			<table align="center" cellpadding="3" cellspacing="3" border="0">
				<tr>
					<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b>
					</td>
				</tr>
				<?php 
					if ($Rs->nFlgEnvio == 1) {
				?>
					<tr>
					<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial"><?php if($_POST['cDescTipoDoc']==""){ echo "REGISTRO"; }Else{ echo $_POST['cDescTipoDoc'];}?> N&ordm;:&nbsp;<?=$_POST[cCodificacion]?></i>
					</td>
				</tr>
				<?php
					}else{
				?>
					<tr>
					<td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">Documento Actualizado
					</td>
				<?php
					}
				?>
				
				
				<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$_POST[fFecActual2]?></b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b></td></tr>
					</table>
					</div><br>
					 
						<table>
							<tr>
								<td>
									<button class="btn btn-primary" style="width:120px" 
													onclick="window.open('<?=$_POST[URI]?>', '_self');" onMouseOver="this.style.cursor='hand'">
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td style=" font-size:10px"><b>Retornar</b>&nbsp;&nbsp;</td>
												<td><img src="images/icon_retornar.png" width="17" height="17" border="0"></td>
											</tr>
										</table>
									</button>
								</td>
								
								<?php if($_POST[nFlgTipoDoc]!=3){?>
								<td>
									<!--button class="btn btn-primary" style="width:120px" 
													onclick="window.open('registroInternoHojasDeRuta_pdf.php?cCodificacion=<?=$_POST[cCodificacion]?>&iCodTramite=<?=$_POST[iCodTramite]?>', '_blank');" onMouseOver="this.style.cursor='hand'">
										<table cellspacing="0" cellpadding="0">
											<tr>
												<td style=" font-size:10px"><b>Hoja de Tr�mite</b>&nbsp;&nbsp;</td>
												<td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
											</tr>
										</table>
									</button-->
								</td>
								<?php } else if($_POST[nFlgTipoDoc]==3){?>
                <td><? /*<button class="btn btn-primary" style="width:120px" onclick="window.open('registroSalidaHojasDeRuta_pdf.php?cCodificacion=<?=$_POST[cCodificacion]?>&iCodTramite=<?=$_POST[iCodTramite]?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>Hoja de Ruta</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button> */?>
                </td>
                     <?php } ?>
							</tr>
						</table>
						
						<?php if($_POST[nFlgRestricUp]==1){?>
							<div style="font-family:arial;font-size:12px;color:#ff0000">
								<br>
								El archivo seleccionado "<b><?=$_POST[cNombreOriginal]?></b>" para "Adjuntar Archivo" <br>
								no ha sido registrado debido a una restricci�n en la extensi�n.
							</div>
								<?php}?>							

				</td>
			</tr>
		</table>
</div>		

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>