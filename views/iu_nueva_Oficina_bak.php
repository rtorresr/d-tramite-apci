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

<div class="AreaTitulo">Maestra oficinas</div>




<form action="../controllers/ln_nueva_oficina.php" method="post" name="form1">

<table width="400" border="0"  align="center">
  <tr>
    <td class="headCellColum" colspan="3" align="center">Crear Nueva Oficina </td>
    
  </tr>
  
    <tr>
   	<td width="61">
    <td>Nombre de Oficina </td>
    <td><input name="cNomOficina" type="text" id="cNomOficina"></td>
    <tr>
  	<td width="61">
    <td>Sigla de Oficina </td>
    <td><input name="cSiglaOficina" type="text" id="cSiglaOficina"></td>
  </tr>
  </tr>
  <tr>
  	<td align="center" colspan="3"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="CREAR DEPENDENCIA"></td>
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