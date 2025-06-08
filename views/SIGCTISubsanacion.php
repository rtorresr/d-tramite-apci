<?php
session_start();

$pageTitle = "Subanacion";
$activeItem = "SIGCTISubsanacion.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <main>
        <div class="container">
            
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-body">
                            <div class="row">
                                <div class="col s6">
                                    <input value="" type="text" id="cud"  class="FormPropertReg form-control">
                                </div>
                                <div class="col s3">
                                    <button type="button" class="btn btn-secondary" id="btnBuscar">Buscar</button>
                                </div>
                                <div class="col s3">
                                    <button type="button" class="btn btn-primary" id="btnSubsanar">Subsanar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <table id="tblPendientes" class="hoverable highlight striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>CUD</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>
    <script>
        function buscarPendientes(cud){
            $.post('ajax/ajaxSIGCTISubsanacion.php', {Evento: 'ListarCudsPendientes', Cud: cud})
                .done(function(response){
                    var response = $.parseJSON(response);
                    $("#tblPendientes tbody").empty();
                    $.each(response, function (i,e) {
                        var fila = `<p><label><input disabled="disabled" type="checkbox" class="filled-in cuds"  value="${e.cud}"><span>${e.cud}</span></label></p>`;
                        $("#tblPendientes tbody").append(`<tr><td>${fila}</td></tr>`);
                    });  
                });
        }

        function subsanarCudPendiente(cud){
            $.post('ajax/ajaxSIGCTISubsanacion.php', {Evento: 'SubsanarCudPendiente', Cud: cud})
                .done(function(response){
                    var response = $.parseJSON(response);
                    if(response.success){
                        $(".cuds[value=" + cud +"]").prop("checked",true);
                    }
                });
        }

        $("#btnBuscar").on("click", function(){
            buscarPendientes($("#cud").val());
        });

        $("#btnSubsanar").on("click", function(){
            $.each($("#tblPendientes tbody .cuds"), function (i,e) {
                var cud = $(e).val();
                subsanarCudPendiente(cud);
            });
        });        

        $(document).ready(function() {
            buscarPendientes(null);
        });
            
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>