<?php
session_start();
$pageTitle = "Información de documento";
$activeItem = "iu_anulacion_documento.php";
$navExtended = false;  


If($_SESSION['CODIGO_TRABAJADOR']!=""){
    include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>        
</head>
<body class="theme-default has-fixed-sidenav" >
    <?php include("includes/menu.php");?>  

    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
                <form id="formBusqueda">
                    <div class="row">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-body">
                                    <fieldset>
                                        <legend>Documento</legend>
                                        <div class="row">                                            
                                            <div class="col s12 m8 input-field">
                                                <input type="text" class="FormPropertReg form-control" id="icoddigital">
                                                <label for="idTramite"></label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <input name="button" type="button" class="btn btn-secondary" value="Buscar" id="btnBuscar">
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>        
                            </div>                                                                                                       
                        </div>
                    </div>
                </form>                  
        </div>
    </main>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    <script>
       
        $("#btnBuscar").on("click", function (e) {
            if ($("#icoddigital").val() != null){
                $.ajax({
                    cache: false,
                    url: 'backResubirLF.php',
                    method: 'POST',
                    data: {Evento: "SubirDoc",IdDigital: $("#icoddigital").val()},
                    datatype: 'json',
                    success: function (response) {
                        var data = JSON.parse(response);
                        if(data.success){
                            $("#icoddigital").prop("readonly",true);
                        } else {
                            $("#icoddigital").prop("readonly",false);
                        }                
                    }
                });
            }
        });
    </script>
    </body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>