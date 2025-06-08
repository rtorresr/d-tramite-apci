<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_tipo_doc.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Administrar la Tabla Maestra de Tipo de Documentos para el Perfil Administrador
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
 if (confirm("Esta seguro de eliminar el registro?")){
  return true; 
 }else{ 
  return false; 
 }
}
</script>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
-->
</style>
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

<div class="AreaTitulo">Mantenimiento >> CONSULTA  Documentos - USO</div>



<form name="form1" method="GET" action="consultaDocOficina.php">



    <td width="234" >Tipo de Documento: </td>

      <select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
		
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE  (nFlgInterno=1 or nFlgSalida=1 )  ";
          $sqlTipo.="ORDER BY cDescTipoDoc ASC  ";
          $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          	if($RsTipo["cCodTipoDoc"]==$_REQUEST[cCodTipoDoc]){
          		$selecTipo="selected";
          	}Else{
          		$selecTipo="";
          	}
          echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          }
          sqlsrv_free_stmt($rsTipo);
					?>
					</select>

   <td width="65" align="left" >A&ntilde;o </td>
    <td width="302" align="left">
    <?php if($_REQUEST[anho]=="") {
	$X=date ("Y");
	$_REQUEST[anho]=$X; }?>
    <select name="anho" class="FormPropertReg form-control"  >
    	<option value="">Seleccione:</option>   
   		<option value="2011" <?php if($_REQUEST[anho]=="2011"){echo "selected";} ?>>2011</option>
        <option value="2012" <?php if($_REQUEST[anho]=="2012"){echo "selected";} ?>>2012</option>
        <option value="2013" <?php if($_REQUEST[anho]=="2013"){echo "selected";} ?>>2013</option>
        <option value="2014" <?php if($_REQUEST[anho]=="2014"){echo "selected";} ?>>2014</option>
    </select>
    </td>  	
  </tr>
  <tr>

    <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"></button>
    �
     <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"></button>
    �
     <button class="btn btn-primary" onClick="window.open('iu_tipo_doc_xls_ofi.php?anho=<?=$_REQUEST[anho]?>&cCodTipoDoc=<?=$_REQUEST[cCodTipoDoc]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
		�	
<?  /*           <button class="btn btn-primary" onClick="window.open('iu_tipo_doc_pdf_ofi.php?cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&cSiglaDoc=<?=$_GET[cSiglaDoc]?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET[Salida]?>&orden=<?=$_GET['orden']?>&campo=<?=$_GET['campo']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
  */?></td>
  </tr>
</table>
</fieldset>
  </td>
 </tr>
</table>
</form>

<table class="table">
 
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
	$campo="Tipo";
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

/*
  $sql="select * from Tra_M_Tipo_Documento ";
  $sql.=" WHERE cCodTipoDoc>0 ";
  if($_GET['Entrada']==1 ){
  $sql.="AND nFlgEntrada='1'  ";
  }
  if($_GET['Interno']==1){
  $sql.="AND nFlgInterno='1'  ";
  }
  if($_GET[Salida]==1){
  $sql.="AND nFlgSalida='1' ";
  }
 if($_GET['cDescTipoDoc']!=""){
$sql.=" AND cDescTipoDoc like '%$_GET['cDescTipoDoc']%' ";
}
if($_GET[cSiglaDoc]!=""){
$sql.=" AND cSiglaDoc='$_GET[cSiglaDoc]' ";
}	
$sql.="ORDER BY $campo $orden"; 
*/
  $sql="SP_DOC_OFICINA_INTERNO_USO  '$_REQUEST[anho]', '$_REQUEST[cCodTipoDoc]' ";
  $rs=sqlsrv_query($cnx,$sql);
  $total = sqlsrv_has_rows($rs);
//  echo $sql;
?>
<tr>

  
	<td width="181" class="headCellColum">Oficinas</td>
	<?  /* <td width="80" class="headCellColum"><a  href="<?=$_SERVER['PHP_SELF']?>?campo=Sigla&orden=<?=$cambio?>&cSiglaDoc=<?=$_GET[cSiglaDoc]?>"  style=" text-decoration:<?php if($campo=="Sigla"){ echo "underline"; }Else{ echo "none";}?>">Sigla</a></td>
	<td width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Entrada&orden=<?=$cambio?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET[Salida]?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>"  style=" text-decoration:<?php if($campo=="Entrada"){ echo "underline"; }Else{ echo "none";}?>">Entradas</a></td>
	<td width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Interno&orden=<?=$cambio?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET[Salida]?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>"  style=" text-decoration:<?php if($campo=="Interno"){ echo "underline"; }Else{ echo "none";}?>">Internos</a></td>
	<td width="80" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Salida&orden=<?=$cambio?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Salida=<?=$_GET[Salida]?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>"  style=" text-decoration:<?php if($campo=="Salida"){ echo "underline"; }Else{ echo "none";}?>">Salidas</a></td>
	<td width="80" class="headCellColum">Opciones</td>*/ ?>
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
  <? /*
   <td><?php echo $Rs[cCodTipoDoc];?></td>
  */ ?> 
    <td height="23" align="left"><?php echo $Rs[cNomOficina];?></td>
   <? /* <td> <?php echo $Rs[cSiglaDoc];?></td>
    <td><a href="../controllers/ln_actualiza_flg_tipo_doc.php?Entrada=<?php echo $Rs[nFlgEntrada];?>&id=<?php echo $Rs[cCodTipoDoc];?>" ><?php if($Rs[nFlgEntrada]=='1'){echo SI;} else{echo NO;}?></a></td>
    <td><a href="../controllers/ln_actualiza_flg_tipo_doc.php?Interno=<?php echo $Rs[nFlgInterno];?>&id=<?php echo $Rs[cCodTipoDoc];?>" ><?  if($Rs[nFlgInterno]=='1'){echo SI;} else{echo NO;}?></a></td>
    <td><a href="../controllers/ln_actualiza_flg_tipo_doc.php?Salida=<?php echo $Rs[nFlgSalida];?>&id=<?php echo $Rs[cCodTipoDoc];?>" ><?php if($Rs[nFlgSalida]=='1'){echo SI;} else{echo NO;}?></a></td>
    <td> 
		<a href="../controllers/ln_elimina_tipo_doc.php?id=<?php echo $Rs[cCodTipoDoc];?>&Entrada=<?=$_REQUEST[Entrada]?>&Interno=<?=$_REQUEST[Interno]?>&Salida=<?=$_REQUEST[Salida]?>&cDescTipoDoc=<?=$_REQUEST['cDescTipoDoc']?>&pag=<?=$pag?>" onClick='return ConfirmarBorrado();'"><i class="far fa-trash-alt"></i></a>
		<a href="../views/iu_actualiza_tipo_doc.php?cod=<?php echo $Rs[cCodTipoDoc];?>&sw=5&Entrada=<?=$_REQUEST[Entrada]?>&Interno=<?=$_REQUEST[Interno]?>&Salida=<?=$_REQUEST[Salida]?>&cDescTipoDoc=<?=$_REQUEST['cDescTipoDoc']?>&pag=<?=$pag?>"><i class="fas fa-edit"></i></a></td>
*/ ?>  </tr>
  
<?
}
}
?>
</table>
<? /* echo paginar($pag, $total, $tampag, "iu_tipo_doc.php?cDescTipoDoc=".$_GET['cDescTipoDoc']."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&Salida=".$_GET[Salida]."&pag=");?>
<?echo "<a class='btn btn-primary' href='iu_nuevo_tipo_doc.php'>Nuevo Tipo Documento</a>";
*/?>
</div>
                 </div>
             </div>
         </div>
     </div>
 </main>




<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>