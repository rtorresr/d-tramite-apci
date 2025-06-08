<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroTramiteEdit.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Modificar el Registro de un Documento y sus Movimientos
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   Larry Ortiz       24/01/2011    Creación del programa.
 
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
<link rel="stylesheet" href="css/detalle.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">

function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}

function muestra(nombrediv) {
   if(document.getElementById(nombrediv).style.display == '') {
      document.getElementById(nombrediv).style.display = 'none';
   } else {
      document.getElementById(nombrediv).style.display = '';
          }
   }
function seleccionar_todo(){
	for (i=0;i<document.frmEdicion.elements.length;i++)
		if(document.frmEdicion.elements[i].type == "checkbox")	
			document.frmEdicion.elements[i].checked=1
}
function deseleccionar_todo(){
	for (i=0;i<document.frmEdicion.elements.length;i++)
		if(document.frmEdicion.elements[i].type == "checkbox")	
			document.frmEdicion.elements[i].checked=0
}
function releer(){
  document.frmEdicion.action="<?=$_SERVER['PHP_SELF']?>?cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&clear=1#area";
  document.frmEdicion.submit();
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

<div class="AreaTitulo">Editar Documento</div>
<table class="table">
 <tr>

<form name="frmEdicion" method="POST" >
 
<?
  $fDesde=date("Ymd H:i", strtotime($_GET['fDesde']));
  $fHasta=date("Ymd H:i", strtotime($_GET['fHasta']));
	
	/*
	$fHasta=date("Y-m-d H:i", strtotime($_GET['fHasta']));
	
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd H:i", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
	}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
	*/
	 
    $sqlCod=" SELECT * FROM Tra_M_Tramite WHERE cCodificacion='$_POST[cCodificacion]' AND  Tra_M_Tramite.iCodTramite='$_POST[iCodTramite]' ";
	$rsCod=sqlsrv_query($cnx,$sqlCod);
	$numrows=sqlsrv_has_rows($rsCod);
    if($numrows==0){ 
		echo "No Se Encuentra ese Documento<br>";
    }
	else {
	$RsCod=sqlsrv_fetch_array($rsCod);
	 ?> 
    <input type="hidden" name="iCodTramite" value="<?=trim($RsCod[iCodTramite])?>">
    <input type="hidden" name="tupa" value="1">
    <input type="hidden" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>">
    <input type="hidden" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>">
 <?
	// consulta de los datos relacionados del documento
	 $sql=" SELECT   *  ";
	 $sql.=" FROM  Tra_M_Tramite LEFT JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ";
	 $sql.=" LEFT JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite_Movimientos.iCodTramite=Tra_M_Tramite.iCodTramite LEFT JOIN ";
	 $sql.=" Tra_M_Oficinas  ON Tra_M_Oficinas.iCodOficina=Tra_M_Tramite_Movimientos.iCodOficinaDerivar ";
	 $sql.=" WHERE  Tra_M_Tramite.iCodTramite='$RsCod[iCodTramite]' AND Tra_M_Tramite.cCodificacion='$RsCod[cCodificacion]' ";
     $sql.=" ORDER BY Tra_M_Tramite.iCodTramite DESC";	   
     $rs=sqlsrv_query($cnx,$sql);
	    //echo $sql;
 ?>
     <br>
   <table width="950" border="0" align="center">
	 <tr>
	  <td>
		<fieldset id="tfa_GeneralDoc" class="fieldset">
		<legend class="LnkZonas"><strong>Documento N&ordm;: <?=$RsCod[cCodificacion]?></strong> </legend>
	      <br>
        <table width="950" border="0" align="center">
		  <tr>
		    <td>
			<fieldset id="tfa_GeneralDoc" class="fieldset">
			<legend class="legend"><a href="javascript:;" onClick="muestra('zonaGeneral')" class="LnkZonas">Datos Generales del Documento  <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend><div id="zonaGeneral">
		      <table border="0" width="860">
		        <tr>
		          <td width="130" >Fecha del Documento:&nbsp;</td>
		          <td width="168" align="left">
                  <input type="txt" name="fFecDocumento" value="<?php echo date('d-m-Y', strtotime($RsCod['fFecDocumento']))." ".date('h:i A', strtotime($RsCod['fFecDocumento']));?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="159" align="left"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDocumento,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		          <td width="130" >Fecha de Registro:&nbsp;</td>
		          <td width="172" align="left">
                  <input type="txt" name="fFecRegistro" value="<?php echo date("d-m-Y", strtotime($RsCod['fFecRegistro']))." ".date("h:i A", strtotime($Rs['fFecRegistro']));?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="75" align="left"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		        </tr> 
		        <tr>
		          <td width="130" >N&ordm; Documento:&nbsp;</td>
		          <td colspan="2" align="left"><input type="txt" name="cNroDocumento" value="<?php if($_GET[clear]==""){ echo trim($RsCod['cNroDocumento']); }Else{ echo $_POST['cNroDocumento'];}?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="130" >Referencia:&nbsp;</td>
		          <td colspan="2" align="left"> <input type="txt" name="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($RsCod[cReferencia]); }Else{ echo $_POST[cReferencia];}?>" size="28" class="FormPropertReg form-control"></td>
		        </tr>
		        <tr>
		          <td width="130" >Tipo de Documento:&nbsp;</td>
		          <td colspan="2" align="left">
                    <select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
					<option value="">Seleccione:</option>
					<?
					include_once("../conexion/conexion.php");
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
                    $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          	        if($RsTipo["cCodTipoDoc"]==$RsCod[cCodTipoDoc]){
          		       $selecTipo="selected";
          	        }Else{
          		       $selecTipo="";
          	        }
                    echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
                    }
                    sqlsrv_free_stmt($rsTipo);
					?></td>
		          <td width="130" >Folios:&nbsp;</td>
		          <td colspan="2" align="left">
                    <input type="txt" name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($RsCod[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" size="28" class="FormPropertReg form-control"></td>
		        </tr>
	            <tr>
		          <td width="130" >Asunto:&nbsp;</td>
		          <td colspan="2" align="left">
                  <textarea name="cAsunto" style="width:320px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsCod['cAsunto']); }Else{ echo $_POST['cAsunto'];}?></textarea>
                  </td>
		          <td width="130" >Observaciones:&nbsp;</td>
		          <td colspan="2" align="left">
                  <textarea name="cObservaciones" style="width:320px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsCod[cObservaciones]); }Else{ echo $_POST[cObservaciones];}?></textarea>
                  </td>
		        </tr>
		        <tr>
		          <td width="130" >Tiempo respuesta:&nbsp;</td>
		          <td colspan="2" align="left"><input type="txt" name="nTiempoRespuesta" value="<?php if($_GET[clear]==""){ echo trim($RsCod[nTiempoRespuesta]); }Else{ echo $_POST[nTiempoRespuesta];}?>"  size="28" class="FormPropertReg form-control"></td>
		          <td width="130" >&nbsp;</td>
		          <td colspan="2"></td>
		        </tr>
		      </table>
              </div>
		  	  <img src="images/space.gif" width="0" height="0">
	        </fieldset>
		    </td>
		  </tr>
		  <tr>
		    <td>   
            <fieldset id="tfa_GeneralDoc" class="fieldset">
			<legend class="legend"><a href="javascript:;" onClick="muestra('zonaAdicionalDcoumento')" class="LnkZonas">Datos Adicionales del Documento  <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend><div  id="zonaAdicionalDcoumento">
		      <table border="0" width="860">
		        <tr>
		          <td width="130" >Tipo de Registro:&nbsp;</td>
		          <td width="343" align="left">
                    <select name="nFlgTipoDoc" class="FormPropertReg form-control" style="width:180px" />
					<option value="">Seleccione:</option>
                    <option <?php if($RsCod[nFlgTipoDoc]=="1") echo "selected"?> value="1">Entrada</option>
                    <option <?php if($RsCod[nFlgTipoDoc]=="2") echo "selected"?> value="2">Interno</option>
                    <option <?php if($RsCod[nFlgTipoDoc]=="3") echo "selected"?> value="3">Salida</option>
                    <option <?php if($RsCod[nFlgTipoDoc]=="4") echo "selected"?> value="4">Anexo</option></td>
                  <td width="114" >Indicación:&nbsp;</td>
		          <td width="255" align="left">
                    <select name="iCodIndicacion" style="width:250px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
				    <? $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                       $sqlIndic .= "ORDER BY cIndicacion ASC";
                       $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                       while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
              	       if($RsIndic[iCodIndicacion]==$RsCod[iCodIndicacion]){
              		   $selecIndi="selected";
              	       }Else{
              		   $selecIndi="";
              	       }              	
                       echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
                       }
                       sqlsrv_free_stmt($rsIndic);
				   ?>  </select></td>
		         
		        </tr> 
		        <tr>
		          <td width="130" >Trabajador de Registro:&nbsp;</td>
		          <td width="343" align="left">
                    <select name="iCodTrabajadorSolicitado" style="width:340px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
					<? $sqlTrb="SELECT * FROM Tra_M_Trabajadores ";
                       $sqlTrb .= "ORDER BY cNombresTrabajador ASC";
                       $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                       while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	       if($RsTrb[iCodTrabajador]==$RsCod[iCodTrabajadorRegistro]){
              		   $selecTrab="selected";
              	       }Else{
              		   $selecTrab="";
              	       }
                       echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                       }
                       sqlsrv_free_stmt($rsTrb);
		 		   ?>
				   </select></td>
		          <td width="114" >Remitente:&nbsp;</td>
		          <td align="left"> 
                    
                  <input type="txt" name="cReferencia" value="<?php echo $RsCod[cReferencia];?>" size="28" class="FormPropertReg form-control"></td>
		        </tr>
		        <tr>
		          <td width="130" >Solicitado por:&nbsp;</td>
		          <td align="left">
                    <select name="iCodTrabajadorSolicitado" style="width:340px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
				    <? $sqlTrb="SELECT * FROM Tra_M_Trabajadores ";
                       $sqlTrb .= "ORDER BY cApellidosTrabajador ASC";
                       $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                       while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	       if($RsTrb[iCodTrabajador]==$RsCod[iCodTrabajadorSolicitado]){
              		   $selecTrab="selected";
              	       }Else{
              		   $selecTrab="";
              	       }
                       echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                       }
                       sqlsrv_free_stmt($rsTrb);
					?> </select></td>
		          <td width="114" >Representante:&nbsp;</td>
		          <td align="left">
                    <input type="txt" name="nNumFolio" value="<?=trim($RsCod[cNomRemite])?>" size="28" class="FormPropertReg form-control"></td>
		        </tr>
           
                <tr>
			      <td valign="top"  width="130">Clase de Procedimiento:</td>
			      <td valign="top" colspan="3" align="left">
				 	<select name="iCodTupaClase" class="FormPropertReg form-control" style="width:110px" onChange="releer();" />
					<?
					if($RsCod[nFlgEnvio]==1){
						$sqlClas="SELECT * FROM Tra_M_Tupa_Clase ORDER BY iCodTupaClase ASC";
					}Else{
						echo "<option value=\"\">Seleccione:</option>";
						$sqlClas="SELECT * FROM Tra_M_Tupa_Clase ORDER BY iCodTupaClase ASC";
					}
          $rsClas=sqlsrv_query($cnx,$sqlClas);
          while ($RsClas=sqlsrv_fetch_array($rsClas)){
          	if($_GET[clear]==""){
          			if($RsClas["iCodTupaClase"]==$RsCod[iCodTupaClase]){
          				$selecClas="selected";
          			}Else{
          				$selecClas="";
          			}
          	}Else{
          			if($RsClas["iCodTupaClase"]==$_POST[iCodTupaClase]){
          				$selecClas="selected";
          			}Else{
          				$selecClas="";
          			}          			
          	}
          echo "<option value=".$RsClas["iCodTupaClase"]." ".$selecClas.">".$RsClas["cNomTupaClase"]."</option>";
          }
          sqlsrv_free_stmt($rsClas);
					?>
					</select></td>
			    </tr>
                <?
					if($_GET[clear]==""){
							$iCodTupaClase=$RsCod[iCodTupaClase];
					}Else{
							$iCodTupaClase=$_POST[iCodTupaClase];
					}
					?>
                <tr>
			      <td valign="top"  width="130">Procedimiento:</td>
			      <td valign="top" colspan="3" align="left">
					<select name="iCodTupa" class="FormPropertReg form-control" style="width:700px" onChange="releer();" <?php if($iCodTupaClase=="") echo "disabled"?> />
					<?
					if($RsCod[nFlgEnvio]==1){
						$sqlTupa="SELECT * FROM Tra_M_Tupa WHERE iCodTupaClase='$iCodTupaClase' ORDER BY iCodTupa ASC";
					}Else{
						echo "<option value=\"\">Seleccione:</option>";
						$sqlTupa="SELECT * FROM Tra_M_Tupa WHERE iCodTupaClase='$iCodTupaClase' ORDER BY iCodTupa ASC";
					}
          $rsTupa=sqlsrv_query($cnx,$sqlTupa);
          while ($RsTupa=sqlsrv_fetch_array($rsTupa)){
          	if($_GET[clear]==""){
          			if($RsTupa["iCodTupa"]==$RsCod['iCodTupa']){
          				$selecTupa="selected";
          			}Else{
          				$selecTupa="";
          			}
          	}Else{
          			if($RsTupa["iCodTupa"]==$_POST['iCodTupa']){
          				$selecTupa="selected";
          			}Else{
          				$selecTupa="";
          			}          			
          	}
          echo "<option value=".$RsTupa["iCodTupa"]." ".$selecTupa.">".$RsTupa["cNomTupa"]."</option>";
          }
          sqlsrv_free_stmt($rsTupa);
					?>
					</select></td>
			      </tr>
                  <tr>
			        <td valign="top"  width="130">Requisitos:</td>
			        <td valign="top" colspan="3" align="left">
				 <?
					if($_GET[clear]==""){
							$iCodTupa=$RsCod['iCodTupa'];
					}Else{
							$iCodTupa=$_POST['iCodTupa'];
					}
					
					$sqlTupaReq="SELECT * FROM Tra_M_Tupa_Requisitos WHERE iCodTupa='$iCodTupa' ORDER BY iCodTupaRequisito ASC";
          $rsTupaReq=sqlsrv_query($cnx,$sqlTupaReq);
					?>
					<fieldset><legend>
					<?php if(sqlsrv_has_rows($rsTupaReq)>0){?>
					<a href="javascript:seleccionar_todo()">Marcar todos</a> | 
					<a href="javascript:deseleccionar_todo()">Desmarcar</a> 
					<?php}?>
					</legend>
					<table cellpadding="0" cellspacing="2" border="0" width="600">
                    <?
				if(sqlsrv_has_rows($rsTupaReq)>0){
						while ($RsTupaReq=sqlsrv_fetch_array($rsTupaReq)){
							if($_GET[clear]==""){
									$sqlReqChk="SELECT * FROM Tra_M_Tramite_Requisitos WHERE iCodTupaRequisito='$RsTupaReq[iCodTupaRequisito]' AND iCodTramite='$_POST[iCodTramite]'";
									//echo $sqlReqChk;
          				$rsReqChk=sqlsrv_query($cnx,$sqlReqChk);
          				if(sqlsrv_has_rows($rsReqChk)>0){
          					$Checkear="checked";
									}
							}Else{
									For ($h=0;$h<count($_POST[iCodTupaRequisito]);$h++){
      							$iCodTupaRequisito= $_POST[iCodTupaRequisito];
										if($RsTupaReq[iCodTupaRequisito]==$iCodTupaRequisito[$h]){
   											$Checkear="checked";
										}
									}
							}
          		echo "<tr><td valign=top width=15><input type=\"checkbox\" name=\"iCodTupaRequisito[]\" value=\"".$RsTupaReq["iCodTupaRequisito"]."\" ".$Checkear."></td><td style=\"color:#004080;font-size:11px\">".$RsTupaReq["cNomTupaRequisito"]."</td></tr>";
          		$Checkear="";
          	}
          }Else{
          	echo "&nbsp;";
          }
          sqlsrv_free_stmt($rsTupaReq);
					?>						
				    </table>
					</fieldset>
			      </td>
			    </tr>
             
	        
		      </table>
              </div>
		  	  <img src="images/space.gif" width="0" height="0">
	        </fieldset>
		    </td>
		  </tr>
		  <tr>
		    <td>   
	          <fieldset id="tfa_GeneralEmp" class="fieldset">
		      <legend class="legend"><a href="javascript:;" onClick="muestra('zonaAnexo')" class="LnkZonas">Datos de Movimiento del Documento  <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend><div id="zonaAnexo">
                <table  border="0" width="913" cellpadding="3" cellspacing="3" align="left">
                  <tr>
	                <td width="105" class="headCellColum">Tipo Documento</td>
	                <td width="103" class="headCellColum">Nro Documento</td>
	                <td width="96" class="headCellColum">Fecha registro</td> 
	                <td width="170" class="headCellColum">Contenido</td>
	                <td width="148" class="headCellColum">Observaciones</td>
                    <td width="162" class="headCellColum">Destino (OFICINA)</td>
                    <td width="63" class="headCellColum">Opciones</td>
	              </tr>
                <?php
    $numrows=sqlsrv_has_rows($rs);
                    if($numrows==0){ 
		            echo "";
                    }else{
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
                   <td valign="top" align="center"><?php echo $Rs['cDescTipoDoc'];?></td>
                   <td valign="top" align="center"><?php echo $Rs[cCodificacion];?></td>
                   <td valign="top" align="center">
     	       <?
    	           echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
                   echo "<div style=color:#0154AF;font-size:10px>".date("h:i A", strtotime($Rs['fFecRegistro']))."</div>";
		       ?>  </td>
                   <td valign="top" align="left"><?php echo $Rs['cAsunto'];?></td>
                   <td valign="top"><?  echo $Rs[cObservaciones];?></td>
                   <td valign="top"><?  echo $Rs[cNomOFicina];?></td>
                   <td valign="top" align="center">
               <?
    		       $sqlDw=" SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]' ";
      		       $rsDw=sqlsrv_query($cnx,$sqlDw);
      		       if(sqlsrv_has_rows($rsDw)>0){
      		       $RsDw=sqlsrv_fetch_array($rsDw);
      		       if($RsDw["cNombreNuevo"]!=""){
			       if (file_exists("../cAlmacenArchivos/".trim($RsDw["cNombreNuevo"]))){
				   echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim                   ($RsDw["cNombreNuevo"])."\"></a>";
			       }Else{
			       echo "<img src=images/space.gif width=16 height=16 border=0>";
						}
				   }
      		       }
    		  ?>  </td>
                </tr>
              <?
				   }
                 }
              ?> 
              </table>
              </div>
		  	  <img src="images/space.gif" width="0" height="0"> 
            </fieldset>
		    </td>
		  </tr>
        </table >
        </fieldset>
      

      </td>
    </tr>
  </table >
  

     <?  
      }
		 
?>
</form>
</td>
 </tr>
   </table>


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