<?php
require_once('../clases/Zip.php');
require_once('../clases/DocDigital.php');
require_once("../clases/Log.php");
require_once('../../vendor/autoload.php');
include_once("../../conexion/conexion.php");
include_once("../../conexion/parametros.php");

$Evento = $_POST['evento'];

switch($Evento){
    case "AgregarAZip":
        $retorno = new StdClass();        

        $codigo = $_POST['codigo'];
        $nombre = strtoupper(DocDigital::formatearNombre($_POST['nombre'],false,['/',' ']));

        $nombreZip = $_POST['nombreZip'];

        $docDigital = new DocDigital($cnx);

        // Documento principal
        $docDigital->idTramite = $codigo;
        $docDigital->obtenerDocMayor();

        $documento = $docDigital->obtenerDocBinario();
        
        if ($documento){
            $result = Zip::agregarArchivo('../../archivosTemp/'.$nombreZip.'.zip',$nombre.'/'.$docDigital->clearName,$documento);
            if ($result->success){
                $retorno->success = true;
                $retorno->message = 'Documento principal Zip creado correctamente';

                // Anexos
                $docDigital->idTipo = 3;
                $ids = $docDigital->obtenerDocTramite();
                if (count($ids) > 0){
                    foreach($ids as $idAnexo){
                        $docDigital->obtenerDocDigitalPorId($idAnexo);
                        $documentoAnexo = $docDigital->obtenerDocBinario();
                        if ($documentoAnexo){
                            $resultAnexo = Zip::agregarArchivo('../../archivosTemp/'.$nombreZip.'.zip',$nombre.'/Anexos/'.$docDigital->clearName,$documentoAnexo);
                            if (!$resultAnexo->success){
                                $retorno->message .= '; {$resultAnexo->message}';
                            }
                        }
                    }
                }
            } else {
                $retorno->success = false;
                $retorno->message = $result->message;
            }
        } else {
            $retorno->success = false;
            $retorno->message = 'No se pudo obtener el documento principal';
        }

        echo json_encode($retorno);
        break;
    case "EliminarZip":
        $nombreZip = $_POST['nombreZip'];
        DocDigital::eliminar('../../archivosTemp/'.$nombreZip.'.zip');
        break;
}
?>