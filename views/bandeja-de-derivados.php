<?php
session_start();

$pageTitle = "Bandeja de derivados";
$activeItem = "bandeja-de-derivados.php";
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
                        <!--<li><a id="btnPrimary" class="btn disabled btn-primary modal-trigger" href="#modalCancelar"><i class="fas fa-check fa-fw left"></i><span>Cancelar</span></a></li>-->
                        <li><a id="btnDetail" class="btn disabled btn-link"><i class="fas fa-info fa-fw left"></i><span>Detalle</span></a></li>
                        <li><a id="btnFlow" class="btn disabled btn-link"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                        <li><a id="btnDoc" class="btn disabled btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver doc.</span></a></li>
                        <li><a id="btnAnexos" class="btn disabled btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <!--<div class="card-header">
                            <span class="card-title">Registro de entrada con tupa</span>
                        </div>-->
                        <div class="card-table">
                                            <table id="tblBandejaDerivados" class="bordered hoverable highlight striped" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>CUD</th>
                                                    <th>Documento</th>
                                                    <th>Asunto</th>
                                                    <th>Destinatario</th>
                                                    <th>Fecha de Derivación</th>
                                                    <th>Estado</th>
                                                </tr>
                                                </thead>
                                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalCancelar" class="modal">
        <div class="modal-header">
            <h4>Motivo de cancelación</h4>
        </div>
        <div class="modal-content">
            <p>Esta acción devolverá el documento a su Bandeja de Pendientes.</p>
            <form name="formCancelacion" class="row">
                <div class="col s12 input-field">
                    <textarea id="motCancelacion" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="motCancelacion">Ingrese motivo</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarCancelar" class="modal-close waves-effect btn-flat">Enviar</a>
        </div>
    </div>

    <div id="modalDetalle" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Detalle del documento</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
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

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>
    <script>
        $(document).ready(function() {
            var tblBandejaDerivados = $('#tblBandejaDerivados').DataTable({
                responsive: true,
                //scrollY:        "50vh",
                //scrollCollapse: true,
                ajax: 'ajaxtablas/ajaxBDerivados.php',
                drawCallback: function( settings ) {
                    //$(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaDerivados_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaDerivados.rows().deselect();
                    }); 
                },
                dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
                buttons: [
                    //{ extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar' },
                    //{ extend: 'csv', text: '<i class="fas fa-file-excel"></i> CSV' },
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
                        'targets': [3, 6],
                        'orderable': false
                    },
                    { 
                        "width": "20%", 
                        "targets": [2] 
                    },
                    { 
                        "width": "65px", 
                        "targets": [1] 
                    }
                ],
                'select': {
                    'style': 'multi'
                }
            });

            var btnEnviarCancelar = $("#btnEnviarCancelar");

            var btnPrimary = $("#btnPrimary");
            var btnDetail = $("#btnDetail");
            var btnFlow = $("#btnFlow");
            var btnDoc = $("#btnDoc");
            var btnAnexos = $("#btnAnexos");
            var actionButtons = [btnPrimary];
            var supportButtons = [btnDetail, btnFlow, btnDoc,btnAnexos];

            tblBandejaDerivados
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = tblBandejaDerivados.rows( indexes ).data().toArray();
                    var count = tblBandejaDerivados.rows( { selected: true } ).count();

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
                    var rowData = tblBandejaDerivados.rows( indexes ).data().toArray();
                    var count = tblBandejaDerivados.rows( { selected: true } ).count();

                    switch (count) {
                        case 0:
                            $.each( actionButtons, function( key, value ) {
                                value.addClass("disabled");
                            });
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

            // Cancel send button
            btnEnviarCancelar.on('click', function (e) {
                e.preventDefault();
                var rows_selected = tblBandejaDerivados.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
                var motCancelacion = $("#motCancelacion").val();
                $.ajax({
                    cache: false,
                    url: "derivadosData.php",
                    method: "POST",
                    data: {opcion: 1, iCodMovimiento : values, motCancelacion : motCancelacion },
                    datatype: "json",
                    success : function(response) {
                        if (response == 1) {
                            $.each(rows_selected, function (index, rowId) {
                                tblBandejaDerivados.row('.selected').remove().draw(false);
                            });
                            if (values.length > 1) {
                                M.toast({html: '¡Derivaciones canceladas!'});
                            } else {
                                M.toast({html: '¡Derivación cancelada!'});
                            }
                        } else {
                            console.log(response);
                            M.toast({html: '¡Error al cancelar derivación!'});
                        }
                    }
                });
            });

            // Detail button
            btnDetail.on('click', function(e) {
                var elems = document.querySelector('#modalDetalle');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                var rows_selected = tblBandejaDerivados.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
                $.ajax({
                    cache: false,
                    url: "registroDetalles.php",
                    method: "POST",
                    data: {iCodMovimiento : values},
                    datatype: "json",
                    success : function(response) {
                        $('#modalDetalle div.modal-content').html(response);
                        instance.open();
                    }
                });
            });

            // flow button
            btnFlow.on('click', function(e) {
                var elems = document.querySelector('#modalFlujo');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                var rows_selected = tblBandejaDerivados.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
                if(values[0] <= 18997){
                    var documentophp = "flujodoc_old.php"
                } else{
                    var documentophp = "flujodoc.php"
                }
                $.ajax({
                    cache: false,
                    url: documentophp,
                    method: "POST",
                    data: {iCodMovimiento : values},
                    datatype: "json",
                    success : function(response) {
                        $('#modalFlujo div.modal-content').html(response);
                        instance.open();
                    }
                });
            });

            // Doc. button
            btnDoc.on('click', function(e) {
                var elems = document.querySelector('#modalDoc');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                var rows_selected = tblBandejaDerivados.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
                $.ajax({
                    cache: false,
                    url: "verDoc.php",
                    method: "POST",
                    data: {iCodMovimiento: values, tabla: 't'},
                    datatype: "json",
                    success: function (response) {
                        console.log(response);
                        var json = eval('(' + response + ')');
                        $('#modalDoc div.modal-content iframe').attr('src', json['url']);
                        instance.open();
                    }
                });
            });

            btnAnexos.on('click', function(e) {
                e.preventDefault();
                var rows_selected = tblBandejaDerivados.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(rowId);
                });
                $.ajax({
                    cache: false,
                    url: "verAnexo.php",
                    method: "POST",
                    data: {iCodMovimiento: values, tabla: 't'},
                    datatype: "json",
                    success: function (response) {
                        $('#modalAnexo div.modal-content ul').html('');
                        var json = eval('(' + response + ')');
                        //  $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);

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
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>