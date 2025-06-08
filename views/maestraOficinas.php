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

<div class="AreaTitulo">Maestra Oficinas</div>


<form name="form1" method="GET" action="<?=$_SERVER['PHP_SELF']?>">
<table width="900" border="0" align="center">
  <tr>
    <td colspan="4">Criterios de Busqueda:</td>
  </tr>
  
  <tr>
    <td>Oficina:</td>
    <td><input name="cNomOficina" type="text" value="<?=$_GET[cNomOficina]?>" size="65" /></td>  	
    <td>Sigla de Oficina:</td>
    <td><label>
      <input name="cSiglaOficina" type="text" value="<?=$_GET[cSiglaOficina]?>" />
    </label>
    </td>

  </tr>
  <tr>
    <td colspan="4"> 
      <input type="submit" name="Submit" value="Iniciar Busqueda" />
			<input type="button" value="Restablecer" name="inicio" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');">
			<input type="button" value="Rep. Excel" name="inicio" onClick="window.open('maestraOficinas_xls.php?cNomOficina=<?=$_GET[cNomOficina]?>&cSiglaOficina=<?=$_GET[cSiglaOficina]?>', '_self');">
			<input type="button" value="Rep. PDF" name="inicio" onClick="window.open('maestraOficinas_pdf.php?cNomOficina=<?=$_GET[cNomOficina]?>&cSiglaOficina=<?=$_GET[cSiglaOficina]?>', '_blank');">
    </td>
  </tr>
</table>
</form>
<table width="900" border="1" align="center">
  
<?
$sql="select * from Tra_M_Oficinas ";
$sql.=" WHERE iCodOficina>0 ";
if($_GET[cNomOficina]!=""){
$sql.=" AND cNomOficina like '%$_GET[cNomOficina]%' ";
}
if($_GET[cSiglaOficina]!=""){
$sql.=" AND cSiglaOficina='$_GET[cSiglaOficina]' ";
}
$sql.="ORDER BY iCodOficina ASC";
$rs=sqlsrv_query($cnx,$sql);
//echo $sql;
?>
<tr>
	<td class="headCellColum">CodOficina</td>
	<td class="headCellColum">NomOficina</td>
	<td class="headCellColum">Sigla</td>
	<td class="headCellColum">Opciones</td>
</tr>
	<?
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "no hay Oficinas registradas<br>";
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
    <td><?php echo $Rs['iCodOficina'];?></td>
    <td><?php echo $Rs[cNomOficina];?></td>
   	<td><?php echo $Rs[cSiglaOficina];?></td>
    <td> 
    	<a href="../controllers/ln_elimina_Oficina.php?id=<?php echo $Rs['iCodOficina'];?>"><i class="far fa-trash-alt"></i></a>
	 	  <a href="/iu_actualiza_Oficina.php?cod=<?php echo $Rs['iCodOficina'];?>&sw=3"><i class="fas fa-edit"></i></a></td>
  </tr>
 
<?
}
}
?>
</table>
<table width="900" border="0" align="center">
  <tr>
    <td align="right"><a href='iu_nueva_Oficina.php'>Nueva Oficina</a>&nbsp;&nbsp;</td>
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