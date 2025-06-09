<?php
session_start();

$pageTitle = "Bandeja de Trabajo";
$activeItem = "bandeja-de-trabajo.php";
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
                        <li><a id="btnPrimary" style="display: none" class="btn btn-primary" href="#"><i class="fas fa-reply fa-fw left"></i><span>Trabajar</span></a></li>
                        <li><a id="btnRechazar" style="display: none" class="btn btn-link" href="#modalRechazar" ><i class="fas fa-times fa-fw left"></i><span>Rechazar</span></a></li>
                        <li><a id="btnSecondary"  style="display: none" class="btn btn-link" href="#modalArchivar"><i class="fas fa-archive fa-fw left"></i><span>Archivar</span></a></li>
                        <?php
                            if ($_SESSION['iCodPerfilLogin'] == 3 || $_SESSION['iCodPerfilLogin'] == 18 || $_SESSION['iCodPerfilLogin'] == 19 || $_SESSION['iCodPerfilLogin'] == 20 ){
                                echo '<li><a id="btnThird" style="display: none" class="btn btn-link"><i class="fas fa-arrow-left fa-fw left"></i><span>Delegar</span></a></li>';
                                echo '<li><a id="btnFourth" style="display: none" class="btn btn-link"><i class="fas fa-arrow-right fa-fw left"></i><span>Derivar</span></span></a></li>';
                            }
                        ?>
                        <li><a id="btnRetroceder" style="display: none" class="btn btn-link"><i class="fas fa-undo left"></i><span>Retroceder</span></a></li>
                        <li><a id="btnDerivar" style="display: none" class="btn btn-link"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<span>Derivar</span></a></li>
                        <li><a id="btnGenerar" style="display: none" class="btn btn-link"><i class="far fa-fw fa-file"></i>&nbsp;<span>Generar Documentos</span></a></li>
                        <li><a id="btnFirmar" style="display: none" class="btn btn-link"><i class="fas fa-fw fa-signature fa-fw left"></i>&nbsp;<span>Firmar Documentos</span></a></li>
                        <li><a id="btnDoc" style="display: none" class="btn btn-link"><i class="fas fa-file-pdf fa-fw left"></i><span>Ver Doc.</span></a></li>
                </div>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable">
                        <div class="card-table">
                            <table id="tblBandejaTrabajo" class="hoverable highlight striped" style="width: 100%">
                                <thead>
                                    <tr>                                        
                                        <th></th>
                                        <th></th>
                                        <th>CUD</th>
                                        <th>Documento</th>
                                        <th>Asunto</th>
                                        <th>Entidad</th>
                                        <th>Última fecha Modificación</th>
                                        <th>Origen</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <form id="frmRespuesta" method="GET" action="registroOficina.php">
                        <input type="hidden" id="dtr" name="dtr">
                        <!-- <input type="hidden" id="iCodMov" name="iCodMov">
                        <input type="hidden" id="trabajarAgrupado" name="trabajarAgrupado">
                        <input type="hidden" id="datos" name="datos"> -->
                    </form>                   
                </div>
            </div>
        </div>
    </main>

    <form id="valoresFirma">
        <input type="hidden" id="idDigitalLote">
        <input type="hidden" id="sT">           <!-- PARA SELLADO DE TIEMPO  --->
    </form>

    <div id="addComponent"></div>

    <?php include("includes/userinfo.php"); ?>
    <?php include("includes/pie.php"); ?>
    </body>

    <div id="modalDoc" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <div class="row">
                <div class="col s6">
                    <h4>Documento</h4>  
                </div>
                <div class="col s6" style="text-align: right">
                    Documento 
                    <span id="textActual"></span> de 
                    <span id="textTotal"></span>
                    <a class="btn btn-link" id="btnAnterior"><i class="fas fa-chevron-left"></i></a>
                    <a class="btn btn-link" id="btnSiguiente"><i class="fas fa-chevron-right"></i></a> 
                </div>
            </div>
        </div>
        <div class="modal-content p-0" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">            
            <a class="modal-close waves-effect btn-flat">Cerrar</a>
        </div>
    </div>
    
    <script type="text/javascript" src="https://dsp.reniec.gob.pe/refirma_invoker/resources/js/client.js"></script>
    <!--RENIEC-->
                            
    <!-- <script type="text/javascript" src="invoker/client.js"></script> -->
    <script type="text/javascript" src="../conexion/global.js"></script>
    <script type="text/javascript">

        var documentName_ = null;

        window.addEventListener('getArguments', function (e) {
            type = e.detail;
            if(type === 'W'){
                ObtieneArgumentosParaFirmaDesdeLaWeb(); // Llama a getArguments al terminar.
            }else if(type === 'L'){
                ObtieneArgumentosParaFirmaDesdeArchivoLocal(); // Llama a getArguments al terminar.
            }
        });

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

        function ObtieneArgumentosParaFirmaDesdeLaWeb(){
            var data = {
                Evento: "ObtenerArgumentosFirmaLote",
                Tipo: "W",
                IdDigitalLote: $("#idDigitalLote").val()
                ,sT: $("#sT").val()           //PARA EL SELLADO DE TIEMPO

                /*console.log('LOG DEL PROGRAMADOR');
                console.log(IdDigitalLote);
                console.log(sT);*/
            };

            getSpinner('Guardando documento');
            $.post("registerDoc/Documentos.php", data)
                .done(function(response){
                    var respuesta = JSON.parse(response);
                    deleteSpinner();
                    dispatchEventClient('sendArguments', respuesta.args);
                });
        }

        function MiFuncionOkWeb(){
            var data = {
                Evento: "RecuperarFirmadoLote", 
                IdDigitalLote: $("#idDigitalLote").val()
                ,sT: $("#sT").val()           //PARA EL SELLADO DE TIEMPO
            };
            $.post("registerDoc/Documentos.php", data)
                .done((r) => {
                    let json = $.parseJSON(r);
                    if(json.ok){     
                                           
                        console.log('Documentos firmados correctamente!');
                        M.toast({html: "Documentos firmados correctamente!"}); 
                        $("#idDigitalLote").val("");
                        $("#sT").val();          //PARA EL SELLADO DE TIEMPO
                        $("#btnDoc").trigger("click");
                        $.each( [$("#btnPrimary"), $("#btnRetroceder"), $("#btnGenerar"), $("#btnFirmar"), $("#btnDoc"), $("#btnDerivar")], function( key, value ) {
                            value.css("display","none");
                        });                       
                        tblBandejaTrabajo.ajax.reload();
                    } else {
                        console.log('Error al firmar los documentos!');
                        deleteSpinner();
                        M.toast({html: "Error al firmar los documentos"});
                    } 
                });
        }

        function MiFuncionCancel(){
            alert("El proceso de firma digital fue cancelado.");
        }
    </script>
    <script>
        var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
        var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;
        var sesionTrabajadorSigcti = <?=$_SESSION['idUsuarioSigcti']??0?>;

        var seleccionados = [];
        var docActual = 0;

        // $('.actionButtons').hide();

        var tblBandejaTrabajo = $('#tblBandejaTrabajo').DataTable({
            responsive: true,
            ajax: 'ajaxtablas/ajaxBTrabajo.php',
            drawCallback: function( settings ) {
                $(".dataTables_scrollBody").attr("data-simplebar", "");
                $('select[name="tblBandejaTrabajo_length"]').formSelect();

                $('.paginate_button:not(.disabled)', this.api().table().container()).on('click', function(){
                    tblBandejaTrabajo.rows().deselect();
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
                        'selectRow': true,
                        'selectCallback': function(){
                            evaluarBotones();
                        }
                    },
                    'createdCell': function (td, cellData, rowData, row, col) {
                        $(td).attr('data-tipo', rowData.tipo);
                        $(td).attr('data-codigo', rowData.codigo);
                        $(td).attr('data-tipodoc', rowData.nFlgTipoDoc);
                        $(td).attr('data-proyectoini', rowData.proyectoIni);
                        
                        if(rowData.corresponde == 1){
                            $(td).addClass('lote');
                        }                            
                    },
                    "width": "3%"
                },
                {
                    'targets': 1,
                    'createdCell': function (td, cellData, rowData, row, col) {
                        if (rowData.contieneDoc == 0) {                                
                            $(td).find("span").hide();
                        } else {
                            $(td).addClass('details-control');
                        }
                    },
                    "width": "2%"
                },  
                {
                    'targets': 2,
                    "width": "8%"
                }, 
                {
                    'targets': 3,
                    "width": "12%"
                }, 
                {
                    'targets': 4,
                    "width": "60%"
                }, 
                {
                    'targets': 5,
                    "width": "15%"
                },              
            ],
            'columns': [                
                {'data': 'rowId', 'className': 'text-left'}     
                ,{
                    'data': null,
                    'render': function (data, type, row, meta) {
                        return `<span><i class="fas fa-chevron-down"></i></span>`    
                    }
                }               
                ,{'data': 'cud'}
                ,{
                    'render': function (data, type, row, meta) {
                        var tipo = 'PROYECTO';
                        var sinFirma = '';
                        if(row.tipo == 'tramite'){
                            tipo = '';
                            
                            if(row.corresponde == 1){
                                sinFirma = `<br/><small><b>Sin Firma</b></small>`;
                            }
                        }                        
                        
                        return `${tipo} ${row.documento} ${sinFirma}`    
                    }
                }
                ,{'data': 'asunto'}
                ,{'data': 'nombreEntidad'}
                ,{'data': 'fechaModificacion'}
                ,{'data': 'distribucion'}
            ],
            'select': {
                'style': 'multi'
            }
        });

        $("#tblBandejaTrabajo thead").on("change", "th.dt-checkboxes-select-all input[type=checkbox]", function(e){
            // e.preventDefault();
            // e.stopPropagation();
            if($(this).prop("checked")){
                $("div.documentosGrupo table input[type=checkbox]").prop("checked",true);
            } else {
                $("div.documentosGrupo table input[type=checkbox]").prop("checked",false);
            }
            evaluarBotones();
        });

        $('#tblBandejaTrabajo tbody').on('click', 'td.details-control span', function (e) {
            // e.stopImmediatePropagation();
            var tr = $(this).closest('tr');
            var row = tblBandejaTrabajo.row(tr);
            var fila = row.data();
            if (row.child.isShown()) {
                $('div.documentosGrupo', row.child()).slideUp(function () {
                    row.child.hide();
                    tr.removeClass('shown');
                });
            }
            else {
                $.ajax({
                    cache: 'false',
                    url: 'registerDoc/Documentos.php',
                    method: 'POST',
                    data: {
                        Evento: 'ListarDocumentosUsuarioCorrespondientes', 
                        Agrupado: fila.agrupado,
                        Tipo: fila.tipo,
                        Codigo: fila.codigo
                    },                                
                    datatype: 'json',
                    success: function (data) {
                        var datos = JSON.parse(data);
                        row.child(documentosGrupo(row,datos.data, fila), 'no-padding').show();
                        tr.addClass('shown');
                        $('div.documentosGrupo', row.child()).slideDown();
                    }
                });                        
            }
        });

        function documentosGrupo(row, data, fila){
            var tblDocumentosHtml =
                `<div class="documentosGrupo">
                    <table id="ListarDocumentosUsuario-${fila.agrupado}" style="width: 100%; margin-bottom: 1rem">
                        <thead>
                            <tr>
                                <th style="width: 13%;"></th>
                                <th style="width: 12%;">Documento</th>
                                <th style="width: 60%;">Asunto</th>
                                <th style="width: 15%;">Última fecha Modificación</th>
                            </tr>
                        </thead>
                    </table>
                </div>`;

            row.child(tblDocumentosHtml).show();

            var tblDocumentos = $('#ListarDocumentosUsuario-' + fila.agrupado).DataTable({
                'info': false,
                'paging': false,
                'serverSide': false,
                'ordering': false,
                'searching': false,
                'responsive': true,
                'data': data,
                'columnDefs': [
                    {
                        'targets': 0,
                        "width": "13%"
                    }, 
                    {
                        'targets': 1,
                        "width": "12%"
                    },
                    {
                        'targets': 2,
                        'createdCell': function (td, cellData, rowData, row, col) {
                            $(td).css("width","60%");
                        },
                        "width": "60%"
                    },
                    {
                        'targets': 3,
                        'createdCell': function (td, cellData, rowData, row, col) {
                            $(td).css("width","15%");
                        },
                        "width": "15%"
                    }
                ],
                'columns': [
                    {
                        'className': 'text-center',
                        'render': function (data, type, row, meta) {
                            return `<label>
                                    <input type="checkbox" class="dt-checkboxes filled-in interno" data-tipo="${row.tipo}" data-codigo="${row.codigo}" data-tipodoc="${row.nFlgTipoDoc}" data-proyectoini="${row.proyectoIni}">
                                    <span></span>
                                </label>`   
                        }
                    },
                    {
                        'className': 'text-left',
                        'render': function (data, type, row, meta) {
                            var tipo = 'Proyecto';
                            var sinFirma = '';
                            if(row.tipo == 'tramite'){
                                tipo = '';
                                sinFirma = `<br/><small><b>Sin Firma</b></small>`;
                            }

                            return `${tipo} ${row.tipoDoc} ${row.cCodificacion == null ? "" : row.cCodificacion} ${sinFirma}`    
                        }
                    },
                    { 'data': 'cAsunto', 'className': 'text-left' },
                    { 'data': 'FecModifica', 'className': 'text-left' }
                ],
                'rowCallback': function(row, data, index) {
                    $(row).find('td:eq(0)').css('width', '13%');
                    $(row).find('td:eq(0)').css('text-align', 'center');
                    $(row).find('td:eq(0)').addClass('lote');
                    $(row).find('td:eq(1)').css('width', '12%');
                },
                'drawCallback': function( settings ) {
                    $('#ListarDocumentosUsuario-' + fila.agrupado + ' thead').remove();
                } 
            });
        }

        $("#tblBandejaTrabajo").on("change", "div.documentosGrupo table tbody td.lote input[type=checkbox]", function(e){
            evaluarBotones();
        });

        var btnPrimary = $("#btnPrimary");
        var btnRetroceder = $("#btnRetroceder");  
        var btnGenerar = $("#btnGenerar");  
        var btnFirmar = $("#btnFirmar"); 
        var btnDoc = $("#btnDoc"); 
        var btnDerivar = $("#btnDerivar");         
        
        var actionButtons = [];
        var supportButtons = [btnPrimary,btnRetroceder];

        tblBandejaTrabajo
            .on( 'select', function ( e, dt, type, indexes ) {
                let count = tblBandejaTrabajo.rows( { selected: true } ).count();
                switch (count) {
                    case 1:
                        let fila = tblBandejaTrabajo.rows( { selected: true } ).data().toArray()[0];
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        if(fila.mov == null){
                            btnRetroceder.css("display","none");
                        }

                        // $('.actionButtons').show();                            
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
                let count = tblBandejaTrabajo.rows( { selected: true } ).count();
                switch (count) {
                    case 0:
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","none");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","none");
                        });

                        // $('.actionButtons').hide();

                        break;

                    case 1:
                        let fila = tblBandejaTrabajo.rows( { selected: true } ).data().toArray()[0];
                        $.each( actionButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        $.each( supportButtons, function( key, value ) {
                            value.css("display","inline-block");
                        });
                        if(fila.mov == null){
                            btnRetroceder.css("display","none");
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

        btnPrimary.on('click', function(e) {
            e.preventDefault();
            let rows_selected = tblBandejaTrabajo.column(0).checkboxes.selected();
            let values = [];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblBandejaTrabajo.rows(rowId).data()[0]);
            });
            let datos = [];
            $.each(values, function (index, filas) {
                let fila = [];
                fila.push(filas.mov);
                fila.push(filas.documento);
                fila.push(filas.cud);
                datos.push(fila);
            });
            let data = new Object();
            data.cudP = values[0].cud;
            data.agrupado = values[0].agrupado;
            if(values[0].mov == null){
                data.flgPendientes = 1;
                $("#dtr").val(window.btoa(JSON.stringify(data)));
                document.getElementById("frmRespuesta").submit();
            }else {
                $.ajax({
                    url: "registerDoc/Documentos.php",
                    method: "POST",
                    data: {
                        Evento: 'ConsultaRespuestaDocumento',
                        movimiento: values[0].mov
                    },
                    datatype: "json",
                    success: function (response) {
                        let respuesta = $.parseJSON(response);
                        data.movimientoP = values[0].mov;
                        data.flgPendientes = respuesta.flgPendientes.trim() == 'no'? 0 : 1;
                        $("#dtr").val(window.btoa(JSON.stringify(data)));
                        document.getElementById("frmRespuesta").submit();
                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al intentar responder el documento!');
                        deleteSpinner();
                        M.toast({html: "Error al intentar responder el documento"});
                    }
                });
            }                       
        });

        $("#btnRetroceder").on("click", function (e) {
            e.preventDefault();
            let rows_selected = tblBandejaTrabajo.column(0).checkboxes.selected();
            let values = [];
            $.each(rows_selected, function (index, rowId) {
                values.push(tblBandejaTrabajo.rows(rowId).data()[0]);
            });
            parametros = {
                iCodAgrupado: values[0].agrupado
            };
            $.ajax({
                cache: false,
                url: "ajax/ajaxRetrocederMovimiento.php",
                method: "POST",
                data: parametros,
                datatype: "json",
                success : function () {
                    $.each( [$("#btnPrimary"), $("#btnRetroceder"), $("#btnGenerar"), $("#btnFirmar"), $("#btnDoc"), $("#btnDerivar")], function( key, value ) {
                        value.css("display","none");
                    });
                    tblBandejaTrabajo.ajax.reload();
                    setTimeout(function(){ window.location = "bandeja-de-trabajo.php"; })
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al retroceder el grupo!');
                    M.toast({html: "Error al retroceder"});
                }
            });
        });

        btnGenerar.on("click", function(e){
            e.preventDefault();
            var resultado = [];

            $.each($("#tblBandejaTrabajo tbody td.lote input[type=checkbox]:checked"), function(i,e){                
                var tipo = '';

                if($(e).hasClass("interno")){
                    if($(e).attr("data-tipo") == "proyecto"){
                        resultado.push({ codigo: $(e).attr("data-codigo")});
                    }               
                } else {
                    if($(e).closest("td").attr("data-tipo") == "proyecto"){
                        resultado.push({ codigo: $(e).closest("td").attr("data-codigo")});
                    }
                }
            });

            if(resultado.length > 0){
                $.confirm({
                    title: '¿Esta seguro de querer generar los documentos?',
                    content: 'Los documentos una vez creados ya no puede ser cambiada la información',
                    buttons: {
                        Si: function () {
                            getSpinner('Cargando...');
                            $.ajax({
                                url: "registerDoc/Documentos.php",
                                method: "POST",
                                data: {
                                    Evento: 'GenerarDocumentoLote',
                                    Codigos: resultado
                                },
                                datatype: "json",
                                success: function (response) {
                                    // let json = $.parseJSON(response);
                                    console.log('Documentos generados correctamente!');
                                    M.toast({html: "Documentos generados correctamente!"});
                                    
                                    tblBandejaTrabajo.ajax.reload(function (x) {
                                        $.each(resultado, (i,j) => {
                                            $("#tblBandejaTrabajo tbody td.lote input[type=checkbox]").closest(`td[data-proyectoini=${j.codigo}]`).find("input[type=checkbox]").prop("checked",true);
                                        })

                                        $("#btnDoc").trigger("click");
                                        $.each( [$("#btnPrimary"), $("#btnRetroceder"), $("#btnGenerar"), $("#btnFirmar"), $("#btnDoc"), $("#btnDerivar")], function( key, value ) {
                                            value.css("display","none");
                                        });
                                    });
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al generar los documentos!');
                                    deleteSpinner();
                                    M.toast({html: "Error al generar los documentos"});
                                }
                            });
                        },
                        No: function () {
                            $.alert('Generación de documento cancelada');
                        }
                    }
                });
            } else {
                $.alert('No hay documentos proyectados para generar!');
            }
        });
        
        btnFirmar.on("click", function(e){
            e.preventDefault();
            var resultado = [];

            $.each($("#tblBandejaTrabajo tbody td.lote input[type=checkbox]:checked"), function(i,e){                
                var tipo = '';
                if($(e).hasClass("interno")){
                    if($(e).attr("data-tipo") == "tramite"){
                        resultado.push({ codigo: $(e).attr("data-codigo")});
                    }               
                } else {
                    if($(e).closest("td").attr("data-tipo") == "tramite"){
                        resultado.push({ codigo: $(e).closest("td").attr("data-codigo")});
                    }
                }
            });

            if(resultado.length > 0){
                $.confirm({
                    title: '¿Esta seguro de querer firmar los documentos?',
                    content: '',
                    buttons: {
                        Si: function () {
                            getSpinner('Cargando...');
                            $.ajax({
                                url: "registerDoc/Documentos.php",
                                method: "POST",
                                data: {
                                    Evento: 'ObtenerArchivoComprimido',
                                    Codigos: resultado
                                },
                                datatype: "json",
                                success: function (response) {
                                    let json = $.parseJSON(response);
                                    if(json.ok){
                                        $("#idDigitalLote").val(json.data);
                                        $("#sT").val(json.sT);    // PARA SELLADO DE TIEMPO
                                        console.log(json.data);
                                        console.log('json.sT');
                                        console.log(json.sT);
                                        initInvoker('W');
                                    } else {
                                        console.log('Error al recuperar el archivo!');
                                        deleteSpinner();
                                        M.toast({html: "Error al recuperar el archivo"});
                                    }                                        
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al recuperar el archivo!');
                                    deleteSpinner();
                                    M.toast({html: "Error al recuperar el archivo"});
                                }
                            });
                        },
                        No: function () {
                            $.alert('Generación de documento cancelada');
                        }
                    }
                });
            } else {
                $.alert('No hay documentos proyectados para generar!');
            }
        });

        btnDoc.on("click", function(e){
            e.preventDefault();
            seleccionados = [];
            docActual = 0;
            totalSeleccionado = 0;
            
            var promise = new Promise((resolve, reject) => {
                var cantidad = 0;
                var total = $("#tblBandejaTrabajo tbody td input[type=checkbox]:checked").length;

                $.each($("#tblBandejaTrabajo tbody td input[type=checkbox]:checked"), function(i,e){ 
                    cantidad++;
                    
                    var vTipo = '';
                    var vCodigo = '';
                    var vTipoDoc = '';
                    var vProyectoInicio = '';

                    if($(e).hasClass("interno")){
                        vTipo = $(e).attr("data-tipo");
                        vCodigo = $(e).attr("data-codigo");
                        vTipoDoc = $(e).attr("data-tipoDoc");
                        vProyectoInicio = $(e).attr("data-proyectoini");
                    } else {
                        vTipo = $(e).closest("td").attr("data-tipo");
                        vCodigo = $(e).closest("td").attr("data-codigo");
                        vTipoDoc = $(e).closest("td").attr("data-tipoDoc");
                        vProyectoInicio = $(e).closest("td").attr("data-proyectoini");
                    }

                    if(vTipoDoc == 1 || vTipoDoc == 2){
                        seleccionados.push({tipo: vTipo, codigo: vCodigo, tipoDoc: vTipoDoc, destino: 0, notificacion: 0});
                        totalSeleccionado++;
                        if(cantidad == total){
                            resolve();
                        }
                    } else {
                        $.ajax({
                            async:false,
                            cache: false,
                            method: "POST",
                            data: {proyecto: vProyectoInicio, tramite: 0, Evento: 'ObtenerDatosDocumentosDestinatarios'},
                            url: "registerDoc/Documentos.php",
                            datatype: 'json',
                            success: function (x) {
                                respuesta = $.parseJSON(x);

                                var promise2 = new Promise((resolve2, reject2) => {
                                    $.each(respuesta, function(i,e){
                                        totalSeleccionado++;
                                        seleccionados.push({tipo: vTipo, codigo: vCodigo, tipoDoc: vTipoDoc, destino: e.iCodRemitente, notificacion: 0}); 
                                        if(e.idTipoEnvio == 98){
                                            totalSeleccionado++;
                                            seleccionados.push({tipo: vTipo, codigo: vCodigo, tipoDoc: vTipoDoc, destino: e.iCodRemitente, notificacion: (e.idTramiteNotificacion == null ? 1 : e.idTramiteNotificacion)}); 
                                        }                                        
                                    });
                                    resolve2();
                                });

                                promise2.then(() => {
                                    if(cantidad == total){
                                        resolve();
                                    }
                                });
                            }
                        });
                    }          
                });
            });

            promise.then(() => {
                mostrarDocumento(false,false);
                let instance = M.Modal.getInstance($("#modalDoc"));
                instance.open();
            });            
        });

        function obtenerDatosRespuesta(movimiento,datos) {
            $.ajax({
                url: "registerDoc/Documentos.php",
                method: "POST",
                data: {
                    Evento: 'RespuestaDocumento',
                    movimiento: movimiento
                },
                datatype: "json",
                success: function () {
                    $("#iCodMov").val(movimiento);
                    $("#trabajarAgrupado").val(respuesta.agrupado);
                    $("#datos").val(JSON.stringify(datos));
                    //document.getElementById("frmRespuesta").submit();
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al responder el documento!');
                    deleteSpinner();
                    M.toast({html: "Error al responder el documento"});
                }
            });
        }

        function evaluarBotones() {
            btnGenerar.css("display","none");
            btnFirmar.css("display","none");
            btnDoc.css("display","none");    
            btnDerivar.css("display","none");        

            var cPro = 0;
            var cTra = 0;
            var cOtro = 0;

            if($("#tblBandejaTrabajo tbody td input[type=checkbox]:checked").length > 0){
                btnDoc.css("display","inline-block");
                btnDerivar.css("display","inline-block");
            }

            if($("#tblBandejaTrabajo tbody td input[type=checkbox]:checked").length > 1){
                btnPrimary.css("display","none");
                btnRetroceder.css("display","none");            
            }

            $.each($("#tblBandejaTrabajo tbody td input[type=checkbox]:checked"), function(i,e){
                if($(e).closest("td").hasClass("lote")){
                    var tipo = '';

                    if($(e).hasClass("interno")){
                        tipo = $(e).attr("data-tipo")
                    } else {
                        tipo = $(e).closest("td").attr("data-tipo");
                    }
                    
                    if(tipo == "proyecto"){
                        cPro ++;
                    } else if (tipo == "tramite"){
                        cTra ++;
                    }
                } else {
                    cOtro++;
                }                
            });

            if((cPro == 0 && cTra == 0) || (cPro != 0 && cTra != 0)){
                btnGenerar.css("display","none");
                btnFirmar.css("display","none");
            } else if(cPro != 0 && cOtro == 0){                    
                btnGenerar.css("display","inline-block");
                btnFirmar.css("display","none");
            } else if(cTra != 0 && cOtro == 0){                    
                btnGenerar.css("display","none");
                btnFirmar.css("display","inline-block");
            }
        }

        function mostrarDocumento(anterior,siguiente){
            $("#btnAnterior").removeAttr("disabled");
            $("#btnSiguiente").removeAttr("disabled");

            if(anterior){
                docActual--;
            }

            if(siguiente){
                docActual++;
            }

            if(docActual == 0){
                $("#btnAnterior").attr('disabled', 'disabled');
            }

            if(docActual + 1 == seleccionados.length){
                $("#btnSiguiente").attr('disabled', 'disabled');
            }

            $("#textActual").text(docActual + 1);
            $("#textTotal").text(seleccionados.length);
            
            let seleccionado = seleccionados[docActual];
            
            if(seleccionado.tipo == 'proyecto'){
                listadoPrevisualizacion = [];               
                
                $.ajax({
                    url: 'registerDoc/Documentos.php',
                    method : 'POST',
                    datatype: 'json',
                    data: {
                        Evento : "ObtenerDatosDocumentos",
                        codigo : seleccionado.codigo,
                        tipo : seleccionado.tipo,
                        agrupado : ''
                    },
                    success: function (response) {
                        let datos = $.parseJSON(response);
                        datos.destinatario = seleccionado.destino;
                        datos.id = seleccionado.codigo;

                        let ruta = 'previsualizacion-pdf.php';
                        if(seleccionado.notificacion > 0){
                            ruta = 'previsualizacion-notificacion-pdf.php';
                        }

                        $.ajax({
                            url: ruta,
                            method: "POST",
                            dataType : "text",
                            data: datos,
                            success: function (respuesta) {
                                let datos = respuesta;
                                let ifr = $("#modalDoc iframe");
                                ifr.attr('src','data:application/pdf;base64,' + datos);
                            },
                            error: function (e) {
                                console.log(e);
                                console.log('Error al obtener el documento!');
                                M.toast({html: "Error al obtener el documento!"});
                            }
                        });
                    }
                });
            }

            if(seleccionado.tipo == 'tramite'){
                var datatramite = {};
                datatramite.codigo = seleccionado.codigo;
                datatramite.destino = seleccionado.destino;

                if(seleccionado.notificacion > 0){
                    datatramite.codigo = seleccionado.notificacion;
                    datatramite.destino = 0;
                }

                $.ajax({
                    url: "ajax/obtenerDoc.php",
                    method: "POST",
                    data: datatramite,
                    datatype: "json",
                    success: function (response) {
                        let json = $.parseJSON(response);
                        if (json.length !== 0){
                            console.log('¡Documento obtenido!');
                            $('#modalDoc div.modal-content').html('');
                            $('#modalDoc div.modal-content').html('<iframe src="' + getPreIframe() + json['url'] + '" frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>');
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
            }
        }

        $("#btnAnterior").on("click", function(e){
            mostrarDocumento(true,false);
        });

        $("#btnSiguiente").on("click", function(e){
            mostrarDocumento(false,true);
        });

        btnDerivar.on("click", function(e){
            e.preventDefault();
            $("#btnDerivar").addClass('disabled');
            
            if($("#tblBandejaTrabajo tbody td input[type=checkbox]:checked").length > 0){
                $.confirm({
                    title: '¿Esta seguro que desea derivar los documentos?',
                    content: '',
                    buttons: {
                        Si: function () {
                            getSpinner('Cargando...');

                            var promise = new Promise((resolve, reject) => {
                                var countInicio = 0;
                                var totalDoc = $("#tblBandejaTrabajo tbody td input[type=checkbox]:checked").length;

                                $.each($("#tblBandejaTrabajo tbody td input[type=checkbox]:checked"), function(i,e){
                                    var vTipo = '';
                                    var vCodigo = '';
                                    
                                    if($(e).hasClass("interno")){
                                        vTipo = $(e).attr("data-tipo");
                                        vCodigo = $(e).attr("data-codigo")
                                    } else {
                                        vTipo = $(e).closest("td").attr("data-tipo");
                                        vCodigo = $(e).closest("td").attr("data-codigo");
                                    }

                                    $.post("registerDoc/Documentos.php", {Evento: "ObtenerDatosDocumentos", tipo: vTipo, codigo: vCodigo})
                                        .done((x) => {
                                            x = JSON.parse(x);
                                            $.post('registerDoc/Documentos.php', { Evento: "ListarDocumentosUsuario", Agrupado: x.cAgrupado})
                                                .done((y) => {
                                                    var promise2 = new Promise((resolve2, reject2) => {
                                                        derivar(JSON.parse(y).data,x.cAgrupado);
                                                        resolve2();
                                                    });

                                                    promise2.then((x) => {
                                                        countInicio++;
                                                        if(countInicio == totalDoc){
                                                            resolve();
                                                        }
                                                    });                                                
                                                });
                                        });
                                });
                            });

                            promise.then(() => {
                                console.log('termino de enviar todo');
                                console.log('Documentos derivados correctamente!');
                                M.toast({html: "Documentos derivados correctamente!"});
                                $.each( [$("#btnPrimary"), $("#btnRetroceder"), $("#btnGenerar"), $("#btnFirmar"), $("#btnDoc"), $("#btnDerivar")], function( key, value ) {
                                    value.css("display","none");
                                });
                                $("#btnDerivar").removeClass("disabled");
                                tblBandejaTrabajo.ajax.reload();
                            })                                                        
                        },
                        No: function () {
                            $.alert('Derivación cancelada');
                        }
                    }
                });
            } else {
                $.alert('No hay documentos seleccionados!');
                $("#btnDerivar").removeClass("disabled");
            }

        });

        function derivar(datagrid, cagrupado){
            let datos = datagrid[0];            
            if (datos.IdSigctiInscripcion != 0){
                var codigoPerfil = 0; // cualquier otro perfil
                if (sesionPerfil == 4){
                    codigoPerfil = 1 // especialista
                }
                if (sesionPerfil == 3){
                    if (sesionOficina == 359){
                        codigoPerfil = 2 // jefe de DOC
                    } else {
                        codigoPerfil = 3 // Cualquier otro jefe
                    }                    
                }
                $.ajax({
                    url: RutaSIGTIDtramite + "ApiD-Tramite/Api/Tramite/TRA_GET_0009?TipEnvio="+datos.nFlgTipoDoc+"&CodInscripcion="+datos.IdSigctiInscripcion+"&CodTupa="+datos.IdTupa+"&DesPerfil="+codigoPerfil,
                    method: "GET",
                    async: false,
                    datatype: "application/json",
                    success: function (response) {
                        if (response.Success == true){
                            derivarDocumentos(datagrid, cagrupado);
                            // console.log(resultado);
                        } else {
                            $.alert(response.MessageResult);
                        }
                    }
                });
            } else {
                derivarDocumentos(datagrid, cagrupado);
                // console.log(resultado);
            }
        }

        function derivarDocumentos (datagrid, cagrupado) {
            var promise = new Promise((resolve, reject) => {
                var filasEnviar = [];
                var paraJefeProyecto = [];
                var paraJefeVisado = [];
                var salir = 0;
                var tabla = datagrid;

                $.each(tabla, function (i, filas) {
                    if(salir == 1){
                        return false;
                    }
                    if (sesionPerfil == 18 || sesionPerfil == 19 || sesionPerfil == 20) {
                        if (filas.tipo == 'proyecto'){
                            paraJefeProyecto.push(filas);
                        } else {
                            if(filas.firma == 0){
                                paraJefeVisado.push(filas)
                            } else {
                                if(filas.nFlgEnvio == 0){
                                    filasEnviar.push(filas);
                                }
                            }
                        }
                    } else {
                        if (filas.iCodOficinaFirmante == sesionOficina && filas.iCodTrabajadorFirmante == sesionTrabajador) {
                            if (filas.tipo == 'proyecto'){
                                $.alert('No se puede derivar, proyecto pendiente');
                                salir += 1;
                            } else {
                                if(filas.firma == 0){
                                    $.alert('No se puede derivar, tiene documento pendiente de firma');
                                    salir += 1;
                                } 
                                else {
                                    if(filas.nFlgEnvio == 0){
                                        filasEnviar.push(filas);
                                    }
                                }
                            }
                        } else {
                            if (filas.tipo == 'proyecto'){
                                paraJefeProyecto.push(filas);
                            } else {
                                if(filas.firma == 0){
                                    paraJefeVisado.push(filas);
                                }
                            }
                        }
                    }
                });

                if (salir == 0) {                                 
                    getSpinner();
                    if (filasEnviar.length !== 0) {
                        let paraJefe = false;
                        var initFilasEnviar = 0;

                        $.each(filasEnviar, function (key, fil) {
                            initFilasEnviar++;

                            let modelo = new Object();
                            modelo.Evento = "DerivarDestino";
                            modelo.codigo = fil.codigo;
                            modelo.tipoDoc = fil.nFlgTipoDoc;
                            modelo.idTramiteNotificacion = fil.idTramiteNotificacion;
                            if (fil.nFlgTipoDoc == 2 && fil.cCodTipoDoc == 12){
                                paraJefe = true;
                            }
                            $.ajax({
                                cache: false,
                                async: false,
                                method: "POST",
                                url: "registerDoc/Documentos.php",
                                data: modelo,
                                datatype: "json",
                                success: function (response) {
                                    var response = $.parseJSON(response);
                                    if(!response.success){
                                        console.log(`Error al derivar: ${response.mensaje}!`);
                                        M.toast({html: `Error al derivar: ${response.mensaje}!`});
                                    }

                                    if(initFilasEnviar == filasEnviar.length){
                                        resolve();
                                    }
                                    // console.log('Derivado correctamente!');
                                    // M.toast({html: "'Derivado correctamente!"});
                                },
                                error: function (e) {
                                    reject(e);
                                    // console.log(e);
                                    // console.log('Error al derivar!');
                                    // M.toast({html: "Error al derivar"});
                                }
                            });
                        });                    
                    } else if (paraJefeVisado.length !== 0) {
                        let modelo = new Object();
                        modelo.Evento = "DerivarJefeVisado";
                        modelo.codigo = paraJefeVisado[0].codigo;
                        $.ajax({
                            cache: false,
                            async: false,
                            method: "POST",
                            url: "registerDoc/Documentos.php",
                            data: modelo,
                            datatype: "json",
                            success: function (response) {
                                resolve();
                                // console.log('Derivado correctamente!');
                                // M.toast({html: "'Derivado correctamente!"});
                            },
                            error: function (e) {
                                reject(e);
                                // console.log(e);
                                // console.log('Error al derivar!');
                                // M.toast({html: "Error al derivar"});
                            }
                        });
                    } else if (paraJefeProyecto.length !== 0) {
                        let modelo = new Object();
                        modelo.Evento = "DerivarJefeProyecto";
                        modelo.codigos = paraJefeProyecto;
                        $.ajax({
                            cache: false,
                            async: false,
                            method: "POST",
                            url: "registerDoc/Documentos.php",
                            data: modelo,
                            datatype: "json",
                            success: function (response) {
                                resolve();
                                // console.log('Derivado correctamente!');
                                // M.toast({html: "'Derivado correctamente!"});
                            },
                            error: function (e) {
                                reject(e);
                                // console.log(e);
                                // console.log('Error al derivar!');
                                // M.toast({html: "Error al derivar"});
                            }
                        });
                    } else {
                        let modelo = new Object();
                        modelo.Evento = "DerivarJefeInmediato";
                        modelo.cAgrupado = cagrupado;
                        $.ajax({
                            cache: false,
                            async: false,
                            method: "POST",
                            url: "registerDoc/Documentos.php",
                            data: modelo,
                            datatype: "json",
                            success: function (response) {
                                resolve();
                                // console.log('Derivado correctamente!');
                                // M.toast({html: "'Derivado correctamente!"});
                            },
                            error: function (e) {
                                reject(e);
                                // console.log(e);
                                // console.log('Error al derivar!');
                                // M.toast({html: "Error al derivar"});
                            }
                        });
                    }    
                }
            });
            
            promise.then(() => {
                console.log('Documento derivado correctamente!');
                // M.toast({html: "'Documentos derivados correctamente!"});
                // return false;
            }, (e) => {
                // console.log(e);
                console.log('Error al derivar el documento!');
                // M.toast({html: "Error al derivar los documentos"});
                // return false;
            });
        }
        
    </script>
    </html>
    <?php
}else{
    header("Location: ../index-b.php?alter=5");
}
?>