<?php
session_start();
$pageTitle = "Bandeja de solicitudes de prestamos";
$activeItem = "solicitudesPrestamoArchivoCentral.php";
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
                        <li><a id="btnRenotificar" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span> Re-Notificar</span></a></li>
                        <li><a id="btnAnular" style="display: none" class="btn btn-primary"><i class="fas fa-trash"></i><span> Anular</span></a></li>
                        <li><a id="btnAmpliarPlazo" style="display: none" class="btn btn-primary"><i class="fas fa-hourglass-end"></i><span> Ampliar Plazo</span></a></li>
                        <li><a id="btnRegistrarDevolucion" style="display: none" class="btn btn-primary"><i class="far fa-times-circle"></i><span> Registrar Devolución</span></a></li>
                        <li><a id="btnVerSolicitud" style="display: none" class="btn btn-primary"><i class="fas fa-eye"></i><span> Ver solicitud</span></a></li>
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
                                <th>Documento</th>
                                <th>Servicio Requerido</th>
                                <!--<th>Ubicación</th>-->
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
                        <div class="col s6 input-field ">
                            <select id="idTipoServicioOfrecido" name="idTipoServicioOfrecido">
                            </select>
                            <label for="idTipoServicioOfrecido">Servicio Ofrecido</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field ">
                            <select id="idTipoUbicacion" name="idTipoUbicacion">
                            </select>
                            <label for="idTipoUbicacion">Ubicación</label>
                        </div>
                        <div class="col s6 input-field " style="display: none">
                            <select id="idSolicitudExternaDetalle" class="js-data-example-ajax browser-default" name="idSolicitudExternaDetalle">
                            </select>
                            <label for="idSolicitudExternaDetalle">Código empresa externa</label>
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
            <h4>Detalle solicitud de préstamo</h4>
        </div>
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <input type="hidden" name="IdSolicitudPrestamoVer" id="IdSolicitudPrestamoVer" value="0">
                    <table id="tblVerDetalleSolicitud" style="display: none; width: 100%;">
                        <thead>
                        <tr>
                            <th>Documento</th>
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
                    $('#documentoDigital div.row div.col').empty();
                    $('#documentoDigital').css('display', 'none');
                    if (fila.FlgTieneDocDigital === 0){
                        let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoDigital[]" value="'+fila.codigo+'"><span><a href="http://'+fila.servidor+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
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

            var btnAtenderSolicitud = $("#btnAtenderSolicitud");
            var btnRenotificar = $("#btnRenotificar");
            var btnAnular = $("#btnAnular");
            var btnAmpliarPlazo = $("#btnAmpliarPlazo");
            var btnRegistrarDevolucion = $("#btnRegistrarDevolucion");
            var btnVerSolicitud = $("#btnVerSolicitud");

            var actionButtonsRecibidosEnCurso = [];
            var supportButtonsRecibidosEnCurso = [btnAtenderSolicitud, btnAnular];

            var actionButtonsRecibidosNotificados = [];
            var supportButtonsRecibidosNotificados = [btnRenotificar, btnAnular, btnVerSolicitud];

            var actionButtonsRecibidosPorDevolver = [];
            var supportButtonsRecibidosPorDevolver = [btnAmpliarPlazo, btnRegistrarDevolucion, btnVerSolicitud];

            var tblBandejaSolicitudesEnCurso = $('#tblBandejaSolicitudesEnCurso').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstadoSolicitudPrestamo": 7
                                ,"FlgArchivoCentral" : 0
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
                            $.each( actionButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosEnCurso, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

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
                    { 'data': 'DescripcionDocumento', 'autoWidth': true},
                    { 'data': 'NomTipoServicio', 'autoWidth': true},
                    //{ 'data': 'NomTipoUbicacion', 'autoWidth': true},
                    { 'data': 'RequiereDocDigital', 'autoWidth': true},
                    { 'data': 'TieneDocDigital', 'autoWidth': true},
                    { 'data': 'NomTipoServicioOfrecido', 'autoWidth': true},
                    { 'data': 'NomEstadoDetallePrestamo', 'autoWidth': true},
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
                        ContenidosTipo("idTipoUbicacion",24);
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
                                window.open('http://'+ data.RutaDocDigital, '_blank');
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
                formData.append("Evento","NotificarSolicitudPrestamo");
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
                        M.toast({html: '¡Solicitud notificada!'});
                        tblBandejaSolicitudesEnCurso.ajax.reload();
                        let elem = document.querySelector('#modalAtenderSolicitud');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
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
                                ,"FlgArchivoCentral" : 0
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
                                window.open('http://'+ data.RutaDocDigital, '_blank');
                            }
                        });
                        break;
                }
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
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstadoSolicitudPrestamo": 44
                                ,"FlgArchivoCentral" : 0
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
                            if (full.flgFueraDePlazo === 0) {
                                iconos += '<i class="fas fa-fw fa-flag" style="color: red; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            if (full.flgRequiereAmpliacion === 0) {
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
                    switch (count) {
                        case 1:
                            $.each( actionButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsRecibidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
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

            btnAmpliarPlazo.on('click', function (e) {
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
            });

            btnRegistrarDevolucion.on('click', function (e) {
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
            });

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

            $("#idTipoUbicacion").on("change", function (e) {
                if ($("#idTipoUbicacion").val() == 39){
                    $("#idSolicitudExternaDetalle").parent().css("display", "none");
                } else {
                    $("#idSolicitudExternaDetalle").parent().css("display", "inline-block");
                }
            });

            $('#btnEnCurso').on('click', function (e) {
                tblBandejaSolicitudesEnCurso.ajax.reload();
                $("div.actionButtons a").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnNotificados').on('click', function (e) {
                tblBandejaSolicitudesNotificados.ajax.reload();
                $("div.actionButtons a").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnPorDevolver').on('click', function (e) {
                tblBandejaSolicitudesPorDevolver.ajax.reload();
                $("div.actionButtons a").css("display","none");
                $('.actionButtons').hide(100);
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
                    formData.append('nombreCarpeta','Prestamo/DocDigital')
                });

                this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        if (fila.evento === 'REGISTRADO' || fila.evento === 'REPETIDO'){
                            let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="documentoDigital[]" value="'+fila.codigo+'"><span><a href="http://'+fila.servidor+fila.ruta+'" target="_blank">'+fila.nombre+'</a></span></label></p>';
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