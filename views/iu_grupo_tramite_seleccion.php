<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: iu_grupo_tramite_seleccion.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Seleccion Trabajador de tramite
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   Larry Ortiz        12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script Language="JavaScript">
<!--


function seleccionar_todo(){
	for (i=0;i<document.formulario.elements.length;i++)
		if(document.formulario.elements[i].type == "checkbox")	
			document.formulario.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.formulario.elements.length;i++)
		if(document.formulario.elements[i].type == "checkbox")	
			document.formulario.elements[i].checked=0
}

function Registrar()
{
  document.formulario.submit();
  
}

//--></script>
</head>
<body>

<table width="1000" height="500" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
<tr>
<td align="left" valign="top">

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

	
<div class="AreaTitulo">Seleccione Trabajador:</div>	
		<table width="100%" border="1" cellpadding="0" cellspacing="3">
        
			<form method="GET" name="formGrupoTramite" action="<?=$_SERVER['PHP_SELF']?>">
            <input type="hidden" name="iCodGrupoTramite" value="<?=$_GET[iCodGrupoTramite]?>">
       	<tr>
			<td height="39" colspan="4" align="CENTER">
			Nombre: <input type="text" name="cNombresTrabajador" value="<?=$_GET[cNombresTrabajador]?>" size="35">
			&nbsp;&nbsp;&nbsp;
			Apellidos: <input type="text" name="cApellidosTrabajador" value="<?=$_GET[cApellidosTrabajador]?>" size="35">
             &nbsp;&nbsp;&nbsp;
             <input type="submit" class="btn btn-primary" value="BUSCAR" >
			
           </td>
		</tr>
        </form>
		<form method="POST" name="formulario" action="../controllers/ln_nuevo_grupo_tramite_detalle.php" target="_parent">
       	<input type="hidden" name="iCodGrupoTramite" value="<?=$_GET[iCodGrupoTramite]?>">
       
        
        <tr>
			<td align="center" valign="middle"    width="18"><a href="javascript:seleccionar_todo()"><img src="images/icon_select.png" width="18" height="18" border="0" /></a></td>
		  <td align="center"    width="510">Trabajador</td>
			<td align="center"    width="90">Nro. de Documento</td>
           
		</tr>
		<?
		
		include_once("../conexion/conexion.php");
		if($_GET[cNombresTrabajador]!="" or $_GET[cApellidosTrabajador]!="" ){
		$sqlRem="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador NOT IN ";
		$sqlRem.=" (SELECT Tra_M_Trabajadores.iCodTrabajador FROM Tra_M_Trabajadores,Tra_M_Grupo_Tramite_Detalle ";
        $sqlRem.=" WHERE Tra_M_Trabajadores.iCodTrabajador=Tra_M_Grupo_Tramite_Detalle.iCodTrabajador And  nFlgEstado=1 ";
        $sqlRem.=" AND iCodGrupoTramite='$_GET[iCodGrupoTramite]') ";
		if($_GET[cNombresTrabajador]!=""){
$sqlRem.=" AND cNombresTrabajador LIKE '%$_GET[cNombresTrabajador]%' ";	
	}
if($_GET[cApellidosTrabajador]!=""){
$sqlRem.=" AND cApellidosTrabajador LIKE '%$_GET[cApellidosTrabajador]%' ";	
	}	
        $sqlRem.="ORDER BY cNombresTrabajador ASC";
		
    $rsRem=sqlsrv_query($cnx,$sqlRem);
	
    while ($RsRem=sqlsrv_fetch_array($rsRem)){
	for ($h=0;$h<count($_POST[iCodTrabajador]);$h++){
      	$iCodTrabajador= $_POST[iCodTrabajador];
		if($RsRem[iCodTrabajador]==$iCodTrabajador[$h]){
   			$Checkear="checked";
		}
	}
							
    if ($color == "#e8f3ff"){
			$color = "#FFFFFF";
	  }else{
			$color = "#e8f3ff";
	  }
	  if ($color == ""){
			$color = "#FFFFFF";
	  }
		?>
        
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'; this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='<?=$color?>'" >
    
    <td width="18"><label>
     <input type="checkbox" name="iCodTrabajador[]"  value="<?=$RsRem["iCodTrabajador"]?>"/>
    </label></td>
    <td width="510"><?php echo $RsRem["cNombresTrabajador"]." ".$RsRem["cApellidosTrabajador"];?></td>
    <td width="90" align=left><?=$RsRem["cNumDocIdentidad"]?></td>
    </tr>
    
    <?
	}
    sqlsrv_free_stmt($rsRem);
	
	}
		?>
    <tr>
     <td  colspan="4" align="center"> 
     <input name="button" type="button" class="btn btn-primary" value="AGREGAR" onclick="Registrar();">
     </td>
    
    </tr>   
        </form>
		</table>
<div>		
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>