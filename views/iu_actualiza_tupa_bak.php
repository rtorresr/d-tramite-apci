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

<div class="AreaTitulo">Maestra TUPA</div>
<?
require_once("../models/ad_busqueda.php");

?>
<form action="../controllers/ln_actualiza_tupa.php" method="post" name="form1">
<input name="txtcod_tupa" type="hidden" id="txtcod_tupa" value="<?php echo $Rs['iCodTupa']; ?>">
<table width="700" border="0" bgcolor="#C7C5CD" align="center">
  <tr>
    <td class="headCellColum" colspan="2" class="style1"><div align="center">Crea Nuevo Tupa</div></td>
  </tr>
  
   
    <td>Descripcion de Tupa: </td>
    <td><input name="txtdesc_tupa" type="text" id="txtdesc_tupa" value="<?php echo $Rs[cNomTupa]; ?>" size="80"></td>
  </tr>
  
  <tr>
    <td>Duracion de Tupa: </td>
    <td><input name="txtdia_tupa" type="text" id="txtdia_tupa"  value="<?php echo $Rs[nDias]; ?>"></td>
  </tr>
  <tr>
    <td>Estado:</td>
    <td><input name="txtest_tupa" type="text" id="txtest_tupa"  value="<?php echo $Rs[nEstado]; ?>"></td>
    </td>
  </tr>
  
  <tr>
    <td colspan="2"> <input name="Insert Tupa" type="submit" id="Insert Tupa" value="ACTUALIZA TUPA"></td>
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