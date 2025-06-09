<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Consulta General";
$activeItem = "consulta-general.php";
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
        <nav>
            <form action="" id="frmConsultaGen">
                <div class="nav-wrapper">
                    <div class="row" style="margin-bottom: 0; display: flex; align-items: center; justify-content: space-between;">
                        <div class="col s6 input-field">
                            <ul id="nav-mobile" class="">
                                <!-- <li><a href="javascript:;" id="btnPrimary" class="btn btn-primary"><i class="fas fa-search fa-fw left"></i><span>Buscar</span></a></li>
                                <li><a id="btnClear" class="btn btn-link" href="#"><i class="fas fa-times fa-fw left"></i><span>Limpiar</span></a></li> -->
                                <li><a id="btnFlow" class="btn btn-link modal-trigger" style="display: none" href="#modalFlujo"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                                <li><a id="btnDoc" class="btn btn-link" style="display: none"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver</span></a></li>
                                <li><a id="btnAnexos" class="btn btn-link modal-trigger" style="display: none" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                                <li><a id="btnDescargarDoc" class="btn btn-link" style="display: none" ><i class="far fa-file-archive"></i><span> Descargar</span></a></li>
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
                                            <div class="col s6 input-field">
                                                <input type="text" name="txtDoc" id="txtDoc">
                                                <label for="txtDoc">N° Doc.</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6 input-field">
                                                <input type="text" name="nomRemitente" id="nomRemitente">
                                                <label for="nomRemitente">Nombre Remitente</label>
                                            </div>
                                            <!--<div class="col s6 input-field">
                                                <select name="codRemitente" id="codRemitente" class="js-data-example-ajax browser-default"></select>
                                                <label for="codRemitente"></label>
                                            </div>-->
                                            <div class="col s6 input-field">
                                                <select id="cCodOfi" name="cCodOfi">
                                                </select>
                                                <label for="cCodOfi" class="active">Oficina</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s6 input-field">
                                                <select id="cboTramite" name="cboTramite">
                                                    <option value="1" selected>TRÁMITES</option>
                                                    <option value="2">PROYECTADOS</option>
                                                </select>
                                                <label for="cboTramite" class="active">Tipo de Trámite</label>
                                            </div>
                                            <div class="col s6 input-field">
                                                <select id="cboEstado" name="cboEstado">
                                                    <option value="">TODOS</option>
                                                    <option value="1">EN PROCESO/PENDIENTE</option>
                                                    <option value="2">DERIVADO</option>
                                                    <option value="3">DELEGADO</option>
                                                    <option value="4">RESPONDIDO</option>
                                                    <option value="5">FINALIZADO</option>
                                                    <option value="6">RECHAZADO</option>
                                                    <option value="7">CANCELADO</option>
                                                    <option value="10">DEVUELTO</option>
                                                </select>
                                                <label for="cboEstado" class="active">Estado</label>
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
                            <table id="tblConsultaGen" class="bordered hoverable highlight striped" name="tblConsultaGen" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>CUD</th>
                                        <th>Documento</th>
                                        <th>Asunto</th>
                                        <th>Remitente</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Fecha de Envío</th>
                                        <th>Estado</th>
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
         <div id="divFlujoTramite" class="modal-content"></div>
         <div class="modal-footer">
            <button type="button" class="modal-print btn-flat" onclick="print('divFlujoTramite','Flujo')">Imprimir</button>
            <button type="button" class="modal-close waves-effect waves-green btn-flat">Cerrar</button>
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
</main>


<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>
<script>
    var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
    var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
    var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
    var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

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

    /*$('#codRemitente').select2({
        placeholder: 'Nombre del remitente',
        minimumInputLength: 3,
        "language": {
            "noResults": function(){
                return "<p>No se encontró al destinatario.</p>";
            },
            "searching": function() {
                return "Buscando..";
            },
            "inputTooShort": function() {
                return "Ingrese más de 3 letras ...";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        ajax: {
            url: 'ajax/ajaxRemitentes.php',
            dataType: 'json',
            delay: 100,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });*/

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

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
        //console.log(instances);
    });

    $(document).ready(function () {
        // console.log(isIOs());
        $('.modal').modal();

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

        $.ajax({
            cache: 'false',
            url: 'ajax/ajaxOficinas.php',
            method: 'POST',
            data: {esTupa: '0'},
            datatype: 'json',
            success: function (data) {

                $('select[name="cCodOfi"]').empty().append('<option value="">TODOS</option>');
                var documentos = JSON.parse(data);
                $.each(documentos.data, function (key,value) {

                    $('select[name="cCodOfi"]').append(value);
                });
                $('select[name="cCodOfi"]').formSelect();
            }
        });

        var tblConsultaGen = $('#tblConsultaGen').DataTable({
            'processing': false,
            'serverSide': true,
            "pageLength": 50,
             responsive: {
                 details: {
                     display: $.fn.dataTable.Responsive.display.childRowImmediate,
                     type: ''
                 }
            },
            order:[[0,"desc"]],
            ajax: {
                url: 'ajaxtablas/ajaxTablaConsulta.php',
                type: 'POST',
                datatype: 'json',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "cAsunto": $('#txtAsunto').val(),
                        "nCud": $('#txtCUD').val(),
                        "tipoDoc": $('#cCodTipoDoc').val(),
                        "nroDoc": $('#txtDoc').val(),
                        "nomRemitente": $('#nomRemitente').val(),
                        //"codRemitente": $('#codRemitente').val(),
                        "iCodOficinaOrigen": $('#cCodOfi').val(),
                        "cboTramite": $('#cboTramite').val(),
                        "nEstadoMovimiento": $('#cboEstado').val(),
                        "fFecInicio": $('#txtFecIni').val(),
                        "fFecFin": $('#txtFecFin').val()
                    });
                }
            },
            drawCallback: function( settings ) {
                $(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tblConsultaGen_length"]').formSelect();

                $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                    tblConsultaGen.rows().deselect();
                }); 
            },
            //dom: 'tr<"footer"l<"paging-info"ip>>',
            dom: '<"header"B>tr<"footer"l<"paging-info"ip>>',
            buttons: [
                { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', exportOptions: { modifier: { page: 'all', search: 'none' } } },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', orientation:'landscape' },
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
                   'targets': [0,2,3,4,5,6,8],
                    'orderable': false
                }
            ],
            'columns': [
                 //{'data': 'rowId', 'autoWidth': true}
                 {'data': 'iCodMovimiento', 'autoWidth': true}
                ,{'data': 'nCud', 'autoWidth': true}
                ,{
                    'render': function (data, type, full, meta) {
                        var origen = ``;
                        if(full.ingreso.trim() != '' && full.ingreso.trim() != 'Interno'){
                            origen = `<small><b>Externo:</b> ${full.ingreso}</small><br>`;
                        }
                        return `${origen}${full.cdesctipodoc}`;
                    },
                    'autoWidth': true
                }
                // ,{'data': 'cdesctipodoc', 'autoWidth': true}
                ,{'data': 'cAsunto', 'autoWidth': true}
                ,{'data': 'remitente', 'autoWidth': true}
                ,{'data': 'origen', 'autoWidth': true}
                ,{'data': 'destino', 'autoWidth': true}
                ,{'data': 'fFecMovimiento', 'autoWidth': true}
                ,{'data': 'nomEstado', 'autoWidth': true}
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
            form.find("select#cboTramite").val("1");
            //$("#codRemitente").val(null).trigger('change');
            form.find("select").formSelect();
            DrawTable(dt);
        }

        $('#txtCUD').keyup(function (e) {
            if(e.which === 13){
                DrawTable(tblConsultaGen);
            }
        });

        $('#txtRemitente').keyup(function (e) {
            if(e.which === 13){
                DrawTable(tblConsultaGen);
            }
        });

        $('#txtAsunto').keyup(function (e) {
            if(e.which === 13){
                DrawTable(tblConsultaGen);
            }
        });

        $('#txtDoc').keyup(function (e) {
            if(e.which === 13){
                DrawTable(tblConsultaGen);
            }

        });

        $('.btnSearch').click(function(e){
            e.preventDefault(); 
            DrawTable(tblConsultaGen);
        });

        $('.btnClear').click(function(e){
            e.preventDefault(); 
            var frmConsultaGen = $('#frmConsultaGen');

            ClearForm(frmConsultaGen, tblConsultaGen);
        });

        var btnPrimary = $("#btnPrimary");
        var btnFlow = $("#btnFlow");
        var btnDoc = $("#btnDoc");
        var btnAnexos = $("#btnAnexos");
        var btnDescargarDoc = $("#btnDescargarDoc");

        var actionButtons = [btnPrimary];
        var supportButtons = [btnFlow, btnDoc, btnAnexos, btnDescargarDoc];
        var uniqueButtons = [btnDoc, btnAnexos, btnDescargarDoc];

        $("#cboTramite").change(function(){
            var selected = $(this).val();
            if(selected === "2"){
                $("#txtDoc").parent().hide();
            }else{
                $("#txtDoc").parent().show();
            }
            DrawTable(tblConsultaGen);
        });

        
        tblConsultaGen
            .on( 'select', function ( e, dt, type, indexes ) {
                var rowData = tblConsultaGen.rows( indexes ).data().toArray();
                var count = tblConsultaGen.rows( { selected: true } ).count();

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
                var rowData = tblConsultaGen.rows( indexes ).data().toArray();
                var count = tblConsultaGen.rows( { selected: true } ).count();

                switch (count) {
                    case 0:
                        // $.each( actionButtons, function( key, value ) {
                        //     value.addClass("disabled");
                        // });
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
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var values=[];
            console.log(values);
            $.each(rows_selected, function (index, rowId) {
                values.push(rowId);
            });
            if(values[0] <= 18997 ){
                var documentophp = "flujodoc_old.php"
            } else {
                var documentophp = "flujodoc.php"
            }
            $.ajax({
                cache: false,
                url: documentophp,
                method: "POST",
                data: {iCodMovimiento : values},
                datatype: "json",
                success : function(response) {
                    console.log(response);
                    $('#modalFlujo div.modal-content').html(response);
                }
            });
        });

        // Doc. button
        btnDoc.on('click', function(e) {
            var elems = document.querySelector('#modalDoc');
            var instance = M.Modal.getInstance(elems);
            e.preventDefault();
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(rowId);
            });
            let fila = tblConsultaGen.rows( { selected: true } ).data().toArray()[0];
            if(fila.flgEncriptado == 1 && !(fila.iCodOficinaFirmante == sesionOficina && (fila.iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
                        $.confirm({
                            columnClass: 'col-md-4 col-md-offset-4',
                            title: 'Validación permiso',
                            content: 'Contraseña: <input type="password">',
                            buttons: {
                                Validar: function(){
                                    var val = this.$content.find('input').val();
                                    if(val.trim() != ''){
                                        $.ajax({
                                            url: "registerDoc/Documentos.php",
                                            method: "POST",
                                            data: {'codigo': fila.codigo, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    $.ajax({
                                                        cache: false,
                                                        url: "verDoc.php",
                                                        method: "POST",
                                                        data: {iCodMovimiento: values, tabla: 't'},
                                                        datatype: "json",
                                                        success: function (response) {
                                                            var json = eval('(' + response + ')');
                                                            if (json['estado'] == 1) {
                                                                // var content = '#modalDoc div.modal-content';
                                                                $('#modalDoc div.modal-content').html('');
                                                                // getSpinnerSm('#modalDoc div.modal-content');
                                                                $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                                                                // $('#modalDoc div.modal-content iframe').attr('src',  preFrame + 'http://' + json['url']);
                                                                instance.open();
                                                            } else {
                                                                M.toast({html: '¡No contiene documento asociado!'});
                                                            }
                                                        },
                                                        error: function (e) {
                                                            M.toast({html: '¡No contiene documento asociado!'});
                                                        }
                                                    });
                                                } else {
                                                    $.alert('Contraseña incorrecta');
                                                }
                                            },
                                            error: function (e) {
                                                console.log(e);
                                                console.log('Error validar clave!');
                                                $.alert('Error');
                                            }
                                        });                                        
                                    }else{
                                        return false;
                                    }
                                },
                                Cancelar: function(){
                                    $.alert('Cancelado');
                                }
                            }                            
                        });
            } else {
                $.ajax({
                    cache: false,
                    url: "verDoc.php",
                    method: "POST",
                    data: {iCodMovimiento: values, tabla: 't'},
                    datatype: "json",
                    success: function (response) {
                        var json = eval('(' + response + ')');
                        if (json['estado'] == 1) {
                            // var content = '#modalDoc div.modal-content';
                            $('#modalDoc div.modal-content').html('');
                            // getSpinnerSm('#modalDoc div.modal-content');
                            $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');                            
                            // $('#modalDoc div.modal-content iframe').attr('src', getPreIframe() + 'http://' + json['url']);
                            instance.open();
                        } else {
                            M.toast({html: '¡No contiene documento asociado!'});
                        }
                    },
                    error: function (e) {
                        M.toast({html: '¡No contiene documento asociado!'});
                    }
                });
            }           
        });

        btnAnexos.on('click', function(e) {
            e.preventDefault();
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var Movimiento = new Array();
            $.each(rows_selected, function (index, Indice) {
                $.each(tblConsultaGen.data(), function (index, entry) {
                    if (entry.iCodMovimiento == Indice) {
                        Movimiento.push(entry);
                        return;
                    }
                });
            });
            let fila = tblConsultaGen.rows( { selected: true } ).data().toArray()[0];
            if(fila.flgEncriptado == 1 && !(fila.iCodOficinaFirmante == sesionOficina && (fila.iCodTrabajadorFirmante == sesionTrabajador || sesionDelegado == 1))){
                        $.confirm({
                            columnClass: 'col-md-4 col-md-offset-4',
                            title: 'Validación permiso',
                            content: 'Contraseña: <input type="password">',
                            buttons: {
                                Validar: function(){
                                    var val = this.$content.find('input').val();
                                    if(val.trim() != ''){
                                        $.ajax({
                                            url: "registerDoc/Documentos.php",
                                            method: "POST",
                                            data: {'codigo': fila.codigo, 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    $.ajax({
                                                        cache: false,
                                                        url: "verAnexo.php",
                                                        method: "POST",
                                                        data: {iCodMovimiento: Movimiento[0].iCodMovimiento},
                                                        datatype: "json",
                                                        success: function (response) {
                                                            $('#modalAnexo div.modal-content ul').html('');
                                                            var json = eval('(' + response + ')');

                                                            if(json.tieneAnexos == '1') {
                                                                let cont = 1;
                                                                json.anexos.forEach(function (elemento) {
                                                                    /*Inicio Renombre*/
                                                                        let elementoNombre = elemento.nombre;            
                                                                        // Verificamos si el nombre empieza con un número
                                                                        if (/^\d/.test(elementoNombre)) {
                                                                            // Si empieza con un número, eliminamos el número al inicio
                                                                            elementoNombre = elementoNombre.replace(/^\d+\.\s*/, '');
                                                                        }
                                                                    /*Fin Renombre*/
                                                                    //$('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+cont+'. '+elemento.nombre+'</a></li>');
                                                                    $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+cont+'. '+elementoNombre+'</a></li>');
                                                                    cont++;
                                                                })
                                                            }else{
                                                                $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    $.alert('Contraseña incorrecta');
                                                }
                                            },
                                            error: function (e) {
                                                console.log(e);
                                                console.log('Error validar clave!');
                                                $.alert('Error');
                                            }
                                        });                                        
                                    }else{
                                        return false;
                                    }
                                },
                                Cancelar: function(){
                                    $.alert('Cancelado');
                                }
                            }                            
                        });
            } else {
                $.ajax({
                    cache: false,
                    url: "verAnexo.php",
                    method: "POST",
                    data: {iCodMovimiento: Movimiento[0].iCodMovimiento},
                    datatype: "json",
                    success: function (response) {
                        $('#modalAnexo div.modal-content ul').html('');
                        var json = eval('(' + response + ')');

                        if(json.tieneAnexos == '1') {
                            let cont = 1;
                            json.anexos.forEach(function (elemento) {
                                /*Inicio Renombre*/
                                    let elementoNombre = elemento.nombre;            
                                    // Verificamos si el nombre empieza con un número
                                    if (/^\d/.test(elementoNombre)) {
                                    // Si empieza con un número, eliminamos el número al inicio
                                    elementoNombre = elementoNombre.replace(/^\d+\.\s*/, '');
                                    }
                               /*Fin Renombre*/
                                //$('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+cont+'. '+elemento.nombre+'</a></li>');
                                $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+cont+'. '+elementoNombre+'</a></li>');
                                cont++;
                            })
                        }else{
                            $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                        }
                    }
                });
            }             
        });




        /*inicio descargarDoc*/
        btnDescargarDoc.on('click', function(){
                    var promesa = new Promise((resolve, reject) => {
                        initProgress();
                        // $("#progressBar p").text('');
                        // $("#progressBar div.progress div.progressbar").css("width","0%");
                        // $("#progressBar").css("display", "block");
                        resolve(true);
                    });

                    promesa.then((respuesta) => {
                        return new Promise((resolve,reject) =>{
                            var data = new Object();

                            data.nombreZip = 'archivo'+Date.now();
                            data.fila = tblConsultaGen.rows( { selected: true } ).data().toArray()[0];
                            data.codigo = data.fila.codigo;

                            

                           /*
                           data.codigo = 0;
                            if (data.fila.tipo == 'T'){
                                data.codigo = data.fila.codigo;
                            } else {
                                data.codigo = data.fila.subCodigo;
                            }*/
                            updateProgress(`Generando Zip`,`0%`);

                            console.log('DATA');
                            console.log(data);

                            return resolve(data);
                        });

                       


                    }).then((respuesta) => {
                        $.ajax({
                            async: false,
                            url: 'ajax/ajaxConsultaGeneralZip.php',
                            type: 'POST',
                            datatype: 'json',
                            data: {
                                "evento" : "AgregarAZip",
                                "codigo" : respuesta.codigo,
                                "nombre" : respuesta.fila.origen.trim()+' '+ respuesta.fila.cdesctipodoc.trim()+' '+ respuesta.fila.nCud.trim(),
                                "nombreZip" : respuesta.nombreZip
                            }
                            
                        }).done(function(response){
                            var result = JSON.parse(response);
                            if (result.success){
                                updateProgress(`Generando Zip 100%`,`100%`);
                                location.href = `../archivosTemp/${respuesta.nombreZip}.zip`;
                                $.ajax({
                                    async: false,
                                    url: 'ajax/ajaxConsultaGeneralZip.php',
                                    type: 'POST',
                                    data: {"evento" : "EliminarZip","nombreZip" : respuesta.nombreZip}                                       
                                })
                                .done(() => finishProgress());
                            } else {
                                finishProgress();
                                M.toast({html: result.message});
                            }                                
                        });

                        
                    });         
                });
        /*fin descargarDoc*/

    });


    /*descargarDoc*/
    function initProgress(){                
                $("#progressBar p").text('');
                $("#progressBar div.progress div.progressbar").css("width","0%");
                
                if ($("#progressBar").css("display") == "none"){
                    $("#progressBar").css("display", "block");
                }
            };

            function updateProgress(text, porcentaje){
                $("#progressBar p").text(text);
                $("#progressBar div.progress div.progressbar").css("width",porcentaje);
                // getSpinner();
            }

            function finishProgress(){                
                $("#progressBar p").text('');
                $("#progressBar div.progress div.progressbar").css("width","0%");
                
                if ($("#progressBar").css("display") == "block"){
                    $("#progressBar").css("display", "none");
                }
            };
        /*fin descargarDoc*/
</script>

</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>