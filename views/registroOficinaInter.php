<?php
session_start();
include_once("../conexion/parametros.php");
$pageTitle = "Registro de Entrada";
$activeItem = "registroEntrada.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){
    $url = RUTA_SIGTI_SERVICIOS."/ApiPide/token";
    $data = array(
        "UserName" =>  USUARIO_SSO,
        "Password" =>   PASSWORD_SSO,
        "grant_type" => GRANT_TYPE_SSO
    );

    $client = curl_init();
    curl_setopt($client, CURLOPT_URL, $url);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = json_decode(curl_exec($client));
    ?>
    <!DOCTYPE html>
    <html lang="es"> 
    <head>
        <?php include("includes/head.php");?>
        <link href="includes/component-dropzone.css" rel="stylesheet">
    </head>
    <body class="theme-default has-fixed-sidenav" onload="mueveReloj()">
    <?php include("includes/menu.php");?>
    <a name="area"></a>
    <main>
        <input id="token" type="hidden" value="<?php echo $response->token_type . ' ' . $response->access_token; ?>">
        
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><a class="btn btn-primary" id="registrar" ><i class="fas fa-save fa-fw left"></i>Registrar</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <form name="frmRegistro" id="frmRegistro" method="post" enctype="multipart/form-data">
            
                <div class="row">
                    <div class="col s12 m9">
                        <div class="card hoverable">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Datos del documento</legend>
                                    <div class="row">
                                        <div class="col s4 input-field">
                                            <div class="switch"></div>
                                        </div>
                                        <div class="col s4 offset-s4 input-field">
                                            <div class="switch">
                                                <label>
                                                    Trámites Generales
                                                    <input type="checkbox" id="nFlgClaseDoc" name="nFlgClaseDoc" value="1">
                                                    <span class="lever"></span>
                                                    Trámites Específicos
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col s6 input-field" style="display: none;">
                                            <input type="text" id="nroConstanciaSIGCTI">
                                            <label for="nroConstanciaSIGCTI">N° constancia SIGCTI</label>
                                            <button id="buscarConstancia" class="input-field__icon btn btn-link">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <input type="hidden" id="nroConstanciaSIGCTIEnvio" name="nroConstanciaSIGCTIEnvio" value="&nbsp;">
                                            <input type="hidden" id="codInscripcionSIGCTI" name="codInscripcionSIGCTI" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m3 input-field">
                                            <select id="cCodTipoDoc" name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary" >
                                            <?php
                                            include_once("../conexion/conexion.php");
                                            $sqlTipo="SELECT cCodTipoDoc,cDescTipoDoc FROM Tra_M_Tipo_Documento WITH(NOLOCK) WHERE cCodTipoDoc=27 ORDER BY cDescTipoDoc ASC";
                                            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                            while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                echo "<option value=".trim($RsTipo["cCodTipoDoc"]).">".trim($RsTipo["cDescTipoDoc"])."</option>";
                                            }
                                            sqlsrv_free_stmt($rsTipo);
                                            ?>
                                            </select>
                                            <label for="cCodTipoDoc">Tipo de Documento</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" id="cNroDocumento" name="cNroDocumento" class="materialize-textarea FormPropertReg">
                                            <input type="hidden" id="nCud" name="nCud" value="<?= isset($_GET['cud']) ? base64_decode($_GET['cud']) : '' ?>">
                                            <input type="hidden" id="COD_OFICINA_DERIVAR" name="COD_OFICINA_DERIVAR" value="<?= isset($_GET['idO']) ? base64_decode($_GET['idO']) : '' ?>">
                                            <input type="hidden" id="COD_TRABAJADOR_DERIVAR" name="COD_TRABAJADOR_DERIVAR" value="<?= isset($_GET['idT']) ? base64_decode($_GET['idT']) : '' ?>">
                                            <input type="hidden" id="SIDEMIEXT" name="SIDEMIEXT" value="<?= isset($_GET['idI']) ? base64_decode($_GET['idI']) : '' ?>">
                                            <label for="cNroDocumento">N° de Documento</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input placeholder="Seleccione fecha" value="" type="text" id="fechaDocumento" name="fechaDocumento" class="FormPropertReg formSelect datepicker">
                                            <label for="fechaDocumento">Fecha del Documento</label>
                                        </div>

                                        <div class="col m3 input-field input-disabled">
                                            <input type="text" value="&nbsp;" id="FormPropertReg" name="reloj" class="FormPropertReg"  onfocus="window.document.frmRegistro.reloj.blur()">
                                            <label class="active" for="FormPropertReg">Fecha de Registro</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m6 input-field">
                                            <textarea id="cAsunto" name="cAsunto"  class="materialize-textarea FormPropertReg"></textarea>
                                            <label for="cAsunto">Asunto</label>
                                        </div>
                                        <div class="col m6 input-field">
                                            <textarea id="cObservaciones" name="cObservaciones"  class="materialize-textarea FormPropertReg"></textarea>
                                            <label for="cObservaciones">Observaciones</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m6 input-field">
                                            <input type="number" id="nNumFolio" min="1" name="nNumFolio" value="1" class="FormPropertReg">
                                            <label class="active">Folios</label>
                                        </div>
                                        <div class="col s2 m2 input-field">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset id="datosTupa" style="display: none">
                                    <legend>Datos del Trámite Específico</legend>
                                    <div class="row">
                                        <div class="col m6 input-field">
                                            <select name="iCodTupaClase" id="iCodTupaClase" >
                                                <option value="">Seleccione:</option>
                                                <?php
                                                $sqlClas = "SELECT iCodTupaClase,cNomTupaClase FROM Tra_M_Tupa_Clase WITH(NOLOCK) ORDER BY iCodTupaClase ASC";
                                                $rsClas  = sqlsrv_query($cnx,$sqlClas);
                                                while ($RsClas = sqlsrv_fetch_array($rsClas)){
                                                    echo "<option value=".$RsClas["iCodTupaClase"]." >".$RsClas["cNomTupaClase"]."</option>";
                                                }
                                                sqlsrv_free_stmt($rsClas);
                                                ?>
                                            </select>
                                            <label>Clase de Procedimiento</label>
                                        </div>
                                        <div class="col m6 input-field">
                                            <select name="iCodTupa" id="iCodTupa">
                                            </select>
                                            <label>Procedimiento</label>
                                        </div>
                                        <div id="divRequisitos" style="display: none;" class="col m12">
                                            <label>Requisitos</label>
                                            <div>
                                                <a href="javascript:seleccionar_todo()">Marcar todos</a>
                                                <a href="javascript:deseleccionar_todo()">Desmarcar</a>
                                                <table cellpadding="0" cellspacing="2" border="0"  class="table" id="tRequisitos">
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                                <!--fieldset>
                                    <legend>Datos del Remitente</legend>
                                    <div class="row">
                                        <div class="col s12" id="areaRemitente">
                                            <div class="row">
                                                <div class="col s12 input-field">
                                                    <select id="iCodRemitente" name="iCodRemitente" class="js-data-example-ajax browser-default" data-nivel="0"></select>
                                                    <label for="iCodRemitente">Remitente / Institución:</label>
                                                    <input type="hidden" id="cNombreRemitente" name="cNombreRemitente" value="&nbsp;">
                                                </div>
                                                <input type="hidden" name="direccionRemi" id="direccionRemi" >
                                                <div class="col m6 input-field">
                                                    <input id="cNomRemitente" type="text" name="cNomRemitente">
                                                    <label for="cNomRemitente">Responsable</label>
                                                </div>
                                                <div class="col m6 input-field">
                                                    <input type="text" name="cCargoRemitente" id="cCargoRemitente">
                                                    <label for="cCargoRemitente">Cargo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset-->
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Referencias</legend>
                                    <div class="row">
                                        <select id="cReferencia" class="js-example-basic-multiple-limit browser-default" name="cReferencia[]" multiple="multiple"></select>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Archivo Principal</legend>
                                    <div class="subir">
                                        <div class="row">
                                            <div class="file-field input-field col s12">
                                                <div id="docPrincipal" class="dropzone" style="width:100%"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s12">
                                                <button type="button" class="btn btn-secondary" id="btnSubirDocPrincipal">Subir</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="boxArchivos">
                                        <div class="row" style="padding: 0 15px">
                                            <table id="tblPrincipal" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Archivo</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Anexos</legend>
                                    <div class="row">
                                        <div class="file-field input-field col s12">
                                            <div id="docAnexos" class="dropzone" style="width:100%"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <button type="button" class="btn btn-secondary" id="btnSubirDocAnexos">Subir</button>
                                        </div>
                                    </div>
                                    <div class="boxArchivos">
                                        <div class="row" style="padding: 0 15px">
                                            <table id="tblAnexos" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Archivo</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </main>

    <div id="modalConcluido" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Registro concluido</h4>
        </div>
        <div id="divHojaIngreso" class="modal-content"></div>
        <div class="modal-footer">
            <button type="button" class="modal-print btn-flat" onclick="print('divHojaIngreso','Hoja-de-Ingreso')">Imprimir</button>
            <a class="waves-effect waves-green btn-flat" id="btnConcluido" >Cerrar</a>
        </div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>

    <script src="includes/dropzone.js"></script>
    <script src="../conexion/global.js"></script>
    <script>
       function mueveReloj() {
           momentoActual = new Date();
           anho = momentoActual.getFullYear();
           mes = (momentoActual.getMonth())+1;
           dia = momentoActual.getDate();
           hora = momentoActual.getHours();
           minuto = momentoActual.getMinutes();
           segundo = momentoActual.getSeconds();
           
           if((mes>=0)&&(mes<=9)){
               mes="0"+mes;
           }
           if((dia>=0)&&(dia<=9)){
               dia="0"+dia;
           }
           if((hora>=0)&&(hora<=9)){
               hora="0"+hora;
           }
           if((minuto>=0)&&(minuto<=9)){
               minuto="0"+minuto;
           }
           if ((segundo>=0)&&(segundo<=9)){
               segundo="0"+segundo;
           }
           horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo;
           document.frmRegistro.reloj.value=horaImprimible;
           setTimeout("mueveReloj()",1000);
       }

       function ContenidosTipo(idDestino, codigoTipo){
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
                method: "POST",
                data: {codigo: codigoTipo},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    destino.append('<option value="0">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        function getPersonaInfo() {
            var nNumDocumento = $("#nNumDocumento");
            var valLenght = nNumDocumento.attr('maxLength');

            switch (valLenght) {
                case "8":
                    ajaxUrl = RutaSIGTID+"/ApiPide/Api/Reniec/REC_GET_0001?dni=";

                    var Persona = function(){};
                        Persona.prototype = {
                            Direccion: "",
                            EstadoCivil: "",
                            ImagenFoto: "",
                            Materno: "",
                            Nombres: "",
                            Numero: "",
                            Paterno: "",
                            Persona: "",
                            Restriccion: "",
                            Ubigeo: ""
                    };
                    break;
                default:
                    break;
            }

            nNumDocumento.on('keyup', function() {

                if($(this).val().replace(/\s+/g, '').length == valLenght) {
                    $.ajax({
                        url: ajaxUrl + nNumDocumento.val(),
                        method: "GET",
                        headers: {
                            'Authorization': $("#token").val(),
                        },
                        datatype: "application/json",
                        success: function (response) {
                            var persona = new Persona();
                            persona = response.EntityResult;
                            if (persona !== null) {
                                switch (valLenght) {
                                    case "8":
                                        $("#nRemitente").val(persona.Nombres + ' ' + persona.Paterno + ' ' + persona.Materno);
                                        $("label[for=nRemitente]").addClass("active");

                                        $("#direccion").val(persona.Direccion);
                                        $("label[for=direccion]").addClass("active");       
                                        break;
                                
                                    default:
                                        break;
                                }
                            }
                        }
                    });
                }
            });
        }
       
       $(function(){
           ContenidosTipo('idTipoRemitente', 30);

           $("#idTipoRemitente").change(function(){
            var persona = $("#idTipoRemitente").val();
            
            $("#nNumDocumento").removeAttr("disabled");
            //$("#nNumDocumento").val('');

            switch (persona) {
                case '60': //Natural
                    $(".pJuridica").hide();
                    $("label[for='nNumDocumento']").html("Número de DNI");
                    $("#nNumDocumento").attr('maxlength','8');
                    $('#nNumDocumento').attr('data-persona', 'natural');
                    $("span.nNumDocumento").html("Hasta 8 dígitos");
                    break;
                case '62': //Jurídica
                    $(".pJuridica").show();
                    $("label[for='nNumDocumento']").html("Número de RUC");
                    $('#nNumDocumento').attr('data-persona', 'juridica');
                    $("#nNumDocumento").attr('maxlength','11');
                    $("span.nNumDocumento").html("Hasta 11 dígitos");
                    break;
            
                default:
                    break;
            }
            getPersonaInfo();
            });
       });

        $('#iCodRemitente').select2({
           placeholder: 'Seleccione y busque',
           minimumInputLength: 3,
           "language": {
               "noResults": function(){
                   return "<p>No se encontró al remitente.</p>";
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
               url: 'mantenimiento/Entidad.php',
               dataType: 'json',
               method: 'POST',
                data: function (params) {
                    var query = {
                        search: params.term,
                        Evento: 'BuscarEntidad'
                    }
                    return query;
                },
               delay: 100,
               processResults: function (data) {
                   return {
                       results: data
                   };
               },
               cache: true
           }
       });

       function ObtenerDatosEntidad(id,callfunct) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Entidad.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    callfunct(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ActualizarDatos(datos) {
            $("#cNomRemitente").val(datos.ResponsableEntidad).next().addClass('active');
            $("#cCargoRemitente").val(datos.CargoResponsableEntidad).next().addClass('active');
        }

       $('#iCodRemitente').on('select2:select', function (e) {
            let valor = $('#iCodRemitente').val();
            ObtenerDatosEntidad(valor,ActualizarDatos);
       });


       $('#cReferencia.js-example-basic-multiple-limit').select2({
           placeholder: 'Seleccione y busque',
           maximumSelectionLength: 10,
           minimumInputLength: 3,
           "language": {
               "noResults": function(){
                   return "<p>No se encontró la referencia.</p><p><a href='#' class='btn btn-link'>¿Desea registrarlo?</a></p>";
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

       $('#nFlgClaseDoc').change(function() {
           if(this.checked) {
               $('#datosTupa').css('display','block');
               $('#faltaDoc').css('display','block');
           }else{
               $('#datosTupa').css('display','none');
               $('#faltaDoc').css('display','none');
               $("#nFlgEnvio").prop('checked',false);
           }
       });

       function seleccionar_todo() {
           $('table#tRequisitos input[type=checkbox]').prop('checked', true);
       }

       function deseleccionar_todo() {
           $('table#tRequisitos input[type=checkbox]').prop('checked', false);
       }

       function validarFormulario(){
           if($("#cCodTipoDoc").val() === ''){
               $.alert("Falta seleccionar tipo de documento!");
               return false;
           }

           /*if($("#cNroDocumento").val() === ''){
               $.alert("Falta número de documento!");
               return false;
           }*/

           if($("#cTrabajadorDerivar").val() === ''){
               $.alert("Falta número de documento!");
               return false;
           }

           if($("#fechaDocumento").val() === ''){
               $.alert("Falta fecha del documento!");
               return false;
           }

           if($("#cAsunto").val() === '') {
               $.alert("Falta asunto!");
               return false;
           }

           
           if ($("#nFlgClaseDoc").is(':checked') === true) {
               if($("#iCodTupaClase").val() === ''){
                   $.alert("Falta clase de TUPA!");
                   return false;
               } else {
                   if($("#iCodTupa").val() === ''){
                       $.alert("Falta procedimiento TUPA!");
                       return false;
                   } else {
                        if ($('table#tRequisitos input[type="checkbox"]').length !== $('table#tRequisitos input[type="checkbox"]:checked').length){
                            $.alert("Falta requisitos en el documento!");
                            return false;
                        }
                   }
               }
           }

           return true;
       }

       $('#btnConcluido').on('click',function (e) {
           e.preventDefault();
           setTimeout(function(){ window.location = "interoperabilidad.php?controller=despacho"; },500);
       });

       function CargarTUPAs(selectValue = ''){
           let valor = $('#iCodTupaClase').val();
           $('#iCodTupa').append('<option value="">Seleccionar</option>');
           $.ajax({
               async: false,
               cache: false,
               url: "ajax/ajaxTupas.php",
               method: "POST",
               data: {iCodTupaClase: valor},
               datatype: "json",
               success: function (response) {
                   $.each(JSON.parse(response), function( index, value ) {
                       $('#iCodTupa').append(value);
                   });
                   if (typeof selectValue != "object"){
                       $('#iCodTupa option[value="'+selectValue+'"]').prop('selected',true);
                       $('#iCodTupa').trigger("change");
                   }
                   $('#iCodTupa').formSelect();
               }
           });
       }

        $('#iCodTupaClase').on('change', CargarTUPAs);

       function CargarRequisitos(seleccionarTodos = false){
           let texto = $("#iCodTupa option:selected").text();
           $("#cAsunto").val(texto).next().addClass("active");
           let valor = $('#iCodTupa').val();
           $.ajax({
               async: false,
               cache: false,
               url: "ajax/ajaxRequisitos.php",
               method: "POST",
               data: {iCodTupa: valor},
               datatype: "json",
               success: function (response) {
                   $('table#tRequisitos').empty();
                   response = JSON.parse(response);
                   $.each(response.datos, function( index, value ) {
                       $('table#tRequisitos').append(value);
                   });
                   if ($("#nroConstanciaSIGCTIEnvio").val().trim() !== '') {
                       $("input[name='iCodTupaRequisito[]']").prop("checked", true);
                   }
                   $("#divRequisitos").css("display", "block");
               }
           });
       }

        $('#iCodTupa').on('change',CargarRequisitos);

       function obtenerDatosFormulario () {
           let data = $('#frmRegistro').serializeArray();
           let formData = new FormData();
           $.each(data, function(key, el) {
               formData.append(el.name, el.value);
           });
           $.each(tblPrincipal.data(), function(key, el) {
               formData.append("documentoEntrada[]",el.codigo);
           });
           $.each(tblAnexos.data(), function(key, el) {
               formData.append("documentoEntrada[]",el.codigo);
           });
           formData.append("Evento","registroDocumentoCargo");
           return formData;
       }

       function registrarDocumento(){
           let datos = obtenerDatosFormulario();
           getSpinner('Guardando documento');
           $.ajax({
               url: "registerDoc/regMesaPartes.php",
               method: "POST",
               data: datos,
               processData: false,
               contentType: false,
               datatype: "json",
               success: function (respuesta) {
                   console.log('Registrado el correctamente!');
                   deleteSpinner();
                   M.toast({html: 'Registrado el correctamente!'});
                   let elems = document.querySelector('#modalConcluido');
                   let instance = M.Modal.init(elems, {dismissible:false});
                   $('#modalConcluido div.modal-content').html(respuesta);
                   instance.open();
               },
               error: function (e) {
                   console.log(e);
                   console.log('Error al registrar el documento!');
                   deleteSpinner();
                   M.toast({html: "Error al registrar el documento"});
               }
           });
       };

       function print(html, title) {
           let printWindow = window.open('', '', 'height=700,width=950');
           printWindow.document.write('<html><head><title>' + title + '</title>');
           printWindow.document.write(document.head.innerHTML);
           printWindow.document.write('</head><body >');
           printWindow.document.write(document.getElementById(html).innerHTML);
           printWindow.document.write('</body></html>');
           printWindow.document.close();
           printWindow.focus();
           setTimeout(function () {
               printWindow.print();
               setTimeout(function () {
                   printWindow.close();
               }, 100);
               printWindow.onmouseover = (function () {
                   printWindow.close();
               });
           }, 500);
           return true;
       }

       Dropzone.autoDiscover = false;
       $("div#docPrincipal").dropzone({
           url: "ajax/cargarDocEntrada.php",
           paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
           autoProcessQueue: false,
           maxFiles: 1,
           acceptedFiles: ".pdf, .PDF",
           addRemoveLinks: true,
           maxFilesize: 1200, // MB
           uploadMultiple: true,
           parallelUploads: 1,
           dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
           dictInvalidFileType: "Archivo no válido",
           dictMaxFilesExceeded: "Solo 1 archivo son permitido",
           dictCancelUpload: "Cancelar",
           dictRemoveFile: "Remover",
           dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
           dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
           dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",
           accept: function (file, done) {
                let estado = false;
                let data = tblPrincipal.data();
                if(data.length > 0){
                    done("El documento principal ya está agregado");
                    $.alert("El documento principal ya está agregado");
                    this.removeFile(file);
                } else {
                    done();
                }
            },
           init: function () {
               var myDropzone = this;

               $("#btnSubirDocPrincipal").on("click", function(e) {
                   e.preventDefault();
                   e.stopPropagation();
                   let queuedFiles = myDropzone.getQueuedFiles();
                   if (queuedFiles.length > 0) {
                       event.preventDefault();
                       event.stopPropagation();
                       myDropzone.processQueue();
                   }else{
                       $.alert('¡No hay documentos para subir al sistema!');
                   }
               });

               $("#registrar").on("click", function(e) {
                   e.preventDefault();
                   e.stopPropagation();
                   if (validarFormulario()){
                       let queuedFiles = myDropzone.getQueuedFiles();
                       let queuedFilesAnexos = $("div#docAnexos")[0].dropzone.getQueuedFiles();
                       if(queuedFiles.length === 0 && queuedFilesAnexos.length === 0){
                           registrarDocumento();
                       } else {
                           $.alert('¡Falta subir documentos!');
                       }
                   }
               });

               this.on("success", function(file, response) {
                    let json = $.parseJSON(response);
                    M.toast({html: json.mensaje});
                    $.each(json.data, function (i,fila) {
                        tblPrincipal.row.add(fila).draw();
                    });                   
                    this.removeAllFiles();
               });
           }
       });

       var tblPrincipal = $('#tblPrincipal').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#tblPrincipal").parents("div.boxArchivos").hide();
                    $("#tblPrincipal").parents("fieldset").find("div.subir").show();
                }else{
                    $("#tblPrincipal").parents("div.boxArchivos").show();
                    $("#tblPrincipal").parents("fieldset").find("div.subir").hide();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                {
                    'render': function (data, type, full, meta) {
                        let nombreAnexo = '';
                        nombreAnexo = '<a href="'+full.nuevo+'" target="_blank">'+full.original+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "95%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped danger" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "5%"
                },
            ]
        });

        $("#tblPrincipal tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            switch(accion){
                case 'eliminar':
                    tblPrincipal.row($(this).parents('tr')).remove().draw(false);
                    break;
            }
        });

       $("div#docAnexos").dropzone({
           url: "ajax/cargarDocEntrada.php",
           paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
           autoProcessQueue: false,
           maxFiles: 10,
           acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx, .rar, .zip, .JPG, .JPEG, .PNG, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PPTX, .RAR, ZIP",
           addRemoveLinks: true,
           maxFilesize: 1200, // MB
           uploadMultiple: true,
           parallelUploads: 10,
           dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
           dictInvalidFileType: "Archivo no válido",
           dictMaxFilesExceeded: "Solo 1 archivo son permitido",
           dictCancelUpload: "Cancelar",
           dictRemoveFile: "Remover",
           dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
           dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
           dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",
           accept: function (file, done) {
               if (tblPrincipal.data().length > 0) {
                    let estado = false;
                    let data = tblAnexos.data();
                    $.each(data, function (i, item) {
                        if (file.name == item.original) {
                            estado = true;
                        }
                    });
                    if (!estado) {
                        done();
                    } else {
                        done("El anexo ya está agregado");
                        $.alert({
                            title: '¡Documento Repetido!',
                            content: 'El documento ' + file.name + ' ya fue agregado.',
                        });
                        this.removeFile(file);
                    }
               } else {
                    $.alert('¡Falta subir documento principal!');
                    this.removeFile(file);
               }                
            },
           init: function () {
               var myDropzone = this;

               $("#btnSubirDocAnexos").on("click", function(e) {
                   e.preventDefault();
                   e.stopPropagation();
                   let queuedFiles = myDropzone.getQueuedFiles();
                   if (queuedFiles.length > 0) {
                       event.preventDefault();
                       event.stopPropagation();
                       myDropzone.processQueue();
                   }else{
                       $.alert('¡No hay documentos para subir al sistema!');
                   }
               });

               this.on("successmultiple", function(file, response) {
                    let json = $.parseJSON(response);
                    M.toast({html: json.mensaje});
                    $.each(json.data, function (i,fila) {
                        tblAnexos.row.add(fila).draw();
                    });                   
                    this.removeAllFiles();
                });
           }
       });

       var tblAnexos = $('#tblAnexos').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#tblAnexos").parents("div.boxArchivos").hide();
                }else{
                    $("#tblAnexos").parents("div.boxArchivos").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                {
                    'render': function (data, type, full, meta) {
                        let nombreAnexo = '';
                        nombreAnexo = '<a href="'+full.nuevo+'" target="_blank" data-id="'+full.codigo+'">'+full.original+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "95%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped danger" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "5%"
                },
            ]
        });

        $("#tblAnexos tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            switch(accion){
                case 'eliminar':
                    tblAnexos.row($(this).parents('tr')).remove().draw(false);
                    break;
            }
        });

       $("#FlgSIGCTI").on("change", function (e) {
           if ($(this).prop("checked")){
                $("#nroConstanciaSIGCTI").parent().css("display", "flex");
           } else {
               $("#nroConstanciaSIGCTI").parent().css("display", "none");
           }
       });


       $(document).ready(function() {
           $('.mdb-select').formSelect();

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
               disableWeekends: true,
               autoClose: true,
               showClearBtn: true
           });
       });
    </script>
    </body>
    </html>
<?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>