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

<div class="AreaTitulo">Maestra Documentos de Identidad</div>

<table width="800" border="1" align="center">
  
<?
//require_once("../models/ad_busqueda.php");
$sql= " select * from Tra_M_Tupa_Requisitos ";
$sql.= " where iCodTupaRequisito >0 ";
$sql.= " AND iCodTupa ='".$cod."' ";
$sql.= " ORDER BY iCodTupaRequisito ASC";
echo $sql;
$rs=sqlsrv_query($cnx,$sql);
?>
<tr>
	<td class="headCellColum">CodRequisito</td>
	<td class="headCellColum">CodTupa</td>
    <td class="headCellColum">NumRequ</td>
	<td class="headCellColum">Nombre Requisito</td>
	<td class="headCellColum">Estado</td>
	<td class="headCellColum">Opciones</td>
</tr>
<?
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "no hay tupas registrados<br>";
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
    <td><?php echo $Rs[iCodTupaRequisito];?></td>
    <td><?php echo $Rs['iCodTupa']?></td>
    <td><?php echo $Rs[nNumTupaRequisito];?></td>
    <td><?php echo $Rs[cNomTupaRequisito];?></td>
    <td><?php echo $Rs[nEstadoTupaRequisito];?></td>
    <td> 
    	<a href="../controllers/ln_elimina_req_tupa.php?id=<?php echo $Rs[iCodTupaRequisito];?>"><i class="far fa-trash-alt"></i></a>
	    <a href="/iu_actualiza_req_tupa.php?cod=<?php echo $Rs[iCodTupaRequisito];?>&sw=8"><i class="fas fa-edit"></i></a></td>
  </tr>
  
<?
}
}
?>

</table>
<table width="800" border="0" align="center">
  <tr>
    <td align="right"><?echo "<a class='btn btn-primary' href='iu_nuevo_tupa.php'>Nuevo Tupa</a>";
?>
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