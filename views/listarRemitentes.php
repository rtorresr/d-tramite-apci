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
<SCRIPT LANGUAGE="JavaScript">

function sendValue(s,t,u){
var selvalue1 = s.value;
var selvalue2 = t.value;
var selvalue3 = u.value;
window.opener.document.getElementById('cNombresTrabajador').value = selvalue1;
window.opener.document.getElementById('cNumDocIdentidad').value = selvalue2;
window.opener.document.getElementById('identificacion').value = selvalue3;
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

<div class="AreaTitulo">
	Seleccione Remitente:
</div>	
	<table width="100%" border="1" cellpadding="0" cellspacing="3">
		<form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
			<tr>
				<td align="left" colspan="3">
					<table width="100%">
						<tr>
							<td>
								Nombre: <input type="text" name="cNombreBuscar" value="<?=$_GET[cNombreBuscar]?>" style="width:320px">
							</td>
							<td align="right">
								Nro. Documento: <input type="text" name="nNumDocumento" value="<?=$_GET['nNumDocumento']?>" size="10">
							<input type="submit" class="btn btn-primary" name="buscar" value="Buscar">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</form>
		<tr>
			<td align="center"    width="560">NOMBRE REMITENTE &nbsp;&nbsp;/&nbsp;&nbsp; N&ordm; DOCUMENTO</td>
			<td align="center"    width="70">OPCION</td>
		</tr>			
		<?php
			include_once("../conexion/conexion.php");
			if ($_GET[buscar]==""){
				$sqlRem = "SELECT TOP 500 * FROM Tra_M_Remitente ";
			}else{
				$sqlRem = "SELECT TOP 500 * FROM Tra_M_Remitente ";
			}
			$sqlRem.="WHERE cNombre IS NOT NULL ";
			if ($_GET[cNombreBuscar]!=""){
				$sqlRem.="AND cNombre LIKE '%$_GET[cNombreBuscar]%' ";
			}
			if ($_GET['nNumDocumento']!=""){
				$sqlRem.="AND nNumDocumento='$_GET['nNumDocumento']' ";
			}
    		$sqlRem.="ORDER BY cNombre ASC";
    		$rsRem  = sqlsrv_query($cnx,$sqlRem);
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
    <td width="560" style="font-family:'Arial Narrow';font-size:11px"><?=$RsRem["cNombre"]?> <?php if($RsRem["nNumDocumento"]!="") echo "- <font color=#A96705><b>".trim($RsRem["nNumDocumento"])."</b></font>"?></td>
	<form name="selectform">
		<?php 
			$DNI_RUC = trim($RsRem["nNumDocumento"]);
			if (!empty($DNI_RUC)) {
				if (strlen($DNI_RUC) == 8) {
					$identificacion = 'DNI';
				}elseif (strlen($DNI_RUC) == 11) {
					$identificacion = 'RUC';
				}
			}
		?>
	    <td width="70">
	    	<input name="cNombresTrabajador" value="<?=trim($RsRem["cNombre"])?>" type="hidden">
	    	<input name="cNumDocIdentidad" value="<?=trim($RsRem["nNumDocumento"])?>" type="hidden">
	    	<input name="identificacion" value="<?=$identificacion?>" type="hidden">
			<input type=button value="seleccione" class="btn btn-primary" style="font-size:8px"
				   onClick="sendValue(this.form.cNombresTrabajador,this.form.cNumDocIdentidad,this.form.identificacion);">
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