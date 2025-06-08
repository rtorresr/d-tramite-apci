<?php

$serverName = "192.168.1.45";
$connectionOptions = array(
    "Database" => "DB_SITDD",
    "Uid" => "sa",
    "PWD" => "sistemas$%",
    'CharacterSet' => 'UTF-8',
    "TrustServerCertificate" => true
);

//Establishes the connection
// try {
//     $cnx = sqlsrv_connect($serverName, $connectionOptions);
//    } catch (\Throwable $th) {
//     die(print_r($th));
//    } die(print_r(sqlsrv_errors(), true));

$cnx = sqlsrv_connect($serverName, $connectionOptions);