<div class="form-group">
    <p class="lead">Estimado, <strong><span id="nombreRemitente"></span></strong>, por favor lea cuidadosamente los datos ingresados y
        valide el envio de su documento a la Mesa de partes digital de APCI.</p>
</div>

<div class="form-group border-bottom mt-5 text-primary">
    <legend class="overline">Datos del remitente</legend>
</div>

<div class="row">
    <div class="col">
        <div class="form-group row" id="rucValidacion">
            <label for="stNumRuc" class="col-sm-4 col-form-label">RUC</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stNumRuc" value="">
            </div>
        </div>
        <div class="form-group row">
            <label for="stNumDocPer" class="col-sm-4 col-form-label">DNI</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stNumDocPer" value="">
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group row" id="denominacionValidacion">
            <label for="stDen" class="col-sm-4 col-form-label">Denominación</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stDen"
                    value="Caritas Arquidiocesana de Huancayo">
            </div>
        </div>
        <div class="form-group row">
            <label for="stNombrePer" class="col-sm-4 col-form-label">Nombre completo</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stNombrePer" value="">
            </div>
        </div>
    </div>
</div>

<div class="form-group border-bottom mt-5 text-primary sigctiValidacion">
    <legend class="overline">Datos del documento</legend>
</div>

<div class="row sigctiValidacion">
    <div class="col">
        <div class="form-group row" id="cudTraIniciadoValidacion">
            <label for="stNumCud" class="col-sm-4 col-form-label">Nº de CUD existente</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stNumCud" value="">
            </div>
        </div>
        <div class="form-group row">
            <label for="stDoc" class="col-sm-4 col-form-label">Documento</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stDoc" value="">
            </div>
        </div>
        <div class="form-group row">
            <label for="stAsuDoc" class="col-sm-4 col-form-label">Asunto del documento</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stAsuDoc"
                    value="">
            </div>
        </div>
    </div>

    <div class="col">
        <div class="form-group row">
            <label for="stFecDoc" class="col-sm-4 col-form-label">Fecha de documento</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stFecDoc" value="">
            </div>
        </div>
        <div class="form-group row">
            <label for="stNumFol" class="col-sm-4 col-form-label">Folios</label>
            <div class="col-sm-8">
                <input type="text" readonly class="form-control-plaintext" id="stNumFol" value="">
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col">
        <label for="txtCodigoValidacion">Código Validación enviado al correo registrado.</label>
            <input class="form-control" id="txtCodigoValidacion" type="text" required>
        </div>
    </div>
</div>

<div class="form-group mt-5 text-center">
    <button class="btn btn-light mt-5" onclick="stregistroDoc.previous()">Anterior</button>
    <button class="btn btn-secondary-light mt-5" type="submit" id="btnEnviar">Enviar</button>
</div>

<!-- Modal -->
<div class="modal fade" id="modalConfirmacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmacionLabel">Confirmación de Registro de Mesa de partes digital</h5>                
            </div>
            <div class="modal-body">
            <p>Su documento ha sido registrado satisfactoriamente, se le enviará un correo de confirmación cuando haya sido recepcionado.<p>
            </div>
            <div class="modal-footer">
                <a href="index.php" class="btn btn-light">Cerrar</a>
            </div>
        </div>
    </div>
</div>