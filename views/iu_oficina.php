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

<div class="AreaTitulo">Maestra Dependencias</div>





<table width="400" border="1" align="center">
  <tr>
    <td colspan="4" bgcolor="#0099FF"><div align="center"> Listado de Oficinas SITD</div></td>
  </tr>
  

<?
require_once("../models/ad_oficina.php");

echo "<tr><td>CodOficina</td><td>NomOficina</td><td>Sigla</td><td>Opciones</td></tr>"; 
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "no hay trabajadores registrados<br>";
}
else{
while ($Rs=sqlsrv_fetch_array($rs)){ ?>

<tr>
    <td bgcolor="#FFFF64"><?php echo $Rs[cCodOficina];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs[cNomOficina];?></td>
	<td bgcolor="#FFFF64"><?php echo $Rs[cSiglaOficina];?></td>
    <td><a href="../controllers/ln_elimina_oficina.php?id=<?php echo $Rs[cCodOficina];?>">Anular</a>
	<br>
	<a href="/iu_actualiza_oficina.php?cod=<?php echo $Rs[cCodOficina];?>&sw=3">Actualizar</a></td>
  </tr>
 
<?
}
}
?>
</table>
<table width="400" border="0" align="center">
  <tr>
    <td align="right"><?echo "<a class='btn btn-primary' href='iu_nueva_oficina.php'>Nueva Oficina</a>";
?>
</td>
  </tr>
</table>



<tr>
<td width="1088" height="32" background="images/pcm_9.jpg">
<!-- **************** -->

<!-- **************** -->	
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>