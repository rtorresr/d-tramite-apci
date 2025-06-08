var botonesAct = '<li><a id="btnEnviarPide" style="display: none" class="btn btn-primary"><i class="fas fa-reply fa-fw left"></i><span>Enviar</span></a></li>';
$("#actionBtns").append(botonesAct);

var tblPendientesEnviar = $('#tblPendientesEnviar').DataTable({
    responsive: true,
    ajax: {
        url: urlpage+ "interoperabilidad/indexAjax.php?controller=despacho&action=datosPendientesEnviar",
    },
    drawCallback: function( settings ) {
        $(".dataTables_scrollBody").attr("data-simplebar", "");
        $('select[name="tblPendientesEnviar_length"]').formSelect();

        $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
            tblPendientesEnviar.rows().deselect();
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
        ,{'data': 'siglasOfi', 'autoWidth': true}
        ,{'data': 'cud', 'autoWidth': true}
        ,{'data': 'documento', 'autoWidth': true}
        ,{'data': 'asunto', 'autoWidth': true}
        ,{'data': 'entDestino', 'autoWidth': true}
        ,{'data': 'fecRegistro', 'autoWidth': true}
    ],
    'select': {
        'style': 'multi'
    }
});

var btnEnviar = $("#btnEnviarPide");

var actionButtons = actionBtn;
actionButtons.push(btnEnviar);

var supportButtons = supportBtns;

tblPendientesEnviar
    .on( 'select', function ( e, dt, type, indexes ) {
        let count = tblPendientesEnviar.rows( { selected: true } ).count();
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
        let count = tblPendientesEnviar.rows( { selected: true } ).count();
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

btnEnviar.on("click", function () {
    let rows_selected = tblPendientesEnviar.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblPendientesEnviar.rows(fila).data()[0]);
    });
    let fila = values[0];
    $.ajax({
        cache: false,
        url: urlpage + "interoperabilidad/indexAjax.php?controller=despacho&action=enviarPide",
        method: "POST",
        data: {id: fila.sIdemiext},
        datatype: "json",
        success: function () {
            tblPendientesEnviar.ajax.reload();
            M.toast({html: '¡Enviado correctamente!'});
        }
    });
});

var tblGeneral = tblPendientesEnviar;