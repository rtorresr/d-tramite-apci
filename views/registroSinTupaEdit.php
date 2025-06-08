<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

<script Language="JavaScript">
<!--

function activaDestino(){
	if (document.frmRegistro.nFlgEnvio.value==1){
			document.frmRegistro.nFlgEnvio.value="";
	} else {
			document.frmRegistro.nFlgEnvio.value=1;
	}
return false;
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmRegistro.submit();
}
var miPopup
	function Buscar(){
 miPopup=window.open('registroBuscarDocEnt.php','popuppage','width=745,height=360,toolbar=0,status=0,resizable=0,scrollbars=yes,top=100,left=100');
	}
	
function AddReferencia(){
  document.frmRegistro.opcion.value=21;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}
function Registrar()
{
  if (document.frmRegistro.cCodTipoDoc.value.length == "")
  {
    alert("Seleccione Tipo de Documento");
    document.frmRegistro.cCodTipoDoc.focus();
    return (false);
  }
  if (document.frmRegistro.cNroDocumento.value.length == "")
  {
    alert("Ingrese Número del Documento");
    document.frmRegistro.cNroDocumento.focus();
    return (false);
  }
  if (document.frmRegistro.nFlgEnvio.value==1)
  {
  		if (document.frmRegistro.iCodOficinaResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Oficina");
  		  document.frmRegistro.iCodOficinaResponsable.focus();
  		  return (false);
  		}
  		if (document.frmRegistro.iCodTrabajadorResponsable.value.length == "")
  		{
  		  alert("Para enviar seleccione Responsable");
  		  document.frmRegistro.iCodTrabajadorResponsable.focus();
  		  return (false);
  		}
	}
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

//--></script>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
</head>
<body>

	<?php include("includes/menu.php");?>

	<?php
		include_once("../conexion/conexion.php");
		$rs = sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs = sqlsrv_fetch_array($rs);
	?>
<a name="area"></a>
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

<div class="AreaTitulo">Actualizacion - Registro de entrada sin tupa</div>
		<table class="table">
		<tr>
			<form name="frmRegistro" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="9">
			<input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
      <input type="hidden" name="sal" value="5">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
			<input type="hidden" name="cCodificacion" value="<?=trim($Rs[cCodificacion])?>">
			<input type="hidden" name="nFlgEnvio" value="<?php if($_POST[ActivarDestino]==1) echo "1"?>">
		<td class="FondoFormRegistro">
			<table width="1030" border="0">
			<tr>
			<td valign="top"  width="200">Tramite:</td>
			<td valign="top" colpsan="3" style="font-size:16px;color:#00468C"><b><?=$Rs[cCodificacion]?></b></td>
			</tr>
			
					
			<tr>
			<td valign="top"  width="200">Tipo de Documento:</td>
			<td valign="top">
					<select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
					<option value="">Seleccione:</option>
					<?
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
          $sqlTipo.="ORDER BY cDescTipoDoc ASC";
          $rsTipo=sqlsrv_query($cnx,$sqlTipo);
          while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          	if($_GET[clear]==""){
          			if($RsTipo["cCodTipoDoc"]==$Rs[cCodTipoDoc]){
          				$selecTipo="selected";
          			}Else{
          				$selecTipo="";
          			}
          	}Else{
          			if($RsTipo["cCodTipoDoc"]==$_POST[cCodTipoDoc]){
          				$selecTipo="selected";
          			}Else{
          				$selecTipo="";
          			}          		
          	}
          echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          }
          sqlsrv_free_stmt($rsTipo);
					?>
				</select>&nbsp;<span class="FormCellRequisito">*</span>
			</td>
			<td  width="160">Fecha Registro:</td>
      <td>
      	<table cellpadding="0" cellspacing="0" border="0">
      <tr>
				<td>
					<input type="text" readonly name="fFecRegistro" value="<?php if($Rs['fFecRegistro']!=""){ echo date("d-m-Y G:i:s", strtotime($Rs['fFecRegistro']))/*echo date("d-m-Y G:i:s", strtotime(substr($Rs['fFecRegistro'], 0, -6)))*/; } else {echo $_POST['fFecRegistro'];}?>" style="width:105px" class="FormPropertReg form-control" >
				</td>
				<td>
					<div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRegistro,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>
					</div>
				</td>
			</tr>
		</table>
    </td>
            <? /*<td style="padding-top:5px;"><b><?=date("d-m-Y H:i", strtotime($Rs['fFecDocumento']))?></td> */ ?>
			</tr>

		<tr>
			<td  valign="top">Fecha del Documento:</td>
			<td>
				<input type="text" name="fechaDocumento" value="<?php echo $Rs['FECHA_DOCUMENTO']; ?>" style="width:120px" class="FormPropertReg form-control" readonly>
				<div class="boton" style="width:24px;height:20px;display:inline">
					<a href="javascript:;" onclick="displayCalendar(document.forms[0].fechaDocumento,'dd-mm-yyyy hh:ii',this,true)">
						<img src="images/icon_calendar.png" width="22" height="20" border="0">
					</a>
				</div>
			</td>
		</tr>	

			<tr>
			<td valign="top"  width="200">N&ordm; del Documento:</td>
			<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase" name="cNroDocumento" value="<?php if($_GET[clear]==""){ echo trim($Rs['cNroDocumento']); }Else{ echo stripslashes((isset($_POST['cNroDocumento']))?$_POST['cNroDocumento']:'');}?>" class="FormPropertReg form-control" style="width:250px" />&nbsp;<span class="FormCellRequisito">*</span></td>
			</tr>
	
					<?
					$sqlRmt="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente=$Rs[iCodRemitente]";
          $rsRmt=sqlsrv_query($cnx,$sqlRmt);
          $RsRmt=sqlsrv_fetch_array($rsRmt);
					?>
			<tr>
				<td valign="top" >Remitente / Instituci&oacute;n:</td>
				<td valign="top" colspan="3">
					<table cellpadding="0" cellspacing="2" border="0">
						<tr>
							<td>
								<?php 
									$sqlWeb = "SELECT iCodTrabajador,ES_EXTERNO,cNombresTrabajador FROM Tra_M_Trabajadores 
														 WHERE iCodTrabajador = (SELECT iCodTrabajadorRegistro FROM Tra_M_Tramite WHERE iCodTramite = '$_GET[iCodTramite]')";
									$rsWeb  = sqlsrv_query($cnx,$sqlWeb);
									$RsWeb  = sqlsrv_fetch_array($rsWeb);
									if ($RsWeb[ES_EXTERNO] == 1) {
								?>
									<input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" 
											 value="<?php echo $RsWeb[cNombresTrabajador]; ?>" 
											 style="width:380px" readonly>
								<?php
									}else{
								?>
									<input id="cNombreRemitente" name="cNombreRemitente" class="FormPropertReg form-control" 
											 value="<?php if($_GET[clear]==""){ echo trim($RsRmt['cNombre']); }else{ echo $_POST[cNombreRemitente];}?>"
											 style="width:380px" readonly>
								<?php
									}
								?>
							</td>
							<td align="center">
								<div class="btn btn-primary" style="width:70px;height:17px;padding-top:4px;">
									<a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesLs.php','popuppage','width=745,height=360,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Buscar</a>
								</div>
							</td>
							<td align="center">
								<div class="btn btn-primary" style="width:115px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="window.open('registroRemitentesNw.php','popuppage','width=590,height=450,toolbar=0,statusbar=1,resizable=0,scrollbars=yes,top=100,left=100');">Nuevo Remitente</a>
								</div>
							</td>
              <td>&nbsp;<span class="FormCellRequisito">*</span></td>
						</tr>					
          </table>
					<?php 
						if ($RsWeb[ES_EXTERNO] == 1) {
							$sqlRemitente = "SELECT iCodRemitente,cNombre FROM Tra_M_Remitente 
														 				 WHERE cNombre LIKE '%' + (SELECT cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador = '$RsWeb[iCodTrabajador]') + '%'";
							$rsRemitente = sqlsrv_query($cnx,$sqlRemitente);
							$RsRemitente = sqlsrv_fetch_array($rsRemitente);
					?>
							<input type="hidden" name="iCodRemitente" id="iCodRemitente"  
								 value="<?php echo $RsRemitente[iCodRemitente]; ?>">
          		<input type="hidden" name="Remitente" id="Remitente" value="<?=$_POST[iCodRemitente]?>">	
					<?php
						}else{
					?>
							<input type="hidden" name="iCodRemitente" id="iCodRemitente"  
								 value="<?php if($_GET[clear]==""){ echo $Rs[iCodRemitente]; }else{ echo $_POST[iCodRemitente];}?>">
          		<input type="hidden" name="Remitente" id="Remitente" value="<?=$_POST[iCodRemitente]?>">
					<?php
						}
					?>
			</td>
			</tr>
			
			
			
			<tr>
			<td valign="top"  width="200">Remite:</td>
			<td valign="top" colspan="3"><input type="text" style="text-transform:uppercase;width:250px;" name="cNomRemite" value="<?php if($_GET[clear]==""){ echo trim($Rs[cNomRemite]); }Else{ echo $_POST[cNomRemite];}?>" class="FormPropertReg form-control" style="width:450px" />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>
			
			
			<tr>
			<td valign="top" >Asunto:</td>
			<td valign="top">
					<textarea name="cAsunto" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs['cAsunto']); }Else{ echo stripslashes($_POST['cAsunto']);}?></textarea>&nbsp;<span class="FormCellRequisito">*</span>
					&nbsp;&nbsp;
			</td>
			<td valign="top" >Observaciones:</td>
			<td valign="top">
					<textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($Rs[cObservaciones]); }Else{ echo stripslashes($_POST[cObservaciones]);}?></textarea>
			</td>
			</tr>				

			<!-- <tr>
				<td valign="top"  width="200">Referencia:</td>
				<td valign="top" colspan="3"><input type="text" name="cReferencia2" style="text-transform:uppercase" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia2]); }Else{ echo $_POST[cReferencia2];}?>" class="FormPropertReg form-control" style="width:250px" />
				</td>
			</tr> -->
      <tr>
          
            <td valign="top"  wdidth="160">Referencia:</td>
			<td valign="top">
					<table><tr>
					<td align="center"><input type="hidden" readonly="readonly" name="cReferencia" value="<?php if($_GET[clear]==""){ echo trim($Rs[cReferencia]); }Else{ echo trim($_POST[cReferencia]);}?>" class="FormPropertReg form-control" style="width:140px;text-transform:uppercase" />
                    <input type="hidden" name="iCodTramiteRef"  value="<?=$_REQUEST[iCodTramiteRef]?>"  />
                    </td>
					<td align="center"></td>
					<td align="center"><div class="btn btn-primary" style="width:125px;height:17px;padding-top:4px;"><a style=" text-decoration:none" href="javascript:;" onClick="Buscar();">A&ntilde;adir Referencia</a> </div></td>
					</tr></table>
                    <table border=0><tr><td>
						<?
						$sqlRefs="SELECT * FROM Tra_M_Tramite_Referencias WHERE cCodSession='".$_SESSION[cCodRef]."' or icodtramite='".$_REQUEST[iCodTramite]."'";
				//	echo $sqlRefs;
          	$rsRefs=sqlsrv_query($cnx,$sqlRefs);
          	while ($RsRefs=sqlsrv_fetch_array($rsRefs)){
						?>
						<span style="background-color:#EAEAEA;"><?=$RsRefs[cReferencia]?><a href="registroData.php?iCodReferencia=<?=$RsRefs[iCodReferencia]?>&opcion=20&iCodTramite=<?=$_GET[iCodTramite]?>&sal=1&URI=<?=$_GET[URI]?>&radioSeleccion=<?=$_POST[radioSeleccion]?>&cNombreRemitente=<?=$_POST[cNombreRemitente]?>&iCodTrabajadorResponsable=<?=$_POST[iCodTrabajadorResponsable]?>&iCodOficinaResponsable=<?=$_POST[iCodOficinaResponsable]?>&cNroDocumento=<?=$_POST['cNroDocumento']?>&cNomRemite=<?=((isset($_POST['cNomRemite']))?$_POST['cNomRemite']:'')?>&ActivarDestino=<?=$_POST[ActivarDestino]?>&iCodRemitente=<?=$_POST[iCodRemitente]?>&Remitente=<?=$_POST[Remitente]?>&cCodTipoDoc=<?=$_POST[cCodTipoDoc]?>&cAsunto=<?=$_POST['cAsunto']?>&cObservaciones=<?=$_POST[cObservaciones]?>&nNumFolio=<?=$_POST[nNumFolio]?>&nFlgEnvio=<?=$_POST[nFlgEnvio]?>&cSiglaAutor=<?=$_POST[cSiglaAutor]?>"><img src="images/icon_del.png" border="0" width="13" height="13"></a></span>&nbsp;
                       	
						<?php}?>

					
			
            </tr>

			<tr>
				<td valign="top"  width="200">Oficina:</td>
				<td>
					<?php 
						$sqlMov = "SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos 
											 WHERE iCodTramite='$_GET[iCodTramite]' AND cFlgTipoMovimiento!=4 
											 ORDER BY iCodMovimiento ASC"; 
						$rsMov  = sqlsrv_query($cnx,$sqlMov);
						echo "<input type=hidden name=numMov value=".sqlsrv_has_rows($rsMov).">";
            if (sqlsrv_has_rows($rsMov) > 0){
            	$RsMov = sqlsrv_fetch_array($rsMov);
              $iCodOficinaResponsable=$RsMov[iCodOficinaDerivar];
              $iCodTrabajadorResponsable=$RsMov[iCodTrabajadorDerivar];
              echo "<input type=hidden name=iCodMov value=".$RsMov[iCodMovimiento].">";
              echo "<input type=hidden name=iCodOfi value=".$RsMov[iCodOficinaDerivar].">";
              echo "<input type=hidden name=iCodTra value=".$RsMov[iCodTrabajadorDerivar].">";
            }
          ?>
          <?php 
          	$sqlEnvio = "SELECT nFlgEnvio FROM Tra_M_Tramite WHERE iCodTramite = ".$_GET['iCodTramite'];
          	$rsEnvio  = sqlsrv_query($cnx,$sqlEnvio);
          	$RsEnvio  = sqlsrv_fetch_array($rsEnvio);
          ?>
        <select name="iCodOficinaResponsable" style="width:340px;" class="js-example-basic-single" 
								onChange="loadResponsables(this.value);">
					<option value="">Seleccione:</option>
						<?php
							$sqlOfVirtual = "SELECT iCodOficina FROM Tra_M_Oficinas WHERE cNomOficina /* LIKE '%VIRTUAL%' */";
							$rsOfVirtual  = sqlsrv_query($cnx,$sqlOfVirtual);
							$RsOfVirtual  = sqlsrv_fetch_array($rsOfVirtual);
							$iCodOficinaVirtual = $RsOfVirtual['iCodOficina'];

							// $sqlDep2 = "SELECT * FROM Tra_M_Oficinas 
							// 						WHERE iFlgEstado != 0 
							// 									AND iCodOficina != '".$_SESSION['iCodOficinaLogin']."'
							// 									AND iCodOficina != $iCodOficinaVirtual
							// 						ORDER BY cNomOficina ASC";

							$sqlDep2 = "SELECT * FROM Tra_M_Oficinas 
													WHERE iFlgEstado != 0 
																AND iCodOficina != $iCodOficinaVirtual
													ORDER BY cNomOficina ASC";

							//$sqlDep2 = "SP_OFICINA_LISTA_COMBO";
              $rsDep2  = sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2 = sqlsrv_fetch_array($rsDep2)){
              	if ($RsDep2['iCodOficina'] == $RsMov[iCodOficinaDerivar]){
              		$selecOfi = "selected";
              	}else{
              		$selecOfi = "";
              	}
                echo "<option value=".$RsDep2['iCodOficina']." ".$selecOfi.">".trim($RsDep2['cNomOficina'])." | ".trim($RsDep2["cSiglaOficina"])."</option>";
              }
              sqlsrv_free_stmt($rsDep2);
						?>
					</select>
					
        </td>
				<td valign="top" >Responsable</td>
				<td>
				
				
				<select name="iCodTrabajadorResponsable" id="responsable" style="width:340px;" class="FormPropertReg combobox">
				<?php
				    $sql= "
                        SELECT TOP 1 
                        (select (cNombresTrabajador+' '+cApellidosTrabajador) as nombre from Tra_M_Trabajadores where iCodTrabajador=m.iCodTrabajadorDerivar) as iCodTrabajadorDerivarx
                        ,* FROM Tra_M_Tramite_Movimientos m WHERE iCodTramite='".$_GET['iCodTramite']."' AND cFlgTipoMovimiento!=4 ORDER BY iCodMovimiento ASC";
				    $query=sqlsrv_query($cnx,$sql);
				    $rs=sqlsrv_fetch_array($query);
				    do{
                        if($rs['iCodMovimiento']==$RsMov[iCodTrabajadorDerivar]){
                            $selecOfix = "selected";
                        }else{
                            $selecOfix = "";
                        }
				       echo "<option value='".$rs['iCodTrabajadorDerivar']."' '".$selecOfi."'>".$rs['iCodTrabajadorDerivarx']."</option>";
				    }while($rs=sqlsrv_fetch_array($query));
				?>
				
				</select>
				
			</td>	
			</tr>
<script>
	function loadResponsables(value)
	{
        
        $("#responsable > option").remove(); 
        $('#responsable').append('<option value="">Cargando Datos...</option>'); 
       
		var parametros = {
					"iCodOficinaResponsable" : value
		   };
		var dominio = document.domain;

	    $.ajax({
	        type: 'POST',
	        url: 'loadResponsable.php', 
	        data: parametros, 
	        dataType: 'json',
	        success: function(list){
                $('#responsable').append('<option value="">Cargando Datos...</option>');
                $("#responsable > option").remove(); 

                console.log(list);
	            var opt = $('<option />'); 
              //opt.text('Seleccione un responsable');
              $('#responsable').append(opt);
              $.each(list,function(index,value) 
              {
                  //var opt = $('<option />'); 
                  opt.val(value.iCodTrabajador);
                  opt.text(value.cNombresTrabajador+" "+value.cApellidosTrabajador);
                  $('#responsable').append(opt); 
              });
	        },
	        error: function(e){
	        	console.log(e);
	            alert('Error Processing your Request!!');
	        }
	    });
	}
</script>
			<tr>
				<td valign="top"  width="200">Indicaci&oacute;n:</td>
				<td valign="top">
					<select name="iCodIndicacion" style="width:250px;" class="FormPropertReg form-control">
						<option value="">Seleccione:</option>
							<?php
								$sqlIndic = "SELECT * FROM Tra_M_Indicaciones ";
              	$sqlIndic .= "ORDER BY cIndicacion ASC";
              	$rsIndic = sqlsrv_query($cnx,$sqlIndic);
              	while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
              	if($_GET[clear]==""){
              			if($RsIndic[iCodIndicacion]==$Rs[iCodIndicacion] OR $RsIndic[iCodIndicacion]==3){
              				$selecIndi="selected";
              			}Else{
              				$selecIndi="";
              			}
              	}Else{		
              			if($RsIndic[iCodIndicacion]==$_POST[iCodIndicacion]){
              				$selecIndi="selected";
              			}Else{
              				$selecIndi="";
              			}
              	}
              			
                echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
              }
              sqlsrv_free_stmt($rsIndic);
							?>
							</select>
				</td>
				<td valign="top" >Folios:</td>
				<td>
					<input type="number" min=1 name="nNumFolio" value="<?php if($_GET[clear]==""){ echo trim($Rs[nNumFolio]); }Else{ echo $_POST[nNumFolio];}?>" class="FormPropertReg form-control" style="width:40px;text-align:right" />&nbsp;<span class="FormCellRequisito"></span></td>
			</tr>
			
					<?
					$sqlFlagEnvio = "SELECT nFlgEnvio FROM Tra_M_Tramite WHERE iCodTramite = ".$_GET['iCodTramite'];
					$rsFlagEnvio  = sqlsrv_query($cnx,$sqlFlagEnvio);
					$RsFlagEnvio  = sqlsrv_fetch_array($rsFlagEnvio);

					if ($RsFlagEnvio['nFlgEnvio'] == 1) {
						$marcarEnvio="checked disabled";
					}else{

					}

					if($_GET[clear]==""){
							if($Rs[nFlgEnvio]==1){
									$marcarEnvio="checked disabled";
									//$marcarEnvio="checked";
							}
					}else{
							if($_POST[ActivarDestino]==0){
									//$marcarEnvio="checked";
								//	$marcarEnvio="checked disabled";
							}
							else{
								$marcarEnvio="checked";
							}
					}
					?>
			<tr>
			<td valign="top" >Derivar inmediatamente:</td>
			<td valign="top">
				<input type="checkbox" name="ActivarDestino" value="1" <?php echo $marcarEnvio; ?>></td>
				<!-- <input type="checkbox" name="ActivarDestino" value="1" onclick="activaDestino();" <?=$marcarEnvio?>></td> -->
			</tr>

			<tr>
				<td valign="top" >Archivo F&iacute;sico:</td>
				<td valign="top" colspan="3">
					<textarea name="archivoFisico" id="archivoFisico" class="FormPropertReg form-control" style="width:33%;height:45px"><?php echo trim($Rs['ARCHIVO_FISICO']); ?></textarea>
				</td>
			</tr>

			<tr>
            <td colspan="4">
              <fieldset id="tfa_FlujoOfi" class="fieldset">
		  		<legend class="legend"><a href="javascript:;" onClick="muestra('zonaCopias')" class="LnkZonas">Copias<img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend>
		    <div  id="zonaCopias">
			    <table border="0" align="center" width="1000">
				    <tr>
				      <td class="headCellColum">Origen</td>
				       <td class="headCellColum">Destino</td>
				       <td class="headCellColum" width="150">Responsable</td>
				       <td class="headCellColum" width="80">Derivado</td>
				       <td class="headCellColum" width="80">Aceptado</td>
				       <td class="headCellColum" width="250">Observaciones</td>
				       <td class="headCellColum" width="120">Indicación</td>
		               <td class="headCellColum" width="100">Estado</td>
		                <td class="headCellColum" width="100">Opciones</td>
				    </tr>
			   		<?php 
			   		$sqlCop="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$Rs[iCodTramite]' AND iCodOficinaOrigen='".$_SESSION['iCodOficinaLogin']."' AND cFlgTipoMovimiento=4 ORDER BY iCodMovimiento ASC";
			   		$rsCop=sqlsrv_query($cnx,$sqlCop);
			   		//echo $sqlCop;
			    	while ($RsCop=sqlsrv_fetch_array($rsCop)){
			      	if ($color == "#CEE7FF"){
				  			$color = "#F9F9F9";
			  			}else{
				  			$color = "#CEE7FF";
			  			}
			  			if ($color == ""){
				  			$color = "#F9F9F9";
			  			}	
					?>
		    <tr bgcolor="<?=$color?>">
		     	<td valign="top"> <? 
		       	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsCop[iCodOficinaOrigen]'";
			       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
			       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
		       	 echo "<a href=\"javascript:;\" title=\"".trim($RsOfiO[cNomOficina])."\">".$RsOfiO[cSiglaOficina]."</a>";
		       	 ?>
		       	</td>
		     	<td valign="top"> <?
		     	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsCop[iCodOficinaDerivar]'";
			       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
			       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
		     	 		echo "<a href=\"javascript:;\" title=\"".trim($RsOfiD[cNomOficina])."\">".$RsOfiD[cSiglaOficina]."</a>";
		     	 	?>
		     	</td> 	
		    	<td valign="top">
		       	<?
          		$rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsCop[iCodTrabajadorDerivar]'");
          		$RsResp=sqlsrv_fetch_array($rsResp);
          		echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
						sqlsrv_free_stmt($rsResp);
        		?>
		        </td>
		        <td valign="top">
		       		 
		       			<span><?=date("d-m-Y", strtotime($RsCop['fFecDerivar']))?></span>
		       </td>
		       <td valign="top"> 
		       		<?
        			if($RsCop[fFecRecepcion]==""){
        					echo "<div style=color:#ff0000>sin aceptar</div>";
        			}Else{
        					echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsCop[fFecRecepcion]))."</div>";
        			}
        			?>
		       </td>
		     	 <td valign="top" align="left"><?=$RsCop[cObservacionesDerivar]?></td>		       
			     <td valign="top" align="left">
			     		<?
			     		$sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsCop[iCodIndicacionDerivar]'";
              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
              $RsIndic=sqlsrv_fetch_array($rsIndic);
                echo $RsIndic["cIndicacion"];
              sqlsrv_free_stmt($rsIndic);
			     		?>
			     </td>
                 <td valign="top" align="center">
		     	 		<?
		     	 		if($RsCop[fFecRecepcion]==""){
		     	 			switch ($RsCop['nEstadoMovimiento']) {
  							case 1:
									echo "Pendiente";
								break;
								case 2:
									echo "En Proceso"; //movimiento derivado a otra ofi
								break;
								case 3:
									echo "En Proceso"; //por delegar a otro trabajador
								break;
								case 4:
									echo "Respondido";
								break;
								case 5:
									echo "Finalizado";
								break;
								}
  				}Else if($RsCop[fFecRecepcion]!=""){ 
						switch ($RsCop['nEstadoMovimiento']) {
  							case 1:
									echo "En Proceso";
								break;
								case 2:
									echo "En Proceso"; //movimiento derivado a otra ofi
								break;
								case 3:
									echo "En Proceso"; //por delegar a otro trabajador
								break;
								case 4:
									echo "Respondido";
								break;
								case 5:
									echo "Finalizado";
								break;
								}  					
  				}
		     	 		?>
		    </td>
            <td valign="top" align="center">	
                 <a href="registroData.php?id=<?=$RsCop[iCodMovimiento];?>&opcion=26&idt=<?=$RsCop[iCodTramite];?>&URI=<?=$_GET[URI]?>" onClick='return ConfirmarBorrado2();'"><i class="far fa-trash-alt"></i></a>
        </td>
		    </tr> 
		    <?
		    }
		    ?>
		    </table>
		    </div>
		    <img src="images/space.gif" width="0" height="0"> 
		  	</fieldset>
            </td>
            </tr>
            <tr>
				<td valign="top"  width="200">Adjuntar Archivo:</td>
				<td valign="top">
						<?
						$sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$_GET[iCodTramite]'";
          	$rsDig=sqlsrv_query($cnx,$sqlDig);
          	if(sqlsrv_has_rows($rsDig)>0){
          			$RsDig=sqlsrv_fetch_array($rsDig);
          			if (file_exists("../cAlmacenArchivos/".trim($RsDig[cNombreNuevo]))){
										echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig[cNombreNuevo])."\">Descargar <img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDig[cNombreNuevo])."\"></a>";
										echo "&nbsp;&nbsp;&nbsp;<a href=\"registroData.php?opcion=13&iCodDigital=".$RsDig[iCodDigital]."&iCodTramite=".$_GET[iCodTramite]."&URI=".$_GET[URI]."\" style=color:#ff0000><img src=images/icon_del.png width=16 height=16 border=0> quitar adjunto</a>";
								}
          	}else{
          			echo "<input type=\"file\" name=\"fileUpLoadDigital\" class=\"FormPropertReg\" style=\"width:340px;\" />";
          	}
                                       
						?>
				</td>
				
			</tr>
			<tr>
			<td colspan="4"> 
					<input name="button" type="button" class="btn btn-primary" value="Actualizar" onclick="Registrar();">
					<input type="button" class="btn btn-primary" value="Cancelar" name="inicio" onClick="window.open('<?=$_GET[URI]?>', '_self');">
			</td>
			</tr>
			</table>
			&nbsp;<span class="FormCellRequisito">* Campos requeridos</span>

		</form>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>