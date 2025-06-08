<?php
session_start();
include_once("../conexion/parametros.php");
$pageTitle = "Revisión Mesa de Partes";
$activeItem = "RevisionMpv.php";
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
    <a name="area"></a>
    <main>
        <?php if ($_POST['Transaccion'] != 4) { ?> 
            <div class="navbar-fixed actionButtons">
                <nav>
                    <div class="nav-wrapper">
                        <ul id="nav-mobile" class="">
                            <li><a class="btn btn-primary" id="btnRegistrar" ><i class="fas fa-save fa-fw left"></i>Registrar</a></li>
                            <li><a class="btn btn-link" id="btnObservar" ><i class="fas fa-tasks"></i>&nbsp;Observar</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        <?php } ?> 
        <div class="container">
            <form name="frmRegistro" id="frmRegistro" method="post" enctype="multipart/form-data">
                <input type="hidden" id="IdMesaPartesVirtual" value="<?=$_POST["Id"]?>">
                <input type="hidden" id="Transaccion" value="<?=$_POST["Transaccion"]?>">
                <div class="row">
                    <div class="col s12 m9">
                        <div class="card hoverable">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Datos del documento</legend>
                                    <div class="row">
                                        <input type="hidden" id="IdCodSigcti" name="IdCodSigcti" class="materialize-textarea FormPropertReg">
                                        <div class="col m4 input-field">
                                            <input type="text" id="NroSigcti" name="NroSigcti" class="materialize-textarea FormPropertReg" disabled>
                                            <label for="NroSigcti" class="active">Nro Solicitud SIGCTI</label>
                                        </div>                                    
                                    </div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <div class="switch">
                                                <label>
                                                    Trámite sin tupa
                                                    <input type="checkbox" id="nFlgClaseDoc" name="nFlgClaseDoc" value="1" disabled>
                                                    <span class="lever"></span>
                                                    Trámite con tupa
                                                </label>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row">
                                        <div class="col m3 input-field">                                            
                                            <select class="form-control" id="cCodTipoDoc" name="cCodTipoDoc">
                                                <option value="">Seleccione</option>
                                                <?php
                                                include_once("../conexion/conexion.php");
                                                $sqlTipo="SELECT cCodTipoDoc,cDescTipoDoc FROM Tra_M_Tipo_Documento WITH(NOLOCK) WHERE nFlgEntrada= 1 ORDER BY cDescTipoDoc ASC";
                                                $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                    echo "<option value=".trim($RsTipo["cCodTipoDoc"]).">".trim($RsTipo["cDescTipoDoc"])."</option>";
                                                }
                                                sqlsrv_free_stmt($rsTipo);
                                                ?>
                                            </select>
                                            <label for="cCodTipoDoc">Tipo de Documento</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="cNroDocumento" name="cNroDocumento" class="materialize-textarea FormPropertReg">
                                            <label for="cNroDocumento" class="active">N° de Documento</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="fechaDocumento" name="fechaDocumento" class="FormPropertReg formSelect datepicker" disabled>
                                            <label for="fechaDocumento" class="active">Fecha del Documento</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="fecRegistro" name="fecRegistro" class="materialize-textarea FormPropertReg" disabled>
                                            <label class="active" for="fecRegistro">Fecha de Registro</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m12 input-field">
                                            <textarea id="cAsunto" name="cAsunto"  class="materialize-textarea FormPropertReg" disabled></textarea>
                                            <label for="cAsunto" class="active">Asunto</label>
                                        </div>
                                        <!-- <div class="col m6 input-field">
                                            <textarea id="cObservaciones" name="cObservaciones"  class="materialize-textarea FormPropertReg"></textarea>
                                            <label for="cObservaciones" class="active">Observaciones</label>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col s4 m4 input-field">
                                            <input type="text" id="cudIngresado" name="cudIngresado" class="materialize-textarea FormPropertReg">
                                            <label class="active">CUD</label>
                                        </div>
                                        <div class="col s2 m2 input-field">
                                            <input type="number" id="nNumFolio" min="1" name="nNumFolio" value="1" class="FormPropertReg">
                                            <label class="active">Folios</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset id="datosTupa">
                                    <!-- <legend>Datos del TUPA</legend> -->
                                    <div class="row">
                                        <div class="col m12 input-field">
                                            
                                            <select class="form-control" id="iCodTupaClase" name="iCodTupaClase" disabled>
                                                <option value="5">Procedimientos y Trámites administrativos</option>
                                                <option value="4">Otros trámites</option>
                                            </select>
                                            <label for="iCodTupaClase">Nuevos trámites</label>
                                        </div>
                                        <div class="col m12 input-field">                                            
                                            <select class="form-control" id="iCodTupa" name="iCodTupa">
                                                <option value="">Seleccione</option>
                                            </select>
                                            <label for="iCodTupa">Trámite</label>
                                        </div>
                                        <div id="divRequisitos" style="display: none;" class="col m12">
                                            <label>Requisitos</label>
                                            <div>
                                                <table cellpadding="0" cellspacing="2" border="0"  class="table" id="tRequisitos">
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Datos del Remitente</legend>
                                    <div class="row">
                                        <div class="col s12" id="areaRemitente">
                                            <div class="row">
                                                <div class="col s4 input-field">
                                                    <input type="text" id="desTipoEntidad" name="desTipoEntidad" class="FormPropertReg formSelect datepicker" disabled>
                                                    <label for="desTipoEntidad">Tipo Entidad:</label>
                                                </div>
                                                <div class="col s4 input-field">
                                                    <input type="text" id="desTipoDocEntidad" name="desTipoDocEntidad" class="FormPropertReg formSelect datepicker" disabled>
                                                    <label for="desTipoDocEntidad">Tipo Documento Identificación</label>
                                                </div>
                                                <div class="col s4 input-field">
                                                    <input type="text" id="nroDocEntidad" name="nroDocEntidad" class="FormPropertReg formSelect datepicker" disabled>
                                                    <label for="nroDocEntidad">Nro Documento Identificación</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col s12 input-field">
                                                    <input type="text" id="iCodRemitente" name="iCodRemitente" class="FormPropertReg formSelect datepicker" disabled>
                                                    <label for="iCodRemitente">Remitente / Institución:</label>
                                                </div>
                                                <div class="col m12 input-field">
                                                    <input type="text" id="cNomRemitente" name="cNomRemitente" class="FormPropertReg formSelect datepicker" disabled>
                                                    <label for="cNomRemitente">Responsable</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Datos de Contacto</legend>
                                    <div class="row">
                                        <div class="col s12" id="areaRemitente">
                                            <div class="row">
                                                <div class="col s6 input-field">
                                                    <input type="text" id="desCorreo" name="desCorreo" class="FormPropertReg formSelect datepicker" disabled>
                                                    <label for="desCorreo">Correo:</label>
                                                </div>
                                                <div class="col s6 input-field">
                                                    <input type="text" id="desTelefono" name="desTelefono" class="FormPropertReg formSelect datepicker" disabled>
                                                    <label for="desTelefono">Teléfono</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Archivo Principal</legend>
                                    <div class="boxArchivos">
                                        <div class="row" style="padding: 0 15px">
                                            <table id="tblPrincipal" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Archivo</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Anexos</legend>
                                    <div class="boxArchivos">
                                        <div class="row" style="padding: 0 15px">
                                            <table id="tblAnexos" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Archivo</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </main>

    <div id="modalConcluido" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Registro concluido</h4>
        </div>
        <div id="divHojaIngreso" class="modal-content"></div>
        <div class="modal-footer">
            <button type="button" class="modal-print btn-flat" onclick="print('divHojaIngreso','Hoja-de-Ingreso')">Imprimir</button>
            <a class="waves-effect waves-green btn-flat" id="btnConcluido" >Cerrar</a>
        </div>
    </div>

    <div id="modalObservacion" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Registro de Observación</h4>
        </div>
        <div id="contentObservación" class="modal-content">
            <div class="row">
                <div class="col m12 input-field">
                    <textarea id="textoObservacion" name="textoObservacion"  class="materialize-textarea FormPropertReg" rows="3"></textarea>
                    <label for="textoObservacion" class="active">Observación</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-close waves-effect waves-green btn-flat" >Cerrar</button>
            <a class="waves-effect waves-green btn-flat btn-primary" id="btnEnviarObservacion" >Enviar</a>
        </div>
    </div>

    <div id="modalRegistro" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Registro de expediente</h4>
        </div>
        <div id="contentObservación" class="modal-content">
            <div class="row">
                <div class="col s12 input-field">
                    <textarea id="textoComentario" name="textoComentario"  class="materialize-textarea FormPropertReg" rows="3"></textarea>
                    <label for="textoComentario" class="active">Comentario</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="modal-close waves-effect waves-green btn-flat" >Cerrar</button>
            <a class="waves-effect waves-green btn-flat btn-primary" id="btnRegistroExpediente" >Registrar</a>
        </div>
    </div>

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>

<script src="../conexion/global.js"></script>
<script>
    $(function() {
        $.post("ajax/ajaxRegMpv.php", {Accion: "Recuperar", IdMesaPartesVirtual: $("#IdMesaPartesVirtual").val()})
            .done(function(response){
                var datos = $.parseJSON(response);

                $("#IdCodSigcti").val(datos.IdCodSigcti);
                $("#NroSigcti").val(datos.NroSigcti).next().addClass('active');

                var valorTupaClase = datos.IdTipoProcedimiento;
                if(valorTupaClase == 1 || valorTupaClase == 3){
                    valorTupaClase = 5;
                    $('#iCodTupa').prop("disabled",true);
                }

                $('#iCodTupaClase option[value="'+valorTupaClase+'"]').prop('selected',true);
                $('#iCodTupaClase').formSelect();
                CargarTUPAs(datos.IdTupa);

                if(datos.FlgEsTupa == 1){
                    $("#nFlgClaseDoc").prop("checked", true);
                    CargarRequisitos(datos.IdTupa);
                } else {
                    $("#nFlgClaseDoc").prop("checked", false)                    
                }
                // $("#nFlgClaseDoc").trigger("change");
                
                $("#cCodTipoDoc").val(datos.IdTipoDoc).next().addClass('active');
                $('#cCodTipoDoc').formSelect();                

                $("#cNroDocumento").val(datos.NumeroDoc).next().addClass('active');
                $("#fechaDocumento").val(datos.FecDocumento).next().addClass('active');
                $("#fecRegistro").val(datos.FecRegistro).next().addClass('active');
                $("#cAsunto").val(datos.Asunto).next().addClass('active');
                if (datos.FlgTieneCud == 1){
                    $("#cudIngresado").val(datos.NroCud + "-"+ datos.AnioCud).next().addClass('active');
                }        
                $("#nNumFolio").val(datos.NumFolios).next().addClass('active');

                $("#iCodRemitente").val(datos.NombreEntidad).next().addClass('active');
                $("#cNomRemitente").val(datos.NombreResponsable).next().addClass('active');
                $("#desTipoEntidad").val(datos.DesTipoEntidad).next().addClass('active');
                $("#desTipoDocEntidad").val(datos.DesTipoDocEntidad).next().addClass('active');
                $("#nroDocEntidad").val(datos.NumeroDocEntidad).next().addClass('active');

                $("#desCorreo").val(datos.CorreoContacto).next().addClass('active');
                $("#desTelefono").val(datos.TelefonoContacto).next().addClass('active');

                $.each(datos.Archivos, function (i,fila) {
                    if(fila.IdTipoArchivo == 5){
                        tblPrincipal.row.add(fila).draw();
                    } 
                    if(fila.IdTipoArchivo == 3){
                        tblAnexos.row.add(fila).draw();
                    }                    
                });
            });
    });

    function CargarTUPAs(selectValue = ''){        
        getSpinner();
        let valor = $('#iCodTupaClase').val();
        $.ajax({
            async: false,
            cache: false,
            url: "ajax/ajaxTupasMPV.php",
            method: "POST",
            data: {iCodTupaClase: valor},
            datatype: "json",
            success: function (response) {                    
                $.each(JSON.parse(response), function( index, value ) {
                    $('#iCodTupa').append(value);
                });
                if (typeof selectValue != "object"){
                    $('#iCodTupa option[value="'+selectValue+'"]').prop('selected',true);
                }
                $('#iCodTupa').formSelect();
            }
        });        
        deleteSpinner();
    }

    // $('#nFlgClaseDoc').change(function() {
    //     if(this.checked) {
    //         $('#datosTupa').css('display','block');
    //     }else{
    //         $('#datosTupa').css('display','none');
    //     }
    // });

    function CargarRequisitos(id, seleccionarTodos = false){
        let valor = id;
        $.ajax({
            async: false,
            cache: false,
            url: "ajax/ajaxRequisitos.php",
            method: "POST",
            data: {iCodTupa: valor},
            datatype: "json",
            success: function (response) {
                $('table#tRequisitos').empty();
                response = JSON.parse(response);
                $.each(response.datos, function( index, value ) {
                    $('table#tRequisitos').append(value);
                });
                $("#divRequisitos").css("display", "block");
                $('table#tRequisitos input[type=checkbox]').prop('checked', true);
            }
        });
    }

    var tblPrincipal = $('#tblPrincipal').DataTable({
        responsive: true,
        searching: false,
        ordering: false,
        paging: false,
        info: false,
        "drawCallback": function() {
            let api = this.api();
            if (api.data().length === 0){
                $("#tblPrincipal").parents("div.boxArchivos").hide();
                $("#tblPrincipal").parents("fieldset").find("div.subir").show();
            }else{
                $("#tblPrincipal").parents("div.boxArchivos").show();
                $("#tblPrincipal").parents("fieldset").find("div.subir").hide();
            }
        },
        "language": {
            "url": "../dist/scripts/datatables-es_ES.json"
        },
        'columns': [
            {
                'render': function (data, type, full, meta) {
                    let nombreAnexo = '';
                    nombreAnexo = '<a href="'+url_srv + full.Ruta+'" target="_blank">'+full.NombreArchivo+'</a>';
                    return nombreAnexo;
                }, 'className': 'center-align',"width": "95%"
            }
        ]
    });

    tblAnexos = $('#tblAnexos').DataTable({
        responsive: true,
        searching: false,
        ordering: false,
        paging: false,
        info: false,
        "drawCallback": function() {
            let api = this.api();
            if (api.data().length === 0){
                $("#tblAnexos").parents("div.boxArchivos").hide();
            }else{
                $("#tblAnexos").parents("div.boxArchivos").show();
            }
        },
        "language": {
            "url": "../dist/scripts/datatables-es_ES.json"
        },
        'columns': [
            {
                'render': function (data, type, full, meta) {
                    let nombreAnexo = '';
                    nombreAnexo = '<a href="'+ url_srv + full.Ruta+'" target="_blank">'+full.NombreArchivo+'</a>';
                    return nombreAnexo;
                }, 'className': 'center-align',"width": "95%"
            }
        ]
    });
    
    $("#btnRegistrar").on("click", function(e){
        $("#textoComentario").val("");
        let elems = document.querySelector('#modalRegistro');
        let instance = M.Modal.init(elems, {dismissible:false});
        instance.open();
    });

    $("#btnRegistroExpediente").on("click", function(e){
        getSpinner('Registrando documento');
        $.post("ajax/ajaxRegMpv.php", 
            {
                Accion: "RegistrarTramite", 
                IdMesaPartesVirtual: $("#IdMesaPartesVirtual").val(),
                Correo: $("#desCorreo").val(),
                NombreResponsable: $("#cNomRemitente").val(),
                codInscripcionSIGCTI: $("#IdCodSigcti").val(),
                folio: $("#nNumFolio").val(),
                cud: $("#cudIngresado").val(),
                comentario: $("#textoComentario").val(),
                idTupa: $("#iCodTupa").val(),
                idTipoDoc: $("#cCodTipoDoc").val(),
                numeroDoc: $("#cNroDocumento").val()
            })
            .done(function(response){
                var response = JSON.parse(response);
                if (response.success){
                    let elemRegistrado = document.querySelector('#modalRegistro');
                    let instanceRegistrado = M.Modal.init(elemRegistrado, {dismissible:false});
                    instanceRegistrado.close();
                    deleteSpinner();
                    M.toast({html: 'Registrado el correctamente!'});
                    let elems = document.querySelector('#modalConcluido');
                    let instance = M.Modal.init(elems, {dismissible:false});
                    $('#modalConcluido div.modal-content').html(response.data);
                    instance.open();
                } else {
                    deleteSpinner();
                    M.toast({html: response.mensaje});
                }                
            })
            .fail(function(response){
                M.toast({html: 'Error al registrar el documento!'});
                deleteSpinner();
            });
    });

    $('#btnConcluido').on('click',function (e) {
        e.preventDefault();
        setTimeout(function(){ window.location = "BandejaRecibidosMpv.php"; },500);
    });

    $("#btnObservar").on("click", function(e){
        $("#textoObservacion").val("");
        let elems = document.querySelector('#modalObservacion');
        let instance = M.Modal.init(elems, {dismissible:false});
        instance.open();
    });

    $("#btnEnviarObservacion").on("click", function(e){
        getSpinner('Enviando observación');
        $.post("ajax/ajaxRegMpv.php", 
            {
                Accion: "EnviarObservación", 
                IdMesaPartesVirtual: $("#IdMesaPartesVirtual").val(),
                Correo: $("#desCorreo").val(),
                NombreResponsable: $("#cNomRemitente").val(),
                Observacion: $("#textoObservacion").val()
            })
            .done(function(response){
                deleteSpinner();
                M.toast({html: 'Observación enviada correctamente!'});
                setTimeout(function(){ window.location = "BandejaRecibidosMpv.php"; },500);              
            })
            .fail(function(response){
                M.toast({html: 'Error al enviar la observación!'});
                deleteSpinner();
            });
    });
</script>
</body>
</html>
<?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>