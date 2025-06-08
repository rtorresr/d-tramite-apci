<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<script>
function ConfirmarBorrado()
{
 if (confirm("Esta seguro de eliminar el registro?")){
  return true; 
 }else{ 
  return false; 
 }
}
</script>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>
 
	<?php include("includes/menu.php");?>



<!--Main layout-->
 <main class="mx-lg-5">
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-md-12 mb-12">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

<div class="AreaTitulo">Mantenimiento >> M. Doc. Identidad</div>



<form name="form1" method="GET" action="iu_doc_identidad.php">
<table width="800" border="0" align="center">
  <tr>
    <td>
      <fieldset><legend>Criterios de B�squeda:</legend> 
      <br>
<table width="750" border="0" align="center">
     <tr>
    <td >Documento de Identidad:</td>
    <td align="left"><label>
 <input name="cDescDocIdentidad" class="FormPropertReg form-control" type="text" value=<?php echo $_REQUEST['cDescDocIdentidad'];?>>
    </label>
    </td>  	
  </tr>
  <tr>
    <td height="42" colspan="4"> 
     <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"></button>
    &nbsp;
     <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"></button>
		&nbsp;	           
            <button class="btn btn-primary" onClick="window.open('iu_doc_identidad_xls.php?cDescDocIdentidad=<?=$_GET[cDescDocIdentidad]?>&orden=<?=$orden?>&campo=<?=$campo?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
		&nbsp;	
            <button class="btn btn-primary" onClick="window.open('iu_doc_identidad_pdf.php?cDescDocIdentidad=<?=$_GET[cDescDocIdentidad]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>

</form>

<table width="352" border="1" align="center">
  
<?php
function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
$total_paginas = ceil($total/$por_pagina);
$anterior = $actual - 1;
$posterior = $actual + 1;
$minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
$maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
if ($actual>1)
$texto = "<a href=\"$enlace$anterior\">�</a> ";
else
$texto = "<b>�</b> ";
if ($minimo!=1) $texto.= "... ";
for ($i=$minimo; $i<$actual; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
$texto .= "<b>$actual</b> ";
for ($i=$actual+1; $i<=$maximo; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
if ($maximo!=$total_paginas) $texto.= "... ";
if ($actual<$total_paginas)
$texto .= "<a href=\"$enlace$posterior\">�</a>";
else
$texto .= "<b>�</b>";
return $texto;
}


if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
$tampag = 15;
$reg1 = ($pag-1) * $tampag;


// ordenamiento
if($_GET['campo']==""){
	$campo="Identidad";
}Else{
	$campo=$_GET['campo'];
}

if($_GET['orden']==""){
	$orden="ASC";
}Else{
	$orden=$_GET['orden'];
}

//invertir orden
if($orden=="ASC") $cambio="DESC";
if($orden=="DESC") $cambio="ASC";
/*$sql="select * from Tra_M_Doc_Identidad ";
$sql.=" WHERE cTipoDocIdentidad>0 ";
if($_GET[cDescDocIdentidad]!=""){
$sql.=" AND cDescDocIdentidad like '%$cDescDocIdentidad%' ";
}

$sql.="ORDER BY cTipoDocIdentidad ASC";*/
 //Define Procedure 
//$proce = 'SP_DOC_IDENTIDAD_LISTA'; 
//$proc = sqlsrv_init($proce, $cnx); 

//Define Parameters 
 $parm1 =str_replace('\"','"',$_GET[cDescDocIdentidad]);
 
//Load Parameters 
// sqlsrv_bind($proc, '@i_cDescDocIdentidad', $parm1, SQLVARCHAR, false, false, 100); 
// sqlsrv_bind($proc, '@i_dir', $orden, SQLVARCHAR, false, false, 10); 
// sqlsrv_bind($proc, '@i_columna', $campo, SQLVARCHAR, false, false, 10); 

// //Execute Procedure 
// $rs=sqlsrv_query($proc);
//print($rs);
//Free Memory 
//sqlsrv_free_stmt($proc);
$sql= " SP_DOC_IDENTIDAD_LISTA '%$_GET[cDescDocIdentidad]%' ,'".$orden."' , '".$campo."' ";
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);

?>
<tr>
	<td width="179" class="headCellColum"><a style=" text-decoration:<?php if($campo=="Identidad"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Identidad&orden=<?=$cambio?>&cDescDocIdentidad=<?=$_GET[cDescDocIdentidad]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>">Documento de Identidad</a></td>
	<td width="83" class="headCellColum">Opciones</td>
</tr>
<?php
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
	echo "NO SE ENCONTRARON REGISTROS<br>";
	echo "TOTAL DE REGISTROS : ".$numrows;
}else{
         echo "TOTAL DE REGISTROS : ".$numrows;
	for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
sqlsrv_fetch_array($rs, $i);
$Rs=sqlsrv_fetch_array($rs);
//while ($Rs=sqlsrv_fetch_array($rs)){
	if ($color == "#CEE7FF"){
			  $color = "#F9F9F9";
	    		}else{
			  $color = "#CEE7FF";
	    		}
	    		if ($color == ""){
			  $color = "#F9F9F9";
	    		}	
?>
<tr bgcolor="<?=$color?>">
    <td align="left"><?php echo $Rs[cDescDocIdentidad];?></td>
    <td> 
    	<a href="../controllers/ln_elimina_doc_identidad.php?id=<?php echo $Rs[cTipoDocIdentidad];?>&cDescDocIdentidad=<?=$_REQUEST['cDescDocIdentidad']?>&pag=<?=$pag?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
	    <a href="/iu_actualiza_doc_identidad.php?cod=<?php echo $Rs[cTipoDocIdentidad];?>&sw=6&cDescDocIdentidad=<?=$_REQUEST['cDescDocIdentidad']?>&pag=<?=$pag?>"><i class="fas fa-edit"></i></a></td>
  </tr>
  
<?php
}
}
?>
</table>
<?php echo paginar($pag, $total, $tampag, "iu_doc_identidad.php?pag=");?>
<table width="400" border="0" align="center">
  <tr>
    <td align="right"><?echo "<a class='btn btn-primary' href='iu_nuevo_doc_identidad.php'>Nuevo Doc de Identidad</a>";
?>
</td>
  </tr>
</table>

</td>
  </tr>
	</table>



<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php
}Else{
   header("Location: ../index-b.php?alter=5");
}
?>