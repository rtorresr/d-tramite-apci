<?php
$uploadpath = $_POST['path'];
$name       = $_POST['name'];
$newname = $_POST['new_name'];
$filedata = $_FILES[$name]['tmp_name'];
$filename = $_FILES[$name]['name'];

$retorno = new StdClass();

try{
    if (!mkdir($uploadpath, 0777, true) && !is_dir($uploadpath)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $uploadpath));
    }else{
        chmod($uploadpath, 0777);
        if (copy($filedata, $uploadpath . $newname)){
            $retorno->success = true;
            $retorno->mensaje = "Guardado correctamente el documento $newname";
            chmod($uploadpath.$newname, 0755);
        }else{
            throw new \Exception(sprintf('No se pudo guardar el documento "%s"', $newname));
        }
        chmod($uploadpath, 0755);
    }
} catch (\RuntimeException $e) {
    $retorno->success = false;
    $retorno->mensaje = $e->getMessage();
} catch (\Exception $e){
    $retorno->success = false;
    $retorno->mensaje = $e->getMessage();
}
echo json_encode($retorno);