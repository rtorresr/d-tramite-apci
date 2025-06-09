var botonesAct = '<li> <a id="btnEnviarCargo" style="display: none" class="btn btn-primary"><i class="fas fa-upload"></i><span> Cargo</span></a> </li>';
$("#actionBtns").append(botonesAct);

var tblPendientesCargo = $('#tblPendientesCargo').DataTable({
    responsive: true,
    ajax: {
        url: urlpage+ "interoperabilidad/indexAjax.php?controller=despacho&action=datosPendientesCargo",
    },
    drawCallback: function( settings ) {
        $(".dataTables_scrollBody").attr("data-simplebar", "");
        $('select[name="tblPendientesCargo_length"]').formSelect();

        $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
            tblPendientesCargo.rows().deselect();
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
            "width": "20%",
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
        ,{'data': 'fecEnvio', 'autoWidth': true}
    ],
    'select': {
        'style': 'multi'
    }
});

var btnEnviarCargo = $("#btnEnviarCargo");
actionButtons.push(btnEnviarCargo);

var actionButtons = actionBtn;
var supportButtons = supportBtns;

tblPendientesCargo
    .on( 'select', function ( e, dt, type, indexes ) {
        let count = tblPendientesCargo.rows( { selected: true } ).count();
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
                    value.css("display","none");
                });
                $.each( supportButtons, function( key, value ) {
                    value.css("display","none");
                });
                break;
        }

    })
    .on( 'deselect', function ( e, dt, type, indexes ) {
        let count = tblPendientesCargo.rows( { selected: true } ).count();
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
                    value.css("display","none");
                });
                $.each( supportButtons, function( key, value ) {
                    value.css("display","none");
                });
                break;
        }
    });

    btnEnviarCargo.on("click", function () {
        let rows_selected = tblPendientesCargo.column(0).checkboxes.selected();
        if (rows_selected.length > 0) {
            let fila = tblPendientesCargo.rows(rows_selected[0]).data()[0];
            window.location.replace(urlpage+"views/registroCargoInteroperabilidad.php?cud=" + btoa(fila.cud)+"&idT="+btoa(fila.iCodTrabajadorRegistro)+"&idO="+btoa(fila.iCodOficinaRegistro)+"&idI="+btoa(fila.sIdemiext)+"&remi="+btoa(fila.iCodRemitente));
        } else {
            alert("Por favor, seleccione una fila.");
        }
    });

var tblGeneral = tblPendientesCargo;