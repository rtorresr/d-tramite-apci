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
			<input name="opcion" value="28" type="hidden">
            
			<input name="iCodMovimientoAccion" value="<?=$_GET[iCodMovimiento]?>" type="hidden">
            <input name="cod" value="<?=$_GET[cod]?>" type="hidden">
            <input type="hidden" name="iCodOficina" value="<?=$_GET['iCodOficina']?>">
			<input name="cCodTipoDoc" value="<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>" type="hidden">
			<input name="iCodOficinaDerivar" value="<?=$_GET[iCodOficinaDerivar]?>" type="hidden">
			<input name="iCodTrabajadorDerivar" value="<?=(isset($_GET['iCodTrabajadorDerivar'])?$_GET['iCodTrabajadorDerivar']:'')?>" type="hidden">
			<input name="cAsuntoDerivar" value="<?=$_GET[cAsuntoDerivar]?>" type="hidden">
			<input name="cObservacionesDerivar" value="<?=$_GET[cObservacionesDerivar]?>" type="hidden">
			<input name="iCodIndicacionDerivar" value="<?=$_GET[iCodIndicacionDerivar]?>" type="hidden">
			<input name="nFlgCopias" value="<?=$_GET[nFlgCopias]?>" type="hidden">
           <?php if ($_GET[iCodMovimientoAccion]!=""){  ?>  
            <input name="iCodMovimientoAccion2" value="<?=((isset($_GET['iCodMovimientoAccion']))?$_GET['iCodMovimientoAccion']:'')?>" type="hidden">
          <?php }
          if ($_GET[iCodMovimientoAccion]==""){ 
            $a=stripslashes($_GET[MovimientoAccion]);
            $MovimientoAccion=unserialize($a);
			$i = 0; 
			foreach ($MovimientoAccion as $v) {
		?>	
        	<input name="iCodMovimientoAccion[]" value="<?=$v?>" type="hidden">
    	<?	$i++;
			}
		}	
		?>
		<tr>
			<td align="center"    width="360">RESPONSABLE</td>
			<td align="center"    width="80">OPCION</td>
		</tr>
		<?
		include_once("../conexion/conexion.php");
		$sqlSel="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina ='$ofi' And iCodTrabajador!='$trab' And nFlgEstado=1 ORDER BY cApellidosTrabajador ASC";
    $rsSel=sqlsrv_query($cnx,$sqlSel);
    while ($RsSel=sqlsrv_fetch_array($rsSel)){
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
    <td align=left><?php echo $RsSel[cApellidosTrabajador].", ".$RsSel[cNombresTrabajador];?></td>
		<td align="center">
				<?
				$sqlAct="SELECT * FROM Tra_M_Tramite_Temporal WHERE iCodTrabajador='$RsSel[iCodTrabajador]' AND cCodSession='$_SESSION[cCodSessionDrv]'";
    		$rsAct=sqlsrv_query($cnx,$sqlAct);
    		if(sqlsrv_has_rows($rsAct)<1){
				?>
                <input type="radio" name="lstRespSel" value="<?=$RsSel[iCodTrabajador]?>" >
				<?php } else{?>
				<input type="radio" name="none" disabled>
				<?php}?>
		</td>
    </tr>
    <?
    }
    sqlsrv_free_stmt($rsSel);
		?>
		<tr>
			<td align="center" colspan="2">
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