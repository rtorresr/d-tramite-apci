<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
		if (!isset($_SESSION["cCodSessionDrv"])){ 
			  $max_chars=round(rand(5,15));  
				$chars=array();
				for($i="a";$i<"z";$i++){
  				$chars[]=$i;
  				$chars[]="z";
				}
				for ($i=0; $i<$max_chars; $i++){
  				$letra=round(rand(0, 1));
  				if ($letra){ 
 						$clave.= $chars[round(rand(0,count($chars)-1))];
  				}else{ 
 						$clave.= round(rand(0, 9));
  				}
				}
    	$_SESSION["cCodSessionDrv"]=$clave;
		}
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />

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
                    <div class="card-header text-center "> Derivar Documento : <?=((isset($RsDoc['cCodificacion']))?$RsDoc['cCodificacion']:'')?></div>
                    <!--Card content-->                     
                    <div class="card-body">
                        <?php
                        if (isset($iCodMovimientoAccion)) {
                            $sqlDoc = " SELECT Tra_M_Tramite.cCodificacion,Tra_M_Tramite_Movimientos.cFlgTipoMovimiento FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite AND iCodMovimiento='" . ''?? $iCodMovimientoAccion . "'";
                            $rsDoc = sqlsrv_query($cnx, $sqlDoc);
                            $RsDoc = sqlsrv_fetch_array($rsDoc);
                        }else{
                            $RsDoc = '';
                        }
                        ?>
                      <form name="frmConsulta" method="POST" enctype="multipart/form-data">
                          <input type="hidden" name="opcion" value="">
                          <input type="hidden" name="iCodMovimientoAccion" value="<?=$_REQUEST['iCodMovimientoAccion']?>">
                          <input type="hidden" name="iCodMovimiento" value="<?=$_REQUEST['iCodMovimientoAccion']?>">
                          <input type="hidden" name="nFlgCopias" value="<?php if(''??$_POST['nFlgCopias']==1) echo "1"?>">
                          <input type="hidden" name="cFlgTipoMovimientoOrigen" value="<?=((isset($RsDoc['cFlgTipoMovimiento']))?$RsDoc['cFlgTipoMovimiento']:'')?>">
                          Derivar a:
                          <select name="iCodOficinaDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui.." onChange="releer();">
                                            <option value="">Seleccione:</option>
                                <?php
                                            $sqlDep2="SELECT iCodOficina,cNomOficina,iFlgEstado FROM Tra_M_Oficinas  ORDER BY cNomOficina ASC ";
                            $rsDep2=sqlsrv_query($cnx,$sqlDep2);
                            while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
                                if($RsDep2['iCodOficina']==($_POST['iCodOficinaDerivar']??'')){
                                    $selecOfi="selected";
                                }Else{
                                    $selecOfi="";
                                }
                              echo utf8_encode("<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>");
                            }
                                sqlsrv_fetch_array($rsDep2);
                            ?>
                          </select>       
                          Responsable:
                          <select name="iCodTrabajadorDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                            <?php if($_POST['iCodOficinaDerivar']??''==""){ ?>
                                            <option value="" >Seleccione Trabajador:</option>
                                            <?php
                                                $sqlTrb = "SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='" . ($_POST['iCodOficinaDerivar']??'') . "'  And nFlgEstado=1   ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
                                                $rsTrb = sqlsrv_query($cnx, $sqlTrb);
                                                while ($RsTrb = sqlsrv_fetch_array($rsTrb)) {
                                                    if ($RsTrb['iCodTrabajador'] == $_POST['iCodTrabajadorDerivar']) {
                                                        $selecTrab = "selected";
                                                    } Else {
                                                        $selecTrab = "";
                                                    }
                                                    echo utf8_encode("<option value=\"" . $RsTrb["iCodTrabajador"] . "\" " . $selecTrab . ">" . $RsTrb["cNombresTrabajador"] . " " . $RsTrb["cApellidosTrabajador"] . "</option>");
                                                }
                                                sqlsrv_free_stmt($rsTrb);
                                            }
                                            ?>
                          </select>
                          Indicación:</td>
                          <select name="iCodIndicacionDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">
                                            <option value="">Seleccione Indicación:</option>
                                            <?php
                            $sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                            $sqlIndic .= "ORDER BY cIndicacion ASC";
                            $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                            while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                if($RsIndic['iCodIndicacion']==($_POST['iCodIndicacionDerivar']??'')){
                                    $selecIndi="selected";
                                }Else{
                                    $selecIndi="";
                                }              	
                              echo utf8_encode("<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>");
                            }
                            sqlsrv_free_stmt($rsIndic);
                                            ?>
                          </select>
                            Tipo de Documento:
                              <select name="cCodTipoDoc"  <?=$est??''?>  class="FormPropertReg mdb-select colorful-select dropdown-primary" searchable="Buscar aqui..">   <span style="color:#F00; size:14pt">Cambiar, para adjuntar nuevo documento </span>
                                <?php
                                    include_once("../conexion/conexion.php");
                                            $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 ORDER BY cDescTipoDoc ASC ";
                                    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                        if($RsTipo["cCodTipoDoc"]===(''??$_POST['cCodTipoDoc']) or $RsTipo["cCodTipoDoc"]==45){
                                            $selecTipo="selected";
                                        }Else{
                                        $selecTipo="";
                                    }
                                    echo utf8_encode("<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>");
                                }
                                sqlsrv_free_stmt($rsTipo);
                                ?>
                                </select>
                             Asunto:
                          <textarea name="cAsuntoDerivar"   style="width:490px;height:55px" class="FormPropertReg form-control"><?=''??$_POST['cAsuntoDerivar']?></textarea></td>
                          Observaciones:
                          <textarea name="cObservacionesDerivar"  style="width:490px;height:55px" class="FormPropertReg form-control"><?=''??$_POST['cObservacionesDerivar']?></textarea>
                          Adjuntar Archivo:
                          <input type="file" name="fileUpLoadDigital"  class="FormPropertReg form-control" style="width:480px;" />
                          <button class="btn btn-primary" onclick="Derivar();" onMouseOver="this.style.cursor='hand'">
                              <b>Derivar</b> <img src="images/icon_derivar.png" width="17" height="17" border="0">
                          </button>&nbsp;&nbsp;&nbsp;
                          <button class="btn btn-primary" onclick="Volver();" onMouseOver="this.style.cursor='hand'">
                              <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0">
                          </button>
                         </form>

                    </div>                 
                </div>             
            </div>         
        </div>     
    </div> 
</main> 

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php");?>

    <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
    <script Language="JavaScript">
        $('.mdb-select').material_select();

        function activaCopias(){
            document.frmConsulta.nFlgCopias.value="1";
            document.frmConsulta.action="<?=$_SERVER['REQUEST_URI']?>?clear=1#area";
            document.frmConsulta.submit();
            return false;
        }


        function releer(){
            document.frmConsulta.action="<?=$_SERVER['REQUEST_URI']?>?clear=1#area";
            document.frmConsulta.submit();
        }

        function Derivar()
        {
            if (document.frmConsulta.cCodTipoDoc.value.length == "")
            {
                alert("Seleccione Tipo Documento");
                document.frmConsulta.cCodTipoDoc.focus();
                return (false);
            }
            if (document.frmConsulta.iCodOficinaDerivar.value.length == "")
            {
                alert("Seleccione Derivar a:");
                document.frmConsulta.iCodOficinaDerivar.focus();
                return (false);
            }
            if (document.frmConsulta.iCodTrabajadorDerivar.value.length == "")
            {
                alert("Seleccione Responsable");
                document.frmConsulta.iCodTrabajadorDerivar.focus();
                return (false);
            }
            if (document.frmConsulta.iCodIndicacionDerivar.value.length == "")
            {
                alert("Seleccione Indicación");
                document.frmConsulta.iCodIndicacionDerivar.focus();
                return (false);
            }

            document.frmConsulta.action="profesionalData.php";
            document.frmConsulta.opcion.value=8;
            document.frmConsulta.submit();
        }
        function Volver(){
            document.frmConsulta.action="profesionalData.php";
            document.frmConsulta.opcion.value=9;
            document.frmConsulta.submit();
        }
        //--></script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>