<?php
session_start();

$pageTitle = "Bandeja de Solicitudes de Registro de Tipos de Tramites";
$activeItem = "BandejaSolicitudRegistroTipoTramite.php";
$navExtended = true;

$puedeAprobar = false;
if($_SESSION['iCodOficinaLogin'] == 363 && $_SESSION['iCodPerfilLogin'] == 3){
    $puedeAprobar = true;
}

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
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">                        
                        <div class="card-content">
                            <span class="card-title"><h6>Filtros de búsqueda</h6></span>
                            <div class="row">
                                <div class="col s3 input-field">
                                    <select name="idEstado" id="idEstado" class="FormPropertReg form-control"></select>
                                    <label for="idEstado">Estado</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-content">                            
                            <div class="row">
                                <div class="col s12">
                                    <table id="tblSolicitudes" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Nuevo Trámite</th>
                                                <th>Solicitante</th>
                                                <th>Teléfono</th>
                                                <th>Correo</th>
                                                <th>Fecha de Registro</th>
                                                <th>Estado</th>
                                                <th>Última Modificación</th>
                                                <th>Comentarios</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalAprobacion" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4><?=($puedeAprobar ? 'Aprobación' : 'Revisión')?> del Nuevo Tipo de Trámite</h4>
        </div>
        <div class="modal-content">
            <input type="hidden" id="idAprobacion">
            <div class="row">
                <div class="col s12 input-field">
                    <input type="text" id="dataSolicitante" name="dataSolicitante" disabled>
                    <label for="dataSolicitante">Solicitante</label>
                </div>
            </div>
            <div class="row">
                <div class="col s6 input-field">
                    <input type="text" id="dataTelefono" name="dataTelefono" disabled>
                    <label for="dataTelefono">Teléfono</label>
                </div>
                <div class="col s6 input-field">
                    <input type="text" id="dataCorreo" name="dataCorreo" disabled>
                    <label for="dataCorreo">Correo</label>
                </div>
            </div>
            <div class="row">
                <div class="col m12 input-field">
                    <textarea id="dataNuevoTramite" name="dataNuevoTramite"  class="materialize-textarea FormPropertReg " <?=($puedeAprobar ? '' : 'disabled')?> style="height: 100px!important"></textarea>
                    <label for="dataNuevoTramite">Nuevo Trámite</label>
                </div>
            </div>
            <?php if ($puedeAprobar) {?>
                <div class="row">
                    <div class="col m12 input-field">
                        <textarea id="dataComentarios" name="dataComentarios"  class="materialize-textarea FormPropertReg"></textarea>
                        <label for="dataComentarios">Comentarios</label>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-close waves-effect waves-green btn-flat" >Cerrar</button>
            <?php if ($puedeAprobar) {?>
                <a class="waves-effect waves-green btn-flat btn-danger" id="btnRechazar" >Rechazar</a>
                <a class="waves-effect waves-green btn-flat btn-primary" id="btnAprobar" >Aprobar</a>
            <?php } ?>
        </div>
    </div>

    <div id="modalArchivoPrincipal" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Archivo Principal</h4>
        </div>
        <div class="modal-content p-0" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>
</body>

<script>
    var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
    var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
    var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
    var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

    $(document).ready(function() {

        ContenidosTipo("idEstado", 36,99);

        tblSolicitudes = $('#tblSolicitudes').DataTable({
            'processing': false,
            'serverSide': true,
            'pageLength': 10,
            'ajax': {
                url: 'ajax/ajaxRegMpvSolNuevoTramite.php',
                type: 'POST',
                datatype: 'json',
                data: function ( d ) {
                    return $.extend( {}, d, {
                        "Accion": "ListarSolicitudes",
                        "IdEstado": $("#idEstado").val()
                    });
                }
            },
            drawCallback: function( settings ) {
                $(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tblBandejaPendientes_length"]').formSelect();
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
            'columns': [ 
                {'data': 'NombreNuevoTramite', 'width': '15%'},
                {'data': 'NombreSolicitante', 'width': '15%'},
                {'data': 'Telefono', 'width': '8%'},
                {'data': 'Correo', 'width': '10%'},
                {'data': 'FecRegistro', 'width': '10%'},
                {'data': 'DesEstado', 'width': '8%'},
                {
                    'render': function (data, type, full, meta) {
                        return `${full.TrabajadorModifica}<br>
                            <b><strong>${full.FecModifica}</strong></b>`;
                    }, 'width': '10%'
                },
                {'data': 'Comentarios', 'width': '15%'},
                {
                    'render': function (data, type, full, meta) {
                        var html = ``;
                        if(full.IdEstado == 99){
                            html += `<button type="button" data-accion="revisar" data-tooltip="Revisar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Revisar"><i class="fas fa-check"></i></button>`;
                        }

                        html += `<button type="button" data-accion="verArchivo" data-tooltip="Ver Archivo Principal" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="VerArchivo"><i class="fas fa-file-pdf"></i></button>`;

                        return html;
                    }, 'width': '9%'
                }
            ]
        });

        $('#tblSolicitudes tbody').on('click', 'button', function (event) {
                let fila = tblSolicitudes.row($(this).parents('tr'));
                let dataFila = fila.data();
                let accion = $(this).attr("data-accion");
                switch (accion) {
                    case 'revisar':                        
                        $("#dataNuevoTramite").val('');
                        $("#dataSolicitante").val('');
                        $("#dataTelefono").val('');
                        $("#dataCorreo").val('');
                        $("#idAprobacion").val('');
                        
                        $("#dataNuevoTramite").val(dataFila.NombreNuevoTramite).next().addClass('active');
                        $("#dataSolicitante").val(dataFila.NombreSolicitante).next().addClass('active');
                        $("#dataTelefono").val(dataFila.Telefono).next().addClass('active');
                        $("#dataCorreo").val(dataFila.Correo).next().addClass('active');
                        $("#idAprobacion").val(dataFila.IdSolTipoTramite);

                        var elem = document.querySelector('#modalAprobacion');
                        var instance = M.Modal.getInstance(elem);
                        instance.options.dismissible = false;
                        instance.open();                        
                        break;
                    case 'verArchivo':
                        $('#modalArchivoPrincipal').modal('close');
                        $.ajax({
                            url: "ajax/ajaxRegMpvSolNuevoTramite.php",
                            method: "POST",
                                data: {
                                    Accion: "ObternerDocumentoPrincipal",
                                    Codigo: dataFila.IdArchivoPrincipal
                                },
                                datatype: "json",
                                success: function (response) {
                                    $('#modalArchivoPrincipal div.modal-content').html('');
                                    $('#modalArchivoPrincipal div.modal-content').html('<iframe src="' + getPreIframe() + response + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
                                    $('#modalArchivoPrincipal').modal('open');
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al obtener el documento!');
                                    M.toast({html: "Error al obtener el documento"});
                                }
                        });
                        break;
                }
            });

        $("#btnRechazar").on("click", function(e){
            $.confirm({
                title: '¿Esta seguro de rechazar el registro del nuevo tipo de trámite?',
                content: 'Este proceso no se puede deshacer.',
                buttons: {
                    Cancelar: function () {
                        $.alert('Rechazo cancelado');
                    },
                    Si: {
                        text: 'Rechazar',
                        btnClass: 'red',
                        action: function() {
                            getSpinner();

                            var data = {
                                Accion: "RechazarRegistro",
                                Codigo: $("#idAprobacion").val(),
                                Comentarios: $("#dataComentarios").val(),
                                Solicitante: $("#dataSolicitante").val(),
                                Correo: $("#dataCorreo").val(),
                                Tramite: $("#dataNuevoTramite").val(),
                            };

                            $.post("ajax/ajaxRegMpvSolNuevoTramite.php", data)
                                .done(function(response){
                                    tblSolicitudes.ajax.reload();
                                    let elemento = document.querySelector('#modalAprobacion');
                                    M.Modal.getInstance(elemento).close();
                                    deleteSpinner();
                                    M.toast({html: "Solicitud rechazada correctamente"});
                                })
                                .fail(function (e) {
                                    console.log(e);
                                    console.log('Error al rechazar el registro!');
                                    let elemento = document.querySelector('#modalAprobacion');
                                    M.Modal.getInstance(elemento).close();
                                    deleteSpinner();                                    
                                    M.toast({html: "Error al rechazar el registro"});
                                });
                        }
                    }
                }
            });
        });

        $("#btnAprobar").on("click", function(e){
            $.confirm({
                title: '¿Esta seguro de aprobar el registro del nuevo tipo de trámite?',
                content: 'Este proceso no se puede deshacer.',
                buttons: {
                    Cancelar: function () {
                        $.alert('Aprobacion cancelada');
                    },
                    Si: {
                        text: 'Aprobar',
                        btnClass: 'btn-primary',
                        action: function() {
                            getSpinner();

                            var data = {
                                Accion: "AprobarRegistro",
                                Codigo: $("#idAprobacion").val(),
                                Comentarios: $("#dataComentarios").val(),
                                Solicitante: $("#dataSolicitante").val(),
                                Correo: $("#dataCorreo").val(),
                                Tramite: $("#dataNuevoTramite").val(),
                            };

                            $.post("ajax/ajaxRegMpvSolNuevoTramite.php", data)
                                .done(function(response){
                                    tblSolicitudes.ajax.reload();
                                    let elemento = document.querySelector('#modalAprobacion');
                                    M.Modal.getInstance(elemento).close();
                                    deleteSpinner();
                                    M.toast({html: "Solicitud aprobada correctamente"});
                                })
                                .fail(function (e) {
                                    console.log(e);
                                    console.log('Error al aprobar el registro!');
                                    let elemento = document.querySelector('#modalAprobacion');
                                    M.Modal.getInstance(elemento).close();
                                    deleteSpinner();                                    
                                    M.toast({html: "Error al aprobar el registro"});
                                });
                        }
                    }
                }
            });
        });

        $("#idEstado").on("change", function(e){
            tblSolicitudes.ajax.reload();            
        });
    }); 
    
    function ContenidosTipo(idDestino, codigoTipo, defaultSelect = 0, arrayQuitar = []) {
        $.ajax({
            cache: false,
            url: "../views/ajax/ajaxContenidosTipo.php",
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
</script>

</html>
<?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>