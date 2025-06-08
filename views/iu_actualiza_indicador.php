<?php
session_start();
$pageTitle = "Actualizar Motivo";
$activeItem = "iu_indicadores.php";
$navExtended = true;
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
</head>
<body class="theme-default has-fixed-sidenav">
<?php include("includes/menu.php");?>

<!--Main layout-->
 <main class="mx-lg-5" >
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-md-12 mb-12">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center ">
                         Editar Motivo
                     </div>
                      <!--Card content-->
                     <div class="card-body">
                        <?php
                        require_once("../models/ad_busqueda.php");
                        ?>
                        <form action="../controllers/ln_actualiza_indicador.php" onSubmit="return validar(this)" method="post" name="form1">
                            <input name="iCodIndicacion" type="hidden" id="iCodIndicacion" value="<?php echo $Rs['iCodIndicacion']??''; ?>">
                            <input type="hidden" name="cIndicacion2" value="<?=$Rs['cIndicacion']??''?>">
                            Descripcion de Motivo:
                            <input name="cIndicacion" type="text" id="cIndicacion"  maxlength="30" value="<?php echo trim($Rs['cIndicacion']??''); ?>" size="40" class="FormPropertReg form-control">
                            <?php if(isset($_GET['cIndicacion'])) if($_GET['cIndicacion']!="") echo "Motivo existente"?>
                            <button class="btn btn-primary"  type="submit" id="Actualizar Indicador" onMouseOver="this.style.cursor='hand'">
                                <b>Actualizar</b>
                                <img src="images/page_refresh.png" width="17" height="17" border="0">
                            </button>
                            <button class="btn btn-primary" type="button" onclick="window.open('iu_indicadores.php', '_self');" onMouseOver="this.style.cursor='hand'">
                                <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0">
                            </button>
                        </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </main>
<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>
<script>
        function validar(f) {
            var error = "Por favor, antes de crear complete:\n\n";
            var a = "";
            if (f.txtindicador.value == "") {
                a += " Ingrese Descripci�n de Indicador";
                alert(error + a);
            }

            return (a == "");

        }
    </script>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>