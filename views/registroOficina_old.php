<?php
date_default_timezone_set('America/Lima');
session_start();
include_once("../conexion/conexion.php");
include_once("../conexion/parametros.php");

$pageTitle = "Registro de Documento";
$activeItem = "registroOficina.php";
$navExtended = true;

$nNumAno    = date("Y");
if($_SESSION['CODIGO_TRABAJADOR']!=""){
    $url = RUTA_SIGTI_SERVICIOS."/ApiPide/token";
    // $data = array(
    //     "UserName" =>  "8/user-dtramite",
    //     "Password" =>   "123456",
    //     "grant_type" => "password"
    // );

    $client = curl_init();
    curl_setopt($client, CURLOPT_URL, $url);
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($client, CURLOPT_POST, true);
    curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = json_decode(curl_exec($client));
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <link href="includes/component-dropzone.css" rel="stylesheet">
    </head>
    <body class="theme-default has-fixed-sidenav">
    <?php include("includes/menu.php");?>
    <a name="area"></a>

    <!--Main layout-->
    <main>
        <input id="token" type="hidden" value="<?php echo $response->token_type . ' ' . $response->access_token; ?>">

        <div class="navbar-fixed actionButtons">
            <nav>
                <div class="nav-wrapper">
                    <ul id="nav-mobile" class="">
                        <?php
                        if (!($_SESSION['iCodPerfilLogin'] == '19') OR ($_SESSION['flgDelegacion'] == '1')){
                            ?>
                            <li><a id="btnValidacionAgregar" class="btn btn-primary"><i class="fas fa-plus fa-fw left"></i><span>Agregar</span></a></li>
                            <?php
                        }
                        ?>
                        <li><a id="btnDerivar" class="btn btn-link"><i class="fas fa-arrow-right fa-fw left"></i><span>Derivar</span></a></li>
                        <li><a id="btnGuardarCambios" style="display: none" class="btn btn-link"><i class="fas fa-save fa-fw left"></i><span>Guardar</span></a></li>

                        <?php
                        if ($_SESSION['iCodPerfilLogin'] == '3' || $_SESSION['iCodPerfilLogin'] == '20' || $_SESSION['iCodPerfilLogin'] == '19'){
                            ?>
                            <li><a id="btnDevolver" class="btn btn-link"><i class="fas fa-hand-point-left fa-fw left"></i><span>Devolver</span></a></li>
                            <?php
                        }
                        ?>
                        <li><a id="btnArchivar" class="btn btn-link"><i class="fas fa-archive left"></i><span>Archivar</span></a></li>
                        <li><a id="btnRetroceder" class="btn btn-link"><i class="fas fa-undo left"></i><span>Retroceder</span></a></li>
                    </ul>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container">
            <form name="frmRegistro" id="frmRegistro" method="POST" action="previsualizacion-pdf.php"  target="_blank" enctype="multipart/form-data">
                <?php
                if(isset($_GET['iCodMov'])){
                    $array = json_decode ($_GET['datos'],true);
                    foreach ($array as $valor) {
                        if ($valor[0] == $_GET['iCodMov']){
                            $cudRespt = $valor[2];
                        }
                    }
                    $movimientos = [];
                    foreach ($array as $valor) {
                        array_push($movimientos,$valor[0]);
                    }

                    $documentos = '';
                    foreach ($array as $clave  => $value) {
                        if ($clave == 0 ){
                            $documentos .= $value[1].' | '.$value[2];
                        } else {
                            $documentos .= ', '.$value[1].' | '.$value[2];
                        }
                    }
                    $iCodMovTramiteProveniente = $_GET['iCodMov'];
                    $sqlDocRefRespuesta = 'SELECT A.iCodTramite
                                            FROM Tra_M_Tramite_Movimientos AS A 
                                            INNER JOIN Tra_M_Tramite AS B ON A.iCodTramite = B.iCodTramite 
                                            WHERE A.iCodMovimiento ='.$iCodMovTramiteProveniente;
                    $rsDocRefRespuesta   = sqlsrv_query($cnx,$sqlDocRefRespuesta);
                    $RsDocRefRespuesta   = sqlsrv_fetch_array($rsDocRefRespuesta);

                    $tramitesRspt = [];
                    foreach ($movimientos as $valor) {
                        $sqlTramitesRespuesta = 'SELECT iCodTramite AS iCodTramiteRef FROM Tra_M_Tramite_Movimientos WITH(NOLOCK) WHERE iCodMovimiento ='.$valor;
                        $rsTramiteRespuesta   = sqlsrv_query($cnx,$sqlTramitesRespuesta);
                        $RsTramiteRespuesta   = sqlsrv_fetch_array($rsTramiteRespuesta, SQLSRV_FETCH_ASSOC);
                        array_push($tramitesRspt,$RsTramiteRespuesta);
                    }
                    ?>
                    <div class="row">
                        <div class="col s9">
                            <div class="card card-info">
                                <div class="card-content">
                                    <input type="hidden" value="<?=$cudRespt?>"  name="nCud" id="nCud">
                                    <input type="hidden" value="<?=json_encode($movimientos)?>" name="iCodMovRespondidos" id="iCodMovRespondidos">
                                    <input type="hidden" value="<?=$_GET['iCodMov']?>" name="iCodMov">
                                    <input type="hidden" value="<?=$RsDocRefRespuesta['iCodTramite']?>" name="iCodTramite">
                                    <input type="hidden" value="<?=$iCodMovTramiteProveniente?>" name="iCodMovTramite">
                                    Respondiendo <strong><?=$documentos?></strong>, con expediente <strong><?=$cudRespt?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div id="SelecionProyectos" class="row card">
                    <div class="col s12 m12 input-field">
                        <select name="cDocumentosEnTramite" id="cDocumentosEnTramite" class="FormPropertReg form-control">
                        </select>
                        <label for="cDocumentosEnTramite">Documentos en proceso</label>
                    </div>
                </div>
                <div id="TablaDocumentosAcumulados" class="row">
                    <div class="col s12">
                        <ul class="collection with-header">
                            <li class="collection-header"><h6>Documentos agregados</h6></li>
                            <li id="item-1">
                                <table id="TblDocumentos" class="bordered hoverable highlight striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Tipo Doc</th>
                                        <th>N° de Doc</th>
                                        <th>CUD</th>
                                        <th>Asunto</th>
                                        <th>Instrucción Específica</th>
                                        <th>Fecha del Documento</th>
                                        <th>Responsable</th>
                                        <th>Distribución</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                </table>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 m9">
                        <div class="card hoverable">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Datos del documento</legend>
                                    <div class="row">
                                        <div class="col s12 m3 input-field">
                                            <select name="cCodTipoTra" id="cCodTipoTra" class="FormPropertReg form-control">
                                                <option value="2">Interno</option>
                                                <option value="3">Externo</option>
                                            </select>
                                            <label for="cCodTipoTra">Tipo de Trámite</label>
                                        </div>
                                        <div class="col s12 m3 input-field">
                                            <select name="cCodTipoDoc" id="cCodTipoDoc" class="FormPropertReg form-control">
                                                <option value="">Seleccione</option>
                                                <?php
                                                $sqlTipo = "SELECT * FROM Tra_M_Tipo_Documento   WHERE nFlgInterno = 1 AND cCodTipoDoc != 45  ORDER BY cDescTipoDoc ASC";
                                                $rsTipo = sqlsrv_query($cnx,$sqlTipo);
                                                while ($RsTipo = sqlsrv_fetch_array($rsTipo)){
                                                    echo "<option value='".trim($RsTipo["cCodTipoDoc"])."' >".trim($RsTipo["cDescTipoDoc"])."</option>";
                                                }
                                                sqlsrv_free_stmt($rsTipo);
                                                ?>
                                            </select>
                                            <label for="cCodTipoDoc">Tipo de Documento</label>
                                        </div>
                                        <div class="col s12 m3 input-field">
                                            <input placeholder="dd-mm-aaaa" value="" type="text" id="fFecPlazo" name="fFecPlazo" class="FormPropertReg form-control datepicker">
                                            <label for="fFecPlazo">Fecha de Plazo</label>
                                            <span class="helper-text" data-error="wrong" data-success="right">Opcional</span>
                                        </div>
                                        <div class="col s12 m3 input-field">
                                            <input id="reloj" value="&nbsp;" type="text" name="reloj" class="FormPropertReg form-control" onfocus="window.document.frmRegistro.reloj.blur()">
                                            <label for="reloj">Fecha de Registro</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <textarea name="cAsunto" id="cAsunto" class="FormPropertReg materialize-textarea"></textarea>
                                            <label for="cAsunto">Asunto</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s4 m4 input-field">
                                            <div class="switch">
                                                <label>
                                                    Nuevo tramite
                                                    <input type="checkbox" id="flgSigo" name="flgSigo" value="1">
                                                    <span class="lever"></span>
                                                    Proviene del Sigo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12 m12 input-field">
                                            <textarea name="editorOficina" id="editorOficina"></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset style="padding-bottom: 2em" id="destinatario">
                                    <legend>Datos del destinatario(s) interno</legend>
                                    <div class="row">
                                        <div class="col s4 m4 input-field">
                                            <div class="switch">
                                                <label>
                                                    Oficinas
                                                    <input type="checkbox" id="flgDelegar" name="flgDelegar" value="1">
                                                    <span class="lever"></span>
                                                    Especialistas
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m12">
                                            <div id="areaOficina">
                                                <div class="row" id="paraEspecialistas" style="display: none">
                                                    <div class="input-field col s12 m6">
                                                        <select id="nomOficinaE">
                                                        </select>
                                                        <label for="nomOficinaE">Oficina</label>
                                                        <input type="hidden" value="0" id="CodOficinaE">
                                                    </div>
                                                    <div class="col s12 m6 input-field">
                                                        <select name="responsableE" id="responsableE">
                                                        </select>
                                                        <label for="responsableE">Responsable</label>
                                                    </div>
                                                </div>
                                                <div class="row" id="paraOficinas">
                                                    <div class="col s12 m6 input-field">
                                                        <select name="iCodOficinaO" id="iCodOficinaO">
                                                        <option value="">Seleccione Oficina</option>
                                                        <?php
                                                        $sqlOficina = "SELECT iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS oficina FROM Tra_M_Oficinas  WHERE iFlgEstado != 0 AND flgEliminado = 0 ORDER BY cNomOficina ASC";
                                                        $rsOficina = sqlsrv_query($cnx, $sqlOficina);
                                                        while ($RsOficina = sqlsrv_fetch_array($rsOficina)) {
                                                            echo "<option value=" . $RsOficina["iCodOficina"] . ">".$RsOficina["oficina"]."</option>";
                                                        }
                                                        sqlsrv_free_stmt($rsOficina);
                                                        ?>
                                                        </select>
                                                        <label for="iCodOficinaO">Oficina</label>
                                                    </div>
                                                    <div class="input-field input-disabled col s12 m6">
                                                        <input type="hidden" value="" id="codResponsableiO">
                                                        <input  class="disabled" id="nomResponsableO" value="&nbsp;" type="text">
                                                        <label class="active" for="nomResponsableO">Responsable</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s6 m2 input-field">
                                                        <select name="cCopia" id="cCopia">
                                                            <option value="0" selected>No</option>
                                                            <option value="1">Si</option>
                                                        </select>
                                                        <label for="cCopia">Copia</label>
                                                    </div>
                                                    <div class="col s6"><br>
                                                        <input name="button" type="button" class="btn btn-secondary" value="Confirmar" id="btnAgregarDestinatario">
                                                    </div>
                                                </div>
                                            </div>
                                            <table id="TblDestinatarios" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Oficina</th>
                                                    <th>Trabajador</th>
                                                    <td>Copia</td>
                                                    <th>Opci&oacute;n</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset style="display: none" id="destinoExterno">
                                    <legend>Destinatario externo</legend>
                                    <div id="sugerenciasDestinatario" style="display: none"></div>
                                    <div class="row" style="display: none" id="nombreDestinoEntidadMREcol">
                                        <div class="col m12 input-field">
                                            <select id="nombreDestinoEntidadMRE" class="js-data-example-ajax browser-default" name="nombreDestinoEntidadMRE"></select>
                                            <label for="nombreDestinoEntidadMRE">Nombre de la entidad</label>
                                        </div>
                                    </div>
                                    <div class="row" id="nombreDestinoExternocol">
                                        <div class="col m9 input-field">
                                            <select id="nombreDestinoExterno" class="js-data-example-ajax browser-default" name="nombreDestinoExterno" data-nivel="0"></select>
                                            <label for="nombreDestinoExterno">Nombre de la entidad</label>
                                        </div>
                                        <div class="col m3 input-field">
                                            <input type="text" class="input-disabled" name="nroDocDestinoExterno" id="nroDocDestinoExterno" >
                                            <label class="active">N° Documento</label>
                                        </div>
                                        <div class="col s12">
                                            <div class="row" id="dependenciasDestinoExterno"></div>
                                        </div>
                                        <!-- <div class="col m5 input-field">
                                            <input type="text" class="input-disabled" name="direccionDestinoExterno" id="direccionDestinoExterno" >
                                            <label class="active">Dirección de la entidad</label>
                                            <button style="display: none" id="btnEditarRemitente" class="input-field__icon btn btn-link"><i class="fas fa-edit"></i></button>
                                        </div> -->
                                        <!-- <div class="col m6 input-field">
                                            <select id="nombreDestinoExternodependencia"  name="nombreDestinoExternodependencia">
                                                <option value="">Seleccione</option>
                                                <option value="">UTI</option>
                                            </select>
                                            <label for="nombreDestinoExternodependencia">Dependencia de la entidad</label>
                                        </div> -->
                                        <div class="col m12 input-field">
                                            <select id="direccionDestinoExterno"  name="direccionDestinoExterno"></select>
                                            <label for="direccionDestinoExterno">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="row" id="opcionalFields">
                                        <div class="col m2 input-field">
                                            <input type="text" name="prefijoNombre" id="prefijoNombre">
                                            <label for="prefijoNombre">Pre-fijo</label>
                                        </div>
                                        <div class="col m4 input-field">
                                            <input type="text" name="responsableDestinoExterno" id="responsableDestinoExterno">
                                            <label for="responsableDestinoExterno">Nombre del responsable</label>
                                        </div>
                                        <div class="col m6 input-field">
                                            <input type="text" name="cargoResponsableDestinoExterno" id="cargoResponsableDestinoExterno">
                                            <label for="cargoResponsableDestinoExterno">Cargo del responsable</label>
                                        </div>
                                        <div class="col m4 input-field">
                                            <div class="switch">
                                                <label>
                                                    Mostrar Dirección
                                                    <input type="checkbox" id="flgMostrarDireccion" name="flgMostrarDireccion" value="1">
                                                    <span class="lever"></span>
                                                    Ocultar Dirección
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col m2">
                                            <input name="button" type="button" class="btn btn-secondary" value="Confirmar" id="btnAgregarDestinoExterno">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px">
                                        <div class="col m12">
                                            <table id="TblDestinosExternos" class="bordered hoverable highlight striped" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Entidad</th>
                                                    <th>N° Documento</th>
                                                    <th>Dirección</th>
                                                    <th>Pre-fijo</th>
                                                    <td>Nombre Responsable</td>
                                                    <th>Cargo Responsable</th>
                                                    <th>Dirección visible</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m3">
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Referencias</legend>
                                    <div class="row">
                                        <div class="col m12">
                                            <select id="cReferencia" class="js-example-basic-multiple-limit browser-default" name="cReferencia[]" multiple="multiple"></select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="card hoverable transparent">
                            <div class="card-body">
                                <fieldset>
                                    <legend>Adjuntos anexos del grupo</legend>
                                    <div class="row">
                                        <div class="file-field input-field col s12">
                                            <div id="dropzoneAgrupado" class="dropzone"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12" style="padding-bottom: 0.75rem">
                                            <button type="button" class="btn btn-secondary" id="btnSubirDocsAgrupado">Subir</button>
                                        </div>
                                    </div>
                                    <div id="anexosDoc" style="display: block">
                                        <p style="padding: 0 15px">Seleccione los anexos:</p>
                                        <div class="row" style="padding: 0 15px">
                                            <div class="col s12">
                                                <table id="TblAnexos" class="bordered hoverable highlight striped" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Antece-<br>dente</th>
                                                        <th>Se adjunta</th>
                                                        <th>Archivo</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4">
                                                                <p style="font-size: 85%; text-align: left">
                                                                    <strong>Antecedente</strong>: permite incluir el anexo como antecedente del expediente<br>
                                                                    <strong>Se adjunta</strong>: permite visualizar el nombre del documento en el PDF
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modalResponsableFirma" class="modal" style="overflow: visible">
                    <div class="modal-header">
                        <h4>Datos responsable de firma</h4>
                    </div>
                    <div class="modal-content">
                        <fieldset>
                            <div class="row">
                                <div class="col m6 input-field">
                                    <select name="iCodOficinaFirma" id="iCodOficinaFirma">
                                        <!--<option value="">Firma Propia</option>-->
                                        <?php
                                        //ESTO SE REEMPLAZARA POR UN AJAX, ES MOMENTANEO
                                        /*$rsOfinasArbolSup = sqlsrv_query($cnx,"SELECT iCodPadre, iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS oficina FROM Tra_M_Oficinas WHere iCodOficina = ".$_SESSION['iCodOficinaLogin']);
                                        $RsOfinasArbolSup = sqlsrv_fetch_array($rsOfinasArbolSup);
                                        if($_SESSION['iCodPerfilLogin'] !== '3'){
                                            echo "<option value='".$RsOfinasArbolSup['iCodOficina']."'>".TRIM($RsOfinasArbolSup['oficina'])."</option>";
                                        }
                                        while($RsOfinasArbolSup['iCodPadre'] !== null) {
                                            $rsOfinasArbolSup = sqlsrv_query($cnx, "SELECT iCodPadre, iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS oficina FROM Tra_M_Oficinas WHere iCodOficina = " . $RsOfinasArbolSup['iCodPadre']);
                                            $RsOfinasArbolSup = sqlsrv_fetch_array($rsOfinasArbolSup);
                                            echo "<option value='" . $RsOfinasArbolSup['iCodOficina'] . "'>" . TRIM($RsOfinasArbolSup['oficina']) . "</option>";
                                        }*/
                                        ?>
                                    </select>
                                    <label for="iCodOficinaFirma">Oficina Responsable Firma</label>
                                </div>
                                <div class="col m6 input-field">
                                    <input type="text" value="&nbsp;" id="nomResponsableFirmar" disabled>
                                    <label class="active" for="nomResponsableFirmar">Trabajador Responsable Firma</label>
                                    <input type="hidden" value="" name="iCodTrabajadorFirma" id="iCodTrabajadorFirma">
                                    <input type="hidden" value="" name="iCodPerfilFirma" id="iCodPerfilFirma">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <a class="waves-effect waves-green btn-flat modal-close" >Cancelar</a>
                        <a class="waves-effect waves-green btn-flat" id="btnAgregarProyecto" >Grabar</a>
                    </div>
                </div>

                <input type="hidden" name="cTipo" value="" id="cTipo">
                <input type="hidden" name="cCodigo" value="" id="cCodigo">
                <input type="hidden" name="agrupadoTemp" value="0" id="agrupadoTemp">

            </form>
    </main>

    <!-- <div id="modalRegRemitente" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Registro Destinatario</h4>
        </div>
        <div class="modal-content">
            <form name="formRegRemitente" id="formRegRemitente" >
                <div class="row">
                    <div class="col m6 input-field">
                        <select type="text"  id="idTipoRemitente" name="idTipoRemitente">
                        </select>
                        <label for="idTipoRemitente">Tipo remitente</label>
                    </div>
                    <div class="col m6 input-field">
                        <input type="text" id="nNumDocumento" name="nNumDocumento" class="disabled" value="0">
                        <label for="nNumDocumento">Número de documento</label>
                        <span class="helper-text nNumDocumento"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col m12 input-field">
                        <input type="text" id="nRemitente" name="nRemitente">
                        <label for="nRemitente">Nombre del destinatario</label>
                    </div>
                </div>
                <div class="row pJuridica" style="display: none">
                    <div class="col m2 input-field">
                        <input type="text"  id="cSiglaRemitente" name="cSiglaRemitente">
                        <label for="cSiglaRemitente">Siglas</label>
                    </div>
                    <div class="col m5 input-field">
                        <input type="text" id="nResponsableRemitente" name="nResponsableRemitente">
                        <label for="nResponsableRemitente">Responsable</label>
                    </div>
                    <div class="col m5 input-field">
                        <input type="text"  id="nResponsableCargoRemitente" name="nResponsableCargoRemitente">
                        <label for="nResponsableCargoRemitente">Cargo</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 input-field">
                        <input type="text" id="direccion" name="direccion">
                        <label for="direccion">Dirección del destinatario</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col m4 input-field">
                        <select type="text"  id="cDepartamento" name="cDepartamento">
                            <option value="">Seleccione</option>
                            <?php
                                // $rsDepa = sqlsrv_query($cnx, "SELECT cCodDepartamento, cNomDepartamento FROM Tra_U_Departamento ORDER BY cNomDepartamento ASC");
                                // while($RsDepa = sqlsrv_fetch_array($rsDepa)){
                                    ?>
                                    <option value="<?//=RTRIM($RsDepa['cCodDepartamento'])?>"><?//=RTRIM($RsDepa['cNomDepartamento'])?></option>
                                <?php //} ?>
                        </select>
                        <label for="cDepartamento">Departamento</label>
                    </div>
                    <div class="col m4 input-field">
                        <select type="text"  id="cProvincia" name="cProvincia">
                        </select>
                        <label for="cProvincia">Provincia</label>
                    </div>
                    <div class="col m4 input-field">
                        <select type="text"  id="cDistrito" name="cDistrito">
                        </select>
                        <label for="cDistrito">Distrito</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnRegistrarRemi" >Registrar</a>
            <a class="waves-effect waves-green btn-flat" id="btnActualizarRemi" >Actualizar</a>
            <a class="waves-effect waves-green btn-flat modal-close" >Cancelar</a>
        </div>
    </div> -->

    <input type="hidden" id="argumentos" value="" />
    <div id="addComponent"></div>
    <input type="hidden" id="nombreDocument" value="">
    <input type="hidden" id="signedDocument" value="">
    <input type="hidden" id="tipo_f" value="">
    <input type="hidden" id="idtra" value="">
    <input type="hidden" id="nroVisto" value="">
    <input type="hidden" id="datosDoc" value="">

    <div id="modalDoc" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Documento</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>

        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat" id="btnCerrarDocFirma">Cerrar</a>
        </div>
    </div>

    <div id="modalDocFirmado" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Documento</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">
            <a class="waves-effect waves-green btn-flat" id="btnCerrarDocFirmado">Cerrar</a>
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

    <div id="modalPrevisualizacion" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Previsualización documento</h4>
        </div>
        <div class="modal-content" style="text-align: center; overflow: hidden;">
            <iframe frameborder="0" scrolling="auto" style="width:100%!important; height:100%!important"></iframe>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        </div>
    </div>

    <div id="modalRegresar" class="modal modal-fixed-footer modal-fixed-header">
        <div class="modal-header">
            <h4>Motivo de regreso</h4>
        </div>
        <div class="modal-content">
            <form id="formMotRegresar" name="formMotRegresar">
                <div class="row">
                    <div class="col s12 input-field">
                        <input type="text" id="motivoRegreso" name="motivoRegreso">
                        <label for="motivoRegreso">Motivo del regreso</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a id="btnMotivoRegresar" class="waves-effect btn-flat">Regresar</a>
            <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>

    <div id="modalDevolver" class="modal">
        <div class="modal-header">
            <h4>Devolución de documento</h4>
        </div>
        <div class="modal-content">
            Use esta opción para devolver el documento, ya sea para VISTO o para ser EDITADO.
            <form name="formEnvioDevolver" class="row">
                <div class="input-field col s12">
                    <select id="codOficinaDevolver">
                        <?php
                        $sqlOfiVisado ="SELECT iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS nomOficina FROM Tra_M_Oficinas WHERE flgEliminado = 0 AND iCodOficina = ".$_SESSION['iCodOficinaLogin']."
                              UNION ALL 
                              SELECT iCodOficina, TRIM(cSiglaOficina)+' | '+TRIM(cNomOficina) AS nomOficina  FROM Tra_M_Oficinas WHERE flgEliminado = 0 AND iCodPadre = ".$_SESSION['iCodOficinaLogin'];
                        $rsOfiVisado = sqlsrv_query($cnx,$sqlOfiVisado);
                        while ($RsOfiVisado = sqlsrv_fetch_array($rsOfiVisado)){
                            echo "<option value='".$RsOfiVisado['iCodOficina']."'>".$RsOfiVisado['nomOficina']."</option>";
                        }
                        ?>
                    </select>
                    <label for="codOficinaDevolver">Oficina</label>
                </div>
                <div class="input-field col s12">
                    <select id="codEspecialistaDevolver">
                        <?php
                        $sqlTra ="SELECT pu.iCodTrabajador, cNombresTrabajador, cApellidosTrabajador , cDescPerfil
                                  FROM Tra_M_Perfil_Ususario AS pu, Tra_M_Trabajadores AS tb, Tra_M_Perfil AS p
                                  WHERE pu.iCodOficina = ".$_SESSION['iCodOficinaLogin']." AND pu.iCodPerfil in (4) AND pu.iCodTrabajador = tb.iCodTrabajador AND p.iCodPerfil = pu.iCodPerfil";
                        $rsTra = sqlsrv_query($cnx,$sqlTra);
                        while ($RsTra = sqlsrv_fetch_array($rsTra)){
                            echo "<option value='".$RsTra['iCodTrabajador']."'>".rtrim($RsTra['cApellidosTrabajador']).", ".rtrim($RsTra['cNombresTrabajador'])." ( ".rtrim($RsTra['cDescPerfil'])." )</option>";
                        }
                        ?>
                    </select>
                    <label for="codEspecialistaDevolver">Especialista</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="obsDevolver" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="obsDevolver">Instrucción Específica</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnvioDevolver" class="waves-effect btn-flat">Enviar</a>
        </div>
    </div>

    <div id="modalArchivar" class="modal">
        <div class="modal-header">
            <h4>Archivar documentos</h4>
        </div>
        <div class="modal-content">
            <form name="formArchivar" class="row">
                <div class="col s12 input-field">
                    <textarea id="motArchivar" class="materialize-textarea FormPropertReg"></textarea>
                    <label for="motArchivar">Motivo de archivo</label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <a class="modal-close waves-effect btn-flat">Cancelar</a>
            <a id="btnEnviarArchivar" class="waves-effect btn-flat">Archivar</a>
        </div>
    </div>

    <div id="modalDespacho" class="modal modal-fixed-header modal-fixed-footer">
    <div class="modal-header">
        <h4>Datos del despacho</h4>
    </div>
    <div class="modal-content">
        <form name="formDatosDespacho" id="formDatosDespacho" >
            <input type="hidden" name="IdProyectoDespacho" id="IdProyectoDespacho" value="0">
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="col m10 input-field input-disabled">
                            <input type="text" id="NombreDespacho">
                            <label for="NombreDespacho">Nombre Destinatario</label>
                        </div>

                        <div class="col m2 input-field input-disabled">
                            <input type="text"  id="RucDespacho" name="RucDespacho">
                            <label for="RucDespacho">Ruc</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 input-field">
                            <select id="IdTipoEnvio" name="IdTipoEnvio">
                            </select>
                            <label for="IdTipoEnvio">Tipo Envío</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" id="ObservacionesDespacho" name="ObservacionesDespacho">
                            <label for="ObservacionesDespacho">Observaciones del despacho</label>
                        </div>
                    </div>
                    <div class="row" id="datosEnvioFisico">
                        <div class="col s12 input-field">
                            <input type="text" id="DireccionDespacho" name="DireccionDespacho">
                            <label for="DireccionDespacho">Dirección</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select id="DepartamentoDespacho" name="DepartamentoDespacho">
                                <option value="">Seleccione</option>
                                <?php
                                $rsDepa = sqlsrv_query($cnx, "SELECT cCodDepartamento, cNomDepartamento FROM Tra_U_Departamento ORDER BY cNomDepartamento ASC");
                                while($RsDepa = sqlsrv_fetch_array($rsDepa)){
                                    ?>
                                    <option value="<?=RTRIM($RsDepa['cCodDepartamento'])?>"><?=RTRIM($RsDepa['cNomDepartamento'])?></option>
                                <?php } ?>
                            </select>
                            <label for="DepartamentoDespacho">Departamento</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select id="ProvinciaDespacho" name="ProvinciaDespacho">
                            </select>
                            <label for="ProvinciaDespacho">Provincia</label>
                        </div>
                        <div class="col s12 m4 input-field">
                            <select id="DistritoDespacho" name="DistritoDespacho">
                            </select>
                            <label for="DistritoDespacho">Distrito</label>
                        </div>
                    </div>
                    <div class="row" id="datosEnvioInteroperabilidad" style="display: none;">
                        <div class="col s12 input-field">
                            <input type="text" id="UnidadOrganicaDstIOT" name="UnidadOrganicaDstIOT">
                            <label for="UnidadOrganicaDstIOT">Unidad Organica Destino</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" id="PersonaDstIOT" name="PersonaDstIOT">
                            <label for="PersonaDstIOT">Persona Destino</label>
                        </div>
                        <div class="col s12 m6 input-field">
                            <input type="text" id="CargoPersonaDstIOT" name="CargoPersonaDstIOT">
                            <label for="CargoPersonaDstIOT">Cargo Destino</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
        <a id="btnGuardarDatosDespacho" class="waves-effect waves-green btn-flat">Guardar</a>
    </div>
    </div>

    <?php include("includes/userinfo.php");?>
    <?php include("includes/pie.php");?>

    <!--COMPONENTES PARA LA FIRMA Y VISTOS-->
    <script type="text/javascript" src="invoker/client.js"></script>
    <script type="text/javascript" src="../conexion/global.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            mueveReloj();
        };
        //<![CDATA[
        var documentName_ = null;
        //
        window.addEventListener('getArguments', function (e) {
            type = e.detail;
            if(type === 'W'){
                ObtieneArgumentosParaFirmaDesdeLaWeb(); // Llama a getArguments al terminar.
            }else if(type === 'L'){
                ObtieneArgumentosParaFirmaDesdeArchivoLocal(); // Llama a getArguments al terminar.
            }
        });
        function getArguments(){
            arg = document.getElementById("argumentos").value;
            dispatchEventClient('sendArguments', arg);
        }

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

        //::LÓGICA DEL PROGRAMADOR::
        function ObtieneArgumentosParaFirmaDesdeLaWeb(){
            //let u = document.getElementById("signedDocument").value.trim();
            let documentURL = document.getElementById("signedDocument").value.trim();
            let documentName = document.getElementById("nombreDocument").value.trim();
            //let documentName_ = u.trim();
            console.log(documentURL);
            let tipFirma = $("#tipo_f").val();
            let nroVisto = $("#nroVisto").val();

            //Obtiene argumentos
            $.post("invoker/postArguments.php", {
                type : "W",
                tipFirma: tipFirma,
                documentURL: documentURL,
                documentName: documentName,
                //documentName : documentName_,
                nroVisto: nroVisto
            }, function(data, status) {
                document.getElementById("argumentos").value = data;
                getArguments();
            });
        }

        function ObtieneArgumentosParaFirmaDesdeArchivoLocal(){
            u = document.getElementById("signedDocument").value;
            //$.get("controller/getArguments.php", {}, function(data, status) {
            documentName_ = u;
            //Obtiene argumentos

            $.post(urlp+"invoker/postArguments.php", {
                type : "L",
                tipFirma: 'f',
                documentName : documentName_
            }, function(data, status) {
                //alert("Data: " + data + "\nStatus: " + status);
                document.getElementById("argumentos").value = data;
                getArguments();
            });
        }

        function MiFuncionOkWeb(){
            let documentURL = document.getElementById("signedDocument").value.trim();
            let documentName = document.getElementById("nombreDocument").value.trim();
        
            let nroVisto = $("#nroVisto").val();

            let tipFirma = $("#tipo_f").val();
            let idtra = $("#idtra").val();
            let datosDoc = $("#datosDoc").val();
            // if (tipFirma == 'f'){
            //     var reemplazo = 'docFirmados';
            // } else {
            //     var reemplazo = 'docVisados';
            // }
            // let original = document.getElementById("signedDocument").value;
            // let nuevaUrl = original.replace(original.split('/')[2],reemplazo).replace('-PF.pdf', '.pdf');
            getSpinner('Guardando Documento');
            $.ajax({
                url: "registerDoc/Documentos.php",
                method: "POST",
                data: {
                    Evento: "ActualizaEstadosSellosDocumentos",
                    tipo: tipFirma,
                    codigo: idtra
                },
                datatype: "json",
                success: function (response) {
                    $.post("invoker/save.php",{
                            // url: nuevaUrl.split('srv-files/')[1].trim().replace(nuevaUrl.split('/').pop().trim(),''),
                            // fileNameOld : original.split('/').pop().trim(),
                            // fileNameNew : nuevaUrl.split('/').pop().trim(),
                            documentName: documentName,
                            idtra: idtra,
                            tipo: tipFirma
                        },
                        function (data,status){
                            $.post("enviarDocAsistentes.php", {
                                    codigoEnviar: idtra,
                                    url: nuevaUrl,
                                    datosDoc: datosDoc
                                },
                                function (data,status) {
                                    tblDocumentos.clear().draw();
                                    tblDocumentos.ajax.reload();
                                    $('#modalDocFirmado div.modal-content iframe').attr('src',"http://"+nuevaUrl);
                                    let elem = document.querySelector('#modalDocFirmado');
                                    let instance = M.Modal.init(elem, {dismissible:false});
                                    instance.open();
                                }
                            );
                        }
                    );
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al actualizar estados de firma!');
                    M.toast({html: "Error al firmar"});
                }
            });
        }

        function MiFuncionOkLocal(){
            alert("Documento firmado desde la PC correctamente.");
            document.getElementById("signedDocument").href="controller/getFile.php?documentName=" + documentName_;
        }

        function MiFuncionCancel(){
            //let documentURL = document.getElementById("signedDocument").value.trim();
            let documentName = document.getElementById("nombreDocument").value.trim();
            $.post("invoker/canceled.php",{
                documentName: documentName,
                },
                function (data,status){
                    alert("El proceso de firma digital fue cancelado.");
                    document.getElementById("signedDocument").href="#";
                }
            );            
        }
    </script>

    <script>
        var sesionTrabajador = <?=$_SESSION['CODIGO_TRABAJADOR']?>;
        var sesionOficina = <?=$_SESSION['iCodOficinaLogin']?>;
        var sesionPerfil = <?=$_SESSION['iCodPerfilLogin']?>;
        var sesionDelegado = <?=$_SESSION['flgDelegacion']?>;

        CKEDITOR.replace( 'editorOficina', {
            language: 'es'
        });

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.pasteFromWordRemoveFontStyles = true;

        // $('#cDepartamento').on('change',function (e) {
        //     e.preventDefault();
        //     $.ajax({
        //         cache: false,
        //         url: "ajax/ajaxProvincias.php",
        //         method: "POST",
        //         data: {codDepa : $('#cDepartamento').val()},
        //         datatype: "json",
        //         success: function (data) {
        //             data = JSON.parse(data);
        //             $('#cProvincia').empty().append('<option value="">Seleccione</option>');
        //             $.each( data.info, function( key, value ) {
        //                 $('#cProvincia').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
        //             });
        //             var elempro = document.getElementById('cProvincia');
        //             M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
        //             $('#cDistrito').empty();
        //             var elempro = document.getElementById('cDistrito');
        //             M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
        //         }
        //     });
        // });

        // $('#cProvincia').on('change',function (e) {
        //     e.preventDefault();
        //     $.ajax({
        //         cache: false,
        //         url: "ajax/ajaxDistritos.php",
        //         method: "POST",
        //         data: {codDepa : $('#cDepartamento').val(), codPro: $('#cProvincia').val()},
        //         datatype: "json",
        //         success: function (data) {
        //             data = JSON.parse(data);
        //             $('#cDistrito').empty().append('<option value="">Seleccione</option>');
        //             $.each( data.info, function( key, value ) {
        //                 $('#cDistrito').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
        //             });
        //             var elemdis = document.getElementById('cDistrito');
        //             M.FormSelect.init(elemdis, {dropdownOptions: {container: document.body}});
        //             //$('#cDistrito').formSelect();
        //         }
        //     });
        // });

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

        $('#cReferencia').select2({
            placeholder: 'Seleccione y busque',
            maximumSelectionLength: 10,
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al referencia.</p>";
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
                url: 'ajax/ajaxReferencias.php',
                dataType: 'json',
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        // AL AGREGAR O QUITAR REFERENCIAS SE OBTINEN SUS ANEXOS Y  DOCUEMNTO FIRMADO
        $('#cReferencia').on('select2:select', function (e) {
            let ultimo = $('#cReferencia').find(':selected:last').val();
            if (typeof ultimo !== "undefined") {
                listarAnexosReferencia(ultimo,'iCodTramite');
            }
        });

        // $('#nombreDestinoExterno').select2({
        //     placeholder: 'Seleccione y busque',
        //     minimumInputLength: 3,
        //     "language": {
        //         "noResults": function(){
        //             return "<p>No se encontró al destinatario.</p>";
        //         },
        //         "searching": function() {

        //             return "Buscando..";
        //         },
        //         "inputTooShort": function() {

        //             return "Ingrese más de 3 letras ...";
        //         }
        //     },
        //     escapeMarkup: function (markup) {
        //         return markup;
        //     },
        //     ajax: {
        //         url: 'ajax/ajaxRemitentes.php',
        //         dataType: 'json',
        //         delay: 100,
        //         processResults: function (data) {
        //             return {
        //                 results: data
        //             };
        //         },
        //         cache: true
        //     }
        // });

        $('#nombreDestinoExterno').select2({
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al destinatario.</p>";
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


        $('#nombreDestinoEntidadMRE').select2({
            placeholder: 'Seleccione y busque',
            minimumInputLength: 3,
            "language": {
                "noResults": function(){
                    return "<p>No se encontró al destinatario.";
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
                url: 'ajax/ajaxEntidadMRE.php',
                dataType: 'json',
                delay: 100,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        // OBTENER DIRECCION DE LA BASE DE DATOS
        // $('#nombreDestinoExterno').on('select2:select', function (e) {
        //     let valor = $('#nombreDestinoExterno').val();
        //     $.ajax({
        //         cache: false,
        //         url: "ajax/ajaxDatosRemitente.php",
        //         method: "POST",
        //         data: {iCodRemitente: valor},
        //         datatype: "json",
        //         success: function (data) {
        //             data = JSON.parse(data);
        //             let direccion = data.cDireccion;
        //             let ubigeo = '';
        //             if (data.cNomDepartamento !== null){
        //                 ubigeo = data.cNomDepartamento+', '+data.cNomProvincia+', '+data.cNomDistrito;
        //             };
        //             let direccionCompleta = direccion + ' ' + ubigeo;
        //             let nroDocDestinoExterno = '';
        //             if (data.idTipoRemitente == 60){
        //                 nroDocDestinoExterno = data.nNumDocumento;
        //             } else {
        //                 nroDocDestinoExterno = data.cRuc;
        //             };
        //             $('input[name="nroDocDestinoExterno"]').val(nroDocDestinoExterno).next().addClass('active');
        //             $('input[name="direccionDestinoExterno"]').val(direccionCompleta).next().addClass('active');
        //             $('input[name="responsableDestinoExterno"]').val(data.cRepresentante).next().addClass('active');
        //             $('input[name="cargoResponsableDestinoExterno"]').val(data.cCargo).next().addClass('active');
        //             $('input[name="codigoMRE"]').val(data.CodMRE).next().addClass('active');
        //         },
        //         error: function (e) {
        //             console.log(e);
        //             console.log('Error al obtener los datos!');
        //             M.toast({html: "Error al obtener los datos!"});
        //         }
        //     });
        //     if(valor !== null) {
        //         $("#btnEditarRemitente").css("display", "block");
        //     } else {
        //         $("#btnEditarRemitente").css("display", "none");
        //     }
        // });

        function ObtenerDatosEntidad(id,callfunct) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Entidad.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    callfunct(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ActualizarDatos(datos) {
            $("#nroDocDestinoExterno").val(datos.NumeroDocumento).next().addClass('active');
            $("#responsableDestinoExterno").val(datos.ResponsableEntidad).next().addClass('active');
            $("#cargoResponsableDestinoExterno").val(datos.CargoResponsableEntidad).next().addClass('active');
        }

        function ObtenerDatosSede(id) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idSede": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    AgregarSede(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ObtenerDatosSedeDespacho(id) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerDatos", "idSede": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    LlenarDatosDespacho(data);
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function ObtenerSedesEntidad(id,callfunct) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerSedesEntidad", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    for(var i of data){
                        callfunct(i.IdSede);
                    }
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        function AgregarSede(datos) {
            var id = datos.IdSede;
            var ubigeo = '';
            var text = '';

            if (datos.IdDepartamento != '15'){
                ubigeo += datos.nomDepartamento + ', '
            }
            if (!(datos.IdDepartamento == '15' && datos.IdProvincia == '01')){
                ubigeo += datos.nomProvincia + ', '
            }
            ubigeo += datos.nomDistrito;

            var text = datos.Direccion + ' | '+  datos.nomPais + ' | ' + ubigeo;
        
            $("#direccionDestinoExterno").append('<option value="'+id+'">'+text+'</option>').formSelect();
        }   


        function CrearSelectDependencia(nivel){
            var nivelNuevo = parseInt(nivel) + 1;
            var html = '<div class="col m12 input-field">'+
                            '<select id="dependenciaEntidad'+String(nivelNuevo)+'"  name="dependenciaEntidad'+String(nivelNuevo)+'" data-tipo="dependencia" data-nivel="'+String(nivelNuevo)+'"></select>'+
                            '<label for="dependenciaEntidad'+String(nivelNuevo)+'">Dependencia</label>'+
                        '</div>';
            $("#dependenciasDestinoExterno").append(html);
            return "dependenciaEntidad"+String(nivelNuevo)
        }

        function AgregarOpcionesSelect(selector,datos,selected=0){
            let destino = $(selector);   
            destino.empty().append('<option value="">Seleccione...</option>');
            if (datos.length != 0){                             
                $.each(datos, function( key, value ) {
                    destino.append('<option value="'+value.id+'" '+((value.id == selected) ? 'selected' : '')+'>'+value.text+'</option>');
                });                
            }     
            destino.formSelect();       
        }

        function ListarEntidadesHijas(selectorPadre,idEntidadPadre,selected = 0) {
            $.ajax({
                cache: false,
                url: "mantenimiento/Entidad.php",
                method: "POST",
                data: {"Evento": "ListarEntidadesHijas","IdEntidadPadre" : idEntidadPadre},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);                    
                    if (data.length != 0){
                        var selector = CrearSelectDependencia(selectorPadre.attr("data-nivel"))
                        AgregarOpcionesSelect("#"+selector,data); 
                    }                                       
                }
            });
        }

        function ObtenerSedesDependencia(id,callfunct) {
            $.ajax({
                cache: false,
                async: false,
                url: "mantenimiento/Sede.php",
                method: "POST",
                data: {"Evento": "ObternerSedesDependencia", "idEntidad": id},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    for(var i of data){
                        callfunct(i.IdSede);
                    }
                },
                error: function (e) {
                    M.toast({html: "Error al obtener los datos!"});
                }
            });
        }

        $('#nombreDestinoExterno').on('select2:select', function (e) {
            let valor = $('#nombreDestinoExterno').val();
            ObtenerDatosEntidad(valor,ActualizarDatos);
            $("#direccionDestinoExterno").empty().append('<option value="">Seleccione...</option>').formSelect();
            ObtenerSedesEntidad(valor,ObtenerDatosSede);
            $("#dependenciasDestinoExterno").empty();
            ListarEntidadesHijas($(this),valor);                
        });

        $("#dependenciasDestinoExterno").on("change", "select", function (e) {
            let valor = $(this).val();
            $("#direccionDestinoExterno").empty().append('<option value="">Seleccione...</option>').formSelect();
            $(this).closest("div.col.input-field").nextAll().remove();
            if (valor != ''){
                ObtenerDatosEntidad(valor,ActualizarDatos);                
                ObtenerSedesDependencia(valor,ObtenerDatosSede);                
                ListarEntidadesHijas($(this),valor);
            }                       
        });

        function mueveReloj(){
            momentoActual = new Date();
            anho = momentoActual.getFullYear();
            mes = (momentoActual.getMonth()) + 1;
            dia = momentoActual.getDate();
            hora = momentoActual.getHours();
            minuto = momentoActual.getMinutes();
            segundo = momentoActual.getSeconds();
            if((mes>=0)&&(mes<=9)){ mes="0"+mes; }
            if((dia>=0)&&(dia<=9)){ dia="0"+dia; }
            if((hora>=0)&&(hora<=9)){ hora="0"+hora; }
            if((minuto>=0)&&(minuto<=9)){ minuto="0"+minuto; }
            if ((segundo>=0)&&(segundo<=9)){ segundo="0"+segundo; }
            horaImprimible = dia + "-" + mes + "-" + anho + " " + hora + ":" + minuto + ":" + segundo;
            document.frmRegistro.reloj.value=horaImprimible;
            setTimeout("mueveReloj()",1000)
        };

        function LlenarDatosDespacho(datos) {
            var direccion = datos.Direccion == null ? '' : datos.Direccion.trim();
            var idDepartamento = datos.Direccion == null ? 0 : datos.IdDepartamento.trim();
            var idProvincia = datos.Direccion == null ? 0 : datos.IdProvincia.trim();
            var idDistrito = datos.Direccion == null ? 0 : datos.Direccion.trim();

       
            $('#formDatosDespacho #DireccionDespacho').val(direccion).next().addClass('active');        

            $('#DepartamentoDespacho option[value="'+idDepartamento+'"]').prop('selected',true);
            var elemdep = document.getElementById('DepartamentoDespacho');
            M.FormSelect.init(elemdep, {dropdownOptions:{container:document.body}});
            $("#DepartamentoDespacho").trigger("change");

            $('#ProvinciaDespacho option[value="'+idProvincia+'"]').prop('selected',true);
            var elempro = document.getElementById('ProvinciaDespacho');
            M.FormSelect.init(elempro, {dropdownOptions:{container:document.body}});
            $("#ProvinciaDespacho").trigger("change");

            $('#DistritoDespacho option[value="'+idDistrito+'"]').prop('selected',true);
            var elemdis = document.getElementById('DistritoDespacho');
            M.FormSelect.init(elemdis, {dropdownOptions:{container:document.body}});
        }

        // $("#btnRegistrarRemi").on('click', function () {
        //     var elems = document.querySelector('#modalRegRemitente');
        //     var instance = M.Modal.getInstance(elems);

        //     if($("#idTipoRemitente").val() === '0') {
        //         $.alert("Falta seleccionar tipo de remitente");
        //         return false;
        //         /*}else if($("#nNumDocumento").val() == null || $("#nNumDocumento").val() == '') {
        //             $.alert("Falta ingresar número de documento");
        //             return false;*/
        //     } else if ($("#nRemitente").val().trim() == '') {
        //         $.alert("Falta nombre de la entidad");
        //         return false;
        //     } else if ($("#direccion").val().trim() == '') {
        //         $.alert("Falta dirección de la entidad");
        //         return false;
        //     } else if ($("#cDepartamento").val().trim() == '') {
        //         $.alert("Falta departamento de la entidad");
        //         return false;
        //     } else if ($("#cProvincia").val().trim() == '') {
        //         $.alert("Falta provincia de la entidad");
        //         return false;
        //     } else if ($("#cDistrito").val().trim() == '') {
        //         $.alert("Falta distrito de la entidad");
        //         return false;
        //     }else{
        //         var datosRemitentes = {};

        //         $.each($('#formRegRemitente').serializeArray(), function() {
        //             datosRemitentes[this.name] = this.value;
        //         });

        //         $.ajax({
        //             cache: false,
        //             url: 'registrarRemitente.php',
        //             method: 'POST',
        //             data: {datos: datosRemitentes, nuevo: 1},
        //             datatype: 'text',
        //             success: function (response) {
        //                 instance.close();
        //                 M.toast({html: response});
        //             }
        //         });
        //     }
        // });

        // $("#btnActualizarRemi").on('click', function (e) {
        //     e.preventDefault();
        //     let elems = document.querySelector('#modalRegRemitente');
        //     let instance = M.Modal.getInstance(elems);
        //     if ($("#nRemitente").val().trim() == '') {
        //         $.alert("Falta nombre de la entidad");
        //         return false;
        //     } else if ($("#direccion").val().trim() == '') {
        //         $.alert("Falta dirección de la entidad");
        //         return false;
        //     } else if ($("#cDepartamento").val().trim() == '') {
        //         $.alert("Falta departamento de la entidad");
        //         return false;
        //     } else if ($("#cProvincia").val().trim() == '') {
        //         $.alert("Falta provincia de la entidad");
        //         return false;
        //     } else if ($("#cDistrito").val().trim() == '') {
        //         $.alert("Falta distrito de la entidad");
        //         return false;
        //     } else {
        //         let iCodRemitente = $('#nombreDestinoExterno').val();
        //         var datosRemitentes = {};
        //         $.each($('#formRegRemitente').serializeArray(), function() {
        //             datosRemitentes[this.name] = this.value;
        //         });
        //         $.ajax({
        //             cache: false,
        //             url: 'registrarRemitente.php',
        //             method: 'POST',
        //             data: {datos: datosRemitentes, nuevo: 0, iCodRemitente: iCodRemitente},
        //             datatype: 'text',
        //             success: function (response) {
        //                 $.ajax({
        //                     cache: false,
        //                     url: "ajax/ajaxDatosRemitente.php",
        //                     method: "POST",
        //                     data: {iCodRemitente: iCodRemitente},
        //                     datatype: "json",
        //                     success: function (dataAct) {
        //                         dataAct = JSON.parse(dataAct);
        //                         let direccionAct = dataAct.cDireccion;
        //                         if (dataAct.cNomDepartamento !== null){
        //                             direccionAct += ' '+dataAct.cNomDepartamento+', '+dataAct.cNomProvincia+', '+dataAct.cNomDistrito;
        //                         }
        //                         $('input[name="nroDocDestinoExterno"]').val(dataAct.nNumDocumento).next().addClass('active');
        //                         $('input[name="direccionDestinoExterno"]').val(direccionAct).next().addClass('active');
        //                         $('input[name="responsableDestinoExterno"]').val(dataAct.cRepresentante).next().addClass('active');
        //                         $('input[name="cargoResponsableDestinoExterno"]').val(dataAct.cCargo).next().addClass('active');
        //                         $('input[name="codigoMRE"]').val(dataAct.CodMRE).next().addClass('active');
        //                     },
        //                     error: function (e) {
        //                         console.log(e);
        //                         console.log('Error al actualizar los datos!');
        //                         M.toast({html: "Error al actualizar los datos!"});
        //                     }
        //                 });
        //                 instance.close();
        //                 M.toast({html: response});
        //             }
        //         });
        //     }
        // });

        // $("#btnEditarRemitente").on('click', function (e) {
        //     e.preventDefault();
        //     var elems = document.querySelector('#modalRegRemitente');
        //     var instance = M.Modal.getInstance(elems);
        //     var valor = $('#nombreDestinoExterno').val();

        //     $("#btnActualizarRemi").css("display", "inline-block");
        //     $("#btnRegistrarRemi").css("display", "none");
        //     $("#modalRegRemitente h4").html("Editar Destinatario");

        //     $.ajax({
        //         cache: false,
        //         url: 'ajax/ajaxDatosRemitente.php',
        //         method: 'POST',
        //         data: {iCodRemitente: valor},
        //         datatype: 'text',
        //         success: function (response) {
        //             console.log(response);
        //             response = JSON.parse(response);

        //             var idTipoRemitente = response.idTipoRemitente;
        //             var nNumDocumento = response.nNumDocumento;

        //             if(idTipoRemitente !== null) {
        //                 //$('select[name="idTipoRemitente"]').attr('disabled', 'disabled');
        //                 $('select[name="idTipoRemitente"] option[value="'+idTipoRemitente+'"]').prop('selected', true);
        //                 var elTipoPersona = document.getElementById('idTipoRemitente');
        //                 M.FormSelect.init(elTipoPersona, {dropdownOptions:{container:document.body}});

        //                 if(idTipoRemitente == "62") {
        //                     $(".pJuridica").show();
        //                 }else{
        //                     $(".pJuridica").hide();
        //                 }
        //             }else{
        //                 //$('select[name="idTipoRemitente"]').removeAttr('disabled');
        //                 $('select[name="idTipoRemitente"] option[value="0"]').prop('selected', true);
        //                 var elTipoPersona = document.getElementById('idTipoRemitente');
        //                 M.FormSelect.init(elTipoPersona, {dropdownOptions:{container:document.body}});
        //             }

        //             if(nNumDocumento !== null) {
        //                 $('form input[name="nNumDocumento"]').attr('disabled', 'disabled');
        //                 $('form input[name="nNumDocumento"]').val(nNumDocumento).next().addClass('active');
        //             }else{
        //                 $('form input[name="nNumDocumento"]').removeAttr('disabled');
        //                 $('form input[name="nNumDocumento"]').val('');
        //                 $('form input[name="nNumDocumento"]').val(nNumDocumento).next().removeClass('active');
        //             }

        //             $('form input[name="nRemitente"]').val(response.cNombre).next().addClass('active');
        //             $('form input[name="cSiglaRemitente"]').val(response.cSiglaRemitente).next().addClass('active');
        //             $('form input[name="nResponsableRemitente"]').val(response.cRepresentante).next().addClass('active');
        //             $('form input[name="nResponsableCargoRemitente"]').val(response.cCargo).next().addClass('active');
        //             $('form input[name="direccion"]').val(response.cDireccion).next().addClass('active');
        //             $('form input[name="codigoMRE"]').val(response.CodMRE).next().addClass('active');

        //             if(response.cDepartamento !== '' && response.cDepartamento !== null){
        //                 $('select[name="cDepartamento"] option[value="'+response.cDepartamento+'"]').prop('selected',true);
        //                 var elemdep = document.getElementById('cDepartamento');
        //                 M.FormSelect.init(elemdep, {dropdownOptions:{container:document.body}});

        //                 if (response.cProvincia !== '' && response.cProvincia !== null) {
        //                     $.ajax({
        //                         cache: false,
        //                         url: "ajax/ajaxProvincias.php",
        //                         method: "POST",
        //                         data: {codDepa : response.cDepartamento},
        //                         datatype: "json",
        //                         success: function (dataP) {
        //                             dataP = JSON.parse(dataP);
        //                             if(dataP.tiene = 1) {
        //                                 $('#cProvincia').empty().append('<option value="">Seleccione</option>');
        //                                 $.each(dataP.info, function (key, value) {
        //                                     $('#cProvincia').append('<option value="' + value.codigo + '">' + value.nombre + '</option>');
        //                                 });
        //                                 $('#cProvincia option[value=' + response.cProvincia + ']').prop('selected', true);
        //                                 var elempro = document.getElementById('cProvincia');
        //                                 M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});

        //                                 if (response.cDistrito !== '' && response.cDistrito !== null) {
        //                                     $.ajax({
        //                                         cache: false,
        //                                         url: "ajax/ajaxDistritos.php",
        //                                         method: "POST",
        //                                         data: {codDepa :response.cDepartamento, codPro: response.cProvincia},
        //                                         datatype: "json",
        //                                         success: function (dataD) {
        //                                             dataD = JSON.parse(dataD);
        //                                             if(dataD.tiene = 1) {
        //                                                 $('#cDistrito').empty().append('<option value="">Seleccione</option>');
        //                                                 $.each(dataD.info, function (key, value) {
        //                                                     $('#cDistrito').append('<option value="' + value.codigo + '">' + value.nombre + '</option>');
        //                                                 });
        //                                                 $('#cDistrito option[value=' + response.cDistrito + ']').prop('selected', true);
        //                                                 var elemdis = document.getElementById('cDistrito');
        //                                                 M.FormSelect.init(elemdis, {dropdownOptions: {container: document.body}});
        //                                             }
        //                                         }
        //                                     });
        //                                 } else {
        //                                     $("#cProvincia").trigger("change");
        //                                 }
        //                             }
        //                         }
        //                     });
        //                 } else {
        //                     $("#cDepartamento").trigger("change");
        //                 }
        //             }
        //             instance.open();
        //         }
        //     });
        // });

        function validarFormulario(){
            if($("#cCodTipoDoc").val().trim() === ''){
                $.alert("Falta seleccionar tipo de documento!");
                return false;
            }
            if($("#cAsunto").val() === ''){
                $.alert("Falta asunto!");
                return false;
            }
            CKEDITOR.instances.editorOficina.updateElement();
            if($("#editorOficina").val() === ''){
                $.alert('Falta el cuerpo del documento!');
                return false;
            }

            if($('#cCodTipoTra').val() === '2'){
                var filastabla = tblDestinatarios.data().length;
            } else {
                var filastabla = tblDestinosExternos.data().length;
            }
            if (filastabla === 0){
                $.alert('Falta seleccionar al menos un destinatario!');
                return false;
            }

            return true;
        }

        function listarDestinatarios(dataString,tipo) {
            let data = $.parseJSON(dataString);
            if(tipo === 2){
                tblDestinatarios.clear().draw();
                $.each(data,function(index,value){
                    tblDestinatarios.row.add(value).draw();
                });
            } else {
                tblDestinosExternos.clear().draw();
                $.each(data,function(index,value){
                    tblDestinosExternos.row.add(value).draw();
                });
            }
        }

        function listarAnexosReferencia(codigo,parametro){
            let parametros = {
                codigo: codigo,
                atributo: parametro
            };
            $.ajax({
                cache: false,
                method: "POST",
                data: parametros,
                url: "ajax/ajaxListarAnexosReferencia.php",
                datatype: 'json',
                success: function (respuesta) {
                    if ($.trim(respuesta)){
                        respuesta = JSON.parse(respuesta);
                        $.each(respuesta,function(index,value){
                            if (value.cNombreOriginal.trim() == '') {
                                let nom = value.cNombreNuevo.split('/');
                                var nombre = nom[nom.length-1];
                            } else {
                                var nombre = value.cNombreOriginal;
                            }
                            InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo);
                        });
                    }
                }
            });
        }

        function listarAnexos(dataString, dataStringAnexosImprimibles = ''){
            let data = $.parseJSON(dataString);
            if (dataStringAnexosImprimibles == '' || dataStringAnexosImprimibles == null){
                $.each(data, function (key,value) {
                    $.ajax({
                        cache: false,
                        method: "POST",
                        data: value,
                        url: "ajax/ajaxListarAnexos.php",
                        datatype: 'json',
                        success: function (respuesta) {
                            let value = JSON.parse(respuesta);
                            if (value.cNombreOriginal.trim() == '') {
                                let nom = value.cNombreNuevo.split('/');
                                var nombre = nom[nom.length-1];
                            } else {
                                var nombre = value.cNombreOriginal;
                            };
                            InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo, false);
                        }
                    });
                });
            } else {
                let anexosImprimibles = $.parseJSON(dataStringAnexosImprimibles);
                $.each(data, function (key,value) {
                    $.ajax({
                        cache: false,
                        method: "POST",
                        data: value,
                        url: "ajax/ajaxListarAnexos.php",
                        datatype: 'json',
                        success: function (respuesta) {
                            let value = JSON.parse(respuesta);
                            if (value.cNombreOriginal.trim() == '') {
                                let nom = value.cNombreNuevo.split('/');
                                var nombre = nom[nom.length-1];
                            } else {
                                var nombre = value.cNombreOriginal;
                            };
                            let imprime = false;
                            $.each(anexosImprimibles, function (i,j){
                                if (value.iCodDigital == j.iCodDigital){
                                    imprime = true;
                                }
                            });
                            InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo, imprime);
                        }
                    });
                });
            }
        }

        function listarReferencias (dataStringReferencia){
            const cReferenciaSelect = $('#cReferencia');
            cReferenciaSelect.val(null).trigger('change');
            $.ajax({
                type: 'POST',
                url: 'ajax/ajaxListarReferencias.php',
                data: {datos: dataStringReferencia},
                datatype: 'json',
            }).then(function (data) {
                let theData = JSON.parse(data);
                $.each(theData, function( index, value ) {
                    let option = new Option(value.text, value.id, true, true);
                    cReferenciaSelect.append(option).trigger('change')
                });
            });
        }

        //BUSCAR EL RESPONSABLE
        function obtenerResponsable (origen,oculto,mostrado){
            if ($(origen).val().trim() != ""){
                $.ajax({
                    type: 'POST',
                    url: 'loadResponsableRIO.php',
                    data: {iCodOficinaResponsable: $(origen).val()},
                    dataType: 'json',
                    success: function(list){
                        $.each(list,function(index,value)
                        {
                            opcion = value.cNombresTrabajador.trim() + " " +  value.cApellidosTrabajador.trim();
                            codigo = value.iCodTrabajador;
                        });
                        $(oculto).val(codigo);
                        $(mostrado).val(opcion);
                    },
                    error: function(){
                        alert('Error Processing your Request 6!!');
                    }
                });
            } else {
                $(oculto).val("");
                $(mostrado).val("");
            }
        };

        // CADA QUE ESCOGE DESTIANTARIO OBTIENE RESPONSABLE
        $('#iCodOficinaO').on('change',function () {
            obtenerResponsable('#iCodOficinaO','#codResponsableiO','#nomResponsableO');
        });
    </script>
    <script src="includes/dropzone.js"></script>
    <script>
        /* Inital */
        $(function(){
            LoadDocumentosEnProceso();

            ContenidosTipo('idTipoRemitente', 30);

            $("#idTipoRemitente").change(function(){
                var persona = $("#idTipoRemitente").val();

                $("#nNumDocumento").removeAttr("disabled");

                switch (persona) {
                    case '60': //Natural
                        $(".pJuridica").hide();
                        $("label[for='nNumDocumento']").html("Número de DNI");
                        $("#nNumDocumento").attr('maxlength','8');
                        $('#nNumDocumento').attr('data-persona', 'natural');
                        $("span.nNumDocumento").html("Hasta 8 dígitos");
                        //console.log("Natural");
                        break;
                    case '62': //Jurídica
                        $(".pJuridica").show();
                        $("label[for='nNumDocumento']").html("Número de RUC");
                        $('#nNumDocumento').attr('data-persona', 'juridica');
                        $("#nNumDocumento").attr('maxlength','11');
                        $("span.nNumDocumento").html("Hasta 11 dígitos");
                        break;

                    default:
                        break;
                }

                getPersonaInfo();

            });

            $("#cDocumentosEnTramite").change(function(){
                if ($("#cDocumentosEnTramite").val() == "0") {
                    $("#btnDerivar").hide();
                    $("#btnDevolver").hide();
                    $("#btnArchivar").hide();
                    $("#btnRetroceder").hide();
                } else {
                    $.ajax({
                        url: "ajax/ajaxConsultaRegreso.php",
                        method: "POST",
                        data: {
                            cAgrupado: $("#cDocumentosEnTramite").val()
                        },
                        datatype: "json",
                        success: function (response) {
                            let respuesta = $.parseJSON(response);
                            if(respuesta.regreso === 'si'){
                                $("#btnDevolver").show();
                                $("#btnArchivar").show();
                                $("#btnRetroceder").show();
                            } else {
                                $("#btnDevolver").hide();
                                $("#btnArchivar").hide();
                                $("#btnRetroceder").hide();
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al consultar si puede regresar!');
                            M.toast({html: "Error al consultar"});
                        }
                    });
                }
                tblDocumentos.ajax.reload();

                let esRspta = <?=$_GET['iCodMov']??0?>;
                if (esRspta === 0) {
                    ListarReferenciaAgrupado($("#cDocumentosEnTramite").val());
                    ListarAnexosAgrupado($("#cDocumentosEnTramite").val());
                } else {
                    if ($("#cDocumentosEnTramite").val() == <?=$_GET['agrupado']??0?>) {
                        listarReferencias(JSON.stringify(<?=json_encode($tramitesRspt??'0')?>));
                        let tramites = <?=json_encode($tramitesRspt??'0')?>;
                        $.each(tramites, function (i,val) {
                            listarAnexosReferencia(val.iCodTramiteRef,'iCodTramite');
                        });
                    }
                }

            });

            ListarOficinaEspecialistasDestino();
        });

        function ListarReferenciaAgrupado(codAgrupado){
            const cReferenciaSelect = $('#cReferencia');
            cReferenciaSelect.val(null).trigger('change');
            $.ajax({
                url: "ajax/referenciaDisponiblesAgrupado.php",
                method: "POST",
                data: {
                    cAgrupado: codAgrupado
                },
                datatype: "json",
                success: function (respuesta) {
                    let datos = $.parseJSON(respuesta);
                    $.each(datos, function( index, value ) {
                        let option = new Option(value.text, value.id, true, true);
                        cReferenciaSelect.append(option).trigger('change');
                    });
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al obtener referencia!');
                    deleteSpinner();
                    M.toast({html: "Error al obtener referencia"});
                }
            });
        }

        // $(document).on("click", "#triggerCrearRemitente" , function() {
        //     $("#btnRegistrarRemi").css("display", "inline-block");
        //     $("#btnActualizarRemi").css("display", "none");

        //     $('select[name="idTipoRemitente"]').removeAttr('disabled');
        //     $('select[name="idTipoRemitente"] option[value="0"]').prop('selected', true);
        //     var elTipoPersona = document.getElementById('idTipoRemitente');
        //     M.FormSelect.init(elTipoPersona, {dropdownOptions:{container:document.body}});

        //     $('#nNumDocumento').attr('disabled', true);

        //     $(".pJuridica").hide();

        //     $("#modalRegRemitente h4").html("Crear Destinatario");

        //     var elems = document.querySelector('#modalRegRemitente');
        //     var instance = M.Modal.getInstance(elems);
        //     instance.options.dismissible = false;
        //     instance.open();
        // });

        // function getPersonaInfo() {
        //     var nNumDocumento = $("#nNumDocumento");
        //     var valLenght = nNumDocumento.attr('maxLength');

        //     switch (valLenght) {
        //         case "8":
        //             ajaxUrl = RutaSIGTID+"/ApiPide/Api/Reniec/REC_GET_0001?dni=";

        //             var Persona = function(){};
        //             Persona.prototype = {
        //                 Direccion: "",
        //                 EstadoCivil: "",
        //                 ImagenFoto: "",
        //                 Materno: "",
        //                 Nombres: "",
        //                 Numero: "",
        //                 Paterno: "",
        //                 Persona: "",
        //                 Restriccion: "",
        //                 Ubigeo: ""
        //             };

        //             break;

        //         default:
        //             break;
        //     }

        //     nNumDocumento.on('keyup', function() {

        //         if($(this).val().replace(/\s+/g, '').length == valLenght) {
        //             $.ajax({
        //                 url: ajaxUrl + nNumDocumento.val(),
        //                 method: "GET",
        //                 headers: {
        //                     'Authorization': $("#token").val(),
        //                 },
        //                 datatype: "application/json",
        //                 success: function (response) {
        //                     var persona = new Persona();
        //                     persona = response.EntityResult;
        //                     if (persona !== null) {
        //                         switch (valLenght) {
        //                             case "8":
        //                                 $("#nRemitente").val(persona.Nombres + ' ' + persona.Paterno + ' ' + persona.Materno);
        //                                 $("label[for=nRemitente]").addClass("active");

        //                                 $("#direccion").val(persona.Direccion);
        //                                 $("label[for=direccion]").addClass("active");
        //                                 break;

        //                             default:
        //                                 break;
        //                         }
        //                     }
        //                 }
        //             });
        //         }
        //     });
        // }

        function ContenidosTipo(idDestino, codigoTipo, arrayQuitar = []){
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
                method: "POST",
                data: {codigo: codigoTipo},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    destino.append('<option value="0">Seleccione</option>');
                    let quitarNum = arrayQuitar.length;
                    if (quitarNum == 0){
                        $.each(data, function( key, value ) {
                            destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                    } else {
                        $.each(data, function( key, value ) {
                            if (!arrayQuitar.includes(value.codigo)){
                                destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                            }
                        });
                    }                
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }


        function ListarAnexosAgrupado(codAgrupado){
            $.ajax({
                url: "ajax/anexosDisponiblesAgrupado.php",
                method: "POST",
                data: {
                    cAgrupado: codAgrupado
                },
                datatype: "json",
                success: function (respuesta) {
                    let datosRespuesta = $.parseJSON(respuesta.trim());
                    $.each(datosRespuesta, function (i,value) {
                        if (value.cNombreOriginal.trim() == '') {
                            let nom = value.cNombreNuevo.split('/');
                            var nombre = nom[nom.length-1];
                        } else {
                            var nombre = value.cNombreOriginal;
                        };
                        InsertarAnexo(value.iCodDigital, nombre, value.cNombreNuevo);
                    });
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al registrar el documento!');
                    deleteSpinner();
                    M.toast({html: "Error al registrar el documento"});
                }
            });
        }

        //tabla de grupos de documentos
        var tblDocumentos = $('#TblDocumentos').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            ajax:{
                'url': 'registerDoc/Documentos.php',
                'type': 'POST',
                'datatype': 'json',
                'data': function (d) {
                    d.Evento = "ListarDocumentosUsuario";
                    d.Agrupado =$("#cDocumentosEnTramite").val();
                }
            },
            "drawCallback": function( settings ) {
                var api = this.api();
                if (api.data().length==0){
                    $("#TablaDocumentosAcumulados").hide();
                    $("#btnDerivar").hide();
                }else{
                    $("#TablaDocumentosAcumulados").show();
                    $("#btnDerivar").show();
                }

                $('.tooltipped').tooltip();
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'tipoDoc', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'cCodificacion', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'nCud', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'cAsunto', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'cObservaciones', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'fFecRegistro', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'responsableFirma', 'autoWidth': true, 'className': 'text-left' },
                { 'data': 'datosDespacho', 'autoWidth': true, 'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        let botones = '';
                        if(full.tipo === 'proyecto'){
                            if(full.iCodOficinaFirmante === sesionOficina && (full.iCodTrabajadorFirmante === sesionTrabajador || sesionDelegado === 1 )) {
                                botones += '<button type="button" data-accion="generar" data-tooltip="Registrar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Generar"><i class="far fa-fw fa-file"></i></button>';
                            }
                            botones += '<button type="button" data-accion="editar" data-tooltip="Editar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Editar"><i class="fas fa-fw fa-pencil-alt"></i></button>'
                                + '<button type="button" data-accion="pre-visualizacion" data-tooltip="Ver" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-fw fa-eye"></i></button>'
                                + '<button type="button" data-accion="anular" data-tooltip="Anular" class="btn btn-sm btn-link danger tooltipped" data-position="bottom" name="Anular"><i class="fas fa-fw fa-trash-alt"></i></button>';
                            if (full.nFlgTipoDoc === 3) {
                                botones += '<button type="button" data-accion="completarDespacho" data-tooltip="Completar Despacho" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Completar Despacho"><i class="fas fa-box"></i></button>';
                            }
                        }
                        if(full.tipo === 'tramite'){
                            if(full.firma === 0){
                                if(full.iCodOficinaFirmante === sesionOficina && (full.iCodTrabajadorFirmante === sesionTrabajador || sesionDelegado === 1)) {
                                    botones += '<button type="button" data-accion="firmar" data-tooltip="Firmar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Firmar"><i class="fas fa-fw fa-signature fa-fw left"></i></button>';
                                } else {
                                    botones  += '<button type="button" data-accion="visar" data-tooltip="Visar" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Visar"><i class="fas fa-fw fa-check left"></i></button>';
                                }
                            }
                            if(full.iCodOficinaFirmante === sesionOficina && (full.iCodTrabajadorFirmante === sesionTrabajador || sesionDelegado === 1) && full.nFlgEnvio == 0) {
                                botones += '<button type="button" data-accion="invalidar" data-tooltip="Invalidar" class="btn btn-sm btn-link danger tooltipped" data-position="bottom" name="invalidar"><i class="fas fa-fw fa-trash-alt"></i></button>';
                            }
                            botones += '<button type="button" data-accion="ver-anexos" data-tooltip="Ver Anexos" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver-Anexos"><i class="fas fa-fw fa-paperclip fa-fw left"></i></button>';
                            botones += '<button type="button" data-accion="ver" data-tooltip="Ver" class="btn btn-sm btn-link tooltipped" data-position="bottom" name="Ver"><i class="far fa-fw fa-eye"></i></button>';
                        }
                        return botones
                    }, 'className': 'text'
                }
            ]
        });

        $('#TblDocumentos tbody').on('click', 'button', function (event) {
            let fila = tblDocumentos.row($(this).parents('tr'));
            let dataFila = fila.data();
            let accion = $(this).attr("data-accion");
            switch (accion) {
                case 'editar':
                    $.ajax({
                        url: 'registerDoc/Documentos.php',
                        method : 'POST',
                        datatype: 'json',
                        data: {
                            Evento : "ObtenerDatosDocumentos",
                            codigo : dataFila.codigo,
                            tipo : dataFila.tipo,
                            agrupado : dataFila.cAgrupado,
                        },
                        success: function (response) {
                            let data = $.parseJSON(response);
                            // llena los datos en el formulario
                            $('#cCodTipoTra option[value="'+data.nFlgTipoDoc+'"]').prop('selected',true);
                            $('#cCodTipoTra').formSelect();
                            formularioTipoDestinatario(data.nFlgTipoDoc);
                            tiposDocumentos(data.nFlgTipoDoc,data.cCodTipoDoc);
                            $('#cCodTipoDoc').attr('onChange','');

                            if(data.nFlgTipoDoc == '3' && data.cCodTipoDoc == '13'){
                                $("#nombreDestinoExternocol").css("display","none");
                                $("#nombreDestinoEntidadMREcol").css("display","block");
                            }

                            if (data.fFecPlazo != null) {
                                let instanceCalendar = M.Datepicker.getInstance($('#fFecPlazo'));
                                let fecPlazo = new Date(data.fFecPlazo.date);
                                instanceCalendar.setDate(fecPlazo);
                                $('#fFecPlazo').attr("placeholder",data.fFecPlazo.date);
                            }

                            $('#cAsunto').val(data.cAsunto).next().addClass('active');

                            $('#cObservaciones').val(data.cObservaciones).next().addClass('active');

                            if(data.flgSigo == 1){
                                $('input[name="flgSigo"]').prop('checked',true);
                            }

                            if (CKEDITOR.instances.editorOficina.getData()){
                                CKEDITOR.instances.editorOficina.setData('');
                            }
                            CKEDITOR.instances.editorOficina.setData(data.cCuerpoDocumento);

                            listarDestinatarios(data.destinatarios,data.nFlgTipoDoc);

                            listarReferencias(data.cReferencia);

                            tblAnexos.rows().remove().draw(false);
                            listarAnexos (data.cAnexos, data.cAnexosImprimibles);
                            $("#cCodigo").val(dataFila.codigo);
                            $("#cTipo").val(dataFila.tipo);

                            //activa boton para guardar cambios
                            $("#btnGuardarCambios").css("display","inline-block");
                            $(fila.node()).find('button[name="Editar"]').css('display','none');
                            $("#btnValidacionAgregar").css("display","none");
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al obtener los datos!');
                            deleteSpinner();
                            M.toast({html: "Error al obtener los datos"});
                        }
                    });
                    break;

                case 'pre-visualizacion':
                    $.ajax({
                        url: 'registerDoc/Documentos.php',
                        method : 'POST',
                        datatype: 'json',
                        data: {
                            Evento : "ObtenerDatosDocumentos",
                            codigo : dataFila.codigo,
                            tipo : dataFila.tipo,
                            agrupado : dataFila.cAgrupado,
                        },
                        success: function (response) {
                            let datos = $.parseJSON(response);
                            $.ajax({
                                url: "previsualizacion-pdf.php",
                                method: "POST",
                                dataType : "text",

                                data: datos,
                                success: function (respuesta) {
                                    let datos = respuesta;
                                    let ifr = $("#modalPrevisualizacion iframe");
                                    ifr.attr('src','data:application/pdf;base64,' + datos);
                                    let instance = M.Modal.getInstance($("#modalPrevisualizacion"));
                                    instance.open();
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al obtener el documento!');
                                    M.toast({html: "Error al obtener el documento!"});
                                }
                            });
                        }
                    });

                    break;

                case 'anular':
                    $.confirm({
                        title: '¿Esta seguro de anular el proyecto?',
                        content: '',
                        buttons: {
                            Si: function () {
                                getSpinner();
                                $.ajax({
                                    url: "registerDoc/Documentos.php",
                                    method: "POST",
                                    data: {
                                        Evento: 'AnularDocumento',
                                        tipo: dataFila.tipo,
                                        codigo: dataFila.codigo
                                    },
                                    datatype: "json",
                                    success: function () {
                                        console.log('Proyecto Anulado!');
                                        M.toast({html: "Proyecto Anulado"});
                                        tblDocumentos.ajax.reload();
                                    },
                                    error: function (e) {
                                        console.log(e);
                                        console.log('Error al anular el proyecto!');
                                        deleteSpinner();
                                        M.toast({html: "Error al anular el proyecto"});
                                    }
                                });
                            },
                            No: function () {
                                $.alert('Proceso de anulación cancelada');
                            }
                        }
                    });
                    break;

                case 'completarDespacho':
                    $("#IdProyectoDespacho").val(dataFila.codigo);
                    $("#ObservacionesDespacho").val('');
                    $('#datosEnvioFisico').css('display','block');
                    if (dataFila.cCodTipoDoc != 13){
                        $.ajax({
                            url: 'registerDoc/Documentos.php',
                            method : 'POST',
                            datatype: 'json',
                            data: {
                                Evento : "ObtenerDatosDocumentos",
                                codigo : dataFila.codigo,
                                tipo : dataFila.tipo,
                                agrupado : dataFila.cAgrupado,
                            },
                            success: function (response) {
                                let datos = $.parseJSON(response);
                                datos = $.parseJSON(datos.destinatarios);
                                datos = datos[0];
                                $('#formDatosDespacho #NombreDespacho').val(datos.nomRemitente).next().addClass('active');
                                $('#formDatosDespacho #RucDespacho').val(datos.nroDocumento).next().addClass('active');
                                ObtenerDatosSedeDespacho(datos.IdSede);
                            }
                        });

                        


                        // $.ajax({
                        //     cache: false,
                        //     url: "ajax/ajaxDatosRemitente.php",
                        //     method: "POST",
                        //     data: {iCodRemitente : dataFila.IdRemitente},
                        //     datatype: "json",
                        //     success : function(response) {
                        //         response = JSON.parse(response);

                        //         $('#formDatosDespacho #NombreDespacho').val(response.cNombre).next().addClass('active');
                        //         $ruc = '';
                        //         if (response.cRuc != null && response.cRuc.trim() != ''){
                        //             $ruc = response.cRuc;
                        //         } else if (response.nNumDocumento != null && response.nNumDocumento.trim() != '') {
                        //             $ruc = response.nNumDocumento;
                        //         }
                        //         $('#formDatosDespacho #RucDespacho').val($ruc).next().addClass('active');
                        //         $('#formDatosDespacho #DireccionDespacho').val(response.cDireccion).next().addClass('active');

                        //         if(response.cDepartamento !== '' && response.cDepartamento !== null){
                        //             $('#formDatosDespacho #DepartamentoDespacho option[value="'+response.cDepartamento+'"]').prop('selected',true);
                        //             var elemdep = document.getElementById('DepartamentoDespacho');
                        //             M.FormSelect.init(elemdep, {dropdownOptions:{container:document.body}});

                        //             if (response.cProvincia !== '' && response.cProvincia !== null) {
                        //                 $.ajax({
                        //                     cache: false,
                        //                     url: "ajax/ajaxProvincias.php",
                        //                     method: "POST",
                        //                     data: {codDepa : response.cDepartamento},
                        //                     datatype: "json",
                        //                     success: function (dataP) {
                        //                         dataP = JSON.parse(dataP);
                        //                         if(dataP.tiene = 1) {
                        //                             $('#formDatosDespacho #ProvinciaDespacho').empty().append('<option value="">Seleccione</option>');
                        //                             $.each(dataP.info, function (key, value) {
                        //                                 $('#formDatosDespacho #ProvinciaDespacho').append('<option value="' + value.codigo + '">' + value.nombre + '</option>');
                        //                             });
                        //                             $('#formDatosDespacho #ProvinciaDespacho option[value=' + response.cProvincia + ']').prop('selected', true);
                        //                             var elempro = document.getElementById('ProvinciaDespacho');
                        //                             M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});

                        //                             if (response.cDistrito !== '' && response.cDistrito !== null) {
                        //                                 $.ajax({
                        //                                     cache: false,
                        //                                     url: "ajax/ajaxDistritos.php",
                        //                                     method: "POST",
                        //                                     data: {codDepa :response.cDepartamento, codPro: response.cProvincia},
                        //                                     datatype: "json",
                        //                                     success: function (dataD) {
                        //                                         dataD = JSON.parse(dataD);
                        //                                         if(dataD.tiene = 1) {
                        //                                             $('#formDatosDespacho #DistritoDespacho').empty().append('<option value="">Seleccione</option>');
                        //                                             $.each(dataD.info, function (key, value) {
                        //                                                 $('#formDatosDespacho #DistritoDespacho').append('<option value="' + value.codigo + '">' + value.nombre + '</option>');
                        //                                             });
                        //                                             $('#formDatosDespacho #DistritoDespacho option[value=' + response.cDistrito + ']').prop('selected', true);
                        //                                             var elemdis = document.getElementById('DistritoDespacho');
                        //                                             M.FormSelect.init(elemdis, {dropdownOptions: {container: document.body}});
                        //                                         }
                        //                                     }
                        //                                 });
                        //                             } else {
                        //                                 $("#ProvinciaDespacho").trigger("change");
                        //                             }
                        //                         }
                        //                     }
                        //                 });
                        //             } else {
                        //                 $("#DepartamentoDespacho").trigger("change");
                        //             }
                        //         }
                        //     }
                        // });
                    } else {
                        $.ajax({
                            cache: false,
                            url: "ajax/ajaxBuscarEntidadMRE.php",
                            method: "POST",
                            data: {IdEntidadMRE : dataFila.IdRemitente},
                            datatype: "json",
                            success : function(response) {
                                response = JSON.parse(response);
                                $('#formDatosDespacho #NombreDespacho').val(response.nombre).next().addClass('active');
                            }
                        });
                    }

                    var rucDespacho = $("#RucDespacho").val();
                   
                    if (rucDespacho == null || rucDespacho == ''){
                        ContenidosTipo('IdTipoEnvio','12', [72]);
                    } else {
                        $.ajax({
                            url: RutaSIGTIInteroperabilidad + "Api/Interoperabilidad/Entidad/SSO_GET_0003?vrucent="+ rucDespacho,
                            method: "POST",
                            datatype: "application/json",
                            success: function (data) {
                                if (data.MessageResult != '-1'){
                                    $.ajax({
                                        url: RutaSIGTIInteroperabilidad + "Api/Interoperabilidad/tramite/SSO_GET_0001",
                                        method: "GET",
                                        datatype: "application/json",
                                        success: function (datos) {
                                            let permite = false;
                                            $.each(datos.ListResult, function (i,value) {
                                                if (dataFila.tipoDoc.trim().toUpperCase() == value.vnomtipdoctraField) {
                                                    permite = true;
                                                }
                                            });
                                            if (permite){
                                                ContenidosTipo('IdTipoEnvio','12');
                                            } else {
                                                ContenidosTipo('IdTipoEnvio','12', [72]);
                                            }
                                        }
                                    });
                                } else {
                                    ContenidosTipo('IdTipoEnvio','12', [72]);
                                }
                            }
                        });
                    }
                    var elemDespacho = document.querySelector('#modalDespacho');
                    var instanceDespacho = M.Modal.getInstance(elemDespacho);
                    instanceDespacho.options.dismissible = false;
                    instanceDespacho.open();
                    break;

                case 'generar':
                    if (dataFila.flgDatosDespacho === 1) {
                        $.confirm({
                            title: '¿Esta seguro de querer generar un documento del proyecto?',
                            content: 'El documento una vez creado ya no puede ser cambiada la información',
                            buttons: {
                                Si: function () {
                                    getSpinner('Cargando...');
                                    $.ajax({
                                        url: "registerDoc/Documentos.php",
                                        method: "POST",
                                        data: {
                                            Evento: 'GenerarDocumento',
                                            codigo: dataFila.codigo
                                        },
                                        datatype: "json",
                                        success: function (response) {
                                            let json = $.parseJSON(response);
                                            let elems = document.querySelector('#modalDoc');
                                            let instance = M.Modal.getInstance(elems);
                                            deleteSpinner();

                                            $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);
                                            instance.open();
                                            console.log('Documento generado!');
                                            M.toast({html: "Documento generado"});
                                            tblDocumentos.ajax.reload();
                                        },
                                        error: function (e) {
                                            console.log(e);
                                            console.log('Error al generar el documento!');
                                            deleteSpinner();
                                            M.toast({html: "Error al generar el documento"});
                                        }
                                    });
                                },
                                No: function () {
                                    $.alert('Generación de documento cancelada');
                                }
                            }
                        });
                    } else{
                        $.alert('Falta completar datos de despacho!');
                    }
                    break;

                case 'visar':
                    $.ajax({
                        url: "ajax/obtenerDocFirma.php",
                        method: "POST",
                        data: {
                            codigo: dataFila.codigo
                        },
                        datatype: "json",
                        success: function (response) {
                            let json = $.parseJSON(response);
                            if (json.length !== 0){
                                console.log('¡Documento obtenido!');
                                // if (json['url'].trim().split('/')[2] == 'docNoFirmados'){
                                //     $("#signedDocument").val(json['url'].trim().replace('.pdf','-PF.pdf'));
                                // } else {
                                //     $("#signedDocument").val(json['url'].trim());
                                // }
                                $("#nombreDocument").val(json['nombre'].trim());
                                $("#signedDocument").val(json['url'].trim());
                                $("#idtra").val(dataFila.codigo);
                                $("#tipo_f").val('v');
                                $("#nroVisto").val(dataFila.visto);
                                initInvoker('W');
                            } else {
                                console.log('¡No se pudo obtener el documento!');
                                M.Toast({html:'¡No se pudo obtener el documento!'});
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al obtener el documento!');
                            M.toast({html: "Error al obtener el documento"});
                        }
                    });
                    break;

                case 'firmar':
                    if (dataFila.tipoDoc.trim() === 'NOTA INFORMATIVA') {
                        $.ajax({
                            url: "ajax/obtenerDocFirma.php",
                            method: "POST",
                            data: {
                                codigo: dataFila.codigo
                            },
                            datatype: "json",
                            success: function (response) {
                                let json = $.parseJSON(response);
                                if (json.length !== 0){
                                    let informacion =
                                        '<dl><dt style="font-weight:700">Asunto</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.cAsunto.trim()+'</dd>'+
                                        '<dt style="font-weight:700">Documento</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.tipoDoc.trim()+' '+dataFila.cCodificacion.trim()+'</dd>'+
                                        '<dt style="font-weight:700">CUD</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.nCud.trim()+'</dd></dl>';
                                    console.log('¡Documento obtenido!');
                                    // if (json['url'].trim().split('/')[2] == 'docNoFirmados'){
                                    //     $("#signedDocument").val(json['url'].trim().replace('.pdf','-PF.pdf'));
                                    // } else {
                                    //     $("#signedDocument").val(json['url'].trim());
                                    // }
                                    $("#nombreDocument").val(json['nombre'].trim());
                                    $("#signedDocument").val(json['url'].trim());
                                    $("#idtra").val(dataFila.codigo);
                                    $("#tipo_f").val('f');
                                    $("#nroVisto").val(dataFila.visto);
                                    $("#datosDoc").val(informacion);
                                    initInvoker('W');
                                } else {
                                    console.log('¡No se pudo obtener el documento!');
                                    M.Toast({html:'¡No se pudo obtener el documento!'});
                                }
                            },
                            error: function (e) {
                                console.log(e);
                                console.log('Error al obtener el documento!');
                                M.toast({html: "Error al obtener el documento"});
                            }
                        });
                    } else {
                        $.confirm({
                            title: '¿Desea enviarlo para visto?',
                            content: '',
                            buttons: {
                                Si: function () {
                                    M.Modal.getInstance($("#modalDevolver")).open();
                                },
                                No: function () {
                                    $.ajax({
                                        url: "ajax/obtenerDocFirma.php",
                                        method: "POST",
                                        data: {
                                            codigo: dataFila.codigo
                                        },
                                        datatype: "json",
                                        success: function (response) {
                                            let json = $.parseJSON(response);
                                            if (json.length !== 0){
                                                let informacion =
                                                    '<dl><dt style="font-weight:700">Asunto</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.cAsunto.trim()+'</dd>'+
                                                    '<dt style="font-weight:700">Documento</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.tipoDoc.trim()+' '+dataFila.cCodificacion.trim()+'</dd>'+
                                                    '<dt style="font-weight:700">CUD</dt><dd style="margin-bottom:.5rem;margin-inline-start:0">'+dataFila.nCud.trim()+'</dd></dl>';
                                                console.log('¡Documento obtenido!');
                                                // if (json['url'].trim().split('/')[2] == 'docNoFirmados'){
                                                //     $("#signedDocument").val(json['url'].trim().replace('.pdf','-PF.pdf'));
                                                // } else {
                                                //     $("#signedDocument").val(json['url'].trim());
                                                // }
                                                $("#nombreDocument").val(json['nombre'].trim());
                                                $("#signedDocument").val(json['url'].trim());
                                                $("#idtra").val(dataFila.codigo);
                                                $("#tipo_f").val('f');
                                                $("#nroVisto").val(dataFila.visto);
                                                $("#datosDoc").val(informacion);
                                                initInvoker('W');
                                            } else {
                                                console.log('¡No se pudo obtener el documento!');
                                                M.Toast({html:'¡No se pudo obtener el documento!'});
                                            }
                                        },
                                        error: function (e) {
                                            console.log(e);
                                            console.log('Error al obtener el documento!');
                                            M.toast({html: "Error al obtener el documento"});
                                        }
                                    });
                                },
                                Cancelar: function () {
                                    console.log('Firma cancelada');
                                }
                            }
                        });
                    }
                    break;

                case 'invalidar':
                    $.confirm({
                        title: '¿Esta seguro de invalidar el documento?',
                        content: 'El correlativo no sera retrocedido en ningún caso.',
                        buttons: {
                            Si: function () {
                                $.ajax({
                                    url: "registerDoc/Documentos.php",
                                    method: "POST",
                                    data: {
                                        Evento: 'AnularTramiteGenerado',
                                        codigo: dataFila.codigo
                                    },
                                    datatype: "json",
                                    error: function (e) {
                                        console.log(e);
                                        console.log('Error al anular el documento!');
                                        deleteSpinner();
                                        M.toast({html: "Error al anular el documento"});
                                    },
                                    success: function (e) {
                                        console.log('Documento invalidado!');
                                        tblDocumentos.ajax.reload();
                                        M.toast({html: "Documento invalidado correctamente "});
                                    }
                                });
                            },
                            No: function () {
                                $.alert('Proceso de anulación cancelada');
                            }
                        }
                    });
                    break;

                case 'ver':
                    $.ajax({
                        url: "ajax/obtenerDoc.php",
                        method: "POST",
                        data: {
                            codigo: dataFila.codigo
                        },
                        datatype: "json",
                        success: function (response) {
                            let json = $.parseJSON(response);
                            if (json.length !== 0){
                                console.log('¡Documento obtenido!');
                                $('#modalDoc div.modal-content iframe').attr('src', 'http://' + json['url']);
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

                    break;

                case 'ver-anexos':
                    $.ajax({
                        cache: false,
                        url: "verAnexo.php",
                        method: "POST",
                        data: { codigo: dataFila.codigo },
                        datatype: "json",
                        success: function (response) {
                            $('#modalAnexo div.modal-content ul').html('');
                            var json = eval('(' + response + ')');
                            if(json.tieneAnexos == '1') {
                                let cont = 1;
                                json.anexos.forEach(function (elemento) {
                                    $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-fw fa-file-alt"></i></span><a class="btn-link" href="http://'+elemento.url+'" target="_blank">'+elemento.nombre+'</a></li>');
                                    cont++;
                                })
                            }else{
                                $('#modalAnexo div.modal-content ul').append('<li><span class="fa-li"><i class="fas fa-fw fa-info"></i></span>El documento no tiene Anexos.</li>');
                            }
                            $('#modalAnexo').modal('open');
                        }
                    });
                    break;
            }
        });

        $("#btnGuardarDatosDespacho").on('click', function(e){
            e.preventDefault();

            let estado = true;
            if ($("#IdTipoEnvio").val() != 0) {
                if ($("#IdTipoEnvio").val() == 19 || $("#IdTipoEnvio").val() == 21){
                    if ($("#DireccionDespacho").val().trim() == ''){
                        estado = false;
                        $.alert("Falta dirección del despacho");
                    } else if ($("#DepartamentoDespacho").val() == null || $("#DepartamentoDespacho").val() == '') {
                        estado = false;
                        $.alert("Falta departamento")
                    } else if ($("#ProvinciaDespacho").val() == null || $("#ProvinciaDespacho").val() == '') {
                        estado = false;
                        $.alert("Falta provincia")
                    } else if ($("#DistritoDespacho").val() == null || $("#DistritoDespacho").val() == '') {
                        estado = false;
                        $.alert("Falta distrito")
                    }
                } else if ($("#IdTipoEnvio").val() == 72){
                    if ($("#UnidadOrganicaDstIOT").val().trim() == ''){
                        estado = false;
                        $.alert("Falta unidad orgánica destino");
                    } else if ($("#PersonaDstIOT").val().trim() == '') {
                        estado = false;
                        $.alert("Falta persona destino")
                    } else if ($("#CargoPersonaDstIOT").val().trim() == '') {
                        estado = false;
                        $.alert("Falta cargo de persona destino")
                    }
                } else if ($("#IdTipoEnvio").val() == 19) {
                    if ($("#ObservacionesDespacho").val().trim() == ''){
                        estado = false;
                        $.alert("Falta observación");
                    }
                }
            } else {
                estado = false;
                $.alert("Falta tipo de despacho");
            }
            

            if (estado == true) {
                getSpinner();
                let data = $('#formDatosDespacho').serializeArray();
                let formData = new FormData();
                $.each(data, function (key, el) {
                    formData.append(el.name, el.value);
                });
                formData.append("Evento", "GuardarDatosDespacho");
                $.ajax({
                    url: "registerDoc/Documentos.php",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    datatype: "json",
                    success: function (cAgrupado) {
                        console.log('Registrado correctamente!');
                        let elemento = document.querySelector('#modalDespacho');
                        M.Modal.getInstance(elemento).close();
                        deleteSpinner();
                        M.toast({html: "Datos guardados correctamente"});
                        tblDocumentos.ajax.reload();

                    },
                    error: function (e) {
                        console.log(e);
                        console.log('Error al guardar datos para el despacho!');
                        deleteSpinner();
                        M.toast({html: "Error al guardar datos para el despacho"});
                    }
                });
            }
        });

        // TABLA DE DESTINATARIOS internos
        var tblDestinatarios = $('#TblDestinatarios').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblDestinatarios").hide();
                }else{
                    $("#TblDestinatarios").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'nomOficina', 'autoWidth': true,"width": "30%", 'className': 'text-left' },
                { 'data': 'nomResponsable', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                { 'data': 'nomCopia', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "20px"
                },
            ]
        });

        $("#TblDestinatarios tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            if(accion === 'eliminar'){
                tblDestinatarios.row($(this).parents('tr')).remove().draw(false);
            }
        });

        $("#btnAgregarDestinatario").click(function(){
            // SI ES PARA ESPECIALISTA U OFICINA
            if($('#flgDelegar').is(':checked')){
                if ($("#responsableE").val() == ""){
                    $.alert('Falta seleccionar especialista');
                    return false;
                } else {
                    var icodOficina = $("#CodOficinaE").val();
                    var nomOficina = $("#nomOficinaE").find(':selected').text();
                    var icodResponsable = $("#responsableE").val();
                    var nomResponsable = $("#responsableE").find(':selected').text().split('(')[0];
                    var iCodPerfil = 4;
                }
            } else {
                if ($("#iCodOficinaO").val() == ""){
                    $.alert('Falta seleccionar oficina');
                    return false
                } else {
                    var icodOficina = $("#iCodOficinaO").val();
                    var nomOficina = $("#iCodOficinaO").find(':selected').text();
                    var icodResponsable = $("#codResponsableiO").val();
                    var nomResponsable = $("#nomResponsableO").val();
                    var iCodPerfil = 3;
                }
            }

            let destinatarios = new Object();
            destinatarios.icodOficina= icodOficina;
            destinatarios.nomOficina=nomOficina;
            destinatarios.icodResponsable= icodResponsable;
            destinatarios.nomResponsable= nomResponsable;
            destinatarios.cCopia = $("#cCopia").val();
            destinatarios.nomCopia = $("#cCopia").find(":selected").text();
            destinatarios.iCodPerfil = iCodPerfil;

            //VALIDAR SI YA ESTA INGRESADO
            let data = tblDestinatarios.data();
            let estado = false;
            $.each(data, function (i, item) {
                if (destinatarios.icodOficina == item.icodOficina && destinatarios.icodResponsable == item.icodResponsable ) {
                    estado = true;
                }
            });
            if (!estado) {
                tblDestinatarios.row.add(destinatarios).draw();
            } else {
                $.alert("El Destinatorio ya está agreado");
            }
        });

        //tabla destinos externos
        var tblDestinosExternos = $('#TblDestinosExternos').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblDestinosExternos").hide();
                }else{
                    $("#TblDestinosExternos").show();
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                { 'data': 'nomRemitente', 'autoWidth': true,"width": "10%", 'className': 'text-left' },
                { 'data': 'nroDocumento', 'autoWidth': true,"width": "10%", 'className': 'text-left' },
                { 'data': 'cDireccion', 'autoWidth': true, "width": "10%",'className': 'text-left' },
                { 'data': 'preFijo', 'autoWidth': true, "width": "5%",'className': 'text-left' },
                { 'data': 'nombreResponsable', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                { 'data': 'cargoResponsable', 'autoWidth': true, "width": "30%",'className': 'text-left' },
                { 'data': 'mostrarDireccion', 'autoWidth': true, "width": "5%",'className': 'text-left' },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "20px"
                },
            ]
        });

        $("#TblDestinosExternos tbody").on('click', 'button', function () {
            let accion = $(this).attr("data-accion");
            if(accion === 'eliminar'){
                tblDestinosExternos.row($(this).parents('tr')).remove().draw(false);
            }
        });

        $("#btnAgregarDestinoExterno").click(function(){
            let destino = new Object();
            if($("#cCodTipoTra").val() == '3' && $("#cCodTipoDoc").val() == '13'){
                if ($("#nombreDestinoEntidadMRE").val() == null){
                    return $.alert("Falta seleccionar entidad");
                }

                destino.iCodRemitente= $("#nombreDestinoEntidadMRE").select2('data')[0].id;
                destino.nomRemitente= $("#nombreDestinoEntidadMRE").select2('data')[0].text;
            } else {
                if ($("#nombreDestinoExterno").val() == null){
                    return $.alert("Falta seleccionar entidad");
                }

                destino.iCodRemitente= $("#nombreDestinoExterno").select2('data')[0].id;
                destino.nomRemitente= $("#nombreDestinoExterno").select2('data')[0].text;

                if ($("#dependenciasDestinoExterno select").length != 0){
                    for (var elem of $("#dependenciasDestinoExterno select")){
                        if ($(elem).val() != ''){
                            destino.iCodRemitente = $(elem).val();
                            destino.nomRemitente += " - " + $(elem).find("option:selected").text();
                        } else {
                            break;
                        }                  
                    }
                }        
            }
            if ($("#flgMostrarDireccion:checked").length == 1){
                destino.flgMostrarDireccion = 0;
                destino.mostrarDireccion = 'No';
            } else {
                destino.flgMostrarDireccion = 1;
                destino.mostrarDireccion = 'Si';
            }

            if ($("#direccionDestinoExterno").val() == '' || $("#direccionDestinoExterno").val() == null){
                return $.alert("Falta seleccionar dirección");
            }

            destino.nroDocumento = $("#nroDocDestinoExterno").val();
            destino.cDireccion = $("#direccionDestinoExterno option:selected").text();
            destino.IdSede = $("#direccionDestinoExterno").val();
            destino.preFijo = $("#prefijoNombre").val();
            destino.nombreResponsable= $("#responsableDestinoExterno").val();
            destino.cargoResponsable= $("#cargoResponsableDestinoExterno").val();

            //VALIDAR SI YA ESTA INGRESADO
            let data = tblDestinosExternos.data();
            let estado = false;
            $.each(data, function (i, item) {
                if (destino.iCodRemitente == item.iCodRemitente && destino.IdSede == item.IdSede) {
                    estado = true;
                }
            });
            if (!estado) {
                tblDestinosExternos.row.add(destino).draw();
            } else {
                $.alert("El destino ingresado ya está agreado");
            }
        });

        //tabla de anexos
        var tblAnexos = $('#TblAnexos').DataTable({
            responsive: true,
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            "drawCallback": function() {
                let api = this.api();
                if (api.data().length === 0){
                    $("#TblAnexos").hide();
                    $('#anexosDoc').css('display', 'none');
                }else{
                    $("#TblAnexos").show();
                    $('#anexosDoc').css('display', 'block');
                }
            },
            "language": {
                "url": "../dist/scripts/datatables-es_ES.json"
            },
            'columns': [
                {
                    'render': function (data, type, full, meta) {
                        let anexoEnviar = '';
                        anexoEnviar = '<p class="'+full.codigoAnexo+'"><label><input type="checkbox" class="filled-in '+full.codigoAnexo+'" data-accion="enviar" checked="checked" name="cAnexos[]" value="'+full.codigoAnexo+'"><span></span></label></p>';
                        return anexoEnviar;
                    }, 'className': 'center-align',"width": "5%"
                },
                {
                    'render': function (data, type, full, meta) {
                        let anexoImprimir = '';
                        anexoImprimir = '<p class="'+full.codigoAnexo+'"><label><input type="checkbox" class="filled-in '+full.codigoAnexo+'" checked="checked" data-accion="imprimir" name="cAnexosImprimibles[]" value="'+full.codigoAnexo+'"><span></span></label></p>';
                        return anexoImprimir;
                    }, 'className': 'center-align',"width": "5%"
                },
                {
                    'render': function (data, type, full, meta) {
                        let nombreAnexo = '';
                        nombreAnexo = '<a href="http://'+full.rutaAnexo+'" target="_blank">'+full.nombreAnexo+'</a>';
                        return nombreAnexo;
                    }, 'className': 'center-align',"width": "85%"
                },
                {
                    'render': function (data, type, full, meta) {
                        return '<button type="button" data-accion="eliminar" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-link tooltipped danger" data-placement="top"><i class="fas fa-fw fa-trash-alt"></i></button> ';
                    }, 'className': 'center-align',"width": "5%"
                },
            ]
        });

        $("#TblAnexos tbody")
            .on('click', 'button', function () {
                let accion = $(this).attr("data-accion");
                if(accion === 'eliminar'){
                    tblAnexos.row($(this).parents('tr')).remove().draw(false);
                }
            })
            .on('change', 'input', function () {
                let accion = $(this).attr("data-accion");
                let valorAnexo = $(this).val();
                switch (accion){
                    case 'imprimir':
                        if ($(this).prop("checked") === true){
                            $("input[value='"+valorAnexo+"'][data-accion='enviar']").prop("checked", true)
                        }
                        break;
                    case 'enviar':
                        if ($(this).prop("checked") === false){
                            $("input[value='"+valorAnexo+"'][data-accion='imprimir']").prop("checked", false)
                        }
                        break;
                    default:
                        break;
                }
            });

        function InsertarAnexo(codigo, nombre, ruta, imprimible = true) {
            let anexo = new Object();
            anexo.codigoAnexo = codigo;
            anexo.nombreAnexo = nombre;
            anexo.rutaAnexo = ruta;

            let estado = false;
            let data = tblAnexos.data();
            console.log(data);
            $.each(data, function (i, item) {
                if (ruta == item.rutaAnexo /*codigo == item.codigoAnexo && nombre == item.nombreAnexo*/) {
                    estado = true;
                }
            });

            if (!estado) {
                tblAnexos.row.add(anexo).draw();
                if (imprimible === false){
                    $("input[value='"+codigo+"'][data-accion='imprimir']").prop("checked", false);
                }
            } else {
                console.log("El anexo ya está agregado");
            }
        }

        function obtenerDatosFormulario () {
            // Obtiene todos los datos del registro
            CKEDITOR.instances.editorOficina.updateElement();
            let data = $('#frmRegistro').serializeArray();
            let formData = new FormData();
            $.each(data, function(key, el) {
                formData.append(el.name, el.value);
            });
            formData.append("Evento","registrarProyecto");
            if ($('#cCodTipoTra').val() === '2'){
                var tabla = tblDestinatarios.data();
            } else {
                var tabla = tblDestinosExternos.data();
            }
            $.each(tabla, function (i, item) {
                $.each(item, function (key,value) {
                    formData.append("DataDestinatario[" + i + "]["+key+"]", value);
                });
            });
            return formData;
        }

        /*function registrarProyecto(){
            
        };*/

        $("#btnAgregarProyecto").on("click",function (e) {
            let datos = obtenerDatosFormulario();
            getSpinner('Guardando documento');
            //Envía para registro del proyecto
            //debugger;
            $.ajax({
                url: "registerDoc/regProyecto.php",
                method: "POST",
                data: datos,
                processData: false,
                contentType: false,
                datatype: "json",
                success: function (cAgrupado) {
                    //getSpinner('Guardando documento');
                    console.log('Registrado correctamente!');
                    //let elemento = document.querySelector('#modalResponsableFirma');
                    //M.Modal.getInstance(elemento).close();
                    M.toast({html: "Registrado correctamente"});
                    if ($("#cDocumentosEnTramite").val() == '0') {
                        setTimeout(function(){ getSpinner('Guardando documento'); window.location = "registroOficina.php?agrupado="+cAgrupado; getSpinner('Guardando documento'); });
                    } else {
                        setTimeout(function(){ getSpinner('Guardando documento'); window.location = "registroOficina.php?agrupado="+$("#cDocumentosEnTramite").val(); getSpinner('Guardando documento'); });
                    }
                    //deleteSpinner();
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al registrar el documento!');
                    deleteSpinner();
                    M.toast({html: "Error al registrar el documento"});
                    let elemento = document.querySelector('#modalResponsableFirma');
                    M.Modal.getInstance(elemento).close();
                }
            });
        });

        Dropzone.autoDiscover = false;
        $("#dropzoneAgrupado").dropzone({
            url: "ajax/cargarDocsAgrupado.php",
            paramName: "fileUpLoadDigital", // The name that will be used to transfer the file
            autoProcessQueue: false,
            maxFiles: 10,
            acceptedFiles: ".jpg, .jpeg, .png, .pdf, .doc, .docx, .xls,.xlsx, .ppt, .pptx",
            addRemoveLinks: true,
            maxFilesize: 1200, // MB
            uploadMultiple: true,
            parallelUploads: 10,
            dictDefaultMessage: "Arrastar y Soltar tus archivos aquí o<br>click a subir...",
            dictInvalidFileType: "Archivo no válido",
            dictMaxFilesExceeded: "Solo 10 archivos son permitidos",
            dictCancelUpload: "Cancelar",
            dictRemoveFile: "Remover",
            dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MiB). Máximo permitido: {{maxFilesize}}MB.",
            dictFallbackMessage: "Tu navegador no soporta  drag 'n' drop .",
            dictCancelUploadConfirmation: "¿Está seguro de cancelar esta subida?",
            accept: function (file, done) {
                let estado = false;
                let data = tblAnexos.data();
                $.each(data, function (i, item) {
                    if (file.name == item.nombreAnexo) {
                        estado = true;
                    }
                });
                if (!estado) {
                    done();
                } else {
                    done("El anexo ya está agregado");
                    $.alert("El anexo" + file.name +" ya está agregado");
                    this.removeFile(file);
                }
            },
            init: function () {
                var myDropzone = this;
                $("#btnSubirDocsAgrupado").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    queuedFiles = myDropzone.getQueuedFiles();
                    if (queuedFiles.length > 0) {
                        event.preventDefault();
                        event.stopPropagation();
                        myDropzone.processQueue();
                    }else{
                        $.alert('¡No hay documentos para subir al sistema!');
                    }
                });

                $("#btnValidacionAgregar").on("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if(validarFormulario()){
                        let queuedFiles = myDropzone.getQueuedFiles();
                        if (queuedFiles.length > 0) {
                            $.alert('¡Documentos pendientes de subir!');
                        }else{
                            ListarResponsableFirma($("#cCodTipoDoc").val());
                            let elemento = document.querySelector('#modalResponsableFirma');
                            M.Modal.getInstance(elemento).open();
                        }
                    }
                });

                $("#btnGuardarCambios").on('click',function (e) {
                    e.preventDefault();
                    if(validarFormulario()){
                        let queuedFiles = myDropzone.getQueuedFiles();
                        if (queuedFiles.length > 0) {
                            $.alert('¡Documentos pendientes de subir!');
                        }else{
                            let datos = obtenerDatosFormulario();
                            datos.append("Evento","GuardarDatos");
                            getSpinner('Guardando documento');

                            $.ajax({
                                url: "registerDoc/Documentos.php",
                                method: "POST",
                                data: datos,
                                processData: false,
                                contentType: false,
                                datatype: "json",
                                success: function () {
                                    console.log('Datos guardados correctamente!');
                                    //deleteSpinner();
                                    M.toast({html: "Datos guardados correctamente"});
                                    setTimeout(function(){ window.location = "registroOficina.php?agrupado="+$("#cDocumentosEnTramite").val(); });
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al guardar los cambios!');
                                    deleteSpinner();
                                    M.toast({html: "Error al guardar los cambios"});
                                }
                            });
                        }
                    }
                });
                this.on("sendingmultiple", function (file, xhr, formData) {
                    let agrupado = $("#cDocumentosEnTramite").val();
                    formData.append('agrupado',agrupado);
                });
                this.on("successmultiple", function(file, response) {
                    let json = $.parseJSON(response);
                    $.each(json, function (i,fila) {
                        InsertarAnexo(fila.codigo, fila.original, fila.nuevo);
                    });
                    this.removeAllFiles();
                });
            }
        });

        $("#btnDerivar").on("click", function(e) {
            derivarDocumentos();
        });

        function derivarDocumentos () {
            let filasEnviar = [];
            let paraJefeProyecto = [];
            let paraJefeVisado = [];
            let salir = 0;
            let tabla = tblDocumentos.data();

            $.each(tabla, function (i, filas) {
                if(salir == 1){
                    return false;
                }
                if (sesionPerfil == 18 || sesionPerfil == 19 || sesionPerfil == 20) {
                    if (filas.tipo == 'proyecto'){
                        paraJefeProyecto.push(filas);
                        if (filas.flgDatosDespacho == 0){
                            $.alert('No se puede derivar, falta datos de despacho');
                            salir += 1;
                        }
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
                            } else {
                                if(filas.nFlgEnvio == 0){
                                    filasEnviar.push(filas);
                                }
                            }
                        }
                    } else {
                        if (filas.tipo == 'proyecto'){
                            paraJefeProyecto.push(filas);
                            if (filas.flgDatosDespacho == 0){
                                $.alert('No se puede derivar, falta datos de despacho');
                                salir += 1;
                            }
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
                    $.each(filasEnviar, function (key, fil) {
                        let modelo = new Object();
                        modelo.Evento = "DerivarDestino";
                        modelo.codigo = fil.codigo;
                        modelo.tipoDoc = fil.nFlgTipoDoc;
                        $.ajax({
                            method: "POST",
                            cache: false,
                            url: "registerDoc/Documentos.php",
                            data: modelo,
                            datatype: "json",
                            success: function (response) {
                                console.log('Derivado correctamente!');
                                M.toast({html: "'Derivado correctamente!"});
                            },
                            error: function (e) {
                                console.log(e);
                                console.log('Error al derivar!');
                                M.toast({html: "Error al derivar"});
                            }
                        });
                    });
                } else if (paraJefeVisado.length !== 0) {
                    let modelo = new Object();
                    modelo.Evento = "DerivarJefeVisado";
                    modelo.codigo = paraJefeVisado[0].codigo;
                    $.ajax({
                        method: "POST",
                        cache: false,
                        url: "registerDoc/Documentos.php",
                        data: modelo,
                        datatype: "json",
                        success: function (response) {
                            console.log('Derivado correctamente!');
                            M.toast({html: "'Derivado correctamente!"});
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar"});
                        }
                    });
                } else if (paraJefeProyecto.length !== 0) {
                    let modelo = new Object();
                    modelo.Evento = "DerivarJefeProyecto";
                    modelo.codigos = paraJefeProyecto;
                    $.ajax({
                        method: "POST",
                        cache: false,
                        url: "registerDoc/Documentos.php",
                        data: modelo,
                        datatype: "json",
                        success: function (response) {
                            console.log('Derivado correctamente!');
                            M.toast({html: "'Derivado correctamente!"});
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar"});
                        }
                    });
                } else {
                    let modelo = new Object();
                    modelo.Evento = "DerivarJefeInmediato";
                    modelo.cAgrupado = $("#cDocumentosEnTramite").val();
                    $.ajax({
                        method: "POST",
                        cache: false,
                        url: "registerDoc/Documentos.php",
                        data: modelo,
                        datatype: "json",
                        success: function (response) {
                            console.log('Derivado correctamente!');
                            M.toast({html: "'Derivado correctamente!"});
                        },
                        error: function (e) {
                            console.log(e);
                            console.log('Error al derivar!');
                            M.toast({html: "Error al derivar"});
                        }
                    });
                }
                setTimeout(function(){ window.location = "registroOficina.php"; });
            }
        }

        /*Obtener Documentos Creados */
        function LoadDocumentosEnProceso(){
            //debugger;
            let grupos = new Object();
            grupos.Evento="DocumentosAgrupados";
            $.ajax({
                method: "POST",
                cache: false,
                url: "registerDoc/Documentos.php",
                data: grupos,
                datatype: "json",
                success: function (response) {
                    var data = $.parseJSON(response);
                    $("#cDocumentosEnTramite").empty();
                    $.each(data, function (keys, datos) {
                        $("#cDocumentosEnTramite").append($("<option></option>").val("0").html(".:: Grupo Nuevo ::."));
                        $.each(datos, function (key, entry) {
                            var codigo= <?= $_GET["agrupado"]??"-1" ?>;
                            if(codigo == "0" && key == (datos.length-1) ){
                                $("#cDocumentosEnTramite").append($("<option selected></option>").val(entry['Valor']).html(entry['Texto']));
                            }else
                            if(codigo == entry['Valor']){
                                $("#cDocumentosEnTramite").append($("<option selected></option>").val(entry['Valor']).html(entry['Texto']));
                            }else{
                                $("#cDocumentosEnTramite").append($("<option></option>").val(entry['Valor']).html(entry['Texto']));
                            }
                        });

                    });
                    $('#cDocumentosEnTramite').formSelect();
                    $("#cDocumentosEnTramite").change();
                }
            });
        }

        function loadProyectos(AgrupadoProyectos){
            $.ajax({
                cache: false,
                method: "POST",
                url: "ajax/parametrosPlantilla.php",
                data: {codigo: codTipoDoc},
                datatype: "json",
                success: function (response) {
                    //console.log(response);
                    var res = eval('(' + response + ')');
                    if (res.flag == 1) {
                        console.log('Tiene parametros');
                        const param = eval('(' + res.editables + ')');
                        let htmltext = '';
                        param.forEach(function (valor) {
                            htmltext +="<div class='subtitle'><h3 contenteditable='false' >"+valor+"</h3><div ><p class='clase-par'></p></div></div>"
                        });
                        CKEDITOR.instances.editorOficina.insertHtml(htmltext);
                    } else {
                        console.log('No tiene parametros');
                    }
                }
            });
        }

        $("#cCodTipoDoc").on("change", function (e) {
            e.preventDefault();
            if ($("#cCodigo").val() === '' && $("#cTipo").val() === '') {
                plantilla();
            }

            if($("#cCodTipoTra").val() == '3' && $("#cCodTipoDoc").val() == '13'){
                $("#nombreDestinoExternocol").css("display","none");
                $("#nombreDestinoEntidadMREcol").css("display","block");
                $("#opcionalFields").css("display","none");
            }else{
                ListarOficinaPorDocumento($("#cCodTipoDoc").val());
                $("#nombreDestinoExternocol").css("display","block");
                $("#nombreDestinoEntidadMREcol").css("display","none");
                $("#opcionalFields").css("display","block");
            }
        });

        function plantilla () {
            const codTipoDoc = $('#cCodTipoDoc').val();
            if (CKEDITOR.instances.editorOficina.getData('')) {
                CKEDITOR.instances.editorOficina.setData('');
            }
            $.ajax({
                cache: false,
                method: "POST",
                url: "ajax/parametrosPlantilla.php",
                data: {codigo: codTipoDoc},
                datatype: "json",
                success: function (response) {
                    var res = eval('(' + response + ')');
                    if (res.flag == 1) {
                        console.log('Tiene parametros');
                        const param = eval('(' + res.editables + ')');
                        let htmltext = '';
                        param.forEach(function (valor) {
                            htmltext +="<div class='subtitle'><h3 contenteditable='false' >"+valor+"</h3><div ><p class='clase-par'></p></div></div>"
                        });
                        CKEDITOR.instances.editorOficina.insertHtml(htmltext);
                    } else {
                        console.log('No tiene parametros');
                    }
                }
            });
        }

        function tiposDocumentos(codDoc,selecionado = ''){
            $.ajax({
                cache: 'false',
                url: 'ajax/ajaxTipoDocumento.php',
                method: 'POST',
                data: {tipoDoc: codDoc},
                datatype: 'json',
                success: function (data) {
                    $('#cCodTipoDoc').empty().append('<option value="&nbsp;">Seleccione</option>');
                    let documentos = JSON.parse(data);
                    $.each(documentos, function (key,value) {
                        if (value.codigo == selecionado){
                            $('#cCodTipoDoc').append('<option value="'+value.codigo+'" selected>'+value.nombre+'</option>');
                        } else {
                            $('#cCodTipoDoc').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        }
                    });
                    $('#cCodTipoDoc').formSelect();
                }
            });
        }

        function ImprimirSugerencia(datos){
            let html = '<label>Sugerencia: </label>';
            html += '<span data-id="'+datos.IdEntidad+'" style="cursor: pointer;text-decoration: underline;">'+datos.NombreEntidad+'</span>';
            $('#sugerenciasDestinatario').append(html);
        }

        function SugerenciaDestinatario(embajada = false){
            let tabla = tblDocumentos.data();
            let resultado = Object();
            $.each(tabla, function (i, filas) {
                if (filas.tipo == 'tramite' && filas.nFlgTipoDoc == 1){
                    resultado.existe = true;
                    resultado.IdRemitente = filas.IdRemitente;
                }
            });

            if (resultado.existe){
                if(!embajada){
                    ObtenerDatosEntidad(resultado.IdRemitente,ImprimirSugerencia);
                }                
                $('#sugerenciasDestinatario').css('display','block');
            } else {
                $('#sugerenciasDestinatario').css('display','none').empty();
            }
        }

        function formularioTipoDestinatario(tipoDestino){
            if(tipoDestino == 3) {                
                SugerenciaDestinatario();
                $('#destinoExterno').css('display','block');
                $('#destinatario').css('display','none');
            } else {
                $('#destinoExterno').css('display','none');
                $('#destinatario').css('display','block');
            }
        }

        $("#sugerenciasDestinatario").on("click", "span", function (e) {
            let valor = $(this).attr("data-id");
            let text =  $(this).text();
            let newOption = new Option(text, valor, false, false);
            //$('#nombreDestinoExterno').empty().trigger('change');
            //$('#nombreDestinoExterno').val(null).trigger('change');
            $('#nombreDestinoExterno').empty().append(newOption).trigger('change').trigger('select2:select');
            $('#sugerenciasDestinatario').css('display','none').empty();
        });

        $('select[name="cCodTipoTra"]').on('change',function (e) {
            let docvalor = $('select[name="cCodTipoTra"]').val();
            formularioTipoDestinatario(docvalor);
            e.preventDefault();
            tiposDocumentos(docvalor);
        });



        //SI ES PARA ESPECIALISTA O NO
        $('#flgDelegar').on('change',function (e) {
            e.preventDefault();
            if(!$('#Proyecto').is(':checked')) {
                if ($(this).is(':checked')) {
                    $('#destinatario #areaOficina #paraOficinas').css('display', 'none');
                    $('#destinatario #areaOficina #paraEspecialistas').css('display', 'block');
                } else {
                    $('#destinatario #areaOficina #paraEspecialistas').css('display', 'none');
                    $('#destinatario #areaOficina #paraOficinas').css('display', 'block');
                }
            } else {
                $.alert({
                    title: 'Advertencia!',
                    content: 'No se puede enviar proyectos a especialistas'
                });
                $(this).prop('checked', false);
            }
        });

        // CARGA REPSONSABLE OFICINA
        $("#iCodOficinaFirma").on("change",function (e) {
            $("#iCodOficinaFirma").formSelect();
            e.preventDefault();
            if($("#iCodOficinaFirma").val() !== ''){
                obtenerResponsable('#iCodOficinaFirma','#iCodTrabajadorFirma','#nomResponsableFirmar');
                $("#iCodPerfilFirma").val(3);
            }
        });

        $("#codOficinaDevolver").on("change",function (e) {
            e.preventDefault();
            $.ajax({
                url: "ajax/ajaxTrabajadorVisto.php",
                method: "POST",
                data: {
                    codOficina: $("#codOficinaDevolver").val()
                },
                datatype: "json",
                success: function (response) {
                    $("#codEspecialistaDevolver").empty();
                    let data = $.parseJSON(response);
                    $.each(data,function (key,value) {
                        $('#codEspecialistaDevolver').append('<option value="'+value.cod+'">'+value.texto+'</option>');
                    });
                    let elemTraVis = document.getElementById('codEspecialistaDevolver');
                    M.FormSelect.init(elemTraVis, {dropdownOptions: {container: document.body}});
                }
            });
        });

        $("#btnDevolver").on("click",function (e) {
            e.preventDefault();
            M.Modal.getInstance($("#modalDevolver")).open();
        });

        $("#btnEnvioDevolver").on("click", function (e) {
            e.preventDefault();
            if($("#codEspecialistaDevolver").val() === '') {
                $.alert("Falta selecionar especialista para el visado!")
            } else {
                $.confirm({
                    title: '¿Está seguro de querer devolver el grupo?',
                    content: '',
                    buttons: {
                        Si: function () {
                            $.ajax({
                                url: "registerDoc/Documentos.php",
                                method: "POST",
                                data: {
                                    Evento: 'Devolver',
                                    cTrabajadorDevolver: $("#codEspecialistaDevolver").val(),
                                    obsDevolver: $("#obsDevolver").val(),
                                    cAgrupado: $("#cDocumentosEnTramite").val(),
                                    cOficinaDevolver: $("#codOficinaDevolver").val()
                                },
                                datatype: "json",
                                success: function (response) {
                                    console.log('Documentos enviados correctamente!');
                                    M.Modal.getInstance($("#modalDevolver")).close();
                                    M.toast({html: "Documentos enviados"});
                                    setTimeout(function () { window.location = "registroOficina.php?agrupado="+$("#cDocumentosEnTramite").val(); });
                                },
                                error: function (e) {
                                    console.log(e);
                                    console.log('Error al enviar el grupo!');
                                    M.toast({html: "Error al enviar el grupo!"});
                                }
                            });
                        },
                        No: function () {
                            $.alert('Envío cancelado!');
                        }
                    }
                });
            }
        });

        $("#btnArchivar").on("click", function (e) {
            e.preventDefault();
            M.Modal.getInstance($("#modalArchivar")).open();
        });

        $("#btnEnviarArchivar").on('click', function(e) {
            e.preventDefault();
            parametros = {
                iCodAgrupado: $("#cDocumentosEnTramite").val(),
                cObservacionesArchivar : $('#motArchivar').val()
            };
            $.ajax({
                cache: false,
                url: "ajax/ajaxArchivarRegOfi.php",
                method: "POST",
                data: parametros,
                datatype: "json",
                success : function (response) {
                    M.toast({html: '¡Grupo archivado!'});
                    setTimeout(function(){ window.location = 'registroOficina.php' })
                },
                error: function (response) {
                    console.log(e);
                    console.log('Error al archivar el grupo!');
                    M.toast({html: "Error al archivar"});
                }
            });
        });

        $("#btnRetroceder").on("click", function (e) {
            e.preventDefault();
            parametros = {
                iCodAgrupado: $("#cDocumentosEnTramite").val()
            };
            $.ajax({
                cache: false,
                url: "ajax/ajaxRetrocederMovimiento.php",
                method: "POST",
                data: parametros,
                datatype: "json",
                success : function () {
                    setTimeout(function(){ window.location = "registroOficina.php"; })
                },
                error: function (e) {
                    console.log(e);
                    console.log('Error al archivar el grupo!');
                    M.toast({html: "Error al archivar"});
                }
            });
        });

        $("#btnCerrarDocFirmado").on("click", function (e) {
            e.preventDefault();
            $.confirm({
                title: '¿Desea derivar o continuar trabajando?',
                content: '',
                buttons: {
                    Derivar: function () {
                        derivarDocumentos();
                    },
                    Continuar: function () {
                        tblDocumentos.ajax.reload();
                        let elem = document.querySelector('#modalDocFirmado');
                        let instance = M.Modal.init(elem, {dismissible:false});
                        instance.close();
                        setTimeout(function(){ window.location = "registroOficina.php?agrupado="+$("#cDocumentosEnTramite").val(); });
                    }
                }
            });
        });

        /*function ContenidosTipo(idDestino, codigoTipo){
            $.ajax({
                cache: false,
                url: "ajax/ajaxContenidosTipo.php",
                method: "POST",
                data: {codigo: codigoTipo},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    let destino = $("#"+idDestino);
                    destino.empty();
                    $.each(data, function( key, value ) {
                        destino.append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                    });
                    var elem = document.getElementById(idDestino);
                    M.FormSelect.init(elem, {dropdownOptions: {container: document.body}});
                }
            });
        }*/

        $('#IdTipoEnvio').on('change', function (e) {
            if ($('#IdTipoEnvio').val() === '19' || $('#IdTipoEnvio').val() === '21') {
                $('#datosEnvioFisico').css('display','block');
                $('#datosEnvioInteroperabilidad').css('display','none');
            } else if ($('#IdTipoEnvio').val() === '20') {
                $('#datosEnvioFisico').css('display','none');
                $('#datosEnvioInteroperabilidad').css('display','none');
            } else if ($('#IdTipoEnvio').val() === '72') {
                $('#datosEnvioFisico').css('display','none');
                $('#datosEnvioInteroperabilidad').css('display','block');
            }
        });

        $('#DepartamentoDespacho').on('change',function (e) {
            e.preventDefault();
            if ($('#DepartamentoDespacho').val() !== ''){
                $.ajax({
                    cache: false,
                    async: false,
                    url: "ajax/ajaxProvincias.php",
                    method: "POST",
                    data: {codDepa : $('#DepartamentoDespacho').val()},
                    datatype: "json",
                    success: function (data) {
                        data = JSON.parse(data);
                        $('#ProvinciaDespacho').empty().append('<option value="">Seleccione</option>');
                        $.each( data.info, function( key, value ) {
                            $('#ProvinciaDespacho').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        var elempro = document.getElementById('ProvinciaDespacho');
                        M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
                        $('#DistritoDespacho').empty();
                        var elempro = document.getElementById('DistritoDespacho');
                        M.FormSelect.init(elempro, {dropdownOptions: {container: document.body}});
                    }
                });
            }
        });

        $('#ProvinciaDespacho').on('change',function (e) {
            e.preventDefault();
            if ($('#ProvinciaDespacho').val() !== '' && $('#DepartamentoDespacho').val() !== ''){
                $.ajax({
                    cache: false,
                    async: false,
                    url: "ajax/ajaxDistritos.php",
                    method: "POST",
                    data: {codDepa : $('#DepartamentoDespacho').val(), codPro: $('#ProvinciaDespacho').val()},
                    datatype: "json",
                    success: function (data) {
                        data = JSON.parse(data);
                        $('#DistritoDespacho').empty().append('<option value="">Seleccione</option>');
                        $.each( data.info, function( key, value ) {
                            $('#DistritoDespacho').append('<option value="'+value.codigo+'">'+value.nombre+'</option>');
                        });
                        var elemdis = document.getElementById('DistritoDespacho');
                        M.FormSelect.init(elemdis, {dropdownOptions: {container: document.body}});
                    }
                });
            }
        });

        function ListarOficinaEspecialistasDestino() {
            $.ajax({
                cache: false,
                url: "ajax/ajaxListarOficinas.php",
                method: "POST",
                data: {'Evento' : 'ListarOficinasEspecialistasDestino'},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#nomOficinaE').empty();
                    $.each(data, function(key, value) {
                        $('#nomOficinaE').append('<option value="'+value.idOficina+'">'+value.nomOficina+'</option>');
                    });
                    $('#nomOficinaE').formSelect().trigger('change');
                }
            });
        }

        function ListarOficinaPorDocumento(tipoDocumento) {
            $.ajax({
                cache: false,
                url: "ajax/ajaxListarOficinas.php",
                method: "POST",
                data: {'Evento' : 'ListarOficinasDocumento', 'IdTipoDocumento': tipoDocumento},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#iCodOficinaO').empty().append('<option value="">Seleccione Oficina</option>');
                    $.each(data, function(key, value) {
                        $('#iCodOficinaO').append('<option value="'+value.idOficina+'">'+value.nomOficina+'</option>');
                    });
                    $('#iCodOficinaO').formSelect().trigger('change');
                }
            });
        }

        function ListarResponsableFirma(tipoDocumento) {
            $.ajax({
                cache: false,
                url: "ajax/ajaxListarOficinas.php",
                method: "POST",
                data: {'Evento' : 'ListarOficinaResponsableFirma', 'IdTipoDocumento': tipoDocumento},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#iCodOficinaFirma').empty();
                    $.each(data, function(key, value) {
                        $('#iCodOficinaFirma').append('<option value="'+value.IdOficina+'">'+value.NomOficina+'</option>');
                    });
                    $('#iCodOficinaFirma').formSelect().trigger('change');
                }
            });
        }

        $('#nomOficinaE').on('change', function (e) {
            e.preventDefault();
            var idOficina = $('#nomOficinaE').val();
            $('#CodOficinaE').val(idOficina);
            $.ajax({
                cache: false,
                url: "ajax/ajaxTrabajador.php",
                method: "POST",
                data: {'Evento' : 'ListarTrabajadoresPorOficina', 'idOficina': $('#CodOficinaE').val()},
                datatype: "json",
                success: function (data) {
                    data = JSON.parse(data);
                    $('#responsableE').empty().append('<option value="">Seleccione</option>');;
                    $.each(data, function(key, value) {
                        $('#responsableE').append('<option value="'+value.idTrabajador+'">'+value.nomTrabajador+' ( '+ value.nomPerfil +' )</option>');
                    });
                    $('#responsableE').formSelect();
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