<?php

class DespachoController
{
    public function index(){
        require_once '../interoperabilidad/views/principal/despacho.php';
    }

    public function pendientesEnviar(){
        require_once '../interoperabilidad/views/despacho/pendientesEnviar.php';
    }

    public function datosPendientesEnviar(){
        $lista = new DespachoModel();
        $resultado = $lista->listarPendientesEnvio();
        $datos = array();
        $contador = 0;
        foreach ($resultado AS $i => $objeto){
            $o = new DespachoModel();
            $o->establecer($objeto);
            $o->fila = $contador;
            $o->fecRegistro = $o->fecRegistro != null ? $o->fecRegistro->format( 'd-m-Y H:i:s') : '';
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

    public function enviarPide(){
        $parametros = array($_POST['id']);
        $despacho = new DespachoModel();
        $resultado = $despacho->obtenerDatosParaEnvio($parametros);
        $o = new DespachoModel();
        $o->establecer($resultado[0]);
        $o->fecDoc = $o->fecDoc->format('Y-m-d H:i:s');
        if ($o->numAnexos > 0){
            $lstanexos = [];
            foreach (json_decode($o->jsonAnexos) as $clave => $valor){
                $anexo = new stdClass();
                $anexo->vnomdoc = $valor->VNOMDOC;
                //array_push($lstanexos,$anexo);
                array_push($lstanexos,trim($valor->VNOMDOC));
            }
            $lstanexos = json_encode($lstanexos);
        }else{
            $lstanexos = null;
        };
        try{            
            //$urlCUO = RUTA_SIGTI_SERVICIOS."ApiInteroperabilidad/Api/Interoperabilidad/CUO/CUO_GET_0001?Ip=127.0.0.1";
            $urlCUO = RUTA_SIGTI_SERVICIOS."ApiInteroperabilidad/Api/Interoperabilidad/CUO/CUO_GET_0002?Ruc=20504915523&Servicio=3011";
            $clientCUO = curl_init();
            curl_setopt($clientCUO, CURLOPT_URL, $urlCUO);
            curl_setopt($clientCUO,CURLOPT_RETURNTRANSFER,true);
            $responseCUO = json_decode(curl_exec($clientCUO));            
            $vcuo = $responseCUO->EntityResult;
            
            $url = RUTA_SIGTI_SERVICIOS."ApiInteroperabilidad/Api/Interoperabilidad/tramite/SSO_GET_0004";
            $data = array(
                'vrucentrem' => RUC,
                'vrucentrec' => $o->ruc,
                'vnomentemi' => NOMBRE,
                'vuniorgrem' => trim($o->oficina),
                'vcuo' => $vcuo,
                'vcuoref' =>  null,
                'ccodtipdoc' => $o->tipoDoc,
                'vnumdoc' => trim($o->numDoc),
                'dfecdoc' => $o->fecDoc,
                'vuniorgdst' => $o->ofiDestino,
                'vnomdst' => $o->perDestino,
                'vnomcardst' => $o->cargPerDestino,
                'vasu' => $o->asunto,
                'snumanx' => $o->numAnexos,
                'snumfol' => $o->foliosDoc,
                'bpdfdoc' => trim($o->docBase64),
                'vnomdoc' => trim($o->documento),
                'IOAnexoBean' => $lstanexos,
                'vurlanxdoc' => $o->urlAnexos,
                'ctipdociderem' => $o->tipoDocIdenRem,
                'vnumdociderem' => $o->docIdenRem 
                );
            $client = curl_init();
            curl_setopt($client, CURLOPT_URL, $url);
            curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($client, CURLOPT_POST, true);
            curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($data));
            $response = json_decode(curl_exec($client));
            $respuesta = $response->EntityResult;
            if ($respuesta->vcodresField == 0) {
                $datoActulizar = array($vcuo, $_POST['id'], $_SESSION['IdSesion']);
                $o->actualizarPendienteEnvio($datoActulizar);
            } else {
                die( print_r( "No se pudo enviar: ".$respuesta->vcodresField." ". utf8_encode($respuesta->vdesresField), true));
            }
        } catch (Exception $e) { 
            echo $e->getMessage();
        }        
    }

    public function pendientesCargo(){
        require_once '../interoperabilidad/views/despacho/pendientesCargo.php';
    }

    public function datosPendientesCargo(){
        $lista = new DespachoModel();
        $resultado = $lista->listarPendientesCargo();
        $datos = array();
        $contador = 0;
        foreach ($resultado AS $i => $objeto){
            $o = new DespachoModel();
            $o->establecer($objeto);
            $o->fila = $contador;
            $o->fecEnvio = $o->fecEnvio != null ? $o->fecEnvio->format( 'd-m-Y H:i:s') : '';
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

    public function pendientesDevolver(){
        require_once '../interoperabilidad/views/despacho/pendientesDevolver.php';
    }

    public function datosPendientesDevolver(){
        $lista = new DespachoModel();
        $resultado = $lista->listarPendientesDevolver();
        $datos = array();
        $contador = 0;
        foreach ($resultado AS $i => $objeto){
            $o = new DespachoModel();
            $o->establecer($objeto);
            $o->fila = $contador;
            $o->fecRecepcion = $o->fecRecepcion != null ? $o->fecRecepcion->format( 'd-m-Y H:i:s') : '';
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

    public function verCargoPide(){
        $despacho = new DespachoModel();
        $despacho->sIdemiext = $_POST['id'];
        $resultado = $despacho->obtenerCargoPide();
        $o = new DespachoModel();
        $o->establecer($resultado[0]);
        $o->cargoBase64 = base64_encode($resultado[0]->cargoBytes);
        echo $o->cargoBase64;
    }

    public function devolverCargo(){
        $despacho = new DespachoModel();
        $despacho->sIdemiext = $_POST['id'];
        $despacho->observacion = $_POST['observacion'];
        $despacho->idSesion = $_SESSION['IdSesion'];
        $resultado = $despacho->obtenerCargoPide();
        $o = new DespachoModel();
        $o->establecer($resultado[0]);
        $o->cargoBase64 = base64_encode($resultado[0]->cargoBytes);
        $documento =  new DocumentoController();
        $datoResultado = $documento->agregarDocumento($_POST['nombre'], $o->cargoBase64, $_POST['tramite'], $_POST['tipoEnlace'], 'Despacho/Cargo', true);
        $despacho->idCargo = $datoResultado['idDocDigital'];
        $despacho->retornarCargo();
    }
}