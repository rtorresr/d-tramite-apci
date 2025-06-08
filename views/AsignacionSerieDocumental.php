<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Bandeja asignación series documentales";
$activeItem = "AsignacionSerieDocumental.php";
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
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile">
                        <li><a id="btnAsignarSerie" style="display: none" class="btn btn-primary"><i class="fas fa-project-diagram fa-fw left"></i><span>Asignar Serie</span></a></li>
                        <li><a id="btnFlow" style="display: none" class="btn btn-link"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                        <li><a id="btnDoc" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver</span></a></li>
                        <li><a id="btnAnexos" style="display: none" class="btn btn-link"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <table id="tblDocsPorAsignarSerie" class="bordered hoverable highlight striped" name="tblDocsPorAsignarSerie" style="width: 100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>CUD</th>
                                    <th>Documento</th>
                                    <th>Asunto</th>
                                    <th>Fecha de Registro</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalAsignacionSerie" class="modal modal-fixed-header modal-fixed-footer">
            <div class="modal-header">
                <h4>Asignación de Serie Documental</h4>
            </div>
            <div class="modal-content">
                <form>
                    <input type="hidden" id="IdTramite" value="0">
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="IdSerieDocumental">
                            </select>
                            <label for="IdSerieDocumental">Serie documental</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
                <a id="btnFinalizarAsignacion" class="waves-effect waves-green btn-flat">Asignar</a>
            </div>
        </div>

        <div id="modalFlujo" class="modal modal-fixed-header modal-fixed-footer">
            <div class="modal-header">
                <h4>Flujo del trámite</h4>
            </div>
            <div class="modal-content"></div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>

        <div id="modalDoc" class="modal modal-fixed-footer modal-fixed-header">
            <div class="modal-header">
                <h4>Documento</h4>
            </div>
            <div class="modal-content" style="text-align: center; overflow: hidden;">
                <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
            </div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>
        <div id="modalAnexo" class="modal">
            <div class="modal-header">
                <h4>Anexos</h4>
            </div>
            <div class="modal-content">
                <ul class="fa-ul"></ul>
            </div>
            <div class="modal-footer">
                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            </div>
        </div>
    </main>


    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>
    <script>
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.modal');
            var instances = M.Modal.init(elems);
        });

        function ListarSerieDocumental(idDestino, viIdOficina) {
            let idOficina = 0;
            if (viIdOficina === null || viIdOficina === ''){
                idOficina = 0;
            } else {
                idOficina = viIdOficina;
            }
            $.ajax({
                cache: false,
                url: "ajax/ajaxSeriesDocumentales.php",
                method: "POST",
                data: {idOficina: idOficina, flgVigente: 2},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    destino.append('<option value="0">SELECCIONE</option>');
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }

        $(document).ready(function (){
            $('.modal').modal();
            $('.actionButtons').hide();

            $('.datepicker').datepicker({
                i18n: {
                    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                    weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                    weekdaysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                    weekdaysAbbrev: ["D", "L", "M", "M", "J", "V", "S"],
                    cancel: "Cancelar",
                    clear: "Limpiar"
                },
                format: 'dd-mm-yyyy',
                disableWeekends: true,
                autoClose: true,
                showClearBtn: true,
                container: 'body'
            });

        });

        var tblDocsPorAsignarSerie = $('#tblDocsPorAsignarSerie').DataTable({
            responsive: true,
            ajax:  'ajaxtablas/ajaxConsultaPorAsignarSerie.php',
            drawCallback: function( settings ) {
                $(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tblDocsPorAsignarSerie_length"]').formSelect();

                $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                    tblDocsPorAsignarSerie.rows().deselect();
                });
            },
            dom: '<"header"B>tr<"footer"l<"paging-info"ip>>',
            buttons: [
                { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel', exportOptions: { modifier: { page: 'all', search: 'none' } } },
                { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
            ],
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columnDefs': [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true
                    }
                }
            ],
            'columns': [
                {'data': 'rowId', 'autoWidth': true}
                ,{
                    'render': function (data, type, full, meta) {
                        let iconos = '';
                        if (full.NroAdjuntos !== 0) {
                            //iconos += '<span class="number">A-'+full.adjuntos+'</span>';
                            iconos += '<i class="fas fa-fw fa-paperclip"style="padding: 6px 6px 0 0; font-size: 16px"></i> ';
                        }else{
                            iconos += '<i class="fas fa-fw fa-paperclip" style="opacity: 0.1; padding: 6px 6px 0 0; font-size: 16px"></i> ';
                        }
                        return iconos
                    },
                }
                ,{'data': 'Cud', 'autoWidth': true}
                ,{'data': 'Documento', 'autoWidth': true}
                ,{'data': 'Asunto', 'autoWidth': true}
                ,{'data': 'FecRegistro', 'autoWidth': true}

            ],
            'select': {
                'style': 'multi'
            },
            "ordering": false
        });
        
        var btnAsignarSerie = $("#btnAsignarSerie");
        var btnFlow = $("#btnFlow");
        var btnDoc = $("#btnDoc");
        var btnAnexos = $("#btnAnexos");

        var actionButtons = [btnAsignarSerie];
        var supportButtons = [btnFlow, btnDoc, btnAnexos];


        tblDocsPorAsignarSerie
            .on( 'select', function ( e, dt, type, indexes ) {
                var rowData = tblDocsPorAsignarSerie.rows( indexes ).data().toArray();
                var count = tblDocsPorAsignarSerie.rows( { selected: true } ).count();

                switch (count) {
                    case 1:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });

                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });

                        let fila = tblDocsPorAsignarSerie.rows( { selected: true } ).data().toArray()[0];
                        if (fila.adjuntos === 0) {
                            btnAnexos.css("display","none");
                        }
                        $('.actionButtons').show();
                        break;

                    default:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        break;
                }



            })
            .on( 'deselect', function ( e, dt, type, indexes ) {
                var rowData = tblDocsPorAsignarSerie.rows( indexes ).data().toArray();
                var count = tblDocsPorAsignarSerie.rows( { selected: true } ).count();

                switch (count) {
                    case 0:
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $('.actionButtons').hide(100);
                        break;

                    case 1:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });

                        let fila = tblDocsPorAsignarSerie.rows( { selected: true } ).data().toArray()[0];
                        if (fila.adjuntos === 0) {
                            btnAnexos.css("display","none");
                        }
                        break;

                    default:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        break;
                }
            });

        btnAsignarSerie.on('click', function (e) {
            let rows_selected = tblDocsPorAsignarSerie.column(0).checkboxes.selected();
            let values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblDocsPorAsignarSerie.rows(rowId).data()[0]);
            });
            let idTramites = [];
            $.each(values, function (index, fila) {
                idTramites.push(fila.IdTramite);
            });
            $("#IdTramite").val(JSON.stringify(idTramites));
            ListarSerieDocumental('IdSerieDocumental' ,sesionOficina);
            let elems = document.querySelector('#modalAsignacionSerie');
            let instance = M.Modal.getInstance(elems);
            instance.open();
        });
        
        $("#btnFinalizarAsignacion").on("click", function (e) {
            if ($("#IdSerieDocumental").val() == 0){
                $.alert("¡Falta seleccionar serie documental!");
                return false;
            }

            $.ajax({
                cache: false,
                url: "ajax/ajaxAsignarSerie.php",
                method: "POST",
                data: {
                    IdTramite : $("#IdTramite").val(),
                    IdSerieDocumental : $("#IdSerieDocumental").val()
                },
                datatype: "json",
                success : function() {
                    tblDocsPorAsignarSerie.ajax.reload();
                    M.toast({html: "¡Serie documental asignada correctamente!"});
                    let elems = document.querySelector('#modalAsignacionSerie');
                    let instance = M.Modal.getInstance(elems);
                    instance.close();
                }
            });
        });

        btnFlow.on('click', function(e) {
            let rows_selected = tblDocsPorAsignarSerie.column(0).checkboxes.selected();
            let values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblDocsPorAsignarSerie.rows(rowId).data()[0]);
            });
            let idTramites = [];
            $.each(values, function (index, fila) {
                idTramites.push(fila.IdTramite);
            });
            if(idTramites[0] <= 7367){
                var documentophp = "flujodoc_old.php"
            } else{
                var documentophp = "flujodoc.php"
            }
            $.ajax({
                cache: false,
                url: documentophp,
                method: "POST",
                data: {codigo : idTramites[0]},
                datatype: "json",
                success : function(response) {
                    $('#modalFlujo div.modal-content').html(response);
                    let elems = document.querySelector('#modalFlujo');
                    let instance = M.Modal.getInstance(elems);
                    instance.open();
                }
            });
        });

        btnDoc.on('click', function(e) {
            e.preventDefault();
            let rows_selected = tblDocsPorAsignarSerie.column(0).checkboxes.selected();
            let values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblDocsPorAsignarSerie.rows(rowId).data()[0]);
            });
            let idTramites = [];
            $.each(values, function (index, fila) {
                idTramites.push(fila.IdTramite);
            });
            $.ajax({
                cache: false,
                url: "ajax/obtenerDoc.php",
                method: "POST",
                data: {codigo: idTramites[0]},
                datatype: "json",
                success: function (response) {
                    let json = $.parseJSON(response);
                    if (json.length !== 0) {
                        $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);
                        let elems = document.querySelector('#modalDoc');
                        let instance = M.Modal.getInstance(elems);
                        instance.open();
                    }else {
                        M.toast({html: '¡No contiene documento asociado!'});
                    }
                }
            });
        });

        btnAnexos.on('click', function(e) {
            e.preventDefault();
            let rows_selected = tblDocsPorAsignarSerie.column(0).checkboxes.selected();
            let values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblDocsPorAsignarSerie.rows(rowId).data()[0]);
            });
            let idTramites = [];
            $.each(values, function (index, fila) {
                idTramites.push(fila.IdTramite);
            });
            $.ajax({
                cache: false,
                url: "verAnexo.php",
                method: "POST",
                data: {codigo: idTramites[0], tabla: 't'},
                datatype: "json",
                success: function (response) {
                    $('#modalAnexo div.modal-content ul').html('');
                    var json = eval('(' + response + ')');
                    if(json.tieneAnexos == '1') {
                        let cont = 1;
                        json.anexos.forEach(function (elemento) {
                            $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="http://'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                            cont++;
                        })
                    }else{
                        $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                    }
                    let elems = document.querySelector('#modalAnexo');
                    let instance = M.Modal.getInstance(elems);
                    instance.open();
                }
            });
        });

    </script>

    </body>
    </html>

    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>