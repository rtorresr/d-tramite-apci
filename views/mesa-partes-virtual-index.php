<?php
include_once("../conexion/parametros.php");
$pageTitle = "Registro de Entrada";
$activeItem = "registroEntrada.php";
$navExtended = true;

?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
    </head>
    <body class="theme-default">
        <header class="mainHeader ">
            <div class="navbar-fixed">
                <nav class="navbar">
                    <div class="nav-wrapper">
                        <img class="left mr-3" style="height: 100%; margin-right: 0.5rem" width="50" src="https://cdn.apci.gob.pe/dist/images/dtramite__logo.svg" />
                        <h5 class="page-header truncate left">D-Trámite</h5>
                    </div>
                </nav>
            </div>
        </header>
        <div 
            class="container"
            style="height: calc(100vh - 70px);
                    display: flex;
                    align-items: center;">
            <div class="row">
                <div class="col s12 m7">
                    <h2 class="">Mesa de partes digital de la APCI</h2>
                    <p class="">Para mayor facilidad, ahora contamos con una Mesa de partes digital que le permitirá el envío de documentos a la  APCI.</p>
                    <a class="btn-primary btn-large" href="mesa-partes-virtual.php">Crear un documento</a>

                </div>
                <div class="col s12 m5">
                <picture>
                    <img width="100%" src="../dist/images/landing.png" class="" alt="">
                </picture>
                </div>
            </div>
        </div>
    <?php include("includes/pie.php"); ?>
    </body>
    </html>
<?php
?>