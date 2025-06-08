<?php
class DocDigital
{
    private $clientSoap;
    private $cnxBd;
    private $cnxRepositorio;
    private $visualizador;
    private $ngnix;
    private $descargaAnexo;

    public function __construct($configuracion)
    {
        $this->cnxBd = $configuracion->cnxBd;
        $this->cnxRepositorio = $configuracion->cnxRepositorio;
        $this->visualizador = $configuracion->visualizador;
        $this->ngnix = $configuracion->ngnix;
        $this->descargaAnexo = $configuracion->descargaAnexo;

        $this->clientSoap = new SoapClient($this->cnxRepositorio);
    }

    public function registrarBD($datos){
        $parametros = array(
            $datos->idTramite,
            $datos->nombre,
            $datos->ruta,
            $datos->tipo,
            $datos->agrupado,
            $datos->idRepositorio
        );
        
        $stored = "{CALL UP_INSERTAR_DOC_DIGITAL_TRAMITE (?,?,?,?,?,?)}";

        $rs = sqlsrv_query($this->cnxBd,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
        return $Rs['IdCodDigital'];
    }

    private function cargarDocumento($idDocDigital,$nombre,$rutaDoc,$metadatos){
            $documento = file_get_contents($rutaDoc,true);
            $parametros = array(
                'NombreArchivo' => $nombre,
                'Archivo' => $documento,
                'Cod_Tramite' => $idDocDigital
            );

        if ($metadatos != null){
            $parametros = array_merge($parametros,$metadatos);
        }        

        $servicio =  $this->clientSoap->SubirArchivoPHP($parametros);
        return $servicio->SubirArchivoPHPResult;
    }

    private function enlazarDocDigitalRepositorio($idDocDigital,$idRepositorio){
        $parametros = array(
            $idDocDigital,
            $idRepositorio
        );
        $stored = "{CALL UP_UPDATE_DOC_DIGITAL_REPOSITORIO (?,?)}";

        $rs = sqlsrv_query($this->cnxBd,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    }

    public function obtenerDatosDocDigital($idDocDigital){
        $parametros = array(
            $idDocDigital
        );
        $stored = "{CALL UP_OBTENER_DOC_DIGITAL_DATOS (?)}";

        $rs = sqlsrv_query($this->cnxBd,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

        $resultado = new stdClass();
        $resultado->idTramite = $Rs['IdTramite'];
        $resultado->nombre = trim($Rs['Nombre']);
        $resultado->ruta = $Rs['Ruta'];
        $resultado->tipoDigital = $Rs['TipoDigital'];
        $resultado->agrupado = $Rs['Agrupado'];
        $resultado->idRepositorio = $Rs['IdRepositorio'];

        return $resultado;
    }

    public function subirDocumento($datosBD,$nombre,$rutaDoc,$metadatos = null){
        $datos = $datosBD;
        $datos->nombre = trim($nombre);
        $idDocDigital = $this->registrarBD($datos);
        $idRepositorio = $this->cargarDocumento($idDocDigital,self::generarNombre(trim($nombre)),$rutaDoc,$metadatos);
        $this->enlazarDocDigitalRepositorio($idDocDigital,$idRepositorio);
        $datos = new stdClass();
        return $idDocDigital;
    }

    public function obtenerDocRepositorio($idRepositorio){
        $parametros = array(
            'ID_LF' => $idRepositorio
        );
        $servicio = $this->clientSoap->Descargar($parametros);
        $resultado = $servicio->DescargarResult;
        return $resultado->Archivo;
    }

    public function descargarDocumento($idDocDigital){
        $datos = $this->obtenerDatosDocDigital($idDocDigital);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=".$datos->nombre);
        header("Content-Transfer-Encoding: binary ");

        echo $this->obtenerDocRepositorio($datos->idRepositorio);
    }

    public function obtenerRutaDocDigital($idDocDigital,$tipo = null){
        $datos = $this->obtenerDatosDocDigital($idDocDigital);
        if ($datos->idRepositorio == null){
            $ruta = $this->ngnix.$datos->ruta;  
        } else{
            if ($tipo == null){
                $ruta = $this->visualizador.$datos->idRepositorio;           
            } else{
                $extension = explode('.',$datos->nombre);
                $num = count($extension) - 1;
                if (strtolower($extension[$num]) == 'pdf'){
                    $ruta = $this->visualizador.$datos->idRepositorio;
                } else{
                    $ruta = $this->descargaAnexo.$idDocDigital;
                }                
            }            
        }

        return $ruta;
    }

    public function obtenerDoc($idTramite,$tipo = 0){
        $parametros = array(
            $idTramite,
            $tipo
        );

        $stored = "{CALL SP_CONSULTA_DOCUMENTO_MAYOR (?,?)}";

        $rs = sqlsrv_query($this->cnxBd,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
        
        return $Rs['idDigital'];
    }

    
}