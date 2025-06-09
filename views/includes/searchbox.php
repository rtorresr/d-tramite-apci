<form id="frmBusquedaCG">
    <div class="row searchMain" style="margin-bottom: 0">
        <div class="col s12">
            <div class="input-field main-field">
                <button id="btnSearchMain" type="button" class="btn-flat btnSearchMain hide-on-small-only">
                    <i class="fas fa-search"></i>
                </button>
                
                <input id="txtAsuntoMain" class="txtAsuntoMain" type="search" required="" placeholder="Consulta general Integrada">

                <button type="button" id="btnAdvanced" class="btn-flat btnAdvanced tooltipped"  data-position="right" data-tooltip="Bùsqueda avanzada">
                    <i class="fas fa-angle-double-down"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="searchForm" class="row searchForm hide">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <fieldset>
                        <div class="row">
                            <div class="col m2 s12">
                                <h6 class="overline">Información del documento</h6>
                            </div>

                            <div class="col m10 s12">
                                <div class="row">
                                    <div class="input-field col s4">
                                        <select id="tipoOrigenCG" name="tipoOrigenCG">
                                            <option value="1" selected>Interno</option>
                                            <option value="2">Externo</option>
                                        </select>
                                        <label>Origen</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <select id="tipoTramiteCG" name="tipoTramiteCG">
                                            <option value="1" selected>Emitido</option>
                                            <option value="2">Proyectado</option>
                                        </select>
                                        <label>Tipo de Trámite</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <select name="estadoTramiteCG">
                                            <option value="" selected>Todos</option>
                                            <option value="1">EN PROCESO/PENDIENTE</option>
                                            <option value="2">DERIVADO</option>
                                            <option value="3">DELEGADO</option>
                                            <!-- <option value="4">RESPONDIDO</option> -->
                                            <option value="5">FINALIZADO</option>
                                            <option value="6">RECHAZADO</option>
                                            <option value="7">CANCELADO</option>
                                            <option value="10">DEVUELTO</option>
                                        </select>
                                        <label>Estado</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <input id="txtCUD" type="text" class="validate" name="txtCUDCG">
                                        <label for="txtCUD">Nùmero de expediente</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <select id="tipoDocumentoCG" name="tipoDocumentoCG">
                                        </select>
                                        <label>Tipo de documento</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <input id="txtNumDoc" type="text" class="validate" name="txtNumDocCG">
                                        <label for="txtNumDoc">Nùmero de documento</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="txtAsunto" type="text" class="validate" name="txtAsuntoCG">
                                        <label for="txtAsunto">Asunto del documento</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="row">
                            <div class="col m2 s12">
                                <h6 class="overline">Informaciòn de envío</h6>
                            </div>

                            <div class="col m10 s12">
                                <div id="envioInterno" class="row">
                                    <div class="input-field col s4">
                                        <select id="oficinaOrigenCG" name="oficinaOrigenCG">
                                        </select>
                                        <label for="oficinaOrigenCG">Oficina</label>
                                    </div>
                                    <div class="input-field col s8">
                                        <select  multiple="multiple" class="browser-default" id="trabajadorOrigenCG" name="trabajadorOrigenCG" disabled="disabled">
                                        </select>
                                        <label for="trabajadorOrigenCG">Trabajador</label>
                                    </div>
                                </div>
                                <div id="envioExterno" class="row hide">
                                    <div class="input-field col s8">
                                        <input type="text" id="remitenteInterno" name="remitenteInterno">
                                        <!-- <select class="browser-default" id="remitenteInterno" name="remitenteInterno">
                                        </select> -->
                                        <label for="remitenteInterno">Remitente</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                    
                    <fieldset>
                        <div class="row">
                            <div class="col m2 s12">
                                <h6 class="overline">Informaciòn de recepciòn</h6>
                            </div>                            
                            <div class="col m10 s12">
                                <div class="row" id="destinoDoc">
                                    <div class="col s12">
                                        <label>
                                            <input class="with-gap" name="rdDestino" type="radio" value="1" checked/>
                                            <span>Interna</span>
                                        </label>
                                        <label>
                                            <input class="with-gap" name="rdDestino" type="radio" value="2" />
                                            <span>Externa</span>
                                        </label>
                                    </div>
                                </div>
                                <div id="recepcionInterno" class="row">                                    
                                    <div class="input-field col s4">
                                        <select id="oficinaDestinoCG" name="oficinaDestinoCG"></select>
                                        <label for="oficinaDestinoCG">Oficina</label>
                                    </div>
                                    <div class="input-field col s8">
                                        <select multiple="multiple" class="browser-default" id="trabajadorDestinoCG" name="trabajadorDestinoCG" disabled="disabled">
                                        </select>
                                        <label for="trabajadorDestinoCG">Trabajador</label>
                                    </div>
                                </div>
                            </div>
                            <div id="recepcionExterno" class="row hide">
                                <div class="input-field col s8">
                                    <input type="text" id="destinoExterno" name="destinoExterno">
                                    <!-- <select class="browser-default" id="destinoExterno" name="destinoExterno">
                                    </select> -->
                                    <label for="destinoExterno">Destino</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="row">
                            <div class="col m2 s12">
                                <h6 class="overline">Informaciòn de fechas</h6>
                            </div>

                            <div class="col m10 s12">
                                <div class="row">
                                    <div class="col s12">
                                        <label>
                                            <input class="with-gap" name="rdFecha" type="radio" value="1" />
                                            <span>Emisión</span>
                                        </label>
                                        <!-- <label>
                                            <input class="with-gap" name="rdFecha" type="radio"  />
                                            <span>Recepción</span>
                                        </label> -->
                                        <label>
                                            <input class="with-gap" name="rdFecha" type="radio" value="2" checked />
                                            <span>Estado</span>
                                        </label>
                                    </div>
                                    <div id="fecIni" class="input-field col s4">
                                        <input id="txtFecIni" type="text" class="datepicker" name="txtFecIniCG">
                                        <label>Inicio</label>
                                    </div>
                                    <div  id="fecFin" class="input-field col s4 hide">
                                        <input id="txtFecFin" type="text" class="datepicker" name="txtFecFinCG">
                                        <label>Fin</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <select name="anioCG">
                                            <option value="">TODOS</option>
                                            <?php
                                                $anioActual = (int)date("Y");
                                                $anioBase = 2019;
                                                $contador = $anioActual - 1;
                                                echo "<option value='$anioActual'>Año actual</option>";
                                                while ($anioBase != $contador){
                                                    echo "<option value='$contador'>$contador</option>";
                                                    $contador = $contador - 1;
                                                }
                                                echo "<option value='$anioBase'>$anioBase</option>"
                                            ?>
                                        </select>
                                        <label>Periodo</label>
                                    </div>
                                    <div class="col s12">
                                        <label>
                                            <input type="checkbox" class="filled-in" id="flgRango" name="flgRango" value="1" />
                                            <span>Rango de fechas</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </div>
                <div class="card-action right-align">
                    <button id="btnSearch" type="button" class="btn btn-primary">Buscar</button>
                    <button id="btnClear" type="button" class="btn btn-link btn-flat">Limpiar</button>
                </div>
            </div>
        </div>
    </div>
</form>
