<?php
/**
 * Created by PhpStorm.
 * User: acachay
 * Date: 12/11/2018
 * Time: 14:31
 */

/* Initialize webservice with your WSDL */
/* Set your parameters for the request */
$params = array(
    "vrucent" => 20504915523,
);
ini_set('max_execution_time', 300);
set_time_limit(300);

$host="https://ws3.pide.gob.pe/services/PcmIMgdTramite?wsdl";
//$host="http://200.48.76.125/wsentidad/Entidad?wsdl":

try {
    $options = array(
        'exceptions'=>true,
        'trace'=>1,
        //'stream_context' => stream_context_create($arrContextOptions)
    );
    $client = new SoapClient('https://ws3.pide.gob.pe/services/PcmIMgdTramite?wsdl', $options);
    print_r("correcto<br>");
    $funciones      = $client->__getFunctions();
    foreach ($funciones as $key => $value) {
            list($funcion) = explode(' ', $value);
             $funcion = str_replace('_Response','',$funcion);
             $funcion = str_replace('Response','',$funcion);
             echo $funcion."<br>";

     }
    //$query = $client->validarEntidad($params);
    //$query = $client->getListaEntidad();
    $query = $client->getTipoDocumento();
    var_dump($query);
    //echo $client->__getLastResponse();
    //echo ($query->return->datosPersona->apPrimer);

} catch (Exception $e) {
    echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}


exit();

