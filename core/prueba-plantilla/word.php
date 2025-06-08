<?php
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$nombre = 'abc.docx';
//$nombre = '160423102018-memo.docx';
//$var = shell_exec(' start C:/xampp/htdocs/sitdd/prueba-plantilla/'.$nombre);
//$var = shell_exec('start \\\\'.$host.'\\tmp\\'.$nombre);

$ejem ='start \\\\'.$host.'\\temp\\'.$nombre;
echo $ejem;

?>

<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=C:/xampp/htdocs/sitdd/prueba-plantilla/160423102018-memo.docx' width='500px' height='500px' frameborder='0'>
</iframe>

<iframe src="https://docs.google.com/gview?url=https://drive.google.com/uc?id=1GL1EyP9Mzg3HjmKmty6uzVIdNCvXvje76bkRRTaq9h4&embedded=true"></iframe>
