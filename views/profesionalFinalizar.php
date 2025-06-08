<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
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
                         Finalizar Documento
                     </div>
                      <!--Card content-->
                     <div class="card-body">
					    <form name="frmConsulta" method="POST">
							<input type="hidden" name="opcion" value="4">
							<input type="hidden" name="iCodMovimiento" value="<?=((isset($_GET['iCodMovimientoAccion']))?$_GET['iCodMovimientoAccion']:'')?>">
							
							<tr>
							<td width="120"  valign="top">Observaciones:</td>
							<td align="left"><textarea name="cObservacionesFinalizar" style="width:400px;height:100px" class="FormPropertReg form-control"></textarea></td>
							</tr>
														
							<tr>
							<td colspan="2" align="right">
							<button class="btn btn-primary" onclick="Finalizar();" onMouseOver="this.style.cursor='hand'"> <b>Finalizar</b> <img src="images/icon_finalizar.png" width="17" height="17" border="0"> </button>
							&nbsp;&nbsp;
							<a class="btn btn-primary" href ='profesionalPendientes.php' > <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </a>
							
							</td>
							</tr>
							</form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php
include_once("../conexion/conexion.php");
include("includes/userinfo.php");
include("includes/pie.php");?>
<script Language="JavaScript">
                             <!--
                             function Finalizar()
                             {
                                 document.frmConsulta.action="profesionalData.php";
                                 document.frmConsulta.submit();
                             }
                             //--></script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>