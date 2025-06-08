<?php
use Spatie\Async\Pool;

class DocDigital
{
    public $flgAmbiente;
    public $tramiteDbCnx;
    public $idAplicacion;
    public $idModTramite;
    // public $idModDespacho;

    public $flgGestor;
    public $flgDobleRepositorio;    

    public $fileHost;
    public $filePort;
    public $filePath;
    public $fileUploadScript;
    public $fileUrl;

    public $repositorioService;

    public $visorArchivo;

    public $tmp_name;
    public $name;
    public $type;
    public $size;
    public $clearName;

    public $idTipo = 0;
    public $path;
    public $idOficina;
    public $idTrabajador;
    public $idDocDigital;
    public $idRepositorio;
    public $grupo;
    public $idTramite;
    public $idEntidad;
    public $sesion;
    public $idRegistroTabla;

    public $urlAplicacion;

    public function __construct($tramiteDbCnx)
    {
        $this->flgAmbiente = FLG_AMBIENTE;
        $this->tramiteDbCnx = $tramiteDbCnx;
        $this->idAplicacion = ID_APLICACION;
        $this->idModTramite = ID_MOD_TRAMITE;
        // $this->idModDespacho = ID_MOD_DESPACHO;

        $this->flgGestor = FLG_GESTOR;
        $this->flgDobleRepositorio = FLG_DOBLE_REPOSITORIO;        

        $this->fileHost = FILES_HOST;
        $this->filePort = FILES_PORT;
        $this->filePath = FILES_PATH;
        $this->fileUploadScript = FILES_FILE_UPLOAD;
        $this->fileUrl = $this->fileHost.$this->filePath;

        $this->repositorioService = RUTA_REPOSITORIO;
        $this->visorArchivo = VISOR_ARCHIVOS;
        $this->urlAplicacion = RUTA_DTRAMITE;
    }

    static function eliminar($ruta,$servidor=false,$repositorio=false){
        if ($repositorio){
            echo "No hay repositorio";
            return false;
        } else if($servidor){
            echo "No hay servidor de archivos";
            return false;    
        } else {
            if (file_exists($ruta)){
                unlink($ruta);
            } else {
                echo "No existe archivo";
                return false;
            }
        }
    }

    static function existeUrl($url) {
        try {
            // if (!(strpos($url,'http://') || strpos($url,'https://'))){
            //     $nuevaUrl = 'http://'.$url;

            //     $ch = curl_init($nuevaUrl);
            //     curl_setopt($ch, CURLOPT_NOBODY, true);
            //     curl_exec($ch);
            //     $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            //     if ($code == 200) {
            //         $ruta = $nuevaUrl;
            //     } else {
            //         $ruta = false;
            //     }
            //     curl_close($ch);
                
            //     if (!$ruta){
            //         $nuevaUrl = 'https://'.$url;
            //         $ch = curl_init($nuevaUrl);
            //         curl_setopt($ch, CURLOPT_NOBODY, true);
            //         curl_exec($ch);
            //         $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            //         if ($code == 200) {
            //             $ruta = $nuevaUrl;
            //         } else {
            //             $ruta = false;
            //         }
            //         curl_close($ch);
            //     }

            //     return $ruta;       
            // } else {
                
            // }
            $url = explode('/',$url);            
            $nombreDoc = array_pop($url);
            $url = implode('/',$url).'/'.rawurlencode($nombreDoc);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($code == 200) {
                $ruta = $url;
            } else {
                $ruta = false;
            }
            curl_close($ch);
            return $ruta;
        } catch (Throwable $e){
            return false;
        }    
    }

    static function formatearNombre($nombre, $flgExtension = false, $buscarCaracteres = null, $remplazarCaracter = null,$quitarCaracteresEspeciales = true, $quitarTildes = true, $limpiarUrl = true){
        $extension = '';
        $nuevoNombre = utf8_encode($nombre);

        if ($flgExtension){
            $arrayExploded = explode('.',$nombre);
            $extension = '.'.array_pop($arrayExploded);
            $nuevoNombre = implode('.',$arrayExploded);
        }

        $nuevoNombre = trim($nuevoNombre);

        if ($quitarCaracteresEspeciales){
            $nuevoNombre = preg_replace('([^A-Za-z0-9\s\-])','', $nuevoNombre);
        }

        if ($quitarTildes){
            $nuevoNombre = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
                array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
                $nuevoNombre
            );

            $nuevoNombre = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
                $nuevoNombre
            );

            $nuevoNombre = str_replace(
                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
                $nuevoNombre
            );

            $nuevoNombre = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
                $nuevoNombre
            );

            $nuevoNombre = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
                $nuevoNombre
            );

            $nuevoNombre = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'),
                array('n', 'N', 'c', 'C'),
                $nuevoNombre
            );
        }
        
        if ($buscarCaracteres != null){
            if ($buscarCaracteres != null && count($buscarCaracteres) > 0){
                $caracterRemplazar = '-';
                if ($remplazarCaracter != null){
                    $caracterRemplazar = $remplazarCaracter;
                }
                foreach($buscarCaracteres as $caracter){                
                    $nuevoNombre = str_replace($caracter,$caracterRemplazar,$nuevoNombre);
                }
            }            
        }

        if ($limpiarUrl){
            $nuevoNombre = filter_var($nuevoNombre, FILTER_SANITIZE_STRING);
        }

        return $nuevoNombre.$extension;
    }

    static function validarFormato($nombre){
        $extension = strtoupper($nombre);
        $formartosPermitido = ['JPG','JPEG','PNG','PDF','DOC','DOCX','XLS','XLSX','XLSM','PPT','PPTX','RAR','ZIP','7Z'];

        return in_array($extension,$formartosPermitido);
    }

    static function carpetaPerteneciente($tipo){
        $carpeta = '';
        switch($tipo){            
            case 1:
                $carpeta = 'docFirmados';
                break;
            case 2:
                $carpeta = 'docNoFirmados';
                break;
            case 3:
                $carpeta = 'docAnexos';
                break;
            case 4:
                $carpeta = 'docVisados';
                break;
            case 5:
                $carpeta = 'docEntrada';
                break;
            case 6:
                $carpeta = 'Despacho/Cargo';
                break;
            case 7:
                $carpeta = 'docEntrada';
                break;
            case 8:
                $carpeta = 'docPreFirmados';
                break;
            case 9:
                $carpeta = 'Despacho/Entrega';
                break;
            case 10:
                $carpeta = 'Despacho/Devolucion';
                break;
            case 11:
                $carpeta = 'Prestamo';
                break;
            case 12:
                $carpeta = 'docEntradaMesaVirtual';
                break;
            case 13:
                $carpeta = 'docEntradaMesaVirtual/SolicitudTipoTramite';
                break;
            case 14:
                $carpeta = 'temporales';
                break;
            case 15:
                $carpeta = 'Prestamo/Solicitudes/NoFirmados';
                break;
            case 16:
                $carpeta = 'Prestamo/Solicitudes/PreFirmados';
                break;
        }

        return $carpeta;
    }

    static function validarTipoDocEnvioGestor($tipo){
        $formartosPermitido = [1, 2, 4, 5, 6, 9, 10, 11];

        return in_array($tipo,$formartosPermitido);
    }

    static function rutaCarpetas($datos){
        $nNumAno    = date('Y');
        $nNumMes    = date('m');
        $nNumDia    = date('d');

        $nomenclatura = $nNumAno.'/'.$nNumMes.'/'.$nNumDia.'/'.$datos->idOficina.'/'.$datos->idTrabajador;
        if ($datos->grupo != null && $datos->grupo != ''){
            $nomenclatura .= '/'.$datos->grupo;
        }

        // return 'prueba17012023/'.self::carpetaPerteneciente($datos->idTipo).'/'.$nomenclatura.'/';
        return self::carpetaPerteneciente($datos->idTipo).'/'.$nomenclatura.'/';
    }

    private function cargarDocNginx(){ 
        if ($this->path == '' || $this->path == null){
            $path = self::rutaCarpetas($this);
            try{
                $curl = new CURLConnection($this->fileHost.':'.$this->filePort.$this->filePath.$this->fileUploadScript);
                $_FILES['fileUpLoadDigital']['tmp_name'] = $this->tmp_name;
                $_FILES['fileUpLoadDigital']['name'] = $this->name;
                $_FILES['fileUpLoadDigital']['type'] = $this->type;            

                $_POST['path'] = $path;
                $_POST['name'] = 'fileUpLoadDigital';
                $_POST['new_name'] = $this->clearName;
            
                $curl->uploadFile($_FILES, $_POST);
                $this->path = $path.$this->clearName;
            } catch (\Exception $e){
                throw new \Exception('Error guardar el archivo en servidor nginx');
            }
            return $this->path != '' ? true : false;
        } else {
            return true;
        }
    }


    private function cargarDocRepositorioFiltro(){
        if(self::validarTipoDocEnvioGestor($this->idTipo)){
            switch($this->idTipo){
                case 2:
                    $result = $this->cargarDocRepositorio();
                    $this->actualizarDatosAlmacenamiento();

                    $listado = self::obtenerDocsDigitalTramite($this->tramiteDbCnx ,$this->idTramite, 3);

                    foreach($listado as $value){
                        $docAnexo = new DocDigital($this->tramiteDbCnx);
                        $docAnexo->obtenerDocDigitalPorId($value);
                        $docAnexo->tmp_name = $this->urlAplicacion.$docAnexo->obtenerRutaDocDigital();
                        if($docAnexo->cargarDocRepositorio()){
                            $docAnexo->actualizarDatosAlmacenamiento();
                        } else {
                            $result = false;
                        }
                    }

                    return $result;
                    break;

                case 5:
                    $result = $this->cargarDocRepositorio();
                    $this->actualizarDatosAlmacenamiento();
                    
                    $listado = self::obtenerDocsDigitalTramite($this->tramiteDbCnx ,$this->idTramite, 3);
                    $listado = array_merge($listado,self::obtenerDocsDigitalTramite($this->tramiteDbCnx ,$this->idTramite, 7));

                    foreach($listado as $value){
                        $docAnexo = new DocDigital($this->tramiteDbCnx);
                        $docAnexo->obtenerDocDigitalPorId($value);
                        $docAnexo->tmp_name = $this->urlAplicacion.$docAnexo->obtenerRutaDocDigital();
                        if($docAnexo->cargarDocRepositorio()){
                            $docAnexo->actualizarDatosAlmacenamiento();
                        } else {
                            $result = false;
                        }
                    }

                    return $result;
                    break;
                default:
                    $result = $this->cargarDocRepositorio(); 
                    $this->actualizarDatosAlmacenamiento();
                    return $result;
            }
        } else {
            return true;
        };
    }

    public function cargarDocRepositorio(){
        $client = new SoapClient($this->repositorioService);
        $documento=file_get_contents($this->tmp_name,true);

        $parametros = array(
            'datos' => array(
                'NombreArchivo' => $this->name,
                'Archivo' => $documento,            
                'IdDigital' => $this->idDocDigital,
                'Cod_Apli' => $this->idAplicacion,
                'IdDigModulo' => $this->idModTramite,
                'IdEnv' => $this->flgAmbiente          
            )
        );

        $servicio =  $client->SubirArchivoPHP($parametros);
        $resultado = $servicio->SubirArchivoPHPResult;
        
        if ($resultado > 0){
            $this->idRepositorio = $resultado;            
        }        
        return $resultado > 0 ? true : false;
    }

    public function cargarDocumento($esSecundario = false){
        $success = false;
        if ($this->flgGestor){
            if($this->cargarDocRepositorio()){
                $success = true;
            } else {
                if($this->cargarDocNginx()){
                    $success = true;
                }; 
            }
        } else {
            if($this->cargarDocNginx()){
                $success = true;                
                if($this->flgDobleRepositorio && (($this->idTramite != null && $this->idTramite != 0) || $esSecundario)){
                    $pool = Pool::create();

                    $pool[] = async(function () {
                        if(!$this->cargarDocRepositorioFiltro()){
                            $log = new Log($this->tramiteDbCnx);
                            $datosDB = new stdClass();
                            $datosDB->archivo = 'DocDigital.php';
                            $datosDB->metodo = "cargarDocumento | cargarDocRepositorio";
                            $datosDB->resultado = 0;
                            $datosDB->mensaje = 'No se pudo registrar en el gestor documental';
                            $datosDB->contenido = $this->repositorioService.' | IdDigital: '.$this->idDocDigital;          
                            
                            $log->logging(false, $datosDB);
                        }                        
                    });
                }
            };
        }
        return $success;
    }

    static function obternerExtension($nombre){
        $arrayExploded = explode('.',$nombre);
        $extension = array_pop($arrayExploded);

        return $extension;
    }

    public function subirDocumento(){
        $this->clearName = self::formatearNombre($this->name,true,[' ']);
        try {
            if (!self::validarFormato(self::obternerExtension($this->clearName))){
                throw new \Exception('Formato no aceptado');
            }

            if (!$this->regDocTramiteDigital()){
                throw new \Exception('No se pudo registrar');
            };

            if (!$this->cargarDocumento()){
                $this->anularDocTramiteDigital();
                throw new \Exception('No se pudo subir el archivo');
            } else {
                $this->actualizarDatosAlmacenamiento();
            };
        } catch (\Exception $e){
            return false;
        }
        return true;
    }

    private function regDocTramiteDigital(){
        $datos = new stdClass();
        $datos->idOficina = $this->idOficina;
        $datos->idTrabajador = $this->idTrabajador;

        $parametros = array(
            $this->idTramite,
            $this->grupo,
            $this->name,
            $this->path,
            $this->idTipo,
            json_encode($datos),
            $this->idEntidad
        );
        
        $store = "{CALL SP_INGRESO_DOCUMENTO_NUEVO (?,?,?,?,?,?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$store,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
        $this->idDocDigital = $Rs['iCodDigital'];
        return $this->idDocDigital > 0 ? true : false;
    }    

    private function actualizarDatosAlmacenamiento(){
        $parametros = array(
            $this->idDocDigital,
            $this->path,
            $this->idRepositorio
        );
        $stored = "{CALL UP_ACTUALIZAR_DATOS_ALMACENAMIENTO_DOCUMENTO (?,?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    }

    private function anularDocTramiteDigital(){
        $parametros = array(
            $this->idDocDigital
        );
        $stored = "{CALL UP_ANULAR_DOC_DIGITAL (?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    }

    public function obtenerRutaDocDigital(){
        $datos = new stdClass();
        $datos->idDigital = $this->idDocDigital;

        $ruta = $this->visorArchivo.base64_encode(json_encode($datos));

        return $ruta;
    }

    public function obtenerRutaDocDigitalSecundario(){
        $datos = new stdClass();
        $datos->idDigital = $this->idDocDigital;

        $ruta = $this->visorArchivo.base64_encode(json_encode($datos)).'&p=1';

        return $ruta;
    }

    public function obtenerDocDigitalPorId($idDocDigital, $principal = 0){
        $parametros = array(
            $idDocDigital,
            $principal
        );
        $stored = "{CALL UP_OBTENER_DOC_DIGITAL_DATOS (?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);

        $this->idTipo = $Rs['iCodTipoDigital'];
        $this->path = $Rs['Ruta'];        
        $this->idDocDigital = $Rs['iCodDigital'];
        $this->idRepositorio = $Rs['IdRepositorioExt'];
        $this->grupo = $Rs['cAgrupado'];
        $this->idTramite = $Rs['iCodTramite'];
        $this->name = $Rs['Nombre'];
        $this->clearName = self::formatearNombre($this->name,true,[' ']);

        $dataDigital = $Rs['dataDigital'];
        if($dataDigital != null && $dataDigital != ''){
            $dataDigital = json_decode($dataDigital);

            if (isset($dataDigital->idOficina)){
                $this->idOficina = $dataDigital->idOficina;
            }

            if (isset($dataDigital->idTrabajador)){
                $this->idTrabajador = $dataDigital->idTrabajador;
            }
        }
    }

    private function obtenerDocNginx(){
        $url = self::existeUrl($this->fileUrl.$this->path);
        
        if($url){
            return file_get_contents($url);
        } else {
            return false;  
        }

        return $result;
    }

    private function obtenerDocRepositorio(){
        $client = new SoapClient($this->repositorioService);

        $params = array('ID_LF'=>$this->idRepositorio);
        $webService =  $client->Descargar($params);
        $wsResult = $webService->DescargarResult;

        $datos = $wsResult;
        
        return $datos->Archivo;
    }

    public function obtenerDocBinario(){              
        if ($this->flgGestor && ($this->idRepositorio != null && trim($this->idRepositorio) != '' && $this->idRepositorio > 0)){
            $buffer = $this->obtenerDocRepositorio();
        } else {
            $buffer = $this->obtenerDocNginx();
        }        
        return $buffer;
    }

    public function descargarDocumento($idDocDigital, $principal = true){
        if ($principal){
            $this->obtenerDocDigitalPorId($idDocDigital);
        } else {
            $this->obtenerDocDigitalPorId($idDocDigital, 1);
        }
        $p1 = "";
        $p2 = "";
        $nombreArchivo = $this->clearName;
        if (str_contains($nombreArchivo, '-')) {
            $nombreArchivo = explode('-',$nombreArchivo);
            $p1 = array_shift($nombreArchivo);
            $p2 = array_shift($nombreArchivo);
            $nombreArchivo = implode('-',$nombreArchivo);
            if(!(is_numeric($p1) && is_numeric($p2))){
                if($nombreArchivo!="") {
                    $nombreArchivo = $p1.'-'.$p2.'-'.$nombreArchivo;
                }else {
                    $nombreArchivo = $p1.'-'.$p2;
                }
            }
        }        
        if(strtoupper(self::obternerExtension($this->clearName)) == 'PDF'){            
            header('Content-type: application/pdf');
            header("Content-Disposition: inline;filename=".$nombreArchivo);
        }else {
            header("Content-Disposition: attachment;filename=".$nombreArchivo);
        }
        echo $this->obtenerDocBinario();
    }

    public function obtenerDocTramite(){
        $parametros = array(
            $this->idTramite,
            $this->idTipo,
            $this->idEntidad
        );

        $stored = "{CALL SP_CONSULTA_DOCUMENTO_MAYOR (?,?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $datos = [];
        while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)) {
            $datos[] = $Rs['idDigital'];
        }
        
        return $datos;
    }

    public function obtenerDocMayor(){
        $resultado = $this->obtenerDocTramite();
        
        $this->idDocDigital = $resultado[0];
        $this->obtenerDocDigitalPorId($this->idDocDigital);
    }

    public function subirDocumentoSecundario(){
        $this->clearName = self::formatearNombre($this->name,true,[' ']);
        $this->idModTramite = ID_MOD_TRAMITE_SECUNDARIO;

        try {
            if (!self::validarFormato(self::obternerExtension($this->clearName))){
                throw new \Exception('Formato no aceptado');
            }

            if (!$this->regDocDocDigital()){
                throw new \Exception('No se pudo registrar');
            };

            if (!$this->cargarDocumento(true)){
                $this->anularDocDigital();
                throw new \Exception('No se pudo subir el archivo');
            } else {
                $this->actualizarDatosAlmacenamientoDocDigital();
            };
        } catch (\Exception $e){
            return false;
        }
        return true;
    }

    private function regDocDocDigital(){
        $datos = new stdClass();
        $datos->idOficina = $this->idOficina;
        $datos->idTrabajador = $this->idTrabajador;

        if($this->idTramite != null){
            $datos->idTramite = $this->idTramite;
        }        

        $parametros = array(
            $this->name,
            null,
            self::obternerExtension($this->clearName),
            $this->size,
            $this->idTipo,
            json_encode($datos),
            $this->sesion,
            $this->idRegistroTabla
        );
        
        $store = "{CALL UP_INSERTAR_DOC_DIGITAL (?,?,?,?,?,?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$store,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC);
        $this->idDocDigital = $Rs['CODIGO'];
        return $this->idDocDigital > 0 ? true : false;
    }

    private function anularDocDigital(){
        $parametros = array(
            $this->idDocDigital,
            $this->sesion
        );
        $stored = "{CALL UP_ANULAR_DOC_DIGITAL_SECUNDARIO (?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    }

    public function actualizarDatosAlmacenamientoDocDigital(){
        $parametros = array(
            $this->idDocDigital,
            $this->path,
            $this->idRepositorio,
            $this->sesion
        );

        $stored = "{CALL UP_ACTUALIZAR_DATOS_ALMACENAMIENTO_DOCUMENTO_DOC_DIGITAL (?,?,?,?)}";

        $rs = sqlsrv_query($this->tramiteDbCnx,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }
    }

    static function obtenerDocsDigitalTramite($cnx, $tramite, $tipo){
        $parametros = array(
            $tramite,
            $tipo
        );

        $stored = "{CALL UP_OBTENER_DOC_DIGITAL_TIPO_TRAMITE (?,?)}";

        $rs = sqlsrv_query($cnx,$stored,$parametros);
        if($rs === false) {
            http_response_code(500);
            die(print_r(sqlsrv_errors()));
        }

        $datos = [];
        while ($Rs = sqlsrv_fetch_array($rs,SQLSRV_FETCH_ASSOC)) {
            $datos[] = $Rs['iCodDigital'];
        }
        
        return $datos;
    }
}