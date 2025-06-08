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

<div class="AreaTitulo">Maestra Perfiles</div>

<form action="../controllers/ln_nuevo_perfil.php" method="post" name="form1">

<table width="400" border="0" align="center">
  <tr>
    <td class="headCellColum" colspan="2" align="center">Crear Nuevo Perfil </td>
  </tr>
  <tr>
    <td>Tipo de Perfil </td>
    <td><input name="txtperfil" type="text" id="txtperfil" size="30"></td>
  </tr>
  <tr>
    <td valign="top">Descripcion de Perfil </td>
    <td><label>
    <input name="textdescricion_perfil" type="text" id="textdescricion_perfil" size="30" />
    </label></td>
  </tr>
    
  <tr>
    <td align="center" colspan="2"><input name="Insert Perfil" type="submit" id="Insert Perfil" value="CREAR PERFIL"></td>
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

