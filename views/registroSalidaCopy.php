<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
			if (!isset($_SESSION["cCodSession"])){ 
			  $max_chars=round(rand(10,15));  
				$chars=array();
				for($i="a";$i<"z";$i++){
  				$chars[]=$i;
  				$chars[]="z";
				}
				for ($i=0; $i<$max_chars; $i++){
  				$letra=round(rand(0, 1));
  				if ($letra){ 
 						$clave.= $chars[round(rand(0,count($chars)-1))];
  				}else{ 
 						$clave.= round(rand(0, 9));
  				}
				}
    	$_SESSION["cCodSession"]=$clave;
		}

			
            	
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

<script Language="JavaScript">
<!--

function AddOficina(){
	if (document.frmRegistro.iCodOficinaMov.value.length == "")
  {
    alert("Seleccione Oficina");
    document.frmRegistro.iCodOficinaMov.focus();
    return (false);
  }
	if (document.frmRegistro.iCodTrabajadorMov.value.length == "")
  {
    alert("Seleccione Trabajador");
    document.frmRegistro.iCodTrabajadorMov.focus();
    return (false);
  }
	if (document.frmRegistro.iCodIndicacionMov.value.length == "")
  {
    alert("Seleccione Indicación");
    document.frmRegistro.iCodIndicacionMov.focus();
    return (false);
  }  
  document.frmRegistro.opcion.value=24;
  document.frmRegistro.action="registroData.php";
  document.frmRegistro.submit();
}

function releer(){
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?iCodTramite=<?=$_GET[iCodTramite]?>&URI=<?=$_GET[URI]?>&clear=1#area";
  document.frmRegistro.submit();
}

//--></script>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
<body>
 

	<?php include("includes/menu.php");?>
	<a name="area"></a>


		<?
		include_once("../conexion/conexion.php");
		$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
		$Rs=sqlsrv_fetch_array($rs);
		?>
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

<div class="AreaTitulo">Copia a Oficina</div>	
  <table class="table">
			<form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
			<input type="hidden" name="opcion" value="">
      <input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
      <input type="hidden" name="pag" value="<?=$_REQUEST[pag]?>">
			<input type="hidden" name="URI" value="<?=$_GET[URI]?>">
      <input type="hidden" name="iCodIndicacionMov" value="3">
      <input type="hidden" name="cPrioridadMov" value="Media">
           
			<?
      if($_REQUEST[pag]=="1"){
				$rtn = "consultaSalidaGeneral.php";
			} else if($_REQUEST[pag]=="2"){
				$rtn = "consultaSalidaOficina.php";
			} 
			?>
		<tr>
		<td class="FondoFormRegistro">
			<table border="0">
			<tr>
			<td valign="top"  width="160">N&ordm; Documento:</td>
			<td width="266" valign="top"  style="font-size:16px;color:#00468C"><b><?=$Rs[cCodificacion]?></b></td>
      <td width="138" align="right"   colpsan="1"><!--Copia : //--></td> 
      <!-- <td width="173" align="left" colpsan="1">
      	<div onClick="window.open('registroSalidaHojasDeRuta_pdf.php?cCodificacion=<?=trim($Rs[cCodificacion])?>&iCodTramite=<?=trim($Rs[iCodTramite])?>','_blank')"  onMouseOver="this.style.cursor='hand'"><img src=images/icon_print.png border=0 width=16 height=16 alt="Copia Informativa">
      	</div>
      </td> -->
		</tr>
			
				<?php if($_POST[radioSeleccion]==1){?>
					 <script language="javascript" type="text/javascript">
					 	activaMultiple();
					 </script>
				<?php}?>
				<?php if($_POST[radioSeleccion]==2){?>
					 <script language="javascript" type="text/javascript">
					 	activaRemitente();
					 </script>
				<?php}?>
              <tr>
			<td valign="top" >&nbsp;</td>
	    <td colspan="4" align="left">
					<table border=1>
					<tr>
					<td>
							<select name="iCodOficinaMov" style="width:260px;" class="FormPropertReg form-control" onChange="releer();">
							<option value="">Seleccione Oficina:</option>
							<?
							$sqlDep2="SP_OFICINA_LISTA_COMBO";
              $rsDep2=sqlsrv_query($cnx,$sqlDep2);
              while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
              	if($RsDep2['iCodOficina']==$_POST[iCodOficinaMov]){
              		$selecOfi="selected";
              	}Else{
              		$selecOfi="";
              	}
                echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
              }
              mysql_free_result($rsDep2);
							?>
							</select>
					</td>
					<td>
							<select name="iCodTrabajadorMov" style="width:200px;" class="FormPropertReg form-control">
							<?php if($_POST[iCodOficinaMov]==""){?>
							<option value="">Seleccione Trabajador:</option>
							<?php}?>
							<?
							$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='$_POST[iCodOficinaMov]' And (iCodPerfil=3 or iCodPerfil=5 ) ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
              $rsTrb=sqlsrv_query($cnx,$sqlTrb);
              while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              	if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorMov]){
              		$selecTrab="selected";
              	}Else{
              		$selecTrab="";
              	}
                echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
              }
              sqlsrv_free_stmt($rsTrb);
							?>
							</select>
					</td>
					
					<td>
							<input name="button" type="button" class="btn btn-primary" value="A�adir" onclick="AddOficina();">
					</td>
					</tr>

					<tr>
					<td class="headColumnas" width="200">Oficina</td>
					<td class="headColumnas" width="200">Trabajador</td>
					<td class="headColumnas" width="60">Opci&oacute;n</td>
					</tr>
					<?
					$sqlMovs="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$_GET[iCodTramite]' AND cFlgOficina=1 ORDER BY iCodMovimiento ASC";
          $rsMovs=sqlsrv_query($cnx,$sqlMovs);
          $ContarMov=1;
          while ($RsMovs=sqlsrv_fetch_array($rsMovs)){
					?>
					<tr bgcolor="#FFE8E8">
					<td align="left">
					<?
					$sqlOfc="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsMovs[iCodOficinaDerivar]'";
          $rsOfc=sqlsrv_query($cnx,$sqlOfc);
          $RsOfc=sqlsrv_fetch_array($rsOfc);
          echo $RsOfc["cNomOficina"];
					?>
					</td>

					<td align="left">
						<?
						$sqlTra="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsMovs[iCodTrabajadorDerivar]' ";
            $rsTra=sqlsrv_query($cnx,$sqlTra);
						$RsTra=sqlsrv_fetch_array($rsTra);
            echo $RsTra["cNombresTrabajador"]." ".$RsTra["cApellidosTrabajador"];
						?>
					</td>
					  <td align="center">
						<a href="registroData.php?iCodMovimiento=<?=$RsMovs[iCodMovimiento]?>&iCodTramite=<?=$_GET[iCodTramite]?>&opcion=22&pag=<?=$_REQUEST[pag]?>&URI=<?=$_GET[URI]?>"><img src="images/icon_del.png" border="0" width="16" height="16"></a>
					</td>
					</tr>
					<?
          }
					?>
		
					</table>
			</td>
			</tr>   	
			<tr>
			<td colspan="4"> 
           
				<button class="btn btn-primary" type="button" onclick="window.open('<?=$rtn?>', '_self'); return false;" onMouseOver="this.style.cursor='hand'"> <b>Retornar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
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
  <?php include("includes/userinfo.php"); ?> <?php include("includes/pie.php"); ?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>