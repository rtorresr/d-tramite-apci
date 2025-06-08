<?php
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
		$cod = $_GET[cod];
        $sqlNombre="SELECT cDesGrupo FROM Tra_M_Grupo_Remitente ";
        $sqlNombre.=" WHERE iCodGrupo = '$cod' ";
        $rsNombre=sqlsrv_query($cnx,$sqlNombre);
		$RsNombre=sqlsrv_fetch_array($rsNombre);
		echo $RsNombre[cDesGrupo]; 
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
    <td width="175" height="35" >Nombre Remitente:</td>
    <td colspan="2" align="left"><label>
      <input name="cNombre" class="FormPropertReg form-control" type="text" value="<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>" style="width:300px;"/>
    </label>
    <input name="button" type="submit" class="btn btn-primary" value="BUSCAR" >    </td>
    <td width="74" align="center">    </td>  	
  </tr>
  <tr>
   <td>   </td>
    <td height="33" >Agregar Remitente:</td>
    <td width="253" align="left"><div align="center" class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;" ><a style="text-align:center; text-decoration:none" href="iu_grupo_remitentes_seleccion.php?iCodGrupo=<?=$cod?>" rel="lyteframe" title="Selecci�n de Remitente" rev="width: 1000px; height: 680px; scrolling: auto; border:no">AGREGAR</a></div>    </td>
    <td width="118" align="left"><button class="btn btn-primary" type="button" onclick="window.open('iu_grupo_remitentes.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>REGRESAR</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button></td>
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

$sql="SELECT * FROM Tra_M_Remitente,Tra_M_Grupo_Remitente_Detalle ";
$sql.=" WHERE Tra_M_Remitente.iCodRemitente=Tra_M_Grupo_Remitente_Detalle.iCodRemitente ";
$sql.=" AND iCodGrupo = '$cod' ";
if($_GET['cNombre']!=""){
$sql.=" AND cNombre LIKE '%'+'%$_GET['cNombre']%'+'%' ";
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
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cTipoPersona"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cTipoPersona&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Tipo Persona</a></td>
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cNombre"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cNombre&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Nombre</a></td>
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cTipoDocIdentidad"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cTipoDocIdentidad&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Documento</a></td>
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cDireccion"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cDireccion&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Direccion</a></td>
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cEmail"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cEmail&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">E-mail</a></td>
	<td class="headCellColum"><a style=" text-decoration:<?php if($campo=="nTelefono"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=nTelefono&orden=<?=$cambio?>&cTipoPersona=<?=$_GET['cTipoPersona']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cDireccion=<?=$_GET[cDireccion]?>&cEmail=<?=$_GET[cEmail]?>&nTelefono=<?=$_GET[nTelefono]?>&cFlag=<?=$_GET[cFlag]?>&cod=<?=$cod?>">Telefono</a></td>
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
    <td align="left"><?php if($Rs['cTipoPersona']=='1'){
	        echo "Persona Natural";
		   }
		   else {
		    echo "Persona Jur�dica"; 
		   } 
	     ?></td>
    <td align="left"><?php echo $Rs['cNombre'];?></td>
    <td align="left">
	  <?
    	$sqlTDoc="SELECT * FROM Tra_M_Doc_Identidad WHERE cTipoDocIdentidad='$Rs[cTipoDocIdentidad]'";
    	$rsTDoc=sqlsrv_query($cnx,$sqlTDoc);
    	$RsTDoc=sqlsrv_fetch_array($rsTDoc);
    	echo $RsTDoc[cDescDocIdentidad].":".$Rs['nNumDocumento'];
      ?></td>
    <td align="left"><?php echo $Rs[cDireccion];?></td>
    <td align="left"><?php echo $Rs[cEmail];?></td>
    <td align="left"><?php echo $Rs[nTelefono];?></td>
    <td><?php if($Rs[cFlag]==1){?>
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
		<a href="../controllers/ln_elimina_grupo_remitentes_detalle.php?id=<?php echo $Rs[iCodRemitente];?>&iCodGrupo=<?php echo $Rs[iCodGrupo];?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
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
