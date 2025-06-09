var botonesAct = '<li><a id="btnEnvioCargo" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Envio cargo</span></a></li>'+
                '<li><a id="btnArchivar" style="display: none" class="btn btn-primary"><i class="	far fa-file-archive"></i><span> Archivar</span></a></li>';
$("#actionBtns").append(botonesAct);

var botonesSupo = '<li><a id="btnFlujo" style="display: none" class="btn btn-link"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>' +
                  '<li><a id="btnDoc" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>' +
                  '<li><a id="btnAnexos" style="display: none" class="btn btn-link"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>';
$("#supportBtns").append(botonesSupo);

var tblPendientesEnvioCargo = $('#tblPendientesEnvioCargo').DataTable({
    responsive: true,
    ajax: {
        url: urlpage+ "interoperabilidad/indexAjax.php?controller=recepcion&action=datosPendientesEnvioCargo",
    },
    drawCallback: function( settings ) {
        $(".dataTables_scrollBody").attr("data-simplebar", "");
        $('select[name="tblPendientesEnvioCargo_length"]').formSelect();

        $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
            tblPendientesEnvioCargo.rows().deselect();
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
        }
    ],
    'columns': [
        {'data': 'fila', 'autoWidth': true}
        ,{'data': 'cud', 'autoWidth': true}
        ,{'data': 'documento', 'autoWidth': true}
        ,{'data': 'fecDoc', 'autoWidth': true}
        ,{'data': 'asunto', 'autoWidth': true}
    ],
    'select': {
        'style': 'multi'
    }
});

var btnEnvioCargo = $("#btnEnvioCargo");
var btnArchivar = $("#btnArchivar");
var btnFlujo = $("#btnFlujo");
var btnDoc = $("#btnDoc");
var btnAnexos = $("#btnAnexos");

var actionButtons = actionBtn;
actionButtons.push(btnEnvioCargo);
actionButtons.push(btnArchivar);

var supportButtons = supportBtns;
supportButtons.push(btnFlujo);
supportButtons.push(btnDoc);
supportButtons.push(btnAnexos);

tblPendientesEnvioCargo
    .on( 'select', function ( e, dt, type, indexes ) {
        let count = tblPendientesEnvioCargo.rows( { selected: true } ).count();
        switch (count) {
            case 1:
                $.each( actionButtons, function( key, value ) {
                    value.css("display","inline-block");
                });
                $.each( supportButtons, function( key, value ) {
                    value.css("display","inline-block");
                });
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
        let count = tblPendientesEnvioCargo.rows( { selected: true } ).count();
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



    btnArchivar.on("click", function () {
        let rows_selected = tblPendientesEnvioCargo.column(0).checkboxes.selected();
        if (rows_selected.length > 0) {
            let fila = tblPendientesEnvioCargo.rows(rows_selected[0]).data()[0];
            if(fila.idTramite>0){
            window.location.replace(urlpage+"views/registroCargoInteroperabilidadArch.php?cud=" + btoa(fila.cud)+"&idT="+btoa(fila.iCodTrabajadorRegistro)+"&idO="+btoa(fila.iCodOficinaRegistro)+"&idI="+btoa(fila.sIdrecext)+"&doc="+btoa(fila.numeroDocumento)+"&remi="+btoa(fila.iCodRemitente));
            }
            else {
                M.toast({html: '¡No se puede archivar por que contiene CUD!'});
            }

        } else {
            alert("Por favor, seleccione una fila.");
        }
    });


btnEnvioCargo.on("click", function () {
    let rows_selected = tblPendientesEnvioCargo.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesEnvioCargo.rows(fila).data()[0]);
    });
    let fila = values[0];

                

    if (fila.idTramite == null){
        $("#urlDocumentoFirmar").val(urlnginx + fila.ruta);
        $("#nombreDocumentoFirmar").val(fila.nombre);
        $("#sIdrecext").val(fila.sIdrecext);
        $("#idTramite").val(fila.idTramite);
        $("#cud").val(fila.cud);   /*CUD*/
        $("#tipoFirma").val('c');
        $("#nroVisto").val(0);
        initInvoker('W');   
    } else {
        $.ajax({
            cache: false,
            url: urlpage + "views/ajax/obtenerDoc.php",
            method: "POST",
            data: {codigo: fila.idTramite},
            datatype: "json",
            success: function (response) {
                let json = $.parseJSON(response);
                if (json.length !== 0) {
                    $("#urlDocumentoFirmar").val(json['url']);
                    $("#nombreDocumentoFirmar").val(json['nombre']);
                    $("#sIdrecext").val(fila.sIdrecext);
                    $("#idTramite").val(fila.idTramite);
                    $("#cud").val(fila.cud);        /*CUD*/
                    $("#tipoFirma").val('c');
                    $("#nroVisto").val(0);
                    initInvoker('W');
                }else {
                    M.toast({html: '¡No contiene documento asociado!'});
                }
                
            }
            
        });
    }
});

btnFlujo.on("click", function () {
    let rows_selected = tblPendientesEnvioCargo.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesEnvioCargo.rows(fila).data()[0]);
    });
    let fila = values[0];
    let documento = new Documento(fila.idTramite, "multiModal");
    documento.flujo();
});

btnDoc.on("click", function () {
    let rows_selected = tblPendientesEnvioCargo.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesEnvioCargo.rows(fila).data()[0]);
    });
    let fila = values[0];
    if (fila.idTramite == null){
        let documento = new Documento(null, "multiModal", urlnginx + fila.ruta);
        documento.mostrarUrl();        
    } else {
        let documento = new Documento(fila.idTramite, "multiModal");
        documento.ver();
    }
});

btnAnexos.on("click", function () {
    let rows_selected = tblPendientesEnvioCargo.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesEnvioCargo.rows(fila).data()[0]);
    });
    let fila = values[0];
    let documento = new Documento(fila.idTramite, "multiModal");
    documento.anexos();
});

document.addEventListener("actualizarTabla", function () {
    tblPendientesEnvioCargo.ajax.reload();
});

var tblGeneral = tblPendientesEnvioCargo;

