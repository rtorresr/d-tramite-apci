<?php
session_start();
require_once "../interoperabilidad/autoload.php";
require_once "../interoperabilidad/config/parametros.php";

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