<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>

</head>
<body  class="theme-default has-fixed-sidenav">
 
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

                        <div class="AreaTitulo">Delegar Documento</div>
		
				        <table cellpadding="0" cellspacing="0" border="0" width="700"><tr><td><?php // ini table por fieldset ?>
				        <fieldset>
						    <table cellpadding="3" cellspacing="3" border="0" width="700">
							<form name="frmDelegar" method="POST">
                                <?php
							        if($_POST['iCodMovimientoAccion']==""){
						                for ($h=0;$h<(count($_POST['MovimientoAccion']??''));$h++){
                    	                    $iCodMovimientoAccion=$_POST['MovimientoAccion'];

	                            ?>
						            <input type="hidden" name="iCodMovimiento[]" value="<?=$iCodMovimientoAccion[$h]?>" size="65" class="FormPropertReg form-control">
                        							
						        <?php  /*	<input type="hidden" name="iCodMovimiento" value="<?=((isset($_GET['iCodMovimientoAccion']))?$_GET['iCodMovimientoAccion']:'')?>">*/ ?>
								<?php
									include_once("../conexion/conexion.php");
									$sqlDlg="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='$iCodMovimientoAccion[$h]'";
									
								}
								?>
								<input type="hidden" name="opcion" value="">
					            <?php
							        }
                                    else if($_POST['iCodMovimientoAccion']!=""){?>
                                        <input type="hidden" name="iCodMovimiento[]" value="<?=$_POST['iCodMovimientoAccion']?>">
                                        <input type="hidden" name="opcion" value="">
                                        <?php
                                            include_once("../conexion/conexion.php");
                                            $sqlDlg="SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodMovimiento='".$_POST['iCodMovimientoAccion']."'";

                                    }

                            //include_once("../conexion/conexion.php");
			            $rsDlg=sqlsrv_query($cnx,$sqlDlg);

			            $RsDlg=sqlsrv_fetch_array($rsDlg);
			            //$RsDlg=sqlsrv_fetch_array($rsDlg);
									?>
							<tr>
							<td width="120" >Delegar a:</td>
							<td align="left" class="CellFormRegOnly">
									<select name="iCodTrabajadorDelegado" id="iCodTrabajadorDelegado" style="width:252px;" class="FormPropertReg mdb-select colorful-select dropdown-primary">
									<option value="">Seleccione:</option>
									<?php
									// $sqlTrb = "SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nFlgEstado = 1
									// 		 			 ORDER BY cApellidosTrabajador ASC";
									// $sqlTrb = "SELECT * FROM Tra_M_Perfil_Ususario TPU
									// 					 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
									// 					  WHERE TT.nFlgEstado = 1 AND TPU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."'";
									$sqlTrb = "SELECT COUNT(*), TT.iCodTrabajador, TT.cNombresTrabajador, TT.cApellidosTrabajador 
														 FROM Tra_M_Perfil_Ususario TPU 
														 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador 
														 WHERE TT.nFlgEstado = 1 AND TPU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."'
														 GROUP BY TT.iCodTrabajador, TT.cNombresTrabajador, TT.cApellidosTrabajador
													   ORDER BY TT.cApellidosTrabajador";

									$rsTrb=sqlsrv_query($cnx,$sqlTrb);
              		while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
              			if($RsTrb[iCodTrabajador]==$RsDlg['iCodTrabajadorDelegado']){
              				$selectD="selected";
              			}Else{
              				$selectD="";
              			}
              		  echo utf8_encode("<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selectD.">".$RsTrb["cApellidosTrabajador"]." ".$RsTrb["cNombresTrabajador"]."</option>");
              		}
              		sqlsrv_free_stmt($rsTrb);
									?>
									</select>&nbsp;<span class="FormCellRequisito">*</span>
							</td>
							
							</tr>
							
							<tr>
							<td  width="120">Acción:</td>
							<td align="left">
							<select name="iCodIndicacionDelegado" style="width:250px;" class="FormPropertReg mdb-select colorful-select dropdown-primary">
							<option value="">Seleccione:</option>
							<?php
                              $sqlIndic="SELECT * FROM Tra_M_Indicaciones ORDER BY cIndicacion ASC";
                              $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                              while ($RsIndic=sqlsrv_fetch_array($rsIndic)){
                                if($RsIndic[iCodIndicacion]==$RsDlg[iCodIndicacionDelegado]){
                                    $selectI="selected";
                                }Else{
                                    $selectI="";
                                }
                                echo utf8_encode( "<option value=".$RsIndic["iCodIndicacion"]." ".$selectI.">".$RsIndic["cIndicacion"]."</option>");

                              }
                              sqlsrv_free_stmt($rsIndic);
							?>
							</select>
							</td>
							</tr>
							
							<tr>
							<td width="120" >Observaciones:</td>
							<td align="left"><textarea name="cObservacionesDelegado" style="width:340px;height:55px" class="FormPropertReg form-control"><?= trim($RsDlg['cObservacionesDelegado']??'')?></textarea></td>
							</tr>

							<tr>
							<td width="120" >Copias:</td>
							<td align="left">
								<table>
									<tr>
										<td>
											<select id="lstTrabajadores" name="lstTrabajadores[]" style="width:360px;" size="6" class="browser-default mdb-select colorful-select dropdown-primary" multiple>
											<?php
												// $sqlTrbCc = "SELECT * FROM Tra_M_Trabajadores 
												// 						 WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' AND nFlgEstado=1
												// 						 ORDER BY cApellidosTrabajador ASC";
												// $sqlTrbCc = "SELECT * FROM Tra_M_Perfil_Ususario TPU
												// 		 			   INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
												// 		  		   WHERE TT.nFlgEstado = 1 AND TPU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."'
												// 		  		   ORDER BY TT.cNombresTrabajador";
												$sqlTrbCc = "SELECT COUNT(*), TT.iCodTrabajador, TT.cNombresTrabajador, TT.cApellidosTrabajador 
																		 FROM Tra_M_Perfil_Ususario TPU 
																		 INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador 
																		 WHERE TT.nFlgEstado = 1 AND TPU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."'
																		 GROUP BY TT.iCodTrabajador, TT.cNombresTrabajador, TT.cApellidosTrabajador
																		 ORDER BY TT.cNombresTrabajador";

          				    	$rsTrbCc = sqlsrv_query($cnx,$sqlTrbCc);
          				    	while ($RsTrbCc = sqlsrv_fetch_array($rsTrbCc)){
          				      	echo utf8_encode("<option value=".$RsTrbCc["iCodTrabajador"].">".$RsTrbCc["cNombresTrabajador"]." ".$RsTrbCc["cApellidosTrabajador"]."</option>");
          				    	}
          				    	sqlsrv_free_stmt($rsTrbCc);
											?>
											</select><br>
									</td>
									<td width="155">
											<table width="100%" border="0" style="height:95px">
											<tr>
											<td valign="top"><a style="color:#006F00" href="javascript:agregar();" id="agregarOtro">Añadir</a></td><td valign="top"><a style="color:#006F00" href="javascript:agregar();"><img src="images/icon_arrow_right.png" width="22" height="22" border="0"></a></td>
											<td width="20"></td>
											<td align="right" valign="bottom"><a style="color:#800000" href="javascript:retirar();"><img src="images/icon_arrow_left.png" width="22" height="22" border="0"></a></td><td valign="bottom"><a style="color:#800000" href="javascript:retirar();">Quitar</a></td>
											</tr>
											</table>
									</td>
									<td>
                                    	<?
											$sqlMTrb="SELECT * FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Trabajadores ON Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar=Tra_M_Trabajadores.iCodTrabajador WHERE iCodMovimientoRel=".$RsDlg[iCodMovimiento]." ORDER BY iCodMovimiento ASC";


                                        $rsMTrb=sqlsrv_query($cnx,$sqlMTrb);
							?>
											<select id="lstTrabajadoresSel" name="lstTrabajadores[]" style="width:355px;" size="6" class="browser-default mdb-select colorful-select dropdown-primary" multiple>
											<?

              				while ($RsMTrb=sqlsrv_fetch_array($rsMTrb)){
              				  echo "<option value=".$RsMTrb["iCodTrabajadorEnviar"].">".$RsMTrb["cNombresTrabajador"]." ".$RsMTrb["cApellidosTrabajador"]."</option>";
              				}
              				sqlsrv_free_stmt($rsMTrb);
											?>
											</select>
									</td>
									</tr>
									</table>								
							</td>
							</tr>
														
							<tr>
							<td colspan="2" align="right">
							<button class="btn btn-primary" onclick="Delegar();" onMouseOver="this.style.cursor='hand'"> <b>Delegar</b> <img src="images/icon_delegar.png" width="17" height="17" border="0"> </button>
							&nbsp;&nbsp;
							<button class="btn btn-primary" onclick="Volver();" onMouseOver="this.style.cursor='hand'"> <b>Cancelar</b> <img src="images/icon_retornar.png" width="17" height="17" border="0"> </button>
							</td>
							</tr>
							</form>


					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>
 <?php include("includes/userinfo.php"); ?>

<?php include("includes/pie.php");?>

<script>
    $(document).ready(function() {
        $('.mdb-select').material_select();
    });

    $('.datepicker').pickadate({
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
    });
</script>

    <script Language="JavaScript">

        function agregar(){
            var bNoAgregar;
            bNoAgregar=false;

            /* var mutli_education = document.frmDelegar.elements["lstTrabajadores[]"];

                 var codTrabajador=document.getElementById("iCodTrabajadorDelegado");
             var pro = codTrabajador.options[codTrabajador.selectedIndex].value;
             var contador=document.frmDelegar.cObservacionesDelegado.value;
             var cantidadRes=contador.length;
             console.log('cantidad',cantidadRes);
             console.log("total 2-->",mutli_education.length);*/

            for(i=0; i<=document.frmDelegar.lstTrabajadores.length-1; i++){
                if(document.frmDelegar.lstTrabajadores.options[i].selected){
                    for(z=0;z<=document.frmDelegar.lstTrabajadoresSel.length-1;z++){
                        if(document.frmDelegar.lstTrabajadores.options[i].text==document.frmDelegar.lstTrabajadoresSel.options[z].text){
                            alert("�El Trabajador ''" + document.frmDelegar.lstTrabajadores.options[i].text + "'' ya está añadido!");
                            bNoAgregar=true;
                            break;
                        }
                    }
                    if(bNoAgregar==false){
                        document.frmDelegar.lstTrabajadoresSel.length++;
                        document.frmDelegar.lstTrabajadoresSel.options[document.frmDelegar.lstTrabajadoresSel.length-1].text= document.frmDelegar.lstTrabajadores.options[i].text;
                        document.frmDelegar.lstTrabajadoresSel.options[document.frmDelegar.lstTrabajadoresSel.length-1].value= document.frmDelegar.lstTrabajadores.options[i].value;
                    }
                }
            }



        }

        function retirar(tipoLst){
            var ArrayProvincias=new Array();
            var ArrayProfesiones=new Array();
            var Contador;
            Contador=0;
            for(i=0;i<=document.frmDelegar.lstTrabajadoresSel.length-1;i++){
                if((document.frmDelegar.lstTrabajadoresSel.options[i].text!="")&&(document.frmDelegar.lstTrabajadoresSel.options[i].selected==false)){
                    ArrayProvincias[Contador]=document.frmDelegar.lstTrabajadoresSel.options[i].text;
                    Contador=Contador+1;
                }
            }
            document.frmDelegar.lstTrabajadoresSel.length=Contador;
            for(i=0;i<Contador;i++){
                document.frmDelegar.lstTrabajadoresSel.options[i].text=ArrayProvincias[i];
            }
        }





        function Delegar()
        {

            var a=$('#iCodTrabajadorDelegado').val();

            if ( !a){

                alert("Seleccione Trabajador a Delegar");
                document.frmDelegar.iCodTrabajadorDelegado.focus();
            }


                Elem=document.getElementById('lstTrabajadoresSel').options;
                for(i=0;i<Elem.length;i++){
                    Elem[i].selected=true;
                }



            document.frmDelegar.opcion.value=3;
            document.frmDelegar.action="pendientesData.php?trabajador="+a;
            document.frmDelegar.submit();
        }

        function Volver(){
            document.frmDelegar.action="registroData.php";
            document.frmDelegar.opcion.value=27;
            document.frmDelegar.submit();
        }
    </script>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>