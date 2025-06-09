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

//$type=$_GET['type'];
$flgRequireFirmaLote = $_GET['flgRequireFirmaLote'];

$flgArchivoTramite = isset($_POST['flgArchivoTramite']) ? 1: 0;
//$flgArchivoTramite = 0;

$docDigital = new DocDigital($cnx);

if($flgArchivoTramite == 0){
	$docDigital->obtenerDocDigitalPorId($_GET['idDigital']);
	$documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
} else {
	$docDigital->obtenerDocDigitalPorId($_GET['idDigital'], 1);
	$documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();
}


$documentName = $docDigital->clearName;
// $documentName = $_POST['documentName'];
$posx = 0;
$posy = 0;
if($_GET['tipFirma']=='f'){
    //$firma = $_SESSION['firma'];
    $firma = "https://files.apci.gob.pe/srv-files/firmas/default/firma.png";
	
    $razon = 'Soy el autor del documento';
	//INICIO OMITIDO
	/*if($_SESSION['flgDelegacion'] == 1 && $_SESSION['iCodOficinaLogin'] == 356){
		$razon = 'Delegacion de firma RDE N° 153-2023-APCI/DE';
	}*/
	//FIN OMITIDO


    $posx =515;
    $posy =174;
}else{
    $firma = $_SESSION['VistoBueno'];
    $razon = 'Visto Bueno';
    $posx =6;
    $posy =174 + 84*((int)$_GET['nroVisto']);
}


// if($type=="L") {
// 	$param ='{
// 			"app":"pdf",
// 			"fileUploadUrl":"'.$FILEUPLOADURL.'",
// 			"reason":"'.$razon.'",
// 			"type":"'.$type.'",
// 			"clientId":"'.$CLIENTID.'",
// 			"clientSecret":"'.$CLIENTSECRET.'",
// 			"dcfilter":".*FIR.*|.*FAU.*",
// 			"fileDownloadUrl":"",
// 			"posx":"'.$posx.'",
// 			"posy":"'. $posy.'",
// 			"outputFile":"'.$documentName.'",
// 			"protocol":"T",
// 			"contentFile":"",
// 			"stampAppearanceId":"2",
// 			"isSignatureVisible":"true",
// 			"idFile":"MyForm",
// 			"fileDownloadLogoUrl":"'.$SERVER_PATH.'/resources/img/iLogo1.png",
// 			"fileDownloadStampUrl":"'.$SERVER_PATH.'/resources/img/iFirma1.png",
// 			"pageNumber":"0",
// 			"maxFileSize":"5242880",
// 			"fontSize":"7",			
// 			"timestamp":"true"
// 		}';

// 		echo  base64_encode($param);

		
// 	//$array = array(
		    
// 	     //   'idRegister' => $ID_REGISTER,
// 	      //  'idFile'  => '002',
// 	      //  'type'  => 'L', /*L=Documento está en la PC , W=Documento está en la Web.*/
// 	     //   'protocol'  => $PROTOCOL, /*T=http, S=https (SE RECOMIENDA HTTPS)*/
// 	     //   'fileDownloadUrl'  =>'',
// 	     //   'fileDownloadLogoUrl'  =>$DIR_IMAGE.'iLogo1.png',
// 	     //   'fileDownloadStampUrl'  =>$DIR_IMAGE.'iFirma1.jpg',
// 	     //   'fileUploadUrl' =>$DIR_UPLOAD.'upload.php',                   
// 	     //   'contentFile' => '',
// 	     //   'reason' => 'Soy el autor del documento',
// 	     //   'isSignatureVisible' => 'true',            
// 	     //   'stampAppearanceId' => '0', /*0:(sello+descripcion) horizontal, 1:(sello+descripcion) vertical, 2:solo sello, 3:solo descripcion*/
// 	     //   'pageNumber' => '0',
// 	     //   'posx' => '5',
// 	     //   'posy' => '5',
// 	     //   'width' => '170',        
// 	     //   'fontSize' => '9' ,
// 	    //    'dcfilter' => '.*FIR.*|.*FAU.*', /*'.*' todos, solo fir '.*FIR.*|.*FAU.*'*/
// 	     //   'timestamp' => 'false',               
// 	     //   'outputFile' => $documentName,  
// 	      //  'maxFileSize' => '5242880' /*Por defecto será 5242880 5MB - Maximo 100MB*/
// 	    //);

// 		//echo  base64_encode( json_encode($array) );

// }	




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


/*if($type=="W"){
	if($flgRequireFirmaLote == 1){
		$param ='{
			"app":"pcx",
			"mode":"lot-p",
			"clientId":"'.$CLIENTID.'",
			"clientSecret":"'.$CLIENTSECRET.'",
			"idFile":"MyForm",
			"type":"'.$type.'",
			"protocol":"S",
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
	} else {	
		$param ='{
			"app":"pdf",
			"fileUploadUrl":"'.$FILEUPLOADURL.'",
			"reason":"'.$razon.'",
			"type":"'.$type.'",
			"clientId":"'.$CLIENTID.'",
			"clientSecret":"'.$CLIENTSECRET.'",
			"dcfilter":".*FIR.*|.*FAU.*",
			"fileDownloadUrl":"'.$documenturl.'",
			"posx":"'.$posx.'",
			"posy":"'. $posy.'",
			"outputFile":"'.$documentName.'",
			"protocol":"S",
			"contentFile":"firmado.pdf",
			"stampAppearanceId":"2",
			"isSignatureVisible":"true",
			"idFile":"MyForm",
			"fileDownloadLogoUrl":"'.$SERVER_PATH.'/resources/img/iLogo1.png",
			"fileDownloadStampUrl":"'.$firma.'",
			"pageNumber":"0",
			"maxFileSize":"5242880",
			"fontSize":"6",			
			"timestamp":"'.$selloTiempo.'"
		}';
		//"timestamp":"true"
		
	}
	echo  base64_encode($param);
}
*/


/*
// URL del token, pasando el parámetro `token`
$url = "http://localhost/d-tramite-final/views/invoker/token.php?token=token";

// Obtener el contenido de la URL (el token)
$token = file_get_contents($url);
*/

$token = trim(file_get_contents("http://localhost/d-tramite-final/views/invoker/token.php"));


/*
$url = "http://localhost/d-tramite-final/views/invoker/token.php?token=token";

// Inicializa cURL
$ch = curl_init();

// Opciones de cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecuta y obtiene la respuesta
$token = curl_exec($ch);

// Cierra la sesión cURL
curl_close($ch);

*/


//FIRMA PERU

if($flgRequireFirmaLote == 1){

	$signatureParams = array(
		"signatureFormat" => "PAdES",
		"signatureLevel" => $selloTiempo,
		"signaturePackaging" => "enveloped",
		//"documentToSign" => "http://192.168.10.18/mostrarDocumento.php?d=eyJpZERpZ2l0YWwiOjExNDYwNTd9",
		"documentToSign" =>$documenturl,
		"certificateFilter" => ".*FIR.*|.*FAU.*",
		"webTsa" => "https://apps.firmaperu.gob.pe/admin/api/security/generate-token",
		"userTsa" => $CLIENTID,
		"passwordTsa" => $CLIENTSECRET,
		"theme" => "claro",
		"visiblePosition" => false,
		"contactInfo" => "",
		"signatureReason" => $razon,
		"signatureStyle" => 0,
		"imageToStamp" => $SERVER_PATH."/resources/img/iLogo1.png",
		"stampTextSize" => 14,
		"stampWordWrap" => 37,
		"role" => "Analista de servicios",
		"stampPage" => 1,
		"positionx" => 400,
		"positiony" => 400,
		"bachtOperation" => false,	//para firma con lote
		"oneByOne" => true,		////para firma con lote
		//"uploadDocumentSigned" => "http://localhost/d-tramite-final/views/invoker/uploadRest.php?name=123",
		"uploadDocumentSigned" => "http://localhost/d-tramite-final/views/invoker/upload.php?idDigital=".$_GET['idDigital'],
		"certificationSignature" => false,
		"token" => "eyJhbGciOiJFUzUxMiIsInR5cCI6IkpXVCIsImtpZCI6IjE2NTUzMjY3MTI3NDEifQ.eyJpc3MiOiJQbGF0YWZvcm1hIE5hY2lvbmFsIGRlIEZpcm1hIERpZ2l0YWwgLSBGaXJtYSBQZXLDuiIsInN1YiI6IkZpcm1hZG9yIiwiZXhwIjoxNzQ3MTQzNTYzLCJpYXQiOjE3NDcwNTcxNjMsImp0aSI6Inc0TnpwVWs4N3pJd05UQTBPVEUxTlRJemNQYk0zM0VyeVEiLCJ2ZXIiOiIxLjAuMCYxLjEuMCIsImVudCI6ImVudGl0eV90eXBlPVNpbiBlc3BlY2lmaWNhciwgZW50aXR5PUFnZW5jaWEgUGVydWFuYSBkZSBDb29wZXJhY2nDs24gSW50ZXJuYWNpb25hbCwgaW5pdGlhbHM9QVBDSSwgZG9jdW1lbnQ9MjA1MDQ5MTU1MjMiLCJhcHAiOiJELVRSQU1JVEUiLCJhaWQiOiJjN1RTSzVMSml2WDIwWkhpQ2t1VzFCQldXNCtJUjc0aUdKMERQNjhXZlY1bGQ3RXhiQWtpZDZlVVhmcHI3ekNxIiwidG9rIjoiTUtoTTA3SWJJSWZuN3FTRWFpa0daRU5KS0FyYmdNSDNHTzBmalFlTFkwdHZVUytUdHphZ29LT2ozV0hnVUJ2MWQ3bDBDNnAzTG5JS3FNUnFxMkV6OVE9PSIsIm13cyI6IldlUWFTSjNwTWFVQzNVN1BNYkJ3SENrNHV6UEVSZXQ2VVJicjRiRGdUZlM4dzNzOGlQVldBeDlOZEYzQnZCUzNjbjJGRmZ5TXB3dit3OU9Da21XMFRRPT0ifQ.AOq3LY7orcF2YmOQVboQCC9V8PxftTkXD96aDx3n4borYr4CQ_dwjSLtPFBi8aa9pc4rYTSKjTsv921nG4qU1PywAQSMq5cklcFTN0FwDs-uVfWdSX7AooHcfWjKboZIqEBRI-iURaiJ7THtAb4--t8CePRxlEANEgBLKGXlJ9ekxuqT"
	);

} else {

	$signatureParams = array(
		"signatureFormat" => "PAdES",
		//"signatureLevel" => "B",
		"signatureLevel" => $selloTiempo,
		"signaturePackaging" => "enveloped",
		//"documentToSign" => "http://192.168.10.18/mostrarDocumento.php?d=eyJpZERpZ2l0YWwiOjExNDYwNTd9",
		"documentToSign" =>$documenturl,
		//"certificateFilter" => ".*",
		"certificateFilter" => ".*FIR.*|.*FAU.*",
		"webTsa" => "https://apps.firmaperu.gob.pe/admin/api/security/generate-token",
		"userTsa" => $CLIENTID,
		"passwordTsa" => $CLIENTSECRET,
		"theme" => "claro",
		"visiblePosition" => false,
		"contactInfo" => "",
		"signatureReason" => $razon,
		"signatureStyle" => 0,
		//"imageToStamp" => "http://192.168.10.18/views/invoker/resources/img/iLogo1.png",
		"imageToStamp" => $SERVER_PATH."/resources/img/iLogo1.png",
		"stampTextSize" => 14,
		"stampWordWrap" => 37,
		"role" => "Analista de servicios",
		"stampPage" => 1,
		//"positionx" => $posx,
		//"positiony" => $posy,
		"positionx" => 400,
		"positiony" => 400,
		"bachtOperation" => false,	//para firma con lote
		"oneByOne" => true,		////para firma con lote
		//"uploadDocumentSigned" => "http://localhost/d-tramite-final/views/invoker/uploadRest.php?name=123",
		"uploadDocumentSigned" => "http://localhost/d-tramite-final/views/invoker/upload.php?idDigital=".$_GET['idDigital'],
		"certificationSignature" => false,
		//"token" => "eyJhbGciOiJFUzUxMiIsInR5cCI6IkpXVCIsImtpZCI6IjE2NTUzMjY3MTI3NDEifQ.eyJpc3MiOiJQbGF0YWZvcm1hIE5hY2lvbmFsIGRlIEZpcm1hIERpZ2l0YWwgLSBGaXJtYSBQZXLDuiIsInN1YiI6IkZpcm1hZG9yIiwiZXhwIjoxNzQ3MjUzNjk5LCJpYXQiOjE3NDcxNjcyOTksImp0aSI6Inc0TnpwVWs4N3pJd05UQTBPVEUxTlRJemNQYk0zM0VyeVEiLCJ2ZXIiOiIxLjAuMCYxLjEuMCIsImVudCI6ImVudGl0eV90eXBlPVNpbiBlc3BlY2lmaWNhciwgZW50aXR5PUFnZW5jaWEgUGVydWFuYSBkZSBDb29wZXJhY2nDs24gSW50ZXJuYWNpb25hbCwgaW5pdGlhbHM9QVBDSSwgZG9jdW1lbnQ9MjA1MDQ5MTU1MjMiLCJhcHAiOiJELVRSQU1JVEUiLCJhaWQiOiJjN1RTSzVMSml2WDIwWkhpQ2t1VzFCQldXNCtJUjc0aUdKMERQNjhXZlY1bGQ3RXhiQWtpZDZlVVhmcHI3ekNxIiwidG9rIjoiTUtoTTA3SWJJSWZuN3FTRWFpa0daRU5KS0FyYmdNSDNHTzBmalFlTFkwdHZVUytUdHphZ29LT2ozV0hnVUJ2MWQ3bDBDNnAzTG5JS3FNUnFxMkV6OVE9PSIsIm13cyI6IldlUWFTSjNwTWFVQzNVN1BNYkJ3SENrNHV6UEVSZXQ2VVJicjRiRGdUZlM4dzNzOGlQVldBeDlOZEYzQnZCUzNjbjJGRmZ5TXB3dit3OU9Da21XMFRRPT0ifQ.AVsEYmMIcTBxJuyE_l3HOYjLbMl9l3R0wQdX9VM92NEr_H51_mtsuycRDxjqiLDCoUGk0wEPnflZM0dYhVXFanP1ADsMugikbE5NKxnxDCEIv50RI43JiXJJa9ENqD3uWdjfZXfnDVmx5cgO5dSQJnTIxJYiCpwGppbfQv2yzxxp-C5E"
		//"token" => $token
		"token" => "$token"
	);

}


// Codificar en JSON y luego en Base64
$jsonSignatureParams = json_encode($signatureParams);

$base64EncodedParams = base64_encode($jsonSignatureParams);

// Enviar como respuesta
echo $base64EncodedParams;

?>