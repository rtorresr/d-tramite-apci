<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$fFechaHora=date("d-m-Y h:i");
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

<div class="AreaTitulo">Documento N&ordm;: <?=$_POST[cCodificacion]?> - Copias generadas</div>	
<table cellpadding="0" cellspacing="0" border="0" width="1030"><tr><td class="FondoFormRegistro">
		<br><br>
					<div id="registroBarr">
					<table align="center" cellpadding="3" cellspacing="3" border="0">
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">TRAMITE N&ordm;:&nbsp;<?=$_POST[cCodificacion]?></i></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$_POST[fFecActual]?></b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b></td></tr>
					</table>
					</div><br>

						<table>
						<tr>
							<td>
								<button class="btn btn-primary" style="width:120px" onclick="window.open('<?=$_POST[URI]?>', '_self');" onMouseOver="this.style.cursor='hand'">
									<table cellspacing="0" cellpadding="0">
										<tr>
											<td style=" font-size:10px"><b>Retornar</b>&nbsp;&nbsp;</td>
											<td><img src="images/icon_retornar.png" width="17" height="17" border="0"></td>
										</tr>
									</table>
								</button>
							</td>
						<!-- 	<td>
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