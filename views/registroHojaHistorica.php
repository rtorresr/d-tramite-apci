<?php
session_start();
ob_start();
//*************************************

include_once("../conexion/conexion.php");
//echo $sql;
$sqlMov=" SELECT iCodOficinaDerivar,iCodTramite,cCodTipoDocDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And 	
		  iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cFlgTipoMovimiento!=5 And cFlgTipoMovimiento!=4  ";
		  $rsMov=sqlsrv_query($cnx,$sqlMov);	$numMov= sqlsrv_has_rows($rsMov);
		 
if($numMov>0){
$RsMov=sqlsrv_fetch_array($rsMov);
if($RsMov[cCodTipoDocDerivar]==16){
$sql="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And
iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cNumDocumentoDerivar='".$_GET['cCodificacion']."'   ";

$rs=sqlsrv_query($cnx,$sql);
while($Rs=sqlsrv_fetch_array($rs)){
?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	  <td style="width:87%;text-align:left;">
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
	<table border=1 style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?=$Rs['cNumDocumentoDerivar']?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					/*
					$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
					$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
					$fechaMesEntero = intval($fechaMes);  
					echo date("d", strtotime($Rs['fFecDerivar']));
					echo "-".$PrintMes[$fechaMesEntero]."-";
					echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
					*/
					
					echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
					
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
  				if($Rs['fFecDerivar']!=""){
					/*
  					$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    				$fechaMesEntero = intval($fechaMes);  
    				echo date("d", strtotime($Rs['fFecDerivar']));
    				echo "-".$PrintMes[$fechaMesEntero]."-";
  					echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
					*/
					
					echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
					
  				}
				
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Doc. Principal</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$Rs[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo trim($RsTrax[cCodificacion]);?>                     
        </b></td>
  		</tr>
        <tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsRef=sqlsrv_query($cnx,"SELECT cReferencia FROM Tra_M_Tramite_Referencias WHERE iCodTramite ='$_GET[iCodTramite]' And iCodTipo=2 ");
	$RsRef=sqlsrv_fetch_array($rsRef);
		echo " ".$RsRef[cReferencia];?>                      
        </b></td>
  		</tr>
  		
			<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$Rs[cCodTipoDocDerivar]";
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
  <td style="width: 100%; text-align:left; border: solid 1px #585858;font-family:Times">
   <?  echo $Rs[cAsuntoDerivar];
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
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Origen</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Destino</td>
  <td style="width:5%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Ind</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fecha Derivo   / <br />
    Fecha Aceptado</td>
  <td style="width:18%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">V.B.</td>
  <td style="width:19%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Observaciones</td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">1</td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaOrigen]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
   <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
		if($Rs[cFlgTipoMovimiento]==4){echo "<br/>copia";} if($Rs[cFlgTipoMovimiento]==5){echo "<br/>referencia";}
  	?>
	</td>
	
	<td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
		/*
		$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
		$fechaMesEntero = intval($fechaMes);  
		echo date("d", strtotime($Rs['fFecDerivar']));
		echo "-".$PrintMes[$fechaMesEntero]."-";
		echo date("Y", strtotime($Rs['fFecDerivar']));
		*/
		echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
		
	}
	echo "<br/>";
	if($Rs[fFecRecepcion]!=""){
		/*
		$fechaMes2=date("m", strtotime($Rs[fFecRecepcion]));
		$fechaMesEntero2 = intval($fechaMes2);  
		echo date("d", strtotime($Rs[fFecRecepcion]));
		echo "-".$PrintMes[$fechaMesEntero2]."-";
		echo date("Y", strtotime($Rs[fFecRecepcion]));
		*/
		echo date("d-m-Y G:i:s", strtotime($Rs[fFecRecepcion], 0, -6)));
		
	}
	?>
	</td>
<td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $Rs['cNumDocumentoDerivar'];?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   <td style="height:20px; text-align: justify; vertical-align:top; border: solid 1px #585858;font-size:10px;font-family:Times">
      <? 
  	$val= strlen(ltrim(rtrim($Rs[Observaciones]))); if($val>84){$con="...";}else{$con="";}
  	echo substr($Rs[Observaciones], 0, 28)."<br/>";
	echo substr($Rs[Observaciones], 28, 28)."<br/>";
	echo substr($Rs[Observaciones], 56, 28)."<br/>";
	echo substr($Rs[Observaciones], 84, 28).$con;?>
      </td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
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
	Referencias del Doc. Principal:
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

 <table style="width:400px;border: solid 0px #585858; border-collapse: collapse" align="center">
    <tr>
    
    </tr>
 </table>

	
	
</page>
<?
	}
}
else{
	$sqlMovMulti=" SELECT cCodTipoDoc,iCodTramite FROM Tra_M_Tramite WHERE iCodTramite = '$_GET[iCodTramite]'   ";
		  $rsMovMulti=sqlsrv_query($cnx,$sqlMovMulti);	$numMovMulti= sqlsrv_has_rows($rsMovMulti);
	if($numMovMulti>0){  $RsMovMulti=sqlsrv_fetch_array($rsMovMulti);
		if($RsMovMulti[cCodTipoDoc]==16){
			         
			$sqlMovC=" SELECT iCodOficinaDerivar,iCodTramite,cCodTipoDocDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And 	
		  iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cFlgTipoMovimiento!=5  ";
		  $rsMovC=sqlsrv_query($cnx,$sqlMovC);	$numMovC= sqlsrv_has_rows($rsMovC);
 if($numMovC>0){
 $sql="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And
iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cNumDocumentoDerivar='".$_GET['cCodificacion']."'    ";

$rs=sqlsrv_query($cnx,$sql);
while($Rs=sqlsrv_fetch_array($rs)){
?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	<td style="width:87%;text-align:left;">
					<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
  <td style="width:13%;text-align:right !important;"> 
      
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
	<table border=1 style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
    		<tr>
    		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
    		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
    		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?=$Rs['cNumDocumentoDerivar']?></b></td>
    		</tr>
  		
    		<tr>
    		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
    		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
    		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  				/*
  				$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
  				$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
  				$fechaMesEntero = intval($fechaMes);  
  				echo date("d", strtotime($Rs['fFecDerivar']));
  				echo "-".$PrintMes[$fechaMesEntero]."-";
  				echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
  				*/
  				echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
  				
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
    		
    		<tr>
    		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H Derivo</td>
    		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
    		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
    				<?
    				if($Rs['fFecDerivar']!=""){
  					/*
    					$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
      				$fechaMesEntero = intval($fechaMes);  
      				echo date("d", strtotime($Rs['fFecDerivar']));
      				echo "-".$PrintMes[$fechaMesEntero]."-";
    					echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
  					*/
  					
  					echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
  					
    				}
  				
    				?>
    		</b></td>
    		</tr>
  		
    		<tr>
    		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Doc. Principal</td>
    		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
    		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
      		<?
      	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$Rs[iCodTramite]' ");
      	$RsTrax=sqlsrv_fetch_array($rsTrax);
      		echo trim($RsTrax[cCodificacion]);?>                     
              </b></td>
    		</tr>
        <tr>
    		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
    		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
    		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
      		<?
      	$rsRef=sqlsrv_query($cnx,"SELECT cReferencia FROM Tra_M_Tramite_Referencias WHERE iCodTramite ='$_GET[iCodTramite]' And iCodTipo=2 ");
      	$RsRef=sqlsrv_fetch_array($rsRef);
      		echo " ".$RsRef[cReferencia];?>                      
              </b></td>
  		  </tr>
  		
  			<tr>
    		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
    		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
    		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
  				<?
  					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$Rs[cCodTipoDocDerivar]";
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
  <td style="width: 100%; text-align:left; border: solid 1px #585858;font-family:Times">
   <?  echo $Rs[cAsuntoDerivar];
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
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Origen</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Destino</td>
  <td style="width:5%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Ind</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fecha Derivo   / <br />
    Fecha Aceptado</td>
  <td style="width:18%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">V.B.</td>
  <td style="width:19%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Observaciones</td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">1</td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaOrigen]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
   <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
		if($Rs[cFlgTipoMovimiento]==4){echo "<br/>copia";} if($Rs[cFlgTipoMovimiento]==5){echo "<br/>referencia";}
  	?>
	</td>
	
	<td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
		/*
		$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
		$fechaMesEntero = intval($fechaMes);  
		echo date("d", strtotime($Rs['fFecDerivar']));
		echo "-".$PrintMes[$fechaMesEntero]."-";
		echo date("Y", strtotime($Rs['fFecDerivar']));
		*/
		echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
		
	}
	echo "<br/>";
	if($Rs[fFecRecepcion]!=""){
		/*
		$fechaMes2=date("m", strtotime($Rs[fFecRecepcion]));
		$fechaMesEntero2 = intval($fechaMes2);  
		echo date("d", strtotime($Rs[fFecRecepcion]));
		echo "-".$PrintMes[$fechaMesEntero2]."-";
		echo date("Y", strtotime($Rs[fFecRecepcion]));
		*/
		echo date("d-m-Y G:i:s", strtotime($Rs[fFecRecepcion], 0, -6)));
		
	}
	?>
	</td>
<td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $Rs['cNumDocumentoDerivar'];?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   <td style="height:20px; text-align: justify; vertical-align:top; border: solid 1px #585858;font-size:10px;font-family:Times">
      <? 
  	$val= strlen(ltrim(rtrim($Rs[Observaciones]))); if($val>84){$con="...";}else{$con="";}
  	echo substr($Rs[Observaciones], 0, 28)."<br/>";
	echo substr($Rs[Observaciones], 28, 28)."<br/>";
	echo substr($Rs[Observaciones], 56, 28)."<br/>";
	echo substr($Rs[Observaciones], 84, 28).$con;?>
      </td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
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
	Referencias del Doc. Principal:
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

 <table style="width:400px;border: solid 0px #585858; border-collapse: collapse" align="center">
    <tr>
    </tr>
 </table>

	
	
</page>
<?
	}
 }
			
			}
		
		else{
		
	$sqlMovMulti=" SELECT cCodTipoDoc,iCodTramite FROM Tra_M_Tramite WHERE iCodTramite = '$_GET[iCodTramite]'   ";
		  $rsMovMulti=sqlsrv_query($cnx,$sqlMovMulti);	$numMovMulti= sqlsrv_has_rows($rsMovMulti);
	if($numMovMulti>0){  $RsMovMulti=sqlsrv_fetch_array($rsMovMulti);
		if($RsMovMulti[cCodTipoDoc]==16){
			         
			$sqlMovC=" SELECT iCodOficinaDerivar,iCodTramite,cCodTipoDocDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And 	
		  iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cFlgTipoMovimiento!=5  ";
		  $rsMovC=sqlsrv_query($cnx,$sqlMovC);	$numMovC= sqlsrv_has_rows($rsMovC);
 if($numMovC>0){
 $sql="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And
iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cNumDocumentoDerivar='".$_GET['cCodificacion']."'    ";

$rs=sqlsrv_query($cnx,$sql);
while($Rs=sqlsrv_fetch_array($rs)){
?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	<td style="width:887%;text-align:left;">
					<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
  <td style="width:13%;text-align:right !important;">
      
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
	<table border=1 style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?=$Rs['cNumDocumentoDerivar']?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
				/*
				$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
				$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
				$fechaMesEntero = intval($fechaMes);  
				echo date("d", strtotime($Rs['fFecDerivar']));
				echo "-".$PrintMes[$fechaMesEntero]."-";
				echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
				*/
				
				echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
				
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
  				if($Rs['fFecDerivar']!=""){
					/*
  					$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    				$fechaMesEntero = intval($fechaMes);  
    				echo date("d", strtotime($Rs['fFecDerivar']));
    				echo "-".$PrintMes[$fechaMesEntero]."-";
  					echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
					*/
					echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
					
  				}
				
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Doc. Principal</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$Rs[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo trim($RsTrax[cCodificacion]);?>                     
        </b></td>
  		</tr>
        <tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsRef=sqlsrv_query($cnx,"SELECT cReferencia FROM Tra_M_Tramite_Referencias WHERE iCodTramite ='$_GET[iCodTramite]' And iCodTipo=2 ");
	$RsRef=sqlsrv_fetch_array($rsRef);
		echo " ".$RsRef[cReferencia];?>                      
        </b></td>
  		</tr>
  		
			<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$Rs[cCodTipoDocDerivar]";
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
  <td style="width: 100%; text-align:left; border: solid 1px #585858;font-family:Times">
   <?  echo $Rs[cAsuntoDerivar];
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
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Origen</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Destino</td>
  <td style="width:5%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Ind</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fecha Derivo   / <br />
    Fecha Aceptado</td>
  <td style="width:18%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">V.B.</td>
  <td style="width:19%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Observaciones</td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">1</td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaOrigen]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
   <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
		if($Rs[cFlgTipoMovimiento]==4){echo "<br/>copia";} if($Rs[cFlgTipoMovimiento]==5){echo "<br/>referencia";}
  	?>
	</td>
	
	<td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
		if($Rs['fFecDerivar']!=""){
			/*
			$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
			$fechaMesEntero = intval($fechaMes);  
			echo date("d", strtotime($Rs['fFecDerivar']));
			echo "-".$PrintMes[$fechaMesEntero]."-";
			echo date("Y", strtotime($Rs['fFecDerivar']));
			*/
		echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
	}
	echo "<br/>";
	if($Rs[fFecRecepcion]!=""){
		/*
			$fechaMes2=date("m", strtotime($Rs[fFecRecepcion]));
			$fechaMesEntero2 = intval($fechaMes2);  
			echo date("d", strtotime($Rs[fFecRecepcion]));
			echo "-".$PrintMes[$fechaMesEntero2]."-";
			echo date("Y", strtotime($Rs[fFecRecepcion]));
		*/
		echo date("d-m-Y G:i:s", strtotime($Rs[fFecRecepcion], 0, -6)));
	}
	?>
	</td>
<td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $Rs['cNumDocumentoDerivar'];?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   <td style="height:20px; text-align: justify; vertical-align:top; border: solid 1px #585858;font-size:10px;font-family:Times">
      <? 
  	$val= strlen(ltrim(rtrim($Rs[Observaciones]))); if($val>84){$con="...";}else{$con="";}
  	echo substr($Rs[Observaciones], 0, 28)."<br/>";
	echo substr($Rs[Observaciones], 28, 28)."<br/>";
	echo substr($Rs[Observaciones], 56, 28)."<br/>";
	echo substr($Rs[Observaciones], 84, 28).$con;?>
      </td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
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
	Referencias del Doc. Principal:
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
			
			}
	}



	
$sqlHistC=" SP_CONSULTA_HISTORICO_COUNT '$RsMov[iCodTramite]' ";	$rsHistC=sqlsrv_query($cnx,$sqlHistC);	$numHistC= sqlsrv_has_rows($rsHistC);

$total_paginas = ceil($numHistC/8);
for($hoja=1;$hoja<=$total_paginas;$hoja++){

if($hoja==1){$contador =1;}else {$contador =(8*($hoja-1)+1);};	$sqlHist=" SP_CONSULTA_HISTORICO '$hoja','8','$RsMov[iCodTramite]' ";	$rsHist=sqlsrv_query($cnx,$sqlHist);	$numHist= sqlsrv_has_rows($rsHist);

$sqlPrim=" SELECT * FROM Tra_M_Tramite WHERE iCodTramite = '$_GET[iCodTramite]' And iCodOficinaRegistro='".$_SESSION['iCodOficinaLogin']."' ";
$rsPrim=sqlsrv_query($cnx,$sqlPrim);
$RsPrim=sqlsrv_fetch_array($rsPrim);
$sql="SELECT *,Tra_M_Tramite.cObservaciones AS Observaciones FROM Tra_M_Tramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
$sql.=" LEFT OUTER JOIN Tra_M_Remitente ON Tra_M_Tramite.iCodRemitente=Tra_M_Remitente.iCodRemitente ";
$sql.=" WHERE Tra_M_Tramite_Movimientos.iCodTramite='$RsMov[iCodTramite]' And iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."'
        and ( cNumDocumentoDerivar = '$RsPrim[cCodificacion]' or cReferenciaDerivar = '$RsPrim[cCodificacion]' )";
$rs=sqlsrv_query($cnx,$sql);
$Rs=sqlsrv_fetch_array($rs);
?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	<td style="width:87%;text-align:left;">
					<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
  <td style="width:13%;text-align:right !important;">
      
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
	<table border=1 style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:70%;border: solid 0px #585858; border-collapse: collapse">
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
				/*
				$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
				$fechaMes=date("m", strtotime($RsPrim['fFecRegistro']));
				$fechaMesEntero = intval($fechaMes);  
				echo date("d", strtotime($RsPrim['fFecRegistro']));
				echo "-".$PrintMes[$fechaMesEntero]."-";
				echo date("Y h:i:s", strtotime($RsPrim['fFecRegistro']));
				*/
				
				echo date("d-m-Y G:i:s", strtotime(substr($RsPrim['fFecRegistro'], 0, -6)));
				
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
						/*
						$fechaMes=date("m", strtotime($RsM1['fFecDerivar']));
						$fechaMesEntero = intval($fechaMes);  
						echo date("d", strtotime($RsM1['fFecDerivar']));
						echo "-".$PrintMes[$fechaMesEntero]."-";
						echo date("Y h:i:s", strtotime($RsM1['fFecDerivar']));
						*/
						echo date("d-m-Y G:i:s", strtotime(substr($RsM1['fFecDerivar'], 0, -6)));
						
  				}
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Doc. Principal</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTraDe=sqlsrv_query($cnx,"SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar ='$_GET[iCodTramite]' and cFlgTipoMovimiento != 5 ");
	$RsTraDe=sqlsrv_fetch_array($rsTraDe);
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$RsTraDe[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo trim($RsTrax[cCodificacion]);?>
                                
        </b></td>
  		</tr>
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsRef=sqlsrv_query($cnx,"SELECT cReferencia FROM Tra_M_Tramite_Referencias WHERE iCodTramite ='$_GET[iCodTramite]' And iCodTipo=2 ");
	$RsRef=sqlsrv_fetch_array($rsRef);
		echo " ".$RsRef[cReferencia];?>
                            
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

	<table border="1" style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
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
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Origen</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Destino</td>
  <td style="width:5%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Ind</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fecha Derivo   / <br />
    Fecha Aceptado</td>
  <td style="width:18%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">V.B.</td>
  <td style="width:19%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Observaciones</td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">C.Recep</td>
   </tr>
	<? 
	while ($RsHist=sqlsrv_fetch_array($rsHist)){
	
	?>
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  <? 
  echo $contador;
  ?>
  </td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsHist[iCodOficinaOrigen]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsHist[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];echo "<br>";
		if($RsHist[cFlgTipoMovimiento]==4){echo "copia";} if($RsHist[cFlgTipoMovimiento]==5){echo "referencia";}
  	?>
	</td>
	
	<td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsHist[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
		if($RsHist['fFecDerivar']!=""){
		/*
		$fechaMes=date("m", strtotime($RsHist['fFecDerivar']));
		$fechaMesEntero = intval($fechaMes);  
		echo date("d", strtotime($RsHist['fFecDerivar']));
		echo "-".$PrintMes[$fechaMesEntero]."-";
		echo date("Y", strtotime($RsHist['fFecDerivar']));
		*/
		
		echo date("d-m-Y G:i:s", strtotime(substr($RsHist['fFecDerivar'], 0, -6)));
	}
	echo "<br/>";
	if($RsHist[fFecRecepcion]!=""){
	/*
		$fechaMes2=date("m", strtotime($RsHist[fFecRecepcion]));
		$fechaMesEntero2 = intval($fechaMes2);  
		echo date("d", strtotime($RsHist[fFecRecepcion]));
		echo "-".$PrintMes[$fechaMesEntero2]."-";
		echo date("Y", strtotime($RsHist[fFecRecepcion]));
		*/
		echo date("d-m-Y G:i:s", strtotime(substr($RsHist[fFecRecepcion], 0, -6)));
	}
	?>
	</td>
<td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<? 
	if($RsHist[cFlgOficina]==1){ $doc=  $RsHist[cCodTipoDoc];} 
	if($RsHist[cFlgTipoMovimiento]==5){ $doc= $RsHist[cCodTipoDocDerivar];}
	if($RsHist[cFlgOficina]!=1 && $RsHist[cFlgTipoMovimiento]!=5 ){ $doc= $RsHist[cCodTipoDocDerivar];}
	
	$docTipo= "SP_TIPO_DOCUMENTO_LISTA_AR '$doc'";
	$rsTipo=sqlsrv_query($cnx,$docTipo);
    $RsTipo=sqlsrv_fetch_array($rsTipo);
	echo $RsTipo['cDescTipoDoc'];echo "<br>";
	
	if(($RsHist[cFlgOficina]==1 or $RsHist[nFlgTipoDoc]==1) && $RsHist['iCodTramiteDerivar']==NULL ){echo $RsHist[cCodificacion];}
	if($RsHist[cFlgTipoMovimiento]==5){echo $RsHist[cReferenciaDerivar];}
	if($RsHist[cFlgOficina]!=1 && $RsHist[cFlgTipoMovimiento]!=5 ){echo $RsHist['cNumDocumentoDerivar'];}
	?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?php echo $RsHist[nNumFolio]; ?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: justify; vertical-align:top; border: solid 1px #585858;font-size:10px;font-family:Times">
      <? 
  	$val= strlen(ltrim(rtrim($RsHist[cObservacionesDerivar]))); if($val>84){$con="...";}else{$con="";}
  	echo substr($RsHist[cObservacionesDerivar], 0, 28)."<br/>";
	echo substr($RsHist[cObservacionesDerivar], 28, 28)."<br/>";
	echo substr($RsHist[cObservacionesDerivar], 56, 28)."<br/>";
	echo substr($RsHist[cObservacionesDerivar], 84, 28).$con;?>
      </td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  <? 
  $contador =  	$contador +1;
  $cont[]	=	$contador; 
  }    
  for($x= end($cont);$x<=(8*$hoja);$x++){
  ?>  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times"><?php echo $x;?></td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>
    <?php }?>
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
  <td style="width:100%; text-align:left; border: solid 0px #585858;font-family:Times"><?=$RsPrim[Observaciones]?></td>
  </tr>
	</table>
<br>
	<br>
	<br>	
	<table style="width:100%;border: solid 0px #585858; border-collapse: collapse" align="left">
	<tr>
	<td style="width:100%;height:30px;text-align:left;vertical-align:bottom; border: solid 0px #585858;font-family:Times">
	Referencias del Doc. Principal:
	</td>
	</tr>
	<tr>
	<td>
	<? $sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE iCodTipo!=2 And iCodTramite='$RsTraDe[iCodTramite]' ";
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
	<br />
	<table border="0" align="center" width="100%">
    <tr>
    <td>
    <?php if($total_paginas>1){
	echo $hoja." de  ".$total_paginas;
    }
	?>
    </td>
    </tr>
    </table>
	
</page>
<?
   }		
  // Copia del historico 		
	$sqlMovC=" SELECT iCodOficinaDerivar,iCodTramite,cCodTipoDocDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And 	
		  iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cFlgTipoMovimiento!=5 And cFlgTipoMovimiento=4  ";
		  $rsMovC=sqlsrv_query($cnx,$sqlMovC);	$numMovC= sqlsrv_has_rows($rsMovC);
 if($numMovC>0){
 $sql="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And
iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cNumDocumentoDerivar='".$_GET['cCodificacion']."'  And cFlgTipoMovimiento=4  ";

$rs=sqlsrv_query($cnx,$sql);
while($Rs=sqlsrv_fetch_array($rs)){
?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	<td style="width:87%;text-align:left;">
					<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
  <td style="width:13%;text-align:right !important;">
      
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
	<table border=1 style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?=$Rs['cNumDocumentoDerivar']?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
				/*
				$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
				$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
				$fechaMesEntero = intval($fechaMes);  
				echo date("d", strtotime($Rs['fFecDerivar']));
				echo "-".$PrintMes[$fechaMesEntero]."-";
				echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
				*/
				echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
				
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
  				if($Rs['fFecDerivar']!=""){
					/*
  					$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    				$fechaMesEntero = intval($fechaMes);  
    				echo date("d", strtotime($Rs['fFecDerivar']));
    				echo "-".$PrintMes[$fechaMesEntero]."-";
  					echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
					*/
					echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
					
  				}
				
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Doc. Principal</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$Rs[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo trim($RsTrax[cCodificacion]);?>                     
        </b></td>
  		</tr>
        <tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsRef=sqlsrv_query($cnx,"SELECT cReferencia FROM Tra_M_Tramite_Referencias WHERE iCodTramite ='$_GET[iCodTramite]' And iCodTipo=2 ");
	$RsRef=sqlsrv_fetch_array($rsRef);
		echo " ".$RsRef[cReferencia];?>                      
        </b></td>
  		</tr>
  		
			<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$Rs[cCodTipoDocDerivar]";
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
  <td style="width: 100%; text-align:left; border: solid 1px #585858;font-family:Times">
   <?  echo $Rs[cAsuntoDerivar];
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
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Origen</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Destino</td>
  <td style="width:5%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Ind</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fecha Derivo   / <br />
    Fecha Aceptado</td>
  <td style="width:18%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">V.B.</td>
  <td style="width:19%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Observaciones</td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">1</td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaOrigen]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
   <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
		if($Rs[cFlgTipoMovimiento]==4){echo "<br/>copia";} if($Rs[cFlgTipoMovimiento]==5){echo "<br/>referencia";}
  	?>
	</td>
	
	<td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
		/*
		$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
		$fechaMesEntero = intval($fechaMes);  
		echo date("d", strtotime($Rs['fFecDerivar']));
		echo "-".$PrintMes[$fechaMesEntero]."-";
		echo date("Y", strtotime($Rs['fFecDerivar']));
		*/
		echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
		
	}
	echo "<br/>";
	if($Rs[fFecRecepcion]!=""){
		/*
		$fechaMes2=date("m", strtotime($Rs[fFecRecepcion]));
		$fechaMesEntero2 = intval($fechaMes2);  
		echo date("d", strtotime($Rs[fFecRecepcion]));
		echo "-".$PrintMes[$fechaMesEntero2]."-";
		echo date("Y", strtotime($Rs[fFecRecepcion]));
		*/
		echo date("d-m-Y G:i:s", strtotime($Rs[fFecRecepcion], 0, -6)));
		
	}
	?>
	</td>
<td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $Rs['cNumDocumentoDerivar'];?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   <td style="height:20px; text-align: justify; vertical-align:top; border: solid 1px #585858;font-size:10px;font-family:Times">
      <? 
  	$val= strlen(ltrim(rtrim($Rs[Observaciones]))); if($val>84){$con="...";}else{$con="";}
  	echo substr($Rs[Observaciones], 0, 28)."<br/>";
	echo substr($Rs[Observaciones], 28, 28)."<br/>";
	echo substr($Rs[Observaciones], 56, 28)."<br/>";
	echo substr($Rs[Observaciones], 84, 28).$con;?>
      </td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
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
	Referencias del Doc. Principal:
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
		
// Fin del historio Copia	
  
  
  
  	
		}	
	}
	
	
	}
 }

/*$sqlMovC=" SELECT iCodOficinaDerivar,iCodTramite,cCodTipoDocDerivar FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And 	
		  iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cFlgTipoMovimiento!=5 And cFlgTipoMovimiento=4  ";
		  $rsMovC=sqlsrv_query($cnx,$sqlMovC);	$numMovC= sqlsrv_has_rows($rsMovC);
 if($numMovC>0){
 $sql="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar = '$_GET[iCodTramite]' And
iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' And cNumDocumentoDerivar='".$_GET['cCodificacion']."'  And cFlgTipoMovimiento=4  ";

$rs=sqlsrv_query($cnx,$sql);
while($Rs=sqlsrv_fetch_array($rs)){
?>
<page backtop="15mm" backbottom="10mm" backleft="10mm" backright="10mm">
	<table style="width:100%;border:solid 0px black;">
	<tr>
	<td style="text-align:left;	width: 100%">
					<img style="width:300px" src="images/pdf_apci.jpg" alt="Logo">
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
	<table border=1 style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
	<tr>
  <td style="width: 100%; text-align: center; border: solid 1px #585858;">
  		<table style="width:90%;border: solid 0px #585858; border-collapse: collapse">
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b><?=$Rs['cNumDocumentoDerivar']?></b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Fecha/H de Registro</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
  			$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
  			$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    		$fechaMesEntero = intval($fechaMes);  
    		echo date("d", strtotime($Rs['fFecDerivar']));
    		echo "-".$PrintMes[$fechaMesEntero]."-";
  			echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
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
  				if($Rs['fFecDerivar']!=""){
  					$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    				$fechaMesEntero = intval($fechaMes);  
    				echo date("d", strtotime($Rs['fFecDerivar']));
    				echo "-".$PrintMes[$fechaMesEntero]."-";
  					echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
  				}
				
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Doc. Principal</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$Rs[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo trim($RsTrax[cCodificacion]);?>                     
        </b></td>
  		</tr>
        <tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsRef=sqlsrv_query($cnx,"SELECT cReferencia FROM Tra_M_Tramite_Referencias WHERE iCodTramite ='$_GET[iCodTramite]' And iCodTipo=2 ");
	$RsRef=sqlsrv_fetch_array($rsRef);
		echo " ".$RsRef[cReferencia];?>                      
        </b></td>
  		</tr>
  		
			<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Tipo Documento</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times"><b>
				<?
					$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc=$Rs[cCodTipoDocDerivar]";
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
  <td style="width: 100%; text-align:left; border: solid 1px #585858;font-family:Times">
   <?  echo $Rs[cAsuntoDerivar];
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
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Origen</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Destino</td>
  <td style="width:5%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Ind</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fecha Derivo   / <br />
    Fecha Aceptado</td>
  <td style="width:18%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">V.B.</td>
  <td style="width:19%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Observaciones</td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">1</td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaOrigen]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
   <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
		if($Rs[cFlgTipoMovimiento]==4){echo "<br/>copia";} if($Rs[cFlgTipoMovimiento]==5){echo "<br/>referencia";}
  	?>
	</td>
	
	<td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
  	$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    $fechaMesEntero = intval($fechaMes);  
    echo date("d", strtotime($Rs['fFecDerivar']));
    echo "-".$PrintMes[$fechaMesEntero]."-";
  	echo date("Y", strtotime($Rs['fFecDerivar']));
	}
	echo "<br/>";
	if($Rs[fFecRecepcion]!=""){
  	$fechaMes2=date("m", strtotime($Rs[fFecRecepcion]));
    $fechaMesEntero2 = intval($fechaMes2);  
    echo date("d", strtotime($Rs[fFecRecepcion]));
    echo "-".$PrintMes[$fechaMesEntero2]."-";
  	echo date("Y", strtotime($Rs[fFecRecepcion]));
	}
	?>
	</td>
<td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $Rs['cNumDocumentoDerivar'];?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   <td style="height:20px; text-align: justify; vertical-align:top; border: solid 1px #585858;font-size:10px;font-family:Times">
      <? 
  	$val= strlen(ltrim(rtrim($Rs[Observaciones]))); if($val>84){$con="...";}else{$con="";}
  	echo substr($Rs[Observaciones], 0, 28)."<br/>";
	echo substr($Rs[Observaciones], 28, 28)."<br/>";
	echo substr($Rs[Observaciones], 56, 28)."<br/>";
	echo substr($Rs[Observaciones], 84, 28).$con;?>
      </td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
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
	Referencias del Doc. Principal:
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
 }*/
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
	<td style="width:87%;text-align:left;">
		<img style="width:300px" src="images/pdf_pcm.jpg" alt="Logo">
	</td>
  <td style="width:13%;text-align:right !important;">
      
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
	<table border=1 style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
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
				/*
				$PrintMes=array("","ENE","FEB","MAR","ABR","MAY","JUN","JUL","AGO","SET","OCT","NOV","DIC");
				$fechaMes=date("m", strtotime($Rs['fFecRegistro']));
				$fechaMesEntero = intval($fechaMes);  
				echo date("d", strtotime($Rs['fFecRegistro']));
				echo "-".$PrintMes[$fechaMesEntero]."-";
				echo date("Y h:i:s", strtotime($Rs['fFecRegistro']));
				*/
				
				echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecRegistro'], 0, -6)));
				
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
  				if($Rs['fFecDerivar']!=""){
					/*
  					$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
    				$fechaMesEntero = intval($fechaMes);  
    				echo date("d", strtotime($Rs['fFecDerivar']));
    				echo "-".$PrintMes[$fechaMesEntero]."-";
  					echo date("Y h:i:s", strtotime($Rs['fFecDerivar']));
					*/
					echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
					
  				}
				
  				?>
  		</b></td>
  		</tr>
  		
  		<tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro Doc. Principal</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsTraDe=sqlsrv_query($cnx,"SELECT iCodTramite FROM Tra_M_Tramite_Movimientos WHERE iCodTramiteDerivar ='$_GET[iCodTramite]' and cFlgTipoMovimiento!=5 And cFlgTipoMovimiento=4 ");
	$RsTraDe=sqlsrv_fetch_array($rsTraDe);
	$rsTrax=sqlsrv_query($cnx,"SELECT nFlgTipoDoc,cCodificacion FROM Tra_M_Tramite WHERE iCodTramite ='$RsTraDe[iCodTramite]' ");
	$RsTrax=sqlsrv_fetch_array($rsTrax);
		echo trim($RsTrax[cCodificacion]);?>                     
        </b></td>
  		</tr>
        <tr>
  		<td style="width:23%;height:10px;text-align:left; border: solid 0px #585858;font-size:14px;font-family:Times">Nro de Referencia</td>
  		<td style="width:2%;text-align:left; border: solid 0px #585858;font-size:14px">:</td>
  		<td style="width:65%;text-align:left; border: solid 0px #585858;font-size:14px;text-transform:uppercase;font-family:Times"><b>
		<?
	$rsRef=sqlsrv_query($cnx,"SELECT cReferencia FROM Tra_M_Tramite_Referencias WHERE iCodTramite ='$_GET[iCodTramite]' And iCodTipo=2 ");
	$RsRef=sqlsrv_fetch_array($rsRef);
		echo " ".$RsRef[cReferencia];?>                      
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

	<table border="1" style="width:100%;border: solid 1px #585858; border-collapse: collapse" align="left">
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
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Origen</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Destino</td>
  <td style="width:5%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Ind</td>
  <td style="width:14%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fecha Derivo   / <br />
    Fecha Aceptado</td>
  <td style="width:18%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">N&uacute;mero de Documento</td>
  <td style="width:7%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Fls</td>
  <td style="width:8%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">V.B.</td>
  <td style="width:19%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">Observaciones.</td>
  <td style="width:12%; text-align: left; border: solid 1px #585858;font-size:12px;font-family:Times">C.Recep</td>
   </tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">1</td>
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaOrigen]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
  	?>
	</td>
   <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
  	$sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
		$rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
		$RsOfiD=sqlsrv_fetch_array($rsOfiD);
		echo $RsOfiD[cSiglaOficina];
		if($Rs[cFlgTipoMovimiento]==4){echo "<br/>copia";} if($Rs[cFlgTipoMovimiento]==5){echo "<br/>referencia";}
  	?>
	</td>
	
	<td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
		<?
		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$Rs[iCodIndicacionDerivar]'";
    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
    $RsIndic=sqlsrv_fetch_array($rsIndic);
				echo substr($RsIndic["cIndicacion"],0,2);
    sqlsrv_free_stmt($rsIndic);
		?>
	</td>
	
  <td style="height:20px; text-align: left; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?
	if($Rs['fFecDerivar']!=""){
		/*
		$fechaMes=date("m", strtotime($Rs['fFecDerivar']));
		$fechaMesEntero = intval($fechaMes);  
		echo date("d", strtotime($Rs['fFecDerivar']));
		echo "-".$PrintMes[$fechaMesEntero]."-";
		echo date("Y", strtotime($Rs['fFecDerivar']));
		*/
		echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecDerivar'], 0, -6)));
		
	}
	echo "<br/>";
	if($Rs[fFecRecepcion]!=""){
		/*
		$fechaMes2=date("m", strtotime($Rs[fFecRecepcion]));
		$fechaMesEntero2 = intval($fechaMes2);  
		echo date("d", strtotime($Rs[fFecRecepcion]));
		echo "-".$PrintMes[$fechaMesEntero2]."-";
		echo date("Y", strtotime($Rs[fFecRecepcion]));
		*/
		echo date("d-m-Y G:i:s", strtotime($Rs[fFecRecepcion], 0, -6)));
		
	}
	?>
	</td>
<td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<? 
	echo $RsTipDoc['cDescTipoDoc'];echo "<br>";
	echo $Rs[cCodificacion];?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">
  	<?php echo $Rs[nNumFolio]; ?>
	</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   <td style="height:20px; text-align: justify; vertical-align:top; border: solid 1px #585858;font-size:10px;font-family:Times">
      <? 
  	$val= strlen(ltrim(rtrim($Rs[Observaciones]))); if($val>84){$con="...";}else{$con="";}
  	echo substr($Rs[Observaciones], 0, 28)."<br/>";
	echo substr($Rs[Observaciones], 28, 28)."<br/>";
	echo substr($Rs[Observaciones], 56, 28)."<br/>";
	echo substr($Rs[Observaciones], 84, 28).$con;?>
      </td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
   </tr>
  
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">2</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  	</tr>

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">3</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>  

  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">4</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr>
	
  <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">5</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">6</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">7</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
 	</tr> 	
     <tr>
  <td style="height:40px; text-align: center; border: solid 1px #585858;font-size:10px;font-family:Times">8</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
  <td style="height:20px; text-align: center; border: solid 1px #585858;">&nbsp;</td>
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
	Referencias del Doc. Principal:
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

?>

<?php
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
         		
