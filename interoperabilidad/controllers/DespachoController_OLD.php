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
            /*$urlCUO = RUTA_SIGTI_SERVICIOS."ApiInteroperabilidad/Api/Interoperabilidad/CUO/CUO_GET_0002?Ruc=20504915523&Servicio=3011";
            $clientCUO = curl_init();
            curl_setopt($clientCUO, CURLOPT_URL, $urlCUO);
            curl_setopt($clientCUO,CURLOPT_RETURNTRANSFER,true);
            $responseCUO = json_decode(curl_exec($clientCUO));            
            $vcuo = $responseCUO->EntityResult;*/

            $urlCUO = "https://ws2.pide.gob.pe/Rest/PCM/CEntidad?ruc=20504915523&servicio=3011";
            $clientCUO = curl_init();
            curl_setopt($clientCUO, CURLOPT_URL, $urlCUO);
            curl_setopt($clientCUO,CURLOPT_RETURNTRANSFER,true);
            $responseCUO = curl_exec($clientCUO);     
            $xml = new SimpleXMLElement( $responseCUO );
            $vcuo = (string) $xml->return[0]; 
            //print_r($vcuo);
            
            
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
                print_r($vcuo);
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

    public function enviarPide_REST(){
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
    
        
            $urlCUO = "https://ws2.pide.gob.pe/Rest/PCM/CEntidad?ruc=20504915523&servicio=3011";
            $clientCUO = curl_init();
            curl_setopt($clientCUO, CURLOPT_URL, $urlCUO);
            curl_setopt($clientCUO,CURLOPT_RETURNTRANSFER,true);
            $responseCUO = curl_exec($clientCUO);     
            $xml = new SimpleXMLElement( $responseCUO );
            $vcuo = (string) $xml->return[0];           
        

            $rucEntrem1 = '20504915523';
            $ruc1 = $o->ruc;
            $nomEntemi1 = 'AGENCIA PERUANA DE COPERACIÓN INTERNACIONAL';
            $uniOrgRem1 = $o->oficina;
            $cuo1 = $vcuo;
            $codTipDoc1 = $o->tipoDoc;
            $numDoc1 = trim($o->numDoc);
            $fecDoc1 = date('Y-m-d', strtotime($o->fecDoc));
            $uniOrgDst1 = $o->ofiDestino;
            $nomDst1 = $o->perDestino;
            $nomCarDst1 = $o->cargPerDestino;
            $asu1 = $o->asunto;
            $numAnx1 = $o->numAnexos;
            $numFol1 = trim($o->foliosDoc);
            $pdfDoc1 = trim($o->docBase64);
            $nomDoc1 = $o->documento;
            $urlDocAnx1 = $o->urlAnexos;
            $tipoDocIdenRem1 = $o->tipoDocIdenRem;
            $numDocIdenRem1 = $o->docIdenRem;

            // Convertir todos los valores a UTF-8
            $rucEntrem = mb_convert_encoding($rucEntrem1, 'UTF-8');
            $ruc = mb_convert_encoding($ruc1, 'UTF-8');
            $nomEntemi = mb_convert_encoding($nomEntemi1, 'UTF-8');
            $uniOrgRem = mb_convert_encoding($uniOrgRem1, 'UTF-8');
            $cuo = mb_convert_encoding($cuo1, 'UTF-8');
            $codTipDoc = mb_convert_encoding($codTipDoc1, 'UTF-8');
            $numDoc = mb_convert_encoding($numDoc1, 'UTF-8');
            $fecDoc = mb_convert_encoding($fecDoc1, 'UTF-8');
            $uniOrgDst = mb_convert_encoding($uniOrgDst1, 'UTF-8');
            $nomDst = mb_convert_encoding($nomDst1, 'UTF-8');
            $nomCarDst = mb_convert_encoding($nomCarDst1, 'UTF-8');
            $asu = mb_convert_encoding($asu1, 'UTF-8');
            $numAnx = mb_convert_encoding($numAnx1, 'UTF-8');
            $numFol = mb_convert_encoding($numFol1, 'UTF-8');
            $pdfDoc = mb_convert_encoding($pdfDoc1, 'UTF-8');
            $nomDoc = mb_convert_encoding($nomDoc1, 'UTF-8');
            $urlDocAnx = mb_convert_encoding($urlDocAnx1, 'UTF-8');
            $tipoDocIdenRem = mb_convert_encoding($tipoDocIdenRem1, 'UTF-8');
            $numDocIdenRem = mb_convert_encoding($numDocIdenRem1, 'UTF-8');



            /*$rucEntrem = '20504915523';
            $ruc = $o->ruc;
            $nomEntemi = 'AGENCIA PERUANA DE COPERACIÓN INTERNACIONAL';
            $uniOrgRem = $o->oficina;
            $cuo = $vcuo;
            $codTipDoc = $o->tipoDoc;
            $numDoc = trim($o->numDoc);
            $fecDoc = date('Y-m-d', strtotime($o->fecDoc));
            $uniOrgDst = $o->ofiDestino;
            $nomDst = $o->perDestino;
            $nomCarDst = $o->cargPerDestino;
            $asu = $o->asunto;
            $numAnx = $o->numAnexos;
            $numFol = trim($o->foliosDoc);
            $pdfDoc = trim($o->docBase64);
            $nomDoc = $o->documento;
            $urlDocAnx = $o->urlAnexos;
            $tipoDocIdenRem = $o->tipoDocIdenRem;
            $numDocIdenRem = $o->docIdenRem;*/

            

            // Crear el array PHP que contiene los datos para el JSON
            $data = [
                "PIDE" => [
                    "vrucentrem" => $rucEntrem,
                    "vrucentrec" => $ruc,
                    "vnomentemi" => $nomEntemi,
                    "vuniorgrem" => $uniOrgRem,
                    "vcuo" => $cuo,
                    "vcuoref" => "",
                    "ccodtipdoc" => $codTipDoc,
                    "vnumdoc" => $numDoc,
                    "dfecdoc" => $fecDoc,
                    "vuniorgdst" => $uniOrgDst,
                    "vnomdst" => $nomDst,
                    "vnomcardst" => $nomCarDst,
                    "vasu" => $asu,
                    "snumanx" => $numAnx,
                    "snumfol" => $numFol,
                    "bpdfdoc" => $pdfDoc,
                    "vnomdoc" => $nomDoc,
                    "vnomdoc2" => "prueba",
                    "vurldocanx" => $urlDocAnx,
                    "ctipdociderem" => $tipoDocIdenRem,
                    "vnumdociderem" => $numDocIdenRem
                ]
            ];

            // Convertir el array a formato JSON usando json_encode
            $jsonData = json_encode($data);

            // Ahora, utilizar curl para enviar el JSON
            $ch = curl_init();

            // Configurar la URL, el método POST, los encabezados y el cuerpo de la solicitud
            curl_setopt($ch, CURLOPT_URL, "https://ws2.pide.gob.pe/Rest/Pcm/RecepcionarTramite?out=json");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json"
            ]);

            // Ejecutar la solicitud
            $response = curl_exec($ch);

            // Comprobar si ocurrió un error en la ejecución de la solicitud
            if(curl_error($ch)) {
                echo 'Error:' . curl_error($ch);
            } else {
                echo 'Response2: ' . $response;
                echo '<br>';
                print_r('ENVIO REST1');
                echo '<br>';
                print_r($jsonData);echo '<br>';
                print_r('b64');echo '<br>';
                print_r($pdfDoc);


            }

            // Cerrar la sesión de curl
            curl_close($ch);

        /*try{            
            
            if ($vcuo !='') {
                $datoActulizar = array($vcuo, $_POST['id'], $_SESSION['IdSesion']);
                $o->actualizarPendienteEnvio($datoActulizar);  
            } else {
                //die( print_r( "No se pudo enviar: ".$respuesta->vcodresField." ". utf8_encode($respuesta->vdesresField), true));
                die( print_r( "No se pudo enviar "));
            }

        } catch (Exception $e) { 
            echo $e->getMessage();
        }  */

    }
}