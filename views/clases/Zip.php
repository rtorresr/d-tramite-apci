<?php
// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting(0);

class Zip
{
    static function agregarArchivo($zipRoute,$fileName,$fileContent,$sobreescribir = false){
        $retorno = new StdClass();
        try {
            $zip = new ZipArchive;
            if ($zip->open($zipRoute,ZIPARCHIVE::CREATE)) {        
                $zip->addFromString($fileName,$fileContent);
                $zip->close();
            } else {
                $retorno->success = false;
                $retorno->message = "No se pudo abrir el zip";
            }

            $retorno->success = true;
            $retorno->message = "Archivo {$fileName} cargado correctamente ";
        } catch (Throwable $e){
            $retorno->success = false;
            $retorno->message = "No se puedo cargar el archivo {$fileName}. Error: {$e->getMessage()}";
        }
        return $retorno;
    }
}