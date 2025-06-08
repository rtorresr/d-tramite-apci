<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Reporte Despacho Archivo Gestión";
$activeItem = "ReporteDespachoArchivoGestion.php";
$navExtended = true;

$nNumAno    = date("Y");
if($_SESSION['CODIGO_TRABAJADOR']!=""){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <style>
            @media print
            {
                #pager,
                form,
                .no-print
                {
                    display: none !important;
                    height: 0;
                }
                .no-print, .no-print *{
                    display: none !important;
                    height: 0;
                }
                div.collapsible-body { display: block; }
            }
        </style>
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <!--Main layout-->
    <main>
        <div class="navbar-fixed actionButtons searchForm">
            <nav style="width: calc(100% - 300px);">
                <form action="" id="frmConsultaGen">
                    <div class="nav-wrapper">
                        <div class="row" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
                            <div class="col s6 input-field">
                                <ul id="nav-mobile" class="">
                                    <li><a id="btnFlow" style="display: none" class="btn btn-link"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                                    <li><a id="btnDoc" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>
                                    <li><a id="btnAnexos" style="display: none" class="btn btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                                    <li><a id="btnCargo" style="display: none" class="btn btn-link" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Cargo</span></a></li>
                                </ul>
                            </div>
                            <div class="col s6 input-field" style="position:relative; line-height: 30px; color: initial">
                                <input type="text" name="txtAsunto" id="txtAsunto" style="border: 1px solid #cccccc; background-color: #eeeeee;">
                                <label for="txtAsunto">Asunto</label>
                                <div class="input-field-buttons" style="position:absolute; right:0.75rem">
                                    <button class="btn btn-link btnSearch" style="height: 50px; line-height: 50px; box-shadow: none">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-link btnClear" style="height: 50px; line-height: 50px; box-shadow: none">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="filters hide">
                                    <legend style="padding-left: 15px">
                                        FILTROS
                                    </legend>
                                    <fieldset>
                                        <div class="row">
                                            <div class="col s3 input-field">
                                                <input type="text" name="txtCUD" id="txtCUD">
                                                <label for="txtCUD">CUD</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6 input-field">
                                                <select id="cCodTipoDoc" name="cCodTipoDoc">
                                                </select>
                                                <label for="cCodTipoDoc" class="active">Tipo de documento</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6 input-field">
                                                <select id="TipoEnvio" name="TipoEnvio">
                                                </select>
                                                <label for="TipoEnvio" class="active">Tipo de envío</label>
                                            </div>
                                            <div class="col s6 input-field">
                                                <select id="EstadoDespacho" name="EstadoDespacho">
                                                </select>
                                                <label for="EstadoDespacho" class="active">Estado del despacho</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6 input-field">
                                                <input type="text" name="txtFecIni" id="txtFecIni" class="datepicker">
                                                <label for="txtFecIni">Fecha Inicio</label>
                                            </div>
                                            <div class="col s6 input-field">
                                                <input type="text" name="txtFecFin" id="txtFecFin" class="datepicker">
                                                <label for="txtFecFin">Fecha Fin</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6 offset-s6 right-align">
                                                <button class="btn btn-link btnClear"><i class="fas fa-redo left " type="button"></i><span>Limpiar</span></button>
                                                <button id="" class="btn btn-secondary btnSearch" type="button"><i class="fas fa-search left"></i><span>Buscar</span></button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
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
                            <table id="tblConsultaDespachoArchivoGestion" class="bordered hoverable highlight striped" name="tblConsultaDespachoArchivoGestion" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>CUD</th>
                                        <th>Documento</th>
                                        <th>Asunto</th>
                                        <th>Tipo de Envío</th>
                                        <th>Observación</th>
                                        <th>Estado</th>
                                        <th>Fecha registro</th>
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

        <div id="modalCargo" class="modal modal-fixed-footer modal-fixed-header">
            <div class="modal-header">
                <h4>Cargo</h4>
            </div>
            <div class="modal-content" style="text-align: center; overflow: hidden;">
                <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
            </div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>
    </main>


    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>
    <script>
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

        function print(html, title) {
            var printWindow = window.open('', '', 'height=700,width=950');
            printWindow.document.write('<html><head><title>' + title + '</title>');
            printWindow.document.write(document.head.innerHTML);
            printWindow.document.write('</head><body >');
            printWindow.document.write(document.getElementById(html).innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function () {
                printWindow.print();
                setTimeout(function () {
                    printWindow.close();
                }, 100);
                printWindow.onmouseover = (function () {
                    printWindow.close();
                });
            }, 500);
            return true;
        }

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
                    destino.append('<option value="0">Todos</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        $(document).ready(function (){
            $('.modal').modal();
            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxTipoDocumentoAll.php',
                method: 'POST',
                data: {tipoDoc: '0'},
                datatype: 'json',
                success: function (data) {

                    $('select[name="cCodTipoDoc"]').empty().append('<option value="0">TODOS</option>');
                    var documentos = JSON.parse(data);
                    $.each(documentos, function (key,value) {

                        $('select[name="cCodTipoDoc"]').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    $('select[name="cCodTipoDoc"]').formSelect();
                }
            });
            ContenidosTipo('TipoEnvio',12);
            ContenidosTipo('EstadoDespacho', 14);

            var tblConsultaDespachoArchivoGestion = $('#tblConsultaDespachoArchivoGestion').DataTable({
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
                    url: 'ajaxtablas/ajaxBdReporteDespacho.php',
                    type: 'POST',
                    datatype: 'json',
                    data: function ( d ) {
                        return $.extend( {}, d, {
                            "cAsunto": $("#txtAsunto").val(),
                            "txtCUD": $("#txtCUD").val(),
                            "cCodTipoDoc": $("#cCodTipoDoc").val(),
                            "TipoEnvio": $("#TipoEnvio").val(),
                            "EstadoDespacho": $("#EstadoDespacho").val(),
                            "txtFecIni": $("#txtFecIni").val(),
                            "txtFecFin": $("#txtFecFin").val(),
                        });
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblConsultaDespachoArchivoGestion_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblConsultaDespachoArchivoGestion.rows().deselect();
                    });
                },
                //dom: 'tr<"footer"l<"paging-info"ip>>',
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
                    },
                    {
                        'targets': [0,1,2,3,4,5,6,7],
                        'orderable': false
                    }
                ],
                'columns': [
                    {'data': 'IdTramite', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {
                            let iconos = '';
                            if (full.nDocAdjuntos !== 0) {
                                iconos += '<i class="fas fa-fw fa-paperclip"style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }else{
                                iconos += '<i class="fas fa-fw fa-paperclip" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }
                            return iconos
                        },
                    }
                    ,{'data': 'Cud', 'autoWidth': true}
                    ,{'data': 'Documento', 'autoWidth': true}
                    ,{'data': 'Asunto', 'autoWidth': true}
                    ,{'data': 'TipoEnvio', 'autoWidth': true}
                    ,{'data': 'Observacion', 'autoWidth': true}
                    ,{'data': 'EstadoDespacho', 'autoWidth': true}
                    ,{'data': 'FecRegistro', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            $("#txtAsunto").click(function(){
                $(".filters").removeClass("hide");
            });

            function DrawTable(table) {
                table.rows().deselect();
                table.clear().draw();
                table.ajax.reload();
                $(".filters").addClass("hide");
            }

            function ClearForm(form, dt) {
                dt.rows().deselect();
                form.find("input").val("");
                form.find("select").val("");
                form.find("select").formSelect();
                DrawTable(dt);
            }

            $('#txtCUD').keyup(function (e) {
                if(e.which === 13){
                    DrawTable(tblConsultaDespachoArchivoGestion);
                }
            });

            $('#txtAsunto').keyup(function (e) {
                if(e.which === 13){
                    DrawTable(tblConsultaDespachoArchivoGestion);
                }
            });

            $('.btnSearch').click(function(e){
                e.preventDefault();
                DrawTable(tblConsultaDespachoArchivoGestion);
            });

            $('.btnClear').click(function(e){
                e.preventDefault();
                var frmConsultaGen = $('#frmConsultaGen');
                ClearForm(frmConsultaGen, tblConsultaDespachoArchivoGestion);
            });

            var btnFlow = $("#btnFlow");
            var btnDoc = $("#btnDoc");
            var btnAnexos = $("#btnAnexos");

            var actionButtons = [];
            var supportButtons = [btnFlow, btnDoc, btnAnexos];

            tblConsultaDespachoArchivoGestion
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = tblConsultaDespachoArchivoGestion.rows( indexes ).data().toArray();
                    var count = tblConsultaDespachoArchivoGestion.rows( { selected: true } ).count();

                    switch (count) {
                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            break;
                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = tblConsultaDespachoArchivoGestion.rows( indexes ).data().toArray();
                    var count = tblConsultaDespachoArchivoGestion.rows( { selected: true } ).count();

                    switch (count) {
                        case 0:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;

                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            btnFlow.on('click', function(e) {
                e.preventDefault();
                var rows_selected = tblConsultaDespachoArchivoGestion.column(0).checkboxes.selected();
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
                        let elems = document.querySelector('#modalFlujo');
                        let instance = M.Modal.getInstance(elems);
                        instance.open();
                    }
                });
            });

            btnDoc.on('click', function(e) {
                var elems = document.querySelector('#modalDoc');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                var rows_selected = tblConsultaDespachoArchivoGestion.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
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
                var rows_selected = tblConsultaDespachoArchivoGestion.column(0).checkboxes.selected();
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
        });
    </script>
    </body>
    </html>

    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>