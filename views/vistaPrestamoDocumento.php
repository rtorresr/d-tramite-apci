<?php
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");

$sqlConsultaCorrelativo = 'SELECT nCorrelativo FROM Tra_M_Correlativo_Oficina WHERE iCodOficina = '.$_SESSION['iCodOficinaLogin'].' AND cCodTipoDoc = 36 AND nNumAno = year(getdate())';
$rsConsultaCorrelativo   = sqlsrv_query($cnx,$sqlConsultaCorrelativo);
$RsConsultaCorrelativo   = sqlsrv_fetch_array($rsConsultaCorrelativo, SQLSRV_FETCH_ASSOC);

$nroCorrelativo = 1;
if($RsConsultaCorrelativo != null){
    $nroCorrelativo = $RsConsultaCorrelativo['nCorrelativo'] + 1;
}

$pageTitle = "Registro Solicitud de Servicios N° ".$nroCorrelativo;
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
                    <input type="hidden" name="nroCorrelativo" id="nroCorrelativo" value="<?=$nroCorrelativo;?>">
                    <div class="card hoverable">
                        <div class="card-body">
                            <fieldset>
                                <legend>Datos de la solicitud</legend>
                                <div class="row">
                                    <div class="input-field col s12 ">
                                        <select id="OficinaRequerida" name="OficinaRequerida">
                                        </select>
                                        <label for="OficinaRequerida">Oficina responsable de la atención</label>
                                        <input type="hidden" id="IdOficinaRequerida" name="IdOficinaRequerida">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Detalle de solicitud</legend>
                                <div class="row">
                                    <div class="input-field col s12 m12">
                                        <input id="NroExpediente" type="text" class="validate">
                                        <label for="NroExpediente">Serie documental</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <textarea id="DescripcionDocumento" class="materialize-textarea" style="height: 127px;!important"></textarea>
                                        <label for="DescripcionDocumento">Descripción documento</label>                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <!--<div class="input-field col s12 m5">
                                        <select id="IdSerieDocumental">
                                        </select>
                                        <label for="IdSerieDocumental">Serie documental</label>
                                    </div>-->
                                    <div class="col s12 m2 input-field">
                                        <!--<p for="FlgTipoDocumento">Tipo documento:</p>-->
                                        <div class="switch">
                                            <label>
                                                Digital
                                                <input type="checkbox" id="FlgTipoDocumento" name="FlgTipoDocumento" value="0">
                                                <span class="lever"></span>
                                                Físico
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input-field col s12 m10" style="display: none">
                                        <select id="IdTipoServicioFisico" name="IdTipoServicioFisico">
                                        </select>
                                        <label for="IdTipoServicioFisico">Tipo de servicio Fisico</label>
                                    </div>
                                    <div class="col s12">
                                        <a class="btn-primary btn" id="AgregarDetalle">Agregar</a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="TblDetalleSolicitudPrestamo" class="bordered hoverable highlight striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Serie documental</th>
                                                    <th>Descripción</th>
                                                    <!--<th>Serie Documental</th>-->
                                                    <th>Tipo documento</th>
                                                    <th>Servicio</th>
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

            /*function ListarSerieDocumental(idDestino, viIdOficina) {
                let idOficina = 0;
                if (viIdOficina === null || viIdOficina === ''){
                    idOficina = 0;
                } else {
                    idOficina = viIdOficina;
                }
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxSeriesDocumentales.php",
                    method: "POST",
                    data: {idOficina: idOficina, flgVigente: 2},
                    datatype: "json",
                    success: function (data) {
                        data = JSON.parse(data);
                        let destino = $("#"+idDestino);
                        destino.empty();
                        destino.append('<option value="0">SELECCIONE</option>');
                        $.each(data, function( key, value ) {
                            destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        var elem = document.getElementById(idDestino);
                        M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                    }
                });
            }*/

            function ReiniciarValores(){
                //ListarSerieDocumental('IdSerieDocumental', $("#OficinaRequerida").val());
                $("#IdOficinaRequerida").val("");
                ContenidosTipo('IdTipoServicioFisico',29);
                // $('.oficina-busqueda').val(null).trigger('change');
                tblDetalleSolicitudPrestamo.rows().remove().draw();
            };

            function Validar()
            {
                /*if ($("#archivoCentral:checked").length === 0){
                    if ($('#IdOficinaRequerida').val() === ''){
                        $.alert("¡Falta seleccionar oficina requerida!");
                        return false;
                    }
                }*/
                if ($('#IdOficinaRequerida').val() === ''){
                    $.alert("¡Falta seleccionar oficina requerida!");
                    return false;
                }

                let filasDetalle = tblDetalleSolicitudPrestamo.data().length;
                if (filasDetalle === 0){
                    $.alert("¡Falta agregar documentos!");
                    return false;
                }
                return true;
            }

            /*$('.oficina-busqueda').select2({
                placeholder: 'Seleccione y busque',
                minimumInputLength: 3,
                "language": {
                    "noResults": function(){
                        return "<p>No se encontró al destinatario</p>";
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
                    url: 'ajax/ajaxOficinas.php',
                    dataType: 'json',
                    delay: 100,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $('.oficina-busqueda').on('select2:select', function() {
                ListarSerieDocumental('IdSerieDocumental', $("#IdOficinaRequerida").val());
            });*/

            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxOficinas.php',
                method: 'POST',
                data: {esTupa: '0', esPrestamo: '1'},
                datatype: 'json',
                success: function (data) {
                    $("#IdOficinaRequerida").val("");
                    $('#OficinaRequerida').empty().append('<option value="">Seleccione</option>');
                    let documentos = JSON.parse(data);
                    $.each(documentos.data, function (key,value) {
                        $('#OficinaRequerida').append(value);
                    });                    
                    $('#OficinaRequerida').formSelect().trigger("change");
                }
            });

            $('#OficinaRequerida').on('change', function() {
                //ListarSerieDocumental('IdSerieDocumental', $("#OficinaRequerida").val());
                $("#IdOficinaRequerida").val($("#OficinaRequerida").val());
            });

            let tblDetalleSolicitudPrestamo = $('#TblDetalleSolicitudPrestamo').DataTable({
                responsive: true,
                searching: false,
                ordering: false,
                paging: false,
                info: false,
                "drawCallback": function() {
                    let api = this.api();
                    if (api.data().length === 0){
                        $("#TblDetalleSolicitudPrestamo").hide();
                        $("#OficinaRequerida").prop("disabled", false);
                    }else{
                        $("#TblDetalleSolicitudPrestamo").show();
                        $("#OficinaRequerida").prop("disabled", true);
                    }
                    $("#OficinaRequerida").formSelect();
                },
                "language": {
                    "url": "../dist/scripts/datatables-es_ES.json"
                },
                'columns': [
                    { 'data': 'NroExpediente', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                    { 'data': 'DescripcionDocumento', 'autoWidth': true,"width": "30%", 'className': 'text-left' },
                    //{ 'data': 'NombreSerieDocumental', 'autoWidth': true, "width": "40%",'className': 'text-left' },
                    { 'data': 'TipoDocumento', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                    { 'data': 'NombreTipoServicio', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                    {
                        'render': function (data, type, full, meta) {
                            return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-trash-alt"></i></button> ';
                        }, 'className': 'text-center',"width": "20px"
                    },
                ]
            });

            $("#TblDetalleSolicitudPrestamo tbody").on('click', 'button', function () {
                let accion = $(this).attr("data-accion");
                if(accion === 'eliminar'){
                    tblDetalleSolicitudPrestamo.row($(this).parents('tr')).remove().draw(false);
                }
            });

            $("#AgregarDetalle").click(function(){
                let detalle = new Object();
                detalle.DescripcionDocumento = $('#DescripcionDocumento').val();
                detalle.NroExpediente = $('#NroExpediente').val();
                //detalle.IdSerieDocumental = $('#IdSerieDocumental').val();
                //detalle.NombreSerieDocumental = $('#IdSerieDocumental').find(':selected').text();
                detalle.FlgTipoDocumento = $("#FlgTipoDocumento:checked").length;
                if ($("#FlgTipoDocumento:checked").length === 0){
                    detalle.TipoDocumento = 'DIGITAL';
                    detalle.IdTipoServicio = 0;
                    detalle.NombreTipoServicio = 'ESCANEO';
                } else {
                    detalle.TipoDocumento = 'FÍSICO';
                    detalle.IdTipoServicio = $('#IdTipoServicioFisico').val();
                    detalle.NombreTipoServicio = $('#IdTipoServicioFisico').find(':selected').text();
                }


                if (detalle.DescripcionDocumento !== '') {
                    let data = tblDetalleSolicitudPrestamo.data();
                    let estado = true;
                    $.each(data, function (i, item) {
                        if (detalle.DescripcionDocumento == item.DescripcionDocumento) {
                            estado = false;
                        }
                    });
                    if (estado) {
                        $('#NroExpediente').val('');
                        $('#DescripcionDocumento').val('');
                        tblDetalleSolicitudPrestamo.row.add(detalle).draw();
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
                    formData.append("Evento","RegistroSolicitud");
                    let tabla = tblDetalleSolicitudPrestamo.data();
                    $.each(tabla, function (i, item) {
                        $.each(item, function (key,value) {
                            formData.append("DataDetalle[" + i + "]["+key+"]", value);
                        });
                    });
                    ReiniciarValores();
                    getSpinner('Cargando...');
                    $.ajax({
                        url: "registerDoc/RegPrestamoDocumentos.php",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        datatype: "json",
                        success: function () {
                            deleteSpinner();
                            $.alert("¡Solicitud registrada correctamente!");
                            //setTimeout(function () { window.location = "bandejaSolicitudesPrestamosEmitidos.php" }, 1000);
                            //M.toast({html: "¡Solicitud registrada correctamente!"});
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

            $("#FlgTipoDocumento").on("change",function (e) {
                if ($("#FlgTipoDocumento:checked").length === 1){
                    $("#IdTipoServicioFisico").parent().parent().css("display","inline-block")
                } else {
                    $("#IdTipoServicioFisico").parent().parent().css("display","none")
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