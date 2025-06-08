window.addEventListener('getArguments', function (e) {
    type = e.detail;
    if(type === 'W'){
        ObtieneArgumentosParaFirmaDesdeLaWeb();
    }
});

window.addEventListener('invokerOk', function (e) {
    type = e.detail;
    if(type === 'W'){
        MiFuncionOkWeb();
    }
});

window.addEventListener('invokerCancel', function (e) {
    MiFuncionCancel();
});

function ObtieneArgumentosParaFirmaDesdeLaWeb(){
    let datos = {
        type : "W",
        urlDocFirmar: $("#urlDocumentoFirmar").val(),
        tipFirma: $("#tipoFirma").val(),
        nroVisto: $("#nroVisto").val()
    };
    $.ajax({
        cache: false,
        url: urlpage + "interoperabilidad/indexAjax.php?controller=firmador&action=argumentosFirmador",
        method: "POST",
        data: datos,
        datatype: "json",
        success: function (response) {
            document.getElementById("argumentos").value = response;
            getArguments();
        }
    })
}

function getArguments(){
    var arg = document.getElementById("argumentos").value;
    dispatchEventClient('sendArguments', arg);
}

function MiFuncionOkWeb(){
    var datos = {
        urlDocFirmar: $("#urlDocumentoFirmar").val(),
        idTramite: $("#idTramite").val()
    };
    getSpinner('Guardando Documento');
    $.ajax({
        cache: false,
        url: urlpage + "interoperabilidad/indexAjax.php?controller=recepcion&action=firmadoCargo",
        method: "POST",
        data: datos,
        success: function (url) {
            deleteSpinner();
            getSpinner('Enviado Documento');
            $.ajax({
                cache: false,
                async: false,
                url: urlpage + "interoperabilidad/indexAjax.php?controller=recepcion&action=enviarCargo",
                method: "POST",
                data: {
                    url : url,
                    idTramite: $("#idTramite").val()
                },
                datatype: "json",
                success: function (url) {
                    document.dispatchEvent("actualizarTabla");
                    deleteSpinner();
                },
                error: function (e) {
                    console.log(e);
                }
            });
            deleteSpinner();
        },
        error: function (e) {
            console.log(e);
        }
    });
}

function MiFuncionCancel(){
    alert("El proceso de firma digital fue cancelado.");
}