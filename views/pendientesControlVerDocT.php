<?php 
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
function sendValue (s){
var selvalue = s.value;
window.opener.document.getElementById('cReferencia').value = selvalue;
window.close();
}
//  End -->
</script>
</head>
<body>
 
<table width="450" height="250" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
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
	Detalles del Documento:
</div>	
		<table width="400" border="0" cellpadding="2" cellspacing="3">
		<?php
		  include_once("../conexion/conexion.php");
      $iCodTramite = (int)($_GET["iCodTramite"]);
		  $sql = "SELECT Tra_M_Tramite.iCodTramite
                    ,cDescTipoDoc
                    ,Tra_M_Tramite.cCodificacion
                    ,fFecRegistro
                    ,cAsunto
                    ,Tra_M_Tramite.cObservaciones,
                    Tra_M_Tramite.cCodTipoDoc ";
      $sql.=" FROM Tra_M_Tramite LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc LEFT OUTER JOIN Tra_M_Trabajadores ON "; 
      $sql.=" Tra_M_Tramite.iCodTrabajadorRegistro=Tra_M_Trabajadores.iCodTrabajador WHERE Tra_M_Tramite.nFlgTipoDoc=2 AND Tra_M_Tramite.nFlgClaseDoc=2 And iCodTramite= '$iCodTramite' ";
      $rsRem = sqlsrv_query($cnx,$sql);
	    $RsRem = sqlsrv_fetch_array($rsRem);
		?>
		
  	<tr>
    <td width="120" align="right" >Fecha de Registro:&nbsp;</td>
		<td align="left"><?=date("d-m-Y", strtotime($RsRem['fFecRegistro']))?></td>
    </tr>
     		
    <tr>
      <td align="right" >Documento:</td>
      <td align=left>
        <?	echo $RsRem[cCodificacion]; 	  ?>
        </td>
    </tr>
    <tr>
    <td width="120" align="right" >Tipo Documento:&nbsp;</td>
    <td align=left>
    	<?php echo $RsRem['cDescTipoDoc'];?>
    </td>
  	</tr>
    <tr>
    <td width="120" align="right" valign="top" >Asunto:&nbsp;</td>
		<td align="left"><?=$RsRem['cAsunto']?></td>
    </tr>

  	<tr>
    <td width="120" align="right" valign="top" >Observaciones:&nbsp;</td>
		<td align="left"><?=$RsRem[cObservaciones]?></td>
    </tr>

  	<tr>
    <td width="120" align="right" >Digital:&nbsp;</td>
		<td align="left">
		    	<?
    			$sqlDw="SELECT TOP 1 * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$RsRem[iCodTramite]'";
      		$rsDw=sqlsrv_query($cnx,$sqlDw);
      		if(sqlsrv_has_rows($rsDw)>0){
      			$RsDw=sqlsrv_fetch_array($rsDw);
      			if($RsDw["cNombreNuevo"]!=""){
				 			if (file_exists("../cAlmacenArchivos/".trim($RsDw["cNombreNuevo"]))){
								echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
							}
						}
      		}Else{
      			echo "<img src=images/space.gif width=16 height=16 border=0>";
      		}
    			?>
				
		</td>
    </tr>
						
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