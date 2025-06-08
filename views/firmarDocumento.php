<?php

session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
    include_once("../conexion/conexion.php");
    $pageTitle = "Firmar Documento";
    $activeItem = $_POST['menu']??"registroTrabajador.php";
    $navExtended = true;
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
    </head>
    <body class="theme-default has-fixed-sidenav" >
    <?php include("includes/menu.php");?>
    <!--Main layout-->
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><button class="btn btn-link btn-primary" id="btnAccion" onclick="initInvoker('W')"><i class="fas fa-signature fa-fw left"></i>Firmar</button></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-body">
                                <iframe id="myIframe" src='http://<?=$_REQUEST['urlfirm']?>' style='width:100%; height:600px;' frameborder='0'></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            <input type="hidden" id="argumentos" value="" />
            <div id="addComponent"></div>
            <input type="hidden" id="signedDocument" value="http://<?=$_REQUEST['urlfirm']?>">
        </div>
    </main>
    <?php
    include("includes/userinfo.php");
    include("includes/pie.php");
    $idtra = $_POST['idtra'];
    ?>
    <script type="text/javascript" src="invoker/client.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        var documentName_ = null;
        //
        window.addEventListener('getArguments', function (e) {
            type = e.detail;
            if(type === 'W'){
                ObtieneArgumentosParaFirmaDesdeLaWeb(); // Llama a getArguments al terminar.
            }else if(type === 'L'){
                ObtieneArgumentosParaFirmaDesdeArchivoLocal(); // Llama a getArguments al terminar.
            }
        });

        function getArguments(){
            arg = document.getElementById("argumentos").value;
            dispatchEventClient('sendArguments', arg);
        }

        window.addEventListener('invokerOk', function (e) {
            type = e.detail;
            if(type === 'W'){
                MiFuncionOkWeb();
            }else if(type === 'L'){
                MiFuncionOkLocal();
            }
        });

        window.addEventListener('invokerCancel', function (e) {
            MiFuncionCancel();
        });

        //::LÓGICA DEL PROGRAMADOR::
        function ObtieneArgumentosParaFirmaDesdeLaWeb(){
            u = document.getElementById("signedDocument").value;
           // $.get("invoker/getArguments.php", {}, function(data, status) {
                documentName_ = u;
                console.log(documentName_);
                //Obtiene argumentos
                $.post("invoker/postArguments.php", {
                    type : "W",
                    tipFirma: 'f',
                    documentName : documentName_
                }, function(data, status) {
                    //alert("Data: " + data + "\nStatus: " + status);
                    document.getElementById("argumentos").value = data;
                    getArguments();
                });
        }

        function ObtieneArgumentosParaFirmaDesdeArchivoLocal(){
            u = document.getElementById("signedDocument").value;
                documentName_ = u;
                //Obtiene argumentos
                    $.post("invoker/postArguments.php", {
                    type: "L",
                    tipFirma: 'f',
                    documentName: documentName_
                } , function(data, status) {
                        document.getElementById("argumentos").value = data;
                        getArguments();
                });
        }

        function MiFuncionOkWeb(){
            u = document.getElementById("signedDocument").value;
            d = u.replace(u.split('/')[4],'docFirmados');
            getSpinner('Guardando Documento Firmado');
            $.get("invoker/save.php?url="+d.split('srv-files/')[1].replace(u.split('/').pop(),'')+"&file="+u.split('/').pop(),
                {'idtrafirm':'<?=$idtra?>'},
                function() {
                    $.ajax({
                        method: "POST",
                        url: "ajax/ajaxPostFirma.php",
                        data: { iCodTramite: '<?=$idtra?>' },
                        datatype: "json",
                        success: function () {
                            document.getElementById('myIframe').src = d;
                            document.getElementById('btnAccion').setAttribute('onclick', 'volver()');
                            document.getElementById('btnAccion').innerText = 'Volver';
                            deleteSpinner();
                        }
                    });
                });
        }

        function MiFuncionOkLocal(){
            alert("Documento firmado desde la PC correctamente.");
            document.getElementById("signedDocument").href="controller/getFile.php?documentName=" + documentName_;
        }

        function MiFuncionCancel(){
            alert("El proceso de firma digital fue cancelado.");
            document.getElementById("signedDocument").href="#";
        }
        
        function  volver() {
            window.location.href = "main.php";
        }
    </script>

    </body>
    </html>

<?php } else{
    header("Location: ../index-b.php?alter=5");
}