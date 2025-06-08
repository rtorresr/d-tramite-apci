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
                        <li><a id="btnDevolver" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span> Devolver</span></a></li>
                        <li><a id="btnVerDocumento" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span> Ver documento</span></a></li>
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
                                        <li id="btnPorDevolver" class="tab col s3"><a href="#porDevolver"> Por Devolver</a></li>
                                        <li id="btnDisponibles" class="tab col s3"><a href="#disponibles"> Disponibles</a></li>
                                    </ul>
                                </div>
                                <div id="porDevolver" class="col s12">
                                    <table id="tblBandejaItemsExternosPorDevolver" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>N° de solicitud</th>
                                            <th>Código Externo</th>
                                            <th>Descripción</th>
                                            <th>Fecha Atención</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="disponibles" class="col s12">
                                    <table id="tblBandejaItemsExternosDisponibles" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>N° de solicitud</th>
                                            <th>Código Externo</th>
                                            <th>Descripción</th>
                                            <th>Fecha Atención</th>
                                            <th>Ubicado en APCI</th>
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

    <div id="modalDevolver" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Devolución items</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="col s12 input-field">
                        <select id="idSolicitudExternaDevolucion" class="js-data-example-ajax browser-default" name="idSolicitudExternaDevolucion">
                        </select>
                        <label for="idSolicitudExternaDevolucion">N° Solicitud Devolución</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a id="btnDevolverListo" class="waves-effect waves-green btn-flat"> Devolver</a>
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

        $('#idSolicitudExternaDevolucion').select2({
            dropdownParent: $('#modalDevolver'),
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
                url: 'ajax/ajaxSolicitudExternaPendienteDevolucion.php',
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

        $(document).ready(function() {
            $('.actionButtons').hide();

            var btnVerSolicitud = $("#btnVerDocumento");
            var btnDevolver = $("#btnDevolver");

            var actionButtonsPorDevolver = [btnDevolver];
            var supportButtonsPorDevolver = [btnVerSolicitud];

            var actionButtonsDisponibles = [];
            var supportButtonsDisponibles = [btnVerSolicitud];

            var tblBandejaItemsExternosPorDevolver = $('#tblBandejaItemsExternosPorDevolver').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdItemsExternos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "Tipo": "POR-DEVOLVER"
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaItemsExternosPorDevolver_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaItemsExternosPorDevolver.rows().deselect();
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
                    ,{'data': 'codigoExterno', 'autoWidth': true}
                    ,{'data': 'descripcion', 'autoWidth': true}
                    ,{'data': 'fechaAtencion', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {
                            let iconos = '';
                            if (full.flgTieneDocDigital === 0) {
                                iconos += '<i class="fas fa-eye" style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            return iconos
                        },
                    }
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaItemsExternosPorDevolver
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaItemsExternosPorDevolver.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaItemsExternosPorDevolver.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            btnDevolver.on("click", function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalDevolver');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.open();
            });

            $("#btnDevolverListo").on("click", function (e) {
                let formData = new FormData();
                formData.append("Evento","RegistrarDevolucionItems");
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

            var tblBandejaItemsExternosDisponibles = $('#tblBandejaItemsExternosDisponibles').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdItemsExternos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "Tipo": "DISPONIBLES"
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaItemsExternosDisponibles_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaItemsExternosDisponibles.rows().deselect();
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
                    ,{'data': 'codigoExterno', 'autoWidth': true}
                    ,{'data': 'descripcion', 'autoWidth': true}
                    ,{'data': 'fechaAtencion', 'autoWidth': true}
                    ,{'data': 'nomDentroIntalacion', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {
                            let iconos = '';
                            if (full.flgTieneDocDigital === 0) {
                                iconos += '<i class="fas fa-eye" style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            return iconos
                        },
                    }
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaItemsExternosDisponibles
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaItemsExternosDisponibles.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsDisponibles, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsDisponibles, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsDisponibles, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsDisponibles, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaItemsExternosDisponibles.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsDisponibles, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsDisponibles, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsDisponibles, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsDisponibles, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsDisponibles, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsDisponibles, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            $('#btnPorDevolver').on('click', function (e) {
                tblBandejaItemsExternosPorDevolver.ajax.reload();
                $("div.actionButtons a").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnDisponibles').on('click', function (e) {
                tblBandejaItemsExternosDisponibles.ajax.reload();
                $("div.actionButtons a").css("display","none");
                $('.actionButtons').hide(100);
            });
        });

    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>