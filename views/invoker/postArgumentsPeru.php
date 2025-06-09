<?php
// Configuración de cabeceras para permitir acceso desde otros dominios
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain'); // Responder en texto plano
header('Cache-Control: no-cache'); // Evitar cacheo

require_once('config.php');
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once("../clases/DocDigital.php");
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');


$pades = $_GET['pades']; 


$signatureParams = array(
   // "signatureFormat" => $pades,
    "signatureFormat" => "PAdES",
    "signatureLevel" => "B",
    "signaturePackaging" => "enveloped",
    "documentToSign" => "http://192.168.10.18/mostrarDocumento.php?d=eyJpZERpZ2l0YWwiOjExNDYwNTd9",
    //"documentToSign" =>$documenturl,
    "certificateFilter" => ".*",
    "webTsa" => "https://apps.firmaperu.gob.pe/admin/api/security/generate-token",
    "userTsa" => "XWWnOE4bCwMB7y-pMHah_3",
    "passwordTsa" => "w4NzpUk87zIwNTA0OTE1NTIQ",
    "theme" => "claro",
    "visiblePosition" => false,
    "contactInfo" => "",
    "signatureReason" => "Soy el autor de este documento",
    "signatureStyle" => 1,
    "imageToStamp" => "http://192.168.10.18/views/invoker/resources/img/iLogo1.png",
    "stampTextSize" => 14,
    "stampWordWrap" => 37,
    "role" => "Analista de servicios",
    "stampPage" => 1,
    "positionx" => 300,
    "positiony" => 300,
    "bachtOperation" => false,
    "oneByOne" => true,
    "uploadDocumentSigned" => "http://localhost/d-tramite-final/views/invoker/uploadRest.php",
    //"uploadDocumentSigned" => "http://192.168.10.18/views/invoker/uploadRest.php",
    "certificationSignature" => false,
    "token" => "eyJhbGciOiJFUzUxMiIsInR5cCI6IkpXVCIsImtpZCI6IjE2NTUzMjY3MTI3NDEifQ.eyJpc3MiOiJQbGF0YWZvcm1hIE5hY2lvbmFsIGRlIEZpcm1hIERpZ2l0YWwgLSBGaXJtYSBQZXLDuiIsInN1YiI6IkZpcm1hZG9yIiwiZXhwIjoxNzQ2ODA4NjQxLCJpYXQiOjE3NDY3MjIyNDEsImp0aSI6Inc0TnpwVWs4N3pJd05UQTBPVEUxTlRJemNQYk0zM0VyeVEiLCJ2ZXIiOiIxLjAuMCYxLjEuMCIsImVudCI6ImVudGl0eV90eXBlPVNpbiBlc3BlY2lmaWNhciwgZW50aXR5PUFnZW5jaWEgUGVydWFuYSBkZSBDb29wZXJhY2nDs24gSW50ZXJuYWNpb25hbCwgaW5pdGlhbHM9QVBDSSwgZG9jdW1lbnQ9MjA1MDQ5MTU1MjMiLCJhcHAiOiJELVRSQU1JVEUiLCJhaWQiOiJjN1RTSzVMSml2WDIwWkhpQ2t1VzFCQldXNCtJUjc0aUdKMERQNjhXZlY1bGQ3RXhiQWtpZDZlVVhmcHI3ekNxIiwidG9rIjoiTUtoTTA3SWJJSWZuN3FTRWFpa0daRU5KS0FyYmdNSDNHTzBmalFlTFkwdHZVUytUdHphZ29LT2ozV0hnVUJ2MWQ3bDBDNnAzTG5JS3FNUnFxMkV6OVE9PSIsIm13cyI6IldlUWFTSjNwTWFVQzNVN1BNYkJ3SENrNHV6UEVSZXQ2VVJicjRiRGdUZlM4dzNzOGlQVldBeDlOZEYzQnZCUzNjbjJGRmZ5TXB3dit3OU9Da21XMFRRPT0ifQ.ABYfUJfv-obznEt2ipzv_u2il1MLG-NJEjI-Xjo94fxJSY33fOa0ZCRO3HUrpcEjcCoXsmSrFKRxEayG2kffYuBJATzaE_xuersHU3jj4CoNRDoeKi_CV1rkSp_YSQdHmck2lwaYSUhxa04o3swbA9MZDICIKbBXRXYjXFkCausTJgfn"
);

// Codificar en JSON y luego en Base64
$jsonSignatureParams = json_encode($signatureParams);
/*
var_dump('jsonSignatureParams');
var_dump($signatureParams);
*/
$base64EncodedParams = base64_encode($jsonSignatureParams);

// Enviar como respuesta
echo $base64EncodedParams;












?>
