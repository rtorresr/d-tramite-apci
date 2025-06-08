<?php
$serverName = "212.28.190.42";
$connectionOptions = array(
    "Database" => "DB_SITDD",
    "Uid" => "user_std",
    "PWD" => "pr0td3_2025",
    'CharacterSet' => 'UTF-8',
    "TrustServerCertificate" => true
);

$cnx2 = sqlsrv_connect($serverName, $connectionOptions);
