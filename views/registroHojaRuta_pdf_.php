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

function filtroString($titulo){
    return(ereg_replace('[^ A-Z�,./-���,./-�a�,./-z0-9_�,./(,./),./-]','',$titulo));
	//  return(ereg("^([^<]*)(<[^>]+>[^<]*)*$", $str, $tags));
}

include_once("../conexion/conexion.php");
$sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sql.=" WHERE Tra_M_Tramite.nCodBarra='$_GET[nCodBarra]' AND Tra_M_Tramite.cCodificacion='".$_GET['cCodificacion']."' ";
$rs=sqlsrv_query($cnx,$sql);
$Rs=sqlsrv_fetch_array($rs)
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
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?php echo " ".$Rs[cCodificacion];?></b></td>
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
					echo trim($RsOfi1[cNomOficina]);
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
  				$sqlM1="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
					$rsM1=sqlsrv_query($cnx,$sqlM1);
					$RsM1=sqlsrv_fetch_array($rsM1);
  				$fechaMes=date("m", strtotime($RsM1['fFecDerivar']));
    			$fechaMesEntero = intval($fechaMes);  
    			echo date("d", strtotime($RsM1['fFecDerivar']));
    			echo "-".$PrintMes[$fechaMesEntero]."-";
  				echo date("Y G:i:s", strtotime($RsM1['fFecDerivar']));
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b><?php echo " ".filtroString($Rs['cNroDocumento']);?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times;vertical-align:top">Institución</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px;vertical-align:top">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<? 
			   $sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
			   $rsRemi=sqlsrv_query($cnx,$sqlRemi);
			   $RsRemi=sqlsrv_fetch_array($rsRemi);
			   echo $RsRemi['cNombre'];
			  ?>
  			</b>
  		</td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Remitente</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:12px;text-transform:uppercase;font-family:Times"><b><?php echo filtroString($Rs[cNomRemite]);?></b></td>
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
	
	<table style="width:810px;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:810px;height:20px;text-align:left; vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Asunto
	</td>
	</tr>
	</table>

	<table border="1" style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 86%; text-align:left; border: solid 1px #585858;font-family:Times">
  <?php echo filtroString($Rs['cAsunto']);
     if($Rs['iCodTupa']!=""){
    		$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='".$Rs['iCodTupa']."'";
      	$rsTup=sqlsrv_query($cnx,$sqlTup);
      	$RsTup=sqlsrv_fetch_array($rsTup);
	 echo "<br>";	
	 echo $RsTup[cNomTupa]; 
	 }
  ?></td>
  </tr>
	</table>
<br>
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

	<?
	$sqlM="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND cFlgTipoMovimiento!=4 ORDER BY iCodMovimiento ASC";
	$rsM=sqlsrv_query($cnx,$sqlM);
	$RsM=sqlsrv_fetch_array($rsM);
	?>
  <tr>
  <td style="width:10px;height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">1</td>
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
	
	<td style="width:20px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacion]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
  	$fechaMes=date("m", strtotime($RsM['fFecDerivar']));
    $fechaMesEntero = intval($fechaMes);  
    echo date("d", strtotime($RsM['fFecDerivar']));
    echo "-".$PrintMes[$fechaMesEntero]."-";
  	echo date("Y", strtotime($RsM['fFecDerivar']));
	}
  	?>
	</td>
<td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	
	</td>
  <td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?php echo filtroString($Rs[nNumFolio]); ?>
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
	<td style="width:410px;height:20px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Observaciones:
	</td>
	</tr>
	</table>
	
	<table border="0" align="left">
	<tr>
  <td style="width:100%; text-align:left; border: solid 0px #585858;font-family:Times"><?=filtroString($Rs[Observaciones])?></td>
  </tr>
	</table>
	<table style="width:410px;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:410px;height:30px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Referencias:
	</td>
	</tr>
	</table>
	
	<table style="width:410px;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:410px;height:40px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Indicaciones:
	</td>
	</tr>
	</table>

	<table style="width:400px;border: solid 0px #585858; border-collapse: collapse" align="center">
  		<tr>
  		<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">01.ACCION NECESARIA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">02.ESTUDIO E INFORME</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">03.CONOCIMIENTO Y FINES</td>
        <td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">04.FORMULAR RESPUESTA</span></td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">05.POR CORRESPONDERLE</span></td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">06.TRANSCRIBIR</span></td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">07.PROYECTAR DISPOSITIVO</span></td>
        <td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">08.FIRMAR Y/O REVISAR</span></td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">09.ARCHIVAR</span></td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">10.CONOCIMIENTO Y RESPUESTA</span></td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">11.PARA COMENTARIOS</span></td>
        <td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">&nbsp;</td>
  		</tr>
		
 </table>

	
	
</page>

<?
//************************ INI COPIA ******************************
$sqlC="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
$sqlC.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
$sqlC.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sqlC.=" WHERE Tra_M_Tramite.nCodBarra='$_GET[nCodBarra]' AND Tra_M_Tramite.cCodificacion='".$_GET['cCodificacion']."' AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=4";
$sqlC.=" ORDER BY Tra_M_Tramite_Movimientos.iCodMovimiento ASC";
$rsC=sqlsrv_query($cnx,$sqlC);
while ($RsC=sqlsrv_fetch_array($rsC)){
?>

<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:400px;border:solid 0px black;">
	<tr>
	<td style="text-align:left;	width: 100%">
					<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
	</tr>
	</table>
		
	<table style="width:400px;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:400px;text-align:left; border: solid 0px #585858;font-family:Times">
	Datos Principales
	</td>
	</tr>
	</table>
	<table border=1 style="width:86%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
  		<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?php echo " ".$RsC[cCodificacion];?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
  			$fechaMes=date("m", strtotime($RsC['fFecRegistro']));
    		$fechaMesEntero = intval($fechaMes);  
    		echo date("d", strtotime($RsC['fFecRegistro']));
    		echo "-".$PrintMes[$fechaMesEntero]."-";
  			echo date("Y h:i:s", strtotime($RsC['fFecRegistro']));
  			?>
  			</b>
  		</td>
  		</tr>  		
  		<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Area Origen</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  				$sqlOfi2="SELECT * FROM Tra_M_Trabajadores,Tra_M_Oficinas WHERE Tra_M_Trabajadores.iCodOficina=Tra_M_Oficinas.iCodOficina AND Tra_M_Trabajadores.iCodTrabajador='$RsC[iCodTrabajadorRegistro]'";
					$rsOfi2=sqlsrv_query($cnx,$sqlOfi2);
					$RsOfi2=sqlsrv_fetch_array($rsOfi2);
					echo trim($RsOfi2[cNomOficina]);
  				?>	
  		</b></td>
  		</tr>
  		
  		<?
  		
  		?>
  		
  		<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H Derivo</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  				$sqlM2="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsC[iCodTramite]' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
					$rsM2=sqlsrv_query($cnx,$sqlM2);
					$RsM2=sqlsrv_fetch_array($rsM2);
  				$fechaMes=date("m", strtotime($RsM2['fFecDerivar']));
    			$fechaMesEntero = intval($fechaMes);  
    			echo date("d", strtotime($RsM2['fFecDerivar']));
    			echo "-".$PrintMes[$fechaMesEntero]."-";
  				echo date("Y h:i:s", strtotime($RsM2['fFecDerivar']));
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b><?php echo " ".filtroString($RsC['cNroDocumento']);?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times;vertical-align:top">Institución</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px;vertical-align:top">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<? 
			   $sqlRemiT="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$RsC[iCodRemitente]'";
			   $rsRemiT=sqlsrv_query($cnx,$sqlRemiT);
			   $RsRemiT=sqlsrv_fetch_array($rsRemiT);
			   echo $RsRemiT['cNombre'];
			  ?>
  			</b>
  		</td>
  		</tr>
  		
  		<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Remitente</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:12px;text-transform:uppercase;font-family:Times"><b><?php echo filtroString($RsC[cNomRemite]);?></b></td>
  		</tr>
  		
			<tr>
  		<td style="width:24%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:64%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$RsC[cCodTipoDoc]";
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

	<table border="1" style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 86%; text-align:left; border: solid 1px #585858;font-family:Times">
  <?php echo filtroString($RsC['cAsunto']);
     if($RsC['iCodTupa']!=""){
    		$sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='$RsC['iCodTupa']'";
      	$rsTup=sqlsrv_query($cnx,$sqlTup);
      	$RsTup=sqlsrv_fetch_array($rsTup);
	 echo "<br>";	
	 echo $RsTup[cNomTupa]; 
	 }
  ?></td>
  </tr>
	</table>
	<br>
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

	<?
	$sqlMov="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsC[iCodTramite]' ORDER BY iCodMovimiento ASC";
	$rsMov=sqlsrv_query($cnx,$sqlMov);
	$RsMov=sqlsrv_fetch_array($rsMov);
	?>
  <tr>
  <td style="width:10px;height:40px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">1</td>
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsC[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
	
	<td style="width:20px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsC[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
		echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="width:80px;height:20px; text-align: left; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?
	if($RsC['fFecDerivar']!=""){
  	$fechaMes=date("m", strtotime($RsC['fFecDerivar']));
    $fechaMesEntero = intval($fechaMes);  
    echo date("d", strtotime($RsC['fFecDerivar']));
    echo "-".$PrintMes[$fechaMesEntero]."-";
  	echo date("Y", strtotime($RsC['fFecDerivar']));
	}
  	?>
	</td>
<td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	
	</td>
  <td style="width:23px;height:20px; text-align: center; border: solid 1px #585858;font-size:14px;font-family:Times">
  	<?php echo $RsC[nNumFolio]; ?>
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
  <td style="width:100%; text-align:left; border: solid 0px #585858;font-family:Times"><?=filtroString($RsC[cObservacionesDerivar])?></td>
  </tr>
	</table>
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:20px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Referencias:
	</td>
	</tr>
	</table>	
  <table style="width:810px;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:810px;height:40px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Indicaciones:
	</td>
	</tr>
	</table>

	<table style="width:400px;border: solid 0px #585858; border-collapse: collapse" align="center">
  		<tr>
  		<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">01.ACCION NECESARIA</td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">02.ESTUDIO E INFORME</td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">03.CONOCIMIENTO Y FINES</td>
        <td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">04.FORMULAR RESPUESTA</span></td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">05.POR CORRESPONDERLE</span></td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">06.TRANSCRIBIR</span></td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">07.PROYECTAR DISPOSITIVO</span></td>
        <td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">08.FIRMAR Y/O REVISAR</span></td>
  		</tr>
		<tr>
			<td style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">09.ARCHIVAR</span></td>
  		<td style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;height:8px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">10.CONOCIMIENTO Y RESPUESTA</span></td>
  		<td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times"><span style="width:140px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">11.PARA COMENTARIOS</span></td>
        <td style="width:120px;text-align:left; border: solid 0px #585858;font-size:8px;font-family:Times">&nbsp;</td>
  		</tr>
		
 </table>

	
	
</page>

<?
}
//************************ END COPIA ******************************
?>

<?
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
         		
