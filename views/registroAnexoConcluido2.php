<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
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
$fFechaHora=date("d-m-Y  h:i");
$dest = "wrapper.php?p_bcType=$p_bcType&p_text=$p_textEnc" . 
				"&p_xDim=$p_xDim&p_w2n=$p_w2n&p_charGap=$p_charGap&p_invert=$p_invert&p_charHeight=$p_charHeight" .
				"&p_type=$p_type&p_label=$p_label&p_rotAngle=$p_rotAngle&p_checkDigit=$p_checkDigit"
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/detalle.css" media="screen" />
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
</head>
<body>

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

<div class="AreaTitulo">Documento N&ordm;: <?=$_POST[cCodificacion]?> - ANEXO ANADIDO</div>
<table cellpadding="0" cellspacing="0" border="0" width="910">
<tr>
<td class="FondoFormRegistro">
		
		<table width="880" border="0" align="center">
		<tr>
		<td>
					<br><br><br><br>
					<div id="registroBarr">
					<table align="center" cellpadding="3" cellspacing="3" border="0">
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;"><img src="<?php echo $dest;?>" ALT="<?php echo strtoupper($p_text); ?>" width="260"></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">REGISTRO N&ordm;:&nbsp;<?=$_POST[cCodificacion]?></i></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$fFechaHora?></b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b></td></tr>
					</table>
					</div><br>

						<div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;" align="center"><a style=" text-decoration:none" onClick="crearVentana();" href="javascript:;">Imprimir Ficha</a></div>

					<br><br><br><br><br>&nbsp;




					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<div>		
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
