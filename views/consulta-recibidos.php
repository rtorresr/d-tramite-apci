<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Consulta de Documentos Recibidos";
$activeItem = "consulta-recibidos.php";
$navExtended = true;

$nNumAno    = date("Y");
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
        <div class="navbar-fixed actionButtons searchForm">
            <nav style="width: calc(100% - 300px)">
                <form>
                    <div class="nav-wrapper">
                        <div class="row" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
                            <div class="col s6 input-field">
                                <ul id="nav-mobile" class="">
                                    <li><a id="btnFlow" class="btn disabled btn-link modal-trigger" href="#modalFlujo"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                                    <li><a id="btnDoc" class="btn disabled btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver</span></a></li>
                                    <li><a id="btnAnexos" class="btn disabled btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                                </ul>
                            </div>
                            <div class="col s6 input-field">
                                <ul>
                                    <li><a id="btnBusqueda" class="btn btn-link"><i class="fas fa-search"></i><span>Búsqueda</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </nav>
        </div>

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <table id="tblConsultaRecibidos" class="bordered hoverable highlight striped" name="tblConsultaRecibidos" style="width: 100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>CUD</th>
                                    <th>Documento</th>
                                    <th>Asunto</th>
                                    <!--<th>Oficina Origen</th>-->
                                    <th>Fecha Enviado</th>
                                    <th>Oficina Origen</th>
                                    <th>Estado</th>
                                    <th>Fecha atención</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalFiltros" class="modal modal-fixed-header modal-fixed-footer">
            <div class="modal-header">
                <h4>Filtros</h4>
            </div>
            <div class="modal-content">
                <form id="frmConsultaRecibidos">
                    <div class="row">
                        <div class="col s6 input-field">
                            <input type="text" name="txtCUD" id="txtCUD">
                            <label for="txtCUD">CUD</label>
                        </div>
                        <div class="col s6 input-field">
                            <input type="text" name="txtDoc" id="txtDoc">
                            <label for="txtDoc">N° Doc.</label>
                        </div>
                        <div class="col s12 input-field">
                            <input type="text" name="txtAsunto" id="txtAsunto">
                            <label for="txtAsunto">Asunto</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <select id="idOficinaOrigen" name="idOficinaOrigen">
                            </select>
                            <label for="idOficinaOrigen" class="active">Oficina Origen</label>
                        </div>
                        <div class="col s6 input-field">
                            <select id="idTipoDoc" name="idTipoDoc">
                            </select>
                            <label for="idTipoDoc" class="active">Tipo de documento</label>
                        </div>
                        <div class="col s6 input-field">
                            <input type="text" name="txtFecIni" id="txtFecIni" class="datepicker">
                            <label for="txtFecIni">Fecha Inicio</label>
                        </div>
                        <div class="col s6 input-field">
                            <input type="text" name="txtFecFin" id="txtFecFin" class="datepicker">
                            <label for="txtFecFin">Fecha Fin</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-link btnClear"><i class="fas fa-redo left " type="button"></i><span>Limpiar</span></a>
                <a class="btn btn-link btnSearch"><i class="fas fa-search left"></i><span>Buscar</span></a>
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
    </main>


    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>
    <script>
        var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
        var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });

        $(document).ready(function (){
            $('.modal').modal();

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

            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxOficinas.php',
                method: 'POST',
                data: {esTupa: '0'},
                datatype: 'json',
                success: function (data) {

                    $('select[name="idOficinaOrigen"]').empty().append('<option value="">TODOS</option>');
                    var documentos = JSON.parse(data);
                    $.each(documentos.data, function (key,value) {

                        $('select[name="idOficinaOrigen"]').append(value);
                    });
                    $('select[name="idOficinaOrigen"]').formSelect();
                }
            });

            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxTipoDocumentoAll.php',
                method: 'POST',
                data: {tipoDoc: '0'},
                datatype: 'json',
                success: function (data) {

                    $('select[name="idTipoDoc"]').empty().append('<option value="0">TODOS</option>');
                    var documentos = JSON.parse(data);
                    $.each(documentos, function (key,value) {

                        $('select[name="idTipoDoc"]').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    $('select[name="idTipoDoc"]').formSelect();
                }
            });
        });

            var tblConsultaRecibidos = $('#tblConsultaRecibidos').DataTable({
                'processing': false,
                'serverSide': true,
                "pageLength": 10,
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: ''
                    }
                },
                ajax: {
                    url: 'ajaxtablas/ajaxConsultaRecibidos.php',
                    type: 'POST',
                    datatype: 'json',
                    data: function ( d ) {
                        return $.extend( {}, d, {
                            "txtCUD": $('#txtCUD').val()==null?"":$('#txtCUD').val(),
                            "idOficinaOrigen": $('#idOficinaOrigen').val()==null?0:$('#idOficinaOrigen').val(),
                            "txtFecIni": $('#txtFecIni').val()==null?"":$('#txtFecIni').val(),
                            "txtFecFin": $('#txtFecFin').val()==null?"":$('#txtFecFin').val(),
                            "cAsunto": $('#txtAsunto').val()==null?"":$('#txtAsunto').val(),
                            "idTipoDoc": $('#idTipoDoc').val()==null?0: $('#idTipoDoc').val(),
                            "txtDoc": $('#txtDoc').val()==null?"":$('#txtDoc').val(),
                        } );
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblConsultaRecibidos_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblConsultaRecibidos.rows().deselect();
                    });
                },
                dom: '<"header"B>tr<"footer"l<"paging-info"ip>>',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', exportOptions: { modifier: { page: 'all', search: 'none' } } },
                    { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
                ],
                "language": {
                    "url": "../dist/scripts/datatables-es_ES.json"
                },
                'columnDefs': [
                    {
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true
                        }
                    }
                ],
                'columns': [
                    {'data': 'ICODTRAMITE', 'autoWidth': true}
                    ,{'data': 'CUD', 'autoWidth': true}
                    ,{'data': 'DOCUMENTO', 'autoWidth': true}
                    ,{'data': 'ASUNTO', 'autoWidth': true}
                    //,{'data': 'OFICINA_ORIGIN', 'autoWidth': true}
                    ,{'data': 'FEC_ENVIO', 'autoWidth': true}
                    ,{'data': 'ORIGEN', 'autoWidth': true}
                    ,{'data': 'ESTADO', 'autoWidth': true}
                    ,{'data': 'FEC_ATENCION', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multiple'
                },
                "ordering": false
            });

            function DrawTable(table, id) {
                table.rows().deselect();
                table.clear().draw();
                table.ajax.reload();
                $(".filters").addClass("hide");
                let elem = document.querySelector('#'+id);
                let instance = M.Modal.getInstance(elem);
                instance.close();
            }

            function ClearForm(form, dt, id) {
                dt.rows().deselect();
                form.find("input").val("");
                form.find("select").val("");
                form.find("select").formSelect();
                DrawTable(dt, id);
            }

            $('#txtCUD').keydown(function (e) {
                if(e.which === 13){
                    e.preventDefault();
                    DrawTable(tblConsultaRecibidos, 'modalFiltros');
                }
            });

            $('#txtDoc').keydown(function (e) {
                if(e.which === 13){
                    e.preventDefault();
                    DrawTable(tblConsultaRecibidos, 'modalFiltros');
                }
            });

            $('#txtAsunto').keydown(function (e) {
                if(e.which === 13){
                    DrawTable(tblConsultaRecibidos, 'modalFiltros');
                }
            });

            $('.btnSearch').click(function(e){
                e.preventDefault();
                DrawTable(tblConsultaRecibidos, 'modalFiltros');
            });

            $('.btnClear').click(function(e){
                e.preventDefault();
                var frmConsultaEmit = $('#frmConsultaEmit');

                ClearForm(frmConsultaRecibidos, tblConsultaRecibidos, 'modalFiltros');
            });

            var btnBusqueda = $("#btnBusqueda");
            var btnFlow = $("#btnFlow");
            var btnDoc = $("#btnDoc");
            var btnAnexos = $("#btnAnexos");

            var actionButtons = [];
            var supportButtons = [btnFlow, btnDoc, btnAnexos];
            var uniqueButtons = [btnDoc, btnAnexos];

            tblConsultaRecibidos
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = tblConsultaRecibidos.rows( indexes ).data().toArray();
                    var count = tblConsultaRecibidos.rows( { selected: true } ).count();

                    switch (count) {
                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });

                            $.each( supportButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.addClass("disabled");
                            });
                            break;
                    }



                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = tblConsultaRecibidos.rows( indexes ).data().toArray();
                    var count = tblConsultaRecibidos.rows( { selected: true } ).count();

                    switch (count) {
                        case 0:
                            $.each( supportButtons, function( key, value ) {
                                value.addClass("disabled");
                            });
                            break;

                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.addClass("disabled");
                            });
                            break;
                    }
                });

            btnBusqueda.on('click', function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalFiltros');
                let instance = M.Modal.getInstance(elem);
                instance.open();
            });

            btnFlow.on('click', function(e) {
                e.preventDefault();
                var rows_selected = tblConsultaRecibidos.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
                if(values[0] <= 7367){
                    var documentophp = "flujodoc_old.php"
                } else{
                    var documentophp = "flujodoc.php"
                }
                $.ajax({
                    cache: false,
                    url: documentophp,
                    method: "POST",
                    data: {codigo : values},
                    datatype: "json",
                    success : function(response) {
                        $('#modalFlujo div.modal-content').html(response);
                    }
                });
            });

            // Doc. button
            btnDoc.on('click', function(e) {
                var elems = document.querySelector('#modalDoc');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                var rows_selected = tblConsultaRecibidos.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
                let fila = tblConsultaRecibidos.rows( { selected: true } ).data().toArray()[0];
                    $.ajax({
                        cache: false,
                        url: "ajax/obtenerDoc.php",
                        method: "POST",
                        data: {codigo: values[0]},
                        datatype: "json",
                        success: function (response) {
                            let json = $.parseJSON(response);
                            if (json.length !== 0) {
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
                var rows_selected = tblConsultaRecibidos.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                    console.log(rowId);
                });
                console.log(values[0]);
                $.ajax({
                    cache: false,
                    url: "verAnexo.php",
                    method: "POST",
                    data: {codigo: values[0], tabla: 't'},
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
    </script>

    </body>
    </html>

    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>