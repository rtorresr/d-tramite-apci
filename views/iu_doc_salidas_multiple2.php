<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_remitentes.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar Tabla Maestra de Remitentes para el Perfil Administrador 
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

<div class="AreaTitulo">Agregar Destinos Multiples</div>




<table width="1000" border="0" align="center">
  <tr>
    <td colspan="10">
    <fieldset><legend>Criterios de Busqueda</legend> 
<table width="900" border="0" align="center">
   <tr>
   
   <form name="form1" method="POST" action="../controllers/ln_nuevo_doc_salidas_multiple.php?op=1">
   <input name="txtcod_tramite" type="hidden" id="txtcod_tramite" value="<?=$_GET[cod]?>">
   
   <td width="76" >GRUPO:</td>
    <td width="162">
    <?
	  $sqlG=" SELECT * FROM Tra_M_Grupo_Remitente ";
    $rsG=sqlsrv_query($cnx,$sqlG);
	 	?>
			<select name="cGrupo" class="FormPropertReg form-control" id="cGrupo"  />
     	                  <option value="%">Seleccione:</option>
	                   <? while ($RsG=sqlsrv_fetch_array($rsG)){
	  	                         echo "<option value=".$RsG[iCodGrupo]." ".$selecClas.">".$RsG[cDesGrupo]."</option>";
                                 }
								 
                                 sqlsrv_free_stmt($rsG);
								 
                              ?>
            </select>	</td>  	
    <td width="169" > <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'"> <b>AGREGAR</b>  </button></td>
    </form>
     
    <td width="9" >&nbsp;</td>
  
    <td width="120" >REMITENTE:</td>
    <td width="157" align="center"><div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;" ><a style=" text-decoration:none" href="iu_multiple_remitentes_seleccion.php?iCodTramite=<?=$cod?>" rel="lyteframe" title="Selecci�n de Remitente" rev="width: 1000px; height: 680px; scrolling: auto; border:no">AGREGAR</a></div></td>
    <td width="177" ></td>	
   
  </tr>
 </table>
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

//require_once("../models/ad_trabajador.php");
/*$sql="select * from Tra_M_Remitente ";
$sql.=" WHERE iCodRemitente>0 ";
if($_GET['cNombre']!=""){
$sql.=" AND cNombre like '%$_GET['cNombre']%' ";
}
if($_GET['nNumDocumento']!=""){
$sql.=" AND nNumDocumento='$_GET['nNumDocumento']' ";
}
$sql.="ORDER BY iCodRemitente ASC";*/
$sql=" SP_DOC_SALIDA_MULTIPLE '$cod' ";
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);

//echo $sql;
?>
<br>
<table class="table">
<tr>
	<td class="headCellColum">Numero Doc.</td>
	<td class="headCellColum">Remitente</td>
	<td class="headCellColum">Asunto</td>
	<td class="headCellColum">Direccion</td>
    <td class="headCellColum">Observacion</td>
	<td class="headCellColum">Opciones</td>
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
//while ($Rs=sqlsrv_fetch_array($rs))
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
    <td align="left"><?=$Rs[Codigo_Documento]?></td>
    <td align="left"><?=$Rs[Remitente]?></td>
    <td align="left"><?=$Rs['cAsunto']?></td>
    <td align="left"><?=$Rs[Direccion]?></td>
    <td align="left"><?=$Rs[cObservacion]?></td>
    <td>
		<a href="../controllers/ln_elimina_doc_salidas_multiple.php?id=<?php echo $Rs[iCodRemitente];?>&iCodTramite=<?php echo $Rs[iCodTramite];?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
     <?   echo "<a style=\"color:#0067CE\" href=\"registroObservacion.php?iCodRemitente=".$Rs[iCodRemitente]."&iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle de la Observacion\" rev=\"width: 410px; height: 280px; scrolling: no; border:no\"><img src='images/icon_avance.png' width='16' height='16' border='0'></a>";
	?>	</td>
  </tr>
  
<?
}
}
?>
</table>
<?php echo paginar($pag, $total, $tampag, "iu_doc_salidas_multiple.php?cod=".$cod."&pag=");?>
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
