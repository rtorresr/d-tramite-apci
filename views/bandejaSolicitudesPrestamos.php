<?php
session_start();
$pageTitle = "Bandeja de solicitudes de prestamos";
$activeItem = "bandejaSolicitudesPrestamos.php";
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
                        <li><a id="btnAtenderSolicitud" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span> Atender</span></a></li>
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
                                        <li class="tab col s3"><a href="#tblRecibidos">Solicitudes Recibidas</a></li>
                                        <li class="tab col s3"><a href="#tblemitidos">Solicitudes Emitidas</a></li>
                                    </ul>
                                </div>
                                <div id="tblRecibidos" class="col s12">
                                    <table id="tblBandejaSolicitudesPrestamosRecibidos" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Origen</th>
                                            <th>Documento</th>
                                            <th>Fecha de Envío</th>
                                            <th>Estado</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="tblemitidos" class="col s12">
                                    <table id="tblBandejaSolicitudesPrestamosEmitidos" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Destino</th>
                                            <th>Documento</th>
                                            <th>Fecha de Envío</th>
                                            <th>Estado</th>
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
                                    <th>Documento</th>
                                    <th>Servicio</th>
                                    <th>Ubicación</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div id="formularioDatos" style="display: none">
                <form>
                    <input type="hidden" value="&nbsp;" name="codSolicitudPrestamo">
                    <input type="hidden" value="&nbsp;" name="codDetalleSolicitud">
                    <div class="row">
                        <div class="col s6 input-field ">
                            <select id="idTipoUbicacion" name="idTipoUbicacion">
                            </select>
                            <label for="idTipoUbicacion">Ubicación</label>
                        </div>
                        <div class="col s6 input-field ">
                            <select id="idSolicitudExternaDetalle" class="js-data-example-ajax browser-default" name="idSolicitudExternaDetalle">
                            </select>
                            <label for="idSolicitudExternaDetalle">Código empresa externa</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field ">
                            <input placeholder="dd-mm-aaaa" value="" type="text" id="FecDevolucion" name="FecDevolucion" class="datepicker">
                            <label for="FecDevolucion">Fecha de devolución</label>
                        </div>
                        <div class="col s6 input-field ">
                            <select id="idEstado" name="idEstado">
                            </select>
                            <label for="idEstado">Estado del documento</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <div class="switch">
                                <p><label for="FlgFinalizado">¿Finalizado?</label></p>
                                <label>
                                    No
                                    <input type="checkbox" id="FlgFinalizado" name="FlgFinalizado" value="0">
                                    <span class="lever"></span>
                                    Si
                                </label>
                            </div>
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
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
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
            var elems = document.querySelectorAll('.tabs');
            var instance = M.Tabs.init(elems,{swipeable: true});

            var tblBandejaSolicitudesPrestamosRecibidos = $('#tblBandejaSolicitudesPrestamosRecibidos').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                            "tipo": "recibidos"
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesPrestamosRecibidos_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesPrestamosRecibidos.rows().deselect();
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
                        "targets": [1,2,3,4],
                        'orderable': false
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'oficinaOrigen', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'fechaEnvio', 'autoWidth': true}
                    ,{'data': 'estado', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            var btnAtenderSolicitud = $("#btnAtenderSolicitud");

            var actionButtonsRecibidos = [];
            var supportButtonsRecibidos = [btnAtenderSolicitud];

            tblBandejaSolicitudesPrestamosRecibidos
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesPrestamosRecibidos.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsRecibidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsRecibidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidos, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesPrestamosRecibidos.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsRecibidos, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsRecibidos, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsRecibidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidos, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsRecibidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidos, function( key, value ) {
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
                "drawCallback": function() {
                    let api = this.api();
                    if (api.data().length === 0){
                        $("#tblDetalleSolicitud").css('display','none');
                    } else{
                        $("#tblDetalleSolicitud").css('display','block');
                    }
                },
                'columns': [
                    { 'data': 'DescripcionDocumento', 'autoWidth': true},
                    { 'data': 'NomTipoServicio', 'autoWidth': true},
                    { 'data': 'NomTipoUbicacion', 'autoWidth': true},
                    { 'data': 'NomEstadoDetallePrestamo', 'autoWidth': true},
                    {
                        'render': function (data, type, full, meta) {
                            let botones = '';
                            if (full.FlgFinalizado === 1){
                                botones += '<button type="button" data-accion="mostrar-formulario" title="Mostrar formulario" data-tooltip="Mostrar formulario" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Mostrar-Formulario"><i class="fab fa-wpforms"></i></button>'
                                /*+ '<button type="button" data-accion="completar" title="Completar" data-tooltip="Completar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Completar"><i class="fas fa-location-arrow"></i></button>'*/;
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
                    case 'mostrar-formulario':
                        $('#documentoDigital div.row div.col').empty();
                        $('#documentoDigital').css("display","none");
                        $('div#formularioDatos form input[name="codSolicitudPrestamo"]').val(dataFila.IdSolicitudPrestamo);
                        $('div#formularioDatos form input[name="codDetalleSolicitud"]').val(dataFila.IdDetallePrestamo);
                        ContenidosTipo('idTipoUbicacion',24);
                        $('#idSolicitudExternaDetalle').val(null).trigger('change');
                        ContenidosTipo('idEstado',11);
                        $('div#formularioDatos').css('display','block');
                        break;
                }
            });

            btnAtenderSolicitud.on('click', function (e) {
                e.preventDefault();
                $('div#formularioDatos').css('display','none');
                let elem = document.querySelector('#modalAtenderSolicitud');
                let instance = M.Modal.init(elem, {dismissible:false});
                let rows_selected = tblBandejaSolicitudesPrestamosRecibidos.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesPrestamosRecibidos.rows(rowId).data()[0]);
                });
                let solicitudPrestamo = [];
                $.each(values, function (index, fila) {
                    solicitudPrestamo.push(fila.IdSolicitudPrestamo);
                });
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: 'POST',
                    data: {
                        IdSolicitudPrestamo: solicitudPrestamo[0],
                        Evento: 'ObtenerDetalleSolicitud'
                    },
                    datatype: "json",
                    success : function(data) {
                        data = JSON.parse(data);
                        tblDetalleSolicitud.clear();
                        $.each(data, function (i, k) {
                            tblDetalleSolicitud.row.add(k);
                        });
                        tblDetalleSolicitud.draw();
                    }
                });
                instance.open();
            });

            $('#btnGuardarDatos').on('click', function (e) {
                e.preventDefault();
                let data = $('#modalAtenderSolicitud div#formularioDatos form').serializeArray();
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
                        M.toast({html: '¡Registrado correctamente!'});
                        $('div#formularioDatos').css('display','none');
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegPrestamoDocumentos.php",
                            method: 'POST',
                            data: {
                                IdSolicitudPrestamo: $('div#formularioDatos form input[name="codSolicitudPrestamo"]').val(),
                                Evento: 'ObtenerDetalleSolicitud'
                            },
                            datatype: "json",
                            success : function(data) {
                                data = JSON.parse(data);
                                tblDetalleSolicitud.clear();
                                $.each(data, function (i, k) {
                                    tblDetalleSolicitud.row.add(k);
                                });
                                tblDetalleSolicitud.draw();
                            }
                        });
                    },
                    error: function () {
                        M.toast({html: '¡Error al registrar en la base de datos!'});
                    }
                });
            });

            var tblBandejaSolicitudesPrestamosEmitidos = $('#tblBandejaSolicitudesPrestamosEmitidos').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "tipo": "emitidos"
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesPrestamosEmitidos_length"]').formSelect();
                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesPrestamosEmitidos.rows().deselect();
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
                        "targets": [1,2,3,4],
                        'orderable': false
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'oficinaDestino', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'fechaEnvio', 'autoWidth': true}
                    ,{'data': 'estado', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            var actionButtonsEmitidos = [];
            var supportButtonsEmitidos = [];

            tblBandejaSolicitudesPrestamosEmitidos
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesPrestamosEmitidos.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsEmitidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsEmitidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidos, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesPrestamosEmitidos.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsEmitidos, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsEmitidos, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsEmitidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidos, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsEmitidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidos, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
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

                    /*let elem = document.querySelector('#modalEntrega');
                    let instance = M.Modal.init(elem, {dismissible:false});
                    instance.close();*/
                });

                this.on("sending", function(file, xhr, formData) {
                    formData.append('nombreCarpeta','Prestamo/DocDigital')
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
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>