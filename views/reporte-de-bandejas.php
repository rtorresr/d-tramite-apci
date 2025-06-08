<?php
session_start();

$pageTitle = "Reporte de bandejas";
$activeItem = "reporte-de-bandejas.php";

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
                <div class="col s12 m6">
                    <div class="card hoverable">
                        <div class="card-table">
                            <table class="bordered hoverable highlight striped" id="tblReporteBandejas">
                                <thead>
                                    <tr>
                                        <th>Oficina</th>
                                        <th>Por recibir</th>
                                        <th>Pendientes</th>
                                        <th>Derivados</th>
                                        <th>Por aprobar</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card hoverable">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </main>

        <?php include("includes/userinfo.php"); ?>
        <?php include("includes/pie.php"); ?>
    </body>
    <script>
        const Highcharts = require('highcharts');
        let draw = false;

        init();

        function init() {

            let table = $("#tblReporteBandejas").DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: ''
                    }
                },
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                },
                dom: '<"header"f>tr<"footer"l<"paging-info"ip>>',
                scrollY:        "50vh",
                scrollCollapse: true,
                ajax: 'ajax/ajaxReporteBandejas.php',
                //"iDisplayLength": 15,
                "paging": false,
                //"bLengthChange": false,
                "language": {
                    "url": "../dist/scripts/datatables-es_ES.json"
                },
            });

             // get table data
            let tableData = getTableData(table);

            // create Highcharts
            createHighcharts(tableData);

            // table events
            setTableEvents(table);
        }

        function getTableData(table) {
            let dataArray = [],
                oficinaArray = [],
                porRecibirArray = []
                pendientesArray = []
                derivadosArray = []
                porAprobarArray = []

            // loop table rows
            table.rows({ search: "applied" }).every(function() {
                let data = this.data();
                oficinaArray.push(data[0]);
                porRecibirArray.push(parseInt(data[1]));
                pendientesArray.push(parseInt(data[2]));
                derivadosArray.push(parseInt(data[3]));
                porAprobarArray.push(parseInt(data[4]));
            });

            // store all data in dataArray
            dataArray.push(oficinaArray, porRecibirArray, pendientesArray, derivadosArray, porAprobarArray);

            return dataArray;
        }

        function createHighcharts(data) {
            Highcharts.setOptions({
                lang: {
                thousandsSep: ","
                }
            });

            Highcharts.chart("chart", {
                title: {
                text: "DataTables to Highcharts"
                },
                subtitle: {
                text: ""
                },
                xAxis: [
                {
                    categories: data[0],
                    labels: {
                    rotation: -45
                    }
                }
                ],
                yAxis: [
                {
                    // first yaxis
                    title: {
                    text: "Cantidad"
                    }
                }
                ],
                series: [
                {
                    name: "Por recibir",
                    color: "#0071A7",
                    type: "column",
                    data: data[1],
                    tooltip: {
                    valueSuffix: ""
                    }
                },
                {
                    name: "Pendientes",
                    color: "#ffce85",
                    type: "column",
                    data: data[2],
                    tooltip: {
                    valueSuffix: ""
                    }
                },
                {
                    name: "Derivados",
                    color: "#f48116",
                    type: "column",
                    data: data[3],
                    tooltip: {
                    valueSuffix: ""
                    }
                },
                {
                    name: "Por aprobar",
                    color: "#90ee02",
                    type: "column",
                    data: data[4],
                    tooltip: {
                    valueSuffix: ""
                    }
                }
                ],
                tooltip: {
                shared: true
                },
                legend: {
                backgroundColor: "#ececec",
                shadow: true
                },
                credits: {
                enabled: false
                },
                noData: {
                style: {
                    fontSize: "16px"
                }
                }
            });
        }

        function setTableEvents(table) {
            // listen for page clicks
            table.on("page", () => {
                draw = true;
            });

            // listen for updates and adjust the chart accordingly
            table.on("draw", () => {
                if (draw) {
                draw = false;
                } else {
                let tableData = getTableData(table);
                createHighcharts(tableData);
                }
            });
        }
    </script>
    </html>
<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>	