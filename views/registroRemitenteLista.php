<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
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
	Seleccione Remitente:
</div>	
		<table width="100%" border="1" cellpadding="0" cellspacing="3">
			<form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
			<input type="hidden" name="cCodTipoDoc" value="<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>">
			<input type="hidden" name="cNroDocumento" value="<?=$_GET['cNroDocumento']?>">
			<input type="hidden" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>">
			<input type="hidden" name="cObservaciones" value="<?=$_GET[cObservaciones]?>">
			<input type="hidden" name="iCodTupaClase" value="<?=$_GET[iCodTupaClase]?>">
			<input type="hidden" name="iCodTupa" value="<?=$_GET['iCodTupa']?>">
			<input type="hidden" name="cReferencia" value="<?=$_GET[cReferencia]?>">
			<input type="hidden" name="iCodOficinaResponsable" value="<?=$_GET[iCodOficinaResponsable]?>">
			<input type="hidden" name="iCodTrabajadorResponsable" value="<?=(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')?>">
			<input type="hidden" name="iCodIndicacion" value="<?=$_GET[iCodIndicacion]?>">
			<input type="hidden" name="nNumFolio" value="<?=$_GET[nNumFolio]?>">
			<input type="hidden" name="nFlgEnvio" value="<?=$_GET[nFlgEnvio]?>">
			<input type="hidden" name="cNomRemite" value="<?=$_GET[cNomRemite]?>">
			<input type="hidden" name="nFlgClaseDoc" value="<?=$_GET[nFlgClaseDoc]?>">
		<tr>
			<td align="left" colspan="3">
			Nombre: <input type="text" name="cNombreBuscar" value="<?=$_GET[cNombreBuscar]?>" style="width:310px">
			&nbsp;&nbsp;&nbsp;
			Nro. Documento: <input type="text" name="nNumDocumento" value="<?=$_GET['nNumDocumento']?>" size="10">
			<input type="submit" class="btn btn-primary" name="buscar" value="Buscar">
			</td>
		</tr>
			</form>
		<tr>
			<td align="center"    width="18">&nbsp;</td>
			<td align="center"    width="510"><?=$nombreTipoRemitente?></td>
			<td align="center"    width="90"><?=$TipoDocumento?></td>
		</tr>
		<?
		include_once("../conexion/conexion.php");
		if($_GET[buscar]==""){
			$sqlRem="SELECT TOP 10 * FROM Tra_M_Remitente ";
		}Else{
			$sqlRem="SELECT TOP 500 * FROM Tra_M_Remitente ";
		}
		$sqlRem.="WHERE cNombre IS NOT NULL ";
		if($_GET[cNombreBuscar]!=""){
		$sqlRem.="AND cNombre LIKE '%$_GET[cNombreBuscar]%' ";
		}
		if($_GET['nNumDocumento']!=""){
		$sqlRem.="AND nNumDocumento='$_GET['nNumDocumento']' ";
		}
    $sqlRem.="ORDER BY cNombre ASC";
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
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'; this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='<?=$color?>'" onClick="window.open('registroRemitenteSelect.php?iCodRemitente=<?=$RsRem[iCodRemitente]?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cNroDocumento=<?=$_GET['cNroDocumento']?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cObservaciones=<?=$_GET[cObservaciones]?>&iCodTupaClase=<?=$_GET[iCodTupaClase]?>&iCodTupa=<?=$_GET['iCodTupa']?>&cReferencia=<?=$_GET[cReferencia]?>&iCodOficinaResponsable=<?=$_GET[iCodOficinaResponsable]?>&iCodTrabajadorResponsable=<?=(isset($_GET['iCodTrabajadorResponsable'])?$_GET['iCodTrabajadorResponsable']:'')?>&iCodIndicacion=<?=$_GET[iCodIndicacion]?>&nNumFolio=<?=$_GET[nNumFolio]?>&nFlgEnvio=<?=$_GET[nFlgEnvio]?>&cNomRemite=<?=$_GET[cNomRemite]?>&nFlgClaseDoc=<?=$_GET[nFlgClaseDoc]?>', '_parent');">
    <td width="18"><img src="images/icon_select.png" width="18" height="18" border="0"></td>
    <td width="510"><?=$RsRem["cNombre"]?></td>
    <td width="90" align=right><?=$RsRem["nNumDocumento"]?></td>
    </tr>
    <?
    }
    sqlsrv_free_stmt($rsRem);
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