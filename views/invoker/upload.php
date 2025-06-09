<?php
require_once("../../conexion/conexion.php");
require_once("../../conexion/parametros.php");
require_once("../clases/DocDigital.php");

$docDigital = new DocDigital($cnx);
$docDigital->obtenerDocDigitalPorId($_GET['idDigital']);
$documenturl = RUTA_DTRAMITE.$docDigital->obtenerRutaDocDigital();
$documentName = $docDigital->clearName;


//if (isset($_FILES['signed_file'])){
    $separa=DIRECTORY_SEPARATOR;

    $tmp = dirname(tempnam (null,''));

    $concurrentDirectory = $tmp.$separa."upload";

    if (!mkdir($concurrentDirectory,0777,true) && !is_dir($concurrentDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }

    // $file_name = $_FILES['MyForm']['name'];
    // $file_tmp =$_FILES['MyForm']['tmp_name'];
    // $tamanio = $_FILES["MyForm"]["size"];
    // $tipo = $_FILES["MyForm"]["type"];

    //$file_name = $_FILES['signed_file']['name'];
    //$file_name = $_GET['idDigital'];
    $file_name = $documentName;
    $file_tmp = $_FILES['signed_file']['tmp_name'];
    $tamanio = $_FILES['signed_file']['size'];
    $tipo = $_FILES["signed_file"]["type"];

    move_uploaded_file($file_tmp,$tmp.$separa."upload".$separa.$file_name);

    echo $tmp . DIRECTORY_SEPARATOR . "upload" . DIRECTORY_SEPARATOR . $file_name;

//}

?>
