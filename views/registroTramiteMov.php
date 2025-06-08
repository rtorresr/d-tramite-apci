<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroTramiteMov.php
SISTEMA: SISTEMA   DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Seleccion remitente
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=UFT-8 charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link rel="stylesheet" href="css/detalle.css" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
//  End -->
</script>
<style type="text/css">
body {
	background-image: url(images/background.jpg);
}
</style>
<script Language="JavaScript">
<!--
function releer(){
  document.frmMovimiento.action="<?=$_SERVER['PHP_SELF']?>?id=<?=$_GET[iCodMovimiento]?>&idt=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmMovimiento.submit();
}
function Volver(){
  document.frmMovimiento.action="registroDataEdicion.php";
  document.frmMovimiento.opcion.value=24;
  document.frmMovimiento.submit();
}
//--></script>
</head>
<body>

	<? include("includes/menu.php");?>



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

	Seleccione Movimiento:
   
</div>	
	  <form method="POST" name="frmMovimiento" action="registroDataEdicion.php"   target="_self" >
      <input type="hidden" name="opcion" value="23"  />
        <input type="hidden" name="iCodMovimiento" value="<?php if($id!=""){ echo $id;}else{ echo $_POST[iCodMovimiento];}?>"  />
        <input type="hidden" name="iCodTramite" value="<?php if($idt!=""){ echo $idt;}else{ echo $_POST[iCodTramite];}?>"  />
      <?
	  	if($_GET[clear]==""){
          	$id=$id;
			$idt=$idt;			
         }Else{
          	$id=$_POST[iCodMovimiento];
			$idt=$_POST[iCodTramite];		
          	   }
	$sqlM="SELECT * FROM Tra_M_Tramite_Movimientos WHERE (iCodTramite=".$idt." OR iCodTramiteRel=".$idt.")  AND (cFlgTipoMovimiento=1 OR cFlgTipoMovimiento=3 OR cFlgTipoMovimiento=5) And iCodMovimiento = ".$id." ORDER BY iCodMovimiento ASC";
		   	$rsM=sqlsrv_query($cnx,$sqlM);
		//	echo $sqlM;
				$recorrido=1;
                    $numrows=sqlsrv_has_rows($rsM);
                    if($numrows==0){ 
		            echo "";
                    }else{
                    $RsM=sqlsrv_fetch_array($rsM);
        		    if ($color == "#DDEDFF"){
			  			$color = "#F9F9F9";
	    			    }else{
			  			$color = "#DDEDFF";
	    			}
	    			if ($color == ""){
			  			$color = "#F9F9F9";
	    			}	
               ?>
       	<fieldset id="tfa_GeneralDoc" class="fieldset">
			<legend class="legend"><a href="javascript:;" onClick="muestra('zonaGeneral')" class="LnkZonas">Datos del movimiento  <img src="images/icon_expand.png" width="16" height="13" border="0"></a></legend><div id="zonaGeneral">
		      <table border="0" width="933" align="center">
		        <tr>
		          <td width="93" >Fecha de Derivo:&nbsp;</td>
		          <td width="168" align="left">
                   <?
				 if($_GET[clear]==""){  
				   if(trim($RsM['fFecDerivar'])!=""){
				  $fFecDerivar= date("d-m-Y", strtotime($RsM['fFecDerivar']))." ".date("G:i", strtotime($RsM['fFecDerivar']));
				   }
				   else { $fFecDerivar =""; }
				 }else{
					 if(trim($_POST['fFecDerivar'])!=""){
				  $fFecDerivar= date("d-m-Y", strtotime($_POST['fFecDerivar']))." ".date("G:i", strtotime($_POST['fFecDerivar']));
					 }else{$fFecDerivar ="";}
				 }
				 
				   ?>
                  <input type="txt" name="fFecDerivar" value="<?php echo $fFecDerivar;?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="178" align="left"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDerivar,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		          <td width="117"  align="left">Fecha de Aceptacion:&nbsp;</td>
		          <td width="168" align="left" >
                   <?
				    if($_GET[clear]==""){  
				   if(trim($RsM[fFecRecepcion])!=""){
				  $fFecRecepcion= date("d-m-Y", strtotime($RsM[fFecRecepcion]))." ".date("G:i", strtotime($RsM[fFecRecepcion]));
				   }
				   else {   $fFecRecepcion ="";   }
					}else{
						 if(trim($_POST[fFecRecepcion])!=""){ 
				  $fFecRecepcion= date("d-m-Y", strtotime($_POST[fFecRecepcion]))." ".date("G:i", strtotime($_POST[fFecRecepcion])); 
					 }else{$fFecRecepcion ="";}
					}
				   ?>
                   <input type="txt" name="fFecRecepcion" value="<?php echo $fFecRecepcion;?>" size="28" class="FormPropertReg form-control"></td>
		          <td width="183" align="left" ><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecRecepcion,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
		        </tr> 
                <tr>
                  <td >Estado:</td>
                  <td colspan="2"  align="left"> 
                  <select name="nEstadoMovimiento" style="width:140px;" class="FormPropertReg form-control" >
                     	<option value="1" <?php if($_GET[clear]==""){ if($RsM['nEstadoMovimiento']==1){ echo "selected";}}else {if($_POST['nEstadoMovimiento']==1){ echo "selected";}}?> >Pendiente / Proceso</option>
                        <option value="2" <?php if($_GET[clear]==""){ if($RsM['nEstadoMovimiento']==2){ echo "selected";}}else {if($_POST['nEstadoMovimiento']==2){ echo "selected";}}?>>Derivado</option>
                        <option value="3" <?php if($_GET[clear]==""){ if($RsM['nEstadoMovimiento']==3){ echo "selected";}}else {if($_POST['nEstadoMovimiento']==3){ echo "selected";}}?>>Delegado</option>
                        <option value="4" <?php if($_GET[clear]==""){ if($RsM['nEstadoMovimiento']==4){ echo "selected";}}else {if($_POST['nEstadoMovimiento']==4){ echo "selected";}}?>>Respondido</option>
                        <option value="5" <?php if($_GET[clear]==""){ if($RsM['nEstadoMovimiento']==5){ echo "selected";}}else {if($_POST['nEstadoMovimiento']==5){ echo "selected";}}?>>Finalizado</option>
                      </select></td>
                  <td valign="top" >Copia</td>
                  <td colspan="2" align="left" valign="top" >
  <?php if($_GET[clear]==""){if($RsM[cFlgTipoMovimiento]==4){$select = "checked";}}else if($_POST[cFlgTipoMovimiento]==4){$select = "checked";}?>
                  <label>
                    <input type="checkbox" name="cFlgTipoMovimiento"  id="cFlgTipoMovimiento" <?=$select?> value="1"/>
                  </label></td>
                </tr>
                <tr>
		          <td width="93" >Tipo de Documento:&nbsp;</td>
		          <td colspan="2"  align="left">
                    <select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
					<option value="">Seleccione:</option>
					<?
					$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
                    $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
				if($_GET[clear]==""){
          			if($RsTipo["cCodTipoDoc"]==$RsM[cCodTipoDocDerivar]){
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
					?></td>
		          <td valign="top" >N&ordm; del Tramite:</td>
			  <td colspan="2" align="left" valign="top" >
      <?php if($_GET[clear]==""){$cNumDocumentoDerivar=trim($RsM['cNumDocumentoDerivar']);}else{$cNumDocumentoDerivar=$_POST[cCodificacion];}?>
              <input type="text" name="cCodificacion" value="<?php echo trim($cNumDocumentoDerivar)?>" class="FormPropertReg form-control" style="text-transform:uppercase;width:150px" />&nbsp;				</td>
		        </tr>               
       	        <tr>
       	          <td >Origen: </td>
       	          <td colspan="2" align="left">
                  <?
			 if(sqlsrv_has_rows($rsM)>0){
              	$iCodOficinaE=$RsM[iCodOficinaOrigen];
              	$iCodTrabajadorE=$RsM[iCodTrabajadorRegistro];
              	$iCodOficinaR=$RsM[iCodOficinaDerivar];
				$iCodOficinaD=$RsM[iCodOficinaDerivar];
              	$iCodTrabajadorR=$RsM[iCodTrabajadorDerivar];
				$iCodTrabajadorD=$RsM['iCodTrabajadorDelegado'];
              	echo "<input type=hidden name=iCodMov value=".$RsMovOfi[iCodMovimiento].">";
              	echo "<input type=hidden name=iCodOfiE value=".$RsMovOfi[iCodOficinaOrigen].">";
              	echo "<input type=hidden name=iCodTraE value=".$RsMovOfi[iCodTrabajadorRegistro].">";
				echo "<input type=hidden name=iCodOfiR value=".$RsMovOfi[iCodOficinaDerivar].">";
              	echo "<input type=hidden name=iCodTraR value=".$RsMovOfi[iCodTrabajadorDerivar].">";
				echo "<input type=hidden name=iCodTraD value=".$RsMovOfi['iCodTrabajadorDelegado'].">";
              }
							?>
                  <select name="iCodOficinaOrigen" style="width:340px;" class="FormPropertReg form-control" onChange="releer();">
       	            <?
							$sqlOfiO="SP_OFICINA_LISTA_COMBO ";
              $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
                while ($RsOfiO=sqlsrv_fetch_array($rsOfiO)){
						if($_GET[clear]==""){
          					if($RsOfiO["iCodOficina"]==$iCodOficinaE){
          						$selecOfi="selected";
          					}Else{
          						$selecOfi="";
          					}
          			}Else{
          					if($RsOfiO["iCodOficina"]==$_POST[iCodOficinaOrigen]){
          						$selecOfi="selected";
          					}Else{
          						$selecOfi="";
          					}
          			}
                echo "<option value=".$RsOfiO["iCodOficina"]." ".$selecOfi.">".$RsOfiO["cNomOficina"]."</option>";
				}?>
   	              </select></td>
       	          <td >Destino:</td>
       	          <td colspan="2"  align="left"><select name="iCodOficinaDerivar" style="width:340px;" class="FormPropertReg form-control" onChange="releer();" >
       	            <?
							$sqlOfiD="SP_OFICINA_LISTA_COMBO ";
              $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
                while ($RsOfiD=sqlsrv_fetch_array($rsOfiD)){
						if($_GET[clear]==""){
          					if($RsOfiD["iCodOficina"]==$iCodOficinaR){
          						$selecOfiD="selected";
          					}Else{
          						$selecOfiD="";
          					}
          			}Else{
          					if($RsOfiD["iCodOficina"]==$_POST[iCodOficinaDerivar]){
          						$selecOfiD="selected";
          					}Else{
          						$selecOfiD="";
          					}
          			}
				echo "<option value=".$RsOfiD["iCodOficina"]." ".$selecOfiD.">".$RsOfiD["cNomOficina"]."</option>";
				}?>
   	              </select>                  </td>
   	            </tr>
       	        <tr>
       	          <td >Responsable de Envio:</td>
       	          <td colspan="2" align="left">
                  <select name="iCodTrabajadorRegistro" style="width:340px;" class="FormPropertReg form-control" >
                   <option value="">Seleccione:</option>
       	            <?  if($_GET[clear]==""){  $iCodOfiRegistro=$iCodOficinaE; }else {$iCodOfiRegistro=$_POST[iCodOficinaOrigen];}
							$sqlEnv="SELECT iCodTrabajador,cNombresTrabajador,cApellidosTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina =".$iCodOfiRegistro ;
              $rsEnv=sqlsrv_query($cnx,$sqlEnv);
                while ($RsEnv=sqlsrv_fetch_array($rsEnv)){
              	if($_GET[clear]==""){
					if($RsEnv[iCodTrabajador]==$RsM[iCodTrabajadorRegistro]){
              		$selecEnv="selected";
              		}
					else{
              		$selecEnv="";
              	}
				}
			else{
					if($RsEnv[iCodTrabajador]==$_POST[iCodTrabajadorRegistro]){
              		$selecEnv="selected";
              	}Else{
              		$selecEnv="";
              	}
				}
                echo "<option value=".$RsEnv["iCodTrabajador"]." ".$selecEnv.">".$RsEnv["cApellidosTrabajador"]." ".$RsEnv["cNombresTrabajador"]."</option>";
				}?>
   	              </select></td>
       	          <td >Responsable de Recepcion:</td>
       	          <td colspan="2"  align="left"><select name="iCodTrabajadorDerivar" style="width:340px;" class="FormPropertReg form-control" >
                  <option value="">Seleccione:</option>
       	            <?php if($_GET[clear]==""){  $iCodOfiDerivar=$iCodOficinaR; }else {$iCodOfiDerivar=$_POST[iCodOficinaDerivar];}
							$sqlDep2="SELECT iCodTrabajador,cNombresTrabajador,cApellidosTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina =".$iCodOfiDerivar ;
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
                while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
              	if($_GET[clear]==""){
					if($RsDep2[iCodTrabajador]==$RsM[iCodTrabajadorDerivar]){
              		$selecOfi="selected";
              		}
					else{
              		$selecOfi="";
              	}
				}
			else{
					if($RsDep2[iCodTrabajador]==$_POST[iCodTrabajadorDerivar]){
              		$selecOfi="selected";
              	}Else{
              		$selecOfi="";
              	}
				}
                echo "<option value=".$RsDep2["iCodTrabajador"]." ".$selecOfi.">".$RsDep2["cApellidosTrabajador"]." ".$RsDep2["cNombresTrabajador"]."</option>";
				}?>
   	              </select></td>
   	            </tr>
       	        <tr>
		          <td width="93" >Asunto:&nbsp;</td>
		          <td colspan="2" align="left">
                  <textarea name="cAsuntoDerivar" style="width:320px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsM[cAsuntoDerivar]); }Else{ echo $_POST[cAsuntoDerivar];}?></textarea>                  </td>
		          <td width="117" >Observaciones:&nbsp;</td>
		          <td colspan="2"  align="left">
                  <textarea name="cObservacionesDerivar" style="width:320px;height:55px" class="FormPropertReg form-control"><?php if($_GET[clear]==""){ echo trim($RsM[cObservacionesDerivar]); }Else{ echo $_POST[cObservacionesDerivar];}?></textarea>                  </td>
		        </tr>
                <tr>
			<td valign="top"  width="93">Delegado:</td>
			<td colspan="2"><select name="iCodTrabajadorResponsable" style="width:340px;" class="FormPropertReg form-control" >
			  <option value="">Seleccione:</option>
			  <?  if($_GET[clear]==""){  $iCodOfiDelegar=$iCodOficinaD; }else {$iCodOfiDelegar=$_POST[iCodOficinaDerivar];}
			  $sqlTrb="SELECT iCodTrabajador,cNombresTrabajador,cApellidosTrabajador FROM Tra_M_Trabajadores WHERE iCodOficina =".$iCodOfiDelegar;
              $rsTrb=sqlsrv_query($cnx,$sqlTrb);
              while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
				  	if($_GET[clear]==""){
          					if($RsTrb["iCodTrabajador"]==$RsM['iCodTrabajadorDelegado']){
          						$selecTrab="selected";
          					}Else{
          						$selecTrab="";
          					}
          			}Else{
          					if($RsTrb["iCodTrabajador"]==$_POST[iCodTrabajadorResponsable]){
          						$selecTrab="selected";
          					}Else{
          						$selecTrab="";
          					}
          			}
              
                echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
              }
              sqlsrv_free_stmt($rsTrb);
							?>
			  </select></td>
			<td valign="top" >Fecha de Delegacion:</td>
			<td><?
				 if($_GET[clear]==""){ 
				   if(trim($RsM[fFecDelegado])!=""){
				  $fFecDelegado= date("d-m-Y", strtotime($RsM[fFecDelegado]))." ".date("G:i", strtotime($RsM[fFecDelegado]));
				   }
				   else {   $fFecDelegado ="";   }
					 }else{
						  if(trim($_POST[fFecDelegado])!=""){ 
				  $fFecDelegado= date("d-m-Y", strtotime($_POST[fFecDelegado]))." ".date("G:i", strtotime($_POST[fFecDelegado])); 
					 }else{$fFecDelegado ="";}
					 }
				   ?>
                   <input type="txt" name="fFecDelegado" value="<?php echo $fFecDelegado;?>" size="28" class="FormPropertReg form-control"></td>
			<td align="left"><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecDelegado,'dd-mm-yyyy hh:ii',this,true)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>&nbsp;<span class="FormCellRequisito">*</span></div></td>
			    </tr>      
          
             <tr>
		          <td width="93" >Indicaci&oacute;n:&nbsp;</td>
		          <td colspan="2"  align="left"><select name="iCodIndicacion" style="width:250px;" class="FormPropertReg form-control">
					<option value="">Seleccione:</option>
				    <? $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                       $sqlIndic .= "ORDER BY cIndicacion ASC";
                       $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                       while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
				if($_GET[clear]==""){
          			if($RsIndic["iCodIndicacion"]==$RsM[iCodIndicacionDerivar]){
          				$selecIndi="selected";
          			}Else{
          				$selecIndi="";
          			}
          	}Else{
          			if($RsIndic["iCodIndicacion"]==$_POST[iCodIndicacion]){
          				$selecIndi="selected";
          			}Else{
          				$selecIndi="";
          			}          		
          	}         	
                       echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
                       }
                       sqlsrv_free_stmt($rsIndic);
				   ?>  </select></td>
		          <td width="117" >&nbsp;</td>
		          <td colspan="2" align="left" >&nbsp;</td>
		        </tr>   
             <tr>
                  <td colspan="4"  align="center"><button class="btn btn-primary"  type="submit" id="Actualizar"   onMouseOver="this.style.cursor='hand'"> <b>Actualizar</b> <img src="images/page_refresh.png" width="17" height="17" border="0"> </button>��
	<button class="btn btn-primary" onclick="Volver();" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button> </td>
                  <td>                  </td>
                   <td>                  </td>
                </tr>
              
            <?php } ?>
		      </table>
          </div>
		  	  <img src="images/space.gif" width="0" height="0">
	        </fieldset>
        
        
        </form>
      </div>	

<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>