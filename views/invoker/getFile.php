<?php
require("config.php");

$documentName = $_REQUEST["documentName"]; 

$separa=DIRECTORY_SEPARATOR;

$tmp = dirname(tempnam (null,''));
//$tmp = $SERVER_PATH;

$archivo = $tmp.$separa."upload".$separa.$documentName;
//echo  $archivo; exit();

//$file_tmp = $SERVER_PATH;
//move_uploaded_file($file_tmp,$tmp.$separa."upload".$separa.$file_name);

//print_r($archivo); die();
//move_uploaded_file($archivo, "a.pdf");
//print_r($archivo); die();
header('Content-Type: application/pdf');
//header('Content-Disposition:attachment;filename="'.$documentName.'"');
readfile($archivo);

//echo $archivo;
?>
