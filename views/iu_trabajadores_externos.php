<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
	include_once("../conexion/conexion.php");
	$rsFont = sqlsrv_query($cnx,"SELECT iCodSubMenu FROM Tra_M_Menu_Items WHERE cScriptSubMenu like '%iu_trabajadores.php%'");
	$RsFont = sqlsrv_fetch_array($rsFont);
	$sqlSub = "SELECT iCodMenuLista FROM Tra_M_Menu_Lista 
			   WHERE iCodSubMenu = $RsFont[iCodSubMenu] AND 
			   		 iCodMenu IN (SELECT iCodMenu FROM Tra_M_Menu WHERE iCodPerfil ='$_SESSION[iCodPerfilLogin]')";
	$rsSub  = sqlsrv_query($cnx,$sqlSub);
	$numProfile = sqlsrv_has_rows($rsSub);
}
if($numProfile > 0){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script>
function ConfirmarBorrado()
{
 if (confirm("Esta seguro de eliminar el registro?")){
  return true; 
 }else{ 
  return false; 
 }
}
function limpiarBusqueda(){
  var cNombreTrabajador = document.getElementById("cNombreTrabajador");
  var cApellidosTrabajador = document.getElementById("cApellidosTrabajador");
  var cNumDocIdentidad = document.getElementById("cNumDocIdentidad");
  var cTipoDocIdentidad = document.getElementById("cTipoDocIdentidad");
  var txtestado = document.getElementById("txtestado");

  cNombreTrabajador.value = "";
  cApellidosTrabajador.value = "";
  cNumDocIdentidad.value = "";
  cTipoDocIdentidad.selectedIndex = "";
  txtestado.selectedIndex = "";
}
</script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
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

<div class="AreaTitulo">Mantenimiento >> M. USUARIOS WEB</div>

<?
require_once("../conexion/conexion.php");
?>

<form name="form1" method="GET" action="<?=$_SERVER['PHP_SELF']?>">


<table width="1000" border="0" align="center">
  <tr>
    <td colspan="9">
    <fieldset><legend>Criterios de B&uacute;squeda</legend> 
    <br>
    <table width="1000" border="0" align="center">
      <tr>
        <td >Raz&oacute;n Social/Nombre:</td>
        <td width="181" align="left">
          <label>
            <input class="FormPropertReg form-control" name="cNombreTrabajador" id="cNombreTrabajador" type="text"
                    value="<?=$_GET[cNombreTrabajador]?>" />
          </label>        
        </td>
        <td >Apellido:&nbsp;</td>
        <td colspan="2" align="left" >
          <label>
            <input class="FormPropertReg form-control" name="cApellidosTrabajador" id="cApellidosTrabajador" type="text"
                   value="<?=$_GET[cApellidosTrabajador]?>" />
            </label>
          </td>
        <td >Documento:&nbsp;</td>
        <td width="173" align="left" ><?php
  $sqlDoc=" SP_DOC_IDENTIDAD_LISTA_COMBO ";
                  $rsDoc=sqlsrv_query($cnx,$sqlDoc);
	                ?>
            <select name="cTipoDocIdentidad" id="cTipoDocIdentidad" class="FormPropertReg form-control"   />
            
            <option value="">Seleccione:</option>
            <? while ($RsDoc=sqlsrv_fetch_array($rsDoc)){
	  	                         if($RsDoc["cTipoDocIdentidad"]==$_GET[cTipoDocIdentidad]){
          		                 $selecClas="selected";
          	                     }Else{
          		                 $selecClas="";
          	                          }
                                 echo "<option value=".$RsDoc["cTipoDocIdentidad"]." ".$selecClas.">".$RsDoc["cDescDocIdentidad"]."</option>";
                                 }
                                 sqlsrv_free_stmt($rsDoc);
                              ?>        </td>
        <td width="116"  >Nro de Identidad:&nbsp;</td>
        <td width="91">
          <label>
            <input class="FormPropertReg form-control" name="cNumDocIdentidad" id="cNumDocIdentidad" type="text" size="15"
                   value="<?=$_GET[cNumDocIdentidad]?>"  onkeypress="if (event.keyCode > 31 && ( event.keyCode < 48 || event.keyCode > 57)) event.returnValue = false;" />
          </label>
        </td>
      </tr>
      
      <tr>
        <td >Perfil:&nbsp;</td>
        <td colspan="3" align="left" >
          <?php //Consulta para rellenar el combo Perfil
              $sqlPer = "SELECT * FROM Tra_M_Perfil WHERE cDescPerfil LIKE 'Web' "; 
              $rsPer  = sqlsrv_query($cnx,$sqlPer);
              $RsPer  = sqlsrv_fetch_array($rsPer);
          ?>
          <select  class="FormPropertReg form-control" name="iCodPerfil" />
            <option value=<?php echo $RsPer["iCodPerfil"]; ?>><?php echo $RsPer["cDescPerfil"]; ?></option>
              <?php 
                sqlsrv_free_stmt($rsPer);
              ?>
        </td>
      </tr>
      
      <tr>
        <td width="66" ></td>
        <td width="181"></td>
        <td width="82"  ></td>
        <td width="121" ></td>
        <td width="34" ></td>
        <td width="77" ></td>
        <td width="173"  ></td>
        <td width="116"  ></td>
        <td width="91"  ></td>
        <td width="17" ></td>
      </tr>
      <tr>
        <td  >Estado:&nbsp;</td>
        <td align="left">
          <select name="txtestado" class="FormPropertReg form-control" id="txtestado">
            <option value="" selected="selected">Seleccione:</option>
            <option value="1" <?php if( $_GET[txtestado]=="1"){echo "selected";} ?> >Activo</option>
            <option value="0" <?php if( $_GET[txtestado]=="0"){echo "selected";} ?>>Inactivo</option>
            </select></td>
        <td   ></td>
        <td   align="right"></td>
        <td  align="left"></td>
        <td   align="left"></td>
        <td   align="left"></td>
      </tr>
      <tr>
        <td colspan="9"> 
            <button class="btn btn-primary" type="submit" name="Submit" onmouseover="this.style.cursor='hand'">
              <table cellspacing="0" cellpadding="0">
                <tr>
                  <td style=" font-size:10px"><b>Buscar</b>&nbsp;&nbsp;</td>
                  <td><img src="images/icon_buscar.png" width="17" height="17" border="0"></td>

                </tr>
              </table>
              </button>&nbsp;&nbsp;&nbsp;              
              <button class="btn btn-primary" name="Restablecer" onclick="limpiarBusqueda();"
                      onmouseover="this.style.cursor='hand'">
              <table cellspacing="0" cellpadding="0">
                <tr>
                  <td style=" font-size:10px"><b>Restablecer</b>&nbsp;&nbsp;</td>
                  <td><img src="images/icon_clear.png" width="17" height="17" border="0"></td>

                </tr>
              </table>
              </button>&nbsp;&nbsp;&nbsp;
                <?php // ordenamiento
		              if($_GET['campo']==""){$campo=" TT.iCodOficina ";}else{$campo=$_GET['campo'];}
		              if($_GET['orden']==""){$orden="ASC";}Else{$orden=$_GET['orden'];}
                ?>
              <button class="btn btn-primary" onclick="window.open('iu_trabajadores_xls.php?cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&txtestado=<?=$_GET[txtestado]?>&campo=<?=$campo?>&orden=<?=$orden?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onmouseover="this.style.cursor='hand'">
              <table cellspacing="0" cellpadding="0">
                <tr>
                  <td style=" font-size:10px"><b>a Excel</b>&nbsp;&nbsp;</td>
                  <td><img src="images/icon_excel.png" width="17" height="17" border="0" /></td>
                </tr>
              </table>
              </button>&nbsp;&nbsp;&nbsp;
              <button class="btn btn-primary" onclick="window.open('iu_trabajadores_pdf.php?cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&txtestado=<?=$_GET[txtestado]?>&campo=<?=$campo?>&orden=<?=$orden?>', '_blank');" onmouseover="this.style.cursor='hand'">
              <table cellspacing="0" cellpadding="0">
                <tr>
                  <td style=" font-size:10px"><b>a Pdf</b>&nbsp;&nbsp;</td>
                  <td><img src="images/icon_pdf.png" width="17" height="17" border="0" /></td>
                </tr>
              </table>
              </button>
         </td>
      </tr>
    </table>
    </fieldset>  </td>
 </tr>
</table>
</form>

<?php
function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
$total_paginas = ceil($total/$por_pagina);
$anterior = $actual - 1;
$posterior = $actual + 1;
$minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
$maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
if ($actual>1)
$texto = "<a href=\"$enlace$anterior\"><<</a>";
else
$texto = "<b><<</b> ";
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
$texto .= "<b>>></b>";
return $texto;
}

if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
$tampag = 20;
$reg1 = ($pag-1) * $tampag;



//invertir orden
if($orden=="ASC") $cambio="DESC";
if($orden=="DESC") $cambio="ASC";

// $sql="SELECT * FROM Tra_M_Trabajadores TT
//       INNER JOIN Tra_M_Remitente TR ON LTRIM(RTRIM(TT.cNumDocIdentidad)) = LTRIM(RTRIM(TR.nNumDocumento)) 
//       WHERE TT.iCodTrabajador>0 AND TT.ES_EXTERNO = 1 ";
$sql="SELECT * FROM Tra_M_Trabajadores TT WHERE TT.ES_EXTERNO = 1 ";
if($_GET[cNombreTrabajador]!=""){
$sql.=" AND TT.cNombresTrabajador LIKE '%$_GET[cNombreTrabajador]%' ";
}
if($_GET[cNumDocIdentidad]!=""){
$sql.=" AND TT.cNumDocIdentidad LIKE '%$_GET[cNumDocIdentidad]%' ";
}
if($_GET[cTipoDocIdentidad]!=""){
$sql.=" AND TT.cTipoDocIdentidad='$_GET[cTipoDocIdentidad]'";
        }
if($_GET[iCodPerfil]!=""){
$sql.=" AND TT.iCodPerfil='$_GET[iCodPerfil]'";
        }
if($_GET[txtestado]!=""){
    $sql.=" AND TT.nFlgEstado='$_GET[txtestado]'";
}else{
    $sql.=" AND TT.nFlgEstado IN (1,0) "; // Activo=1 y Inactivo=0... Eliminado lógico=3
}
$sql.="ORDER BY $campo  $orden ";
?>

<table class="table">
<tr>
	<td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cApellidosTrabajador&orden=<?=$cambio?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>"  style=" text-decoration:<?php if($campo=="cApellidosTrabajador"){ echo "underline"; }else{ echo "none";}?>">Raz&oacute;n social / Nombres</a>
  </td>
	
  <td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cTipoDocIdentidad&orden=<?=$cambio?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>"  style=" text-decoration:<?php if($campo=="cTipoDocIdentidad"){ echo "underline"; }else{ echo "none";}?>">Documento</a>
  </td>
	
  <td class="headCellColum">
    <a href="<?=$_SERVER['PHP_SELF']?>?campo=cMailTrabajador&orden=<?=$cambio?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>"
      style=" text-decoration:<?php if($campo=="cMailTrabajador"){ echo "underline"; }else{ echo "none";}?>">Correo</a>
  </td>
  
  <td class="headCellColum">
    <a href="<?=$_SERVER['PHP_SELF']?>?campo=cMailTrabajador&orden=<?=$cambio?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>"
      style=" text-decoration:<?php if($campo=="cMailTrabajador"){ echo "underline"; }else{ echo "none";}?>">Nro Tr&aacute;mite </a>
  </td>
	
  <td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=iCodPerfil&orden=<?=$cambio?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>"  style=" text-decoration:<?php if($campo=="iCodPerfil"){ echo "underline"; }else{ echo "none";}?>">Perfil</a>
  </td>
	
  <td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cUsuario&orden=<?=$cambio?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>"  style=" text-decoration:<?php if($campo=="cUsuario"){ echo "underline"; }else{ echo "none";}?>">Usuario</a>
  </td>
	
  <td class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=nFlgEstado&orden=<?=$cambio?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>"  style=" text-decoration:<?php if($campo=="nFlgEstado"){ echo "underline"; }else{ echo "none";}?>">Estado</a>
  </td>
	
  <td class="headCellColum">Opciones</td>
	</tr>
<?php
$rs = sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);
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
    <?php 
      $sqlTrabajador = "SELECT * FROM Tra_M_Remitente WHERE cNombre LIKE '$Rs[cNombresTrabajador]'";
      $rsTrabajador  = sqlsrv_query($cnx,$sqlTrabajador);
      $RsTrabajador  = sqlsrv_fetch_array($rsTrabajador);
    ?>
    <td align="left" valign="top"><?php echo $RsTrabajador['cNombre']; ?></td>
    <td align="left" valign="top">
    	<?php
    	 $sqlTDoc = "SP_DOC_IDENTIDAD_LISTA_AR '$RsTrabajador[cTipoDocIdentidad]'";
    	 $rsTDoc  = sqlsrv_query($cnx,$sqlTDoc);
    	 $RsTDoc  = sqlsrv_fetch_array($rsTDoc);
    	 echo $RsTDoc['cDescDocIdentidad'].":".$Rs['nNumDocumento'];
    	?>
    </td>
    <td align="left" valign="top"><?=$Rs['cEmail'];?></td>
    <td align="left" valign="top"><?=$Rs['CCODIFICACION'];?></td>
    <td align="left" valign="top">
    	<?php
      //echo $Rs[iCodPerfil];
    	$sqlPerf="SP_PERFIL_LISTA_AR '$Rs[iCodPerfil]'";
    	$rsPerf=sqlsrv_query($cnx,$sqlPerf);
    	$RsPerf=sqlsrv_fetch_array($rsPerf);
    	echo $RsPerf['cDescPerfil'];
    	?>
    </td>
    <td align="left" valign="top"><?=$Rs['cUsuario'];?></td>
    <td align="center" valign="top">
    	<?php if($Rs['nFlgEstado']==1){?>
    		<div style="color:#005E2F">Activo</div>
    	<?php } else{?>
    		<div style="color:#950000">Inactivo</div>
    	<?php}?>
    </td>
	<td>
     
		  <a href="../controllers/ln_elimina_trabajador.php?id=<?=$Rs[iCodTrabajador]?>&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&txtestado=<?=$_GET[txtestado]?>&pag=<?=$pag?>"
        onClick='return ConfirmarBorrado();'">
          <i class="far fa-trash-alt"></i>
      </a>

      <a href="/iu_actualiza_trabajadores_externos.php?cod=<?=$Rs[iCodTrabajador]?>&sw=1&cNombreTrabajador=<?=trim($Rs['cNombre'])?>&cTipoDocIdentidad=<?=$Rs['cTipoPersona']?>&cNumDocIdentidad=<?=trim($Rs['nNumDocumento'])?>&iCodPerfil=<?=$Rs[iCodPerfil]?>&txtestado=<?=$Rs[nFlgEstado]?>&pag=<?=$pag?>">
      	<i class="fas fa-edit"></i>
      </a>

      <a href="/iu_actualiza_key.php?cod=<?=$Rs[iCodTrabajador]?>&usr=<?=trim($Rs[cUsuario])?>&cod=<?=trim($Rs[iCodTrabajador])?>&sw=1&cNombreTrabajador=<?=$_GET[cNombreTrabajador]?>&cApellidosTrabajador=<?=$_GET[cApellidosTrabajador]?>&cTipoDocIdentidad=<?=$_GET[cTipoDocIdentidad]?>&cNumDocIdentidad=<?=$_GET[cNumDocIdentidad]?>&iCodOficina=<?=$_GET['iCodOficina']?>&iCodPerfil=<?=$_GET[iCodPerfil]?>&iCodCategoria=<?=$_GET[iCodCategoria]?>&txtestado=<?=$_GET[txtestado]?>&pag=<?=$pag?>"
        rel="lyteframe" title="Cambio de Contrase&ntilde;a" rev="width: 380px; height: 80px; scrolling: auto; border:no">
        <img src="images/icon_key.png" width="16" height="16" border="0">
      </a>
	</td>
  </tr>
  
<?
}
}
?>  
</table>
<?php echo paginar($pag, $total, $tampag, "iu_trabajadores.php?cNombreTrabajador=".$_GET[cNombreTrabajador]."&cApellidosTrabajador=".$_GET[cApellidosTrabajador]."&iCodOficina=".$_GET['iCodOficina']."&cTipoDocIdentidad=".$_GET[cTipoDocIdentidad]."&cNumDocIdentidad=".$_GET[cNumDocIdentidad]."&iCodPerfil=".$_GET[iCodPerfil]."&iCodCategoria=".$_GET[iCodCategoria]."&txtestado=".$_GET[txtestado]."&campo=".$campo."&orden=".$orden."&pag="); ?>
<?php echo "<a href='iu_nuevo_trabajador_externo.php'>Nuevo Trabajador</a>";?></td>
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