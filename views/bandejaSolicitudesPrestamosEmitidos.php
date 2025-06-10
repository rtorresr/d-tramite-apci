<?php
session_start();
$pageTitle = "Bandeja de servicios archivísticos";
$activeItem = "bandejaSolicitudesPrestamosEmitidos.php";
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
                        <li><button id="btnVistoBueno" style="display: none" class="btn btn-primary"><i class="fas fa-signature"></i><span> Visto Bueno</span></button></li>
                        <li><button id="btnFirmaCargo" style="display: none" class="btn btn-primary"><i class="fas fa-signature"></i><span> Firma cargo</span></button></li>
                        <li><button id="btnFirmaCargoDevolucion" style="display: none" class="btn btn-primary"><i class="fas fa-signature"></i><span> Firma devolución</span></button></li>
                        <li><button id="btnVerSolicitud" style="display: none" class="btn btn-link"><i class="fas fa-clipboard fa-fw left"></i><span> Ver Solicitud</span></button></li>
                        <li><button id="btnHistorico" style="display: none" class="btn btn-link"><i class="fas fa-eye"></i><span> Ver historico</span></button></li>
                        <li><button id="btnEditarSolicitud" style="display: none" class="btn btn-link"><i class="fas fa-clipboard fa-fw left"></i><span> Editar Solicitud</span></button></li>
                        <li><button id="btnArchivarSolicitud" style="display: none" class="btn btn-link"><i class="fas fa-box-full"></i><span> Archivar Solicitud</span></button></li>
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
                                        <li id="btnEmitidosFinalizados" class="tab col s3"><a href="#emitidosFinalizados">Emitidos</a></li>
                                    </ul>
                                </div>
                                <div id="emitidosFinalizados" class="col s12">
                                    <table id="tblBandejaSolicitudesEmitidoFinalizados" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Oficina Solicitante</th>
                                            <th>Documento</th>
                                            <!--<th>Servicio</th>
                                            <th>Última notificación</th>
                                            <th>Fecha de recepción</th>
                                            <th>Fecha de devolución</th>-->
                                            <th>Estado</th>
                                            <th>Plazo de Atención</th>
                                            <th>Observación</th>
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

    <div id="modalVerSolicitud" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Solicitud de servicios</h4>
        </div>
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <input type="hidden" name="IdSolicitudPrestamoVer" id="IdSolicitudPrestamoVer" value="0">
                    <table id="tblVerSolicitudPrestamo" class="table table-bordered" style="display: none; width: 100%;">
                        <thead>
                        <tr>
                            <th>Serie Documental</th>
                            <th>Descripción</th>
                            <th>Servicio Requerido</th>
                            <th>Requiere Doc. Digital</th>
                            <th>Tiene Doc. Digital</th>
                            <th>Servicio dado</th>
                            <th>Estado</th>
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

    <div id="modalEditarSolicitud" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Edición Solicitud préstamo documento</h4>
        </div>
        <div class="modal-content">
            <div id="datosSolicitud">
                <div class="row">
                    <div class="col s12">
                        <a class="btn-primary btn" id="AgregarDetalle">Nuevo</a>
                    </div>
                    <div class="col s12">
                        <table id="tblDetalleSolicitudEdicion" style="display: none; width: 100%;">
                            <thead>
                            <tr>
                                <th>Serie Documental</th>
                                <th>Descripción</th>
                                <th>Servicio Requerido</th>
                                <th>Requiere Doc. Digital</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            
            <div id="formularioEditarDatos" style="display: none">            
                <form>
                    <input type="hidden" value="0" name="codSolicitudPrestamo" id="codSolicitudPrestamo">
                    <input type="hidden" value="0" name="codDetalleSolicitud" id="codDetalleSolicitud">
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <input id="NroExpediente" type="text" class="validate" name="NroExpediente">
                            <label for="NroExpediente">Serie documental</label>
                        </div>
                        <div class="input-field col s12 m12">
                            <textarea id="DescripcionDocumento" name="DescripcionDocumento" class="materialize-textarea" style="height: 127px;!important"></textarea>
                            <label for="DescripcionDocumento">Descripción documento</label>                                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <div class="switch">
                                <label>
                                    Digital
                                    <input type="checkbox" id="FlgTipoDocumento" name="FlgTipoDocumento" value="1">
                                    <span class="lever"></span>
                                    Físico
                                </label>
                            </div>
                        </div>
                        <div class="col s6 input-field" style="display: none;">
                            <select id="idTipoServicioOfrecido" name="idTipoServicioOfrecido">
                            </select>
                            <label for="idTipoServicioOfrecido">Tipo de servicio físico</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="btnGuardarDatos"> Guardar</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelarDatos"> Cancelar</button>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnEnviar"> Enviar</a>
            <a class="modal-close waves-effect waves-green btn-flat"> Cerrar</a>
        </div>
    </div>

    <div id="modalArchivar" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Archivar solicitud de préstamo</h4>
        </div>
        <div class="modal-content">
            <form>
                <div class="row">
                    <div class="col s12 input-field ">
                        <input type="text" id="observacionArchivar" name="observacionArchivar">
                        <label for="observacionArchivar">Observación</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnArchivarSolicitudPrestamo"> Archivar</a>
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

        // window.onload = function() {
        //     mueveReloj();
        // };
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

            let evento = 'GuardarVistoBueno';

            if(firmaRealizada == 'GuardarFirmaCargo'){
                evento = 'GuardarFirmaCargo';
            } else if(firmaRealizada == 'GuardarFirmaDevolucion'){
                evento = 'GuardarFirmaDevolucion';
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
                    // tblBandejaSolicitudesEmitidoFinalizados.clear().draw();
                    // tblBandejaSolicitudesEmitidoFinalizados.ajax.reload();
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

            var btnVistoBueno = $("#btnVistoBueno");
            var btnFirmaCargo = $("#btnFirmaCargo");
            var btnFirmaCargoDevolucion = $("#btnFirmaCargoDevolucion");
            var btnVerSolicitud = $("#btnVerSolicitud");
            var btnEditarSolicitud = $("#btnEditarSolicitud"); 
            var btnArchivarSolicitud = $("#btnArchivarSolicitud");      
            var btnHistorico = $("#btnHistorico");              

            var actionButtonsEmitidosFinalizados = [];
            var supportButtonsEmitidosFinalizados = [btnVerSolicitud, btnHistorico, btnEditarSolicitud, btnArchivarSolicitud];

            var tblBandejaSolicitudesEmitidoFinalizados = $('#tblBandejaSolicitudesEmitidoFinalizados').DataTable({
                responsive: true,
                ajax: {
                    url: 'ajaxtablas/ajaxBdSolicitudesPrestamosEmitidos.php',
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {
                                "IdEstadoSolicitudPrestamo": 0,
                            }
                        );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaSolicitudesEmitidoFinalizados_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaSolicitudesEmitidoFinalizados.rows().deselect();
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
                    /*,{'data': 'ultimaFecNotificacion', 'autoWidth': true}
                    ,{'data': 'fechaRecepcion', 'autoWidth': true}
                    ,{'data': 'fechaDevolucion', 'autoWidth': true}*/
                    ,{'data': 'estado', 'autoWidth': true}                    
                    ,{'data': 'fecPlazoAtencion', 'autoWidth': true}
                    ,{'data': 'observacion', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            tblBandejaSolicitudesEmitidoFinalizados
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEmitidoFinalizados.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            let fila = tblBandejaSolicitudesEmitidoFinalizados.rows( { selected: true } ).data().toArray()[0];

                            switch(fila.IdEstadoSolicitudPrestamo) {
                                case 112: //nuevo
                                    btnVistoBueno.css("display","inline-block");
                                    break;
                                case 115: //nuevo
                                    btnFirmaCargo.css("display","inline-block");
                                    break;
                                case 116: //nuevo
                                    btnFirmaCargoDevolucion.css("display","inline-block");
                                    break;
                            }

                            $.each( actionButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            
                            if (fila.IdEstadoSolicitudPrestamo != 93 && fila.IdEstadoSolicitudPrestamo != 95 && fila.IdEstadoSolicitudPrestamo != 96) {
                                btnEditarSolicitud.css("display","none");
                                btnArchivarSolicitud.css("display","none");
                            }

                            break;

                        default:
                            $.each( actionButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaSolicitudesEmitidoFinalizados.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            let fila = tblBandejaSolicitudesEmitidoFinalizados.rows( { selected: true } ).data().toArray()[0];
                            if (fila.IdEstadoSolicitudPrestamo != 93 && fila.IdEstadoSolicitudPrestamo != 95 && fila.IdEstadoSolicitudPrestamo != 96) {
                                btnEditarSolicitud.css("display","none");
                                btnArchivarSolicitud.css("display","none");
                            }

                            break;

                        default:
                            $.each( actionButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtonsEmitidosFinalizados, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            var tblVerSolicitudPrestamo = $('#tblVerSolicitudPrestamo').DataTable({
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
                        $("#tblVerSolicitudPrestamo").css('display','none');
                    } else{
                        $("#tblVerSolicitudPrestamo").css('display','table');
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
                    /*{
                        'render': function (data, type, full, meta) {
                            let botones = '';
                            if (full.FlgTieneDocDigital === 0){
                                botones += '<button type="button" data-accion="ver-documento" title="Ver documento" data-tooltip="Ver documento" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-eye"></i></button>';
                            }
                            return botones;
                        }, 'className': 'text-center',"width": "20px"
                    }*/
                ]
            });

            /*$('#tblVerSolicitudPrestamo tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblVerSolicitudPrestamo.row($(this).parents('tr'));
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
            });*/

            btnVerSolicitud.on("click", function (e) {
                let elem = document.querySelector('#modalVerSolicitud');
                let instance = M.Modal.init(elem, {dismissible:false});

                var tablaObtenerDato = tblBandejaSolicitudesEmitidoFinalizados;

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                $('#IdSolicitudPrestamoVer').val(values[0].IdSolicitudPrestamo);
                tblVerSolicitudPrestamo.ajax.reload();
                instance.open();
            });

            $('#btnEmitidosFinalizados').on('click', function (e) {
                tblBandejaSolicitudesEmitidoFinalizados.ajax.reload();
                $("div.actionButtons button").css("display","none");
                $('.actionButtons').hide(100);
            });

            var tblDetalleSolicitudEdicion = $('#tblDetalleSolicitudEdicion').DataTable({
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
                        $("#tblDetalleSolicitudEdicion").css('display','none');
                    } else{
                        $("#tblDetalleSolicitudEdicion").css('display','block');
                    }
                },
                'columns': [
                    { 'data': 'ExpedienteDocumento'},
                    { 'data': 'DescripcionDocumento'},
                    { 'data': 'NomTipoServicio'},
                    //{ 'data': 'NomTipoUbicacion', 'autoWidth': true},
                    { 'data': 'RequiereDocDigital'},
                    { 'data': 'NomEstadoDetallePrestamo'},
                    {
                        'render': function (data, type, full, meta) {
                            let botones = '';
                            if (full.IdEstadoDetallePrestamo === 12){
                                botones += '<button type="button" data-accion="editar" title="Editar" data-tooltip="Editar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Editar"><i class="fas fa-pen-square"></i></button>';
                                botones += '<button type="button" data-accion="eliminar" title="Eliminar" data-tooltip="Eliminar" class="btn btn-sm btn-link tooltipped red-text" data-position="bottom" name="Eliminar"><i class="fas fa-trash-alt"></i></button>';
                            }
                            return botones;
                        }, 'className': 'text-center',"width": "20px"
                    }
                ]
            });

            function ContenidosTipo(idDestino, codigoTipo, selected = 0){
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
                            if (selected == value.codigo){
                                destino.append('<option value="'+value.codigo+'" selected>'+value.nombre+'</option>');
                            } else {
                                destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                            }                            
                        });
                        var elem = document.getElementById(idDestino);
                        M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                    }
                });
            }

            $("#FlgTipoDocumento").on("change",function (e) {
                if ($("#FlgTipoDocumento:checked").length === 1){
                    $("#idTipoServicioOfrecido").parent().parent().css("display","inline-block")
                } else {
                    $("#idTipoServicioOfrecido").parent().parent().css("display","none")
                }
            });

            $('#tblDetalleSolicitudEdicion tbody').on('click', 'button', function (e) {
                e.preventDefault();
                let fila = tblDetalleSolicitudEdicion.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {                    
                    case 'editar':
                        $("#codDetalleSolicitud").val(dataFila.IdDetallePrestamo);                        
                        $("#NroExpediente").val(dataFila.ExpedienteDocumento).next().addClass('active');
                        $("#DescripcionDocumento").val(dataFila.DescripcionDocumento).next().addClass('active');
                        if(dataFila.FlgDocDigital == 1){
                            $('#FlgTipoDocumento').prop('checked',true);
                            ContenidosTipo("idTipoServicioOfrecido",8, dataFila.IdTipoServicioOfrecido);
                        } else {
                            $('#FlgTipoDocumento').prop('checked',false);
                            ContenidosTipo("idTipoServicioOfrecido",8);
                        }
                        $('#FlgTipoDocumento').trigger("change");                        
                        $("#formularioEditarDatos").css("display","block");
                        break;
                    case 'eliminar':
                        $.confirm({
                            title: '¿Esta seguro de eliminar el registro?',
                            content: '',
                            buttons: {
                                Cancelar: function () {
                                    $.alert('Proceso de eliminación cancelada');
                                },
                                Si: {
                                    text: 'Anular',
                                    btnClass: 'red',
                                    action: function() {
                                        getSpinner();
                                        let formData = new FormData();
                                        formData.append("Evento","EliminarDetalle");
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
                                                tblDetalleSolicitudEdicion.ajax.reload();
                                            }
                                        });
                                    }
                                }
                            }
                        });
                        break;
                }
            });

            $("#AgregarDetalle").on("click", function(e){
                $("#codDetalleSolicitud").val(0);                        
                $("#NroExpediente").val("");
                $("#DescripcionDocumento").val("");
                $('#FlgTipoDocumento').prop('checked',false);
                $('#FlgTipoDocumento').trigger("change");
                ContenidosTipo("idTipoServicioOfrecido",8);                   
                $("#formularioEditarDatos").css("display","block");
            });

            $('#btnGuardarDatos').on('click', function (e) {
                e.preventDefault();
                let data = $('#formularioEditarDatos form').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","EditarDatosDetallePrestamo");
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
                        $("#NroExpediente").val("");
                        $("#DescripcionDocumento").val("");
                        $('#FlgTipoDocumento').prop('checked',false);
                        $('#FlgTipoDocumento').trigger("change");
                        ContenidosTipo("idTipoServicioOfrecido",8);
                        $("#formularioEditarDatos").css("display","none");
                        tblDetalleSolicitudEdicion.ajax.reload();
                    }
                });
            });

            $('#btnCancelarDatos').on('click', function (e) {
                $("#codDetalleSolicitud").val(0);                        
                $("#NroExpediente").val("");
                $("#DescripcionDocumento").val("");
                $('#FlgTipoDocumento').prop('checked',false);
                $('#FlgTipoDocumento').trigger("change");
                ContenidosTipo("idTipoServicioOfrecido",8);
                $("#formularioEditarDatos").css("display","none");
            });

            btnEditarSolicitud.on('click', function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalEditarSolicitud');
                let instance = M.Modal.init(elem, {dismissible:false});
                let rows_selected = tblBandejaSolicitudesEmitidoFinalizados.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEmitidoFinalizados.rows(rowId).data()[0]);
                });
                $("#codSolicitudPrestamo").val(values[0].IdSolicitudPrestamo);
                tblDetalleSolicitudEdicion.ajax.reload();
                instance.open();
            });

            $("#btnEnviar").on("click", function (e) {
                let formData = new FormData();
                formData.append("Evento","EnviarSolicitudPrestamo");
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
                        M.toast({html: '¡Solicitud envida!'});
                        tblBandejaSolicitudesEmitidoFinalizados.ajax.reload();
                        let elem = document.querySelector('#modalEditarSolicitud');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                    }
                });
            });

            btnArchivarSolicitud.on("click", function (e) {
                let elem = document.querySelector('#modalArchivar');
                let instance = M.Modal.init(elem, {dismissible:false});
                $("#observacionArchivar").val('');
                instance.open();
            });

            $("#btnArchivarSolicitudPrestamo").on("click", function (e) {
                e.preventDefault();
                var tablaObtenerDato = tblBandejaSolicitudesEmitidoFinalizados;
                if (tblBandejaSolicitudesEmitidoFinalizados.column(0).checkboxes.selected().length !== 0){
                    var tablaObtenerDato = tblBandejaSolicitudesEmitidoFinalizados;
                } else if (tblBandejaSolicitudesEmitidoFinalizados.column(0).checkboxes.selected().length !== 0) {
                    var tablaObtenerDato = tblBandejaSolicitudesEmitidoFinalizados;
                }

                let rows_selected = tablaObtenerDato.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tablaObtenerDato.rows(rowId).data()[0]);
                });
                let fila = values[0];

                let formData = new FormData();
                formData.append("Evento","ArchivarSolicitudPrestamo");
                formData.append("IdSolicitudPrestamo", fila.IdSolicitudPrestamo);
                formData.append("Observacion",$("#observacionArchivar").val());
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
                        if (data.ARCHIVADO === 1){
                            M.toast({html: '¡No se pudo archivar la solicitud!'});
                        } else {
                            M.toast({html: '¡Solicitud archivada!'});
                        }
                        let elem = document.querySelector('#modalArchivar');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        tablaObtenerDato.ajax.reload();
                    }
                });

            });

            btnHistorico.on('click', function(e) {
                var elems = document.querySelector('#modalHistorico');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();

                var tablaObtenerDato = tblBandejaSolicitudesEmitidoFinalizados;

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

            btnVistoBueno.on("click", function (e) {
                let rows_selected = tblBandejaSolicitudesEmitidoFinalizados.column(0).checkboxes.selected();

                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEmitidoFinalizados.rows(rowId).data()[0]);
                });
                let fila = values[0];

                $("#idSolicitudPrestamo").val(fila.IdSolicitudPrestamo);
                $("#idDigital").val(fila.IdArchivoSolicitud);
                $("#tipo_f").val('v');
                $("#nroVisto").val(0);
                $("#idTipoTra").val(2);
                $("#flgRequireFirmaLote").val(0);

                sendParam();
            });

            btnFirmaCargo.on("click", function (e) {
                let rows_selected = tblBandejaSolicitudesEmitidoFinalizados.column(0).checkboxes.selected();

                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEmitidoFinalizados.rows(rowId).data()[0]);
                });
                let fila = values[0];

                $("#idSolicitudPrestamo").val(fila.IdSolicitudPrestamo);
                $("#idDigital").val(fila.IdArchivoCargoPrestamo);
                $("#tipo_f").val('F');
                $("#nroVisto").val(0);
                $("#idTipoTra").val(2);
                $("#flgRequireFirmaLote").val(0);
                $("#firmaRealizada").val("GuardarFirmaCargo");

                sendParam();
            });

            btnFirmaCargoDevolucion.on("click", function (e) {
                let rows_selected = tblBandejaSolicitudesEmitidoFinalizados.column(0).checkboxes.selected();

                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaSolicitudesEmitidoFinalizados.rows(rowId).data()[0]);
                });
                let fila = values[0];

                $("#idSolicitudPrestamo").val(fila.IdSolicitudPrestamo);
                $("#idDigital").val(fila.IdArchivoCargoDevolucion);
                $("#tipo_f").val('F');
                $("#nroVisto").val(0);
                $("#idTipoTra").val(2);
                $("#flgRequireFirmaLote").val(0);
                $("#firmaRealizada").val("GuardarFirmaDevolucion");

                sendParam();
            });

            
        });
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>