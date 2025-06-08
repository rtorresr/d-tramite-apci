<?php
session_start();
$pageTitle = "Servicios archivísticos";
$activeItem = "serviciosSolicitados.php";
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
                        <li><button id="btnRecibir" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span> Recibir</span></button></li>
                        <li><button id="btnHistorico" style="display: none" class="btn btn-link"><i class="fas fa-eye"></i><span> Ver historico</span></button></li>
                        <li><button id="btnRequiereMasTiempo" style="display: none" class="btn btn-link"><i class="fas fa-reply fa-fw left"></i><span> Solicitar Ampliacion</span></button></li>
                    </ul>
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
                                        <li id="btnPorRecibir" class="tab col s3"><a href="#porRecibir">Por Recibir</a></li>
                                        <li id="btnPorDevolver" class="tab col s3"><a href="#porDevolver">Por Devolver</a></li>
                                    </ul>
                                </div>
                                <div id="porRecibir" class="col s12">
                                    <table id="tblBandejaSolicitudesEmitidoPorRecibir" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Solicitante</th>
                                            <th>Documento</th>
                                            <th>Servicio</th>
                                            <th>Fecha de notificación</th>
                                            <th>Cantidad notificaciones</th>
                                            <th>Última fecha notificación</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="porDevolver" class="col s12">
                                    <table id="tblBandejaSolicitudesEmitidoPorDevolver" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Solicitante</th>
                                            <th>Documento</th>
                                            <th>Servicio</th>
                                            <th>Fecha de recepción</th>
                                            <th>N° de Ampliaciones</th>
                                            <th>Fecha plazo</th>
                                            <th>Observación</th>
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

    <div id="modalAmpliar" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Ampliar solicitud de préstamo</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <textarea id="observacionAmpliar" class="materialize-textarea" style="height: 127px;!important"></textarea>
                        <label for="observacionAmpliar">Motivo</label>                                        
                    </div> 
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnAmpliarSolicitudPrestamo"> Ampliar</a>
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

            var btnRecibir = $("#btnRecibir");
            var btnRequiereMasTiempo = $("#btnRequiereMasTiempo");
            var btnVerSolicitud = $("#btnVerSolicitud");
            var btnHistorico = $("#btnHistorico");


            var actionButtonsEmitidosPorRecibir = [btnRecibir];
            var supportButtonsEmitidosPorRecibir = [btnHistorico];

            var actionButtonsEmitidosPorDevolver = [];
            var supportButtonsEmitidosPorDevolver = [btnRequiereMasTiempo, btnVerSolicitud, btnHistorico];

            var tblBandejaSolicitudesEmitidoPorRecibir = $('#tblBandejaSolicitudesEmitidoPorRecibir').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdPrestamoDetalle.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "evento" : "porRecibir"
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesEmitidoPorRecibir_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesEmitidoPorRecibir.rows().deselect();
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
                    ,{'data': 'oficinaDestino', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'servicio', 'autoWidth' : true}
                    ,{'data': 'FecNotificacionEntrega', 'autoWidth': true}
                    ,{'data': 'CantidadNotificaciones', 'autoWidth': true}
                    ,{'data': 'UltimaFecNotificacion', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesEmitidoPorRecibir
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEmitidoPorRecibir.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEmitidoPorRecibir.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            break;

                        default:
                            $.each( actionButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorRecibir, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            btnRecibir.on('click', function (e) {
                e.preventDefault();
                let rows_selected = tblBandejaSolicitudesEmitidoPorRecibir.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEmitidoPorRecibir.rows(rowId).data()[0]);
                });
                let formData = new FormData();
                formData.append("Evento","RecibirDocumentos");
                for(var i = 0; i < values.length; i ++){
                    formData.append("IdPrestamoDetalle["+i+"]", values[i].IdDetallePrestamo);
                }
                //formData.append("IdPrestamoDetalle", values[0].IdDetallePrestamo);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Recibido!'});
                        tblBandejaSolicitudesEmitidoPorRecibir.ajax.reload();
                    }
                });
            });

            var tblBandejaSolicitudesEmitidoPorDevolver = $('#tblBandejaSolicitudesEmitidoPorDevolver').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdPrestamoDetalle.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "evento" : "porDevolver"
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesEmitidoPorDevolver_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesEmitidoPorDevolver.rows().deselect();
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
                    ,{'data': 'oficinaDestino', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'servicio', 'autoWidth': true}
                    ,{'data': 'fechaRecepcion', 'autoWidth': true}
                    ,{'data': 'cantidadAmpliaciones', 'autoWidth': true}
                    ,{'data': 'fechaPlazo', 'autoWidth': true}
                    ,{'data': 'observacion', 'autoWidth': true}
                    , {
                        'render': function (data, type, full, meta) {
                            let iconos = '';
                            if (full.flgFueraPlazo === 1) {
                                iconos += '<i class="fas fa-fw fa-flag" style="color: red; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            if (full.flgSolicitudAmpliacionPlaza === 1) {
                                iconos += '<i class="fab fa-autoprefixer" style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            if (full.flgDocDigitalOfrecido === 1 && full.flgFueraPlazo === 0) {
                                iconos += '<button type="button" data-accion="ver-documento" title="Ver documento" data-tooltip="Ver documento" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-eye"></i></button>';
                            }
                            return iconos
                        },
                    }
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesEmitidoPorDevolver
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEmitidoPorDevolver.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            let fila = tblBandejaSolicitudesEmitidoPorDevolver.rows( { selected: true } ).data().toArray()[0];
                            if (fila.flgRequiereAmpliacion === 0){
                                btnRequiereMasTiempo.css("display","none");
                            }
                            $('.actionButtons').show();

                            break;

                        default:
                            $.each( actionButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEmitidoPorDevolver.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            let fila = tblBandejaSolicitudesEmitidoPorDevolver.rows( { selected: true } ).data().toArray()[0];
                            if (fila.flgRequiereAmpliacion === 0){
                                btnRequiereMasTiempo.css("display","none");
                            }
                            break;

                        default:
                            $.each( actionButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosPorDevolver, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            $('#tblBandejaSolicitudesEmitidoPorDevolver tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblBandejaSolicitudesEmitidoPorDevolver.row($(this).parents('tr'));
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

            btnRequiereMasTiempo.on("click", function (e) {
                let elem = document.querySelector('#modalAmpliar');
                let instance = M.Modal.init(elem, {dismissible:false});
                $("#observacionAmpliar").val('');
                instance.open();
            });

            $("#btnAmpliarSolicitudPrestamo").on("click", function (e) {
                e.preventDefault();
                let rows_selected = tblBandejaSolicitudesEmitidoPorDevolver.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEmitidoPorDevolver.rows(rowId).data()[0]);
                });
                let formData = new FormData();
                formData.append("Evento","SolicitarAmpliacionPlazo");
                formData.append("Observacion",$("#observacionAmpliar").val());
                formData.append("IdPrestamoDetalle", values[0].IdDetallePrestamo);
                $.ajax({
                    cache: false,
                    url: "registerDoc/RegPrestamoDocumentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success : function() {
                        M.toast({html: '¡Ampliación de plazo solicitada!'});
                        let elem = document.querySelector('#modalAmpliar');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tblBandejaSolicitudesEmitidoPorDevolver.ajax.reload();
                    }
                });

            });

            $('#btnPorRecibir').on('click', function (e) {
                tblBandejaSolicitudesEmitidoPorRecibir.ajax.reload();
                $("div.actionButtons button").css("display","none");
                $('.actionButtons').hide(100);
            });

            $('#btnPorDevolver').on('click', function (e) {
                tblBandejaSolicitudesEmitidoPorDevolver.ajax.reload();
                $("div.actionButtons button").css("display","none");
                $('.actionButtons').hide(100);
            });

            btnHistorico.on('click', function(e) {
                var elems = document.querySelector('#modalHistorico');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();

                var tablaObtenerDato = tblBandejaSolicitudesEmitidoPorRecibir;
                if (tblBandejaSolicitudesEmitidoPorRecibir.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesEmitidoPorRecibir;
                } else if (tblBandejaSolicitudesEmitidoPorDevolver.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesEmitidoPorDevolver;
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
                        IdSolicitudPrestamo: fila.idSolicitudPrestamo
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

        });
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>