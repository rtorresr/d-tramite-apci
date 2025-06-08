<?php
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");

$pageTitle = "Registro Solicitud Prestamo documento";
$activeItem = "vistaPrestamoDocumento.php";
$navExtended = true;
$nNumAno    = date("Y");
if($_SESSION['CODIGO_TRABAJADOR']!=""){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <link href="includes/component-dropzone.css" rel="stylesheet">
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <a name="area"></a>
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><a id="btnRegistrar" class="btn btn-primary"><i class="fas fa-plus fa-fw left"></i><span> Registrar</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <form id="frmRegistroSolicitud">
                <div class="card hoverable">
                    <div class="card-body">
                        <fieldset>
                            <legend>Datos de la solicitud</legend>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input id="nroSolitud" type="text" name="nroSolitud">
                                    <label for="nroSolitud">N° de solicitud</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="IdTipoServicio" name="IdTipoServicio">
                                    </select>
                                    <label for="IdTipoServicio">Tipo de servicio solicitud</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6 input-field ">
                                    <select id="idEmpresaCustodia" name="idEmpresaCustodia">
                                    </select>
                                    <label for="idEmpresaCustodia">Empresa de custodia</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="observacion" type="text" name="observacion">
                                    <label for="observacion">Observación</label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Detalle solicitud</legend>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input id="codigoExterno" type="text" >
                                    <label for="codigoExterno">Código externo</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="descripcionDocumento" type="text">
                                    <label for="descripcionDocumento">Descripción documento</label>
                                </div>
                                <div class="col s12">
                                    <a class="waves-effect waves-light btn" id="AgregarDetalle">Agregar</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <table id="tblDetalleSolicitudExterno" class="bordered hoverable highlight striped" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Código externo item</th>
                                            <th>Descripción</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
    </main>

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>

    <script>
        function ReiniciarValores(){
            $("#nroSolitud").val('');
            ContenidosTipo('IdTipoServicio',25);
            ListarEmpresasCustodia('idEmpresaCustodia');
            $("#observacion").val('');
            tblDetalleSolicitudExterno.rows().remove().draw();
        };

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
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        function ListarEmpresasCustodia(idDestino){
            $.ajax({
                cache: false,
                url: "ajax/ajaxListarEmpresasCustodia.php",
                datatype: "json",
                success : function(data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        function Validar()
        {
            if ($("#nroSolitud").val() === ""){
                $.alert("¡Falta número de solicitud!");
                return false;
            }
            /*let filasDetalle = tblDetalleSolicitudExterno.data().length;
            if (filasDetalle === 0){
                $.alert("¡Falta agregar documentos!");
                return false;
            }*/
            return true;
        }

        let tblDetalleSolicitudExterno = $('#tblDetalleSolicitudExterno').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#tblDetalleSolicitudExterno").hide();
                }else{
                    $("#tblDetalleSolicitudExterno").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'CodigoExterno', 'autoWidth': true,"width": "30%", 'className': 'text-left' },
                { 'data': 'DescripcionDocumento', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-trash-alt"></i></button> ';
                    }, 'className': 'text-center',"width": "20px"
                },
            ]
        });

        $("#tblDetalleSolicitudExterno tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            if(accion === 'eliminar'){
                tblDetalleSolicitudExterno.row($(this).parents('tr')).remove().draw(false);
            }
        });

        $("#AgregarDetalle").click(function(){
            let detalle = new Object();
            detalle.CodigoExterno = $('#codigoExterno').val();
            detalle.DescripcionDocumento = $('#descripcionDocumento').val();

            if (detalle.DescripcionDocumento !== '' &&  detalle.CodigoExterno !== '') {
                let data = tblDetalleSolicitudExterno.data();
                let estado = true;
                $.each(data, function (i, item) {
                    if (detalle.CodigoExterno === item.CodigoExterno) {
                        estado = false;
                    }
                    if (detalle.DescripcionDocumento === item.DescripcionDocumento) {
                        estado = false;
                    }
                });
                if (estado) {
                    $('#codigoExterno').val('');
                    $('#DescripcionDocumento').val('');
                    tblDetalleSolicitudExterno.row.add(detalle).draw();
                } else {
                    $.alert("El documento ya está agreado");
                }
            }else {
                $.alert("¡No hay documento ingresado!");
            }
        });

        $('#btnRegistrar').on('click', function () {
            if (Validar() === true){
                let data = $('#frmRegistroSolicitud').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","RegistrarSolicitudExterna");
                let tabla = tblDetalleSolicitudExterno.data();
                $.each(tabla, function (i, item) {
                    $.each(item, function (key,value) {
                        formData.append("DataDetalle[" + i + "]["+key+"]", value);
                    });
                });
                ReiniciarValores();
                getSpinner('Cargando...');
                $.ajax({
                    url: "registerDoc/RegSolicitudExterna.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success: function () {
                        deleteSpinner();
                        M.toast({html: "¡Solicitud registrada correctamente!"});
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('¡Error al registrar la solicitud!');
                        deleteSpinner();
                        M.toast({html: "¡Error al registrar la solicitud!"});
                    }
                });
            }
        });

        $("#archivoCentral").on("change",function (e) {
            if ($("#archivoCentral:checked").length === 1){
                $("#IdOficinaRequerida").parent().css("display", "none")
            } else {
                $("#IdOficinaRequerida").parent().css("display", "block")
            }
        });

        $(function() {
            ReiniciarValores();
        });
    </script>
    </body>
    </html>

    <?php
}else{

    header("Location: ../index-b.php?alter=5");
}
?>