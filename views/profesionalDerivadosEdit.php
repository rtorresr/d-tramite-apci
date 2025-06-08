<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Formulario para Derivar pendiente.
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    05/09/2018      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
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
                     <? $sqlDoc=" SELECT cCodificacion,* FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And iCodMovimiento='$_GET[iCodMovimientoDerivar]'";
                     //echo $sqlDoc;
                     $rsDoc=sqlsrv_query($cnx,$sqlDoc);
                     $RsDoc=sqlsrv_fetch_array($rsDoc);
                     ?>
                     <div class="card-header text-center ">
                         Derivar Documento : <?=((isset($RsDoc['cCodificacion']))?$RsDoc['cCodificacion']:'')?>
                     </div>
                      <!--Card content-->
                     <div class="card-body">
						<form name="frmConsulta" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="opcion" value="">
							<input type="hidden" name="iCodMovimiento" value="<?=$_GET[iCodMovimientoDerivar]?>">
				            Destino de Derivo:
                            Derivar a:
                            <? 
							if($RsDoc[fFecRecepcion]!="" or $RsDoc[fFecRecepcion]!=NULL){
							 $select="disabled";
							}else if($RsDoc[fFecRecepcion]=="" or $RsDoc[fFecRecepcion]==NULL){
								 $select="";
							}?>
							<select name="iCodOficinaDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                searchable="Buscar aqui.." <?php echo $select;?> onchange="releer();" >
									<option value="">Seleccione:</option>
									<?php
if($_POST[iCodOficinaDerivar]==""){$iCodOficinaDerivar=$RsDoc[iCodOficinaDerivar];}else{$iCodOficinaDerivar=$_POST[iCodOficinaDerivar];}
                                    $sqlDep2="SELECT iCodOficina,cNomOficina,iFlgEstado FROM Tra_M_Oficinas WHERE iCodOficina in (SELECT iCodOficina FROM Tra_M_Grupo_Oficina_Detalle WHERE iCodGrupoOficina in (
                                    SELECT iCodGrupoOficina FROM Tra_M_Grupo_Oficina_Detalle WHERE iCodOficina = '".$_SESSION['iCodOficinaLogin']."')
                                    and iCodOficina!= '".$_SESSION['iCodOficinaLogin']."' and iFlgEstado = 1
                                    ) ORDER BY cNomOficina ASC ";
                                    $rsDep2=sqlsrv_query($cnx,$sqlDep2);
                                    while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
                                        if($RsDep2['iCodOficina']==$iCodOficinaDerivar){
                                            $selecOfi="selected";
                                        }Else{
                                            $selecOfi="";
                                        }
                                      echo "<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>";
                                    }
                                    mysql_free_result($rsDep2);
									?>
                            </select>                                    
							Responsable:
                            <select name="iCodTrabajadorDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                    searchable="Buscar aqui.." <?php echo $select;?>>
									<?php if($_POST[iCodOficinaDerivar]==""){?>
									<option value="">Seleccione Trabajador:</option>
									<?php}?>
									<?
									$sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='".$iCodOficinaDerivar."' ORDER BY iCodCategoria DESC, cNombresTrabajador ASC";
                                        $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                                        while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
                                            if($RsTrb[iCodTrabajador]==$_POST[iCodTrabajadorDerivar] or $RsTrb[iCodTrabajador]==$RsDoc[iCodTrabajadorDerivar]){
                                                $selecTrab="selected";
                                            }Else{
                                                $selecTrab="";
                                            }
                                          echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                                        }
                                        sqlsrv_free_stmt($rsTrb);
									?>
                            </select>
							Indicación:
                            <select name="iCodIndicacionDerivar" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                    searchable="Buscar aqui..">
									<option value="">Seleccione Indicación:</option>
									<?
									$sqlIndic="SELECT * FROM Tra_M_Indicaciones ";
                                    $sqlIndic .= "ORDER BY cIndicacion ASC";
                                    $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                                    while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                        if($RsIndic[iCodIndicacion]==$RsDoc[iCodIndicacionDerivar]){
                                            $selecIndi="selected";
                                        }Else{
                                            $selecIndi="";
                                        }
                                      echo "<option value=".$RsIndic["iCodIndicacion"]." ".$selecIndi.">".$RsIndic["cIndicacion"]."</option>";
                                    }
                                    sqlsrv_free_stmt($rsIndic);
									?>
                            </select>
                            <hr>
                    	  <legend class="LnkZonas"> <span style="color:#F00; size:14pt">Para derivar con un nuevo documento, cambie el tipo de documento: </span></legend>
                        Tipo de Documento:
                            <select name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                                                searchable="Buscar aqui.." disabled>
									<option value="">Seleccione:</option>
									<?
									include_once("../conexion/conexion.php");
									$sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ORDER BY cDescTipoDoc ASC ";
                                    $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                    while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                        if($RsTipo["cCodTipoDoc"]==$RsDoc[cCodTipoDocDerivar]){
                                            $selecTipo="selected";
                                        }Else{
                                            $selecTipo="";
                                        }
                                    echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
                                    }
                                    sqlsrv_free_stmt($rsTipo);
									?>
                            </select>
							Asunto:
                            <textarea name="cAsuntoDerivar" style="width:490px;height:55px" class="FormPropertReg form-control"><?=$RsDoc[cAsuntoDerivar]?></textarea>
                            Observaciones:
                            <textarea name="cObservacionesDerivar" style="width:490px;height:55px" class="FormPropertReg form-control"><?=$RsDoc[cObservacionesDerivar]?></textarea>
							<button class="btn btn-primary" onclick="Actualizar();" onMouseOver="this.style.cursor='hand'"> 
                                <b>Actualizar</b> <img src="images/icon_derivar.png" width="17" height="17" border="0"> 
                            </button>&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;
							<button class="btn btn-primary" onclick="window.open('profesionalDerivados.php', '_self');" onMouseOver="this.style.cursor='hand'"> 
                                <b>Retornar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> 
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
    $('.datepicker').pickadate({
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
    });
    $('.mdb-select').material_select();
        function activaCopias(){
            document.frmConsulta.nFlgCopias.value="1";
            document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>?iCodMovimientoDerivar=<?=$_GET[iCodMovimientoDerivar]?>&clear=1#area";
            document.frmConsulta.submit();
            return false;
        }

        function releer(){
            document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>?iCodMovimientoDerivar=<?=$_GET[iCodMovimientoDerivar]?>&clear=1#area";
            document.frmConsulta.submit();
        }

        function Actualizar()
        {
            document.frmConsulta.action="profesionalData.php";
            document.frmConsulta.opcion.value=10;
            document.frmConsulta.submit();
        }

        function ConfirmarBorrado()
        {
            if (confirm("Desea remover la copia?")){
                return true;
            }else{
                return false;
            }
        }
</script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>