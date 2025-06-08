<?php
	function secureSQL( $strVar ){
     $banned = array("select", "drop", ";", "--", "insert","delete", "xp_","update");  

    for ($i = 0 ;$i <=  strlen($banned);$i++) { 
            $strVar = str_replace( $banned[$i], "'",$strVar)  ;
      
	  }
      $final = str_replace( "'", "''",$strVar)  ;
     $secureSQL = $final;
	return 	  $secureSQL;
}
	
/*	
if(is_array($_GET) ) 
{ 
foreach ($_GET as $_GET_nombre=>$_GET_contenido) 
{ 
$_GET[$_GET_nombre]= seguridad_x($_GET_contenido); 
} 
} 
if(is_array($_POST) ) 
{ 
foreach ($_POST as $_POST_nombre=>$_POST_contenido) 
{ 
$_GET[$_POST_nombre]= seguridad_x($_POST_contenido); 
} 
} 
function seguridad_x($texto){ 
$texto    = stripslashes($texto); 
$texto    = addslashes($texto);
$texto= ereg_replace("'","",$texto);
$texto= ereg_replace(";","",$texto); 
$texto= ereg_replace("<","",$texto); 
$texto= ereg_replace(">","",$texto); 
$texto= ereg_replace("/","",$texto); 
$texto= ereg_replace(':',"",$texto); 
return $texto; 
}?> */
?>
