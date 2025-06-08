<?php
class RecepcionController
{
    public function index(){
        require_once '../interoperabilidad/views/principal/recepcion.php';
    }

    public function pendientesRecibir(){
        require_once '../interoperabilidad/views/recepcion/pendientesRecibir.php';
    }

    public function datosPendientesRecibir(){
        $lista = new RecepcionModel();
        $resultado = $lista->listarPendientesRecibir();
        $datos = array();
        $contador = 0;
        foreach ($resultado AS $i => $objeto){
            $o = new RecepcionModel();
            $o->establecer($objeto);
            $o->fila = $contador;
            $o->fecDoc = $o->fecDoc != null ? $o->fecDoc->format( 'd-m-Y') : '';
            $o->fecEmision = $o->fecEmision != null ? $o->fecEmision->format( 'd-m-Y H:i:s') : '';
            $contador ++;
            $datos[] = $o;
        };
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) count($datos),
            "recordsFiltered" => (int) count($datos) ,
            "data"            => $datos
        );
        echo json_encode($json_data);
    }

    public function verDocPide(){
        $recepcion = new RecepcionModel();
        $recepcion->sIdrecext = $_POST['id'];
        $resultado = $recepcion->obtenerDocPide();
        $recepcion->docBase64 = base64_encode($resultado[0]->docBytes);
        echo $recepcion->docBase64;
    }

    public function registrarTramite(){
        $recepcion = new RecepcionModel();
        $recepcion->idSesion = $_SESSION['IdSesion'];
        $recepcion->sIdrecext = $_POST['Id'];

        if ($_POST['FlgObservado'] == 1){        
            $recepcion->observacionDoc = $_POST['ObservacionDoc'];
        } else {
            $recepcion->idOficinaDestino = $_POST['OfinaDestino'];
            
            if(isset($_POST['anexosPide'])){
                $cAnexos = [];
                foreach ($_POST['anexosPide'] as $key => $value) {
                    $cAnexos[$key]['idDigital'] = $value;
                }
                $i_cAnexos =  json_encode($cAnexos);
            } else {
                $i_cAnexos = null;
            }
            $recepcion->stringAnexos = $i_cAnexos;            
        }
        
        $recepcion->documento =$_POST['NomDocumento'];

        $resultado = $recepcion->obtenerDocPide();
        $recepcion->docBase64 = base64_encode($resultado[0]->docBytes);

        $documento =  new DocumentoController();
        $dataResult = $documento->agregarDocumentoVersionAnterior($recepcion->documento, $recepcion->docBase64, 'docEntrada', true);

        $recepcion->urlDoc = $dataResult['url'];
        $recepcion->nomUrlDoc = $dataResult['nombre'];

        $recepcion->registrarTramite();
    }

    public function pendientesEnvioCargo(){
        require_once '../interoperabilidad/views/recepcion/pendientesEnvioCargo.php';
    }

    public function datosPendientesEnvioCargo(){
        $lista = new RecepcionModel();
        $resultado = $lista->listarPendientesEnvioCargo();
        $datos = array();
        $contador = 0;
        foreach ($resultado AS $i => $objeto){
            $o = new RecepcionModel();
            $o->establecer($objeto);
            $o->fila = $contador;
            $o->fecDoc = $o->fecDoc != null ? $o->fecDoc->format( 'd-m-Y') : '';
            $contador ++;
            $datos[] = $o;
        };
        $json_data = array(
            "draw"            => (int)($_POST['draw']??0),
            "recordsTotal"    => (int) count($datos),
            "recordsFiltered" => (int) count($datos) ,
            "data"            => $datos
        );
        echo json_encode($json_data);
    }

    public function firmadoCargo(){
        $url = $_POST['urlDocFirmar'];
        $nombre = $_POST['nombreDocumentoFirmar'];
        $idTramite = $_POST['idTramite'];
        $sIdrecext = $_POST['sIdrecext'];
        $resultado = $this->guardarCargoFirmado($url,$idTramite,$nombre);
        $recepcion = new RecepcionModel();
        $recepcion->idTramite = $idTramite;
        $recepcion->sIdrecext = $sIdrecext;
        $recepcion->bcarstd = base64_encode(file_get_contents(NGINX.$resultado['url']));
        $recepcion->actualizarCargoFirmado();
        echo $resultado['url'];
    }

    public function guardarCargoFirmado($urlDoc,$idTramite,$nombre){
        // $urlArray = explode("/", $urlDoc);
        // $nomDoc = DocDigital::formatearNombre(array_pop($urlArray),true,[' ']);
        $tmp = dirname(tempnam (null,''));
        $temp = $tmp."/upload/".$nombre;
        $documento =  new DocumentoController();
        $dataResult = $documento->agregarDocumento($nombre,$temp,$idTramite,6, "Recepcion/Cargo", false);
        return $dataResult;
    }

    public function enviarCargo(){
        $recepcion = new RecepcionModel();
        $recepcion->urlCargoDoc = trim($_POST['url']);
        $recepcion->idTramite = $_POST['idTramite'];
        $recepcion->sIdrecext = $_POST['sIdrecext'];
        $resultado = $recepcion->obtenerDatosParaEnvioCargo();
        $o = $resultado[0];
        $bcarstd = base64_encode(file_get_contents(NGINX.$recepcion->urlCargoDoc)); 
        
        $recepcion->cargoBase64 = $bcarstd;

        try {
            $url = RUTA_SIGTI_SERVICIOS."ApiInteroperabilidad/Api/Interoperabilidad/tramite/SSO_GET_0002";
            $data = array(
                'vrucentrem' => RUC,
                'vrucentrec' => $o->rucDestino,
                'vcuo' => $o->cuo,
                'vcuoref' => '',
                'vnumregstd' => $recepcion->idTramite,
                'vanioregstd' => $o->anioRegistro,
                'dfecregstd' => $o->fecRegTramite->format('Y-m-d H:i:s'),
                'vuniorgstd' => $o->oficinaDestino,
                'vusuregstd' => $o->usurioReg,
                'bcarstd' => $bcarstd,
                'vobs' => $o->observacionDoc,
                'cflgest' => $o->flgRecepcion,
                'vdesanxstdrec' => ''  
            );

            $client = curl_init();
            curl_setopt($client, CURLOPT_URL, $url);
            curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($client, CURLOPT_POST, true);
            curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
            $response = json_decode(curl_exec($client));
            $respuesta = $response->EntityResult;
            if ($respuesta->vcodresField == 0) {
                $recepcion->actualizarCargoEnviado();
                echo "Enviado correctamente";
            } else {
                http_response_code(500);
                die( print_r( "No se pudo enviar: ".$respuesta->vcodresField." ". utf8_encode($respuesta->vdesresField), true));
                echo "No se pudo enviar: ".$respuesta->vcodresField." ". utf8_encode($respuesta->vdesresField);
            }
    
        } catch (SoapFault $E) { 
            echo $E->faultstring;
        } 
    }

}