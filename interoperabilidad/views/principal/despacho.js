function limpiar(){
    $("#actionBtns").empty();
    $('#supportBtns a').not('.documento').remove();
    $('.actionButtons').hide(100);
}

$("#btnPendientesEnviar").on("click", function(){
    limpiar();
    $.ajax({
        url: urlpage + "interoperabilidad/indexAjax.php?controller=despacho&action=pendientesEnviar",
        success: function (response) {
            $("#tablas").empty().append(response);
            let script = '<script src="' + urlpage + 'interoperabilidad/views/despacho/pendientesEnviar.js"></script>';
            $("#dinamicScript").empty().append(script);
        },
        error: function (e) {
            console.log(e);
            console.log('No se pudo recuperar datos');
        }
    })
});


$("#btnPendientesCargo").on("click", function() {
    limpiar();
    $.ajax({
        url: urlpage + "interoperabilidad/indexAjax.php?controller=despacho&action=pendientesCargo",
        success: function (response) {
            $("#tablas").empty().append(response);
            let script = '<script src="' + urlpage + 'interoperabilidad/views/despacho/pendientesCargo.js"></script>';
            $("#dinamicScript").empty().append(script);
        },
        error: function (e) {
            console.log(e);
            console.log('No se pudo recuperar datos');
        }
    })
});
$("#btnPendientesDevolver").on("click", function(){
    limpiar();
    $.ajax({
        url: urlpage + "interoperabilidad/indexAjax.php?controller=despacho&action=pendientesDevolver",
        success: function (response) {
            $("#tablas").empty().append(response);
            let script = '<script src="' + urlpage + 'interoperabilidad/views/despacho/pendientesDevolver.js"></script>';
            $("#dinamicScript").empty().append(script);
        },
        error: function (e) {
            console.log(e);
            console.log('No se pudo recuperar datos');
        }
    })
});

var htmlBtnDocs = '<li><a id="btnFlujo" style="display: none" class="documento btn btn-link"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>\n' +
    '            <li><a id="btnDoc" style="display: none" class="documento btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>\n' +
    '            <li><a id="btnAnexos" style="display: none" class="documento btn btn-link"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>';

$("#supportBtns").append(htmlBtnDocs);

var btnFlujo = $("#btnFlujo");
var btnDoc = $("#btnDoc");
var btnAnexos = $("#btnAnexos");

var actionBtn = [];
var supportBtns = [btnFlujo, btnDoc, btnAnexos];

btnFlujo.on("click", function () {
    let rows_selected = tblGeneral.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblGeneral.rows(fila).data()[0]);
    });
    let fila = values[0];
    let documento = new Documento(fila.idTramite, "multiModal");
    documento.flujo();
});

btnDoc.on("click", function () {
    let rows_selected = tblGeneral.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblGeneral.rows(fila).data()[0]);
    });
    let fila = values[0];  
      
    let documento = new Documento(fila.idTramite, "multiModal",null ,fila.idEntidad);
    documento.ver();
});

btnAnexos.on("click", function () {
    let rows_selected = tblGeneral.column(0).checkboxes.selected();
    let values = [];
    $.each(rows_selected, function (index, fila) {
        values.push(tblGeneral.rows(fila).data()[0]);
    });
    let fila = values[0];
    let documento = new Documento(fila.idTramite, "multiModal");
    documento.anexos();
});

$(function () {
    $("#btnPendientesEnviar").trigger("click");
});
