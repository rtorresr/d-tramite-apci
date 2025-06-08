<?php
session_start();
$pageTitle = "Información de documento";
$activeItem = "iu_anulacion_documento.php";
$navExtended = false;  


If($_SESSION['CODIGO_TRABAJADOR']!=""){
    include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>        
</head>
<body class="theme-default has-fixed-sidenav" >
    <?php include("includes/menu.php");?>  

    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
                <form id="formBusqueda">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Documento</legend>
                                        <div class="row">                                            
                                            <div class="col s12 m8 input-field">
                                                <select id="idTramite" class="js-data-example-ajax browser-default" name="idTramite"></select>
                                                <label for="idTramite"></label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="button" type="button" class="btn btn-secondary" value="Buscar" id="btnBuscar">
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>                                                                                                       
                        </div>
                    </div>
                </form>
                <form>
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable" id="datosTramite">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Datos</legend>
                                        <div class="row">
                                            <input type="hidden" name="IdTramite" id="IdTramite" value="&nbsp;">
                                            <div class="col s12 m6 input-field">
                                                <input name="cud" type="text" id="cud" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="cud">Número de Cud</label>
                                            </div> 
                                            <div class="col s12 m6 input-field">
                                                <input name="tipoTramite" type="text" id="tipoTramite" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="tipoTramite">Tipo trámite</label>
                                            </div>                                           
                                            <div class="col s12 m6 input-field">
                                                <input name="tipoDocumento" type="text" id="tipoDocumento" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="tipoDocumento">Tipo documento</label>
                                            </div>
                                            <div class="col s12 m6 input-field">                                                            
                                            <input name="numeroDocumento" type="text" id="numeroDocumento" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="numeroDocumento">Número documento</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <input name="asunto" type="text" id="asunto" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="asunto">Asunto</label>
                                            </div>
                                            <div class="col s12 input-field">                                                            
                                                <input name="observacion" type="text" id="observacion" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="observacion">Observación</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="oficinaRegistro" type="text" id="oficinaRegistro" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="oficinaRegistro">Oficina Registro</label>
                                            </div>                                           
                                            <div class="col s12 m6 input-field">
                                                <input name="trabajadorRegistro" type="text" id="trabajadorRegistro" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="trabajadorRegistro">Trabajador Registro</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="fechaRegistro" type="text" id="fechaRegistro" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="fechaRegistro">Fecha Registro</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="numeroVistos" type="text" id="numeroVistos" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="numeroVistos">Número vistos buenos</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="firmado" type="text" id="firmado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="firmado">Firmado</label>
                                            </div>                                           
                                            <div class="col s12 m6 input-field">
                                                <input name="oficinaFirma" type="text" id="oficinaFirma" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="oficinaFirma">Oficina Responsable Firma</label>
                                            </div>                                           
                                            <div class="col s12 m6 input-field">
                                                <input name="trabajadorFirma" type="text" id="trabajadorFirma" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="trabajadorFirma">Trabajador Responsable Firma</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="trabajadorModificacion" type="text" id="trabajadorModificacion" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="trabajadorModificacion">Trabajador Última modificación</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="fechaModificacion" type="text" id="fechaModificacion" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="fechaModificacion">Fecha Última modificación</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="estado" type="text" id="estado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="estado">Estado</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="button" type="button" class="btn btn-secondary" value="&nbsp;" id="btnAccion">
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>                                                                                                       
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable" id="datosProyectado">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Datos Proyectado</legend>
                                        <div class="row">
                                            <input type="hidden" name="IdProyecto" id="IdProyecto" value="&nbsp;">
                                            <div class="col s12 m6 input-field">
                                                <input name="oficinaRegistroProyectado" type="text" id="oficinaRegistroProyectado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="oficinaRegistroProyectado">Oficina Registro</label>
                                            </div>                                           
                                            <div class="col s12 m6 input-field">
                                                <input name="trabajadorRegistroProyectado" type="text" id="trabajadorRegistroProyectado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="trabajadorRegistroProyectado">Trabajador Registro</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <input name="fechaRegistroProyectado" type="text" id="fechaRegistroProyectado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="fechaRegistroProyectado">Fecha Registro</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="trabajadorModificacionProyectado" type="text" id="trabajadorModificacionProyectado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="trabajadorModificacionProyectado">Trabajador Última modificación</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="fechaModificacionProyectado" type="text" id="fechaModificacionProyectado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="fechaModificacionProyectado">Fecha Última modificación</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="estadoProyectado" type="text" id="estadoProyectado" value="&nbsp;" class="FormPropertReg form-control" readonly>
                                                <label for="estadoProyectado">Estado</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="button" type="button" class="btn btn-secondary" value="&nbsp;" id="btnAccionProyectado">
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>                                                                                                       
                        </div>
                    </div>
                </form>                   
        </div>
    </main>

    <div id="modalGeneral" class="modal">
        <div class="modal-header"></div>
        <div class="modal-content"></div>
        <div class="modal-footer"></div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    <script>
        $(function() {
            $("#btnBuscar").trigger("click");
        });

        $("select").on("change",function () {
            $(this).formSelect();
        });

        function LimpiarModal(nombre = "modal"){
            $("#"+nombre+" div").html("");
        }

        $('#idTramite').select2({
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró documento generado.</p>";
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
                url: 'mantenimiento/Documento.php',
                dataType: 'json',
                type: 'POST',
                data: function (params) {
                    var query = {
                        search: params.term,
                        Evento: 'Buscar'
                    }
                    return query;
                },
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $("#btnBuscar").on("click", function (e) {
            $("#datosTramite,#datosProyectado").css("display","none");
            if ($("#idTramite").val() != null){
                $.ajax({
                    cache: false,
                    url: 'mantenimiento/Documento.php',
                    method: 'POST',
                    data: {Evento: "Obtener",IdTramite: $("#idTramite").val()},
                    datatype: 'json',
                    success: function (response) {
                        var data = JSON.parse(response);
                        $.each(data, function(i, item) {
                            $("#"+i).val(item);
                        });
                        $("#datosTramite").css("display","block");
                        if (data.IdProyecto != null) {
                            $("#datosProyectado").css("display","block");
                        }                       
                    }
                });
            }
        });

        $("#btnAccion").on("click", function (e) {
            getSpinner('Cargando ...');
            var accion = $("#btnAccion").val();
            switch (accion){
                case "ANULAR":
                    LimpiarModal("modalGeneral");

                    var headerModal = "<h4>Anulación Documento</h4>";
                    $("#modalGeneral .modal-header").html(headerModal);
                    var contentModal = "<form name='formAnulacion' class='row'>"+
                                            "<div class='col s12 input-field'>"+
                                                "<textarea id='motAnulacion' class='materialize-textarea FormPropertReg'></textarea>"+
                                                "<label for='motAnulacion'>Motivo de anulación</label>"+
                                            "</div>"+
                                        "</form>";
                    $("#modalGeneral .modal-content").html(contentModal);
                    var footerModal = "<a class='modal-close waves-effect btn-flat'>Cancelar</a>"+
                                        "<a id='btnEnviarAnulacion' data-action='anular-documento' class='waves-effect btn-flat'>Anular</a>";
                    $("#modalGeneral .modal-footer").html(footerModal);
                    deleteSpinner();
                    M.Modal.getInstance($("#modalGeneral")).open();                    
                    break;
                
                case "DESANULAR":
                    LimpiarModal("modalGeneral");

                    var headerModal = "<h4>Desanulación Documento</h4>";
                    $("#modalGeneral .modal-header").html(headerModal);
                    var contentModal = "<form name='formDesanulacion' class='row'>"+
                                            "<div class='col s12 input-field'>"+
                                                "<textarea id='motDesanulacion' class='materialize-textarea FormPropertReg'></textarea>"+
                                                "<label for='motDesanulacion'>Motivo de desanulación</label>"+
                                            "</div>"+
                                        "</form>";
                    $("#modalGeneral .modal-content").html(contentModal);
                    var footerModal = "<a class='modal-close waves-effect btn-flat'>Cancelar</a>"+
                                        "<a id='btnEnviarDesanulacion' data-action='desanular-documento' class='waves-effect btn-flat'>Desanular</a>";
                    $("#modalGeneral .modal-footer").html(footerModal);
                    deleteSpinner();
                    M.Modal.getInstance($("#modalGeneral")).open();                    
                    break;
            }
        });

        $("#btnAccionProyectado").on("click", function (e) {
            getSpinner('Cargando ...');
            var accion = $("#btnAccionProyectado").val();
            switch (accion){
                case "RETROTRAER":
                    var idProyecto = $("#IdProyecto").val();
                    var datos = {
                        'Id': idProyecto,
                        'Evento': "Retrotraer"
                    };
                    $.ajax({
                        cache: false,
                        url: 'mantenimiento/Documento.php',
                        method: 'POST',
                        data: datos,
                        datatype: 'json',
                        success: function () {
                            deleteSpinner();
                            M.toast({html: "Proyecto retrotraido correctamente"});
                            $("#btnBuscar").trigger("click");
                        }
                    });                   
                    break;
                
                case "ANULAR":
                    $.ajax({
                        url: "registerDoc/Documentos.php",
                        method: "POST",
                        data: {
                            Evento: 'AnularDocumento',
                            tipo: 'proyecto',
                            codigo: $("#IdProyecto").val()
                        },
                        datatype: "json",
                        success: function () { 
                            deleteSpinner();                                       
                            M.toast({html: "Proyecto Anulado"});
                            $("#btnBuscar").trigger("click");          
                        }
                    });                                      
                    break;
            }
        });

        $("#modalGeneral .modal-footer").on('click', 'a',function () {
            var action = $(this).attr("data-action");
            switch(action){
                case "anular-documento":
                    getSpinner("Cargando...");
                    var idTramite = $("#IdTramite").val();
                    var motAnulacion = $("#motAnulacion").val();
                    var datos = {
                        'Id': idTramite,
                        'Mensaje': motAnulacion,
                        'Evento': "Anular"
                    };
                    $.ajax({
                        cache: false,
                        url: 'mantenimiento/Documento.php',
                        method: 'POST',
                        data: datos,
                        datatype: 'json',
                        success: function () {
                            deleteSpinner();
                            M.toast({html: "Anulado correctamente"});
                            $("#btnBuscar").trigger("click");
                            M.Modal.getInstance($("#modalGeneral")).close();
                        }
                    });
                    break;

                case "desanular-documento":
                    getSpinner("Cargando...");
                    var idTramite = $("#IdTramite").val();
                    var motDesanulacion = $("#motDesanulacion").val();
                    var datos = {
                        'Id': idTramite,
                        'Mensaje': motDesanulacion,
                        'Evento': "Desanular"
                    };
                    $.ajax({
                        cache: false,
                        url: 'mantenimiento/Documento.php',
                        method: 'POST',
                        data: datos,
                        datatype: 'json',
                        success: function () {
                            deleteSpinner();
                            M.toast({html: "Desanulado correctamente"});
                            $("#btnBuscar").trigger("click");
                            M.Modal.getInstance($("#modalGeneral")).close();
                        }
                    });
                    break;
            };
        });
    </script>
    </body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>