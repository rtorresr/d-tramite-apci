function limpiar(){
    $("#actionBtns").empty();
    $("#supportBtns").empty();
    $('.actionButtons').hide(100);
}

$("#btnPendientesRecibir").on("click", function(){
    if ($("ul.tabs li a.active").attr("href") == "#pendientesEnvioCargo"){
        window.location.href = urlpage + "views/interoperabilidad.php?controller=recepcion";
    } else {
        limpiar();
        $.ajax({
            url: urlpage + "interoperabilidad/indexAjax.php?controller=recepcion&action=pendientesRecibir",
            success: function (response) {
                $("#tablas").empty().append(response);
                let script = '<script src="' + urlpage + 'interoperabilidad/views/recepcion/pendientesRecibir.js"></script>' +
                            '<script src="' + urlpage + 'views/includes/dropzone.js"></script>';
                $("#dinamicScript").empty().append(script);
            },
            error: function (e) {
                console.log(e);
                console.log('No se pudo recuperar datos');
            }
        })
    }
});

$("#btnPendientesEnvioCargo").on("click", function(){
    limpiar();
    $.ajax({
        url: urlpage + "interoperabilidad/indexAjax.php?controller=recepcion&action=pendientesEnvioCargo",
        success: function (response) {
            $("#tablas").empty().append(response);
            let script = '<script src="' + urlpage + 'interoperabilidad/views/recepcion/pendientesEnvioCargo.js"></script>' +
                         '<script src="' + urlpage + 'interoperabilidad/core/Firmador.js"></script>' +
                         '<script src="' + urlpage + 'views/invoker/client.js"></script>';
            $("#dinamicScript").empty().append(script);
        },
        error: function (e) {
            console.log(e);
            console.log('No se pudo recuperar datos');
        }
    })
});

var actionBtn = [];
var supportBtns = [];

$(function () {
    $("#btnPendientesRecibir").trigger("click");
});
