<?php
include_once('../conexion/conexion.php');
$iCodTramite = $_POST['iCodTramite'][0];
$rstra = sqlsrv_query($cnx,"SELECT nFlgClaseDoc,iCodTupa,* FROM Tra_M_Tramite WHERE iCodTramite = ".$iCodTramite);
$RsTra = sqlsrv_fetch_array($rstra);
?>
<link href="includes/component-dropzone.css" rel="stylesheet">
<form name="formCompletar" id="formCompletar">
    <input type="hidden" name="opcion" value="3">
    <input type="hidden" name="iCodTramite" value="<?=$iCodTramite?>">
    <?php if ($RsTra['nFlgClaseDoc'] == 1) :?>

                <table cellpadding="0" cellspacing="2" border="0"  class="table" id="tRequisitos">
                <?php
                $sqlTupaReq="SELECT iCodTupaRequisito,cNomTupaRequisito FROM Tra_M_Tupa_Requisitos WHERE iCodTupa='".$RsTra['iCodTupa']."' ORDER BY iCodTupaRequisito ASC";
                $rsTupaReq = sqlsrv_query($cnx,$sqlTupaReq);

                        while ($RsTupaReq=sqlsrv_fetch_array($rsTupaReq)) {
                            $sqlBusReq = "SELECT iCodTupaRequisito FROM Tra_M_Tramite_Requisitos WHERE iCodTramite = ".$iCodTramite." AND iCodTupaRequisito = ".$RsTupaReq['iCodTupaRequisito'];
                            $rsBusReq = sqlsrv_query($cnx,$sqlBusReq);
                            if (!sqlsrv_has_rows($rsBusReq)) {
                                ?>
                                <tr>
                                    <td valign=top width=155>
                                        <label class='form-check-label' for='<?= $RsTupaReq["iCodTupaRequisito"] ?>'>
                                            <input class='form-check-input' type='checkbox' name='iCodTupaRequisito[]'
                                                   value='<?= $RsTupaReq["iCodTupaRequisito"] ?>'
                                                   id='<?= $RsTupaReq["iCodTupaRequisito"] ?>'>
                                            <span><?= $RsTupaReq["cNomTupaRequisito"] ?></span>
                                        </label>
                                    </td>
                                </tr>
                                <?php
                            }
                        } ?>
                </table>
            </div>
        </div>
    <?php endif;?>
    <fieldset>
        <legend>Archivo</legend>
        <div class="row">
            <div class="file-field input-field col s12">
                <div id="dropzone" class="dropzone" style="width:100%"></div>
            </div>
        </div>
        <div class="row">
            <div class="col m12 input-field">
                <textarea name="archivoFisico" id="archivoFisico" class="FormPropertReg materialize-textarea"></textarea>
                <label for="archivoFisico">Tipo de soporte</label>
            </div>
        </div>
    </fieldset>
</form>
<script>
    $(document).ready(function () {
        if($('#tRequisitos tr').length > 0){
            $('table#tRequisitos').before('<div class="col m12"><p>Requisitos faltantes</p>\n' +
                '            <a href="javascript:seleccionar_todo()">Marcar todos</a>\n' +
                '            <a href="javascript:deseleccionar_todo()">Desmarcar</a>\n' +
                '        <div>');
        }

        Dropzone.autoDiscover = false;
        $("div#dropzone").dropzone({
            url: "registerDoc/regEntrada.php",
            paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
            autoProcessQueue: false,
            maxFiles: 2,
            acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
            addRemoveLinks: true,
            maxFilesize: 1200, // MB
            uploadMultiple: true,
            parallelUploads: 2,

            dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
            dictInvalidFileType: "Archivo no válido",
            dictMaxFilesExceeded: "Solo 2 archivos son permitidos",
            dictCancelUpload: "Cancelar",
            dictRemoveFile: "Remover",
            dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
            dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
            dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",

            init: function () {
                // First change the button to actually tell Dropzone to process the queue.
                var myDropzone = this;

                $("#btnEnviarCompletar").on("click", function(e)  {
                    e.preventDefault();
                    e.stopPropagation();
                    let queuedFiles = myDropzone.getQueuedFiles();
                    if(queuedFiles.length === 0){
                        $.alert({
                            title: '¡Falta documento pdf!',
                            content: '',
                            columnClass: 'col s8 offset-s2  m6 offset-m3  l4 offset-l4'
                        });
                        location.reload();
                    } else {
                        myDropzone.processQueue();
                    }
                });
                this.on('sendingmultiple', function(file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    console.log("Multiple");
                    var data = $('form#formCompletar').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                });
                // on add file
                this.on("addedfile", function(file) {
                    console.log(file);
                });
                // on error
                this.on("error", function(file, response) {
                    console.log(response);
                });
                // on success
                this.on("success", function(file, response) {
                    // submit form
                    console.log("correcto");
                    let elems = document.querySelector('#modalConcluido');
                    let instance = M.Modal.getInstance(elems);
                    $('#modalConcluido div.modal-content').html(response);
                    instance.open();
                });
            }
        });
    });
</script>

