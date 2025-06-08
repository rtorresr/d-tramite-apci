<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: registroObservacion.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Ingresa observacion para un tramitre de salida
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
<script Language="JavaScript">
<!--
function Registrar(){
  document.frmRegistro.submit();
}

function releer(){
  document.frmRegistro.method="POST";
  document.frmRegistro.action="<?=$_SERVER['PHP_SELF']?>?clear=1";
  document.frmRegistro.submit();
}
//--></script>
</head>
<body>
<table width="350" height="240"  cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff" align="center" >
<tr>
<td  align="left" valign="top">

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

<div class="AreaTitulo">Ingresar Observacion</div>
<form method="POST" name="frmRegistro" action="registroObservaciondata.php" >
		
		<table width="351" border="0" cellpadding="0" cellspacing="3" align="center">
	<?
 		if($_GET[clear]==""){ 
 			if(trim($_GET[iCodAuto])!=""){  $auto=$_GET[iCodAuto]; } }
 		else{ $auto = $_POST[iCodAuto]; }
 
 		if($_GET[clear]==""){ 
 			if(trim($_GET[iCodRemitente])!=""){  $remitente=$_GET[iCodRemitente]; } }
 		else{ $remitente = $_POST[iCodRemitente]; }
 
 		if($_GET[clear]==""){ 
 			if(trim($_GET[iCodTramite])!=""){ $tramite=$_GET[iCodTramite]; } }
 		else{ $tramite = $_POST[iCodTramite]; }
 	?>	
    	<input type="hidden" name="iCodAuto" value="<?=$auto?>">
    	<input type="hidden" name="iCodRemitente" value="<?=$remitente?>">
        <input type="hidden" name="iCodTramite" value="<?=$tramite?>">
		<tr>
        	<td  valign="top">Observacion:</td>
			<td  align="left">
        <?
        $sql="SELECT  cObservacion,cNomRemite, cDireccion , cDepartamento, cProvincia, cDistrito FROM Tra_M_Doc_Salidas_Multiples  WHERE iCodRemitente=".$remitente." AND  iCodAuto=".$auto." ";
        $rs=sqlsrv_query($cnx,$sql);
			  $Rs=sqlsrv_fetch_array($rs);
			 
		if($_GET[clear]==""){ 
 			 $obs=trim($Rs[cObservacion]); } 
 		else{ $obs =  $_POST[cObservacion]; }
		
		if($_GET[clear]==""){ 
 			 $nom=trim($Rs[cNomRemite]); } 
 		else{ $nom =  $_POST[cNomRemite]; }	 
		
		if($_GET[clear]==""){ 
 			 $dir=trim($Rs[cDireccion]); } 
 		else{ $dir =  $_POST[txtdirec_remitente]; }	 
		
		if($_GET[clear]==""){ 
 			 $dep=trim($Rs[cDepartamento]); } 
 		else{ $dep =  $_POST[cCodDepartamento]; }	 
		
		if($_GET[clear]==""){ 
 			 $pro=trim($Rs[cProvincia]); } 
 		else{ $pro =  $_POST[cCodProvincia]; }	 
		
		if($_GET[clear]==""){ 
 			 $dis=trim($Rs[cDistrito]); } 
 		else{ $dis =  $_POST[cCodDistrito]; }	 
		   	
		?>	      
		    <textarea name="cObservacion" style="width:300px;height:70px" class="FormPropertReg form-control"><?=$obs?></textarea></td>
		  </tr>
    <tr>
     	<td >Destinatario:</td>
    	<td  align="left"><input type="text" name="cNomRemite" style="width:300px" value="<?=$nom?>" class="FormPropertReg form-control"/></td>
    </tr>  
     <tr>
    <td >Dirección:</td>
    <td  align="left"><input name="txtdirec_remitente" type="text" style="width:300px" value="<?=$dir?>" maxlength="120" size="70" class="FormPropertReg form-control"></td>
    </tr>
    <tr>
    <td >Departamento:</td>
    <td align="left">
				<select name="cCodDepartamento" class="FormPropertReg form-control" id="cCodDepartamento" style="width:236px" onChange="releer();">
				<option value="">Seleccione:</option>
				<?
        $sqlDep="select * from Tra_U_Departamento "; 
        $rsDep=sqlsrv_query($cnx,$sqlDep);
				while ($RsDep=sqlsrv_fetch_array($rsDep)){
	  	  		if($RsDep["cCodDepartamento"]==$dep){
          			$selecClas="selected";
						}else{
          			$selecClas="";
						}
            echo "<option value=".$RsDep["cCodDepartamento"]." ".$selecClas.">".$RsDep["cNomDepartamento"]."</option>";
				}
        sqlsrv_free_stmt($rsDep);
        ?>
				</select>
		</td>
    </tr>
    
    <tr>
    <td >Provincia:</td>
    <td align="left">
    		<select name="cCodProvincia"  class="FormPropertReg form-control" id="cCodProvincia" onChange="releer();" style="width:236px" <?php if($dep=="") echo "disabled"?> >
     	  <option value="">Seleccione:</option>
    		<?
        $sqlPro="SELECT * from Tra_U_Provincia WHERE cCodDepartamento=".$dep;
        $rsPro=sqlsrv_query($cnx,$sqlPro);
				while ($RsPro=sqlsrv_fetch_array($rsPro)){
	  	  		if($RsPro["cCodProvincia"]==$pro){
          			$selecPro="selected";
						}else{
          			$selecPro="";
						}
            echo "<option value=".$RsPro["cCodProvincia"]." ".$selecPro.">".$RsPro["cNomProvincia"]."</option>";
				}
        sqlsrv_free_stmt($rsPro);
			  ?>
				</select>
		</td>
    </tr>
    
    <tr>
    <td >Distrito:</td>
    <td align="left">
    		<select name="cCodDistrito" class="FormPropertReg form-control" id="cCodDistrito" style="width:236px" <?php if($dep=="" || $pro=="" ) echo "disabled"?> >
				<option value="">Seleccione:</option>
    		<?
        $sqlDis="SELECT * from Tra_U_Distrito WHERE cCodDepartamento='$dep' AND cCodProvincia='$pro'"; 
        $rsDis=sqlsrv_query($cnx,$sqlDis);
				while ($RsDis=sqlsrv_fetch_array($rsDis)){
	  	  		if($RsDis["cCodDistrito"]==$dis){
          		$selecDis="selected";
          	}else{
          		$selecDis="";
          	}
            echo "<option value=".$RsDis["cCodDistrito"]." ".$selecDis.">".$RsDis["cNomDistrito"]."</option>";
				}
				sqlsrv_free_stmt($rsDis);
        ?>
				</select>
		</td>
    </tr>
    <tr>
			<td height="37" colspan="2" align="center">
			  <input name="button" type="button" class="btn btn-primary" value="Modificar" onclick="Registrar();">
	
        </form>
  </div>      
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