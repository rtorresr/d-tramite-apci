<?php
    session_start();
    $pageTitle = "Bandeja de Despacho";
    $activeItem = "Despacho-mesa-partes.php";
    $navExtended = true;

    if($_SESSION['CODIGO_TRABAJADOR']!=""){
        $url = "https://app.apci.gob.pe/ApiPide/token";
        $data = array(
            "UserName" =>  "8/user-dtramite",
            "Password" =>   "123456",
            "grant_type" => "password"
        );

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
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <main>
        <input id="token" type="hidden" value="<?php echo $response->token_type . ' ' . $response->access_token; ?>">
        <div class="navbar-fixed actionButtons">
            <nav>
                <ul id="nav-mobile" class="">
                    <li><a id="btnEntregar" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Entregar</span></a></li>
                    <li><a id="btnDevolver" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Devolver</span></a></li>
                    <li><a id="btnFinalizarDevolucion" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Finalizar Devolución</span></a></li>
                    <li><a id="btnDetail" style="display: none" class="btn btn-link"><i class="fas fa-info fa-fw left"></i><span>Detalle</span></a></li>
                    <li><a id="btnFlow" style="display: none" class="btn btn-link"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                    <li><a id="btnDoc" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>
                    <li><a id="btnAnexos" style="display: none" class="btn btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                </ul>
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
                                        <li id="btnPendientesEnvio" class="tab col s3"><a href="#pendientesEnvio">Pendiente de envío</a></li>
                                        <li id="btnEnviadosFisicamente" class="tab col s3"><a href="#enviadosFisicamente">Enviados</a></li>
                                        <li id="btnPendientesDevolucion" class="tab col s3"><a href="#pendientesDevolucion"> Pendientes Devolver</a></li>
                                    </ul>
                                </div>
                                <div id="pendientesEnvio" class="col s12">
                                    <table id="tblDespachoMesaPartesPendientes" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>CUD</th>
                                            <th>Documento</th>
                                            <th>Asunto</th>
                                            <th>Nombre Destinatario</th>
                                            <th>Dirección</th>
                                            <th>Ubigeo</th>
                                            <th>Zona</th>
                                            <th>Fecha enviado</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="enviadosFisicamente" class="col s12">
                                    <table id="tblDespachoMesaPartesEnviados" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>CUD</th>
                                            <th>Documento</th>
                                            <th>Asunto</th>
                                            <th>N° doc Entrega</th>
                                            <th>Mensajeria</th>
                                            <th>N° Orden Entrega</th>
                                            <th>Fecha Entrega</th>
                                            <th>Nombre Destinatario</th>
                                            <th>Dirección</th>
                                            <th>Ubigeo</th>
                                            <th>Zona</th>
                                            <th>Plazo</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="pendientesDevolucion" class="col s12">
                                    <table id="tblDespachoMesaPartesPendientesDevolucion" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>N° Orden Devolución</th>
                                            <th>Empresa Responsable</th>
                                            <th>Trabajador Responsable</th>
                                            <th>Trabajador Validador</th>
                                            <th>Fecha de Registro</th>
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

    <div id="modalEntrega" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Entrega documentos</h4>
        </div>
        <div class="modal-content">
            <div id="formDatosParteUno">
                <form>
                    <div class="col s12 input-field">
                        <p for="flgEnvioPropio">Institución a cargo:</p>
                        <div class="switch">
                            <label>
                                APCI
                                <input type="checkbox" id="flgEnvioPropio" name="flgEnvioPropio" value="1">
                                <span class="lever"></span>
                                Empresa Externa
                            </label>
                        </div>
                    </div>
                    <div class="row" id="datosPropios">
                        <div class="col s6 input-field ">
                            <select id="codTrabajadorMensajeria" class="js-data-example-ajax browser-default" name="codTrabajadorMensajeria"></select>
                            <label for="codTrabajadorMensajeria">Responsable</label>
                        </div>
                    </div>
                    <div class="row" id="datosEmpresaExterna" style="display: none;">
                        <div class="col s12 input-field ">
                            <select id="codEmpresaResponsable" name="codEmpresaResponsable">
                            </select>
                            <label for="codEmpresaResponsable">Empresa responsable</label>
                        </div>
                        <div class="col s3 input-field">
                            <input type="text" name="nroDNI" id="nroDNI">
                            <label for="nroDNI">N° de DNI</label>
                        </div>
                        <div class="col s1 input-field">
                            <a class="waves-effect waves-light btn" id="btnBuscarDNI"><i class="fas fa-search"></i></a>
                        </div>
                        <div class="col s8 input-field ">
                            <input type="text" name="nombreResponsableExterno" id="nombreResponsableExterno">
                            <label for="nombreResponsableExterno">Nombre Responsable</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table id="tablaDocsEntrega">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Cud</th>
                                    <th>Documento</th>
                                    <th>Destinatario</th>
                                    <th>Dirección</th>
                                    <th>Ubigeo</th>
                                    <th>Zona</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <form action="FormatoEntrega.php" method="post" target="_blank" id="abrirPdf"></form>
            <div id="formDatosParteDos" style="display: none;">
                <form>
                    <input type="hidden" value="&nbsp;" name="codDespachoOrden">
                    <div class="row">
                        <div class="col s12 input-field input-disabled">
                            <input type="text" name="nroFormatoEntrega">
                            <label for="nroFormatoEntrega">N° Formato de Entrega</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 input-field ">
                            <input id="nroOrden" name="nroOrden" type="text" class="validate">
                            <label for="nroOrden">Nº de la orden</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s12">
                            <div id="dropzoneEntrega" class="dropzone" style="width:100%"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button type="button" class="btn btn-secondary" id="btnSubirDocEntrega">Subir</button>
                        </div>
                    </div>
                    <div id="documentoArchivoEntrega" style="display: none">
                        <p style="padding: 0 15px">Seleccione archivo:</p>
                        <div class="row" style="padding: 0 15px">
                            <div class="col s12">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a id="btnGenerarFormatoEntrega" class="waves-effect waves-green btn-flat">Generar Formato</a>
            <a id="btnFinalizarEntrega" style="display: none;" class="waves-effect waves-green btn-flat">Finalizar Entrega</a>
            <a id="btnCancelarEntrega" class="waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>

    <div id="modalDevolucion" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Devolución de documentos</h4>
        </div>
        <div class="modal-content">
            <form id="formDevolucion">
                <div class="row">
                    <div class="col s6 input-field">
                        <p for="flgEnvioPropioDevolucion">Institución a cargo:</p>
                        <div class="switch">
                            <label>
                                APCI
                                <input type="checkbox" id="flgEnvioPropioDevolucion" name="flgEnvioPropioDevolucion" value="1">
                                <span class="lever"></span>
                                Empresa Externa
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6 input-field ">
                        <input id="nroDevolucion" name="nroDevolucion" type="text" class="validate">
                        <label for="nroDevolucion">Nº de Guía devolución</label>
                    </div>
                </div>
                <div class="row" id="datosPropiosDevolucion">
                    <div class="col s12 input-field ">
                        <select id="codTrabajadorMensajeriaDevolucion" class="js-data-example-ajax browser-default" name="codTrabajadorMensajeriaDevolucion"></select>
                        <label for="codTrabajadorMensajeriaDevolucion">Trabajador encargado</label>
                    </div>
                </div>
                <div class="row" id="datosEmpresaExternaDevolucion" style="display: none;">
                    <div class="col s12 input-field ">
                        <select id="codEmpresaMensajeriaDevolucion" name="codEmpresaMensajeriaDevolucion">
                        </select>
                        <label for="codEmpresaMensajeriaDevolucion">Empresa de mensajería</label>
                    </div>
                    <div class="col s3 input-field">
                        <input type="text" name="nroDNIDevolucion" id="nroDNIDevolucion">
                        <label for="nroDNIDevolucion">N° de DNI</label>
                    </div>
                    <div class="col s1 input-field">
                        <a class="waves-effect waves-light btn" id="btnBuscarDNIDevolucion"><i class="fas fa-search"></i></a>
                    </div>
                    <div class="col s8 input-field">
                        <input type="text" name="nombreResponsableExternoDevolucion" id="nombreResponsableExternoDevolucion">
                        <label for="nombreResponsableExternoDevolucion">Nombre Responsable</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table id="tablaDocsDevolucion">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Cud</th>
                                <th>Documento</th>
                                <th>N° doc Entrega</th>
                                <th>Mensajería</th>
                                <th>N° Orden Entrega</th>
                                <th>Fecha Entrega</th>
                                <th>Plazo</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="file-field input-field col s12">
                        <div id="dropzoneDevolucion" class="dropzone" style="width:100%"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button type="button" class="btn btn-secondary" id="btnSubirDocDevolucion">Subir</button>
                    </div>
                </div>
                <div id="documentoArchivoDevolucion" style="display: none">
                    <p style="padding: 0 15px">Seleccione archivo:</p>
                    <div class="row" style="padding: 0 15px">
                        <div class="col s12">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a id="btnRegistrarDevolucion" class="waves-effect waves-green btn-flat">Registrar Devolución</a>
            <a id="btnCancelarRegistrarDevolucion" class="waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>

    <div id="modalDevolucionDetalle" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Devolución de documentos</h4>
        </div>
        <div class="modal-content">
            <input type="hidden" id="IdDespachoDevolucion" value="0">
            <div class="row">
                <div class="col s12">
                    <table id="TblDocsCompletarDev" style="display: none;width: 100%">
                        <thead>
                        <tr>
                            <th>Cud</th>
                            <th>Documento</th>
                            <th>Destinario</th>
                            <th>Orden Entrega</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <form id="formCompletarDev" style="display: none">
                <input type="hidden" value="&nbsp;" name="codigoDetalle">
                <input type="hidden" value="&nbsp;" name="idTramite">
                <div class="row">
                    <div class="col s12 input-field">
                        <p for="flgNotificacionCorrecto">Estado Notificación: </p>
                        <div class="switch">
                            <label>
                                Bien Notificado
                                <input type="checkbox" id="flgNotificacionCorrecto" name="flgNotificacionCorrecto" value="1" >
                                <span class="lever"></span>
                                Mal Notificado
                            </label>
                        </div>
                    </div>
                    <div class="col s12 input-field ">
                        <input placeholder="dd-mm-aaaa" value="" type="text" id="FecContactoCompletar" name="FecContactoCompletar" class="datepicker">
                        <label for="FecContactoCompletar">Fecha de notificación</label>
                    </div>
                    <div class="col s6 input-field ">
                        <select id="codContacto" name="codContacto">
                        </select>
                        <label for="codContacto">Tipo de notificación</label>
                    </div>
                    <div class="col s6 input-field ">
                        <select id="codTipoContacto" name="codTipoContacto">
                        </select>
                        <label for="codTipoContacto">Motivo de contacto</label>
                    </div>
                    <div class="col s6 input-field ">
                        <input type="text" id="observacionComDev" name="observacionComDev">
                        <label for="observacionComDev">Observación</label>
                    </div>
                    <div class="col s6 input-field ">
                        <input type="number" id="nroVisitasDev" name="nroVisitasDev" value="1">
                        <label for="nroVisitasDev">N° de visitas realizadas</label>
                    </div>
                    <div class="col s6 input-field" style="display: none">
                        <select id="codTipoMalNotificado" name="codTipoMalNotificado">
                        </select>
                        <label for="codTipoMalNotificado">Motivo mal notificado</label>
                    </div>
                </div>
                <div class="row">
                    <div class="file-field input-field col s12">
                        <div id="dropzoneCargo" class="dropzone" style="width:100%"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button type="button" class="btn btn-secondary" id="btnSubirDocCargo">Subir</button>
                    </div>
                </div>
                <div id="documentoArchivoCargo" style="display: none">
                    <p style="padding: 0 15px">Seleccione archivo:</p>
                    <div class="row" style="padding: 0 15px">
                        <div class="col s12">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-secondary" id="btnGuardarDatosDetalleDevolucion"> Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btnCancelarDatosDetalleDevolucion"> Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a id="btnFinalizarDevolución" class="waves-effect waves-green btn-flat">Finalizar Devolución</a>
            <a id="btnCancelarDevolucionDetalle" class="waves-effect waves-green btn-flat">Cancelar</a>
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
        <div class="modal-content" style="text-align: center; overflow: hidden;">
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

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>
    <script src="includes/dropzone.js"></script>
    <script>
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

        function SelectTwoTrabajadorMensajeria(idSelect, idmodal){
            $('#'+idSelect).select2({
                dropdownParent: $('#'+ idmodal),
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
                    url: 'ajax/ajaxBuscarTrabajadorMensajeria.php',
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
        }

        function ListaEmpresasMensajeria(idDestino){
            $.ajax({
                cache: false,
                url: "ajax/ajaxListaEmpresasMensajeria.php",
                datatype: "json",
                success : function(data) {
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

        SelectTwoTrabajadorMensajeria('codTrabajadorMensajeria', 'modalEntrega');
        SelectTwoTrabajadorMensajeria('codTrabajadorMensajeriaDevolucion', 'modalDevolucion');
        SelectTwoTrabajadorMensajeria('codTrabajadorValidador', 'modalDevolucion');

        $(document).ready(function() {
            $('.actionButtons').hide();

            var btnEntregar = $("#btnEntregar");
            var btnDevolver = $("#btnDevolver");
            var btnFinalizarDevolucion = $("#btnFinalizarDevolucion");

            var btnDetail = $("#btnDetail");
            var btnFlow = $("#btnFlow");
            var btnDoc = $("#btnDoc");
            var btnAnexos = $("#btnAnexos");

            var actionButtonsPendientesEnvio = [btnEntregar];
            var supportButtonsPendientesEnvio = [btnDetail, btnFlow, btnDoc, btnAnexos];

            var actionButtonsEnviadosFisicamente = [btnDevolver];
            var supportButtonsEnviadosFisicamente = [btnDetail, btnFlow, btnDoc, btnAnexos];

            var actionButtonsPendientesDevolucion = [];
            var supportButtonsPendientesDevolucion = [btnFinalizarDevolucion];

            var tblDespachoMesaPartesPendientes = $('#tblDespachoMesaPartesPendientes').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdDespachoMesaPartes.php',
                    type: 'POST',
                    data: function (d) {
                        return $.extend( {}, d, {
                            "estado": 23,
                        } );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblDespachoMesaPartesPendientes_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblDespachoMesaPartesPendientes.rows().deselect();
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
                        'targets': [1],
                        'orderable': false
                    },
                    {
                        "width": "25%",
                        "targets": [4],
                        'orderable': false
                    },
                    {
                        "width": "40px",
                        "targets": [1],
                        'orderable': false
                    },
                    {
                        "width": "12%",
                        "targets": [3,5],
                        'orderable': false
                    },
                    {
                        "width": "10px",
                        "targets": [2]
                    },
                    {
                        "width": "65px",
                        "targets": [6, 7]
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {

                            let iconos = '';

                            if (full.adjuntos !== 0) {
                                iconos += '<i class="fas fa-fw fa-paperclip"style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }else{
                                iconos += '<i class="fas fa-fw fa-paperclip" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }

                            return iconos
                        },
                    }
                    ,{'data': 'cud', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'asunto', 'autoWidth': true}
                    ,{'data': 'nombreDestinatario', 'autoWidth': true}
                    ,{'data': 'direccion', 'autoWidth': true}
                    ,{'data': 'ubigeo', 'autoWidth': true}
                    ,{'data': 'zonaEntrega', 'autoWidth': true}
                    ,{'data': 'FecRegistro', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblDespachoMesaPartesPendientes
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblDespachoMesaPartesPendientes.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();
                            break;

                        default:
                            $.each( actionButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblDespachoMesaPartesPendientes.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            break;

                        default:
                            $.each( actionButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesEnvio, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            btnEntregar.on('click', function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalEntrega');
                let instance = M.Modal.init(elem, {dismissible:false});
                ListaEmpresasMensajeria("codEmpresaResponsable");

                let rows_selected = tblDespachoMesaPartesPendientes.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblDespachoMesaPartesPendientes.rows(rowId).data()[0]);
                });
                $("#tablaDocsEntrega tbody").empty();
                $.each(values, function (index, fila) {
                    let fil = '<tr>' +
                        '          <td>' +
                        '               <p>' +
                        '                   <label>' +
                        '                       <input type="checkbox" checked="checked" value="'+fila.IdDespachoDetalle+'" name="despachoDetalle[]" />' +
                        '                       <span>&nbsp;</span>' +
                        '                   </label>' +
                        '               </p>' +
                        '           </td>' +
                        '           <td>'+fila.cud+'</td>' +
                        '           <td>'+fila.documento+'</td>' +
                        '           <td>'+fila.nombreDestinatario+'</td>' +
                        '           <td>'+fila.direccion+'</td>' +
                        '           <td>'+fila.ubigeo+'</td>' +
                        '           <td>'+fila.zonaEntrega+'</td>' +
                        '       </tr>';
                    $('#tablaDocsEntrega tbody').append(fil);
                });

                $("#formDatosParteUno").css('display', 'block');
                $("#formDatosParteDos").css('display', 'none');
                $("#btnGenerarFormatoEntrega").css('display', 'inline-block');
                $("#btnFinalizarEntrega").css('display', 'none');
                instance.open();
            });

            $("#btnGenerarFormatoEntrega").on('click',function (e) {
                e.preventDefault();
                if ($("#flgEnvioPropio:checked").length === 0){
                    if($("#codTrabajadorMensajeria").val() === null){
                        $.alert('¡Falta seleccionar trabajador!');
                        return false;
                    }
                } else {
                    if ($('#nombreResponsableExterno').val() === ''){
                        $.alert('¡Falta nombres responsable externo!');
                        return false;
                    }
                }

                let data = $('#formDatosParteUno form').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","RegistrarOrden");
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxDespacho.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        data = JSON.parse(data);
                        $("#abrirPdf").empty();
                        $.each(data, function (x,y) {
                            let inp = "<input type='hidden' name='"+x+"' value='"+y+"'>";
                            $("#abrirPdf").append(inp);
                        });
                        $("#abrirPdf").submit();
                        $("#formDatosParteDos form input[name='codDespachoOrden']").val(data.CODIGO);
                        $("#formDatosParteDos form input[name='nroFormatoEntrega']").val(data.DOCUMENTO).next().addClass('active');;
                        $("#formDatosParteUno").css('display', 'none');
                        $("#formDatosParteDos").css('display', 'block');
                        $("#btnGenerarFormatoEntrega").css('display', 'none');
                        $("#btnFinalizarEntrega").css('display', 'inline-block');
                    }
                });
            });

            $("#btnFinalizarEntrega").on('click',function (e) {
                e.preventDefault();
                if ($('#documentoArchivoEntrega div.row div.col input[type="checkbox"]:checked').length !== 1){
                    $.alert('¡Falta agregar el documento digital!');
                    return false;
                }

                let elem = document.querySelector('#modalEntrega');
                let instance = M.Modal.init(elem, {dismissible:false});
                let data = $('#formDatosParteDos form').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","FinalizarEntrega");
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxDespacho.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        tblDespachoMesaPartesPendientes.ajax.reload();
                        M.toast({html: '¡Documentos entregados!'});
                        instance.close();
                        $('#documentoArchivoEntrega div.row div.col').empty();
                        $('#documentoArchivoEntrega').css("display","none");
                    }
                });
            });

            var tblDespachoMesaPartesEnviados = $('#tblDespachoMesaPartesEnviados').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdDespachoMesaPartes.php',
                    type: 'POST',
                    data: function (d) {
                        return $.extend( {}, d, {
                            "estado": 26,
                        } );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblDespachoMesaPartesEnviados_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblDespachoMesaPartesEnviados.rows().deselect();
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
                        'targets': [1],
                        'orderable': false
                    },
                    {
                        "width": "15%",
                        "targets": [4],
                        'orderable': false
                    },
                    {
                        "width": "40px",
                        "targets": [1],
                        'orderable': false
                    },
                    {
                        "width": "12%",
                        "targets": [3],
                        'orderable': false
                    },
                    {
                        "width": "10%",
                        "targets": [7],
                        'orderable': false
                    },
                    {
                        "width": "10px",
                        "targets": [2,6]
                    },
                    {
                        "width": "65px",
                        "targets": [8]
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {

                            let iconos = '';

                            if (full.adjuntos !== 0) {
                                iconos += '<i class="fas fa-fw fa-paperclip"style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }else{
                                iconos += '<i class="fas fa-fw fa-paperclip" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }

                            return iconos
                        },
                    }
                    ,{'data': 'cud', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'asunto', 'autoWidth': true}
                    ,{'data': 'docEntrega', 'autoWidth': true}
                    ,{'data': 'tipoMensajeria', 'autoWidth': true}
                    ,{'data': 'ordenEntrega', 'autoWidth': true}
                    ,{'data': 'fecEntrega', 'autoWidth': true}
                    ,{'data': 'nombreDestinatario', 'autoWidth': true}
                    ,{'data': 'direccion', 'autoWidth': true}
                    ,{'data': 'ubigeo', 'autoWidth': true}
                    ,{'data': 'zonaEntrega', 'autoWidth': true}
                    ,{'data': 'plazo', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblDespachoMesaPartesEnviados
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblDespachoMesaPartesEnviados.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();
                            break;

                        default:
                            $.each( actionButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblDespachoMesaPartesEnviados.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            break;

                        default:
                            $.each( actionButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEnviadosFisicamente, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            btnDevolver.on('click', function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalDevolucion');
                let instance = M.Modal.init(elem, {dismissible:false});
                ListaEmpresasMensajeria("codEmpresaMensajeriaDevolucion");

                let rows_selected = tblDespachoMesaPartesEnviados.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblDespachoMesaPartesEnviados.rows(rowId).data()[0]);
                });
                $("#tablaDocsDevolucion tbody").empty();
                $.each(values, function (index, fila) {
                    let fil = '<tr>' +
                        '           <td>' +
                        '               <p>' +
                        '                   <label>' +
                        '                       <input type="checkbox" checked="checked" value="'+fila.IdDespachoDetalle+'" name="despachoDetalleDevolucion[]" />' +
                        '                       <span>&nbsp;</span>' +
                        '                   </label>' +
                        '               </p>' +
                        '           </td>' +
                        '           <td>'+fila.cud+'</td>' +
                        '           <td>'+fila.documento+'</td>' +
                        '           <td>'+fila.docEntrega+'</td>' +
                        '           <td>'+fila.tipoMensajeria+'</td>' +
                        '           <td>'+fila.ordenEntrega+'</td>' +
                        '           <td>'+fila.fecEntrega+'</td>' +
                        '           <td>'+fila.plazo+'</td>' +
                        '       </tr>';
                    $('#tablaDocsDevolucion tbody').append(fil);
                });
                instance.open();
            });

            $("#btnRegistrarDevolucion").on('click',function (e) {
                e.preventDefault();
                if ($("#flgEnvioPropioDevolucion:checked").length === 0){
                    if ($('#codTrabajadorMensajeriaDevolucion').val() === null){
                        $.alert('¡Falta seleccionar trabajador encargado!');
                        return false;
                    }
                } else {
                    if ($('#nroDNIDevolucion').val() === ''){
                        $.alert('¡Falta DNI responsable externo!');
                        return false;
                    }
                    if ($('#nombreResponsableExternoDevolucion').val() === ''){
                        $.alert('¡Falta nombres responsable externo!');
                        return false;
                    }
                }
                if ($('#documentoArchivoDevolucion div.row div.col input[type="checkbox"]:checked').length !== 1){
                    $.alert('¡Falta agregar el documento digital!');
                    return false;
                }

                let data = $('#modalDevolucion form#formDevolucion').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","RegistrarDevolucion");
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxDespacho.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function(data) {
                        M.toast({html: '¡Devolución registrada!'});
                        $('#documentoArchivoDevolucion div.row div.col').empty();
                        $('#documentoArchivoDevolucion').css("display","none");
                        tblDespachoMesaPartesEnviados.ajax.reload();
                        let elem = document.querySelector('#modalDevolucion');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                    }
                });
            });

            var tblDespachoMesaPartesPendientesDevolucion = $('#tblDespachoMesaPartesPendientesDevolucion').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdOrdenesDevolucion.php',
                    type: 'POST',
                    data: function (d) {
                        return $.extend( {}, d, {
                            "Finalizado": 1,
                        } );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblDespachoMesaPartesEnviados_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblDespachoMesaPartesEnviados.rows().deselect();
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
                        'targets': [1],
                        'orderable': false
                    },
                    {
                        "width": "15%",
                        "targets": [4],
                        'orderable': false
                    },
                    {
                        "width": "40px",
                        "targets": [1],
                        'orderable': false
                    },
                    {
                        "width": "12%",
                        "targets": [3],
                        'orderable': false
                    },
                    {
                        "width": "10px",
                        "targets": [2]
                    },
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'nroDocDevolucion', 'autoWidth': true}
                    ,{'data': 'empresaResponsable', 'autoWidth': true}
                    ,{'data': 'trabajadorResponsable', 'autoWidth': true}
                    ,{'data': 'trabajadorValidador', 'autoWidth': true}
                    ,{'data': 'fecRegistro', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblDespachoMesaPartesPendientesDevolucion
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblDespachoMesaPartesPendientesDevolucion.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();
                            break;

                        default:
                            $.each( actionButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblDespachoMesaPartesPendientesDevolucion.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            break;

                        default:
                            $.each( actionButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPendientesDevolucion, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            btnFinalizarDevolucion.on('click', function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalDevolucionDetalle');
                let instance = M.Modal.init(elem, {dismissible:false});

                let rows_selected = tblDespachoMesaPartesPendientesDevolucion.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblDespachoMesaPartesPendientesDevolucion.rows(rowId).data()[0]);
                });

                $("#IdDespachoDevolucion").val(values[0].idDespachoDevolucion);
                tblDocsCompletarDev.ajax.reload();
                instance.open();
            });

            $("#btnGuardarDatosDetalleDevolucion").on("click", function (e) {
                if ($('#FecContactoCompletar').val() === ''){
                    $.alert('¡Falta seleccionar la fecha de notificación!');
                    return false;
                } else if ($('#nroVisitasDev').val() === ''){
                    $.alert('¡Falta indicar la cantidad de visitas!');
                    return false;
                } else if ($('#documentoArchivoCargo div.row div.col input[type="checkbox"]:checked').length !== 1){
                    $.alert('¡Falta agregar el cargo digital!');
                    return false;
                }

                let data = $('#modalDevolucionDetalle form#formCompletarDev').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","CompletarDevolucion");
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxDespacho.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Devolución completada!'});
                        $('#documentoArchivoCargo div.row div.col').empty();
                        $('#documentoArchivoCargo').css("display","none");
                        $('#formCompletarDev').css('display', 'none');

                        $('#formCompletarDev input[name="codigoDetalle"]').val(0);
                        $('#formCompletarDev input[name="idTramite"]').val(0);
                        tblDocsCompletarDev.ajax.reload();
                    }
                });
            });

            $("#btnCancelarDatosDetalleDevolucion").on("click", function (e) {
                M.toast({html: '¡Devolución cancelada!'});
                $('#documentoArchivoCargo div.row div.col').empty();
                $('#documentoArchivoCargo').css("display","none");
                $('#formCompletarDev').css('display', 'none');
                $('#formCompletarDev input[name="codigoDetalle"]').val(0);
                $('#formCompletarDev input[name="idTramite"]').val(0);
            });

            $("#btnFinalizarDevolución").on("click", function (e) {
                let data = tblDocsCompletarDev.data();
                let noFinaliza = false;
                $.each(data, function (i, item) {
                    if (item.FINALIZADO === 1) {
                        noFinaliza = true;
                    }
                });
                if (noFinaliza === true){
                    $.alert('¡Falta completar!');
                } else {
                    $('#formDevolucion').css('display', 'block');
                    $('#formCompletarDev').css('display', 'none');
                    $('#btnRegistrarDevolucion').css('display', 'inline-block');
                    $('#btnCancelarDevolucion').css('display', 'inline-block');
                    $('#btnFinalizarDevolución').css('display', 'none');
                    $("#IdDespachoDevolucion").val(0);
                    tblDocsCompletarDev.ajax.reload();
                    tblDespachoMesaPartesPendientesDevolucion.ajax.reload();
                    let elem = document.querySelector('#modalDevolucionDetalle');
                    let instance = M.Modal.init(elem, {dismissible:false});
                    instance.close();
                    M.toast({html: '¡Devolución finalizada!'});
                }
            });

            //botones generales
            btnDetail.on('click', function(e) {
                var elems = document.querySelector('#modalDetalle');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                if (tblDespachoMesaPartesPendientes.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                } else if (tblDespachoMesaPartesEnviados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblDespachoMesaPartesEnviados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.IdMovimiento);
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

            btnFlow.on('click', function(e) {
                var elems = document.querySelector('#modalFlujo');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();

                var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                if (tblDespachoMesaPartesPendientes.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                } else if (tblDespachoMesaPartesEnviados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblDespachoMesaPartesEnviados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.IdMovimiento);
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

            btnDoc.on('click', function(e) {
                var elems = document.querySelector('#modalDoc');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();

                var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                if (tblDespachoMesaPartesPendientes.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                } else if (tblDespachoMesaPartesEnviados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblDespachoMesaPartesEnviados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.IdMovimiento);
                });
                $.ajax({
                    cache: false,
                    url: "verDoc.php",
                    method: "POST",
                    data: {iCodMovimiento: movimientos, tabla: 't'},
                    datatype: "json",
                    success: function (response) {

                        var json = eval('(' + response + ')');
                        if (json['estado'] == 1) {
                            $('#modalDoc div.modal-content iframe').attr('src', json['url']);
                            instance.open();
                        }else {
                            M.toast({html: '¡No contiene documento asociado!'});
                        }
                    }
                });
            });

            btnAnexos.on('click', function(e) {
                e.preventDefault();

                var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                if (tblDespachoMesaPartesPendientes.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblDespachoMesaPartesPendientes;
                } else if (tblDespachoMesaPartesEnviados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblDespachoMesaPartesEnviados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.IdMovimiento);
                });
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
                        }else{
                            $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                        }
                    }
                });

            });

            $("#btnCancelarDevolucionDetalle").on("click", function(e) {
                $('#documentoArchivoCargo div.row div.col').empty();
                $('#documentoArchivoCargo').css("display","none");
                let elem = document.querySelector('#modalDevolucionDetalle');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.close();
            });

            $('#btnPendientesEnvio').on('click', function (e) {
                tblDespachoMesaPartesPendientes.ajax.reload();
                $("div.actionButtons a").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnEnviadosFisicamente').on('click', function (e) {
                tblDespachoMesaPartesEnviados.ajax.reload();
                $('.actionButtons').hide(100);
                $("div.actionButtons a").css("display","none");
            });

            $('#btnPendientesDevolucion').on('click', function (e) {
                tblDespachoMesaPartesPendientesDevolucion.ajax.reload();
                $('.actionButtons').hide(100);
                $("div.actionButtons a").css("display","none");
            });
        });

        Dropzone.autoDiscover = false;
        $("div#dropzoneEntrega").dropzone({
            url: "ajax/cargarDoc.php",
            paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
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
                $("#btnSubirDocEntrega").on("click", function(e) {
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

                $("#btnCancelarEntrega").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.removeAllFiles();
                    $('#documentoArchivoEntrega div.row div.col').empty();
                    $('#documentoArchivoEntrega').css("display","none");
                    let elem = document.querySelector('#modalEntrega');
                    let instance = M.Modal.init(elem, {dismissible:false});
                    instance.close();
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append('IdTipo','9')
                });

                this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        if (fila.evento === 'REGISTRADO' || fila.evento === 'REPETIDO'){
                            let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoEntrega[]" value="'+fila.codigo+'"><span><a href="'+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
                            $('#documentoArchivoEntrega div.row div.col').append(check);
                            $('#documentoArchivoEntrega').css('display', 'block');
                        }
                        M.toast({html: fila.mensaje});
                    });
                    this.removeAllFiles();
                });

            }

        });

        $("div#dropzoneDevolucion").dropzone({
            url: "ajax/cargarDoc.php",
            paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
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
                $("#btnSubirDocDevolucion").on("click", function(e) {
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

                $("#btnCancelarRegistrarDevolucion").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.removeAllFiles();
                    $('#documentoArchivoDevolucion div.row div.col').empty();
                    $('#documentoArchivoDevolucion').css("display","none");
                    let elem = document.querySelector('#modalDevolucion');
                    let instance = M.Modal.init(elem, {dismissible:false});
                    instance.close();
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append('IdTipo','10');
                });

                this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        if (fila.evento === 'REGISTRADO' || fila.evento === 'REPETIDO'){
                            let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoDevolucion[]" value="'+fila.codigo+'"><span><a href="'+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
                            $('#documentoArchivoDevolucion div.row div.col').append(check);
                            $('#documentoArchivoDevolucion').css('display', 'block');
                        }
                        M.toast({html: fila.mensaje});
                    });
                    this.removeAllFiles();
                });

            }

        });

        $("div#dropzoneCargo").dropzone({
            url: "ajax/cargarDoc.php",
            paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
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
                $("#btnSubirDocCargo").on("click", function(e) {
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

                this.on("sending", function(file, xhr, formData) {
                    formData.append('IdTipo','6');
                    formData.append('IdTramite',$('#formCompletarDev input[name="idTramite"]').val());
                });

                this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        if (fila.evento === 'REGISTRADO' || fila.evento === 'REPETIDO'){
                            let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoCargo[]" value="'+fila.codigo+'"><span><a href="'+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
                            $('#documentoArchivoCargo div.row div.col').append(check);
                            $('#documentoArchivoCargo').css('display', 'block');
                        }
                        M.toast({html: fila.mensaje});
                    });
                    this.removeAllFiles();
                });

            }

        });

        var tblDocsCompletarDev = $('#TblDocsCompletarDev').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            ajax: {
                url: 'ajax/ajaxDespacho.php',
                type: 'POST',
                datatype: 'json',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "IdDespachoDevolucion": $('#IdDespachoDevolucion').val(),
                        "Evento": "ListarDetalleDevolucion"
                    });
                }
            },
            'drawCallback': function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblDocsCompletarDev").css('display','none');
                } else{
                    $("#TblDocsCompletarDev").css('display','block');
                }
            },
            'columns': [
                { 'data': 'Cud', 'autoWidth': true, 'width': '100%'},
                { 'data': 'DOCUMENTO', 'autoWidth': true, 'width': '100%'},
                { 'data': 'DESTINATARIO', 'autoWidth': true, 'width': '100%'},
                { 'data': 'ORDENENTREGA', 'autoWidth': true, 'width': '100%'},
                { 'data': 'ESTADO', 'autoWidth': true, 'width': '100%'},
                {
                    'render': function (data, type, full, meta) {
                        let botones = '';
                        if (full.FINALIZADO === 1){
                            botones += '<button type="button" data-accion="mostrar-formulario" title="Mostrar formulario" data-tooltip="Mostrar formulario" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Mostrar-Formulario"><i class="fab fa-wpforms"></i></button>';
                        }
                        return botones;
                    }, 'className': 'text-center',"width": "20px"
                },
            ]
        });

        $('#TblDocsCompletarDev tbody').on('click', 'button', function (e) {
            e.preventDefault();
            let fila = tblDocsCompletarDev.row($(this).parents('tr'));
            let dataFila = fila.data();
            let accion = $(this).attr("data-accion");
            switch (accion) {
                case 'mostrar-formulario':
                    $('#formCompletarDev input[name="codigoDetalle"]').val(dataFila.CODIGO);
                    $('#formCompletarDev input[name="idTramite"]').val(dataFila.IdTramite);
                    ContenidosTipo("codContacto","19");
                    ContenidosTipo("codTipoMalNotificado","28");
                    ContenidosTipo("codTipoContacto","20");
                    $('form#formCompletarDev').css('display','block');
                    break;
            }
        });

        $('#codContacto').on('change', function () {
            if($('#codContacto').val() == '29'){
                ContenidosTipo("codTipoContacto","20");
            }else {
                ContenidosTipo("codTipoContacto","21");
            }
        });

        $("#flgEnvioPropio").on("change",function (e) {
            if ($("#flgEnvioPropio:checked").length === 1){
                $("#datosEmpresaExterna").css("display", "block");
                $("#datosPropios").css("display", "none");
            } else {
                $("#datosEmpresaExterna").css("display", "none");
                $("#datosPropios").css("display", "block");
            }
        });

        $("#flgEnvioPropioDevolucion").on("change",function (e) {
            if ($("#flgEnvioPropioDevolucion:checked").length === 1){
                $("#datosEmpresaExternaDevolucion").css("display", "block");
                $("#datosPropiosDevolucion").css("display", "none");
            } else {
                $("#datosEmpresaExternaDevolucion").css("display", "none");
                $("#datosPropiosDevolucion").css("display", "block");
            }
        });

        $("#flgNotificacionCorrecto").on("change",function (e) {
            if ($("#flgNotificacionCorrecto:checked").length === 1){
                $("#codTipoMalNotificado").parent().parent().css("display", "block");
            } else {
                $("#codTipoMalNotificado").parent().parent().css("display", "none");
            }
        });

        $("#btnBuscarDNIDevolucion").on("click", function (e) {
            e.preventDefault();
            deleteSpinner();
            $("#nombreResponsableExterno").val("");

            $.ajax({
                url: "https://app.apci.gob.pe/ApiPide/Api/Reniec/REC_GET_0001?dni="+ $("#nroDNIDevolucion").val(),
                method: "GET",
                headers: {
                    'Authorization': $("#token").val(),
                },
                datatype: "application/json",
                success: function (response) {
                    let resultado = response.EntityResult;
                    if (resultado !== null){
                        let nombres = resultado.Nombres;
                        let paterno = resultado.Paterno;
                        let materno = resultado.Materno;
                        let nombreCompleto = nombres + ' ' + paterno + ' ' + materno;
                        $("#nombreResponsableExternoDevolucion").val(nombreCompleto);
                        $("label[for=nombreResponsableExternoDevolucion]").addClass("active");
                    }
                }
            });
        });

        $("#btnBuscarDNI").on("click", function (e) {
            e.preventDefault();
            console.log($("#nroDNI").val());
            $("#nombreResponsableExterno").val("");
            $.ajax({
                url: "https://app.apci.gob.pe/ApiPide/Api/Reniec/REC_GET_0001?dni="+ $("#nroDNI").val(),
                method: "GET",
                headers: {
                    "Authorization" : $("#token").val(),
                },
                datatype: "application/json",
                success: function (response) {
                    let resultado = response.EntityResult;
                    if (resultado !== null){
                        let nombres = resultado.Nombres;
                        let paterno = resultado.Paterno;
                        let materno = resultado.Materno;
                        let nombreCompleto = nombres + ' ' + paterno + ' ' + materno;
                        $("#nombreResponsableExterno").val(nombreCompleto);
                        $("label[for=nombreResponsableExterno]").addClass("active");
                    }
                }
            });
            deleteSpinner();
        });
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>