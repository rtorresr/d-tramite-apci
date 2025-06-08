<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_grupo_remitentes_detalle.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de Grupo de Remitentes Detalle para el Perfil Administrador 
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
<? include("includes/head.php");?>
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
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>

</head>
<body>

	<? include("includes/menu.php");?>



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

<div class="AreaTitulo">Grupo : 
     <? 
        $sqlNombre="SELECT cDesGrupoOficina FROM Tra_M_Grupo_Oficina ";
        $sqlNombre.=" WHERE iCodGrupoOficina = '$cod' ";
        $rsNombre=sqlsrv_query($cnx,$sqlNombre);
		$RsNombre=sqlsrv_fetch_array($rsNombre);
		echo $RsNombre[cDesGrupoOficina]; 
	 ?></div>



 <table width="1000" border="0" align="center">
  <tr>
    <td colspan="10">
    <fieldset><legend>Criterios de Busqueda</legend> 
    <form method="GET" name="formGrupo" action="<?=$_SERVER['PHP_SELF']?>">
    <input type="hidden" name="cod" value="<?=$_GET[cod]?>">
   
<table width="652" border="0" align="center">
   <tr>
   <td width="10">   </td>
    <td width="175" height="35" >Nombre Oficina:</td>
    <td colspan="2" align="left"><label>
      <input name="cNombre" class="FormPropertReg form-control" type="text" value="<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>" style="width:300px;"/>
    </label>
    <input name="button" type="submit" class="btn btn-primary" value="BUSCAR" >    </td>  	
    <td width="74" align="center">    </td>  	
  </tr>
  <tr>
   <td>   </td>
    <td height="33" >Agregar Oficina:</td>
    <td width="253" align="left"><div align="center" class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;" ><a style="text-align:center; text-decoration:none" href="iu_grupo_oficina_seleccion.php?iCodGrupoOficina=<?=$cod?>" rel="lyteframe" title="Selecci�n de Remitente" rev="width: 1000px; height: 680px; scrolling: auto; border:no">AGREGAR</a></div>    </td>
    <td width="118" align="left"><button class="btn btn-primary" type="button" onclick="window.open('iu_grupo_oficina.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>REGRESAR</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button></td>
    <td align="center">    </td>  	
  </tr>
 </table>
 </form>
 </fieldset>
  </td>
 </tr>
</table>
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
$tampag = 50;
$reg1 = ($pag-1) * $tampag;

// ordenamiento
if($_GET['campo']==""){
	$campo="cNombre";
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

$sql="SELECT * FROM Tra_M_Oficinas,Tra_M_Grupo_Oficina_Detalle ";
$sql.=" WHERE Tra_M_Oficinas.iCodOficina=Tra_M_Grupo_Oficina_Detalle.iCodOficina ";
$sql.=" AND iCodGrupoOficina = '$cod' ";
if($_GET['cNombre']!=""){
$sql.=" AND cNomOficina LIKE '%'+'%$_GET['cNombre']%'+'%' ";
	}
$sql.="ORDER BY cNomOficina ASC ";

/*$sql="SP_REMITENTE_LISTA  '%$_GET['cNombre']%', '%$_GET['nNumDocumento']%' ";*/
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);
//echo $sql;
?>
<br>
<table width="750" border="1" align="center">
<tr>
	<td class="headCellColum">Oficina</td>
	<td class="headCellColum">Sigla</td>
	<td class="headCellColum">Estado</td>
	<td class="headCellColum">Opciones</td>
</tr>
<?
$numrows=sqlsrv_has_rows($rs);
if($numrows==0){ 
		echo "NO SE ENCONTRARON REGISTROS<br>";
		echo "TOTAL DE REGISTROS : ".$numrows;
}else{
         echo "TOTAL DE REGISTROS : ".$numrows;
//////////
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
    <td align="left"><?php echo $Rs[cNomOficina];?></td>
    <td align="left"><?php echo $Rs[cSiglaOficina];?></td>
    <td><?php if($Rs[iFlgEstado]==1){?>
    		<div style="color:#005E2F">Activo</div>
    	<?php } else{?>
    		<div style="color:#950000">Inactivo</div>
    	<?php}?></td>
        
	<td>
	<?  
		$sqlRe=" SELECT cFlgAdmin FROM Tra_M_Grupo_Remitente WHERE iCodGrupo='$Rs[iCodGrupo]'";
		$rsRe=sqlsrv_query($cnx,$sqlRe);
		$RsRe=sqlsrv_fetch_array($rsRe);
		if($RsRe[cFlgAdmin]==0){
		?>
		<a href="../controllers/ln_elimina_grupo_oficina_detalle.php?id=<?php echo $Rs['iCodOficina'];?>&iCodGrupo=<?php echo $Rs[iCodGrupoOficina];?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
	<?php } 
		if($RsRe[cFlgAdmin]==1){?>
		<img src="images/icon_del_off.png" width="16" height="16" alt="Grupo de Destinos" border="0">
	<?	}
		?>
		</td>
  </tr>
  
<?
}
}
?>
<tr>
<td colspan="8">
<?php echo paginar($pag, $total, $tampag, "iu_grupo_remitentes_detalle.php?cNombre=".$_GET['cNombre']."&cod=".$cod."&pag=");?>
</tr>
</td>
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
