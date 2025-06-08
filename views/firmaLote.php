<?php
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");
include_once("../conexion/parametros.php");

$pageTitle = "Firma en lote";
$activeItem = "firmaLote.php";
$navExtended = true;

$nNumAno    = date("Y");
if($_SESSION['CODIGO_TRABAJADOR']!=""){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>

    <!--Main layout-->
    <main>
        <form name="frmRegistro" id="frmRegistro" target="_blank" enctype="multipart/form-data"> 
            <div class="navbar-fixed actionButtons">
                <nav>
                    <div class="nav-wrapper">
                        <ul id="nav-mobile" class="">
                            <li>
                                <a id="btnFirmaLot" class="btn btn-flat btn-primary tooltipped" data-position="top" data-tooltip="Agregar">
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                        <path d="M 6 0 L 6 48 L 34 48 C 35.671875 49.257813 37.753906 50 40 50 C 45.511719 50 50 45.511719 50 40 C 50 35.914063 47.519531 32.394531 44 30.84375 L 44 14.59375 L 43.71875 14.28125 L 29.71875 0.28125 L 29.40625 0 Z M 8 2 L 28 2 L 28 16 L 42 16 L 42 30.21875 C 41.351563 30.085938 40.6875 30 40 30 C 34.488281 30 30 34.488281 30 40 C 30 42.253906 30.765625 44.324219 32.03125 46 L 8 46 Z M 30 3.4375 L 40.5625 14 L 30 14 Z M 40 32 C 44.429688 32 48 35.570313 48 40 C 48 44.429688 44.429688 48 40 48 C 35.570313 48 32 44.429688 32 40 C 32 35.570313 35.570313 32 40 32 Z M 39 35 L 39 39 L 35 39 L 35 41 L 39 41 L 39 45 L 41 45 L 41 41 L 45 41 L 45 39 L 41 39 L 41 35 Z"/>
                                    </svg>
                                    <span>Firmar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            
        <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="card hoverable">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Datos del documento</legend>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Archivo</span>
                                                    <input type="file" id="archivo">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text">
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </main>

    <input type="hidden" id="idDigital" value="" />
    <div id="addComponent"></div>

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>

    <script type="text/javascript" src="https://dsp.reniec.gob.pe/refirma_invoker/resources/js/client.js"></script>
    <!-- <script type="text/javascript" src="invoker/client.js"></script> -->
    <script type="text/javascript" src="../conexion/global.js"></script>
    <script type="text/javascript">

        var documentName_ = null;

        window.addEventListener('getArguments', function (e) {
            type = e.detail;
            if(type === 'W'){
                ObtieneArgumentosParaFirmaDesdeLaWeb(); // Llama a getArguments al terminar.
            }else if(type === 'L'){
                ObtieneArgumentosParaFirmaDesdeArchivoLocal(); // Llama a getArguments al terminar.
            }
        });

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

        function ObtieneArgumentosParaFirmaDesdeLaWeb(){
            var formData = new FormData();

            formData.append('Evento','ObtenerArgumentos');
            formData.append('Tipo','W');
            formData.append('Archivo',document.getElementById('archivo').files[0]);

            getSpinner('Guardando documento');
            $.ajax({
                async: false,
                url: "registroFirmaLote.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                datatype: "json",
                success: function (response) {
                    var respuesta = JSON.parse(response);
                    $("#idDigital").val(respuesta.id);
                    deleteSpinner();
                    dispatchEventClient('sendArguments', respuesta.args);
                },
                error: function (e) {
                    deleteSpinner();
                    toastr.warning('Error en la aplicación', 'Mensaje del Sistema', { 'progressBar': true });
                }
            });
        }

        function MiFuncionOkWeb(){
            $.post("registroFirmaLote.php", {Evento: "DescargarFirmado", IdDigital: $("#idDigital").val()})
                .done((r) => {
                    console.log(r);
                });
        }

        function MiFuncionCancel(){
            alert("El proceso de firma digital fue cancelado.");
        }
    </script>

    <script>
        var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
        var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;
        var sesionTrabajadorSigcti = <?=$_SESSION['idUsuarioSigcti']??0?>;

        $("#btnFirmaLot").on("click", function(e){
            initInvoker('W');
            // var formData = new FormData();

            // formData.append('Evento','FirmaLote');
            // formData.append('Archivo',document.getElementById('archivo').files[0]);

            // getSpinner('Guardando documento');
            // $.ajax({
            //     async: false,
            //     url: "registroFirmaLote.php",
            //     method: "POST",
            //     data: formData,
            //     processData: false,
            //     contentType: false,
            //     datatype: "json",
            //     success: function (response) {
            //         deleteSpinner();
            //         alert("registro");              
            //     },
            //     error: function (e) {
            //         deleteSpinner();
            //         toastr.warning('Error en la aplicación', 'Mensaje del Sistema', { 'progressBar': true });
            //     }
            // });
        });

    </script>
    </body>
    </html>

    <?php
}else{

    header("Location: ../index-b.php?alter=5");
}
?>