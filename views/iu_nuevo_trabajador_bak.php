<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
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

<div class="AreaTitulo">Maestra Trabajadores</div>
<form action="../controllers/ln_nuevo_trabajador.php" method="post" name="form1">

<table width="600" border="0" align="center">
  <tr>
    <td class="headCellColum" colspan="3"><div align="center">Ingrese datos de Trabajador </div></td>
    
  </tr>
   <tr>
    <td>Oficina </td>
     <td width="285"><label> 
      
	  <?
$sqlOfi="select * from Tra_M_Oficinas "; 
$rsOfi=sqlsrv_query($cnx,$sqlOfi);
	?>
     <select name="iCodOficina" id="iCodOficina"  />
     	<option value="">Seleccione:</option>
	  <? while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
	  	if($RsOfi["iCodOficina"]==$_POST['iCodOficina']){
          		$selecClas="selected";
          	}Else{
          		$selecClas="";
          	}
          echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
          }
          sqlsrv_free_stmt($rsOfi);
       
					?>
		
		</select>
     
      </label></td>

  </tr>
  <tr>
    <td>Codigo Perfil </td>
    <td width="285"><label> 
      
	  <?
$sqlPer="select * from Tra_M_Perfil "; 
$rsPer=sqlsrv_query($cnx,$sqlPer);
	?>
     <select name="nCodPerfil" id="nCodPerfil"  />
     	<option value="">Seleccione:</option>
	  <? while ($RsPer=sqlsrv_fetch_array($rsPer)){
	  	   echo "<option value=".$RsPer["nCodPerfil"]." ".$selecClas.">".$RsPer["cDescPerfil"]."</option>";
          }
          sqlsrv_free_stmt($rsPer);
       
					?>
		
		</select>
     
      </label>
      </td>
    	
  </tr>
  <tr>
    <td>Nombre de Trabajador</td>
    <td><input name="cNombresTrabajador" type="text" id="cNombresTrabajador" ></td>
  </tr>
  <tr>
    <td>Apellidos de Trabajador</td>
    <td><input name="cApellidosTrabajador" type="text" id="cApellidosTrabajador" ></td>
  </tr>
  <tr>
    <td>Tipo de Documento</td>
    <td width="285"><label> 
      
	  <?
$sqlDoc="select * from Tra_M_Doc_Identidad "; 
$rsDoc=sqlsrv_query($cnx,$sqlDoc);
	?>
     <select name="cTipoDocIdentidad" id="cTipoDocIdentidad"  />
     	<option value="">Seleccione:</option>
	  <? while ($RsDoc=sqlsrv_fetch_array($rsDoc)){
	  	   echo "<option value=".$RsDoc["cTipoDocIdentidad"]." ".$selecClas.">".$RsDoc["cDescDocIdentidad"]."</option>";
          }
          sqlsrv_free_stmt($rsDoc);
       
					?>
		
		</select>
     
      </label>
      </td>
    
  </tr>
  <tr>
    <td>Numero de Documento</td>
    <td><input name="cNumDocIdentidad" type="text" id="cNumDocIdentidad" ></td>
  </tr>
  <tr>
    <td>Direccion</td>
    <td><input name="cDireccionTrabajador" type="text" id="cDireccionTrabajador" ></td>
  </tr>
  <tr>
    <td>E-MAIL</td>
    <td><input name="cMailTrabajador" type="text" id="cMailTrabajador" ></td>
  </tr>
  <tr>
    <td>Telefono 1</td>
    <td><input name="cTlfTrabajador1" type="text" id="cTlfTrabajador1" ></td>
  </tr>
  <tr>
    <td>Telefono 2</td>
    <td><input name="cTlfTrabajador2" type="text" id="cTlfTrabajador2" ></td>
  </tr>
  <tr>
    <td>Estado</td>
    <td><select name="txtestado" id="txtestado">
        <? 
			if ($Rs[nFlgEstado]==1){
	  	echo "<OPTION value=1 selected>Activo</OPTION> ";
		}
		else{
		echo "<OPTION value=1>Activo</OPTION> ";
		}
        if ($Rs[nFlgEstado]==0){
	  	echo "<OPTION value=0 selected>Inactivo</OPTION> ";
		}
		else{
		echo "<OPTION value=0>Inactivo</OPTION> ";
		}
	   ?>
	   
	   
	    
      </select></td>
  </tr>
  
    <tr>
    <td align="center" colspan="3"><input name="Insert Trabajador" type="submit" id="Insert Trabajador" value="CREA USUARIO"></td>
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