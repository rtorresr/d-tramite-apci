<?php
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
        <div class="row wow fadeIn justify-content-center">
            <!--Grid column-->
            <div class="col-11 col-sm-8 col-md-6 col-xl-4">
                <!--Card-->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header text-center ">CREAR NUEVO PERFIL</div>
                    <!--Card content-->
                    <div class="card-body">
                        <form action="../controllers/ln_nuevo_perfil.php" onSubmit="return validar(this)" method="post" name="form1">
                            <div class="form-row justify-content-center">
                                <div class="col-12">
                                    <div class="md-form">
                                        <input type="text" id="cDescPerfil" name="cDescPerfil" class="FormPropertReg form-control" value="<?=$_GET['cDescPerfil']??''?>" >
                                        <?php if(($_GET['cDescPerfil']??'')!="") echo "Perfil existente"?>
                                        <label for="cDescPerfil">Nombre del Perfil</label>
                                    </div>
                                </div>

                                <div class="col- mx-3 mb-3">
                                    <button class="botenviar"  type="submit" id="Insert Perfil" onMouseOver="this.style.cursor='hand'">Crear</button>
                                </div>
                                <div class="col- mx-3">
                                    <button class="botenviar" type="button" onclick="window.open('iu_perfil.php', '_self');" onMouseOver="this.style.cursor='hand'">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->
            </div>
            <!--Grid column-->
        </div>
        <!--Grid column-->
</main>
<!--Main layout-->
<?php include("includes/userinfo.php");?>


<?php include("includes/pie.php");?>
<script>
    function validar(f) {
        var error = "Por favor, antes de crear complete:\n\n";
        var a = "";
        if (f.txtperfil.value == "") {
            a += " Ingrese Nùmero de Perfil";
            alert(error + a);
        }
        else if (f.textdescricion_perfil.value == "") {
            a += " Ingrese Descripciòn de perfil";
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

