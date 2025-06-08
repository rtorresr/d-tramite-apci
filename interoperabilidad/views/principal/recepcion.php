<div id="dinamicStyle"></div>
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
                                <li id="btnPendientesRecibir" class="tab col s4"><a class="active" href="#pendientesRecibir">Pendientes de Recibir</a></li>
                                <li id="btnPendientesEnvioCargo" class="tab col s4"><a href="#pendientesEnvioCargo">Pendientes envio Cargo</a></li>
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
    <div class="modal-content"></div>
    <div class="modal-footer"></div>
</div>
<script src="<?=URLPAGE?>interoperabilidad/views/principal/recepcion.js"></script>
<script src="<?=URLPAGE?>/interoperabilidad/core/Documento.js"></script>
<div id="dinamicScript"></div>