var botonesAct = '<li><a id="btnIngresar" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Ingresar</span></a></li>';
$("#actionBtns").append(botonesAct);

var botonesSupo = '<li><a id="btnDocPide" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>' +
                  '<li><a id="btnAnexosPide" style="display: none" class="btn btn-link"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>';
$("#supportBtns").append(botonesSupo);

var tblPendientesRecibir = $('#tblPendientesRecibir').DataTable({
    responsive: true,
    ajax: {
        url: urlpage+ "interoperabilidad/indexAjax.php?controller=recepcion&action=datosPendientesRecibir",
    },
    drawCallback: function( settings ) {
        $(".dataTables_scrollBody").attr("data-simplebar", "");
        $('select[name="tblPendientesRecibir_length"]').formSelect();

        $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
            tblPendientesRecibir.rows().deselect();
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
            'targets': [1,2],
            "width": "6%",
        },
        {
            "width": "30%",
            "targets": [4],
            'orderable': false
        },
        {
            "width": "40px",
            "targets": [1],
            'orderable': false
        },
        {
            "width": "15%",
            "targets": [3],
            'orderable': false
        },
        {
            "width": "25%",
            "targets": [5],
            'orderable': false
        }
    ],
    'columns': [
        {'data': 'fila', 'autoWidth': true}
        ,{'data': 'cuo', 'autoWidth': true}
        ,{'data': 'documento', 'autoWidth': true}
        ,{'data': 'fecDoc', 'autoWidth': true}
        ,{'data': 'entRemitente', 'autoWidth': true}
        ,{'data': 'uniRemitente', 'autoWidth': true}
        ,{'data': 'asunto', 'autoWidth': true}
        ,{'data': 'uniDestino', 'autoWidth': true}
        ,{'data': 'perDestino', 'autoWidth': true}
        ,{'data': 'carDestino', 'autoWidth': true}
        ,{'data': 'fecEmision', 'autoWidth': true}
    ],
    'select': {
        'style': 'multi'
    }
});

var btnIngresar = $("#btnIngresar");
var btnDocPide = $("#btnDocPide");
var btnAnexosPide = $("#btnAnexosPide");


var actionButtons = actionBtn;

var supportButtons = supportBtns;
supportButtons.push(btnIngresar);
supportButtons.push(btnDocPide);
supportButtons.push(btnAnexosPide);

tblPendientesRecibir
    .on( 'select', function ( e, dt, type, indexes ) {
        let count = tblPendientesRecibir.rows( { selected: true } ).count();
        switch (count) {
            case 1:
                $.each( actionButtons, function( key, value ) {
                    value.css("display","inline-block");
                });
                $.each( supportButtons, function( key, value ) {
                    value.css("display","inline-block");
                });

                var row = tblPendientesRecibir.rows( { selected: true } ).data().toArray()[0];
                if (row.numAnexos === 0) {
                    btnAnexosPide.css("display","none");
                }
                $('.actionButtons').show();

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
        let count = tblPendientesRecibir.rows( { selected: true } ).count();
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
                var row = tblPendientesRecibir.rows( { selected: true } ).data().toArray()[0];
                if (row.numAnexos === 0) {
                    btnAnexosPide.css("display","none");
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

btnIngresar.on("click", function () {
    let rows_selected = tblPendientesRecibir.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesRecibir.rows(fila).data()[0]);
    });
    let fila = values[0];
    let subContenido = '';
    $("#dinamicStyle").empty();
    if (fila.numAnexos != 0) {
        subContenido = '<div class="row rowSinObservaciones">' +
                                '<div class="file-field input-field col s12">' +
                                    '<div id="dropzone" class="dropzone" style="width:100%"></div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="row rowSinObservaciones">' +
                                '<div class="col s12">' +
                                    '<button type="button" class="btn btn-secondary" id="btnSubirDoc">Subir</button>' +
                                '</div>' +
                            '</div>' +
                            '<form class="rowSinObservaciones" name="formCargarDocumento" id="formCargarDocumento">' +
                                '<div id="documentoArchivo" style="display: none">' +
                                    '<p style="padding: 0 15px">Seleccione archivo:</p>' +
                                    '<div class="row" style="padding: 0 15px">' +
                                       '<div class="col s12"></div>' +
                                    '</div>' +
                                '</div>' +
                            '</form>';
    }
    let ingresoTramite = new Documento(null,"multiModal");
    let titulo = '<h4>Ingreso de documento</h4>';
    let contenido = `<form>
                        <div class="row">
                            <div class="col s12 input-field">
                                <div class="switch">
                                    <label>
                                        Sin Observaciones
                                        <input type="checkbox" id="flgObservado" name="flgObservado" value="1">
                                        <span class="lever"></span>
                                        Con Observaciones
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="rowConObservaciones" style="display: none;">
                            <div class="col s12 input-field">
                                <input type="text" id="observacionDoc" name="observacionDoc">
                                <label for="observacionDoc">Observacion Documento</label>
                            </div>
                        </div>
                        <div class="row rowSinObservaciones">    
                            <div class="col s12 input-field">
                                <select id="oficinaDestino" name="oficinaDestino"></select>
                                <label for="oficinaDestino">Oficina Destino</label>
                            </div>
                        </div>                                          
                    </form>` + subContenido;
    let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>' +
                    '<a id="btnIngresarTramite" class="waves-effect btn-flat">Ingresar</a>';
    ingresoTramite.mostrarModal(titulo, contenido, btnFooter);

    $.ajax({
        cache: false,
        url: urlpage + "interoperabilidad/indexAjax.php?controller=utiles&action=listarOficinas",
        method: "POST",
        data: {tipo: 0},
        datatype: "json",
        success: function (respuesta) {
            var options = '<option value="">Seleccione... </option>';
            var data = JSON.parse(respuesta);
            data.forEach(function(objeto) {
                options += '<option value="'+objeto.idOficina+'">' + objeto.siglasOficina + ' | ' + objeto.nomOficina + '</option>';
            });
            document.querySelector("#oficinaDestino").innerHTML = options;
            $('select').formSelect();
        }
    });

    $("#dinamicScript #dropzoneScript").remove();
    if (fila.numAnexos != 0){
        let style = '<link href="' + urlpage + 'views/includes/component-dropzone.css" rel="stylesheet">';
        $("#dinamicStyle").append(style);
        let script = '<script id="dropzoneScript" src="' + urlpage + 'interoperabilidad/views/recepcion/dropzonePendientesRecibir.js"></script>';
        $("#dinamicScript").append(script);
    }

    $("#flgObservado").on("change", function (e) {
        if ($(this).prop("checked")){
            $("#rowConObservaciones").show();
            $(".rowSinObservaciones").hide();
        } else {
            $("#rowConObservaciones").hide();
            $(".rowSinObservaciones").show();
        }
    });
});

$(document).on('click', '#btnIngresarTramite', function(e){
    let rows_selected = tblPendientesRecibir.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesRecibir.rows(fila).data()[0]);
    });
    let fila = values[0];
    if (!$("#flgObservado").prop("checked")){
        if ($("#oficinaDestino").val().trim() == ''){
            $.alert("Falta seleccionar oficina!");
            return false;
        } else if (fila.numAnexos !== $("#documentoArchivo input[name='anexosPide[]']").length){
            $.alert("Falta subir anexos, anexos: " + $("#documentoArchivo input[name='anexosPide[]']").length + " de " + fila.numAnexos + " !");
            return false;
        }
    } else {
        if ($("#observacionDoc").val().trim() == ''){
            $.alert("Falta indicar la observación del documento!");
            return false;
        }
    }

    let data = $('#formCargarDocumento').serializeArray();
    let formData = new FormData();
    $.each(data, function (key, el) {
        formData.append(el.name, el.value);
    });
    formData.append('Id', fila.sIdrecext);
    formData.append('FlgObservado', $("#flgObservado").prop("checked") ? 1 : 0);
    formData.append('OfinaDestino', $("#oficinaDestino").val());
    formData.append('ObservacionDoc', $("#observacionDoc").val());
    formData.append('NomDocumento', fila.documento);
    $.ajax({
        url: urlpage + "interoperabilidad/indexAjax.php?controller=recepcion&action=registrarTramite",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        datatype: "json",
        success: function () {
            tblPendientesRecibir.ajax.reload();
            var cargo = new Documento(null,"multiModal");
            cargo.cerrarModal();
            M.toast({html: '¡Registrado correctamente!'});
        },error: function (e) {
            console.log(e);
            M.toast({html: e.responseText});
        }
    });
});

btnDocPide.on("click", function () {
    let rows_selected = tblPendientesRecibir.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesRecibir.rows(fila).data()[0]);
    });
    let fila = values[0];
    $.ajax({
        cache: false,
        url: urlpage + "interoperabilidad/indexAjax.php?controller=recepcion&action=verDocPide",
        method: "POST",
        data: {id: fila.sIdrecext},
        success: function (respuesta) {
            var documento = new Documento(null,"multiModal");
            let titulo = '<h4>Documento</h4>';
            let contenido = '<iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important" src="data:application/pdf;base64,' + respuesta+ '"></iframe>';
            let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>';
            documento.mostrarModal(titulo, contenido, btnFooter);
        }
    });
});

btnAnexosPide.on("click", function () {
    let rows_selected = tblPendientesRecibir.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesRecibir.rows(fila).data()[0]);
    });
    let fila = values[0];
    window.open(fila.urlAnexos, '_blank');
});

var tblGeneral = tblPendientesRecibir;

