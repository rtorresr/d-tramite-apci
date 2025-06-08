<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>

</head>

<body>
<? $departamento=$_GET['departamento'];
   $dep2=$_GET['dep2'];	
   $departamento =  str_pad ($departamento,2,"0",str_pad_right); 
   include_once("../conexion/conexion.php");
   $sqlPro="  SELECT * from Tra_U_Provincia ";
   $sqlPro.=" WHERE  cCodDepartamento LIKE '$departamento' order by cNomProvincia ";
   $rsPro=sqlsrv_query($cnx,$sqlPro);
?>
<select name="cCodProvincia" onchange="getCity(<?php echo $departamento;?>,this.value)" style="width:236px">
 <option>Seleccione:</option>
  <?  while ($RsPro=sqlsrv_fetch_array($rsPro)){
    if($RsPro["cCodProvincia"]==$dep2){
	$selecPro="selected";
     }else{
     $selecPro="";
     }
    echo "<option value=".$RsPro["cCodProvincia"]." ".$selecPro.">".$RsPro[cNomProvincia]."</option>";
   } 
   sqlsrv_free_stmt($rsPro);	?>
</select>
</body>
</html>