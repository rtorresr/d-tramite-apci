<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Para eliminar
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
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

<div class="AreaTitulo">Registro - Dependencia</div>	
		<br><br><br><br><br>
		 <b>LOS DATOS HAN SIDO REGISTRADOS SATISFACTORIAMENTE</b><br><br>
		<table><tr><td align="left">
		 <u>DATOS DEL REGISTRO</u>
		CODIGO: <b>OFICIO-00006-2010-PRODUCE/OADA </b><br>
		FECHA: <b><?=date("Y-m-d  h:m:s")?></b><br>
		EXPIRA: <b>2010-12-11</b><br>
		REGISTRADOR: <b>Rodolfo Salcedo</b>
		 

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<?
include_once("../conexion/conexion.php");
include("includes/userinfo.php");
?>
</table>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>