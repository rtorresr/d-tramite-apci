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
  document.form1.action="<?=$_SERVER['PHP_SELF']?>";
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
 require_once("../conexion/conexion.php");?>
<form action="../controllers/ln_nuevo_remitente.php" method="post" name="form1">

<table width="505" border="0"  align="center">
  <tr>
    <td class="headCellColum" colspan="2" class="style1">Ingrese Datos de Remitente</td>
    
  </tr>
  <tr>
    <td width="210" >Tipo Persona</td>
    <td width="285"><label> 
      
	  <?
$sql="select  DISTINCT cTipoPersona  from Tra_M_Remitente"; 
$rs=sqlsrv_query($cnx,$sql);
	?>
     <select name="tipo_persona" id="tipo_persona" >
	  <? while ($Rs=sqlsrv_fetch_array($rs)){
	   	
	   	 if($Rs['cTipoPersona']==1){
	   	//echo "<option value=".$Rs['cTipoPersona']." >".$Rs['cTipoPersona']."</option>";
			  echo "<option value=".$Rs['cTipoPersona'].">Persona Natural</option>";
		                           }
		   else{
			  echo "<option value=".$Rs['cTipoPersona'].">Persona Juridica</option>";
		   //echo "<option value='02' >Persona Natural</option>";
		       }
	   	
		}?>
      </select>
     
      </label></td>
  </tr>
  <tr>
    <td>Nombre de Remitente</td>
    <td><input name="txtnom_remitente" type="text" id="txtnom_remitente"></td>
  </tr>
  <tr>
    <td>Nro de Documento</td>
    <td><input name="txtnum_documento" type="text" id="txtnum_documento"></td>
  </tr>
  <tr>
    <td>Direccion</td>
    <td><input name="txtdir_remitente" type="text" id="txtdir_remitente"></td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td><input name="txtmail" type="text" id="txtmail"></td>
  </tr>
  <tr>
    <td>Telefono</td>
    <td><input name="txtfono_remitente" type="text" id="txtfono_remitente"></td>
  </tr>
  <tr>
    <td>Fax</td>
    <td><input name="txtfax_remitente" type="text" id="txtfax_remitente"></td>
  </tr>
  <tr>
    <td>Departamento</td>
    <td width="285"><label> 
      
	  <?
$sqlDep="select * from Tra_U_Departamento "; 
$rsDep=sqlsrv_query($cnx,$sqlDep);

	?>
     <select name="cCodDepartamento" id="cCodDepartamento" onChange="releer();"/>
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
    <td><input name="txtrep_remitente" type="text" id="txtrep_remitente"></td>
  </tr>
  
  <tr>
    <td>Flag Estado</td>
    <td><label>
      <select name="txtestado" id="txtestado">
	  <option value=1 selected>Activo</option>
	  <option value=0 selected>Inactivo</option>  
	  </select>
      </label></td>
  </tr>
    <tr>
    <td align="center" colspan="2"><input name="Insert Remitente" type="submit" id="Insert Remitente" value="Logeo"></td>
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
