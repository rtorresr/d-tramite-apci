<?php
session_start();
require_once "../interoperabilidad/autoload.php";
require_once "../interoperabilidad/config/parametros.php";
require_once('../vendor/autoload.php');

$pageTitle = "Interoperabilidad";
$activeItem = "interoperabilidad.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php require("includes/head.php");?>
        <script src="../dist/scripts/vendor.min.js?ver=1"></script>
        <script src="../interoperabilidad/config/parametros.js"></script>
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php require("includes/menu.php");?>
    <main>
        <?php
        if (isset($_GET['controller'])){
            $nombre_controlador = ucfirst($_GET['controller']).'Controller';

        } elseif (!isset($_GET['controller'])){
            $nombre_controlador = CONTROLLER_DEFAULT;
        } else {
            $error = new ErrorController();
            $error->index();
        }

        if (class_exists($nombre_controlador)){
            $controlador = new $nombre_controlador();

            if (isset($_GET['action']) && method_exists($controlador , $_GET['action'])){
                $action = $_GET['action'];
                $controlador->$action();
            } elseif (!isset($_GET['action'])){
                $action = ACTION_DEFAULT;
                $controlador->$action();
            } else {
                $error = new ErrorController();
                $error->index();
            }
        } else {
            $error = new ErrorController();
            $error->index();
        }
        ?>
    </main>
    <?php require("includes/userinfo.php"); ?>
    <?php require("includes/pie.php"); ?>
    </body>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>
