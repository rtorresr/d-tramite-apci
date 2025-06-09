<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain'); // Responder en texto plano
header('Cache-Control: no-cache'); // Evitar cacheo

require_once('config.php');
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once("../clases/DocDigital.php");
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

//require_once('token.php');

session_start();


$flgRequireFirmaLote = $_GET['flgRequireFirmaLote'];

$flgArchivoTramite = isset($_POST['flgArchivoTramite']) ? 1: 0;
$flgSecundario = isset($_GET['flgSecundario']) ? $_GET['flgSecundario']: 0;


$docDigital = new DocDigital($cnx);

$docDigital->obtenerDocDigitalPorId($_GET['idDigital'], 1);
$documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();


$documentName = $docDigital->clearName;
$posx = 0;
$posy = 0;
if($_GET['tipFirma']=='f'){
    $firma = "https://files.apci.gob.pe/srv-files/firmas/default/firma.png";
    $razon = 'Soy el autor del documento';
    $posx = 515;
    $posy = 174;
}else{
	$firma = "https://files.apci.gob.pe/srv-files/firmas/default/firma.png";
    $razon = 'Visto Bueno';
    $posx = 6;
    $posy = 174 + 84*((int)$_GET['nroVisto']);
}

/* CONDICIONAL SELLADO TIEMPO EXTERNO*/
$selloTiempoMap = [
    1 => "B",   // INTERNO
    2 => "B",  // INTERNO
    3 => "T",  // EXTERNO
    null => "T"  // -
];

// Determinar el valor de selloTiempo basado en el mapeo
$idTipoTra = $_GET['idTipoTra'];
$selloTiempo = $selloTiempoMap[$idTipoTra] ?? "T";


// Uso
$configPath = 'config/fwAuthorization.json';
$cachePath = 'token_cache.json';

$jsonContent = file_get_contents($configPath);
$fwAuthorization = json_decode($jsonContent);

$url = $fwAuthorization->token_url;
$data = array(
    'client_id' => $fwAuthorization->client_id,
    'client_secret' => $fwAuthorization->client_secret
);

$token = postRequest($url, $data);

$signatureParams = array(
	"signatureFormat" => "PAdES",
	"signatureLevel" => $selloTiempo,
	"signaturePackaging" => "enveloped",
	"documentToSign" =>$documenturl,
	"certificateFilter" => ".*FIR.*|.*FAU.*",
	"webTsa" => "https://apps.firmaperu.gob.pe/admin/api/security/generate-token",
	"userTsa" => $CLIENTID,
	"passwordTsa" => $CLIENTSECRET,
	"theme" => "claro",
	"visiblePosition" => true,
	"contactInfo" => "",
	"signatureReason" => $razon,
	"signatureStyle" => 1, 
	"imageToStamp" => $SERVER_PATH."/resources/img/iLogo1.png",
	"stampTextSize" => 14,
	"stampWordWrap" => 37,
	"role" => "",
	"stampPage" => 1,
	"positionx" => 400,
	"positiony" => 400,
	"bachtOperation" => false,	//para firma con lote
	"oneByOne" => true,		////para firma con lote
	"uploadDocumentSigned" => RUTA_DTRAMITE."views/invoker/uploadServArch.php?idDigital=".$_GET['idDigital'],
	"certificationSignature" => false,
	"token" => "$token"
);


// Codificar en JSON y luego en Base64
$jsonSignatureParams = json_encode($signatureParams);

$base64EncodedParams = base64_encode($jsonSignatureParams);

// Enviar como respuesta
echo $base64EncodedParams;

function postRequest($url, $data) {
    $ch = curl_init($url);

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    // Desactivar la verificación del certificado SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Ejecutar la solicitud y obtener la respuesta
    $response = curl_exec($ch);

    // Verificar si hubo un error
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    // Cerrar la sesión cURL
    curl_close($ch);

    return $response;
}

?>