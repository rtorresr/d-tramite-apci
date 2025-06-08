<?php
session_start();

$pageTitle = "Registro sin TUPA";
$activeItem = "registroSinTupa.php";
$navExtended = true;


if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link href="includes/component-dropzone.css" rel="stylesheet">
</head>
<body class="theme-default has-fixed-sidenav" onload="mueveReloj()">

<?php include("includes/menu.php");?>

<!--Main layout--> 
<main>     
    <div class="navbar-fixed actionButtons">
        <nav>
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="">
                    <li><button type="button" id="rsit" class="btn btn-primary" value="Registrar" ><i class="fas fa-save fa-fw left"></i>Registrar</button></li>
                    <li><button id="btnReference" class="btn btn-link" ><i class="fas fa-plus fa-fw left"></i> Agregar Referencia</button></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container">          
        <form  name="frmRegistro"  id="frmRegistro" method="POST" enctype="multipart/form-data" >
            <div class="row">
                <div class="col s12 m9">
                    <div class="card hoverable">
                        <div class="card-body">
                            <fieldset>
                                <legend>Datos del documento</legend>
                                <div class="row">
                                    <div class="col m3 input-field">
                                        <select name="cCodTipoDoc" class="form-control-sm mdb-select colorful-select dropdown-primary"   searchable="Buscar aqui..">
                                            <option value="">Seleccione:</option>
                                            <?php
                                            include_once("../conexion/conexion.php");
                                            $sqlTipo = "SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgEntrada = 1 ORDER BY cDescTipoDoc ASC";
                                            $rsTipo  = sqlsrv_query($cnx,$sqlTipo);
                                            while ($RsTipo = sqlsrv_fetch_array($rsTipo)){

                                                if ($RsTipo['cCodTipoDoc'] == ($_POST['cCodTipoDoc']??'')){
                                                    $selecTipo="selected";
                                                }

                                                else{
                                                    $selecTipo = "";
                                                }
                                                echo utf8_encode("<option value=".$RsTipo['cCodTipoDoc']." ".$selecTipo.">".ucwords(strtolower($RsTipo['cDescTipoDoc']))."</option>");
                                            }
                                            sqlsrv_free_stmt($rsTipo);
                                            ?>
                                        </select>
                                        <label for="cNroDocumento">Tipo de documento</label>
                                    </div>    
                                    <div class="col m3 input-field">
                                        <input type="text" name="cNroDocumento" <?php (isset($fondo1)??'')?> value="<?php echo stripslashes((isset($_POST['cNroDocumento']))?$_POST['cNroDocumento']:'');?>"   id="cNroDocumento" required>
                                        <label for="cNroDocumento">Número de documento</label>
                                        <?php
                                        if(isset($_POST['cNroDocumento']))
                                            if(trim($_POST['cNroDocumento'])!==""){
                                                $sqlChek = "SELECT cNroDocumento FROM Tra_M_tramite WHERE cNroDocumento = '".$_POST['cNroDocumento']."'";
                                                $rsChek  = sqlsrv_query($cnx,$sqlChek);
                                                $numChek = sqlsrv_has_rows($rsChek);
                                                if ($numChek>0) {
                                                    $fondo1 = "style=background-color:#FF3333;color:#000"; $eti="<span class='helper-text' data-error='wrong' data-success='right'>El número ingresado ya existe</span>";
                                                }
                                            }
                                        ?>
                                        <button type="button" class="input-field__icon btn btn-link" onclick="releer();">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <?php (isset($eti)??'')?>
                                    </div>
                                    <div class="col m3 input-field">
                                        <input placeholder="dd-mm-aaaa" value="<?php ((isset($_POST['fechaDocumento']))?$_POST['fechaDocumento']:'')?>" type="text"
                                            id="date-picker-example" name="fechaDocumento" class="FormPropertReg form-control datepicker">
                                        <label for="date-picker-example">Fecha del Documento</label>
                                    </div>
                                    <div class="col m3 input-field">
                                        <input type="text" value="&nbsp;" name="reloj" id="FormPropertReg" class="disabled"  onfocus="window.document.frmRegistro.reloj.blur()">
                                        <label for="FormPropertReg">Fecha de Registro</label>
                                    </div>
                                    <div class="col m6 input-field">
                                        <textarea type="text" name="cAsunto" id="cAsunto" class="materialize-textarea"><?php ((isset($_POST['cAsunto']))?$_POST['cAsunto']:'')?></textarea>
                                        <label for="cAsunto">Asunto</label>
                                    </div>
                                    <div class="col m6 input-field">
                                        <textarea type="text"  name="cObservaciones" id="cObservaciones"class="materialize-textarea" rows="1"><?php ((isset($_POST['cObservaciones']))?$_POST['cObservaciones']:'')?></textarea>
                                        <label for="cObservaciones">Observaciones</label>
                                    </div>
                                    <div class="col m1 input-field">
                                        <input type="number" min=1 name="nNumFolio" value="<?php if(($_POST['nNumFolio']??'')==""){echo 1;} else { echo $_POST['nNumFolio'];}?>" class="FormPropertReg form-control"  />
                                        <label class="active">Folios</label>
                                    </div>
                                    <div class="col m5 input-field">
                                        <select id="iCodIndicacion" name="iCodIndicacion" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                            <option value="">Seleccione:</option>
                                            <?php
                                            $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                                            $sqlIndic .= "ORDER BY cIndicacion ASC";
                                            $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                            
                                            while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                                if(($RsIndic['iCodIndicacion']??'')==($_POST['iCodIndicacion']??'') OR ($RsIndic['iCodIndicacion']??'')==3){
                                                    $selecIndi="selected";
                                                }Else{
                                                    $selecIndi="";
                                                }
                                                echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".trim($RsIndic["cIndicacion"])."</option>";
                                            }

                                            sqlsrv_free_stmt($rsIndic);
                                            ?>
                                        </select>
                                        <label form="iCodIndicacion">Indicaci&oacute;n</label>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Datos del remitente</legend>
                                <div class="row">
                                    <div class="col l6 input-field">
                                        <input id="cNombreRemitente" placeholder="Remitente / Instituci&oacute;n:" type="search" name="cNombreRemitente" class="form-control form-control-sm" value="<?php utf8_encode($_POST['cNombreRemitente']??'')?>"  readonly>
                                        <label for="cNombreRemitente" class="active">Remitente / Instituci&oacute;n:</label>
                                        <a style="right:3rem" class="input-field__icon btn btn-link" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">
                                            <i class="fas fa-search"></i>
                                        </a>
                                        <a class="input-field__icon btn btn-link" href="javascript:;" onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                        <input id="iCodRemitente" name="iCodRemitente" type="hidden" value="<?php $_POST['iCodRemitente']??''?>">
                                        <input id="Remitente" name="Remitente" type="hidden" value="<?php $_POST['iCodRemitente']??''?>">
                                    </div>
                                    <div class="col l6 input-field">
                                        <input type="text"  name="cNomRemite" class="form-control form-control-sm" value="<?php ((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>"   id="cNomRemite" required>
                                        <label for="cNomRemite">Responsable</label>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Datos del destinatario</legend>
                                <div class="row">
                                    <div class="col m6 input-field">
                                        <select id="iCodOficinaResponsable" name="iCodOficinaResponsable" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." onChange="loadResponsables(this.value);">
                                            <option value="">Seleccione</option>
                                            <?php
                                                $sqlDep2 = "SELECT * FROM Tra_M_Oficinas 
                                                            WHERE iFlgEstado != 0 
                                                            ORDER BY cNomOficina ASC"; //AND iCodOficina != $iCodOficinaVirtual
                                                //$sqlDep2 = " SP_OFICINA_LISTA_COMBO ";
                                                $rsDep2  = sqlsrv_query($cnx,$sqlDep2);
                                                
                                                while ($RsDep2 = sqlsrv_fetch_array($rsDep2)){
                                                    if ($RsDep2['iCodOficina'] === ($_POST['iCodOficinaResponsable']??'')){
                                                        $selecOfi = "selected";
                                                    }else{
                                                        $selecOfi = "";
                                                    }
                                                    echo "<option value=".$RsDep2['iCodOficina']." ".$selecOfi.">".trim($RsDep2['cNomOficina'])." | ".trim($RsDep2["cSiglaOficina"])."</option>";
                                                }
                                                sqlsrv_free_stmt($rsDep2);
                                            ?>
                                        </select>
                                        <label for="iCodOficinaResponsable">Oficina</label>
                                    </div>
                                    <div class="col m6 input-field">
                                        <select name="iCodTrabajadorResponsable" id="responsable" class="FormPropertReg colorful-select dropdown-primary"></select>
                                        <label for="iCodTrabajadorResponsable">Responsable</label>
                                    </div>
                                    <div class="col m6">
                                        <div class="form-check">
                                            <label class="form-check-label" for="materialChecked2">
                                                <input type="checkbox" name="ActivarDestino" class="form-check-input" id="materialChecked2" >
                                                <span>Derivar inmediatamente</span>
                                            </label>
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
                                        <ul class="collection">
                                        <?php
                                            $sqlRefs = "SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='".($_SESSION['cCodRef']??'')."'";
                                            // echo $sqlRefs;
                                            $rsRefs = sqlsrv_query($cnx,$sqlRefs);
                                            while ($RsRefs = sqlsrv_fetch_array($rsRefs)){ ?>
                                                <li class="collection-item">
                                                    <div>
                                                        <?php echo $RsRefs['cReferencia']?>
                                                        <a class="secondary-content" href="registroData.php?iCodReferencia=<?=($RsRefs['iCodReferencia']??'')?>&opcion=19&iCodTramite=<?=$_GET['iCodTramite']??''?>&sal=1&URI=<?=$_GET['URI']??''?>&radioSeleccion=<?=$_POST['radioSeleccion']??''?>&cNombreRemitente=<?=$_POST['cNombreRemitente']??''?>&iCodTrabajadorResponsable=<?=$_POST['iCodTrabajadorResponsable']??''?>&iCodOficinaResponsable=<?=$_POST['iCodOficinaResponsable']??''?>&cNroDocumento=<?=$_POST['cNroDocumento']??''?>&cNomRemite=<?=$_POST['cNomRemite']??''?>&ActivarDestino=<?=$_POST['ActivarDestino']??''?>&iCodRemitente=<?=$_POST['iCodRemitente']??''?>&Remitente=<?=$_POST['Remitente']??''?>&cCodTipoDoc=<?=$_POST['cCodTipoDoc']??''?>&cAsunto=<?=$_POST['cAsunto']??''?>&cObservaciones=<?=$_POST['cObservaciones']??''?>&nNumFolio=<?php $_POST['nNumFolio']??''?>&nFlgEnvio=<?php $_POST['nFlgEnvio']??''?>&cSiglaAutor=<?php $_POST['cSiglaAutor']??''?>&archivoFisico=<?php $_POST['archivoFisico']??''?>">

                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                        </ul>
                                        <input type="hidden" readonly="readonly" name="cReferencia" value="<?php if(($_GET['clear']??'')===''){ echo trim($RsRefs['cReferencia']??''); }else{ echo trim(($_POST['cReferencia']??''));}?>" class="FormPropertReg form-control" style="width:140px;text-transform:uppercase" />
                                        <input type="hidden" name="iCodTramiteRef" value="<?php $_REQUEST['iCodTramiteRef']??''?>"  />
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Archivo</legend>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                    <?php
                                        if (empty($_FILES['fileUpLoadDigital']['name'] )) {
                                            $fileUploadDigital = $_FILES['fileUpLoadDigital']['name'] ?? '';
                                            if ($fileUploadDigital != null) {
                                                $_SESSION['ArchivoPDF'] = $_FILES['fileUpLoadDigital']['tmp_name'] . "/" . $_FILES['fileUpLoadDigital']['name'];
                                                echo $_FILES['fileUpLoadDigital']['name'];
                                            }
                                        }
                                        ?>

                                        <div id="dropzone" class="dropzone" style="width:100%"></div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="opcion" value="1">
            <input type="hidden" name="sal" value="1">
            <input type="hidden" name="nFlgClaseDoc" value="2">
            <input type="hidden" name="nFlgEnvio" value="<?php if(($_POST['ActivarDestino']??'')===1) echo "1"?>">
        </form>
    </div>
</main>

<div id="modalReference" class="modal modal-fixed-footer modal-fixed-header">
    <div class="modal-header">
        <h4>Agregar referencia</h4>
    </div>
    <div class="modal-content"></div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>

<div id="modalConcluido" class="modal modal-fixed-footer modal-fixed-header">
    <div class="modal-header">
        <h4>Registro concluido</h4>
    </div>
    <div class="modal-content"></div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>
    <script>

        function activaDestino(){
            if (document.frmRegistro.nFlgEnvio.value == 1){
                document.frmRegistro.nFlgEnvio.value="";
            }else{
                document.frmRegistro.nFlgEnvio.value=1;
            }
            return false;
        }

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
            horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo
            document.frmRegistro.reloj.value=horaImprimible
            setTimeout("mueveReloj()",1000)
        }



        function activaDerivar(){
            document.frmRegistro.action="<?php $_SERVER['PHP_SELF']?>";
            document.frmRegistro.submit();
            return false;
        }

        function releer(){
            document.frmRegistro.action="<?php $_SERVER['PHP_SELF']?>#area";
            document.frmRegistro.submit();
        }



        function Registrar()
        {
            if (document.frmRegistro.cCodTipoDoc.value.length == "")
            {
                alert("Seleccione Tipo de Documento");
                document.frmRegistro.cCodTipoDoc.focus();
                return false;
            }
            if (document.frmRegistro.cNroDocumento.value.length == "")
            {
                alert("Ingrese Número del Documento");
                document.frmRegistro.cNroDocumento.focus();
                return false;
            }
            if (document.frmRegistro.iCodRemitente.value.length == "")
            {
                alert("Seleccione Remitente");
                return false;
            }
            if(document.frmRegistro.fechaDocumento.value.length==""){
                alert("Seleccione una fecha de documento");
                return false;
            }

            //  if (document.frmRegistro.nFlgEnvio.value==1)
            if (document.frmRegistro.nFlgEnvio.value=="")
            {
                if (document.frmRegistro.iCodOficinaResponsable.value.length == "")
                {
                    document.frmRegistro.nFlgEnvio.value=1;
                }
            }
            return true;
            /*document.frmRegistro.action="registroData.php";
            document.frmRegistro.submit();*/
        }
       </script>
    <script>
        // Data Picker Initialization
        $('.datepicker').datepicker({
            monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            format: 'dd-mm-yyyy',
            formatSubmit: 'dd-mm-yyyy',
        });
        $('.mdb-select').formSelect();
        function loadResponsables(value)	{
            $('#responsable option').remove();
            var parametros = {
                        "iCodOficinaResponsable" : value
            };
            $.ajax({
                type: 'POST',
                url: 'loadResponsable.php', 
                data: parametros, 
                dataType: 'json',
                success: function(list){
                    $.each(list,function(index,value) 
                    {
                        $('#responsable').append($('<option>',{
                            value : value.iCodTrabajador,
                            text  : value.cNombresTrabajador.trim()+" "+value.cApellidosTrabajador.trim()
                        }));
                    });
                    $('#responsable').formSelect();
                },
                error: function(e){
                    console.log(e);
                    alert('Error Processing your Request!!');
                }
            });
            
        }


    </script>
    <script src="includes/dropzone.js"></script>
    <script>
        $(document).ready(function() {
            // Detail button
            $("#btnReference").on('click', function(e) {
                e.preventDefault();
                let elems = document.querySelector('#modalReference');
                let instance = M.Modal.getInstance(elems);
                $.ajax({
                    cache: false,
                    url: "registroBuscarDocEnt.php",
                    method: "POST",
                    //data: {},
                    datatype: "json",
                    success : function(response) {
                        //console.log(response);
                        $('#modalReference div.modal-content').html(response);
                        instance.open();
                    }
                });
            });
        });

        Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
                url: "registerDoc/regDocST.php",
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

                    $("#rsit").on("click", function(e) {
                        // Make sure that the form isn't actually being sent.
                        e.preventDefault();
                        e.stopPropagation();
                        flag = Registrar();
                        if (flag){
                            queuedFiles = myDropzone.getQueuedFiles();
                            if ((queuedFiles.length > 0)) {
                                myDropzone.processQueue();
                            }else{
                                var blob = new Blob();
                                blob.upload = { 'chunked': myDropzone.defaultOptions.chunking };
                                myDropzone.uploadFile(blob);
                            }
                        }

                    });
                    this.on('sending', function(file, xhr, formData) {
                        // Append all form inputs to the formData Dropzone will POST
                        var data = $('form').serializeArray();
                        $.each(data, function(key, el) {
                            formData.append(el.name, el.value);
                        });
                    });

                    this.on('sendingmultiple', function(file, xhr, formData) {
                        // Append all form inputs to the formData Dropzone will POST
                        console.log("multiple");
                        var data = $('form').serializeArray();
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
                        //$('#frmRegistro')[0].reset();
                        instance.open();
                    });

                }

        })

    </script>
</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>