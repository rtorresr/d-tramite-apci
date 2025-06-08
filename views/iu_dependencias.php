<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
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

<div class="AreaTitulo">Maestra Dependencias</div>


<form name="form1" method="GET" action="iu_dependencias.php">
<table width="600" border="0" align="center">
  <tr>
    <td colspan="4">Criterios de Busqueda </td>
  </tr>
  
  <tr>
    <td>Dependencia:</td>
    <td><label>
      <input name="cNomDependencia" type="text" value="<?=$_GET[cNomDependencia]?>" />
    </label>
    </td>  	
    <td>Sigla de Dependencia:</td>
    <td><label>
      <input name="cSiglaDependencia" type="text" value="<?=$_GET[cSiglaOficina]?>" />
    </label>
    </td>

  </tr>
  <tr>
    <td colspan="4">
      <input type="submit" name="Submit" value="Iniciar Busqueda" />
			<input type="button" value="Restablecer" name="inicio" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');">
			<input type="button" value="Rep. Excel" name="inicio" onClick="window.open('iu_dependencias_xls.php?cNomDependencia=<?=$_GET[cNomDependencia]?>&cSiglaDependencia=<?=$_GET[cSiglaDependencia]?>', '_self');">
			<input type="button" value="Rep. PDF" name="inicio" onClick="window.open('iu_dependencias_pdf.php?cNomDependencia=<?=$_GET[cNomDependencia]?>&cSiglaDependencia=<?=$_GET[cSiglaDependencia]?>', '_blank');">
    </td>
  </tr>
</table>
</form>
<table width="900" border="1" align="center">
  
<?
//require_once("../models/ad_oficina.php");
$sql="select * from Tra_M_Dependencias ";
$sql.=" WHERE iCodDependencia>0 ";
if($_GET[cNomDependencia]!=""){
$sql.=" AND cNomDependencia like '%$_GET[cNomDependencia]%' ";
}
if($_GET[cSiglaDependencia]!=""){
$sql.=" AND cSiglaDependencia='$_GET[cSiglaDependencia]' ";
}
$sql.="ORDER BY iCodDependencia ASC";
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
?>
<tr>
	<td class="headCellColum">CodDependencia</td>
	<td class="headCellColum">NomDependencia</td>
	<td class="headCellColum">Sigla</td>
	<td class="headCellColum">Opciones</td>
</tr>
	<?
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "no hay dependencias registradas<br>";
}
else{
while ($Rs=sqlsrv_fetch_array($rs)){
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
    <td><?php echo $Rs[iCodDependencia];?></td>
    <td><?php echo $Rs[cNomDependencia];?></td>
   	<td><?php echo $Rs[cSiglaDependencia];?></td>
    <td>
    	<a href="../controllers/ln_elimina_dependencia.php?id=<?php echo $Rs[iCodDependencia];?>"><i class="far fa-trash-alt"></i></a>
	 	  <a href="/iu_actualiza_dependencia.php?cod=<?php echo $Rs[iCodDependencia];?>&sw=3"><i class="fas fa-edit"></i></a></td>
  </tr>
 
<?
}
}
?>
</table>
<table width="400" border="0" align="center">
  <tr>
    <td align="right"><?echo "<a class='btn btn-primary' href='iu_nueva_dependencia.php'>Nueva Dependencia</a>";
?>
</td>
  </tr>
</table>



					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>