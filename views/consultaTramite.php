<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaTramite.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Acceso al estado del Tramite
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripci�n
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creaci�n del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
include_once("../conexion/conexion.php");
include("secure_string.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UFT-8' />
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<link rel="stylesheet" href="css/detalle_web.css" type="text/css" />
<script Language="JavaScript">
function verif(n){
permitidos=/[^0-9.]/;
if(permitidos.test(n.value)){
alert("Solo se puedeingresar numeros");
n.value="";
n.focus();
}
}
function Buscar()
{
  document.frmConsultaTramite.submit();
}

//--></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body style="margin-top:0px; w" >
<table width="373" border="0" style="background:url(images/fondo1.png); background-repeat:no-repeat; width:100%">
<tr height="58px">
<td>

</td>
</tr>
<tr>
<td>
<table cellpadding="0" cellspacing="0" border="0" width="361" align="center">
  <tr><td width="607"><?php // ini table por fieldset ?>
	
		<table cellpadding="3" cellspacing="3" border="0" width="361">
<form name="frmConsultaTramite" method="POST" >

						<tr>
							<td width="97" >N&ordm; Documento:</td>
							<td width="135" align="left"><input type="txt" onpaste="return false" name="cCodificacion" value="<?php echo htmlspecialchars($_POST['cCodificacion']); ?>"  size="20" maxlength="10" class="FormPropertReg form-control"  onKeyup="verif(this)" onblur="verif(this)" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"></td>
							<td width="99" align="left">

									<td ><input  type="submit" value="Buscar" >
             </td>
									</tr></table>
						  </td>
						</tr>

		  </form>
		</table>
	
 
</td>
</tr>
<tr>
<td>

<?
if($_REQUEST[cCodificacion]!=""){ //obtener el codigo del documento
   $x= secureSQL($_REQUEST[cCodificacion]);
   $sqlCod= "SP_WEBCONSULTA_MAESTRA_LISTA '$x'  ";
   $rsCod=sqlsrv_query($cnx,$sqlCod);
   $numrows=sqlsrv_has_rows($rsCod);
    if($numrows==0){ 
		echo "No Se Encuentra ese Documento<br>";
    }
	else {
		$RsCod=sqlsrv_fetch_array($rsCod);
 		
	$rs=sqlsrv_query($cnx,"SP_WEBCONSULTA_MAESTRA_LISTAXCODTRAMITE '".$RsCod[iCodTramite]."' ");
	$Rs=sqlsrv_fetch_array($rs);
	$sqlTipDoc=" SP_TIPO_DOCUMENTO_LISTA_AR '$Rs[cCodTipoDoc]'";
	$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
	$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
	$sqlRemi=" SP_REMITENTE_LISTA_AR '$Rs[iCodRemitente]'";
    $rsRemi=sqlsrv_query($cnx,$sqlRemi);
    $RsRemi=sqlsrv_fetch_array($rsRemi);
	$sqlOfi="SELECT TOP 1 iCodOficinaDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsCod[iCodTramite]' ORDER BY iCodMovimiento DESC ";
	$rsOfi=sqlsrv_query($cnx,$sqlOfi);
    $RsOfi=sqlsrv_fetch_array($rsOfi);
	$sqlOfis="SELECT cNomOficina FROM Tra_M_Oficinas WHERE iCodOficina='$RsOfi[iCodOficinaDerivar]'  ";
	$rsOfis=sqlsrv_query($cnx,$sqlOfis);
    $RsOfis=sqlsrv_fetch_array($rsOfis);
?>
		<table   border="0" width="370" align="center">
		<tr>
		<td width="380" >
				<fieldset id="tfa_GeneralDoc" class="fieldset">
				<div align="center">
				  <legend class="legend"><a href="javascript:;" onClick="muestra('zonaGeneral')" class="LnkZonas">Datos Generales <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
				  </div>
				<div id="zonaGeneral">
		    <table border="0" >
		    <tr>
		        <td width="6"   >&nbsp;</td>
		        <td width="141"  ><div align="left">Fecha de Registro:&nbsp;</div></td>
		        <td width="192"   class="CellFormDet">
		        	<span><?=date("d-m-Y", strtotime($Rs['fFecRegistro']))?></span>
        			<span style=font-size:10px><?=date("G: i", strtotime($Rs['fFecRegistro']))?></span>		        </td>
		    </tr> 

		    <tr>
		      <td >&nbsp;</td>
		      <td ><div align="left">N&ordm; Tramite:</div></td>
		      <td class="CellFormDet"><?=$Rs[cCodificacion]?></td>
		      </tr>
		    <tr>
		      <td >&nbsp;</td>
		      <td ><div align="left">Tipo de Documento:&nbsp;</div></td>
		      <td class="CellFormDet"><?=$RsTipDoc['cDescTipoDoc']?></td>
		      </tr>
		    <tr>
		        <td  >&nbsp;</td>
		        <td ><div align="left">N&ordm; Documento:&nbsp;</div></td>
		        <td class="CellFormDet"><?=$Rs['cNroDocumento']?></td>
	          </tr>

		    <tr>
		      <td >&nbsp;</td>
		      <td ><div align="left">Institucion:</div></td>
		      <td class="CellFormDet"><?=$RsRemi['cNombre']?>
		      </tr>
		    <tr>
		      <td >&nbsp;</td>
		      <td ><div align="left">Remite:</div></td>
		      <td class="CellFormDet"><?=$Rs[cNomRemite]?></td>
		      </tr>
		    <tr>
		        <td  >&nbsp;</td>
		        <td   ><div align="left">Folios:&nbsp;</div></td>
		        <td class="CellFormDet"><?=$Rs[nNumFolio];?></td>
		    </tr>
	    
		    <tr>
		      <td >&nbsp;</td>
		      <td ><div align="left">Asunto:&nbsp;</div></td>
		      <td class="CellFormDet"><?=$Rs['cAsunto']?></td>
		      </tr>
		    <tr>
		        <td   >&nbsp;</td>
		        <td   ><div align="left">Observaciones:&nbsp;</div></td>
		        <td class="CellFormDet"><?=$Rs[cObservaciones]?></td>
		    </tr>
    	    <tr>
		        <td   >&nbsp;</td>
		        <td  ><div align="left">Oficina en Atencion:</div></td>
		        <td class="CellFormDet"><?=$RsOfis[cNomOficina]?></td>
		    </tr>
		     <tr>
		      <td >&nbsp;</td>
		      <td ><div align="left">Estado del Documento:</div></td>
		      <td class="CellFormDet"><?php 
			  		if($Rs[nFlgEstado]==1){
					echo "<div style=color:#950000>PENDIENTE</div>";}
					else if($Rs[nFlgEstado]==2){
					echo "<div style=color:#950000>EN PROCESO</div>";}
					else if($Rs[nFlgEstado]==3){
					echo "<div style=color:#060>FINALIZADO</div>";
					$sqlFinTxt="SELECT fFecFinalizar FROM Tra_M_Tramite_Movimientos WHERE nEstadoMovimiento=5 AND iCodTramite='$RsCod[iCodTramite]' order by iCodMovimiento DESC";
			            $rsFinTxt=sqlsrv_query($cnx,$sqlFinTxt);
			            $RsFinTxt=sqlsrv_fetch_array($rsFinTxt);
			            echo "<div >".date("d-m-Y", strtotime($RsFinTxt["fFecFinalizar"]))."</div>";
						echo "<div style=style=font-size:10px>".date("G:i", strtotime($RsFinTxt["fFecFinalizar"]))."</div>";
						?>
				<?php	}?></td>
		      </tr>
		    </table>
		  	</div>
		  	<img src="images/space.gif" width="0" height="0">
				</fieldset>
		</td>
		</tr>
</table>
<?
	}
}
?>		
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


</body>
</html>