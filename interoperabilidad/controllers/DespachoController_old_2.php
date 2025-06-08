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
        // // $o->fecDoc = $o->fecDoc->format( 'Y-m-d H:i:s');
        $o->fecDoc = $o->fecDoc->format( 'Y/m/d');
        if ($o->numAnexos > 0){
            $lstanexos = [];
            foreach (json_decode($o->jsonAnexos) as $clave => $valor){
                $anexo = new stdClass();
                $anexo->vnomdoc = $valor->VNOMDOC;
                array_push($lstanexos,$anexo);
            }
        }else {
            $lstanexos = [];
        }
        //HABILITAR EN PRODUCCION
        /*$obj = new COM("ComponentePide.wsInterop");
        $servicio = "3111";
        $vcuo = $obj->getCUOEntidad($vrucentrem, $servicio);*/
        $vcuo = '0890487952';
        // // $objetoInter = new COM("ComponentePideDesa.wsInterop");
        // // $respuesta = $objetoInter->recepcionarTramiteResponse(
        // //      RUC
        // //     ,$o->ruc
        // //     ,NOMBRE
        // //     ,$o->oficina
        // //     ,$vcuo
        // //     ,$o->tipoDoc
        // //     ,$o->numDoc
        // //     ,$o->fecDoc
        // //     ,$o->ofiDestino
        // //     ,$o->perDestino
        // //     ,$o->cargPerDestino
        // //     ,$o->asunto
        // //     ,$o->numAnexos
        // //     ,$o->foliosDoc
        // //     ,$o->docBase64
        // //     ,$o->documento
        // //     ,$o->tipoDocIdenRem
        // //     ,$o->docIdenRem
        // // );
        // // if (strcmp($respuesta[0],'0000') == 0) {
        // //     $datoActulizar = array($vcuo, $_POST['id'], $_SESSION['IdSesion']);
        // //     $o->actualizarPendienteEnvio($datoActulizar);
        // // } else {
        // //     die( print_r( "No se pudo enviar: ".$respuesta[0]." ". utf8_encode($respuesta[1]), true));
        // // }

        //fergerhgergterhg
        try {
        
        /*para produccion*/
        // $optionsCuo = array(
        //     'exceptions'=>true,
        //     'trace'=>1,
        //     'location' => INTEROPERABILIDAD_CUO            
        // );
        // $clientCuo = new SoapClient(INTEROPERABILIDAD_CUO,$optionsCuo);
        // $parametersCuo = array(
        //     'ruc'=> RUC,
        //     'servicio' => 3111
        // );
        // $serviceCuo = $clientCuo->getCUOEntidad($parametersCuo);
        // $vcuo = $serviceCuo->return;
        /*para produccion */

        $options = array(
            'exceptions'=>true,
            'trace'=>1,
            'location' => INTEROPERABILIDAD_TRAMITE            
        );
        $client = new SoapClient(INTEROPERABILIDAD_TRAMITE,$options);
        $parameters = array(
            'request' => array(
                'vrucentrem' => RUC,
                'vrucentrec' => $o->ruc,
                'vnomentemi' => NOMBRE,
                'vuniorgrem' => trim($o->oficina),
                'vcuo' => $vcuo,
                'vcuoref' =>  '',
                'ccodtipdoc' => $o->tipoDoc,
                'vnumdoc' => trim($o->numDoc),
                'dfecdoc' => $o->fecDoc,
                'vuniorgdst' => $o->ofiDestino,
                'vnomdst' => $o->perDestino,
                'vnomcardst' => $o->cargPerDestino,
                'vasu' => $o->asunto,
                'snumanx' => $o->numAnexos,
                'snumfol' => $o->foliosDoc,
                'bpdfdoc' => $o->docBase64,
                'vnomdoc' => $o->documento,
                'lstanexos' => $lstanexos,               
                'vurldocanx' => $o->urlAnexos,
                'ctipdociderem' => $o->tipoDocIdenRem,
                'vnumdociderem' => $o->docIdenRem            
            )
        );
        $service = $client->recepcionarTramiteResponse($parameters);
        $respuesta = $service->return;
        if ($respuesta->vcodres == 0) {
            $datoActulizar = array($vcuo, $_POST['id'], $_SESSION['IdSesion']);
            $o->actualizarPendienteEnvio($datoActulizar);
        } else {
            die( print_r( "No se pudo enviar: ".$respuesta->vcodres." ". utf8_encode($respuesta->vdesres), true));
        }

        } catch (SoapFault $E) { 
            echo $E->faultstring;
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