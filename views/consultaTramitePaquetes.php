<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaTramiteTupa.php
SISTEMA: SISTEMA   DE TRÁMITE DOCUMENTARIO DIGITAL
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

<div class="AreaTitulo">Consulta de Fiscalizacion - Paquetes</div>
<table class="table">
<tr>

	<br>
	
	<table width="1000" border="0" cellpadding="3" cellspacing="3" align="center">
	<tr>
	<td width="98" class="headCellColum">N&ordm; Paquete</td>
  <td width="92" class="headCellColum">Registro</td>
	<td width="150" class="headCellColum">Registrado</td>
  <td width="530" class="headCellColum">Observaciones</td>
  <td width="83" class="headCellColum">Opciones</td>
	</tr>
	<?
	function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
    	for($m=0; $m<$dif_diez; $m++){
            @$insertar_ceros .= 0;
    	}
    	return $insertar_ceros .= $numero;
  }	
		$sql="SELECT * FROM Tra_M_Tramite_Fiscalizacion ORDER BY iCodPaquete DESC";	   
    $rs=sqlsrv_query($cnx,$sql);
    //echo $sql;
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
    	<a href="consultaTramitePaquetesLst.php?iCodPaquete=<?=$Rs[iCodPaquete]?>"><?=add_ceros($Rs[iCodPaquete],5)?></a>
  </td>
    <td valign="top" align="center" valign="top"><?
    	echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($Rs[fFecPaquete]))."</div>";
      echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($Rs[fFecPaquete]))."</div>";
      ?>
    </td>
    <td valign="top">
    	<?
    	$rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'");
      $RsDelg=sqlsrv_fetch_array($rsDelg);
      echo "<span style=color:#6F3700>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</span>";
			sqlsrv_free_stmt($rsDelg);
    	?>
    </td>
    <td width="530" valign="top" style="text-align:justify;padding-left:10px;padding-right:10px;"><?=nl2br($Rs[cObservaciones])?></td> 
    <td valign="top" align="center">
				<a href="consultaTramitePaquetesEdit.php?iCodPaquete=<?=$Rs[iCodPaquete]?>"  rel="lyteframe" title="Editar Datos" rev="width: 750px; height: 240px; scrolling: auto; border:no"><i class="fas fa-edit"></i></a>
				<?php if($Rs[cInformeDigital]!=""){
						if (file_exists("../cAlmacenArchivos/".$Rs[cInformeDigital])){
								echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($Rs[cInformeDigital])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($Rs[cInformeDigital])."\"></a>";
						}Else{
								echo "<img src=images/space.gif width=16 height=16 border=0>";
						}
				}Else{
								echo "<img src=images/space.gif width=16 height=16 border=0>";
				}
				?>
		</td>
 </tr>
<?php}?> 
</table>

<!-- fin cierre borde azul -->
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>




<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>