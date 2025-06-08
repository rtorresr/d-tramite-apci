<?php
session_start();
$pageTitle = "Bandeja de Despacho";
$activeItem = "bandeja-para-despacho.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){
    $url = "https://app.apci.gob.pe/ApiPide/token";
    $data = array(
        "UserName" =>  "8/user_dtramite",
        "Password" =>   "123456",
        "grant_type" => "password"
    );

    $client = curl_init();
    curl_setopt($client, CURLOPT_URL, $url);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
    $respuestaToken = curl_exec($client);
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
                        <li><a id="btnDespachar" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Despachar</span></a></li>
                        <li><a id="btnArchivar"  style="display: none" class="btn btn-link"><i class="fas fa-archive fa-fw left"></i><span>Archivar</span></a></li>

                        <li><a id="btnDetail" style="display: none" class="btn btn-link"><i class="fas fa-info fa-fw left"></i><span>Detalle</span></a></li>
                        <li><a id="btnFlow" style="display: none" class="btn btn-link"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                        <li><a id="btnDoc" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>
                        <li><a id="btnAnexos" style="display: none" class="btn btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                        <li><a id="btnCargo" style="display: none" class="btn btn-link" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Cargo</span></a></li>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">

                            <table id="tblBandejaParaDespacho" class="hoverable highlight striped" style="width: 100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>CUD</th>
                                    <th>Documento</th>
                                    <th>Asunto</th>
                                    <th>Fecha de Envío</th>
                                    <th>Indicación</th>
                                    <th>Estado</th>
                                    <th>Instrucción Específica</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalDespacho" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Datos del despacho</h4>
        </div>
        <div class="modal-content">
            <form name="formDatosDespacho" id="formDatosDespacho" >
                <input type="hidden" value="0" name="CodTramite" id="CodTramite">
                <input type="hidden" value="0" name="CodDestinatario" id="CodDestinatario">
                <input type="hidden" value="0" name="CodMovimiento" id="CodMovimiento">
                <div class="row">
                    <div class="col m8 input-field input-disabled">
                        <input type="text" id="NombreDestinatario" name="NombreDestinatario">
                        <label for="NombreDestinatario">Nombre Destinatario</label>
                    </div>
                    <div class="col m2 input-field input-disabled">
                        <input type="text"  id="SiglasDestinatario" name="SiglasDestinatario">
                        <label for="SiglasDestinatario">Siglas</label>
                    </div>
                    <div class="col m2 input-field input-disabled">
                        <input type="text"  id="RucDestinario" name="RucDestinario">
                        <label for="RucDestinario">Ruc</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col m6 input-field">
                        <select id="IdTipoEnvio" name="IdTipoEnvio">
                        </select>
                        <label for="IdTipoEnvio">Tipo Envío</label>
                    </div>
                    <div class="col m6 input-field">
                        <select id="FlgReenvio" name="FlgReenvio">
                            <option value="0" selected>No</option>
                            <option value="1">Si</option>
                        </select>
                        <label for="FlgReenvio">¿Reenvío?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 input-field">
                        <input type="text" id="ObservacionesDespacho" name="ObservacionesDespacho">
                        <label for="ObservacionesDespacho">Observaciones del despacho</label>
                    </div>
                </div>
                <div class="row" id="datosEnvioFisico">
                    <div class="col s12 input-field">
                        <input type="text" id="DireccionDestinatario" name="DireccionDestinatario">
                        <label for="DireccionDestinatario">Dirección</label>
                    </div>
                    <div class="col m4 input-field">
                        <select id="DepartamentoDestinatario" name="DepartamentoDestinatario">
                            <option value="">Seleccione</option>
                            <?php
                            $rsDepa = sqlsrv_query($cnx, "SELECT cCodDepartamento, cNomDepartamento FROM Tra_U_Departamento ORDER BY cNomDepartamento ASC");
                            while($RsDepa = sqlsrv_fetch_array($rsDepa)){
                                ?>
                                <option value="<?=RTRIM($RsDepa['cCodDepartamento'])?>"><?=RTRIM($RsDepa['cNomDepartamento'])?></option>
                            <?php } ?>
                        </select>
                        <label for="DepartamentoDestinatario">Departamento</label>
                    </div>
                    <div class="col m4 input-field">
                        <select id="ProvinciaDestinatario" name="ProvinciaDestinatario">
                        </select>
                        <label for="ProvinciaDestinatario">Provincia</label>
                    </div>
                    <div class="col m4 input-field">
                        <select id="DistritoDestinatario" name="DistritoDestinatario">
                        </select>
                        <label for="DistritoDestinatario">Distrito</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a id="btnEnviarDespacho" class="waves-effect waves-green btn-flat">Enviar</a>
            <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>

    <div id="modalArchivar" class="modal">
        <div class="modal-header">
            <h4>Archivar documentos</h4>
        </div>
        <div class="modal-content">
            <form name="formArchivar" class="row">
                <div class="col s12 input-field">
                    <textarea id="motArchivar" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="motArchivar">Motivo de archivo</label>
                </div>
                <div class="col s12">
                    <div class="card hoverable transparent">
                        <div class="card-body">
                            <fieldset>
                                <legend>Adjuntos</legend>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                        <div id="dropzoneAgrupadoArchivar" class="dropzone"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12" style="padding-bottom: 0.75rem">
                                        <button type="button" class="btn btn-secondary" id="btnSubirDocsAgrupadoArchivar">Subir</button>
                                    </div>
                                </div>
                                <div id="anexosDocArchivar" style="display: block">
                                    <p style="padding: 0 15px">Seleccione los anexos:</p>
                                    <div class="row" style="padding: 0 15px">
                                        <div class="col s12">
                                            <table id="TblAnexosArchivar" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Archivo</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarArchivar" class="waves-effect btn-flat">Archivar</a>
        </div>
    </div>

    <div id="modalDetalle" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Detalle del documento</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalFlujo" class="modal modal-fixed-header modal-fixed-footer">
        <div class="modal-header">
            <h4>Flujo del trámite</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalDoc" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Documento</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
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

    <div id="modalCargo" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Cargo</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
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
        Dropzone.autoDiscover = false;
        //var responseToken = <?//=$respuestaToken?>;
        $('#IdTipoEnvio').on('change', function (e) {
            if ($('#IdTipoEnvio').val() === '20' || $('#IdTipoEnvio').val() === '72') {
                $('#datosEnvioFisico').css('display','none');
            } else {
                $('#datosEnvioFisico').css('display','block');
            }
        });

        $('#DepartamentoDestinatario').on('change',function (e) {
            e.preventDefault();
            if ($('#DepartamentoDestinatario').val() !== ''){
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxProvincias.php",
                    method: "POST",
                    data: {codDepa : $('#DepartamentoDestinatario').val()},
                    datatype: "json",
                    success: function (data) {
                        data = JSON.parse(data);
                        $('#ProvinciaDestinatario').empty().append('<option value="">Seleccione</option>');
                        $.each( data.info, function( key, value ) {
                            $('#ProvinciaDestinatario').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        var elempro = document.getElementById('ProvinciaDestinatario');
                        M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
                        $('#DistritoDestinatario').empty();
                        var elempro = document.getElementById('DistritoDestinatario');
                        M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
                    }
                });
            }
        });

        $('#ProvinciaDestinatario').on('change',function (e) {
            e.preventDefault();
            if ($('#ProvinciaDestinatario').val() !== '' && $('#DepartamentoDestinatario').val() !== ''){
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxDistritos.php",
                    method: "POST",
                    data: {codDepa : $('#DepartamentoDestinatario').val(), codPro: $('#ProvinciaDestinatario').val()},
                    datatype: "json",
                    success: function (data) {
                        data = JSON.parse(data);
                        $('#DistritoDestinatario').empty().append('<option value="">Seleccione</option>');
                        $.each( data.info, function( key, value ) {
                            $('#DistritoDestinatario').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        var elemdis = document.getElementById('DistritoDestinatario');
                        M.FormSelect.init(elemdis, {dropdownOptions: {container: document.body}});
                        //$('#cDistrito').formSelect();
                    }
                });
            }
        });

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

        $(document).ready(function() {
            $('.actionButtons').hide();

            var tblBandejaParaDespacho = $('#tblBandejaParaDespacho').DataTable({
                responsive: true,
                ajax: 'ajaxtablas/ajaxBdParaDespacho.php',
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaParaDespacho_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaParaDespacho.rows().deselect();
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
                        'targets': [1],
                        'orderable': false
                    },
                    {
                        "width": "25%",
                        "targets": [4],
                        'orderable': false
                    },
                    {
                        "width": "40px",
                        "targets": [1],
                        'orderable': false
                    },
                    {
                        "width": "12%",
                        "targets": [3,5],
                        'orderable': false
                    },
                    {
                        "width": "10px",
                        "targets": [2]
                    },
                    {
                        "width": "65px",
                        "targets": [6, 7]
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true}
                    ,{
                        //'data': 'cud',
                        'render': function (data, type, full, meta) {
                            //console.log(full)
                            let iconos = '';

                            if (full.prioridad.trim() === 'Alta') {
                                //$(row).css('background-color','red')
                                iconos += '<i class="fas fa-fw fa-flag" style="color: red; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            } else if (full.prioridad.trim() === 'Media') {
                                //$(row).css('background-color','green')
                                iconos += '<i class="far fa-fw fa-flag" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            } else {
                                //$(row).css('background-color','orange')
                                iconos += '<i class="far fa-fw fa-flag" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }

                            if (full.adjuntos !== 0) {
                                //iconos += '<span class="number">A-'+full.adjuntos+'</span>';
                                iconos += '<i class="fas fa-fw fa-paperclip"style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }else{
                                iconos += '<i class="fas fa-fw fa-paperclip" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                            }

                            if (full.copia !== 0) {
                                //iconos += '<span class="number">Copia</span>';
                                iconos += '<i class="fas fa-fw fa-closed-captioning" style="font-size: 16px; padding: 6px 0 0 0"></i>';
                            }else{
                                iconos += '<i class="fas fa-fw fa-closed-captioning" style="opacity: 0.1; font-size: 16px; padding: 6px 0 0 0"></i>';

                            }

                            /*if (full.proyectos !== 0) {
                                iconos += '<span class="number">P-'+full.proyectos+'</span>';
                            }*/

                            return iconos
                        },
                    }
                    ,{'data': 'cud', 'autoWidth': true}
                    ,{'data': 'documento', 'autoWidth': true}
                    ,{'data': 'asunto', 'autoWidth': true}
                    ,{'data': 'fechaEnvio', 'autoWidth': true}
                    ,{'data': 'nomIndicacion', 'autoWidth': true}
                    ,{'data': 'estado', 'autoWidth': true}
                    ,{'data': 'instruccion', 'autoWidth': true}
                ],
                'select': {
                    'style': 'multi'
                }
            });

            var btnDespachar = $("#btnDespachar");
            var btnArchivar = $("#btnArchivar");

            var btnDetail = $("#btnDetail");
            var btnFlow = $("#btnFlow");
            var btnDoc = $("#btnDoc");
            var btnAnexos = $("#btnAnexos");
            var btnCargo = $("#btnCargo");

            var actionButtons = [];
            var supportButtons = [btnDespachar, btnArchivar, btnDetail, btnFlow, btnDoc, btnAnexos, btnCargo];

            tblBandejaParaDespacho
                .on( 'select', function ( e, dt, type, indexes ) {
                    let count = tblBandejaParaDespacho.rows( { selected: true } ).count();
                    switch (count) {
                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $('.actionButtons').show();

                            let fila = tblBandejaParaDespacho.rows( { selected: true } ).data().toArray()[0];
                            if (fila.idEstado === '11') {
                                btnArchivar.css("display","none");
                            }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    let count = tblBandejaParaDespacho.rows( { selected: true } ).count();
                    switch (count) {
                        case 0:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            $('.actionButtons').hide(100);
                            break;

                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });

                            let fila = tblBandejaParaDespacho.rows( { selected: true } ).data().toArray()[0];
                            if (fila.idEstado === '11') {
                                btnArchivar.css("display","none");
                            }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display","inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display","none");
                            });
                            break;
                    }
                });

            btnDespachar.on('click', function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalDespacho');
                let instance = M.Modal.init(elem, {dismissible:false});
                let rows_selected = tblBandejaParaDespacho.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaParaDespacho.rows(rowId).data()[0]);
                });
                let CodigoRemitente = 0;
                let CodigoTramite = 0;
                let CodigoMovimiento = 0;
                let nomTipDocumento = '';
                $.each(values, function (index, fila) {
                    CodigoRemitente = fila.codDestino;
                    CodigoTramite = fila.codigo;
                    CodigoMovimiento = fila.mov;
                    nomTipDocumento = fila.nomTipDocumento;
                });

                $("#ObservacionesDespacho").val('');
                ContenidosTipo('IdTipoEnvio','12');
                $('#datosEnvioFisico').css('display','block');

                $.ajax({
                    cache: false,
                    url: "ajax/ajaxDatosRemitente.php",
                    method: "POST",
                    data: {iCodRemitente : CodigoRemitente},
                    datatype: "json",
                    success : function(response) {
                        response = JSON.parse(response);
                        if (response.cRuc != null){
                            $.ajax({
                                url: "https://app.apci.gob.pe/ApiInteroperabilidad/Api/Interoperabilidad/Entidad/SSO_GET_0003?vrucent="+ response.cRuc,
                                method: "POST",
                                datatype: "application/json",
                                success: function (data) {
                                    if (data.MessageResult != '-1'){
                                        $.ajax({
                                            url: "https://app.apci.gob.pe/ApiInteroperabilidad/Api/Interoperabilidad/tramite/SSO_GET_0001",
                                            method: "GET",
                                            datatype: "application/json",
                                            success: function (datos) {
                                                let permite = false;
                                                $.each(datos.ListResult, function (i,value) {
                                                    if (nomTipDocumento.trim().toUpperCase() == value.vnomtipdoctraField) {
                                                        permite = true;
                                                    }
                                                });
                                                if (!permite){
                                                    $("#IdTipoEnvio").find("option[value='72']").remove();
                                                    $("#IdTipoEnvio").formSelect();
                                                }
                                            }
                                        });
                                    } else {
                                        $("#IdTipoEnvio").find("option[value='72']").remove();
                                        $("#IdTipoEnvio").formSelect();
                                    }
                                }
                            });
                        } else {
                            $("#IdTipoEnvio").find("option[value='72']").remove();
                            $("#IdTipoEnvio").formSelect();
                        }

                        $('form#formDatosDespacho input[name="CodTramite"]').val(CodigoTramite);
                        $('form#formDatosDespacho input[name="CodDestinatario"]').val(CodigoRemitente);
                        $('form#formDatosDespacho input[name="CodMovimiento"]').val(CodigoMovimiento);
                        $('form#formDatosDespacho input[name="NombreDestinatario"]').val(response.cNombre).next().addClass('active');
                        $('form#formDatosDespacho input[name="SiglasDestinatario"]').val(response.cSiglaRemitente).next().addClass('active');
                        $('form#formDatosDespacho input[name="RucDestinario"]').val(response.cRuc).next().addClass('active');
                        $('form#formDatosDespacho input[name="DireccionDestinatario"]').val(response.cDireccion).next().addClass('active');

                        if(response.cDepartamento !== '' && response.cDepartamento !== null){
                            $('form#formDatosDespacho select[name="DepartamentoDestinatario"] option[value="'+response.cDepartamento+'"]').prop('selected',true);
                            var elemdep = document.getElementById('DepartamentoDestinatario');
                            M.FormSelect.init(elemdep, {dropdownOptions:{container:document.body}});
                            //$('select[name="cDepartamento"]').formSelect();

                            if (response.cProvincia !== '' && response.cProvincia !== null) {
                                $.ajax({
                                    cache: false,
                                    url: "ajax/ajaxProvincias.php",
                                    method: "POST",
                                    data: {codDepa : response.cDepartamento},
                                    datatype: "json",
                                    success: function (dataP) {
                                        dataP = JSON.parse(dataP);
                                        if(dataP.tiene = 1) {
                                            $('form#formDatosDespacho #ProvinciaDestinatario').empty().append('<option value="">Seleccione</option>');
                                            $.each(dataP.info, function (key, value) {
                                                $('form#formDatosDespacho #ProvinciaDestinatario').append('<option value="' + value.codigo + '">' + value.nombre + '</option>');
                                            });
                                            $('form#formDatosDespacho #ProvinciaDestinatario option[value=' + response.cProvincia + ']').prop('selected', true);
                                            var elempro = document.getElementById('ProvinciaDestinatario');
                                            M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
                                            //$('#cProvincia').formSelect();

                                            if (response.cDistrito !== '' && response.cDistrito !== null) {
                                                $.ajax({
                                                    cache: false,
                                                    url: "ajax/ajaxDistritos.php",
                                                    method: "POST",
                                                    data: {codDepa :response.cDepartamento, codPro: response.cProvincia},
                                                    datatype: "json",
                                                    success: function (dataD) {
                                                        dataD = JSON.parse(dataD);
                                                        if(dataD.tiene = 1) {
                                                            $('form#formDatosDespacho #DistritoDestinatario').empty().append('<option value="">Seleccione</option>');
                                                            $.each(dataD.info, function (key, value) {
                                                                $('form#formDatosDespacho #DistritoDestinatario').append('<option value="' + value.codigo + '">' + value.nombre + '</option>');
                                                            });
                                                            $('form#formDatosDespacho #DistritoDestinatario option[value=' + response.cDistrito + ']').prop('selected', true);
                                                            var elemdis = document.getElementById('DistritoDestinatario');
                                                            M.FormSelect.init(elemdis, {dropdownOptions: {container: document.body}});
                                                            //$('#cDistrito').formSelect();
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            }
                        }
                        instance.open();
                    }
                });
            });

            $("#btnEnviarDespacho").on('click', function (e) {
                e.preventDefault();

                if ($('#IdTipoEnvio').val() !== '20' && $('#IdTipoEnvio').val() !== '72') {
                    if ($("#DireccionDestinatario").val() === '') {
                        $.alert("Falta ingresar dirección!");
                        return false;
                    }
                    if ($("#DepartamentoDestinatario").val() === '') {
                        $.alert("Falta seleccionar departamento!");
                        return false;
                    }
                    if ($("#ProvinciaDestinatario").val() === '') {
                        $.alert("Falta seleccionar provincia!");
                        return false;
                    }
                    if ($("#DistritoDestinatario").val() === '') {
                        $.alert("Falta seleccionar distrito!");
                        return false;
                    }
                }

                var formData = new FormData();
                $.each($('#formDatosDespacho').serializeArray(), function() {
                    formData.append(this.name, this.value);
                });

                $.ajax({
                    cache: false,
                    url: 'ajax/ajaxInsertarDespacho.php',
                    method: 'POST',
                    data: formData,
                    datatype: 'text',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        tblBandejaParaDespacho.ajax.reload();
                        let elem = document.querySelector('#modalDespacho');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        if ($("#IdTipoEnvio").val() == 20){
                            $.alert("¡Documento despachado electronicamente, se archivo correctamente!");
                        } else {
                            $.alert("¡Documento enviado a mesa de partes correctamente!");
                        }
                        //M.toast({html: '¡Enviado correctamente!'});
                    }
                });
            });

            // Detail button
            btnDetail.on('click', function(e) {
                var elems = document.querySelector('#modalDetalle');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                let rows_selected = tblBandejaParaDespacho.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaParaDespacho.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                $.ajax({
                    cache: false,
                    url: "registroDetalles.php",
                    method: "POST",
                    data: {iCodMovimiento : movimientos},
                    datatype: "json",
                    success : function(response) {
                        $('#modalDetalle div.modal-content').html(response);
                        instance.open();
                    }
                });
            });

            // flow button
            btnFlow.on('click', function(e) {
                var elems = document.querySelector('#modalFlujo');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                let rows_selected = tblBandejaParaDespacho.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaParaDespacho.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                if(values[0] <= 18997){
                    var documentophp = "flujodoc_old.php"
                } else{
                    var documentophp = "flujodoc.php"
                }
                $.ajax({
                    cache: false,
                    url: documentophp,
                    method: "POST",
                    data: {iCodMovimiento : movimientos},
                    datatype: "json",
                    success : function(response) {
                        $('#modalFlujo div.modal-content').html(response);
                        instance.open();
                    }
                });
            });

            // Doc. button
            btnDoc.on('click', function(e) {
                var elems = document.querySelector('#modalDoc');
                var instance = M.Modal.getInstance(elems);
                e.preventDefault();
                let rows_selected = tblBandejaParaDespacho.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaParaDespacho.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                $.ajax({
                    cache: false,
                    url: "verDoc.php",
                    method: "POST",
                    data: {iCodMovimiento: movimientos, tabla: 't'},
                    datatype: "json",
                    success: function (response) {

                        var json = eval('(' + response + ')');
                        if (json['estado'] == 1) {
                            $('#modalDoc div.modal-content iframe').attr('src', json['url']);
                            instance.open();
                        }else {
                            M.toast({html: '¡No contiene documento asociado!'});
                        }
                    }
                });
            });

            btnAnexos.on('click', function(e) {
                e.preventDefault();
                let rows_selected = tblBandejaParaDespacho.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaParaDespacho.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                $.ajax({
                    cache: false,
                    url: "verAnexo.php",
                    method: "POST",
                    data: {iCodMovimiento: movimientos[0]},
                    datatype: "json",
                    success: function (response) {

                        $('#modalAnexo div.modal-content ul').html('');
                        var json = eval('(' + response + ')');

                        if(json.tieneAnexos == '1') {
                            let cont = 1;
                            json.anexos.forEach(function (elemento) {
                                $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                                cont++;
                            })
                        }else{
                            $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                        }
                    }
                });

            });

            btnCargo.on('click', function (e) {
                e.preventDefault();
                let rows_selected = tblBandejaParaDespacho.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaParaDespacho.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                $.ajax({
                    cache: false,
                    url: "ajax/ajaxVerCargo.php",
                    method: "POST",
                    data: {iCodMovimiento: movimientos},
                    datatype: "json",
                    success: function (response) {
                        let json = $.parseJSON(response);
                        if (json['estado'] === 1) {
                            $('#modalCargo div.modal-content iframe').attr('src', json['url']);
                            let elem = document.querySelector('#modalCargo');
                            let instance = M.Modal.init(elem, {dismissible:false});
                            instance.open();
                        }else {
                            M.toast({html: '¡No contiene cargo asociado!'});
                        }
                    }
                });
            });

            $("#btnArchivar").on("click", function (e) {
                e.preventDefault();
                $("#motArchivar").val('');
                tblAnexosArchivar.rows().remove().draw(false);
                M.Modal.getInstance($("#modalArchivar")).open();
            });

            $("#btnEnviarArchivar").on('click', function(e) {
                e.preventDefault();
                let rows_selected = tblBandejaParaDespacho.column(0).checkboxes.selected();
                let values=[];
                $.each(rows_selected, function (index, rowId) {
                    values.push(tblBandejaParaDespacho.rows(rowId).data()[0]);
                });
                let movimientos = [];
                $.each(values, function (index, fila) {
                    movimientos.push(fila.mov);
                });
                var anexosAdjuntos = '';
                $.each(tblAnexosArchivar.data(), function (index, fila) {
                    anexosAdjuntos += fila.codigoAnexo +'|';
                });

                parametros = {
                    opcion : 3,
                    iCodMovimiento : movimientos,
                    cObservacionesFinalizar : $('#motArchivar').val(),
                    anexos : (anexosAdjuntos != '' ? anexosAdjuntos.slice(0, -1) : '')
                };
                $.ajax({
                    cache: false,
                    url: "pendientesData.php",
                    method: "POST",
                    data: parametros,
                    datatype: "json",
                    success : function (response) {
                        if (response == 1) {
                            tblBandejaParaDespacho.ajax.reload();
                            if (values.length > 1) {
                                M.toast({html: '¡Documentos Archivados!'});
                            } else {
                                M.toast({html: '¡Documento Archivado!'});
                            }
                        } else {
                            console.log(response);
                            M.toast({html: '¡Error al Archivar!'});
                        }
                    }
                });
                M.Modal.getInstance($("#modalArchivar")).close();
            });

            var tblAnexosArchivar = $('#TblAnexosArchivar').DataTable({
                responsive: true,
                searching: false,
                ordering: false,
                paging: false,
                info: false,
                "drawCallback": function() {
                    let api = this.api();
                    if (api.data().length === 0){
                        $("#TblAnexosArchivar").hide();
                        $('#anexosDocArchivar').css('display', 'none');
                    }else{
                        $("#TblAnexosArchivar").show();
                        $('#anexosDocArchivar').css('display', 'block');
                    }
                },
                "language": {
                    "url": "../dist/scripts/datatables-es_ES.json"
                },
                'columns': [
                    {
                        'render': function (data, type, full, meta) {
                            let nombreAnexo = '';
                            nombreAnexo = '<a href="'+full.rutaAnexo+'" target="_blank">'+full.nombreAnexo+'</a>';
                            return nombreAnexo;
                        }, 'className': 'center-align',"width": "85%"
                    },
                    {
                        'render': function (data, type, full, meta) {
                            return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped danger" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                        }, 'className': 'center-align',"width": "5%"
                    },
                ]
            });

            $("#TblAnexosArchivar tbody")
                .on('click', 'button', function () {
                    let accion = $(this).attr("data-accion");
                    if(accion === 'eliminar'){
                        tblAnexosArchivar.row($(this).parents('tr')).remove().draw(false);
                    }
                })

            function InsertarAnexoArchivar(codigo, nombre, ruta, imprimible = true) {
                let anexo = new Object();
                anexo.codigoAnexo = codigo;
                anexo.nombreAnexo = nombre;
                anexo.rutaAnexo = ruta;

                let estado = false;
                let data = tblAnexosArchivar.data();
                $.each(data, function (i, item) {
                    if (nombre == item.nombreAnexo) {
                        estado = true;
                    }
                });

                if (!estado) {
                    tblAnexosArchivar.row.add(anexo).draw();
                    if (imprimible === false){
                        $("input[value='"+codigo+"'][data-accion='imprimir']").prop("checked", false);
                    }
                } else {
                    console.log("El anexo ya está agregado");
                }
            }
            
            $("#dropzoneAgrupadoArchivar").dropzone({
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
                    let data = tblAnexosArchivar.data();
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
                    $("#btnSubirDocsAgrupadoArchivar").on("click", function(e) {
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
                            InsertarAnexoArchivar(fila.codigo, fila.original, fila.nuevo);
                        });                   
                        this.removeAllFiles();
                    });
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