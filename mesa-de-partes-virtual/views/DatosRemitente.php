<form id="FormRemitente">
    <?php if (isset($_POST["tipoPersona"])){ ?>
        <input type="hidden" id="idTipoPersona" value="<?=$_POST["tipoPersona"]?>">
    <?php } ?>
    <div class="form-group border-bottom juridica"> 
        <legend class="overline">Datos de la empresa/institución</legend>
    </div>
    <?php if (!isset($_POST["tipoPersona"])){ ?>
        <div class="form-group mb-5">            
            <div class="row">
                <div class="col-4">
                    <label for="txtTipoDoc">Tipo de Remitente</label>
                    <select class="form-control" id="idTipoPersona" name="idTipoPersona" required>
                        <option value="">Seleccione</option>
                        <option value="60">Persona Natural</option>
                        <option value="62">Persona Jurídica</option>
                    </select>
                    <div class="invalid-feedback">
                        Por favor, seleccione un tipo de remitente.
                    </div>
                </div>
            </div>            
        </div>
    <?php } ?>
    <div class="form-group mb-5 juridica">
        <div class="row">
            <input type="hidden" id="idTipoDocPersonaJuridica" value="74">
            <div class="col-4">
                <label for="txtRUC">RUC</label>
                <div class="input-group">
                    <input class="form-control" id="txtRUC" type="text" placeholder="Ej. 10776565652" required>
                    <div class="input-group-append">
                        <button class="btn" type="button" id="buscarRUC"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="invalid-feedback">
                        Por favor, ingrese el RUC de la entidad.
                    </div>
                </div>
            </div>
            <div class="col" id="htmlDenS">
                <label for="txtDenInst">Denominación</label>
                <input class="form-control" id="txtDenInst" type="text" placeholder="Ej. Caritas Arquidiocesana de Huancayo" disabled="disabled">
            </div>
        </div>
    </div>
    <div class="form-group border-bottom"> 
        <legend class="overline" id="cabeceraLegenDatosRemitente">Datos</legend>
    </div>
    <div class="form-group">
        <div class="row"> 
            <div class="col-2">
                <label for="txtTipoDoc">Tipo de documento</label>
                <select class="form-control" id="txtTipoDoc" name="txtTipoDoc" required></select>
                <div class="invalid-feedback">
                    Por favor, seleccione un tipo de documento.
                </div>
            </div>
            <div class="col-3">
            <label for="txtNumDocEntidad">Número de documento</label>
            <div class="input-group">
                <input class="form-control" id="txtNumDocEntidad" type="text" placeholder="Ej. 77656565" required>
                <div class="input-group-append">
                <button type="button" class="btn" id="buscarDNI"><i class="fas fa-search"></i></button>
                </div>
                <div class="invalid-feedback">
                Por favor, ingrese el número de documento.
                </div>
            </div>
            </div>
            <div class="col" id="htmlNombreR">
                <label for="txtNombComp">Nombre completo</label>
                <input class="form-control" id="txtNombComp" type="text" placeholder="Ej. JUAN SOTO SANCHEZ" disabled="disabled" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"> 
            <div class="col" id="htmlDireccionR">
                <label for="txtDireccion">Dirección</label>
                <input class="form-control" id="txtDireccion" type="text" placeholder="Ej. Calle Los Girasoles 123 Int. 11, Piso 4" required>
                <div class="invalid-feedback">
                    Por favor, ingrese la dirección.
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"> 
            <div class="col">
            <label for="txtDep">Departamento</label>
            <select class="form-control" id="txtDep" name="txtDep" required> 
                <option value="">Seleccione</option>
            </select>
            <div class="invalid-feedback">
                Por favor, seleccione un departamento.
            </div>
            </div>
            <div class="col">
            <label for="txtProv">Provincia</label>
            <select class="form-control" id="txtProv" name="txtProv" required> 
                <option value="">Seleccione</option>
            </select>
            <div class="invalid-feedback">
                Por favor, seleccione una provincia.
            </div>
            </div>
            <div class="col">
            <label for="txtDis">Distrito</label>
            <select class="form-control" id="txtDis" name="txtDis" required> 
                <option value="">Seleccione</option>
            </select>
            <div class="invalid-feedback">
                Por favor, seleccione un distrito.
            </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row"> 
            <div class="col">
            <label for="txtTel">Teléfono</label>
            <input class="form-control numero" minlength="9" maxlength="9" id="txtTel" type="tel" placeholder="Ej. 944065761" required>
            <div class="invalid-feedback">
                Por favor, ingrese un teléfono.
            </div>
            </div>
            <div class="col">
            <label for="txtCorreo">Correo</label>
            <input class="form-control" id="txtCorreo" type="email" placeholder="Ej. juan.soto@gmail.com" aria-describedby="emailHelp" required>
            <div class="invalid-feedback">
                Por favor, ingrese su correo electrónico.
            </div>
            </div>
            <div class="col">
            <label for="txtCorreoConf">Confirme correo</label>
            <input class="form-control" id="txtCorreoConf" type="email" placeholder="Ej. juan.soto@gmail.com" aria-describedby="emailHelp" required>
            <div class="invalid-feedback">
                Por favor, confirme su correo electrónico.
            </div>
            </div>
        </div>
    </div>
    <div class="form-group mt-5 text-center">
        <button class="btn btn-secondary-light" id="primerBoton">Siguiente</button>
    </div>
</form>