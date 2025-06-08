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
    //"tipoParticipante" => $_REQUEST['persona'], //44069967
    "tipoParticipante" => 'J',
    "razonSocial" => ''
);
ini_set('max_execution_time', 300);
set_time_limit(300);

try {
    $options = array(
        'exceptions'=>true,
        'trace'=>1,
        //'stream_context' => stream_context_create($arrContextOptions)
    );
    $client = new SoapClient('https://ws3.pide.gob.pe/services/SunarpPideService?wsdl', $options);
    //print_r("correcto<br>");
    /*$funciones      = $client->__getFunctions();
    foreach ($funciones as $key => $value) {
            list($funcion) = explode(' ', $value);
             $funcion = str_replace('_Response','',$funcion);
             $funcion = str_replace('Response','',$funcion);
             echo $funcion."<br>";

     }*/
    $query = $client->consultar(array('arg0'=>$params));
    //var_dump($query);
    //echo $client->__getLastResponse();
    //echo ($query->return->datosPersona->apPrimer);

} catch (Exception $e) {
    echo "<h2>Exception Error!</h2>";
    echo $e->getMessage();
}

if ($_REQUEST['type']==='json'){
    $dp = $query->return->datosPersona;
    array_walk_recursive($dp, function(&$val) {
        $val = utf8_encode($val);
    });
    echo (json_encode($dp, JSON_FORCE_OBJECT| JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
    exit();
}

?>
