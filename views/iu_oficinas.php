<?php
session_start();

$pageTitle = "Mantenimiento Oficinas";
$activeItem = "iu_oficinas.php";
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
                        <li><a id="btnAgregar" class="btn btn-primary modal-trigger" href="#modalRegistro"><i class="fas fa-plus left"></i><span>Agregar</span></a></li>
                        <li><a id="btnBuscar" class="btn btn-secondary modal-trigger" href="#modalBuscar"><i class="fas fa-search left"></i><span>Buscar</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <table id="tblOficinas" class="hoverable highlight striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Siglas</th>
                                        <th>Nombre</th>
                                        <th>Oficina Padre</th>
                                        <th>Estado</th>
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

    <div id="modalRegistro" class="modal">
        <div class="modal-header">
            <h4>Registro</h4>
        </div>
        <div class="modal-content">
            <form id="formRegistro" class="row">
                <div class="col s12 input-field">
                    <input type="text" id="siglaOficinaR">
                    <label for="siglaOficinaR">Sigla</label>
                </div>
                <div class="col s12 input-field">
                    <input type="text" id="nombreOficinaR">
                    <label for="nombreOficinaR">Nombre</label>
                </div>
                <div class="col s12 input-field">
                    <select id="oficinaPadreR"></select>
                    <label for="oficinaPadreR">Oficina padre</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnRegistrarOficina" class="waves-effect btn-flat">Registrar</a>
        </div>
    </div>

    <div id="modalBuscar" class="modal">
        <div class="modal-header">
            <h4>Búsqueda</h4>
        </div>
        <div class="modal-content">
            <form id="formBusqueda" class="row">
                <div class="col s12 input-field">
                    <input type="text" id="siglaOficina">
                    <label for="siglaOficina">Sigla</label>
                </div>
                <div class="col s12 input-field">
                    <input type="text" id="nombreOficina">
                    <label for="nombreOficina">Nombre</label>
                </div>
                <div class="col s12 input-field">
                    <select id="estadoOficina">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                    <label for="estadoOficina">Estado</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnBuscarParametros" class="waves-effect btn-flat">Buscar</a>
        </div>
    </div>

    <div id="modalEditar" class="modal">
        <div class="modal-header">
            <h4>Editar</h4>
        </div>
        <div class="modal-content">
            <form id="formEditar" class="row">
                <input type="hidden" id="idOficinaE">
                <div class="col s12 input-field">
                    <input type="text" id="siglaOficinaE">
                    <label for="siglaOficinaE">Sigla</label>
                </div>
                <div class="col s12 input-field">
                    <input type="text" id="nombreOficinaE">
                    <label for="nombreOficinaE">Nombre</label>
                </div>
                <div class="col s12 input-field">
                    <select id="oficinaPadreE"></select>
                    <label for="oficinaPadreE">Oficina padre</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEditarOficina" class="waves-effect btn-flat">Editar</a>
        </div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>
    <script>
        $(document).ready(function() {
            $('.modal').modal();

            var tblOficinas = $('#tblOficinas').DataTable({
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
                    $('select[name="tblOficinas_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblOficinas.rows().deselect();
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

            $('#tblOficinas tbody').on('click', 'button', function (event) {
                let fila = tblOficinas.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {
                    case 'eliminar':
                        getSpinner('¡Eliminando oficina!');
                        $.confirm({
                            title: '¿Esta seguro de eliminar?',
                            content: '',
                            buttons: {
                                Si: function () {
                                    $.ajax({
                                        url: 'mantenimiento/Oficina.php',
                                        method: "POST",
                                        data: {
                                            Evento: 'Eliminar',
                                            id: dataFila.idOficina,
                                        },
                                        datatype: "json",
                                        success: function () {
                                            console.log('¡Oficina anulada!');                                            
                                            tblOficinas.ajax.reload();
                                            deleteSpinner();
                                            M.toast({html: "¡Oficina anulada!"});
                                        },
                                        error: function (e) {
                                            console.log(e);
                                            console.log('¡Error al eliminar!');
                                            deleteSpinner();
                                            M.toast({html: '¡Error al eliminar!'});
                                        }
                                    });
                                },
                                No: function () {
                                    $.alert('Eliminación cancelada');
                                }
                            }
                        });
                        break;

                    case 'editar':
                        $.ajax({
                            url: 'mantenimiento/Oficina.php',
                            method: "POST",
                            data: {
                                Evento: 'Obtener',
                                id: dataFila.idOficina,
                            },
                            datatype: "json",
                            success: function (response) {
                                console.log('¡Oficina datos!');
                                response = JSON.parse(response);
                                $("#formEditar #idOficinaE").val(response.idOficina);
                                $("#formEditar #siglaOficinaE").val(response.siglas).next().addClass("active");
                                $("#formEditar #nombreOficinaE").val(response.nombre).next().addClass("active");
                                $("#formEditar #oficinaPadreE").val(response.oficinaPadre).formSelect();
                                var elem = document.querySelector('#modalEditar');
                                var instance = M.Modal.init(elem, {dismissible:false});
                                instance.open();
                            }
                        });
                        break;
                }
            });

            $('#btnBuscarParametros').on('click', function (e) {
                tblOficinas.ajax.reload();
                var elem = document.querySelector('#modalBuscar');
                var instance = M.Modal.init(elem, {dismissible:false});
                instance.close();
            });

            $.ajax({
               cache: false,
               url: "ajax/ajaxOficinas.php",
               method: "POST",
               data: {esTupa: 0, iCodTupa: 0 },
               datatype: "json",
               success: function (response) {
                    response = JSON.parse(response);
                   $('#oficinaPadreR').empty().append('<option value="0">Seleccione</option>');
                   $('#oficinaPadreE').empty().append('<option value="0">Seleccione</option>');
                   $.each(response.data, function (key,value) {
                       $('#oficinaPadreR').append(value);
                       $('#oficinaPadreE').append(value);
                   });
                   $('#oficinaPadreR').formSelect();
                   $('#oficinaPadreE').formSelect();
               }
           });

            $('#btnRegistrarOficina').on('click', function (e) {
                $.ajax({
                    url: 'mantenimiento/Oficina.php',
                    method: "POST",
                    data: {
                        Evento: 'Registrar',
                        siglas: $("#formRegistro #siglaOficinaR").val(),
                        nombre: $("#formRegistro #nombreOficinaR").val(),
                        oficinaPadre: $("#formRegistro #oficinaPadreR").val()
                    },
                    datatype: "json",
                    success: function () {
                        console.log('¡Oficina registrada!');                                            
                        tblOficinas.ajax.reload();
                        deleteSpinner();
                        var elem = document.querySelector('#modalRegistro');
                        var instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        M.toast({html: "¡Oficina registrada!"});
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('¡Error al registrar!');
                        deleteSpinner();
                        M.toast({html: '¡Error al registrar!'});
                    }
                });
            });

            $('#btnEditarOficina').on('click', function (e) {
                $.ajax({
                    url: 'mantenimiento/Oficina.php',
                    method: "POST",
                    data: {
                        Evento: 'Editar',                        
                        id: $("#formEditar #idOficinaE").val(),
                        siglas: $("#formEditar #siglaOficinaE").val(),
                        nombre: $("#formEditar #nombreOficinaE").val(),
                        oficinaPadre: $("#formEditar #oficinaPadreE").val()
                    },
                    datatype: "json",
                    success: function () {
                        console.log('¡Oficina actualizada!');                                            
                        tblOficinas.ajax.reload();
                        deleteSpinner();
                        var elem = document.querySelector('#modalEditar');
                        var instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        M.toast({html: "¡Oficina actualizada!"});
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('¡Error al actualizar!');
                        deleteSpinner();
                        M.toast({html: '¡Error al actualizar!'});
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