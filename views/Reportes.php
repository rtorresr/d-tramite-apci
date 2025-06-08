<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Reportes";
$activeItem = "Reportes.php";
$navExtended = true;

$nNumAno    = date("Y");
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
        <div class="row" id="filaGraficos" style="margin-top: 5px">

        </div>
    </main>

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>
    <script>
        function random_rgba() {
            var o = Math.round,
                r = Math.random,
                s = 255;
            return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
        }

        function generaGrafico(NombreReporte, tipo, idGrafico, tipoDatos, tituloGrafico){
            var html = '<div class="col s12 m6 l4">\n' +
                '                <div class="card">\n' +
                '                    <div class="card-header">\n' +
                '                        \n' + tituloGrafico +
                '                    </div>\n' +
                '                    <div class="card-content">\n' +
                '                        <canvas id="'+ idGrafico +'" width="400" height="400"></canvas>\n' +
                '                    </div>\n' +
                '                </div>\n' +
                '            </div>';

            $( "#filaGraficos" ).append(html);
            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxReportes.php',
                method: 'POST',
                data: {tipo: NombreReporte},
                datatype: 'json',
                success: function (data) {
                    var ctx = $('#'+idGrafico);
                    data = $.parseJSON(data);
                    var labels = [];
                    var datos = [];
                    var colores = {
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1,
                    };

                    $.each(data, function (i, value) {
                        labels.push(value.NOMBRE);
                        datos.push(value.TOTAL);
                        // var color = random_rgba();
                        // while ($.inArray(color, colores) !== -1) {
                        //     color = random_rgba();
                        // }
                        // colores.push(color);
                    });

                    var grafico = new Chart(ctx, {
                        type: tipo,
                        data: {
                            labels: labels,
                            datasets: [{
                                label: tipoDatos,
                                data: datos,
                                borderWidth: 0.35,
                                backgroundColor: colores.backgroundColor,
                                borderColor: colores.borderColor
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        }

        // var graficosPorGenerar = [
        //     'MOVIMIENTOS-GENERAL-APCI-OFICINAS',
        //     'OFICINA-RECIBIDOS-PENDIENTES',
        //     'OFICINA-RECIBIDOS-ATENDIDOS',
        //     'OFICINA-RECIBIDOS-ESTADOS',
        //     'JEFE-DELEGADOS',
        //     'JEFE-DERIVADOS',
        //     'PERSONAL-RECIBIDOS-PENDIENTE',
        //     'PERSONAL-RECIBIDOS-ATENDIDO',
        //     'PERSONAL-RECIBIDOS-ESTADOS',
        // ];

        var graphs = [
            {
                'id' : 'MOVIMIENTOS-GENERAL-APCI-OFICINAS',
                'name' : 'Movimiento General de Oficinas',
                'type' : 'bar',
                'color' : '#ff6384'

            },
            {
                'id' : 'OFICINA-RECIBIDOS-PENDIENTES',
                'name' : 'Pendientes de la Oficina',
                'type' : 'doughnut',
                'color' : '#ff6384'

            },
            {
                'id' : 'OFICINA-RECIBIDOS-ATENDIDOS',
                'name' : 'Atendidos de la Oficina',
                'type' : 'pie',
                'color' : '#ff6384'

            },
            {
                'id' : 'OFICINA-RECIBIDOS-ESTADOS',
                'name' : 'Recibidos de la Oficina',
                'type' : 'bar',
                'color' : '#ff6384'

            },
            {
                'id' : 'JEFE-DELEGADOS',
                'name' : 'Delegados',
                'type' : 'bar',
                'color' : '#ff6384'

            },
            {
                'id' : 'JEFE-DERIVADOS',
                'name' : 'Derivados',
                'type' : 'bar',
                'color' : '#ff6384'

            },
            {
                'id' : 'PERSONAL-RECIBIDOS-PENDIENTE',
                'name' : 'Pendientes de Personal',
                'type' : 'bar',
                'color' : '#ff6384'

            },
            {
                'id' : 'PERSONAL-RECIBIDOS-ATENDIDO',
                'name' : 'Atendidos del Persona',
                'type' : 'bar',
                'color' : '#ff6384'

            },
            {
                'id' : 'PERSONAL-RECIBIDOS-ESTADOS',
                'name' : 'Recibidos del Personal',
                'type' : 'bar',
                'color' : '#ff6384'

            }
        ];

        // $.each(graficosPorGenerar, function(l, m){
        //     generaGrafico(m, 'bar', m, 'Nº Movimientos', m);
        // });

        $.each(graphs, function(index, graph){
            generaGrafico(graph.id, graph.type, graph.id, 'Nº Movimientos', graph.name);            
            //console.log(graph.color);
        });
    </script>

    </body>
    </html>

    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>