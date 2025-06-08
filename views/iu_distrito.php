<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<?php 
      $departamentoId=$_GET['departamento'];
	  $prov2=$_GET['prov2'];	
	  $departamentoId =  str_pad ($departamentoId,2,"0",str_pad_right); 
      $provinciaId=$_GET['provincia'];
	  $provinciaId =  str_pad ($provinciaId,2,"0",str_pad_right); 
	  include_once("../conexion/conexion.php");
	  $sqlDis="SELECT * from Tra_U_Distrito "; 
      $sqlDis.=" WHERE cCodDepartamento LIKE '$departamentoId' ";
      $sqlDis.=" AND cCodProvincia LIKE '$provinciaId' order by cNomDistrito "; 
      $rsDis=sqlsrv_query($cnx,$sqlDis);
?>
<select name="cCodDistrito" style="width:236px">
 <option>Seleccione:</option>
  <?php 
   while ($RsDis=sqlsrv_fetch_array($rsDis)){
    if($RsDis["cCodDistrito"]==$prov2){
	$selecDis="selected";
     }else{
     $selecDis="";
     }
    echo "<option value=".$RsDis["cCodDistrito"]." ".$selecDis.">".$RsDis[cNomDistrito]."</option>";
	} 
	sqlsrv_free_stmt($rsDis);?>
</select>
</body>
</html>
