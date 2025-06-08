<?php
session_start();
$pageTitle = "Nueva Entidad";
$activeItem = "iu_nueva_entidad.php";
$navExtended = true;


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
    <a name="area"></a>    

    <!--Main layout-->
    <main>
    <div class="navbar-fixed actionButtons">
        <nav>
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="">
                    <li><a id="btnGuardarDatos" class="btn btn-primary"><i class="fas fa-plus fa-fw left"></i><span>Guardar</span></a></li>
                </ul>
            </div>
        </nav>
    </div>
        <div class="container">
                <form>
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable" data-tipo="datos-generales">
                                <div class="card-body">
                                    <fieldset data-tipo="datos-generales">
                                        <legend>Datos Generales</legend>
                                        <div class="row" data-tipo="subnivel" data-nivel="0">
                                            <div class="col s12 m10 input-field">
                                                <select id="idEntidad" class="js-data-example-ajax browser-default" name="idEntidad"></select>
                                                <label for="idEntidad">Nombre de la entidad</label>
                                            </div>
                                            <div class="col s2 m1 input-field">
                                                <a data-action="agregar-entidad" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                            </div>                                            
                                            <div class="col s2 m1 input-field">
                                                <a data-action="agregar-sub-nivel-dependencia" class="btn btn-secondary"><i class="fas fa-arrow-down"></i></a>
                                            </div>                                        
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Responsable</legend>
                                        <div class="row">                                            
                                            <div class="col s12 m6 input-field">
                                                <input name="nombreResponsableEntidad" type="text" id="nombreResponsableEntidad" value="" class="FormPropertReg form-control" disabled>
                                                <label for="nombreResponsableEntidad">Nombre responsable entidad</label>
                                            </div>
                                            <div class="col s12 m6 input-field">
                                                <input name="cargoResponsableEntidad" type="text" id="cargoResponsableEntidad" value="" class="FormPropertReg form-control" disabled>
                                                <label for="cargoResponsableEntidad">Cargo responsable entidad</label>
                                            </div>                                           
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Sedes de la entidad</legend>
                                        <div class="col s12 m12 input-field">
                                            <div class="row">
                                                <div class="col s12">
                                                    <a data-action="agregar-direccion" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12">
                                                    <table id="TblSedes" class="bordered hoverable highlight striped" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Dirección</th>
                                                                <th>Pais</th>
                                                                <th>Departamento</th>
                                                                <th>Provincia</th>
                                                                <th>Distrito</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
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

    <div id="modalGeneral" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header"></div>
        <div class="modal-content" style="text-align: center; overflow: hidden;"></div>
        <div class="modal-footer"></div>
    </div>

    <div id="modalDatosSede" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Datos Sede</h4>
        </div>
        <div class="modal-content">
            <form name="formDatosDespacho" id="formDatosDespacho" >
                <input type="hidden" name="IdProyectoDespacho" id="IdProyectoDespacho" value="0">
                <div class="row">
                    <div class="col s12">
                        <div class="row">
                            <div class="col m10 input-field input-disabled">
                                <input type="text" id="NombreDespacho">
                                <label for="NombreDespacho">Nombre Destinatario</label>
                            </div>

                            <div class="col m2 input-field input-disabled">
                                <input type="text"  id="RucDespacho" name="RucDespacho">
                                <label for="RucDespacho">Ruc</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m6 input-field">
                                <select id="IdTipoEnvio" name="IdTipoEnvio">
                                </select>
                                <label for="IdTipoEnvio">Tipo Envío</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <input type="text" id="ObservacionesDespacho" name="ObservacionesDespacho">
                                <label for="ObservacionesDespacho">Observaciones del despacho</label>
                            </div>
                        </div>
                        <div class="row" id="datosEnvioFisico">
                            <div class="col s12 input-field">
                                <input type="text" id="DireccionDespacho" name="DireccionDespacho">
                                <label for="DireccionDespacho">Dirección</label>
                            </div>
                            <div class="col s12 m4 input-field">
                                <select id="DepartamentoDespacho" name="DepartamentoDespacho">
                                    <option value="">Seleccione</option>
                                    <?php
                                    $rsDepa = sqlsrv_query($cnx, "SELECT cCodDepartamento, cNomDepartamento FROM Tra_U_Departamento ORDER BY cNomDepartamento ASC");
                                    while($RsDepa = sqlsrv_fetch_array($rsDepa)){
                                        ?>
                                        <option value="<?=RTRIM($RsDepa['cCodDepartamento'])?>"><?=RTRIM($RsDepa['cNomDepartamento'])?></option>
                                    <?php } ?>
                                </select>
                                <label for="DepartamentoDespacho">Departamento</label>
                            </div>
                            <div class="col s12 m4 input-field">
                                <select id="ProvinciaDespacho" name="ProvinciaDespacho">
                                </select>
                                <label for="ProvinciaDespacho">Provincia</label>
                            </div>
                            <div class="col s12 m4 input-field">
                                <select id="DistritoDespacho" name="DistritoDespacho">
                                </select>
                                <label for="DistritoDespacho">Distrito</label>
                            </div>
                        </div>
                        <div class="row" id="datosEnvioInteroperabilidad" style="display: none;">
                            <div class="col s12 input-field">
                                <input type="text" id="UnidadOrganicaDstIOT" name="UnidadOrganicaDstIOT">
                                <label for="UnidadOrganicaDstIOT">Unidad Organica Destino</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <input type="text" id="PersonaDstIOT" name="PersonaDstIOT">
                                <label for="PersonaDstIOT">Persona Destino</label>
                            </div>
                            <div class="col s12 m6 input-field">
                                <input type="text" id="CargoPersonaDstIOT" name="CargoPersonaDstIOT">
                                <label for="CargoPersonaDstIOT">Cargo Destino</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a id="btnGuardarDatosDespacho" class="waves-effect waves-green btn-flat">Guardar</a>
        </div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    <script>
        $("select").on("change",function () {
            $(this).formSelect();
        });

        $('#idEntidad').select2({
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró entidad.</p>";
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
                url: 'mantenimiento/Entidad.php',
                dataType: 'json',
                method: 'POST',
                data: function (params) {
                    var query = {
                        search: params.term,
                        Evento: 'BuscarEntidad'
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

        function ObtenerDatosEntidad(id,callfunct) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Entidad.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    callfunct(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ActualizarDatosResponsable(datos) {
            $("#nombreResponsableEntidad").val(datos.ResponsableEntidad).next().addClass('active');;
            $("#cargoResponsableEntidad").val(datos.CargoResponsableEntidad).next().addClass('active');;
        }

        $('#idEntidad').on('select2:select', function (e) {
            ObtenerDatosEntidad($('#idEntidad').val(),ActualizarDatosResponsable);
            TblSedes.rows().remove().draw(false);
            ObtenerSedesEntidad($('#idEntidad').val(),ObtenerDatosSede);
        });

        function ObtenerDatosSede(id) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idSede": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    AgregarSede(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ObtenerSedesEntidad(id,callfunct) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerSedesEntidad", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    for(var i of data){
                        callfunct(i.IdSede);
                    }
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function AgregarSede(datos) {
            let sede = new Object();

            sede.direccionSede = datos.Direccion;
            sede.paisSede = datos.nomPais;
            sede.departamentoSede = datos.nomDepartamento;
            sede.provinciaSede= datos.nomProvincia;
            sede.distritoSede= datos.nomDistrito;
            sede.idSede = datos.IdSede;

            TblSedes.row.add(sede).draw();                                
        }   

        function ObtenerSedesDependencia(id,callfunct) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerSedesDependencia", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    for(var i of data){
                        callfunct(i.IdSede);
                    }
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }  

        function SeleccionarSede(id) {
            TblSedes.$("input[type=checkbox][value="+id+"]").prop("checked",true);                              
        }    

        var TblSedes = $('#TblSedes').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblSedes").hide();
                }else{
                    $("#TblSedes").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                {
                    'render': function (data, type, full, meta) {
                        let sede = '';
                        sede = '<p><label><input type="checkbox" checked="checked" value="'+full.idSede+'"><span></span></label></p>';
                        return sede;
                    }, 'className': 'center-align',"width": "20px"
                },
                { 'data': 'direccionSede', 'autoWidth': true,"width": "10%", 'className': 'text-left' },
                { 'data': 'paisSede', 'autoWidth': true,"width": "10%", 'className': 'text-left' },
                { 'data': 'departamentoSede', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'provinciaSede', 'autoWidth': true, "width": "5%",'className': 'text-left' },
                { 'data': 'distritoSede', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        // let botones = '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-trash-alt"></i></button>'+
                        //                 '<button type="button" data-accion="editar" data-toggle="tooltip" title="Editar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-pencil-alt"></i></button>';
                        // let botones = '<button type="button" data-accion="editar" data-toggle="tooltip" title="Editar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-pencil-alt"></i></button>';
                    let botones='';    
return botones;
                    }, 'className': 'center-align'
                }
            ]
        });

        $("#TblSedes tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            let fila = TblSedes.row($(this).parents('tr'));
            let dataFila = fila.data();
            switch (accion){
                // case 'eliminar':                    
                //     $.ajax({
                //         url: 'mantenimiento/Sede.php',
                //         method: "POST",
                //         datatype: "json",
                //         data: {
                //             'Evento' : 'EliminarSede',
                //             'IdSede' : dataFila.idSede
                //         },
                //         success: function (e) {
                                            
                //         }
                //     });
 
                //     break;

                case 'editar':


                    $.ajax({
                        url: 'mantenimiento/Sede.php',
                        method: "POST",
                        datatype: "json",
                        data: {
                            'Evento' : 'ObternerDatos',
                            'IdSede' : dataFila.idSede
                        },
                        success: function (e) {
                                            
                        }
                    });
                    break;
            }
            if(accion === 'eliminar'){
                TblSedes.row($(this).parents('tr')).remove().draw(false);
            }
        });

        function ContenidosTipo(idDestino, codigoTipo, arrayQuitar = []){
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
                    destino.append('<option value="">Seleccione</option>');
                    let quitarNum = arrayQuitar.length;
                    if (quitarNum == 0){
                        $.each(data, function( key, value ) {
                            destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                    } else {
                        $.each(data, function( key, value ) {
                            if (!arrayQuitar.includes(value.codigo)){
                                destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                            }
                        });
                    }                
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        function AgregarOpcionesSelect(selector,datos,selected=0){
            let destino = $(selector);   
            destino.empty().append('<option value="">Seleccione...</option>');
            if (datos.length != 0){                             
                $.each(datos, function( key, value ) {
                    destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                });                
            }     
            destino.formSelect();       
        }

        function ListarPais(selector, selected = 0) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Pais.php",
                method: "POST",
                data: {Evento: "Listar"},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $(selector);
                    destino.empty().append('<option value="">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                    });
                    destino.formSelect();
                }
            });
        }

        function ListarDepartamento(selector, selected = 0) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Departamento.php",
                method: "POST",
                data: {Evento: "Listar"},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $(selector);
                    destino.empty().append('<option value="">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                    });
                    destino.formSelect();
                }
            });
        }

        function ListarProvincia(selector,departamento,selected = 0) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Provincia.php",
                method: "POST",
                data: {"Evento": "Listar", "Departamento": departamento},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $(selector);
                    destino.empty().append('<option value="">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                    });
                    destino.formSelect();
                }
            });
        }

        function ListarDistrito(selector,departamento,provincia,selected = 0) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Distrito.php",
                method: "POST",
                data: {"Evento": "Listar","Departamento": departamento,"Provincia": provincia},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $(selector);
                    destino.empty().append('<option value="">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                    });
                    destino.formSelect();
                }
            });
        }

        function ListarEntidadesHijas(selector,idEntidadPadre,selected = 0) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Entidad.php",
                method: "POST",
                data: {"Evento": "ListarEntidadesHijas","IdEntidadPadre" : idEntidadPadre},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    AgregarOpcionesSelect(selector,data,selected);                    
                }
            });
        }

        function ValidarFormulario(selector) {
            var flgFalta = false;
            var faltanteNombre = "";

            for(let elemento of document.querySelector(selector).querySelectorAll("[required]")){
                if (elemento.value.trim() == ""){
                    flgFalta = true;
                    faltanteNombre = elemento.closest("div.col").querySelector("label").textContent;
                    break;
                }               
            }  
            return {"flgFalta" : flgFalta, "faltanteNombre": faltanteNombre}
        }

        $("main div.container form").on("click", "a", function (e) {
            let action = $(this).attr("data-action");
            let header = '';
            let content = '';
            let footer = '';
            let elem = document.querySelector('#modalGeneral');
            switch(action){
                case "agregar-entidad":
                    header = '<h4>Registro entidad</h4>';
                    content = '<form>'+
                                    '<div class="row">'+
                                        '<div class="col s6 input-field">'+
                                            '<select id="tipoEntidad" name="tipoEntidad" required><select>'+
                                            '<label for="tipoEntidad">Tipo entidad</label>'+
                                        '</div>'+
                                        '<div class="col s6 input-field">'+
                                            '<input type="text" id="siglaEntidad" name="siglaEntidad" required>'+
                                            '<label for="siglaEntidad">Sigla entidad</label>'+
                                        '</div>'+
                                        '<div class="col s12 input-field">'+
                                            '<input type="text" id="nombreEntidad" name="nombreEntidad" required>'+
                                            '<label for="nombreEntidad">Nombre entidad</label>'+
                                        '</div>'+
                                        '<div class="col s6 input-field">'+
                                            '<select id="tipoDocumento" name="tipoDocumento" required><select>'+
                                            '<label for="tipoDocumento">Tipo de documento</label>'+
                                        '</div>'+
                                        '<div class="col s6 input-field">'+
                                            '<input type="text" id="numeroDocumento" name="numeroDocumento" required>'+
                                            '<label for="numeroDocumento">Numero de documento</label>'+
                                        '</div>'+
                                        '<div class="col s12 input-field">'+
                                            '<input type="text" id="responsableEntidad" name="responsableEntidad" required>'+
                                            '<label for="responsableEntidad">Responsable entidad</label>'+
                                        '</div>'+
                                        '<div class="col s12 input-field">'+
                                            '<input type="text" id="cargoResponsableEntidad" name="cargoResponsableEntidad" required>'+
                                            '<label for="cargoResponsableEntidad">Cargo Responsable entidad</label>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>';
                    footer = '<a data-action="agregar-entidad-nueva" class="waves-effect waves-green btn-flat">Grabar</a>'+
                                '<a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>';

                    $("#modalGeneral div.modal-header").html(header);
                    $("#modalGeneral div.modal-content").html(content);
                    $("#modalGeneral div.modal-footer").html(footer);

                    ContenidosTipo("tipoEntidad",30);
                    ContenidosTipo("tipoDocumento",31);

                    $("#modalGeneral div.modal-content select").formSelect();
                    
                    M.Modal.init(elem, {dismissible:false}).open();
                    break;

                case "agregar-sub-nivel-dependencia":
                    var nivel = $(this).closest("div.row[data-tipo]").attr("data-nivel");  
                    if (nivel == 0){
                        var idEntidadPadre = $("#idEntidad").val();
                    } else {
                        var idEntidadPadre = $("select#dependenciaEntidad"+nivel).val();
                    }
                    
                    if (idEntidadPadre == null || idEntidadPadre == ''){
                        M.toast({html: "¡Falta seleccionar entidad o dependencia padre!"});
                    } else {
                        var nuevoNivel = parseInt(nivel) +1;
                        var html = '<div class="row" data-tipo="subniveldep" data-nivel="'+nuevoNivel+'">'+                              
                                        '<div class="col s12 m5 input-field">'+
                                            '<select id="dependenciaEntidad'+nuevoNivel+'" name="dependenciaEntidad'+nuevoNivel+'"></select>'+
                                            '<label for="dependenciaEntidad'+nuevoNivel+'">Dependencia de la entidad</label>'+
                                        '</div>'+
                                        '<div class="col s2 m1 input-field">'+
                                            '<a data-action="agregar-dependencia" class="btn btn-primary"><i class="fas fa-plus"></i></a>'+
                                        '</div>'+
                                        '<div class="col s2 m1 input-field">'+
                                            '<a data-action="agregar-sub-nivel-dependencia" class="btn btn-secondary"><i class="fas fa-arrow-down"></i></a>'+
                                        '</div>'+                                        
                                    '</div>';
                        $("div.card[data-tipo=datos-generales] fieldset[data-tipo=datos-generales] div.row a[data-action=agregar-sub-nivel-dependencia]").parent().remove();
                        $("div.card[data-tipo=datos-generales] fieldset[data-tipo=datos-generales]").append(html);
                        $("div.card[data-tipo=datos-generales] fieldset[data-tipo=datos-generales] select").formSelect();

                        ListarEntidadesHijas("#dependenciaEntidad"+nuevoNivel,idEntidadPadre);
                    }                    
                    break;
                
                case "agregar-dependencia":
                    var subnivel = $(this).closest("div.row[data-tipo]").attr("data-nivel");
                    if (subnivel == 1){
                        var idEntidadPadre = $("#idEntidad").val();
                    } else {
                        var idEntidadPadre = $("select#dependenciaEntidad"+(parseInt(subnivel)-1)).val();
                    }                    
                    
                    if (idEntidadPadre == null || idEntidadPadre == ''){
                        M.toast({html: "¡Falta seleccionar entidad o dependencia padre!"});
                    } else {
                        header = '<h4>Registro dependencia entidad</h4>';
                        content = '<form>'+
                                        '<input type="hidden" name="idEntidadPadre" value="'+idEntidadPadre+'">'+
                                        '<input type="hidden" name="nivelActual" value="'+parseInt(subnivel)+'">'+    
                                        '<div class="row">'+
                                            '<div class="col s10 input-field">'+
                                                '<input type="text" id="nombreDependenciaEntidad" name="nombreDependenciaEntidad">'+
                                                '<label for="nombreDependenciaEntidad">Nombre dependencia</label>'+
                                            '</div>'+      
                                            '<div class="col s2 input-field">'+
                                                '<input type="text" id="siglaDependenciaEntidad" name="siglaDependenciaEntidad">'+
                                                '<label for="siglaDependenciaEntidad">Sigla</label>'+
                                            '</div>'+  
                                            '<div class="col s12 input-field">'+
                                                '<input type="text" id="nombreResponsableDependenciaEntidad" name="nombreResponsableDependenciaEntidad">'+
                                                '<label for="nombreResponsableDependenciaEntidad">Nombre responsable</label>'+
                                            '</div>'+  
                                            '<div class="col s12 input-field">'+
                                                '<input type="text" id="cargoResponsableDependenciaEntidad" name="cargoResponsableDependenciaEntidad">'+
                                                '<label for="cargoResponsableDependenciaEntidad">Cargo responsable</label>'+
                                            '</div>'+    
                                        '</div>'+
                                    '</form>';
                        footer = '<a data-action="agregar-dependencia-nueva" class="waves-effect waves-green btn-flat">Grabar</a>'+
                                    '<a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>';

                        $("#modalGeneral div.modal-header").html(header);
                        $("#modalGeneral div.modal-content").html(content);
                        $("#modalGeneral div.modal-footer").html(footer);                    
                        
                        M.Modal.init(elem, {dismissible:false}).open();
                    }
                    break;

                case "agregar-direccion":
                    header = '<h4>Registro dirección entidad</h4>';
                    content = '<form>'+
                                        '<div class="row">'+
                                            '<div class="col s3 input-field">'+
                                                '<select id="paisSede" name="paisSede">'+
                                                    '<option value="0">Seleccione ...</option>'+
                                                '<select>'+
                                                '<label for="paisSede">País</label>'+
                                            '</div>'+
                                            '<div class="col s9 input-field">'+
                                                '<input type="text" id="direccionSede" name="direccionSede">'+
                                                '<label for="direccionSede">Dirección</label>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="row">'+
                                            '<div class="col s4 input-field">'+
                                                '<select id="departamentoSede" name="departamentoSede">'+
                                                    '<option value="0">Seleccione ...</option>'+
                                                '<select>'+
                                                '<label for="departamentoSede">Departamento</label>'+
                                            '</div>'+
                                            '<div class="col s4 input-field">'+
                                                '<select id="provinciaSede" name="provinciaSede">'+
                                                    '<option value="0">Seleccione ...</option>'+
                                                '<select>'+
                                                '<label for="provinciaSede">Provincia</label>'+
                                            '</div>'+
                                            '<div class="col s4 input-field">'+
                                                '<select id="distritoSede" name="distritoSede">'+
                                                    '<option value="0">Seleccione ...</option>'+
                                                '<select>'+
                                                '<label for="distritoSede">Distrito</label>'+
                                            '</div>'+
                                        '</div>'+
                                '</form>';
                    footer = '<a data-action="agregar-direccion-nueva" class="waves-effect waves-green btn-flat">Grabar</a>'+
                                '<a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>';

                    $("#modalGeneral div.modal-header").html(header);
                    $("#modalGeneral div.modal-content").html(content);
                    $("#modalGeneral div.modal-footer").html(footer);

                    ListarPais("#paisSede",348);
                    ListarDepartamento("#departamentoSede");

                    $("#modalGeneral div.modal-content select").formSelect();
                    
                    M.Modal.init(elem, {dismissible:false}).open();
                    break;
            }            
        });


        $("#modalGeneral div.modal-content").on("change", "form select", function (e) {
            let id = $(this).attr("id");
            switch(id){
                case "departamentoSede":
                    ListarProvincia("#provinciaSede",$("#departamentoSede").val());
                    break;

                case "provinciaSede":
                    ListarDistrito("#distritoSede",$("#departamentoSede").val(),$("#provinciaSede").val());
                    break;
            }
        });

        $("#modalGeneral div.modal-footer").on("click", "a", function (e) {
            let action = $(this).attr("data-action");
            let elem = document.querySelector('#modalGeneral');            
            switch(action){
                case "agregar-entidad-nueva":
                    var validacion = ValidarFormulario("#modalGeneral div.modal-content form");
                    if (validacion.flgFalta){
                        M.toast({html: "¡Falta "+validacion.faltanteNombre+"!"});
                    }else {
                        var datosEntidad = new Object();

                        $.each($('#modalGeneral div.modal-content form').serializeArray(), function() {
                            datosEntidad[this.name] = this.value;
                        });

                        $.ajax({
                            cache: false,
                            url: 'mantenimiento/Entidad.php',
                            method: 'POST',
                            data: {"Evento": "AgregarEntidad", "Datos": datosEntidad},
                            success: function (response) {
                                response = JSON.parse(response);
                                var data = {
                                    id: response.id,
                                    text: response.text
                                };

                                var nuevaOpcion = new Option(data.text, data.id, false, false);
                                $('#idEntidad').append(nuevaOpcion).trigger('change');
                                M.Modal.init(elem, {dismissible:false}).close();
                                M.toast({html: "¡Agregado correctamente!"});
                            }
                        }); 
                    }                           
                    break;

                case "agregar-dependencia-nueva":
                    var validacion = ValidarFormulario("#modalGeneral div.modal-content form");
                    if (validacion.flgFalta){
                        M.toast({html: "¡Falta "+validacion.faltanteNombre+"!"});
                    }else {
                        var datosEntidad = new Object();

                        $.each($('#modalGeneral div.modal-content form').serializeArray(), function() {
                            datosEntidad[this.name] = this.value;
                        });

                        $.ajax({
                            cache: false,
                            url: 'mantenimiento/Entidad.php',
                            method: 'POST',
                            data: {"Evento": "AgregarDependencia", "Datos": datosEntidad},
                            success: function (response) {
                                data = JSON.parse(response);
                                ListarEntidadesHijas("#dependenciaEntidad"+datosEntidad.nivelActual,datosEntidad.idEntidadPadre,data.id);
                                ObtenerDatosEntidad(data.id,ActualizarDatosResponsable);
                                M.Modal.init(elem, {dismissible:false}).close();
                                M.toast({html: "¡Agregado correctamente!"});                                
                            }
                        }); 
                    }      
                    break;

                case "agregar-direccion-nueva":
                    var validacion = ValidarFormulario("#modalGeneral div.modal-content form");
                    var idEntidad = $("#idEntidad").val();
                    if (validacion.flgFalta){
                        M.toast({html: "¡Falta "+validacion.faltanteNombre+"!"});
                    } else if (idEntidad == '' || idEntidad == null){ 
                        M.toast({html: "¡Falta entidad o dependencia!"});
                    }else {
                        var datosSede = new Object();

                        $.each($('#modalGeneral div.modal-content form').serializeArray(), function() {
                            datosSede[this.name] = this.value;
                        });                        

                        $.ajax({
                            cache: false,
                            url: 'mantenimiento/Sede.php',
                            method: 'POST',
                            data: {"Evento": "AgregarSede", "Datos": datosSede, "idEntidad": idEntidad},
                            success: function (response) {
                                response = JSON.parse(response);
                                ObtenerDatosSede(response.id,AgregarSede);
                                M.Modal.init(elem, {dismissible:false}).close();
                            }
                        }); 
                    }   
                    
                    break;
            }
        });

        $("main div.container form fieldset[data-tipo=datos-generales]").on("change", "div.row[data-tipo=subniveldep] select", function (e) {
            var subnivel = $(this).closest("div.row[data-tipo]").attr("data-nivel");
            if (subnivel == 1){
                var idEntidadPadre = $("#idEntidad").val();
                if (idEntidadPadre == null || idEntidadPadre == ''){
                    M.toast({html: "¡Falta seleccionar entidad o dependencia padre!"});
                } else {
                    if ($(this).val().trim() != ''){
                        ObtenerDatosEntidad($(this).val(),ActualizarDatosResponsable);
                        TblSedes.rows().remove().draw(false);
                        ObtenerSedesEntidad(idEntidadPadre,ObtenerDatosSede);
                        TblSedes.$('input').removeAttr( 'checked' );
                        ObtenerSedesDependencia($(this).val(),SeleccionarSede);
                    }              
                }
            } else {
                var idEntidadPadre = $("select#dependenciaEntidad"+(subnivel-1)).val();
                if (idEntidadPadre == null || idEntidadPadre == ''){
                    M.toast({html: "¡Falta seleccionar entidad o dependencia padre!"});
                } else {
                    if ($(this).val().trim() != ''){
                        ObtenerDatosEntidad($(this).val(),ActualizarDatosResponsable);
                        TblSedes.rows().remove().draw(false);
                        ObtenerSedesDependencia(idEntidadPadre,ObtenerDatosSede);
                        TblSedes.$('input').removeAttr( 'checked' );
                        ObtenerSedesDependencia($(this).val(),SeleccionarSede);
                    }              
                }
            }           
        });

        $("#btnGuardarDatos").on("click", function (e) {
            var validacion = ValidarFormulario("main div.container form");
            if (validacion.flgFalta){
                M.toast({html: "¡Falta "+validacion.faltanteNombre+"!"});
            }else {
                var nivelActual = $("div.card[data-tipo=datos-generales] fieldset[data-tipo=datos-generales] div.row[data-nivel]").length -1;
                if (nivelActual == 0){
                    var idEntidadPadre = $("#idEntidad").val();
                } else {
                    var idEntidadPadre = $("select#dependenciaEntidad"+nivelActual).val();
                }
                let datos = new FormData();
                datos.append("Evento", "RelacionarSedes");
                datos.append("idEntidad", idEntidadPadre);

                $("#TblSedes input[type=checkbox]:checked").each(function(index,elem) {
                    datos.append("DataSedeRelacion[" + index + "]",$(elem).val());
                });

                $.ajax({
                    cache: false,
                    url: 'mantenimiento/Sede.php',
                    processData: false,
                    contentType: false,
                    method: 'POST',
                    data: datos,
                    success: function (response) {
                        
                        M.toast({html: "¡Datos guardados correctamente!"});
                    }
                });
            }             
        });
    </script>
    </body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
