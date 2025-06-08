<?
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

<table width="410" height="75" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff">
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
                         <div class="AreaTitulo">Edición de Sub Menu:</div>
                     </div>
                      <!--Card content-->
                     <div class="card-body">


		<table border="0" width="430" height="320" cellpadding="0" cellspacing="3">
		<tr>
		<td align="left" width="215" valign="top">
			<fieldset><legend>Añadidos:</legend>
					<table width="100%">
					<?
					require_once("../conexion/conexion.php");
  				$sqlSm= "SELECT * FROM Tra_M_Menu_Items,Tra_M_Menu_Lista WHERE Tra_M_Menu_Items.iCodSubMenu=Tra_M_Menu_Lista.iCodSubMenu AND Tra_M_Menu_Lista.iCodMenu='$_GET[iCodMenu]' ORDER BY Tra_M_Menu_Lista.nOrden ASC";
					$rsSm=sqlsrv_query($cnx,$sqlSm);
					while ($RsSm=sqlsrv_fetch_array($rsSm)){
						echo "<tr><td bgcolor=".$RsSm[cCodColor]."><li>".$RsSm[cNombreSubMenu]."</td><td><a href=../models/ad_menuOpciones_data.php?opcion=3&iCodMenu=".$_GET[iCodMenu]."&iCodMenuLista=".$RsSm[iCodMenuLista]."><img src=images/icon_del.png width=16 height=16 border=0></a></td></tr>";
					}
  				?>
  				</table>
  	</fieldset>
  				<br>
  				<table>
  				<tr><td width="100" bgcolor="#DFFFDF">Registros</td></tr>
  				<tr><td width="100" bgcolor="#CAE4FF">Maestras</td></tr>
  				<tr><td width="100" bgcolor="#FFFFD2">P.Control</td></tr>
  				<tr><td width="100" bgcolor="#E2E2F1">Reportes</td></tr>
  				<tr><td width="100" bgcolor="#E4E4E4">Profesionales</td></tr>
  				<tr><td width="100" bgcolor="#FFCBB3">Consultas</td></tr>
					</table>
		</td>
		<td align="left" width="215" valign="top">
			<fieldset><legend>Disponibles:</legend>
					<table width="100%">
					<?
					$sqlSm2= "SELECT * FROM Tra_M_Menu_Items ORDER BY cCodColor DESC";
					$rsSm2=sqlsrv_query($cnx,$sqlSm2);
					while ($RsSm2=sqlsrv_fetch_array($rsSm2)){
						$sqlSm3= "SELECT * FROM Tra_M_Menu_Lista WHERE iCodSubMenu='$RsSm2[iCodSubMenu]' AND iCodMenu='$_GET[iCodMenu]'";
						//echo $sqlSm3;
						$rsSm3=sqlsrv_query($cnx,$sqlSm3);
						if(sqlsrv_has_rows($rsSm3)==0){
								echo "<tr><td bgcolor=".$RsSm2[cCodColor]."><li>".$RsSm2[cNombreSubMenu]."</td><td width=16><a href=../models/ad_menuOpciones_data.php?opcion=1&iCodMenu=".$_GET[iCodMenu]."&iCodSubMenu=".$RsSm2[iCodSubMenu]."><img src=images/icon_select.png width=16 height=16 border=0></a></td></tr>";
						}
					}
					?>
					</table>
  		</fieldset>

		&nbsp;
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