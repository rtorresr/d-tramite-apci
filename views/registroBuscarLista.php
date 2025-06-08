<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Seleccion remitente
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
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
</head>
<body>

<div class="container">

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

<div class="AreaTitulo">
	Seleccione Documento:
</div>	
		<table width="100%" border="1" cellpadding="0" cellspacing="3">
			<form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
			<input type="hidden" name="cCodTipoDoc" value="<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>">
			<input type="hidden" name="iCodTrabajadorSolicitado" value="<?=$_GET[iCodTrabajadorSolicitado]?>">
			<input type="hidden" name="iCodOficinaSolicitado" value="<?=$_GET[iCodOficinaSolicitado]?>">
			<input type="hidden" name="cReferencia" value="<?=$_GET[cReferencia]?>">
			<input type="hidden" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>">
			<input type="hidden" name="cObservaciones" value="<?=$_GET[cObservaciones]?>">
			<input type="hidden" name="iCodIndicacion" value="<?=$_GET[iCodIndicacion]?>">
			<input type="hidden" name="nFlgRpta" value="<?=$_GET[nFlgRpta]?>">
			<input type="hidden" name="nNumFolio" value="<?=$_GET[nNumFolio]?>">
			<input type="hidden" name="fFecPlazo" value="<?=$_GET[fFecPlazo]?>">
			<input type="hidden" name="cSiglaAutor" value="<?=$_GET[cSiglaAutor]?>">
			<input type="hidden" name="iCodOficinaResponsable" value="<?=$_GET[iCodOficinaResponsable]?>">
			<input type="hidden" name="nFlgEnvio" value="<?=$_GET[nFlgEnvio]?>">
			<input type="hidden" name="tipoRemitente" value="<?=$_GET[tipoRemitente]?>">
			<input type="hidden" name="nFlgRegistro" value="<?=$_GET[nFlgRegistro]?>">
			<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
		<tr>
			<td align="left" colspan="3">
			Documento: <input type="text" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="30">
			<input type="submit" class="btn btn-primary" name="buscar" value="Buscar">
			</td>
		</tr>
			</form>
		<tr>
			<td align="center"    width="18">&nbsp;</td>
			<td align="center"    width="150"><?=$nombreTipoRemitente?></td>
			<td align="center"    width="400"><?=$TipoDocumento?></td>
		</tr>
		<?
		if($_GET[buscar]!=""){
		include_once("../conexion/conexion.php");
		$sqlRem="SELECT TOP 30 * FROM Tra_M_Tramite ";
		$sqlRem.="WHERE nFlgTipoDoc=1 ";
		$sqlRem.="AND cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
    $sqlRem.="ORDER BY iCodTramite DESC";
    $rsRem=sqlsrv_query($cnx,$sqlRem);
    while ($RsRem=sqlsrv_fetch_array($rsRem)){
    if ($color == "#e8f3ff"){
			$color = "#FFFFFF";
	  }else{
			$color = "#e8f3ff";
	  }
	  if ($color == ""){
			$color = "#FFFFFF";
	  }
		?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'; this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='<?=$color?>'" onClick="window.open('registroBuscarSelect.php?cReferencia=<?=$RsRem[cCodificacion]?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorSolicitado=<?=$_GET[iCodTrabajadorSolicitado]?>&iCodOficinaSolicitado=<?=$_GET[iCodOficinaSolicitado]?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>&iCodIndicacion=<?=$_GET[iCodIndicacion]?>&nFlgRpta=<?=$_GET[nFlgRpta]?>&nNumFolio=<?=$_GET[nNumFolio]?>&fFecPlazo=<?=$_GET[fFecPlazo]?>&cSiglaAutor=<?=$_GET[cSiglaAutor]?>&iCodOficinaResponsable=<?=$_GET[iCodOficinaResponsable]?>&nFlgEnvio=<?=$_GET[nFlgEnvio]?>&tipoRemitente=<?=$_GET[tipoRemitente]?>&iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&nFlgRegistro=<?=$_GET[nFlgRegistro]?>', '_parent');">
    <td width="18"><img src="images/icon_select.png" width="18" height="18" border="0"></td>
    <td align=left>
    	<?
    	$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsRem[cCodTipoDoc]'";
			$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			echo $RsTipDoc['cDescTipoDoc'];
			?>
    </td>
    <td><?=$RsRem["cCodificacion"]?></td>
    </tr>
    <?
    }
    sqlsrv_free_stmt($rsRem);
}
		?>
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