<?php
session_start();

$pageTitle = "Bandeja de Documentos por Aprobar";
$activeItem = "bandeja-por-aprobar.php";
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
                        <li><button id="btnPrimary" class="btn disabled btn-primary"><i class="fas fa-check-double fa-fw left"></i><span>Revisar</span></button></li>
                        <!--<li><a id="btnEliminarP" class="btn disabled btn-link" href="#" ><i class="fas fa-check fa-trash-alt left"></i><span>Eliminar Proyecto</span></a></li>-->
                        <li><a id="btnDoc" class="btn disabled btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>
                        <li><a id="btnAnexos" class="btn disabled btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Anexos.</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <form name="frm-example" id="frm-example">
                                <table class="bordered hoverable highlight striped" id="tblBandejaPorAprobar" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>CUD</th>
                                            <th>Documento</th>
                                            <th>Asunto</th>
                                            <th>Entidad</th>
                                            <th>Remitente</th>
                                            <th>Fecha de Envío</th>
                                            <th>Estado</th>
                                            <th>Instrucción específica</th>
                                        </tr>
                                    </thead>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <form id="frmRespuesta" method="GET" action="registroOficina.php">
        <input type="hidden" id="dtr" name="dtr">
        <!-- <input type="hidden" id="movProyecto" name="movProyecto">
        <input type="hidden" id="agrupado" name="agrupado"> -->
    </form>

    <div id="modalDoc" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <div class="row">
                <div class="col s6">
                    <h4>Documento</h4>  
                </div>
                <div class="col s6" style="text-align: right">
                    Documento 
                    <span id="textActual"></span> de 
                    <span id="textTotal"></span>
                    <a class="btn btn-link" id="btnAnterior"><i class="fas fa-chevron-left"></i></a>
                    <a class="btn btn-link" id="btnSiguiente"><i class="fas fa-chevron-right"></i></a> 
                </div>
            </div>
        </div>
        <div class="modal-content p-0" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">            
            <a class="modal-close waves-effect btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modelAnexos" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Anexos</h4>
        </div>
        <div class="modal-content p-0" style="text-align: center; overflow: hidden;">
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>

    <script>
        $(document).ready(function() {
            $('.modal').modal();

            var tblBandejaPorAprobar = $('#tblBandejaPorAprobar').DataTable({
                responsive: true,
                //scrollY:        "50vh",
                //scrollCollapse: true,
                ajax: 'ajaxtablas/ajaxBpAprobar.php',
                drawCallback: function( settings ) {
                    //$(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaPorAprobar_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaPorAprobar.rows().deselect();
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
                        'targets': [3, 7],
                        'orderable': false
                    },
                    { 
                        "width": "20%", 
                        "targets": [2] 
                    },
                    { 
                        "width": "65px", 
                        "targets": [1, 6] 
                    }
                ],
                'columns': [
                     {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'nCud', 'autoWidth': true}
                    ,{'data': 'Proyecto', 'autoWidth': true}
                    ,{'data': 'cAsunto', 'autoWidth': true}
                    ,{'data': 'entidad', 'autoWidth': true}
                    ,{'data': 'Remitente', 'autoWidth': true}
                    ,{'data': 'fFecMovimiento', 'autoWidth': true}
                    ,{'data': 'estado', 'autoWidth': true}
                    ,{'data': 'cObservacionesDerivar', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            var btnPrimary = $("#btnPrimary");
            //var btnEliminarP = $("#btnEliminarP");
            var btnDoc = $("#btnDoc");
            var btnAnexos = $("#btnAnexos");

            var actionButtons = [btnPrimary, btnDoc, btnAnexos];

            tblBandejaPorAprobar
                .on( 'select', function ( e, dt, type, indexes ) {
                    //var rowData = tblBandejaPorAprobar.rows( indexes ).data().toArray();
                    var count = tblBandejaPorAprobar.rows( { selected: true } ).count();

                    switch (count) {
                        case 1:
                            let fila = tblBandejaPorAprobar.rows( { selected: true } ).data().toArray()[0];
                            $.each( actionButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });                            
                            // if(fila.tipo == 'tramite'){
                            //     btnDoc.addClass("disabled");
                            // }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.addClass("disabled");
                            });
                            break;
                    }
                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    //var rowData = tblBandejaPorAprobar.rows( indexes ).data().toArray();
                    var count = tblBandejaPorAprobar.rows( { selected: true } ).count();

                    switch (count) {
                        case 0:
                            $.each( actionButtons, function( key, value ) {
                                value.addClass("disabled");
                            });
                            break;

                        case 1:
                            let fila = tblBandejaPorAprobar.rows( { selected: true } ).data().toArray()[0];
                            $.each( actionButtons, function( key, value ) {
                                value.removeClass("disabled");
                            });
                            // if(fila.tipo == 'tramite'){
                            //     btnDoc.addClass("disabled");
                            // }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.addClass("disabled");
                            });
                            break;
                    }
                });

            // Check button
            btnPrimary.on('click', function(e) {
                e.preventDefault();
                var rows_selected = tblBandejaPorAprobar.column(0).checkboxes.selected();
                var values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaPorAprobar.rows(rowId).data()[0]);
                });
                var value=[];
                value.push(values[0].iCodMovimiento);
                let datos = [];
                $.each(values, function (index, rowId) {

                    let fila = [];
                    fila.push(rowId.iCodMovimiento);
                    fila.push(rowId.Proyecto);
                    fila.push(rowId.nCud);
                    datos.push(fila);
                });

                $.ajax({
                    url: "registerDoc/Documentos.php",
                    method: "POST",
                    data: {
                        Evento: 'RevisarDocumento',
                        movimiento: value,
                        tipo: 'proyecto'
                    },
                    datatype: "json",
                    success: function (response) {
                        let respuesta = $.parseJSON(response);

                        let data = new Object();
                        data.movimientoP = values[0].iCodMovimiento;
                        data.cudP = values[0].nCud;
                        data.agrupado = respuesta.cAgrupado;
                        data.flgPendientes = 1;
                        data.documentos = datos;

                        $("#dtr").val(window.btoa(JSON.stringify(data)));
                        // $("#movProyecto").val(values);
                        // $("#agrupado").val(respuesta.cAgrupado);
                        document.getElementById("frmRespuesta").submit();
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al intentar revisar el documento!');
                        deleteSpinner();
                        M.toast({html: "Error al intentar revisar el documento"});
                    }
                });
            });

            /*btnEliminarP.on('click', function(e) {
                $.confirm({
                    title: '¿ Esta seguro de eliminar el proyecto ?',
                    content: 'Si elimina el proyecto ya no lo podra recuperar.',
                    boxWidth: '30%',
                    useBootstrap: false,
                    draggable: false,
                    buttons: {
                        confirm:{
                            text: 'Eliminar',
                            btnClass: 'btn-secondary danger',
                            action: function(){
                                e.preventDefault();
                                var rows_selected = tblBandejaPorAprobar.column(0).checkboxes.selected();
                                var values=[];
                                $.each(rows_selected, function (index, rowId) {
                                    values.push(rowId);
                                });
                                $.ajax({
                                    cache: false,
                                    url: "ajax/eliminarProyecto.php",
                                    method: "POST",
                                    data: {iCodMovimiento: values},
                                    datatype: "json",
                                    success: function (response) {
                                        console.log(response);
                                        var json = eval('(' + response + ')');
                                        if(json.esProyecto == '1') {
                                            tblBandejaPorAprobar.row('.selected').remove().draw(false);
                                            M.toast({html: 'El proyecto se eliminó correctamente'});
                                        }else{
                                            M.toast({html: 'No se puede eliminar. No es un proyecto.'});
                                        }
                                    }
                                });

                            }
                        },
                        cancelar: function () {
                        },
                    }
                });
            });*/

            btnDoc.on('click', function(e) {
                e.preventDefault();
                seleccionados = [];
                docActual = 0;
                totalSeleccionado = 0;

                var rows_selected = tblBandejaPorAprobar.column(0).checkboxes.selected();
                var values=[];
                var value=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaPorAprobar.rows(rowId).data()[0]);
                });

                var promise = new Promise((resolve, reject) => { 
                    var vTipo = values[0].tipo;
                    var vCodigo = values[0].codigo;
                    var vTipoDoc = values[0].tipoDoc;
                    var vProyectoInicio = values[0].IdProyecto;

                    if(vTipoDoc == 1 || vTipoDoc == 2){
                        seleccionados.push({tipo: vTipo, codigo: vCodigo, tipoDoc: vTipoDoc, destino: 0, notificacion: 0});
                        totalSeleccionado++;
                        resolve();
                    } else {
                        $.ajax({
                            async:false,
                            cache: false,
                            method: "POST",
                            data: {proyecto: vProyectoInicio, tramite: 0, Evento: 'ObtenerDatosDocumentosDestinatarios'},
                            url: "registerDoc/Documentos.php",
                            datatype: 'json',
                            success: function (x) {
                                respuesta = $.parseJSON(x);

                                var promise2 = new Promise((resolve2, reject2) => {
                                    $.each(respuesta, function(i,e){
                                        totalSeleccionado++;
                                        seleccionados.push({tipo: vTipo, codigo: vCodigo, tipoDoc: vTipoDoc, destino: e.iCodRemitente, notificacion: 0}); 
                                        if(e.idTipoEnvio == 98){
                                            totalSeleccionado++;
                                            seleccionados.push({tipo: vTipo, codigo: vCodigo, tipoDoc: vTipoDoc, destino: e.iCodRemitente, notificacion: (e.idTramiteNotificacion == null ? 1 : e.idTramiteNotificacion)}); 
                                        }                                        
                                    });
                                    resolve2();
                                });

                                promise2.then(() => {
                                    resolve();
                                });
                            }
                        });
                    }
                });

                promise.then(() => {
                    mostrarDocumento(false,false);
                    let instance = M.Modal.getInstance($("#modalDoc"));
                    instance.open();
                });  

                // var value=[];
                // value.push(values[0].iCodMovimiento);
                // if (values[0].tipo!="proyecto") {
                //     $.ajax({
                //         cache: false,
                //         url: "verDoc.php",
                //         method: "POST",
                //         data: {iCodMovimiento: value, tabla: 't'},
                //         datatype: "json",
                //         success: function (response) {
                //             var json = eval('(' + response + ')');
                //             if (json['estado'] == 1) {
                //                 $('#modalPrevisualizacion div.modal-content').html('');
                //                 $('#modalPrevisualizacion div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                //                 // $('#modalPrevisualizacion div.modal-content iframe').attr('src', 'http://' + json['url']);
                //                 let instance = M.Modal.getInstance($("#modalPrevisualizacion"));
                //                 instance.open();
                //             }else {
                //                 M.toast({html: '¡No contiene documento asociado!'});
                //             }
                //         }
                //     });
                // }else{
                //     $.ajax({
                //         url: 'registerDoc/Documentos.php',
                //         method : 'POST',
                //         datatype: 'json',
                //         data: {
                //             Evento : "ObtenerDatosDocumentos",
                //             movimiento: values[0].iCodMovimiento,
                //             codigo : '',
                //             tipo : values[0].tipo,
                //             agrupado : '',
                //         },
                //         success: function (response) {
                //             console.log(typeof (response));
                //             let datos = $.parseJSON(response);
                //             $.ajax({
                //                 url: "previsualizacion-pdf.php",
                //                 method: "POST",
                //                 dataType : "text",

                //                 data: datos,
                //                 success: function (respuesta) {
                //                     let datos = respuesta;
                //                     let ifr = $("#modalPrevisualizacion iframe");
                //                     ifr.attr('src','data:application/pdf;base64,' + datos);
                //                     let instance = M.Modal.getInstance($("#modalPrevisualizacion"));
                //                     instance.open();
                //                 },
                //                 error: function (e) {
                //                     console.log(e);
                //                     console.log('Error al obtener el documento!');
                //                     M.toast({html: "Error al obtener el documento!"});
                //                 }
                //             });
                //         }
                //     });
                // }
            });

            function mostrarDocumento(anterior,siguiente){
                $("#btnAnterior").removeAttr("disabled");
                $("#btnSiguiente").removeAttr("disabled");

                if(anterior){
                    docActual--;
                }

                if(siguiente){
                    docActual++;
                }

                if(docActual == 0){
                    $("#btnAnterior").attr('disabled', 'disabled');
                }

                if(docActual + 1 == seleccionados.length){
                    $("#btnSiguiente").attr('disabled', 'disabled');
                }

                $("#textActual").text(docActual + 1);
                $("#textTotal").text(seleccionados.length);
                
                let seleccionado = seleccionados[docActual];
                
                if(seleccionado.tipo == 'proyecto'){
                    listadoPrevisualizacion = [];               
                    
                    $.ajax({
                        url: 'registerDoc/Documentos.php',
                        method : 'POST',
                        datatype: 'json',
                        data: {
                            Evento : "ObtenerDatosDocumentos",
                            codigo : seleccionado.codigo,
                            tipo : seleccionado.tipo,
                            agrupado : ''
                        },
                        success: function (response) {
                            let datos = $.parseJSON(response);
                            datos.destinatario = seleccionado.destino;
                            datos.id = seleccionado.codigo;

                            let ruta = 'previsualizacion-pdf.php';
                            if(seleccionado.notificacion > 0){
                                ruta = 'previsualizacion-notificacion-pdf.php';
                            }

                            $.ajax({
                                url: ruta,
                                method: "POST",
                                dataType : "text",
                                data: datos,
                                success: function (respuesta) {
                                    let datos = respuesta;
                                    let ifr = $("#modalDoc iframe");
                                    ifr.attr('src','data:application/pdf;base64,' + datos);
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al obtener el documento!');
                                    M.toast({html: "Error al obtener el documento!"});
                                }
                            });
                        }
                    });
                }

                if(seleccionado.tipo == 'tramite'){
                    var datatramite = {};
                    datatramite.codigo = seleccionado.codigo;
                    datatramite.destino = seleccionado.destino;

                    if(seleccionado.notificacion > 0){
                        datatramite.codigo = seleccionado.notificacion;
                        datatramite.destino = 0;
                    }

                    $.ajax({
                        url: "ajax/obtenerDoc.php",
                        method: "POST",
                        data: datatramite,
                        datatype: "json",
                        success: function (response) {
                            let json = $.parseJSON(response);
                            if (json.length !== 0){
                                console.log('¡Documento obtenido!');
                                $('#modalDoc div.modal-content').html('');
                                $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                                $('#modalDoc').modal('open');
                            } else {
                                console.log('¡No se pudo obtener el documento!');
                                M.toast({html:'¡No se pudo obtener el documento!'});
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al obtener el documento!');
                            M.toast({html: "Error al obtener el documento"});
                        } 
                    });
                }
            }

            $("#btnAnterior").on("click", function(e){
                mostrarDocumento(true,false);
            });

            $("#btnSiguiente").on("click", function(e){
                mostrarDocumento(false,true);
            });


            btnAnexos.on('click', function(e) {
                e.preventDefault();
                var rows_selected = tblBandejaPorAprobar.column(0).checkboxes.selected();
                var values=[];
                var value=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaPorAprobar.rows(rowId).data()[0]);
                });
                var value=[];
                value.push(values[0].iCodMovimiento);
                $.ajax({
                    url: 'registerDoc/Documentos.php',
                    method : 'POST',
                    datatype: 'json',
                    data: {
                        Evento : "ObtenerDatosDocumentos",
                        movimiento: values[0].iCodMovimiento,
                        codigo : '',
                        tipo : values[0].tipo,
                        agrupado : '',
                    },
                    success: function (response) {
                        $("#modelAnexos div.modal-content").html('');
                        let data = $.parseJSON(response);
                        var htmlanexos = '';
                        htmlanexos = listarAnexos(data.cAnexos);
                        if (htmlanexos == ''){
                            M.toast({html: "No tiene anexos"});
                        } else {
                            $("#modelAnexos div.modal-content").html(htmlanexos);
                            let instance = M.Modal.getInstance($("#modelAnexos"));
                            instance.open();
                        }                 
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al obtener los datos!');
                        M.toast({html: "Error al obtener los datos"});
                    }
                }); 
            });
        });
        
        function listarAnexos(anexos){
            var html = '';
            if (anexos != '' && anexos != null){
                let data = $.parseJSON(anexos);
                html += `<ul>`;
                $.each(data, function (key,value) {
                    html +=  `<li>`;
                    var atag = '';
                    $.ajax({
                        cache: false,
                        method: "POST",
                        data: value,
                        url: "ajax/ajaxListarAnexos.php",
                        datatype: 'json',
                        async: false,
                        success: function (respuesta) {
                            let value = JSON.parse(respuesta);
                            if (value.cNombreOriginal.trim() == '') {
                                let nom = value.cNombreNuevo.split('/');
                                var nombre = nom[nom.length-1];
                            } else {
                                var nombre = value.cNombreOriginal;
                            };
                            html += '<a href="'+value.cNombreNuevo+'">'+nombre+'</a>';
                        }
                    });
                    html +=  `</li>`;
                });
                html += `</ul>`;
            }
            return html;
            
        }

    </script>
    </body>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>