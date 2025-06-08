<?php
session_start();

$pageTitle = "Bandeja de Recibidos";
$activeItem = "bandeja-de-pendientes.php";
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
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><a class="btn btn-primary" id="btnBuscar"><i class="fas fa-reply fa-fw left"></i><span>Buscar</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <span class="card-title">Filtros</span>
                        <div class="card-content">
                            <form id="FormFiltros">
                                <div class="row">
                                    <div class="col s12 m6 input-field">
                                        <input placeholder="dd-mm-aaaa" value="" type="text" class="datepicker" name="FecInicio" id="FecInicio">
                                        <label for="FecInicio">Fecha de Inicio</label>
                                    </div>
                                    <div class="col s12 m6 input-field">
                                        <input placeholder="dd-mm-aaaa" value="" type="text" class="datepicker" name="FecFin" id="FecFin">
                                        <label for="FecFin">Fecha de Fin</label>
                                    </div>
                                    <div class="col s12 m6 input-field">
                                        <select name="nivelBusqueda" id="nivelBusqueda">
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                        <label for="nivelBusqueda">Nivel de búsqueda</label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div id="TablaResumen">
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

        function GraphTable(data,objeto){
            objeto.html += '<table class="striped">' +
                '       <tbody>';
            $.each(data, function (i, conjunto) {
                let ArrayDatos = [];
                objeto.html += '   <tr>';
                $.each(conjunto, function (key, value) {
                    ArrayDatos.push(value);
                });
                objeto.html += '   <td>'+ArrayDatos[1]+'</td>' +
                    '       <td>'+ArrayDatos[2]+'</td>' +
                    '       <td>';
                if(ArrayDatos[3] !== null){
                    GraphTable(ArrayDatos[3],objeto);
                }
                objeto.html += '   </td>';
                objeto.html += '   </tr>';
            });
            objeto.html += '   </tbody>' +
                '   </table>';
        };

        $('#btnBuscar').on('click', function () {
            let datos = new FormData();
            let data = $('#FormFiltros').serializeArray();
            $.each(data, function(key, el) {
                datos.append(el.name, el.value);
            });
            datos.append("TipoReporte","Resumen");
            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxReportes.php',
                method: 'POST',
                data: datos,
                processData: false,
                contentType: false,
                datatype: 'json',
                success: function (data) {
                    var objeto = {
                        html : ''
                    };
                    data = $.parseJSON(data);
                    data = $.parseJSON(data[0].JSONDATOS);
                    GraphTable(data,objeto);
                    $('#TablaResumen').empty().append(objeto.html);
                }
            })
        });

    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>