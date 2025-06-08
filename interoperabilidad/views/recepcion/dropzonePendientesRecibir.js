Dropzone.autoDiscover = false;
$("#dropzone").dropzone({
    url: "ajax/cargarDocsAgrupado.php",
    paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
    autoProcessQueue: false,
    maxFiles: 10,
    acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx, .rar, .zip",
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
        let anexos = document.querySelectorAll("#documentoArchivo input[name='anexosPide[]']");
        for (let elem of anexos) {
            if (file.name == elem.parentElement.querySelector("a").text) {
                estado = true;
            }
        }
        if (!estado) {
            done();
        } else {
            done("El anexo ya está agregado");
            $.alert("El anexo " + file.name +" ya está agregado");
            this.removeFile(file);
        }
    },
    init: function () {
        var myDropzone = this;
        $("#btnSubirDoc").on("click", function(e) {
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
            if (json.success){
                $.each(json.data, function (i,fila) {
                    let check = '<p class="'+fila.codigo+'"><label><input type="checkbox" class="filled-in '+fila.codigo+'" checked="checked" name="anexosPide[]" value="'+fila.codigo+'"><span><a href="'+fila.nuevo+'" target="_blank">'+fila.original+'</a></span></label></p>';
                    $('#documentoArchivo div.row div.col').append(check);
                });
                $('#documentoArchivo').css('display', 'block');
            } else {
                M.toast({html: json.mensaje});
            }            
            this.removeAllFiles();
        });
}
});