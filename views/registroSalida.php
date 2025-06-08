<?php
date_default_timezone_set('America/Lima');
session_start();
$pageTitle = "Registro de Salida";
$activeItem = "registroSalida.php";
$navExtended = true;


$nNumAno    = date('Y');
if($_SESSION['CODIGO_TRABAJADOR']!=='') {
    if (!isset($_SESSION['cCodRef'])){
        $fecSesRef=date('Ymd-Gis');
        $_SESSION['cCodRef']=$_SESSION['CODIGO_TRABAJADOR'].'-'.$_SESSION['iCodOficinaLogin'].'-'.$fecSesRef;
    }
    if (!isset($_SESSION['cCodOfi'])){
        $fecSesOfi=date('Ymd-Gis');
        $_SESSION['cCodOfi']=$_SESSION['CODIGO_TRABAJADOR'].'-'.$_SESSION['iCodOficinaLogin'].'-'.$fecSesOfi;
    }
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include('includes/head.php');?>
        <link href="includes/component-dropzone.css" rel="stylesheet">
    </head>
    <body class="theme-default has-fixed-sidenav" onload="mueveReloj()">
    <?php include('includes/menu.php');?>
    <!--Main layout-->
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><button id="rsit" type="button" class="btn btn-primary" value="Registrar" ><i class="fas fa-save fa-fw left"></i>Registrar</button></li></ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <form name="frmRegistro" id="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
                <input type="hidden" name="id_identificador" value="<?php echo random_int(1000000,9999999);?>">
                <input type="hidden" name="opcion" value="">
                <input type="hidden" name="sal" value="3">
                <input type="hidden" name="radioSeleccion" value="">
                <?php
                include_once '../conexion/conexion.php';
                $porAprobar = '';
                if ($_SESSION['iCodPerfilLogin'] === '3') {
                    $porAprobar = '';
                    //echo "Punto de Control - Jefes";
                }elseif ($_SESSION['iCodPerfilLogin'] === '4') {
                    $porAprobar = '(Por Aprobar)';
                    //echo "Profesional";
                }elseif ($_SESSION['iCodPerfilLogin'] === '19') {
                    $porAprobar = '(Por Aprobar)';
                    //echo "Punto de Control - Asistentes";
                }elseif ($_SESSION['iCodPerfilLogin'] === '20') {
                    $porAprobar = '(Por Aprobar)';
                    //echo "Punto de Control - Especial";
                }
                ?>
                <div class="row">
                    <div class="col s12 m9">
                        <div class="card hoverable">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Datos del documento</legend>
                                    <div class="row">
                                        <div class="col m3 input-field">
                                            <select name="cCodTipoDoc" id="cCodTipoDoc" onChange="valorSelect('<?php echo $porAprobar; ?>')" >
                                                <option value="">Seleccione</option>
                                                <?php
                                                $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgSalida=1";
                                                $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                                                $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                    if($RsTipo['cCodTipoDoc'] === ($_POST['cCodTipoDoc']??'')){
                                                        $selecTipo='selected';
                                                    }else{
                                                        $selecTipo='';
                                                    }
                                                    echo utf8_encode('<option value='.$RsTipo['cCodTipoDoc'].' '.$selecTipo.'>'.$RsTipo['cDescTipoDoc'].'</option>');
                                                }
                                                sqlsrv_free_stmt($rsTipo);
                                                ?>
                                            </select>
                                            <label for="cCodTipoDoc">Tipo de Documento:</label>
                                        </div>
                                        <div class="col m6 input-field" >
                                            <input type="text" value="&nbsp;" id="posibleCodificacion" class="FormPropertReg form-control" readonly/>
                                            <label class="active" for="posibleCodificacion">Correlativo</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" value="&nbsp;" id="reloj" name="reloj" class="FormPropertReg form-control" onfocus="window.document.frmRegistro.reloj.blur()">
                                            <label class="active" for="reloj">Fecha de Registro</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m6 input-field">
                                            <textarea name="cAsunto" class="FormPropertReg materialize-textarea"><?=$_POST['cAsunto']??''?></textarea>
                                            <label for="cAsunto">Asunto</label>
                                        </div>
                                        <div class="col m6 input-field">
                                            <textarea name="cObservaciones" class="FormPropertReg materialize-textarea"><?=$_POST['cObservaciones']??''?></textarea>
                                            <label for="cObservaciones">Observaciones</label>
                                        </div>
                                        <div class="col s12 m12 input-field">
                                            <textarea name="editor" id="editor"></textarea>
                                        </div>
                                        <div class="col s1 input-field">
                                            <input id="nNumFolio" type="number" name="nNumFolio" value="<?php if($_POST['nNumFolio']??''===''){echo 1;} else { echo $_POST['nNumFolio'];}?>" class="FormPropertReg form-control" >
                                            <label for="nNumFolio">Folios</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <!--<fieldset style="display: none">
                                    <legend>Datos del remitente</legend>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <?php
                                            $sqlJefe = "SELECT iCodTrabajador FROM Tra_M_Perfil_Ususario WHERE iCodOficina = '".$_SESSION['iCodOficinaLogin']."' AND iCodPerfil = 3";
                                            $rsJefe = sqlsrv_query($cnx,$sqlJefe);
                                            $RsJefe = sqlsrv_fetch_array($rsJefe);
                                            if ($RsJefe['iCodTrabajador'] === $_SESSION['CODIGO_TRABAJADOR']) {
                                                $valor = 1;
                                                $codJefe = $RsJefe['iCodTrabajador'];
                                            }else{
                                                $valor = 0;
                                                $codJefe='';
                                            }
                                            ?>
                                            <input type="hidden" name="esJefe" value="<?php echo $valor; ?>">
                                            <input type="hidden" name="codJefe" value="<?php echo $codJefe; ?>">
                                            <input type="hidden" name="nFlgEnvio" value="0">
                                            <input type="hidden" name="cSiglaAutor" value="<?= $_SESSION['CODIGO_TRABAJADOR'] ?>">
                                            <select name="cSiglaAutor" id="cSiglaAutor" style="display:none" >
                                                <option value="">Seleccione:</option>
                                            </select>
                                            <label for="cSiglaAutor">Autor</label>
                                        </div>
                                    </div>
                                </fieldset>-->
                                <fieldset>
                                    <legend>Datos del destinatario</legend>
                                    <div class="row">
                                        <div class="col s12" id="areaRemitente">
                                            <div class="row">
                                                <div class="col s6 input-field">
                                                    <select id="cNombreRemitente" class="js-data-example-ajax browser-default"></select>
                                                    <label for="cNombreRemitente">Remitente</label>
                                                </div>
                                                <div class="col s6 input-field">
                                                    <input id="cNomRemite" name="cNomRemite" value="<?=isset($_POST['cNomRemite'])?>" class="FormPropertReg form-control">
                                                    <label class="active" for="cNomRemite">Dirección</label>
                                                    <button id="btnEditarRemitente" class="input-field__icon btn btn-link"><i class="fas fa-edit"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Referencias</legend>
                                    <div class="row">
                                        <div class="col m12">
                                            <select id="cReferencia" class="js-example-basic-multiple-limit browser-default" name="cReferencia[]" multiple="multiple"></select>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Archivo</legend>
                                    <div class="row">
                                        <div class="col m12 input-field">
                                            <textarea name="archivoFisico" id="archivoFisico" class="FormPropertReg form-control materialize-textarea"><?php echo trim($_POST['archivoFisico']??''); ?></textarea>
                                            <label for="archivoFisico">Archivo Físico</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Adjuntar Archivo</legend>
                                    <div class="row">
                                        <div class="file-field input-field col s12">
                                            <div id="dropzone" class="dropzone"></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $sqlOficina = "SELECT iCodOficina FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
                $rsOficina  = sqlsrv_query($cnx,$sqlOficina);
                $RsOficina  = sqlsrv_fetch_array($rsOficina);
                ?>
                <input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?=$_POST['iCodRemitente']??''?>">
                <input id="Remitente" name="Remitente" type="hidden" value="<?= $_POST['iCodRemitente']??'';?>">
                <input id="txtdirec_remitente" name="txtdirec_remitente" type="hidden" value="<?=$_POST['txtdirec_remitente']??''?>">
                <input id="cCodDepartamento" name="cCodDepartamento" type="hidden" value="<?=$_POST['cCodDepartamento']??''?>">
                <input id="cCodProvincia" name="cCodProvincia" type="hidden" value="<?=$_POST['cCodProvincia']??''?>">
                <input id="cCodDistrito" name="cCodDistrito" type="hidden" value="<?=$_POST['cCodDistrito']??''?>">
                <?php if($_POST['radioSeleccion']??''===1){
                    echo  '<script language="javascript" type="text/javascript">';
                    echo 'activaMultiple();';
                    echo '</script>';
                }
                if($_POST['radioSeleccion']??''===2){
                    echo  '<script language="javascript" type="text/javascript">';
                    echo 'activaRemitente();';
                    echo '</script>';
                }?>
            </form>
        </div>
    </main>

    <div id="modalEditarRemitente" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Agregar o editar remitente</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            <input name="button" type="button" class="waves-effect waves-green btn-flat btn btn-secondary" value="Modificar" onClick="sendValue(document.frmRegistroRemitente.txtdirec_remitente,document.frmRegistroRemitente.cCodDepartamento,document.frmRegistroRemitente.cCodProvincia,document.frmRegistroRemitente.cCodDistrito);">
        </div>
    </div>

    <div id="modalRegRemitente" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Registro Remitente</h4>
        </div>
        <div class="modal-content">
            <form name="formRegRemitente" id="formRegRemitente" >
                <div class="col m6 input-field">
                    <textarea id="nRemitente" name="nRemitente"  class="materialize-textarea FormPropertReg"></textarea>
                    <label for="nRemitente">Nombre del remitente</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnRegistrarRemi" >Registrar</a>
        </div>
    </div>

    <form name="frmFirmas" action="firmarDocumento.php"  method="POST">
        <input type="hidden" name="menu" value="registroSalida.php">
        <input type="hidden" name="idtra" id="idtra">
        <input type="hidden" name="urlfirm" id="urlfirm">
    </form>
    <?php
    include 'includes/userinfo.php';
    include 'includes/pie.php';
    ?>
    <script src="ckeditor/ckeditor.js"></script>
    <script>
        
        $('#cReferencia.js-example-basic-multiple-limit').select2({
            placeholder: 'Seleccione y busque',
            maximumSelectionLength: 10,
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró la referencia.</p>";
                },
                "searching": function() {

                    return "Buscando..";
                },
                "inputTooShort": function() {

                    return "Ingrese más de 3 letras ...";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'ajax/ajaxReferencias.php',
                dataType: 'json',
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('#cNombreRemitente').select2({
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al remitente.</p><p><a href='#modalRegRemitente' class='btn modal-trigger btn-link'>¿Desea registrarlo?</a></p>";
                },
                "searching": function() {

                    return "Buscando..";
                },
                "inputTooShort": function() {

                    return "Ingrese más de 3 letras ...";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            ajax: {
                url: 'ajax/ajaxRemitentes.php',
                dataType: 'json',
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        function mueveReloj(){
            momentoActual = new Date()
            anho = momentoActual.getFullYear()
            mes = (momentoActual.getMonth())+1
            dia = momentoActual.getDate()
            hora = momentoActual.getHours()
            minuto = momentoActual.getMinutes()
            segundo = momentoActual.getSeconds()
            if((mes>=0)&&(mes<=9)){ mes="0"+mes; }
            if((dia>=0)&&(dia<=9)){ dia="0"+dia; }
            if((hora>=0)&&(hora<=9)){ hora="0"+hora; }
            if((minuto>=0)&&(minuto<=9)){ minuto="0"+minuto; }
            if ((segundo>=0)&&(segundo<=9)){ segundo="0"+segundo; }
            horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo;
            //console.log(horaImprimible);
            document.frmRegistro.reloj.value=horaImprimible;
            setTimeout("mueveReloj()",1000)
        }


        function muestra(nombrediv) {
            if(document.getElementById(nombrediv).style.display == '') {
                document.getElementById(nombrediv).style.display = 'none';
            } else {
                document.getElementById(nombrediv).style.display = '';
            }
        }

        function activaRemitente() {
            document.frmRegistro.radioMultiple.checked = false;
            document.frmRegistro.radioRemitente.checked = true;
            document.frmRegistro.iCodRemitente.value=document.frmRegistro.Remitente.value;
            document.frmRegistro.radioSeleccion.value="2";
            muestra('areaRemitente');
            document.frmRegistro.cNombreRemitente.focus();
            return false;
        }

        function activaMultiple(){
            document.frmRegistro.radioMultiple.checked  = true;
            document.frmRegistro.radioRemitente.checked = false;
            document.frmRegistro.iCodRemitente.value    = 0;
            document.frmRegistro.radioSeleccion.value   = "1";
            document.getElementById('areaRemitente').style.display = 'none';
            return true;
        }

        function buscarRemitente(){
            window.open('registroRemitentesSalidaLs.php','popuppage','width=735,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');
        }

        function infoRemitente() {
            var w = document.frmRegistro.txtdirec_remitente.value;
            var x = document.frmRegistro.cCodDepartamento.value;
            var y = document.frmRegistro.cCodProvincia.value;
            var z = document.frmRegistro.cCodDistrito.value ;
            var t = document.frmRegistro.iCodRemitente.value;

            window.open('registroRemitenteDetalle.php?iCodRemitente='+t+'&txtdirec_remitentex='+w+'&cCodDepartamentox='+x+'&cCodProvinciax='+y+'&cCodDistritox='+z,'popuppage','width=590,height=240,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');
        }

        function AddOficina(){
            if (document.frmRegistro.iCodOficinaMov.value.length == "")
            {
                alert("Seleccione Oficina");
                document.frmRegistro.iCodOficinaMov.focus();
                return (false);
            }
            if (document.frmRegistro.iCodTrabajadorMov.value.length == "")
            {
                alert("Seleccione Trabajador");
                document.frmRegistro.iCodTrabajadorMov.focus();
                return (false);
            }
            if (document.frmRegistro.iCodIndicacionMov.value.length == "")
            {
                alert("Seleccione Indicación");
                document.frmRegistro.iCodIndicacionMov.focus();
                return (false);
            }
            document.frmRegistro.opcion.value=23;
            document.frmRegistro.action="registroData.php";
            document.frmRegistro.submit();
        }

        function Registrar(){
            if (document.frmRegistro.cCodTipoDoc.value.length == "")
            {
                alert("Seleccione Tipo Documento");
                document.frmRegistro.cCodTipoDoc.focus();
                return false;
            }

            if (document.frmRegistro.nNumFolio.value.length == "")
            {
                alert("Ingrese Número de Folios");
                document.frmRegistro.nNumFolio.focus();
                return false;
            }

            if (document.frmRegistro.iCodRemitente.value.length == "")
            {
                document.frmRegistro.iCodRemitente.value=-1;
            }
        }

        function releer(){
            document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>#area";
            document.frmRegistro.submit();
        }

        function copy(){

            if(document.frmRegistro.cNombreRemitente.value.length!="" ){
                document.getElementById('areaCopiaOficina').style.display = '';
                return false;
            }

            else if(document.frmRegistro.cNombreRemitente.value.length=="" ){
                document.getElementById('areaCopiaOficina').style.display = 'none';
                return false;
            }
        }

        var miPopup;
        function Buscar(){
            miPopup=window.open('registroBuscarDoc.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
        }

        $("#btnRegistrarRemi").on('click', function (e) {
            e.preventDefault();
            let elems = document.querySelector('#modalRegRemitente');
            let instance = M.Modal.getInstance(elems);
            let nombre = $('#formRegRemitente #nRemitente').val();
            $.ajax({
                cache: false,
                url: 'registrarRemitente.php',
                method: 'POST',
                data: {nombre: nombre},
                datatype: 'text',
                success: function (response) {
                    instance.close();
                    M.toast({html: response});
                }
            });
        });

    </script>
    <script>
        $(document).ready(function() {

            CKEDITOR.replace( 'editor');
            CKEDITOR.config.pasteFromWordRemoveFontStyles = true;

            $('.majorpoints').click(function(){
                $('.hiders').toggle("slow");
            });

            $("#btnEditarRemitente").on('click', function(e) {
                e.preventDefault();
                let editarRemitente = document.querySelector('#modalEditarRemitente');
                let editarRemitenteInstance = M.Modal.getInstance(editarRemitente);
                $.ajax({
                    cache: false,
                    url: "registroRemitenteDetalle.php",
                    method: "POST",
                    //data: {},
                    datatype: "json",
                    success : function(response) {
                        //console.log(response);
                        $('#modalEditarRemitente div.modal-content').html(response);
                        editarRemitenteInstance.open();
                    }
                });
            });
        });


    </script>
    <script src="includes/dropzone.js"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
            url: "registerDoc/registrarDocumentoSalida.php",
            paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
            autoProcessQueue: false,
            maxFiles: 10,
            acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
            addRemoveLinks: true,
            maxFilesize: 1200, // MB
            uploadMultiple: true,
            parallelUploads: 10,

            dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
            dictInvalidFileType: "Archivo no válido",
            dictMaxFilesExceeded: "Solo 2 archivos son permitidos",
            dictCancelUpload: "Cancelar",
            dictRemoveFile: "Remover",
            dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
            dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
            dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",

            init: function () {
                // First change the button to actually tell Dropzone to     process the queue.
                var myDropzone = this;

                $("#rsit").on("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    $("#iCodRemitente").val($("#cNombreRemitente").val());
                    //if (Registrar()){
                        console.log('entraaa');
                        queuedFiles = myDropzone.getQueuedFiles();
                        if ((queuedFiles.length > 0)) {
                            myDropzone.processQueue();
                        }else{
                            var blob = new Blob();
                            blob.upload = { 'chunked': myDropzone.defaultOptions.chunking };
                            myDropzone.uploadFile(blob);
                        }
                    //}
                    /*if (Registrar()){
                        queuedFiles = myDropzone.getQueuedFiles();
                        if ((queuedFiles.length > 0)) {
                            myDropzone.processQueue();
                        }else{
                            var blob = new Blob();
                            blob.upload = { 'chunked': myDropzone.defaultOptions.chunking };
                            myDropzone.uploadFile(blob);
                        }
                        debugger;
                        console.log('ferferw');
                    }*/
                });
                this.on('sending', function(file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    CKEDITOR.instances.editor.updateElement();
                    //seleccionar('lstTrabajadoresSel');
                    var data = $('#frmRegistro').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                    getSpinner('generando Documento');
                });

                this.on('sendingmultiple', function(file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    console.log("multiple");
                    CKEDITOR.instances.editor.updateElement();
                    var data = $('#frmRegistro').serializeArray();
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
                    console.log("error");
                    console.log(response);
                });
                // on success
                this.on("success", function(file, response) {
                    // submit form
                    deleteSpinner();
                    /*$("body").append(response);
                    document.form_envio.submit();*/
                    var json = eval('(' + response + ')');
                    console.log(response);
                    console.log("Registro Concluido");
                    console.log(json['tra']);
                    $('#idtra').val(json['tra']);
                    $('#urlfirm').val(json['url']);
                    document.frmFirmas.submit();
                });

            }
        });

        /*$('#cCodTipoDoc').on('change', function () {
            const codTipoDoc = $('#cCodTipoDoc').val();
            CKEDITOR.instances.editor.setData('');
            $.ajax({
                cache : false,
                method : "POST",
                url : "ajax/parametrosPlantilla.php",
                data : { codigo : codTipoDoc },
                datatype : "json",
                success : function (response) {
                    var res = eval('(' + response + ')');
                    if (res.flag == 1 ){
                        console.log('Tiene parametros');
                        const param = eval('(' + res.editables + ')');
                        let htmltext ='';
                        param.forEach(function (valor) {
                            htmltext +="<div id='"+valor+"'><h1 id='lab-"+valor+"' contenteditable='false' disabled='isReadOnly' >"+valor+"</h1><div><p id='cont-"+valor+"'>......................................<br></p></div></div>"
                        } );
                        CKEDITOR.instances.editor.insertHtml(htmltext);
                    } else {
                        console.log('No tiene parametros');
                    }
                }
            });
        });*/
        function valorSelect(porAprobar){
            var cCodTipoDoc = document.getElementById("cCodTipoDoc").value;
            var parametros = {
                'cCodTipoDoc' : cCodTipoDoc,
                'iCodOficina' : <?php echo $_SESSION['iCodOficinaLogin']; ?>,
                'nNumAno'			: <?php echo $nNumAno; ?>
            };

            $.ajax({
                type: 'POST',
                url: 'ajaxCorrelativoSalida.php',
                data: parametros,
                dataType: 'json',
                success: function(correlativo){
                    console.log(correlativo);
                    var correlativo = correlativo;
                    $.each(correlativo,function(index,value)
                    {
                        $('#posibleCodificacion').val(value + " "+ porAprobar);
                        const codTipoDoc = $('#cCodTipoDoc').val();
                        if (CKEDITOR.instances.editor.getData()){
                            CKEDITOR.instances.editor.setData('');
                        }
                        $.ajax({
                            cache : false,
                            method : "POST",
                            url : "ajax/parametrosPlantilla.php",
                            data : { codigo : codTipoDoc },
                            datatype : "json",
                            success : function (response) {
                                var res = eval('(' + response + ')');
                                if (res.flag == 1 ){
                                    console.log('Tiene parametros');
                                    const param = eval('(' + res.editables + ')');
                                    let htmltext ='';
                                    param.forEach(function (valor) {
                                        htmltext +="<div id='"+valor+"'><h1 id='lab-"+valor+"' contenteditable='false' disabled='isReadOnly' >"+valor+"</h1><div><p id='cont-"+valor+"'></p></div></div>"
                                    } );
                                    CKEDITOR.instances.editor.insertHtml(htmltext);
                                } else {
                                    console.log('No tiene parametros');
                                }
                            }
                        });
                    });
                },
                error: function(e){
                    console.log(e);
                    alert('Error Processing your Request 6!!');
                }
            });

        }

    </script>
    </body>
    </html>

    <?php
} else {
    header("Location: ../index-b.php?alter=5");
}
?>
