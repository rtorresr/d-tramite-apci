<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$pageTitle = "Registro Interno del Trabajador";
$activeItem = "registroTrabajador.php";
$navExtended = true;

    if (!isset($_SESSION["cCodRef"])){
        $fecSesRef = date("Ymd-Gis");
        $_SESSION['cCodRef'] = $_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesRef;
    } else {
        unset($_SESSION["cCodRef"]);
        $fecSesRef = date("Ymd-Gis");
        $_SESSION['cCodRef'] = $_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesRef;
    }
    if (!isset($_SESSION["cCodOfi"])){
        $fecSesOfi=date("Ymd-Gis");
        $_SESSION['cCodOfi']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesOfi;
    } else {
        unset($_SESSION["cCodOfi"]);
        $fecSesOfi=date("Ymd-Gis");
        $_SESSION['cCodOfi']=$_SESSION['CODIGO_TRABAJADOR']."-".$_SESSION['iCodOficinaLogin']."-".$fecSesOfi;
    }

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
                        <li><a class="btn btn-primary" id="rsit" href="#" value="Registrar" ><i class="fas fa-save fa-fw left"></i>Registrar</a></li>
                    </ul>
                </div>
            </nav>
        </div>
         <div class="container">
            <form name="frmRegistro" id="frmRegistro" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="opcion" value="">
                <div class="row">
                    <div class="col s12 m8 l9">
                        <div class="card hoverable">
                            <div class="card-body" id="formDocumento">
                                <fieldset >
                                    <legend id="firmarDoc">Datos del documento</legend>
                                    <div class="row" id="bodyFirmar">
                                        <div class="col s12 m6 input-field">
                                            <?php
                                            $sqlTipo = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc = 27";
                                            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                            $RsTipo=sqlsrv_fetch_array($rsTipo);
                                            ?>
                                            <select id="cCodTipoDoc"  disabled class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                                <?= "<option value='".$RsTipo['cCodTipoDoc']."' selected >".ucwords(strtolower($RsTipo['cDescTipoDoc']))."</option>";?>
                                            </select>
                                            <input type="hidden"name="cCodTipoDoc" value="<?=$RsTipo['cCodTipoDoc']?>">
                                            <label for="cCodTipoDoc" class="active">Tipo de Documento</label>
                                        </div>
                                        <div class="col s6 m3 input-field">
                                            <input placeholder="dd-mm-aaaa" value="<?=$_GET['fFecPlazo']??''?>" type="text" id="fFecPlazo" name="fFecPlazo" class="FormPropertReg form-control datepicker">
                                            <label for="fFecPlazo">Fecha del Plazo</label>
                                        </div>
                                        <div class="col s6 m3 input-field">
                                            <input type="text" value="&nbsp;" id="FormPropertReg" name="reloj" class="FormPropertReg" disabled onfocus="window.document.frmRegistro.reloj.blur()">
                                            <label class="active" for="FormPropertReg">Fecha de Registro</label>
                                        </div>
                                        <div class="col s12 m6 input-field">
                                            <textarea id="cAsunto" name="cAsunto"  class="materialize-textarea  FormPropertReg form-control"></textarea>
                                            <label for="cAsunto">Asunto</label>
                                        </div>
                                        <div class="col s12 m6 input-field">
                                            <textarea id="cObservaciones" name="cObservaciones"  class="materialize-textarea  FormPropertReg form-control"></textarea>
                                            <label for="cObservaciones">Observaciones</label>
                                        </div>
                                        <div class="col s12 m6 input-field">
                                            <select id="iCodIndicacion" name="iCodIndicacion[]" multiple class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                                <!-- <option value="">Seleccione</option> -->
                                                <?php
                                                $sqlIndic="SELECT * FROM Tra_M_Indicaciones where flgInterno = 1";
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
                                        <div class="col s12 m12 input-field">
                                            <textarea name="editor" id="editor">
                                            </textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                    <?php
                                          //check if is boss
                                                $sqljefe = "SELECT iCodTrabajador as jefe FROM dbo.Tra_M_Perfil_Ususario where iCodPerfil=3 and iCodOficina =".$_SESSION['iCodOficinaLogin']." and iCodTrabajador = ".$_SESSION['CODIGO_TRABAJADOR'];
                                                $qjefe=sqlsrv_query($cnx,$sqljefe);

                                                $qjefe=sqlsrv_fetch_array($qjefe);
                                                $indexJefe = 1;
                                                if ($qjefe['jefe']){
                                                    $indexJefe = 0;
                                                }

                                                //get office
                                                $sqlofi = "select cSiglaOficina as sigla  from Tra_M_Oficinas where iCodOficina = (select iCodOficina from Tra_M_Trabajadores where iCodTrabajador = '".$_SESSION['CODIGO_TRABAJADOR']."' and iFlgEstado = 1)";

                                                $qofice=sqlsrv_query($cnx,$sqlofi);
                                                $siglaoficina=sqlsrv_fetch_array($qofice);

                                                if (strpos($siglaoficina['sigla'], '-')){
                                                    $arrayoficina = explode("-", $siglaoficina['sigla']);
                                                    $oficinajefe = $arrayoficina[$indexJefe];
                                                }else{
                                                    $oficinajefe = $siglaoficina;
                                                }
                                                if (trim($oficinajefe) == "MP"){
                                                    $oficinajefe = "UASG";
                                                }
                                                $sqlIDjefe = "SELECT iCodTrabajador,iCodOficina FROM dbo.Tra_M_Perfil_Ususario where iCodPerfil=3 and iCodOficina = (select iCodOficina  from Tra_M_Oficinas where cSiglaOficina like '%$oficinajefe')";
                                                $idJefe=sqlsrv_query($cnx,$sqlIDjefe);
                                                $idJefe=sqlsrv_fetch_array($idJefe);
                                                echo "<input type='hidden' value='".$idJefe['iCodTrabajador']."' name='lstTrabajadoresSel[]'/>";
                                                echo "<input type='hidden' name='iCodOficinaDerivar' value='".$idJefe['iCodOficina']."' >";

                                                ?>
                                    <input type="hidden" name="nFlgEnvio" value="1" class="form-check-input" id="nFlgEnvio"  >

                                </fieldset>
                            </div>
                        </div>
                    </div>
                                
                    <div class="col s12 m4 l3">
                        <div class="card hoverable transparent">
                            <div class="card-body">
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
            </form>
         </div>
         <form name="frmFirmas" action="firmarDocumento.php"  method="POST">
             <input type="hidden" name="menu" value="registroTrabajador.php">
             <input type="hidden" name="idtra" id="idtra">
             <input type="hidden" name="urlfirm" id="urlfirm">
         </form>
     </main>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    <script src="ckeditor/ckeditor.js"></script>
    <script>
        //CKEDITOR.replace( 'editor' );
        CKEDITOR.replace( 'editor', {
            language: 'es'
        });
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.pasteFromWordRemoveFontStyles = true;
        //CKEDITOR.config.protectedSource(/<i[^>]*>>\/i/g);

        $('.datepicker').datepicker({
            i18n: {
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"],
                cancel: "Cancelar",
                clear: "Limpiar"
            },
            format: 'dd-mm-yyyy',
            //formatSubmit: 'dd-mm-yyyy',
            disableWeekends: true,
            autoClose: true,
            showClearBtn: true
        });
    $('.mdb-select').formSelect();

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
        function agregar(){
            var bNoAgregar;
            bNoAgregar=false;

            for(i=0; i<=document.frmRegistro.lstTrabajadores.length-1; i++){
                if(document.frmRegistro.lstTrabajadores.options[i].selected){
                    for(z=0;z<=document.frmRegistro.lstTrabajadoresSel.length-1;z++){
                        if(document.frmRegistro.lstTrabajadores.options[i].text==document.frmRegistro.lstTrabajadoresSel.options[z].text){
                            alert("El Trabajador ''" + document.frmRegistro.lstTrabajadores.options[i].text + "'' ya esta añadido!");
                            bNoAgregar=true;
                            break;
                        }
                    }
                    if(bNoAgregar==false){
                        document.frmRegistro.lstTrabajadoresSel.length++;
                        document.frmRegistro.lstTrabajadoresSel.options[document.frmRegistro.lstTrabajadoresSel.length-1].text= document.frmRegistro.lstTrabajadores.options[i].text;
                        document.frmRegistro.lstTrabajadoresSel.options[document.frmRegistro.lstTrabajadoresSel.length-1].value= document.frmRegistro.lstTrabajadores.options[i].value;
                    }
                }
            }
        }
        function retirar(tipoLst){
            var ArrayProvincias=new Array();
            var ArrayProfesiones=new Array();
            var Contador;
            Contador=0;
            for(i=0;i<=document.frmRegistro.lstTrabajadoresSel.length-1;i++){
                if((document.frmRegistro.lstTrabajadoresSel.options[i].text!="")&&(document.frmRegistro.lstTrabajadoresSel.options[i].selected==false)){
                    ArrayProvincias[Contador]=document.frmRegistro.lstTrabajadoresSel.options[i].text;
                    Contador=Contador+1;
                }
            }
            document.frmRegistro.lstTrabajadoresSel.length=Contador;
            for(i=0;i<Contador;i++){
                document.frmRegistro.lstTrabajadoresSel.options[i].text=ArrayProvincias[i];
            }
        }
        function seleccionar(obj) {
            Elem=document.getElementById(obj).options;
            for(i=0;i<Elem.length;i++)
                Elem[i].selected=true;
        }
        function Registrar(){
            if (document.frmRegistro.cAsunto.value.length == "")
            {
                alert("Ingrese Asunto o Asunto");
                document.frmRegistro.cAsunto.focus();
                return false;
            }

            return true;
        }

        function envioParaFirma(codigo) {
            $.ajax({
                cache: false,
                url: "ajax/ajaxPostergarFirma.php",
                method: "POST",
                data: {iCodTramite: codigo},
                datatype: "json",
                success: function () {
                    console.log('Contingencia de envio a bandeja por aprobar');
                }
            });
        }

</script>
    <script src="includes/dropzone.js"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
            url: "registerDoc/registrarDocumentoInterno.php",
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
                    if (Registrar()){
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

                this.on('sendingmultiple', function(file, xhr, formData) {
                    console.log("multiple");
                    // Append all form inputs to the formData Dropzone will POST
                    CKEDITOR.instances.editor.updateElement();
                    //seleccionar('lstTrabajadoresSel');
                    var data = $('#frmRegistro').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                    getSpinner('generando Documento');
                });
                // on error
                this.on("error", function(file, response) {
                    console.log("error");
                    console.log(response);
                });
                // on success
                this.on("successmultiple", function(file, response) {
                    // submit form
                    var json = eval('(' + response + ')');
                    console.log(response);
                    console.log("Registro Concluido");
                    console.log(json['tra']);
                    envioParaFirma(json['tra']);
                    $('#idtra').val(json['tra']);
                    $('#urlfirm').val(json['url']);
                    deleteSpinner();
                    document.frmFirmas.submit();
                });
            }
        });


        $(document).ready(function () {
            $.ajax({
                cache : false,
                method : "POST",
                url : "ajax/parametrosPlantilla.php",
                data : { codigo : 27 },
                datatype : "json",
                success : function (response) {
                    var res = eval('(' + response + ')');
                    if (res.flag == 1 ){
                        console.log('Tiene parametros');
                        const param = eval('(' + res.editables + ')');
                        htmltext = '';
                        param.forEach(function (valor) {
                           htmltext +="<div class='subtitle'><h3 contenteditable='false' >"+valor+"</h3><div><p class='clase-par'></p></div></div>"
                        } );
                        CKEDITOR.instances.editor.setData(htmltext);
                    } else {
                        console.log('No tiene parametros');
                    }
                }
            });
        });


    </script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>