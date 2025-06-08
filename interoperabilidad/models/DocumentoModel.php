<?php

class DocumentoModel extends ModeloBase
{
    public $codigo;
    public $nombre;
    public $url;
    public $urlTemp;
    public $tipo;
    public $tamano;

    public function agregarDocumento(){
        $extension = explode('.', $this->nombre);
        $num = count($extension) - 1;
        $this->tipo = $extension[$num];

        $parametros = array(
            $this->nombre,
            $this->url,
            $this->tipo,
            $this->tamano,
            null,
            null,
            $_SESSION['IdSesion']
        );      
        $nomStore = "[DBO].[UP_INSERTAR_DOC_DIGITAL]";
        return $this->ejecutar($nomStore, $parametros);
    }

    public function enlazarDocumento($idEnlazar, $tipoEnlace){
        $parametros = array(
            $idEnlazar,
            $this->codigo,
            $tipoEnlace,
            $_SESSION['IdSesion']
        );
        $nomStore = "[DBO].[UP_ENLAZAR_DOC_DIGITAL]";
        $this->ejecutar($nomStore, $parametros);
    }

    public function agregarDocumentoVersionAnterior($idEnlazar,$tipoEnlace){
        $parametros = array(
            $idEnlazar,
            0,
            $this->nombre,
            $this->url,
            $tipoEnlace
        );
        $nomStore = "[DBO].[SP_INGRESO_DOCUMENTO_NUEVO]";
        return $this->ejecutar($nomStore, $parametros);
    }
}