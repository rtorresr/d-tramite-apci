<?php
include_once("../conexion/parametros.php");
$pageTitle = "Registro de Entrada";
$activeItem = "registroEntrada.php";
$navExtended = true;

// $url = RUTA_SERVICIOS_PIDE."/ApiPide/token";
// $data = array(
//     "UserName" =>  "8/user-dtramite",
//     "Password" =>   "123456",
//     "grant_type" => "password"
// );

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
    <body class="theme-default landing">
        <input id="token" type="hidden" value="<?php echo $response->token_type . ' ' . $response->access_token; ?>">
        <main>
            <div class="content content__left">
                <header>
                    <a href="https://www.gob.pe/rree"><img src="../dist/images/logo__mre.svg" height="35" alt=""></a>
                    <a href="http://www.apci.gob.pe"><img src="../dist/images/apci__logo--color--blue.svg" height="35"></a>
                </header>
                <h5>Mesa de partes digital</h5>
                <!---->
                <p>Estimados usuarios, para mayor facilidad, se ha puesto a su disposición este formulario, que le permitirá el envío de documentos a la Agencia Peruana de Cooperación Internacional - APCI.</p>
                <p>Esta modalidad de recepción estará activa en tanto dura la emergencia nacional declarada por D.S. N° 044-2020-PCM.</p>
                <p>El horario de recepción de documentos es de 08:30 hasta las 4:30pm, de Lunes a Viernes.</p>
                <footer>
                    <figure>
                        <img src="../dist/images/landing.png" width="100%" alt="" srcset="">
                    </figure>
                </footer>
            </div>
            <div class="content content__right">
                <form name="frmRegistro" id="frmRegistro" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Datos del Remitente</legend>
                                        <div class="row">
                                            <div class="col s12" id="areaRemitente">
                                                <div class="row" style="margin-bottom: 0">
                                                    <div class="col s12 m5 input-field">
                                                        <select id="tipoEntidad" name="tipoEntidad"></select>
                                                        <label for="tipoEntidad">Tipo entidad</label>
                                                    </div>
                                                    <div class="col s9 m6 input-field">
                                                        <input id="numeroDocumento" type="text" name="numeroDocumento">
                                                        <label for="numeroDocumento">Numero documento</label>
                                                    </div>
                                                    <div class="col s3 m1 input-field">
                                                        <a style="display: none" class="btn btn-large btn-secondary tooltipped" data-position="top" data-tooltip="Buscar DNI" id="btnNroDoc"><i class="fas fa-search"></i></a>
                                                    </div>
                                                    <div class="col s12 m12 input-field">
                                                        <input type="text" name="nomEntidad" id="nomEntidad">
                                                        <label for="nomEntidad">Entidad</label>
                                                    </div>
                                                </div>
                                                <div class="row" id="datosResponsable" style="margin-bottom: 0">
                                                    <div class="col s12 m2 input-field">
                                                        <input id="dniResponsable" type="text" name="dniResponsable">
                                                        <label for="dniResponsable">DNI</label>
                                                    </div>
                                                    <div class="col s12 m5 input-field">
                                                        <input id="nomResponsable" type="text" name="nomResponsable">
                                                        <label for="nomResponsable">Responsable</label>
                                                    </div>
                               
                                                    <div class="col s12 m5 input-field">
                                                        <input type="text" name="cargoResponsable" id="cargoResponsable">
                                                        <label for="cargoResponsable">Cargo</label>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-bottom: 0">
                                                    <div class="col s12 m6 input-field">
                                                        <input id="telefonoContacto" type="text" name="telefonoContacto">
                                                        <label for="telefonoContacto">Teléfono contacto</label>
                                                    </div>
                                                    <div class="col s12 m6 input-field">
                                                        <input id="correoContacto" type="text" name="correoContacto">
                                                        <label for="correoContacto">Correo contacto</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset>
                                        <legend>Datos del documento</legend>
                                        <div class="row" style="margin-bottom: 0">
                                            <div class="col s12 m3 input-field">
                                                <select id="cCodTipoDoc" name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary" >
                                                    <option value="">Seleccione</option>
                                                    <?php
                                                    include_once("../conexion/conexion.php");
                                                    $sqlTipo="SELECT cCodTipoDoc,cDescTipoDoc FROM Tra_M_Tipo_Documento WITH(NOLOCK) WHERE nFlgEntrada=1 ORDER BY cDescTipoDoc ASC";
                                                    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                        echo "<option value=".trim($RsTipo["cCodTipoDoc"]).">".trim($RsTipo["cDescTipoDoc"])."</option>";
                                                    }
                                                    sqlsrv_free_stmt($rsTipo);
                                                    ?>
                                                </select>
                                                <label for="cCodTipoDoc">Tipo de Documento</label>
                                            </div>
                                            <div class="col s12 m3 input-field">
                                                <input type="text" id="cNroDocumento" name="cNroDocumento" class="materialize-textarea FormPropertReg">
                                                <label for="cNroDocumento">N° de Documento</label>
                                            </div>
                                            <div class="col s12 m3 input-field">
                                                <input placeholder="Seleccione fecha" value="" type="text" id="fechaDocumento" name="fechaDocumento" class="FormPropertReg formSelect datepicker">
                                                <label for="fechaDocumento">Fecha del Documento</label>
                                            </div>
                                            <div class="col s2 m3 input-field">
                                                <input type="number" id="nNumFolio" min="0" name="nNumFolio" value="1" class="FormPropertReg">
                                                <label class="active">Folios</label>
                                            </div>
                                            <div class="col s12 input-field">
                                                <textarea id="cAsunto" name="cAsunto"  class="materialize-textarea FormPropertReg"></textarea>
                                                <label for="cAsunto">Asunto</label>
                                            </div>                                            
                                        </div>
                                    </fieldset>
                                
                                    <fieldset>
                                        <legend>Archivos</legend>
                                        <div class="row" style="margin-bottom: 0">
                                            <div class="col s12">
                                                <div class="file-field input-field">
                                                    <div class="btn btn-secondary">
                                                        <span>Principal</span>
                                                        <input type="file" name="archivoPrincipal" id="archivoPrincipal" accept="application/pdf">
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text" placeholder="Adjuntar principal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12">
                                                <div class="file-field input-field">
                                                    <div class="btn btn-secondary">
                                                        <span>Anexos</span>
                                                        <input type="file" name="anexos" id="anexos" multiple accept="application/pdf">
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Adjuntar anexos">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </fieldset>
                            </div>
                            <div class="card-action">
                                <a class="btn btn-primary" id="registrar" ><i class="fas fa-save fa-fw left"></i>Registrar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    <div id="modalValidacion" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Validación de registro</h4>
        </div>
        <div class="modal-content"></div>
        <div class="modal-footer">
            <button type="button" class="modal-print btn-flat" id="ValidacionCodigo">Validar</button>
        </div>
    </div>

    <?php include("includes/pie.php"); ?>

    <script src="../conexion/global.js"></script>
    <script>
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
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

       function validarFormulario(){
            if ($("#tipoEntidad").val() == 62){
                if($("#numeroDocumento").val() == ''){
                    $.alert("Falta número de doumento de la entidad!");
                    return false;
                }

                if($("#nomEntidad").val() == ''){
                    $.alert("Falta nombre de la entidad!");
                    return false;
                }

                if($("#dniResponsable").val() == ''){
                    $.alert("Falta número de doumento del responsable!");
                    return false;
                }

                if($("#nomResponsable").val() == ''){
                    $.alert("Falta nombre del responsable!");
                    return false;
                }

                if($("#cargoResponsable").val() == ''){
                    $.alert("Falta cargo del responsable!");
                    return false;
                }
            } else {
                if($("#numeroDocumento").val() == ''){
                    $.alert("Falta número de doumento de la persona!");
                    return false;
                }

                if($("#nomEntidad").val() == ''){
                    $.alert("Falta nombre de la persona!");
                    return false;
                }
            }

            if($("#telefonoContacto").val() == ''){
                $.alert("Falta teléfono de contacto!");
                return false;
            }

            if($("#correoContacto").val() == ''){
                $.alert("Falta correo de contacto!");
                return false;
            }

            if($("#cCodTipoDoc").val() == ''){
                $.alert("Falta tipo de documento!");
                return false;
            }

            if($("#cNroDocumento").val() == ''){
                $.alert("Falta número del documento!");
                return false;
            }

            if($("#fechaDocumento").val() == ''){
                $.alert("Falta fecha del documento!");
                return false;
            }

            if($("#nNumFolio").val() == ''){
                $.alert("Falta número de folios!");
                return false;
            }

            if($("#cAsunto").val() == ''){
                $.alert("Falta asunto del documento!");
                return false;
            }

            if($('#archivoPrincipal')[0].files.length == 0){
                $.alert("Falta archivo del documento!");
                return false;
            } else {
                var archivo = $('#archivoPrincipal')[0].files[0];
                if (Archivo.Tipo.findIndex(e => e.Extension.find(i => i == archivo.name.split('.').pop().toUpperCase())) == -1){
                    $.alert(`Tipo del archivo ${archivo.name} no aceptado!`);
                    return false;
                }
                
            }

            if($('#anexos')[0].files.length != 0){
                var archivos = $('#anexos')[0].files;
                $.each(archivos, function( index,archivo) {
                    if (Archivo.Tipo.findIndex(e => e.Extension.find(i => i == archivo.name.split('.').pop().toUpperCase())) == -1){
                        $.alert(`Tipo del archivo anexo ${archivo.name} no aceptado!`);
                        return false;
                    } 
                });                               
            }

            return true;
       }

       $('#btnConcluido').on('click',function (e) {
           e.preventDefault();
           setTimeout(function(){ window.location = "registroEntrada.php"; },500);
       });    

       function obtenerDatosFormulario () {
           let data = $('#frmRegistro').serializeArray();
           let formData = new FormData();
           $.each(data, function(key, el) {
               formData.append(el.name, el.value);
           });
           formData.append('archivoPrincipal',document.getElementById('archivoPrincipal').files[0]);
           for (var i = 0; i < document.getElementById('anexos').files.length; i++) {
                formData.append('anexos[]',document.getElementById('anexos').files[i]);
            }
           formData.append("Evento","registroMesaPartesVirtual");
           return formData;
       }

       $('#registrar').on('click', function(e) {  
            if (validarFormulario()) {
                registrarDocumento();
            }
       });

       function modalValidacion(hash){
            let elems = document.querySelector('#modalValidacion');
            let instance = M.Modal.init(elems, {dismissible:false});
            var html = `<form id="formValidacion">
                <input type="hidden" name="hash" value="${hash}">
                <div class="row">
                    <div class="col s12 input-field">
                        <p>Por favor revise la bandeja de su correo electrónico e ingrese el código que le ha sido enviado.</p>
                    </div>                    
                    <div class="col s12 input-field">
                        <input type="text" name="pin" id="pin">
                        <label for="pin">Código validación</label>
                    </div>
                </div>
            </form>`;
            $('#modalValidacion div.modal-content').html(html);
            instance.open();
       }

       function registrarDocumento(){
           let datos = obtenerDatosFormulario();
           getSpinner('Guardando documento');
           $.ajax({
               url: "registerDoc/regMesaPartesVirtual.php",
               method: "POST",
               data: datos,
               processData: false,
               contentType: false,
               datatype: "json",
               success: function (hash) {
                   console.log('Registrado correctamente!');
                   deleteSpinner();
                   M.toast({html: 'Registrado correctamente!'});
                   modalValidacion(hash);
               },
               error: function (e) {
                   console.log(e);
                   console.log('Error al registrar el documento!');
                   deleteSpinner();
                   M.toast({html: "Error al registrar el documento"});
               }
           });
       };

       $("#ValidacionCodigo").on('click',function(e){
            $.ajax({
               url: "registerDoc/regMesaPartesVirtual.php",
               method: "POST",
               data: {
                   'Evento': 'validacionCodigo',
                   'hash': $("#formValidacion input[name=hash]").val(),
                   'pin': $("#formValidacion input[name=pin]").val(),
               },
               datatype: "json",
               success: function (json) {
                    var respuesta = JSON.parse(json);
                    if (respuesta.estado == '1'){                      
                        M.toast({html: respuesta.mensaje});
                        setTimeout(function () { window.location = RUTA_DTRAMITE+'views/mesa-partes-virtual-index.php' },1000);
                    } else {
                        M.toast({html: respuesta.mensaje});
                    }                    
               },
               error: function (e) {
                   console.log(e);
                   console.log('Error al validar el codigo!');
                   deleteSpinner();
                   M.toast({html: "Error al validar el codigo!"});
               }
           });
       });

       $("#tipoEntidad").on('change', function(e){
           var valorTipoEntidad = $("#tipoEntidad").val();
           if (valorTipoEntidad == 62){
                $("label[for=numeroDocumento]").text("RUC");
                $("label[for=nomEntidad]").text("Entidad");
                $("#datosResponsable").css('display','block');
                $('#btnNroDoc').css('display', 'none');
           } else {
                $("label[for=numeroDocumento]").text("DNI");
                $("label[for=nomEntidad]").text("Persona");
                $("#datosResponsable").css('display','none');
                $('#btnNroDoc').css('display', 'block');
           }
       });

       $("#btnNroDoc").on("click", function (e) {
            e.preventDefault();

            if ($("#numeroDocumento").val() != ''){
                getSpinner('Cargando datos!');
                $.ajax({
                    url: RutaServiciosPide+"/ApiPide/Api/Reniec/REC_GET_0001?dni="+$("#numeroDocumento").val(),
                    method: "GET",
                    headers: {
                        "Authorization" : $("#token").val()
                    },
                    datatype: "application/json",
                    success: function (data) {
                        if (data.Success){
                            data = data.EntityResult;
                            var nombre = `${data.Nombres} ${data.Paterno} ${data.Materno}`;
                            $("#nomEntidad").val(nombre);
                            $("#nomEntidad").next().addClass("active");
                        }
                    }
                });
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

           ContenidosTipo('tipoEntidad',30);
           $("#tipoEntidad").trigger('change');
       });
    </script>
    </body>
    </html>
<?php
?>