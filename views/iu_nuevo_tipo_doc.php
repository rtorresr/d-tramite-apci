<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
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
                         Agregar Tipo de Documentos
                     </div>
                      <!--Card content-->
                     <div class="card-body">
                        <?php
                        require_once("../models/ad_busqueda.php");
                        ?>
                        <form action="../controllers/ln_nuevo_tipo_doc.php" onSubmit="return validar(this)" method="post" name="form1">
                                     Tipo de Documento:
                                      <input name="cDescTipoDoc" class="FormPropertReg form-control" style="text-transform:uppercase" maxlength="70" type="text" id="cDescTipoDoc"
                                             value="<?=$_GET['cDescTipoDoc']??''?>" size="40"/><?php if(isset($_GET['cSiglaDoc']))if($_GET['cSiglaDoc']!="") echo "El Tipo de Documento Ya Existe"?>
                                      <button class="btn btn-primary"  type="submit" id="Insert Tipo Doc" onMouseOver="this.style.cursor='hand'"> <b>Crear</b> <img src="images/page_add.png" width="17" height="17" border="0"> </button>
                                      <button class="btn btn-primary"  type="button" onclick="window.open('iu_tipo_doc.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>    </td>

                        </form>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>
<script>
    function validar(f) {
        var error = "Por favor, antes de crear complete:\n\n";
        var a = "";
        if (f.cDescTipoDoc.value == "") {
            a += " Ingrese el Tipo de Documento";
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