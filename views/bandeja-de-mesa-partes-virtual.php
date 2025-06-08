<?php
session_start();

$pageTitle = "Bandeja Mesa de partes digital";
$activeItem = "bandeja-de-mesa-partes-virtual.php";
$navExtended = true;

if($_SESSION['CODIGO_TRABAJADOR']!=""){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <link href="includes/component-dropzone.css" rel="stylesheet">
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <main>
        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <li><a id="btnPrimary" style="display: none;" class="btn btn-primary" ><i class="fas fa-check fa-fw left"></i> Validar</a></li>
                        <li><a id="btnSecondary" style="display: none;" class="btn btn-primary" ><i class="fas fa-check fa-fw left"></i> Agregar Entidad</a></li>
                        <li><a id="btnThird" style="display: none;" class="btn btn-primary" ><i class="fas fa-check fa-fw left"></i> Derivar</a></li>
                        <li><a id="btnFourth" style="display: none;" class="btn btn-link" ><i class="fas fa-times fa-fw left"></i> Anular</a></li>
                        <li><a id="btnFifth" style="display: none;" class="btn btn-primary" ><i class="fas fa-check fa-fw left"></i> Ver</a></li>
                        <li><a id="btnSixth" style="display: none;" class="btn btn-primary" ><i class="fas fa-check fa-fw left"></i> Hoja Ruta</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <form name="frm-example" id="frm-example">
                                <table class="bordered hoverable highlight striped" id="tblBandejaMesaVirtual">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tipo</th>
                                            <th>Documento</th>
                                            <th>Entidad</th>
                                            <th>Responsable</th>
                                            <th>Cargo</th>                                            
                                            <th>Fecha de Registro</th>
                                            <th>Teléfono</th>
                                            <th>Correo</th>
                                        </tr>
                                    </thead>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modalEntidad" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Entidad</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <div class="row" id="nombreEntidadCol">
                <div class="col m9 input-field">
                    <select id="nombreEntidad" class="js-data-example-ajax browser-default" name="nombreEntidad"></select>
                    <label for="nombreEntidad">Nombre de la entidad</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
            <a id="AsignarEntidad" class="waves-effect waves-green btn-flat">Asignar</a>
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

    <div id="modalDerivar" class="modal">
        <div class="modal-header">
            <h4>Derivación del documento</h4>
        </div>
        <div class="modal-content">
            <form name="formDerivar" class="row" id="formDerivar">
                <div id="ofiOne">
                    <div class="col s12 m6 l6 input-field">
                        <select id="OficinaResponsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                            <option value="">Seleccione</option>
                            <?php
                            $sqlOfi = "SELECT iCodOficina, cNomOficina, cSiglaOficina FROM Tra_M_Oficinas WHERE iFlgEstado != 0 AND flgEliminado = 0 ORDER BY cNomOficina ASC";
                            $rsOfi  = sqlsrv_query($cnx,$sqlOfi);
                            while ($RsDep2 = sqlsrv_fetch_array($rsOfi)){
                                echo "<option value=".$RsDep2['iCodOficina']." >".trim($RsDep2['cNomOficina'])." - ".trim($RsDep2["cSiglaOficina"])."</option>";
                            }
                            //sqlsrv_free_stmt($rsDep2);
                            ?>
                        </select>
                        <label for="OficinaResponsableDer">Oficina</label>
                    </div>
                    <div class="col s12 m6 l6 input-field">
                        <select id="responsableDer" class="FormPropertReg mdb-select colorful-select dropdown-primary"></select>
                        <label for="responsableDer">Responsable</label>
                    </div>
                </div>
                <div class="input-field col s12 m5">
                    <select id="IndicacionDer">
                        <?php
                        $rsInd = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Indicaciones where flgEntrada = 1");
                        while ($RsInd = sqlsrv_fetch_array($rsInd)){
                            echo "<option value='".$RsInd['iCodIndicacion']."'>".trim($RsInd['cIndicacion'])."</option>";
                        } ?>
                    </select>
                    <label for="IndicacionDer">Indicación</label>
                </div>
                <div class="input-field col s12 m5">
                    <select id="prioridadDer"  class="size9 FormPropertReg mdb-select colorful-select dropdown-primary">
                        <option value="Alta">Alta</option>
                        <option value="Media" selected>Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                    <label for="prioridadDer">Prioridad</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarDer" class="waves-effect btn-flat">Derivar</a>
        </div>
    </div>

    <div id="modalHojaRuta" class="modal modal-fixed-footer modal-fixed-header" style="width: 30%!important;">
        <div class="modal-header">
            <h4>Registro concluido</h4>
        </div>
        <div id="divHojaIngreso" class="modal-content"></div>
        <div class="modal-footer">
            <button type="button" class="modal-print btn-flat" onclick="print('divHojaIngreso','Hoja-de-Ingreso')">Imprimir</button>
            <a class="waves-effect waves-green btn-flat modal-close" >Cerrar</a>
        </div>
    </div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>

    <script>
        $(document).ready(function() {
            $('.modal').modal();

            var tblBandejaMesaVirtual = $('#tblBandejaMesaVirtual').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.childRowImmediate,
                        type: ''
                    }
                },
                scrollY:"50vh",
                scrollCollapse: true,
                ajax: 'ajaxtablas/ajaxBMesaVirtual.php',
                drawCallback: function( settings ) {
                    $(".dataTables_scrollBody").attr("data-simplebar", "");
                    $('select[name="tblBandejaMesaVirtual_length"]').formSelect();

                    $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                        tblBandejaMesaVirtual.rows().deselect();
                    });
                },
                dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
                buttons: [
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
                        'orderable': false,
                        'checkboxes': {
                            'selectRow': true
                        }
                    },
                    {
                        'targets' : [2,3,4,6],
                        'orderable' : false
                    },
                    {
                        'targets' : [1,5,7,8]
                    }
                ],
                'columns': [
                    {'data': 'rowId', 'autoWidth': true},
                    {'data': 'TipoDoc', 'autoWidth': true},
                    {'data': 'NumeroDoc', 'autoWidth': true},
                    {'data': 'NombreEntidad', 'autoWidth': true},
                    {'data': 'NombreResponsable', 'autoWidth': true},
                    {'data': 'CargoResponsable', 'autoWidth': true},
                    {'data': 'FecRegistro', 'autoWidth': true},
                    {'data': 'Telefono', 'autoWidth': true},
                    {'data': 'Correo', 'autoWidth': true},
                ],
                'select': {
                    'style': 'multi'
                }
            });

            var btnPrimary = $("#btnPrimary");
            var btnSecondary = $("#btnSecondary");
            var btnThird = $("#btnThird");
            var btnFourth = $("#btnFourth");
            var btnFifth = $("#btnFifth");
            var btnSixth = $("#btnSixth");

            var actionButtons = [btnPrimary,btnSecondary,btnThird,btnFifth,btnSixth];
            var supportButtons = [btnFourth];

            tblBandejaMesaVirtual
                .on( 'select', function ( e, dt, type, indexes ) {
                    var count = tblBandejaMesaVirtual.rows( { selected: true } ).count();

                    switch (count) {
                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });

                            let fila = tblBandejaMesaVirtual.rows( { selected: true } ).data().toArray()[0];
                            if (fila.IdEntidad == null){
                                btnPrimary.css("display", "none");
                                btnThird.css("display", "none");
                            } else {
                                if (fila.IdTramite == null){
                                    btnSecondary.css("display", "none");
                                    btnThird.css("display", "none");
                                } else {
                                    btnPrimary.css("display", "none");
                                    btnSecondary.css("display", "none");
                                }
                            }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            break;
                    }

                })
                .on( 'deselect', function ( e, dt, type, indexes ) {
                    var rowData = tblBandejaMesaVirtual.rows( indexes ).data().toArray();
                    var count = tblBandejaMesaVirtual.rows( { selected: true } ).count();

                    switch (count) {
                        case 0:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            break;

                        case 1:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });

                            let fila = tblBandejaMesaVirtual.rows( { selected: true } ).data().toArray()[0];
                            if (fila.IdEntidad == null){
                                btnPrimary.css("display", "none");
                                btnThird.css("display", "none");
                            } else {
                                if (fila.IdTramite == null){
                                    btnSecondary.css("display", "none");
                                    btnThird.css("display", "none");
                                } else {
                                    btnPrimary.css("display", "none");
                                    btnSecondary.css("display", "none");
                                }
                            }
                            break;

                        default:
                            $.each( actionButtons, function( key, value ) {
                                value.css("display", "none");
                            });
                            $.each( supportButtons, function( key, value ) {
                                value.css("display", "inline-block");
                            });
                            break;
                    }
                });

            btnPrimary.on('click', function(e) {
                e.preventDefault();
                let fila = tblBandejaMesaVirtual.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    url: "registerDoc/regMesaPartesVirtual.php",
                    method: "POST",
                    data: {Evento : 'Validar', Id: fila.Id},
                    datatype: "json",
                    success: function () {
                        deleteSpinner();
                        tblBandejaMesaVirtual.ajax.reload();
                        M.toast({html: 'Documento validado correctamente!'});
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al derivar!');
                        deleteSpinner();
                        M.toast({html: "Error al validar documento"});
                    }
                });  
            });

            btnSecondary.on('click', function(e){
                e.preventDefault();
                $('#nombreEntidad').val(null).trigger('change');                
                let elem = document.querySelector('#modalEntidad');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.open();
            });

            $("#AsignarEntidad").on('click', function(e){
                e.preventDefault();
                let fila = tblBandejaMesaVirtual.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    url: "registerDoc/regMesaPartesVirtual.php",
                    method: "POST",
                    data: {Evento : 'AsignarEntidad', Id: fila.Id,IdEntidad : $("#nombreEntidad").val(), },
                    datatype: "json",
                    success: function () {
                        let elem = document.querySelector('#modalEntidad');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        deleteSpinner();
                        tblBandejaMesaVirtual.ajax.reload();
                        M.toast({html: 'Entidad asignada correctamente!'});
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al derivar!');
                        deleteSpinner();
                        M.toast({html: "Error al asignar entidad"});
                    }
                });              
                
            });

            $('#nombreEntidad').select2({
                placeholder: 'Seleccione y busque',
                minimumInputLength: 3,
                "language": {
                    "noResults": function(){
                        return "<p>No se encontró al destinatario. Para incluir un nuevo destinatario, comuníquese con el Responsable de Archivo de Gestión de su área.</p>";
                    },
                    "searching": function() {

                        return "Buscando..";
                    },
                    "inputTooShort": function() {

                        return "Ingrese más de 3 letras ...";
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                ajax: {
                    url: 'mantenimiento/Entidad.php',
                    dataType: 'json',
                    method: 'POST',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            Evento: 'BuscarEntidad'
                        }
                        return query;
                    },
                    delay: 100,
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            btnThird.on('click',function (e) {
                e.preventDefault();
                let elem = document.querySelector('#modalDerivar');
                let instance = M.Modal.init(elem, {dismissible:false});
                instance.open();
            });

            $("#btnEnviarDer").on('click',function (e) {
                e.preventDefault();
                let fila = tblBandejaMesaVirtual.rows( { selected: true } ).data().toArray()[0];
                let formData = new FormData();
                formData.append("Evento", "derivarMesaPartes");
                formData.append("iCodTramite", fila.IdTramite);
                formData.append("codEsTupa", 0);
                formData.append("iCodOficina", $("#OficinaResponsableDer").val());
                formData.append("iCodIndicacion", $("#IndicacionDer").val());
                formData.append("prioridad", $("#prioridadDer").val());
                getSpinner('Derivando documento');
                $.ajax({
                    url: "registerDoc/regMesaPartes.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success: function () {
                        refresh(actionButtons, supportButtons, tblBandejaMesaVirtual);
                        let elem = document.querySelector('#modalDerivar');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        deleteSpinner();
                        M.toast({html: 'Documento derivado correctamente!'});
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al derivar!');
                        deleteSpinner();
                        M.toast({html: "Error al derivar el documento"});
                    }
                });
            });

            btnFourth.on('click', function (e) {
                e.preventDefault();
                $.confirm({
                    columnClass: 'col s8 offset-s2  m6 offset-m3  l4 offset-l4',
                    title: '¿Esta seguro de anular?',
                    icon: 'fa fa-warning',
                    content: '',
                    closeIcon: true,
                    buttons: {
                        Si: function () {
                            getSpinner('Anulando...');
                            var rows_selected = tblBandejaIncompletos.column(0).checkboxes.selected();
                            var values=[];
                            $.each(rows_selected, function (index, rowId) {
                                values.push(tblBandejaIncompletos.rows(rowId).data()[0]);
                            });
                            let codigosTramite = [];
                            $.each(values, function (index, fila) {
                                codigosTramite.push(fila.codTramite);
                            });
                            console.log(values);
                            $.ajax({
                                cache: false,
                                url: "registerDoc/regMesaPartes.php",
                                method: "POST",
                                data: {Evento: "anularMesaPartes", values: codigosTramite},
                                datatype: "json",
                                success: function () {
                                    refresh(actionButtons,supportButtons,tblBandejaIncompletos);
                                    console.log('Documentos anulados correctamente!');
                                    deleteSpinner();
                                    M.toast({html: 'Documentos anulados correctamente!'});
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al anular los documentos!');
                                    M.toast({html: "Error al anular los documentos!"});
                                }
                            });
                        },
                        No: function () {
                            $.alert({
                                title: '¡Cancelado!',
                                content: '',
                                columnClass: 'col s8 offset-s2  m6 offset-m3  l4 offset-l4'
                            });
                        }
                    }
                });
            });

            btnFifth.on('click', function (e) {
                e.preventDefault();
                let fila = tblBandejaMesaVirtual.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    url: "ajax/obtenerDoc.php",
                    method: "POST",
                    data: {
                        codigo: fila.IdTramite
                    },
                    datatype: "json",
                    success: function (response) {
                        let json = $.parseJSON(response);
                        if (json.length !== 0){
                            console.log('¡Documento obtenido!');
                            $('#modalDoc div.modal-content iframe').attr('src', json['url']);
                            $('#modalDoc').modal('open');
                        } else {
                            console.log('¡No se pudo obtener el documento!');
                            M.toast({html:'¡No se pudo obtener el documento!'});
                        }
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al obtener el documento!');
                        M.toast({html: "Error al obtener el documento"});
                    }
                });
            });

            btnSixth.on('click', function (e) {
                e.preventDefault();
                let fila = tblBandejaMesaVirtual.rows( { selected: true } ).data().toArray()[0];
                $.ajax({
                    url: "registerDoc/regMesaPartes.php",
                    method: "POST",
                    data: {
                        codTramite: fila.codTramite,
                        Evento: "consultarHojaRuta"

                    },
                    datatype: "json",
                    success: function (respuesta) {
                        console.log('Obtenido correctamente!');
                        deleteSpinner();
                        let elems = document.querySelector('#modalHojaRuta');
                        let instance = M.Modal.init(elems, {dismissible:false});
                        $('#modalHojaRuta div.modal-content').html(respuesta);
                        instance.open();
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al obtener el documento!');
                        M.toast({html: "Error al obtener el documento"});
                    }
                });
            });
        });


        function refresh(actionButtons,supportButtons,tblBandejaIncompletos) {
            $.each( actionButtons, function( key, value ) {
                value.css("display", "none");
            });
            $.each( supportButtons, function( key, value ) {
                value.css("display", "none");
            });
            tblBandejaIncompletos.ajax.reload();
        }

        $('#OficinaResponsableDer').on('change', function () {
            $('#responsableDer option').remove();
            codigo = this.value;
            $.ajax({
                cache: false,
                method: 'POST',
                url: 'loadResponsableRIO.php',
                data: {iCodOficinaResponsable : codigo},
                dataType: 'json',
                success: function(list){
                    $.each(list,function(index,value)
                    {
                        $('#responsableDer').append($('<option>',{
                            value : value.iCodTrabajador,
                            text  : value.cNombresTrabajador.trim()+", "+value.cApellidosTrabajador.trim()
                        }));
                    });
                    $('#responsableDer').formSelect();
                },
            });

        });

    </script>

    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>