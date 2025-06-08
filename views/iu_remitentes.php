<?php
session_start();

$pageTitle = "Mantenimiento Remitentes";
$activeItem = "iu_remitentes.php";
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
                        <li><a id="btnAgregar" class="btn btn-primary" href="#"><i class="fas fa-plus left"></i><span>Agregar</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <table id="tblRemitentes" class="hoverable highlight striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Dependencia</th>
                                        <th>Documento</th>
                                        <th>Direcciòn</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalGeneral" class="modal">
        <div class="modal-header"></div>
        <div class="modal-content"></div>
        <div class="modal-footer"></div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>
    <script>
        $(document).ready(function() {
            $('.modal').modal();

            var tblRemitentes = $('#tblRemitentes').DataTable({
                'processing': true,
                'serverSide': false,
                responsive: true,
                ajax: {
                    url: 'mantenimiento/Oficina.php',
                    type: 'POST',
                    datatype: 'json',
                    data: function ( d ) {
                        return $.extend( {}, d, {
                            'Evento' : 'Listar',
                            'Sigla' : $("#formBusqueda #siglaOficina").val(),
                            'Nombre' : $("#formBusqueda #nombreOficina").val(),
                            'Estado' : $("#formBusqueda #estadoOficina").val()
                        });
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblRemitentes_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblRemitentes.rows().deselect();
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
                        'targets': [1,2,3,4,5],
                        'orderable': false
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{'data': 'siglas', 'autoWidth': true}
                    ,{'data': 'nombre', 'autoWidth': true}
                    ,{'data': 'oficinaPadre', 'autoWidth': true}
                    ,{'data': 'estado', 'autoWidth': true}
                    ,{
                        'render': function (data, type, full, meta) {
                            let botones = '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-trash-alt"></i></button>'+
                                          '<button type="button" data-accion="editar" data-toggle="tooltip" title="Editar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-pencil-alt"></i></button>';
                            return botones
                        }, 'className': 'center-align',"width": "100px"
                    }
                ],
                'select': {
                    'style': 'single'
                }
            });

            $('#tblRemitentes tbody').on('click', 'button', function (event) {
                let fila = tblRemitentes.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {
                    case 'eliminar':
                        console.log("eliminar");
                        break;

                    case 'editar':
                        console.log("editar");
                        break;
                }
            });         
        });
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>