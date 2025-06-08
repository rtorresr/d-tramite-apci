<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
require("core.php");
$p_bcType = 1;
$p_text = $_POST[cCodificacion];
$p_textEnc = $_POST[cCodificacion];
$p_xDim = 2;
$p_w2n = 3;
$p_charHeight = 50;
$p_charGap = $p_xDim;
$p_type = 2;
$p_label = "Y";
$p_checkDigit = "N";
$p_rotAngle = 0;
$dest = "wrapper.php?p_bcType=$p_bcType&p_text=$p_textEnc" . 
				"&p_xDim=$p_xDim&p_w2n=$p_w2n&p_charGap=$p_charGap&p_invert=$p_invert&p_charHeight=$p_charHeight" .
				"&p_type=$p_type&p_label=$p_label&p_rotAngle=$p_rotAngle&p_checkDigit=$p_checkDigit"
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
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

<div class="AreaTitulo">Registro de entrada sin tupa</div>	
		<br><br><br><br><br>
		 <b>LOS DATOS HAN SIDO REGISTRADOS SATISFACTORIAMENTE</b><br><br>
			<table>
			<tr>
			<td>
					<table>
					<tr><td align="right" style="padding-top:7px">CODIGO:&nbsp;</td><td align="left" style="font-size:22px;color:#00458A;font-family:verdana;text-align:center"><i><b><?=$_POST[cCodificacion]?></b></i></td></tr>
					<tr><td align="right">FECHA:&nbsp;</td><td align="left"><b><?=date("Y-m-d  H:m a")?></b></td></tr>
					<?
					include_once("../conexion/conexion.php");
					$sqlUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
					$rsUsr=sqlsrv_query($cnx,$sqlUsr);
					$RsUsr=sqlsrv_fetch_array($rsUsr);
					?>
					<tr><td align="right">REGISTRADOR:&nbsp;</td><td align="left"><b><?=$RsUsr[cApellidosTrabajador]?>, <?=$RsUsr[cNombresTrabajador]?></b></td></tr>			
					</table>
			</td>
			<td align="center">
					<img src="<?php echo $dest;?>" ALT="<?php echo strtoupper($p_text); ?>">
			</td>
			</tr>
			</table>


					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
 <?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>