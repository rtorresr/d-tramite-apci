<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
<body>


<td width="950" height="21" background="images/pcm_5.jpg" align="left">

</td>
</tr>

<tr>
<td><img width="950" height="11" src="images/pcm_6.jpg" border="0"  align="left"></td>
</tr>

<tr>
<td width="950" height="200" background="images/pcm_7.jpg" align="left" valign= "top">


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

<div class="AreaTitulo">Detalle del Documento</div>

<?
$sql=" SELECT * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos ";
$sql.=" WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
$sql.=" AND cCodificacion='".$codmov."'";
$rs=sqlsrv_query($cnx,$sql);
$Rs=sqlsrv_fetch_array($rs);
//echo $sql;
?>

<form name="form1" method="GET" action="pendientesControl.php">
<table width="800" border="0" align="left">
  <tr>
    <td>
    	<fieldset id="tfa_GeneralDoc" class="fieldset"  >
        <legend class="legend">Datos Generales del Documento</legend>
          <table border="0">
            <tr>
              <td width="71"></td>
              <td width="474" class="label">Nro. Documento :<?php echo " ".$Rs[cCodificacion];?></td>
              <td width="201" class="label">Fecha de Ingreso :<?php echo " ".$Rs['fFecRegistro'];?></td>
            </tr> 
            <tr>
              <td width="71"></td>
              <td width="474" class="label">Tipo de Documento : <? 
    	            $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$Rs[cCodTipoDoc]'";
    	            $rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
    	            $RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
    	            echo " ".$RsTipDoc['cDescTipoDoc'];
                  ?></td>
              <td width="201" class="label">Folios :<?php echo " ".$Rs[nNumFolio];?></td>
            </tr>   
            <tr>
              <td width="71"></td>
              <td width="474" class="label">Asunto :<?php echo " ".$Rs['cAsunto'];?></td>
              <td width="201" class="label">Referencia :<?php echo " ".$Rs[cReferencia];?></td>
            </tr>
          </table>  
      </fieldset>

   <td>   
      <fieldset id="tfa_GeneralEmp" class="fieldset"  >
        <legend class="legend">Datos de la Empresa</legend>
         <table border="0">
           <tr>
              <td width="71"></td>
              <td width="476" class="label">Razon Social :<? 
    	            $sqlRemi="SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='$Rs[iCodRemitente]'";
    	            $rsRemi=sqlsrv_query($cnx,$sqlRemi);
    	            $RsRemi=sqlsrv_fetch_array($rsRemi);
    	            echo " ".$RsRemi['cNombre'];
                  ?></td>
              <td width="199" class="label">Ruc :<?php echo " ".$RsRemi['nNumDocumento'];?></td>
            </tr> 
            <tr>
              <td width="71"></td>
              <td width="476" class="label">Direccion :<?php echo " ".$RsRemi[cDireccion];?></td>
              <td width="199" class="label">Telefono :<?php echo " ".$RsRemi[nTelefono];?></td>
            </tr>   
            <tr>
              <td width="71"></td>
              <td width="476" class="label">E-mail :<?php echo " ".$RsRemi[cEmail];?></td>
              <td width="199" class="label"> </td>
            </tr>
          </table>  
      </fieldset>

   <td>   
      <fieldset id="tfa_FlujoOfi" class="fieldset"  >
       <legend class="legend">Flujo Entre Oficinas</legend>
        <table border="0" align="center">
         <tr>
	         <td class="headCellColum">Tipo Documento</td>
	         <td class="headCellColum">Referencia</td>
	         <td class="headCellColum">Fecha</td>
	         <td class="headCellColum">Asunto</td>
	         <td class="headCellColum">Observaciones</td>
	         <td class="headCellColum">Avances</td>
	         <td class="headCellColum">Ofi. Origen</td>
	         <td class="headCellColum">Ofi. Destino</td>
         </tr>
	     <?
         $numrows=sqlsrv_has_rows($rs);
          if($numrows==0){ 
		      echo "No ha Sido Derivado<br>";
            }
              else{
            while ($Rs=sqlsrv_fetch_array($rs)){
	         if ($color == "#CEE7FF"){
			  $color = "#F9F9F9";
	    		}else{
			  $color = "#CEE7FF";
	    		}
	    		if ($color == ""){
			  $color = "#F9F9F9";
	    		}	
          ?>
          <tr bgcolor="<?=$color?>">
           <td><?php echo $RsTipDoc['cDescTipoDoc'];?></td>
           <td><?php echo $Rs['cNroDocumento'];?></td>
           <td><?php echo $Rs['fFecDerivar'];?></td>
           
           <td><?php echo $Rs['cAsunto'];?></td>
         	 <td><?php echo $Rs[cObservacionesDerivar];?></td>
         	 
         	 <td><?php echo $Rs['iCodOficina'];?></td>
         	 
           <td><? 
           	 $sqlOfiO="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaOrigen]'";
    	       $rsOfiO=sqlsrv_query($cnx,$sqlOfiO);
    	       $RsOfiO=sqlsrv_fetch_array($rsOfiO);
           	 echo $RsOfiO[cNomOficina];?></td>
         	 <td><?
         	 	 $sqlOfiD="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$Rs[iCodOficinaDerivar]'";
    	       $rsOfiD=sqlsrv_query($cnx,$sqlOfiD);
    	       $RsOfiD=sqlsrv_fetch_array($rsOfiD);
         	 	echo $RsOfiD[cNomOficina];?></td>
          </tr> 
          <?
           }
          }
         ?>
        </table>  
      </fieldset>
       
    </td>
  </tr>
</table>
</form>  
  
  
<div>		
</td>
</tr>
<tr>
<td><img width="950" height="11" src="images/pcm_8.jpg" border="0" align="left"></td>
<?php include("includes/userinfo.php");?>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>
