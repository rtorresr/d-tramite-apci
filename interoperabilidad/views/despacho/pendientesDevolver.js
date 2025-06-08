var botonesAct = '<li><a id="btnEnviarCargoDevuelto" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Devolver cargo</span></a></li>';
$("#actionBtns").append(botonesAct);

var botonesSupo = '<li><a id="btnCargoPide" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Cargo</span></a></li>';
$("#supportBtns").append(botonesSupo);

var tblPendientesDevolver = $('#tblPendientesDevolver').DataTable({
    responsive: true,
    ajax: {
        url: urlpage+ "interoperabilidad/indexAjax.php?controller=despacho&action=datosPendientesDevolver",
    },
    drawCallback: function( settings ) {
        $(".dataTables_scrollBody").attr("data-simplebar", "");
        $('select[name="tblPendientesDevolver_length"]').formSelect();

        $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
            tblPendientesDevolver.rows().deselect();
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
            "width": "10%",
            "targets": [3],
            'orderable': false
        },
        {
            "width": "20%",
            "targets": [5],
            'orderable': false
        },
    ],
    'columns': [
        {'data': 'fila', 'autoWidth': true}
        ,{'data': 'siglasOfi', 'autoWidth': true}
        ,{
            'render': function (data, type, full, meta) {
                var html = `CUD: ${full.cud}<br/>
                CUO: <small><i>${full.cuo}</i></small>`;
                return html;
            }, 'autoWidth': true
        }
        ,{'data': 'documento', 'autoWidth': true}
        ,{'data': 'asunto', 'autoWidth': true}
        ,{'data': 'entDestino', 'autoWidth': true}
        ,{'data': 'fecRecepcion', 'autoWidth': true}
        ,{
            'render': function (data, type, full, meta) {
                var html = '';
                if (full.estado == 'R'){     
                    html = `Recepcionado`;
                } else {
                    html = `Observado<br/>
                        <small><i>${full.observacion}</i></small>`;
                }
                return html;
            }, 'width': '10%'
        }
    ],
    'select': {
        'style': 'multi'
    }
});

var btnEnviarCargoDevuelto = $("#btnEnviarCargoDevuelto");
var btnCargoPide = $("#btnCargoPide");

var actionButtons = actionBtn;
actionButtons.push(btnEnviarCargoDevuelto);

var supportButtons = supportBtns;
supportButtons.push(btnCargoPide);

tblPendientesDevolver
    .on( 'select', function ( e, dt, type, indexes ) {
        let count = tblPendientesDevolver.rows( { selected: true } ).count();
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
        let count = tblPendientesDevolver.rows( { selected: true } ).count();
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

btnCargoPide.on("click", function () {
    let rows_selected = tblPendientesDevolver.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesDevolver.rows(fila).data()[0]);
    });
    let fila = values[0];
    $.ajax({
        cache: false,
        url: urlpage + "interoperabilidad/indexAjax.php?controller=despacho&action=verCargoPide",
        method: "POST",
        data: {id: fila.sIdemiext},
        success: function (respuesta) {
            var cargo = new Documento(null,"multiModal");
            let titulo = '<h4>Cargo</h4>';
            let contenido = '<iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important" src="data:application/pdf;base64,' + respuesta+ '"></iframe>';
            let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>';
            cargo.mostrarModal(titulo, contenido, btnFooter);
        }
    });
});

btnEnviarCargoDevuelto.on("click", function () {
    var cargo = new Documento(null,"multiModal");
    let titulo = '<h4>Devolución Cargo</h4>';
    let contenido = '<form class="row">' +
                        '<div class="col s12 input-field">' +
                            '<textarea id="observacionCargo" class="materialize-textarea FormPropertReg"></textarea>' +
                            '<label for="observacionCargo">Observación</label>' +
                        '</div>' +
                    '</form>';
    let btnFooter = '<a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>' +
                    '<a id="btnEnviarCargo" class="waves-effect btn-flat">Enviar</a>';
    cargo.mostrarModal(titulo, contenido, btnFooter);
});

$(document).on('click', '#btnEnviarCargo', function(){
    let rows_selected = tblPendientesDevolver.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesDevolver.rows(fila).data()[0]);
    });
    let fila = values[0];
    $.ajax({
        cache: false,
        url: urlpage + "interoperabilidad/indexAjax.php?controller=despacho&action=devolverCargo",
        method: "POST",
        data: {
            id: fila.sIdemiext,
            tramite: fila.idTramite,
            nombre: fila.documento.trim()+'.pdf',
            tipoEnlace: 6,
            observacion: $("#observacionCargo").val()
        },
        datatype: "json",
        success: function () {
            tblPendientesDevolver.ajax.reload();
            var cargo = new Documento(null,"multiModal");
            cargo.cerrarModal();
            M.toast({html: '¡Enviado correctamente!'});
        },error: function (e) {
            console.log(e);
            M.toast({html: e.responseText});
        }

    });
});

var tblGeneral = tblPendientesDevolver;