<?php header('Content-Type: text/html; charset=UFT-8');
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<SCRIPT LANGUAGE="JavaScript">
function sendValue (s){
var selvalue1 = s.value;
window.opener.document.getElementById('cCodificacion').value = selvalue1;
window.close();
}
</script>
</head>
<body>

<div class="container">

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

<div class="AreaTitulo">Seleccione Tr&aacute;mite:</div>	
	<table width="100%" border="1" cellpadding="0" cellspacing="3">
		<form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
			<tr>
				<td align="left">
					<table width="100%">
						<tr>
							<td width="20%">Nro Documento:</td>
							<td width="30%">Desde:</td>
							<td width="10%"></td>
							<td width="30%">Hasta:</td>
							<td width="10%"></td>
						</tr>
						<tr>
							<td width="20%">
								<input type="text" name="nNumDocumento" value="<?=$_GET['nNumDocumento']?>"></td>	
							</td>
							<?php
								if(trim($_REQUEST[fDesde])==""){$fecini = $_REQUEST[fDesde];}else{ $fecini = $_REQUEST[fDesde]; }
								if(trim($_REQUEST[fHasta])==""){$fecfin = $_REQUEST[fHasta];}else{ $fecfin = $_REQUEST[fHasta]; }
							?>
							<td width="20%">
								<input type="text" readonly name="fDesde" value="<?=$fecini?>" style="width:105px" class="FormPropertReg form-control">
							</td>
							<td width="10%" align="left">
								<div class="boton" style="width:24px;height:20px">
									<a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,true)">
										<img src="images/icon_calendar.png" width="22" height="20" border="0">
									</a>
								</div>
							</td>

							<td width="20%">
								<input type="text" readonly name="fHasta" value="<?=$fecfin?>" style="width:105px" class="FormPropertReg form-control">
							</td>
							<td width="10%">
								<div class="boton" style="width:24px;height:20px">
									<a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,true)">
										<img src="images/icon_calendar.png" width="22" height="20" border="0"></a>
								</div>
							</td>

							<td width="20%">
								<input type="submit" class="btn btn-primary" name="buscar" value="Buscar">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</form>
		<tr>
			<td align="center"    width="560">N&ordm; TR&Aacute;MITE &nbsp;&nbsp;&nbsp;</td>
			<td align="center"    width="70">OPCION</td>
		</tr>
		<?php
			include_once("../conexion/conexion.php");
			if (empty($_GET["buscar"])) {
				$sqlRem = "SELECT cCodificacion FROM Tra_M_Tramite 
						   WHERE cCodificacion<>'' 
						   ORDER BY fFecRegistro DESC";
			}

			if (!empty($_GET["buscar"]) AND !empty($_GET["nNumDocumento"])) {
				$sqlRem = "SELECT cCodificacion FROM Tra_M_Tramite 
						   WHERE cCodificacion LIKE '%$_GET['nNumDocumento']%' AND cCodificacion<>'' 
						   ORDER BY fFecRegistro DESC";
			}

			if (!empty($_GET["buscar"]) AND !empty($_GET["fDesde"]) AND !empty($_GET["fHasta"])) {
				$sqlRem = "SELECT cCodificacion FROM Tra_M_Tramite 
						   WHERE cCodificacion<>'' AND fFecRegistro BETWEEN '$_GET['fDesde']' AND '$_GET['fHasta']' 
						   ORDER BY fFecRegistro DESC";
			}
    		$rsRem = sqlsrv_query($cnx,$sqlRem);
    		while ($RsRem = sqlsrv_fetch_array($rsRem)){
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
    		<td width="560" align="center" style="font-family:'Arial Narrow';font-size:11px">
    			<?php echo $RsRem["cCodificacion"]; ?>
    		</td>
			<form name="selectform">
    			<td width="70">
    				<input name="cCodificacion" value="<?=trim($RsRem["cCodificacion"])?>" type="hidden">
					<input type=button value="seleccione" class="btn btn-primary" style="font-size:8px" onClick="sendValue(this.form.cCodificacion);">
    			</td>
    		</form>
    	</tr>
    <?php
    }
    sqlsrv_free_stmt($rsRem);
	?>
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

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>