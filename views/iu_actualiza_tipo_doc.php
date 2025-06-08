<?php
$pageTitle = "Editar Tipo de Documento";
$activeItem = "iu_tipo_doc.php";
$navExtended = true;
session_start();
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
                         Actualizar Tipo de Documentos
                     </div>
                      <!--Card content-->
                     <div class="card-body">
                        <?php
                            require_once("../models/ad_busqueda.php");
                        ?>
                        <form action="../controllers/ln_actualiza_tipo_doc.php" onSubmit="return validar(this)" method="post" name="form1">
                        <input name="cCodTipoDoc" type="hidden" id="cCodTipoDoc" value="<?php echo $_GET['cod']??''; ?>">
                        <input name="cSiglaDoc2" type="hidden" value="<?php echo $_GET['cSiglaDoc']??''; ?>">
                        <input name="cDescTipoDoc2" type="hidden"  value="<?php echo $_GET['cDescTipoDoc']??''; ?>">
                        <input name="Entradax" type="hidden"  value="<?php echo $_GET['Entrada']??''?>">
                        <input name="Internox" type="hidden"  value="<?php echo $_GET['Interno']??''?>">
                        <input name="Salidax" type="hidden"  value="<?php echo $_GET['Salida']??''?>">
                        <input name="cDescTipoDocx" type="hidden"  value="<?php echo $_GET['cDescTipoDoc']??''?>">
                        <input name="pagx" type="hidden"  value="<?=$pag?>">

                        Documento:
                        <input name="cDescTipoDoc" class="FormPropertReg form-control"   maxlength="70" type="text" id="cDescTipoDoc" value="<?php echo trim( $_GET['cDescTipoDoc']??''); ?>" size="40" >
                        <button class="btn btn-primary"  type="submit" id="Actualizar Tipo Doc" onMouseOver="this.style.cursor='hand'">
                                 <b>Actualizar</b> <img src="images/page_refresh.png" width="17" height="17" border="0">
                             </button>
                        <button class="btn btn-primary" type="button" onclick="window.open('iu_tipo_doc.php', '_self');" onMouseOver="this.style.cursor='hand'">
                                  <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0">
                        </button>
                        </form>
 
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>

<script>
        function validar(f) {
            var error = "Por favor, antes de crear complete:\n\n";
            var a = "";

            if (f.cDescTipoDoc.value == "") {
                a += "Ingrese el Tipo de Documento";
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