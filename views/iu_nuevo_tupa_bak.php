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

<div class="AreaTitulo">Maestra Tupa</div>

<form action="../controllers/ln_nuevo_tupa.php" method="post" name="form1">

<table width="600" border="0" bgcolor="#6699FF" align="center">
  <tr>
    <td colspan="2" class="style1"><div align="center">Crea Nuevo Tupa</div></td>
  </tr>
  <tr>
    <td>Codigo Tupa </td>
    <td><input name="txtcod_tupa" type="text" id="txtcod_tupa"></td>
  </tr>
  <tr>
    <td>Descripcion de Tupa </td>
    <td><input name="txtdesc_tupa" type="text" id="txtdesc_tupa"></td>
  </tr>
  
  <tr>
    <td>A&ntilde;o de Tupa </td>
    <td><input name="txtanio_tupa" type="text" id="txtanio_tupa"  ></td>
  </tr>
  <tr>
    <td>Vigencia</td>
    <td>
      <select name="sltvigencia_tupa" id="sltvigencia_tupa">
        <option value="1">SI</option>
        <option value="0">NO</option>
      </select>

    <td colspan="2"><input name="Insert Trabajador2" type="submit" id="Insert Trabajador2" value="CREAR TUPA"></td>
    </tr>
</table>

</form> 



<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>