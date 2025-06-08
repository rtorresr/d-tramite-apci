<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Spatie\Async\Pool;

//Load Composer's autoloader
require '../vendor/autoload.php';

require_once("../conexion/conexion.php");
require_once("../core/CURLConection.php");
require_once("../conexion/parametros.php");
require_once("clases/DocDigital.php");
require_once("clases/Email.php");
require_once("clases/Log.php");
require_once('invoker/config.php');


session_start();
date_default_timezone_set('America/Lima');
//momentaneo
$fFecActual = date('Ymd').' '.date('G:i:s');


if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    switch ($_POST["Evento"]){
        case "ObtenerArgumentos":
            $agrupado = $_SESSION['iCodOficinaLogin'].$_SESSION['CODIGO_TRABAJADOR'].date("YmdGis");

            $archivo = $_FILES['Archivo'];
            $resultado = new stdClass();
            $datos = [];

            $docDigital = new DocDigital($cnx);
            $docDigital->idTipo = 3;
            $docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
            $docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];
            $docDigital->grupo = $agrupado;
            
            try {
                $docDigital->tmp_name = $archivo['tmp_name'];
                $docDigital->name = $archivo['name'];
                $docDigital->type = $archivo['type'];
                $docDigital->size = $archivo['size'];

                if($docDigital->subirDocumento()){
                    $type=$_POST['Tipo'];
                    $razon = 'Soy el autor del documento';
                    $documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
                    $posx =515;
                    $posy =174;
                    $documentName = $docDigital->clearName;
                    $firma = "https://files.apci.gob.pe/srv-files/firmas/default/firma.png";

                    $param ='{
                        "app":"pcx",
                        "mode":"lot-p",
                        "clientId":"'.$CLIENTID.'",
                        "clientSecret":"'.$CLIENTSECRET.'",
                        "idFile":"MyForm",
                        "type":"'.$type.'",
                        "protocol":"T",
                        "fileDownloadUrl":"'.$documenturl.'",
                        "fileDownloadLogoUrl":"'.$SERVER_PATH.'/resources/img/iLogo1.png",
                        "fileDownloadStampUrl":"'.$firma.'",
                        "fileUploadUrl":"'.$FILEUPLOADURL.'",
                        "contentFile":"'.$documentName.'",
                        "reason":"'.$razon.'",
                        "isSignatureVisible":"true",
                        "stampAppearanceId":"2",
                        "pageNumber":"0",
                        "posx":"'.$posx.'",
                        "posy":"'. $posy.'",
                        "fontSize":"7",
                        "dcfilter":".*FIR.*|.*FAU.*",
                        "signatureLevel":"1",
                        "maxFileSize":"5242880"
                    }';

                    // "outputFile":"'.$documentName.'",	
                    //     "timestamp":"true"

                    // $param ='{
                    //     "app":"pdf",
                    //     "clientId":"'.$CLIENTID.'",
                    //     "clientSecret":"'.$CLIENTSECRET.'",
                    //     "idFile":"MyForm",
                    //     "type":"'.$type.'",
                    //     "protocol":"T",
                    //     "fileDownloadUrl":"'.$documenturl.'",
                    //     "fileDownloadLogoUrl":"'.$SERVER_PATH.'/resources/img/iLogo1.png",
                    //     "fileDownloadStampUrl":"'.$firma.'",
                    //     "fileUploadUrl":"'.$FILEUPLOADURL.'",
                    //     "contentFile":"firmado.pdf",
                    //     "reason":"'.$razon.'",
                    //     "isSignatureVisible":"true",
                    //     "stampAppearanceId":"2",
                    //     "pageNumber":"0",
                    //     "posx":"'.$posx.'",
                    //     "posy":"'. $posy.'",
                    //     "fontSize":"7",                        
                    //     "dcfilter":".*FIR.*|.*FAU.*",
                    //     "timestamp":"true",
                    //     "outputFile":"'.$documentName.'",
                    //     "maxFileSize":"5242880"
                    // }';

                    $paramentro = base64_encode($param);

                    echo json_encode(["args" => $paramentro, "id" => $docDigital->idDocDigital]);
                } else {
                    echo '';
                }
                                
            } catch (\Exception $e){
                echo '';
            }
            break;

        case "DescargarFirmado":
            $idDigital = $_POST['IdDigital'];
            $docDigitalOriginal = new DocDigital($cnx);
            $docDigitalOriginal->obtenerDocDigitalPorId($idDigital);

            $docDigital = new DocDigital($cnx);
            $docDigital->idTipo = 3;

            $nombreFile = $docDigitalOriginal->clearName;

            $arrayExploded = explode('.',$nombreFile);
            $extension = '.'.array_pop($arrayExploded);
            $nuevoNombre = implode('.',$arrayExploded);

            $nombreFile = urlencode($nuevoNombre."[R]").$extension;

            $separa=DIRECTORY_SEPARATOR;
            $tmp = dirname(tempnam (null,''));

            $tmp_name = $tmp.$separa."upload".$separa.$nombreFile;

            $docDigital->tmp_name = $tmp_name;
            $docDigital->name = $docDigitalOriginal->name;
            $docDigital->type = 'application/pdf';

            $docDigital->idOficina = $_SESSION['iCodOficinaLogin'];
            $docDigital->idTrabajador = $_SESSION['CODIGO_TRABAJADOR'];

            $docDigital->subirDocumento();

            echo json_encode(["url" => RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital()]);
            break;
    }
}else{
    header("Location: ../../index-b.php?alter=5");
}
?>