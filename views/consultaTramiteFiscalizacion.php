<? 
   
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaTramiteTupa.php
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
require("core.php");
$p_bcType = 1;
$p_text = $_POST[iCodPaquete];
$p_textEnc = $_POST[iCodPaquete];
$p_xDim = 1;
$p_w2n = 3;
$p_charHeight = 50;
$p_charGap = $p_xDim;
$p_type = 2;
$p_label = "N";
$p_checkDigit = "N";
$p_rotAngle = 0;
$fFechaHora=date("d-m-Y  h:i");
$dest = "wrapper.php?p_bcType=$p_bcType&p_text=$p_textEnc" . 
				"&p_xDim=$p_xDim&p_w2n=$p_w2n&p_charGap=$p_charGap&p_invert=$p_invert&p_charHeight=$p_charHeight" .
				"&p_type=$p_type&p_label=$p_label&p_rotAngle=$p_rotAngle&p_checkDigit=$p_checkDigit"
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
  document.frmGenerador.busqueda.value=1;
  document.frmGenerador.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmGenerador.submit();
}

function Guardar()
{
  document.frmGuardar.opcion.value=1;
  document.frmGuardar.method="POST";
  document.frmGuardar.action="consultaTramiteData.php";
  document.frmGuardar.submit();
}

function Excel()
{
  document.frmGuardar.method="POST";
  document.frmGuardar.action="consultaTramiteFiscalizacion_xls.php";
  document.frmGuardar.target="_blank"
  document.frmGuardar.submit();
}

function PDF()
{
  document.frmGuardar.method="POST";
  document.frmGuardar.action="consultaTramiteFiscalizacion_pdf.php";
  document.frmGuardar.target="_blank"
  document.frmGuardar.submit();
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

<div class="AreaTitulo">Generar Documentos Aleatorios</div>




							<form name="frmGenerador" method="POST" action="consultaTramiteTupa.php" >
							<input type="hidden" name="busqueda" value="">
						<tr>
							<td width="76" >Desde:</td>
							<td width="303" align="left">

									<td><input type="text" readonly name="fDesde" value="<?=$_POST[fDesde]?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									<td width="20"></td>
									<td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=$_POST[fHasta]?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
									</tr></table>							</td>
						    <td width="12" align="left">&nbsp;</td>
						    <td width="66" align="left" >Oficina:</td>
						    <td width="495" align="left"> 
                   <select name="iCodTupa" class="FormPropertReg form-control" style="width:360px" />
					<option value="">TODOS</option>
					<? 
					$sqlTupa="SELECT * FROM Tra_M_Tupa ";
                    $sqlTupa.="ORDER BY iCodTupa ASC";
                    $rsTupa=sqlsrv_query($cnx,$sqlTupa);
                    while ($RsTupa=sqlsrv_fetch_array($rsTupa)){
          	        if($RsTupa["iCodTupa"]==$_POST['iCodTupa']){
          		    $selecTupa="selected";
          	        } Else{
          		    $selecTupa="";
          	        }
                    echo "<option value=".$RsTupa["iCodTupa"]." ".$selecTupa.">".$RsTupa["cNomTupa"]."</option>";
                    }
                    sqlsrv_free_stmt($rsTupa);
					?>
					</select></td>
						</tr>

						<tr>
                         
							<td height="38" colspan="5" align="right">
							<button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Generar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
							�
							
							<button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>
                            �
                            <?php if($_POST[busqueda]==1){?>
							<button class="btn btn-primary" onclick="Guardar();" onMouseOver="this.style.cursor='hand'"> <b>Guardar</b> <img src="images/icon_rec.png" width="17" height="17" border="0"> </button>
							<?php}?>
                            &nbsp;
                            <button class="btn btn-primary" onclick="Excel();" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
							�
							<button class="btn btn-primary" onclick="PDF();" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>						  </td>
						</tr>
							</form>
						</table>
			</fieldset>





<?
if($_POST[busqueda]==1){
?>
<form name="frmGuardar">
<input type="hidden" name="opcion" value="">
<input type="hidden" name="fHasta" value="<?=$_POST[fHasta]?>">
<input type="hidden" name="fDesde" value="<?=$_POST[fDesde]?>">
<?	
	  if ($fDesde!=''){$fDesde=date("Ymd", strtotime($_POST[fDesde]));}
      if($_POST[fHasta]!=""){
 	$fHasta=date("d-m-Y", strtotime($_POST[fHasta]));
	function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
    $date_r = getdate(strtotime($date));
    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
    return $date_result;
				}
	$fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
	}
	
	//////////////
	 $totalreg=$total;
	 echo  $totalreg;
	 ////////////
	 if($_POST['iCodTupa']==""){	
		$sqltupa=" SP_TUPA_LISTA_COMBO ";
		$rstupa=sqlsrv_query($cnx,$sqltupa);
	  } else{
	  	$sqltupa= "SP_TUPA_LISTA_AR  '$_POST['iCodTupa']' ";
		$rstupa=sqlsrv_query($cnx,$sqltupa);
	  }		
	  
		$numrowstupa=sqlsrv_has_rows($rstupa);
		
		//echo  $numrowstupa; echo "<br>";
		for ($i=1;$i<=$numrowstupa;$i++){
		   
		    while($Rstupa=sqlsrv_fetch_array($rstupa)){
			  $sqltra=" SP_CONSULTA_FISCALIZACION_TUPA_LISTA '$fDesde', '$fHasta', '".$Rstupa['iCodTupa']."' ";
			  $rstra=sqlsrv_query($cnx,$sqltra);
			  $registro_por_tupa=sqlsrv_has_rows($rstra);
			  
			  if($registro_por_tupa<=500){
			    $x=ceil(0.1*$registro_por_tupa);
			  }
			  if($registro_por_tupa>500 and $registro_por_tupa<=2500 ){
			    $x=50;
			  }
			  if($registro_por_tupa>2500){
			    $x=ceil(sqrt($registro_por_tupa));
			  }
			 // echo $registro_por_tupa;  echo "-".$Rstupa['iCodTupa']." - "; echo $x;echo "<br>";
			 $sql="SP_CONSULTA_FISCALIZACION '$_GET['fDesde']', '$fHasta','".$x."','".$Rstupa['iCodTupa']."'";
    	    $rs=sqlsrv_query($cnx,$sql);
	//  echo $sql;
	  
	  
	  if($registro_por_tupa!=0){
	  
	echo "SUBTOTAL DE REGISTROS PROCESADOS : ".$registro_por_tupa; 
	echo "<br>";
 	echo "SUBTOTAL DE REGISTROS SELECCIONADOS: ".$x;
	$totalproces=$totalproces+$x;
	$totalselect=$totalselect+$registro_por_tupa;
	
 ?> 
     <table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
<tr>
	<td width="98" class="headCellColum">Nro Documento</td>
  <td width="92" class="headCellColum">Fecha de Registro</td>
	<td width="142" class="headCellColum">Oficina</td>
	<td width="250" class="headCellColum">Procedimiento TUPA</td> 
	<td width="84" class="headCellColum">N� de Dias Programados</td>
  <td width="84" class="headCellColum">N� de Dias Ejecutados</td>
  <td width="92" class="headCellColum">Estado</td>
  <td width="83" class="headCellColum">Resultado</td>
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
 		<td valign="top" align="center">
 			<input type="hidden" name="iCodTramite[]" value="<?=$Rs[iCodTramite]?>">
    	<a href="registroDetalles.php?iCodTramite=<?=$Rs[iCodTramite]?>"  rel="lyteframe" title="Detalle del Documento" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$Rs[cCodificacion]?></a>
    </td>
    <td valign="top" align="center"><?
    	echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
      echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
      ?>
    </td>
    <td width="142" valign="top" align="justify"><?=$Rs[cNomOFicina]?></td> 
    <td width="250" valign="top" align="justify"><?=$Rs[cNomTupa]?></td>
    <td valign="top" align="center"><?=$Rs[nDias]?> </td>
    <td valign="top" align="center"><? 
	        if($Rs[nFlgEstado]==1){
					echo $Rs[Proceso];
					}
				  else if($Rs[nFlgEstado]==2){
					echo $Rs[Proceso];
					}
				  else if($Rs[nFlgEstado]==3){
					$sqlFin="  SP_CONSULTA_FISCALIZACION_FIN '$Rs[iCodTramite]'";
				$rsFin=sqlsrv_query($cnx,$sqlFin);
				$RsFin=sqlsrv_fetch_array($rsFin);
				$fFecFinalizar=date("Ymd",strtotime($RsFin[fFecFinalizar]));
				$sqlDate=" SP_CONSULTA_FISCALIZACION_REPORTE '$Rs[iCodTramite]','$fFecFinalizar'";
				$rsDate=sqlsrv_query($cnx,$sqlDate);
				$RsDate=sqlsrv_fetch_array($rsDate);
					echo $RsDate[proceso2];
					} 
				   
				   ?></td>
    <td valign="top" align="center">
	            <?php
    if($Rs[nFlgEstado]==1){
					echo "<div style='color:#005E2F'>PENDIENTE</div>";
					}
					else if($Rs[nFlgEstado]==2){
					echo "<div style='color:#0154AF'>EN PROCESO</div>";
					}
					else if($Rs[nFlgEstado]==3){
					echo "FINALIZADO";
						$sqlFinTxt="SELECT * FROM Tra_M_Tramite_Movimientos WHERE nEstadoMovimiento=5 AND iCodTramite='$Rs[iCodTramite]'";
						$rsFinTxt=sqlsrv_query($cnx,$sqlFinTxt);
			            $RsFinTxt=sqlsrv_fetch_array($rsFinTxt);
			            echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsFinTxt[fFecFinalizar]))."</div>";
						echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsFinTxt[fFecFinalizar]))."</div>";	
					}
				?>
    </td>
    <td valign="top" align="center">
    		<?
    		if($Rs[Proceso] > $Rs[nDias] and $Rs[nSilencio]==1 and $Rs[nFlgEstado]!=3){ 
	  		  echo "<div style='color:#950000'>VENCIDO</div>"; 
					echo "<div style='color:#950000'>SAP</div>";
				}
				else if($Rs[Proceso] > $Rs[nDias] and $Rs[nSilencio]==0 and $Rs[nFlgEstado]!=3){
					echo "<div style='color:#950000'>VENCIDO</div>"; 
					echo "<div style='color:#950000'>SAN</div>"; 
				}
				else if($RsDate[proceso2] > $Rs[nDias] and $Rs[nSilencio]==1  and $Rs[nFlgEstado]==3){ 
	  		  echo "<div style='color:#950000'>VENCIDO</div>"; 
					echo "<div style='color:#950000'>SAP</div>";
				}
				else if($RsDate[proceso2] > $Rs[nDias] and $Rs[nSilencio]==0  and $Rs[nFlgEstado]==3){
					echo "<div style='color:#950000'>VENCIDO</div>"; 
					echo "<div style='color:#950000'>SAN</div>"; 
				}
				?>
		</td>
 </tr>
  
<?
}
?> 
</table>
	  
	  <?
		    }
	else {
			$totalproces==0;
			$totalselect==0;	
	}
		  }  
		}
	 echo "TOTAL DE REGISTROS SELECCIONADOS: ".$totalselect;
	 echo "<br>";
	 echo "TOTAL DE REGISTROS PROCESADOS : ".$totalproces;	  
?>


</form>
<?php }?>

<?php if($_POST[iCodPaquete]!=""){?>

<br><br><br>
<div class="AreaTitulo">Paquete registrado</div>
<table class="table">
<tr>

<br>
					<table align="center" cellpadding="3" cellspacing="3" border="0">
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:12px;font-family:arial"><b>SITDD</b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;"><img src="<?php echo $dest;?>" ALT="<?php echo strtoupper($p_text); ?>" width="220" height="30"></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:19px;font-family:arial">PAQUETE N&ordm;:&nbsp;<?=$_POST[iCodPaquete]?></i></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:13px;font-family:arial">FECHA Y HORA:&nbsp;<b><?=$fFechaHora?></b></td></tr>
					<tr><td align="center" style="border-right:1px solid #043D75;border-left:1px solid #043D75;border-top:1px solid #043D75;border-bottom:1px solid #043D75;font-size:17px;font-family:arial"><b>sitdd.apci.gob.pe</b></td></tr>
					</table>
&nbsp;
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<?php}?>
  
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/userinfo.php");?>
<?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>