<?php
session_start();
$pageTitle = "Bandeja de solicitudes externas";
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
                        <li><a id="btnAtenderSolicitud" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span> Registrar Atención</span></a></li>
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
                                        <li id="btnPorAtender" class="tab col s3"><a href="#porAtender"> Por Atender</a></li>
                                        <li id="btnAtendidos" class="tab col s3"><a href="#atendidos"> Atendidos</a></li>
                                    </ul>
                                </div>
                                <div id="porAtender" class="col s12">
                                    <table id="tblBandejaSolicitudesExternasPorAtender" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>N° de solicitud</th>
                                            <th>Nombre de la empresa</th>
                                            <th>Nombre del servicio</th>
                                            <th>Fecha de registro</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="atendidos" class="col s12">
                                    <table id="tblBandejaSolicitudesExternasAtendidos" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>N° de solicitud</th>
                                            <th>Nombre de la empresa</th>
                                            <th>Nombre del servicio</th>
                                            <th>Fecha de registro</th>
                                            <th>Fecha de atención</th>
                                            <th>Trabajador atendió</th>
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
            <h4>Solicitud Externa</h4>
        </div>
        <div class="modal-content">
            <div id="datosSolicitud">
                <div class="row">
                    <div class="col s12">
                        <table id="tblDetalleSolicitudExterna" style="display: none; width: 100%;">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Dentro de Institución</th>
                                <th>Requiere Doc. Digital</th>
                                <th>Tiene Doc. Digital</th>
                                <th>Modalidad Requerida</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <input type="hidden" value="0" name="idSolicitudExterna" id="idSolicitudExterna">
            <div id="formularioDatos" style="display: none">
                <form>
                    <input type="hidden" value="0" name="idDetalleSolicitudExterna" id="idDetalleSolicitudExterna">
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
            <a class="waves-effect waves-green btn-flat" id="btnAtender"> Atender</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalDetalleSolicitud" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Detalle solicitud externa</h4>
        </div>
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <input type="hidden" name="IdSolicitudExternaVer" id="IdSolicitudExternaVer" value="0">
                    <table id="tblDetalleSolicitudExternaVer" style="display: none; width: 100%;">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Dentro de Institución</th>
                            <th>Requiere Doc. Digital</th>
                            <th>Tiene Doc. Digital</th>
                            <th>Modalidad Requerida</th>
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

        $(document).ready(function() {
            $('.actionButtons').hide();

            var btnAtenderSolicitud = $("#btnAtenderSolicitud");
            var btnVerSolicitud = $("#btnVerSolicitud");

            var actionButtonsPorAtender = [];
            var supportButtonsPorAtender = [btnAtenderSolicitud];

            var actionButtonsAtendidos = [];
            var supportButtonsAtendidos = [btnVerSolicitud];

            var tblBandejaSolicitudesExternasPorAtender = $('#tblBandejaSolicitudesExternasPorAtender').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesExternas.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstado": 49
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesExternasPorAtender_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesExternasPorAtender.rows().deselect();
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
                    ,{'data': 'nroSolicitud', 'autoWidth': true}
                    ,{'data': 'nomEmpresa', 'autoWidth': true}
                    ,{'data': 'nomTipoServicio', 'autoWidth': true}
                    ,{'data': 'fechaRegistro', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesExternasPorAtender
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesExternasPorAtender.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsPorAtender, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorAtender, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsPorAtender, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorAtender, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesExternasPorAtender.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsPorAtender, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsPorAtender, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsPorAtender, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorAtender, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsPorAtender, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorAtender, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            var tblDetalleSolicitudExterna = $('#tblDetalleSolicitudExterna').DataTable({
                responsive: true,
                searching: false,
                ordering: false,
                paging: false,
                info: false,
                ajax: {
                    url: "registerDoc/RegSolicitudExterna.php",
                    type: 'POST',
                    datatype: 'json',
                    data: function ( d ) {
                        return $.extend( {}, d, {
                            "IdSolicitudExterna": $('#idSolicitudExterna').val(),
                            "Evento": "ObtenerDetalleSolicitudExterna"
                        });
                    }
                },
                "drawCallback": function() {
                    let api = this.api();
                    if (api.data().length === 0){
                        $("#tblDetalleSolicitudExterna").css('display','none');
                    } else{
                        $("#tblDetalleSolicitudExterna").css('display','block');
                    }
                },
                'columns': [
                    { 'data': 'CodigoExterno', 'autoWidth': true},
                    { 'data': 'Descripcion', 'autoWidth': true},
                    { 'data': 'NomFlgDentroInstalacion', 'autoWidth': true},
                    { 'data': 'NomFlgRequiereDocDigital', 'autoWidth': true},
                    { 'data': 'NomFlgTieneDocDigital', 'autoWidth': true},
                    { 'data': 'ModalidadRequerida', 'autoWidth': true},
                    {
                        'render': function (data, type, full, meta) {
                            let botones = '';
                            if (full.IdEstado === 53 && full.FlgParaListo === 0){
                                botones += '<button type="button" data-accion="listo" title="Registrar Listo" data-tooltip="Listo" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Listo"><i class="fas fa-check-double"></i></button>';
                            }
                            if (full.IdEstado === 53){
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

            $('#tblDetalleSolicitudExterna tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblDetalleSolicitudExterna.row($(this).parents('tr'));
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
                        formData.append("IdDetalleSolicitudExterna",dataFila.IdDetalleSolicitudExterna);
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegSolicitudExterna.php",
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            datatype: "json",
                            success : function() {
                                M.toast({html: '¡Documento listo!'});
                                tblDetalleSolicitudExterna.ajax.reload();
                            }
                        });
                        break;
                    case 'presentar-formulario':
                        $("#idDetalleSolicitudExterna").val(dataFila.IdDetalleSolicitudExterna);
                        $("#formularioDatos").css("display","block");
                        break;
                    case 'ver-documento':
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegSolicitudExterna.php",
                            method: "POST",
                            data: {
                                "Evento" : "VerDocumentoPrestamoDetalle"
                                ,"IdDetalleSolicitudExterna" : dataFila.IdDetalleSolicitudExterna
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

            $('#btnGuardarDatos').on('click', function (e) {
                e.preventDefault();
                let data = $('#formularioDatos form').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","ActualizarDatosDetalleSolicitudExterna");
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegSolicitudExterna.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Datos guardados correctamente!'});
                        $("#idDetalleSolicitudExterna").val(0);
                        $('#documentoDigital div.row div.col').empty();
                        $('#documentoDigital').css("display","none");
                        $("#formularioDatos").css("display","none");
                        tblDetalleSolicitudExterna.ajax.reload();
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
                let rows_selected = tblBandejaSolicitudesExternasPorAtender.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesExternasPorAtender.rows(rowId).data()[0]);
                });
                $("#idSolicitudExterna").val(values[0].idSolicitudExterna);
                tblDetalleSolicitudExterna.ajax.reload();
                instance.open();
            });

            $("#btnAtender").on("click", function (e) {
                let data = tblDetalleSolicitudExterna.data();
                let noAtender = false;
                $.each(data, function (i, item) {
                    if (item.IdEstado === 53) {
                        noAtender = true;
                    }
                });
                if (noAtender === true){
                    $.alert('¡La solicitud tiene documentos pendientes!');
                    return false;
                }
                let formData = new FormData();
                formData.append("Evento","AtenderSolicitudExterna");
                formData.append("IdSolicitudExterna",$("#idSolicitudExterna").val());
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegSolicitudExterna.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Solicitud atendida!'});
                        tblBandejaSolicitudesExternasPorAtender.ajax.reload();
                        let elem = document.querySelector('#modalAtenderSolicitud');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                    }
                });
            });

            var tblBandejaSolicitudesExternasAtendidos = $('#tblBandejaSolicitudesExternasAtendidos').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesExternas.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstado": 52
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesExternasAtendidos_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesExternasAtendidos.rows().deselect();
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
                    ,{'data': 'nroSolicitud', 'autoWidth': true}
                    ,{'data': 'nomEmpresa', 'autoWidth': true}
                    ,{'data': 'nomTipoServicio', 'autoWidth': true}
                    ,{'data': 'fechaRegistro', 'autoWidth': true}
                    ,{'data': 'fechaAtencion', 'autoWidth': true}
                    ,{'data': 'nomTrabajadorAtencion', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesExternasAtendidos
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesExternasAtendidos.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsAtendidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsAtendidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsAtendidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsAtendidos, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesExternasAtendidos.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsAtendidos, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsAtendidos, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsAtendidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsAtendidos, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsAtendidos, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsAtendidos, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            var tblDetalleSolicitudExternaVer = $('#tblDetalleSolicitudExternaVer').DataTable({
                responsive: true,
                searching: false,
                ordering: false,
                paging: false,
                info: false,
                ajax: {
                    url: "registerDoc/RegSolicitudExterna.php",
                    type: 'POST',
                    datatype: 'json',
                    data: function ( d ) {
                        return $.extend( {}, d, {
                            "IdSolicitudExterna": $('#IdSolicitudExternaVer').val(),
                            "Evento": "ObtenerDetalleSolicitudExterna"
                        });
                    }
                },
                "drawCallback": function() {
                    let api = this.api();
                    if (api.data().length === 0){
                        $("#tblDetalleSolicitudExternaVer").css('display','none');
                    } else{
                        $("#tblDetalleSolicitudExternaVer").css('display','block');
                    }
                },
                'columns': [
                    { 'data': 'CodigoExterno', 'autoWidth': true},
                    { 'data': 'Descripcion', 'autoWidth': true},
                    { 'data': 'NomFlgDentroInstalacion', 'autoWidth': true},
                    { 'data': 'NomFlgRequiereDocDigital', 'autoWidth': true},
                    { 'data': 'NomFlgTieneDocDigital', 'autoWidth': true},
                    { 'data': 'ModalidadRequerida', 'autoWidth': true},
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

            $('#tblDetalleSolicitudExternaVer tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblDetalleSolicitudExternaVer.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {
                    case 'ver-documento':
                        $.ajax({
                            cache: false,
                            url: "registerDoc/RegSolicitudExterna.php",
                            method: "POST",
                            data: {
                                "Evento" : "VerDocumentoPrestamoDetalle"
                                ,"IdDetalleSolicitudExterna" : dataFila.IdDetalleSolicitudExterna
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

            btnVerSolicitud.on("click", function (e) {
                let elem = document.querySelector('#modalDetalleSolicitud');
                let instance = M.Modal.init(elem, {dismissible:false});

                let rows_selected = tblBandejaSolicitudesExternasAtendidos.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesExternasAtendidos.rows(rowId).data()[0]);
                });
                $('#IdSolicitudExternaVer').val(values[0].idSolicitudExterna);
                tblDetalleSolicitudExternaVer.ajax.reload();
                instance.open();
            });

            $('#btnPorAtender').on('click', function (e) {
                tblBandejaSolicitudesExternasPorAtender.ajax.reload();
                $("div.actionButtons a").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnAtendidos').on('click', function (e) {
                tblBandejaSolicitudesExternasAtendidos.ajax.reload();
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
                    formData.append('nombreCarpeta','SolicitudExterna/ItemDigital')
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