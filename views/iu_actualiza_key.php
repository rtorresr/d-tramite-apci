<?php
session_start();
$pageTitle = "Cambio contraseña";
$activeItem = "iu_actualiza_key.php";
$navExtended = false;  


If($_SESSION['CODIGO_TRABAJADOR']!=""){
    include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>        
</head>
<body class="theme-default has-fixed-sidenav" >
    <?php include("includes/menu.php");?>
    <a name="area"></a>    

    <!--Main layout-->
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
                <form action="../models/ad_actualiza_key.php" method="post" name="formulario">
                    <input type="hidden" name="usr" value="<?=trim($_GET['usr'])?>">
                    <input type="hidden" name="cod" value="<?=trim($_GET['cod'])?>">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Datos</legend>
                                        <div class="row">                                            
                                            <div class="col s12 m6 input-field"> 
                                                <input type="text" id="usuario" name="usuario" class="form-control" value="<?=trim($_GET['usr'])?>" disabled>
                                                <label for="usuario">Usuario</label>
                                            </div>                                                  
                                            <div class="col s12 m6 input-field"> 
                                                <input type="password" id="contrasena" name="contrasena" class="form-control">
                                                <label for="contrasena">Nueva Contraseña</label>
                                                <button id="nuevoboton" onclick="mostrar()" class="input-field__icon btn btn-link"><i class="far fa-eye"></i></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s4 m2 offset-s4 offset-m5 input-field"">
                                                <button class="btn botenviar" type="submit" onclick="ingresar()" >Actualizar</button>
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>                                                                                                       
                        </div>
                    </div>
                </form>                     
        </div>
    </main>
    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    <script>
        $("select").on("change",function () {
            $(this).formSelect();
        });function ingresar() {
        document.datos.submit();
        }
        function mostrar() {
            document.getElementById("contrasena").setAttribute('type','text');
            document.getElementById('nuevoboton').setAttribute('onclick','nomostrar()');
            document.getElementById('nuevoboton').innerHTML = '<i class="far fa-eye-slash"></i>';
        }
        function nomostrar() {
            document.getElementById('contrasena').setAttribute('type','password');
            document.getElementById('nuevoboton').setAttribute('onclick','mostrar()');
            document.getElementById('nuevoboton').innerHTML = '<i class="far fa-eye"></i>';
        }
    </script>
    </body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>