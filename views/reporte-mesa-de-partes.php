<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Reporte de documentos ingresados a la APCI";
$activeItem = "reporte-mesa-de-partes.php";
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
            <nav>
                <form>
                    <div class="nav-wrapper">
                        <div class="row" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
                            <div class="col s6 input-field">
                                <ul id="nav-mobile" class="">
                                    <li><a id="btnFlow" class="btn disabled btn-link modal-trigger" href="#modalFlujo"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                                    <li><a id="btnDoc" class="btn disabled btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver</span></a></li>
                                    <li><a id="btnAnexos" class="btn disabled btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                                    <li><a id="btnCargo" class="btn disabled btn-link"><i class="far fa-file fa-fw left"></i><span>Cargo</span></a></li>
                                </ul>
                            </div>
                            <div class="col s6 input-field">
                                <ul>
                                    <li style="float: right"><a id="btnBusqueda" class="btn btn-link"><i class="fas fa-search"></i><span>Búsqueda</span></a></li>
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
                            <table id="tblReporteMP" class="bordered hoverable highlight striped" name="tblConsulta" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tipo de Ingreso</th>
                                        <th>Entidad</th>
                                        <th>Expediente</th>
                                        <th>Documento</th>
                                        <th>Asunto</th>
                                        <th>Tipo de Trámite</th>
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
                <form id="frmConsultaEmit">
                    <div class="row">
                        <div class="col s6 input-field">
                            <select id="tipoIngreso" name="tipoIngreso">
                            </select>
                            <label for="tipoIngreso" class="active">Tipo de Ingreso</label>
                        </div>
                        <div class="col s6 input-field">
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
                        <div class="col s6 input-field">
                            <input type="text" name="txtDoc" id="txtDoc">
                            <label for="txtDoc">N° Doc.</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 input-field">
                            <input type="text" name="txtAsunto" id="txtAsunto">
                            <label for="txtAsunto">Asunto</label>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col s4 input-field">
                            <select id="tipoRemitente" name="tipoRemitente">
                            </select>
                            <label for="tipoRemitente" class="active">Tipo de Entidad</label>
                        </div>
                        <div class="col s8 input-field">
                            <input type="text" name="txtEntidad" id="txtEntidad">
                            <label for="txtEntidad">Nombre de la Entidad</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 input-field">
                            <select id="tipoTramite" name="tipoTramite">
                                <option value="">Seleccione</option>
                                <option value="5">Procedimientos y Trámites administrativos</option>
                                <option value="4">Otros trámites</option>    
                            </select>
                            <label for="tipoTramite" class="active">Tipo de Trámite</label>
                        </div>
                        <div class="col s6 input-field">
                            <select id="tipoTupa" name="tipoTupa">
                                <option value="">Seleccione</option>
                            </select>
                            <label for="tipoTupa" class="active">Trámite</label>
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
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-link btnClear"><i class="fas fa-redo left " type="button"></i><span>Limpiar</span></a>
                <a class="btn btn-link" id="btnSearch"><i class="fas fa-search left"></i><span>Buscar</span></a>
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
            <div class="modal-content p-0" style="text-align: center; overflow: hidden;">
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
                <h4>Documento</h4>
            </div>
            <div class="modal-content p-0" style="text-align: center; overflow: hidden;">
                <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
            </div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>

        <div id="modalHojaRuta" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
            <div class="modal-header">
                <h4>Cargo</h4>
            </div>
            <div id="divHojaIngreso" class="modal-content"></div>
            <div class="modal-footer">
                <button type="button" class="modal-print btn-flat" onclick="print('divHojaIngreso','Cargo')">Imprimir</button>
                <a class="waves-effect waves-green btn-flat modal-close" >Cerrar</a>
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

            ContenidosTipo("tipoIngreso", 37);

            ContenidosTipo("tipoRemitente", 30);

            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxTipoDocumentoAll.php',
                method: 'POST',
                data: {tipoDoc: '0'},
                datatype: 'json',
                success: function (data) {

                    $('select[name="cCodTipoDoc"]').empty().append('<option value="">TODOS</option>');
                    var documentos = JSON.parse(data);
                    $.each(documentos, function (key,value) {

                        $('select[name="cCodTipoDoc"]').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    $('select[name="cCodTipoDoc"]').formSelect();
                }
            });

            $('#tipoTramite').on('change', CargarTUPAs);
        });

        function ContenidosTipo(idDestino, codigoTipo, defaultSelect = 0, arrayQuitar = []) {
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
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

         function CargarTUPAs(){
            $("#tipoTupa").val("");
            getSpinner();
            $('#tipoTupa').empty().append('<option value="">Seleccione</option>');
            $('#tipoTupa').formSelect();
            let valor = $('#tipoTramite').val();

            if(valor != ''){
                $.ajax({
                    async: false,
                    cache: false,
                    url: "ajax/ajaxTupasMPV.php",
                    method: "POST",
                    data: {iCodTupaClase: valor},
                    datatype: "json",
                    success: function (response) {                    
                        $.each(JSON.parse(response), function( index, value ) {
                            $('#tipoTupa').append(value);
                        });
                        $('#tipoTupa').formSelect();
                    }
                });   
            }     
            deleteSpinner();
        }  

        tblReporteMP = $('#tblReporteMP').DataTable({
            'processing': false,
            'serverSide': true,
            'pageLength': 10,
            'ajax': {
                url: 'ajax/ajaxReporteMP.php',
                type: 'POST',
                datatype: 'json',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "Accion": "ListarReporte",
                        "IdTipoIngreso": $("#tipoIngreso").val(),
                        "Cud": $("#txtCUD").val(),
                        "IdTipoDocumento": $("#cCodTipoDoc").val(),
                        "NroDocumento": $("#txtDoc").val(),
                        "Asunto": $("#txtAsunto").val(),
                        "IdTipoEntidad": $("#tipoRemitente").val(),
                        "Entidad": $("#txtEntidad").val(),
                        "IdTipoTramiteClase": $("#tipoTramite").val(),
                        "IdTupa": $("#tipoTupa").val(),
                        "FecIni": $("#txtFecIni").val(),
                        "FecFin": $("#txtFecFin").val()
                    });
                }
            },
            drawCallback: function( settings ) {
                $(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tblReporteMP_length"]').formSelect();

                $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                    tblReporteMP.rows().deselect();
                }); 
            },
            dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
            buttons: [
                { 
                    extend: 'excelHtml5', 
                    text: '<i class="fas fa-file-excel"></i> Excel', 
                    action: function ( e, dt, node, config ) {
                        var datos = {
                            "Accion": "DescargarListadoReporte",
                            "IdTipoIngreso": $("#tipoIngreso").val(),
                            "Cud": $("#txtCUD").val(),
                            "IdTipoDocumento": $("#cCodTipoDoc").val(),
                            "NroDocumento": $("#txtDoc").val(),
                            "Asunto": $("#txtAsunto").val(),
                            "IdTipoEntidad": $("#tipoRemitente").val(),
                            "Entidad": $("#txtEntidad").val(),
                            "IdTipoTramiteClase": $("#tipoTramite").val(),
                            "IdTupa": $("#tipoTupa").val(),
                            "FecIni": $("#txtFecIni").val(),
                            "FecFin": $("#txtFecFin").val(),
                            "start": 0,
                            "length": dt.page.info().recordsTotal
                        }

                        openWindowWithPost("ajax/ajaxReporteMP.php", datos);
                    }
                },
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
                {'data': 'IdTramite', 'width': '3%'}
                ,{'data': 'TipoRegistro', 'width': '10%'}
                ,{
                    'render': function (data, type, full, meta) {
                        var html = `<b>${full.TipoEntidad}</b><br/>
                            ${full.Entidad}`                        
                        return html;
                    }, 'width': '15%'
                }
                ,{
                    'render': function (data, type, full, meta) {
                        var html = '';
                        if (full.Cud != null && full.Cud != ''){     
                            html = `<b>CUD: </b>${full.Cud}<br/>
                                <i>${full.FechaRegistro}</i>`;
                        }
                        return html;
                    }, 'width': '10%'
                }
                
                ,{
                    'render': function (data, type, full, meta) {       
                        var html = `<b>${full.TipoDocumento}</b><br/>
                            ${full.NroDocumento}<br/>
                            <i>${full.FechaDocumento}</i>`;
                        return html;
                    }, 'width': '10%'
                }
                ,{'data': 'Asunto', 'width': '35%'}
                ,{
                    'render': function (data, type, full, meta) {
                        var html = `<b>${full.TupaClase}</b><br/>${full.Tupa == null ? '' : full.Tupa}`;
                        return html;
                    }, 'width': '17%'
                }
            ],
            'select': {
                'style': 'multi'
            }
        });

        function DrawTable(table, id) {
            table.rows().deselect();
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
            form.find("select#cboTramite").val("1");
            form.find("select").formSelect();
            DrawTable(dt, id);
        }

        $('#frmConsultaEmit input').keydown(function (e) {
            if(e.which === 13){
                e.preventDefault();
                DrawTable(tblReporteMP, 'modalFiltros');
            }
        });

        $('#btnSearch').click(function(e){
            e.preventDefault();
            DrawTable(tblReporteMP, 'modalFiltros');
        });

        $('.btnClear').click(function(e){
            e.preventDefault();
            var frmConsultaEmit = $('#frmConsultaEmit');

            ClearForm(frmConsultaEmit, tblReporteMP, 'modalFiltros');
        });

        var btnBusqueda = $("#btnBusqueda");
        var btnFlow = $("#btnFlow");
        var btnDoc = $("#btnDoc");
        var btnAnexos = $("#btnAnexos");
        var btnCargo = $("#btnCargo");        

        var actionButtons = [];
        var supportButtons = [btnFlow, btnDoc, btnAnexos, btnCargo];
        var uniqueButtons = [btnDoc, btnAnexos];

        tblReporteMP
            .on( 'select', function ( e, dt, type, indexes ) {
                var rowData = tblReporteMP.rows( indexes ).data().toArray();
                var count = tblReporteMP.rows( { selected: true } ).count();

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
                var rowData = tblReporteMP.rows( indexes ).data().toArray();
                var count = tblReporteMP.rows( { selected: true } ).count();

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
            var rows_selected = tblReporteMP.column(0).checkboxes.selected();
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

        btnDoc.on('click', function(e) {
            var elems = document.querySelector('#modalDoc');
            var instance = M.Modal.getInstance(elems);
            e.preventDefault();
            var rows_selected = tblReporteMP.column(0).checkboxes.selected();
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
                        $('#modalDoc div.modal-content').html('');
                        $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                        instance.open();
                    }else {
                        M.toast({html: '¡No contiene documento asociado!'});
                    }
                }
            });
        });

        btnCargo.on('click', function(e) {            
            e.preventDefault();

            let fila = tblReporteMP.rows( { selected: true } ).data().toArray()[0];
            if(fila.IdTipoRegistro != 106){
                $.ajax({
                    url: "registerDoc/regMesaPartes.php",
                    method: "POST",
                    data: {
                        codTramite: fila.IdTramite,
                        Evento: "consultarHojaRuta"

                    },
                    datatype: "json",
                    success: function (respuesta) {
                        console.log('Obtenido correctamente!');
                        deleteSpinner();
                        let elems = document.querySelector('#modalHojaRuta');
                        let instance = M.Modal.init(elems, {dismissible:false});
                        $('#modalHojaRuta div.modal-content').html(respuesta);
                        instance.open();
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al obtener el documento!');
                        M.toast({html: "Error al obtener el documento"});
                    }
                });
            } else {
                $.ajax({
                    cache: false,
                    url: "ajax/obtenerCargoInteroperabilidad.php",
                    method: "POST",
                    data: {codigo: fila.IdTramite},
                    datatype: "json",
                    success: function (response) {
                        let json = $.parseJSON(response);
                        if (json.length !== 0) {
                            $('#modalCargo div.modal-content').html('');
                            $('#modalCargo div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                            
                            var elems = document.querySelector('#modalCargo');
                            var instance = M.Modal.getInstance(elems);
                            instance.open();
                        }else {
                            M.toast({html: '¡No contiene documento asociado!'});
                        }
                    }
                });
            }
        });        

        btnAnexos.on('click', function(e) {
            e.preventDefault();
            var rows_selected = tblReporteMP.column(0).checkboxes.selected();
            var values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(rowId);
                console.log(rowId);
            });
            
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
                            /*Inicio Renombre*/
                                let elementoNombre = elemento.nombre;            
                                if (/^\d/.test(elementoNombre)) {
                                    elementoNombre = elementoNombre.replace(/^\d+\.\s*/, '');
                                }
                            /*Fin Renombre*/
                            //$('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+cont+'. ' + elemento.nombre+'</a></li>');
                            $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+cont+'. ' + elementoNombre+'</a></li>');
                            cont++;
                        })
                    }else{
                        $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                    }
                }
            });
        });

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

    </body>
    </html>

    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>