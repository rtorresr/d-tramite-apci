<?php
  include_once("config/parametros.php");
  include_once("config/datosConexion.php");

  $id = "0";
  if (isset($_GET['c'])){
      $id = trim(base64_decode($_GET['c']));
  }  
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Bienvenido">
    <title>APCI - Mesa de partes digital</title>
    <link rel="apple-touch-icon-precomposed" href="https://cdn.apci.gob.pe/dist/images/apple-touch-icon-152x152.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="https://cdn.apci.gob.pe/dist/images/mstile-144x144.png">
    <link rel="icon" href="https://cdn.apci.gob.pe/dist/images/favicon-32x32.png" sizes="32x32">
    <link href="https://cdn.apci.gob.pe/dist/styles/app.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css" type="text/css" rel="stylesheet">
    <link href="dist/styles/app.css" type="text/css" rel="stylesheet">
</head>

<body class="theme-yellow dashboard sidebarless contained bg-white" id="noSidebar">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="icon-facebook-fill" viewbox="0 0 50 50">
            <path
                d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z">
            </path>
        </symbol>
        <symbol id="icon-dribbble-fill" viewbox="0 0 50 50">
            <path
                d="M22.58 28c.42 1.97 1.05 3.93 1.72 5.18-1.1 1.8-2.4 2.82-3.68 2.82C17.29 36 17 33.36 17 32.12c0-.19-.06-5.12 3.12-5.12 1.26 0 2.23.81 2.23.81C22.42 27.88 22.5 27.94 22.58 28zM26.29 14.05c.47.66.75 2.69.75 7.45 0 2.53-.12 5.52-1.05 8.09-.62-2-1.03-4.7-1.03-8.22C24.96 18.13 25.68 15.09 26.29 14.05z">
            </path>
            <path
                d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M35.93,28.84c-0.76,2.34-2.89,8.14-6.11,8.14c-1.02,0-2.39-0.04-3.7-1.32c-1.47,2-3.3,3.34-5.47,3.34C16.06,39,14,35.51,14,32.05c0-3.67,1.88-8,6.13-8c0.72,0,1.38,0.13,1.95,0.33c-0.08-1-0.08-1.8-0.08-3C22,21.27,22.04,11,26.17,11C28.14,11,30,12.77,30,21.5c0,3.12-0.53,7.65-2.38,11.38c0.8,1.04,1.6,1.37,2.13,1.12c1.5-0.72,2.46-3.25,3.36-6.01c0.25-0.75,1.08-1.16,1.85-0.93C35.74,27.3,36.18,28.1,35.93,28.84z">
            </path>
        </symbol>
        <symbol id="icon-linkedin-fill" viewbox="0 0 50 50">
            <path
                d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56c3.97,0,7.19,2.73,7.19,8.26V39z">
            </path>
        </symbol>
        <symbol id="icon-youtube-fill" viewbox="0 0 50 50">
            <path
                d="M44.9,14.5c-0.4-2.2-2.3-3.8-4.5-4.3C37.1,9.5,31,9,24.4,9c-6.6,0-12.8,0.5-16.1,1.2c-2.2,0.5-4.1,2-4.5,4.3C3.4,17,3,20.5,3,25s0.4,8,0.9,10.5c0.4,2.2,2.3,3.8,4.5,4.3c3.5,0.7,9.5,1.2,16.1,1.2s12.6-0.5,16.1-1.2c2.2-0.5,4.1-2,4.5-4.3c0.4-2.5,0.9-6.1,1-10.5C45.9,20.5,45.4,17,44.9,14.5z M19,32V18l12.2,7L19,32z">
            </path>
        </symbol>
        <symbol id="icon-open-book-fill" viewbox="0 0 50 50">
            <path fill="none" stroke-miterlimit="10" stroke-width="2" d="M25 42L25 9"></path>
            <path
                d="M43,8v30c-10,0-18,4-18,4s-8-4-18-4V8H2v35h1c12.612,0,21.506,3.875,21.595,3.914l0.406,0.18l0.404-0.18C25.494,46.875,34.388,43,47,43h1V8H43z">
            </path>
            <path fill="none" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"
                d="M25,9c0,0-8-4-18-4v33c10,0,18,4,18,4s8-4,18-4V5C33,5,25,9,25,9z"></path>
        </symbol>
        <symbol id="icon-default" viewBox="0 0 512 512">
            <path
                d="M156.5,447.7l-12.6,29.5c-18.7-9.5-35.9-21.2-51.5-34.9l22.7-22.7C127.6,430.5,141.5,440,156.5,447.7z M40.6,272H8.5 c1.4,21.2,5.4,41.7,11.7,61.1L50,321.2C45.1,305.5,41.8,289,40.6,272z M40.6,240c1.4-18.8,5.2-37,11.1-54.1l-29.5-12.6 C14.7,194.3,10,216.7,8.5,240H40.6z M64.3,156.5c7.8-14.9,17.2-28.8,28.1-41.5L69.7,92.3c-13.7,15.6-25.5,32.8-34.9,51.5 L64.3,156.5z M397,419.6c-13.9,12-29.4,22.3-46.1,30.4l11.9,29.8c20.7-9.9,39.8-22.6,56.9-37.6L397,419.6z M115,92.4 c13.9-12,29.4-22.3,46.1-30.4l-11.9-29.8c-20.7,9.9-39.8,22.6-56.8,37.6L115,92.4z M447.7,355.5c-7.8,14.9-17.2,28.8-28.1,41.5 l22.7,22.7c13.7-15.6,25.5-32.9,34.9-51.5L447.7,355.5z M471.4,272c-1.4,18.8-5.2,37-11.1,54.1l29.5,12.6 c7.5-21.1,12.2-43.5,13.6-66.8H471.4z M321.2,462c-15.7,5-32.2,8.2-49.2,9.4v32.1c21.2-1.4,41.7-5.4,61.1-11.7L321.2,462z M240,471.4c-18.8-1.4-37-5.2-54.1-11.1l-12.6,29.5c21.1,7.5,43.5,12.2,66.8,13.6V471.4z M462,190.8c5,15.7,8.2,32.2,9.4,49.2h32.1 c-1.4-21.2-5.4-41.7-11.7-61.1L462,190.8z M92.4,397c-12-13.9-22.3-29.4-30.4-46.1l-29.8,11.9c9.9,20.7,22.6,39.8,37.6,56.9 L92.4,397z M272,40.6c18.8,1.4,36.9,5.2,54.1,11.1l12.6-29.5C317.7,14.7,295.3,10,272,8.5V40.6z M190.8,50 c15.7-5,32.2-8.2,49.2-9.4V8.5c-21.2,1.4-41.7,5.4-61.1,11.7L190.8,50z M442.3,92.3L419.6,115c12,13.9,22.3,29.4,30.5,46.1 l29.8-11.9C470,128.5,457.3,109.4,442.3,92.3z M397,92.4l22.7-22.7c-15.6-13.7-32.8-25.5-51.5-34.9l-12.6,29.5 C370.4,72.1,384.4,81.5,397,92.4z">
            </path>
            <circle cx="256" cy="364" r="28">
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="r"
                    values="28;14;28;28;14;28;"></animate>
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="opacity"
                    values="1;0;1;1;0;1;"></animate>
            </circle>
            <path opacity="1"
                d="M263.7,312h-16c-6.6,0-12-5.4-12-12c0-71,77.4-63.9,77.4-107.8c0-20-17.8-40.2-57.4-40.2c-29.1,0-44.3,9.6-59.2,28.7 c-3.9,5-11.1,6-16.2,2.4l-13.1-9.2c-5.6-3.9-6.9-11.8-2.6-17.2c21.2-27.2,46.4-44.7,91.2-44.7c52.3,0,97.4,29.8,97.4,80.2 c0,67.6-77.4,63.5-77.4,107.8C275.7,306.6,270.3,312,263.7,312z">
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="opacity"
                    values="1;0;0;0;0;1;"></animate>
            </path>
            <path opacity="0"
                d="M232.5,134.5l7,168c0.3,6.4,5.6,11.5,12,11.5h9c6.4,0,11.7-5.1,12-11.5l7-168c0.3-6.8-5.2-12.5-12-12.5h-23 C237.7,122,232.2,127.7,232.5,134.5z">
                <animate attributetype="XML" repeatcount="indefinite" dur="2s" attributename="opacity"
                    values="0;0;1;1;0;0;"></animate>
            </path>
        </symbol>
    </svg>
    <div class="preloader"></div>
    <div class="wrapper">
        <header class="main-header bg-primary-dark">
            <div class="container"><a class="brand w-auto d-flex align-items-center" href="index.php"><img
                        src="https://cdn.apci.gob.pe/dist/images/apci__logo--full.svg" alt="alt" height="30"><span
                        class="ml-3">Mesa de partes digital</span></a></div>
        </header>
        <main class="page-wrapper">
            <input type="hidden" value="<?=$id?>" id="id">
            <section class="page-breadcrumb border-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                            <h5 class="mb-0" id="titulo">Registro de documento</h5>
                        </div>
                        <div class="col-lg-8 col-md-8 col-xs-12 align-self-center">
                            <nav class="mt-2 float-md-right float-left" aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 justify-content-end p-0">
                                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page" id="currentPage">Registro de documento</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
            <section class="page-content container">
                <div class="bs-stepper" id="stregistroDoc">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#test-l-1">
                            <button class="step-trigger" id="stregistroDoctrigger1" type="button" role="tab"
                                aria-controls="test-l-1"><span class="bs-stepper-circle">1</span><span
                                    class="bs-stepper-label">Datos del remitente</span></button>
                        </div>
                        <div class="bs-stepper-line"></div>
                        <div class="step" data-target="#test-l-2">
                            <button class="step-trigger" id="stregistroDoctrigger2" type="button" role="tab"
                                aria-controls="test-l-2"><span class="bs-stepper-circle">2</span><span
                                    class="bs-stepper-label">Datos del documento</span></button>
                        </div>
                        <div class="bs-stepper-line" id="linea2"></div>
                        <div class="step" id="step3" data-target="#test-l-3">
                            <button class="step-trigger" id="stregistroDoctrigger3" type="button" role="tab"
                                aria-controls="test-l-3"><span class="bs-stepper-circle">3</span><span
                                    class="bs-stepper-label">Validación de registro</span></button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <div class="bs-stepper-pane" id="test-l-1" role="tabpanel"
                            aria-labelledby="stregistroDoctrigger1">
                            <?php
                        include_once("views/DatosRemitente.php");
                    ?>
                        </div>
                        <div class="bs-stepper-pane" id="test-l-2" role="tabpanel"
                            aria-labelledby="stregistroDoctrigger2">
                            <?php
                        include_once("views/DatosDocumento.php");
                    ?>
                        </div>
                        <div class="bs-stepper-pane" id="test-l-3" role="tabpanel"
                            aria-labelledby="stregistroDoctrigger3">
                            <?php
                        include_once("views/Validacion.php");
                    ?>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="footer text-center"></footer>
        </main>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDisc" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalDiscLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDiscLabel">Términos y condiciones</h5>
            
                </div>
                <div class="modal-body">
                    <p>Mediante el uso del presente Módulo, personas naturales y personas jurídicas tendrán la opción de generar de manera virtual, desde cualquier punto del país, las 24 horas del día y durante los 365 días del año la presentación de documentos electrónicos dirigidos a la APCI, sin la necesidad de acercarse para tal fin a nuestra Mesa de partes digital.</p>
                    <p><b>Política de Tratamiento de Datos y la modalidad de notificación</b></p>
                    <p>&nbsp;&nbsp;&nbsp;<b>Tratamiento de Datos Personales:</b></p>
                    <p>La información personal que se registre está sujeta a lo establecido en la Ley No 29733, Ley de Protección de Datos Personales, y sus modificatorias; y, su Reglamento, aprobado por Decreto Supremo No 003-2013-JUS, y sus modificatorias, en lo que resulte aplicable.</p>
                    <p>&nbsp;&nbsp;&nbsp;<b>Notificaciones realizadas por la APCI:</b></p>
                    <p>Al hacer uso de la Mesa de partes digital de la Agencia Peruana de Cooperación Internacional (APCI), autorizo a partir de la fecha a la APCI para que remita al correo electrónico registrado las notificaciones vinculadas al trámite (procedimiento administrativo, comunicación, entre otros) que realice mi representada ante la APCI, a las cuales mi representada acusará recibo en el plazo máximo de dos (02) días hábiles de que fueron enviadas por la Agencia.</p>
                    <p>El horario de recepción de documentos es de 08:30 hasta las 5:00pm, de Lunes a Viernes.</p>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-light">No acepto</a>
                    <button type="button" class="btn btn-action" data-dismiss="modal">Acepto</button>
                </div>
            </div>
        </div>
    </div


    <!-- Modal -->
    <!-- <div class="modal fade" id="modalDisc" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalDiscLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                        <p>Informamos que la <strong>Mesa de Partes Digital de la Agencia Peruana de Cooperación Internacional (APCI)</strong>
                        se encuentra <strong>temporalmente inhabilitada</strong> debido a problemas técnicos con su servicio de interoperabilidad.</p>
                        <p<><strong>🛠️ El servicio estará nuevamente disponible el lunes 28 a partir de las 5:00 p.m.</strong></p>
                        <p>Mientras tanto, puede remitir sus documentos a través de los siguientes canales alternativos:</p>
                        <ul>
                            <li>
                                📧 <strong>Correo electrónico</strong>: 
                                <a href="mailto:mesadepartes@apci.gob.pe">mesadepartes@apci.gob.pe</a>
                            </li>
                            <li>
                                🏢 <strong>Mesa de Partes Presencial</strong>: Horario de atención:
                                <strong>lunes a viernes, de 08:30 a.m. a 4:30 p.m.</strong>
                            </li>
                        </ul>
                        <p>Agradecemos su comprensión.</p>
                </div>
            </div>
        </div>
    </div> -->





    <div class="modal" tabindex="-1" id="modalDoc">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">             
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link close" type="button" data-dismiss="modal"  aria-label="Close">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmacionSubsanacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmacionLabel">Confirmación de Envío de subsanación</h5>                
                </div>
                <div class="modal-body">
                <p>Se ha enviado satisfactoriamente la subsanación de su expediente, se le enviará un correo de confirmación cuando haya sido recepcionado.<p>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-light">Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmacionSolicitudNuevoTramite" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalConfirmacionSolicitudNuevoTramiteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalConfirmacionSolicitudNuevoTramiteLabel">Confirmación de Envío de Solicitud de Registro de Nuevo Tipo de Trámite</h5>                
                </div>
                <div class="modal-body">
                <p>Su solicitud ha sido registrada satisfactoriamente, se le enviará un correo de confirmación cuando haya sido validado.<p>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-light">Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.apci.gob.pe/dist/scripts/app.lite.js"></script>
    <script src="https://cdn.apci.gob.pe/dist/scripts/vendor/fontawesome-5.12.0/all.min.js"></script>
    <script src="https://cdn.apci.gob.pe/dist/scripts/vendor/datatables-1.10.20/pdfmake.min.js"></script>
    <script src="https://cdn.apci.gob.pe/dist/scripts/vendor/datatables-1.10.20/vfs_fonts.js"></script>
    <script src="https://cdn.apci.gob.pe/dist/scripts/vendor/datatables-1.10.20/datatables.min.js"></script>
    <script src="https://cdn.apci.gob.pe/dist/scripts/vendor/bs-stepper-1.7/bs-stepper.min.js"></script>
    <script src="https://cdn.apci.gob.pe/dist/scripts/vendor/toastr-2.1.4/toastr.min.js"></script>
    <script src="config/parametros.js"></script>
    <script>
    var $ = require('jquery')
    //- var Stepper = require('bs-stepper')    

    var stregistroDoc = null
    //- var stepper2 = null
    //- var stepper3 = null
    //- var stepper4 = null

    document.addEventListener('DOMContentLoaded', function() {
        stregistroDoc = new Stepper(document.querySelector('#stregistroDoc'))
        //- stepper2 = new Stepper(document.querySelector('#stepper2'), {
        //-     linear: false
        //- })
        //- stepper3 = new Stepper(document.querySelector('#stepper3'), {
        //-     linear: false,
        //-     animation: true
        //- })
        //- stepper4 = new Stepper(document.querySelector('#stepper4'))
    })

    $("body").on("change","input[type=file]",function(){
        var actual = this;
        var file = this.files[0];
        $(this).closest("div.custom-file").find("label.custom-file-label").text(file.name);
    });

    $(document).ready(function() {
        getSpinner('Cargando datos...');

        ContenidosTipo('txtTipoDoc', 31, 0, [74, 77]);
        ListarDepartamento('#txtDep');
        $("#txtTipoDoc").trigger("change");
        cudExistente();
        docTupa();

        mostarCamposPorRemitente();  
        
        tblPrincipal = $('#tblPrincipal').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#tblPrincipal").parents("div.boxArchivos").hide();
                    $("#tblPrincipal").parents("fieldset").find("div.subir").show();
                }else{
                    $("#tblPrincipal").parents("div.boxArchivos").show();
                    $("#tblPrincipal").parents("fieldset").find("div.subir").hide();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                {
                    'render': function (data, type, full, meta) {
                        let nombreAnexo = '';
                        nombreAnexo = '<a href="'+url_srv + full.Ruta+'" target="_blank">'+full.NombreArchivo+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "95%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<nav class="nav-actions">'
                                +'<button class="btn btn-sm btn-link text-danger" type="button" data-accion="eliminar"><i class="fas fa-trash"></i></button>'
                                +'</nav>';
                    }, 'className': 'center-align',"width": "5%"
                }
            ]
        });

        $("#tblPrincipal tbody")
            .on('click', 'button', function () {
            var fila = tblPrincipal.row($(this).parents('tr'));
            var dataFila = fila.data();
            var accion = $(this).attr("data-accion");
            switch(accion){
                case 'eliminar':
                    tblPrincipal.row($(this).parents('tr')).remove().draw(false);
                    break;
            }
        });

        tblAnexosSubsanacion = $('#tblAnexosSubsanacion').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#tblAnexosSubsanacion").parents("div.boxArchivos").hide();
                }else{
                    $("#tblAnexosSubsanacion").parents("div.boxArchivos").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                {
                    'render': function (data, type, full, meta) {
                        let nombreAnexo = '';
                        nombreAnexo = '<a href="'+ url_srv + full.Ruta+'" target="_blank">'+full.NombreArchivo+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "95%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<nav class="nav-actions">'
                                +'<button class="btn btn-sm btn-link text-danger" type="button" data-accion="eliminar"><i class="fas fa-trash"></i></button>'
                                +'</nav>';
                    }, 'className': 'center-align',"width": "5%"
                }
            ]
        });

        $("#tblAnexosSubsanacion tbody")
            .on('click', 'button', function () {
            var fila = tblAnexosSubsanacion.row($(this).parents('tr'));
            var dataFila = fila.data();
            var accion = $(this).attr("data-accion");
            switch(accion){
                case 'eliminar':
                    tblAnexosSubsanacion.row($(this).parents('tr')).remove().draw(false);
                    break;
            }
        });

        if ($("#id").val() != 0){
            $.post("../views/ajax/ajaxRegMpv.php", {Accion: "Recuperar", IdMesaPartesVirtual: $("#id").val()})
                .done(function(response){
                    var cargadatos = 1;
                    getSpinner('Cargando datos...');
                    var datos = $.parseJSON(response);

                    if (datos.IdEstado != 90){
                        cargadatos = 0;
                        deleteSpinner();
                        toastr.warning("El expediente no se encuentra en estado 'Observación recibida'!", 'Mensaje del Sistema', { 'progressBar': true });
                        setTimeout(function(){ window.location = "index.php"; },5000);
                    }

                    if (datos.FlgVencimiento == 0){
                        cargadatos = 0;
                        deleteSpinner();
                        toastr.warning("El expediente se encuentra fuera de plazo para ser subsanado!", 'Mensaje del Sistema', { 'progressBar': true });
                        setTimeout(function(){ window.location = "index.php"; },5000);
                    }

                    if (cargadatos == 1){
                        $("#titulo").text("Subsanación de documento");
                        $("#currentPage").text("Subsanación de documento");
                        $("#linea2").hide();
                        $("#step3").hide();
                        $("#segundoBoton").text("Grabar");

                        // REMITENTE
                        $("#idTipoPersona").val(datos.TipoEntidad);
                        mostarCamposPorRemitente();

                        $("#idTipoDocPersonaJuridica").val(datos.IdTipoDocEntidad);
                        $("#txtRUC").val(datos.NumeroDocEntidad);
                        $("#txtDenInst").val(datos.NombreEntidad);

                        if (datos.TipoEntidad == 60){
                            $("#txtTipoDoc").val(datos.IdTipoDocEntidad);
                            $("#txtNumDocEntidad").val(datos.NumeroDocEntidad);
                            $("#txtNombComp").val(datos.NombreEntidad);
                        } else {
                            $("#txtTipoDoc").val(datos.IdTipoDocResponsable);
                            $("#txtNumDocEntidad").val(datos.NumeroDocResponsable);
                            $("#txtNombComp").val(datos.NombreResponsable);
                        }
                        $("#txtTipoDoc").trigger("change");           
                        
                        $("#txtDireccion").val(datos.DireccionEntidad);
                        $("#txtDep").val(String(datos.IdDepartamentoEntidad).padStart(2,"00")).trigger("change");
                        $("#txtProv").val(String(datos.IdProvinciaEntidad).padStart(2,"00")).trigger("change");
                        $("#txtDis").val(String(datos.IdDistritoEntidad).padStart(2,"00"));

                        $("#txtTel").val(datos.TelefonoContacto);
                        $("#txtCorreo").val(datos.CorreoContacto).prop("disabled", true);
                        $("#txtCorreoConf").val(datos.CorreoContacto).prop("disabled", true);

                        //DOCUEMNTO
                        if(datos.FlgTieneCud == 1){
                            $("#cboCudExist").trigger("click");
                            $("#txtNumCud").val(datos.NroCud);
                            $("#txtAnioCud").val(datos.AnioCud);
                        }

                        $("#txtTipoDocumento").val(datos.IdTipoDoc);
                        $("#txtNumDoc").val(datos.NumeroDoc);
                        $("#txtFecDoc").val(datos.FecDocumento.split("-").join("/"));
                        $("#intFilios").val(datos.NumFolios);
                        $("#txtAsunto").val(datos.Asunto);

                        if(datos.FlgEsTupa == 1){
                            // $("#cboEsTupa").prop("checked", true).trigger("click");
                            $("#txtClaseProc").val(5).trigger("change");
                            $("#txtDenProc").val(datos.IdTupa).trigger("change");
                        }

                        $(".subsanacion").show();
                        $.each(datos.Archivos, function (i,fila) {
                            if(fila.IdTipoArchivo == 5){
                                tblPrincipal.row.add(fila).draw();
                            } 
                            if(fila.IdTipoArchivo == 3){
                                tblAnexosSubsanacion.row.add(fila).draw();
                            }                    
                        });
                    }
                    deleteSpinner();
                });
        } else {
            $('#modalDisc').modal('toggle');
        }

        deleteSpinner();
    });

    tblAnexos = $('#tblAnexos').DataTable({
        responsive: true,
        searching: false,
        ordering: false,
        paging: false,
        info: false,
        "drawCallback": function() {
            var api = this.api();
            if (api.data().length === 0){
                $("#TblAnexos").hide();
                $('#anexosDoc').css('display', 'none');
            }else{
                $("#TblAnexos").show();
                $('#anexosDoc').css('display', 'block');
            }
        },
        "language": {
            "url": "dist/scripts/datatables-es_ES.json"
        },
        'columns': [
            { 'className': 'center-align',"width": "5%", 'data': 'name' },
            { 'className': 'center-align',"width": "5%", 'data': 'size' },
            {
                'render': function (data, type, full, meta) {
                    return '<nav class="nav-actions">'
                            +'<button class="btn btn-sm btn-link docView" type="button" data-accion="mostrar"><i class="fas fa-eye"></i></button>'
                            +'<button class="btn btn-sm btn-link text-danger" type="button" data-accion="eliminar"><i class="fas fa-trash"></i></button>'
                            +'</nav>';
                }, 'className': 'center-align',"width": "5%"
            },
        ]
    });

    $("#tblAnexos tbody")
        .on('click', 'button', function () {
        var fila = tblAnexos.row($(this).parents('tr'));
        var dataFila = fila.data();
        var accion = $(this).attr("data-accion");
        switch(accion){
            case 'eliminar':
            tblAnexos.row($(this).parents('tr')).remove().draw(false);
            break;
            case 'mostrar':          

            var extension = dataFila.name.split('.').pop().toUpperCase();
            if(extension != 'PDF'){
                file = dataFila.file;
                fr = new FileReader();
                fr.readAsDataURL(file);

                var blob = new Blob([file], { type: file.type });
                var objectURL = window.URL.createObjectURL(blob);

                if (navigator.appVersion.toString().indexOf('.NET') > 0) {
                    window.navigator.msSaveOrOpenBlob(blob, file.name);
                } else {
                    var link = document.createElement('a');
                    link.href = objectURL;
                    link.download = file.name;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                }
            } else {
                var html = `<object data="${dataFila.documento}" type="application/pdf" style="width:100%;height:500px">
                <embed src="${dataFila.documento}" type="application/pdf" style="width:100%;height:500px">
                </object>`;
                $("#modalDoc div.modal-body").html(html);

                $("#modalDoc").modal('show');
            }
            
            break;
        }
    });

    mostarCamposPorRemitente = () =>{
        if ($("#idTipoPersona").val() == 62){
            $(".juridica").show();
            $("#cabeceraLegenDatosRemitente").text("Datos del remitente");

            $(".juridica input").attr("required", "");
        } else {
            $(".juridica").hide();
            $("#cabeceraLegenDatosRemitente").text("Datos de la persona natural");

            $(".juridica input").removeAttr("required");
        }
    }

    function ContenidosTipo(idDestino, codigoTipo, defaultSelect = 0, arrayQuitar = []) {
        $.ajax({
            cache: false,
            url: "../views/ajax/ajaxContenidosTipo.php",
            method: "POST",
            async: false,
            data: {
                codigo: codigoTipo
            },
            datatype: "json",
            success: function(data) {
                data = JSON.parse(data);
                let destino = $("#" + idDestino);
                destino.empty();
                destino.append('<option value="">Seleccione</option>');
                let quitarNum = arrayQuitar.length;
                if (quitarNum == 0) {
                    $.each(data, function(key, value) {
                        destino.append('<option value="' + value.codigo + '">' + value.nombre +
                            '</option>');
                    });
                } else {
                    $.each(data, function(key, value) {
                        if (!arrayQuitar.includes(value.codigo)) {
                            destino.append('<option value="' + value.codigo + '">' + value.nombre +
                                '</option>');
                        }
                    });
                }
                if (defaultSelect != 0) {
                    $('#' + idDestino + ' option[value="' + defaultSelect + '"]').prop('selected', true);
                }
            }
        });
    }

    function ListarDepartamento(selector, selected = 0) {
        $.ajax({
            cache: false,
            async: false,
            url: "../views/mantenimiento/Departamento.php",
            method: "POST",
            data: {
                Evento: "Listar"
            },
            datatype: "json",
            success: function(data) {
                data = JSON.parse(data);
                let destino = $(selector);
                destino.empty().append('<option value="">Seleccione</option>');
                $.each(data, function(key, value) {
                    destino.append('<option value="' + value.id + '" ' + ((value.id == selected) ?
                        'selected' : '') + '>' + value.text + '</option>');
                });
            }
        });
    }

    function ListarProvincia(selector, departamento, selected = 0) {
        $.ajax({
            cache: false,
            async: false,
            url: "../views/mantenimiento/Provincia.php",
            method: "POST",
            data: {
                "Evento": "Listar",
                "Departamento": departamento
            },
            datatype: "json",
            success: function(data) {
                data = JSON.parse(data);
                let destino = $(selector);
                destino.empty().append('<option value="">Seleccione</option>');
                $.each(data, function(key, value) {
                    destino.append('<option value="' + value.id + '" ' + ((value.id == selected) ?
                        'selected' : '') + '>' + value.text + '</option>');
                });
            }
        });
    }

    $('#txtFecDoc').daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false
    });

    $('#txtFecDoc').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });

    $('#txtFecDoc').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    function ListarDistrito(selector, departamento, provincia, selected = 0) {
        $.ajax({
            cache: false,
            async: false,
            url: "../views/mantenimiento/Distrito.php",
            method: "POST",
            data: {
                "Evento": "Listar",
                "Departamento": departamento,
                "Provincia": provincia
            },
            datatype: "json",
            success: function(data) {
                data = JSON.parse(data);
                let destino = $(selector);
                destino.empty().append('<option value="">Seleccione</option>');
                $.each(data, function(key, value) {
                    destino.append('<option value="' + value.id + '" ' + ((value.id == selected) ?
                        'selected' : '') + '>' + value.text + '</option>');
                });
            }
        });
    }

    $("#txtDep").on("change", function() {
        ListarProvincia("#txtProv", $("#txtDep").val());
        $("#txtDis").empty().append('<option value="">Seleccione</option>');
    });

    $("#txtProv").on("change", function() {
        ListarDistrito("#txtDis", $("#txtDep").val(), $("#txtProv").val());
    });

    $("#txtCorreoConf").on("blur", function(e) {
        if ($("#txtCorreoConf").val() != $("#txtCorreo").val()) {
            $("#txtCorreoConf").val("");
        }
    });
   

    $("#primerBoton").on("click", function(e) {
        
        if ($("#txtTipoDoc").val() == 73) {
                    $("#txtNombComp").val() == $("#txtNombComp").val();
                    $("#txtDireccion").val() == $("#txtDireccion").val();
                }
        else {
            $("#txtNombComp").val($("#txtNombCompCorto").val());
            $("#txtDireccion").val($("#txtDireccionCorto").val());
        }
        var valido = true;
        var form = $("#FormRemitente");
     
        if (form[0].checkValidity()) {
            event.target.checkValidity();
            event.preventDefault();
            event.stopPropagation();
            if ($("#txtCorreo").val() == $("#txtCorreoConf").val()) {

                stregistroDoc.next();
            }
        } else {
            event.preventDefault()
            event.stopPropagation()
        }
        form.addClass('was-validated');
    });

    $("#txtTipoDoc").on("change", function(e) {
        if ($("#txtTipoDoc").val() == 73) {
            $("#buscarDNI").closest("div.input-group-append").show();
            $("#txtNombComp").prop("disabled", true);
            $("#txtNombCompCorto").prop("disabled", true);
            $("#limpiarBoton").closest("div.input-group-append").show();
            $("#txtDireccionCorto").prop("disabled", true);
        } else {
            $("#buscarDNI").closest("div.input-group-append").hide();
            $("#txtNombComp").prop("disabled", false);
            $("#txtNombCompCorto").prop("disabled", false);
            $("#limpiarBoton").closest("div.input-group-append").hide();
            $("#txtDireccionCorto").prop("disabled", false);
        }
    });
    

    $("#buscarDNI").on("click", function(e) {
        //$("#txtDireccionCorto").prop("disabled", true);
        if ($("#txtNumDocEntidad").val() != '') {
            getSpinner('Cargando datos...');
            

            $.post("regMesaPartesVirtual.php", 
                {
                    Evento: "ObtenerDatosDNI",
                    DNI: $("#txtNumDocEntidad").val()
                })
                .done(function(response){
                    let html = JSON.parse(response);
                    if(html.nombre != null){
                        $("#htmlNombreR").html(html.nombre);
                        $("#htmlNombreCorto").html(html.nombreCorto);
                        $("#htmlDireccionR").html(html.direccion);
                        $("#htmlDireccionRCorto").html(html.direccionCorto);
                        $("#limpiarBoton").closest("div.input-group-append").show();
                        //$("#htmlNombreR").html(html.nombreCorto).css("disabled", "block");

                        $("#htmlDireccionRCorto").closest("div").show();
                        $("#htmlDireccionR").closest("div").hide();
                        
                        

                        cargarUbigeoReniec(html.ubigeo);
                    }
                    deleteSpinner();
                });
        }
    });

    cargarUbigeoReniec = (ubigeo) => {
        var arrayUbigeo = ubigeo.split("/");
        if (arrayUbigeo.length == 2) {
            arrayUbigeo[0] = "PROV. CONST. DEL CALLAO";
            arrayUbigeo.unshift("CALLAO");
        }
        $('#txtDep option').filter(function() {
            return $(this).html().toUpperCase() == arrayUbigeo[0];
        }).prop("selected", true);
        $('#txtDep').trigger("change");

        $('#txtProv option').filter(function() {
            return $(this).html().toUpperCase() == arrayUbigeo[1];
        }).prop("selected", true);
        $('#txtProv').trigger("change");

        $('#txtDis option').filter(function() {
            return $(this).html().toUpperCase() == arrayUbigeo[2];
        }).prop("selected", true);
    }

    $(".numero").keypress(function() {
        if (!IsNumeric(event, this)) {
            event.preventDefault();
        }
    });

    function IsNumeric(event, inputs) {
        event = (event) ? event : window.event;
        var charCode = (event.which) ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $("#buscarRUC").on("click", function(e) {
        if ($("#txtRUC").val() != '') {
            getSpinner('Cargando datos...');
            $.post("regMesaPartesVirtual.php", 
                {
                    Evento: "ObtenerDatosRUC",
                    RUC: $("#txtRUC").val()
                })
                .done(function(response){
                    let html = JSON.parse(response);
                    if(html.denominacion != null){
                        $("#htmlDenS").html(html.denominacion);
                    }
                    deleteSpinner();
                });
        }
    });


    //////////////////////////////////////////////
    // STEP 2
    /////////////////////////////////////////////
    function cudExistente(){
        var checkBox = document.getElementById("cboCudExist");
        var nroExp = document.getElementById("nroExp");
        var anioExp = document.getElementById("anioExp");
        if (checkBox.checked == true){
          nroExp.style.display = "block";
          anioExp.style.display = "block";     
          $("#txtNumCud").val();
          $("#txtAnioCud").val(new Date().getFullYear());    
          $("#txtNumCud").prop('required', true); 
          $("#txtAnioCud").prop('required', true);
        }else{
          nroExp.style.display = "none";
          anioExp.style.display = "none";
          $("#txtNumCud").prop('required', false); 
          $("#txtAnioCud").prop('required', false);
        }

        if($("#txtDenProc").val() != ""){
            $("#txtDenProc").trigger("change");
        } else {
            $("#txtClaseProc").trigger("change");
        }
    }

    function docTupa(){
        // var checkBox = document.getElementById("cboEsTupa");
        var docTupa = document.getElementById("docTupa");
        var docTupaDocumentos = document.getElementById("docTupaDocumentos");
        var anexo = document.getElementById("anexo");
        // if (checkBox.checked == true){
        if ($("#txtClaseProc").val() != ""){
          docTupa.style.display = "block";
          anexo.style.display = "none";
          docTupaDocumentos.style.display = "block";
          $("#tblDocTupa input.anexosTupa").val("");
          $("#tblDocTupa label.anexosTupaLabel").text("Seleccionar Archivo");
        //   $("#txtClaseProc").prop('required', true); 
          $("#txtDenProc").prop('required', true); 
        }else{
          docTupa.style.display = "none";
          anexo.style.display = "block";
          docTupaDocumentos.style.display = "none";
        //   $("#txtClaseProc").prop('required', false); 
          $("#txtDenProc").prop('required', false); 
        }
        $("#avisoRedireccion").hide();
        $("#botonesSegundoStep").show();
    }

    //cambiar para publicar en produccion
    function CargarTUPAs(selectValue = ''){
        $("#txtAsunto").val("");
        getSpinner();
        $('#txtDenProc').empty().append('<option value="">Seleccione</option>');
        $('#txtDenProc').trigger("change");
        let valor = $('#txtClaseProc').val();
        $.ajax({
            async: false,
            cache: false,
            url: "../views/ajax/ajaxTupasMPV.php",
            method: "POST",
            data: {iCodTupaClase: valor},
            datatype: "json",
            success: function (response) {                    
                $.each(JSON.parse(response), function( index, value ) {
                    $('#txtDenProc').append(value);
                });
                if(valor == "4"){
                    $('#txtDenProc').append(`<option value="-1">Otro que no se encuentra en la lista</option>`);
                }
                if (typeof selectValue != "object"){
                    $('#txtDenProc option[value="'+selectValue+'"]').prop('selected',true);
                    $('#txtDenProc').trigger("change");
                }
            }
        });        
        deleteSpinner();
    }
    // function CargarTUPAs(selectValue = ''){
    //     $("#txtAsunto").val("");
    //     getSpinner();
    //     $('#txtDenProc').empty().append('<option value="">Seleccione</option>');
    //     $('#txtDenProc').trigger("change");
    //     let valor = $('#txtClaseProc').val();
    //     $.ajax({
    //         async: false,
    //         cache: false,
    //         url: "../views/ajax/ajaxTupas.php",
    //         method: "POST",
    //         data: {iCodTupaClase: valor},
    //         datatype: "json",
    //         success: function (response) {                    
    //             $.each(JSON.parse(response), function( index, value ) {
    //                 $('#txtDenProc').append(value);
    //             });
    //             if (typeof selectValue != "object"){
    //                 $('#txtDenProc option[value="'+selectValue+'"]').prop('selected',true);
    //                 $('#txtDenProc').trigger("change");
    //             }
    //         }
    //     });        
    //     deleteSpinner();
    // }

    $('#txtClaseProc').on('change', CargarTUPAs);

    function CargarRequisitos(){        
        let valor = $('#txtDenProc').val();
        $.ajax({
            async: false,
            cache: false,
            url: "../views/ajax/ajaxRequisitosTupa.php",
            method: "POST",
            data: {iCodTupa: valor},
            datatype: "json",
            success: function (response) {
                response = JSON.parse(response);
                $('#tblDocTupa tbody').empty();
                if (response.length > 0){
                    $("#docTupaDocumentos").removeClass("d-none");
                    $("#tblDocTupa").show();
                    $("#anexo").hide();
                } else {
                    $("#tblDocTupa").hide();
                    $("#anexo").show();
                }
                $.each(response, function( index, value ) {
                    var html = `<tr>
                                <td>${value.cNomTupaRequisito}</td>
                                <td style="vertical-align: middle">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input anexosTupa" lang="es" id="anexoTupa${value.iCodTupaRequisito}" required>
                                        <label class="custom-file-label anexosTupaLabel" for="anexoTupa${value.iCodTupaRequisito}">Seleccionar Archivo</label>
                                    </div>
                                </td>
                                </tr>`;
                    $('#tblDocTupa tbody').append(html);
                });
            }
        });
    }

    $('#txtDenProc').on("change",function(e){
        $("#tblDocTupa").hide();
        $("#anexo").show();
        $(".tupa").show();
        $("#avisoRedireccion").hide();
        $("#formNuevoTipo").hide();
        $("#formPostulacionCas").hide();
        $(".postulacionesCas").show();
        $(".postulacionesCasRequeridos input").attr("required", "");
        $(".postulacionesCasRequeridos select").attr("required", "");

        if ($("#cboCudExist").prop("checked")){
            if($('#txtDenProc option:selected').val() == "-1"){
                $(".tupa").hide();
                $('#tblDocTupa tbody').empty();
                $("#botonesSegundoStep").hide();
                $(".tupa").hide();
                $("#formNuevoTipo").show();
            } else {
                $(".tupa").show();
                // CargarRequisitos();
                $("#botonesSegundoStep").show();
                $("#avisoRedireccion").hide();
            }
            
        } else {
            if($('#txtDenProc option:selected').attr("ruta") == undefined || $('#txtDenProc option:selected').attr("ruta") == ""){
                if($('#txtDenProc option:selected').val() == "-1"){
                    $(".tupa").hide();
                    $('#tblDocTupa tbody').empty();
                    $("#botonesSegundoStep").hide();
                    $("#formNuevoTipo").show();
                } else if($('#txtDenProc option:selected').val() == "44"){
                    $(".tupa").hide();
                    $('#tblDocTupa tbody').empty();
                    $("#formPostulacionCas").show();
                    $(".postulacionesCas").hide();
                    $(".postulacionesCasRequeridos input").removeAttr("required");
                    $(".postulacionesCasRequeridos select").removeAttr("required");

                } else {
                    $(".tupa").show();
                    CargarRequisitos();
                    $("#botonesSegundoStep").show();
                    $("#avisoRedireccion").hide();
                }
            } else {
                $(".tupa").hide();
                $('#tblDocTupa tbody').empty();
                var ruta = $('#txtDenProc option:selected').attr("ruta");
                var nomApp  = $('#txtDenProc option:selected').attr("nomApp");
                $("#avisoRedireccion").html(`<div class="alert alert-success" role="alert">Estimado usuario, el trámite que desea registrar se encuentra disponible y debe ser iniciado en el siguiente aplicación: ${nomApp}. <i><a href="${ruta}">Ir Ahora</a></i></div>`);
                $("#botonesSegundoStep").hide();            
                $("#avisoRedireccion").show();
                $(".tupa").hide();
            }            
        }
        if($("#txtClaseProc").val() == '5'){
            $("#txtAsunto").val($('#txtDenProc option:selected').text());
        }
    });

    $("#segundoBoton").on("click", function(e){
        //Validacion
        if ($("#id").val() == 0){
            var valido = true;
            var form = $("#FormDocumento");

            if (form[0].checkValidity()) {
                event.target.checkValidity();
                event.preventDefault();
                event.stopPropagation();    

                var data = {
                Evento: "EnviarCodigoValidacion",
                Correo: $("#txtCorreoConf").val(),
                Nombre: $("#txtNombComp").val()
                }
                getSpinner('Enviando correo de validación');
                $.post("regMesaPartesVirtual.php", data)
                    .done(function(response){
                        stregistroDoc.next();
                        deleteSpinner();
                        var rucValidacion = document.getElementById("rucValidacion");
                        var denominacionValidacion = document.getElementById("denominacionValidacion");
                        var cudTraIniciadoValidacion = document.getElementById("cudTraIniciadoValidacion");
                        var checkBoxCUD = document.getElementById("cboCudExist");
                        if($('#idTipoPersona').val() == 62){
                            rucValidacion.style.display = "block";
                            denominacionValidacion.style.display = "block";
                        }else{
                            rucValidacion.style.display = "none";
                            denominacionValidacion.style.display = "none";
                        }

                        if(checkBoxCUD.checked == true){
                            cudTraIniciadoValidacion.style.display="block";
                        }else{
                            cudTraIniciadoValidacion.style.display="none";
                        }
                        
                    })
                    .fail(function(response){
                        deleteSpinner();
                        toastr.warning("No se pudo enviar el código de validación", 'Mensaje del Sistema', { 'progressBar': true });
                    });                
            } else {
                event.preventDefault()
                event.stopPropagation()
            }
            form.addClass('was-validated');
            // Fin Validacion
        } else {
            event.preventDefault()
            event.stopPropagation()
            enviarDatos($("#id").val());
        }
    });

    $("#btnEnviar").on("click", function(e){
        e.preventDefault()
        e.stopPropagation()
        enviarDatos()
    });

    function enviarDatos (id = "0") {
        var formData = new FormData();
        if (id == "0"){
            formData.append("Evento", "RegistrarDocumento");
        } else {
            formData.append("Evento", "SubsanarDocumento");
            formData.append("ID_MESA_PARTES_VIRTUAL", id);

            var tablatblPrincipal = tblPrincipal.data();
            $.each(tablatblPrincipal, function (i, item) {
                formData.append('ANEXOS_ANTERIORES[]',item.IdArchivo);
            });

            var tablatblAnexos = tblAnexosSubsanacion.data();
            $.each(tablatblAnexos, function (i, item) {
                formData.append('ANEXOS_ANTERIORES[]',item.IdArchivo);
            });
        }  

        formData.append("ID_TIPO_ENTIDAD", $("#idTipoPersona").val());        

        formData.append("ID_TIPO_ENTIDAD", $("#idTipoPersona").val());
        formData.append("ID_TIPO_ENTIDAD", $("#idTipoPersona").val());
        
        if ($("#idTipoPersona").val() == 62){
          formData.append("ID_TIPO_DOC_ENTIDAD",74);
          formData.append("NUM_DOC_ENTIDAD", $("#txtRUC").val());
          formData.append("NOM_ENTIDAD", $("#txtDenInst").val());

          formData.append("ID_TIPO_DOC_RESPONSABLE",$("#txtTipoDoc").val());
          formData.append("DNI_RESPONSABLE", $("#txtNumDocEntidad").val());
          formData.append("NOM_RESPONSABLE", $("#txtNombComp").val());          
        } else {
          formData.append("ID_TIPO_DOC_ENTIDAD",$("#txtTipoDoc").val());
          formData.append("NUM_DOC_ENTIDAD", $("#txtNumDocEntidad").val());
          formData.append("NOM_ENTIDAD", $("#txtNombComp").val());

          formData.append("ID_TIPO_DOC_RESPONSABLE",'');
          formData.append("DNI_RESPONSABLE", '');
          formData.append("NOM_RESPONSABLE", ''); 
        }

        formData.append("DIRECCION_ENTIDAD",$("#txtDireccion").val());
        formData.append("ID_DEPARTEMENTO", $("#txtDep").val());
        formData.append("ID_PROVINCIA", $("#txtProv").val());
        formData.append("ID_DISTRITO",$("#txtDis").val());
        formData.append("TELEFONO_CONTACTO", $("#txtTel").val());
        formData.append("CORREO_CONTACTO", $("#txtCorreoConf").val());

        formData.append('ARCHIVO_PRINCIPAL',document.getElementById('archivoPrincipal').files[0]);
        formData.append("PIN", $("#txtCodigoValidacion").val());

        if ($("#chxSigcti").prop("checked")){
            formData.append("FLG_SIGCTI",1);
            formData.append("NRO_SOLICITUD_SIGCTI", $("#txtNumSolicitudSigcti").val());

            getSpinner('Cargando datos...');
            $.post("regMesaPartesVirtual.php", 
            {
                Evento: "ObtenerDatosConstancia",
                NumSol: $("#txtNumSolicitudSigcti").val()
            })
            .done(function(response){
                let respuesta = JSON.parse(response);
                if (respuesta.data != ''){
                    let data = respuesta.data;

                    formData.append("ID_SIGCTI", data.CodInscripcion);

                    formData.append("FLG_TIENE_CUD",0);
                    formData.append("NRO_CUD", '');
                    formData.append("ANIO_CUD", '');                    

                    formData.append("ID_TIPO_DOC", data.TipDocumento);
                    formData.append("NUMERO_DOC", data.NroDocumento);

                    var arrayfec = data.FecDocumento.split("/");
                    formData.append("FEC_DOC", arrayfec[2] + "-" + arrayfec[1] + "-" + arrayfec[0]);
                    
                    formData.append("FOLIOS", data.Folio);
                    formData.append("ASUNTO", data.Asunto);

                    formData.append("FLG_ES_TUPA",1);
                    formData.append("ID_TIPO_PROCEDIMIENTO", data.TupaClase);
                    formData.append("ID_TUPA", data.TupaCodigo);

                    $.each(data.ListDocumento, function (i,fila) {
                        formData.append('ANEXOS_SIGCTI[]',JSON.stringify(fila));
                    });

                    getSpinner('Guardando documento');
                    $.ajax({
                        async: false,
                        url: "regMesaPartesVirtual.php",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        datatype: "json",
                        success: function (response) {
                            deleteSpinner();
                            if (id == "0"){
                                $('#modalConfirmacion').modal('toggle');
                            } else {
                                $('#modalConfirmacionSubsanacion').modal('toggle');
                                // toastr.success("Expediente subsanado correctamente!", 'Mensaje del Sistema', { 'progressBar': true });
                                // setTimeout(function(){ window.location = "index.php"; },5000);
                            }                
                        },
                        error: function (e) {
                            deleteSpinner();
                            toastr.warning(e, 'Mensaje del Sistema', { 'progressBar': true });
                        }
                    });
                } else {
                    toastr.warning(data.mensaje, 'Mensaje del Sistema', { 'progressBar': true });
                }
                deleteSpinner();
            });
        } else {
            formData.append("FLG_SIGCTI",0);
            formData.append("NRO_SOLICITUD_SIGCTI", '');
            formData.append("ID_SIGCTI", 0);

            formData.append("ID_TIPO_DOC", $("#txtTipoDocumento").val());
            formData.append("NUMERO_DOC", $("#txtNumDoc").val());

            var arrayfec = $("#txtFecDoc").val().split("/");
            formData.append("FEC_DOC", arrayfec[2] + "-" + arrayfec[1] + "-" + arrayfec[0]);
            
            formData.append("FOLIOS", $("#intFilios").val());
            formData.append("ASUNTO", $("#txtAsunto").val());

            if ($("#cboCudExist").prop("checked")){
                formData.append("FLG_TIENE_CUD",1);
                formData.append("NRO_CUD", $("#txtNumCud").val());
                formData.append("ANIO_CUD", $("#txtAnioCud").val());

                if ($("#txtClaseProc").val() == "5"){
                    formData.append("FLG_ES_TUPA",1);
                    
                } else {
                    formData.append("FLG_ES_TUPA",0);
                }

                formData.append("ID_TIPO_PROCEDIMIENTO", $("#txtClaseProc").val());
                formData.append("ID_TUPA", $("#txtDenProc").val());

                var tabla = tblAnexos.data();
                $.each(tabla, function (i, item) {
                    formData.append('ANEXOS[]',item.file);
                });
            } else {
                formData.append("FLG_TIENE_CUD",0);
                formData.append("NRO_CUD", '');
                formData.append("ANIO_CUD", '');

                if ($("#txtClaseProc").val() == "5"){
                    formData.append("FLG_ES_TUPA",1);                    

                    if ($("#txtDenProc option:selected").attr("ruta") == undefined || $("#txtDenProc option:selected").attr("ruta") == ""){
                        if ($("#anexo").css("display") == "none"){
                            $("#tblDocTupa input[type=file]").each(function(i,e){
                                if ($(e).val() != ""){
                                    formData.append('ANEXOS[]',$(e)[0].files[0]);
                                }              
                            });
                        } else {
                            var tabla = tblAnexos.data();
                            $.each(tabla, function (i, item) {
                                formData.append('ANEXOS[]',item.file);
                            });
                        }
                    }                    
                } else {
                    formData.append("FLG_ES_TUPA",0);

                    var tabla = tblAnexos.data();
                    $.each(tabla, function (i, item) {
                        formData.append('ANEXOS[]',item.file);
                    });
                }

                formData.append("ID_TIPO_PROCEDIMIENTO", $("#txtClaseProc").val());
                formData.append("ID_TUPA", $("#txtDenProc").val());
            }

            // si es una convocatoria de personal
            if($("#txtDenProc").val() == 44){
                formData.append("DESC_PROCESO", $("#txtProcesoPostulacionCAS").val());
                formData.append('ARCHIVO_PRINCIPAL_PROCESO',document.getElementById('fileArchivoPrincipalPostulacionCAS').files[0]);
            }

            getSpinner('Guardando documento');
            $.ajax({
                async: false,
                url: "regMesaPartesVirtual.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                datatype: "json",
                success: function (response) {
                    deleteSpinner();
                    if (id == "0"){
                        $('#modalConfirmacion').modal('toggle');
                    } else {
                        $('#modalConfirmacionSubsanacion').modal('toggle');
                        // toastr.success("Expediente subsanado correctamente!", 'Mensaje del Sistema', { 'progressBar': true });
                        // setTimeout(function(){ window.location = "index.php"; },5000);
                    }                
                },
                error: function (e) {
                    deleteSpinner();
                    toastr.warning('Error en la aplicación', 'Mensaje del Sistema', { 'progressBar': true });
                }
            });
        }     
    }    

    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    function InsertarAnexo(file) {
        if (file.size <= 2 * 1024 * 1024 * 1024){
        var anexo = new Object();
        anexo.name = file.name;
        anexo.size = bytesToSize(file.size);      

        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function (evt) {
            anexo.documento = evt.target.result;
        };
        anexo.file = file;
        tblAnexos.row.add(anexo).draw();
        } else {
        alert(`Tamaño del archivo ${file.name} es superior a los 50MB permitidos.`);
        }
    }

    $("#documentoAnexo").on("change",function(e){
        var actual = this;
        var files = actual.files;
        for (var i = 0; i < files.length; i++) {
        InsertarAnexo(files[i]);
        }
        $("#documentoAnexo").val('');
        $("#documentoAnexo").closest("div.custom-file").find("label.custom-file-label").text("Seleccione")
    }); 

    function cargarValidacion(){
        var textoDocumento = $('#txtTipoDocumento').find('option:selected').text();
        $('#nombreRemitente').html($('#txtNombComp').val());
        $('#stNombrePer').val($('#txtNombComp').val());
        $('#stNumRuc').val($('#txtRUC').val());
        $('#stNumDocPer').val($('#txtNumDocEntidad').val());
        $('#stDen').val($('#txtDenInst').val());
        $('#stNumCud').val($('#txtNumCud').val());
        $('#stDoc').val(textoDocumento+ " "+ $('#txtNumDoc').val());
        $('#stAsuDoc').val($('#txtAsunto').val());
        $('#stFecDoc').val($('#txtFecDoc').val());
        $('#stNumFol').val($('#intFilios').val());
    }

    $("#chxSigcti").on("change", function(e){
        $(".tupa").show();
        $("#avisoRedireccion").hide();
        if ($("#chxSigcti").prop("checked")){
            $(".sigcti").hide();            
            $(".sigcti input").removeAttr("required");
            $(".sigcti select").removeAttr("required");

            $(".sigctiValidacion").hide();            

            $("#nroSigcti").show();
        } else {
            $(".sigcti").show();            
            $(".sigcti input").attr("required", "");
            $(".sigcti select").attr("required", "");

            $(".sigctiValidacion").show();

            $("#nroSigcti").hide();
            cudExistente();
        }        
    });

    $("#idTipoPersona").on("change", function(e){
        mostarCamposPorRemitente();
    });

    $(document).on("click", "#btnEnviarSolicitudNuevoTramite", function(e){
        e.preventDefault();
        e.stopPropagation();

        if($("#txtTipoNuevoTramite").val() == ''){
            toastr.warning("No se ha indicado el nuevo trámite a registrar", 'Mensaje del Sistema', { 'progressBar': true });
            return false;
        }

        if(document.getElementById('fileArchivoPrincipalNuevoTipo').files.length == 0){
            toastr.warning("No se ha indicado el archivo principal del trámite", 'Mensaje del Sistema', { 'progressBar': true });
            return false;
        }

        getSpinner('Enviando solicitud de nuevo tipo de trámite');

        var formData = new FormData();
        formData.append("Evento", "EnviarSolicitudNuevoTramite");
        formData.append("Telefono", $("#txtTel").val());
        formData.append("Correo", $("#txtCorreoConf").val());
        formData.append("Nombre", $("#txtNombComp").val());
        formData.append("NombreCorto", $("#txtNombCompCorto").val());
        formData.append("DireccionCorto", $("#txtDireccionCorto").val());
        formData.append("NuevoTramite", $("#txtTipoNuevoTramite").val());
        formData.append('ArchivoPrincipalNuevoTipo',document.getElementById('fileArchivoPrincipalNuevoTipo').files[0]);        
        
        $.ajax({
            async: false,
            url: "regMesaPartesVirtual.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            datatype: "json",
            success: function (response) {
                deleteSpinner();  
                $('#modalConfirmacionSolicitudNuevoTramite').modal('toggle');             
            },
            error: function (e) {
                deleteSpinner();
                toastr.warning("No se pudo enviar la solicitud", 'Mensaje del Sistema', { 'progressBar': true });
            }
        });
    });    

    </script>
</body>

</html>