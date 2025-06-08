<?php
session_start();

$pageTitle = "Bandeja de Recibidos Mesa de partes digital";
$activeItem = "BandejaRecibidosMpv.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li>
                            <a id="btnRevisar" style="display: none" class="btn btn-flat btn-primary tooltipped" href="#" data-position="top" data-tooltip="Revisar">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 40 0 C 34.5 0 30 4.5 30 10 C 30 15.5 34.5 20 40 20 C 45.5 20 50 15.5 50 10 C 50 4.5 45.5 0 40 0 z M 40 2 C 44.4 2 48 5.6 48 10 C 48 14.4 44.4 18 40 18 C 35.6 18 32 14.4 32 10 C 32 5.6 35.6 2 40 2 z M 44.300781 5.4003906 L 38.900391 11.699219 L 35.599609 9.1992188 L 34.400391 10.800781 L 39.099609 14.400391 L 45.800781 6.6992188 L 44.300781 5.4003906 z M 9 8 C 8.569 8 8.1877813 8.2745937 8.0507812 8.6835938 L 2.0507812 26.683594 C 2.0494749 26.687505 2.0500835 26.691397 2.0488281 26.695312 A 1.0001 1.0001 0 0 0 2 27 L 2 42 A 1.0001 1.0001 0 0 0 3 43 L 47 43 A 1.0001 1.0001 0 0 0 48 42 L 48 27 A 1.0001 1.0001 0 0 0 47.947266 26.683594 L 45.873047 20.457031 C 45.291047 20.784031 44.679969 21.059109 44.042969 21.287109 L 45.613281 26 L 32 26 A 1.0001 1.0001 0 0 0 31 27 C 31 30.325562 28.325562 33 25 33 C 21.674438 33 19 30.325562 19 27 A 1.0001 1.0001 0 0 0 18 26 L 4.3867188 26 L 9.7207031 10 L 28 10 C 28 9.317 28.069688 8.652 28.179688 8 L 9 8 z M 4 28 L 17.203125 28 C 17.718014 31.915394 20.947865 35 25 35 C 29.052135 35 32.281986 31.915394 32.796875 28 L 46 28 L 46 41 L 4 41 L 4 28 z"/>
                                </svg>
                                <span>Revisar</span>
                            </a>
                        </li>
                        <li>
                            <a id="btnAnular" style="display: none" class="btn btn-link tooltipped" href="#modalRechazar" data-position="top" data-tooltip="Anular">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 25 2 C 12.309534 2 2 12.309534 2 25 C 2 37.690466 12.309534 48 25 48 C 37.690466 48 48 37.690466 48 25 C 48 12.309534 37.690466 2 25 2 z M 25 4 C 36.609534 4 46 13.390466 46 25 C 46 36.609534 36.609534 46 25 46 C 13.390466 46 4 36.609534 4 25 C 4 13.390466 13.390466 4 25 4 z M 32.990234 15.986328 A 1.0001 1.0001 0 0 0 32.292969 16.292969 L 25 23.585938 L 17.707031 16.292969 A 1.0001 1.0001 0 0 0 16.990234 15.990234 A 1.0001 1.0001 0 0 0 16.292969 17.707031 L 23.585938 25 L 16.292969 32.292969 A 1.0001 1.0001 0 1 0 17.707031 33.707031 L 25 26.414062 L 32.292969 33.707031 A 1.0001 1.0001 0 1 0 33.707031 32.292969 L 26.414062 25 L 33.707031 17.707031 A 1.0001 1.0001 0 0 0 32.990234 15.986328 z"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a id="btnFlow" style="display: none" class="btn btn-link tooltipped" data-position="top" data-tooltip="Flujo">
                                <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                    <path d="M 3 6 C 1.355469 6 0 7.355469 0 9 L 0 15 C 0 16.644531 1.355469 18 3 18 L 11 18 C 12.644531 18 14 16.644531 14 15 L 14 13 L 20 13 L 20 15 C 20 16.644531 21.355469 18 23 18 L 31 18 C 32.644531 18 34 16.644531 34 15 L 34 13 L 39 13 C 40.65625 13 42 14.34375 42 16 L 42 19 L 39 19 C 37.355469 19 36 20.355469 36 22 L 36 28 C 36 29.644531 37.355469 31 39 31 L 42 31 L 42 34 C 42 35.65625 40.65625 37 39 37 L 34 37 L 34 35 C 34 33.355469 32.644531 32 31 32 L 23 32 C 21.355469 32 20 33.355469 20 35 L 20 37 L 14 37 L 14 35 C 14 33.355469 12.644531 32 11 32 L 3 32 C 1.355469 32 0 33.355469 0 35 L 0 41 C 0 42.644531 1.355469 44 3 44 L 11 44 C 12.644531 44 14 42.644531 14 41 L 14 39 L 20 39 L 20 41 C 20 42.644531 21.355469 44 23 44 L 31 44 C 32.644531 44 34 42.644531 34 41 L 34 39 L 39 39 C 41.746094 39 44 36.746094 44 34 L 44 31 L 47 31 C 48.644531 31 50 29.644531 50 28 L 50 22 C 50 20.355469 48.644531 19 47 19 L 44 19 L 44 16 C 44 13.253906 41.746094 11 39 11 L 34 11 L 34 9 C 34 7.355469 32.644531 6 31 6 L 23 6 C 21.355469 6 20 7.355469 20 9 L 20 11 L 14 11 L 14 9 C 14 7.355469 12.644531 6 11 6 Z M 3 8 L 11 8 C 11.554688 8 12 8.445313 12 9 L 12 15 C 12 15.554688 11.554688 16 11 16 L 3 16 C 2.445313 16 2 15.554688 2 15 L 2 9 C 2 8.445313 2.445313 8 3 8 Z M 23 8 L 31 8 C 31.554688 8 32 8.445313 32 9 L 32 15 C 32 15.554688 31.554688 16 31 16 L 23 16 C 22.445313 16 22 15.554688 22 15 L 22 9 C 22 8.445313 22.445313 8 23 8 Z M 39 21 L 47 21 C 47.554688 21 48 21.445313 48 22 L 48 28 C 48 28.554688 47.554688 29 47 29 L 39 29 C 38.445313 29 38 28.554688 38 28 L 38 22 C 38 21.445313 38.445313 21 39 21 Z M 3 34 L 11 34 C 11.554688 34 12 34.445313 12 35 L 12 41 C 12 41.554688 11.554688 42 11 42 L 3 42 C 2.445313 42 2 41.554688 2 41 L 2 35 C 2 34.445313 2.445313 34 3 34 Z M 23 34 L 31 34 C 31.554688 34 32 34.445313 32 35 L 32 41 C 32 41.554688 31.554688 42 31 42 L 23 42 C 22.445313 42 22 41.554688 22 41 L 22 35 C 22 34.445313 22.445313 34 23 34 Z"/>
                                </svg>
                            </a>
                        </li>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">                        
                        <div class="card-content">
                            <span class="card-title"><h6>Filtros de búsqueda</h6></span>
                            <div class="row">
                                <div class="col s3 input-field">
                                    <select name="idEstado" id="idEstado" class="FormPropertReg form-control"></select>
                                    <label for="idEstado">Estado</label>
                                </div>
                                <div class="col s3 input-field">
                                    <input type="text" name="fecInicio" id="fecInicio" class="datepicker">
                                    <label for="fecInicio">Fecha Inicio</label>
                                </div>
                                <div class="col s3 input-field">
                                    <input type="text" name="fecFin" id="fecFin" class="datepicker">
                                    <label for="fecFin">Fecha Fin</label>
                                </div>
                                <div class="col s3 input-field">
                                    <select name="idCol" id="idCol" class="FormPropertReg form-control">
                                        <option value="0" selected>Fecha de registro Mesa de Partes Digital</option>
                                        <option value="1">Fecha de registro D-tramite</option>
                                    </select>
                                    <label for="idCol">Tipo de fecha de búsqueda</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-content">                            
                            <div class="row">
                                <div class="col s12">
                                    <table id="tblRecibidos" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Registro D-tramite</th>
                                                <th>Entidad</th>
                                                <th>Documento</th>
                                                <th>Asunto</th>
                                                <th>Tipo de trámite</th>
                                                <th>Casuística</th>
                                                <th>Contacto</th>
                                                <th>Fecha de registro</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <!-- form para cambiar de pantalla -->
                    <form id="frmIr" method="POST" action=""></form>
                </div>
            </div>
        </div>
    </main>

    <div id="modalHistorico" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Histórico</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalAnulacion" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Registro de Anulación</h4>
        </div>
        <div class="modal-content">
            <div class="row">
                <div class="col m12 input-field">
                    <textarea id="textoMotivo" name="textoMotivo"  class="materialize-textarea FormPropertReg" rows="3"></textarea>
                    <label for="textoMotivo" class="active">Motivo</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-close waves-effect waves-green btn-flat" >Cerrar</button>
            <a class="waves-effect waves-green btn-flat btn-primary" id="btnEnviarAnulacion" >Guardar</a>
        </div>
    </div>

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>
</body>

<script>
    var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
    var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
    var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
    var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

    $(document).ready(function() {
        $('.datepicker').datepicker({
            i18n: {
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                weekdaysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                weekdaysAbbrev: ["D", "L", "M", "M", "J", "V", "S"],
                cancel: "Cancelar",
                clear: "Limpiar"
            },
            format: 'dd-mm-yyyy',
            disableWeekends: true,
            autoClose: true,
            showClearBtn: true,
            container: 'body'
        });
        $("#idCol").parent(".select-wrapper").children("input.select-dropdown").prop("disabled", true);
        $('.actionButtons').hide();

        ContenidosTipo("idEstado", 35,85);

        tblRecibidos = $('#tblRecibidos').DataTable({
            'processing': false,
            'serverSide': true,
            'pageLength': 10,
            'ajax': {
                url: 'ajax/ajaxRegMpv.php',
                type: 'POST',
                datatype: 'json',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "Accion": "ListarRecibidosMpv",
                        "IdEstado": $("#idEstado").val(),
                        "FecInicio": $("#fecInicio").val(),
                        "FecFin": $("#fecFin").val(),
                        "IdCol": $("#idCol").val()
                    });
                }
            },
            drawCallback: function( settings ) {
                $(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tblBandejaPendientes_length"]').formSelect();

                $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                    tblRecibidos.rows().deselect();
                }); 
            },
            dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
            buttons: [
                { 
                    extend: 'excelHtml5', 
                    text: '<i class="fas fa-file-excel"></i> Excel', 
                    action: function ( e, dt, node, config ) {
                        var datos = {
                            "Accion": "DescargarListadoRecibidosMpv",
                            "IdEstado": $("#idEstado").val(),
                            "FecInicio": $("#fecInicio").val(),
                            "FecFin": $("#fecFin").val(),
                            "IdCol": $("#idCol").val(),
                            "start": 0,
                            "length": dt.page.info().recordsTotal,
                            "search": $("#tblRecibidos_wrapper input[type=search]").val()
                        }

                        openWindowWithPost("ajax/ajaxRegMpv.php", datos);
                    }
                },
                // { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' }
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
                }
            ],
            'columns': [  
                {'data': 'IdMesaPartesVirtual', 'width': '3%'}
                ,{
                    'render': function (data, type, full, meta) {
                        var html = '';
                        if (full.Cud != null && full.Cud != ''){     
                            html = `<b>CUD: </b>${full.Cud}<br/>
                                <i>${full.FecRegistroTramite}</i>`;
                        }
                        return html;
                    }, 'width': '10%'
                }
                ,{
                    'render': function (data, type, full, meta) {
                        var html = `<b>${full.DesTipoEntidad}</b><br/>
                            <small><i><b>${full.DesTipoDocEntidad}</b>: ${full.NumeroDocEntidad}</i></small><br/>
                            ${full.NombreEntidad}`                        
                        return html;
                    }, 'width': '15%'
                }
                ,{
                    'render': function (data, type, full, meta) {       
                        var html = `<b>${full.DesTipoDoc}</b><br/>
                            ${full.NumeroDoc}<br/>
                            <i>${full.FecDocumento}</i>`;
                        return html;
                    }, 'width': '10%'
                }
                ,{'data': 'Asunto', 'width': '17%'}
                ,{
                    'render': function (data, type, full, meta) {
                        var tipoTramite = 'General';
                        var desTipoTramite = '';
                        if (full.IdTipoProcedimiento != null){
                            if (full.IdTipoProcedimiento == 1){
                                tipoTramite = 'Procedimientos administrativos';
                            }
                            if (full.IdTipoProcedimiento == 3){
                                tipoTramite = 'Tramites administrativos';
                            }
                            if (full.IdTipoProcedimiento == 4){
                                tipoTramite = 'Otros trámites';
                            }
                            desTipoTramite = `<br/><small>${full.DesTupa}</small>`;
                        }
                        var html = `<b>${tipoTramite}</b>${desTipoTramite}`;
                        return html;
                    }, 'width': '12%'
                }
                ,{
                    'render': function (data, type, full, meta) {
                        var esTupa = '';
                        var esSigcti = '';
                        var esReingreso = '';

                        if (full.FlgEsTupa == 1){
                            esTupa = `<b>- Es TUPA</b>`;
                        }

                        if (full.FlgSigcti == 1){
                            esSigcti = `<br/><b>- Proviene de SIGCTI</b><br>&nbsp;&nbsp;<i><b>Constancia:</b> ${full.NroSigcti}</i>`;
                        }

                        if (full.FlgTieneCud == 1){
                            esReingreso = `<br/><b>- Es reingreso</b><br>&nbsp;&nbsp;<i><b>CUD:</b> ${full.NroCud}-${full.AnioCud}</i>`;
                        }

                        var html = `${esTupa}${esSigcti}${esReingreso}`;
                        return html;
                    }, 'width': '13%'
                }
                ,{
                    'render': function (data, type, full, meta) {       
                        var html = `<b>${full.TelefonoContacto}</b><br/>
                            ${full.CorreoContacto}`;
                        return html;
                    }, 'width': '12%'
                }
                ,{
                    'render': function (data, type, full, meta) {
                        return full.FecRegistro;
                    }, 'width': '8%'
                }
                ,{
                    'render': function (data, type, full, meta) {
                        return full.DesEstado;
                    }, 'width': '10%'
                }
            ],
            'select': {
                'style': 'multi'
            },
            'initComplete': function () {
                var api = this.api();
                api.column(9).visible(false);
                if ($("#idEstado").val() == 88) {
                    api.column(1).visible(true);
                } else {
                    api.column(1).visible(false);
                }
            }
        });

        var btnRevisar = $("#btnRevisar");
        var btnAnular = $("#btnAnular");
        var btnFlow = $("#btnFlow");

        var actionButtons = [btnRevisar, btnAnular, btnFlow];
        var supportButtons = [];

        tblRecibidos
            .on( 'select', function ( e, dt, type, indexes ) {
                let count = tblRecibidos.rows( { selected: true } ).count();
                switch (count) {
                    case 1:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });

                        let fila = tblRecibidos.rows( { selected: true } ).data().toArray()[0];

                        if (fila.IdEstado == 88 || fila.IdEstado == 89) {
                            btnAnular.css("display","none");
                        }

                        $('.actionButtons').show();
                        break;

                    default:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        break;
                }

            })
            .on( 'deselect', function ( e, dt, type, indexes ) {
                let count = tblRecibidos.rows( { selected: true } ).count();
                switch (count) {
                    case 0:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","none");
                        });

                        $('.actionButtons').hide(100);

                        break;

                    case 1:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });

                        let fila = tblRecibidos.rows( { selected: true } ).data().toArray()[0];                        

                        if (fila.IdEstado == 88 || fila.IdEstado == 89) {
                            btnAnular.css("display","none");
                        }
                        
                        break;

                    default:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        break;
                }
            });

        btnRevisar.on('click', function(e) {
            e.preventDefault();
            var fila = tblRecibidos.rows( { selected: true } ).data().toArray()[0];

            $("#frmIr").attr("action","RevisionMpv.php");
            var html = `<input name="Id" value="${fila.IdMesaPartesVirtual}">`;

            if (fila.IdEstado == 85 || fila.IdEstado == 87){
                html += `<input name="Transaccion" value="1">`;
            } else {
                html += `<input name="Transaccion" value="4">`;
            }
            $("#frmIr").html(html);

            $("#frmIr").submit();
        });  

        btnAnular.on('click', function(e) {
            e.preventDefault();
            $("#textoMotivo").val("");
            let elems = document.querySelector('#modalAnulacion');
            let instance = M.Modal.init(elems, {dismissible:false});
            instance.open();
        });

        $("#btnEnviarAnulacion").on("click", function(e){
            getSpinner('Anulando...');
            var fila = tblRecibidos.rows( { selected: true } ).data().toArray()[0];
            $.post("ajax/ajaxRegMpv.php", 
                {
                    Accion: "AnularRegistro", 
                    IdMesaPartesVirtual: fila.IdMesaPartesVirtual,
                    Motivo: $("#textoMotivo").val()
                })
                .done(function(response){
                    var response = JSON.parse(response);
                    if (response.success){
                        deleteSpinner();
                        M.toast({html: 'Anulado correctamente!'});
                        tblRecibidos.ajax.reload();
                        M.Modal.getInstance($("#modalAnulacion")).close();
                    } else {
                        deleteSpinner();
                        M.toast({html: response.mensaje});
                    }                
                })
                .fail(function(response){
                    M.toast({html: 'Error al registrar el documento!'});
                    deleteSpinner();
                });
        });

        btnFlow.on('click', function(e) {
            var elems = document.querySelector('#modalHistorico');
            var instance = M.Modal.getInstance(elems);
            e.preventDefault();
            var fila = tblRecibidos.rows( { selected: true } ).data().toArray()[0];
            $.post("ajax/ajaxRegMpv.php", 
                {
                    Accion: "ListarHistorico", 
                    IdMesaPartesVirtual: fila.IdMesaPartesVirtual
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
                                <td>${elem.Responsable}</td>
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

        $("#idEstado").on("change", function(e){
            tblRecibidos.ajax.reload();
            $('#tblRecibidos').trigger("deselect");

            var api = $('#tblRecibidos').dataTable().api();
            if ($("#idEstado").val() != ''){
                api.column(9).visible(false);
                if ($("#idEstado").val() == 88) {
                    api.column(1).visible(true);
                } else {
                    api.column(1).visible(false);
                }
            } else {
                api.column(1).visible(true);
                api.column(9).visible(true);
            }
            
            $("#idCol").val(0).formSelect();
            if($("#idEstado").val() == 88){
                $("#idCol").parent(".select-wrapper").children("input.select-dropdown").prop("disabled", false);
            } else {
                $("#idCol").parent(".select-wrapper").children("input.select-dropdown").prop("disabled", true);
            }
        });

        $("#fecInicio, #fecFin, #idCol").on("change", function(e){
            tblRecibidos.ajax.reload();
            $('#tblRecibidos').trigger("deselect");
        });
    }); 
    
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
                destino.formSelect();
            }
        });
    }    

    function openWindowWithPost(url, data) {
        var form = document.createElement("form");
        form.target = "_blank";
        form.method = "POST";
        form.action = url;
        form.style.display = "none";

        for (var key in data) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>

</html>
<?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>