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







<table width="486" border="1" align="center">
  <tr>
    <td colspan="2">Criterios de Busqueda </td>
  </tr>
  <tr>
    <td width="255">Apellidos</td>
    <td width="215"><label>
      <input name="cUsuario" type="text" id="cUsuario" />
    </label></td>
  </tr>
  <tr>
    <td><label>
      <input type="submit" name="Submit" value="Iniciar Busqueda" />
    </label></td>
    <td><label>
      <input type="reset" name="Submit2" value="Restablecer" />
    </label></td>
  </tr>
</table>

<table class="table">
  <tr>
    <td colspan="12" bgcolor="#0099FF"><div align="center"> LISTADO DE TRABAJADORES </div></td>
  </tr>
  

<?
require_once("../models/ad_trabajador.php");

echo "<tr><td>Nombres</td><td>Apellidos</td><td>Tipo de Documento</td><td>E-mail</td><td>Estado</td><td>Opciones</td></tr>"; 
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "no hay trabajadores registrados<br>";
}
else{
while ($Rs1=sqlsrv_fetch_array($rs)){ ?>

<tr>
    <td bgcolor="#FFFF64"><?php echo $Rs1[cNombresTrabajador];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs1[cApellidosTrabajador];?></td>
    <td bgcolor="#FFFF64"><?  if ($Rs1[cTipoDocIdentidad]==0){
			echo "&nbsp";}
			if ($Rs1[cTipoDocIdentidad]==01){
			echo "DNI";}
			if ($Rs1[cTipoDocIdentidad]==02){
			echo "Libreta Militar";}
			if ($Rs1[cTipoDocIdentidad]==03){
			echo "Carnet de Extrangeria";}
	?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs1[cMailTrabajador];?></td>
    <td bgcolor="#FFFF64"><?php echo $Rs1[nFlgEstado];?></td>
	<td><a href="../controllers/ln_cancela_trabajador.php?cod=<?php echo $Rs1[cCodTrabajador];?>">Anular</a>
	<br>
	<a href="/iu_actualiza_trabajador.php?cod=<?php echo $Rs1[cCodTrabajador];?> &sw=2">Actualizar</a></td>
  </tr>
  
<?
}
}
?>
</table>


<?echo "<a class='btn btn-primary' href='iu_nuevo_trabajador.php'>Nuevo Trabajador</a>";
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
