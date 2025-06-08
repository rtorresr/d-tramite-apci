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

<table width="440" height="300" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
<tr>
<td align="left" valign="top">

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
	Seleccione Oficina:
</div>	
		<table width="100%" border="1" cellpadding="0" cellspacing="3">
			<form method="POST" name="formulario" action="registroData.php" target="_parent">
			<input name="opcion" value="26" type="hidden">
			<input name="iCodMovimientoDerivar" value="<?=$_GET[iCodMovimientoDerivar]?>" type="hidden">
			<input name="iCodTramite" value="<?=$_GET[iCodTramite]?>" type="hidden">
			<?
			include_once("../conexion/conexion.php");
	 		$sqlDoc="SELECT * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite AND Tra_M_Tramite_Movimientos.iCodMovimiento='$_GET[iCodMovimientoDerivar]'";
	 		$rsDoc=sqlsrv_query($cnx,$sqlDoc);
	 		$RsDoc=sqlsrv_fetch_array($rsDoc);
			?>
			<input name="cCodTipoDoc" value="<?=$RsDoc[cCodTipoDocDerivar]?>" type="hidden">
			<input name="nFlgTipoDoc" value="<?=$RsDoc[nFlgTipoDoc]?>" type="hidden">
			<input name="cAsuntoDerivar" value="<?=$RsDoc[cAsuntoDerivar]?>" type="hidden">
			<input name="cObservacionesDerivar" value="<?=$RsDoc[cObservacionesDerivar]?>" type="hidden">
			
		<tr>
			<td align="center"    width="360">OFICINA</td>
			<td align="center"    width="80">OPCION</td>
		</tr>
		<?
		$sqlOfic="SELECT * FROM Tra_M_Oficinas WHERE iFlgEstado=1 ORDER BY cNomOficina ASC";
    $rsOfic=sqlsrv_query($cnx,$sqlOfic);
    while ($RsOfic=sqlsrv_fetch_array($rsOfic)){
    if ($color == "#e8f3ff"){
			$color = "#FFFFFF";
	  }else{
			$color = "#e8f3ff";
	  }
	  if ($color == ""){
			$color = "#FFFFFF";
	  }
		?>
    <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF';" onMouseOut="this.style.backgroundColor='<?=$color?>'">
    <td align=left><?=$RsOfic[cNomOficina]?></td>
		<td align="center">
				<?
				$sqlAct="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodOficinaDerivar='$RsOfic['iCodOficina']' AND iCodTramite='$_GET[iCodTramite]' AND cFlgTipoMovimiento=4";
				$rsAct=sqlsrv_query($cnx,$sqlAct);
				//echo $sqlAct;
    		if(sqlsrv_has_rows($rsAct)<1){
				?>
				<input type="checkbox" name="lstOficinasSel[]" value="<?=$RsOfic['iCodOficina']?>">
				<?php } else{?>
				<input type="checkbox" name="none" disabled>
				<?php}?>
		</td>
    </tr>
    <?
    }
    sqlsrv_free_stmt($rsOfic);
		?>
		<tr>
			<td>
					<select name="iCodIndicacionSel" style="width:220px;" class="FormPropertReg form-control">
					<option value="">Seleccione Indicación:</option>
					<?
					$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
      		$sqlIndic .= "ORDER BY cIndicacion ASC";
      		$rsIndic=sqlsrv_query($cnx,$sqlIndic);
      		while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
      			if($RsIndic[iCodIndicacion]==3){
      				$selecIndi="selected";
      			}Else{
      				$selecIndi="";
      			}              	
      		  echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>\n";
      		}
      		sqlsrv_free_stmt($rsIndic);
					?>
					</select>
					
					<select name="cPrioridad" class="size9" style="width:100;background-color:#FBF9F4">
          <option <?php if($_POST[cPrioridad]=="Alta") echo "selected"?> value="Alta">Alta</option>
          <option <?php if($_POST[cPrioridad]=="Media") echo "selected"?> value="Media" selected>Media</option>
          <option <?php if($_POST[cPrioridad]=="Baja") echo "selected"?> value="Baja">Baja</option>
          </select>				
			</td>
			<td align="center">
				<input type="submit" value="Enviar" class="btn btn-primary">
			</td>
		</tr>
		</form>
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