<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_categoria.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de Categorias para el Perfil Administrador 
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creaci�n del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
$pag = $_GET['pag'];
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

<div class="AreaTitulo">Mantenimiento >> M. Categor�a</div>


<form name="form1" method="GET" action="iu_categoria.php">
<table width="800" border="0" align="center">
  <tr>
    <td>
      <fieldset><legend>Criterios de B�squeda:</legend> 
     <table width="750" border="0" align="center">
     <tr>
    <td width="315" height="42"  >Categor�a:</td>
    <td width="425" align="left"><label>
      <input name="cCategoria" class="FormPropertReg form-control" type="text" value="<?=$_GET[cCategoria]?>" />
    </label>
    </td>  	
  </tr>
  <tr>
    <td colspan="4" align="center">
    <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"></button>
    &nbsp;
     <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"></button>
		&nbsp;	           
    <button class="btn btn-primary" onClick="window.open('iu_categoria_xls.php?cCategoria=<?=$_GET[cCategoria]?>&orden=<?=$orden?>&campo=<?=$campo?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
		&nbsp;	
            <button class="btn btn-primary" onClick="window.open('iu_categoria_pdf.php?cCategoria=<?=$_GET[cCategoria]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>


</form>

<table width="225" border="1" align="center">
  
<?
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
	$campo="Categoria";
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
/*$sql= "SELECT * FROM Tra_M_Categoria";
$sql.=" WHERE iCodCategoria>0 ";
if($_GET[cCategoria]!=""){
$sql.=" AND cDesCategoria like '%$_GET[cCategoria]%' ";
}
$sql.=" ORDER BY cDesCategoria ASC";*/
$sql=" SP_CATEGORIA_LISTA '%$_GET[cCategoria]%' ,'".$orden."' , '".$campo."' ";
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);
//echo $sql;
?>
<tr>
	<td width="144" class="headCellColum"><a   style="text-decoration:<?php if($campo=="Categoria"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Categoria&orden=<?=$cambio?>&cCategoria=<?=$_GET[cCategoria]?>">Categor�a</a></td>
  <td width="65" class="headCellColum">Opciones</td>
	</tr>
	<?
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
    <td align="left"><?php echo $Rs[cDesCategoria];?></td>
	<td>
    	<a href="../controllers/ln_elimina_categoria.php?id=<?php echo $Rs[iCodCategoria];?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
     	<a href="/iu_actualiza_categoria.php?cod=<?php echo $Rs[iCodCategoria];?>&sw=12"><i class="fas fa-edit"></i></a></td>
  </tr>
  
<?
}
}
?>
</table>
<?php echo paginar($pag, $total, $tampag, "iu_categoria.php?pag=");?>
<table width="240" border="0" align="center">
  <tr>
    <td align="right"><?echo "<a class='btn btn-primary' href='iu_nueva_categoria.php'>Nueva Categoria</a>";
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

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>