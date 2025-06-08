<?php

class RecepcionModel extends ModeloBase
{
    public $fila;
    public $sIdrecext;
    public $idTramite;
    public $cuo;
    public $cud;
    public $documento;
    public $numAnexos;
    public $urlAnexos;
    public $fecDoc;
    public $entRemitente;
    public $uniRemitente;
    public $asunto;
    public $uniDestino;
    public $perDestino;
    public $carDestino;
    public $fecEmision;
    public $idSesion;
    public $docBase64;
    public $urlDoc;
    public $nomUrlDoc;
    public $idOficinaDestino;
    public $stringAnexos;
    public $observacionDoc;
    public $urlCargoDoc;
    public $cargoBase64;

    public function listarPendientesRecibir(){
        $nomStore = "[INTEROPERABILIDAD].[UP_LISTAR_PENDIENTES_RECIBIR]";
        return $this->ejecutar($nomStore);
    }

    public function obtenerDocPide(){
        $parametros = array($this->sIdrecext);
        $nomStore = "[INTEROPERABILIDAD].[UP_OBTENER_DOC_RECEPCION]";
        return $this->ejecutar($nomStore, $parametros);
    }

    public function registrarTramite(){
        $parametros = array(
            $this->sIdrecext,
            $this->idOficinaDestino,
            $this->observacionDoc,
            $this->stringAnexos,
            $this->urlDoc,
            $this->nomUrlDoc,
            $this->idSesion
        );

        $nomStore = "[INTEROPERABILIDAD].[UP_INSERTAR_TRAMITE_SISTEMA]";
        $this->ejecutar($nomStore, $parametros);
    }

    public function listarPendientesEnvioCargo(){
        $nomStore = "[INTEROPERABILIDAD].[UP_LISTAR_PENDIENTES_ENVIO_CARGO]";
        return $this->ejecutar($nomStore);
    }

    public function actualizarCargoFirmado(){
        $parametros = array(
            $this->sIdrecext,
            $this->bcarstd
        );
        $nomStore = "[INTEROPERABILIDAD].[UP_ACTUALIZAR_CARGO_FIRMADO]";
        $this->ejecutar($nomStore, $parametros);
    }

    public function obtenerDatosParaEnvioCargo(){
        $parametros = array(
            $this->sIdrecext
        );
        $nomStore = "[INTEROPERABILIDAD].[UP_OBTENER_DATOS_ENVIO_CARGO]";
        return $this->ejecutar($nomStore, $parametros);
    }

    public function actualizarCargoEnviado(){
        $parametros = array(
            $this->sIdrecext
        );
        $nomStore = "[INTEROPERABILIDAD].[UP_ACTUALIZAR_CARGO_ENVIADO]";
        return $this->ejecutar($nomStore, $parametros);
    }
}