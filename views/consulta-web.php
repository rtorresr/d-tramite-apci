<?php
date_default_timezone_set('America/Lima');
if (isset($_POST['cCodificacion'])) {
    $request = $_POST;
} elseif (isset($_GET['cCodificacion'])){
    $request = $_GET;
}  else {
    header("Location: consultaWeb.php?alter=3");
}
if($request['cCodificacion']=='' || $request['contrasena']==''){
    header("Location: consultaWeb.php?alter=3");
}else{
    include_once("../conexion/conexion.php");
    include_once("../conexion/parametros.php");
    $codificacion = trim($request['cCodificacion']);
    $clave = trim($request['contrasena']);

    $sql= "SELECT * FROM Tra_M_Tramite WHERE cCodificacion='".$codificacion."' AND clave = '".$clave."'";
    $rs = sqlsrv_query($cnx,$sql);
    if (sqlsrv_has_rows($rs)>0){
        $Rs=sqlsrv_fetch_array($rs);

        $sqlM = "SELECT TOP 1 iCodMovimiento FROM Tra_M_Tramite_Movimientos WHERE iCodTramite = '".$Rs['iCodTramite']."'";

        $rsM = sqlsrv_query($cnx,$sqlM);
        $RsM = sqlsrv_fetch_array($rsM);

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    $pageTitle = "Consulta Web";
    $activeItem = "consulta-web.php";
    include("includes/head.php");?>
</head>
<body id="consultaWeb" class="theme-default">
    <header class="mainHeader ">
        <div class="navbar-fixed">
            <nav class="navbar">
                <div class="nav-wrapper">
                    <h5 class="page-header truncate left">Consulta de Trámite con CUD N° <?= $Rs['cCodificacion'];?></h5>
                    <ul class="right" id="nav-mobile">
                        <li class="goBack">
                            <a class="btn btn-link" href="./consultaWeb.php">
                                <i class="fas fa-arrow-left left"></i><span>Volver</span>
                            </a>
                        </li>    
                    </ul> 
                </div>
            </nav>
        </div>
    </header>

        <div class="container" style="margin-top: 3rem">
            <div class="row">
                <div id="datosGenerales" class="col s12">

                </div>
            </div>
            <div class="row">
                <div id="DatosSigcti" class="col s12" style="display: none">

                </div>
            </div>
            <div class="row">
                <div id="flujoDoc" class="col s12">

                </div>
            </div>
   
        <!-- <div class="row">
            <div class="col s12 m9 l10">
                <div id="datosGenerales" class="section scrollspy"></div>

                <div id="DatosSigcti" class="section scrollspy"></div>

                <div id="flujoDoc" class="section scrollspy"></div>
            </div>

            <div class="col hide-on-small-only m3 l2">
                <ul class="section table-of-contents">
                    <li><a href="#datosGenerales">Datos Generales</a></li>
                    <li><a href="#DatosSigcti">SIGCTI</a></li>
                    <li><a href="#flujoDoc">Flujo</a></li>
                </ul>
            </div>
        </div> -->
        </div>
        
    </main>

    <script src="../dist/scripts/vendor.js"></script>
    <script src="../conexion/global.js"></script>
    <script>
        $(document).ready(function() {
            $('.scrollspy').scrollSpy();

            var value = [];
            value.push(<?php echo $RsM['iCodMovimiento']; ?>);

            var tramite = <?php echo $Rs['iCodTramite']?>;

            $.ajax({
                url: RutaSIGTID+"/ApiD-Tramite/Api/Tramite/TRA_GET_0006?CodTramite=" + tramite,
                method: "GET",
                datatype: "application/json",
                success: function (response) {
                    if (response.Success === true){
                        var datos = response.ListResult[0];

                        var htmlFinal = `
                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <span class="card-title" style="display: block; line-height: 32px; margin-bottom: 8px; background: #d2e4f3; padding: 0 10px;">Observaciones SIGCTI</span>
                                    <div class="card-content">
                                        <small class="overline">CONST. ${datos.NroConstancia}</small>
                                        <h5 class="subtitle" style="margin-top: 0">
                                            ${datos.NroDocumento}
                                            
                                            <span class='badge'>F. Doc. ${datos.FecDocumento}</span>
                                        </h5>
                                        <p>${datos.Asunto}</p>
                                    </div>
                                    <div class="card-action">
                                        <a class="btn waves-effect waves-light btn-primary" href="${datos.Susbsanar}">Subsanar</a>
                                        <a class="btn waves-effect waves-light btn-link" href="${datos.Digital}" download  title="Descargar">Ver documento</a>
                                        <a></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                        var html =
                            '<ul class="collapsible">\n' +
                            '    <li class="active">\n' +
                            '        <div class="collapsible-header">Bandeja de Observaciones</div>\n' +
                            '        <div class="collapsible-body" style="display:block">\n' +
                            '            <div class="row">\n' +
                            '                <div class="col s12">\n' +
                            '                    <table>\n' +
                            '                        <thead>\n' +
                            '                            <tr>\n' +
                                                            '<th>Documento</th>\n' +
                            '                                <th>Asunto</th>\n' +
                            '                                <th>Fecha</th>                              \n' +
                            '                                <th>CUD</th>\n' +
                            '                                <th>N° Constancia</th>\n' +
                            '                                <th>Archivo</th>\n' +
                            '                                <th>Subsanar</th>\n' +
                            '                            </tr>  \n' +
                            '                        </thead>\n' +
                            '                        <tbody>\n' +
                            '                            <tr>\n' +
                            '                                <td>'+ datos.NroDocumento +'</td>\n' +
                            '                                <td>'+ datos.Asunto +'</td>\n' +
                            '                                <td>'+ datos.FecDocumento +'</td>\n' +
                            '                                <td>'+ datos.NroCud +'</td>\n' +
                            '                                <td>'+ datos.NroConstancia +'</td>\n' +
                            '                                <td>\n' +
                            '                                    <a href="'+ datos.Digital +'" target="_blank"  title="Descargar"><i class="fas fa-file-pdf"></i></a>\n' +
                            '                                </td>\n' +
                            '                                <td>\n' +
                            '                                    <a href="'+ datos.Susbsanar +'" target="_blank">Subsanar</a>\n' +
                            '                                </td>\n' +
                            '                            </tr>\n' +
                            '                        </tbody>\n' +
                            '                    </table>                    \n' +
                            '                </div>   \n' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '    </li>\n' +
                            '</ul>';
                        $('#DatosSigcti').html(htmlFinal);
                        $("#DatosSigcti").css("display","block");
                    } else {
                        console.log('Datos no encontrados.');
                    }
                }
            });

            $.ajax({
                cache: false,
                url: "registroDetalles.php",
                method: "POST",
                data: {iCodMovimiento : value},
                datatype: "json",
                success : function(response) {
                    console.log(response);
                    $('#datosGenerales').html(response);
                }
            });

            if(value[0] <= 18997){
                var documentophp = "flujodoc_old.php"
            } else{
                var documentophp = "flujodoc.php"
            }

            $.ajax({
                cache: false,
                url: documentophp,
                method: "POST",
                data: {iCodMovimiento : value, ocultarCom: '1'},
                datatype: "json",
                success : function(response) {
                    $('#flujoDoc').html(response);
                }
            });

        });
    </script>
</body>

        </html>
<?php
    }else{
        header("Location: consultaWeb.php?alter=4");
    }
}
