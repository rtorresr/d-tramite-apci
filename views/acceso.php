<?php
session_start();

$pageTitle = "Cambio de contraseña";
$activeItem = "acceso.php";
$navExtended = true;

If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--    <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
    <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen">
    <script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>-->
</head>
<body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <?php
    require_once("../conexion/conexion.php");
    $sql= "select * from Tra_M_Trabajadores where iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    ?>
    <!--Main layout-->
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><button type="submit" id="resetPassword" class="btn btn-primary" onclick="ingresar()"><i class="fas fa-key fa-fw left"></i><span>Cambiar</span></button></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <form action="../models/ad_trabajadores_data.php" method="post"  name="datos">
                <input type="hidden" name="opcion" value="3">
                    <div class="row">
                        <div class="col s12 m12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Cambie su contraseña</legend>
                                        <div class="row">
                                            <div class="col m3 input-field">
                                                <input type="text" id="usuario" name="usuario" class="form-control" value="<?php echo trim($Rs['cUsuario']);?>" disabled>
                                                <input name="cUsuario" type="hidden" value="<?php echo trim($Rs['cUsuario']); ?>">
                                                <label for="usuario">Usuario</label>
                                            </div>
                                            <div class="col m3 input-field">
                                                <input type="password" id="nuevo" name="nuevo" class="form-control" placeholder="Nueva contraseña"  >
                                                <label for="nuevo">Nueva Contraseña</label>
                                                <button id="nuevoboton" type="button" class="input-field__icon btn btn-link" onclick="mostrar()"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </main>

    <script>
        function ingresar() {
            document.datos.submit();
        }
        function mostrar() {
            document.getElementById("nuevo").setAttribute('type','text');
            document.getElementById('nuevoboton').setAttribute('onclick','nomostrar()');
            document.getElementById('nuevoboton').innerHTML = '<i class="fas fa-eye-slash"></i>';
        }
        function nomostrar() {
            document.getElementById('nuevo').setAttribute('type','password');
            document.getElementById('nuevoboton').setAttribute('onclick','mostrar()');
            document.getElementById('nuevoboton').innerHTML = '<i class="fas fa-eye"></i>';
        }
    </script>
    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>
</body>
</html>

<?php } else {
   header("Location: ../index-b.php?alter=5");
}
?>