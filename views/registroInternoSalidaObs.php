<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$fFechaHora=date("d-m-Y  G:i");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");

?>
<script language="Javascript">
	var ventana;
	function crearVentana() {
	    ventana = window.open("registroConCluidoPrint.php?nCodBarra=<?=$_POST[nCodBarra]?>&cCodificacion=<?=$_POST[cCodificacion]?>&cPassword=<?=$_POST[cPassword]?>&fFechaHora=<?=$fFechaHora?>&cDescTipoDoc=<?=$_POST['cDescTipoDoc']?>","nuevo","width=370,height=200");
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

<div class="AreaTitulo">Registro - <?php if($_POST[nFlgClaseDoc]==1) echo "Interno Oficina"?><?php if($_POST[nFlgClaseDoc]==2) echo "Interno Trabajadores"?><?php if($_POST[nFlgClaseDoc]==3) echo "SALIDA"?><?php if($_POST[nFlgClaseDoc]==4) echo "SALIDA ESPECIAL"?></div>	
		<table class="table">
		<tr>
		<td class="FondoFormRegistro">
			<br><br>
				<table align="center" cellpadding="3" cellspacing="3" border="0">
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>PRESIDENCIA DE CONSEJO DE MINISTROS</b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial"><?php if($_POST['cDescTipoDoc']==""){ echo "REGISTRO"; }Else{ echo $_POST['cDescTipoDoc'];}?> N&ordm;:&nbsp;<?=$_POST[cCodificacion]?></i></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$_POST[fFecActual]?></b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>WWW.PCM.GOB.PE</b></td></tr>			
					</table>
					</div>
						 
						<table><tr>
							<td><button class="btn btn-primary" style="width:120px" onclick="crearVentana();" onMouseOver="this.style.cursor='hand'"> <b>Imprimir Ficha</b> <img src="images/icon_print.png" width="17" height="17" border="0"> </button></td>
							<?php 
							$tramitePDF=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_POST[iCodTramite]'");
  							$RsTramitePDF=sqlsrv_fetch_object($tramitePDF);
							if ($RsTramitePDF->descripcion != NULL and $RsTramitePDF->descripcion!=' ') {
  							?>
							<td>
							<button class="btn btn-primary" style="width:120px" onclick="window.open('registroInternoDocumento_pdf.php?iCodTramite=<?=$_POST[iCodTramite]?>', '_blank');" onMouseOver="this.style.cursor='hand'">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td style=" font-size:10px"><b>Documento</b>&nbsp;&nbsp;</td>
										<td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
									</tr>
								</table>
							</button>
							</td>
							<?php } ?>
              <?php if($_POST[iCodRemitente]==0  and $_POST[nFlgTipoDoc]==3){
							$sqlSal= "SP_DOC_SALIDA_MULTIPLE_DL '$_POST[iCodTramite]' ";
							$rsSal=sqlsrv_query($cnx,$sqlSal);
						 	?>                           
                        <td>
                        
                        <button class="btn btn-primary" type="button" onclick="window.open('iu_doc_salidas_multiple.php?cod=<?=$_POST[iCodTramite]?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Agregar Destinatarios</b>  </button>
                     
                         </td>

                        <?php }  ?> 
							<?php if($_POST[nFlgTipoDoc]!=3){?>
							<td><button class="btn btn-primary" style="width:120px height:20px" onclick="window.open('registroInternoHojasDeRuta_pdf.php?cCodificacion=<?=$_POST[cCodificacion]?>&iCodTramite=<?=$_POST[iCodTramite]?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>Hoja de TRÁMITE</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
							</td>
							<td>
							<button class="btn btn-primary" style="width:120px" onclick="window.open('registroInternoDocumento_pdf.php?iCodTramite=<?=$_POST[iCodTramite]?>', '_blank');" onMouseOver="this.style.cursor='hand'">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td style=" font-size:10px"><b>Documento</b>&nbsp;&nbsp;</td>
										<td><img src="images/icon_pdf.png" width="17" height="17" border="0"></td>
									</tr>
								</table>
							</button>
							</td>
							<?php } else if($_POST[nFlgTipoDoc]==3){?>
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

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>