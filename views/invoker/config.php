<?php
$CLIENTID="62Az1GtrpqE9oG11isP2rv7r2Fw";
$CLIENTSECRET="9GjNw61PKwC3V_eoxQ-f";
//$PROTOCOL="http://";

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$SERVER_PATH=$actual_link."/views/invoker";
$FILEUPLOADURL=$SERVER_PATH."/upload.php";

//$FILEDOWNLOADLOGOURL="http://localhost:8182-php/invoker/img/iLogo1.png";

//$FILEDOWNLOADSTAMPURL="http://localhost:8182-php/formd/refirma/img/iFirma1.jpg";


//$FILEDOWNLOADURL="http://localhost:8182-php/invoker/";

//$UPLOAD_DIRECTORY = "http://localhost:8182/invoker-php/upload/";


?>