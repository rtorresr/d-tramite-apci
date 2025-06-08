<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_grupo_remitentes_detalle.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de Grupo de Tramite DOCUMENTARIO DIGITAL Detalle para el Perfil Administrador
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
		$cod=$_GET[cod];
		
        $sqlNombre="SELECT cDesGrupoTramite FROM Tra_M_Grupo_Tramite ";
        $sqlNombre.=" WHERE iCodGrupoTramite = '$cod' ";
        $rsNombre=sqlsrv_query($cnx,$sqlNombre);
		$RsNombre=sqlsrv_fetch_array($rsNombre);
		echo $RsNombre[cDesGrupoTramite]; 
	 ?></div>



 <table width="1000" border="0" align="center">
  <tr>
    <td colspan="10">
    <fieldset><legend>Criterios de Busqueda</legend> 
    <form method="GET" name="formGrupo" action="<?=$_SERVER['PHP_SELF']?>">
    <input type="hidden" name="cod" value="<?=$_GET[cod]?>">
   

    <td width="175" height="35" >Nombre de Trabajador:</td>
    <td colspan="2" align="left"><label>
      <input name="cNombresTrabajador" class="FormPropertReg form-control" type="text" value="<?=$_GET[cNombresTrabajador]?>" style="width:300px;"/>
    </label>
    </td>  	
    <td width="200" height="35" >Apellidos de Trabajador:</td>
    <td colspan="2" align="left">
      <input name="cApellidosTrabajador" class="FormPropertReg form-control" type="text" value="<?=$_GET[cApellidosTrabajador]?>" style="width:300px;"/>
     </td>  	
    <td width="74" align="center"><input name="button" type="submit" class="btn btn-primary" value="BUSCAR" >    </td>  	
  </tr>
  <tr>
    <td width="300">    </td> 
    <td width="253" align="center"><div align="center" class="btn btn-primary" style="width:150px;height:17px;padding-top:4px;" ><a style="text-align:center; text-decoration:none" href="iu_grupo_tramite_seleccion.php?iCodGrupoTramite=<?=$cod?>" rel="lyteframe" title="Selecci�n de Trabajador" rev="width: 1000px; height: 680px; scrolling: auto; border:no">AGREGAR TRABAJADOR</a></div>    </td>
    <td width="253" align="center"><button class="btn btn-primary" type="button" onclick="window.open('iu_grupo_tramite.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>REGRESAR</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button></td>
    <td  width="140">    </td> 
    	
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
	$campo="cNombresTrabajador";
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

$sql="SELECT * FROM Tra_M_Trabajadores,Tra_M_Grupo_Tramite_Detalle ";
$sql.=" WHERE Tra_M_Trabajadores.iCodTrabajador=Tra_M_Grupo_Tramite_Detalle.iCodTrabajador ";
$sql.=" AND iCodGrupoTramite = '$cod' ";
if($_GET[cNombresTrabajador]!=""){
$sql.=" AND cNombresTrabajador LIKE '%$_GET[cNombresTrabajador]%' ";	
	}
if($_GET[cApellidosTrabajador]!=""){
$sql.=" AND cApellidosTrabajador LIKE '%$_GET[cApellidosTrabajador]%' ";	
	}	
$sql.="ORDER BY ".$campo." ".$orden." ";

/*$sql="SP_REMITENTE_LISTA  '%$_GET['cNombre']%', '%$_GET['nNumDocumento']%' ";*/
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);
//echo $sql;
?>
<br>
<table class="table">
<tr>
    <td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cTipoPersona"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cTipoPersona&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Oficina</a></td>
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cTipoPersona"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cTipoPersona&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Trabajador</a></td>
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cFlag"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cFlag&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Estado</a></td>
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
      <td align="left">
	  <?
    	$sqlTDoc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs['iCodOficina']'";
    	$rsTDoc=sqlsrv_query($cnx,$sqlTDoc);
    	$RsTDoc=sqlsrv_fetch_array($rsTDoc);
    	echo $RsTDoc[cNomOficina];
      ?></td>
    <td align="left"><?php echo $Rs["cNombresTrabajador"]." ".$Rs["cApellidosTrabajador"];?></td>
    
    <td><?php if($Rs[nFlgEstado]==1){?>
    		<div style="color:#005E2F">Activo</div>
    	<?php } else{?>
    		<div style="color:#950000">Inactivo</div>
    	<?php}?></td>
        
	<td>
		<a href="../controllers/ln_elimina_grupo_tramite_detalle.php?id=<?php echo $Rs[iCodTrabajador];?>&iCodGrupoTramite=<?php echo $Rs[iCodGrupoTramite];?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
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
