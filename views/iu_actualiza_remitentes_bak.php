<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script Language="JavaScript">
<!--

function releer(){
  document.form1.action="<?=$_SERVER['PHP_SELF']?>?change=1";
  document.form1.submit();
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

<div class="AreaTitulo">Maestra Remitentes</div>

<?
if($_GET[change]==""){
	$iCodRemitente=$_GET[iCodRemitente];
}Else{
	$iCodRemitente=$_POST[iCodRemitente];
}

$sql= "select * from Tra_M_Remitente where iCodRemitente='$iCodRemitente'";
$rs=sqlsrv_query($cnx,$sql);
$Rs=sqlsrv_fetch_array($rs);
?>

<form action="../controllers/ln_actualiza_remitente.php" method="POST" name="form1">
<input type="hidden" name="iCodRemitente" value="<?=$iCodRemitente?>">
	
  <table width="600" border="0"  align="center">
    <tr>
      <td  class="headCellColum" colspan="2" class="style1"><div align="center">Actualizacion de Datos</div></td>
    </tr>
    </tr>
      <td width="236">Tipo de Persona</td>
      <td width="354">
        <select name="tipo_persona" id="tipo_persona" style="width:147px">        						 
						  <?
    if($Rs['cTipoPersona']==1){	
			echo "<option value='01' selected>Persona Natural</option>";
		}
		else{
			echo "<option value='01' >Persona Natural</option>";
		}
		if($Rs['cTipoPersona']==2){	
			echo "<option value='02' selected>Persona Juridica</option>";
		}
		else{
			echo "<option value='02' >Persona Juridica</option>";
		}
						 ?>
		    </select>
      </td>
    </tr>
    <tr>
      <td>Nombre de Remitente</td>
      <td><input name="txtnom_remitente" type="text" id="txtnom_remitente" value="<?php echo $Rs['cNombre']; ?>" /></td>
    </tr>
    <tr>
      <td>Nro Documento</td>
      <td><input name="txtnum_documento" type="text" id="txtnum_documento" value="<?php echo $Rs['nNumDocumento']; ?>" /></td>
    </tr>
    <tr>
      <td>Direccion</td>
      <td><input name="txtdirec_remitente" type="text" id="txtdirec_remitente" value="<?php echo $Rs[cDireccion]; ?>" /></td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="txtmail" type="text" id="txtmail" value="<?php echo $Rs[cEmail]; ?>" /></td>
    </tr>
    <tr>
      <td>Telefono</td>
      <td><input name="txtfono_remitente" type="text" id="txtfono_remitente" value="<?php echo $Rs[nTelefono]; ?>" /></td>
    </tr>
    
    
        
  <tr>
    <td>Fax</td>
    <td><input name="txtfax_remitente" type="text" id="txtfax_remitente" value="<?php echo $Rs[nFax]; ?>"></td>
  </tr>
  <tr>
    <td>Departamento</td>
    <td width="285"><label> 
      
	  <?
$sqlDep="select * from Tra_U_Departamento "; 
$rsDep=sqlsrv_query($cnx,$sqlDep);
	?>
     <select name="cCodDepartamento" id="cCodDepartamento" style="width:147px" onChange="releer();"/>
     	<option value="">Seleccione:</option>
	  <? while ($RsDep=sqlsrv_fetch_array($rsDep)){
	  	if($RsDep["cCodDepartamento"]==$_POST[cCodDepartamento]){
          		$selecClas="selected";
          	}Else{
          		$selecClas="";
          	}
          echo "<option value=".$RsDep["cCodDepartamento"]." ".$selecClas.">".$RsDep["cNomDepartamento"]."</option>";
          }
          sqlsrv_free_stmt($rsDep);
       
					?>
		
		</select>
     
      </label></td>
  </tr>
  <tr>
    <td>Provincia</td>
    <td width="285"><label> 
      
	  <?
$sqlPro="SELECT * from Tra_U_Provincia ";
$sqlPro.=" WHERE  cCodDepartamento like '$_POST[cCodDepartamento]' ";
$rsPro=sqlsrv_query($cnx,$sqlPro);
//echo $sqlPro;
	?>
     <select name="cCodProvincia" id="cCodProvincia" onChange="releer();"  <?php if($_POST[cCodDepartamento]=="") echo "disabled"?> />
     	<option value="">Seleccione:</option>
	  <? while ($RsPro=sqlsrv_fetch_array($rsPro)){
	  	if($RsPro["cCodProvincia"]==$_POST[cCodProvincia]){
          		$selecClas="selected";
          	}Else{
          		$selecClas="";
          	}
          echo "<option value=".$RsPro["cCodProvincia"]." ".$selecClas.">".$RsPro["cNomProvincia"]."</option>";
          }
          sqlsrv_free_stmt($rsPro);
			 
	?>
      </select>
     
      </label></td>
  </tr>
  <tr>
    <td>Distrito</td>
    <td width="285"><label> 
      
	  <?
$sqlDis="SELECT * from Tra_U_Distrito "; 
$sqlDis.=" WHERE cCodDepartamento like '$_POST[cCodDepartamento]' ";
$sqlDis.=" AND cCodProvincia like '$_POST[cCodProvincia]'"; 
$rsDis=sqlsrv_query($cnx,$sqlDis);
//echo $sqlDis;
	?>
     <select name="cCodDistrito" id="cCodDistrito"  <?php if($_POST[cCodProvincia]=="" || $_POST[cCodDepartamento]=="" ) echo "disabled"?> />
     	<option value="">Seleccione:</option>
	  <? while ($RsDis=sqlsrv_fetch_array($rsDis)){
	  	
	  	if($RsDis["cCodProvincia"]==$_POST[cCodProvincia]){
          		$selecClas="selected";
          	}Else{
          		$selecClas="";
          	}
          echo "<option value=".$RsDis["cCodDistrito"]." ".$selecClas.">".$RsDis["cNomDistrito"]."</option>";
          }
          sqlsrv_free_stmt($rsDis);
          
      ?>
      </select>
     
      </label></td>
  </tr>
  <tr>
    <td>Representante</td>
    <td><input name="txtrep_remitente" type="text" id="txtrep_remitente" value="<?php echo $Rs[cRepresentante]; ?>"></td>
  </tr>
   
    <tr>
      <td>Flag Estado</td>
      <td><label>
        <select name="txtflg_estado" id="txtflg_estado">
		<?
		if($Rs[cFlag]==1){
			echo "<option value='1' selected>Activo</option>";
		}
		else{
			echo "<option value='1'>Activo</option>";
		}
		
		if($Rs[cFlag]==0){
			echo "<option value='0' selected>Inactivo</option>";
		}
		else{
			echo "<option value='0'>Inactivo</option>";
		}

		?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><div align="center">
        <input name="Insert Remitente" type="submit" id="Insert Remitente" value="Actualiza Datos" />        
      </td>
      </td>
    </tr>
  </table>
  <input type="hidden" name="txtcodremi" value="<?php echo $Rs[iCodRemitente];?>">
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
