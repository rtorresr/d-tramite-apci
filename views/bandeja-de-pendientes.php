<?php
session_start();

$pageTitle = "Bandeja de Recibidos";
$activeItem = "bandeja-de-pendientes.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <link href="includes/component-dropzone.css" rel="stylesheet">
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li>
                            <a id="btnPrimary" style="display: none" class="btn btn-flat btn-primary tooltipped" href="#" data-position="top" data-tooltip="Revisar">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 40 0 C 34.5 0 30 4.5 30 10 C 30 15.5 34.5 20 40 20 C 45.5 20 50 15.5 50 10 C 50 4.5 45.5 0 40 0 z M 40 2 C 44.4 2 48 5.6 48 10 C 48 14.4 44.4 18 40 18 C 35.6 18 32 14.4 32 10 C 32 5.6 35.6 2 40 2 z M 44.300781 5.4003906 L 38.900391 11.699219 L 35.599609 9.1992188 L 34.400391 10.800781 L 39.099609 14.400391 L 45.800781 6.6992188 L 44.300781 5.4003906 z M 9 8 C 8.569 8 8.1877813 8.2745937 8.0507812 8.6835938 L 2.0507812 26.683594 C 2.0494749 26.687505 2.0500835 26.691397 2.0488281 26.695312 A 1.0001 1.0001 0 0 0 2 27 L 2 42 A 1.0001 1.0001 0 0 0 3 43 L 47 43 A 1.0001 1.0001 0 0 0 48 42 L 48 27 A 1.0001 1.0001 0 0 0 47.947266 26.683594 L 45.873047 20.457031 C 45.291047 20.784031 44.679969 21.059109 44.042969 21.287109 L 45.613281 26 L 32 26 A 1.0001 1.0001 0 0 0 31 27 C 31 30.325562 28.325562 33 25 33 C 21.674438 33 19 30.325562 19 27 A 1.0001 1.0001 0 0 0 18 26 L 4.3867188 26 L 9.7207031 10 L 28 10 C 28 9.317 28.069688 8.652 28.179688 8 L 9 8 z M 4 28 L 17.203125 28 C 17.718014 31.915394 20.947865 35 25 35 C 29.052135 35 32.281986 31.915394 32.796875 28 L 46 28 L 46 41 L 4 41 L 4 28 z"/>
                                </svg>
                                <span>Revisar</span>
                            </a>
                        </li>
                        <li>
                            <a id="btnRechazar" style="display: none" class="btn btn-link tooltipped" href="#modalRechazar" data-position="top" data-tooltip="Rechazar">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 25 2 C 12.309534 2 2 12.309534 2 25 C 2 37.690466 12.309534 48 25 48 C 37.690466 48 48 37.690466 48 25 C 48 12.309534 37.690466 2 25 2 z M 25 4 C 36.609534 4 46 13.390466 46 25 C 46 36.609534 36.609534 46 25 46 C 13.390466 46 4 36.609534 4 25 C 4 13.390466 13.390466 4 25 4 z M 32.990234 15.986328 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.990234 15.986328 z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a id="btnSecondary"  style="display: none" class="btn btn-link tooltipped" href="#modalArchivar" data-position="top" data-tooltip="Archivar">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 1 3 L 1 15 L 3 15 L 3 48 L 47 48 L 47 15 L 49 15 L 49 3 Z M 3 5 L 47 5 L 47 13 L 3 13 Z M 5 15 L 45 15 L 45 46 L 5 46 Z M 17.5 19 C 15.578125 19 14 20.578125 14 22.5 C 14 24.421875 15.578125 26 17.5 26 L 32.5 26 C 34.421875 26 36 24.421875 36 22.5 C 36 20.578125 34.421875 19 32.5 19 Z M 17.5 21 L 32.5 21 C 33.339844 21 34 21.660156 34 22.5 C 34 23.339844 33.339844 24 32.5 24 L 17.5 24 C 16.660156 24 16 23.339844 16 22.5 C 16 21.660156 16.660156 21 17.5 21 Z"/>
                                </svg>
                            </a>
                        </li>

                        <?php
                            if ($_SESSION['iCodPerfilLogin'] == 3 || $_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20 ){
                            echo '<li><a id="btnFourth" style="display: none" class="btn btn-link tooltipped" data-position="top" data-tooltip="Enviar">
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                        <path d="M 25 2 C 12.308594 2 2 12.308594 2 25 C 2 37.691406 12.308594 48 25 48 C 37.691406 48 48 37.691406 48 25 C 48 12.308594 37.691406 2 25 2 Z M 25 4 C 36.609375 4 46 13.390625 46 25 C 46 36.609375 36.609375 46 25 46 C 13.390625 46 4 36.609375 4 25 C 4 13.390625 13.390625 4 25 4 Z M 28.90625 15.96875 C 28.863281 15.976563 28.820313 15.988281 28.78125 16 C 28.40625 16.066406 28.105469 16.339844 28 16.703125 C 27.894531 17.070313 28.003906 17.460938 28.28125 17.71875 L 34.5625 24 L 13 24 C 12.96875 24 12.9375 24 12.90625 24 C 12.355469 24.027344 11.925781 24.496094 11.953125 25.046875 C 11.980469 25.597656 12.449219 26.027344 13 26 L 34.5625 26 L 28.28125 32.28125 C 27.882813 32.679688 27.882813 33.320313 28.28125 33.71875 C 28.679688 34.117188 29.320313 34.117188 29.71875 33.71875 L 37.5625 25.84375 C 37.617188 25.808594 37.671875 25.765625 37.71875 25.71875 C 37.742188 25.6875 37.761719 25.65625 37.78125 25.625 C 37.804688 25.605469 37.824219 25.585938 37.84375 25.5625 C 37.882813 25.503906 37.914063 25.441406 37.9375 25.375 C 37.949219 25.355469 37.960938 25.332031 37.96875 25.3125 C 37.96875 25.300781 37.96875 25.292969 37.96875 25.28125 C 37.980469 25.25 37.992188 25.21875 38 25.1875 C 38.015625 25.082031 38.015625 24.980469 38 24.875 C 38 24.855469 38 24.832031 38 24.8125 C 38 24.800781 38 24.792969 38 24.78125 C 37.992188 24.761719 37.980469 24.738281 37.96875 24.71875 C 37.96875 24.707031 37.96875 24.699219 37.96875 24.6875 C 37.960938 24.667969 37.949219 24.644531 37.9375 24.625 C 37.9375 24.613281 37.9375 24.605469 37.9375 24.59375 C 37.929688 24.574219 37.917969 24.550781 37.90625 24.53125 C 37.894531 24.519531 37.886719 24.511719 37.875 24.5 C 37.867188 24.480469 37.855469 24.457031 37.84375 24.4375 C 37.808594 24.382813 37.765625 24.328125 37.71875 24.28125 L 37.6875 24.28125 C 37.667969 24.257813 37.648438 24.238281 37.625 24.21875 L 29.71875 16.28125 C 29.511719 16.058594 29.210938 15.945313 28.90625 15.96875 Z"/>
                                    </svg>
                                </a>
                                </li>';
                            }
                        ?>
                        <li>
                            <a id="btnDetail" style="display: none" class="btn btn-link tooltipped" data-position="top" data-tooltip="Información">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 9 4 C 6.2504839 4 4 6.2504839 4 9 L 4 41 C 4 43.749516 6.2504839 46 9 46 L 41 46 C 43.749516 46 46 43.749516 46 41 L 46 9 C 46 6.2504839 43.749516 4 41 4 L 9 4 z M 9 6 L 41 6 C 42.668484 6 44 7.3315161 44 9 L 44 41 C 44 42.668484 42.668484 44 41 44 L 9 44 C 7.3315161 44 6 42.668484 6 41 L 6 9 C 6 7.3315161 7.3315161 6 9 6 z M 23.451172 12 C 23.179172 12 23 12.171688 23 12.429688 L 23 15.570312 C 23 15.827312 23.178172 16 23.451172 16 L 23.451172 15.998047 L 26.544922 15.998047 C 26.816922 15.998047 27 15.826359 27 15.568359 L 27 12.429688 C 27 12.172688 26.816922 12 26.544922 12 L 23.451172 12 z M 23.474609 20 C 23.190609 20 23 20.151953 23 20.376953 L 23 37.623047 C 23 37.848047 23.188609 37.998047 23.474609 37.998047 L 23.474609 38 L 26.523438 38 C 26.809437 38 27 37.848047 27 37.623047 L 27 20.376953 C 27 20.151953 26.810437 20 26.523438 20 L 23.474609 20 z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a id="btnFlow" style="display: none" class="btn btn-link tooltipped" data-position="top" data-tooltip="Flujo">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 3 6 C 1.355469 6 0 7.355469 0 9 L 0 15 C 0 16.644531 1.355469 18 3 18 L 11 18 C 12.644531 18 14 16.644531 14 15 L 14 13 L 20 13 L 20 15 C 20 16.644531 21.355469 18 23 18 L 31 18 C 32.644531 18 34 16.644531 34 15 L 34 13 L 39 13 C 40.65625 13 42 14.34375 42 16 L 42 19 L 39 19 C 37.355469 19 36 20.355469 36 22 L 36 28 C 36 29.644531 37.355469 31 39 31 L 42 31 L 42 34 C 42 35.65625 40.65625 37 39 37 L 34 37 L 34 35 C 34 33.355469 32.644531 32 31 32 L 23 32 C 21.355469 32 20 33.355469 20 35 L 20 37 L 14 37 L 14 35 C 14 33.355469 12.644531 32 11 32 L 3 32 C 1.355469 32 0 33.355469 0 35 L 0 41 C 0 42.644531 1.355469 44 3 44 L 11 44 C 12.644531 44 14 42.644531 14 41 L 14 39 L 20 39 L 20 41 C 20 42.644531 21.355469 44 23 44 L 31 44 C 32.644531 44 34 42.644531 34 41 L 34 39 L 39 39 C 41.746094 39 44 36.746094 44 34 L 44 31 L 47 31 C 48.644531 31 50 29.644531 50 28 L 50 22 C 50 20.355469 48.644531 19 47 19 L 44 19 L 44 16 C 44 13.253906 41.746094 11 39 11 L 34 11 L 34 9 C 34 7.355469 32.644531 6 31 6 L 23 6 C 21.355469 6 20 7.355469 20 9 L 20 11 L 14 11 L 14 9 C 14 7.355469 12.644531 6 11 6 Z M 3 8 L 11 8 C 11.554688 8 12 8.445313 12 9 L 12 15 C 12 15.554688 11.554688 16 11 16 L 3 16 C 2.445313 16 2 15.554688 2 15 L 2 9 C 2 8.445313 2.445313 8 3 8 Z M 23 8 L 31 8 C 31.554688 8 32 8.445313 32 9 L 32 15 C 32 15.554688 31.554688 16 31 16 L 23 16 C 22.445313 16 22 15.554688 22 15 L 22 9 C 22 8.445313 22.445313 8 23 8 Z M 39 21 L 47 21 C 47.554688 21 48 21.445313 48 22 L 48 28 C 48 28.554688 47.554688 29 47 29 L 39 29 C 38.445313 29 38 28.554688 38 28 L 38 22 C 38 21.445313 38.445313 21 39 21 Z M 3 34 L 11 34 C 11.554688 34 12 34.445313 12 35 L 12 41 C 12 41.554688 11.554688 42 11 42 L 3 42 C 2.445313 42 2 41.554688 2 41 L 2 35 C 2 34.445313 2.445313 34 3 34 Z M 23 34 L 31 34 C 31.554688 34 32 34.445313 32 35 L 32 41 C 32 41.554688 31.554688 42 31 42 L 23 42 C 22.445313 42 22 41.554688 22 41 L 22 35 C 22 34.445313 22.445313 34 23 34 Z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a id="btnDoc" style="display: none" class="btn btn-link tooltipped" data-position="top" data-tooltip="Documento">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 7 2 L 7 48 L 43 48 L 43 15.410156 L 29.183594 2 Z M 9 4 L 28 4 L 28 17 L 41 17 L 41 46 L 9 46 Z M 30 5.578125 L 39.707031 15 L 30 15 Z M 23.769531 19.875 C 23.019531 19.875 22.242188 20.300781 21.902344 20.933594 C 21.558594 21.5625 21.535156 22.238281 21.621094 22.941406 C 21.753906 24.050781 22.257813 25.304688 22.910156 26.589844 C 22.585938 27.683594 22.429688 28.636719 21.941406 29.804688 C 21.320313 31.292969 20.558594 32.472656 19.828125 33.710938 C 18.875 34.15625 17.671875 34.554688 16.96875 35.015625 C 16.179688 35.535156 15.554688 36 15.1875 36.738281 C 15.007813 37.105469 14.914063 37.628906 15.09375 38.101563 C 15.273438 38.574219 15.648438 38.882813 16.035156 39.082031 C 16.855469 39.515625 17.800781 39.246094 18.484375 38.785156 C 19.167969 38.324219 19.777344 37.648438 20.390625 36.824219 C 20.699219 36.40625 20.945313 35.730469 21.25 35.242188 C 22.230469 34.808594 22.925781 34.359375 24.039063 33.976563 C 25.542969 33.457031 26.882813 33.238281 28.289063 32.933594 C 29.464844 33.726563 30.714844 34.34375 32.082031 34.34375 C 32.855469 34.34375 33.453125 34.308594 34.035156 33.992188 C 34.621094 33.675781 34.972656 32.914063 34.972656 32.332031 C 34.972656 31.859375 34.765625 31.355469 34.4375 31.03125 C 34.105469 30.707031 33.714844 30.535156 33.3125 30.425781 C 32.515625 30.210938 31.609375 30.226563 30.566406 30.332031 C 30.015625 30.390625 29.277344 30.683594 28.664063 30.796875 C 28.582031 30.734375 28.503906 30.707031 28.421875 30.636719 C 27.175781 29.5625 26.007813 28.078125 25.140625 26.601563 C 25.089844 26.511719 25.097656 26.449219 25.046875 26.359375 C 25.257813 25.570313 25.671875 24.652344 25.765625 23.960938 C 25.894531 23.003906 25.921875 22.167969 25.691406 21.402344 C 25.574219 21.019531 25.378906 20.632813 25.039063 20.335938 C 24.699219 20.039063 24.21875 19.875 23.769531 19.875 Z M 23.6875 21.867188 C 23.699219 21.867188 23.71875 21.875 23.734375 21.878906 C 23.738281 21.886719 23.746094 21.882813 23.777344 21.980469 C 23.832031 22.164063 23.800781 22.683594 23.78125 23.144531 C 23.757813 23.027344 23.621094 22.808594 23.609375 22.703125 C 23.550781 22.238281 23.625 21.941406 23.65625 21.890625 C 23.664063 21.871094 23.675781 21.867188 23.6875 21.867188 Z M 24.292969 28.882813 C 24.910156 29.769531 25.59375 30.597656 26.359375 31.359375 C 25.335938 31.632813 24.417969 31.730469 23.386719 32.085938 C 23.167969 32.160156 23.042969 32.265625 22.828125 32.34375 C 23.132813 31.707031 23.511719 31.234375 23.785156 30.578125 C 24.035156 29.980469 24.078125 29.476563 24.292969 28.882813 Z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a id="btnAnexos" style="display: none" class="btn btn-link tooltipped" data-position="top" data-tooltip="Anexos" href="#modalAnexo">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 39 6 C 37.210938 6 35.421875 6.671875 34.0625 8.03125 L 14.21875 27.90625 C 14.148438 27.960938 14.085938 28.023438 14.03125 28.09375 C 14.007813 28.113281 13.988281 28.132813 13.96875 28.15625 C 13.921875 28.195313 13.882813 28.234375 13.84375 28.28125 C 13.84375 28.292969 13.84375 28.300781 13.84375 28.3125 C 12.105469 30.265625 12.160156 33.285156 14.03125 35.15625 C 15.972656 37.097656 19.152344 37.097656 21.09375 35.15625 L 36.1875 20.03125 C 36.484375 19.746094 36.574219 19.304688 36.414063 18.925781 C 36.257813 18.546875 35.878906 18.304688 35.46875 18.3125 C 35.207031 18.324219 34.960938 18.433594 34.78125 18.625 L 19.6875 33.71875 C 18.511719 34.894531 16.613281 34.894531 15.4375 33.71875 C 14.300781 32.582031 14.28125 30.804688 15.34375 29.625 C 15.378906 29.585938 15.410156 29.542969 15.4375 29.5 C 15.460938 29.480469 15.480469 29.460938 15.5 29.4375 L 15.59375 29.375 C 15.59375 29.363281 15.59375 29.355469 15.59375 29.34375 L 35.5 9.46875 C 37.453125 7.515625 40.574219 7.511719 42.53125 9.46875 C 44.484375 11.421875 44.484375 14.546875 42.53125 16.5 L 17.90625 41.125 C 15.171875 43.859375 10.765625 43.859375 8.03125 41.125 C 5.296875 38.390625 5.296875 33.984375 8.03125 31.25 L 27.71875 11.5625 C 28.015625 11.320313 28.152344 10.933594 28.066406 10.558594 C 27.980469 10.1875 27.6875 9.894531 27.316406 9.808594 C 26.941406 9.722656 26.554688 9.859375 26.3125 10.15625 L 6.625 29.84375 C 3.128906 33.339844 3.125 39.066406 6.625 42.5625 C 10.125 46.058594 15.816406 46.058594 19.3125 42.5625 L 43.96875 17.9375 C 46.6875 15.21875 46.6875 10.75 43.96875 8.03125 C 42.609375 6.671875 40.789063 6 39 6 Z"/>
                                </svg>
                            </a>
                        </li>
                        <?php
                            if ($_SESSION['iCodPerfilLogin'] == 3 || $_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20 ){
                            echo '<li>
                                    <a style="display: none" id="btnDescargarDoc" class="btn btn-link tooltipped" data-position="top" data-tooltip="Descargar documento">
                                        <i class="far fa-file-archive"></i>
                                    </a>
                                </li>';
                            }
                        ?>                        
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card" id="progressBar" style="display: none; position: fixed; z-index: 100000;width: 100%">
                        <div class="card-content">
                            <p style="text-align: center; font-weight: bold;"></p>
                            <div class="progress">
                                <div class="progressbar secondary indeterminate" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <table id="tblBandejaPendientes" class="hoverable highlight striped" style="width: 100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>CUD</th>
                                    <th>Documento</th>
                                    <th>Asunto</th>
                                    <th>Entidad Externa</th>
                                    <th>Oficina Origen</th>
                                    <th>Fecha de Envío</th>
                                    <th>Fecha Fin de Plazo</th>
                                    <th>Indicación</th>
                                    <th>Instrucción Específica</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <!--ENVIA CODIGO DE MOVIMIENTO DE LA BANDEJA QUE DA RESPUESTA-->
                    <form id="frmRespuesta" method="GET" action="registroOficina.php">
                        <input type="hidden" id="dtr" name="dtr">
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div id="modalRechazar" class="modal">
        <div class="modal-content">
            <h4>Motivo del rechazo</h4>
            <p>Esta opción devolverá el documento a la Bandeja de Recibidos del remitente.</p>
            <form name="formRechazo" class="row">
                <div class="col s12 input-field">
                    <textarea id="motRechazo" name="motRechazo"  class="materialize-textarea FormPropertReg"></textarea>
                    <label for="motRechazo">Ingrese motivo</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarRechazo" class="modal-close waves-effect btn-flat">Rechazar</a>
        </div>
    </div>

    <div id="modalArchivar" class="modal">
        <div class="modal-header">
            <h4>Archivar documentos</h4>
        </div>
        <div class="modal-content">
            <form name="formArchivar" class="row">
                <div class="col s12 input-field">
                    <textarea id="motArchivar" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="motArchivar">Motivo de archivo</label>
                </div>
                <div class="col s12">
                    <div class="card hoverable transparent">
                        <div class="card-body">
                            <fieldset>
                                <legend>Adjuntos</legend>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                        <div id="dropzoneAgrupado" class="dropzone"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12" style="padding-bottom: 0.75rem">
                                        <button type="button" class="btn btn-secondary" id="btnSubirDocsAgrupado">Subir</button>
                                    </div>
                                </div>
                                <div id="anexosDoc" style="display: block">
                                    <p style="padding: 0 15px">Seleccione los anexos:</p>
                                    <div class="row" style="padding: 0 15px">
                                        <div class="col s12">
                                            <table id="TblAnexos" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Archivo</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarArchivar" class="waves-effect btn-flat">Archivar</a>
        </div>
    </div>

    <div id="modalDerivar" class="modal">
        <div class="modal-header">
            <h4>Envío del documento</h4>
        </div>
        <div class="modal-content">
            <form name="formDerivar" class="row" id="formDerivar">
                <div class="col s12 m6 l6 input-field">
                    <select id="OficinaResponsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                        <option value="">Seleccione</option>
                        <?php
                        $sqlOfi = "SELECT iCodOficina, cNomOficina, cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0 AND flgEliminado = 0 ORDER BY cNomOficina ASC";
                        $rsOfi  = sqlsrv_query($cnx,$sqlOfi);
                        while ($RsDep2 = sqlsrv_fetch_array($rsOfi)){
                            echo "<option value=".$RsDep2['iCodOficina']." >".trim($RsDep2['cNomOficina'])." - ".trim($RsDep2["cSiglaOficina"])."</option>";
                        }
                        ?>
                    </select>
                    <label for="OficinaResponsableDer">Oficina</label>
                </div>
                <div class="col s12 m6 l6 input-field">
                    <select id="responsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary"></select>
                    <label for="responsableDer">Responsable</label>
                </div>
                <div class="input-field col s12 m5">
                    <select id="IndicacionDer">
                        <?php
                        $rsInd = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Indicaciones");
                        while ($RsInd = sqlsrv_fetch_array($rsInd)){
                            echo "<option value='".$RsInd['iCodIndicacion']."'>".trim($RsInd['cIndicacion'])."</option>";
                        } ?>
                    </select>
                    <label for="IndicacionDer">Indicación</label>
                </div>
                <div class="input-field col s12 m5">
                    <select id="prioridadDer"  class="size9 FormPropertReg mdb-select colorful-select dropdown-primary">
                        <option value="Alta">Alta</option>
                        <option value="Media" selected>Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                    <label for="prioridadDer">Prioridad</label>
                </div>
                <div class="input-field col s12 m2">
                    <select id="cCopiaDer"  class="size9 FormPropertReg mdb-select colorful-select dropdown-primary">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                    <label for="cCopiaDer">Copia</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="obsDerivar" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="obsDerivar">Instrucción Específica</label>
                </div>
                <div class="col s12">
                    <div class="row">
                        <div class="col s4">
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" id="habilitarPlazo">
                                    <span>Con plazo</span>
                                </label>
                            </p>
                        </div>
                        <div class="col s6 input-field" id="fecPlazoDiv" style="display: none;">
                            <input placeholder="dd-mm-aaaa" value="" type="text" id="fecPlazo" name="fecPlazo" class="FormPropertReg form-control datepicker">
                            <label for="fecPlazo">Fecha de Plazo</label>
                        </div>
                    </div>
                </div>
                <div class="col m2">
                    <input name="button" type="button" class="btn btn-secondary" value="Agregar" id="btnAgregarDestinoDerivar">
                </div>

                <table id="TblDestinosDerivar" class="bordered hoverable highlight striped" style="width:100%">
                    <thead>
                    <tr>
                        <th>Oficina</th>
                        <th>Responsable</th>
                        <th>Indicación</th>
                        <th>Prioridad</th>
                        <th>Instrucción Específica</th>
                        <th>Copia</th>
                        <th>Plazo</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarDer" class="waves-effect btn-flat">Derivar</a>
        </div>
    </div>

    <div id="modalDetalle" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Detalle del documento</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalFlujo" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Flujo del trámite</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalDoc" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Documento</h4>
        </div>
        <div class="modal-content p-0" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalAnexo" class="modal">
        <div class="modal-header">
            <h4>Anexos</h4>
        </div>
        <div class="modal-content">
            <ul class="fa-ul"></ul>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalRespuesta" class="modal">
        <div class="modal-header">
            <h4>Seleccionar cud principal</h4>
        </div>
        <div class="modal-content">
            <form name="formSeleccionar" id="formSeleccionar"></form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a class="waves-effect waves-green btn-flat" id="btnResptContinuar">Continuar</a>
        </div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>
    <script src="includes/dropzone.js"></script>
    <script>
        var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
        var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

        $(document).ready(function() {
            $('.datepicker').datepicker({
                i18n: {
                    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                    weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                    weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                    weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"],
                    cancel: "Cancelar",
                    clear: "Limpiar"
                },
                format: 'dd-mm-yyyy',
                disableWeekends: true,
                autoClose: true,
                showClearBtn: true
            });

            $('.actionButtons').hide();
            var tblBandejaPendientes = $('#tblBandejaPendientes').DataTable({
                responsive: true,                
                'processing': true,
                'serverSide': true,
                searchDelay: 1500,
                'serverMethod': 'post',
                ajax: 'ajaxtablas/ajaxBPendientes.php',
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaPendientes_length"]').formSelect();

                    // $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                    //     tblBandejaPendientes.rows().deselect();
                    // }); 
                    // $("div.dataTables_filter input").unbind();
                    // $("div.dataTables_filter input").keyup( function (e) {
                    //     if (e.keyCode == 13) {
                    //         tblBandejaPendientes.search( this.value ).draw();
                    //     }
                    // });                    
                    $('div.dataTables_filter input').unbind().keyup(delay(function (e) {
                        $(this).val($(this).val().trim());
                        tblBandejaPendientes.search( this.value ).draw();
                    }, 700)
                    );
                },
                dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', orientation:'landscape' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' },
                    // 'selectAll',
                    // 'selectNone'
                ],
                "language": {
                    "url": "../dist/scripts/datatables-es_ES.json"
                },
                'columnDefs': [
                    {
                        'targets': 0,
                        'orderable': false,
                        'checkboxes': {
                            'selectRow': true
                        }
                    },
                    {
                        'targets': [1,8],
                        'orderable': false
                    },
                    {
                        "width": "20%",
                        "targets": [4],
                        'orderable': false
                    },
                    {
                        "width": "120px",
                        "targets": [1],
                        'orderable': false
                    },
                    { 
                        "width": "12%",
                        "targets": [3,5],
                        'orderable': false
                    },
                    { 
                        "width": "60px",
                        "targets": [2]
                    },
                    { 
                        "width": "65px",
                        "targets": [7]
                    },
                    {
                        "width": "10%",
                        "targets": [6,10]
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {
                            let iconos = '';

                            if (full.prioridad.trim() === 'Alta') {
                                iconos += '<i class="fas fa-fw fa-flag" style="color: red; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            } else if (full.prioridad.trim() === 'Media') {
                                iconos += '<i class="far fa-fw fa-flag" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            } else {
                                iconos += '<i class="far fa-fw fa-flag" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }

                            if (full.adjuntos !== 0) {
                                iconos += '<i class="fas fa-fw fa-paperclip"style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }else{
                                iconos += '<i class="fas fa-fw fa-paperclip" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }

                            if (full.copia !== 0) {
                                iconos += '<i class="fas fa-fw fa-closed-captioning" style="font-size: 16px; padding: 6px 0 0 0"></i>';
                            }else{
                                iconos += '<i class="fas fa-fw fa-closed-captioning" style="opacity: 0.1; font-size: 16px; padding: 6px 0 0 0"></i>';

                            }

                            return iconos
                        },
                    }
                    ,{'data': 'cud', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {
                            var origen = ``;
                            if(full.origen.trim() != '' && full.origen.trim() != 'Interno'){
                                origen = `<small><b>Externo:</b> ${full.origen}</small><br>`;
                            }
                            return `${origen}${full.documento}`;
                        },
                        'autoWidth': true
                    }
                    ,{'data': 'asunto', 'autoWidth': true}
                    ,{'data': 'entidadExterna', 'autoWidth': true}
                    ,{'data': 'oficinaOrigen', 'autoWidth': true}
                    ,{'data': 'fechaEnvio', 'autoWidth': true}
                    ,{'data': 'fechaPlazo', 'autoWidth': true}
                    ,{'data': 'nomIndicacion', 'autoWidth': true}
                    ,{'data': 'instruccion', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });        

            function delay(callback, ms) {
                var timer = 0;
                return function() {
                    var context = this, args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                    callback.apply(context, args);
                    }, ms || 0);
                };
            }

            var btnEnviarDer = $("#btnEnviarDer");
            var btnEnviarArchivar = $("#btnEnviarArchivar");

            var btnPrimary = $("#btnPrimary");
            var btnRechazar = $("#btnRechazar");
            var btnSecondary = $("#btnSecondary");
            var btnFourth = $("#btnFourth");
            var btnDetail = $("#btnDetail");
            var btnFlow = $("#btnFlow");
            var btnDoc = $("#btnDoc");
            var btnAnexos = $("#btnAnexos");
            var btnDescargarDoc = $("#btnDescargarDoc")

            /*var actionButtons = [btnPrimary, btnRechazar, btnSecondary];
            var supportButtons = [btnFourth, btnDetail, btnFlow, btnDoc, btnAnexos, btnDescargarDoc];*/
            var actionButtons = [btnPrimary,btnFourth, btnRechazar, btnSecondary];
            var supportButtons = [btnDetail, btnFlow, btnDoc, btnAnexos, btnDescargarDoc];

            var totalCount = 0;
            var seleccionados = [];

            totalCount = 0;

            tblBandejaPendientes
                .on( 'select', function ( e, dt, type, indexes ) {

                    if( tblBandejaPendientes.rows( dt[0] ).data()[1] == undefined ){
                        
                        let seleccionado = tblBandejaPendientes.rows( dt[0] ).data()[0];
                        
                        var lists = seleccionados.filter(x => {
                            return x.rowId == seleccionado.rowId;
                        });
    
                        if ( lists.length == 0 ) {
                            seleccionados.push(seleccionado);
                        }

                    } else {
                            let sets = tblBandejaPendientes.rows( { selected: true } ).data();

                            $.each( sets, function( key, value ) {
                                var lists = seleccionados.filter(x => {
                                    return x.rowId == value.rowId;
                                });
            
                                if ( lists.length == 0 ) {
                                    seleccionados.push(value);
                                }
                            });

                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });

                            $('.actionButtons').show(100);
                    }
                    
                    switch (seleccionados.length) {
                        case 0:
                            seleccionados = [];

                            $.each( actionButtons, function( key, value ) {
                                value.css("display","none");
                            });

                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });

                            $('.actionButtons').hide(100);
                            break;
                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            $('.actionButtons').show();

                            // let fila = tblBandejaPendientes.rows( { selected: true } ).data().toArray()[0];
                            let fila = seleccionados[0];

                            if (fila.copia === 1) {
                                btnPrimary.css("display","none");
                            }

                            if (fila.adjuntos === 0) {
                                btnAnexos.css("display","none");
                            }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                    totalCount = seleccionados.length;
                    if (totalCount > 1) {
                        $("#btnPrimary span").text("Revisar " + totalCount);
                    } else {
                        $("#btnPrimary span").text("Revisar");
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    // let count = tblBandejaPendientes.rows( { selected: true } ).count();

                    var seleccionado = tblBandejaPendientes.rows( dt[0] ).data()[0];
                    
                    seleccionados = seleccionados.filter(x => {
                        return x.rowId != seleccionado.rowId;
                    });
                    
                    switch (seleccionados.length) {
                        case 0:
                            seleccionados = [];

                            $.each( actionButtons, function( key, value ) {
                                value.css("display","none");
                            });

                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });

                            $('.actionButtons').hide(100);

                            break;

                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            let fila = seleccionados[0];

                            if (fila.copia === 1) {
                                btnPrimary.css("display","none");
                            }

                            if (fila.adjuntos === 0) {
                                btnAnexos.css("display","none");
                            }
                            
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                    
                    totalCount = seleccionados.length ;
                    $("#btnPrimary span").text("Revisar " + totalCount);

                });

            $("#tblBandejaPendientes thead").on("click", "th.dt-checkboxes-select-all input[type=checkbox]", function(e) {
                e.preventDefault();

                if( seleccionados.length > 0 && !$(this).prop("checked") ) {
                    seleccionados = [];
                }

                //TODO: Hacer mañana

            });

            function limpiarSeleccionados() {
                seleccionados = [];
                tblBandejaPendientes.rows().deselect();
            }

            // Response button
            btnPrimary.on('click', function(e) {
                // console.log(seleccionados);
                // return;
                e.preventDefault();
                // let  rows_selected= tblBandejaPendientes.column(0).checkboxes.selected();                
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {             
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);             
                    // values.push(tblBandejaPendientes.rows(rowId).data()[0]);                    
                // });        

                let data = [];                
               
                $.each(values, function (index, filas) {                             
                    let fila = [];
                    fila.push(filas.mov);
                    fila.push(filas.documento);
                    fila.push(filas.cud);
                    data.push(fila);
                });

                if (data.length > 1) {
                    $('#modalRespuesta form#formSeleccionar').empty();
                    $.each(data, function (index, dato) {
                        let cod = '<p>' +
                            '      <label>' +
                            '        <input name="movimiento" type="radio" value="'+dato[0]+'" data-cud="'+dato[2]+'">' +
                            '        <span>'+dato[1]+' | CUD: '+dato[2]+'</span>' +
                            '      </label>' +
                            '    </p>';
                        $('#modalRespuesta div.modal-content form#formSeleccionar').append(cod);
                    });
                    let elem = document.querySelector('#modalRespuesta');
                    let instance = M.Modal.init(elem, {dismissible:false});
                    instance.open();
                } else {
                    obtenerDatosRespuesta(data[0][0],data[0][2],data);
                }
            });

            $('#btnResptContinuar').on('click', function (e) {
                e.preventDefault();
                // let rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                // let values = [];
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data());
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });
                let data = [];

                // console.log(values);

                // return;

                $.each(values, function (index, rowId) {
                    let fila = [];
                    fila.push(rowId.mov);
                    fila.push(rowId.documento);
                    fila.push(rowId.cud);
                    data.push(fila);

                    // console.log(index);
                    // console.log(rowId.mov);
                    // console.log(fila);
                });


                // return;

                let movimientoPrincipal = $('#modalRespuesta div.modal-content form#formSeleccionar input[name="movimiento"]:checked').val();
                let cudPrincipal = $('#modalRespuesta div.modal-content form#formSeleccionar input[name="movimiento"]:checked').attr("data-cud");
                obtenerDatosRespuesta(movimientoPrincipal,cudPrincipal,data);
            });

            function obtenerDatosRespuesta(movimiento,cud,datos) {
                //verifica si hay documentos pendientes (proyectos o tramites no enviados)
                $.ajax({
                    url: "registerDoc/Documentos.php",
                    method: "POST",
                    data: {
                        Evento: 'ConsultaRespuestaDocumento',
                        movimiento: movimiento
                    },
                    datatype: "json",
                    success: function (response) {
                        let respuesta = $.parseJSON(response);

                        $.confirm({
                            title: 'Usted ' +respuesta.flgPendientes+ ' tiene documentos pendientes por atender.',
                            content: '¿Esta seguro de atenderlo?',
                            buttons: {
                                Si: function () {
                                    //actualiza movimiento a en proceso
                                    $.ajax({
                                        url: "registerDoc/Documentos.php",
                                        method: "POST",
                                        data: {
                                            Evento: 'RespuestaDocumento',
                                            movimiento: movimiento
                                        },
                                        datatype: "json",
                                        success: function () {
                                            let data = new Object();
                                            data.movimientoP = movimiento;
                                            data.cudP = cud;
                                            data.agrupado = respuesta.cAgrupado;
                                            data.flgPendientes = respuesta.flgPendientes.trim() == 'no'? 0 : 1;
                                            data.documentos = datos;

                                            $("#dtr").val(window.btoa(JSON.stringify(data)));
                                            document.getElementById("frmRespuesta").submit();
                                        },
                                        error: function (e) {
                                            console.log(e);
                                            console.log('Error al responder el documento!');
                                            deleteSpinner();
                                            M.toast({html: "Error al responder el documento"});
                                        }
                                    });
                                },
                                No: function () {}
                            }
                        });
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al intentar responder el documento!');
                        deleteSpinner();
                        M.toast({html: "Error al intentar responder el documento"});
                    }
                });
            }

            $("#btnRechazar").on('click', function(e) {
                let elem = document.querySelector('#modalRechazar');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.open();
            });

            $("#btnEnviarRechazo").on('click', function (e) {
                
                e.preventDefault();
                // let rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                var motRechazo = $("#motRechazo").val();
                $.ajax({
                    cache: false,
                    url: "entradaData.php",
                    method: "POST",
                    data: {opcion: 2, iCodMovimiento : movimientos, motRechazo : motRechazo },
                    datatype: "json",
                    success : function(response) {
                        if (response == 1) {
                            tblBandejaPendientes.ajax.reload();
                            limpiarSeleccionados();
                            if (values.length > 1) {
                                M.toast({html: '¡Documentos Rechazados!'});
                            } else {
                                M.toast({html: '¡Documento Rechazado!'});
                            }
                        } else {
                            console.log(response);
                            M.toast({html: '¡Error al rechazar!'});
                        }
                    }
                });
            });

            btnSecondary.on('click', function(e) {
                $("#motArchivar").val('');
                tblAnexos.rows().remove().draw(false);
                let elem = document.querySelector('#modalArchivar');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.open();
            });

            // send File button
            btnEnviarArchivar.on('click', function(e) {
                // debugger;
                e.preventDefault();
                // let rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });

                let movimientos = [];

                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                var anexosAdjuntos = '';
                $.each(tblAnexos.data(), function (index, fila) {
                    anexosAdjuntos += fila.codigoAnexo +'|';
                });

                parametros = {
                    opcion : 3,
                    iCodMovimiento : movimientos,
                    cObservacionesFinalizar : $('#motArchivar').val(),
                    anexos : (anexosAdjuntos != '' ? anexosAdjuntos.slice(0, -1) : '')
                };
                $.ajax({
                    cache: false,
                    url: "pendientesData.php",
                    method: "POST",
                    data: parametros,
                    datatype: "json",
                    success : function (response) {
                        if (response == 1) {
                            tblBandejaPendientes.ajax.reload();
                            limpiarSeleccionados();

                            if (values.length > 1) {
                                M.toast({html: '¡Documentos Archivados!'});
                            } else {
                                M.toast({html: '¡Documento Archivado!'});
                            }
                        } else {
                            console.log(response);
                            M.toast({html: '¡Error al Archivar!'});
                        }
                    }
                });
                M.Modal.getInstance($("#modalArchivar")).close();
            });

            btnFourth.on('click',function (e) {
                // var rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                var values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });

                let movimientos = [];

                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });

                $.ajax({
                    url: "ajax/ajaxValidarMovimiento.php",
                    method: "POST",
                    data: {
                        //IdMovimiento: movimientos[0]
                        IdMovimiento: JSON.stringify(movimientos)
                    },
                    datatype: "json",
                    success: function (response) {
                        let data = JSON.parse(response);
                        if (data.HABILITAR === 0) {
                            e.preventDefault();
                            tblDestinosDerivar.clear().draw();
                            if (values[0].copia == 1){
                                $("#cCopiaDer").val(1);
                                $("#cCopiaDer").prop("disabled", true);
                                $("#cCopiaDer").formSelect();
                            } else {
                                $("#cCopiaDer").val(0);
                                $("#cCopiaDer").prop("disabled", false);
                                $("#cCopiaDer").formSelect();
                            }
                            $("#cCopiaDer").formSelect();
                            let elem = document.querySelector('#modalDerivar');
                            let instance = M.Modal.init(elem, {dismissible: false});
                            instance.open();
                        } else {
                            tblBandejaPendientes.ajax.reload();
                            $.alert("¡Documento ya enviado!");
                        }
                    }
                });
            });

            // Send derivated office
            btnEnviarDer.on('click', function (e) {
                e.preventDefault();
                if (tblDestinosDerivar.data().length === 0){
                    $.alert('No tiene ningún destinatario agregado!');
                }else{
                    // var rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                    var values=seleccionados;
                    // $.each(rows_selected, function (index, rowId) {
                    //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                    //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                    //                 return parseInt(data.rowId) === parseInt(rowId) ?
                    //                     true : false;
                    //             }).data()[0]);
                    // });
                    let movimientos = [];
                    $.each(values, function (index, fila) {
                        movimientos.push(fila.mov);
                    });
                    let tablaDer = tblDestinosDerivar.data();
                    let dataTablaDer = [];
                    $.each(tablaDer, function (i, item) {
                        var dato = item;
                        if (dato.fecPlazo != ""){
                            dato.fecPlazo = dato.fecPlazo.split("-").reverse().join("-");
                        }
                        dataTablaDer.push(dato);
                    });
                    var parametrosDer = {
                        opcion : 1,
                        iCodMovimiento : movimientos,
                        datos: dataTablaDer
                    };
                    $.ajax({
                        cache: false,
                        url: "pendientesData.php",
                        method: "POST",
                        data: parametrosDer,
                        datatype: "json",
                        success: function (response) {
                            tblBandejaPendientes.ajax.reload();
                            M.toast({html: '¡Documento Derivado!'});
                            limpiarSeleccionados();
                            M.Modal.getInstance($("#modalDerivar")).close();
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar!"});
                        }
                    });
                }
            });

            btnDescargarDoc.on('click', function(){
                var promesa = new Promise((resolve, reject) => {
                    initProgress();
                    resolve(true);
                });

                promesa.then((respuesta) => {
                    return new Promise((resolve,reject) =>{
                        var data = new Object();

                        data.nombreZip = 'archivo'+Date.now();
                        data.fila = tblBandejaPendientes.rows( { selected: true } ).data().toArray()[0];
                        data.codigo = data.fila.codigo;
                        updateProgress(`Generando Zip`,`0%`);

                        return resolve(data);
                    });
                }).then((respuesta) => {
                    console.log(respuesta);
                    $.ajax({
                        async: false,
                        url: 'ajax/ajaxConsultaGeneralZip.php',
                        type: 'POST',
                        datatype: 'json',
                        data: {
                            "evento" : "AgregarAZip",
                            "codigo" : respuesta.codigo,
                            "nombre" : respuesta.fila.documento.trim() + respuesta.fila.cud.trim(),
                            "nombreZip" : respuesta.nombreZip
                        }
                    }).done(function(response){
                        var result = JSON.parse(response);
                        if (result.success){
                            updateProgress(`Generando Zip 100%`,`100%`);
                            location.href = `../archivosTemp/${respuesta.nombreZip}.zip`;
                            $.ajax({
                                async: false,
                                url: 'ajax/ajaxConsultaGeneralZip.php',
                                type: 'POST',
                                data: {"evento" : "EliminarZip","nombreZip" : respuesta.nombreZip}                                       
                            })
                            .done(() => finishProgress());
                        } else {
                            finishProgress();
                            M.toast({html: result.message});
                        }                                
                    });
                });         
            });

            function initProgress(){                
                $("#progressBar p").text('');
                $("#progressBar div.progress div.progressbar").css("width","0%");
                
                if ($("#progressBar").css("display") == "none"){
                    $("#progressBar").css("display", "block");
                }
            };

            function updateProgress(text, porcentaje){
                $("#progressBar p").text(text);
                $("#progressBar div.progress div.progressbar").css("width",porcentaje);
            }

            function finishProgress(){                
                $("#progressBar p").text('');
                $("#progressBar div.progress div.progressbar").css("width","0%");
                
                if ($("#progressBar").css("display") == "block"){
                    $("#progressBar").css("display", "none");
                }
            };

            var cmbRespon = document.getElementById('OficinaResponsableDer');
            M.FormSelect.init(cmbRespon, {dropdownOptions: {container: document.body}});

            var cmbIndicacionDer = document.getElementById('IndicacionDer');
            M.FormSelect.init(cmbIndicacionDer, {dropdownOptions: {container: document.body}});

            $('#OficinaResponsableDer').on('change', function () {
                $('#responsableDer').empty();
                $('#responsableDer').formSelect();

                codigo = this.value;
                if (codigo == sesionOficina){
                    $.ajax({
                        cache: false,
                        url: "ajax/ajaxTrabajador.php",
                        method: "POST",
                        data: {'Evento' : 'ListarTrabajadoresPorOficina', 'idOficina': codigo},
                        datatype: "json",
                        success: function (data) {
                            data = JSON.parse(data);
                            $('#responsableDer').append('<option value="">Seleccione</option>');
                            $.each(data, function(key, value) {
                                $('#responsableDer').append('<option value="'+value.idTrabajador+'">'+value.nomTrabajador+' ( '+ value.nomPerfil +' )</option>');
                            });
                            $('#responsableDer').formSelect();
                        }
                    });
                } else {
                    $.ajax({
                        cache: false,
                        method: 'POST',
                        url: 'loadResponsableRIO.php',
                        data: {iCodOficinaResponsable : codigo},
                        dataType: 'json',
                        success: function(list){
                            $.each(list,function(index,value)
                            {
                                $('#responsableDer').append($('<option>',{
                                    value : value.iCodTrabajador,
                                    text  : value.cNombresTrabajador.trim()+", "+value.cApellidosTrabajador.trim()
                                }));
                            });
                            $('#responsableDer').formSelect();
                        },
                    });
                }
            });

            // Detail button
            btnDetail.on('click', function(e) {
                var elems = document.querySelector('#modalDetalle');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                // let rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                $.ajax({
                    cache: false,
                    url: "registroDetalles.php",
                    method: "POST",
                    data: {iCodMovimiento : movimientos},
                    datatype: "json",
                    success : function(response) {
                        $('#modalDetalle div.modal-content').html(response);
                        instance.open();
                    }
                });
            });

            // flow button
            btnFlow.on('click', function(e) {
                var elems = document.querySelector('#modalFlujo');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                // let rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                if(values[0] <= 18997){
                    var documentophp = "flujodoc_old.php"
                } else{
                    var documentophp = "flujodoc.php"
                }
                $.ajax({
                    cache: false,
                    url: documentophp,
                    method: "POST",
                    data: {iCodMovimiento : movimientos},
                    datatype: "json",
                    success : function(response) {
                        $('#modalFlujo div.modal-content').html(response);
                        instance.open();
                    }
                });
            });

            // Doc. button
            btnDoc.on('click', function(e) {
                var elems = document.querySelector('#modalDoc');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                // let rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                if(values[0].flgEncriptado == 1 && !(values[0].iCodOficinaFirmante == sesionOficina && (values[0].iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
                        $.confirm({
                            columnClass: 'col-md-4 col-md-offset-4',
                            title: 'Validación permiso',
                            content: 'Contraseña: <input type="password">',
                            buttons: {
                                Validar: function(){
                                    var val = this.$content.find('input').val();
                                    if(val.trim() != ''){
                                        $.ajax({
                                            url: "registerDoc/Documentos.php",
                                            method: "POST",
                                            data: {'codigo': values[0].codigo, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    $.ajax({
                                                        cache: false,
                                                        url: "verDoc.php",
                                                        method: "POST",
                                                        data: {iCodMovimiento: movimientos, tabla: 't'},
                                                        datatype: "json",
                                                        success: function (response) {
                                                            var json = eval('(' + response + ')');
                                                            if (json['estado'] == 1) {
                                                                $('#modalDoc div.modal-content').html('');
                                                                $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                                                                instance.open();
                                                            }else {
                                                                M.toast({html: '¡No contiene documento asociado!'});
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    $.alert('Contraseña incorrecta');
                                                }
                                            },
                                            error: function (e) {
                                                console.log(e);
                                                console.log('Error validar clave!');
                                                $.alert('Error');
                                            }
                                        });                                        
                                    }else{
                                        return false;
                                    }
                                },
                                Cancelar: function(){
                                    $.alert('Cancelado');
                                }
                            }                            
                        });
                } else {
                    $.ajax({
                            cache: false,
                            url: "verDoc.php",
                            method: "POST",
                            data: {iCodMovimiento: movimientos, tabla: 't'},
                            datatype: "json",
                            success: function (response) {
                                var json = eval('(' + response + ')');
                                if (json['estado'] == 1) {
                                    $('#modalDoc div.modal-content').html('');
                                    $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                                    instance.open();
                                }else {
                                    M.toast({html: '¡No contiene documento asociado!'});
                                }
                            }
                    });
                }                             
            });

            btnAnexos.on('click', function(e) {
                e.preventDefault();
                // let rows_selected = tblBandejaPendientes.column(0).checkboxes.selected();
                let values = seleccionados;
                // $.each(rows_selected, function (index, rowId) {
                //     //values.push(tblBandejaPendientes.rows(rowId).data()[0]);
                //     values.push(tblBandejaPendientes.rows( function ( idx, data, node ) {                       
                //                     return parseInt(data.rowId) === parseInt(rowId) ?
                //                         true : false;
                //                 }).data()[0]);
                // });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                if(values[0].flgEncriptado == 1 && !(values[0].iCodOficinaFirmante == sesionOficina && (values[0].iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
                        $.confirm({
                            columnClass: 'col-md-4 col-md-offset-4',
                            title: 'Validación permiso',
                            content: 'Contraseña: <input type="password">',
                            buttons: {
                                Validar: function(){
                                    var val = this.$content.find('input').val();
                                    if(val.trim() != ''){
                                        $.ajax({
                                            url: "registerDoc/Documentos.php",
                                            method: "POST",
                                            data: {'codigo': values[0].codigo, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    $.ajax({
                                                        cache: false,
                                                        url: "verAnexo.php",
                                                        method: "POST",
                                                        data: {iCodMovimiento: movimientos[0]},
                                                        datatype: "json",
                                                        success: function (response) {

                                                            $('#modalAnexo div.modal-content ul').html('');
                                                            var json = eval('(' + response + ')');

                                                            if(json.tieneAnexos == '1') {
                                                                let cont = 1;
                                                                json.anexos.forEach(function (elemento) {
                                                                    $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                                                                    cont++;
                                                                })
                                                                let elem = document.querySelector('#modalAnexo');
                                                                let instance = M.Modal.init(elem, {dismissible:false});
                                                                instance.open();
                                                            }else{
                                                                $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    $.alert('Contraseña incorrecta');
                                                }
                                            },
                                            error: function (e) {
                                                console.log(e);
                                                console.log('Error validar clave!');
                                                $.alert('Error');
                                            }
                                        });                                        
                                    }else{
                                        return false;
                                    }
                                },
                                Cancelar: function(){
                                    $.alert('Cancelado');
                                }
                            }                            
                        });
                } else {
                    $.ajax({
                        cache: false,
                        url: "verAnexo.php",
                        method: "POST",
                        data: {iCodMovimiento: movimientos[0]},
                        datatype: "json",
                        success: function (response) {

                            $('#modalAnexo div.modal-content ul').html('');
                            var json = eval('(' + response + ')');

                            if(json.tieneAnexos == '1') {
                                let cont = 1;
                                json.anexos.forEach(function (elemento) {
                                    $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                                    cont++;
                                })
                                let elem = document.querySelector('#modalAnexo');
                                let instance = M.Modal.init(elem, {dismissible:false});
                                instance.open();
                            }else{
                                $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                            }
                        }
                    });
                }              
            });

            

        });

        var tblAnexos = $('#TblAnexos').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblAnexos").hide();
                    $('#anexosDoc').css('display', 'none');
                }else{
                    $("#TblAnexos").show();
                    $('#anexosDoc').css('display', 'block');
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                {
                    'render': function (data, type, full, meta) {
                        let nombreAnexo = '';
                        nombreAnexo = '<a href="'+full.rutaAnexo+'" target="_blank">'+full.nombreAnexo+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "85%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped danger" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "5%"
                },
            ]
        });

        $("#TblAnexos tbody")
            .on('click', 'button', function () {
                let accion = $(this).attr("data-accion");
                if(accion === 'eliminar'){
                    tblAnexos.row($(this).parents('tr')).remove().draw(false);
                }
            })

        function InsertarAnexo(codigo, nombre, ruta, imprimible = true) {
            let anexo = new Object();
            anexo.codigoAnexo = codigo;
            anexo.nombreAnexo = nombre;
            anexo.rutaAnexo = ruta;

            let estado = false;
            let data = tblAnexos.data();
            $.each(data, function (i, item) {
                if (ruta == item.rutaAnexo) {
                    estado = true;
                }
            });

            if (!estado) {
                tblAnexos.row.add(anexo).draw();
                if (imprimible === false){
                    $("input[value='"+codigo+"'][data-accion='imprimir']").prop("checked", false);
                }
            } else {
                console.log("El anexo ya está agregado");
            }
        }

        Dropzone.autoDiscover = false;
        $("#dropzoneAgrupado").dropzone({
                url: "ajax/cargarDocsAgrupado.php",
                paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
                autoProcessQueue: false,
                maxFiles: 10,
                acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
                addRemoveLinks: true,
                maxFilesize: 1200, // MB
                uploadMultiple: true,
                parallelUploads: 10,
                dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
                dictInvalidFileType: "Archivo no válido",
                dictMaxFilesExceeded: "Solo 10 archivos son permitidos",
                dictCancelUpload: "Cancelar",
                dictRemoveFile: "Remover",
                dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
                dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
                dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",
                accept: function (file, done) {
                    let estado = false;
                    let data = tblAnexos.data();
                    $.each(data, function (i, item) {
                        if (file.name == item.nombreAnexo) {
                            estado = true;
                        }
                    });
                    if (!estado) {
                        done();
                    } else {
                        done("El documento ya está agregado");
                        $.alert("El documento" + file.name +" ya está agregado");
                        this.removeFile(file);
                    }
                },
                init: function () {
                    var myDropzone = this;
                    $("#btnSubirDocsAgrupado").on("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        queuedFiles = myDropzone.getQueuedFiles();
                        if (queuedFiles.length > 0) {
                            event.preventDefault();
                            event.stopPropagation();
                            myDropzone.processQueue();
                        }else{
                            $.alert('¡No hay documentos para subir al sistema!');
                        }
                    });

                    this.on("sendingmultiple", function (file, xhr, formData) {
                        let agrupado = 0;
                        formData.append('agrupado',agrupado);
                    });
                    this.on("successmultiple", function(file, response) {
                        let json = $.parseJSON(response);
                        M.toast({html: json.mensaje});
                        $.each(json.data, function (i,fila) {
                            InsertarAnexo(fila.codigo, fila.original, fila.nuevo);
                        });                   
                        this.removeAllFiles();
                    });
                }
            });

        
            $('#cOficinas').select2({
            width: '100%',
            placeholder: 'Seleccione o busque',
            maximumSelectionLength: 10,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró la oficina.</p><p><a href='#' class='btn btn-link'>¿Desea registrarlo?</a></p>";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'ajax/ajaxOficinas.php',
                dataType: 'json',
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        var tblDestinosDerivar = $('#TblDestinosDerivar').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblDestinosDerivar").hide();
                }else{
                    $("#TblDestinosDerivar").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'nomOficinaDer', 'autoWidth': true,"width": "25%", 'className': 'text-left' },
                { 'data': 'nomResponsableDer', 'autoWidth': true, "width": "25%",'className': 'text-left' },
                { 'data': 'nIndicacionDer', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'nomPrioridadDer', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'nObservacionDer', 'autoWidth': true, "width": "20%",'className': 'text-left' },
                { 'data': 'nCopiaDer', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'fecPlazo', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-outline-secondary" data-placement="top"><i class="fas fa-trash-alt"></i></button> ';
                    }, 'className': 'text-center',"width": "20px"
                },
            ]
        });

        $("#TblDestinosDerivar tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            if(accion === 'eliminar'){
                tblDestinosDerivar.row($(this).parents('tr')).remove().draw(false);
            }
        });

        $("#btnAgregarDestinoDerivar").click(function(){
            var validacion = true;

            if ($("#OficinaResponsableDer option:selected").val() == "" || $("#OficinaResponsableDer option:selected").val() == undefined){
                $.alert("Seleccione una oficina");
                validacion = false;
                return false;
            }

            if ($("#responsableDer option:selected").val() == "" || $("#responsableDer option:selected").val() == undefined){
                $.alert("Seleccione un trabajador");
                validacion = false;
                return false;
            }
            
            if(validacion){
                let destinoDerivar = new Object();
                destinoDerivar.cOficinaDer= $("#OficinaResponsableDer option:selected").val();
                destinoDerivar.nomOficinaDer= $("#OficinaResponsableDer option:selected").text();
                destinoDerivar.cResponsableDer = $("#responsableDer option:selected").val();
                destinoDerivar.nomResponsableDer = $("#responsableDer option:selected").text();
                destinoDerivar.cIndicacionDer = $("#IndicacionDer option:selected").val();
                destinoDerivar.nIndicacionDer = $("#IndicacionDer option:selected").text();
                destinoDerivar.cPrioridadDer = $("#prioridadDer option:selected").val();
                destinoDerivar.nomPrioridadDer = $("#prioridadDer option:selected").text();
                destinoDerivar.nObservacionDer = $("#obsDerivar").val();
                destinoDerivar.cCopiaDer = $("#cCopiaDer option:selected").val();
                destinoDerivar.nCopiaDer = $("#cCopiaDer option:selected").text();
                if ($("#habilitarPlazo").prop("checked")){
                    destinoDerivar.fecPlazo = $("#fecPlazo").val();
                } else {
                    destinoDerivar.fecPlazo = ""
                }                

                //VALIDAR SI YA ESTA INGRESADO
                let data = tblDestinosDerivar.data();
                let estado = false;
                $.each(data, function (i, item) {
                    if (destinoDerivar.cOficinaDer == item.cOficinaDer && destinoDerivar.cResponsableDer == item.cResponsableDer) {
                        estado = true;
                    }
                });
                if (!estado) {
                    tblDestinosDerivar.row.add(destinoDerivar).draw();
                } else {
                    $.alert("El destino ingresado ya está agregado");
                }
            }
        });

        $("#habilitarPlazo").on("click", function(e){
            $("#fecPlazo").val("");
            if ($("#habilitarPlazo").prop("checked")){
                $("#fecPlazoDiv").show();
            } else {
                $("#fecPlazoDiv").hide();                
            }
        });
        
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>