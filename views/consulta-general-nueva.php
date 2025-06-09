<?php 
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Consulta General Integrada";
$activeItem = "consulta-general-nueva.php";
$navExtended = true;
$hasSearch = true;
$nNumAno    = date("Y");

if( $_SESSION['CODIGO_TRABAJADOR'] != "" ) {
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
                                <a style="display: none" id="btnFlow" class="btn btn-link modal-trigger tooltipped" data-position="top" data-tooltip="Flujo" href="#modalFlujo">
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                        <path d="M 3 6 C 1.355469 6 0 7.355469 0 9 L 0 15 C 0 16.644531 1.355469 18 3 18 L 11 18 C 12.644531 18 14 16.644531 14 15 L 14 13 L 20 13 L 20 15 C 20 16.644531 21.355469 18 23 18 L 31 18 C 32.644531 18 34 16.644531 34 15 L 34 13 L 39 13 C 40.65625 13 42 14.34375 42 16 L 42 19 L 39 19 C 37.355469 19 36 20.355469 36 22 L 36 28 C 36 29.644531 37.355469 31 39 31 L 42 31 L 42 34 C 42 35.65625 40.65625 37 39 37 L 34 37 L 34 35 C 34 33.355469 32.644531 32 31 32 L 23 32 C 21.355469 32 20 33.355469 20 35 L 20 37 L 14 37 L 14 35 C 14 33.355469 12.644531 32 11 32 L 3 32 C 1.355469 32 0 33.355469 0 35 L 0 41 C 0 42.644531 1.355469 44 3 44 L 11 44 C 12.644531 44 14 42.644531 14 41 L 14 39 L 20 39 L 20 41 C 20 42.644531 21.355469 44 23 44 L 31 44 C 32.644531 44 34 42.644531 34 41 L 34 39 L 39 39 C 41.746094 39 44 36.746094 44 34 L 44 31 L 47 31 C 48.644531 31 50 29.644531 50 28 L 50 22 C 50 20.355469 48.644531 19 47 19 L 44 19 L 44 16 C 44 13.253906 41.746094 11 39 11 L 34 11 L 34 9 C 34 7.355469 32.644531 6 31 6 L 23 6 C 21.355469 6 20 7.355469 20 9 L 20 11 L 14 11 L 14 9 C 14 7.355469 12.644531 6 11 6 Z M 3 8 L 11 8 C 11.554688 8 12 8.445313 12 9 L 12 15 C 12 15.554688 11.554688 16 11 16 L 3 16 C 2.445313 16 2 15.554688 2 15 L 2 9 C 2 8.445313 2.445313 8 3 8 Z M 23 8 L 31 8 C 31.554688 8 32 8.445313 32 9 L 32 15 C 32 15.554688 31.554688 16 31 16 L 23 16 C 22.445313 16 22 15.554688 22 15 L 22 9 C 22 8.445313 22.445313 8 23 8 Z M 39 21 L 47 21 C 47.554688 21 48 21.445313 48 22 L 48 28 C 48 28.554688 47.554688 29 47 29 L 39 29 C 38.445313 29 38 28.554688 38 28 L 38 22 C 38 21.445313 38.445313 21 39 21 Z M 3 34 L 11 34 C 11.554688 34 12 34.445313 12 35 L 12 41 C 12 41.554688 11.554688 42 11 42 L 3 42 C 2.445313 42 2 41.554688 2 41 L 2 35 C 2 34.445313 2.445313 34 3 34 Z M 23 34 L 31 34 C 31.554688 34 32 34.445313 32 35 L 32 41 C 32 41.554688 31.554688 42 31 42 L 23 42 C 22.445313 42 22 41.554688 22 41 L 22 35 C 22 34.445313 22.445313 34 23 34 Z"></path>
                                    </svg>
                                    <!-- <span>Flujo</span> -->
                                </a>
                            </li>
                            <li>
                                <a style="display: none" id="btnDoc" class="btn btn-link modal-trigger tooltipped" data-position="top" data-tooltip="Documento" href="#modalDoc">
                                    <!-- <i class="fas fa-file-pdf fa-fw left"></i>
                                    <span>Ver Doc.</span> -->
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                        <path d="M 7 2 L 7 48 L 43 48 L 43 15.410156 L 29.183594 2 Z M 9 4 L 28 4 L 28 17 L 41 17 L 41 46 L 9 46 Z M 30 5.578125 L 39.707031 15 L 30 15 Z M 23.769531 19.875 C 23.019531 19.875 22.242188 20.300781 21.902344 20.933594 C 21.558594 21.5625 21.535156 22.238281 21.621094 22.941406 C 21.753906 24.050781 22.257813 25.304688 22.910156 26.589844 C 22.585938 27.683594 22.429688 28.636719 21.941406 29.804688 C 21.320313 31.292969 20.558594 32.472656 19.828125 33.710938 C 18.875 34.15625 17.671875 34.554688 16.96875 35.015625 C 16.179688 35.535156 15.554688 36 15.1875 36.738281 C 15.007813 37.105469 14.914063 37.628906 15.09375 38.101563 C 15.273438 38.574219 15.648438 38.882813 16.035156 39.082031 C 16.855469 39.515625 17.800781 39.246094 18.484375 38.785156 C 19.167969 38.324219 19.777344 37.648438 20.390625 36.824219 C 20.699219 36.40625 20.945313 35.730469 21.25 35.242188 C 22.230469 34.808594 22.925781 34.359375 24.039063 33.976563 C 25.542969 33.457031 26.882813 33.238281 28.289063 32.933594 C 29.464844 33.726563 30.714844 34.34375 32.082031 34.34375 C 32.855469 34.34375 33.453125 34.308594 34.035156 33.992188 C 34.621094 33.675781 34.972656 32.914063 34.972656 32.332031 C 34.972656 31.859375 34.765625 31.355469 34.4375 31.03125 C 34.105469 30.707031 33.714844 30.535156 33.3125 30.425781 C 32.515625 30.210938 31.609375 30.226563 30.566406 30.332031 C 30.015625 30.390625 29.277344 30.683594 28.664063 30.796875 C 28.582031 30.734375 28.503906 30.707031 28.421875 30.636719 C 27.175781 29.5625 26.007813 28.078125 25.140625 26.601563 C 25.089844 26.511719 25.097656 26.449219 25.046875 26.359375 C 25.257813 25.570313 25.671875 24.652344 25.765625 23.960938 C 25.894531 23.003906 25.921875 22.167969 25.691406 21.402344 C 25.574219 21.019531 25.378906 20.632813 25.039063 20.335938 C 24.699219 20.039063 24.21875 19.875 23.769531 19.875 Z M 23.6875 21.867188 C 23.699219 21.867188 23.71875 21.875 23.734375 21.878906 C 23.738281 21.886719 23.746094 21.882813 23.777344 21.980469 C 23.832031 22.164063 23.800781 22.683594 23.78125 23.144531 C 23.757813 23.027344 23.621094 22.808594 23.609375 22.703125 C 23.550781 22.238281 23.625 21.941406 23.65625 21.890625 C 23.664063 21.871094 23.675781 21.867188 23.6875 21.867188 Z M 24.292969 28.882813 C 24.910156 29.769531 25.59375 30.597656 26.359375 31.359375 C 25.335938 31.632813 24.417969 31.730469 23.386719 32.085938 C 23.167969 32.160156 23.042969 32.265625 22.828125 32.34375 C 23.132813 31.707031 23.511719 31.234375 23.785156 30.578125 C 24.035156 29.980469 24.078125 29.476563 24.292969 28.882813 Z"></path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a style="display: none" id="btnAnexos" class="btn btn-link modal-trigger tooltipped" data-position="top" data-tooltip="Anexos" href="#modalAnexo">
                                    <svg class="svg-inline--fa fa-w-16 fa-fw" fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                        <path d="M 39 6 C 37.210938 6 35.421875 6.671875 34.0625 8.03125 L 14.21875 27.90625 C 14.148438 27.960938 14.085938 28.023438 14.03125 28.09375 C 14.007813 28.113281 13.988281 28.132813 13.96875 28.15625 C 13.921875 28.195313 13.882813 28.234375 13.84375 28.28125 C 13.84375 28.292969 13.84375 28.300781 13.84375 28.3125 C 12.105469 30.265625 12.160156 33.285156 14.03125 35.15625 C 15.972656 37.097656 19.152344 37.097656 21.09375 35.15625 L 36.1875 20.03125 C 36.484375 19.746094 36.574219 19.304688 36.414063 18.925781 C 36.257813 18.546875 35.878906 18.304688 35.46875 18.3125 C 35.207031 18.324219 34.960938 18.433594 34.78125 18.625 L 19.6875 33.71875 C 18.511719 34.894531 16.613281 34.894531 15.4375 33.71875 C 14.300781 32.582031 14.28125 30.804688 15.34375 29.625 C 15.378906 29.585938 15.410156 29.542969 15.4375 29.5 C 15.460938 29.480469 15.480469 29.460938 15.5 29.4375 L 15.59375 29.375 C 15.59375 29.363281 15.59375 29.355469 15.59375 29.34375 L 35.5 9.46875 C 37.453125 7.515625 40.574219 7.511719 42.53125 9.46875 C 44.484375 11.421875 44.484375 14.546875 42.53125 16.5 L 17.90625 41.125 C 15.171875 43.859375 10.765625 43.859375 8.03125 41.125 C 5.296875 38.390625 5.296875 33.984375 8.03125 31.25 L 27.71875 11.5625 C 28.015625 11.320313 28.152344 10.933594 28.066406 10.558594 C 27.980469 10.1875 27.6875 9.894531 27.316406 9.808594 C 26.941406 9.722656 26.554688 9.859375 26.3125 10.15625 L 6.625 29.84375 C 3.128906 33.339844 3.125 39.066406 6.625 42.5625 C 10.125 46.058594 15.816406 46.058594 19.3125 42.5625 L 43.96875 17.9375 C 46.6875 15.21875 46.6875 10.75 43.96875 8.03125 C 42.609375 6.671875 40.789063 6 39 6 Z"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a style="display: none" id="btnDescargarDoc" class="btn btn-link tooltipped" data-position="top" data-tooltip="Descargar documento">
                                    <i class="far fa-file-archive"></i>
                                </a>
                            </li>
                            <?php
                            if ($_SESSION['iCodPerfilLogin'] == '3' || $_SESSION['iCodPerfilLogin'] == '20' || $_SESSION['iCodPerfilLogin'] == '19'){
                                ?>
                                <li>
                                    <a style="display: none" id="btnDescargarZip" class="btn btn-link tooltipped" data-position="top" data-tooltip="Descargar Zip">
                                        <i class="far fa-file-archive"></i>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                            <li>
                                <a style="" id="btnDescargarExcel" class="btn btn-link tooltipped" data-position="top" data-tooltip="Descargar Excel">
                                    <i class="far fa-file-excel"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="card" id="progressBar" style="display: none; position: fixed; z-index: 100000;width: 100%">
                <div class="card-content">
                    <p style="text-align: center; font-weight: bold;"></p>
                    <div class="progress">
                        <div class="progressbar secondary indeterminate" style="width: 0%"></div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <table id="tablaDatos" class="bordered hoverable highlight striped" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>CUD</th>
                                <th>Documento</th>
                                <th>Asunto</th>
                                <th>Fecha Documento</th>
                            </tr>
                        </thead>
                    </table>
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
        <script type="text/javascript" src="../conexion/global.js"></script>
        <script>
            $(document).ready(function(){
                //var preFrame = setFrame();

                M.updateTextFields();

                //var btnPrimary = $("#btnPrimary");
                var btnFlow = $("#btnFlow");
                var btnDoc = $("#btnDoc");
                var btnAnexos = $("#btnAnexos");
                var btnDescargarDoc = $("#btnDescargarDoc");
                var btnDescargarZip = $("#btnDescargarZip");                

                //var actionButtons = [btnPrimary];
                var supportButtons = [btnFlow, btnDoc, btnAnexos, btnDescargarDoc];
                var uniqueButtons = [btnDoc, btnAnexos];

                var dtTablaDatos = $('#tablaDatos').DataTable( {
                    processing: false,
                    serverSide: true,
                    pageLength: 50,
                    ajax: {
                        url: 'ajaxtablas/ajaxTablaConsultaNueva.php',
                        type: 'POST',
                        datatype: 'json',
                        data: function ( d ) {
                            return $.extend( {}, d, {
                                "Evento" : "DataTableData",
                                "tipoOrigen": $("#searchForm").find("[name=tipoOrigenCG]").val(),
                                "tipoTramite": $("#searchForm").find("[name=tipoTramiteCG]").val(),
                                "estadoTramite": $("#searchForm").find("[name=estadoTramiteCG]").val(),
                                "numExpediente": $("#searchForm").find("[name=txtCUDCG]").val(),
                                "tipoDocumento": $("#searchForm").find("[name=tipoDocumentoCG]").val(),
                                "numDocumento": $("#searchForm").find("[name=txtNumDocCG]").val(),
                                "asunto": $("#searchForm").find("[name=txtAsuntoCG]").val(),
                                "entidadOrigen": $("#searchForm").find("[name=remitenteInterno]").val(),
                                "oficinaOrigen": $("#searchForm").find("[name=oficinaOrigenCG]").val(),
                                "trabajadorOrigen": $("#searchForm").find("[name=trabajadorOrigenCG]").val(),
                                "entidadDestino": $("#searchForm").find("[name=destinoExterno]").val(),
                                "oficinaDestino": $("#searchForm").find("[name=oficinaDestinoCG]").val(),
                                "trabajadorDestino": $("#searchForm").find("[name=trabajadorDestinoCG]").val(),
                                "tipoFecha": $("#searchForm").find("[name=rdFecha]:checked").val(),
                                "fechaInicio": $("#searchForm").find("[name=txtFecIniCG]").val(),
                                "fechaFin": $("#searchForm").find("[name=txtFecFinCG]").val(),
                                "anioDocumento": $("#searchForm").find("[name=anioCG]").val(),
                                "rangoFecha": ($("#searchForm").find("[name=flgRango]").prop("checked") ? $("#searchForm").find("[name=flgRango]:checked").val() : '0'),
                                "flgExterno": $("#searchForm").find("input[name=rdDestino]:checked").val(),
                            });
                        }
                    },
                    drawCallback: function( settings ) {
                        if ($("#searchForm").find("[name=tipoTramiteCG]").val() == 1){
                            $("#btnDescargarZip").css("display","inline-block");
                        } else {
                            $("#btnDescargarZip").css("display","none");
                        }
                        

                        //$(".dataTables_scrollBody").attr("data-simplebar", "");
                        $('select[name="tablaDatos_length"]').formSelect();

                        $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                            dtTablaDatos.rows().deselect();
                        });
                    },
                    dom: '<"header">tr<"footer"l<"paging-info"ip>>',
                    language: {
                        "url": "../dist/scripts/datatables-es_ES.json"
                    },
                    columnDefs: [ {
                        orderable: false,
                        className: 'select-checkbox',
                        targets:   0
                    } ],
                    columns:[
                        {'data': 'row_id'}
                        ,{
                            'className': 'details-control',
                            'render': function (data, type, row, meta) {
                                return `<i class="fas fa-chevron-down"></i>`    
                            }
                        }
                        ,{'data': 'cud'}
                        ,{
                            'render': function (data, type, row, meta) {
                                var hue = 'lighten-2';

                                switch (row.origen_doc) {
                                    case 'Interno':
                                        var color = 'teal'
                                        break;
                                
                                    default:
                                        var color = 'indigo';
                                        break;
                                }

                                var origen = `${row.origen_doc}`;
                                if(row.origen_doc == 'Externo'){
                                    origen = `<small><b>Externo:</b> ${row.origen}</small><br>`;
                                }

                                return `<div>
                                            <div class="antd-badge" style="margin-bottom: 3px">
                                                <span class="antd-badge-status-dot ${ color } ${ hue }"></span>
                                                <span class="antd-badge-status-text">${origen}</span>
                                            </div>
                                            <p>${row.tipo_doc} ${row.nro_documento}</p>
                                        </div>`    
                            }
                        }
                        ,{'data': 'asunto'}
                        ,{'data': 'fecha_doc'}
                    ],
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                    order: [[ 1, 'asc' ]]
                } );

                dtTablaDatos
                .on( 'select', function ( e, dt, type, indexes ) {
                    var rowData = dtTablaDatos.rows( indexes ).data().toArray();
                    var count = dtTablaDatos.rows( { selected: true } ).count();
                    //console.log('rowData',  rowData);
                    
                    switch (count) {
                        case 1:
                            /*
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });*/

                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            
                            if (rowData[0].tipo == 'P'){
                                if (rowData[0].subTipo != 'T'){
                                    btnDoc.css("display","none");
                                    btnAnexos.css("display","none");
                                    btnDescargarDoc.css("display","none");
                                }                                
                            }
                            break;

                        default:
                            /*$.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });*/
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                    
                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = dtTablaDatos.rows( indexes ).data().toArray();
                    var count = dtTablaDatos.rows( { selected: true } ).count();
                    
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
                            /*$.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });*/
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            if (rowData[0].tipo == 'P'){
                                if (rowData[0].subTipo != 'T'){
                                    btnDoc.css("display","none");
                                    btnAnexos.css("display","none");
                                    btnDescargarDoc.css("display","none");
                                }                                
                            }
                            break;

                        default:
                            /*$.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });*/
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                    
                });

                $('#tablaDatos tbody').on('click', 'td.details-control', function (e) {
                    e.stopImmediatePropagation();
                    var tr = $(this).closest('tr');
                    var row = dtTablaDatos.row(tr);
                    if (row.child.isShown()) {
                        $('div.information', row.child()).slideUp(function () {
                            row.child.hide();
                            tr.removeClass('shown');
                        });
                    }
                    else {
                        $.ajax({
                            cache: 'false',
                            url: 'ajaxtablas/ajaxTablaConsultaNueva.php',
                            method: 'POST',
                            data: {
                                Evento: 'DataTableDetalle', 
                                codigo: row.data().codigo,
                                tipoTramite : row.data().tipo
                            },                                
                            datatype: 'json',
                            success: function (data) {
                               var datos = JSON.parse(data);
                               row.child(informacionAdicional(datos[0]), 'no-padding').show();
                                tr.addClass('shown');
                                $('div.information', row.child()).slideDown();
                            }
                        });                        
                    }
                });

                function informacionAdicional(datos){ 
                    var tableInit = `<table>`;
                    var tableClose = `</table>`;

                    var hue = 'lighten-4';

                    switch (datos.origenDoc) {
                        case 'Interno':
                            var color = 'teal'
                            break;
                    
                        default:
                            var color = 'indigo';
                            break;
                    }

                    var autor = ``
                    if (datos.autor != null && datos.autor.trim != '') {
                        autor = `<small>Proyectado por: ${datos.autor.toUpperCase()}</small>`;
                        //console.log(autor);
                    }

                    var firmante = ``
                    if (datos.firmante != null && datos.firmante.trim != '') {
                        firmante = `<small>Responsable de firma: ${datos.firmante.toUpperCase()}</small>`;
                        //console.log(autor);
                    }

                    var origen = ``
                    if(datos.tipoDoc == 1){
                        origen = `<td class="center-align">${datos.entidad_origen}</td>`;
                    } else{
                        if (datos.oficina_origen != null && datos.oficina_origen.trim != ''
                            && datos.trabajador_origen != null && datos.trabajador_origen.trim != ''){
                            var suborigen = ``
                            if (datos.tipo == 'T'){
                                suborigen = autor;
                            } else {
                                suborigen = firmante;
                            }
                            origen = `<td class="center-align">
                                            <p>${datos.trabajador_origen} (${datos.oficina_origen})</p>
                                            ${suborigen}
                                    </td>`;
                        }
                    }
                    // if (datos.oficina_origen != null && datos.oficina_origen.trim != ''
                    //     && datos.trabajador_origen != null && datos.trabajador_origen.trim != ''){
                    //     origen = `<td class="center-align">
                    //                     <p>${datos.trabajador_origen} (${datos.oficina_origen})</p>
                    //                     ${autor}
                    //             </td>`;
                    // }

                    var destinos = ``
                    if (datos.destinos != null && datos.destinos.trim != ''){
                        var array = JSON.parse(datos.destinos);
                        if (array.length > 0) {
                            var iterator = ``                    
                            array.forEach(function (destino){
                                if(datos.tipoDoc == 3){
                                    iterator += `<li>${destino.entidad_destino}</li>`
                                } else{
                                    if(destino.flgCopia == 1){
                                        iterator += `<li>Cc. ${destino.trabajador_destino} (${destino.oficina_destino})</li>`
                                    } else {
                                        iterator += `<li>${destino.trabajador_destino} (${destino.oficina_destino})</li>`
                                    }                                    
                                }                                
                            });                    
                            destinos = `<td class="center-align"><ul>${iterator}</ul></td>`;
                        }                        
                    } else {
                        destinos = `<td class="center-align"><ul>El documento aún no tiene un destino asignado.</ul></td>`;
                    }

                    var pendientes = ``
                    if (datos.mov_pendientes != null && datos.mov_pendientes.trim != '') {
                        var array = JSON.parse(datos.mov_pendientes);

                        if (array.length > 0) {                    
                            var iterator = ``                        
                            array.forEach(function (pendiente) {
                                iterator += `
                                <tr>
                                        <td>(${pendiente.oficina_origen}) ${pendiente.trabajador_origen}</td>
                                        <td>(${pendiente.oficina_destino}) ${pendiente.trabajador_destino}</td>
                                        <td>${pendiente.fecha_envio}</td>
                                        <td>${pendiente.estado}</td>
                                        <td>${pendiente.indicacion}</td>
                                        <td>${pendiente.observacion}</td>
                                    </tr>`
                            });

                            var label = `Pendiente(s)`
                            /*if (array.length > 1){
                                label = `Últimos movimientos: `
                            } else {
                                label = `Último movimiento: `
                            }*/
                            pendientes = `
                                            <table width="100%">
                                                <thead>
                                                    <tr class="${color} ${hue}">
                                                        <th class="center-align" colspan="6">
                                                            ${label}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Envìa</th>
                                                        <th>Recibe</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th>Indicaciòn</th>
                                                        <th>Observaciones</th>
                                                    </tr>
                                                    
                                                    ${iterator}
                                                </tbody>
                                            </table>`;
                        }                    
                    }else {
                            pendientes = `
                                            <table width="100%">
                                                <thead>
                                                    <tr class="${color} ${hue}">
                                                        <th class="center-align">Pendientes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th class="center-align">Este documento no tiene pendientes</th>
                                                    </tr>                                                    
                                                </tbody>
                                            </table>`;
                        }


                    var html = `<div class="information">
                            <table style="width=100%">
                                <thead>
                                    <tr class="${color} ${hue}">
                                        <th class="center-align">Origen</th>
                                        <th class="center-align">Destino</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        ${origen}
                                        ${destinos}
                                    </tr>
                                </tbody>
                            </table>
                            ${pendientes}</div>`;
                    
                    return html;
                }

                btnDescargarZip.on('click', function(){
                    var datosTabla = dtTablaDatos.page.info();
                    var actual = 0;
                    var total = datosTabla.recordsTotal;
                    var nombreZip = 'archivozipconsultageneral'+Date.now();
                    var porcentaje = Math.round((actual/total)*100);
                    $.confirm({
                            columnClass: 'col-md-4 col-md-offset-4',
                            title: '¿Esta seguro de querer descargar estos '+total+ ' archivos?',
                            content: '',
                            buttons: {
                                Si: function(){
                                    initProgress();
                                    updateProgress(`Generando Zip ${porcentaje} %`,`${porcentaje}%`);
                                    $.ajax({
                                        async: false,
                                        url: 'ajaxtablas/ajaxTablaConsultaNueva.php',
                                        type: 'POST',
                                        datatype: 'json',                            
                                        data: {
                                            "Evento" : "DataTableData",
                                            "tipoOrigen": $("#searchForm").find("[name=tipoOrigenCG]").val(),
                                            "tipoTramite": $("#searchForm").find("[name=tipoTramiteCG]").val(),
                                            "estadoTramite": $("#searchForm").find("[name=estadoTramiteCG]").val(),
                                            "numExpediente": $("#searchForm").find("[name=txtCUDCG]").val(),
                                            "tipoDocumento": $("#searchForm").find("[name=tipoDocumentoCG]").val(),
                                            "numDocumento": $("#searchForm").find("[name=txtNumDocCG]").val(),
                                            "asunto": $("#searchForm").find("[name=txtAsuntoCG]").val(),
                                            "entidadOrigen": "",
                                            "oficinaOrigen": $("#searchForm").find("[name=oficinaOrigenCG]").val(),
                                            "trabajadorOrigen": $("#searchForm").find("[name=trabajadorOrigenCG]").val(),
                                            "entidadDestino": "",
                                            "oficinaDestino": $("#searchForm").find("[name=oficinaDestinoCG]").val(),
                                            "trabajadorDestino": $("#searchForm").find("[name=trabajadorDestinoCG]").val(),
                                            "tipoFecha": $("#searchForm").find("[name=rdFecha]:checked").val(),
                                            "fechaInicio": $("#searchForm").find("[name=txtFecIniCG]").val(),
                                            "fechaFin": $("#searchForm").find("[name=txtFecFinCG]").val(),
                                            "anioDocumento": $("#searchForm").find("[name=anioCG]").val(),
                                            "rangoFecha": ($("#searchForm").find("[name=flgRango]").prop("checked") ? $("#searchForm").find("[name=flgRango]:checked").val() : '0'),
                                            "start" : 0,
                                            "length" : total
                                        },
                                        success: function(data){
                                            var datos = JSON.parse(data);
                                            datos.data.forEach(function(fila){
                                                $.ajax({
                                                    async: false,
                                                    url: 'ajax/ajaxConsultaGeneralZip.php',
                                                    type: 'POST',
                                                    datatype: 'json',
                                                    data: {
                                                        "evento" : "AgregarAZip",
                                                        "codigo" : fila.codigo,
                                                        "nombre" : fila.tipo_doc.trim()+' '+fila.nro_documento.trim()+' '+fila.cud.trim(),
                                                        "nombreZip" : nombreZip
                                                    },
                                                    success: function(data){
                                                        actual ++;
                                                        porcentaje = Math.round((actual/total)*100);
                                                        updateProgress(`Generando Zip ${porcentaje} %`,`${porcentaje}%`);
                                                        var data = JSON.parse(data);
                                                        if (!data.success){
                                                            M.toast({html: data.message});
                                                        }
                                                        if (porcentaje == 100){
                                                            location.href = `../archivosTemp/${nombreZip}.zip`;
                                                            $.ajax({
                                                                async: false,
                                                                url: 'ajax/ajaxConsultaGeneralZip.php',
                                                                type: 'POST',
                                                                data: {"evento" : "EliminarZip","nombreZip" : nombreZip
                                                                }                                       
                                                            }).done(() => finishProgress());
                                                        }
                                                    }                                        
                                                });                                    
                                            });
                                        }
                                    });
                                },
                                Cancelar: function(){
                                    $.alert('Cancelado');
                                }
                            }                            
                        });                    
                });

                $('.datepicker').datepicker({
                    autoClose: true,
                    format: 'dd/mm/yyyy'
                });

                $('#txtAsuntoMain').keyup(function(){
                    var valor = $(this).val();

                    if (valor.length > 0) {
                        $("label[for='txtAsunto']").addClass('active');
                        $('#txtAsunto').val($(this).val());
                    } else {
                        $('#txtAsunto').val('');
                        $("label[for='txtAsunto']").removeClass('active');
                    }
                });

                $('#btnSearch').click(function(e) {    
                    filtro = CargaVariables();                
                    dtTablaDatos.ajax.reload(function() {
                        var isOpen = $('#btnAdvanced').find('svg').hasClass('fa-angle-double-up');

                        if (isOpen) {
                            $('#btnAdvanced').trigger('click');
                        }
                    });
                });

                $('#btnSearchMain').click(function() {
                    $('#btnSearch').trigger('click');
                });
                
                $('#txtAsuntoMain').keyup(function(e){
                    if( e.keyCode == 13 ) {
                        $('#btnSearch').trigger('click');
                    }
                });

                //carga de componentes y validaciones en searchbox       
                //Carga Select Tipo de Documentos    
                $.ajax({
                    cache: 'false',
                    url: 'ajax/ajaxTipoDocumentoAll.php',
                    method: 'POST',
                    data: {tipoDoc: '0'},
                    datatype: 'json',
                    success: function (data) {

                        $('select[name="tipoDocumentoCG"]').empty().append('<option value="">TODOS</option>');
                        var documentos = JSON.parse(data);
                        $.each(documentos, function (key,value) {

                            $('select[name="tipoDocumentoCG"]').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        $('select[name="tipoDocumentoCG"]').formSelect();
                    }
                });
                
                //OFICINA ENVIO
                //Select Oficinas
                $.ajax({
                    cache: 'false',
                    url: 'ajax/ajaxOficinas.php',
                    method: 'POST',
                    data: {esTupa: '0'},
                    datatype: 'json',
                    success: function (data) {
                        $('select[name="oficinaOrigenCG"]').empty().append('<option value="">TODOS</option>');
                        var oficinas = JSON.parse(data);
                        $.each(oficinas.data, function (key,value) {
                            $('select[name="oficinaOrigenCG"]').append(value);
                        });
                        // M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                        // var elems = document.querySelectorAll('select');
                        //var instances = M.FormSelect.init(elems, options);
                        $('select[name="oficinaOrigenCG"]').formSelect();
                    }
                });
                
                $('#trabajadorOrigenCG').select2();
                //Select Trabajadores
                var selectOfiEnvio = document.getElementById('oficinaOrigenCG');
                selectOfiEnvio.addEventListener('change',function(){
                    var selectedOption = this.options[selectOfiEnvio.selectedIndex];
                    listarJefeOficina('ListarJefePorOficinaCG',selectedOption.value);
                    $('#trabajadorOrigenCG').select2({
                        placeholder: 'Seleccione y busque',
                        multiple: true,
                        maximumSelectionLength: 10,
                        minimumInputLength: 0,
                        "language": {
                            "noResults": function(){
                                return "<p>No se encontró el trabajador.</p>";
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
                            url: 'ajax/ajaxTrabajador.php',
                            dataType: 'json',
                            method: 'POST',
                            data: function (term, page) {
                                return {
                                query: term,
                                page: page,
                                pageLimit: 25,
                                Evento: 'ListarTrabajadoresPorOficinaCG',
                                idOficina:selectedOption.value
                                };
                            },
                            //{Evento: 'ListarTrabajadoresPorOficinaCG',idOficina:selectedOption.value},
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function(obj) {
                                        return {
                                            id: obj.id,
                                            text: obj.text,
                                            selected: obj.selected
                                        };
                                    })    
                                };
                            },
                            cache: true
                        }
                    });
                    
                });

                function listarJefeOficina (evento,idOficina){
                    const trabajadorOrigenCG = $('#trabajadorOrigenCG');
                    trabajadorOrigenCG.val(null).trigger('change');
                    $.ajax({
                        type: 'POST',
                        url: 'ajax/ajaxTrabajador.php',
                        data: {Evento: evento, idOficina: idOficina},
                        datatype: 'json',
                    }).then(function (data) {
                        var theData = JSON.parse(data);
                        //console.log(theData);
                        if (theData.length > 0) {
                            trabajadorOrigenCG.prop('disabled', false);
                        } else {
                            trabajadorOrigenCG.prop('disabled', 'disabled');
                        }
                        $.each(theData, function( index, value ) {
                            var option = new Option(value.text, value.id, true, true);
                            trabajadorOrigenCG.append(option).trigger('change')
                        });
                    });
                }        


                //OFICINA DESTINO
                //Select Oficinas
                $.ajax({
                    cache: 'false',
                    url: 'ajax/ajaxOficinas.php',
                    method: 'POST',
                    data: {esTupa: '0'},
                    datatype: 'json',
                    success: function (data) {
                        $('select[name="oficinaDestinoCG"]').empty().append('<option value="">TODOS</option>');
                        var oficinas = JSON.parse(data);
                        $.each(oficinas.data, function (key,value) {
                            $('select[name="oficinaDestinoCG"]').append(value);
                        });
                        $('select[name="oficinaDestinoCG"]').formSelect();
                    }
                });

                //Select Trabajadores
                $('#trabajadorDestinoCG').select2();
                var selectOfiDestino = document.getElementById('oficinaDestinoCG');
                selectOfiDestino.addEventListener('change',function(){
                    var selectedOption = this.options[selectOfiDestino.selectedIndex];
                    listarJefeOficinaDestino('ListarJefePorOficinaCG',selectedOption.value);
                    $('#trabajadorDestinoCG').select2({
                        placeholder: 'Seleccione y busque',
                        multiple: true,
                        maximumSelectionLength: 10,
                        minimumInputLength: 0,
                        "language": {
                            "noResults": function(){
                                return "<p>No se encontró el trabajador.</p>";
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
                            url: 'ajax/ajaxTrabajador.php',
                            dataType: 'json',
                            method: 'POST',
                            data: function (term, page) {
                                return {
                                query: term,
                                page: page,
                                pageLimit: 25,
                                Evento: 'ListarTrabajadoresPorOficinaCG',
                                idOficina:selectedOption.value
                                };
                            },
                            //{Evento: 'ListarTrabajadoresPorOficinaCG',idOficina:selectedOption.value},
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function(obj) {
                                        return {
                                            id: obj.id,
                                            text: obj.text,
                                            selected: obj.selected
                                        };
                                    })    
                                };
                            },
                            cache: true
                        }
                    });
                });

                function listarJefeOficinaDestino (evento,idOficina){
                    const trabajadorDestinoCG = $('#trabajadorDestinoCG');
                    trabajadorDestinoCG.val(null).trigger('change');
                    $.ajax({
                        type: 'POST',
                        url: 'ajax/ajaxTrabajador.php',
                        data: {Evento: evento, idOficina: idOficina},
                        datatype: 'json',
                    }).then(function (data) {
                        var theData = JSON.parse(data);
                        if (theData.length > 0) {
                            trabajadorDestinoCG.prop('disabled', false);
                        } else {
                            trabajadorDestinoCG.prop('disabled', 'disabled');
                        }

                        $.each(theData, function( index, value ) {
                            var option = new Option(value.text, value.id, true, true);
                            trabajadorDestinoCG.append(option).trigger('change')
                        });
                    });
                }
                
                //Botones Flujo, Documento y Anexos
                btnFlow.on('click', function(e) {
                    $('#modalFlujo div.modal-content').html('');
                    e.preventDefault();
                    var rows_selected = dtTablaDatos.rows( { selected: true } ).data().toArray();
                    var fila = rows_selected[0];
                    var values=[];    
                    values.push(rows_selected[0]['codigo']);
                    
                    if(values[0] <= 18997 ){
                        var documentophp = "flujodoc_old.php"
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
                    } else {
                        var documentophp = "flujodoc.php"
                        var tipoD = '';
                        var codigoD = 0;
                        if (fila.tipo == 'T'){
                            codigoD = fila.codigo;
                            tipoD = 'tramite';
                        } else {
                            if (fila.subTipo == 'T'){
                                codigoD = fila.subCodigo;
                                tipoD = 'tramite';
                            } else {
                                codigoD = fila.codigo;
                                tipoD = 'proyecto';
                            }
                            values.push(fila.subCodigo);
                        }
                        $.ajax({
                            cache: false,
                            url: documentophp,
                            method: "POST",
                            data: {codigo : codigoD,tipo: tipoD},
                            datatype: "json",
                            success : function(response) {
                                $('#modalFlujo div.modal-content').html(response);
                            }
                        });
                    }                    
                });

                // Doc. button
                btnDoc.on('click', function(e) {
                    $('#modalDoc div.modal-content iframe').attr('src','');
                    var elems = document.querySelector('#modalDoc');
                    var instance = M.Modal.getInstance(elems);
                    e.preventDefault();
                    let fila = dtTablaDatos.rows( { selected: true } ).data().toArray()[0];
                    var values=[];
                    if (fila.tipo == 'T'){
                        values.push(fila.codigo);
                    } else {
                        values.push(fila.subCodigo);
                    }
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
                                            data: {'codigo': values[0], 'valor': val,'Evento': 'ValidarPassword'},
                                            datatype: "json",
                                            success: function (data) {
                                                let datos = JSON.parse(data);
                                                if(datos.validacion){
                                                    $.ajax({
                                                        cache: false,
                                                        url: "verDoc.php",
                                                        method: "POST",
                                                        data: {codigo: values, tabla: 't'},
                                                        datatype: "json",
                                                        success: function (response) {
                                                            var json = eval('(' + response + ')');
                                                            if (json['estado'] == 1) {
                                                                $('#modalDoc div.modal-content').html('');
                                                                $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                                                                // $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);
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
                            url: "ajax/obtenerDoc.php",
                            method: "POST",
                            data: {codigo: values[0], tabla: 't'},
                            datatype: "json",
                            success: function (response) {
                                var json = eval('(' + response + ')');
                                //if (json['estado'] == 1) {
                                    $('#modalDoc div.modal-content').html('');
                                    $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                                    // $('#modalDoc div.modal-content iframe').attr('src', preFrame + 'http://' + json['url']);
                                    instance.open();
                               // } else {
                                //    M.toast({html: '¡No contiene documento asociado!'});
                                //}
                            },
                            error: function (e) {
                                M.toast({html: '¡No contiene documento asociado!'});
                            }
                        });
                    }           
                });

                btnAnexos.on('click', function(e) {
                    e.preventDefault();
                    let fila = dtTablaDatos.rows( { selected: true } ).data().toArray()[0];
                    var values = new Array();                    
                    if (fila.tipo == 'T'){
                        values.push(fila.codigo);
                    } else {
                        values.push(fila.subCodigo);
                    }
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
                                                                data: {iCodMovimiento: values[0].iCodMovimiento},
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
                            data: {codigo: values[0]},
                            datatype: "json",
                            success: function (response) {
                            
                                $('#modalAnexo div.modal-content ul').html('');
                                var json = JSON.parse(response);

                                if(json.tieneAnexos == '1') {
                                    let cont = 1;
                                    json.anexos.forEach(function (elemento) {
                                        /*Inicio Renombre*/
                                            let elementoNombre = elemento.nombre;            
                                            if (/^\d/.test(elementoNombre)) {
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
                            data.fila = dtTablaDatos.rows( { selected: true } ).data().toArray()[0];
                            data.codigo = 0;
                            if (data.fila.tipo == 'T'){
                                data.codigo = data.fila.codigo;
                            } else {
                                data.codigo = data.fila.subCodigo;
                            }
                            updateProgress(`Generando Zip`,`0%`);

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
                                "nombre" : respuesta.fila.tipo_doc.trim()+' '+ respuesta.fila.nro_documento.trim()+' '+ respuesta.fila.cud.trim(),
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

                function ClearForm(form, dt) {
                
                    // dt.rows().deselect();
                    form.find("input").val("");
                    form.find("select").val("");
                    form.find("select#tipoOrigenCG").val("1");
                    form.find("select#tipoTramiteCG").val("1");
                    form.find("select").formSelect();
                    // dt.clear().draw();
                    // dt.ajax.reload();
                    $('#envioExterno').addClass('hide');
                    $('#envioInterno').removeClass('hide');
                    $('#recepcionExterno').addClass('hide');
                    $('#recepcionInterno').removeClass('hide');
                    // $('#remitenteInterno').append(null).trigger('change');
                    // $('#destinoExterno').append(null).trigger('change');
                    //DrawTable(dt, id);
                }

                var btnClear = document.getElementById('#btnClear');
                $('#btnClear').on('click',function(){
                   // e.preventDefault();
                    var frmConsultaG = $('#searchForm');
                    //CargaVariables();
                    ClearForm(frmConsultaG, dtTablaDatos);
                    //CargaVariables();
                });

                var tipoOrigenCG = document.getElementById('tipoOrigenCG');
                tipoOrigenCG.addEventListener('change',function(){
                    
                    var tipoOrigen = $('#tipoOrigenCG').val();
                    if( tipoOrigen =='1'){
                            $('#envioExterno').addClass('hide');
                            $('#envioInterno').removeClass('hide');
                    }if(tipoOrigen =='2'){
                        $('#envioExterno').removeClass('hide');
                        $('#envioInterno').addClass('hide');
                    }
                });

                // var tipoDocumentoCG = document.getElementById('tipoDocumentoCG');
                // tipoDocumentoCG.addEventListener('change',function(){
                    
                //     var tipoOrigen = $('#tipoDocumentoCG').val();
                //     if( tipoOrigen =='19' | tipoOrigen =='32' | tipoOrigen =='13' | tipoOrigen =='11' | tipoOrigen =='10'){
                //             $('#recepcionExterno').removeClass('hide');
                //             $('#recepcionInterno').addClass('hide');
                //     }else{
                //         $('#recepcionExterno').addClass('hide');
                //         $('#recepcionInterno').removeClass('hide');
                //     }
                // });                

                //carga destinatario externo
                // $('#remitenteInterno').select2({
                //     placeholder: 'Seleccione y busque',
                //     minimumInputLength: 3,
                //     "language": {
                //         "noResults": function(){
                //             return "<p>No se encontró al destinatario. Para incluir un nuevo destinatario, comuníquese con el Responsable de Archivo de Gestión de su área.</p>";
                //         },
                //         "searching": function() {

                //             return "Buscando..";
                //         },
                //         "inputTooShort": function() {

                //             return "Ingrese más de 3 letras ...";
                //         }
                //     },
                //     escapeMarkup: function (markup) {
                //         return markup;
                //     },
                //     ajax: {
                //         url: 'mantenimiento/Entidad.php',
                //         dataType: 'json',
                //         method: 'POST',
                //         data: function (params) {
                //             var query = {
                //                 search: params.term,
                //                 Evento: 'BuscarEntidad'
                //             }
                //             return query;
                //         },
                //         delay: 100,
                //         processResults: function (data) {
                //             return {
                //                 results: data
                //             };
                //         },
                //         cache: true
                //     }
                // });

                // $('#destinoExterno').select2({
                //     placeholder: 'Seleccione y busque',
                //     minimumInputLength: 3,
                //     "language": {
                //         "noResults": function(){
                //             return "<p>No se encontró al destinatario. Para incluir un nuevo destinatario, comuníquese con el Responsable de Archivo de Gestión de su área.</p>";
                //         },
                //         "searching": function() {

                //             return "Buscando..";
                //         },
                //         "inputTooShort": function() {

                //             return "Ingrese más de 3 letras ...";
                //         }
                //     },
                //     escapeMarkup: function (markup) {
                //         return markup;
                //     },
                //     ajax: {
                //         url: 'mantenimiento/Entidad.php',
                //         dataType: 'json',
                //         method: 'POST',
                //         data: function (params) {
                //             var query = {
                //                 search: params.term,
                //                 Evento: 'BuscarEntidad'
                //             }
                //             return query;
                //         },
                //         delay: 100,
                //         processResults: function (data) {
                //             return {
                //                 results: data
                //             };
                //         },
                //         cache: true
                //     }
                // });

                //rango de fechas
                var rangoFec = document.getElementById('flgRango');
                rangoFec.addEventListener('change',function(){
                    var flgRango = $('#flgRango').prop('checked');
                    if(flgRango == true){
                        $('#fecFin').removeClass('hide');
                    }else{
                        $('#fecFin').addClass('hide');
                        $('#txtFecFin').val('');
                    }
                });
                
                //Descargar en Excel

                //Funcion para obtenter valores del formulario

                function CargaVariables() {
                    
                    var variables = new Array();
                    var Evento = "DataTableData";
                    var tipoOrigen = $("#searchForm").find("[name=tipoOrigenCG]").val();
                    var tipoTramite = $("#searchForm").find("[name=tipoTramiteCG]").val();
                    var estadoTramite = $("#searchForm").find("[name=estadoTramiteCG]").val();
                    var numExpediente = $("#searchForm").find("[name=txtCUDCG]").val();
                    var tipoDocumento = $("#searchForm").find("[name=tipoDocumentoCG]").val();
                    var numDocumento = $("#searchForm").find("[name=txtNumDocCG]").val();
                    
                    var asunto = $("#searchForm").find("[name=txtAsuntoCG]").val();
                    
                    var entidadOrigen = $("#searchForm").find("[name=remitenteInterno]").val();
                    var oficinaOrigen = $("#searchForm").find("[name=oficinaOrigenCG]").val();
                    var trabajadorOrigen = $("#searchForm").find("[name=trabajadorOrigenCG]").val();
                    var entidadDestino = $("#searchForm").find("[name=destinoExterno]").val();
                    var oficinaDestino =$("#searchForm").find("[name=oficinaDestinoCG]").val();
                    var trabajadorDestino = $("#searchForm").find("[name=trabajadorDestinoCG]").val();
                    var tipoFecha = $("#searchForm").find("[name=rdFecha]:checked").val();
                    var fechaInicio = $("#searchForm").find("[name=txtFecIniCG]").val();
                    var fechaFin = $("#searchForm").find("[name=txtFecFinCG]").val();
                    var anioDocumento = $("#searchForm").find("[name=anioCG]").val();
                    var rangoFecha = ($("#searchForm").find("[name=flgRango]").prop("checked") ? $("#searchForm").find("[name=flgRango]:checked").val() : '0');
                    variables.push(Evento,tipoOrigen,tipoTramite,estadoTramite,numExpediente,tipoDocumento,numDocumento,asunto,entidadOrigen,oficinaOrigen,trabajadorOrigen,entidadDestino,oficinaDestino,trabajadorDestino,tipoFecha,fechaInicio,fechaFin,anioDocumento,rangoFecha);
                    //console.log(variables);
                    return variables;
                }

                $('#btnDescargarExcel').on('click',function(){
                    var datosTabla = dtTablaDatos.page.info();
                    var total = datosTabla.recordsTotal;
                    var data = new Object();
                    data.datos = filtro;
                    data.length = total;
                    data.start = 0;
                    
                    var string = window.btoa(JSON.stringify(data));
                    window.open(RUTA_DTRAMITE+'views/ajax/ajaxConsultaGeneralExcel.php?var='+string,'_blank' );
                    // $.ajax({
                    //     url: 'ajax/ajaxConsultaGeneralExcel.php',
                    //     type: 'POST',
                        
                    //     data: {
                    //         "Evento" : filtro[0] ,
                    //         "tipoOrigen": filtro[1],
                    //         "tipoTramite": filtro[2],
                    //         "estadoTramite": filtro[3],
                    //         "numExpediente": filtro[4],
                    //         "tipoDocumento": filtro[5],
                    //         "numDocumento": filtro[6],
                    //         "asunto": filtro[7],
                    //         "entidadOrigen": filtro[8],
                    //         "oficinaOrigen": filtro[9],
                    //         "trabajadorOrigen": filtro[10],
                    //         "entidadDestino": filtro[11],
                    //         "oficinaDestino": filtro[12],
                    //         "trabajadorDestino": filtro[13],
                    //         "tipoFecha": filtro[14],
                    //         "fechaInicio": filtro[15],
                    //         "fechaFin": filtro[16],
                    //         "anioDocumento": filtro[17],
                    //         "rangoFecha": filtro[18],
                    //         "start" : 0,
                    //         "length" : total
                    //     },
                    //     success: function(){
                    //         //window.open('http://localhost/d-tramite-final/views/ajax/ajaxConsultaGeneralExcel.php','_blank' );
                    //     }                                        
                    // });  
                });
                

            });

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
            
            $(document).on('click', '#btnAdvanced', function(){
                //debugger;
                /*$('#btnAdvanced')
                .find('[data-fa-i2svg]')
                .toggleClass('fa-angle-double-down')
                .toggleClass('fa-angle-double-up');*/
                var icon = $('#btnAdvanced').find('[data-fa-i2svg]');
                var isOpen = icon.hasClass('fa-angle-double-up');
                var sf = $('#searchForm');

                if (isOpen === true) {
                   icon.removeClass('fa-angle-double-up'); 
                   icon.addClass('fa-angle-double-down');
                   sf.addClass('hide');
                } else {
                    icon.removeClass('fa-angle-double-down'); 
                    icon.addClass('fa-angle-double-up');
                    sf.removeClass('hide');                
                }
            });

            $("#tipoOrigenCG").on('change', function(e){
                e.preventDefault();
                e.stopPropagation();

                if($("#tipoOrigenCG").val() == '1'){
                    $("#destinoDoc").css("display", "block");
                } else {
                    $("#destinoDoc").css("display", "none");
                    $("input[name=rdDestino][value=1]").prop("checked",true).trigger("change");
                }
            });

            $("input[name=rdDestino]").on('change',function(e){
                if($("input[name=rdDestino]:checked").val() == 2){
                        $('#recepcionExterno').removeClass('hide');
                        $('#recepcionInterno').addClass('hide');
                }else{
                    $('#recepcionExterno').addClass('hide');
                    $('#recepcionInterno').removeClass('hide');
                }
            });
        </script>
    </body>
</html>

<?php
} else {
   header("Location: ../index-b.php?alter=5");
}
?>