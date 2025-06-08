<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
    <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
    <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
    <script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
    <script Language="JavaScript">
        function activaOpciones1(){
            for (j=0;j<document.formulario.elements.length;j++){
                if(document.formulario.elements[j].type == "radio"){
                    document.formulario.elements[j].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=false;
            document.formulario.OpDerivar.disabled=true;
            document.formulario.OpDelegar.disabled=true;
            document.formulario.OpFinalizar.disabled=true;
            document.formulario.OpAvance.disabled=true;
            document.formulario.OpAceptar.filters.alpha.opacity=100;
            document.formulario.OpDerivar.filters.alpha.opacity=50;
            document.formulario.OpDelegar.filters.alpha.opacity=50;
            document.formulario.OpFinalizar.filters.alpha.opacity=50;
            document.formulario.OpAvance.filters.alpha.opacity=50;
        return false;
        }
        function activaOpciones2(){
            for (i=0;i<document.formulario.elements.length;i++){
                if(document.formulario.elements[i].type == "checkbox"){
                    document.formulario.elements[i].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=true;
            document.formulario.OpDerivar.disabled=false;
            document.formulario.OpDelegar.disabled=false;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=false;
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpDerivar.filters.alpha.opacity=100;
            document.formulario.OpDelegar.filters.alpha.opacity=100;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=100;
        return false;
        }
        function activaOpciones3(){
            for (i=0;i<document.formulario.elements.length;i++){
                if(document.formulario.elements[i].type == "checkbox"){
                    document.formulario.elements[i].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=true;
            document.formulario.OpDerivar.disabled=true;
            document.formulario.OpDelegar.disabled=true;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=true;
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpDerivar.filters.alpha.opacity=50;
            document.formulario.OpDelegar.filters.alpha.opacity=50;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=50;
        return false;
        }
        function activaOpciones4(){
            for (j=0;j<document.formulario.elements.length;j++){
                if(document.formulario.elements[j].type == "radio"){
                    document.formulario.elements[j].checked=0;
                }
            }
            document.formulario.OpAceptar.disabled=true;
            document.formulario.OpDerivar.disabled=true;
            document.formulario.OpDelegar.disabled=false;
            document.formulario.OpFinalizar.disabled=false;
            document.formulario.OpAvance.disabled=false;
            document.formulario.OpAceptar.filters.alpha.opacity=50;
            document.formulario.OpDerivar.filters.alpha.opacity=50;
            document.formulario.OpDelegar.filters.alpha.opacity=100;
            document.formulario.OpFinalizar.filters.alpha.opacity=100;
            document.formulario.OpAvance.filters.alpha.opacity=100;
        return false;
        }
        function activaAceptar()
        {
          document.formulario.opcion.value=1;
          document.formulario.method="POST";
          document.formulario.action="pendientesDataAdm.php";
          document.formulario.submit();
        }
        function activaDerivar()
        {
          document.formulario.OpAceptar.value="";
          document.formulario.OpDerivar.value="";
          document.formulario.OpDelegar.value="";
          document.formulario.OpFinalizar.value="";
          document.formulario.OpAvance.value="";
          document.formulario.opcion.value=1;
          document.formulario.method="GET";
          document.formulario.action="pendientesControlDerivarAdm.php";
          document.formulario.submit();
        }
        function activaDelegar()
        {
          document.formulario.method="POST";
          document.formulario.action="pendientesControlDelegarAdm.php";
          document.formulario.submit();
        }
        function activaFinalizar()
        {
          document.formulario.method="POST";
          document.formulario.action="pendientesControlFinalizarAdm.php";
          document.formulario.submit();
        }
        function activaAvance()
        {
          document.formulario.method="POST";
          document.formulario.action="pendientesControlAvanceAdm.php";
          document.formulario.submit();
        }
        function Buscar()
        {
          document.frmConsulta.action="<?=$_SERVER['PHP_SELF']?>";
          document.frmConsulta.submit();
        }
    </script>
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
                         <div class="card-header text-center "> >> documentos pendientes Generales </div>
                          <!--Card content-->
                         <div class="card-body">
                                <form name="frmConsulta" method="GET">
                                    <table>
                                        <tr>
                                        <td width="110" >Documentos:</td>
                                        <td width="390" align="left"><input type="checkbox" name="Entrada" value="1" <?php if($_GET['Entrada']==1) echo "checked"?>  />
                                          Entrada  &nbsp;&nbsp;&nbsp;
                                      <input type="checkbox" name="Interno" value="1" <?php if($_GET['Interno']==1) echo "checked"?> >Internos  &nbsp;&nbsp;&nbsp;
                                      <input type="checkbox" name="Anexo" value="1" <?php if($_GET['Anexo']==1) echo "checked"?> >Anexos</td>
                                      <td width="110" >Desde:</td>
                                        <td align="left">

                                        <td><input type="text" readonly name="fDesde" value="<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fDesde,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
                                        <td width="20"></td>
                                        <td >Hasta:&nbsp;<input type="text" readonly name="fHasta" value="<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>" style="width:75px" class="FormPropertReg form-control"></td><td><div class="boton" style="width:24px;height:20px"><a href="javascript:;" onclick="displayCalendar(document.forms[0].fHasta,'dd-mm-yyyy',this,false)"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a></div></td>
                                        </tr>
                                    </table>							</td>
                            </tr>
                            <tr>
                                <td width="110" >N&ordm; Documento:</td>
                                <td width="390" align="left"><input type="txt" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="28" class="FormPropertReg form-control"></td>
                                <td width="110" >Asunto:</td>
                                <td align="left"><input type="txt" name="cAsunto" value="<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>" size="65" class="FormPropertReg form-control">							</td>
                            </tr>
                            <tr>
                                <td width="110" >Tipo Documento:</td>
                                <td width="390" align="left">
                                        <select name="cCodTipoDoc" class="FormPropertReg form-control" style="width:180px" />
                                        <option value="">Seleccione:</option>
                                        <?
                                        include_once("../conexion/conexion.php");
                                        $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento ";
                            $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                            $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                            while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                if($RsTipo["cCodTipoDoc"]==$_GET['cCodTipoDoc']){
                                    $selecTipo="selected";
                                }Else{
                                    $selecTipo="";
                                }
                            echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
                            }
                            sqlsrv_free_stmt($rsTipo);
                                        ?>
                                        </select>							</td>
                                <td width="110" >Delegado:</td>
                                <td align="left" class="CellFormRegOnly">
                                        <select name="iCodTrabajadorDelegado" style="width:250px;" class="FormPropertReg form-control">
                                        <option value="">Seleccione:</option>
                                        <?php
                                        // $sqlTrb="SELECT * FROM Tra_M_Trabajadores ";
             //      		$sqlTrb.="WHERE iCodOficina = '$iCodOficina' ";
             //      		$sqlTrb .= "ORDER BY cApellidosTrabajador ASC";
                        $sqlTrb = "SELECT * FROM Tra_M_Trabajadores WHERE nFlgEstado = 1 
                                             ORDER BY cApellidosTrabajador, cNombresTrabajador";
                        $rsTrb=sqlsrv_query($cnx,$sqlTrb);
                        while ($RsTrb=sqlsrv_fetch_array($rsTrb)){
                            if($RsTrb[iCodTrabajador]==$_GET['iCodTrabajadorDelegado']){
                                $selecTrab="selected";
                            }Else{
                                $selecTrab="";
                            }
                          echo "<option value=\"".$RsTrb["iCodTrabajador"]."\" ".$selecTrab.">".$RsTrb["cApellidosTrabajador"]." ".$RsTrb["cNombresTrabajador"]."</option>";
                        }
                        sqlsrv_free_stmt($rsTrb);
                                        ?>
                                        </select>
                          </td>
                            </tr>
                            <tr>
                              <td height="10" >Tema:</td>
                              <td  align="left"><select name="iCodTema" style="width:192px;" class="FormPropertReg form-control">
                                <option value="">Seleccione:</option>
                                <?
                                        $sqlTem="SELECT * FROM Tra_M_Temas WHERE  iCodOficina = '".$_SESSION['iCodOficinaLogin']."' ";
                                        $sqlTem .= "ORDER BY cDesTema ASC";
                        $rsTem=sqlsrv_query($cnx,$sqlTem);
                        while ($RsTem=sqlsrv_fetch_array($rsTem)){
                            if($RsTem['iCodTema']==$_GET['iCodTema']){
                                $selecTem="selected";
                            }Else{
                                $selecTem="";
                            }
                          echo "<option value=\"".$RsTem["iCodTema"]."\" ".$selecTem.">".$RsTem["cDesTema"]." ".$RsTem["cNombresTrabajador"]."</option>";
                        }
                        sqlsrv_free_stmt($rsTem);
                                        ?>
                                </select></td>
                              <td height="10" >Estado:</td>
                              <td><input type="checkbox" name="Aceptado" value="1" <?php if($_GET['Aceptado']==1) echo "checked"?>  />
                                Aceptado  &nbsp;&nbsp;&nbsp;
      <input type="checkbox" name="SAceptado" value="1" <?php if($_GET['SAceptado']==1) echo "checked"?> />
                                Sin Aceptar </td>
                              </tr>
                            <tr>
                                <td height="10" >Oficina:</td>
                                <td  align="left">
                                    <select name="iCodOficina" class="FormPropertReg form-control" style="width:360px" />
                        <option value="">Seleccione:</option>
                      <?
                         $sqlOfi="SP_OFICINA_LISTA_COMBO ";
                         $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                         while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                         if($RsOfi["iCodOficina"]==$_GET['iCodOficina']){
                                                    $selecClas="selected";
                         }Else{
                                $selecClas="";
                         }
                         echo "<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>";
                         }
                         sqlsrv_free_stmt($rsOfi);
                      ?>
                </select></td>
                            <td height="10" >&nbsp;</td>
                            <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">
                                <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"> </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"> </button>�
                                &nbsp;&nbsp;
                                <button class="btn btn-primary" onclick="window.open('pendientesControlAdm.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&Entrada=<?=(isset($_GET['Entrada'])?$_GET['Entrada']:'')?>&Interno=<?=(isset($_GET['Interno'])?$_GET['Interno']:'')?>&Anexo=<?=(isset($_GET['Anexo'])?$_GET['Anexo']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodTrabajadorDelegado=<?=(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')?>&iCodTema=<?=(isset($_GET['iCodTema'])?$_GET['iCodTema']:'')?>&EstadoMov=<?=(isset($_GET['EstadoMov'])?$_GET['EstadoMov']:'')?>&Aceptado=<?=(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')?>&SAceptado=<?=(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
                                &nbsp;&nbsp;
                                <button class="btn btn-primary" onclick="window.open('pendientesControlAdm2.php?fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Oficina Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>

                                                        �
                                                            </td>
                            </tr>
                                </form>



                        <form name="formulario">
                        <input type="hidden" name="opcion" value="">
                        <input type="hidden" name="iCodOficina" value="<?=$_GET['iCodOficina']?>">
                    <tr>
                    <td align="left" valign="bottom">
                            <button class="FormBotonAccion btn btn-primary" name="OpAceptar" disabled onclick="activaAceptar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)">
                            <table cellspacing="0" cellpadding="0">
                                <tr><td><img src="images/icon_aceptar.png" width="17" height="17" border="0"></td>
                                <td>&nbsp;Aceptar</td></tr>
                            </table>
                            </button>
                            <span style="font-size:18px">&#124;&nbsp;</span>
                            <button class="FormBotonAccion btn btn-primary" name="OpDerivar" disabled onclick="activaDerivar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_derivar.png" width="17" height="17" border="0">Derivar </button>
                            <span style="font-size:18px">&#124;&nbsp;</span>
                            <button class="FormBotonAccion btn btn-primary" name="OpDelegar" disabled onclick="activaDelegar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_delegar.png" width="17" height="17" border="0">Delegar </button>
                            <span style="font-size:18px">&#124;&nbsp;</span>
                            <button class="FormBotonAccion btn btn-primary" name="OpFinalizar" disabled onclick="activaFinalizar();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_finalizar.png" width="17" height="17" border="0">Finalizar </button>
                            <span style="font-size:18px">&#124;&nbsp;</span>
                            <button class="FormBotonAccion btn btn-primary" name="OpAvance" disabled onclick="activaAvance();" onMouseOver="this.style.cursor='hand'" style="FILTER:alpha(opacity=50)"><img src="images/icon_avance.png" width="17" height="17" border="0">Avance </button>
                    </td>
                    </tr>
                    </table>
                    <?
                    if($_GET['fDesde']!=""){ $fDesde=date("Y-m-d", strtotime($_GET['fDesde'])); }
                    if($_GET['fHasta']!=""){
                    $fHasta=date("Y-m-d", strtotime($_GET['fHasta']));

                    function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                          $date_r = getdate(strtotime($date));
                          $date_result = date("Y-m-d", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),($date_r["year"]+$yy)));
                          return $date_result;
                    }
                    $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
                    }
            function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
            $total_paginas = ceil($total/$por_pagina);
            $anterior = $actual - 1;
            $posterior = $actual + 1;
            $minimo = $maxpags ? max(1, $actual-ceil($maxpags/2)): 1;
            $maximo = $maxpags ? min($total_paginas, $actual+floor($maxpags/2)): $total_paginas;
            if ($actual>1)
            $texto = "<a href=\"$enlace$anterior\">�</a> ";
            else
            $texto = "<b>�</b> ";
            if ($minimo!=1) $texto.= "... ";
            for ($i=$minimo; $i<$actual; $i++)
            $texto .= "<a href=\"$enlace$i\">$i</a> ";
            $texto .= "<b>$actual</b> ";
            for ($i=$actual+1; $i<=$maximo; $i++)
            $texto .= "<a href=\"$enlace$i\">$i</a> ";
            if ($maximo!=$total_paginas) $texto.= "... ";
            if ($actual<$total_paginas)
            $texto .= "<a href=\"$enlace$posterior\">�</a>";
            else
            $texto .= "<b>�</b>";
            return $texto;
           }


           if (!isset($pag)) $pag = 1; // Por defecto, pagina 1
           $tampag = 15;
           $reg1 = ($pag-1) * $tampag;

          // ordenamiento
           if($_GET['campo']==""){
           $campo="Fecha";
           }Else{
           $campo=$_GET['campo'];
           }

          if($_GET['orden']==""){
         $orden="DESC";
         }Else{
        $orden=$_GET['orden'];
         }

         //invertir orden
         if($orden=="ASC") $cambio="DESC";
         if($orden=="DESC") $cambio="ASC";


                    /*
            $sqlTra="SELECT  cDescTipoDoc,Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite ";
            $sqlTra.=" LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ,Tra_M_Tramite_Movimientos ";
        $sqlTra.="WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
           if($_GET['Entrada']==1 AND $_GET['Interno']==""){
            $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=1 ";
           }
           if($_GET['Entrada']=="" AND $_GET['Interno']==1){
            $sqlTra.="AND Tra_M_Tramite.nFlgTipoDoc=2 ";
           }
           if($_GET['Entrada']==1 AND $_GET['Interno']==1){
            $sqlTra.="AND (Tra_M_Tramite.nFlgTipoDoc=1 OR Tra_M_Tramite.nFlgTipoDoc=2) ";
           }
           if($_GET['fDesde']!="" AND $_GET['fHasta']==""){
            $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar>'$fDesde' ";
           }
           if($_GET['fDesde']=="" AND $_GET['fHasta']!=""){
            $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar<='$fHasta' ";
           }
           if($_GET['fDesde']!="" AND $_GET['fHasta']!=""){
            $sqlTra.="AND Tra_M_Tramite_Movimientos.fFecDerivar BETWEEN '$fDesde' AND '$fHasta' ";
           }
           if($_GET['cCodificacion']!=""){
            $sqlTra.="AND Tra_M_Tramite.cCodificacion LIKE '%".$_GET['cCodificacion']."%' ";
           }
           if($_GET['cAsunto']!=""){
            $sqlTra.="AND Tra_M_Tramite.cAsunto LIKE '%".$_GET['cAsunto']."%' ";
           }
           if($_GET['cCodTipoDoc']!=""){
            $sqlTra.="AND Tra_M_Tramite.cCodTipoDoc='".$_GET['cCodTipoDoc']."' ";
           }
           if($_GET['iCodTrabajadorDelegado']!=""){
            $sqlTra.="AND Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='$_GET['iCodTrabajadorDelegado']' ";
           }
           if($_GET['EstadoMov']==""){
            $sqlTra.="AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3) ";
           }
            $sqlTra.="AND Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' ";
                $sqlTra.="AND Tra_M_Tramite.nFlgEnvio=1 ";
                $sqlTra.="AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 ";*/
          //  $sqlTra.= "ORDER BY ".$campo." ".$orden." ";

          //////////////////////////////////////////////nuevo /////////////////////////////////////////////////////*
          /*
    Entrada
    Interno

    <?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?> cCodificacion


    iCodOficina
    <?=$_GET[]?>
    <?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>
    <?=$_GET[]?>



    */
    if($_GET['Entrada']=="" && $_GET['Interno']=="" && $_GET['Anexo']=="" && $_GET['cCodificacion']=="" && $_GET['cCodTipoDoc']=="" && $_GET['iCodTema']=="" && $_GET['iCodOficina']=="" && $_GET['iCodOficina']=="" && $_GET['fDesde']==""  && $_GET['fHasta']=="" && $_GET['cAsunto']=="" && $_GET['iCodTrabajadorDelegado']=="" && $_GET['Aceptado']=="" && $_GET['SAceptado']=="" ){
        $sqlTra= " SP_BANDEJA_PENDIENTES_REPORTE_A  '$fDesde','$fHasta','".$_GET['Entrada']."','".$_GET['Interno']."','$_GET['Anexo']','%".$_GET['cCodificacion']."%', ";
        $sqlTra.= " '%".$_GET['cAsunto']."%', '".$_GET['cCodTipoDoc']."', '$_GET['iCodTrabajadorDelegado']', '".$_GET['iCodTema']."', '$_GET['EstadoMov']', '$_GET['Aceptado']', '$_GET['SAceptado']','$_GET['iCodOficina']','$campo','$orden' ";
          $rsTra=sqlsrv_query($cnx,$sqlTra);
        $sqlTraCo= " SP_BANDEJA_PENDIENTES_REPORTE_CONTEO  '$fDesde','$fHasta','".$_GET['Entrada']."','".$_GET['Interno']."','$_GET['Anexo']','%".$_GET['cCodificacion']."%', ";
        $sqlTraCo.= " '%".$_GET['cAsunto']."%', '".$_GET['cCodTipoDoc']."', '$_GET['iCodTrabajadorDelegado']', '".$_GET['iCodTema']."', '$_GET['EstadoMov']', '$_GET['Aceptado']', '$_GET['SAceptado']','$_GET['iCodOficina']','$campo','$orden' ";

        $rsTraCo=sqlsrv_query($cnx,$sqlTraCo);
        $RsTraCo=sqlsrv_fetch_array($rsTraCo);
        $rsTraCoF=$RsTraCo[c];
        $total2=$rsTraCoF;
    //	echo $sqlTraCo;
        $total = sqlsrv_has_rows($rsTra);
       }
       else
        {
            $sqlTra = " SP_BANDEJA_PENDIENTES_REPORTE  '$fDesde','$fHasta','".$_GET['Entrada']."','".$_GET['Interno']."','$_GET['Anexo']','%".$_GET['cCodificacion']."%', ";
            $sqlTra.= " '%".$_GET['cAsunto']."%', '".$_GET['cCodTipoDoc']."', '$_GET['iCodTrabajadorDelegado']', '".$_GET['iCodTema']."', '$_GET['EstadoMov']', '$_GET['Aceptado']', '$_GET['SAceptado']','$_GET['iCodOficina']','$campo','$orden' ";
            //echo $sqlTra;
        $rsTra = sqlsrv_query($cnx,$sqlTra);
            $total = sqlsrv_has_rows($rsTra);
           }

        //	$rsTraCoF
          //  $total = sqlsrv_has_rows($rsTraCoF);
            //echo $sqlTra;
           ?>

                    <tr>
            <td width="20" class="headColumnas"></td>
            <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Codigo&orden=<?=$cambio?>&Tra_M_Tramite.cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Codigo"){ echo "underline"; }Else{ echo "none";}?>">N&ordm; TRÁMITE</a></td>
                    <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&nFlgTipoDoc=<?=(isset($_GET['nFlgTipoDoc'])?$_GET['nFlgTipoDoc']:'')?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Tipo de Documento</a></td>
                    <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=cNombre&orden=<?=$cambio?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>"  style=" text-decoration:<?php if($campo=="cNombre"){ echo "underline"; }Else{ echo "none";}?>">Nombre / Razón Social</a></td>
                    <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Asunto&orden=<?=$cambio?>&cAsunto=<?=(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')?>"  style=" text-decoration:<?php if($campo=="Asunto"){ echo "underline"; }Else{ echo "none";}?>">Asunto / Procedimiento TUPA</a></td>
                    <td class="headColumnas">Derivado Por</td>
                    <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Recepcion&orden=<?=$cambio?>&fFecRecepcion=<?=$_GET[fFecRecepcion]?>"  style=" text-decoration:<?php if($campo=="Recepcion"){ echo "underline"; }Else{ echo "none";}?>">Recepción</a></td>
                    <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Trabajador&orden=<?=$cambio?>&iCodTrabajadorDerivar=<?=(isset($_GET['iCodTrabajadorDerivar'])?$_GET['iCodTrabajadorDerivar']:'')?>"  style=" text-decoration:<?php if($campo=="Trabajador"){ echo "underline"; }Else{ echo "none";}?>">Responsable/ Delegado</a></td>
                    <td class="headColumnas"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Estado&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>"  style=" text-decoration:<?php if($campo=="Estado"){ echo "underline"; }Else{ echo "none";}?>">Estado</a></td>
                    <td class="headColumnas">Opción</td>
                    </tr>
      <?
    //   $numrows=sqlsrv_has_rows($rsTra);
     $numrows=$total;

    if($numrows==0){
            echo "NO SE ENCONTRARON REGISTROS<br>";
            echo "TOTAL DE REGISTROS : ".$numrows;
    }else{
        if($_GET['Entrada']=="" && $_GET['Interno']=="" && $_GET['Anexo']=="" && $_GET['cCodificacion']=="" && $_GET['cCodTipoDoc']=="" && $_GET['iCodTema']=="" && $_GET['iCodOficina']=="" && $_GET['iCodOficina']=="" && $_GET['fDesde']==""  && $_GET['fHasta']=="" && $_GET['cAsunto']=="" && $_GET['iCodTrabajadorDelegado']=="" && $_GET['Aceptado']=="" && $_GET['SAceptado']=="" ){
     echo "TOTAL DE REGISTROS : ".$total2;}

     else {
         if($numrows<500){
         echo "TOTAL DE REGISTROS : ".$numrows;

         }
         else
         {
        $sqlTra2= "SP_BANDEJA_PENDIENTES_REPORTE_B  '$fDesde','$fHasta','".$_GET['Entrada']."','".$_GET['Interno']."','$_GET['Anexo']','%".$_GET['cCodificacion']."%', ";
            $sqlTra2.= " '%".$_GET['cAsunto']."%', '".$_GET['cCodTipoDoc']."', '$_GET['iCodTrabajadorDelegado']', '".$_GET['iCodTema']."', '$_GET['EstadoMov']', '$_GET['Aceptado']', '$_GET['SAceptado']','$_GET['iCodOficina']','$campo','$orden' ";
            $rsTra2=sqlsrv_query($cnx,$sqlTra2);
            $total2 = sqlsrv_fetch_array($rsTra2);
            //	echo  $sqlTra2;
            echo "TOTAL DE REGISTROS : ".$total2[0];
             }
         }
            // echo "TOTAL DE REGISTROS : ".$numrows;
    ///////////////////////////////////////////////////////
       for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
            //    for ($i=$reg1; min($reg1+$tampag, $total)<100; $i++) {
               //
           sqlsrv_fetch_array($rsTra, $i);
    //sqlsrv_fetch_array($rsTra, $i);

           $RsTra=sqlsrv_fetch_array($rsTra);
    ///////////////////////////////////////////////////////
           // while ($RsTra=sqlsrv_fetch_array($rsTra)){
                    if ($color == "#DDEDFF"){
                            $color = "#F9F9F9";
                        }else{
                            $color = "#DDEDFF";
                        }
                        if ($color == ""){
                            $color = "#F9F9F9";
                        }
            ?>


            <tr bgcolor="<?=$color?>" onMouseOver="this.style.backgroundColor='#BFDEFF'" OnMouseOut="this.style.backgroundColor='<?=$color?>'" >
            <td align="left" valign="top">
             <?php if($RsTra['fFecRecepcion']!=""){?>
                <input type="checkbox" name="MovimientoAccion[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones4();" >
                 <?php }?>
            </td>
        <td width="95" valign="top" align="left">
                <?php if($RsTra['nFlgTipoDoc']==1){?>
                    <a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramite']?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$RsTra['cCodificacion']?></a>
                <?php}
                    if($RsTra['nFlgTipoDoc']==2){
                            echo "INTERNO";}
                   if($RsTra['nFlgTipoDoc']==3){
                            echo "SALIDA";}
                        if($RsTra['nFlgTipoDoc']==4){
                ?>
                    <a href="registroDetalles.php?iCodTramite=<?=$RsTra['iCodTramiteRel']?>"  rel="lyteframe" title="Detalle del TRÁMITE" rev="width: 970px; height: 550px; scrolling: auto; border:no"><?=$RsTra['cCodificacion']?></a>
                <?php}?>
                <?
                echo "<div style=color:#727272>".date("d-m-Y", strtotime($RsTra['fFecRegistro']))."</div>";
            echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($RsTra['fFecRegistro']))."</div>";
            if($RsTra['cFlgTipoMovimiento']==4){
             echo "<div style=color:#FF0000;font-size:12px>Copia</div>";
            }
            ?>
                </td>
          <td width="95" valign="top" align="left">
                <?php echo $RsTra['cDescTipoDoc'];
                    if($RsTra['nFlgTipoDoc']==1 ){
                        echo "<div style=color:#808080;text-transform:uppercase>".$RsTra['cNroDocumento']."</div>";
                    }
                    else if($RsTra['nFlgTipoDoc']==2 ){
                        echo "<br>";
                        echo "<a style=\"color:#0067CE\" href=\"registroOficinaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 450px; scrolling: auto; border:no\">";
                echo $RsTra['cCodificacion'];
                echo "</a>";
                    }
                else if($RsTra['nFlgTipoDoc']==3 ){
                echo "<br>";
                echo "<a style=\"color:#0067CE\" href=\"registroSalidaDetalles.php?iCodTramite=".$RsTra['iCodTramite']."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
                echo $RsTra['cCodificacion'];
                echo "</a>";
        }
                    ?>
                </td>
          <td width="210" align="left" valign="top">
                <?
              $rsRem=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Remitente WHERE iCodRemitente='".$RsTra['iCodRemitente']."'");
              $RsRem=sqlsrv_fetch_array($rsRem);
                    if($RsRem['cTipoPersona']=='1'){
                           echo "<div style=color:#000000;>".$RsRem['cNombre']."</div>";
                   echo "<div style=color:#0154AF;font-size:10px;text-align:left>DNI: ".$RsRem['nNumDocumento']."</div>";
                        }else if ($RsRem['cTipoPersona']=='2') {
                           echo "<div style=color:#000000;>".$RsRem['cNombre']."</div>";
                           echo "<div style=color:#408080;>".$RsTra['cNomRemite']."</div>";
                   echo "<div style=color:#0154AF;font-size:10px;>RUC:".$RsRem['nNumDocumento']."</div>";
                } else {
                             echo "";
                        }
                        sqlsrv_free_stmt($rsRem);

                        if($RsTra['cFlgTipoMovimiento']==3){
                            echo "<div style=color:#006600;><b>ANEXO</b></div>";
                        }
                ?>
            </td>
            <td width="300" align="left" valign="top"">
                <?
                echo $RsTra['cAsunto'];
                if($RsTra['iCodTupa']!=""){
                        $sqlTup="SELECT * FROM Tra_M_Tupa WHERE iCodTupa='$RsTra['iCodTupa']'";
                    $rsTup=sqlsrv_query($cnx,$sqlTup);
                    $RsTup=sqlsrv_fetch_array($rsTup);
                    echo "<div style=color:#0154AF>".$RsTup["cNomTupa"]."</div";
                }
                ?>
            </td>
            <td width="80" align="center" valign="top">
            <?
                  $sqlSig="SP_OFICINA_LISTA_AR '$RsTra[iCodOficinaOrigen]'";
                  $rsSig=sqlsrv_query($cnx,$sqlSig);
                  $RsSig=sqlsrv_fetch_array($rsSig);
                    echo $RsSig["cSiglaOficina"];
                  sqlsrv_free_stmt($rsSig);
                  $sqlIndic="SELECT * FROM Tra_M_Indicaciones WHERE iCodIndicacion='$RsTra[iCodIndicacion]'";
                  $rsIndic=sqlsrv_query($cnx,$sqlIndic);
                  $RsIndic=sqlsrv_fetch_array($rsIndic);
                    echo "<div style=color:#808080;font-size:10px align=left>".$RsIndic["cIndicacion"]."</div>";
                  sqlsrv_free_stmt($rsIndic);
                  ?>

                    <?
                        echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecDerivar']))."</div>";
                        echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra['fFecDerivar']))."</div>";
                    ?>
            </td>
            <td width="80" align="left" valign="top">
                <?
                if($RsTra['fFecRecepcion']==""){
                        echo "<div style=color:#ff0000>sin aceptar</div>";
                }Else{
                        echo "<div style=color:#0154AF>aceptado</div>";
                        echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra['fFecRecepcion']))."</div>";
                        echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra['fFecRecepcion']))."</div>";
                }
                ?>
            </td>
            <td width="150" align="center" valign="top">
                <?
              $rsResp=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$RsTra['iCodTrabajadorDerivar']."'");
              $RsResp=sqlsrv_fetch_array($rsResp);
              echo $RsResp["cApellidosTrabajador"]." ".$RsResp["cNombresTrabajador"];
                        sqlsrv_free_stmt($rsResp);

                if($RsTra['iCodTrabajadorDelegado']!=""){
                        $rsDelg=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_GET['iCodTrabajadorDelegado']."'");
                $RsDelg=sqlsrv_fetch_array($rsDelg);
                echo "<div style=color:#005B2E;font-size:12px>".$RsDelg["cApellidosTrabajador"]." ".$RsDelg["cNombresTrabajador"]."</div>";
                            sqlsrv_free_stmt($rsDelg);
                            echo "<div style=color:#0154AF>".date("d-m-Y", strtotime($RsTra[fFecDelegado]))."</div>";
                            echo "<div style=color:#0154AF;font-size:10px>".date("G:i", strtotime($RsTra[fFecDelegado]))."</div>";
                        }
                        if($RsTra['nEstadoMovimiento']==4){ //respondido
                            echo "<a style=\"color:#0067CE\" href=\"pendientesControlVerRpta.php?iCodMovimiento=".$RsTra['iCodMovimiento']."\" rel=\"lyteframe\" title=\"Detalle Respuesta\" rev=\"width: 480px; height: 270px; scrolling: auto; border:no\">RESPONDIDO</a>";
                        }
                ?>

            </td>
            <td width="100" valign="top">
                <?
                if($RsTra['fFecRecepcion']==""){
                        switch ($RsTra['nEstadoMovimiento']){
                            case 1:
                                echo "Pendiente";
                            break;
                            case 2:
                                echo "Derivado";
                            break;
                            case 3:
                                echo "Asignado";
                            break;
                            case 4:
                                echo "Finalizado";
                            break;
                            }
                    }Else{
                                echo "En Proceso";
                    }
                        $sqlAvan="SELECT TOP(1) * FROM Tra_M_Tramite_Avance WHERE iCodMovimiento='$RsTra['iCodMovimiento']' ORDER BY iCodAvance DESC";
                        $rsAvan=sqlsrv_query($cnx,$sqlAvan);
                        if(sqlsrv_has_rows($rsAvan)>0){
                        $RsAvan=sqlsrv_fetch_array($rsAvan);
                            echo "<hr>";
                                        echo "<div style=font-size:10px>".$RsAvan[cObservacionesAvance]."</div>";
                        }
                ?>
            </td>
            <td width="110" valign="middle">
             <?
                    if($RsTra['cFlgTipoMovimiento']!=4){?>
                        <?php if($RsTra['fFecRecepcion']==""){?>
                                        <input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
                                <?php } else{?>
                                        <?php if($RsTra['cFlgTipoMovimiento']!=3 ){?>
                                            <input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2();">
                                        <?php } else{?>
                                            <input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
                                        <?php}?>

                                        <?php if($RsTra['iCodTupa']=="" && $RsTra['nFlgTipoDoc']==1){?>
                                <a href="registroDiasVigencia.php?iCodTramite=<?=$RsTra['iCodTramite']?>"  rel="lyteframe" title="Ingresar Dias de Respuesta" rev="width: 400px; height: 160px; scrolling: auto; border:no"><img src="images/icon_calendar.png" width="22" height="20" border="0"></a>
                                        <?php}?>


                                        <?php if($RsTra['nFlgTipoDoc']==1 or $RsTra['nFlgTipoDoc']==2){?>
                                <a href="registroTemaSelect.php?iCodTramite=<?=$RsTra['iCodTramite']?>&iCodOficinaRegistro=<?=$_SESSION['iCodOficinaLogin']?>"  rel="lyteframe" title="Vincular Tema" rev="width: 600px; height: 400px; scrolling: auto; border:no"><img src="images/page_add.png" width="22" height="20" border="0"></a>
                        <?php}?>
                        <?php}?>
                <?php }
                else if($RsTra['cFlgTipoMovimiento']==4){
                if($RsTra['fFecRecepcion']==""){?>
                            <input type="checkbox" name="iCodMovimiento[]" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones1();">
                                <?php }
                    else {
                     if($RsTra['nFlgTipoDoc']==3){ ?>
                <input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones3();">
                        <?      } else{ ?>

                        <input type="radio" name="iCodMovimientoAccion" value="<?=$RsTra['iCodMovimiento']?>" onclick="activaOpciones2();">
                       <a href="registroTemaSelect.php?iCodTramite=<?=$RsTra['iCodTramite']?>&iCodOficinaRegistro=<?=$_SESSION['iCodOficinaLogin']?>"  rel="lyteframe" title="Vincular Tema" rev="width: 600px; height: 400px; scrolling: auto; border:no"><img src="images/page_add.png" width="22" height="20" border="0"></a>
                <?	}
                }
                }
                ?>
            </td>
            </tr>
            <?
            }
            }
            sqlsrv_free_stmt($rsTra);
                    ?>
                            </form>
                    </table>
                    <?php echo paginar($pag, $total, $tampag, "pendientesControlAdmi.php?fDesde=".(isset($_GET['fDesde'])?$_GET['fDesde']:'')."&fHasta=".(isset($_GET['fHasta'])?$_GET['fHasta']:'')."&cCodificacion=".(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')."&cAsunto=".(isset($_GET['cAsunto'])?$_GET['cAsunto']:'')."&cCodTipoDoc=".(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')."&iCodTrabajadorDelegado=".(isset($_GET['iCodTrabajadorDelegado'])?$_GET['iCodTrabajadorDelegado']:'')."&Entrada=".(isset($_GET['Entrada'])?$_GET['Entrada']:'')."&Interno=".(isset($_GET['Interno'])?$_GET['Interno']:'')."&Anexo=".(isset($_GET['Anexo'])?$_GET['Anexo']:'')."&Aceptado=".(isset($_GET['Aceptado'])?$_GET['Aceptado']:'')."&SAceptado=".(isset($_GET['SAceptado'])?$_GET['SAceptado']:'')."&iCodOficina=".$_GET['iCodOficina']."&campo=".$campo."&orden=".$orden."&pag="); ?>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
     </main>

     <?php include("includes/userinfo.php"); ?>
     <?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>