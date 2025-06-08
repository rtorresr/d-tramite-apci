<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroHojaRuta_pdf.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Reporte General en PDF
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
ob_start();
//*************************************

include_once("../conexion/conexion.php");
//echo $sql;
$sqlMov=" SELECT iCodOficinaDerivar,iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' ";
$rsMov=sqlsrv_query($cnx,$sqlMov);
$numMov= sqlsrv_has_rows($rsMov);
if($numMov>0){
$RsMov=sqlsrv_fetch_array($rsMov);
$sqlPrim=" SELECT * FROM Tra_M_Tramite WHERE iCodTramite = '$_GET[iCodTramite]' And iCodOficinaRegistro='".$_SESSION['iCodOficinaLogin']."' ";
$rsPrim=sqlsrv_query($cnx,$sqlPrim);
$RsPrim=sqlsrv_fetch_array($rsPrim);
$sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sql.=" WHERE Tra_M_Tramite_Movimientos.iCodTramite='$RsMov[iCodTramite]' And iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."'
        and ( cNumDocumentoDerivar = '$RsPrim[cCodificacion]' or cReferenciaDerivar = '$RsPrim[cCodificacion]' )";
$rs=sqlsrv_query($cnx,$sql);
while ($Rs=sqlsrv_fetch_array($rs)){

?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	<td style="text-align:left;	width: 100%">
					<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
	</tr>
	</table>
		
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;text-align:left; border: solid 0px #585858;font-family:Times">
	Datos Principales
	</td>
	</tr>
	</table>
	<table border=1 style="width:86%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?=$RsPrim[cCodificacion]?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
  			$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
  			$fechaMes=date("m", strtotime($RsPrim['fFecRegistro']));
    		$fechaMesEntero = intval($fechaMes);  
    		echo date("d", strtotime($RsPrim['fFecRegistro']));
    		echo "-".$PrintMes[$fechaMesEntero]."-";
  			echo date("Y h:i:s", strtotime($RsPrim['fFecRegistro']));
  			?>
  			</b>
  		</td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Area Origen</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  				$sqlOfi1="SELECT * FROM Tra_M_Trabajadores,Tra_M_Oficinas WHERE Tra_M_Trabajadores.iCodOficina=Tra_M_Oficinas.iCodOficina AND Tra_M_Trabajadores.iCodTrabajador='$RsPrim[iCodTrabajadorRegistro]'";
					$rsOfi1=sqlsrv_query($cnx,$sqlOfi1);
					$RsOfi1=sqlsrv_fetch_array($rsOfi1);
					echo $RsOfi1[cNomOficina];
  				?>	
  		</b></td>
  		</tr>
  		
  		<?
  		
  		?>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H Derivo</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  				$sqlM1="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
					$rsM1=sqlsrv_query($cnx,$sqlM1);
					if(sqlsrv_has_rows($rsM1)>0){
						$RsM1=sqlsrv_fetch_array($rsM1);
  					$fechaMes=date("m", strtotime($RsM1['fFecDerivar']));
    				$fechaMesEntero = intval($fechaMes);  
    				echo date("d", strtotime($RsM1['fFecDerivar']));
    				echo "-".$PrintMes[$fechaMesEntero]."-";
  					echo date("Y h:i:s", strtotime($RsM1['fFecDerivar']));
  				}
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTraDe=sqlsrv_query($cnx,"SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar ='$_GET[iCodTramite]' ");
	$RsTraDe=sqlsrv_fetch_array($rsTraDe);
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$RsTraDe[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo "( ".trim($RsTrax[cCodificacion])." ) ";?>
        <?php echo " ".$Rs[cReferencia];?>                        
        </b></td>
  		</tr>
  		
			<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$RsPrim[cCodTipoDoc]";
			    $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			    $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			    echo $RsTipDoc['cDescTipoDoc'];
				?>
  			</b>
  		</td>
  		</tr>		        		
  		</table>
	</td>
  </tr>
	</table>
	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:20px;text-align:left; vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Asunto
	</td>
	</tr>
	</table>

	<table border="1" style="width:86%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align:left; border: solid 1px #585858;font-family:Times">
   <?  echo $RsPrim['cAsunto'];
     if($Rs['iCodTupa']!=""){
    		$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='$RsPrim['iCodTupa']'";
      	$rsTup=sqlsrv_query($cnx,$sqlTup);
      	$RsTup=sqlsrv_fetch_array($rsTup);
	 echo "<br>";	
	 echo $RsTup[cNomTupa]; 
	 }?></td>
  </tr>
	</table>

	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:20px;text-align:left; vertical-align:bottom; border: solid 0px #585858;font-family:Times">&nbsp;
	
	</td>
	</tr>
	</table>

	<table border="1" style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
 <td style="width:3%; text-align: left; border: solid 1px #585858;"></td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Destino</td>
	<td style="width:6%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Ind</td>
  <td style="width:15%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Fecha Trans</td>
  <td style="width:20%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">V.B.</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="width:10px;height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">1</td>
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
	
	<td style="width:20px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
  	$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    $fechaMesEntero = intval($fechaMes);  
    echo date("d", strtotime($Rs['fFecDerivar']));
    echo "-".$PrintMes[$fechaMesEntero]."-";
  	echo date("Y", strtotime($Rs['fFecDerivar']));
	}
	?>
	</td>
<td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $RsPrim[cCodificacion];?>
	</td>
  <td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="width:40px;height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="width:44px;height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
   </table>
	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:20px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Observaciones:
	</td>
	</tr>
	</table>
	
	<table border="0" align="left">
	<tr>
  <td style="width:100%; text-align:left; border: solid 0px #585858;font-family:Times"><?=$Rs[Observaciones]?></td>
  </tr>
	</table>
	<br>
	<br>
	<br>	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:30px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Referencias:
	</td>
	</tr>
	<tr>
	<td>
	<? $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='".$_GET[iCodTramite]."'";
         $rsRefs=sqlsrv_query($cnx,$sqlRefs);
         while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
		echo $RsRefs[cReferencia];echo " <br> ";
		}?> 
	</td>
	</tr>
	
	</table>
	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:40px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Indicaciones:
	</td>
	</tr>
	</table>

	<table style="width:400px;border: solid 0px #585858; border-collapse: collapse" align="center">
  		<tr>
  		<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">01.ACCION NECESARIA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">02.ESTUDIO E INFORME</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">03.CONOCIMIENTO Y FINES</td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">04.FORMULAR RESPUESTA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">05.POR CORRESPONDERLE</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">06.TRANSCRIBIR</td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">07.PROYECTAR DISPOSITIVO</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">08.FIRMAR Y/O REVISAR</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">09.ARCHIVAR</td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">10.CONOCIMIENTO Y RESPUESTA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">11.PARA COMENTARIOS</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"></td>
  		</tr>
 </table>

	
	
</page>
<?
}
}
else {
$sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sql.=" WHERE Tra_M_Tramite.iCodTramite='$_GET[iCodTramite]' And iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."'   ";
$rs=sqlsrv_query($cnx,$sql);
while($Rs=sqlsrv_fetch_array($rs)){
?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	<td style="text-align:left;	width: 100%">
					<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
	</tr>
	</table>
		
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;text-align:left; border: solid 0px #585858;font-family:Times">
	Datos Principales
	</td>
	</tr>
	</table>
	<table border=1 style="width:86%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?=$Rs[cCodificacion]?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
  			$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
  			$fechaMes=date("m", strtotime($Rs['fFecRegistro']));
    		$fechaMesEntero = intval($fechaMes);  
    		echo date("d", strtotime($Rs['fFecRegistro']));
    		echo "-".$PrintMes[$fechaMesEntero]."-";
  			echo date("Y h:i:s", strtotime($Rs['fFecRegistro']));
  			?>
  			</b>
  		</td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Area Origen</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  				$sqlOfi1="SELECT * FROM Tra_M_Trabajadores,Tra_M_Oficinas WHERE Tra_M_Trabajadores.iCodOficina=Tra_M_Oficinas.iCodOficina AND Tra_M_Trabajadores.iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
					$rsOfi1=sqlsrv_query($cnx,$sqlOfi1);
					$RsOfi1=sqlsrv_fetch_array($rsOfi1);
					echo $RsOfi1[cNomOficina];
  				?>	
  		</b></td>
  		</tr>
  		
  		<?
  		
  		?>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H Derivo</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  				$sqlM1="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
					$rsM1=sqlsrv_query($cnx,$sqlM1);
					if(sqlsrv_has_rows($rsM1)>0){
						$RsM1=sqlsrv_fetch_array($rsM1);
  					$fechaMes=date("m", strtotime($RsM1['fFecDerivar']));
    				$fechaMesEntero = intval($fechaMes);  
    				echo date("d", strtotime($RsM1['fFecDerivar']));
    				echo "-".$PrintMes[$fechaMesEntero]."-";
  					echo date("Y h:i:s", strtotime($RsM1['fFecDerivar']));
  				}
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTraDe=sqlsrv_query($cnx,"SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar ='$_GET[iCodTramite]' ");
	$RsTraDe=sqlsrv_fetch_array($rsTraDe);
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$RsTraDe[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo "( ".trim($RsTrax[cCodificacion])." ) ";?>
        <?php echo " ".$Rs[cReferencia];?>                        
        </b></td>
  		</tr>
  		
			<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$Rs[cCodTipoDoc]";
			    $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			    $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			    echo $RsTipDoc['cDescTipoDoc'];
				?>
  			</b>
  		</td>
  		</tr>		        		
  		</table>
	</td>
  </tr>
	</table>
	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:20px;text-align:left; vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Asunto
	</td>
	</tr>
	</table>

	<table border="1" style="width:86%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align:left; border: solid 1px #585858;font-family:Times">
   <?  echo $Rs['cAsunto'];
     if($Rs['iCodTupa']!=""){
    		$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$Rs['iCodTupa']."'";
      	$rsTup=sqlsrv_query($cnx,$sqlTup);
      	$RsTup=sqlsrv_fetch_array($rsTup);
	 echo "<br>";	
	 echo $RsTup[cNomTupa]; 
	 }?></td>
  </tr>
	</table>

	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:20px;text-align:left; vertical-align:bottom; border: solid 0px #585858;font-family:Times">&nbsp;
	
	</td>
	</tr>
	</table>

	<table border="1" style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
 <td style="width:3%; text-align: left; border: solid 1px #585858;"></td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Destino</td>
	<td style="width:6%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Ind</td>
  <td style="width:15%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Fecha Trans</td>
  <td style="width:20%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">V.B.</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="width:10px;height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">1</td>
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
	
	<td style="width:20px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
  	$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    $fechaMesEntero = intval($fechaMes);  
    echo date("d", strtotime($Rs['fFecDerivar']));
    echo "-".$PrintMes[$fechaMesEntero]."-";
  	echo date("Y", strtotime($Rs['fFecDerivar']));
	}
	?>
	</td>
<td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $Rs[cCodificacion];?>
	</td>
  <td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="width:40px;height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="width:44px;height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
   </table>
	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:20px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Observaciones:
	</td>
	</tr>
	</table>
	
	<table border="0" align="left">
	<tr>
  <td style="width:100%; text-align:left; border: solid 0px #585858;font-family:Times"><?=$Rs[Observaciones]?></td>
  </tr>
	</table>
	<br>
	<br>
	<br>	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:30px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Referencias:
	</td>
	</tr>
	<tr>
	<td>
	<? $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTramite='".$_GET[iCodTramite]."'";
         $rsRefs=sqlsrv_query($cnx,$sqlRefs);
         while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
		echo $RsRefs[cReferencia];echo " <br> ";
		}?> 
	</td>
	</tr>
	
	</table>
	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:40px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Indicaciones:
	</td>
	</tr>
	</table>

	<table style="width:400px;border: solid 0px #585858; border-collapse: collapse" align="center">
  		<tr>
  		<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">01.ACCION NECESARIA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">02.ESTUDIO E INFORME</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">03.CONOCIMIENTO Y FINES</td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">04.FORMULAR RESPUESTA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">05.POR CORRESPONDERLE</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">06.TRANSCRIBIR</td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">07.PROYECTAR DISPOSITIVO</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">08.FIRMAR Y/O REVISAR</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">09.ARCHIVAR</td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">10.CONOCIMIENTO Y RESPUESTA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">11.PARA COMENTARIOS</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"></td>
  		</tr>
 </table>

	
	
</page>
<?
}
}
//*************************************


	$content = ob_get_clean();  set_time_limit(0);     ini_set('memory_limit', '640M');

	// conversion HTML => PDF
	require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	try
	{
		$html2pdf = new HTML2PDF('P','A4', 'es', false, 'UTF-8', 3);
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('exemple03.pdf');
	}
	catch(HTML2PDF_exception $e) { echo $e; }
?>   
         		
