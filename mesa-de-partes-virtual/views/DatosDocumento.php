<form id="FormDocumento">

<div class="form-group border-bottom"> 
        <legend class="overline">Datos del documento</legend>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-5">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="chxSigcti">
                    <label class="form-check-label" for="chxSigcti">Para trámites iniciados en la plataforma SIGCTI</label>
                </div>
            </div>

            <div class="col-7" id="nroSigcti" style="display: none">
                <label for="txtNumSolicitudSigcti">Número de la solicitud</label>
                <input class="form-control" id="txtNumSolicitudSigcti" type="text"
                    placeholder="Ej. 00234-2021">
                <div class="invalid-feedback">
                Por favor, ingrese el número de la solicitud.
                </div>
                <small class="form-text text-muted">El número se encuentra en la esquina superior derecha del documento.</small>
                <small class="form-text text-muted">Recuerde adjuntar la solicitud firmada como documento principal.</small>
            </div>
        </div>
    </div>    

    <div class="form-group sigcti">
        <div class="row">
            <div class="col-6">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="cboCudExist" onclick="cudExistente()">
                    <label class="form-check-label" for="cboCudExist">Cuento con un expediente (CUD) y
                        continuaré un trámite ya iniciado</label>
                </div>
            </div>

            <div class="col-3" id="nroExp">
                <label for="txtNumCud">Número de expediente</label>
                <input class="form-control" id="txtNumCud" type="text"
                    placeholder="Ej. 01234">
                <div class="invalid-feedback">
                Por favor, ingrese el número del expediente.
                </div>
            </div>

            <div class="col-3" id="anioExp">
                <label for="txtAnioCud">Año de expediente</label>
                <select class="form-control" id="txtAnioCud" name="txtAnioCud" >
                    <?php 
                    $anioBase = 2019;
                    $anioActual = date("Y");
                    for($i = $anioActual; $i >= $anioBase ;$i--){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                </select>
                <div class="invalid-feedback">
                Por favor, ingrese el año del expediente.
                </div>
            </div>
        </div>
    </div>

    <div class="form-group sigcti">
        <div class="row">
            <div class="col">
                <label for="txtClaseProc">Nuevos trámites</label>
                <select class="form-control" id="txtClaseProc" name="txtClaseProc" onChange="docTupa()">
                    <option value="5">Procedimientos y Trámites administrativos</option>
                    <option value="4">Otros trámites</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group sigcti" id="docTupa"> 
        <div class="row">
            <div class="col">
                <label for="txtDenProc">Seleccione Trámite</label>
                <select class="form-control" id="txtDenProc" name="txtDenProc">
                    <option value="">Seleccione</option>
                </select>
                <div class="invalid-feedback">
                    Por favor, seleccione un trámite
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-warning text-left" role="alert" id="formNuevoTipo" style="display:none">
        <div class="row">
            <div class="col-12">
                Estimado usuario, ingrese el trámite que quiere solicitar que no se encuentra en la lista anterior:
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-8">
                <label for="txtTipoNuevoTramite">Nuevo Tipo de Trámite</label>
                <input class="form-control" id="txtTipoNuevoTramite" type="text">
            </div>
            <div class="col-4">
                <label for="fileArchivoPrincipalNuevoTipo">Archivo principal</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="fileArchivoPrincipalNuevoTipo" accept="application/pdf">
                    <label class="custom-file-label" for="fileArchivoPrincipalNuevoTipo">Seleccionar Archivo</label>
                </div>
            </div>            
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <strong>El documento Adjunto NO significa la Recepción de la Presentación de documentos a la APCI</strong>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                Una vez validado se le notificará para su continuación con el registro de la solicitud del trámite.
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3 text-center">
                <button id="btnEnviarSolicitudNuevoTramite" class="btn btn-secondary-light">Enviar</button>
            </div>
        </div>
    </div>

    <div class="form-group sigcti tupa">
        <div class="row">
            <div class="col-2">
                <label for="txtTipoDocumento">Tipo de documento</label>
                <select class="form-control" id="txtTipoDocumento" name="txtTipoDocumento" required>
                    <option value="">Seleccione </option>
                    <?php
                    include_once("../conexion/conexion.php");
                    $sqlTipo="SELECT cCodTipoDoc,cDescTipoDoc FROM Tra_M_Tipo_Documento WITH(NOLOCK) WHERE nFlgEntrada= 1 ORDER BY cDescTipoDoc ASC";
                    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                        echo "<option value=".trim($RsTipo["cCodTipoDoc"]).">".trim($RsTipo["cDescTipoDoc"])."</option>";
                    }
                    sqlsrv_free_stmt($rsTipo);
                    ?>
                </select>
                <div class="invalid-feedback">
                Por favor, ingrese el tipo del documento.
                </div>
            </div>
            <div class="col-3">
                <label for="txtNumDoc">Número de documento</label>
                <input class="form-control" id="txtNumDoc" type="text" placeholder="Ej. 123-2021/ABC" required>
                <div class="invalid-feedback">
                Por favor, ingrese el número del documento.
                </div>
            </div>
            <div class="col-3">
                <label for="txtFecDoc">Fecha del documento</label>
                <input class="form-control date" type="text" name="txtFecDoc" id="txtFecDoc" required>
                <div class="invalid-feedback">
                Por favor, ingrese la fecha del documento.
                </div>
            </div>
            <div class="col-2">
                <label for="intFilios">Folios</label>
                <input class="form-control" type="number" name="intFilios" id="intFilios" min="1" required>
                <div class="invalid-feedback">
                Por favor, ingrese el número de folios del documento.
                </div>
            </div>
        </div>
    </div>

    <div class="form-group sigcti tupa">
        <div class="row">
            <div class="col">
                <label for="txtAsunto">Asunto del documento</label>
                <input class="form-control" id="txtAsunto" type="text"
                    placeholder="Ej. Solicitud de información" required>
                <div class="invalid-feedback">
                Por favor, ingrese el asunto del documento.
                </div>
            </div>
        </div>
    </div>

    <div class="form-group border-bottom mt-5 tupa"> 
        <legend class="overline">Archivos del documento</legend>
    </div>

    <div class="form-group tupa">
        <div class="row">
            <div class="col">
                <label for="archivoPrincipal">Archivo principal</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="archivoPrincipal" lang="es" required accept="application/pdf">
                    <label class="custom-file-label" for="archivoPrincipal">Seleccionar Archivo</label>
                    <div class="invalid-feedback">
                    Por favor, adjunte el documento principal.
                    </div>
                </div>
                <small id="emailHelp" class="form-text text-muted">Suba aquí el archivo que desea registrar (CARTA, OFICIO, etc).</small>
            </div>
        </div>
        <div class="row subsanacion" style="display: none">
            <div class="col">
                <label>Archivo principal Ingresado</label>
                <table id="tblPrincipal" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Archivo</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>    

    <div class="form-group sigcti tupa" style="display:none" id="docTupaDocumentos">
        <div class="row">
            <div class="col-sm-12" style="width: 100%!important">
                <div class="table-wrapper">
                    <table id="tblDocTupa" style="width: 100%!important; display: none" class="table table-hover table-bordered table-sm w-100">
                        <thead class="thead-light">
                            <tr>
                                <th width="70%">Requisito</th>
                                <th style="text-align: center; width: 30%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <small class="form-text text-muted">Los archivos deben estar en formato .pdf, .xlsx, .docx, .rar, .zip</small>
            </div>
        </div>
    </div>

    <div class="form-group sigcti tupa" id="anexo">
        <div class="row">
            <div class="col">
                <label for="documentoAnexo">Anexos</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="documentoAnexo" lang="es">
                    <label class="custom-file-label" for="documentoAnexo">Seleccionar Archivo</label>
                </div>
                <small class="form-text text-muted">Los archivos deben estar en formato .pdf, .xlsx, .docx, .rar, .zip</small>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-sm" id="tblAnexos" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="70%">Archivo</th>
                            <th width="20%">Tamaño</th>
                            <th style="text-align: center; width: 10%">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group tupa">
        <div class="row subsanacion" style="display: none">
            <div class="col">
                <label>Anexos Ingresados</label>
                <table id="tblAnexosSubsanacion" class="table table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th width="90%">Archivo</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group mt-5 text-center" id="avisoRedireccion" style="display: none"></div>

    <div class="form-group mt-5 text-center" id="botonesSegundoStep">
        <button class="btn btn-light" onclick="stregistroDoc.previous()">Anterior</button>
        <button id="segundoBoton" class="btn btn-secondary-light" onclick="cargarValidacion();">Siguiente</button>
    </div>
</form>