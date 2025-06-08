<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaEntradaGeneral.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta de los Documentos de Entrada
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   APCI       03/08/2018   Creación del programa.
 
------------------------------------------------------------------------


*****************************************************************************************/
?>
<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">

function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}

//--></script>
</head>
<body>
 
	<?php include("includes/menu.php");?>



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

<div class="AreaTitulo">Consulta de Documentos de Anexo</div>

	<legend>Criterios de B�squeda:</legend>

							<form name="frmConsultaEntrada" method="GET" action="consultaAnexos.php">
						<tr>
							<td width="110" >N&ordm; Documento:</td>
							<td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" maxlength="15" size="28" class="FormPropertReg form-control" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;"></td>
							<td align="left">

									<td ><button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							&nbsp;
							<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
             </td>
									</tr></table>
							</td>
						</tr>

							</form>

</form>



<?
 if($_GET['fDesde']!='' && $_GET['fHasta']!=''){
	$fDesde=date("Ymd", strtotime($_GET['fDesde']));
	$fHasta=date("Y-m-d", strtotime($_GET['fHasta']));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
	}
	
	/*
	$fHasta=date("Y-m-d H:i", strtotime($_GET['fHasta']));
	
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd H:i", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
	}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
	*/
	
	if($_GET['cCodificacion']!=""){ //obtener el codigo del documento
    $sqlCod.="SP_CONSULTA_ANEXO_AR '".$_GET['cCodificacion']."'";
	$rsCod=sqlsrv_query($cnx,$sqlCod);
	$numrows=sqlsrv_has_rows($rsCod);
    if($numrows==0){ 
		echo "No Se Encuentra ese Documento<br>";
    }
	else {
	$RsCod=sqlsrv_fetch_array($rsCod);
	 
    
	// consulta los anexos relacionados 
	/* $sql=" SELECT   Tra_M_Tramite.iCodTramite,cDescTipoDoc,cCodificacion,fFecRegistro,cAsunto,cObservaciones,cNomOFicina ";
	 $sql.=" FROM  Tra_M_Tramite INNER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ";
	 $sql.=" INNER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite INNER JOIN ";
	 $sql.=" Tra_M_Oficinas  ON Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Movimientos.iCodOficinaDerivar ";
	 $sql.=" WHERE   Tra_M_Tramite.nFlgTipoDoc=4 ";
     $sql.=" AND Tra_M_Tramite.iCodTramiteRel='$RsCod[iCodTramite]' ";
     $sql.=" ORDER BY Tra_M_Tramite.iCodTramite DESC";	*/
	 
	 $sql.="SP_CONSULTA_ANEXO '$RsCod[iCodTramite]'";   
     $rs=sqlsrv_query($cnx,$sql);
	    //echo $sql;
 ?>
     <br>
     <table width="1000" border="0" align="center">
		<tr>
		<td>
				<fieldset id="tfa_GeneralDoc" class="fieldset">
				<legend class="legend"><strong>Documento N&ordm;: <?=$RsCod[cCodificacion]?></strong> </legend>
	     <br>
       <table width="950" border="0" align="center">
		<tr>
		<td>
			<fieldset id="tfa_GeneralDoc" class="fieldset">
			<legend class="legend">Datos Generales </legend>
		    
		  <table border="0" width="860">
		    <tr>
		        <td width="130" >Fecha del Documento:&nbsp;</td>
		        <td width="320" align="left">
		        	<span><?=date("d-m-Y", strtotime($RsCod['fFecDocumento']))?></span>
        			<span style=font-size:10px><?=date("G:i", strtotime($Rs['fFecDocumento']))?></span>
		        </td>
		        <td width="130" >Fecha de Registro:&nbsp;</td>
		        <td align="left">
		        	<span><?=date("d-m-Y", strtotime($RsCod['fFecRegistro']))?></span>
        			<span style=font-size:10px><?=date("G:i", strtotime($Rs['fFecRegistro']))?></span>
		        </td>
		    </tr> 
		    <tr>
		        <td width="130" >N&ordm; Documento:&nbsp;</td>
		        <td align="left"><?=$RsCod['cNroDocumento']?></td>
		        <td width="130" >Referencia:&nbsp;</td>
		        <td align="left"><?=$RsCod[cReferencia]?></td>
		    </tr>
		    <tr>
		        <td width="130" >Tipo de Documento:&nbsp;</td>
		        <td align="left">
		        		<? 
			          $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsCod[cCodTipoDoc]'";
			          $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			          $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
			          echo $RsTipDoc['cDescTipoDoc'];
		            ?>
		        </td>
		        <td width="130" >Folios:&nbsp;</td>
		        <td align="left"><?=$RsCod[nNumFolio];?></td>
		    </tr>
	        <tr>
		        <td width="130" >Asunto:&nbsp;</td>
		        <td align="left" width="200"><?=$RsCod['cAsunto']?></td>
		        <td width="130" >Observaciones:&nbsp;</td>
		        <td align="left"><?=$RsCod[cObservaciones]?></td>
		    </tr>
		    <tr>
		        <td width="130" >Tiempo respuesta:&nbsp;</td>
		        <td align="left"><?=$RsCod[nTiempoRespuesta]?></td>
		        <td width="130" >&nbsp;</td>

		    </tr>
		   </table>
	        </fieldset>
		       </td>
		   </tr>
		   <tr>
		       <td>   
	        <fieldset id="tfa_GeneralEmp" class="fieldset">
		     <legend class="legend">Datos de la Empresa </legend>
		   <table border="0">
		    <tr>
		          <td width="130" >Razon Social:</td>
		          <td width="315" align="left">
		          	<? 
			            $sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$RsCod[iCodRemitente]'";
			            $rsRemi=sqlsrv_query($cnx,$sqlRemi);
			            $RsRemi=sqlsrv_fetch_array($rsRemi);
			            echo $RsRemi['cNombre'];
		              ?>
		          </td>
		          <td width="130" >Ruc:</td>
		          <td width="265" align="left"><?=$RsRemi['nNumDocumento']?></td>
		    </tr> 
		    <tr>
		          <td width="130" >Direccion:</td>
		          <td align="left"><?=$RsRemi[cDireccion]?></td>
		          <td width="130" >Representante:</td>
		          <td align="left"><?=$RsRemi[cRepresentante]?></td>
		    </tr>   
		    <tr>
		          <td width="130" >E-mail:</td>
		          <td align="left"><?=$RsRemi[cEmail]?></td>
		          <td width="130" >Provincia:</td>
		          <td align="left"><?=$RsRemi[cProvincia]?></td>
		    </tr>
		    <tr>
		          <td width="130" >Telefono:</td>
		          <td width="315" align="left"><?=$RsRemi[nTelefono]?></td>
		          <td width="130" >Fax:</td>
		          <td align="left"><?=$RsRemi[nFax]?></td>
		          
		    </tr>
		    </table>  
		    </fieldset>
		</td>
		</tr>
     </table>
      <fieldset id="tfa_GeneralEmp" class="fieldset">
		<legend class="legend">Listado de Anexos </legend>
    <table  border="0" cellpadding="3" cellspacing="3" align="center">
    <tr>
	  <td width="115" class="headCellColum">Tipo Documento</td>
	  <td width="107" class="headCellColum">Nro Documento</td>
	  <td width="100" class="headCellColum">Fecha registro</td> 
	  <td width="185" class="headCellColum">Contenido</td>
	  <td width="138" class="headCellColum">Observaciones</td>
    <td width="173" class="headCellColum">Destino (OFICINA)</td>
    <td width="66" class="headCellColum">Opciones</td>
		</tr>
		<?
    while ($Rs=sqlsrv_fetch_array($rs)){
    		if ($color == "#DDEDFF"){
			  	$color = "#F9F9F9";
				}else{
			  			$color = "#DDEDFF";
	    	}
	    	if ($color == ""){
			  			$color = "#F9F9F9";
	    	}	
		?>
   	<tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
    <td valign="top" align="center"><?=$Rs['cDescTipoDoc']?></td>
    <td valign="top" align="center"><?=$Rs[cCodificacion]?></td>
    <td valign="top" align="center">
    		<?
    	  echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
        echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
				?>
		</td>
    <td valign="top" align="left"><?=$Rs['cAsunto']?></td> 
    <td valign="top"><?=$Rs[cObservaciones]?></td>
    <td valign="top"><?=$Rs[cNomOFicina]?></td>
    <td valign="top" align="center">
				<?
    		$sqlDw=" SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]' ";
      	$rsDw=sqlsrv_query($cnx,$sqlDw);
      		if(sqlsrv_has_rows($rsDw)>0){
      		   $RsDw=sqlsrv_fetch_array($rsDw);
      		   if($RsDw["cNombreNuevo"]!=""){
			   				if (file_exists("../cAlmacenArchivos/".trim($RsDw["cNombreNuevo"]))){
									echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
			   				}Else{
			    				echo "<img src=images/space.gif width=16 height=16 border=0>";
								}
							}
      		}
    			?>
     </td>
   </tr>
	 <?php}?> 
 	 </table>
 	
 	
   </fieldset>
                </fieldset>
     </td>
		</tr>
	 </table>
     <?  
      }
	}	 
?>
    </td>
	  </tr>
		</table>
</div>		

</tr>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>