<?php
session_start();
$pageTitle = "Bandeja de servicios archivísticos";
$activeItem = "bandejaSolicitudesPrestamosRecibidos.php";
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
                        <li><button id="btnValidarSolicitud" style="display: none" class="btn btn-primary"><i class="fas fa-check"></i><span> Validar</span></button></li>
                        <li><button id="btnFirmarSolicitud" style="display: none" class="btn btn-primary"><i class="fas fa-check"></i><span> Autorizar y enviar</span></button></li>
                        <li><button id="btnAtenderSolicitud" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span> Atender</span></button></li>
                        <li><button id="btnObservar" style="display: none" class="btn btn-link"><i class="fas fa-undo"></i><span> Observar</span></button></li>
                        <li><button id="btnAmpliarPLazoAtencion" style="display: none" class="btn btn-link"><i class="fas fa-hourglass-end"></i><span> Ampliar Plazo Atención</span></button></li>
                        <li><button id="btnDevolverFaltaDatos" style="display: none" class="btn btn-link"><i class="fas fa-undo"></i><span> D. por falta de datos</span></button></li>
                        <li><button id="btnDevolverNoObrarArchivo" style="display: none" class="btn btn-link"><i class="fas fa-undo"></i><span> D. por no obrar en el Archivo</span></button></li>
                        <li><button id="btnRenotificar" style="display: none" class="btn btn-link"><i class="fas fa-reply fa-fw left"></i><span> Re-Notificar</span></button></li>
                        <li><button id="btnAnular" style="display: none" class="btn btn-link"><i class="fas fa-trash"></i><span> Anular</span></button></li>
                        <!--<li><button id="btnAmpliarPlazo" style="display: none" class="btn btn-link"><i class="fas fa-hourglass-end"></i><span> Ampliar Plazo</span></button></li>-->
                        <!--<li><button id="btnRegistrarDevolucion" style="display: none" class="btn btn-link"><i class="far fa-times-circle"></i><span> Registrar Devolución</span></button></li>-->
                        <li><button id="btnVerSolicitud" style="display: none" class="btn btn-link"><i class="fas fa-eye"></i><span> Ver solicitud</span></button></li>
                        <li><button id="btnHistorico" style="display: none" class="btn btn-link"><i class="fas fa-eye"></i><span> Ver historico</span></button></li>
                        <li><button id="btnVerSolicitudPorDevolver" style="display: none" class="btn btn-link"><i class="fas fa-eye"></i><span>Ver solicitud por devolver</span></button></li>
                        <li><button id="btnVerDocSolicitud" style="display: none" class="btn btn-link"><i class="fas fa-clipboard fa-fw left"></i><span> Ver doc. solicitud</span></button></li>
                        <li><button id="btnVerDocCargo" style="display: none" class="btn btn-link"><i class="fas fa-clipboard fa-fw left"></i><span> Ver doc. cargo</span></button></li>
                        <li><button id="btnVerDocDevolucion" style="display: none" class="btn btn-link"><i class="fas fa-clipboard fa-fw left"></i><span> Ver doc. devolución</span></button></li>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <div class="row">
                                <div class="col s12">
                                    <ul class="tabs">
                                        <li id="btnEnCurso" class="tab col s3"><a href="#enCurso">En curso</a></li>
                                        <li id="btnNotificados" class="tab col s3"><a href="#notificados"> Notificado</a></li>
                                        <li id="btnPorDevolver" class="tab col s3"><a href="#porDevolver"> Por Devolver</a></li>
                                    </ul>
                                </div>
                                <div id="enCurso" class="col s12">
                                    <table id="tblBandejaSolicitudesEnCurso" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Origen</th>
                                            <th>Trabajador Origen</th>
                                            <th>Documento</th>
                                            <th>Fecha de Envío</th>
                                            <th>Fecha de Plazo Atención</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="notificados" class="col s12">
                                    <table id="tblBandejaSolicitudesNotificados" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Origen</th>
                                            <th>Trabajador Origen</th>
                                            <th>Documento</th>
                                            <th>Fecha de Primera Notificación</th>
                                            <th>Cantidad Notificaciones</th>
                                            <th>Fecha Última Notificación</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="porDevolver" class="col s12">
                                    <table id="tblBandejaSolicitudesPorDevolver" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Origen</th>
                                            <th>Trabajador Origen</th>
                                            <th>Documento</th>
                                            <th>Fecha de recepción</th>
                                            <th>N° de Ampliaciones</th>
                                            <th>Fecha plazo</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalAtenderSolicitud" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Solicitud préstamo documento</h4>
        </div>
        <div class="modal-content">
            <div id="datosSolicitud">
                <div class="row">
                    <div class="col s12">
                        <table id="tblDetalleSolicitud" style="display: none; width: 100%;">
                            <thead>
                            <tr>
                                <th>Serie Documental</th>
                                <th>Descripción</th>
                                <th>Servicio Requerido</th>
                                <th>Requiere Doc. Digital</th>
                                <th>Tiene Doc. Digital</th>
                                <th>Servicio dado</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <input type="hidden" value="0" name="codSolicitudPrestamo" id="codSolicitudPrestamo">
            <div id="formularioDatos" style="display: none">
                <form>
                    <input type="hidden" value="0" name="codDetalleSolicitud" id="codDetalleSolicitud">
                    <div class="row">
                        <div class="col s6 input-field">
                            <div class="switch">
                                <label>
                                    Reproducción Digital
                                    <input type="checkbox" id="FlgTipoDocumento" name="FlgTipoDocumento" value="0">
                                    <span class="lever"></span>
                                    Reproducción Física
                                </label>
                            </div>
                        </div>
                        <div class="col s6 input-field" style="display: none;">
                            <select id="idTipoServicioOfrecido" name="idTipoServicioOfrecido">
                            </select>
                            <label for="idTipoServicioOfrecido">Servicio Ofrecido</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s12">
                            <div id="dropzoneDocDigital" class="dropzone" style="width:100%"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button type="button" class="btn btn-secondary" id="btnSubirDocDigital">Subir</button>
                        </div>
                    </div>
                    <div id="documentoDigital" style="display: none">
                        <p style="padding: 0 15px">Seleccione archivo:</p>
                        <div class="row" style="padding: 0 15px">
                            <div class="col s12">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="btnGuardarDatos"> Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelarDatos"> Cancelar</button>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnNotificar"> Notificar</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalAnular" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Anular solicitud de préstamo</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="col s12 input-field ">
                        <input type="text" id="observacionAnular" name="observacionAnular">
                        <label for="observacionAnular">Observación</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnAnularSolicitudPrestamo"> Finalizar</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalDetalleSolicitud" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Detalle solicitud de servicios</h4>
        </div>
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <input type="hidden" name="IdSolicitudPrestamoVer" id="IdSolicitudPrestamoVer" value="0">
                    <table id="tblVerDetalleSolicitud" style="display: none; width: 100%;">
                        <thead>
                        <tr>
                            <th>Serie Documental</th>
                            <th>Descripción</th>
                            <th>Servicio Requerido</th>
                            <th>Requiere Doc. Digital</th>
                            <th>Tiene Doc. Digital</th>
                            <th>Servicio dado</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>            
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalDetalleSolicitudPorDevolver" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Detalle solicitud de servicios</h4>
        </div>
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <table id="tblVerDetalleSolicitudPorDevolver" style="display: none; width: 100%;">
                        <thead>
                        <tr>
                            <th>Serie Documental</th>
                            <th>Descripción</th>
                            <th>Servicio Requerido</th>
                            <th>Requiere Doc. Digital</th>
                            <th>Tiene Doc. Digital</th>
                            <th>Servicio dado</th>
                            <th>Estado</th>
                            <th>Observación</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row">
                <div id="formularioDevolverDatos" style="display: none">
                    <form>
                        <input type="hidden" value="0" name="codDetalleSolicitudDevolver" id="codDetalleSolicitudDevolver">
                        <div class="row">
                            <div class="file-field input-field col s12">
                                <div id="dropzoneDocDigitalDevolver" class="dropzone" style="width:100%"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <button type="button" class="btn btn-secondary" id="btnSubirDocDigitalDevolver">Subir</button>
                            </div>
                        </div>
                        <div id="documentoDigitalDevolver" style="display: none">
                            <p style="padding: 0 15px">Seleccione archivo:</p>
                            <div class="row" style="padding: 0 15px">
                                <div class="col s12">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="btnGuardarDatosDevolver"> Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btnCancelarDatosDevolver"> Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnGenerarDevolucion"> Generar devolucion</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalObservar" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Observar solicitud de préstamo</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <textarea id="observacionObservar" class="materialize-textarea" style="height: 127px;!important"></textarea>
                        <label for="observacionObservar">Observación</label>                                        
                    </div> 
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnObservarSolicitudPrestamo"> Observar</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalAmpliarPlazo" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Ampliar Plazo de Atencion de solicitud de préstamo</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <textarea id="observacionAmpliarPlazoAtencion" class="materialize-textarea" style="height: 127px;!important"></textarea>
                        <label for="observacionAmpliarPlazoAtencion">Motivo</label>                                        
                    </div> 
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnAmpliarPlazoAtencion"> Ampliar Plazo</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalDevolverFaltaDatos" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Devolver solicitud de préstamo por falta de datos</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <textarea id="observacionDevolverFaltaDatos" class="materialize-textarea" style="height: 127px;!important"></textarea>
                        <label for="observacionDevolverFaltaDatos">Observación</label>                                        
                    </div> 
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnDevolverFaltaDatosSolicitudPrestamo"> Devolver</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalDevolverNoObrarArchivo" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Devolver solicitud de préstamo por no obrar en el Archivo</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <textarea id="observacionDevolverNoObrarArchivo" class="materialize-textarea" style="height: 127px;!important"></textarea>
                        <label for="observacionDevolverNoObrarArchivo">Observación</label>                                        
                    </div> 
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnDevolverNoObrarArchivoSolicitudPrestamo"> Devolver</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalHistorico" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Histórico</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalValidar" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Validar solicitud de préstamo</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="input-field col s12 m12">
                         <select id="OficinaRequeridaValidar" name="OficinaRequeridaValidar">
                        </select>
                        <label for="OficinaRequeridaValidar">Oficina responsable de la atención</label>
                    </div> 
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnValidarSolicitudPrestamo"> Validar</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <input type="hidden" id="idSolicitudPrestamo" value="">
    <input type="hidden" id="idDigital" value="">
    <input type="hidden" id="tipo_f" value="">
    <input type="hidden" id="idTipoTra" value="">
    <input type="hidden" id="nroVisto" value="">
    <input type="hidden" id="flgRequireFirmaLote" value="">
    <input type="hidden" id="firmaRealizada" value="">

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>
    <script src="includes/dropzone.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.6/dist/js/bootstrap.bundle.min.js" ></script>
    <!--FIN PERU--> 

    <script type="text/javascript" src="../conexion/global.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        var documentName_ = null;

        //::LÓGICA DEL PROGRAMADOR::
        //INICIO PERU
        var jqFirmaPeru = jQuery.noConflict(true);

        function signatureInit(){
            alert('PROCESO INICIADO');
        }

        function signatureOk(){
            alert('DOCUMENTO FIRMADO');
            MiFuncionOkWeb();
        }

        function signatureCancel(){
            alert('OPERACIÓN CANCELADA');
        }

        function base64EncodeUnicode(str) {
            // Codifica texto unicode en base64 (equivalente a base64_encode en PHP)
            return btoa(unescape(encodeURIComponent(str)));
        }

        function generateToken(length) {
            const array = new Uint8Array(length);
            window.crypto.getRandomValues(array);
            return Array.from(array, byte => byte.toString(16).padStart(2, '0')).join('');
        }

        function sendParam() {
            const idDigital = document.getElementById("idDigital").value;
            const tipFirma = $("#tipo_f").val();
            const nroVisto = $("#nroVisto").val();
            const flgRequireFirmaLote = $("#flgRequireFirmaLote").val();
            const idTipoTra = $("#idTipoTra").val(); // PARA SELLADO DE TIEMPO EXTERNO
            
            const firmaInitParams = {
                param_url: RUTA_DTRAMITE + "views/invoker/postArgumentsServArch.php?idDigital="+idDigital+"&tipFirma="+tipFirma+"&nroVisto="+nroVisto+"&flgRequireFirmaLote="+flgRequireFirmaLote+"&idTipoTra="+idTipoTra,
                param_token: generateToken(16),
                document_extension: "pdf"
            };
            const jsonString = JSON.stringify(firmaInitParams);

            const base64Param = base64EncodeUnicode(jsonString);

            const port = "48596";

            // Llama al cliente de Firma Perú
            startSignature(port, base64Param);
        }

        //FIN PERU

        function MiFuncionOkWeb(){
            let idDigital = document.getElementById("idDigital").value;
            let idSolicitudPrestamo = document.getElementById("idSolicitudPrestamo").value;
            let firmaRealizada = document.getElementById("firmaRealizada").value;

            let evento = 'GuardarFirmaAutorizacion';

            if(firmaRealizada == 'GuardarVistoCargo'){
                evento = 'GuardarVistoCargo';
            } else if(firmaRealizada == 'GuardarVistoCargoDevolucion'){
                evento = 'GuardarVistoCargoDevolucion';
            }

            getSpinner('Guardando Documento');
            $.ajax({
                url: "registerDoc/RegPrestamoDocumentos.php",
                method: "POST",
                data: {
                    Evento: evento,
                    IdSolicitudPrestamo: idSolicitudPrestamo,
                    IdDigital: idDigital,
                },
                datatype: "json",
                success: function (response) {
                    location.reload();
                    // tblBandejaSolicitudesEnCurso.ajax.reload();
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al actualizar estados de firma!');
                    M.toast({html: "Error al firmar"});
                }
            });
        }

        function MiFuncionCancel(){
            alert("El proceso de firma digital fue cancelado.");
        }
    </script>
    <!--INICIO PERU-->
    <script src="https://apps.firmaperu.gob.pe/web/clienteweb/firmaperu.min.js"></script> 
    <div id="addComponent" style="display:none;"></div>
    <!--FIN PERU-->

    <script>
        var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;

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
            showClearBtn: true,
            container: 'body'
        });

        function ContenidosTipo(idDestino, codigoTipo){
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
                method: "POST",
                data: {codigo: codigoTipo},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        $('#idSolicitudExternaDetalle').select2({
            dropdownParent: $('#modalAtenderSolicitud'),
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al destinatario.</p>";
                },
                "searching": function() {
                    return "Buscando...";
                },
                "inputTooShort": function() {
                    return "Ingrese más de 3 letras ...";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'ajax/ajaxSolicitudExternaDetalleDisponible.php',
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

        $('#idSolicitudExternaDetalle').on('select2:select', function () {
            let valor = $('#idSolicitudExternaDetalle').val();
            let formData = new FormData();
            formData.append("Evento","ObtenerDatosSolicitudExternaDetalle");
            formData.append("CodigoSolicitudExternaDetalle", valor);
            $.ajax({
                cache: false,
                url: "registerDoc/RegPrestamoDocumentos.php",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                datatype: "json",
                success : function(data) {
                    fila = $.parseJSON(data);
                    if (fila.IdCodDigital !== null){
                        let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoDigital[]" value="'+fila.codigo+'"><span><a href="'+fila.servidor+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
                        $('#documentoDigital div.row div.col').append(check);
                        $('#documentoDigital').css('display', 'block');
                    }
                },
                error: function () {
                    M.toast({html: '¡Error al obtener los datos!'});
                }
            });
        });

        $(document).ready(function() {
            $('.actionButtons').hide();

            var btnValidarSolicitud = $("#btnValidarSolicitud");
            var btnFirmarSolicitud = $("#btnFirmarSolicitud");
            var btnAtenderSolicitud = $("#btnAtenderSolicitud");
            var btnObservar = $("#btnObservar");
            var btnAmpliarPLazoAtencion = $("#btnAmpliarPLazoAtencion");
            var btnDevolverFaltaDatos = $("#btnDevolverFaltaDatos");
            var btnDevolverNoObrarArchivo = $("#btnDevolverNoObrarArchivo");
            var btnRenotificar = $("#btnRenotificar");
            var btnAnular = $("#btnAnular");
            //var btnAmpliarPlazo = $("#btnAmpliarPlazo");
            //var btnRegistrarDevolucion = $("#btnRegistrarDevolucion");
            var btnVerSolicitud = $("#btnVerSolicitud");
            var btnHistorico = $("#btnHistorico");
            var btnVerSolicitudPorDevolver = $("#btnVerSolicitudPorDevolver");
            var btnVerDocSolicitud = $("#btnVerDocSolicitud");
            var btnVerDocCargo = $("#btnVerDocCargo");
            var btnVerDocDevolucion = $("#btnVerDocDevolucion");            

            var actionButtonsRecibidosEnCurso = [];
            var supportButtonsRecibidosEnCurso = [btnAtenderSolicitud, btnAnular, btnObservar, btnAmpliarPLazoAtencion, btnDevolverFaltaDatos, btnDevolverNoObrarArchivo, btnHistorico, btnVerDocSolicitud, btnVerDocCargo, btnVerDocDevolucion];

            var actionButtonsRecibidosNotificados = [];
            var supportButtonsRecibidosNotificados = [btnRenotificar, btnAnular, btnVerSolicitud, btnHistorico, btnVerDocSolicitud, btnVerDocCargo, btnVerDocDevolucion];

            var actionButtonsRecibidosPorDevolver = [];
            var supportButtonsRecibidosPorDevolver = [btnVerSolicitudPorDevolver, btnHistorico, btnVerDocSolicitud, btnVerDocCargo, btnVerDocDevolucion];
            /*btnAmpliarPlazo,*/ 

            var tblBandejaSolicitudesEnCurso = $('#tblBandejaSolicitudesEnCurso').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstadoSolicitudPrestamo": 7
                                ,"FlgArchivoCentral" : 1
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesEnCurso_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesEnCurso.rows().deselect();
                    });
                },
                dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
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
                        "width": "25%",
                        "targets": [1,2,3],
                        'orderable': false
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'oficinaOrigen', 'autoWidth': true}
                    ,{'data': 'trabajadorOrigen', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'fechaEnvio', 'autoWidth': true}
                    ,{'data': 'fechaPlazoAtencion', 'autoWidth': true}
                    , {
                        'render': function (data, type, full, meta) {
                            let iconos = '';
                            if (full.flgFueraPlazoAtencion === 1) {
                                iconos += '<i class="fas fa-fw fa-flag" style="color: red; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            return iconos
                        },
                    }
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesEnCurso
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEnCurso.rows( { selected: true } ).count();        
                    
                    switch (count) {
                        case 1:
                            let fila = tblBandejaSolicitudesEnCurso.rows( { selected: true } ).data().toArray()[0];
                            
                            switch(fila.IdEstadoSolicitudPrestamo) {
                                case 7: // en curso
                                    $.each( actionButtonsRecibidosEnCurso, function( key, value ) {
                                        value.css("display","inline-block");
                                    });
                                    $.each( supportButtonsRecibidosEnCurso, function( key, value ) {
                                        value.css("display","inline-block");
                                    });

                                    btnValidarSolicitud.css("display","none");

                                    break;
                                case 111: //nuevo
                                    btnValidarSolicitud.css("display","inline-block");
                                    btnVerSolicitud.css("display","inline-block");
                                    btnHistorico.css("display","inline-block");
                                    break;

                                case 113: //nuevo
                                    btnFirmarSolicitud.css("display","inline-block");
                                    break;
                            }
                            
                            $('.actionButtons').show();

                            if (fila.flgFueraPlazoAtencion == 0) {
                                btnAmpliarPLazoAtencion.css("display","none");
                            }

                            break;

                        default:
                            $.each( actionButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEnCurso.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            let fila = tblBandejaSolicitudesEnCurso.rows( { selected: true } ).data().toArray()[0];
                            if (fila.flgFueraPlazoAtencion == 0) {
                                btnAmpliarPLazoAtencion.css("display","none");
                            }

                            break;

                        default:
                            $.each( actionButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            var tblDetalleSolicitud = $('#tblDetalleSolicitud').DataTable({
                responsive: true,
                searching: false,
                ordering: false,
                paging: false,
                info: false,
                ajax: {
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    type: 'POST',
                    datatype: 'json',
                    data: function ( d ) {
                        return $.extend( {}, d, {
                            "IdSolicitudPrestamo": $('#codSolicitudPrestamo').val(),
                            "Evento": "ObtenerDetalleSolicitud"
                        });
                    }
                },
                "drawCallback": function() {
                    let api = this.api();
                    if (api.data().length === 0){
                        $("#tblDetalleSolicitud").css('display','none');
                    } else{
                        $("#tblDetalleSolicitud").css('display','block');
                    }
                },
                'columns': [
                    { 'data': 'ExpedienteDocumento'},
                    { 'data': 'DescripcionDocumento'},
                    { 'data': 'NomTipoServicio'},
                    //{ 'data': 'NomTipoUbicacion', 'autoWidth': true},
                    { 'data': 'RequiereDocDigital'},
                    { 'data': 'TieneDocDigital'},
                    { 'data': 'NomTipoServicioOfrecido'},
                    { 'data': 'NomEstadoDetallePrestamo'},
                    {
                        'render': function (data, type, full, meta) {
                            let botones = '';
                            if (full.IdEstadoDetallePrestamo === 12 && full.FlgParaListo === 0){
                                botones += '<button type="button" data-accion="listo" title="Registrar Listo" data-tooltip="Listo" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Listo"><i class="fas fa-check-double"></i></button>';
                            }
                            if (full.IdEstadoDetallePrestamo === 12){
                                botones += '<button type="button" data-accion="presentar-formulario" title="Ver formulario" data-tooltip="Ver formulario" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="VerFormuulario"><i class="fas fa-copy"></i></button>';
                            }
                            if (full.FlgTieneDocDigital === 0){
                                botones += '<button type="button" data-accion="ver-documento" title="Ver documento" data-tooltip="Ver documento" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-eye"></i></button>';
                            }
                            return botones;
                        }, 'className': 'text-center',"width": "20px"
                    }
                ]
            });

            $('#tblDetalleSolicitud tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblDetalleSolicitud.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {
                    case 'listo':
                        if (dataFila.FlgRequiereDocDigital === 0 && dataFila.FlgTieneDocDigital === 1){
                            $.alert("¡Falta subir documento requerido!");
                            return false;
                        }
                        let formData = new FormData();
                        formData.append("Evento","CambiarListo");
                        formData.append("IdDetallePrestamo",dataFila.IdDetallePrestamo);
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegPrestamoDocumentos.php",
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            datatype: "json",
                            success : function() {
                                M.toast({html: '¡Documento listo!'});
                                tblDetalleSolicitud.ajax.reload();
                            }
                        });
                        break;
                    case 'presentar-formulario':
                        $("#codDetalleSolicitud").val(dataFila.IdDetallePrestamo);
                        ContenidosTipo("idTipoServicioOfrecido",8);
                        $("#formularioDatos").css("display","block");
                        break;
                    case 'ver-documento':
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegPrestamoDocumentos.php",
                            method: "POST",
                            data: {
                                 "Evento" : "VerDocumentoPrestamoDetalle"
                                ,"IdDetallePrestamo" : dataFila.IdDetallePrestamo
                            },
                            datatype: "json",
                            success : function(data) {
                                data = JSON.parse(data);
                                //M.toast({html: '¡Documento listo!'});
                                window.open(data.RutaDocDigital, '_blank');
                            }
                        });
                        break;
                }
            });

            $('#btnGuardarDatos').on('click', function (e) {
                e.preventDefault();
                let data = $('#formularioDatos form').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","ActualizarDatosDetallePrestamo");
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Datos guardados correctamente!'});
                        $("#codDetalleSolicitud").val(0);
                        $('#documentoDigital div.row div.col').empty();
                        $('#documentoDigital').css("display","none");
                        $("#formularioDatos").css("display","none");
                        tblDetalleSolicitud.ajax.reload();
                    }
                });
            });

            $('#btnCancelarDatos').on('click', function (e) {
                $("#codDetalleSolicitud").val(0);
                $('#documentoDigital div.row div.col').empty();
                $('#documentoDigital').css("display","none");
                $("#formularioDatos").css("display","none");
            });

            btnAtenderSolicitud.on('click', function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalAtenderSolicitud');
                let instance = M.Modal.init(elem, {dismissible:false});
                let rows_selected = tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEnCurso.rows(rowId).data()[0]);
                });
                $("#codSolicitudPrestamo").val(values[0].IdSolicitudPrestamo);
                tblDetalleSolicitud.ajax.reload();
                instance.open();
            });

            $("#btnNotificar").on("click", function (e) {
                let data = tblDetalleSolicitud.data();
                let noNotificar = false;
                $.each(data, function (i, item) {
                    if (item.IdEstadoDetallePrestamo === 12) {
                        noNotificar = true;
                    }
                });
                if (noNotificar === true){
                    $.alert('¡Falta buscar documentos!');
                    return false;
                }
                let formData = new FormData();
                formData.append("Evento","CargoPrestamo");
                formData.append("IdSolicitudPrestamo",$("#codSolicitudPrestamo").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        let rows_selected = tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected();

                        let values=[];
                        $.each(rows_selected, function (index, rowId) {
                            values.push(tblBandejaSolicitudesEnCurso.rows(rowId).data()[0]);
                        });
                        let fila = values[0];                        

                        $("#idSolicitudPrestamo").val(fila.IdSolicitudPrestamo);
                        $("#idDigital").val(fila.IdArchivoCargoPrestamo);
                        $("#tipo_f").val('f');
                        $("#nroVisto").val(0);
                        $("#idTipoTra").val(2);
                        $("#flgRequireFirmaLote").val(0);
                        $("#firmaRealizada").val("GuardarVistoCargo");

                        sendParam();

                        // M.toast({html: '¡Solicitud notificada!'});
                        // tblBandejaSolicitudesEnCurso.ajax.reload();
                        // let elem = document.querySelector('#modalAtenderSolicitud');
                        // let instance = M.Modal.init(elem, {dismissible:false});
                        // instance.close();
                    }
                });
            });

            $("#btnGenerarDevolucion").on("click", function (e) {
                let data = tblVerDetalleSolicitudPorDevolver.data();
                let noNotificar = false;
                $.each(data, function (i, item) {
                    if (item.IdEstadoDetallePrestamo !== 16) {
                        noNotificar = true;
                    }
                });
                if (noNotificar === true){
                    $.alert('¡Falta devolver documentos!');
                    return false;
                }
                let formData = new FormData();
                formData.append("Evento","CargoPrestamoDevolucion");
                formData.append("IdSolicitudPrestamo",$("#IdSolicitudPrestamoVer").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(responseIdDigital) {
                        let rows_selected = tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected();

                        let values=[];
                        $.each(rows_selected, function (index, rowId) {
                            values.push(tblBandejaSolicitudesEnCurso.rows(rowId).data()[0]);
                        });
                        let fila = values[0];

                        $("#idSolicitudPrestamo").val($("#IdSolicitudPrestamoVer").val());
                        $("#idDigital").val(responseIdDigital);
                        $("#tipo_f").val('v');
                        $("#nroVisto").val(0);
                        $("#idTipoTra").val(2);
                        $("#flgRequireFirmaLote").val(0);
                        $("#firmaRealizada").val("GuardarVistoCargoDevolucion");

                        sendParam();
                    }
                });
            });
            

            var tblBandejaSolicitudesNotificados = $('#tblBandejaSolicitudesNotificados').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstadoSolicitudPrestamo": 8
                                ,"FlgArchivoCentral" : 1
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesNotificados_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesNotificados.rows().deselect();
                    });
                },
                dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
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
                        "width": "25%",
                        "targets": [1,2,3],
                        'orderable': false
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'oficinaOrigen', 'autoWidth': true}
                    ,{'data': 'trabajadorOrigen', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'fechaNotificacion', 'autoWidth': true}
                    ,{'data': 'cantidadNotificaciones', 'autoWidth': true}
                    ,{'data': 'ultimaFecNotificacion', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesNotificados
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesNotificados.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesNotificados.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosNotificados, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            var tblVerDetalleSolicitud = $('#tblVerDetalleSolicitud').DataTable({
                responsive: true,
                searching: false,
                ordering: false,
                paging: false,
                info: false,
                ajax: {
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    type: 'POST',
                    datatype: 'json',
                    data: function ( d ) {
                        return $.extend( {}, d, {
                            "IdSolicitudPrestamo": $('#IdSolicitudPrestamoVer').val(),
                            "Evento": "ObtenerDetalleSolicitud"
                        });
                    }
                },
                "drawCallback": function() {
                    let api = this.api();
                    if (api.data().length === 0){
                        $("#tblVerDetalleSolicitud").css('display','none');
                    } else{
                        $("#tblVerDetalleSolicitud").css('display','block');
                    }
                },
                'columns': [
                    { 'data': 'ExpedienteDocumento', 'autoWidth': true},
                    { 'data': 'DescripcionDocumento', 'autoWidth': true},
                    { 'data': 'NomTipoServicio', 'autoWidth': true},
                    { 'data': 'RequiereDocDigital', 'autoWidth': true},
                    { 'data': 'TieneDocDigital', 'autoWidth': true},
                    { 'data': 'NomTipoServicioOfrecido', 'autoWidth': true},
                    { 'data': 'NomEstadoDetallePrestamo', 'autoWidth': true},
                    {
                        'render': function (data, type, full, meta) {
                            let botones = '';
                            if (full.FlgTieneDocDigital === 0){
                                botones += '<button type="button" data-accion="ver-documento" title="Ver documento" data-tooltip="Ver documento" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-eye"></i></button>';
                            }                            
                            return botones;
                        }, 'className': 'text-center',"width": "20px"
                    }
                ]
            });

            $('#tblVerDetalleSolicitud tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblVerDetalleSolicitud.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {
                    case 'ver-documento':
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegPrestamoDocumentos.php",
                            method: "POST",
                            data: {
                                "Evento" : "VerDocumentoPrestamoDetalle"
                                ,"IdDetallePrestamo" : dataFila.IdDetallePrestamo
                            },
                            datatype: "json",
                            success : function(data) {
                                data = JSON.parse(data);
                                window.open(data.RutaDocDigital, '_blank');
                            }
                        });
                        break;
                }
            });

            $('#btnGuardarDatosDevolver').on('click', function (e) {

                e.preventDefault();
                let data = $('#formularioDevolverDatos form').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","RegistrarDevolucion");
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Datos guardados correctamente!'});
                        $("#codDetalleSolicitudDevolver").val(0);
                        $('#documentoDigitalDevolver div.row div.col').empty();
                        $('#documentoDigitalDevolver').css("display","none");
                        $("#formularioDevolverDatos").css("display","none");
                        tblBandejaSolicitudesPorDevolver.ajax.reload();
                        tblVerDetalleSolicitudPorDevolver.ajax.reload();
                    }
                });
            });

            $('#btnCancelarDatosDevolver').on('click', function (e) {
                $("#codDetalleSolicitudDevolver").val(0);
                $('#documentoDigitalDevolver div.row div.col').empty();
                $('#documentoDigitalDevolver').css("display","none");
                $("#formularioDevolverDatos").css("display","none");
            });

            btnRenotificar.on('click', function (e) {
                let rows_selected = tblBandejaSolicitudesNotificados.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesNotificados.rows(rowId).data()[0]);
                });
                let formData = new FormData();
                formData.append("Evento","ReNotificarSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo",values[0].IdSolicitudPrestamo);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Solicitud notificada!'});
                        tblBandejaSolicitudesNotificados.ajax.reload();
                    }
                });
            });

            var tblBandejaSolicitudesPorDevolver = $('#tblBandejaSolicitudesPorDevolver').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamosPendientesDevolver.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstadoSolicitudPrestamo": 44
                                ,"FlgArchivoCentral" : 1
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesPorDevolver_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesPorDevolver.rows().deselect();
                    });
                },
                dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel' },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
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
                        "width": "25%",
                        "targets": [1,2,3],
                        'orderable': false
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'oficinaOrigen', 'autoWidth': true}
                    ,{'data': 'trabajadorOrigen', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'fechaRecepcion', 'autoWidth': true}
                    ,{'data': 'cantidadAmpliaciones', 'autoWidth': true}
                    ,{'data': 'fechaPlazo', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {
                            let iconos = '';
                            if (full.CantFueraDePlazo > 0) {
                                iconos += '<i class="fas fa-fw fa-flag" style="color: red; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            if (full.CantPorAmpliar > 0) {
                                iconos += '<i class="fab fa-autoprefixer" style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            return iconos
                        },
                    }
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesPorDevolver
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesPorDevolver.rows( { selected: true } ).count();
                    console.log(supportButtonsRecibidosPorDevolver);
                    
                    switch (count) {
                        case 1:
                            $.each( actionButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            let fila = tblBandejaSolicitudesPorDevolver.rows( { selected: true } ).data().toArray()[0];
                            /*if (fila.flgRequiereAmpliacion === 1){
                                btnAmpliarPlazo.css("display","none");
                            }*/
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesPorDevolver.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

                var tblVerDetalleSolicitudPorDevolver = $('#tblVerDetalleSolicitudPorDevolver').DataTable({
                    responsive: true,
                    searching: false,
                    ordering: false,
                    paging: false,
                    info: false,
                    ajax: {
                        url: "registerDoc/RegPrestamoDocumentos.php",
                        type: 'POST',
                        datatype: 'json',
                        data: function ( d ) {
                            return $.extend( {}, d, {
                                "IdSolicitudPrestamo": $('#IdSolicitudPrestamoVer').val(),
                                "Evento": "ObtenerDetalleSolicitud"
                            });
                        }
                    },
                    "drawCallback": function() {
                        let api = this.api();
                        if (api.data().length === 0){
                            $("#tblVerDetalleSolicitudPorDevolver").css('display','none');
                        } else{
                            $("#tblVerDetalleSolicitudPorDevolver").css('display','block');
                        }
                    },
                    'columns': [
                        { 'data': 'ExpedienteDocumento', 'autoWidth': true},
                        { 'data': 'DescripcionDocumento', 'autoWidth': true},
                        { 'data': 'NomTipoServicio', 'autoWidth': true},
                        { 'data': 'RequiereDocDigital', 'autoWidth': true},
                        { 'data': 'TieneDocDigital', 'autoWidth': true},
                        { 'data': 'NomTipoServicioOfrecido', 'autoWidth': true},
                        { 'data': 'NomEstadoDetallePrestamo', 'autoWidth': true},
                        { 'data': 'Observacion', 'autoWidth': true},
                        {
                            'render': function (data, type, full, meta) {
                                let botones = '';
                                if (full.IdEstadoDetallePrestamo === 15){
                                    botones += '<button type="button" data-accion="devolver" title="Registrar devolución" data-tooltip="Registrar devolución" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Devolver"><i class="fas fa-undo-alt"></i></button>';
                                }
                                if (full.FlgTieneDocDigital === 0){
                                    botones += '<button type="button" data-accion="ver-documento" title="Ver documento" data-tooltip="Ver documento" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-eye"></i></button>';
                                }
                                if (full.FlgSolicitudAmpliacionPlaza === 1){
                                    botones += '<button type="button" data-accion="ampliarFecha" title="Ampliar Fecha" data-tooltip="Ampliar Fecha" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ampliar"><i class="far fa-clock"></i></button>';
                                }
                                return botones;
                            }, 'className': 'text-center',"width": "20px"
                        }
                    ]
                });

                $('#tblVerDetalleSolicitudPorDevolver tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblVerDetalleSolicitudPorDevolver.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {
                    case 'devolver':
                        $("#codDetalleSolicitudDevolver").val(dataFila.IdDetallePrestamo);
                        $("#formularioDevolverDatos").css("display","block");                        
                        break;

                    case 'ver-documento':
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegPrestamoDocumentos.php",
                            method: "POST",
                            data: {
                                "Evento" : "VerDocumentoPrestamoDetalle"
                                ,"IdDetallePrestamo" : dataFila.IdDetallePrestamo
                            },
                            datatype: "json",
                            success : function(data) {
                                data = JSON.parse(data);
                                window.open(data.RutaDocDigital, '_blank');
                            }
                        });
                        break;

                    case 'ampliarFecha':
                        e.preventDefault();
                        let ele = document.querySelector('#modalDetalleSolicitudPorDevolver');
                        let instanc = M.Modal.init(ele, {dismissible:false}); 
                        let formDat = new FormData();
                        formDat.append("Evento","AmpliarPlazoSolicitud");
                        formDat.append("IdDetallePrestamo", dataFila.IdDetallePrestamo);
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegPrestamoDocumentos.php",
                            method: "POST",
                            data: formDat,
                            processData: false,
                            contentType: false,
                            datatype: "json",
                            success : function() {
                                M.toast({html: '¡Plazo ampliado!'});
                                tblBandejaSolicitudesPorDevolver.ajax.reload();
                            }
                        });
                        instanc.close();
                        break;
                }
            });

            /*btnAmpliarPlazo.on('click', function (e) {
                e.preventDefault();
                let rows_selected = tblBandejaSolicitudesPorDevolver.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesPorDevolver.rows(rowId).data()[0]);
                });
                let formData = new FormData();
                formData.append("Evento","AmpliarPlazoSolicitud");
                formData.append("IdSolicitudPrestamo", values[0].IdSolicitudPrestamo);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Plazo ampliado!'});
                        tblBandejaSolicitudesPorDevolver.ajax.reload();
                    }
                });
            });*/

            /*btnRegistrarDevolucion.on('click', function (e) {
                e.preventDefault();
                let rows_selected = tblBandejaSolicitudesPorDevolver.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesPorDevolver.rows(rowId).data()[0]);
                });
                let formData = new FormData();
                formData.append("Evento","RegistrarDevolucionSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", values[0].IdSolicitudPrestamo);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Documentos devueltos!'});
                        tblBandejaSolicitudesPorDevolver.ajax.reload();
                    }
                });
            });*/

            btnVerSolicitud.on("click", function (e) {
                let elem = document.querySelector('#modalDetalleSolicitud');
                let instance = M.Modal.init(elem, {dismissible:false});

                var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                } else if (tblBandejaSolicitudesPorDevolver.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesPorDevolver;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                $('#IdSolicitudPrestamoVer').val(values[0].IdSolicitudPrestamo);
                tblVerDetalleSolicitud.ajax.reload();
                instance.open();
            });

            btnVerSolicitudPorDevolver.on("click", function (e) {
                let elem = document.querySelector('#modalDetalleSolicitudPorDevolver');
                let instance = M.Modal.init(elem, {dismissible:false});

                var tablaObtenerDato = tblBandejaSolicitudesPorDevolver;

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                $('#IdSolicitudPrestamoVer').val(values[0].IdSolicitudPrestamo);
                tblVerDetalleSolicitudPorDevolver.ajax.reload();
                instance.open();
            });

            btnAnular.on("click", function (e) {
                let elem = document.querySelector('#modalAnular');
                let instance = M.Modal.init(elem, {dismissible:false});
                $("#observacionAnular").val('');
                instance.open();
            });

            $("#btnAnularSolicitudPrestamo").on("click", function (e) {
                e.preventDefault();
                var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                } else if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","AnularSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("Observacion",$("#observacionAnular").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        data = JSON.parse(data);
                        if (data.ANULADO === 1){
                            M.toast({html: '¡No se pudo anular la solicitud!'});
                        } else {
                            M.toast({html: '¡Solicitud anulada!'});
                        }
                        let elem = document.querySelector('#modalAnular');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tablaObtenerDato.ajax.reload();
                    }
                });

            });

            btnObservar.on("click", function (e) {
                let elem = document.querySelector('#modalObservar');
                let instance = M.Modal.init(elem, {dismissible:false});
                $("#observacionObservar").val('');
                instance.open();
            });

            $("#btnObservarSolicitudPrestamo").on("click", function (e) {
                e.preventDefault();
                var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                } else if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","ObservarSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("Observacion",$("#observacionObservar").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        data = JSON.parse(data);
                        if (data.ANULADO === 1){
                            M.toast({html: '¡No se pudo observar la solicitud!'});
                        } else {
                            M.toast({html: '¡Solicitud observada!'});
                        }
                        let elem = document.querySelector('#modalObservar');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tablaObtenerDato.ajax.reload();
                    }
                });

            });

            btnValidarSolicitud.on("click", function (e) {
                let rows_selected = tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEnCurso.rows(rowId).data()[0]);
                });
                let fila = values[0];

                $.ajax({
                    cache: 'false',
                    url: 'ajax/ajaxOficinas.php',
                    method: 'POST',
                    data: {esTupa: '0', esPrestamo: '1'},
                    datatype: 'json',
                    success: function (data) {
                        
                        $("#OficinaRequeridaValidar").val("");
                        $('#OficinaRequeridaValidar').empty().append('<option value="">Seleccione</option>');
                        let documentos = JSON.parse(data);
                        $.each(documentos.data, function (key,value) {
                            $('#OficinaRequeridaValidar').append(value);
                        });

                        $("#OficinaRequeridaValidar").val(fila.IdOficinaRequerida);
                        $('#OficinaRequeridaValidar').formSelect().trigger("change");

                        let elem = document.querySelector('#modalValidar');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.open();
                    }
                });                
            });

            $("#btnValidarSolicitudPrestamo").on("click", function (e) {
                e.preventDefault();

                let rows_selected = tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEnCurso.rows(rowId).data()[0]);
                });
                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","ValidarSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("OficinaRequeridaValidar",$("#OficinaRequeridaValidar").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        M.toast({html: '¡Solicitud validada!'});
                        let elem = document.querySelector('#modalValidar');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tblBandejaSolicitudesEnCurso.ajax.reload();
                    }
                });
            });

            btnFirmarSolicitud.on("click", function (e) {
                let rows_selected = tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected();

                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEnCurso.rows(rowId).data()[0]);
                });
                let fila = values[0];

                console.log(fila);

                $("#idSolicitudPrestamo").val(fila.IdSolicitudPrestamo);
                $("#idDigital").val(fila.IdArchivoSolicitud);
                $("#tipo_f").val('f');
                $("#nroVisto").val(0);
                $("#idTipoTra").val(2);
                $("#flgRequireFirmaLote").val(0);

                sendParam();
            });

            btnDevolverFaltaDatos.on("click", function (e) {
                let elem = document.querySelector('#modalDevolverFaltaDatos');
                let instance = M.Modal.init(elem, {dismissible:false});
                $("#observacionDevolverFaltaDatos").val('');
                instance.open();
            });

            $("#btnDevolverFaltaDatosSolicitudPrestamo").on("click", function (e) {
                e.preventDefault();
                var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                } else if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","DevolverFaltaDatosSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("Observacion",$("#observacionDevolverFaltaDatos").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        data = JSON.parse(data);
                        if (data.DEVUELTO === 1){
                            M.toast({html: '¡No se pudo devolver la solicitud!'});
                        } else {
                            M.toast({html: '¡Solicitud devuelta!'});
                        }
                        let elem = document.querySelector('#modalDevolverFaltaDatos');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tablaObtenerDato.ajax.reload();
                    }
                });

            });

            btnDevolverNoObrarArchivo.on("click", function (e) {
                let elem = document.querySelector('#modalDevolverNoObrarArchivo');
                let instance = M.Modal.init(elem, {dismissible:false});
                $("#observacionDevolverNoObrarArchivo").val('');
                instance.open();
            });

            $("#btnDevolverNoObrarArchivoSolicitudPrestamo").on("click", function (e) {
                e.preventDefault();
                var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                } else if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","DevolverNoObrarArchivoSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("Observacion",$("#observacionDevolverNoObrarArchivo").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        data = JSON.parse(data);
                        if (data.DEVUELTO === 1){
                            M.toast({html: '¡No se pudo devolver la solicitud!'});
                        } else {
                            M.toast({html: '¡Solicitud devuelto!'});
                        }
                        let elem = document.querySelector('#modalDevolverNoObrarArchivo');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tablaObtenerDato.ajax.reload();
                    }
                });

            });

            btnAmpliarPLazoAtencion.on("click", function (e) {
                let elem = document.querySelector('#modalAmpliarPlazo');
                let instance = M.Modal.init(elem, {dismissible:false});
                $("#observacionAmpliarPlazoAtencion").val('');
                instance.open();
            });

            $("#btnAmpliarPlazoAtencion").on("click", function (e) {
                e.preventDefault();
                var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                } else if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","AmpliarPLazoAtencionSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("Observacion",$("#observacionAmpliarPLazoAtencion").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        data = JSON.parse(data);
                        if (data.AMPLIADO === 1){
                            M.toast({html: '¡No se pudo ampliar la fecha de atención la solicitud!'});
                        } else {
                            M.toast({html: '¡Fecha de atención ampliada!'});
                        }
                        let elem = document.querySelector('#modalAmpliarPlazo');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tablaObtenerDato.ajax.reload();
                    }
                });

            });

            $("#FlgTipoDocumento").on("change",function (e) {
                if ($("#FlgTipoDocumento:checked").length === 1){
                    $("#idTipoServicioOfrecido").parent().parent().css("display","inline-block")
                } else {
                    $("#idTipoServicioOfrecido").parent().parent().css("display","none")
                }
            });

            $('#btnEnCurso').on('click', function (e) {
                tblBandejaSolicitudesEnCurso.ajax.reload();
                $("div.actionButtons button").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnNotificados').on('click', function (e) {
                tblBandejaSolicitudesNotificados.ajax.reload();
                $("div.actionButtons button").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnPorDevolver').on('click', function (e) {
                tblBandejaSolicitudesPorDevolver.ajax.reload();
                $("div.actionButtons button").css("display","none");
                $('.actionButtons').hide(100);
            });

            btnHistorico.on('click', function(e) {
                var elems = document.querySelector('#modalHistorico');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();

                var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                } else if (tblBandejaSolicitudesPorDevolver.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesPorDevolver;
                } else if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                } 

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });

                var fila = values[0];

                $.post("registerDoc/RegPrestamoDocumentos.php", 
                    {
                        Evento: "ObtenerHistorico", 
                        IdSolicitudPrestamo: fila.IdSolicitudPrestamo
                    })
                    .done(function(response){
                        var html = `<table>
                            <thead>
                                <tr>
                                    <th>Responsable</th>
                                    <th>Estado</th>                                
                                    <th>Fecha</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>`;

                        var datos = $.parseJSON(response);
                        datos.forEach(elem => {
                            html += `<tr>
                                    <td>${elem.Trabajador}</td>
                                    <td>${elem.Estado}</td>
                                    <td>${elem.FecRegistro}</td>
                                    <td>${elem.Observacion == null ? '' : elem.Observacion}</td>
                                </tr>`;
                        });

                        html += `</tbody></table>`;
                        $('#modalHistorico div.modal-content').html(html);
                        instance.open();
                    });
            });

            btnVerDocSolicitud.on("click", function (e) {
                var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                } else if (tblBandejaSolicitudesPorDevolver.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesPorDevolver;
                } else if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                }
                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });

                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","VerSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("codTipo", 1);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(ruta) {
                        if(ruta != ''){
                            window.open(ruta, '_blank');
                        }
                    }
                });
            });

            btnVerDocCargo.on("click", function (e) {
                var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                } else if (tblBandejaSolicitudesPorDevolver.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesPorDevolver;
                } else if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                }
                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });

                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","VerSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("codTipo", 2);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(ruta) {
                        if(ruta != ''){
                            window.open(ruta, '_blank');
                        }
                    }
                });
            });

            btnVerDocDevolucion.on("click", function (e) {
                var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                if (tblBandejaSolicitudesNotificados.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesNotificados;
                } else if (tblBandejaSolicitudesPorDevolver.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesPorDevolver;
                } else if (tblBandejaSolicitudesEnCurso.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesEnCurso;
                }
                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });

                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","VerSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("codTipo", 3);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(ruta) {
                        if(ruta != ''){
                            window.open(ruta, '_blank');
                        }
                    }
                });
            });

        });

        Dropzone.autoDiscover = false;
        $("div#dropzoneDocDigital").dropzone({
            url: "ajax/cargarDoc.php",
            paramName: "fileUpLoadDigital",
            autoProcessQueue: false,
            maxFiles: 1,
            acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
            addRemoveLinks: true,
            maxFilesize: 1200, // MB
            uploadMultiple: true,
            parallelUploads: 1,
            dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
            dictInvalidFileType: "Archivo no válido",
            dictMaxFilesExceeded: "Solo 1 archivo son permitido",
            dictCancelUpload: "Cancelar",
            dictRemoveFile: "Remover",
            dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
            dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
            dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",

            init: function () {
                var myDropzone = this;
                $("#btnSubirDocDigital").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let queuedFiles = myDropzone.getQueuedFiles();
                    if (queuedFiles.length > 0) {
                        event.preventDefault();
                        event.stopPropagation();
                        myDropzone.processQueue();
                    }else{
                        $.alert('¡No hay documentos para subir al sistema!');
                    }
                });

                $("#btnCancelarDatos").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('div#formularioDatos').css('display','none');
                    myDropzone.removeAllFiles();
                    $('#documentoDigital div.row div.col').empty();
                    $('#documentoDigital').css("display","none");
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append('IdTipo','11')
                });

                this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        if (fila.evento === 'REGISTRADO' || fila.evento === 'REPETIDO'){
                            let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoDigital[]" value="'+fila.codigo+'"><span><a href="'+fila.servidor+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
                            $('#documentoDigital div.row div.col').append(check);
                            $('#documentoDigital').css('display', 'block');
                        }
                        M.toast({html: fila.mensaje});
                    });
                    this.removeAllFiles();
                });

            }

        });

        $("div#dropzoneDocDigitalDevolver").dropzone({
            url: "ajax/cargarDoc.php",
            paramName: "fileUpLoadDigital",
            autoProcessQueue: false,
            maxFiles: 1,
            acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
            addRemoveLinks: true,
            maxFilesize: 1200, // MB
            uploadMultiple: true,
            parallelUploads: 1,
            dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
            dictInvalidFileType: "Archivo no válido",
            dictMaxFilesExceeded: "Solo 1 archivo son permitido",
            dictCancelUpload: "Cancelar",
            dictRemoveFile: "Remover",
            dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
            dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
            dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",

            init: function () {
                var myDropzone = this;
                $("#btnSubirDocDigitalDevolver").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let queuedFiles = myDropzone.getQueuedFiles();
                    if (queuedFiles.length > 0) {
                        event.preventDefault();
                        event.stopPropagation();
                        myDropzone.processQueue();
                    }else{
                        $.alert('¡No hay documentos para subir al sistema!');
                    }
                });

                $("#btnCancelarDatosDevolver").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('div#formularioDevolverDatos').css('display','none');
                    myDropzone.removeAllFiles();
                    $('#documentoDigitalDevolver div.row div.col').empty();
                    $('#documentoDigitalDevolver').css("display","none");

                    /*let elem = document.querySelector('#modalEntrega');
                    let instance = M.Modal.init(elem, {dismissible:false});
                    instance.close();*/
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append('IdTipo','11')
                    formData.append('nombreCarpeta','Prestamo/DocDigital')
                });

                this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        if (fila.evento === 'REGISTRADO' || fila.evento === 'REPETIDO'){
                            let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoDigitalDevolver[]" value="'+fila.codigo+'"><span><a href="'+fila.servidor+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
                            $('#documentoDigitalDevolver div.row div.col').append(check);
                            $('#documentoDigitalDevolver').css('display', 'block');
                        }
                        M.toast({html: fila.mensaje});
                    });
                    this.removeAllFiles();
                });

            }

        });
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>