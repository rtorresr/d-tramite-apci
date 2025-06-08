<?php
ini_set('max_execution_time', 300);
set_time_limit(300);
error_reporting(E_ALL);
ini_set('display_errors', '1');
//stream_context_set_default(['http'=>['proxy'=>'http://triton:8080']]);

$options = array(
    'exceptions'=>true,
    'trace'=>1,  
    'proxy_host'     => 'http://triton',
    'proxy_port'     => '8080',
    'http' => array(
        'user_agent' => 'PHPSoapClient'
    )
    
);
//$url = '';

$params = array(
    "dni" => $_POST['NroDNI']
        //"nuDniConsulta" => $_POST['NroDNI'], //44069967
        //"nuDniUsuario" => 43169867,//43169867,
        //"nuRucUsuario" => 20504915523,//20504915523,
        //"password" => 198530,//198530,
);
//$url = 'https://ws5.pide.gob.pe/services/ReniecConsultaDni?wsdl';
$url = 'http://app.apci.gob.pe/ApiReniec_v2/Reniec.asmx?WSDL';
$client = new SoapClient($url, $options);
$query = $client->ConsultarDNI(array('arg0'=>$params));

$dp = $query->return->datosPersona;

array_walk_recursive($dp, function(&$val) {
    $val = utf8_encode($val);
});

print_r($query->return); die();

$datos = [];
$datos['nombres'] = $query->return->datosPersona->prenombres.' '.$query->return->datosPersona->apPrimer.' '.$query->return->datosPersona->apSegundo;
echo (json_encode($datos));
exit();