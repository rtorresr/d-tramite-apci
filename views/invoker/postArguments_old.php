<?php
require_once('config.php');
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once("../clases/DocDigital.php");
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');

session_start();

$type=$_POST['type'];
$flgRequireFirmaLote = $_POST['flgRequireFirmaLote'];

$flgArchivoTramite = isset($_POST['flgArchivoTramite']) ? 1: 0;

$docDigital = new DocDigital($cnx);

if($flgArchivoTramite == 0){
	$docDigital->obtenerDocDigitalPorId($_POST['idDigital']);
	$documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
} else {
	$docDigital->obtenerDocDigitalPorId($_POST['idDigital'], 1);
	$documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigitalSecundario();
}


$documentName = $docDigital->clearName;
// $documentName = $_POST['documentName'];
$posx =0;
$posy =0;
if($_POST['tipFirma']=='f'){
    //$firma = $_SESSION['firma'];
    $firma = "https://files.apci.gob.pe/srv-files/firmas/default/firma.png";
	
    $razon = 'Soy el autor del documento';
	if($_SESSION['flgDelegacion'] == 1 && $_SESSION['iCodOficinaLogin'] == 356){
		$razon = 'Delegacion de firma RDE N° 153-2023-APCI/DE';
	}

    $posx =515;
    $posy =174;
}else{
    $firma = $_SESSION['VistoBueno'];
    $razon = 'Visto Bueno';
    $posx =6;
    $posy =174 + 84*((int)$_POST['nroVisto']);
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
    1 => 'false',   // INTERNO
    2 => 'false',  // INTERNO
    3 => 'true',  // EXTERNO
    null => 'true'  // -
];

// Determinar el valor de selloTiempo basado en el mapeo
$idTipoTra = $_POST['idTipoTra'];
$selloTiempo = $selloTiempoMap[$idTipoTra] ?? 'true';


if($type=="W"){
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
?>