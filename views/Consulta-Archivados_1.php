<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Consulta Archivados";
$activeItem = "consulta-archivados.php";
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
                                <li><a id="btnPrimary" style="display: none" class="btn btn-primary"><i class="fas fa-undo-alt left"></i><span>Desarchivar</span></a></li>
                                <!--<li><a id="btnClear" class="btn btn-link" href="#"><i class="fas fa-times fa-fw left"></i><span>Limpiar</span></a></li> -->
                                <li><a id="btnFlow" style="display: none" class="btn btn-link modal-trigger" href="#modalFlujo"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                                <li><a id="btnDoc" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver</span></a></li>
                                <li><a id="btnAnexos" style="display: none" class="btn btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                                <li><a id="btnCargo" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Cargo</span></a></li>
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
                                            <div class="col s3 input-field">
                                                <select id="cCodTipoDoc" name="cCodTipoDoc">
                                                </select>
                                                <label for="cCodTipoDoc" class="active">Tipo de documento</label>
                                            </div>
                                            <div class="col s3 input-field">
                                                <input type="text" name="txtDoc" id="txtDoc">
                                                <label for="txtDoc">N° Doc.</label>
                                            </div>
                                            <div class="col s3 input-field">
                                                <input type="text" name="txtRemitente" id="txtRemitente">
                                                <label for="txtRemitente">Remitente</label>
                                            </div>
                                            <div class="col s3 input-field">
                                                <select id="cCodOfi" name="cCodOfi">
                                                </select>
                                                <label for="cCodOfi" class="active">Oficina Finaliza</label>
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
                                        <!--<th>Oficina de Origen</th>-->
                                        <!--<th>Trabajador Origen</th>-->
                                        <th>Fecha de Recepcion</th>
                                        <th>Oficina Finaliza</th>
                                        <th>Trabajador Finaliza</th>
                                        <th>Fecha de finalización</th>
                                        <th>Motivo Archivamiento</th>
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
    var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
    var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
    var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
    var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

    var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
    function print(html, title) {
        //var panel = html;
        //debugger;
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
    // function print(divName) {
    //     try {
    //         var printContents = document.getElementById(divName).innerHTML;
    //         var originalContents = document.body.innerHTML;
    //         document.body.innerHTML = printContents;
    //         window.print();
    //         //document.body.innerHTML = originalContents;   
    //     } catch (error) {
            
    //     }        
    // }

    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
        //console.log(instances);
    });

    $(document).ready(function (){
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
            "pageLength": 10,
             responsive: {
                 details: {
                     display: $.fn.dataTable.Responsive.display.childRowImmediate,
                     type: ''
                 }
            },
            //scrollY: "100%",
            //scrollCollapse: true,
            ajax: {
                url: 'ajaxtablas/ajaxConsultaArchivados.php',
                type: 'POST',
                datatype: 'json',
                data: function ( d ) {
                    //console.log(d);

                  return $.extend( {}, d, {
                    "tipoDoc": $('#cCodTipoDoc').val(),
                    "cud": $('#txtCUD').val(),
                    "cAsunto": $('#txtAsunto').val(),
                    // "nEstadoMovimiento": $('#cboEstado').val(),
                    "iCodOficinaOrigen": $('#cCodOfi').val(),
                    "nroDoc": $('#txtDoc').val(),
                    // "cboTramite": $('#cboTramite').val(),
                    "remitente": $('#txtRemitente').val()                
                  } );
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
                'targets': [0,1,2,3,4,5,6,7,8,9],
                'orderable': false
            }
            ],
            'columns': [
                {'data': 'rowId', 'autoWidth': true}
                //,{'data': 'iCodMovimiento', 'autoWidth': true}
                ,{'data': 'nCud', 'autoWidth': true}                
                ,{'data': 'cdesctipodoc', 'autoWidth': true}
                ,{'data': 'cAsunto', 'autoWidth': true}
                ,{'data': 'remitente', 'autoWidth': true}
                //,{'data': 'cOficinaOrigen', 'autoWidth': true}
                //,{'data': 'cTrabajadorRegistro', 'autoWidth': true}
                ,{'data': 'fFecRecepcion', 'autoWidth': true}
                ,{'data': 'cOficinaDestino', 'autoWidth': true}
                ,{'data': 'cTrabajadorDerivar', 'autoWidth': true}
                ,{'data': 'fFecDerivar', 'autoWidth': true}
                ,{'data': 'cObservacionesFinalizar', 'autoWidth': true}
            ],
            'select': {
                'style': 'multi'
            }
        });

        $("#txtAsunto").click(function(){
            $(".filters").removeClass("hide");
            //console.log("Clicked!");
        });

        function DrawTable(table) {
            table.rows().deselect();
            table.clear().draw();
            table.ajax.reload();
            $(".filters").addClass("hide");
        }

        function ClearForm(form, dt) {
            debugger;
            dt.rows().deselect();
            form.find("input").val("");
            //form.find(".active").removeClass("active");
            form.find("select").val("");
            form.find("select#cboTramite").val("1");
            form.find("select").formSelect();
            DrawTable(dt);
        }

        // $('#cCodTipoDoc').change(function () {
        //     DrawTable(tblConsultaGen);
        // });

        // $('#cboEstado').change(function () {
        //     DrawTable(tblConsultaGen);
        // });

        // $('#cCodOfi').change(function () {
        //     DrawTable(tblConsultaGen);
        // });

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

        


        // $("body").bind("DOMNodeInserted", function() {
        //     $(this).find(".dt-checkboxes-select-all").addClass("input-disabled");
        // });

        var btnPrimary = $("#btnPrimary");
        var btnFlow = $("#btnFlow");
        var btnDoc = $("#btnDoc");
        var btnAnexos = $("#btnAnexos");
        var btnCargo = $("#btnCargo");

        var actionButtons = [];
        var supportButtons = [btnPrimary, btnFlow, btnDoc, btnAnexos, btnCargo];
        var uniqueButtons = [btnDoc, btnAnexos];

        // $.each( uniqueButtons, function( key, value ) {
        //     value.css("display", "none");
        // });

        // $("#cCodOfi").change(function(){
        //     var selected = $("#cCodOfi").val();

        //     if(selected != ""){
        //         $.each( uniqueButtons, function( key, value ) {
        //             value.css("display", "inline-block");
        //         });
        //     }else{
        //         $.each( uniqueButtons, function( key, value ) {
        //             value.css("display", "none");
        //         });
        //     }
        // });

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
                        let fila = tblConsultaGen.rows( { selected: true } ).data().toArray()[0];
                        if (fila.iCodTrabajadorDerivar !== sesionTrabajador) {
                            btnPrimary.css("display","none");
                            console.log('no corresponde desarchivar')
                        }
                        if (fila.flgTieneCargo == 0) {
                            btnCargo.css("display","none");
                        }
                        $('.actionButtons').show();
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
                        $('.actionButtons').hide(100);
                        break;

                    case 1:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        let fila = tblConsultaGen.rows( { selected: true } ).data().toArray()[0];
                        if (fila.iCodTrabajadorDerivar !== sesionTrabajador) {
                            btnPrimary.css("display","none");
                            console.log('no corresponde desarchivar')
                        }
                        if (fila.flgTieneCargo == 0) {
                            btnCargo.css("display","none");
                        }

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

        btnPrimary.on('click', function(e) {
            e.preventDefault();
            let rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            let values = [];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblConsultaGen.rows(rowId).data()[0]);
            });
            var fila = values[0];
            $.ajax({
                url: "ajax/ajaxDesarchivar.php",
                method: "POST",
                data: {iCodMovimiento : fila.iCodMovimiento},
                success: function () {
                    tblConsultaGen.ajax.reload();
                    M.toast({html: '¡Documento desarchivado!'});
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al desarchivar el documento!');
                    M.toast({html: "Error al desarchivar el documento!"});
                }
            });
        });

        btnFlow.on('click', function(e) {
            e.preventDefault();
            //debugger;
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblConsultaGen.rows(rowId).data()[0]);
            });
            var fila = values[0];
            if(fila.iCodMovimiento <= 18997 ){
                var documentophp = "flujodoc_old.php"
            } else {
                var documentophp = "flujodoc.php"
            }
            var movimiento = [fila.iCodMovimiento];
            $.ajax({
                cache: false,
                url: documentophp,
                method: "POST",
                data: {iCodMovimiento : movimiento},
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
                values.push(tblConsultaGen.rows(rowId).data()[0]);
            });
            var fila = values[0];
            var movimiento = [fila.iCodMovimiento];
            let filados = tblConsultaGen.rows( { selected: true } ).data().toArray()[0];
            console.log(filados);
            if (validarPermisoDoc(filados.iCodOficinaFirmante, filados.iCodTrabajadorFirmante)) {
                $.ajax({
                    cache: false,
                    url: "verDoc.php",
                    method: "POST",
                    data: {iCodMovimiento: movimiento, tabla: 't'},
                    datatype: "json",
                    success: function (response) {
                        var json = eval('(' + response + ')');
                        if (json['estado'] == 1) {
                            $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);
                            instance.open();
                        } else {
                            M.toast({html: '¡No contiene documento asociado!'});
                        }
                    }
                });
            } else {
                M.toast({html: '¡No tiene permiso!'});
            }
        });

        btnAnexos.on('click', function(e) {
            e.preventDefault();
            //tblConsultaGen.column(0).checkboxes.selected();
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var values = [];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblConsultaGen.rows(rowId).data()[0]);
            });
            var fila = values[0];
            $.ajax({
                cache: false,
                url: "verAnexo.php",
                method: "POST",
                data: {iCodMovimiento: fila.iCodMovimiento},
                datatype: "json",
                success: function (response) {

                    $('#modalAnexo div.modal-content ul').html('');
                    var json = eval('(' + response + ')');
                    //  $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);

                    if(json.tieneAnexos == '1') {
                        let cont = 1;
                        json.anexos.forEach(function (elemento) {
                            $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="http://'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                            cont++;
                        })
                    }else{
                        $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                    }
                }
            });
        });

        btnCargo.on('click', function (e) {
            e.preventDefault();
            let rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            let values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblConsultaGen.rows(rowId).data()[0]);
            });
            let movimientos = [];
            $.each(values, function (index, fila) {
                movimientos.push(fila.iCodMovimiento);
            });
            $.ajax({
                cache: false,
                url: "ajax/ajaxVerCargo.php",
                method: "POST",
                data: {iCodMovimiento: movimientos},
                datatype: "json",
                success: function (response) {
                    let json = $.parseJSON(response);
                    if (json['estado'] === 1) {
                        $('#modalCargo div.modal-content iframe').attr('src', 'http://' + json['url']);
                        let elem = document.querySelector('#modalCargo');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.open();
                    }else {
                        M.toast({html: '¡No contiene cargo asociado!'});
                    }
                }
            });
        });

    });

    function validarPermisoDoc($oficina, $trabajador) {
        debugger;
        var permiso = false;
        if (sesionPerfil == 3 || sesionPerfil == 18 || sesionPerfil == 19 || sesionPerfil == 20 || sesionDelegado == 1) {
            if (sesionOficina == $oficina){
                permiso = true;
            }
        } else {
            if (sesionOficina == $oficina && sesionTrabajador == $trabajador){
                permiso = true;
            }
        }
        console.log(permiso);
        //return permiso;
        return true;
    }
</script>

</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>