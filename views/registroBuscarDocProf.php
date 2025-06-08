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
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function sendValue (s,t,x,y,z,w){
var selvalue = s.value;	
var selvalue2 = t.value;
var selvalue3 = x.value;	
var selvalue4 = y.value;
var selvalue5 = z.value;
var selvalue6 = w.value;	
window.opener.document.getElementById('iCodTramiteRespuesta').value = selvalue;
window.opener.document.getElementById('iCodTramiteRep').value = selvalue2;
window.opener.document.getElementById('cCodTipoDocResponder').value = selvalue3;
window.opener.document.getElementById('cAsuntoResponder').value = selvalue4;
window.opener.document.getElementById('cObservacionesResponder').value = selvalue5;
window.opener.document.getElementById('cDescTipoDoc').value = selvalue6;
window.close();
}
//  End -->
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

<div class="AreaTitulo">
	Seleccione Documento:
</div>	
		<table width="100%" border="1" cellpadding="0" cellspacing="3">
			<form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
		<tr>
			<td align="left" colspan="3">
			Documento: <input type="text" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="30">
			Tipo Doc:<select name="cCodTipoDocResponder" class="FormPropertReg form-control" style="width:220px">
									<option value="">Seleccione:</option>
									<?
									include_once("../conexion/conexion.php");
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 ORDER BY cDescTipoDoc ASC";
          				$rsTipo=sqlsrv_query($cnx,$sqlTipo);
          				while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
          					if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
          						$selecTipo="selected";
          					}Else{
          						$selecTipo="";
          					}
          				echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
          				}
          				sqlsrv_free_stmt($rsTipo);
									?>
									</select>&nbsp;&nbsp;
			<input type="submit" class="btn btn-primary" name="buscar" value="Buscar">
			</td>
		</tr>
			</form>
		<tr>
			<td align="center"    width="320">TIPO DOCUMENTO</td>
			<td align="center"    width="180">REGISTRO N�</td>
			<td align="center"    width="80">OPCION</td>
		</tr>
		<?
		if($_GET[buscar]!=""){
		include_once("../conexion/conexion.php");
		$sql= "SP_CONSULTA_INTERNO_TRABAJADOR_PERSONAL '$fDesde', '$fHasta',  '$_GET[SI]', '$_GET[NO]',  '%".$_GET['cCodificacion']."%', '%".$_GET['cAsunto']."%',  '%$_GET[cObservaciones]%', '$_GET[cCodTipoDocResponder]','".$_SESSION['CODIGO_TRABAJADOR']."', '$campo', '$orden' ";
    $rsRem=sqlsrv_query($cnx,$sql);
		
    //echo $sqlRem;
    while ($RsRem=sqlsrv_fetch_array($rsRem)){
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
    <td align=left>
    	<?php echo $RsRem['cDescTipoDoc'];?>
    </td>
    <td align="center"><?=trim($RsRem["cCodificacion"])?></td>
			<form name="selectform">
		<td align="center">
			<input name="cCodificacion" 	value="<?=trim($RsRem["cCodificacion"])?>" type="hidden">
            <input name="iCodTramiteRep" 	value="<?=trim($RsRem["iCodTramite"])?>" type="hidden">
            <input name="cCodTipoDoc" 		value="<?=trim($RsRem["cCodTipoDoc"])?>" type="hidden">
            <input name="cAsunto" 			value="<?=trim($RsRem["cAsunto"])?>" type="hidden">
            <input name="cObservaciones" 	value="<?=trim($RsRem["cObservaciones"])?>" type="hidden">
            <input name="cDescTipoDoc" 		value="<?=trim($RsRem["cDescTipoDoc"])?>" type="hidden">
    	<input type=button value="seleccione" class="btn btn-primary" style="font-size:8px" onClick="sendValue(this.form.cCodificacion,this.form.iCodTramiteRep,this.form.cCodTipoDoc,this.form.cAsunto,this.form.cObservaciones,this.form.cDescTipoDoc);">
		</td>
			</form>
    </tr>
    <?
    }
    sqlsrv_free_stmt($rsRem);
}
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

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>