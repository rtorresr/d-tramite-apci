<?php
include_once("../conexion/parametros.php");
include_once('../conexion/conexion.php');

$pageTitle = "Solicitud de acceso de información pública";
$activeItem = "acceso-informacion-publica..php";
$navExtended = true;

$url = RUTA_SERVICIOS_PIDE."/ApiPide/token";
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
    <body class="theme-default landing">
        <input type="hidden" id="idTipoPersona" value="<?=$_POST["tipoPersona"]?>">
        <input id="token" type="hidden" value="<?php echo $response->token_type.' '. $response->access_token; ?>">
        <main>
            <div class="content content__left">
                <header>
                    <a href="https://www.gob.pe/rree"><img src="../dist/images/logo__mre.svg" height="45" alt=""></a>
                    <a href="http://www.apci.gob.pe"><img src="../dist/images/apci__logo--xl--blue.svg" height="45"></a>
                </header>
                <h5>SOLICITUD DE ACCESO A LA INFORMACIÓN PÚBLICA</h5>
                <p>SOLICITUD DE ACCESO A LA
                    INFORMACIÓN PÚBLICA
                    (Texto Único Ordenado de la Ley N° 27806, Ley
                    de Transparencia y Acceso a la Información
                    Pública, aprobado por Decreto Supremo N° 021-
                    2019-PCM)</p>
                <footer>
                    <figure>
                        <img src="../dist/images/landing.png" width="100%" alt="" srcset="">
                    </figure>
                </footer>
            </div>
            <div class="content content__right">
                <form style="width: 100%" class="w-100" name="frmRegistro" id="frmRegistro" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">                                    
                                    <fieldset>
                                        <legend>Funcionario Responsable de Entregar la Información</legend>
                                        <div class="row">
                                            <div class="col s12">
                                                <p>Lic. Gloria Bejarano Noblecilla</p>
                                            </div>
                                        </div>                                        
                                    </fieldset>
                                    <fieldset>
                                        <legend>Datos del solicitante</legend>
                                        <div class="row">
                                            <div class="col s12 input-field">
                                                <select id="flgMayorEdad" name="flgMayorEdad">
                                                    <option value="">Seleccione ...</option>
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                                <label for="flgMayorEdad">Es mayor de edad?</label>
                                            </div>
                                        </div>
                                        <div class="row formulario" style="display: none">
                                            <div class="col s12" id="areaRemitente">
                                                <div class="row">
                                                    <div style="margin-bottom: 0">
                                                        <div class="col s12 m4 input-field mayorEdad">
                                                            <select id="tipoPersona" name="tipoPersona"></select>
                                                            <label for="tipoPersona">Tipo de Persona</label>
                                                            <span class="helper-text red-text">*Obligatorio</span>
                                                        </div>
                                                        <div class="col s12 m4 input-field mayorEdad">
                                                            <select id="tipoDoc" name="tipoDoc"></select>
                                                            <label for="tipoDoc">Tipo de documento</label>
                                                            <span class="helper-text red-text">*Obligatorio</span>
                                                        </div>
                                                        <div class="col s9 m3 input-field mayorEdad">
                                                            <input id="numeroDocumento" type="text" name="numeroDocumento">
                                                            <label for="numeroDocumento">Numero documento</label>
                                                            <span class="helper-text red-text">*Obligatorio</span>
                                                        </div>
                                                        <div class="col s3 m1 input-field mayorEdad">
                                                            <a style="display: none" class="btn btn-small btn-secondary tooltipped" data-position="top" data-tooltip="Buscar DNI" id="btnNroDoc"><i class="fas fa-search"></i></a>
                                                        </div>
                                                        
                                                        <div class="col s12 input-field">
                                                            <input id="nombreEntidad" type="text" name="nombreEntidad">
                                                            <label for="nombreEntidad">Nombres</label>
                                                            <span class="helper-text red-text">*Obligatorio</span>
                                                        </div>
                                                        <div class="col s6 input-field">
                                                            <input id="apePaterno" type="text" name="apePaterno">
                                                            <label for="apePaterno">Apellido Paterno</label>
                                                            <span class="helper-text red-text">*Obligatorio</span>
                                                        </div>
                                                        <div class="col s6 input-field">
                                                            <input id="apeMaterno" type="text" name="apeMaterno">
                                                            <label for="apeMaterno">Apellido Materno</label>
                                                            <span class="helper-text red-text">*Obligatorio</span>
                                                        </div>
                                                    </div>
                                                    <div id="datosResponsable" style="margin-bottom: 0">
                                                        <div class="col s12 input-field">
                                                            <input id="direccion" type="text" name="direccion">
                                                            <label for="direccion">Dirección</label>
                                                            <span class="helper-text">(Detallar calle/distrito/provincia/departamento/país)</span>
                                                            <span class="helper-text red-text">*Obligatorio</span>
                                                        </div>
                                                    </div>
                                                    <div style="margin-bottom: 0">
                                                        <div class="col s12 m4 input-field">
                                                            <input id="telefonoContacto" type="text" name="telefonoContacto">
                                                            <label for="telefonoContacto">Teléfono contacto</label>
                                                        </div>
                                                    </div>
                                                    <div style="margin-bottom: 0">
                                                        <div class="col s12 m4 input-field">
                                                            <input id="correoContacto" type="text" name="correoContacto">
                                                            <label for="correoContacto">Correo contacto</label>
                                                        </div>
                                                        <div class="col s12 m4 input-field">
                                                            <input id="correoContactoValidacion" type="text" name="correoContactoValidacion">
                                                            <label for="correoContactoValidacion">Repite correo contacto</label>
                                                        </div>
                                                    </div>
                                                    <div style="margin-bottom: 0">
                                                        <div class="col s12" style="color: #0c70c0!important ">
                                                            <p>"A fin de poder generar un mejor servicio para la atención de su requerimiento, se sugiere
llenar los campos referidos a teléfono y correo electrónico."</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="formulario" style="display: none">
                                        <legend>Datos de la solicitud</legend>
                                        <div class="row">
                                            <div class="col s12 input-field">
                                                <textarea id="informacion" name="informacion"  class="materialize-textarea FormPropertReg"></textarea>
                                                <label for="informacion">Información solicitada</label>
                                                <span class="helper-text red-text">*Obligatorio</span>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset class="formulario" style="display: none">
                                        <legend>Formas de entrega</legend>
                                        <div class="row" style="margin-bottom: 0">
                                            <div class="col s12 input-field">
                                                <p style="margin: 0">Selecciona cómo quieres recibirla. Si no seleccionas una opción, se entregará el pedido como copia simple con el costo correspondiente.</p>
                                                <p id="formaEntrega"></p>
                                            </div>
                                            <div class="col s12 input-field" style="display: none">
                                                <input id="descOtraForma" type="text" name="descOtraForma">
                                                <label for="descOtraForma">Si quieres recibirla en otro formato, especifícalo</label>
                                                <p>Se te indicará el pago por costo de reproducción que deberás cancelar previamente a la entrega de la información.</p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="card-action formulario" style="display: none">
                                    <a class="btn btn-primary btn-small" id="registrar" ><i class="fas fa-save fa-fw left"></i>Registrar</a>
                                </div>
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

    <div id="modalPrincipal" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header"></div>
        <div id="divHojaIngreso" class="modal-content"></div>
        <div class="modal-footer"></div>
    </div>

    <?php include("includes/pie.php"); ?>

    <script src="../conexion/global.js"></script>
    <script>
        function ContenidosTipo(idDestino, codigoTipo,defaultSelect = 0, arrayQuitar = []){
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
                method: "POST",
                async: false,
                data: {codigo: codigoTipo},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    destino.append('<option value="0">Seleccione</option>');
                    let quitarNum = arrayQuitar.length;
                    if (quitarNum == 0){
                        $.each(data, function( key, value ) {
                            destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                    } else {
                        $.each(data, function( key, value ) {
                            if (!arrayQuitar.includes(value.codigo)){
                                destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                            }
                        });
                    }
                    if (defaultSelect != 0){
                        $('#'+idDestino+' option[value="'+defaultSelect+'"]').prop('selected',true);
                    }                    
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

       function validarFormulario(){           

            if($("#flgMayorEdad").val() == 1){
                if($("#tipoPersona").val() == '0'){
                    $.alert("Falta seleccionar el tipo de persona!");
                    return false;
                }

                if($("#tipoDoc").val() == ''){
                    $.alert("Falta seleccionar el tipo de documento!");
                    return false;
                }

                if($("#numeroDocumento").val() == ''){
                    $.alert("Falta indicar numero de documento!");
                    return false;
                }
            }    

            if($("#tipoPersona").val() == 60){
                if($("#nombreEntidad").val() == ''){
                    $.alert("Falta indicar los nombres!");
                    return false;
                }

                if($("#apePaterno").val() == ''){
                    $.alert("Falta indicar el apellido paterno!");
                    return false;
                }

                if($("#apeMaterno").val() == ''){
                    $.alert("Falta indicar el apellido materno!");
                    return false;
                }
            }

            if($("#tipoPersona").val() == 62){
                if($("#nombreEntidad").val() == ''){
                    $.alert("Falta indicar el nombre de la entidad!");
                    return false;
                }
            }           

            if($("#direccion").val() == ''){
                $.alert("Falta indicar la dirección del solicitante!");
                return false;
            }

            if($("#correoContacto").val() != ''){
                if ($("#correoContacto").val() != $("#correoContactoValidacion").val()){
                    $.alert("Los correos no coinciden!");
                    return false;
                }
            }            

            if($("#informacion").val() == ''){
                $.alert("Falta ingresar la información solicitada!");
                return false;
            }

            if($("[name=formaEntrega]:checked").val() == undefined){
                $.alert("Falta indicar forma de entrega!");
                return false;
            }
            
            if($("input[name=formaEntrega]:checked").val() == 91){
                if($("#descOtraForma").val() == ''){
                    $.alert("Falta indicar la forma de entrega!");
                    return false;
                }
            }

            return true;
       }

       function ListarDepartamento(selector, selected = 0) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Departamento.php",
                method: "POST",
                data: {Evento: "Listar"},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $(selector);
                    destino.empty().append('<option value="">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                    });
                    destino.formSelect();
                }
            });
        }

        function ListarProvincia(selector,departamento,selected = 0) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Provincia.php",
                method: "POST",
                data: {"Evento": "Listar", "Departamento": departamento},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $(selector);
                    destino.empty().append('<option value="">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                    });
                    destino.formSelect();
                }
            });
        }

        function ListarDistrito(selector,departamento,provincia,selected = 0) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Distrito.php",
                method: "POST",
                data: {"Evento": "Listar","Departamento": departamento,"Provincia": provincia},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $(selector);
                    destino.empty().append('<option value="">Seleccione</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                    });
                    destino.formSelect();
                }
            });
        }

        $("#departamento").on("change", function(){
            ListarProvincia("#provincia",$("#departamento").val());
        });

        $("#provincia").on("change", function(){
            ListarDistrito("#distrito",$("#departamento").val(),$("#provincia").val());
        });

       $('#btnConcluido').on('click',function (e) {
           location.reload();
       });    

       function obtenerDatosFormulario () {
           let data = $('#frmRegistro').serializeArray();
           let formData = new FormData();
           $.each(data, function(key, el) {
               formData.append(el.name, el.value);
           });
           formData.append("Evento","registroAccesoInformacionPublica");
           return formData;
       }

       $('#registrar').on('click', function(e) {  
            if(validarFormulario()){
                registrarDocumento();
            };
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
               url: "registerDoc/regAccesoInformacionPublica.php",
               method: "POST",
               data: datos,
               processData: false,
               contentType: false,
               datatype: "json",
               success: function (hash) {
                    $.ajax({
                        url: "registerDoc/regAccesoInformacionPublica.php",
                        method: "POST",
                        data: {
                            'Evento': 'validacionCodigo',
                            'hash': hash,
                            'pin': 0,
                        },
                        datatype: "json",
                        success: function (json) {
                                var respuesta = JSON.parse(json);
                                if (respuesta.estado == '1'){                      
                                    M.toast({html: respuesta.mensaje});
                                    var data = {
                                        Evento: 'registroMesaPartes',
                                        hash: hash
                                    };
                                    $.post("registerDoc/regAccesoInformacionPublica.php",data)
                                        .done(function(response){
                                            let validacion = document.querySelector('#modalValidacion');
                                            let instancevalidacion = M.Modal.init(validacion, {dismissible:false});
                                            instancevalidacion.close();

                                            let elems = document.querySelector('#modalPrincipal');
                                            let instance = M.Modal.init(elems, {dismissible:false});
                                            $('#modalPrincipal div.modal-header').html(`<h4>Registro concluido</h4>`);
                                            $('#modalPrincipal div.modal-content').html(response);
                                            $('#modalPrincipal div.modal-footer').html(`<button type="button" class="modal-print btn-flat" onclick="print('divHojaIngreso','Hoja-de-Ingreso')">Imprimir</button>
                                                <a class="waves-effect waves-green btn-flat" id="btnConcluido">Cerrar</a>`);
                                            instance.open();
                                        })
                                        .fail(function (response){
                                            M.toast({html: 'No se pudo registrar la solicitud'});
                                        });
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
                //    console.log('Registrado correctamente!');
                //    deleteSpinner();
                //    M.toast({html: 'Registrado correctamente!'});
                //    modalValidacion(hash);
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
               url: "registerDoc/regAccesoInformacionPublica.php",
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
                        var data = {
                            Evento: 'registroMesaPartes',
                            hash: $("#formValidacion input[name=hash]").val()
                        };
                        $.post("registerDoc/regAccesoInformacionPublica.php",data)
                            .done(function(response){
                                let validacion = document.querySelector('#modalValidacion');
                                let instancevalidacion = M.Modal.init(validacion, {dismissible:false});
                                instancevalidacion.close();

                                let elems = document.querySelector('#modalPrincipal');
                                let instance = M.Modal.init(elems, {dismissible:false});
                                $('#modalPrincipal div.modal-header').html(`<h4>Registro concluido</h4>`);
                                $('#modalPrincipal div.modal-content').html(response);
                                $('#modalPrincipal div.modal-footer').html(`<button type="button" class="modal-print btn-flat" onclick="print('divHojaIngreso','Hoja-de-Ingreso')">Imprimir</button>
                                    <a class="waves-effect waves-green btn-flat" id="btnConcluido" >Cerrar</a>`);
                                instance.open();
                            })
                            .fail(function (response){
                                M.toast({html: 'No se pudo registrar la solicitud'});
                            });
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

       $("#tipoPersona").on('change', function(e){
           var valorTipoEntidad = $("#tipoPersona").val();
           if (valorTipoEntidad == 62){
                $("#apePaterno").closest("div.input-field").css("display","none");
                $("#apeMaterno").closest("div.input-field").css("display","none");
                $("label[for=nombreEntidad]").text("Nombre de la Entidad");
                ContenidosTipo('tipoDoc',31,0,[73,75,76,77]);                
           } else {
                $("#apePaterno").closest("div.input-field").css("display","flex");
                $("#apeMaterno").closest("div.input-field").css("display","flex");
                $("label[for=nombreEntidad]").text("Nombres");
                ContenidosTipo('tipoDoc',31,0,[74]);                
           }
       });

       $('#tipoDoc').on('change', function(e) {
            var valorTipoDoc = $("#tipoDoc").val();
            if (valorTipoDoc != 73) {
                $('#btnNroDoc').css('display', 'none');
            }else{
                $('#btnNroDoc').css('display', 'block');
            }
       });

       function ContenidoFormaEntrega(){
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
                method: "POST",
                data: {codigo: 34},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#formaEntrega");
                    destino.empty();
                    $.each(data, function( key, value ) {
                        destino.append(`<label>
                                <input name="formaEntrega" type="radio" value="${value.codigo}">
                                <span>${value.nombre}</span>
                            </label></br>`);
                    });
                }
            });
        }

        $("#btnNroDoc").on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

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
                            $("#nombreEntidad").val(nombre);
                            // $("#nombreEntidad").attr("disabled",true);
                            $("#nombreEntidad").next().addClass("active");
                            $("#direccion").val(data.Direccion);
                            $("#direccion").next().addClass("active");
                        }
                    }
                });
            }
        });

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

       $('body').on('click', '#btnConcluido',function (e) {
           e.preventDefault();
           setTimeout(function(){ location.reload(); },500);
       });

       $(document).ready(function() {
           $('.mdb-select').formSelect();

           ContenidosTipo('tipoPersona',30);
           $("#tipoPersona").trigger('change');

           ContenidosTipo("tipoDoc",31);

           ListarDepartamento('#departamento');

           ContenidoFormaEntrega();
       });

        $("#flgMayorEdad").on("change", function(e){
           e.preventDefault();
           e.stopPropagation();
           if($("#flgMayorEdad").val() != ''){
               $(".formulario").css("display", "block");
               if($("#flgMayorEdad").val() == '1'){
                    ContenidosTipo('tipoPersona',30);
                    $("#tipoPersona").trigger("change");
                    $(".mayorEdad").css("display", "block");
               } else {
                    ContenidosTipo('tipoPersona',30,60);
                    $(".mayorEdad").css("display", "none");
               }
           } else {
               $(".formulario").css("display", "none");
           }
        });

        $(document).on("change","input[name=formaEntrega]",function(e){
            e.preventDefault();
            e.stopPropagation();
            if($(this).val() == 91){
                $("#descOtraForma").closest("div.input-field").css("display","flex");
            } else {
                $("#descOtraForma").closest("div.input-field").css("display","none");
            }
        });
    </script>
    </body>
    </html>
<?php
?>