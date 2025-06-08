<?php
require '../core/CURLConection.php';
require_once("../views/clases/DocDigital.php");
require_once("../views/clases/Log.php");

class DocumentoController
{
    private $nginx = NGINX;
    private $php_nginx = PHP_NGINX;    
    
    private function crearUrlDestino($carpeta){
        $nomenclatura = $carpeta.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$_SESSION['iCodOficinaLogin'].'/'.$_SESSION['CODIGO_TRABAJADOR'].'/';
        return $nomenclatura;
    }

    public function subirDocumento($nombre , $documento, $carpeta, $flgBase64 = false){
        $resultado = new stdClass();
        $datos = [];

        if ($flgBase64) {
            $doc = base64_decode($documento);
            $tmp = dirname(tempnam (null,''));
            $tmp = $tmp.'/'.'upload';

            if ( !is_dir($tmp)) {
                mkdir($tmp);
            }
            $urlTemp = $tmp.'/'.$nombre;
            file_put_contents($urlTemp, $doc);
        } else {
            $urlTemp = $documento;
        }

        $urlDestino = $this->crearUrlDestino($carpeta);

        $_FILES['fileDigital']['tmp_name'] = $urlTemp;
        $_FILES['fileDigital']['name'] = $nombre;
        $_FILES['fileDigital']['type'] = mime_content_type($urlTemp);
        $_POST['new_name'] = $nombre;
        $_POST['path'] = $urlDestino;
        $_POST['name'] = 'fileDigital';

        try{
            $curl = new CURLConnection($this->nginx.$this->php_nginx);
            $curl->uploadFile($_FILES, $_POST);
            $curl->closeCurl();
            $resultado->success = true;
            $resultado->mensaje = "Documendos subidos correctamente";
            $resultado->data = $datos;
        } catch (\Exception $e){
            $resultado->success = false;
            $resultado->mensaje = $e->getMessage();
            $resultado->data = $datos;
        } finally {
            return json_encode($resultado);
        }        
    }

    public function agregarDocumento($nombre, $documento, $idTramite, $tipoEnlace, $carpeta, $flgBase64 = false){
        $resultado = new stdClass();
        
        $d = new DocumentoModel();
        $d->nombre = DocDigital::formatearNombre(($nombre),true,[' ']);
        $d->tamano = 0;
        $d->url = $this->crearUrlDestino($carpeta).$d->nombre;
        $result = $d->agregarDocumento();
        $resultado = $result[0];

        if ($resultado->EVENTO == "REGISTRADO") {
            $d->codigo = $resultado->CODIGO;
            $response = $this->subirDocumento($d->nombre, $documento, $carpeta, $flgBase64);
            $response = json_decode($response);
            if (!$response->success){
                http_response_code(500);
                die(print_r($response->mensaje));
            }
            if ($idTramite != null){
                $d->enlazarDocumento($idTramite, $tipoEnlace);
            }
        } else {
            http_response_code(500);
            die(print_r($resultado->MENSAJE));
        }

        $datoResult = array(
            "idDocDigital" => $d->codigo,
            "url" => $d->url
        );
        return $datoResult;
    }

    public function agregarDocumentoVersionAnterior($nombre, $documento, $carpeta, $flgBase64 = false){
        $datos = [];
        
        $nomDocumento = DocDigital::formatearNombre(($nombre),false,[' ']).'.pdf';
        $response = $this->subirDocumento($nomDocumento, $documento, $carpeta, $flgBase64);
        $response = json_decode($response);
        if (!$response->success){
            http_response_code(500);
            die(print_r($response->mensaje));
        }
        $url = $this->crearUrlDestino($carpeta).$nomDocumento;
        $datos = array(
            "nombre" => $nomDocumento,
            "url"    => $url
        );
        return $datos;
    }

    public function numeroPaginasPdf($archivoPDF)
    {
        $content = file_get_contents($archivoPDF);
        $count = 0;
        $regex  = "/\/Count\s+(\d+)/";
        $regex2 = "/\/Page\W*(\d+)/";
        $regex3 = "/\/N\s+(\d+)/";
        if(preg_match_all($regex, $content, $matches)) {
            $count = max($matches);
        }
        return $count[1];
    }

}