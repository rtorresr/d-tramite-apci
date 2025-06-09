<?php
session_start();

$pageTitle = "Bandeja por Regularizar";
$activeItem = "bandeja-de-incompletos.php";
$navExtended = true;

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
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><a id="btnPrimary" style="display: none;" class="btn btn-primary" ><i class="fas fa-check fa-fw left"></i> <span>Completar Requisitos</span></a></li>
                        <li><a id="btnSecondary" style="display: none;" class="btn btn-link" ><i class="fas fa-check fa-fw left"></i> <span>Cargar documento</span></a></li>
                        <li><a id="btnThird" style="display: none;" class="btn btn-primary" ><i class="fas fa-paper-plane fa-fw left"></i> <span>Derivar</span></a></li>
                        <li><a id="btnFourth" style="display: none;" class="btn btn-link" ><i class="fas fa-times fa-fw left"></i> <span>Anular</span></a></li>
                        <li><a id="btnFifth" style="display: none;" class="btn btn-link" ><i class="fas fa-eye fa-fw left"></i> <span>Ver</span></a></li>
                        <li><a id="btnSeventh" style="display: none;" class="btn btn-link" ><i class="fas fa-paperclip fa-fw left"></i> <span>Anexos</span></a></li>
                        <li><a id="btnSixth" style="display: none;" class="btn btn-link" ><i class="fas fa-file-invoice fa-fw left"></i> <span>Hoja Ruta</span></a></li>
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
                                <table class="bordered hoverable highlight striped" id="tblBandejaIncompletos">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>CUD</th>
                                            <th>Documento</th>
                                            <th>TUPA</th>
                                            <th>Remitente</th>
                                            <th>Fecha del documento</th>
                                            <th>Persona de Registro</th>
                                            <th>Fecha de Registro</th>
                                            <th>Plazo</th>
                                            <th>Fecha Fin de Plazo</th>
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

    <div id="modalRequisitosFaltantes" class="modal">
        <div class="modal-header">
            <h4>Completar documento - Requisitos</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a id="btnEnviarRequistos" class="waves-effect waves-green btn-flat">Completar</a>
            <a class="waves-effect waves-green btn-flat modal-close">Cancelar</a>
        </div>
    </div>

    <div id="modalCargarDocumento" class="modal">
        <div class="modal-header">
            <h4>Completar documento - Archivo</h4>
        </div>
        <div class="modal-content">
            <div class="card hoverable transparent">
                <div class="card-body">
                    <div class="row">
                        <div class="col s12">
                            <fieldset>
                                <legend>Archivo Principal</legend>
                                <div class="subir">
                                    <div class="row">
                                        <div class="file-field input-field col s12">
                                            <div id="docPrincipal" class="dropzone" style="width:100%"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <button type="button" class="btn btn-secondary" id="btnSubirDocPrincipal">Subir</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="boxArchivos">
                                    <div class="row" style="padding: 0 15px">
                                        <table id="tblPrincipal" class="bordered hoverable highlight striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Archivo</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <fieldset>
                                <legend>Anexos</legend>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                        <div id="docAnexos" class="dropzone" style="width:100%"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <button type="button" class="btn btn-secondary" id="btnSubirDocAnexos">Subir</button>
                                    </div>
                                </div>
                                <div class="boxArchivos">
                                    <div class="row" style="padding: 0 15px">
                                        <table id="tblAnexos" class="bordered hoverable highlight striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Archivo</th>
                                                    <th></th>
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
        </div>
        <div class="modal-footer">
            <a id="btnCargarDocumento" class="waves-effect waves-green btn-flat">Cargar</a>
            <a id="btnCancelarCargarDocumento" class="waves-effect waves-green btn-flat">Cancelar</a>
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

    <!--div id="modalDerivar" class="modal">
        <div class="modal-header">
            <h4>Derivación del documento</h4>
        </div>
        <div class="modal-content">
            <form name="formDerivar" class="row" id="formDerivar">
                <div id="ofiOne">
                    <div class="col s12 m6 l6 input-field">
                        <select id="OficinaResponsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                            <option value="">Seleccione</option>
                            <?php
                            $sqlOfi = "SELECT iCodOficina, cNomOficina, cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0 AND flgEliminado = 0 ORDER BY cNomOficina ASC";
                            $rsOfi  = sqlsrv_query($cnx,$sqlOfi);
                            while ($RsDep2 = sqlsrv_fetch_array($rsOfi)){
                                echo "<option value=".$RsDep2['iCodOficina']." >".trim($RsDep2['cNomOficina'])." - ".trim($RsDep2["cSiglaOficina"])."</option>";
                            }
                            ?>
                        </select>
                        <label for="OficinaResponsableDer">Oficina</label>
                    </div>
                    <div class="col s12 m6 l6 input-field">
                        <select id="responsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary"></select>
                        <label for="responsableDer">Responsable</label>
                    </div>
                </div>
                <div class="input-field col s12 m5">
                    <select id="IndicacionDer">
                        <?php
                        $rsInd = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Indicaciones where flgEntrada = 1");
                        while ($RsInd = sqlsrv_fetch_array($rsInd)){
                            echo "<option value='".$RsInd['iCodIndicacion']."'>".trim($RsInd['cIndicacion'])."</option>";
                        } ?>
                    </select>
                    <label for="IndicacionDer">Indicación</label>
                </div>
                <div class="input-field col s12 m5">
                    <select id="prioridadDer"  class="size9 FormPropertReg mdb-select colorful-select dropdown-primary">
                        <option value="Alta">Alta</option>
                        <option value="Media" selected>Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                    <label for="prioridadDer">Prioridad</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarDer" class="waves-effect btn-flat">Derivar</a>
        </div>
    </div-->

    <div id="modalDerivar" class="modal">
        <div class="modal-header">
            <h4>Envío del documento</h4>
        </div>
        <div class="modal-content">
            <form name="formDerivar" class="row" id="formDerivar">
                <div class="col s12 m6 l6 input-field">
                    <select id="OficinaResponsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                        <option value="">Seleccione</option>
                        <?php
                        $sqlOfi = "SELECT iCodOficina, cNomOficina, cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0 AND flgEliminado = 0 ORDER BY cNomOficina ASC";
                        $rsOfi  = sqlsrv_query($cnx,$sqlOfi);
                        while ($RsDep2 = sqlsrv_fetch_array($rsOfi)){
                            echo "<option value=".$RsDep2['iCodOficina']." >".trim($RsDep2['cNomOficina'])." - ".trim($RsDep2["cSiglaOficina"])."</option>";
                        }
                        ?>
                    </select>
                    <label for="OficinaResponsableDer">Oficina</label>
                </div>
                <div class="col s12 m6 l6 input-field">
                    <select id="responsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary"></select>
                    <label for="responsableDer">Responsable</label>
                </div>
                <div class="input-field col s12 m5">
                    <select id="IndicacionDer">
                        <?php
                        $rsInd = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Indicaciones");
                        while ($RsInd = sqlsrv_fetch_array($rsInd)){
                            echo "<option value='".$RsInd['iCodIndicacion']."'>".trim($RsInd['cIndicacion'])."</option>";
                        } ?>
                    </select>
                    <label for="IndicacionDer">Indicación</label>
                </div>
                <div class="input-field col s12 m5">
                    <select id="prioridadDer"  class="size9 FormPropertReg mdb-select colorful-select dropdown-primary">
                        <option value="Alta">Alta</option>
                        <option value="Media" selected>Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                    <label for="prioridadDer">Prioridad</label>
                </div>
                <div class="input-field col s12 m2">
                    <select id="cCopiaDer"  class="size9 FormPropertReg mdb-select colorful-select dropdown-primary">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                    <label for="cCopiaDer">Copia</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="obsDerivar" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="obsDerivar">Instrucción Específica</label>
                </div>
                <div class="col s12">
                    <div class="row">
                        <div class="col s4">
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" id="habilitarPlazo">
                                    <span>Con plazo</span>
                                </label>
                            </p>
                        </div>
                        <div class="col s6 input-field" id="fecPlazoDiv" style="display: none;">
                            <input placeholder="dd-mm-aaaa" value="" type="text" id="fecPlazo" name="fecPlazo" class="FormPropertReg form-control datepicker">
                            <label for="fecPlazo">Fecha de Plazo</label>
                        </div>
                    </div>
                </div>
                <div class="col m2">
                    <input name="button" type="button" class="btn btn-secondary" value="Agregar" id="btnAgregarDestinoDerivar">
                </div>

                <table id="TblDestinosDerivar" class="bordered hoverable highlight striped" style="width:100%">
                    <thead>
                    <tr>
                        <th>Oficina</th>
                        <th>Responsable</th>
                        <th>Indicación</th>
                        <th>Prioridad</th>
                        <th>Instrucción Específica</th>
                        <th>Copia</th>
                        <th>Plazo</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
                 <!--MODIFICADO-->
                    <div class="col s6 input-field">
                     <div class="switch">
                        <label>
                             Sin encriptar
                                <input type="checkbox" <?=($_SESSION['flgEncriptacion'] == 1 ? '' : 'disabled')?> id="flgEncriptado" name="flgEncriptado" value="1">
                                 <span class="lever"></span>
                                 Encriptado
                         </label>
                      </div>
                    </div>   
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarDer" class="waves-effect btn-flat">Derivar</a>
        </div>
    </div>

    <div id="modalHojaRuta" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Registro concluido</h4>
        </div>
        <div id="divHojaIngreso" class="modal-content"></div>
        <div class="modal-footer">
            <button type="button" class="modal-print btn-flat" onclick="print('divHojaIngreso','Hoja-de-Ingreso')">Imprimir</button>
            <a class="waves-effect waves-green btn-flat modal-close" >Cerrar</a>
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

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>

    <script src="includes/dropzone.js"></script>
    <script>
        let dataResponable = [];
        $(document).ready(function() {
            $('.modal').modal();

            var tblBandejaIncompletos = $('#tblBandejaIncompletos').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: ''
                    }
                },
                scrollY:"50vh",
                scrollCollapse: true,
                ajax: 'ajaxtablas/ajaxBIncompletos.php',
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaIncompletos_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaIncompletos.rows().deselect();
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
                        'targets' : [2,3,4,6],
                        'orderable' : false
                    },
                    {
                        'targets' : [1,5,7,8,9]
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true},
                    {'data': 'cud', 'autoWidth': true},
                    {'data': 'documento', 'autoWidth': true},
                    {'data': 'esTupa', 'autoWidth': true},
                    {'data': 'remitente', 'autoWidth': true},
                    {'data': 'fechaDocumento', 'autoWidth': true},
                    {'data': 'trabajadorRegistro', 'autoWidth': true},
                    {'data': 'fechaRegistro', 'autoWidth': true},
                    {'data': 'tiempoPlazo', 'autoWidth': true},
                    {'data': 'fechaPlazo', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });
            
            var btnPrimary = $("#btnPrimary");
            var btnSecondary = $("#btnSecondary");
            var btnThird = $("#btnThird");
            var btnFourth = $("#btnFourth");
            var btnFifth = $("#btnFifth");
            var btnSixth = $("#btnSixth");
            var btnSeventh = $("#btnSeventh");

            var actionButtons = [btnPrimary,btnSecondary,btnThird,btnFifth,btnSixth,btnSeventh];
            var supportButtons = [btnFourth];

            tblBandejaIncompletos
                .on( 'select', function ( e, dt, type, indexes ) {
                    var count = tblBandejaIncompletos.rows( { selected: true } ).count();
                    /*INICIO MULTIPLE*/
                    if( tblBandejaIncompletos.rows( dt[0] ).data()[1] == undefined ){
                        
                        let seleccionado = tblBandejaIncompletos.rows( dt[0] ).data()[0];
                        
                        var lists = seleccionados.filter(x => {
                            return x.rowId == seleccionado.rowId;
                        });
    
                        if ( lists.length == 0 ) {
                            seleccionados.push(seleccionado);
                        }

                    } else {
                            let sets = tblBandejaIncompletos.rows( { selected: true } ).data();

                            $.each( sets, function( key, value ) {
                                var lists = seleccionados.filter(x => {
                                    return x.rowId == value.rowId;
                                });
            
                                if ( lists.length == 0 ) {
                                    seleccionados.push(value);
                                }
                            });

                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });

                            $('.actionButtons').show(100);
                    }
                    /*FIN MULTIPLE*/

                    switch (count) {
                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });

                            let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                            if (fila.codEsTupa === 1) {
                                if (fila.requisitosFaltantes === 0) {
                                    btnPrimary.css("display", "none");
                                    if (fila.tienePdf === 0) {
                                        btnFifth.css("display", "none");
                                        btnThird.css("display", "none");
                                        btnSeventh.css("display", "none");
                                    } else {
                                        btnSecondary.css("display", "none");
                                    }
                                } else {
                                    btnSecondary.css("display", "none");
                                    btnThird.css("display", "none");
                                    btnFifth.css("display", "none");
                                    btnSixth.css("display", "none");
                                    btnSeventh.css("display", "none");
                                }
                            } else {
                                btnPrimary.css("display", "none");
                                if (fila.tienePdf === 0) {
                                    btnFifth.css("display", "none");
                                    btnThird.css("display", "none");
                                    btnSeventh.css("display", "none");
                                } else {
                                    btnSecondary.css("display", "none");
                                }
                            }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = tblBandejaIncompletos.rows( indexes ).data().toArray();
                    var count = tblBandejaIncompletos.rows( { selected: true } ).count();

                    switch (count) {
                        case 0:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            break;

                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });

                            let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                            if (fila.codEsTupa === 1) {
                                if (fila.requisitosFaltantes === 0) {
                                    btnPrimary.css("display", "none");
                                    if (fila.tienePdf === 0) {
                                        btnFifth.css("display", "none");
                                        btnThird.css("display", "none");
                                        btnSeventh.css("display", "none");
                                    } else {
                                        btnSecondary.css("display", "none");
                                    }
                                } else {
                                    btnSecondary.css("display", "none");
                                    btnThird.css("display", "none");
                                    btnFifth.css("display", "none");
                                    btnSixth.css("display", "none");
                                    btnSeventh.css("display", "none");
                                }
                            } else {
                                btnPrimary.css("display", "none");
                                if (fila.tienePdf === 0) {
                                    btnFifth.css("display", "none");
                                    btnThird.css("display", "none");
                                    btnSeventh.css("display", "none");
                                } else {
                                    btnSecondary.css("display", "none");
                                }
                            }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            break;
                    }
                });

            btnPrimary.on('click', function(e) {
                e.preventDefault();
                let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    cache: false,
                    url: "requisitosFaltantes.php",
                    method: "POST",
                    data: {iCodTramite : fila.codTramite, iCodTupa: fila.codTupa},
                    datatype: "text",
                    success : function (response) {
                        $('div#modalRequisitosFaltantes div.modal-content').empty().html(response);
                        let elem = document.querySelector('#modalRequisitosFaltantes');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.open();
                    }
                });
            });

            $("#btnEnviarRequistos").on("click", function(e) {
                e.preventDefault();
                let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                let data = $('#formRequisitosFaltante').serializeArray();
                let formData = new FormData();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento","registroRequisitosFaltantes");
                formData.append("iCodTramite",fila.codTramite);
                getSpinner('Guardando datos');
                $.ajax({
                    url: "registerDoc/regMesaPartes.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success: function () {
                        refresh(actionButtons,supportButtons,tblBandejaIncompletos);
                        console.log('Requisitos actualizados correctamente!');
                        deleteSpinner();
                        M.toast({html: 'Datos guardados correctamente!'});
                        let elem = document.querySelector('#modalRequisitosFaltantes');
                        M.Modal.getInstance(elem).close();
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al guardar los requisitos del documento!');
                        deleteSpinner();
                        M.toast({html: "Error al guardar los datos"});
                    }
                });
            });

            btnSecondary.on('click', function(e) {
                e.preventDefault();
                let elem = document.querySelector('#modalCargarDocumento');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.open();
            });

            $("#btnCargarDocumento").on("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                let cantidadDocs = $('#documentoArchivo div.row div.col input').length;
                let queuedFilesPrincipal = $("div#docPrincipal")[0].dropzone.getQueuedFiles().length;
                let queuedFilesAnexos = $("div#docAnexos")[0].dropzone.getQueuedFiles().length;
                if (!(queuedFilesPrincipal == 0 && queuedFilesAnexos == 0)){
                    $.alert('¡Faltan cargar documentos!');
                } else if (tblPrincipal.data().length == 0) {
                    $.alert('¡Faltan documento principal!');
                } else {
                    let formData = new FormData();
                    
                    $.each(tblPrincipal.data(), function(key, el) {
                        formData.append("documentoEntrada[]",el.codigo);
                    });
                    $.each(tblAnexos.data(), function(key, el) {
                        formData.append("documentoEntrada[]",el.codigo);
                    });
                    formData.append("Evento","registroDocumentoPdf");
                    formData.append("iCodTramite",fila.codTramite);
                    getSpinner('Guardando documento');
                    $.ajax({
                        url: "registerDoc/regMesaPartes.php",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        datatype: "json",
                        success: function () {
                            console.log('Documento cargado correctamente!');
                            let elem = document.querySelector('#modalCargarDocumento');
                            M.Modal.getInstance(elem).close();
                            tblPrincipal.clear().draw();
                            tblAnexos.clear().draw();
                            refresh(actionButtons,supportButtons,tblBandejaIncompletos);
                            deleteSpinner();
                            M.toast({html: 'Documento cargado correctamente!'});
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al cargar el documento!');
                            deleteSpinner();
                            M.toast({html: "Error al cargar el documento"});
                        }
                    });
                }
            });

            btnThird.on('click',function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalDerivar');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.open();
            });

            /*$("#btnEnviarDer").on('click',function (e) { AQUI NO ESTA CORREO
                e.preventDefault();
                let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                let formData = new FormData();
                formData.append("Evento", "derivarMesaPartes");
                formData.append("iCodTramite", fila.codTramite);
                formData.append("codEsTupa", fila.codEsTupa);
                formData.append("iCodOficina", $("#OficinaResponsableDer").val());
                formData.append("iCodIndicacion", $("#IndicacionDer").val());
                formData.append("prioridad", $("#prioridadDer").val());
                formData.append("incriptado", $("#flgEncriptado").prop("checked") ? 1 : 0);
                formData.append("correo", dataResponable.cMailTrabajador);
                formData.append("nombreTrabajador", dataResponable.cNombresTrabajador.trim()+", "+dataResponable.cApellidosTrabajador.trim());
                getSpinner('Derivando documento');
                $.ajax({
                    url: "registerDoc/regMesaPartes.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success: function () {
                        refresh(actionButtons, supportButtons, tblBandejaIncompletos);
                        let elem = document.querySelector('#modalDerivar');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        deleteSpinner();
                        M.toast({html: 'Documento derivado correctamente!'});
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al derivar!');
                        deleteSpinner();
                        M.toast({html: "Error al derivar el documento"});
                    }
                });
            });*/

            /*INICIO MULTIPLE**/
            var btnEnviarDer = $("#btnEnviarDer");
            var seleccionados = [];

            btnEnviarDer.on('click', function (e) {
                e.preventDefault();
                let iCodTramite = 0;
                if (tblDestinosDerivar.data().length === 0){
                    $.alert('No tiene ningún destinatario agregado!');
                }else{
                    var values=seleccionados;
                    
                    let movimientos = [];
                    $.each(values, function (index, fila) {
                        movimientos.push(fila.codTramite);
                        iCodTramite = fila.codTramite;
                    });
                    
                    let tablaDer = tblDestinosDerivar.data();
                    let dataTablaDer = [];

                    console.log("dataResponable",dataResponable)

                    $.each(tablaDer, function (i, item) {
                        var dato = item;

                        let cResponsableDer = parseInt(dato.cResponsableDer);
                        let responsable = dataResponable.find(function(resp) {
                            return parseInt(resp.value) === cResponsableDer;
                        });
                        console.log("cResponsableDer",cResponsableDer,responsable)
                        dato.correo = responsable ? responsable.correo : "";

                        

                        // let dataResponableMap = new Map();

                        // dataResponable.forEach(resp => {
                        //     dataResponableMap.set(parseInt(resp.value), resp.correo);
                        // });
                        // console.log("dataResponable",dataResponable)
                        // dato.correo = dataResponableMap.get(cResponsableDer) || "";

                        if (dato.fecPlazo != ""){
                            dato.fecPlazo = dato.fecPlazo.split("-").reverse().join("-");
                        }
                        dataTablaDer.push(dato);
                    });

                    var parametrosDer = {
                        iCodTramite: iCodTramite,
                        iCodMovimiento : movimientos,
                        datos: dataTablaDer,
                        incriptado: $("#flgEncriptado").prop("checked") ? 1 : 0,
                        // destinos: dataResponable,
                        //correo: dataResponable.cMailTrabajador,
                        //nombreTrabajador: dataResponable.cNombresTrabajador.trim()+", "+dataResponable.cApellidosTrabajador.trim()

                    };
                    console.log('datos enviar1');
                    console.log(parametrosDer);
                  
                    //var_dump(arrayParametros);
                  
                    $.ajax({
                        cache: false,
                        url: "pendientesDataMesaParte.php",
                        method: "POST",
                        //data: parametrosDer,
                        data: parametrosDer,
                        datatype: "json",
                        success: function (response) {
                            tblBandejaIncompletos.ajax.reload();
                            M.toast({html: '¡Documento Derivado!'});
                            limpiarSeleccionados();
                            M.Modal.getInstance($("#modalDerivar")).close();
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar!"});
                        }                                     
                    });
                }
            });

            function limpiarSeleccionados() {
                seleccionados = [];
                tblBandejaIncompletos.rows().deselect();
            }
            /*FIN MULTIPLE*/

            btnFourth.on('click', function (e) {
                e.preventDefault();
                $.confirm({
                    columnClass: 'col s8 offset-s2  m6 offset-m3  l4 offset-l4',
                    title: '¿Esta seguro de anular?',
                    icon: 'fa fa-warning',
                    content: '',
                    closeIcon: true,
                    buttons: {
                        Si: function () {
                            getSpinner('Anulando...');
                            var rows_selected = tblBandejaIncompletos.column(0).checkboxes.selected();
                            var values=[];
                            $.each(rows_selected, function (index, rowId) {
                                values.push(tblBandejaIncompletos.rows(rowId).data()[0]);
                            });
                            let codigosTramite = [];
                            $.each(values, function (index, fila) {
                                codigosTramite.push(fila.codTramite);
                            });
                            console.log(values);
                            $.ajax({
                                cache: false,
                                url: "registerDoc/regMesaPartes.php",
                                method: "POST",
                                data: {Evento: "anularMesaPartes", values: codigosTramite},
                                datatype: "json",
                                success: function () {
                                    refresh(actionButtons,supportButtons,tblBandejaIncompletos);
                                    console.log('Documentos anulados correctamente!');
                                    deleteSpinner();
                                    M.toast({html: 'Documentos anulados correctamente!'});
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al anular los documentos!');
                                    M.toast({html: "Error al anular los documentos!"});
                                }
                            });
                        },
                        No: function () {
                            $.alert({
                                title: '¡Cancelado!',
                                content: '',
                                columnClass: 'col s8 offset-s2  m6 offset-m3  l4 offset-l4'
                            });
                        }
                    }
                });
            });

            btnFifth.on('click', function (e) {
                e.preventDefault();
                let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    url: "ajax/obtenerDoc.php",
                    method: "POST",
                    data: {
                        codigo: fila.codTramite
                    },
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
            });

            btnSixth.on('click', function (e) {
                e.preventDefault();
                let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    url: "registerDoc/regMesaPartes.php",
                    method: "POST",
                    data: {
                        codTramite: fila.codTramite,
                        Evento: "consultarHojaRuta"

                    },
                    datatype: "json",
                    success: function (respuesta) {
                        console.log('Obtenido correctamente!');
                        deleteSpinner();
                        let elems = document.querySelector('#modalHojaRuta');
                        let instance = M.Modal.init(elems, {dismissible:false});
                        $('#modalHojaRuta div.modal-content').html(respuesta);
                        instance.open();
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al obtener el documento!');
                        M.toast({html: "Error al obtener el documento"});
                    }
                });
            });

            btnSeventh.on('click', function (e) {
                e.preventDefault();
                let fila = tblBandejaIncompletos.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    cache: false,
                    url: "verAnexo.php",
                    method: "POST",
                    data: {codigo: fila.codTramite, tabla: 't'},
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
                        $('#modalAnexo').modal('open');
                    }
                });
            });
        });

        

        function seleccionar_todo() {
            $('table#tRequisitos input[type=checkbox]').prop('checked', true);
        }

        function deseleccionar_todo() {
            $('table#tRequisitos input[type=checkbox]').prop('checked', false);
        }

        function refresh(actionButtons,supportButtons,tblBandejaIncompletos) {
            $.each( actionButtons, function( key, value ) {
                value.css("display", "none");
            });
            $.each( supportButtons, function( key, value ) {
                value.css("display", "none");
            });
            tblBandejaIncompletos.ajax.reload();
        }

        Dropzone.autoDiscover = false;
        
        $("div#docPrincipal").dropzone({
           url: "ajax/cargarDocEntrada.php",
           paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
           autoProcessQueue: false,
           maxFiles: 1,
           acceptedFiles: ".pdf, .PDF",
           addRemoveLinks: true,
           maxFilesize: 1200, // MB
           uploadMultiple: true,
           parallelUploads: 1,
           dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
           dictInvalidFileType: "Archivo no válido",
           dictMaxFilesExceeded: "Solo 1 archivo son permitido",
           dictCancelUpload: "Cancelar",
           dictRemoveFile: "Remover",
           dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
           dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
           dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",
           accept: function (file, done) {
                let estado = false;
                let data = tblPrincipal.data();
                if(data.length > 0){
                    done("El documento principal ya está agregado");
                    $.alert("El documento principal ya está agregado");
                    this.removeFile(file);
                } else {
                    done();
                }
            },
           init: function () {
               var myDropzone = this;

               $("#btnSubirDocPrincipal").on("click", function(e) {
                   e.preventDefault();
                   e.stopPropagation();
                   let queuedFiles = myDropzone.getQueuedFiles();
                   if (queuedFiles.length > 0) {
                       event.preventDefault();
                       event.stopPropagation();
                       myDropzone.processQueue();
                   }else{
                       $.alert('¡No hay documentos para subir al sistema!');
                   }
               });

               this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    M.toast({html: json.mensaje});
                    $.each(json.data, function (i,fila) {
                        tblPrincipal.row.add(fila).draw();
                    });                   
                    this.removeAllFiles();
               });
           }
       });

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
                        nombreAnexo = '<a href="'+full.nuevo+'" target="_blank">'+full.original+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "95%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped danger" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "5%"
                },
            ]
        });

        $("#tblPrincipal tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            switch(accion){
                case 'eliminar':
                    tblPrincipal.row($(this).parents('tr')).remove().draw(false);
                    break;
            }
        });

       $("div#docAnexos").dropzone({
           url: "ajax/cargarDocEntrada.php",
           paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
           autoProcessQueue: false,
           maxFiles: 10,
           acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .xlsm, .ppt, .pptx, .JPG, .JPEG, .PNG, .PDF, .DOC, .DOCX, .XLS, .XLSX, .XLSM, .PPT, .PPTX",
           addRemoveLinks: true,
           maxFilesize: 1200, // MB
           uploadMultiple: true,
           parallelUploads: 10,
           dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
           dictInvalidFileType: "Archivo no válido",
           dictMaxFilesExceeded: "Solo 1 archivo son permitido",
           dictCancelUpload: "Cancelar",
           dictRemoveFile: "Remover",
           dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
           dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
           dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",
           accept: function (file, done) {
               if (tblPrincipal.data().length > 0) {
                    let estado = false;
                    let data = tblAnexos.data();
                    $.each(data, function (i, item) {
                        if (file.name == item.original) {
                            estado = true;
                        }
                    });
                    if (!estado) {
                        done();
                    } else {
                        done("El anexo ya está agregado");
                        $.alert({
                            title: '¡Documento Repetido!',
                            content: 'El documento ' + file.name + ' ya fue agregado.',
                        });
                        this.removeFile(file);
                    }
               } else {
                    $.alert('¡Falta subir documento principal!');
                    this.removeFile(file);
               }                
            },
           init: function () {
               var myDropzone = this;

               $("#btnSubirDocAnexos").on("click", function(e) {
                   e.preventDefault();
                   e.stopPropagation();
                   let queuedFiles = myDropzone.getQueuedFiles();
                   if (queuedFiles.length > 0) {
                       event.preventDefault();
                       event.stopPropagation();
                       myDropzone.processQueue();
                   }else{
                       $.alert('¡No hay documentos para subir al sistema!');
                   }
               });

               this.on("successmultiple", function(file, response) {
                    let json = $.parseJSON(response);
                    M.toast({html: json.mensaje});
                    $.each(json.data, function (i,fila) {
                        tblAnexos.row.add(fila).draw();
                    });                   
                    this.removeAllFiles();
                });
           }
       });

        var tblAnexos = $('#tblAnexos').DataTable({
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
                        nombreAnexo = '<a href="'+full.nuevo+'" target="_blank" data-id="'+full.codigo+'">'+full.original+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "95%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped danger" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "5%"
                },
            ]
        });

        $("#tblAnexos tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            switch(accion){
                case 'eliminar':
                    tblAnexos.row($(this).parents('tr')).remove().draw(false);
                    break;
            }
        });

       
        $("#FlgSIGCTI").on("change", function (e) {
           if ($(this).prop("checked")){
                $("#nroConstanciaSIGCTI").parent().css("display", "flex");
           } else {
               $("#nroConstanciaSIGCTI").parent().css("display", "none");
           }
        });

        $("#btnCancelarCargarDocumento").on("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            $("div#docPrincipal")[0].dropzone.removeAllFiles();
            $("div#docAnexos")[0].dropzone.removeAllFiles();
            tblPrincipal.clear().draw();
            tblAnexos.clear().draw();
            let elem = document.querySelector('#modalCargarDocumento');
            let instance = M.Modal.init(elem, {dismissible:false});
            instance.close();
        });

        /*$('#OficinaResponsableDer').on('change', function () {
            $('#responsableDer option').remove();

            dataResponable = [];
            codigo = this.value;
            $.ajax({
                cache: false,
                method: 'POST',
                url: 'loadResponsableRIO.php',
                data: {iCodOficinaResponsable : codigo},
                dataType: 'json',
                success: function(list){
                    $.each(list,function(index,value)
                    {
                        let obj = {
                            value: value.iCodTrabajador,
                            text: value.cNombresTrabajador.trim() + ", " + value.cApellidosTrabajador.trim(),
                            correo: value.cMailTrabajador
                        };
                        dataResponable.push(obj);
                        // dataResponable = value;

                        $('#responsableDer').append($('<option>',{
                            value : value.iCodTrabajador,
                            text  : value.cNombresTrabajador.trim()+", "+value.cApellidosTrabajador.trim()
                        }));
                    });
                    console.log(dataResponable);
                    $('#responsableDer').formSelect();
                },
            });

        });*/


    $('#OficinaResponsableDer').on('change', function () {
    $('#responsableDer option').remove();

    //dataResponable = [];
    codigo = this.value;
    
    $.ajax({
        cache: false,
        method: 'POST',
        url: 'loadResponsableRIO.php',
        data: { iCodOficinaResponsable: codigo },
        dataType: 'json',
        success: function (list) {
            $.each(list, function (index, value) {
                let obj = {
                    value: value.iCodTrabajador,
                    text: value.cNombresTrabajador.trim() + ", " + value.cApellidosTrabajador.trim(),
                    correo: value.cMailTrabajador
                };
                dataResponable.push(obj);

                $('#responsableDer').append($('<option>', {
                    value: value.iCodTrabajador,
                    text: value.cNombresTrabajador.trim() + ", " + value.cApellidosTrabajador.trim()
                }));
            });
            console.log(dataResponable);
            $('#responsableDer').formSelect();
        },
        error: function (xhr, status, error) {
            console.error("Error responsables: " + error);
        }
    });
});


        /*INICIO MULTIPLE*/
        Dropzone.autoDiscover = false;
        $("#dropzoneAgrupado").dropzone({
                url: "ajax/cargarDocsAgrupado.php",
                paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
                autoProcessQueue: false,
                maxFiles: 10,
                acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
                addRemoveLinks: true,
                maxFilesize: 1200, // MB
                uploadMultiple: true,
                parallelUploads: 10,
                dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
                dictInvalidFileType: "Archivo no válido",
                dictMaxFilesExceeded: "Solo 10 archivos son permitidos",
                dictCancelUpload: "Cancelar",
                dictRemoveFile: "Remover",
                dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
                dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
                dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",
                accept: function (file, done) {
                    let estado = false;
                    let data = tblAnexos.data();
                    $.each(data, function (i, item) {
                        if (file.name == item.nombreAnexo) {
                            estado = true;
                        }
                    });
                    if (!estado) {
                        done();
                    } else {
                        done("El documento ya está agregado");
                        $.alert("El documento" + file.name +" ya está agregado");
                        this.removeFile(file);
                    }
                },
                init: function () {
                    var myDropzone = this;
                    $("#btnSubirDocsAgrupado").on("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        queuedFiles = myDropzone.getQueuedFiles();
                        if (queuedFiles.length > 0) {
                            event.preventDefault();
                            event.stopPropagation();
                            myDropzone.processQueue();
                        }else{
                            $.alert('¡No hay documentos para subir al sistema!');
                        }
                    });

                    this.on("sendingmultiple", function (file, xhr, formData) {
                        let agrupado = 0;
                        formData.append('agrupado',agrupado);
                    });
                    this.on("successmultiple", function(file, response) {
                        let json = $.parseJSON(response);
                        M.toast({html: json.mensaje});
                        $.each(json.data, function (i,fila) {
                            InsertarAnexo(fila.codigo, fila.original, fila.nuevo);
                        });                   
                        this.removeAllFiles();
                    });
                }
            });

        
            $('#cOficinas').select2({
            width: '100%',
            placeholder: 'Seleccione o busque',
            maximumSelectionLength: 10,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró la oficina.</p><p><a href='#' class='btn btn-link'>¿Desea registrarlo?</a></p>";
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

        var tblDestinosDerivar = $('#TblDestinosDerivar').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblDestinosDerivar").hide();
                }else{
                    $("#TblDestinosDerivar").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'nomOficinaDer', 'autoWidth': true,"width": "25%", 'className': 'text-left' },
                { 'data': 'nomResponsableDer', 'autoWidth': true, "width": "25%",'className': 'text-left' },
                { 'data': 'nIndicacionDer', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'nomPrioridadDer', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'nObservacionDer', 'autoWidth': true, "width": "20%",'className': 'text-left' },
                { 'data': 'nCopiaDer', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'fecPlazo', 'autoWidth': true, "width": "10%",'className': 'text-left' },
               // { 'data': 'resPcorreo', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-outline-secondary" data-placement="top"><i class="fas fa-trash-alt"></i></button> ';
                    }, 'className': 'text-center',"width": "20px"
                },
            ]
        });

        $("#TblDestinosDerivar tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            if(accion === 'eliminar'){
                tblDestinosDerivar.row($(this).parents('tr')).remove().draw(false);
            }
        });

        $("#btnAgregarDestinoDerivar").click(function(){
            var validacion = true;

            if ($("#OficinaResponsableDer option:selected").val() == "" || $("#OficinaResponsableDer option:selected").val() == undefined){
                $.alert("Seleccione una oficina");
                validacion = false;
                return false;
            }

            if ($("#responsableDer option:selected").val() == "" || $("#responsableDer option:selected").val() == undefined){
                $.alert("Seleccione un trabajador");
                validacion = false;
                return false;
            }
           
            if(validacion){
                let destinoDerivar = new Object();
                destinoDerivar.cOficinaDer= $("#OficinaResponsableDer option:selected").val();
                destinoDerivar.nomOficinaDer= $("#OficinaResponsableDer option:selected").text();
                destinoDerivar.cResponsableDer = $("#responsableDer option:selected").val();
                destinoDerivar.nomResponsableDer = $("#responsableDer option:selected").text();
                destinoDerivar.cIndicacionDer = $("#IndicacionDer option:selected").val();
                destinoDerivar.nIndicacionDer = $("#IndicacionDer option:selected").text();
                destinoDerivar.cPrioridadDer = $("#prioridadDer option:selected").val();
                destinoDerivar.nomPrioridadDer = $("#prioridadDer option:selected").text();
                destinoDerivar.nObservacionDer = $("#obsDerivar").val();
                destinoDerivar.cCopiaDer = $("#cCopiaDer option:selected").val();
                destinoDerivar.nCopiaDer = $("#cCopiaDer option:selected").text();
                destinoDerivar.encriptado = $("#flgEncriptado option:selected").val();
                
                //destinoDerivar.correo = $("#correo option:selected").val();
                //destinoDerivar.nombres = $("#cNombresTrabajador option:selected").val();
                if ($("#habilitarPlazo").prop("checked")){
                    destinoDerivar.fecPlazo = $("#fecPlazo").val();
                } else {
                    destinoDerivar.fecPlazo = ""
                }           
                
                 
                 // destinosDerivarArray.push(destinoDerivar);

                //VALIDAR SI YA ESTA INGRESADO
                let data = tblDestinosDerivar.data();
                let estado = false;
                $.each(data, function (i, item) {
                    if (destinoDerivar.cOficinaDer == item.cOficinaDer && destinoDerivar.cResponsableDer == item.cResponsableDer) {
                        estado = true;
                    }
                });
                if (!estado) {
                    tblDestinosDerivar.row.add(destinoDerivar).draw();
                } else {
                    $.alert("El destino ingresado ya está agregado");
                }
            }
        });

        $("#habilitarPlazo").on("click", function(e){
            $("#fecPlazo").val("");
            if ($("#habilitarPlazo").prop("checked")){
                $("#fecPlazoDiv").show();
            } else {
                $("#fecPlazoDiv").hide();                
            }
        });
        /*FIN MULTIPLE*/


    </script>

    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>