<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroRespuesta.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Ingresa respuesta para un tramitre de salida
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script Language="JavaScript">
<!--
function Registrar(){
  if (document.frmRegistro.cRptaOK.value.length == "")
  {
    alert("Ingrese respuesta");
    document.frmRegistro.cRptaOK.focus();
    return (false);
  }
  document.frmRegistro.submit();
}
//--></script>
</head>
<body>
<table width="350" height="240"  cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff" align="center" >
<tr>
<td  align="left" valign="top">

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

<div class="AreaTitulo">Ingresar Respuesta</div>
<form method="POST" name="frmRegistro" action="registroRespuestadata.php" target="_parent">
		<table width="351" border="0" cellpadding="0" cellspacing="3" align="center">
		  <td width="230">
			<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
		<tr><td colspan="2">&nbsp;</td>
		<tr>
			<td colspan="2" align="center">
        <?    $sql="  SELECT  cRptaOK FROM Tra_M_Tramite  WHERE iCodTramite=".$_GET[iCodTramite];
              $rs=sqlsrv_query($cnx,$sql);	
			  $Rs=sqlsrv_fetch_array($rs);
		?>	      
		    <textarea name="cRptaOK" style="width:300px;height:70px" class="FormPropertReg form-control"><?=$Rs[cRptaOK]?></textarea></td>
		  </tr>
    <tr>
			<td height="37" colspan="2" align="center">
			  <input name="button" type="button" class="btn btn-primary" value="Continuar" onclick="Registrar();">
	
        </form>
  </div>      
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