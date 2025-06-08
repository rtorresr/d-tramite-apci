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

<div class="AreaTitulo">Registro - Trabajador</div>	
		<br><br><br><br><br>
		 <b>LOS DATOS HAN SIDO REGISTRADOS SATISFACTORIAMENTE</b><br><br>
		<table><tr><td align="left">
		 <u>DATOS DEL REGISTRO</u>
		CODIGO: <b>MEMORANDO-00024-2010-PRODUCE/OADA</b><br>
		FECHA: <b><?=date("Y-m-d  h:m:s")?></b><br>
		EXPIRA: <b>2010-12-11</b><br>
		REGISTRADOR: <b>Rodolfo Salcedo</b>



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