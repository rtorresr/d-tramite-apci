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

<div class="AreaTitulo">Maestra Documentos de Identidad</div>


<form action="../controllers/ln_nuevo_doc_identidad.php" method="post" name="form1">

<table width="400" border="0" bgcolor="#6699FF" align="center">
  <tr>
    <td colspan="2" align="center">Crear Nuevo Documento de Identidad </td>
    
  </tr>
  <tr>
    <td>Codigo de Documento Identidad </td>
    <td><input name="txtcod_doc_ident" type="text" id="txtcod_doc_ident"></td>
  </tr>
    <tr>
    <td>Documento de Identidad </td>
    <td><input name="txtnom_oficina" type="text" id="txtnom_oficina"></td>
  </tr>
  <tr>
    <td align="center"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="CREA DOCUMENTO"></td>
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
