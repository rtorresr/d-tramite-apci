<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_correlativo_salida.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de correlativos de Documentos internos para el Perfil Administrador 
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<script>
function ConfirmarBorrado()
{
 if (confirm("Esta seguro de eliminar el registro?")){
  return true; 
 }else{ 
  return false; 
 }
}

function Buscar()
{
  document.form1.action="<?=$_SERVER['PHP_SELF']?>";
  document.form1.submit();
}
</script>



</head>
<body  >
 
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

<div class="AreaTitulo">Mantenimiento >> M. Correlativo SALIDA</div>




  
<?
function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
$total_paginas = ceil($total/$por_pagina);
$anterior = $actual - 1;
$posterior = $actual + 1;
$minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
$maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
if ($actual>1)
$texto = "<a href=\"$enlace$anterior\">«</a> ";
else
$texto = "<b>«</b> ";
if ($minimo!=1) $texto.= "... ";
for ($i=$minimo; $i<$actual; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
$texto .= "<b>$actual</b> ";
for ($i=$actual+1; $i<=$maximo; $i++)
$texto .= "<a href=\"$enlace$i\">$i</a> ";
if ($maximo!=$total_paginas) $texto.= "... ";
if ($actual<$total_paginas)
$texto .= "<a href=\"$enlace$posterior\">»</a>";
else
$texto .= "<b>»</b>";
return $texto;
}


if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
$tampag = 15;
$reg1 = ($pag-1) * $tampag;
/*
$sql="select * from Tra_M_Oficinas ";
$sql.=" WHERE iCodOficina>0 ";
if($_GET[cNomOficina]!=""){
$sql.=" AND cNomOficina like '%$_GET[cNomOficina]%' ";
}
if($_GET[cSiglaOficina]!=""){
$sql.=" AND cSiglaOficina='$_GET[cSiglaOficina]' ";
}
if($_GET['cTipoUbicacion']!=""){
$sql.=" AND iCodUbicacion='".$_GET['cTipoUbicacion']."'";
}
$sql.="ORDER BY cNomOficina ASC";*/

// ordenamiento
if($_GET['campo']==""){
	$campo="Oficina";
}Else{
	$campo=$_GET['campo'];
}

if($_GET['orden']==""){
	$orden="ASC";
}Else{
	$orden=$_GET['orden'];
}

//invertir orden
if($orden=="DESC") $cambio="ASC";
if($orden=="ASC") $cambio="DESC";


$sql=" SP_CORRELATIVO_SALIDA_LISTA '".$_SESSION['iCodOficinaLogin']."','".date('Y')."' ";
//echo $sql;
/*
$sql="select * from Tra_M_Oficinas ";
$sql.=" WHERE iCodOficina>0 ";
if($_GET[cNomOficina]!=""){
$sql.=" AND cNomOficina like '%$_GET[cNomOficina]%' ";
}
if($_GET[cSiglaOficina]!=""){
$sql.=" AND cSiglaOficina like '%$_GET[cSiglaOficina]%' ";
}
if($_GET['cTipoUbicacion']!=""){
$sql.=" AND iCodUbicacion='".$_GET['cTipoUbicacion']."'";
}
$sql.=" ORDER BY $campo $orden";
*/
$rs=sqlsrv_query($cnx,$sql);
///////////
$total = sqlsrv_has_rows($rs);

?>
<?php
    $_REQUEST['iCodOficina']  =   $_SESSION['iCodOficinaLogin'];
    $_REQUEST[anho]         =   date(Y);
?>
<form name="frmRegistro" method="POST" action="cst_actualiza_correlativo.php">
	<input type="hidden" name="opcion" value="3">
    <input type="hidden" name="iCodOficina" value="<?=$_REQUEST['iCodOficina']?>">
    <input type="hidden" name="anho" value="<?=$_REQUEST[anho]?>">
<table width="500"   border="1" align="center">
<tr>
    <td class="headCellColum">Siglas</td>
	<td width="357" class="headCellColum">Tipo de Documento</td>
	<td width="50" class="headCellColum"> N&deg;</td>
 <!--	<td width="112" class="headCellColum">Opciones</td> /-->
</tr>
	<?
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
         echo "TOTAL DE REGISTROS : ".$numrows;
	
///	//////
	for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
sqlsrv_fetch_array($rs, $i);
$Rs=sqlsrv_fetch_array($rs);
//////////////////
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
   <td><?php echo $Rs[cSiglaOficina];?></td>
    <td align="left"><?php echo $Rs['cDescTipoDoc'];?><input type="hidden" name="cCodTipoDoc[]" value="<?php echo $Rs[cCodTipoDoc];?>" /></td>
   	<td  align="center"><input type="text" name="cCorrelativo[]" value="<?php echo trim($Rs[nCorrelativo]);?>"   style="width:40px; text-align:right; background-color:#F93"   <?php if($_REQUEST[cCorrelativo]!=trim($Rs[nCorrelativo])){echo " style=background-color:#FFF;";  }  ?> onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" /> </td>
  <?  /*
    <td> 
      	<a href="../controllers/ln_elimina_oficina.php?id=<?php echo $Rs['iCodOficina'];?>&cNomOficina=<?=$_GET[cNomOficina]?>&cSiglaOficina=<?=$_GET[cSiglaOficina]?>&cTipoUbicacion=<?=$_GET[cTipoUbicacion]?>&iFlgEstado=<?=$_GET[iFlgEstado]?>&pag=<?=$pag?>" onClick='return ConfirmarBorrado();'" ><i class="far fa-trash-alt"></i></a>
	 	  <a href="../views/iu_actualiza_oficina.php?cod=<?php echo $Rs['iCodOficina'];?>&sw=3&se=<?=$Rs[iCodUbicacion]?>&cNomOficina=<?=$_GET[cNomOficina]?>&cSiglaOficina=<?=$_GET[cSiglaOficina]?>&cTipoUbicacion=<?=$_GET[cTipoUbicacion]?>&iFlgEstado=<?=$_GET[iFlgEstado]?>&pag=<?=$pag?>"><i class="fas fa-edit"></i></a></td>
      */    ?>
  </tr>
 
<?
}
?>
<tr>
<td align="center" colspan="3">
    <button class="btn btn-primary" type="submit" onMouseOver="this.style.cursor='hand'"> <b>Registrar</b>  </button>
</td>
<tr>
<?
}
?>
</table>
</form>
<?php echo paginar($pag, $total, $tampag, "iu_correlativo_salida.php?iCodOficina=".$_REQUEST['iCodOficina']."&pag=");?>
<table width="900" border="0" align="center">
  <tr>
    <td align="right"><a href='cst_nuevo_corre_sal.php?iCodOficina=<?=$_REQUEST['iCodOficina']?>'>Nuevo Correlativo</a>&nbsp;&nbsp;</td>
  </tr>
</table>
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