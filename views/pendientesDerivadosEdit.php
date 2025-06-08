<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />

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
                         Derivar Documento : <?=($RsDoc['cCodificacion']??'')?>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

                            <?php
                            if(isset($_GET['iCodMovimientoDerivar'])) {
                                $sqlDoc = " SELECT cCodificacion,* FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And iCodMovimiento='$_GET[iCodMovimientoDerivar]'";
                                $rsDoc = sqlsrv_query($cnx, $sqlDoc);
                                $RsDoc = sqlsrv_fetch_array($rsDoc);
                            }
                            ?>
							<form name="frmConsulta" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="opcion" value="">
							<input type="hidden" name="iCodMovimiento" value="<?=$_GET['iCodMovimientoDerivar']??''?>">
                              <legend class="LnkZonas">Destino de Derivo:</legend>
                              Derivar a:
                               <?php
                                        if($RsDoc['fFecRecepcion']!="" or $RsDoc['fFecRecepcion']!=NULL){
                                         $select="disabled";
                                        }else if($RsDoc['fFecRecepcion']=="" or $RsDoc['fFecRecepcion']==NULL){
                                             $select="";
                                        }?>
                                <select name="iCodOficinaDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." <?php echo $select;?> onchange="releer();" >
                                     <option value="">Seleccione:</option>
                                     <?php
                                        if(isset($_POST['iCodOficinaDerivar'])) {
                                            if ($_POST['iCodOficinaDerivar'] == "") {
                                                $iCodOficinaDerivar = $RsDoc['iCodOficinaDerivar'];
                                            } else {
                                                $iCodOficinaDerivar = $_POST['iCodOficinaDerivar'];
                                            }
                                            $sqlDep2 = "SELECT * FROM Tra_M_Oficinas WHERE iCodOficina!='" . $_SESSION['iCodOficinaLogin'] . "' ORDER BY cNomOficina ASC";
                                            $rsDep2 = sqlsrv_query($cnx, $sqlDep2);
                                            while ($RsDep2 = sqlsrv_fetch_array($rsDep2)) {
                                                if ($RsDep2['iCodOficina'] == $iCodOficinaDerivar) {
                                                    $selecOfi = "selected";
                                                } Else {
                                                    $selecOfi = "";
                                                }
                                                echo "<option value=" . $RsDep2["iCodOficina"] . " " . $selecOfi . ">" . $RsDep2["cNomOficina"] . "</option>";
                                            }
                                            mysql_free_result($rsDep2);
                                        }
                                      ?>
                                 </select>
                                Responsable:
                                <select name="iCodTrabajadorDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." <?php echo $select;?>>
                                   <?php if(($_POST['iCodOficinaDerivar']??'')==""){?>
                                   <option value="">Seleccione Trabajador:</option>
                                   <?php } ?>
                                    <?php
                                        $sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='".($iCodOficinaDerivar??'')."' And nFlgEstado=1 ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
                                        $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                                        while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
                                            if($RsTrb['iCodTrabajador']==$_POST['iCodTrabajadorDerivar'] or $RsTrb['iCodTrabajador']==$RsDoc['iCodTrabajadorDerivar']){
                                                $selecTrab="selected";
                                            }Else{
                                                $selecTrab="";
                                            }
                                          echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                                        }
                                        sqlsrv_free_stmt($rsTrb);
                                    ?>
                                 </select>
                                 Indicación:
                                 <select name="iCodIndicacionDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                     <option value="">Seleccione Indicación:</option>
                                     <?php
                                                $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                                $sqlIndic .= "ORDER BY cIndicacion ASC";
                                $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                    if($RsIndic['iCodIndicacion']==$RsDoc['iCodIndicacionDerivar']){
                                        $selecIndi="selected";
                                    }Else{
                                        $selecIndi="";
                                    }
                                  echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
                                }
                                sqlsrv_free_stmt($rsIndic);
                                                ?>
                                 </select>
                                <legend class="LnkZonas"> <span style="color:#F00; size:14pt">Para derivar con un nuevo documento, cambie el tipo de documento: </span></legend>
                               <select name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." disabled />
                                    <option value="">Seleccione:</option>
                                    <?php
                                            include_once("../conexion/conexion.php");
                                            $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ORDER BY cDescTipoDoc ASC ";
                                $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                    if($RsTipo["cCodTipoDoc"]==$RsDoc['cCodTipoDocDerivar']){
                                        $selecTipo="selected";
                                    }else{
                                        $selecTipo="";
                                    }
                                echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
                                }
                                sqlsrv_free_stmt($rsTipo);
                                            ?>
                               </select>
                               Asunto:
                                  <textarea name="cAsuntoDerivar" style="width:490px;height:55px" class="FormPropertReg form-control"><?=$RsDoc['cAsuntoDerivar']?></textarea>
                                  Observaciones:
                                  <textarea name="cObservacionesDerivar" style="width:490px;height:55px" class="FormPropertReg form-control"><?=$RsDoc['cObservacionesDerivar']?></textarea></td>
                                  <button class="btn btn-primary" onclick="Actualizar();" onMouseOver="this.style.cursor='hand'"> <b>Actualizar</b> <img src="images/icon_derivar.png" width="17" height="17" border="0"> </button>&nbsp;&nbsp;&nbsp;							&nbsp;&nbsp;
							<button class="btn btn-primary" onclick="window.open('pendientesDerivados.php', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Retornar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
			 <fieldset>
	  <legend class="LnkZonas">Activar otros Destinatarios:</legend>	
      <table align="left">				
			<tr>
			<td  valign="top">Copias:</td>
			<td align="left">
				
					<table border=0>
						<tr>
							<td align="center">
								<div class="btn btn-primary" style="width:130px;height:17px;padding-top:4px;">
									<a style=" text-decoration:none" href="pendientesDerivadosOficinasLs.php?iCodMovimientoDerivar=<?=$_GET['iCodMovimientoDerivar']?>&iCodTramite=<?=$RsDoc['iCodTramite']?>&cCodTipoDoc=<?=$RsDoc['cCodTipoDocDerivar']?>" rel="lyteframe" title="Lista de Oficinas" rev="width: 500px; height: 550px; scrolling: auto; border:no">Seleccione Oficinas</a>
								</div>
							</td>
						</tr>
					</table>
				
					<?php
					// selec de copias temporales
					$sqlMovs="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsDoc[iCodTramite]' AND iCodMovimiento!='$_GET[iCodMovimientoDerivar]' AND iCodOficinaOrigen=".$_SESSION['iCodOficinaLogin']." ORDER BY iCodMovimiento ASC";
          			$rsMovs=sqlsrv_query($cnx,$sqlMovs);
					if(sqlsrv_has_rows($rsMovs)>0){
					?>
						<table border=1 width="100%">
							<tr>
								<td class="headColumnas" width="25">De</td>
								<td class="headColumnas" width="350">Oficina</td>
								<td class="headColumnas" width="175">Indicacion</td>
								<td class="headColumnas" width="60">Prioridad</td>
								<td class="headColumnas">X</td>
							</tr>
							<?php
          					while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
							?>
							<tr>
							<td align="center" valign="top">
		    					<?php
		    					$sqlOfO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs[iCodOficinaOrigen]'";
			      				$rsOfO=sqlsrv_query($cnx,$sqlOfO);
			      				$RsOfO=sqlsrv_fetch_array($rsOfO);
		     	 				echo "<a style=text-decoration:none href=javascript:; title=\"".trim($RsOfO['cNomOficina'])."\">".trim($RsOfO['cSiglaOficina'])."</a>";
		    					?>
		    				</td>
							<td align="left" valign="top">
								<?php
								$sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs[iCodOficinaDerivar]'";
	          					$rsOfc=sqlsrv_query($cnx,$sqlOfc);
	          					$RsOfc=sqlsrv_fetch_array($rsOfc);
	          					echo $RsOfc["cNomOficina"];
								?>
							</td>
							<td align="center" valign="top">
								<?php
								$sqlInd="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsMovs[iCodIndicacionDerivar]'";
			          		  	$rsInd=sqlsrv_query($cnx,$sqlInd);
			          		  	$RsInd=sqlsrv_fetch_array($rsInd);
			          		  	echo $RsInd["cIndicacion"];
								?>
							</td>
							<td align="left" valign="top">
								<?=$RsMovs['cPrioridadDerivar']?>
							</td>
							<td align="center" valign="top">
                             <?php if($RsMovs['cFlgTipoMovimiento']==4){ ?>
								<a href="registroData.php?iCodTemp=<?=$RsMovs['iCodMovimiento']?>&opcion=25&iCodMovimientoDerivar=<?=$_GET['iCodMovimientoDerivar']?>&cAsuntoDerivar=<?=$_POST['cAsuntoDerivar']?>&cObservacionesDerivar=<?=$_POST['cObservacionesDerivar']?>" onClick="return ConfirmarBorrado();"><img src="images/icon_del.png" border="0" width="16" height="16"></a>
                                 <?php }?> 
							</td>
							</tr>
							<?php } ?>
						</table>
					<?php } ?>
			</td>
			</tr>									
         </table> 
       </fieldset> 

       <table width="100%">
       		<tr>
				<td>
					<hr style="color:#ccc">
					<h3 style="color:#808080">PASO 1 - ELABORAR DOCUMENTO ELECTRónICO</h3>
					<p style="padding:0px 0px 0px 14px;">
					<a href="javascript:void(0);" class="btn-default1 btn1" style="cursor:not-allowed">Documento electrónico</a>
				    
				    <div class="hiders" style="display:none;padding:0px 0px 0px 14px;" > 
						<textarea name="descripcion" id="descripcion" class="FormPropertReg form-control"><?php echo $_POST['descripcion']??'';?></textarea>
					</div>
					</p>
					<H3 style="color:#808080">PASO 2 - ABRIR FIRMA DIGITAL</H3><input type="button" value="Abrir" onClick="return go()" disabled>
					
					<H3 style="color:#808080">PASO 3 - ADJUNTAR DOCUMENTO</H3>
					<h4 style="color:#808080">Documento electrónico:</h4>
					<input type="file" name="documentoElectronicoPDF" disabled>
					<h4 style="color:#808080">Documento complementario:</h4>
					<input type="file" name="fileUpLoadDigital" disabled/>
					<script>
					</script>
					<p>
						
				</td>
			</tr>
       	</table>
														
							</form>



					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
 <?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<script Language="JavaScript">
    $(document).ready(function() {
        $('.mdb-select').material_select();

    });

    function activaCopias(){
        document.frmConsulta.nFlgCopias.value="1";
        document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>?iCodMovimientoDerivar=<?=$_GET['iCodMovimientoDerivar']?>&clear=1#area";
        document.frmConsulta.submit();
        return false;
    }

    function releer(){
        document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>?iCodMovimientoDerivar=<?=$_GET['iCodMovimientoDerivar']?>&clear=1#area";
        document.frmConsulta.submit();
    }

    function Actualizar()
    {
        document.frmConsulta.action="pendientesData.php";
        document.frmConsulta.opcion.value=6;
        document.frmConsulta.submit();
    }

    function ConfirmarBorrado()
    {
        if (confirm("Desea remover la copia?")){
            return true;
        }else{
            return false;
        }
    }
</script>
</body>
</html>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>