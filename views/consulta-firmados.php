<?php
date_default_timezone_set('America/Lima');
session_start();

$pageTitle = "Consulta de Documentos Emitidos";
$activeItem = "consulta-emitidos_.php";
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
<!--Main layout-->
 <main>
    <div class="navbar-fixed actionButtons">
        <nav>
            <div class="nav-wrapper">
                <ul id="nav-mobile" class="">
                    <li><a href="javascript:;" id="btnPrimary" class="btn btn-primary"><i class="fas fa-search fa-fw left"></i><span>Buscar</span></a></li>
                    <li><a id="btnFlow" class="btn disabled btn-link modal-trigger" href="#modalFlujo"><i class="fas fa-project-diagram fa-fw left"></i><span>Flujo</span></a></li>
                    <!-- <li><a id="btnDoc" class="btn disabled btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li> -->
                    <li><a id="btnAnexos" class="btn disabled btn-link modal-trigger" href="#modalAnexo"><i class="fas fa-paperclip fa-fw left"></i><span>Anexos</span></a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container">
        <form action="">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-body">
                        <fieldset>
                                <legend>Campos de búsqueda</legend>
                                    <div class="row">
                                        <div class="col s1 input-field">
                                            <input type="text" name="txtCUD" id="txtCUD">
                                            <label for="txtCUD">CUD</label>
                                        </div>
                                        <div class="col s2 input-field">
                                            <select id="cCodTipoDoc" name="cCodTipoDoc">
                                            </select>
                                            <label for="cCodTipoDoc">Tipo de documento</label>
                                        </div>
                                        <div class="col s1 input-field">
                                            <input type="text" name="txtDoc" id="txtDoc">
                                            <label for="txtDoc">N° Doc.</label>
                                        </div>
                                        <div class="col s3 input-field">
                                            <input type="text" name="txtAsunto" id="txtAsunto">
                                            <label for="txtAsunto">Asunto</label>
                                        </div>
                                        <div class="col s2 input-field">
                                            <input type="text" name="txtRemitente" id="txtRemitente">
                                            <label for="txtRemitente">Remitente</label>
                                        </div>
                                        <div class="col s2 input-field">
                                            <select id="cCodOfi" name="cCodOfi">
                                            </select>
                                            <label for="cCodOfi">Oficina</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s2 input-field">
                                            <select id="cboTramite" name="cboTramite">
                                                <!-- <option value="">TODOS</option> -->
                                                <option value="1" selected>TRÁMITES</option>
                                                <option value="2">PROYECTADOS</option>
                                            </select>
                                            <label for="cboTramite">Tipo de Trámite</label>
                                        </div>
                                        <div class="col s2 input-field">
                                            <select id="cboEstado" name="cboEstado">
                                                <option value="">TODOS</option>
                                                <option value="1">EN PROCESO/PENDIENTE</option>
                                                <option value="2">DERIVADO</option>
                                                <option value="3">DELEGADO</option>
                                                <option value="4">RESPONDIDO</option>
                                                <option value="5">FINALIZADO</option>
                                                <option value="6">RECHAZADO</option>
                                                <option value="7">CANCELADO</option>
                                                <option value="8">VISADO</option>
                                                <option value="9">FIRMADO</option>
                                            </select>
                                            <label for="cboEstado">Estado</label>
                                        </div>
                                    </div>
                            </fieldset>
                        </div>
                        <div class="card-table">
                            <table id="tblConsultaGen" class="bordered hoverable highlight striped" name="tblConsultaGen">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>CUD</th>
                                        <th>Documento</th>
                                        <th>Asunto</th>
                                        <th>Remitente</th>
                                        <th>Oficina de Origen</th>
                                        <th>Trabajador Origen</th>
                                        <th>Oficina Destino</th>
                                        <th>Estado Documento</th>
                                        <th>Fecha de Derivacion</th>
                                        <th>Fecha de Recepcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        var instances = M.Modal.init(elems);
        //console.log(instances);
    });

    $(document).ready(function (){
        $('.modal').modal();
        $.ajax({
            cache: 'false',
            url: 'ajax/ajaxTipoDocumento.php',
            method: 'POST',
            data: {tipoDoc: '0'},
            datatype: 'json',
            success: function (data) {

                $('select[name="cCodTipoDoc"]').empty().append('<option value="">Seleccione</option>');
                var documentos = JSON.parse(data);
                $.each(documentos, function (key,value) {

                    $('select[name="cCodTipoDoc"]').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                });
                $('select[name="cCodTipoDoc"]').formSelect();
            }
        });

        $.ajax({
            cache: 'false',
            url: 'ajax/ajaxOficinas.php',
            method: 'POST',
            data: {esTupa: '0'},
            datatype: 'json',
            success: function (data) {

                $('select[name="cCodOfi"]').empty().append('<option value="">Seleccione</option>');
                var documentos = JSON.parse(data);
                $.each(documentos.data, function (key,value) {

                    $('select[name="cCodOfi"]').append(value);
                });
                $('select[name="cCodOfi"]').formSelect();
            }
        });

    });

    $(function(){
        var tblConsultaGen = $('#tblConsultaGen').DataTable({
             responsive: {
                 details: {
                     display: $.fn.dataTable.Responsive.display.childRowImmediate,
                     type: ''
                 }
            },
            scrollY:        "50vh",
            scrollCollapse: true,
            ajax: 'ajaxtablas/ajaxTablaConsultaFirmado.php',
            drawCallback: function( settings ) {
                $(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tblConsultaGen_length"]').formSelect();
            },
            dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
            buttons: [
                //{ extend: 'copy', text: '<i class="fas fa-copy"></i> Copiar' },
                //{ extend: 'csv', text: '<i class="fas fa-file-excel"></i> CSV' },
                { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel' },
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
            'select': {
                'style': 'single'
            }, 
            'order': [[1, 'asc']]
        });

        $("body").bind("DOMNodeInserted", function() {
            $(this).find(".dt-checkboxes-select-all").addClass("input-disabled");
        });

        var btnPrimary = $("#btnPrimary");
        var btnFlow = $("#btnFlow");
        var btnDoc = $("#btnDoc");
        var btnAnexos = $("#btnAnexos");

        var actionButtons = [btnPrimary];
        var supportButtons = [btnFlow,btnDoc,btnAnexos];



        tblConsultaGen
            .on( 'select', function ( e, dt, type, indexes ) {
                var rowData = tblConsultaGen.rows( indexes ).data().toArray();
                var count = tblConsultaGen.rows( { selected: true } ).count();

                switch (count) {
                    case 1:
                        $.each( actionButtons, function( key, value ) {
                            value.removeClass("disabled");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.removeClass("disabled");
                        });
                        break;

                    default:
                        $.each( actionButtons, function( key, value ) {
                            value.removeClass("disabled");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.addClass("disabled");
                        });
                        break;
                }



            })
            .on( 'deselect', function ( e, dt, type, indexes ) {
                var rowData = tblConsultaGen.rows( indexes ).data().toArray();
                var count = tblConsultaGen.rows( { selected: true } ).count();

                switch (count) {
                    case 0:
                        // $.each( actionButtons, function( key, value ) {
                        //     value.addClass("disabled");
                        // });
                        $.each( supportButtons, function( key, value ) {
                            value.addClass("disabled");
                        });
                        break;

                    case 1:
                        $.each( actionButtons, function( key, value ) {
                            value.removeClass("disabled");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.removeClass("disabled");
                        });
                        break;

                    default:
                        $.each( actionButtons, function( key, value ) {
                            value.removeClass("disabled");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.addClass("disabled");
                        });
                        break;
                }
            });

        btnFlow.on('click', function(e) {
            e.preventDefault();
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(rowId);
            });
            console.log(values);
            $.ajax({
                cache: false,
                url: "flujodoc.php",
                method: "POST",
                data: {iCodMovimiento : values},
                datatype: "json",
                success : function(response) {
                    console.log(response);
                    $('#modalFlujo div.modal-content').html(response);
                }
            });
        });

        // Doc. button
        btnDoc.on('click', function(e) {
            var elems = document.querySelector('#modalDoc');
            var instance = M.Modal.getInstance(elems);
            e.preventDefault();
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(rowId);
            });
            $.ajax({
                cache: false,
                url: "verDoc.php",
                method: "POST",
                data: {iCodMovimiento: values, tabla: 't'},
                datatype: "json",
                success: function (response) {
                    var json = eval('(' + response + ')');
                    if (json['estado'] == 1) {
                        $('#modalDoc div.modal-content iframe').attr('src', json['url']);
                        instance.open();
                    }else {
                        M.toast({html: '¡No contiene documento asociado!'});
                    }
                }
            });
        });

        btnAnexos.on('click', function(e) {
            e.preventDefault();
            var rows_selected = tblConsultaGen.column(0).checkboxes.selected();
            var values=[];
            $.each(rows_selected, function (index, rowId) {
                values.push(rowId);
            });
            $.ajax({
                cache: false,
                url: "verAnexo.php",
                method: "POST",
                data: {iCodMovimiento: values, tabla: 't'},
                datatype: "json",
                success: function (response) {

                    $('#modalAnexo div.modal-content ul').html('');
                    var json = eval('(' + response + ')');
                    //  $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);

                    if(json.tieneAnexos == '1') {
                        let cont = 1;
                        json.anexos.forEach(function (elemento) {
                            $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-file-alt"></i></span><a class="btn-link" href="'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                            cont++;
                        })
                    }else{
                        $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-info"></i></span>El documento no tiene Anexos.</li>');
                    }
                }
            });

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