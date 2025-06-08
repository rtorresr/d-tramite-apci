<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_grupo_tramite.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de Grupos de tramite DOCUMENTARIO DIGITAL para el Perfil Administrador 
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
<script>
function ConfirmarBorrado()
{
 if (confirm("Al eliminar el grupo borrara toda la lista de Remitenters Asociadas a este Grupo. Esta seguro de eliminar el registro?")){

  
 if (confirm("Esta completamente seguro?")){
       return true;                        }
	   
 else{ 
       return false; 
     }	   
  
                                                                                                                                       }
 else{ 
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

<div class="AreaTitulo">Mantenimiento >> M. Grupo de Tr�mite</div>


<form name="form1" method="GET" action="iu_grupo_tramite.php">
<table width="800" border="0" align="center">
  <tr>
    <td>
      <fieldset><legend>Criterios de B�squeda:</legend> 
     <table width="750" border="0" align="center">
     <tr>
    <td width="375" height="42"  >Grupo de Tr&aacute;mite:</td>
    <td width="365" align="left"><label>
      <input name="cGrupo" class="FormPropertReg form-control" type="text" value="<?=$_GET[cGrupo]?>" />
    </label>
    </td>  	
  </tr>
  <tr>
    <td colspan="4" align="center">
    <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"></button>
    &nbsp;
     <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"></button>
    &nbsp;
     <button class="btn btn-primary" onClick="window.open('iu_grupo_remitentes_xls.php?cGrupo=<?=$_GET[cGrupo]?>&orden=<?=$orden?>&campo=<?=$campo?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
		&nbsp;	
            <button class="btn btn-primary" onClick="window.open('iu_grupo_remitentes_pdf.php?cGrupo=<?=$_GET[cGrupo]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>


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
	$campo="Grupo";
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

$sql= "SP_GRUPO_TRAMITE_LISTA '%$_GET[cGrupo]%' ,'".$orden."' , '".$campo."' ";
/*
$sql= "SELECT * FROM Tra_M_Grupo_Remitente";
$sql.=" WHERE iCodGrupo>0 ";
if($_GET[cGrupo]!=""){
$sql.=" AND  cDesGrupo LIKE '%$_GET[cGrupo]%' ";
}
$sql.=" ORDER BY cDesGrupo ASC";
*/
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);
//echo $sql;
?>
<tr>
	<td width="144" class="headCellColum"><a style=" text-decoration:<?php if($campo=="Grupo"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=Grupo&orden=<?=$cambio?>&cGrupo=<?=$_GET[cGrupo]?>">Grupo de Tr�mite</a></td>
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
    <td align="left"><a href="/iu_grupo_tramite_detalle.php?cod=<?=$Rs[iCodGrupoTramite]?>&sw=13"><?php echo $Rs[cDesGrupoTramite]."(".$Rs[Cantidad].")";?></a></td>
    <td>
    	<a href="../controllers/ln_elimina_grupo_tramite.php?id=<?php echo $Rs[iCodGrupoTramite];?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
     	<a href="/iu_actualiza_grupo_tramite.php?cod=<?php echo $Rs[iCodGrupoTramite];?>&sw=15"><i class="fas fa-edit"></i></a></td>
  </tr>
  
<?
}
}
?>
</table>
<?php echo paginar($pag, $total, $tampag, "iu_grupo_tramite.php?pag=");?>
<table width="240" border="0" align="center">
  <tr>
    <td align="right"><?echo "<a class='btn btn-primary' href='iu_nuevo_grupo_tramite.php'>Nuevo Grupo</a>";
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