<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
  include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<? include("includes/head.php");?>
<script>
function funcion(bol, frm, chkbox) { 
  for (var i=0;i < frmGrupoSalidas.elements[chkbox].length;i++) { // Dentro de todos los elementos, seleccionamos lo que tengan el mismo nombre que el seleccionado
  elemento = frmGrupoSalidas.elements[chkbox][i]; // Ahora es bidimensional
  elemento.checked = (bol) ? true : false;
  } 
}

function Del()
{ 
  cont = 0
  for (i=0;i<document.frmGrupoSalidas.elements.length;i++)
  {
      if(document.frmGrupoSalidas.elements[i].type == "checkbox")
      {
        if(document.frmGrupoSalidas.elements[i].checked == 1)
        {
          cont = cont + 1;
        }
      }
  }    
  if (cont>0){
    document.frmGrupoSalidas.method='POST';  
    document.frmGrupoSalidas.submit();
  }
  else{
    a = "Seleccione un Documento";
    alert( a);
  } 
}

function ConfirmarBorrado()
{
 if (confirm("Esta seguro de eliminar el registro?")){
  return true; 
 }else{ 
  return false; 
 }
}
function validar(f) {
 var error = "Por favor, seleccione un grupo de remitentes:\n\n";
  if (f.cGrupo.value == "%") {
    alert(error );
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
    <fieldset>
<legend>Criterios de B&uacute;squeda</legend> 
<table width="900" border="0">
   <tr>
   
   <!--

    <form name="form1" method="POST" onSubmit="return validar(this)" action="../cLogicaNegocio_SITD/ln_nuevo_doc_salidas_multiple.php?op=1"  >
   <input name="txtcod_tramite" type="hidden" id="txtcod_tramite" value="<?=$_GET[cod]?>"> -->
   <!--
   <td width="70" valign="middle" >Grupo:</td>
    <td width="156" valign="middle">
    <?
	  $sqlG=" SELECT * FROM Tra_M_Grupo_Remitente ";
    $rsG=sqlsrv_query($cnx,$sqlG);
	 	?>
		<!--<select name="cGrupo" class="FormPropertReg form-control" id="cGrupo"  />
     	                  <option value="%">Seleccione:</option>
	                   <? while ($RsG=sqlsrv_fetch_array($rsG)){
	  	                         echo "<option value=".$RsG[iCodGrupo]." ".$selecClas.">".$RsG[cDesGrupo]."</option>";
                                 }
								 
                                 sqlsrv_free_stmt($rsG);
								 
                              ?>
           <!-- </select>	</td>  	
    <td width="145" valign="middle" > <div align="center">
      <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'">
        <table cellspacing="0" cellpadding="0">
          <tr><td style=" font-size:10px"><table cellspacing="0" cellpadding="0">
            <tr>
              <td style=" font-size:10px"><b>Agregar</b>&nbsp;&nbsp;</td>

          </tr>
            </table>      <b></b></td></tr>
        </table>
        </button>
    </div></td>
    </form> -->
     
  
    <td valign="middle" >
    <div class="btn btn-primary" style="width:200px;height:17px;padding-top:4px;" >
      <div align="center">
      <a style=" text-decoration:none" href="iu_multiple_remitentes_seleccion.php?iCodTramite=<?=$cod?>" rel="lyteframe" title="Selecci&oacute;n de Remitente" rev="width: 1000px; height: 550px; scrolling: auto; border:no">Buscar institucion</a></div>
    </div>
    </td>
    <td width="28" valign="middle">
      <div align="center"></div>      </td>  
    <td width="166" valign="middle" ></td>	
  </tr>
   <!-- <tr>
     <td colspan="7" >
     <form name="form1" method="GET" action="<?=$_SERVER['PHP_SELF']?>">
       <table width="80%" border="0" align="left">
         <tr>
           <td width="70%"><div align="left">

Buscar Instituci&oacute;n:&nbsp; 


               <input name="cNombre" class="FormPropertReg form-control" type="text" value="<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>" size="50" />
              <input name="cod" class="FormPropertReg form-control" type="hidden" value="<?=$_GET[cod]?>"/>
              <button class="btn btn-primary" onclick="submit()" onmouseover="this.style.cursor='hand'">
              <table cellspacing="0" cellpadding="0">
                <tr>
                  <td style=" font-size:10px"><b>Buscar</b></td>
                  <td><img src="images/icon_buscar.png" width="1" height="17" border="0" /></td>
                </tr>
              </table>
              </button>
               </div></td>
           </tr>
       </table>
     </form>     </td>
     </tr>-->
   <tr>
     <td colspan="6" >
     <form id="form2" name="form2" method="post" action="consultaSalidaGeneral.php"><button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'">
        <table cellspacing="0" cellpadding="0" border="0">
          <tr><td style=" font-size:10px"><table cellspacing="0" cellpadding="0">
            <tr>
              <td style=" font-size:10px"><b>Finalizar</b>&nbsp;&nbsp;</td>

          </tr>
            </table>      <b></b></td></tr>
        </table>
        </button>
          </form>
     </td>
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

if($_GET['cNombre']!=""){

$sql="SELECT iCodAuto, Tra_M_Doc_Salidas_Multiples.iCodTramite, Tra_M_Doc_Salidas_Multiples.cCodificacion, Tra_M_Remitente.cNombre,Tra_M_Doc_Salidas_Multiples.cAsunto,  Tra_M_Doc_Salidas_Multiples.cNomRemite, Tra_M_Remitente.cDireccion , Tra_M_Doc_Salidas_Multiples.cObservacion, Tra_M_Doc_Salidas_Multiples.cDireccion, Tra_M_Doc_Salidas_Multiples.cDepartamento, Tra_M_Doc_Salidas_Multiples.cProvincia, Tra_M_Doc_Salidas_Multiples.cDistrito,  Tra_M_Remitente.iCodRemitente FROM Tra_M_Remitente,Tra_M_Doc_Salidas_Multiples
WHERE Tra_M_Remitente.iCodRemitente=Tra_M_Doc_Salidas_Multiples.iCodRemitente and Tra_M_Doc_Salidas_Multiples.iCodTramite=$_GET[cod]";

$sql.=" AND Tra_M_Remitente.cNombre like '%$_GET['cNombre']%' ";
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);
}

else{
$sql=" SP_DOC_SALIDA_MULTIPLE '".$_GET['cod']."' ";
$rs=sqlsrv_query($cnx,$sql);
$total = sqlsrv_has_rows($rs);
}
//echo $sql;
?>
<br>
<form name="frmGrupoSalidas" method="POST" action="../controllers/ln_elimina_doc_salidas_multiple.php" >
 <input name="cod" type="hidden" id="cod" value="<?php echo $_REQUEST['cod'];?>">
      	<td class="headCellColum">Numero Doc.</td>
    	<td class="headCellColum">Instituci&oacute;n</td>
    	<td class="headCellColum">Asunto</td>
        <td class="headCellColum">Destinatario</td>
    	<td class="headCellColum">Direcci&oacute;n</td>
        <td class="headCellColum">Observaci&oacute;n</td>
    	<td class="headCellColum">Opciones</td>
        <td class="headCellColum">
         <button class="btn btn-primary" onclick="Del();" onMouseOver="this.style.cursor='hand'"><i class="far fa-trash-alt"></i></td><td style=" font-size:10px"><b>Eliminar</b>&nbsp;&nbsp; </button>
        <input type="checkbox" name="iCodAuto[]"  value="" onclick="funcion(this.checked, this.frmGrupoSalidas, this.name);"/>
        </td>
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
  <tr bgcolor="<?=$color?>"><?php if($_GET['cNombre']!=""){?>

      <td align="left"><?=$Rs[cCodificacion]?></td>
      <td align="left"><?=$Rs['cNombre']?></td>
      <td align="left"><?=$Rs['cAsunto']?></td>
      <td align="left"><?=$Rs[cNomRemite]?></td>
      <td align="left"><?=$Rs[cDireccion]?></td>
      <td align="left"><?=$Rs[cObservacion]?></td>
      
    <?php } else {?>
      <td align="left"><?=$Rs[Codigo_Documento]?></td>
      <td align="left"><?=$Rs[Remitente]?></td>
      <td align="left"><?=$Rs['cAsunto']?></td>
      <td align="left"><?=$Rs[cNomRemite]?></td>
      <td align="left">
  	<? 
  	 $sqlDep="SELECT cNomDepartamento 	FROM Tra_U_Departamento WHERE cCodDepartamento='$Rs[cDepartamento]'";
  	  $rsDep=sqlsrv_query($cnx,$sqlDep);
  	  $RsDep=sqlsrv_fetch_array($rsDep);
  	  $sqlPro="SELECT cNomProvincia 	FROM Tra_U_Provincia 	WHERE cCodDepartamento='$Rs[cDepartamento]' And cCodProvincia='$Rs[cProvincia]'";
  	  $rsPro=sqlsrv_query($cnx,$sqlPro);
  	  $RsPro=sqlsrv_fetch_array($rsPro);
  	  $sqlDis="SELECT cNomDistrito	 	FROM Tra_U_Distrito 	WHERE cCodDepartamento='$Rs[cDepartamento]' And cCodProvincia='$Rs[cProvincia]' And cCodDistrito='$Rs[cDistrito]'";
  	  $rsDis=sqlsrv_query($cnx,$sqlDis);
  	  $RsDis=sqlsrv_fetch_array($rsDis);
  	  echo $Rs[Direccion]."<br>";
  	  if($Rs[cDepartamento]!=""){ echo $RsDep[cNomDepartamento];}
  	  if($Rs[cProvincia]!=""){ echo " - ".$RsPro[cNomProvincia];}
  	  if($Rs[cDistrito]!=""){ echo " - ".$RsDis[cNomDistrito];}
  	 
  	?></td>
      <td align="left"><?=$Rs[cObservacion]?></td>
    
       <?php }?>
      <td>
  	<div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;text-align:center"><a style=" text-decoration:none" href="javascript:;"  onClick="window.open('registroObservacion.php?iCodRemitente=<?=$Rs[iCodRemitente]?>&iCodTramite=<?=$Rs[iCodTramite]?>&iCodAuto=<?=$Rs[iCodAuto]?>','popuppage','width=590,height=340,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">+ Datos</a> </div>
      </td>
      <td>
      <input type="checkbox" name="iCodAuto[]" value="<?=$Rs[iCodAuto]?>">
      <input type="hidden" name="id[]" value="<?=$Rs[iCodRemitente]?>">
      </td>
    </tr>
    
  <?
  }
  }
  ?>
  </table>
</form>
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
