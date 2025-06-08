<div class="navbar-fixed actionButtons">
    <nav>
        <ul id="nav-mobile"><div id="actionBtns"></div><div id="supportBtns"></div></ul>
    </nav>
</div>
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card">
                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li id="btnPendientesEnviar" class="tab col s4"><a class="active" href="#pendientesEnviar">Pendientes de envío</a></li>
                                <li id="btnPendientesCargo" class="tab col s4"><a href="#pendientesCargo">Pendientes de cargo</a></li>
                                <li id="btnPendientesDevolver" class="tab col s4"><a href="#pendientesDevolver">Pendientes de Devolver</a></li>
                            </ul>
                        </div>
                        <div id="tablas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="multiModal" class="modal modal-fixed-header modal-fixed-footer">
    <div class="modal-header"></div>
    <div class="modal-content" style="overflow: hidden;"></div>
    <div class="modal-footer"></div>
</div>
<script src="<?=URLPAGE?>interoperabilidad/views/principal/despacho.js"></script>
<script src="<?=URLPAGE?>/interoperabilidad/core/Documento.js"></script>
<div id="dinamicScript"></div>