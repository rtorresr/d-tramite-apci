<?php
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");
include_once("../conexion/parametros.php");

$pageTitle = "Registro de Documento";
$activeItem = "registroOficina.php";
$navExtended = true;

$nNumAno    = date("Y");
if($_SESSION['CODIGO_TRABAJADOR']!=""){
    $url = RUTA_SIGTI_SERVICIOS."/ApiPide/token";
    // $data = array(
    //     "UserName" =>  "8/user-dtramite",
    //     "Password" =>   "123456",
    //     "grant_type" => "password"
    // );

    $client = curl_init();
    curl_setopt($client, CURLOPT_URL, $url);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = json_decode(curl_exec($client));
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <link href="includes/component-dropzone.css" rel="stylesheet">
        <style>
            .references nav {
                background-color: #D8E8FF;
                color: #000000;
            }
        </style>
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <a name="area"></a>

    <!--Main layout-->
    <main>
        <form name="frmRegistro" id="frmRegistro" target="_blank" enctype="multipart/form-data">
            <input id="token" type="hidden" value="<?php echo $response->token_type . ' ' . $response->access_token; ?>">
            <input type="hidden" id="dtrUri" value="<?=$_GET['dtr']??''?>">        

            <div class="navbar-fixed actionButtons">
                <nav>
                    <div class="nav-wrapper">
                        <ul id="nav-mobile" class="">
                            <?php
                            if (!($_SESSION['iCodPerfilLogin'] == '19') OR ($_SESSION['flgDelegacion'] == '1')){
                                ?>
                                <li>
                                    <a id="btnValidacionAgregar" class="btn btn-flat btn-primary tooltipped" data-position="top" data-tooltip="Agregar">
                                        <!-- <i class="fas fa-plus fa-fw left"></i> -->
                                        <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                            <path d="M 6 0 L 6 48 L 34 48 C 35.671875 49.257813 37.753906 50 40 50 C 45.511719 50 50 45.511719 50 40 C 50 35.914063 47.519531 32.394531 44 30.84375 L 44 14.59375 L 43.71875 14.28125 L 29.71875 0.28125 L 29.40625 0 Z M 8 2 L 28 2 L 28 16 L 42 16 L 42 30.21875 C 41.351563 30.085938 40.6875 30 40 30 C 34.488281 30 30 34.488281 30 40 C 30 42.253906 30.765625 44.324219 32.03125 46 L 8 46 Z M 30 3.4375 L 40.5625 14 L 30 14 Z M 40 32 C 44.429688 32 48 35.570313 48 40 C 48 44.429688 44.429688 48 40 48 C 35.570313 48 32 44.429688 32 40 C 32 35.570313 35.570313 32 40 32 Z M 39 35 L 39 39 L 35 39 L 35 41 L 39 41 L 39 45 L 41 45 L 41 41 L 45 41 L 45 39 L 41 39 L 41 35 Z"/>
                                        </svg>
                                        <span>Agregar</span>
                                    </a>
                                </li>

                                <?php
                            }
                            ?>
                            <li>
                                <a id="btnDerivar" class="btn btn-link tooltipped" data-position="top" data-tooltip="Derivar">
                                    <!-- <i class="fas fa-arrow-right fa-fw left"></i>
                                    <span>Derivar</span> -->
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 25 2 C 12.308594 2 2 12.308594 2 25 C 2 37.691406 12.308594 48 25 48 C 37.691406 48 48 37.691406 48 25 C 48 12.308594 37.691406 2 25 2 Z M 25 4 C 36.609375 4 46 13.390625 46 25 C 46 36.609375 36.609375 46 25 46 C 13.390625 46 4 36.609375 4 25 C 4 13.390625 13.390625 4 25 4 Z M 28.90625 15.96875 C 28.863281 15.976563 28.820313 15.988281 28.78125 16 C 28.40625 16.066406 28.105469 16.339844 28 16.703125 C 27.894531 17.070313 28.003906 17.460938 28.28125 17.71875 L 34.5625 24 L 13 24 C 12.96875 24 12.9375 24 12.90625 24 C 12.355469 24.027344 11.925781 24.496094 11.953125 25.046875 C 11.980469 25.597656 12.449219 26.027344 13 26 L 34.5625 26 L 28.28125 32.28125 C 27.882813 32.679688 27.882813 33.320313 28.28125 33.71875 C 28.679688 34.117188 29.320313 34.117188 29.71875 33.71875 L 37.5625 25.84375 C 37.617188 25.808594 37.671875 25.765625 37.71875 25.71875 C 37.742188 25.6875 37.761719 25.65625 37.78125 25.625 C 37.804688 25.605469 37.824219 25.585938 37.84375 25.5625 C 37.882813 25.503906 37.914063 25.441406 37.9375 25.375 C 37.949219 25.355469 37.960938 25.332031 37.96875 25.3125 C 37.96875 25.300781 37.96875 25.292969 37.96875 25.28125 C 37.980469 25.25 37.992188 25.21875 38 25.1875 C 38.015625 25.082031 38.015625 24.980469 38 24.875 C 38 24.855469 38 24.832031 38 24.8125 C 38 24.800781 38 24.792969 38 24.78125 C 37.992188 24.761719 37.980469 24.738281 37.96875 24.71875 C 37.96875 24.707031 37.96875 24.699219 37.96875 24.6875 C 37.960938 24.667969 37.949219 24.644531 37.9375 24.625 C 37.9375 24.613281 37.9375 24.605469 37.9375 24.59375 C 37.929688 24.574219 37.917969 24.550781 37.90625 24.53125 C 37.894531 24.519531 37.886719 24.511719 37.875 24.5 C 37.867188 24.480469 37.855469 24.457031 37.84375 24.4375 C 37.808594 24.382813 37.765625 24.328125 37.71875 24.28125 L 37.6875 24.28125 C 37.667969 24.257813 37.648438 24.238281 37.625 24.21875 L 29.71875 16.28125 C 29.511719 16.058594 29.210938 15.945313 28.90625 15.96875 Z"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a id="btnGuardarCambios" style="display: none" class="btn btn-link tooltipped" data-position="top" data-tooltip="Guardar">
                                    <!-- <i class="fas fa-save fa-fw left"></i>
                                    <span>Guardar</span> -->
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                        <path d="M 7 4 C 5.3545455 4 4 5.3545455 4 7 L 4 43 C 4 44.645455 5.3545455 46 7 46 L 43 46 C 44.645455 46 46 44.645455 46 43 L 46 13.199219 A 1.0001 1.0001 0 0 0 45.707031 12.492188 L 37.507812 4.2929688 A 1.0001 1.0001 0 0 0 36.800781 4 L 7 4 z M 7 6 L 12 6 L 12 18 C 12 19.645455 13.354545 21 15 21 L 34 21 C 35.645455 21 37 19.645455 37 18 L 37 6.6132812 L 44 13.613281 L 44 43 C 44 43.554545 43.554545 44 43 44 L 38 44 L 38 29 C 38 27.354545 36.645455 26 35 26 L 15 26 C 13.354545 26 12 27.354545 12 29 L 12 44 L 7 44 C 6.4454545 44 6 43.554545 6 43 L 6 7 C 6 6.4454545 6.4454545 6 7 6 z M 14 6 L 35 6 L 35 18 C 35 18.554545 34.554545 19 34 19 L 15 19 C 14.445455 19 14 18.554545 14 18 L 14 6 z M 29 8 A 1.0001 1.0001 0 0 0 28 9 L 28 16 A 1.0001 1.0001 0 0 0 29 17 L 32 17 A 1.0001 1.0001 0 0 0 33 16 L 33 9 A 1.0001 1.0001 0 0 0 32 8 L 29 8 z M 30 10 L 31 10 L 31 15 L 30 15 L 30 10 z M 15 28 L 35 28 C 35.554545 28 36 28.445455 36 29 L 36 44 L 14 44 L 14 29 C 14 28.445455 14.445455 28 15 28 z M 8 40 L 8 42 L 10 42 L 10 40 L 8 40 z M 40 40 L 40 42 L 42 42 L 42 40 L 40 40 z"/>    
                                    </svg>
                                </a>
                            </li>

                            <?php
                            if ($_SESSION['iCodPerfilLogin'] == '3' || $_SESSION['iCodPerfilLogin'] == '20' || $_SESSION['iCodPerfilLogin'] == '19'){
                                ?>
                                <li>
                                    <a id="btnDevolver" class="btn btn-link tooltipped" data-position="top" data-tooltip="Devolver">
                                        <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                            <path d="M 25 2 C 12.309534 2 2 12.309534 2 25 C 2 37.690466 12.309534 48 25 48 C 37.690466 48 48 37.690466 48 25 C 48 12.309534 37.690466 2 25 2 z M 25 4 C 36.609534 4 46 13.390466 46 25 C 46 36.609534 36.609534 46 25 46 C 13.390466 46 4 36.609534 4 25 C 4 13.390466 13.390466 4 25 4 z M 32.990234 15.986328 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.990234 15.986328 z"/>
                                        </svg>
                                        <!-- <i class="fas fa-hand-point-left fa-fw left"></i>
                                        <span>Devolver</span> -->
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <li>
                                <a id="btnArchivar" class="btn btn-link tooltipped" data-position="top" data-tooltip="Archivar">
                                    <!-- <i class="fas fa-archive left"></i>
                                    <span>Archivar</span> -->
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                        <path d="M 1 3 L 1 15 L 3 15 L 3 48 L 47 48 L 47 15 L 49 15 L 49 3 Z M 3 5 L 47 5 L 47 13 L 3 13 Z M 5 15 L 45 15 L 45 46 L 5 46 Z M 17.5 19 C 15.578125 19 14 20.578125 14 22.5 C 14 24.421875 15.578125 26 17.5 26 L 32.5 26 C 34.421875 26 36 24.421875 36 22.5 C 36 20.578125 34.421875 19 32.5 19 Z M 17.5 21 L 32.5 21 C 33.339844 21 34 21.660156 34 22.5 C 34 23.339844 33.339844 24 32.5 24 L 17.5 24 C 16.660156 24 16 23.339844 16 22.5 C 16 21.660156 16.660156 21 17.5 21 Z"/>
                                    </svg>
                                </a>
                            </li>
                            <li><a id="btnRetroceder" class="btn btn-link"><i class="fas fa-undo left"></i><span>Retroceder</span></a></li>

                            <li>
                                        <!-- <a id="antecedentesCudDd" data-target="antecedentesCudDdC">
                                            <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                                <path d="M 7.90625 0.96875 C 7.863281 0.976563 7.820313 0.988281 7.78125 1 C 7.316406 1.105469 6.988281 1.523438 7 2 L 7 12 L 17 12 C 17.359375 12.003906 17.695313 11.816406 17.878906 11.503906 C 18.058594 11.191406 18.058594 10.808594 17.878906 10.496094 C 17.695313 10.183594 17.359375 9.996094 17 10 L 10.34375 10 C 14.105469 6.304688 19.269531 4 25 4 C 36.664063 4 46 13.335938 46 25 C 46 36.664063 36.664063 46 25 46 C 13.335938 46 4 36.664063 4 25 C 4 21.566406 4.847656 18.207031 6.28125 15.34375 L 4.5 14.4375 C 2.933594 17.574219 2 21.234375 2 25 C 2 37.734375 12.265625 48 25 48 C 37.734375 48 48 37.734375 48 25 C 48 12.265625 37.734375 2 25 2 C 18.777344 2 13.117188 4.496094 9 8.5 L 9 2 C 9.011719 1.710938 8.894531 1.433594 8.6875 1.238281 C 8.476563 1.039063 8.191406 0.941406 7.90625 0.96875 Z M 24 9 L 24 23.28125 C 23.402344 23.628906 23 24.261719 23 25 C 23 25.171875 23.019531 25.339844 23.0625 25.5 L 16.28125 32.28125 L 17.71875 33.71875 L 24.5 26.9375 C 24.660156 26.980469 24.828125 27 25 27 C 26.105469 27 27 26.105469 27 25 C 27 24.261719 26.597656 23.628906 26 23.28125 L 26 9 Z"/>
                                            </svg>
                                            <span>Antecedentes</span>
                                        </a>

                                        <ul id='antecedentesCudDdC' class='dropdown-content' style='top: 100%!important;'></ul> -->

                                        <!-- <a class="modal-trigger" href="#modalAntecedentes"> -->
                                        <button type="button" id="antecedentesCudDd" class="btn btn-link tooltipped" data-position="top" data-tooltip="Antecedentes">
                                            <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                                <path d="M 7.90625 0.96875 C 7.863281 0.976563 7.820313 0.988281 7.78125 1 C 7.316406 1.105469 6.988281 1.523438 7 2 L 7 12 L 17 12 C 17.359375 12.003906 17.695313 11.816406 17.878906 11.503906 C 18.058594 11.191406 18.058594 10.808594 17.878906 10.496094 C 17.695313 10.183594 17.359375 9.996094 17 10 L 10.34375 10 C 14.105469 6.304688 19.269531 4 25 4 C 36.664063 4 46 13.335938 46 25 C 46 36.664063 36.664063 46 25 46 C 13.335938 46 4 36.664063 4 25 C 4 21.566406 4.847656 18.207031 6.28125 15.34375 L 4.5 14.4375 C 2.933594 17.574219 2 21.234375 2 25 C 2 37.734375 12.265625 48 25 48 C 37.734375 48 48 37.734375 48 25 C 48 12.265625 37.734375 2 25 2 C 18.777344 2 13.117188 4.496094 9 8.5 L 9 2 C 9.011719 1.710938 8.894531 1.433594 8.6875 1.238281 C 8.476563 1.039063 8.191406 0.941406 7.90625 0.96875 Z M 24 9 L 24 23.28125 C 23.402344 23.628906 23 24.261719 23 25 C 23 25.171875 23.019531 25.339844 23.0625 25.5 L 16.28125 32.28125 L 17.71875 33.71875 L 24.5 26.9375 C 24.660156 26.980469 24.828125 27 25 27 C 26.105469 27 27 26.105469 27 25 C 27 24.261719 26.597656 23.628906 26 23.28125 L 26 9 Z"/>
                                            </svg>
                                            <!-- <span>Antecedentes</span> -->
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" id="flujo" class="btn btn-link tooltipped" data-position="top" data-tooltip="Flujo">
                                            <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                                <path d="M 3 6 C 1.355469 6 0 7.355469 0 9 L 0 15 C 0 16.644531 1.355469 18 3 18 L 11 18 C 12.644531 18 14 16.644531 14 15 L 14 13 L 20 13 L 20 15 C 20 16.644531 21.355469 18 23 18 L 31 18 C 32.644531 18 34 16.644531 34 15 L 34 13 L 39 13 C 40.65625 13 42 14.34375 42 16 L 42 19 L 39 19 C 37.355469 19 36 20.355469 36 22 L 36 28 C 36 29.644531 37.355469 31 39 31 L 42 31 L 42 34 C 42 35.65625 40.65625 37 39 37 L 34 37 L 34 35 C 34 33.355469 32.644531 32 31 32 L 23 32 C 21.355469 32 20 33.355469 20 35 L 20 37 L 14 37 L 14 35 C 14 33.355469 12.644531 32 11 32 L 3 32 C 1.355469 32 0 33.355469 0 35 L 0 41 C 0 42.644531 1.355469 44 3 44 L 11 44 C 12.644531 44 14 42.644531 14 41 L 14 39 L 20 39 L 20 41 C 20 42.644531 21.355469 44 23 44 L 31 44 C 32.644531 44 34 42.644531 34 41 L 34 39 L 39 39 C 41.746094 39 44 36.746094 44 34 L 44 31 L 47 31 C 48.644531 31 50 29.644531 50 28 L 50 22 C 50 20.355469 48.644531 19 47 19 L 44 19 L 44 16 C 44 13.253906 41.746094 11 39 11 L 34 11 L 34 9 C 34 7.355469 32.644531 6 31 6 L 23 6 C 21.355469 6 20 7.355469 20 9 L 20 11 L 14 11 L 14 9 C 14 7.355469 12.644531 6 11 6 Z M 3 8 L 11 8 C 11.554688 8 12 8.445313 12 9 L 12 15 C 12 15.554688 11.554688 16 11 16 L 3 16 C 2.445313 16 2 15.554688 2 15 L 2 9 C 2 8.445313 2.445313 8 3 8 Z M 23 8 L 31 8 C 31.554688 8 32 8.445313 32 9 L 32 15 C 32 15.554688 31.554688 16 31 16 L 23 16 C 22.445313 16 22 15.554688 22 15 L 22 9 C 22 8.445313 22.445313 8 23 8 Z M 39 21 L 47 21 C 47.554688 21 48 21.445313 48 22 L 48 28 C 48 28.554688 47.554688 29 47 29 L 39 29 C 38.445313 29 38 28.554688 38 28 L 38 22 C 38 21.445313 38.445313 21 39 21 Z M 3 34 L 11 34 C 11.554688 34 12 34.445313 12 35 L 12 41 C 12 41.554688 11.554688 42 11 42 L 3 42 C 2.445313 42 2 41.554688 2 41 L 2 35 C 2 34.445313 2.445313 34 3 34 Z M 23 34 L 31 34 C 31.554688 34 32 34.445313 32 35 L 32 41 C 32 41.554688 31.554688 42 31 42 L 23 42 C 22.445313 42 22 41.554688 22 41 L 22 35 C 22 34.445313 22.445313 34 23 34 Z"/>
                                            </svg>
                                            <!-- <span>Flujo</span> -->
                                        </button>
                                    </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <?php
                    if(isset($_GET['dtr']) && trim($_GET['dtr']) != ''){
                        $informacion = json_decode(utf8_encode(base64_decode(trim($_GET['dtr']))));
                    ?>
                    <input type="hidden" value="<?=$informacion->cudP??''?>"  name="nCud" id="nCud">
                    <?php
                    if (isset($informacion->documentos)){
                        $movimientos = [];
                        foreach ($informacion->documentos as $valor) {
                            array_push($movimientos,$valor[0]);
                        }

                        $tramitesRspt = [];
                        foreach ($movimientos as $valor) {
                            $sqlTramitesRespuesta = 'SELECT iCodTramite AS iCodTramiteRef FROM Tra_M_Tramite_Movimientos WITH(NOLOCK) WHERE iCodMovimiento ='.$valor;
                            $rsTramiteRespuesta   = sqlsrv_query($cnx,$sqlTramitesRespuesta);
                            $RsTramiteRespuesta   = sqlsrv_fetch_array($rsTramiteRespuesta, SQLSRV_FETCH_ASSOC);
                            array_push($tramitesRspt,$RsTramiteRespuesta);
                        }

                        $documentos = '';
                        foreach ($informacion->documentos as $clave  => $value) {
                            if ($clave == 0 ){
                                $documentos .= $value[1].' | '.$value[2];
                            } else {
                                $documentos .= ', '.$value[1].' | '.$value[2];
                            }
                        }
                        ?>
                        <input type="hidden" value="<?=json_encode($movimientos)?>" name="iCodMovRespondidos" id="iCodMovRespondidos">
                        <?php
                    }

                    if(isset($informacion->movimientoP)){
                        $sqlDocRefRespuesta = 'SELECT A.iCodTramite
                                            FROM Tra_M_Tramite_Movimientos AS A
                                            INNER JOIN Tra_M_Tramite AS B ON A.iCodTramite = B.iCodTramite
                                            WHERE A.iCodMovimiento ='.$informacion->movimientoP;
                        $rsDocRefRespuesta   = sqlsrv_query($cnx,$sqlDocRefRespuesta);
                        $RsDocRefRespuesta   = sqlsrv_fetch_array($rsDocRefRespuesta);
                        ?>
                        <input type="hidden" value="<?=$RsDocRefRespuesta['iCodTramite']?>" name="iCodTramite">
                        <input type="hidden" value="<?=$informacion->movimientoP?>" name="iCodMov">
                        <?php
                    }
                ?>

                        

                    <div class="navbar-fixed references">
                        <nav class="navbar">
                            <div class="nav-wrapper">
                                <?php if(isset($documentos))
                                    {
                                        ?>
                                        <a href="#!" class="">Trabajando: <strong><?=$documentos?></strong> con CUD <strong><?=((isset($informacion->cudP) && trim($informacion->cudP) != '') ? $informacion->cudP : 'SIN CUD')?></strong>.</a>
                                        <?php
                                    }else { ?>
                                        Trabajando el CUD: <strong><?=((isset($informacion->cudP) && trim($informacion->cudP) != '') ? $informacion->cudP : 'SIN CUD')?></strong>
                                    <?php }
                                ?>
                                
                                <!-- <ul class="right">
                                    <li>
                                        <a id="antecedentesCudDd">
                                            <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                                <path d="M 7.90625 0.96875 C 7.863281 0.976563 7.820313 0.988281 7.78125 1 C 7.316406 1.105469 6.988281 1.523438 7 2 L 7 12 L 17 12 C 17.359375 12.003906 17.695313 11.816406 17.878906 11.503906 C 18.058594 11.191406 18.058594 10.808594 17.878906 10.496094 C 17.695313 10.183594 17.359375 9.996094 17 10 L 10.34375 10 C 14.105469 6.304688 19.269531 4 25 4 C 36.664063 4 46 13.335938 46 25 C 46 36.664063 36.664063 46 25 46 C 13.335938 46 4 36.664063 4 25 C 4 21.566406 4.847656 18.207031 6.28125 15.34375 L 4.5 14.4375 C 2.933594 17.574219 2 21.234375 2 25 C 2 37.734375 12.265625 48 25 48 C 37.734375 48 48 37.734375 48 25 C 48 12.265625 37.734375 2 25 2 C 18.777344 2 13.117188 4.496094 9 8.5 L 9 2 C 9.011719 1.710938 8.894531 1.433594 8.6875 1.238281 C 8.476563 1.039063 8.191406 0.941406 7.90625 0.96875 Z M 24 9 L 24 23.28125 C 23.402344 23.628906 23 24.261719 23 25 C 23 25.171875 23.019531 25.339844 23.0625 25.5 L 16.28125 32.28125 L 17.71875 33.71875 L 24.5 26.9375 C 24.660156 26.980469 24.828125 27 25 27 C 26.105469 27 27 26.105469 27 25 C 27 24.261719 26.597656 23.628906 26 23.28125 L 26 9 Z"/>
                                            </svg>
                                            <span>Antecedentes</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="flujo">
                                            <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                                <path d="M 3 6 C 1.355469 6 0 7.355469 0 9 L 0 15 C 0 16.644531 1.355469 18 3 18 L 11 18 C 12.644531 18 14 16.644531 14 15 L 14 13 L 20 13 L 20 15 C 20 16.644531 21.355469 18 23 18 L 31 18 C 32.644531 18 34 16.644531 34 15 L 34 13 L 39 13 C 40.65625 13 42 14.34375 42 16 L 42 19 L 39 19 C 37.355469 19 36 20.355469 36 22 L 36 28 C 36 29.644531 37.355469 31 39 31 L 42 31 L 42 34 C 42 35.65625 40.65625 37 39 37 L 34 37 L 34 35 C 34 33.355469 32.644531 32 31 32 L 23 32 C 21.355469 32 20 33.355469 20 35 L 20 37 L 14 37 L 14 35 C 14 33.355469 12.644531 32 11 32 L 3 32 C 1.355469 32 0 33.355469 0 35 L 0 41 C 0 42.644531 1.355469 44 3 44 L 11 44 C 12.644531 44 14 42.644531 14 41 L 14 39 L 20 39 L 20 41 C 20 42.644531 21.355469 44 23 44 L 31 44 C 32.644531 44 34 42.644531 34 41 L 34 39 L 39 39 C 41.746094 39 44 36.746094 44 34 L 44 31 L 47 31 C 48.644531 31 50 29.644531 50 28 L 50 22 C 50 20.355469 48.644531 19 47 19 L 44 19 L 44 16 C 44 13.253906 41.746094 11 39 11 L 34 11 L 34 9 C 34 7.355469 32.644531 6 31 6 L 23 6 C 21.355469 6 20 7.355469 20 9 L 20 11 L 14 11 L 14 9 C 14 7.355469 12.644531 6 11 6 Z M 3 8 L 11 8 C 11.554688 8 12 8.445313 12 9 L 12 15 C 12 15.554688 11.554688 16 11 16 L 3 16 C 2.445313 16 2 15.554688 2 15 L 2 9 C 2 8.445313 2.445313 8 3 8 Z M 23 8 L 31 8 C 31.554688 8 32 8.445313 32 9 L 32 15 C 32 15.554688 31.554688 16 31 16 L 23 16 C 22.445313 16 22 15.554688 22 15 L 22 9 C 22 8.445313 22.445313 8 23 8 Z M 39 21 L 47 21 C 47.554688 21 48 21.445313 48 22 L 48 28 C 48 28.554688 47.554688 29 47 29 L 39 29 C 38.445313 29 38 28.554688 38 28 L 38 22 C 38 21.445313 38.445313 21 39 21 Z M 3 34 L 11 34 C 11.554688 34 12 34.445313 12 35 L 12 41 C 12 41.554688 11.554688 42 11 42 L 3 42 C 2.445313 42 2 41.554688 2 41 L 2 35 C 2 34.445313 2.445313 34 3 34 Z M 23 34 L 31 34 C 31.554688 34 32 34.445313 32 35 L 32 41 C 32 41.554688 31.554688 42 31 42 L 23 42 C 22.445313 42 22 41.554688 22 41 L 22 35 C 22 34.445313 22.445313 34 23 34 Z"/>
                                            </svg>
                                            <span>Flujo</span>
                                        </a>
                                    </li>
                                </ul> -->
                            </div>
                        </nav>
                    </div>

                    
                    <?php
                        if (trim($informacion->flgPendientes) == 1){
                            $documentosEnTramite = $informacion->agrupado;
                        }else {
                            $documentosEnTramite = 0;
                        }
                }
                ?>
            
        <div class="container">
            
                <input type="hidden" name="cDocumentosEnTramite" id="cDocumentosEnTramite" value="<?=$documentosEnTramite??0?>">

                <div id="TablaDocumentosAcumulados" class="row">
                    <div class="col s12">
                        <ul class="collection with-header">
                            <li class="collection-header"><h6>Documentos agregados</h6></li>
                            <li id="item-1">
                                <table id="TblDocumentos" class="bordered hoverable highlight striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Tipo Doc</th>
                                        <th>N° de Doc</th>
                                        <th>CUD</th>
                                        <th>Asunto</th>
                                        <th>Instrucción Específica</th>
                                        <th>Fecha del Documento</th>
                                        <th>Responsable</th>
                                        <th>Encriptado</th>
                                        <th>Distribución</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m9">
                        <div class="card hoverable">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Datos del documento</legend>
                                    <div class="row">
                                        <div class="col s12 m3 input-field">
                                            <select name="cCodTipoTra" id="cCodTipoTra" class="FormPropertReg form-control">
                                                <option value="2">Interno</option>
                                                <option value="3">Externo</option>
                                            </select>
                                            <label for="cCodTipoTra">Tipo de Trámite</label>
                                        </div>
                                        <div class="col s12 m3 input-field">
                                            <select name="cCodTipoDoc" id="cCodTipoDoc" class="FormPropertReg form-control">
                                                <option value="">Seleccione</option>
                                                <?php
                                                $sqlTipo = "SELECT * FROM Tra_M_Tipo_Documento   WHERE nFlgInterno = 1 AND cCodTipoDoc != 45  ORDER BY cDescTipoDoc ASC";
                                                $rsTipo = sqlsrv_query($cnx,$sqlTipo);
                                                while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
                                                    echo "<option value='".trim($RsTipo["cCodTipoDoc"])."' >".trim($RsTipo["cDescTipoDoc"])."</option>";
                                                }
                                                sqlsrv_free_stmt($rsTipo);
                                                ?>
                                            </select>
                                            <label for="cCodTipoDoc">Tipo de Documento</label>
                                        </div>
                                        <div class="col s12 m3 input-field">
                                            <input placeholder="dd-mm-aaaa" value="" type="text" id="fFecPlazo" name="fFecPlazo" class="FormPropertReg form-control datepicker">
                                            <label for="fFecPlazo">Fecha de Plazo</label>
                                            <span class="helper-text" data-error="wrong" data-success="right">Opcional</span>
                                        </div>
                                        <div class="col s12 m3 input-field">
                                            <input id="reloj" value="&nbsp;" type="text" name="reloj" class="FormPropertReg form-control" onfocus="window.document.frmRegistro.reloj.blur()">
                                            <label for="reloj">Fecha de Registro</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <textarea name="cAsunto" id="cAsunto" class="FormPropertReg materialize-textarea"></textarea>
                                            <label for="cAsunto">Asunto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s6 input-field">
                                            <div class="switch">
                                                <label>
                                                    Nuevo tramite
                                                    <input type="checkbox" id="flgSigo" name="flgSigo" value="1">
                                                    <span class="lever"></span>
                                                    Proviene del Sigo
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col s6 input-field">
                                            <div class="switch">
                                                <label>
                                                    Sin encriptar
                                                    <input type="checkbox" <?=($_SESSION['flgEncriptacion'] == 1 ? '' : 'disabled')?> id="flgEncriptado" name="flgEncriptado" value="1">
                                                    <span class="lever"></span>
                                                    Encriptado
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m12 input-field">
                                            <textarea name="editorOficina" id="editorOficina"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset style="padding-bottom: 2em" id="destinatario">
                                    <legend>Datos del destinatario(s) interno</legend>
                                    <div class="row">
                                        <div class="col s4 m4 input-field">
                                            <div class="switch">
                                                <label>
                                                    Oficinas
                                                    <input type="checkbox" id="flgDelegar" name="flgDelegar" value="1">
                                                    <span class="lever"></span>
                                                    Especialistas
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m12">
                                            <div id="areaOficina">
                                                <div class="row" id="paraEspecialistas" style="display: none">
                                                    <div class="input-field col s12 m6">
                                                        <select id="nomOficinaE">
                                                        </select>
                                                        <label for="nomOficinaE">Oficina</label>
                                                        <input type="hidden" value="0" id="CodOficinaE">
                                                    </div>
                                                    <div class="col s12 m6 input-field">
                                                        <select name="responsableE" id="responsableE">
                                                        </select>
                                                        <label for="responsableE">Responsable</label>
                                                    </div>
                                                </div>
                                                <div class="row" id="paraOficinas">
                                                    <div class="col s12 m6 input-field">
                                                        <select name="iCodOficinaO" id="iCodOficinaO">
                                                        <option value="">Seleccione Oficina</option>
                                                        <?php
                                                        $sqlOficina = "SELECT iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS oficina FROM Tra_M_Oficinas  WHERE iFlgEstado != 0 AND flgEliminado = 0 ORDER BY cNomOficina ASC";
                                                        $rsOficina = sqlsrv_query($cnx, $sqlOficina);
                                                        while ($RsOficina = sqlsrv_fetch_array($rsOficina)) {
                                                            echo "<option value=" . $RsOficina["iCodOficina"] . ">".$RsOficina["oficina"]."</option>";
                                                        }
                                                        sqlsrv_free_stmt($rsOficina);
                                                        ?>
                                                        </select>
                                                        <label for="iCodOficinaO">Oficina</label>
                                                    </div>
                                                    <div class="input-field input-disabled col s12 m6">
                                                        <input type="hidden" value="" id="codResponsableiO">
                                                        <input  class="disabled" id="nomResponsableO" value="&nbsp;" type="text">
                                                        <label class="active" for="nomResponsableO">Responsable</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s6 m2 input-field">
                                                        <select name="cCopia" id="cCopia">
                                                            <option value="0" selected>No</option>
                                                            <option value="1">Si</option>
                                                        </select>
                                                        <label for="cCopia">Copia</label>
                                                    </div>
                                                    <div class="col s6"><br>
                                                        <input name="button" type="button" class="btn btn-secondary" value="Confirmar" id="btnAgregarDestinatario">
                                                    </div>
                                                </div>
                                            </div>
                                            <table id="TblDestinatarios" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Oficina</th>
                                                    <th>Trabajador</th>
                                                    <td>Copia</td>
                                                    <th>Opci&oacute;n</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset style="display: none" id="destinoExterno">
                                    <legend>Destinatario externo</legend>
                                    <div id="sugerenciasDestinatario" style="display: none"></div>
                                    <div class="row" style="display: none" id="nombreDestinoEntidadMREcol">
                                        <div class="col m12 input-field">
                                            <select id="nombreDestinoEntidadMRE" class="js-data-example-ajax browser-default" name="nombreDestinoEntidadMRE"></select>
                                            <label for="nombreDestinoEntidadMRE">Nombre de la entidad</label>
                                        </div>
                                    </div>
                                    <div class="row" id="nombreDestinoExternocol">
                                        <div class="col m9 input-field">
                                            <select id="nombreDestinoExterno" class="js-data-example-ajax browser-default" name="nombreDestinoExterno" data-nivel="0"></select>
                                            <label for="nombreDestinoExterno">Nombre de la entidad</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" class="input-disabled" name="nroDocDestinoExterno" id="nroDocDestinoExterno" >
                                            <label class="active">N° Documento</label>
                                        </div>
                                        <div class="col s12">
                                            <div class="row" id="dependenciasDestinoExterno"></div>
                                        </div>
                                        <div class="col m12 input-field">
                                            <select id="direccionDestinoExterno"  name="direccionDestinoExterno"></select>
                                            <label for="direccionDestinoExterno">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="row" id="opcionalFields">
                                        <div class="col m2 input-field">
                                            <input type="text" name="prefijoNombre" id="prefijoNombre">
                                            <label for="prefijoNombre">Pre-fijo</label>
                                        </div>
                                        <div class="col m4 input-field">
                                            <input type="text" name="responsableDestinoExterno" id="responsableDestinoExterno">
                                            <label for="responsableDestinoExterno">Nombre del responsable</label>
                                        </div>
                                        <div class="col m6 input-field">
                                            <input type="text" name="cargoResponsableDestinoExterno" id="cargoResponsableDestinoExterno">
                                            <label for="cargoResponsableDestinoExterno">Cargo del responsable</label>
                                        </div>
                                        <div class="col m4 input-field">
                                            <div class="switch">
                                                <label>
                                                    Mostrar Dirección
                                                    <input type="checkbox" id="flgMostrarDireccion" name="flgMostrarDireccion" value="1">
                                                    <span class="lever"></span>
                                                    Ocultar Dirección
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m2">
                                            <input name="button" type="button" class="btn btn-secondary" value="Confirmar" id="btnAgregarDestinoExterno">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col m12">
                                            <table id="TblDestinosExternos" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Entidad</th>
                                                    <th>N° Documento</th>
                                                    <th>Dirección</th>
                                                    <th>Pre-fijo</th>
                                                    <td>Nombre Responsable</td>
                                                    <th>Cargo Responsable</th>
                                                    <th>Dirección visible</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Referencias</legend>
                                    <div class="row">
                                        <div class="col m12">
                                            <select id="cReferencia" class="js-example-basic-multiple-limit browser-default" name="cReferencia[]" multiple="multiple"></select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Adjuntos anexos del grupo</legend>
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
                                                        <th>Antece-<br>dente</th>
                                                        <th>Se adjunta</th>
                                                        <th>Archivo</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4">
                                                                <p style="font-size: 85%; text-align: left">
                                                                    <strong>Antecedente</strong>: permite incluir el anexo como antecedente del expediente<br>
                                                                    <strong>Se adjunta</strong>: permite visualizar el nombre del documento en el PDF
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modalResponsableFirma" class="modal" style="overflow: visible">
                    <div class="modal-header">
                        <h4>Datos responsable de firma</h4>
                    </div>
                    <div class="modal-content">
                        <fieldset>
                            <div class="row">
                                <div class="col m6 input-field">
                                    <select name="iCodOficinaFirma" id="iCodOficinaFirma"></select>
                                    <label for="iCodOficinaFirma">Oficina Responsable Firma</label>
                                </div>
                                <div class="col m6 input-field">
                                    <input type="text" value="&nbsp;" id="nomResponsableFirmar" disabled>
                                    <label class="active" for="nomResponsableFirmar">Trabajador Responsable Firma</label>
                                    <input type="hidden" value="" name="iCodTrabajadorFirma" id="iCodTrabajadorFirma">
                                    <input type="hidden" value="" name="iCodPerfilFirma" id="iCodPerfilFirma">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <a class="waves-effect waves-green btn-flat modal-close" >Cancelar</a>
                        <a class="waves-effect waves-green btn-flat" id="btnAgregarProyecto" >Grabar</a>
                    </div>
                </div>

                <input type="hidden" name="cTipo" value="" id="cTipo">
                <input type="hidden" name="cCodigo" value="" id="cCodigo">
                <!-- <input type="hidden" name="agrupadoTemp" value="0" id="agrupadoTemp"> -->
            </form>
    </main>

    <input type="hidden" id="argumentos" value="" />
    <div id="addComponent"></div>
    <input type="hidden" id="nombreDocument" value="">
    <input type="hidden" id="signedDocument" value="">
    <input type="hidden" id="tipo_f" value="">
    <input type="hidden" id="idtra" value="">
    <input type="hidden" id="nroVisto" value="">
    <input type="hidden" id="datosDoc" value="">

    <!-- Modal Structure -->
    <div id="modalAntecedentes" class="modal bottom-sheet">
        <div class="modal-content">
            <ul id='antecedentesCudDdC' class="collection with-header"></ul>
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalDoc" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Documento</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>

        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat" id="btnCerrarDocFirma">Cerrar</a>
        </div>
    </div>

    <div id="modalDocFirmado" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Documento</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnCerrarDocFirmado">Cerrar</a>
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

    <div id="modalPrevisualizacion" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Previsualización documento</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalRegresar" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Motivo de regreso</h4>
        </div>
        <div class="modal-content">
            <form id="formMotRegresar" name="formMotRegresar">
                <div class="row">
                    <div class="col s12 input-field">
                        <input type="text" id="motivoRegreso" name="motivoRegreso">
                        <label for="motivoRegreso">Motivo del regreso</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a id="btnMotivoRegresar" class="waves-effect btn-flat">Regresar</a>
            <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>

    <div id="modalDevolver" class="modal">
        <div class="modal-header">
            <h4>Devolución de documento</h4>
        </div>
        <div class="modal-content">
            Use esta opción para devolver el documento, ya sea para VISTO o para ser EDITADO.
            <form name="formEnvioDevolver" class="row">
                <div class="input-field col s12">
                    <select id="codOficinaDevolver">
                        <?php
                        $sqlOfiVisado ="SELECT iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS nomOficina FROM Tra_M_Oficinas WHERE flgEliminado = 0 AND iCodOficina = ".$_SESSION['iCodOficinaLogin']."
                              UNION ALL
                              SELECT iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS nomOficina  FROM Tra_M_Oficinas WHERE flgEliminado = 0 AND iCodPadre = ".$_SESSION['iCodOficinaLogin'];
                        $rsOfiVisado = sqlsrv_query($cnx,$sqlOfiVisado);
                        while ($RsOfiVisado = sqlsrv_fetch_array($rsOfiVisado)){
                            echo "<option value='".$RsOfiVisado['iCodOficina']."'>".$RsOfiVisado['nomOficina']."</option>";
                        }
                        ?>
                    </select>
                    <label for="codOficinaDevolver">Oficina</label>
                </div>
                <div class="input-field col s12">
                    <select id="codEspecialistaDevolver">
                        <?php
                        $sqlTra ="SELECT pu.iCodTrabajador, cNombresTrabajador, cApellidosTrabajador , cDescPerfil
                                  FROM Tra_M_Perfil_Ususario AS pu, Tra_M_Trabajadores AS tb, Tra_M_Perfil AS p
                                  WHERE pu.iCodOficina = ".$_SESSION['iCodOficinaLogin']." AND pu.iCodPerfil in (4) AND pu.iCodTrabajador = tb.iCodTrabajador AND p.iCodPerfil = pu.iCodPerfil";
                        $rsTra = sqlsrv_query($cnx,$sqlTra);
                        while ($RsTra = sqlsrv_fetch_array($rsTra)){
                            echo "<option value='".$RsTra['iCodTrabajador']."'>".rtrim($RsTra['cApellidosTrabajador']).", ".rtrim($RsTra['cNombresTrabajador'])." ( ".rtrim($RsTra['cDescPerfil'])." )</option>";
                        }
                        ?>
                    </select>
                    <label for="codEspecialistaDevolver">Especialista</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="obsDevolver" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="obsDevolver">Instrucción Específica</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnvioDevolver" class="waves-effect btn-flat">Enviar</a>
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
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarArchivar" class="waves-effect btn-flat">Archivar</a>
        </div>
    </div>

    <div id="modalDespacho" class="modal modal-fixed-header modal-fixed-footer">
    <div class="modal-header">
        <h4>Datos del despacho</h4>
    </div>
    <div class="modal-content">
        <form name="formDatosDespacho" id="formDatosDespacho" >
            <input type="hidden" name="IdProyectoDespacho" id="IdProyectoDespacho" value="0">
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="col m10 input-field input-disabled">
                            <input type="text" id="NombreDespacho">
                            <label for="NombreDespacho">Nombre Destinatario</label>
                        </div>

                        <div class="col m2 input-field input-disabled">
                            <input type="text"  id="RucDespacho" name="RucDespacho">
                            <label for="RucDespacho">Ruc</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <select id="IdTipoEnvio" name="IdTipoEnvio">
                            </select>
                            <label for="IdTipoEnvio">Tipo Envío</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" id="ObservacionesDespacho" name="ObservacionesDespacho">
                            <label for="ObservacionesDespacho">Observaciones del despacho</label>
                        </div>
                    </div>
                    <div class="row" id="datosEnvioFisico">
                        <div class="col s12 input-field">
                            <input type="text" id="DireccionDespacho" name="DireccionDespacho">
                            <label for="DireccionDespacho">Dirección</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select id="DepartamentoDespacho" name="DepartamentoDespacho">
                                <option value="">Seleccione</option>
                                <?php
                                $rsDepa = sqlsrv_query($cnx, "SELECT cCodDepartamento, cNomDepartamento FROM Tra_U_Departamento ORDER BY cNomDepartamento ASC");
                                while($RsDepa = sqlsrv_fetch_array($rsDepa)){
                                    ?>
                                    <option value="<?=RTRIM($RsDepa['cCodDepartamento'])?>"><?=RTRIM($RsDepa['cNomDepartamento'])?></option>
                                <?php } ?>
                            </select>
                            <label for="DepartamentoDespacho">Departamento</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select id="ProvinciaDespacho" name="ProvinciaDespacho">
                            </select>
                            <label for="ProvinciaDespacho">Provincia</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select id="DistritoDespacho" name="DistritoDespacho">
                            </select>
                            <label for="DistritoDespacho">Distrito</label>
                        </div>
                    </div>
                    <div class="row" id="datosEnvioInteroperabilidad" style="display: none;">
                        <div class="col s12 input-field">
                            <input type="text" id="UnidadOrganicaDstIOT" name="UnidadOrganicaDstIOT">
                            <label for="UnidadOrganicaDstIOT">Unidad Organica Destino</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" id="PersonaDstIOT" name="PersonaDstIOT">
                            <label for="PersonaDstIOT">Persona Destino</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" id="CargoPersonaDstIOT" name="CargoPersonaDstIOT">
                            <label for="CargoPersonaDstIOT">Cargo Destino</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a id="btnGuardarDatosDespacho" class="waves-effect waves-green btn-flat">Guardar</a>
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

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>

    <!--COMPONENTES PARA LA FIRMA Y VISTOS-->
    <script type="text/javascript" src="invoker/client.js"></script>
    <script type="text/javascript" src="../conexion/global.js"></script>
    <script type="text/javascript">

        window.onload = function() {
            mueveReloj();
        };
        //<![CDATA[
        var documentName_ = null;
        //
        window.addEventListener('getArguments', function (e) {
            type = e.detail;
            if(type === 'W'){
                ObtieneArgumentosParaFirmaDesdeLaWeb(); // Llama a getArguments al terminar.
            }else if(type === 'L'){
                ObtieneArgumentosParaFirmaDesdeArchivoLocal(); // Llama a getArguments al terminar.
            }
        });
        function getArguments(){
            arg = document.getElementById("argumentos").value;
            dispatchEventClient('sendArguments', arg);
        }

        window.addEventListener('invokerOk', function (e) {
            type = e.detail;
            if(type === 'W'){
                MiFuncionOkWeb();
            }else if(type === 'L'){
                MiFuncionOkLocal();
            }
        });

        window.addEventListener('invokerCancel', function (e) {
            MiFuncionCancel();
        });

        //::LÓGICA DEL PROGRAMADOR::
        function ObtieneArgumentosParaFirmaDesdeLaWeb(){
            //let u = document.getElementById("signedDocument").value.trim();
            let documentURL = document.getElementById("signedDocument").value.trim();
            let documentName = document.getElementById("nombreDocument").value.trim();
            //let documentName_ = u.trim();
            console.log(documentURL);
            let tipFirma = $("#tipo_f").val();
            let nroVisto = $("#nroVisto").val();

            //Obtiene argumentos
            $.post("invoker/postArguments.php", {
                type : "W",
                tipFirma: tipFirma,
                documentURL: documentURL,
                documentName: documentName,
                //documentName : documentName_,
                nroVisto: nroVisto
            }, function(data, status) {
                document.getElementById("argumentos").value = data;
                getArguments();
            });
        }

        function ObtieneArgumentosParaFirmaDesdeArchivoLocal(){
            u = document.getElementById("signedDocument").value;
            //$.get("controller/getArguments.php", {}, function(data, status) {
            documentName_ = u;
            //Obtiene argumentos

            $.post(urlp+"invoker/postArguments.php", {
                type : "L",
                tipFirma: 'f',
                documentName : documentName_
            }, function(data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                document.getElementById("argumentos").value = data;
                getArguments();
            });
        }

        function MiFuncionOkWeb(){
            let documentURL = document.getElementById("signedDocument").value.trim();
            let documentName = document.getElementById("nombreDocument").value.trim();

            let nroVisto = $("#nroVisto").val();

            let tipFirma = $("#tipo_f").val();
            let idtra = $("#idtra").val();
            let datosDoc = $("#datosDoc").val();
            getSpinner('Guardando Documento');
            $.ajax({
                url: "registerDoc/Documentos.php",
                method: "POST",
                data: {
                    Evento: "ActualizaEstadosSellosDocumentos",
                    tipo: tipFirma,
                    codigo: idtra
                },
                datatype: "json",
                success: function (response) {
                    $.post("invoker/save.php",{
                            documentName: documentName,
                            documentURL: documentURL,
                            idtra: idtra,
                            tipo: tipFirma
                        },
                        function (data,status){
                            $.post("enviarDocAsistentes.php", {
                                    codigoEnviar: idtra,
                                    url: documentURL,
                                    datosDoc: datosDoc
                                },
                                function (data,status) {
                                    tblDocumentos.clear().draw();
                                    tblDocumentos.ajax.reload();
                                    $('#modalDocFirmado div.modal-content iframe').attr('src',"http://"+documentURL);
                                    let elem = document.querySelector('#modalDocFirmado');
                                    let instance = M.Modal.init(elem, {dismissible:false});
                                    instance.open();
                                }
                            );
                        }
                    );
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al actualizar estados de firma!');
                    M.toast({html: "Error al firmar"});
                }
            });
        }

        function MiFuncionOkLocal(){
            alert("Documento firmado desde la PC correctamente.");
            document.getElementById("signedDocument").href="controller/getFile.php?documentName=" + documentName_;
        }

        function MiFuncionCancel(){
            let documentName = document.getElementById("nombreDocument").value.trim();
            $.post("invoker/canceled.php",{
                documentName: documentName,
                },
                function (data,status){
                    alert("El proceso de firma digital fue cancelado.");
                    document.getElementById("signedDocument").href="#";
                }
            );
        }
    </script>

    <script>
        var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
        var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

        CKEDITOR.replace( 'editorOficina', {
            language: 'es'
        });

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.pasteFromWordRemoveFontStyles = true;

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

        $('#cReferencia').select2({
            placeholder: 'Seleccione y busque',
            maximumSelectionLength: 10,
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al referencia.</p>";
                },
                "searching": function() {
                    return "Buscando..";
                },
                "inputTooShort": function() {
                    return "Ingrese más de 3 letras ...";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'ajax/ajaxReferencias.php',
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

        // AL AGREGAR O QUITAR REFERENCIAS SE OBTINEN SUS ANEXOS Y  DOCUEMNTO FIRMADO
        $('#cReferencia').on('select2:select', function (e) {
            let ultimo = $('#cReferencia').find(':selected:last').val();
            if (typeof ultimo !== "undefined") {
                listarAnexosReferencia(ultimo,'iCodTramite');
            }
        });

        $('#nombreDestinoExterno').select2({
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al destinatario. Para incluir un nuevo destinatario, comuníquese con el Responsable de Archivo de Gestión de su área.</p>";
                },
                "searching": function() {

                    return "Buscando..";
                },
                "inputTooShort": function() {

                    return "Ingrese más de 3 letras ...";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'mantenimiento/Entidad.php',
                dataType: 'json',
                method: 'POST',
                data: function (params) {
                    var query = {
                        search: params.term,
                        Evento: 'BuscarEntidad'
                    }
                    return query;
                },
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('#nombreDestinoEntidadMRE').select2({
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al destinatario.";
                },
                "searching": function() {

                    return "Buscando..";
                },
                "inputTooShort": function() {

                    return "Ingrese más de 3 letras ...";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'ajax/ajaxEntidadMRE.php',
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

        function ObtenerDatosEntidad(id,callfunct) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Entidad.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    callfunct(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ActualizarDatos(datos) {
            $("#nroDocDestinoExterno").val(datos.NumeroDocumento).next().addClass('active');
            $("#responsableDestinoExterno").val(datos.ResponsableEntidad).next().addClass('active');
            $("#cargoResponsableDestinoExterno").val(datos.CargoResponsableEntidad).next().addClass('active');
        }

        function ObtenerDatosSede(id) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idSede": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    AgregarSede(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ObtenerDatosSedeDespacho(id) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idSede": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    LlenarDatosDespacho(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ObtenerSedesEntidad(id,callfunct) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerSedesEntidad", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    for(var i of data){
                        callfunct(i.IdSede);
                    }
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function AgregarSede(datos) {
            var id = datos.IdSede;
            var ubigeo = '';
            var text = '';

            if (datos.IdDepartamento != '15'){
                ubigeo += datos.nomDepartamento + ', '
            }
            if (!(datos.IdDepartamento == '15' && datos.IdProvincia == '01')){
                ubigeo += datos.nomProvincia + ', '
            }
            ubigeo += datos.nomDistrito;

            var text = datos.Direccion + ' | '+  datos.nomPais + ' | ' + ubigeo;

            $("#direccionDestinoExterno").append('<option value="'+id+'">'+text+'</option>').formSelect();
        }


        function CrearSelectDependencia(nivel){
            var nivelNuevo = parseInt(nivel) + 1;
            var html = '<div class="col m12 input-field">'+
                            '<select id="dependenciaEntidad'+String(nivelNuevo)+'"  name="dependenciaEntidad'+String(nivelNuevo)+'" data-tipo="dependencia" data-nivel="'+String(nivelNuevo)+'"></select>'+
                            '<label for="dependenciaEntidad'+String(nivelNuevo)+'">Dependencia</label>'+
                        '</div>';
            $("#dependenciasDestinoExterno").append(html);
            return "dependenciaEntidad"+String(nivelNuevo)
        }

        function AgregarOpcionesSelect(selector,datos,selected=0){
            let destino = $(selector);
            destino.empty().append('<option value="">Seleccione...</option>');
            if (datos.length != 0){
                $.each(datos, function( key, value ) {
                    destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                });
            }
            destino.formSelect();
        }

        function ListarEntidadesHijas(selectorPadre,idEntidadPadre,selected = 0) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Entidad.php",
                method: "POST",
                data: {"Evento": "ListarEntidadesHijas","IdEntidadPadre" : idEntidadPadre},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.length != 0){
                        var selector = CrearSelectDependencia(selectorPadre.attr("data-nivel"))
                        AgregarOpcionesSelect("#"+selector,data);
                    }
                }
            });
        }

        function ObtenerSedesDependencia(id,callfunct) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerSedesDependencia", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    for(var i of data){
                        callfunct(i.IdSede);
                    }
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        $('#nombreDestinoExterno').on('select2:select', function (e) {
            let valor = $('#nombreDestinoExterno').val();
            ObtenerDatosEntidad(valor,ActualizarDatos);
            $("#direccionDestinoExterno").empty().append('<option value="">Seleccione...</option>').formSelect();
            ObtenerSedesEntidad(valor,ObtenerDatosSede);
            $("#dependenciasDestinoExterno").empty();
            ListarEntidadesHijas($(this),valor);
        });

        $("#dependenciasDestinoExterno").on("change", "select", function (e) {
            let valor = $(this).val();
            $("#direccionDestinoExterno").empty().append('<option value="">Seleccione...</option>').formSelect();
            $(this).closest("div.col.input-field").nextAll().remove();
            if (valor != ''){
                ObtenerDatosEntidad(valor,ActualizarDatos);
                ObtenerSedesDependencia(valor,ObtenerDatosSede);
                ListarEntidadesHijas($(this),valor);
            }
        });

        function mueveReloj(){
            momentoActual = new Date();
            anho = momentoActual.getFullYear();
            mes = (momentoActual.getMonth()) + 1;
            dia = momentoActual.getDate();
            hora = momentoActual.getHours();
            minuto = momentoActual.getMinutes();
            segundo = momentoActual.getSeconds();
            if((mes>=0)&&(mes<=9)){ mes="0"+mes; }
            if((dia>=0)&&(dia<=9)){ dia="0"+dia; }
            if((hora>=0)&&(hora<=9)){ hora="0"+hora; }
            if((minuto>=0)&&(minuto<=9)){ minuto="0"+minuto; }
            if ((segundo>=0)&&(segundo<=9)){ segundo="0"+segundo; }
            horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo;
            document.frmRegistro.reloj.value=horaImprimible;
            setTimeout("mueveReloj()",1000)
        };

        function LlenarDatosDespacho(datos) {
            var direccion = datos.Direccion == null ? '' : datos.Direccion.trim();
            var idDepartamento = datos.IdDepartamento == null ? 0 : datos.IdDepartamento.trim();
            var idProvincia = datos.IdProvincia == null ? 0 : datos.IdProvincia.trim();
            var idDistrito = datos.IdDistrito == null ? 0 : datos.IdDistrito.trim();



            $('#formDatosDespacho #DireccionDespacho').val(direccion).next().addClass('active');

            $('#DepartamentoDespacho option[value="'+idDepartamento+'"]').prop('selected',true);
            var elemdep = document.getElementById('DepartamentoDespacho');
            M.FormSelect.init(elemdep, {dropdownOptions:{container:document.body}});
            $("#DepartamentoDespacho").trigger("change");

            $('#ProvinciaDespacho option[value="'+idProvincia+'"]').prop('selected',true);
            var elempro = document.getElementById('ProvinciaDespacho');
            M.FormSelect.init(elempro, {dropdownOptions:{container:document.body}});
            $("#ProvinciaDespacho").trigger("change");

            $('#DistritoDespacho option[value="'+idDistrito+'"]').prop('selected',true);
            var elemdis = document.getElementById('DistritoDespacho');
            M.FormSelect.init(elemdis, {dropdownOptions:{container:document.body}});
        }

        function validarFormulario(){
            if($("#cCodTipoDoc").val().trim() === ''){
                $.alert("Falta seleccionar tipo de documento!");
                return false;
            }
            if($("#cAsunto").val() === ''){
                $.alert("Falta asunto!");
                return false;
            }
            CKEDITOR.instances.editorOficina.updateElement();
            if($("#editorOficina").val() === ''){
                $.alert('Falta el cuerpo del documento!');
                return false;
            }

            if($('#cCodTipoTra').val() === '2'){
                var filastabla = tblDestinatarios.data().length;
            } else {
                var filastabla = tblDestinosExternos.data().length;
            }
            if (filastabla === 0){
                $.alert('Falta seleccionar al menos un destinatario!');
                return false;
            }

            return true;
        }

        function listarDestinatarios(dataString,tipo) {
            let data = $.parseJSON(dataString);
            if(tipo === 2){
                tblDestinatarios.clear().draw();
                $.each(data,function(index,value){
                    tblDestinatarios.row.add(value).draw();
                });
            } else {
                tblDestinosExternos.clear().draw();
                $.each(data,function(index,value){
                    tblDestinosExternos.row.add(value).draw();
                });
            }
        }

        function listarAnexosReferencia(codigo,parametro){
            let parametros = {
                codigo: codigo,
                atributo: parametro
            };
            $.ajax({
                cache: false,
                method: "POST",
                data: parametros,
                url: "ajax/ajaxListarAnexosReferencia.php",
                datatype: 'json',
                success: function (respuesta) {
                    if ($.trim(respuesta)){
                        respuesta = JSON.parse(respuesta);
                        $.each(respuesta,function(index,value){
                            if (value.cNombreOriginal.trim() == '') {
                                let nom = value.cNombreNuevo.split('/');
                                var nombre = nom[nom.length-1];
                            } else {
                                var nombre = value.cNombreOriginal;
                            }
                            InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo);
                        });
                    }
                }
            });
        }

        function listarAnexos(dataString, dataStringAnexosImprimibles = ''){
            let data = $.parseJSON(dataString);
            if (dataStringAnexosImprimibles == '' || dataStringAnexosImprimibles == null){
                $.each(data, function (key,value) {
                    $.ajax({
                        cache: false,
                        method: "POST",
                        data: value,
                        url: "ajax/ajaxListarAnexos.php",
                        datatype: 'json',
                        success: function (respuesta) {
                            let value = JSON.parse(respuesta);
                            if (value.cNombreOriginal.trim() == '') {
                                let nom = value.cNombreNuevo.split('/');
                                var nombre = nom[nom.length-1];
                            } else {
                                var nombre = value.cNombreOriginal;
                            };
                            InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo, false);
                        }
                    });
                });
            } else {
                let anexosImprimibles = $.parseJSON(dataStringAnexosImprimibles);
                $.each(data, function (key,value) {
                    $.ajax({
                        cache: false,
                        method: "POST",
                        data: value,
                        url: "ajax/ajaxListarAnexos.php",
                        datatype: 'json',
                        success: function (respuesta) {
                            let value = JSON.parse(respuesta);
                            if (value.cNombreOriginal.trim() == '') {
                                let nom = value.cNombreNuevo.split('/');
                                var nombre = nom[nom.length-1];
                            } else {
                                var nombre = value.cNombreOriginal;
                            };
                            let imprime = false;
                            $.each(anexosImprimibles, function (i,j){
                                if (value.iCodDigital == j.iCodDigital){
                                    imprime = true;
                                }
                            });
                            InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo, imprime);
                        }
                    });
                });
            }
        }

        function listarReferencias (dataStringReferencia){
            const cReferenciaSelect = $('#cReferencia');
            cReferenciaSelect.val(null).trigger('change');
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxListarReferencias.php',
                data: {datos: dataStringReferencia},
                datatype: 'json',
            }).then(function (data) {
                let theData = JSON.parse(data);
                $.each(theData, function( index, value ) {
                    let option = new Option(value.text, value.id, true, true);
                    cReferenciaSelect.append(option).trigger('change')
                });
            });
        }

        //BUSCAR EL RESPONSABLE
        function obtenerResponsable (origen,oculto,mostrado){
            if ($(origen).val().trim() != ""){
                $.ajax({
                    type: 'POST',
                    url: 'loadResponsableRIO.php',
                    data: {iCodOficinaResponsable: $(origen).val()},
                    dataType: 'json',
                    success: function(list){
                        $.each(list,function(index,value)
                        {
                            opcion = value.cNombresTrabajador.trim() + " " +  value.cApellidosTrabajador.trim();
                            codigo = value.iCodTrabajador;
                        });
                        $(oculto).val(codigo);
                        $(mostrado).val(opcion);
                    },
                    error: function(){
                        alert('Error Processing your Request 6!!');
                    }
                });
            } else {
                $(oculto).val("");
                $(mostrado).val("");
            }
        };

        // CADA QUE ESCOGE DESTIANTARIO OBTIENE RESPONSABLE
        $('#iCodOficinaO').on('change',function () {
            obtenerResponsable('#iCodOficinaO','#codResponsableiO','#nomResponsableO');
        });
    </script>
    <script src="includes/dropzone.js"></script>
    <script>
        /* Inital */
        $(function(){
            // LoadDocumentosEnProceso();

            var sidenav = $(".sidenav");

            ContenidosTipo('idTipoRemitente',30);

            $("#idTipoRemitente").change(function(){
                var persona = $("#idTipoRemitente").val();

                $("#nNumDocumento").removeAttr("disabled");

                switch (persona) {
                    case '60': //Natural
                        $(".pJuridica").hide();
                        $("label[for='nNumDocumento']").html("Número de DNI");
                        $("#nNumDocumento").attr('maxlength','8');
                        $('#nNumDocumento').attr('data-persona', 'natural');
                        $("span.nNumDocumento").html("Hasta 8 dígitos");
                        //console.log("Natural");
                        break;
                    case '62': //Jurídica
                        $(".pJuridica").show();
                        $("label[for='nNumDocumento']").html("Número de RUC");
                        $('#nNumDocumento').attr('data-persona', 'juridica');
                        $("#nNumDocumento").attr('maxlength','11');
                        $("span.nNumDocumento").html("Hasta 11 dígitos");
                        break;

                    default:
                        break;
                }

                getPersonaInfo();

            });

            CargaDocumentosGrupo();

            ListarOficinaEspecialistasDestino();
        });

        function CargaDocumentosGrupo (){
                let agrupado = $("#cDocumentosEnTramite").val();                

                if (agrupado == "0") {
                    $("#btnDerivar").hide();
                    $("#btnDevolver").hide();
                    $("#btnArchivar").hide();
                    $("#btnRetroceder").hide();
                } else {
                    $.ajax({
                        url: "ajax/ajaxConsultaRegreso.php",
                        method: "POST",
                        data: {
                            cAgrupado: agrupado
                        },
                        datatype: "json",
                        success: function (response) {
                            let respuesta = $.parseJSON(response);
                            if(respuesta.regreso === 'si'){
                                $("#btnDevolver").show();
                                $("#btnArchivar").show();
                                $("#btnRetroceder").show();
                            } else {
                                $("#btnDevolver").hide();
                                $("#btnArchivar").hide();
                                $("#btnRetroceder").hide();
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al consultar si puede regresar!');
                            M.toast({html: "Error al consultar"});
                        }
                    });
                }
                tblDocumentos.ajax.reload();

                <?php
                if (isset($informacion->movimientoP)){
                    ?> let esRspta = 1;<?php
                } else {
                    ?> let esRspta = 0;<?php
                }
                ?>

                //let esRspta = <?//=$informacion->movimientoP??0?>;
                if (esRspta == 0) {
                    ListarReferenciaAgrupado(<?=$informacion->agrupado??'0'?>);
                    ListarAnexosAgrupado(<?=$informacion->agrupado??'0'?>);
                } else {
                    // if (agrupado == <?//=$_GET['trabajarAgrupado']??0?>) {
                        listarReferencias(JSON.stringify(<?=json_encode($tramitesRspt??'0')?>));
                        let tramites = <?=json_encode($tramitesRspt??'0')?>;
                        if (tramites != 0){
                            $.each(tramites, function (i,val) {
                                listarAnexosReferencia(val.iCodTramiteRef,'iCodTramite');
                            });
                        }
                    // }
                }
        };

        function ListarReferenciaAgrupado(codAgrupado){
            const cReferenciaSelect = $('#cReferencia');
            cReferenciaSelect.val(null).trigger('change');
            $.ajax({
                url: "ajax/referenciaDisponiblesAgrupado.php",
                method: "POST",
                data: {
                    cAgrupado: codAgrupado
                },
                datatype: "json",
                success: function (respuesta) {
                    let datos = $.parseJSON(respuesta);
                    $.each(datos, function( index, value ) {
                        let option = new Option(value.text, value.id, true, true);
                        cReferenciaSelect.append(option).trigger('change');
                    });
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al obtener referencia!');
                    deleteSpinner();
                    M.toast({html: "Error al obtener referencia"});
                }
            });
        }

        function ContenidosTipo(idDestino, codigoTipo,defaultSelect = 0, arrayQuitar = []){
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
                method: "POST",
                async: false,
                data: {codigo: codigoTipo},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    destino.append('<option value="0">Seleccione</option>');
                    let quitarNum = arrayQuitar.length;
                    if (quitarNum == 0){
                        $.each(data, function( key, value ) {
                            destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                    } else {
                        $.each(data, function( key, value ) {
                            if (!arrayQuitar.includes(value.codigo)){
                                destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                            }
                        });
                    }
                    if (defaultSelect != 0){
                        $('#'+idDestino+' option[value="'+defaultSelect+'"]').prop('selected',true);
                    }                    
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        function ListarAnexosAgrupado(codAgrupado){
            $.ajax({
                url: "ajax/anexosDisponiblesAgrupado.php",
                method: "POST",
                data: {
                    cAgrupado: codAgrupado
                },
                datatype: "json",
                success: function (respuesta) {
                    let datosRespuesta = $.parseJSON(respuesta.trim());
                    $.each(datosRespuesta, function (i,value) {
                        if (value.cNombreOriginal.trim() == '') {
                            let nom = value.cNombreNuevo.split('/');
                            var nombre = nom[nom.length-1];
                        } else {
                            var nombre = value.cNombreOriginal;
                        };
                        InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo);
                    });
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al registrar el documento!');
                    deleteSpinner();
                    M.toast({html: "Error al registrar el documento"});
                }
            });
        }

        //tabla de grupos de documentos
        var tblDocumentos = $('#TblDocumentos').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            ajax:{
                'url': 'registerDoc/Documentos.php',
                'type': 'POST',
                'datatype': 'json',
                'data': function (d) {
                    d.Evento = "ListarDocumentosUsuario";
                    d.Agrupado =$("#cDocumentosEnTramite").val();
                }
            },
            "drawCallback": function( settings ) {
                var api = this.api();
                if (api.data().length==0){
                    $("#TablaDocumentosAcumulados").hide();
                    $("#btnDerivar").hide();
                }else{
                    $("#TablaDocumentosAcumulados").show();
                    $("#btnDerivar").show();
                }

                $('.tooltipped').tooltip();
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'tipoDoc', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'cCodificacion', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'nCud', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'cAsunto', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'cObservaciones', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'fFecRegistro', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'responsableFirma', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'NomflgEncriptado', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'datosDespacho', 'autoWidth': true, 'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        let botones = '';
                        if(full.tipo === 'proyecto'){
                            if(full.iCodOficinaFirmante === sesionOficina && (full.iCodTrabajadorFirmante === sesionTrabajador || sesionDelegado === 1 )) {
                                botones += '<button type="button" data-accion="generar" data-tooltip="Registrar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Generar"><i class="far fa-fw fa-file"></i></button>';
                            }
                            
                            botones += '<button type="button" data-accion="editar" data-tooltip="Editar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Editar"><i class="fas fa-fw fa-pencil-alt"></i></button>'
                                + '<button type="button" data-accion="pre-visualizacion" data-tooltip="Ver" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-fw fa-eye"></i></button>';
                            if (full.nFlgTipoDoc === 3) {
                                botones += '<button type="button" data-accion="completarDespacho" data-tooltip="Completar Despacho" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Completar Despacho"><i class="fas fa-box"></i></button>';
                            }

                            botones += '<button type="button" data-accion="anular" data-tooltip="Anular" class="btn btn-sm btn-link danger tooltipped" data-position="bottom" name="Anular"><i class="fas fa-fw fa-trash-alt"></i></button>';
                        }
                        if(full.tipo === 'tramite'){
                            if(full.firma === 0){
                                if(full.iCodOficinaFirmante === sesionOficina && (full.iCodTrabajadorFirmante === sesionTrabajador || sesionDelegado === 1)) {
                                    botones += '<button type="button" data-accion="firmar" data-tooltip="Firmar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Firmar"><i class="fas fa-fw fa-signature fa-fw left"></i></button>';
                                } else {
                                    botones  += '<button type="button" data-accion="visar" data-tooltip="Visar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Visar"><i class="fas fa-fw fa-check left"></i></button>';
                                }
                            }
                            botones += '<button type="button" data-accion="ver-anexos" data-tooltip="Ver Anexos" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver-Anexos"><i class="fas fa-fw fa-paperclip fa-fw left"></i></button>';
                            botones += '<button type="button" data-accion="ver" data-tooltip="Ver" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-fw fa-eye"></i></button>';
                            if(full.iCodOficinaFirmante === sesionOficina && (full.iCodTrabajadorFirmante === sesionTrabajador || sesionDelegado === 1) && full.nFlgEnvio == 0) {
                                botones += '<button type="button" data-accion="invalidar" data-tooltip="Dejar sin efecto" class="btn btn-sm btn-link danger tooltipped" data-position="bottom" name="invalidar"><i class="fas fa-fw fa-trash-alt"></i></button>';
                            }
                        }
                        return botones
                    }, 'className': 'text'
                }
            ]
        });

        $('#TblDocumentos tbody').on('click', 'button', function (event) {
            let fila = tblDocumentos.row($(this).parents('tr'));
            let dataFila = fila.data();
            let accion = $(this).attr("data-accion");
            switch (accion) {
                case 'editar':
                    $.ajax({
                        url: 'registerDoc/Documentos.php',
                        method : 'POST',
                        datatype: 'json',
                        data: {
                            Evento : "ObtenerDatosDocumentos",
                            codigo : dataFila.codigo,
                            tipo : dataFila.tipo,
                            agrupado : dataFila.cAgrupado,
                        },
                        success: function (response) {
                            let data = $.parseJSON(response);
                            // llena los datos en el formulario
                            $('#cCodTipoTra option[value="'+data.nFlgTipoDoc+'"]').prop('selected',true);
                            $('#cCodTipoTra').formSelect();
                            formularioTipoDestinatario(data.nFlgTipoDoc);
                            tiposDocumentos(data.nFlgTipoDoc,data.cCodTipoDoc);
                            $('#cCodTipoDoc').attr('onChange','');

                            if(data.nFlgTipoDoc == '3' && data.cCodTipoDoc == '13'){
                                $("#nombreDestinoExternocol").css("display","none");
                                $("#nombreDestinoEntidadMREcol").css("display","block");
                            }

                            if (data.fFecPlazo != null) {
                                let instanceCalendar = M.Datepicker.getInstance($('#fFecPlazo'));
                                let fecPlazo = new Date(data.fFecPlazo.date);
                                instanceCalendar.setDate(fecPlazo);
                                $('#fFecPlazo').attr("placeholder",data.fFecPlazo.date);
                            }

                            $('#cAsunto').val(data.cAsunto).next().addClass('active');

                            $('#cObservaciones').val(data.cObservaciones).next().addClass('active');

                            if(data.flgSigo == 1){
                                $('input[name="flgSigo"]').prop('checked',true);
                            }
                            if(data.flgEncriptado == 1){
                                $('input[name="flgEncriptado"]').prop('checked',true);
                            }

                            if (CKEDITOR.instances.editorOficina.getData()){
                                CKEDITOR.instances.editorOficina.setData('');
                            }
                            CKEDITOR.instances.editorOficina.setData(data.cCuerpoDocumento);

                            listarDestinatarios(data.destinatarios,data.nFlgTipoDoc);

                            listarReferencias(data.cReferencia);

                            tblAnexos.rows().remove().draw(false);
                            listarAnexos (data.cAnexos, data.cAnexosImprimibles);
                            $("#cCodigo").val(dataFila.codigo);
                            $("#cTipo").val(dataFila.tipo);

                            //activa boton para guardar cambios
                            $("#btnGuardarCambios").css("display","inline-block");
                            $(fila.node()).find('button[name="Editar"]').css('display','none');
                            $("#btnValidacionAgregar").css("display","none");
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al obtener los datos!');
                            deleteSpinner();
                            M.toast({html: "Error al obtener los datos"});
                        }
                    });
                    break;

                case 'pre-visualizacion':
                    $.ajax({
                        url: 'registerDoc/Documentos.php',
                        method : 'POST',
                        datatype: 'json',
                        data: {
                            Evento : "ObtenerDatosDocumentos",
                            codigo : dataFila.codigo,
                            tipo : dataFila.tipo,
                            agrupado : dataFila.cAgrupado,
                        },
                        success: function (response) {
                            let datos = $.parseJSON(response);
                            $.ajax({
                                url: "previsualizacion-pdf.php",
                                method: "POST",
                                dataType : "text",

                                data: datos,
                                success: function (respuesta) {
                                    let datos = respuesta;
                                    let ifr = $("#modalPrevisualizacion iframe");
                                    ifr.attr('src','data:application/pdf;base64,' + datos);
                                    let instance = M.Modal.getInstance($("#modalPrevisualizacion"));
                                    instance.open();
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al obtener el documento!');
                                    M.toast({html: "Error al obtener el documento!"});
                                }
                            });
                        }
                    });

                    break;

                case 'anular':
                    $.confirm({
                        title: '¿Esta seguro de anular el proyecto?',
                        content: 'Este proceso no se puede deshacer.',
                        buttons: {
                            Cancelar: function () {
                                $.alert('Proceso de anulación cancelada');
                            },
                            Si: {
                                text: 'Anular',
                                btnClass: 'red',
                                action: function() {
                                    getSpinner();
                                    $.ajax({
                                        url: "registerDoc/Documentos.php",
                                        method: "POST",
                                        data: {
                                            Evento: 'AnularDocumento',
                                            tipo: dataFila.tipo,
                                            codigo: dataFila.codigo
                                        },
                                        datatype: "json",
                                        success: function () {
                                            console.log('Proyecto Anulado!');
                                            M.toast({html: "Proyecto Anulado"});
                                            tblDocumentos.ajax.reload();
                                        },
                                        error: function (e) {
                                            console.log(e);
                                            console.log('Error al anular el proyecto!');
                                            deleteSpinner();
                                            M.toast({html: "Error al anular el proyecto"});
                                        }
                                    });
                                }
                            }
                        }
                    });
                    break;

                case 'completarDespacho':
                    $("#IdProyectoDespacho").val(dataFila.codigo);
                    $("#ObservacionesDespacho").val('');
                    $('#datosEnvioFisico').css('display','block');
                    if (dataFila.cCodTipoDoc != 13){
                        $.ajax({
                            url: 'registerDoc/Documentos.php',
                            method : 'POST',
                            async: false,
                            datatype: 'json',
                            data: {
                                Evento : "ObtenerDatosDocumentos",
                                codigo : dataFila.codigo,
                                tipo : dataFila.tipo,
                                agrupado : dataFila.cAgrupado,
                            },
                            success: function (response) {
                                let datos = $.parseJSON(response);
                                datos = $.parseJSON(datos.destinatarios);
                                datos = datos[0];
                                $('#formDatosDespacho #NombreDespacho').val(datos.nomRemitente).next().addClass('active');
                                $('#formDatosDespacho #RucDespacho').val(datos.nroDocumento).next().addClass('active');
                                ObtenerDatosSedeDespacho(datos.IdSede);
                            }
                        });
                    } else {
                        $.ajax({
                            cache: false,
                            url: "ajax/ajaxBuscarEntidadMRE.php",
                            method: "POST",
                            async: false,
                            data: {IdEntidadMRE : dataFila.IdRemitente},
                            datatype: "json",
                            success : function(response) {
                                response = JSON.parse(response);
                                $('#formDatosDespacho #NombreDespacho').val(response.nombre).next().addClass('active');
                            }
                        });
                    }

                    var rucDespacho = $("#RucDespacho").val();

                    if (rucDespacho == null || rucDespacho == ''){
                        ContenidosTipo('IdTipoEnvio','12',0,[72]);
                    } else {
                        $.ajax({
                            url: 'registerDoc/Documentos.php',
                            method: "POST",
                            async: false,
                            data: {
                                'Evento': 'ConsultarRucInteroperabilidad',
                                'Ruc': rucDespacho
                            },
                            success: function (data) {
                                data = JSON.parse(data);
                                if (data.MessageResult != '-1'){
                                    $.ajax({
                                        url: 'registerDoc/Documentos.php',
                                        method: "POST",
                                        async: false,
                                        data: {
                                            'Evento': 'ConsultarDocPermitidosInteroperabilidad'
                                        },
                                        success: function (datos) {
                                            let permite = false;
                                            datos = JSON.parse(datos);
                                            $.each(datos.ListResult, function (i,value) {
                                                if (dataFila.tipoDoc.trim().toUpperCase() == value.vnomtipdoctra) {
                                                    permite = true;
                                                }
                                            });
                                            if (permite){
                                                ContenidosTipo('IdTipoEnvio','12',72);
                                                $('#IdTipoEnvio').trigger('change');
                                            } else {
                                                ContenidosTipo('IdTipoEnvio','12',0,[72]);
                                            }
                                        }
                                    });
                                } else {
                                    ContenidosTipo('IdTipoEnvio','12',0,[72]);
                                }
                            }
                        });
                        // $.ajax({
                        //     url: RutaSIGTIInteroperabilidad + "Api/Interoperabilidad/Entidad/SSO_GET_0003?vrucent="+ rucDespacho,
                        //     method: "POST",
                        //     datatype: "application/json",
                        //     success: function (data) {
                        //         if (data.MessageResult != '-1'){
                        //             $.ajax({
                        //                 url: RutaSIGTIInteroperabilidad + "Api/Interoperabilidad/tramite/SSO_GET_0001",
                        //                 method: "GET",
                        //                 datatype: "application/json",
                        //                 success: function (datos) {
                        //                     let permite = false;
                        //                     $.each(datos.ListResult, function (i,value) {
                        //                         if (dataFila.tipoDoc.trim().toUpperCase() == value.vnomtipdoctraField) {
                        //                             permite = true;
                        //                         }
                        //                     });
                        //                     if (permite){
                        //                         ContenidosTipo('IdTipoEnvio','12');
                        //                     } else {
                        //                         ContenidosTipo('IdTipoEnvio','12', [72]);
                        //                     }
                        //                 }
                        //             });
                        //         } else {
                        //             ContenidosTipo('IdTipoEnvio','12', [72]);
                        //         }
                        //     }
                        // });

                    }
                    var elemDespacho = document.querySelector('#modalDespacho');
                    var instanceDespacho = M.Modal.getInstance(elemDespacho);
                    instanceDespacho.options.dismissible = false;
                    instanceDespacho.open();
                    break;

                case 'generar':
                    if (dataFila.flgDatosDespacho === 1) {
                        $.confirm({
                            title: '¿Esta seguro de querer generar un documento del proyecto?',
                            content: 'El documento una vez creado ya no puede ser cambiada la información',
                            buttons: {
                                Si: function () {
                                    getSpinner('Cargando...');
                                    $.ajax({
                                        url: "registerDoc/Documentos.php",
                                        method: "POST",
                                        data: {
                                            Evento: 'GenerarDocumento',
                                            codigo: dataFila.codigo
                                        },
                                        datatype: "json",
                                        success: function (response) {
                                            let json = $.parseJSON(response);
                                            if($("#nCud").val() == ''){
                                                let data = new Object();
                                                data = JSON.parse(window.atob($("#dtrUri").val()));
                                                data.cudP = json['cud'];
                                                let nuevoDatos = window.btoa(JSON.stringify(data));
                                                let ruta = "registroOficina.php?dtr="+nuevoDatos;
                                                setTimeout(function(){window.location = ruta});
                                            } else{                                                
                                                let elems = document.querySelector('#modalDoc');
                                                let instance = M.Modal.getInstance(elems);
                                                deleteSpinner();

                                                $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);
                                                instance.open();
                                                console.log('Documento generado!');
                                                M.toast({html: "Documento generado"});
                                                tblDocumentos.ajax.reload();
                                            }
                                        },
                                        error: function (e) {
                                            console.log(e);
                                            console.log('Error al generar el documento!');
                                            deleteSpinner();
                                            M.toast({html: "Error al generar el documento"});
                                        }
                                    });
                                },
                                No: function () {
                                    $.alert('Generación de documento cancelada');
                                }
                            }
                        });
                    } else{
                        $.alert('Falta completar datos de despacho!');
                    }
                    break;

                case 'visar':
                    if(dataFila.flgEncriptado == 1 && !(dataFila.iCodOficinaFirmante == sesionOficina && (dataFila.iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
                        $.confirm({
                            columnClass: 'col-md-4 col-md-offset-4',
                            title: 'Validación permiso',
                            content: 'Contraseña: <input type="password">',
                            buttons: {
                                Validar: function(){
                                    var val = this.$content.find('input').val();
                                    if(val.trim() != ''){
                                        $.ajax({
                                            url: "ajax/obtenerDocFirma.php",
                                            method: "POST",
                                            data: {
                                                codigo: dataFila.codigo
                                            },
                                            datatype: "json",
                                            success: function (response) {
                                                let json = $.parseJSON(response);
                                                if (json.length !== 0){
                                                    console.log('¡Documento obtenido!');
                                                    $("#nombreDocument").val(json['nombre'].trim());
                                                    $("#signedDocument").val(json['url'].trim());
                                                    $("#idtra").val(dataFila.codigo);
                                                    $("#tipo_f").val('v');
                                                    $("#nroVisto").val(dataFila.visto);
                                                    initInvoker('W');
                                                } else {
                                                    console.log('¡No se pudo obtener el documento!');
                                                    M.Toast({html:'¡No se pudo obtener el documento!'});
                                                }
                                            },
                                            error: function (e) {
                                                console.log(e);
                                                console.log('Error al obtener el documento!');
                                                M.toast({html: "Error al obtener el documento"});
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
                            url: "ajax/obtenerDocFirma.php",
                            method: "POST",
                            data: {
                                codigo: dataFila.codigo
                            },
                            datatype: "json",
                            success: function (response) {
                                let json = $.parseJSON(response);
                                if (json.length !== 0){
                                    console.log('¡Documento obtenido!');
                                    $("#nombreDocument").val(json['nombre'].trim());
                                    $("#signedDocument").val(json['url'].trim());
                                    $("#idtra").val(dataFila.codigo);
                                    $("#tipo_f").val('v');
                                    $("#nroVisto").val(dataFila.visto);
                                    initInvoker('W');
                                } else {
                                    console.log('¡No se pudo obtener el documento!');
                                    M.Toast({html:'¡No se pudo obtener el documento!'});
                                }
                            },
                            error: function (e) {
                                console.log(e);
                                console.log('Error al obtener el documento!');
                                M.toast({html: "Error al obtener el documento"});
                            }
                        });
                    }                    
                    break;

                case 'firmar':
                    if (dataFila.tipoDoc.trim() === 'NOTA INFORMATIVA') {
                        $.ajax({
                            url: "ajax/obtenerDocFirma.php",
                            method: "POST",
                            data: {
                                codigo: dataFila.codigo
                            },
                            datatype: "json",
                            success: function (response) {
                                let json = $.parseJSON(response);
                                if (json.length !== 0){
                                    let informacion =
                                        '<dl><dt style="font-weight:700">Asunto</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.cAsunto.trim()+'</dd>'+
                                        '<dt style="font-weight:700">Documento</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.tipoDoc.trim()+' '+dataFila.cCodificacion.trim()+'</dd>'+
                                        '<dt style="font-weight:700">CUD</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.nCud.trim()+'</dd></dl>';
                                    console.log('¡Documento obtenido!');
                                    $("#nombreDocument").val(json['nombre'].trim());
                                    $("#signedDocument").val(json['url'].trim());
                                    $("#idtra").val(dataFila.codigo);
                                    $("#tipo_f").val('f');
                                    $("#nroVisto").val(dataFila.visto);
                                    $("#datosDoc").val(informacion);
                                    initInvoker('W');
                                } else {
                                    console.log('¡No se pudo obtener el documento!');
                                    M.Toast({html:'¡No se pudo obtener el documento!'});
                                }
                            },
                            error: function (e) {
                                console.log(e);
                                console.log('Error al obtener el documento!');
                                M.toast({html: "Error al obtener el documento"});
                            }
                        });
                    } else {
                        $.confirm({
                            title: '¿Desea enviarlo para visto?',
                            content: '',
                            buttons: {
                                Si: function () {
                                    M.Modal.getInstance($("#modalDevolver")).open();
                                },
                                No: function () {
                                    $.ajax({
                                        url: "ajax/obtenerDocFirma.php",
                                        method: "POST",
                                        data: {
                                            codigo: dataFila.codigo
                                        },
                                        datatype: "json",
                                        success: function (response) {
                                            let json = $.parseJSON(response);
                                            if (json.length !== 0){
                                                let informacion =
                                                    '<dl><dt style="font-weight:700">Asunto</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.cAsunto.trim()+'</dd>'+
                                                    '<dt style="font-weight:700">Documento</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.tipoDoc.trim()+' '+dataFila.cCodificacion.trim()+'</dd>'+
                                                    '<dt style="font-weight:700">CUD</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.nCud.trim()+'</dd></dl>';
                                                console.log('¡Documento obtenido!');
                                                $("#nombreDocument").val(json['nombre'].trim());
                                                $("#signedDocument").val(json['url'].trim());
                                                $("#idtra").val(dataFila.codigo);
                                                $("#tipo_f").val('f');
                                                $("#nroVisto").val(dataFila.visto);
                                                $("#datosDoc").val(informacion);
                                                initInvoker('W');
                                            } else {
                                                console.log('¡No se pudo obtener el documento!');
                                                M.Toast({html:'¡No se pudo obtener el documento!'});
                                            }
                                        },
                                        error: function (e) {
                                            console.log(e);
                                            console.log('Error al obtener el documento!');
                                            M.toast({html: "Error al obtener el documento"});
                                        }
                                    });
                                },
                                Cancelar: function () {
                                    console.log('Firma cancelada');
                                }
                            }
                        });
                    }
                    break;

                case 'invalidar':
                    $.confirm({
                        title: '¿Esta seguro de dejar sin efecto el documento?',
                        content: 'Perderá el número correlativo de su documentación. Este proceso no puede deshacerse.',
                        buttons: {
                            Cancelar: function () {
                                $.alert('Proceso de anulación cancelada');
                            },
                            Si: {
                                text: 'Dejar sin efecto',
                                btnClass: 'red',
                                action: function(){
                                    $.ajax({
                                        url: "registerDoc/Documentos.php",
                                        method: "POST",
                                        data: {
                                            Evento: 'AnularTramiteGenerado',
                                            codigo: dataFila.codigo
                                        },
                                        datatype: "json",
                                        error: function (e) {
                                            console.log(e);
                                            console.log('Error al anular el documento!');
                                            deleteSpinner();
                                            M.toast({html: "Error al anular el documento"});
                                        },
                                        success: function (e) {
                                            console.log('Documento invalidado!');
                                            tblDocumentos.ajax.reload();
                                            M.toast({html: "Documento invalidado correctamente "});
                                        }
                                    });
                                }
                            }
                        }
                    });
                    break;

                case 'ver':
                    if(dataFila.flgEncriptado == 1 && !(dataFila.iCodOficinaFirmante == sesionOficina && (dataFila.iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
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
                                            data: {'codigo': dataFila.codigo, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    VerDocumentoTabla(dataFila.codigo);
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
                        VerDocumentoTabla(dataFila.codigo);
                    }     
                    break;

                case 'ver-anexos':
                    if(dataFila.flgEncriptado == 1 && !(dataFila.iCodOficinaFirmante == sesionOficina && (dataFila.iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
                        permite = $.confirm({
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
                                            data: {'codigo': dataFila.codigo, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    VerAnexosDocumentoTabla(dataFila.codigo);
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
                        VerAnexosDocumentoTabla(dataFila.codigo);
                    } 
                    break;
            }
        });

        function VerDocumentoTabla(id){
            $.ajax({
                url: "ajax/obtenerDoc.php",
                method: "POST",
                    data: {
                        codigo: id
                    },
                    datatype: "json",
                            success: function (response) {
                                let json = $.parseJSON(response);
                                if (json.length !== 0){
                                    console.log('¡Documento obtenido!');
                                    $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);
                                    $('#modalDoc').modal('open');
                                } else {
                                    console.log('¡No se pudo obtener el documento!');
                                    M.toast({html:'¡No se pudo obtener el documento!'});
                                }
                            },
                            error: function (e) {
                                console.log(e);
                                console.log('Error al obtener el documento!');
                                M.toast({html: "Error al obtener el documento"});
                    }
            });
        }

        function VerAnexosDocumentoTabla(id){
                    $.ajax({
                        cache: false,
                        url: "verAnexo.php",
                        method: "POST",
                        data: { codigo: id },
                        datatype: "json",
                        success: function (response) {
                            $('#modalAnexo div.modal-content ul').html('');
                            var json = eval('(' + response + ')');
                            if(json.tieneAnexos == '1') {
                                let cont = 1;
                                json.anexos.forEach(function (elemento) {
                                    $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-fw fa-file-alt"></i></span><a class="btn-link" href="http://'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                                    cont++;
                                })
                            }else{
                                $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-fw fa-info"></i></span>El documento no tiene Anexos.</li>');
                            }
                            $('#modalAnexo').modal('open');
                        }
                    });
        }

        $("#btnGuardarDatosDespacho").on('click', function(e){
            e.preventDefault();

            let estado = true;
            if ($("#IdTipoEnvio").val() != 0) {
                if ($("#IdTipoEnvio").val() == 19 || $("#IdTipoEnvio").val() == 21){
                    if ($("#DireccionDespacho").val().trim() == ''){
                        estado = false;
                        $.alert("Falta dirección del despacho");
                    } else if ($("#DepartamentoDespacho").val() == null || $("#DepartamentoDespacho").val() == '') {
                        estado = false;
                        $.alert("Falta departamento")
                    } else if ($("#ProvinciaDespacho").val() == null || $("#ProvinciaDespacho").val() == '') {
                        estado = false;
                        $.alert("Falta provincia")
                    } else if ($("#DistritoDespacho").val() == null || $("#DistritoDespacho").val() == '') {
                        estado = false;
                        $.alert("Falta distrito")
                    }
                } else if ($("#IdTipoEnvio").val() == 72){
                    if ($("#UnidadOrganicaDstIOT").val().trim() == ''){
                        estado = false;
                        $.alert("Falta unidad orgánica destino");
                    } else if ($("#PersonaDstIOT").val().trim() == '') {
                        estado = false;
                        $.alert("Falta persona destino")
                    } else if ($("#CargoPersonaDstIOT").val().trim() == '') {
                        estado = false;
                        $.alert("Falta cargo de persona destino")
                    }
                } else if ($("#IdTipoEnvio").val() == 19) {
                    if ($("#ObservacionesDespacho").val().trim() == ''){
                        estado = false;
                        $.alert("Falta observación");
                    }
                }
            } else {
                estado = false;
                $.alert("Falta tipo de despacho");
            }


            if (estado == true) {
                getSpinner();
                let data = $('#formDatosDespacho').serializeArray();
                let formData = new FormData();
                $.each(data, function (key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento", "GuardarDatosDespacho");
                $.ajax({
                    url: "registerDoc/Documentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success: function (cAgrupado) {
                        console.log('Registrado correctamente!');
                        let elemento = document.querySelector('#modalDespacho');
                        M.Modal.getInstance(elemento).close();
                        deleteSpinner();
                        M.toast({html: "Datos guardados correctamente"});
                        tblDocumentos.ajax.reload();

                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al guardar datos para el despacho!');
                        deleteSpinner();
                        M.toast({html: "Error al guardar datos para el despacho"});
                    }
                });
            }
        });

        // TABLA DE DESTINATARIOS internos
        var tblDestinatarios = $('#TblDestinatarios').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblDestinatarios").hide();
                }else{
                    $("#TblDestinatarios").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'nomOficina', 'autoWidth': true,"width": "30%", 'className': 'text-left' },
                { 'data': 'nomResponsable', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                { 'data': 'nomCopia', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "20px"
                },
            ]
        });

        $("#TblDestinatarios tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            if(accion === 'eliminar'){
                tblDestinatarios.row($(this).parents('tr')).remove().draw(false);
            }
        });

        $("#btnAgregarDestinatario").click(function(){
            // SI ES PARA ESPECIALISTA U OFICINA
            if($('#flgDelegar').is(':checked')){
                if ($("#responsableE").val() == ""){
                    $.alert('Falta seleccionar especialista');
                    return false;
                } else {
                    var icodOficina = $("#CodOficinaE").val();
                    var nomOficina = $("#nomOficinaE").find(':selected').text();
                    var icodResponsable = $("#responsableE").val();
                    var nomResponsable = $("#responsableE").find(':selected').text().split('(')[0];
                    var iCodPerfil = 4;
                }
            } else {
                if ($("#iCodOficinaO").val() == ""){
                    $.alert('Falta seleccionar oficina');
                    return false
                } else {
                    var icodOficina = $("#iCodOficinaO").val();
                    var nomOficina = $("#iCodOficinaO").find(':selected').text();
                    var icodResponsable = $("#codResponsableiO").val();
                    var nomResponsable = $("#nomResponsableO").val();
                    var iCodPerfil = 3;
                }
            }

            let destinatarios = new Object();
            destinatarios.icodOficina= icodOficina;
            destinatarios.nomOficina=nomOficina;
            destinatarios.icodResponsable= icodResponsable;
            destinatarios.nomResponsable= nomResponsable;
            destinatarios.cCopia = $("#cCopia").val();
            destinatarios.nomCopia = $("#cCopia").find(":selected").text();
            destinatarios.iCodPerfil = iCodPerfil;

            //VALIDAR SI YA ESTA INGRESADO
            let data = tblDestinatarios.data();
            let estado = false;
            $.each(data, function (i, item) {
                if (destinatarios.icodOficina == item.icodOficina && destinatarios.icodResponsable == item.icodResponsable ) {
                    estado = true;
                }
            });
            if (!estado) {
                tblDestinatarios.row.add(destinatarios).draw();
            } else {
                $.alert("El Destinatorio ya está agreado");
            }
        });

        //tabla destinos externos
        var tblDestinosExternos = $('#TblDestinosExternos').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblDestinosExternos").hide();
                }else{
                    $("#TblDestinosExternos").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'nomRemitente', 'autoWidth': true,"width": "10%", 'className': 'text-left' },
                { 'data': 'nroDocumento', 'autoWidth': true,"width": "10%", 'className': 'text-left' },
                { 'data': 'cDireccion', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'preFijo', 'autoWidth': true, "width": "5%",'className': 'text-left' },
                { 'data': 'nombreResponsable', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                { 'data': 'cargoResponsable', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                { 'data': 'mostrarDireccion', 'autoWidth': true, "width": "5%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "20px"
                },
            ]
        });

        $("#TblDestinosExternos tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            if(accion === 'eliminar'){
                tblDestinosExternos.row($(this).parents('tr')).remove().draw(false);
            }
        });

        $("#btnAgregarDestinoExterno").click(function(){
            let destino = new Object();
            if($("#cCodTipoTra").val() == '3' && $("#cCodTipoDoc").val() == '13'){
                if ($("#nombreDestinoEntidadMRE").val() == null){
                    return $.alert("Falta seleccionar entidad");
                }

                destino.iCodRemitente= $("#nombreDestinoEntidadMRE").select2('data')[0].id;
                destino.nomRemitente= $("#nombreDestinoEntidadMRE").select2('data')[0].text;
            } else {
                if ($("#nombreDestinoExterno").val() == null){
                    return $.alert("Falta seleccionar entidad");
                }

                destino.iCodRemitente= $("#nombreDestinoExterno").select2('data')[0].id;
                destino.nomRemitente= $("#nombreDestinoExterno").select2('data')[0].text;

                if ($("#dependenciasDestinoExterno select").length != 0){
                    for (var elem of $("#dependenciasDestinoExterno select")){
                        if ($(elem).val() != ''){
                            destino.iCodRemitente = $(elem).val();
                            destino.nomRemitente += " - " + $(elem).find("option:selected").text();
                        } else {
                            break;
                        }
                    }
                }
if ($("#direccionDestinoExterno").val() == '' || $("#direccionDestinoExterno").val() == null){
                return $.alert("Falta seleccionar dirección");
            }
            }
            if ($("#flgMostrarDireccion:checked").length == 1){
                destino.flgMostrarDireccion = 0;
                destino.mostrarDireccion = 'No';
            } else {
                destino.flgMostrarDireccion = 1;
                destino.mostrarDireccion = 'Si';
            }

            

            destino.nroDocumento = $("#nroDocDestinoExterno").val();
            destino.cDireccion = $("#direccionDestinoExterno option:selected").text();
            destino.IdSede = $("#direccionDestinoExterno").val();
            destino.preFijo = $("#prefijoNombre").val();
            destino.nombreResponsable= $("#responsableDestinoExterno").val();
            destino.cargoResponsable= $("#cargoResponsableDestinoExterno").val();

            //VALIDAR SI YA ESTA INGRESADO
            let data = tblDestinosExternos.data();
            let estado = false;
            $.each(data, function (i, item) {
                if (destino.iCodRemitente == item.iCodRemitente && destino.IdSede == item.IdSede) {
                    estado = true;
                }
            });
            if (!estado) {
                tblDestinosExternos.row.add(destino).draw();
            } else {
                $.alert("El destino ingresado ya está agreado");
            }
        });

        //tabla de anexos
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
                        let anexoEnviar = '';
                        anexoEnviar = '<p class="'+full.codigoAnexo+'"><label><input type="checkbox" class="filled-in '+full.codigoAnexo+'" data-accion="enviar" checked="checked" name="cAnexos[]" value="'+full.codigoAnexo+'"><span></span></label></p>';
                        return anexoEnviar;
                    }, 'className': 'center-align',"width": "5%"
                },
                {
                    'render': function (data, type, full, meta) {
                        let anexoImprimir = '';
                        anexoImprimir = '<p class="'+full.codigoAnexo+'"><label><input type="checkbox" class="filled-in '+full.codigoAnexo+'" checked="checked" data-accion="imprimir" name="cAnexosImprimibles[]" value="'+full.codigoAnexo+'"><span></span></label></p>';
                        return anexoImprimir;
                    }, 'className': 'center-align',"width": "5%"
                },
                {
                    'render': function (data, type, full, meta) {
                        let nombreAnexo = '';
                        nombreAnexo = '<a href="http://'+full.rutaAnexo+'" target="_blank">'+full.nombreAnexo+'</a>';
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
            .on('change', 'input', function () {
                let accion = $(this).attr("data-accion");
                let valorAnexo = $(this).val();
                switch (accion){
                    case 'imprimir':
                        if ($(this).prop("checked") === true){
                            $("input[value='"+valorAnexo+"'][data-accion='enviar']").prop("checked", true)
                        }
                        break;
                    case 'enviar':
                        if ($(this).prop("checked") === false){
                            $("input[value='"+valorAnexo+"'][data-accion='imprimir']").prop("checked", false)
                        }
                        break;
                    default:
                        break;
                }
            });

        function InsertarAnexo(codigo, nombre, ruta, imprimible = true) {
            let anexo = new Object();
            anexo.codigoAnexo = codigo;
            anexo.nombreAnexo = nombre;
            anexo.rutaAnexo = ruta;

            let estado = false;
            let data = tblAnexos.data();
            //console.log(data);
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

        function obtenerDatosFormulario () {
            // Obtiene todos los datos del registro
            CKEDITOR.instances.editorOficina.updateElement();
            let data = $('#frmRegistro').serializeArray();
            let formData = new FormData();
            $.each(data, function(key, el) {
                formData.append(el.name, el.value);
            });
            formData.append("Evento","registrarProyecto");
            if ($('#cCodTipoTra').val() === '2'){
                var tabla = tblDestinatarios.data();
            } else {
                var tabla = tblDestinosExternos.data();
            }
            $.each(tabla, function (i, item) {
                $.each(item, function (key,value) {
                    formData.append("DataDestinatario[" + i + "]["+key+"]", value);
                });
            });
            return formData;
        }

        $("#btnAgregarProyecto").on("click",function (e) {
            let datos = obtenerDatosFormulario();
            getSpinner('Guardando documento');
            $.ajax({
                url: "registerDoc/regProyecto.php",
                method: "POST",
                data: datos,
                processData: false,
                contentType: false,
                datatype: "json",
                success: function (cAgrupado) {
                    console.log('Registrado correctamente!');
                    M.toast({html: "Registrado correctamente"});
                    let data = new Object();
                    if ($("#dtrUri").val() != ''){
                        data = JSON.parse(window.atob($("#dtrUri").val()));
                        if ($("#cDocumentosEnTramite").val() == '0') {
                            data.agrupado = cAgrupado;
                        }
                        data.flgPendientes = 1;
                    }else {                        
                        data.agrupado = cAgrupado;
                        data.flgPendientes = 1;
                    }                  
                    let nuevoDatos = window.btoa(JSON.stringify(data));
                    let ruta = "registroOficina.php?dtr="+nuevoDatos;
                    setTimeout(function(){window.location = ruta});
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al registrar el documento!');
                    deleteSpinner();
                    M.toast({html: "Error al registrar el documento"});
                    let elemento = document.querySelector('#modalResponsableFirma');
                    M.Modal.getInstance(elemento).close();
                }
            });
        });

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
                    done("El anexo ya está agregado");
                    $.alert("El anexo" + file.name +" ya está agregado");
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

                $("#btnValidacionAgregar").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if(validarFormulario()){
                        let queuedFiles = myDropzone.getQueuedFiles();
                        if (queuedFiles.length > 0) {
                            $.alert('¡Documentos pendientes de subir!');
                        }else{
                            ListarResponsableFirma($("#cCodTipoDoc").val());
                            let elemento = document.querySelector('#modalResponsableFirma');
                            M.Modal.getInstance(elemento).open();
                        }
                    }
                });

                $("#btnGuardarCambios").on('click',function (e) {
                    e.preventDefault();
                    if(validarFormulario()){
                        let queuedFiles = myDropzone.getQueuedFiles();
                        if (queuedFiles.length > 0) {
                            $.alert('¡Documentos pendientes de subir!');
                        }else{
                            let datos = obtenerDatosFormulario();
                            datos.append("Evento","GuardarDatos");
                            getSpinner('Guardando documento');

                            $.ajax({
                                url: "registerDoc/Documentos.php",
                                method: "POST",
                                data: datos,
                                processData: false,
                                contentType: false,
                                datatype: "json",
                                success: function () {
                                    console.log('Datos guardados correctamente!');
                                    M.toast({html: "Datos guardados correctamente"});
                                    let ruta = "registroOficina.php?dtr="+$("#dtrUri").val();
                                    setTimeout(function(){ window.location = ruta; });
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al guardar los cambios!');
                                    deleteSpinner();
                                    M.toast({html: "Error al guardar los cambios"});
                                }
                            });
                        }
                    }
                });
                this.on("sendingmultiple", function (file, xhr, formData) {
                    let agrupado = $("#cDocumentosEnTramite").val();
                    formData.append('agrupado',agrupado);
                });
                this.on("successmultiple", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        InsertarAnexo(fila.codigo, fila.original, fila.nuevo);
                    });
                    this.removeAllFiles();
                });
            }
        });

        $("#btnDerivar").on("click", function(e) {
            derivarDocumentos();
        });

        function derivarDocumentos () {
            let filasEnviar = [];
            let paraJefeProyecto = [];
            let paraJefeVisado = [];
            let salir = 0;
            let tabla = tblDocumentos.data();

            $.each(tabla, function (i, filas) {
                if(salir == 1){
                    return false;
                }
                if (sesionPerfil == 18 || sesionPerfil == 19 || sesionPerfil == 20) {
                    if (filas.tipo == 'proyecto'){
                        paraJefeProyecto.push(filas);
                        if (filas.flgDatosDespacho == 0){
                            $.alert('No se puede derivar, falta datos de despacho');
                            salir += 1;
                        }
                    } else {
                        if(filas.firma == 0){
                            paraJefeVisado.push(filas)
                        } else {
                            if(filas.nFlgEnvio == 0){
                                filasEnviar.push(filas);
                            }
                        }
                    }
                } else {
                    if (filas.iCodOficinaFirmante == sesionOficina && filas.iCodTrabajadorFirmante == sesionTrabajador) {
                        if (filas.tipo == 'proyecto'){
                            $.alert('No se puede derivar, proyecto pendiente');
                            salir += 1;
                        } else {
                            if(filas.firma == 0){
                                $.alert('No se puede derivar, tiene documento pendiente de firma');
                                salir += 1;
                            } else {
                                if(filas.nFlgEnvio == 0){
                                    filasEnviar.push(filas);
                                }
                            }
                        }
                    } else {
                        if (filas.tipo == 'proyecto'){
                            paraJefeProyecto.push(filas);
                            if (filas.flgDatosDespacho == 0){
                                $.alert('No se puede derivar, falta datos de despacho');
                                salir += 1;
                            }
                        } else {
                            if(filas.firma == 0){
                                paraJefeVisado.push(filas);
                            }
                        }
                    }
                }
            });

            if (salir == 0) {
                getSpinner();
                if (filasEnviar.length !== 0) {
                    let paraJefe = false;
                    $.each(filasEnviar, function (key, fil) {
                        let modelo = new Object();
                        modelo.Evento = "DerivarDestino";
                        modelo.codigo = fil.codigo;
                        modelo.tipoDoc = fil.nFlgTipoDoc;
                        if (fil.nFlgTipoDoc == 2 && fil.cCodTipoDoc == 12){
                            paraJefe = true;
                        }
                        $.ajax({
                            method: "POST",
                            cache: false,
                            url: "registerDoc/Documentos.php",
                            data: modelo,
                            datatype: "json",
                            success: function (response) {
                                console.log('Derivado correctamente!');
                                M.toast({html: "'Derivado correctamente!"});
                            },
                            error: function (e) {
                                console.log(e);
                                console.log('Error al derivar!');
                                M.toast({html: "Error al derivar"});
                            }
                        });
                    });                    
                } else if (paraJefeVisado.length !== 0) {
                    let modelo = new Object();
                    modelo.Evento = "DerivarJefeVisado";
                    modelo.codigo = paraJefeVisado[0].codigo;
                    $.ajax({
                        method: "POST",
                        cache: false,
                        url: "registerDoc/Documentos.php",
                        data: modelo,
                        datatype: "json",
                        success: function (response) {
                            console.log('Derivado correctamente!');
                            M.toast({html: "'Derivado correctamente!"});
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar"});
                        }
                    });
                } else if (paraJefeProyecto.length !== 0) {
                    let modelo = new Object();
                    modelo.Evento = "DerivarJefeProyecto";
                    modelo.codigos = paraJefeProyecto;
                    $.ajax({
                        method: "POST",
                        cache: false,
                        url: "registerDoc/Documentos.php",
                        data: modelo,
                        datatype: "json",
                        success: function (response) {
                            console.log('Derivado correctamente!');
                            M.toast({html: "'Derivado correctamente!"});
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar"});
                        }
                    });
                } else {
                    let modelo = new Object();
                    modelo.Evento = "DerivarJefeInmediato";
                    modelo.cAgrupado = $("#cDocumentosEnTramite").val();
                    $.ajax({
                        method: "POST",
                        cache: false,
                        url: "registerDoc/Documentos.php",
                        data: modelo,
                        datatype: "json",
                        success: function (response) {
                            console.log('Derivado correctamente!');
                            M.toast({html: "'Derivado correctamente!"});
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar"});
                        }
                    });
                }
                setTimeout(function(){ window.location = "registroOficina.php"; });
            }
        }

        /*Obtener Documentos Creados */
        // function LoadDocumentosEnProceso(){
        //     let grupos = new Object();
        //     grupos.Evento="DocumentosAgrupados";
        //     $.ajax({
        //         method: "POST",
        //         cache: false,
        //         url: "registerDoc/Documentos.php",
        //         data: grupos,
        //         datatype: "json",
        //         success: function (response) {
        //             var data = $.parseJSON(response);
        //             $("#cDocumentosEnTramite").empty();
        //             $.each(data, function (keys, datos) {
        //                 $("#cDocumentosEnTramite").append($("<option></option>").val("0").html(".:: Grupo Nuevo ::."));
        //                 $.each(datos, function (key, entry) {
        //                     var codigo= <?//=$_GET["agrupado"]??"-1" ?>;
        //                     if(codigo == "0" && key == (datos.length-1) ){
        //                         $("#cDocumentosEnTramite").append($("<option selected></option>").val(entry['Valor']).html(entry['Texto']));
        //                     }else
        //                     if(codigo == entry['Valor']){
        //                         $("#cDocumentosEnTramite").append($("<option selected></option>").val(entry['Valor']).html(entry['Texto']));
        //                     }else{
        //                         $("#cDocumentosEnTramite").append($("<option></option>").val(entry['Valor']).html(entry['Texto']));
        //                     }
        //                 });

        //             });
        //             $('#cDocumentosEnTramite').formSelect();
        //             $("#cDocumentosEnTramite").change();
        //         }
        //     });
        // }

        $("#cCodTipoDoc").on("change", function (e) {
            e.preventDefault();
            if ($("#cCodigo").val() === '' && $("#cTipo").val() === '') {
                plantilla();
            }

            if($("#cCodTipoTra").val() == '3' && $("#cCodTipoDoc").val() == '13'){
                $("#nombreDestinoExternocol").css("display","none");
                $("#nombreDestinoEntidadMREcol").css("display","block");
                $("#opcionalFields").css("display","none");
            }else{
                ListarOficinaPorDocumento($("#cCodTipoDoc").val());
                $("#nombreDestinoExternocol").css("display","block");
                $("#nombreDestinoEntidadMREcol").css("display","none");
                $("#opcionalFields").css("display","block");
            }
        });

        function plantilla () {
            const codTipoDoc = $('#cCodTipoDoc').val();
            if (CKEDITOR.instances.editorOficina.getData('')) {
                CKEDITOR.instances.editorOficina.setData('');
            }
            $.ajax({
                cache: false,
                method: "POST",
                url: "ajax/parametrosPlantilla.php",
                data: {codigo: codTipoDoc},
                datatype: "json",
                success: function (response) {
                    var res = eval('(' + response + ')');
                    if (res.flag == 1) {
                        console.log('Tiene parametros');
                        const param = eval('(' + res.editables + ')');
                        let htmltext = '';
                        param.forEach(function (valor) {
                            htmltext +="<div class='subtitle'><h3 contenteditable='false' >"+valor+"</h3><div ><p class='clase-par'></p></div></div>"
                        });
                        CKEDITOR.instances.editorOficina.insertHtml(htmltext);
                    } else {
                        console.log('No tiene parametros');
                    }
                }
            });
        }

        function tiposDocumentos(codDoc,selecionado = ''){
            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxTipoDocumento.php',
                method: 'POST',
                data: {tipoDoc: codDoc},
                datatype: 'json',
                success: function (data) {
                    $('#cCodTipoDoc').empty().append('<option value="&nbsp;">Seleccione</option>');
                    let documentos = JSON.parse(data);
                    $.each(documentos, function (key,value) {
                        if (value.codigo == selecionado){
                            $('#cCodTipoDoc').append('<option value="'+value.codigo+'" selected>'+value.nombre+'</option>');
                        } else {
                            $('#cCodTipoDoc').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        }
                    });
                    $('#cCodTipoDoc').formSelect();
                }
            });
        }

        function ImprimirSugerencia(datos){
            let html = '<label>Sugerencia: </label>';
            html += '<span data-id="'+datos.IdEntidad+'" style="cursor: pointer;text-decoration: underline;">'+datos.NombreEntidad+'</span>';
            $('#sugerenciasDestinatario').append(html);
        }

        function SugerenciaDestinatario(embajada = false){
            if($("#nCud").length != 0){
                $.ajax({
                cache: 'false',
                url: 'registerDoc/Documentos.php',
                method: 'POST',
                data: {'Evento': 'BuscarEntidadSugerencia', 'cud': $("#nCud").val()},
                datatype: 'json',
                success: function (data) {
                    let datos = JSON.parse(data);
                    if (datos.tiene){
                        if(!embajada){
                            $.each(datos.datos, function(key,value) {
                                //ObtenerDatosEntidad(resultado.IdRemitente,ImprimirSugerencia);
                                ObtenerDatosEntidad(value.iCodRemitente,ImprimirSugerencia);
                            });
                        }
                        $('#sugerenciasDestinatario').css('display','block');
                    } else {
                        $('#sugerenciasDestinatario').css('display','none').empty();
                    }
                }
            });
            }

            
        }

        function formularioTipoDestinatario(tipoDestino){
            if(tipoDestino == 3) {
                SugerenciaDestinatario();
                $('#destinoExterno').css('display','block');
                $('#destinatario').css('display','none');
            } else {
                $('#sugerenciasDestinatario').css('display','none').empty();
                $('#destinoExterno').css('display','none');
                $('#destinatario').css('display','block');
            }
        }

        $("#sugerenciasDestinatario").on("click", "span", function (e) {
            let valor = $(this).attr("data-id");
            let text =  $(this).text();
            let newOption = new Option(text, valor, false, false);
            $('#nombreDestinoExterno').empty().append(newOption).trigger('change').trigger('select2:select');
            $('#sugerenciasDestinatario').css('display','none').empty();
        });

        $('select[name="cCodTipoTra"]').on('change',function (e) {
            let docvalor = $('select[name="cCodTipoTra"]').val();
            formularioTipoDestinatario(docvalor);
            e.preventDefault();
            tiposDocumentos(docvalor);
        });

        //SI ES PARA ESPECIALISTA O NO
        $('#flgDelegar').on('change',function (e) {
            e.preventDefault();
            if(!$('#Proyecto').is(':checked')) {
                if ($(this).is(':checked')) {
                    $('#destinatario #areaOficina #paraOficinas').css('display', 'none');
                    $('#destinatario #areaOficina #paraEspecialistas').css('display', 'block');
                } else {
                    $('#destinatario #areaOficina #paraEspecialistas').css('display', 'none');
                    $('#destinatario #areaOficina #paraOficinas').css('display', 'block');
                }
            } else {
                $.alert({
                    title: 'Advertencia!',
                    content: 'No se puede enviar proyectos a especialistas'
                });
                $(this).prop('checked', false);
            }
        });

        // CARGA REPSONSABLE OFICINA
        $("#iCodOficinaFirma").on("change",function (e) {
            $("#iCodOficinaFirma").formSelect();
            e.preventDefault();
            if($("#iCodOficinaFirma").val() !== ''){
                obtenerResponsable('#iCodOficinaFirma','#iCodTrabajadorFirma','#nomResponsableFirmar');
                $("#iCodPerfilFirma").val(3);
            }
        });

        $("#codOficinaDevolver").on("change",function (e) {
            e.preventDefault();
            $.ajax({
                url: "ajax/ajaxTrabajadorVisto.php",
                method: "POST",
                data: {
                    codOficina: $("#codOficinaDevolver").val()
                },
                datatype: "json",
                success: function (response) {
                    $("#codEspecialistaDevolver").empty();
                    let data = $.parseJSON(response);
                    $.each(data,function (key,value) {
                        $('#codEspecialistaDevolver').append('<option value="'+value.cod+'">'+value.texto+'</option>');
                    });
                    let elemTraVis = document.getElementById('codEspecialistaDevolver');
                    M.FormSelect.init(elemTraVis, {dropdownOptions: {container: document.body}});
                }
            });
        });

        $("#btnDevolver").on("click",function (e) {
            e.preventDefault();
            M.Modal.getInstance($("#modalDevolver")).open();
        });

        $("#btnEnvioDevolver").on("click", function (e) {
            e.preventDefault();
            if($("#codEspecialistaDevolver").val() === '') {
                $.alert("Falta selecionar especialista para el visado!")
            } else {
                $.confirm({
                    title: '¿Está seguro de querer devolver el grupo?',
                    content: '',
                    buttons: {
                        Si: function () {
                            $.ajax({
                                url: "registerDoc/Documentos.php",
                                method: "POST",
                                data: {
                                    Evento: 'Devolver',
                                    cTrabajadorDevolver: $("#codEspecialistaDevolver").val(),
                                    obsDevolver: $("#obsDevolver").val(),
                                    cAgrupado: $("#cDocumentosEnTramite").val(),
                                    cOficinaDevolver: $("#codOficinaDevolver").val()
                                },
                                datatype: "json",
                                success: function (response) {
                                    console.log('Documentos enviados correctamente!');
                                    M.Modal.getInstance($("#modalDevolver")).close();
                                    M.toast({html: "Documentos enviados"});
                                    //setTimeout(function () { window.location = "registroOficina.php?agrupado="+$("#cDocumentosEnTramite").val(); });
                                    setTimeout(function () { window.location = "registroOficina.php" });
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al enviar el grupo!');
                                    M.toast({html: "Error al enviar el grupo!"});
                                }
                            });
                        },
                        No: function () {
                            $.alert('Envío cancelado!');
                        }
                    }
                });
            }
        });

        $("#btnArchivar").on("click", function (e) {
            e.preventDefault();
            M.Modal.getInstance($("#modalArchivar")).open();
        });

        $("#btnEnviarArchivar").on('click', function(e) {
            e.preventDefault();
            parametros = {
                iCodAgrupado: $("#cDocumentosEnTramite").val(),
                cObservacionesArchivar : $('#motArchivar').val()
            };
            $.ajax({
                cache: false,
                url: "ajax/ajaxArchivarRegOfi.php",
                method: "POST",
                data: parametros,
                datatype: "json",
                success : function (response) {
                    M.toast({html: '¡Grupo archivado!'});
                    setTimeout(function(){ window.location = 'registroOficina.php' })
                },
                error: function (response) {
                    console.log(e);
                    console.log('Error al archivar el grupo!');
                    M.toast({html: "Error al archivar"});
                }
            });
        });

        // $("#antecedentesCud").on('click', function(e) {     
        //     if($("#nCud").length != 0){
        //         $.ajax({
        //             cache: false,
        //             url: "registerDoc/Documentos.php",
        //             method: "POST",
        //             data: {'Evento':'BuscarDocumentosAntecedentes', 'Cud': $("#nCud").val()},
        //             datatype: "json",
        //             success : function () {

        //                 let elem = document.querySelector('#modalAntecedentesCud');
        //                 let instance = M.Modal.init(elem, {dismissible:false});
        //                 instance.close();
        //             },
        //             error: function (e) {
        //                 console.log(e);
        //                 console.log('Error al archivar el grupo!');
        //                 M.toast({html: "Error al archivar"});
        //             }
        //         });
        //     }          
        // });

        $("#btnRetroceder").on("click", function (e) {
            e.preventDefault();
            parametros = {
                iCodAgrupado: $("#cDocumentosEnTramite").val()
            };
            $.ajax({
                cache: false,
                url: "ajax/ajaxRetrocederMovimiento.php",
                method: "POST",
                data: parametros,
                datatype: "json",
                success : function () {
                    setTimeout(function(){ window.location = "registroOficina.php"; })
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al archivar el grupo!');
                    M.toast({html: "Error al archivar"});
                }
            });
        });

        $("#btnCerrarDocFirmado").on("click", function (e) {
            e.preventDefault();
            $.confirm({
                title: '¿Desea derivar o continuar trabajando?',
                content: '',
                buttons: {
                    Derivar: function () {
                        derivarDocumentos();
                    },
                    Continuar: function () {
                        tblDocumentos.ajax.reload();
                        let elem = document.querySelector('#modalDocFirmado');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        CargaDocumentosGrupo($("#cDocumentosEnTramite").val());
                        instance.close();
                        //setTimeout(function(){ window.location = "registroOficina.php?agrupado="+$("#cDocumentosEnTramite").val(); });
                    }
                }
            });
        });

        $('#IdTipoEnvio').on('change', function (e) {
            if ($('#IdTipoEnvio').val() === '19' || $('#IdTipoEnvio').val() === '21') {
                $('#datosEnvioFisico').css('display','block');
                $('#datosEnvioInteroperabilidad').css('display','none');
            } else if ($('#IdTipoEnvio').val() === '20') {
                $('#datosEnvioFisico').css('display','none');
                $('#datosEnvioInteroperabilidad').css('display','none');
            } else if ($('#IdTipoEnvio').val() === '72') {
                $('#datosEnvioFisico').css('display','none');
                $('#datosEnvioInteroperabilidad').css('display','block');
            }
        });

        $('#DepartamentoDespacho').on('change',function (e) {
            e.preventDefault();
            if ($('#DepartamentoDespacho').val() !== ''){
                $.ajax({
                    cache: false,
                    async: false,
                    url: "ajax/ajaxProvincias.php",
                    method: "POST",
                    data: {codDepa : $('#DepartamentoDespacho').val()},
                    datatype: "json",
                    success: function (data) {
                        data = JSON.parse(data);
                        $('#ProvinciaDespacho').empty().append('<option value="">Seleccione</option>');
                        $.each( data.info, function( key, value ) {
                            $('#ProvinciaDespacho').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        var elempro = document.getElementById('ProvinciaDespacho');
                        M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
                        $('#DistritoDespacho').empty();
                        var elempro = document.getElementById('DistritoDespacho');
                        M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
                    }
                });
            }
        });

        $('#ProvinciaDespacho').on('change',function (e) {
            e.preventDefault();
            if ($('#ProvinciaDespacho').val() !== '' && $('#DepartamentoDespacho').val() !== ''){
                $.ajax({
                    cache: false,
                    async: false,
                    url: "ajax/ajaxDistritos.php",
                    method: "POST",
                    data: {codDepa : $('#DepartamentoDespacho').val(), codPro: $('#ProvinciaDespacho').val()},
                    datatype: "json",
                    success: function (data) {
                        data = JSON.parse(data);
                        $('#DistritoDespacho').empty().append('<option value="">Seleccione</option>');
                        $.each( data.info, function( key, value ) {
                            $('#DistritoDespacho').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        var elemdis = document.getElementById('DistritoDespacho');
                        M.FormSelect.init(elemdis, {dropdownOptions: {container: document.body}});
                    }
                });
            }
        });

        function ListarOficinaEspecialistasDestino() {
            $.ajax({
                cache: false,
                url: "ajax/ajaxListarOficinas.php",
                method: "POST",
                data: {'Evento' : 'ListarOficinasEspecialistasDestino'},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#nomOficinaE').empty();
                    $.each(data, function(key, value) {
                        $('#nomOficinaE').append('<option value="'+value.idOficina+'">'+value.nomOficina+'</option>');
                    });
                    $('#nomOficinaE').formSelect().trigger('change');
                }
            });
        }

        function ListarOficinaPorDocumento(tipoDocumento) {
            $.ajax({
                cache: false,
                url: "ajax/ajaxListarOficinas.php",
                method: "POST",
                data: {'Evento' : 'ListarOficinasDocumento', 'IdTipoDocumento': tipoDocumento},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#iCodOficinaO').empty().append('<option value="">Seleccione Oficina</option>');
                    $.each(data, function(key, value) {
                        $('#iCodOficinaO').append('<option value="'+value.idOficina+'">'+value.nomOficina+'</option>');
                    });
                    $('#iCodOficinaO').formSelect().trigger('change');
                }
            });
        }

        function ListarResponsableFirma(tipoDocumento) {
            $.ajax({
                cache: false,
                url: "ajax/ajaxListarOficinas.php",
                method: "POST",
                data: {'Evento' : 'ListarOficinaResponsableFirma', 'IdTipoDocumento': tipoDocumento},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#iCodOficinaFirma').empty();
                    $.each(data, function(key, value) {
                        $('#iCodOficinaFirma').append('<option value="'+value.IdOficina+'">'+value.NomOficina+'</option>');
                    });
                    $('#iCodOficinaFirma').formSelect().trigger('change');
                }
            });
        }

        $('#nomOficinaE').on('change', function (e) {
            e.preventDefault();
            var idOficina = $('#nomOficinaE').val();
            $('#CodOficinaE').val(idOficina);
            $.ajax({
                cache: false,
                url: "ajax/ajaxTrabajador.php",
                method: "POST",
                data: {'Evento' : 'ListarTrabajadoresPorOficina', 'idOficina': $('#CodOficinaE').val()},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#responsableE').empty().append('<option value="">Seleccione</option>');;
                    $.each(data, function(key, value) {
                        $('#responsableE').append('<option value="'+value.idTrabajador+'">'+value.nomTrabajador+' ( '+ value.nomPerfil +' )</option>');
                    });
                    $('#responsableE').formSelect();
                }
            });
        });

        $("#antecedentesCudDd").on("click",function(e){
            if($("#nCud").length != 0){
                $.ajax({
                    url: 'registerDoc/Documentos.php',
                    method : 'POST',
                    datatype: 'json',
                    data: {
                        'Evento' : "BuscarDocumentosAntecedentes",
                        'cud' : $("#nCud").val()
                    },
                    success: function (data) {
                        let datos = JSON.parse(data);
                        if(datos.tieneAntecendetes){
                            $("#antecedentesCudDdC").empty();
                            let html = '';
                            html += `<li class="collection-header"><h4>Antecedentes al CUD ${$("#nCud").val()}</h4></li>`;
                            
                            $.each(datos.datos, function( key, value ) {
                                html += `
                                <li class="collection-item" data-id="${value.id}" data-flgEncriptado="${value.flgEncriptado}" data-iCodTrabajadorFirmante="${value.iCodTrabajadorFirmante}" data-iCodOficinaFirmante="${value.iCodOficinaFirmante}">
                                    ${value.nombre} | ${value.fecha}
                                    
                                    <div class="secondary-content">
                                        <button type="button" class="btn btn-link" data-action="ver" data-tooltip="Ver" data-position="bottom">
                                            <i class="far fa-fw fa-eye"></i>
                                        </button>
                                `;

                                    if(value.tieneAnexos){
                                        html += ' <button type="button" class="btn btn-link" data-action="anexos" data-tooltip="Anexos" data-position="bottom"><i class="fas fa-fw fa-paperclip fa-fw left"></i></button>';
                                    }
                                
                                    html += `</div>`;
                                html += '</li>';
                            })
                            
                            $("#antecedentesCudDdC").append(html);

                            var elem = document.querySelector('#modalAntecedentes');
                            var instance = M.Modal.init(elem);
                            instance.open();
                        }else {
                            M.toast({html: "No tiene documentos antecedentes"});
                        }                                
                    }
                });
            }         
        });

        $("#antecedentesCudDdC").on("click","li button",function(e){            
            let action = $(this).attr("data-action");
            let id = $(this).closest("li").attr("data-id");
            let flgEncriptado = $(this).closest("li").attr("data-flgEncriptado");
            let iCodOficinaFirmante = $(this).closest("li").attr("data-iCodOficinaFirmante");
            let iCodTrabajadorFirmante = $(this).closest("li").attr("data-iCodTrabajadorFirmante");

            switch(action){
                case 'ver':                  
                    if(flgEncriptado == 1 && !(iCodOficinaFirmante == sesionOficina && (iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
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
                                            data: {'codigo': id, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    VerDocumentoTabla(id);
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
                        VerDocumentoTabla(id);
                    }                    
                    break;

                case 'anexos':
                    if(flgEncriptado == 1 && !(iCodOficinaFirmante == sesionOficina && (iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
                        permite = $.confirm({
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
                                            data: {'codigo': dataFila.codigo, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    VerAnexosDocumentoTabla(id);
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
                        VerAnexosDocumentoTabla(id);
                    }
                    break;
            }
        });

        $("#flujo").on("click",function(e){
            e.preventDefault();    
            if($("#nCud").length != 0){
                // if(values[0] <= 7367){
                //     var documentophp = "flujodoc_old.php"
                // } else{
                //     var documentophp = "flujodoc.php"
                // }
                var documentophp = "flujodoc.php"
                $.ajax({
                    cache: false,
                    url: documentophp,
                    method: "POST",
                    data: {"cud" : $("#nCud").val()},
                    datatype: "json",
                    success : function(response) {
                        $('#modalFlujo div.modal-content').html(response);
                        let elem = document.querySelector('#modalFlujo');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.open();
                    }
                }); 
            }                        
        });
    </script>
    </body>
    </html>

    <?php
}else{

    header("Location: ../index-b.php?alter=5");
}
?>