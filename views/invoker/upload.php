<?php
if (isset($_FILES['MyForm']))
{
    $separa=DIRECTORY_SEPARATOR;

    $tmp = dirname(tempnam (null,''));

    $concurrentDirectory = $tmp.$separa."upload";

    if (!mkdir($concurrentDirectory,0777,true) && !is_dir($concurrentDirectory)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
    }

    $file_name = $_FILES['MyForm']['name'];
    $file_tmp =$_FILES['MyForm']['tmp_name'];
    $tamanio = $_FILES["MyForm"]["size"];
    $tipo = $_FILES["MyForm"]["type"];

    move_uploaded_file($file_tmp,$tmp.$separa."upload".$separa.$file_name);
}

?>
