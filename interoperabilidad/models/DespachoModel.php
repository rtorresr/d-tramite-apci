<?php

class DespachoModel extends ModeloBase
{
    public $fila;
    public $sIdemiext;
    public $idTramite;
    public $cud;
    public $siglasOfi;
    public $entDestino;
    public $documento;
    public $asunto;
    public $fecRegistro;
    public $ruc;
    public $oficina;
    public $tipoDocIdenRem;
    public $docIdenRem;
    public $numDoc;
    public $fecDoc;
    public $ofiDestino;
    public $perDestino;
    public $cargPerDestino;
    public $tipoDoc;
    public $foliosDoc;
    public $numAnexos;
    public $urlAnexos;
    public $jsonAnexos;
    public $arrayAnexos;
    public $docBase64;
    public $fecEnvio;
    public $fecRecepcion;
    public $cargoBase64;
    public $idCargo;
    public $estado;
    public $observacion;
    public $cuo;
    public $idSesion;
    public $ruta;
    public $idEntidad;

    public function listarPendientesEnvio(){
        $nomStore = "[INTEROPERABILIDAD].[UP_LISTAR_PENDIENTES_ENVIO]";
        return $this->ejecutar($nomStore);
    }

    public function obtenerDatosParaEnvio($datos){
        $nomStore = "[INTEROPERABILIDAD].[UP_DATOS_PARA_ENVIO]";
        return $this->ejecutar($nomStore, $datos);
    }

    public function actualizarPendienteEnvio($datos){
        $nomStore = "[INTEROPERABILIDAD].[UP_ACTUALIZAR_DESPACHO_ENVIADO]";
        return $this->ejecutar($nomStore, $datos);
    }

    public function listarPendientesCargo(){
        $nomStore = "[INTEROPERABILIDAD].[UP_LISTAR_PENDIENTES_CARGO]";
        return $this->ejecutar($nomStore);
    }

    public function listarPendientesDevolver(){
        $nomStore = "[INTEROPERABILIDAD].[UP_LISTAR_PENDIENTES_DEVOLVER]";
        return $this->ejecutar($nomStore);
    }

    public function obtenerCargoPide(){
        $parametros = array($this->sIdemiext);
        $nomStore = "[INTEROPERABILIDAD].[UP_OBTENER_CARGO_DESPACHO]";
        return $this->ejecutar($nomStore, $parametros);
    }

    public function retornarCargo(){
        $parametros = array(
            $this->sIdemiext,
            $this->idCargo,
            $this->observacion,
            $this->idSesion
        );
        $nomStore = "[INTEROPERABILIDAD].[UP_RETORNAR_CARGO]";
        return $this->ejecutar($nomStore, $parametros);
    }
}