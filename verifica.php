<?php
date_default_timezone_set('America/Lima');
session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>D-tramite verifica</title>
        <link href="https://cdn.apci.gob.pe/dist/styles/app.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    </head>
    <body class="theme-blue dashboard sidebarless">
        <div class="wrapper">
        <header class="main-header bg-primary-dark">
            <a class="brand" href="/" style="text-align: center; margin: auto;">
                <img src="http://cdn.apci.gob.pe/dist/images/apci__logo--full.svg" alt="alt" height="30">
            </a>
        </header>
        <main class="page-wrapper">
            <section class="page-breadcrumb border-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <h5 class="mb-0 text-center">Verificación de Documento con Firma Digital</h5>
                        </div>
                    </div>
                </div>
            </section>

            <section class="page-content mt-5">
                <div class="container bg-white">
                    <div class="row d-flex align-items-center" style="min-height: 500px">
                        <div class="col-12 col-md-3">
                            <div class="inner">
                                <form>
                                    <?php
                                    if (isset($_GET['cud']) AND isset($_GET['clave'])){
                                        ?>
                                            <div id="fromQR">
                                                <form>
                                                    <input type="hidden" id="cudDocQR" value="<?=$_GET['cud']?>">
                                                    <input type="hidden" id="claveDocQR" value="<?=$_GET['clave']?>">
                                                </form>
                                            </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="form-group">
                                        <h2>Buscar</h2>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipoDocumento">Tipo de documento</label>
                                        <select class="form-control" id="tipoDocumento"></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cudDocumento">CUD</label>
                                        <input type="text" class="form-control" id="cudDocumento" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="claveDocumento">Clave</label>
                                        <input type="password" class="form-control togglePassword" id="claveDocumento" autocomplete="off">
                                    </div>
                                    <button type="button" class="btn btn-action btn-block" id="buscarDocumento">Buscar</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-md-9" style="">
                            <div id="noFrame" class="inner text-center">
                                <picture class="d-block mb-3">
                                    <img src="dist/images/busca.svg" alt="" class="fluid-image" width="300">
                                </picture>

                                <h6>Busca tu documento</h6>
                                <p>Aquí aparecerá tu documento cuando finalices tu búsqueda</p>
                            </div>
                            <div id="notFound" class="inner text-center" style="display: none">
                                <picture class="d-block mb-3">
                                    <img src="dist/images/error-404.svg" alt="" class="fluid-image" width="300">
                                </picture>

                                <h6>No encontramos tu documento</h6>
                                <p>Por favor, intenta con otros parámetros de búsqueda.</p>
                            </div>
                            <div id="iframe" class="inner text-center"></div>
                            <div id="anexos" style="display: none;">
                                <p>Anexos: </p>
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        </div>

        <script src="https://cdn.apci.gob.pe/dist/scripts/app.min.js"></script>
        <script src="conexion/global.js"></script>
        <script type="text/javascript">
            var $ = require('jquery');

            $(function() {
                $.ajax({
                    cache: 'false',
                    url: 'views/ajax/ajaxTipoDocumentoVerifica.php',
                    method: 'POST',
                    data: {tipoDoc: 3},
                    datatype: 'json',
                    success: function (data) {
                        $('#tipoDocumento').empty();
                        $('#tipoDocumento').append('<option value="0">Seleccione</option>');
                        let documentos = JSON.parse(data);
                        $.each(documentos, function (key,value) {
                            $('#tipoDocumento').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                    }
                });

                if ($("#fromQR").length == 1){
                    BuscarDocumento(null, $("#cudDocQR").val(), $("#claveDocQR").val());
                    $("#fromQR").remove();
                }

                $(".togglePassword").click(function(){
                    togglePassword("password");
                });
            });

            function BuscarDocumento (tipoDoc, cudDoc, claveDoc){
                getSpinner();

                $.ajax({
                    cache: 'false',
                    url: 'views/ajax/ajaxBuscarDocVerifica.php',
                    method: 'POST',
                    data: {
                        'tipoDoc' : tipoDoc,
                        'cud' : cudDoc,
                        'clave' : claveDoc
                    },
                    datatype: 'json',
                    success: function (response) {
                        var datos = JSON.parse(window.atob(response));
                        
                        if (datos.success == true){
                            var data = JSON.parse(window.atob(datos.datosD));

                            var documentosPruta = new Object();
                            documentosPruta.idDigital = data.idP;
                            // documentosPruta.descargable = false;

                            $("#noFrame").hide();
                            $("#notFound").hide();

                            if ($("#iframe iframe").length == 0){
                                var iframe = '<iframe scrolling="auto" class="w-100" src="" frameborder="0" style="height:500px"></iframe>';

                                $("#iframe").append(iframe);
                            }

                            $("#iframe iframe").attr('src',RUTA_DTRAMITE+'mostrarDocumento.php?d='+window.btoa(JSON.stringify(documentosPruta)));

                            //console.log(RUTA_DTRAMITE+'mostrarDocumento.php?d='+window.btoa(JSON.stringify(documentosPruta)));
                            //$("#iframe iframe").attr('src','data:application/pdf;base64,' + datos.documento);

                            var html = '<div class="alert alert-success float-right d-inline-block" role="alert">Documento encontrado!</div>';

                            if(data.flgAnexos){
                                $("#anexos").css("display","block");
                                var anexosA = JSON.parse(data.JidA);
                                $("#anexos ul").empty();
                                $.each(anexosA, function(i,v) {
                                    var anexoRuta = new Object();
                                    anexoRuta.idDigital = v.id;
                                    // anexoRuta.descargable = true;
                                    $("#anexos ul").append('<li><a href="'+RUTA_DTRAMITE+'mostrarDocumento.php?d='+window.btoa(JSON.stringify(anexoRuta))+'">'+v.nombre+'</a></li>');
                                });
                            }else {
                                $("#anexos").css("display","none");
                            }

                        } else {
                            if ($("#iframe iframe").length == 1){
                                $("#iframe iframe").parent().remove();
                            }
                            $("#noFrame").hide();
                            $("#notFound").show();
                        }
                        deleteSpinner();
                    }

                });
            }

            $("#buscarDocumento").on('click', function (e) {
                if($("#tipoDocumento").val() == 0){
                    $.alert("¡Falta seleccionar tipo de documento!");
                    return false;
                }

                if($("#cudDocumento").val().trim() == ''){
                    $.alert("¡Falta ingresar CUD!");
                    return false;
                }
                if($("#claveDocumento").val().trim() == ''){
                    $.alert("¡Falta ingresar clave!");
                    return false;
                }

                BuscarDocumento($("#tipoDocumento").val(), $("#cudDocumento").val(), $("#claveDocumento").val());
            });
        </script>
    </body>
</html>