<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
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

<div class="AreaTitulo">Maestra Remitentes</div>

<?
require_once("../models/ad_busqueda.php");

?>
<form action="../controllers/ln_actualiza_dependencia.php" method="post" name="form1">
<input type="hidden" name="iCodDependencia" value="<?=$Rs[iCodDependencia]?>">
<table width="600" border="0" bgcolor="#C7C5CD" align="center">
  <tr>
    <td  class="headCellColum" colspan="2" align="center">Actualizar Datos Dependencia </td>
    
  </tr>
  <tr>
    <td>Sigla de Dependencia </td>
    <td><input name="cSiglaDependencia" type="text" id="cSiglaDependencia" value="<?=$Rs[cSiglaDependencia]?>" size="30"></td>
  </tr>
    <tr>
    <td>Nombre de Dependencia </td>
    <td><input name="txtnom_dependencia" type="text" id="txtnom_dependencia" value="<?php echo $Rs[cNomDependencia]; ?>" size="30"></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="ACTUALIZA DEPENDENCIA"></td>
    </tr>
</table>

</form>


					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
