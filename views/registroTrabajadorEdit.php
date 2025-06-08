<?php
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Registro de internos para trabajadores
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
$rsM=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite ='".$_GET['iCodTramite']."'");
$RsM=sqlsrv_fetch_array($rsM);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
    <script Language="JavaScript">
        function agregar(){
        <?php if($RsM['cFlgTipoMovimiento']==2){  ?>
            var bNoAgregar;
            bNoAgregar=false;
            for(i=0; i<=document.frmRegistro.lstTrabajadores.length-1; i++){
                if(document.frmRegistro.lstTrabajadores.options[i].selected){
                    for(z=0;z<=document.frmRegistro.lstTrabajadoresSel.length-1;z++){
                        if(document.frmRegistro.lstTrabajadores.options[i].text==document.frmRegistro.lstTrabajadoresSel.options[z].text){
                            alert("El Trabajador ''" + document.frmRegistro.lstTrabajadores.options[i].text + "'' ya esta añadido!");
                            bNoAgregar=true;
                        break;
                        }
                    }
                    if(bNoAgregar==false){
                        document.frmRegistro.lstTrabajadoresSel.length++;
                        document.frmRegistro.lstTrabajadoresSel.options[document.frmRegistro.lstTrabajadoresSel.length-1].text= document.frmRegistro.lstTrabajadores.options[i].text;
                        document.frmRegistro.lstTrabajadoresSel.options[document.frmRegistro.lstTrabajadoresSel.length-1].value= document.frmRegistro.lstTrabajadores.options[i].value;
                    }
                }
            }
        <?php }else{?>
            alert("No se Puede Añadir un Nuevo Trabajador al Registro");
        <?php }?>
        }
        <?php
             $sqlList="SELECT  iCodOficina,iCodTrabajador, cNombresTrabajador, cApellidosTrabajador  FROM Tra_M_Trabajadores WHERE iCodOficina= '".$_SESSION['iCodOficinaLogin']."' and nFlgEstado = 1 ORDER BY cNombresTrabajador ASC";
             $rsList=sqlsrv_query($cnx,$sqlList);
             $num=sqlsrv_has_rows($rsList);
             if($num){
         ?>
             //Declaracion de arreglos unidimensionales
                Ofi = new Array();
                Tra = new Array();
                Nom = new Array();
                Ape = new Array();
             //Declaracion de un arreglo de arreglos (simula un arreglo multidimensional)
                //Lista = new Array(Ofi, Tra, Nom, Ape); FUE CAMBIADO POR dos lina Siguientes CesarAc
                Lista = new Array();
                Lista = {Ofi, Tra, Nom, Ape};
        <?php
             $i=0;
        while ($RsList=sqlsrv_fetch_array($rsList)){
            ?>
            Lista[0][<?=$i?>] = '<?=$RsList[0]?>';
            Lista[1][<?=$i?>] = '<?=$RsList[1]?>';
            Lista[2][<?=$i?>] = '<?=trim($RsList[2])?>';
            Lista[3][<?=$i?>] = '<?=trim($RsList[3])?>';
        <?php
                $i=$i+1;
         }
        ?>

        function OfiList(id,oficina){
            document.getElementById(id).innerHTML = "";
            var selectObj = document.frmRegistro.lstTrabajadores;
            var numShown = selectObj.options.length;
            var value = selectObj.options.value;

            for(var i = 0; i < <?=$num?>; i++) {
                    if( oficina == Lista[0][i] ){
                        selectObj.options[numShown] = new Option(  Lista[2][i] + ' ' + Lista[3][i], Lista[1][i]);
                        numShown++;
                    }
            }
        }
        <?php
        }
        ?>
        function retirar(tipoLst){
        <?php if($RsM['cFlgTipoMovimiento']==2){  ?>
        var ArrayProvincias=new Array();
        var ArrayProfesiones=new Array();
        var Contador;
        Contador=0;
            for(i=0;i<=document.frmRegistro.lstTrabajadoresSel.length-1;i++){
                if((document.frmRegistro.lstTrabajadoresSel.options[i].text!="")&&(document.frmRegistro.lstTrabajadoresSel.options[i].selected==false)){
                    ArrayProvincias[Contador]=document.frmRegistro.lstTrabajadoresSel.options[i].text;
                    Contador=Contador+1;
                }
            }
            document.frmRegistro.lstTrabajadoresSel.length=Contador;
            for(i=0;i<Contador;i++){
                document.frmRegistro.lstTrabajadoresSel.options[i].text=ArrayProvincias[i];
            }
        <?php }else{?>
            alert("No se Puede Quitar al Trabajador del Registro");
        <?php }?>
        }

        function seleccionar(obj) {
            Elem=document.getElementById(obj).options;
            for(i=0;i<Elem.length;i++)
            Elem[i].selected=true;
        }

        function Registrar(){
          if (document.frmRegistro.cCodTipoDoc.value.length == "")
          {
            alert("Seleccione Clase Documento");
            document.frmRegistro.cCodTipoDoc.focus();
            return (false);
          }
          if (document.frmRegistro.cAsunto.value.length == "")
          {
            alert("Ingrese Asunto o Asunto");
            document.frmRegistro.cAsunto.focus();
            return (false);
          }
          if (document.frmRegistro.nFlgEnvio.checked == false)
          {
            alert("Recuerde Enviar el Documento Marcando el Check de Envio");
          }
          seleccionar('lstTrabajadoresSel');
          document.frmRegistro.opcion.value=15;
          document.frmRegistro.action="registroData.php";
          document.frmRegistro.submit();
        }
    </script>
    <link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
    <script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
</head>
<body>
	<?php include("includes/menu.php");?>
	<?php
	$rs=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$_GET['iCodTramite']."'");
	$Rs=sqlsrv_fetch_array($rs);
	?>
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
                         <div class="card-header text-center "> >> </div>
                          <!--Card content-->
                         <div class="card-body">
                             <div class="AreaTitulo">Actualizacion - Registro de Trabajadores</div>
                             <table class="table">
                                 <form name="frmRegistro" method="POST" action="registroData.php" enctype="multipart/form-data">
                                     <input type="hidden" name="opcion" value="">
                                     <input type="hidden" name="iCodTramite" value="<?=$_GET['iCodTramite']?>">
                                     <input type="hidden" name="URI" value="<?=$_GET['URI']?>">
                                     <input type="hidden" name="cCodificacion" value="<?=trim($Rs['cCodificacion'])?>">
                                     <input type="hidden" name="fFecMovimiento" value="<?=$Rs['fFecDocumento']->format("Ymd H:i:s")//date("Ymd H:i:s", strtotime($Rs['fFecDocumento']))?>">
                                     <tr>
                                        <td class="FondoFormRegistro">
                                            <table border="0">
                                                <tr>
                                                    <td valign="top"  width="200">N&ordm; Documento:</td>
                                                    <td valign="top" colpsan="3" style="font-size:16px;color:#00468C"><b><?=$Rs['cCodificacion']?></b></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"  width="200">Tipo de Documento:</td>
                                                    <td valign="top">
                                                        <select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:280px" />
                                                            <option value="">Seleccione:</option>
                                                            <?php
                                                            $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgInterno=1 ORDER BY cDescTipoDoc ASC";
                                                            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                                            while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                                                if(!isset($_GET['clear'])){
                                                                        if($RsTipo["cCodTipoDoc"]==$Rs['cCodTipoDoc']){
                                                                            $selecTipo="selected";
                                                                        }Else{
                                                                            $selecTipo="";
                                                                        }
                                                                } else {
                                                                        if($RsTipo["cCodTipoDoc"]==$_POST['cCodTipoDoc']){
                                                                            $selecTipo="selected";
                                                                        }Else{
                                                                            $selecTipo="";
                                                                        }
                                                                }
                                                              echo utf8_encode("<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>");
                                                            }
                                                            sqlsrv_free_stmt($rsTipo);
                                                            ?>
                                                        </select>&nbsp;
                                                        <span class="FormCellRequisito">*</span>
                                                    </td>
                                                    <td  width="160">Fecha Registro:</td>
                                                    <td style="padding-top:5px;"><b><?=$Rs['fFecDocumento']->format("d-m-Y H:i")//date("d-m-Y H:i", strtotime($Rs['fFecDocumento']))?></td>
                                                </tr>
                                                <?php
                                                //$sqlDerivo="SELECT iCodOficina FROM Tra_M_Grupo_Oficina_Detalle WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."'";
                                                //$rs=sqlsrv_query($cnx,$sqlDerivo);
                                                //$numOfi=sqlsrv_has_rows($rs);
                                                //if($numOfi){
                                                //    $x=1;
                                                ?>
                                                    <tr>
                                                      <td valign="top" >Oficina:</td>
                                                      <td valign="top" colspan="3">
                                                        <select name="iCodOficina" style="width:400px;" class="FormPropertReg form-control" onChange="OfiList('lstTrabajadores',this.value);">
                                                            <option value="">Seleccione:</option>
                                                            <?php
                                                            $sqlDep2="SELECT iCodOficina,cNomOficina,iFlgEstado FROM Tra_M_Oficinas WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' and iFlgEstado = 1 ORDER BY cNomOficina ASC ";
                                                            $rsDep2=sqlsrv_query($cnx,$sqlDep2);
                                                            while ($RsDep2=sqlsrv_fetch_array($rsDep2)){
                                                                if($RsDep2['iCodOficina']==($_POST['iCodOficina']??'')){
                                                                    $selecOfi="selected";
                                                                } else {
                                                                    $selecOfi="";
                                                                }
                                                              echo utf8_encode("<option value=".$RsDep2["iCodOficina"]." ".$selecOfi.">".$RsDep2["cNomOficina"]."</option>");
                                                            }
                                                            sqlsrv_free_stmt($rsDep2);
                                                            ?>
                                                        </select>  &nbsp;
                                                      </td>
                                                    </tr>
                                                <?php
                                                //}
                                                ?>
                                                <tr>
                                                    <td valign="top" >Delegar a:</td>
                                                    <td valign="top" colspan="3">
                                                        <table>
                                                            <tr>
                                                                <td>
                                                                        <select id="lstTrabajadores" name="lstTrabajadores[]" style="width:360px;" size="6" class="FormPropertReg form-control" multiple>
                                                                        <?php
                                                                        // if($x!=1){
                                                                        $sqlTrb="SELECT * FROM Tra_M_Trabajadores WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' and iCodTrabajador!= '".$_SESSION['CODIGO_TRABAJADOR']."'  and nFlgEstado=1 ORDER BY cNombresTrabajador ASC";
                                                                        //} else {
                                                                        //$sqlTrb="SELECT iCodTrabajador, cNombresTrabajador, cApellidosTrabajador, nFlgEstado FROM Tra_M_Trabajadores WHERE iCodOficina='".$_SESSION['iCodOficinaLogin']."' and nFlgEstado = 1 ORDER BY cNombresTrabajador ASC";
                                                                        //}
                                                                        $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                                                                        while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
                                                                            echo "<option value=".$RsTrb["iCodTrabajador"].">".$RsTrb["cNombresTrabajador"]." ".$RsTrb["cApellidosTrabajador"]."</option>";
                                                                        }
                                                                        sqlsrv_free_stmt($rsTrb);
                                                                        ?>
                                                                        </select>
                                                                        <br>
                                                                </td>
                                                                <td width="155">
                                                                        <table width="100%" border="0" style="height:95px">
                                                                            <tr>
                                                                                <td valign="top">
                                                                                    <a style="color:#006F00" href="javascript:agregar();">Añadir</a>
                                                                                </td>
                                                                                <td valign="top">
                                                                                    <a style="color:#006F00" href="javascript:agregar();">
                                                                                        <img src="images/icon_arrow_right.png" width="22" height="22" border="0">
                                                                                    </a>
                                                                                </td>
                                                                                <td width="20"></td>
                                                                                <td align="right" valign="bottom">
                                                                                    <a style="color:#800000" href="javascript:retirar();">
                                                                                        <img src="images/icon_arrow_left.png" width="22" height="22" border="0">
                                                                                    </a>
                                                                                </td>
                                                                                <td valign="bottom">
                                                                                    <a style="color:#800000" href="javascript:retirar();">Quitar</a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                </td>
                                                                <td>
                                                                    <select id="lstTrabajadoresSel" name="lstTrabajadoresSel[]" style="width:355px;" size="6" class="FormPropertReg form-control" multiple>
                                                                        <?php
                                                                        if($RsM['cFlgTipoMovimiento']==2){
                                                                            $sqlMTrb="SELECT * FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Trabajadores ON Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado=Tra_M_Trabajadores.iCodTrabajador WHERE iCodTramite='".$_GET['iCodTramite']."' ORDER BY iCodMovimiento ASC";
                                                                            $rsMTrb=sqlsrv_query($cnx,$sqlMTrb);
                                                                            while ($RsMTrb=sqlsrv_fetch_array($rsMTrb)){
                                                                                echo "<option value=".$RsMTrb["iCodTrabajadorDelegado"].">".$RsMTrb["cNombresTrabajador"]." ".$RsMTrb["cApellidosTrabajador"]."</option>";
                                                                            }
                                                                        } else {
                                                                            $sqlMTrb="SELECT * FROM Tra_M_Tramite_Movimientos LEFT OUTER JOIN Tra_M_Trabajadores ON Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar=Tra_M_Trabajadores.iCodTrabajador WHERE iCodTramite='".$_GET['iCodTramite']."' ORDER BY iCodMovimiento ASC";
                                                                            $rsMTrb=sqlsrv_query($cnx,$sqlMTrb);
                                                                            while ($RsMTrb=sqlsrv_fetch_array($rsMTrb)){
                                                                                echo "<option value=".$RsMTrb["iCodTrabajadorDerivar"].">".$RsMTrb["cNombresTrabajador"]." ".$RsMTrb["cApellidosTrabajador"]."</option>";
                                                                            }
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
                                                    <td valign="top" >Asunto:</td>
                                                    <td valign="top">
                                                            <textarea name="cAsunto" style="width:360px;height:55px" class="FormPropertReg form-control"><?php if(!isset($_GET['clear'])){ echo trim($Rs['cAsunto']); } else{ echo $_POST['cAsunto'];}?></textarea>&nbsp;
                                                            <span class="FormCellRequisito">*</span>
                                                            &nbsp;&nbsp;
                                                    </td>
                                                    <td valign="top" >Observaciones:</td>
                                                    <td valign="top">
                                                            <textarea name="cObservaciones" style="width:340px;height:55px" class="FormPropertReg form-control"><?php if(!isset($_GET['clear'])){ echo trim($Rs['cObservaciones']); }Else{ echo $_POST['cObservaciones'];}?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"  width="200">Adjuntar Archivo:</td>
                                                    <td valign="top">
                                                        <?php
                                                        $sqlDig="SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='".$_GET['iCodTramite']."'";
                                                        $rsDig=sqlsrv_query($cnx,$sqlDig,array(),array("Scrollable"=>"buffered"));
                                                        if(sqlsrv_num_rows($rsDig)>0) {
                                                            $RsDig = sqlsrv_fetch_array($rsDig);
                                                            if (file_exists("../cAlmacenArchivos/" . trim($RsDig['cNombreNuevo']))) {
                                                                echo "<a href='download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDig['cNombreNuevo'])."' > Descargar 
                                                                        <img src=images/icon_download.png border=0 width=16 height=16 alt='".trim($RsDig['cNombreNuevo'])."'>
                                                                      </a>";
                                                                echo "&nbsp;&nbsp;&nbsp;
                                                                      <a href='registroData.php?opcion=17&iCodDigital=".$RsDig['iCodDigital']."&iCodTramite=".$_GET['iCodTramite']."&URI=".$_GET['URI']."' style='color:#ff0000;' >
                                                                        <img src='images/icon_del.png' width=16 height=16 border=0> quitar adjunto
                                                                      </a>";
                                                            } else {
                                                                echo "<input type='file' name='fileUpLoadDigital' class='FormPropertReg' style='width:340px;' >";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td valign="top" >Fecha Plazo:</td>
                                                    <td valign="top" class="CellFormRegOnly">
                                                                <?php
                                                                if(!isset($_GET['clear'])){
                                                                    if($Rs['fFecPlazo']!=""){
                                                                        $fFecPlazo=$Rs['fFecPlazo']->format("d-m-Y");//date("d-m-Y", $Rs['fFecPlazo']);
                                                                    }
                                                                } else {
                                                                    $fFecPlazo=$_POST['fFecPlazo'];
                                                                }
                                                                ?>
                                                    </td>
                                                    <td><input type="text" readonly name="fFecPlazo" value="<?=$fFecPlazo?>" style="width:75px" class="FormPropertReg form-control"></td>
                                                    <td>
                                                        <div class="boton" style="width:24px;height:20px">
                                                            <a href="javascript:;" onclick="displayCalendar(document.forms[0].fFecPlazo,'dd-mm-yyyy',this,false)">
                                                                <img src="images/icon_calendar.png" width="22" height="20" border="0">
                                                            </a>&nbsp;
                                                            <span class="FormCellRequisito">*</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                     </tr>
                                     <tr>
                                            <td valign="top" >Enviar inmediatamente:</td>
                                            <td valign="top" colspan="3">
                                                <?php
                                                if(!isset($_GET['clear'])){
                                                        if($Rs['nFlgEnvio']==1){
                                                                $marcarEnvio="checked";
                                                        }
                                                } else {
                                                        if($_POST['nFlgEnvio']==1){
                                                                $marcarEnvio="checked";
                                                        }
                                                }
                                                if($Rs['nFlgEnvio']==1){ ?>
                                                    <input type="checkbox" name="tempoEnvio" checked disabled>
                                                    <input type="hidden" name="nFlgEnvio" value="1" checked>
                                                <?php
                                                } else{ ?>
                                                    <input type="checkbox" name="nFlgEnvio" value="1" <?=$marcarEnvio??''?>>
                                                <?php
                                                } ?>
                                            </td>
                                     </tr>
                                     <tr>
                                        <td colspan="4">
                                                <input name="button" type="button" class="btn btn-primary" value="Actualizar" onclick="Registrar();">
                                        </td>
                                     </tr>
                                  </form>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
    </main>
    <?php include("includes/userinfo.php");?>

    <?php include("includes/pie.php");?>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>