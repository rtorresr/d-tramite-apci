<?php

define('DISPLAY_XPM4_ERRORS', true); // display XPM4 errors
require_once 'SMTP.php'; // path to 'SMTP.php' file from XPM4 package

$f = 'christian_m@llampanet.net'; // from mail address
$t = 'christian_m@lcpconsultores.com'; // to mail address

// standard mail message RFC2822
$m = 'From: '.$f."\r\n".
     'To: '.$t."\r\n".
     'Subject: test'."\r\n".
     'Content-Type: text/plain'."\r\n\r\n".
     'Text message.';

$h = explode('@', $t); // get client hostname
$c = SMTP::MXconnect($h[1]); // connect to SMTP server (direct) from MX hosts list
$s = SMTP::Send($c, array($t), $m, $f); // send mail
// print result
if ($s) echo 'Sent !';
else print_r($_RESULT);
SMTP::Disconnect($c); // disconnect

?>