<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
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

<table width="1000" height="550" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
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

	
<div class="AreaTitulo">Seleccione Destinatario:</div>
	<table width="100%" border="1" cellpadding="0" cellspacing="3">
        
			<form method="GET" name="formGrupoRemitente" action="<?=$_SERVER['PHP_SELF']?>">
            <input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
       	<tr>
			<td height="39" colspan="4" align="CENTER">
			Nombre: <input type="text" name="cNombreBuscar" value="<?=$_GET[cNombreBuscar]?>" size="35">
			&nbsp;&nbsp;&nbsp;
			Nro. Documento: <input type="text" name="nNumDocumento" value="<?=$_GET['nNumDocumento']?>" size="10">
             &nbsp;&nbsp;&nbsp;
			Sigla de Destinatario: 
			<input type="text" name="cSiglaRemitente" value="<?=$_GET[cSiglaRemitente]?>" size="20">
            &nbsp;&nbsp;&nbsp;
             <input type="submit" class="btn btn-primary" value="Buscar "  >
			
           </td>
		</tr>
        </form>
		<form method="POST" name="formulario" action="../controllers/ln_nuevo_doc_salidas_multiple.php?op=2" target="_parent">
       	   <input type="hidden" name="CodTramite" value="<?=$_GET[iCodTramite]?>">
       
        
        <tr>
			<td align="center" valign="middle"    width="18"><a href="javascript:seleccionar_todo()"><img src="images/icon_select.png" width="18" height="18" border="0" /></a></td>
		  <td align="center"    width="510">Destinatario</td>
			<td align="center"    width="90">Nro. de Documento</td>
            <td align="center"    width="90">Sigla de Destinatario</td>
		</tr>
		<?
		
		include_once("../conexion/conexion.php");
		if($_GET[cNombreBuscar]!="" or $_GET['nNumDocumento']!="" or $_GET[cSiglaRemitente]!="" ){
		$sqlRem="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente > 1  ";
	/*	$sqlRem.=" WHERE iCodRemitente NOT IN (SELECT Tra_M_Remitente.iCodRemitente FROM Tra_M_Remitente,Tra_M_Doc_Salidas_Multiples ";
        $sqlRem.=" WHERE Tra_M_Remitente.iCodRemitente=Tra_M_Doc_Salidas_Multiples.iCodRemitente  ";
        $sqlRem.=" AND iCodTramite='$_GET[iCodTramite]') "; */
		if($_GET[cNombreBuscar]!=""){
		$sqlRem.=" AND cNombre LIKE '%'+'$_GET[cNombreBuscar]'+'%' ";
		}
		if($_GET['nNumDocumento']!=""){
		$sqlRem.=" AND nNumDocumento LIKE '%'+'$_GET['nNumDocumento']'+'%' ";
		}
		if($_GET[cSiglaRemitente]!=""){
		$sqlRem.=" AND cSiglaRemitente LIKE '%$_GET[cSiglaRemitente]%' ";
		}
        $sqlRem.="ORDER BY cNombre ASC";
		
    $rsRem=sqlsrv_query($cnx,$sqlRem);
	
    while ($RsRem=sqlsrv_fetch_array($rsRem)){
	For ($h=0;$h<count($_POST[iCodRemitente]);$h++){
      	$iCodRemitente= $_POST[iCodRemitente];
		if($RsTupaReq[iCodRemitente]==$iCodRemitente[$h]){
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
      <input type="checkbox" name="iCodRemitente[]"  value="<?=$RsRem["iCodRemitente"]?>"/>
    </label></td>
    <td width="510"><?=$RsRem["cNombre"]?></td>
    <td width="90" align=left><?=$RsRem["nNumDocumento"]?></td>
    <td width="90" align=left><?=$RsRem["cSiglaRemitente"]?></td>
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