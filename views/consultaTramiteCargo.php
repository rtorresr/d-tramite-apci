<?php
session_start();
if($_SESSION['CODIGO_TRABAJADOR'] != ""){
  include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php"); ?>

<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>

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
                    <div class="card-header text-center "> Consulta >> Control de Cargos</div>
                    <!--Card content-->
                    <div class="card-body">
                       <form name="frmConsultaTramiteCargo" method="POST" action="consultaTramiteCargo.php">
                           <input type="hidden" name="opcion" value="">
                           <input type="hidden" name="codigoTramite" id="codigoTramite" value="" />
                           <div class="form-row">
                               <div class="col-lg-2">
                                   <div class="md-form">
                                       <label >N&ordm; Documento:</label>
                                       <input type="txt" name="cCodificacion" value="<?=$_REQUEST[cCodificacion]?>" size="28" class="FormPropertReg form-control"  />
                                   </div>
                               </div>
                               <div class="col-lg-2 ">
                                   <div class="md-form">
                                       <input placeholder="dd-mm-aaaa" value="<?=$fecini?>" type="text"
                                              id="date-picker-example" name="fDesde"  class="FormPropertReg form-control datepicker">
                                       <label for="date-picker-example">Desde:</label>
                                   </div>
                               </div>
                               <div class="col-lg-2 ">
                                   <div class="md-form">
                                       <input placeholder="dd-mm-aaaa" name="fHasta" value="<?=$fecfin?>" type="text"
                                              id="date-picker-example"  class="FormPropertReg form-control datepicker">
                                       <label for="date-picker-example">Hasta:</label>
                                   </div>
                               </div>

                           <div class="col-lg-2 ">
                               <label>Tipo Documento:</label>
                               <select name="cCodTipoDoc" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                       searchable="Buscar aqui..">
                                   <option value="">Seleccione:</option>
                                   <?php
       $sqlTipo="SELECT * FROM Tra_M_Tipo_Documento WHERE nFlgSalida=1 ";
                                   $sqlTipo.="ORDER BY cDescTipoDoc ASC";
                                   $rsTipo=sqlsrv_query($cnx,$sqlTipo);
                                   while ($RsTipo=sqlsrv_fetch_array($rsTipo)){
                                       if($RsTipo["cCodTipoDoc"]==$_REQUEST[cCodTipoDoc]){
                                           $selecTipo="selected";
                                       }Else{
                                           $selecTipo="";
                                       }
                                       echo "<option value=".$RsTipo["cCodTipoDoc"]." ".$selecTipo.">".$RsTipo["cDescTipoDoc"]."</option>";
                                   }
                                   sqlsrv_free_stmt($rsTipo);
                                   ?>
                               </select>
                           </div>
                           <div class="col-lg-2 ">
                               <label for="cNomRemite">Destino:</label>
                               <input type="text" name="cNombre" id="cNombre" value="<?=$_REQUEST['cNombre']?>" size="28" class="FormPropertReg form-control" >
                           </div>
                           <div class="col-lg-2 ">
                               <label>Oficina Origen:</label>
                               <select name="iCodOficina" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                       searchable="Buscar aqui.." >
                                   <option value="">Seleccione:</option>
                                   <?php
       $sqlOfi="SP_OFICINA_LISTA_COMBO ";
                                   $rsOfi=sqlsrv_query($cnx,$sqlOfi);
                                   while ($RsOfi=sqlsrv_fetch_array($rsOfi)){
                                       if($RsOfi["iCodOficina"]==$_REQUEST['iCodOficina']){
                                           $selecClas="selected";
                                       }Else{
                                           $selecClas="";
                                       }
                                       echo utf8_encode("<option value=".$RsOfi["iCodOficina"]." ".$selecClas.">".$RsOfi["cNomOficina"]."</option>");
                                   }
                                   sqlsrv_free_stmt($rsOfi);
                                   ?>
                               </select>
                           </div>

                           <div class="col-lg-2 ">
                               <label for="cDireccion">Direccion:</label>
                               <input type="txt" name="cDireccion" value="<?=$_POST[cDireccion]?>" size="65" class="FormPropertReg form-control">
                           </div>

                           <div class="col-lg-2 ">
                               <label>Mensajeria:</label>
                               <select name="iCodTrabajadorEnvio" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                       searchable="Buscar aqui.." >
                                   <option value="">Seleccione:</option>
                                   <?php
                                   $sqlTrab="SELECT TOP 50 * FROM Tra_M_Trabajadores WHERE iCodCategoria=2 OR iCodCategoria=3 OR iCodCategoria=4  ORDER BY cNombresTrabajador,cApellidosTrabajador";
                                   $rsTrab=sqlsrv_query($cnx,$sqlTrab);
                                   while ($RsTrab=sqlsrv_fetch_array($rsTrab)){
                                       if($RsTrab["iCodTrabajador"]==$_REQUEST[iCodTrabajadorEnvio]){
                                           $selec="selected";
                                       }Else{
                                           $selec="";
                                       }
                                       echo "<option value=".$RsTrab["iCodTrabajador"]." ".$selec.">".$RsTrab["cNombresTrabajador"]." ".$RsTrab["cApellidosTrabajador"]."</option>";
                                   }
                                   sqlsrv_free_stmt($rsTrab);
                                   ?>
                               </select>
                           </div>
                               <div class="col-lg-2 ">
                                   <label>Departamento:</label>
                                   <?php
                                   $sqlDep="select * from Tra_U_Departamento order by cCodDepartamento ";
                                   $rsDep=sqlsrv_query($cnx,$sqlDep);
                                   ?>
                                   <select name="cCodDepartamento" onChange="releer();" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                           searchable="Buscar aqui..">
                                       <option value="">Seleccione:</option>
                                       <?php   while ($RsDep=sqlsrv_fetch_array($rsDep)){
                                           if($RsDep["cCodDepartamento"]==$_REQUEST[cCodDepartamento]){
                                               $selecDep="selected";
                                           }else{
                                               $selecDep="";
                                           }
                                           echo "<option value=".$RsDep["cCodDepartamento"]." ".$selecDep.">".$RsDep[cNomDepartamento]."</option>";
                                       }
                                       sqlsrv_free_stmt($rsDep);
                                       ?>
                                   </select>
                               </div>
                           <div class="col-lg-2 ">
                               <label>Provincia:</label>
                               <?php
                               $sqlPro="SELECT cCodDepartamento,cCodProvincia,cNomProvincia FROM Tra_U_Provincia WHERE cCodDepartamento='$_POST[cCodDepartamento]'  order by cNomProvincia ASC ";
                               $rsPro=sqlsrv_query($cnx,$sqlPro);
                               ?>
                               <select  name="cCodProvincia" <?php if($_REQUEST[cCodDepartamento]=="") echo "disabled"?>  onChange="releer();"
                                        class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                        searchable="Buscar aqui..">
                                   <option value="">Seleccione:</option>
                                   <?   while ($RsPro=sqlsrv_fetch_array($rsPro)){
                                       if($RsPro["cCodProvincia"]==$_REQUEST[cCodProvincia]){
                                           $selecPro="selected";
                                       }else{
                                           $selecPro="";
                                       }
                                       echo "<option value=".$RsPro["cCodProvincia"]." ".$selecPro.">".$RsPro[cNomProvincia]."</option>";
                                   }
                                   sqlsrv_free_stmt($rsDep);
                                   ?>
                               </select>
                               <?

                               $sqlTrab="SELECT TOP 50 * FROM Tra_M_Trabajadores WHERE iCodCategoria=2 OR iCodCategoria=3 OR iCodCategoria=4  ORDER BY cNombresTrabajador,cApellidosTrabajador";
                               $rsTrab=sqlsrv_query($cnx,$sqlTrab);
                               while ($RsTrab=sqlsrv_fetch_array($rsTrab)){
                                   if($RsTrab["iCodTrabajador"]==$_REQUEST[iCodTrabajadorEnvio]){
                                       $selec="selected";
                                   }Else{
                                       $selec="";
                                   }
                                   echo "<option value=".$RsTrab["iCodTrabajador"]." ".$selec.">".$RsTrab["cNombresTrabajador"]." ".$RsTrab["cApellidosTrabajador"]."</option>";
                               }
                               sqlsrv_free_stmt($rsTrab);
                               ?>
                               </select>
                           </div>

                           <div class="col-lg-2 ">
                               <label>Distrito:</label>
                               <?      $sqlDis="SELECT cCodDepartamento,cCodProvincia,cCodDistrito,cNomDistrito FROM Tra_U_Distrito WHERE cCodProvincia='$_POST[cCodProvincia]' AND cCodDepartamento='$_REQUEST[cCodDepartamento]' order by cNomDistrito ASC ";
                               $rsDis=sqlsrv_query($cnx,$sqlDis);
                               ?>
                               <select  name="cCodDistrito" <?php if($_REQUEST[cCodProvincia]=="") echo "disabled"?>
                                        class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                        searchable="Buscar aqui..">
                                   <option value="">Seleccione:</option>
                                   <?   while ($RsDis=sqlsrv_fetch_array($rsDis)){
                                       if($RsDis["cCodDistrito"]==$_REQUEST[cCodDistrito]){
                                           $selecDis="selected";
                                       }else{
                                           $selecDis="";
                                       }
                                       echo "<option value=".$RsDis["cCodDistrito"]." ".$selecDis.">".$RsDis[cNomDistrito]."</option>";
                                   }
                                   sqlsrv_free_stmt($rsDep);
                                   ?>
                               </select>
                           </div>

                               <div class="col-lg-2 ">
                                   <label>Estado:</label>
                                   <select name="cFlgEstado" class="FormPropertReg mdb-select colorful-select dropdown-primary"
                                           searchable="Buscar aqui..">
                                       <option value="" selected>Seleccione:</option>
                                       <option value="3" <?php if($_REQUEST[cFlgEstado]=="3") echo "selected" ?>>Pendiente</option>
                                       <option value="1" <?php if($_REQUEST[cFlgEstado]=="1") echo "selected" ?>>Notificado</option>
                                       <option value="2" <?php if($_REQUEST[cFlgEstado]=="2") echo "selected" ?>>Devuelto</option>
                                   </select>
                               </div>
                           <div class="col-lg-2">
                               <div class="form-check">
                                   <input type="checkbox" value="1" name="cFlgNacional" class="form-check-input" <?php if($_REQUEST['cFlgNacional'] == 1) echo "checked"?> id="cFlgNacional" >
                                   <label class="form-check-label" for="cFlgNacional">Nacional</label>
                               </div>
                           </div>
                           <div class="col-lg-2">
                               <div class="form-check">
                                   <input type="checkbox" value="1" id="cFlgInternacional" class="form-check-input" name="cFlgInternacional"  <?php if($_REQUEST['cFlgInternacional'] == 1) echo "checked"?> >
                                   <label class="form-check-label" for="cFlgInternacional">Internacional</label>
                               </div>
                           </div>
                           <div class="col-lg-2">
                               <div class="form-check">
                                   <input type="checkbox" value="1" id="cFlgUrgente" class="form-check-input" name="cFlgUrgente" <?php if($_REQUEST['cFlgUrgente'] == 1) echo "checked"?> >
                                   <label class="form-check-label" for="cFlgUrgente">Urgente</label>
                               </div>
                           </div>
                           <div class="col-lg-2">
                               <div class="form-check">
                                   <input type="checkbox" value="1" id="cFlgLocal" class="form-check-input"name="cFlgLocal"  <?php if($_REQUEST['cFlgLocal'] == 1) echo "checked"?> >
                                   <label class="form-check-label" for="cFlgLocal">Local</label>
                               </div>
                           </div>

                             <button class="btn btn-primary" id="aceptar" onMouseOver="this.style.cursor='hand'">
                                 <img src="images/icon_aceptar.png" width="17" height="17" border="0"></td>
                                 <b>Aceptar</b>
                             </button>
                             <?php if($_SESSION['iCodPerfilLogin']!=7){ ?>
                                <button class="btn btn-primary" onclick="Entregar();"  onMouseOver="this.style.cursor='hand'" >
                                   <img src="images/icon_derivar.png" width="17" height="17" border="0"></td>
                                   <b>Entregar</b>
                                </button>
                             <?php } ?>
                             <button class="btn btn-primary" onclick="Estado();" onMouseOver="this.style.cursor='hand'">
                                 <img src="images/icon_delegar.png" width="17" height="17" border="0"></td>
                                 <b>Estado</b>
                             </button>

                             <?php if($_SESSION['iCodPerfilLogin']!=7){ ?>
                                 <button class="btn btn-primary" onclick="Ubicacion();" onMouseOver="this.style.cursor='hand'">
                                     <b>Ubicación</b>
                                 </button>
                             <?php } ?>
                             <button class="btn btn-primary"
                                  onclick="window.open('consultaTramiteCargoDep.php?fDesde=<?=$fecini?>&fHasta=<?=$fecfin?>&cCodificacion=<?=$_REQUEST[cCodificacion]?>&cCodTipoDoc=<?=$_REQUEST[cCodTipoDoc]?>&cFlgUrgente=<?=$_REQUEST[cFlgUrgente]?>&cFlgLocal=<?=$_REQUEST[cFlgLocal]?>&cFlgNacional=<?=$_REQUEST[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_REQUEST[iCodTrabajadorEnvio]?>&cNombre=<?=$_REQUEST['cNombre']?>&cDireccion=<?=$_REQUEST[cDireccion]?>&cOrdenServicio=<?=$_REQUEST[cOrdenServicio]?>&ChxfRespuesta=<?=$_REQUEST[ChxfRespuesta]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&cFlgEstado=<?=$_REQUEST[cFlgEstado]?>&cCodDepartamento=<?=$_REQUEST[cCodDepartamento]?>&cCodProvincia=<?=$_REQUEST[cCodProvincia]?>&cCodDistrito=<?=$_REQUEST[cCodDistrito]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_self'); return false;"
                                  onMouseOver="this.style.cursor='hand'">
                                  <b>Nacional</b>&nbsp;&nbsp;
                                 <img src="images/icon_excel.png" width="17" height="17" border="0">
                             </button>
                             <button class="btn btn-primary"
                                            onclick="window.open('consultaTramiteCargoLoc.php?fDesde=<?=$fecini?>&fHasta=<?=$fecfin?>&cCodificacion=<?=$_REQUEST[cCodificacion]?>&cCodTipoDoc=<?=$_REQUEST[cCodTipoDoc]?>&cFlgUrgente=<?=$_REQUEST[cFlgUrgente]?>&cFlgLocal=<?=$_REQUEST[cFlgLocal]?>&cFlgNacional=<?=$_REQUEST[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_REQUEST[iCodTrabajadorEnvio]?>&cNombre=<?=$_REQUEST['cNombre']?>&cDireccion=<?=$_REQUEST[cDireccion]?>&cOrdenServicio=<?=$_REQUEST[cOrdenServicio]?>&ChxfRespuesta=<?=$_REQUEST[ChxfRespuesta]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&cFlgEstado=<?=$_REQUEST[cFlgEstado]?>&cCodDepartamento=<?=$_REQUEST[cCodDepartamento]?>&cCodProvincia=<?=$_REQUEST[cCodProvincia]?>&cCodDistrito=<?=$_REQUEST[cCodDistrito]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_self'); return false;"
                                            onMouseOver="this.style.cursor='hand'">
                                 <b>Local</b>&nbsp;
                                 <img src="images/icon_excel.png" width="17" height="17" border="0">
                              </button>
                              <button class="btn btn-primary" onclick="Buscar();" onMouseOver="this.style.cursor='hand'">
                                  <b>Buscar</b>
                                  <img src="images/icon_buscar.png" width="17" height="17" border="0">
                              </button>
                              <button class="btn btn-primary" onclick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self'); return false;"
                                              onMouseOver="this.style.cursor='hand'">
                                  <b>Restablecer</b>&nbsp;&nbsp;
                                  <img src="images/icon_clear.png" width="17" height="17" border="0"></td>
                              </button>
                               <?php // ordenamiento
                                            if($_GET['campo']==""){ $campo="Fecha"; }else{ $campo=$_GET['campo']; }
                                            if($_GET['orden']==""){ $orden="DESC"; }else{ $orden=$_GET['orden']; } ?>
                                  <button class="btn btn-primary"
                                              onclick="window.open('consultaTramiteCargo_xls.php?fDesde=<?=$_REQUEST[fDesde]?>&fHasta=<?=$_REQUEST[fHasta]?>&cCodificacion=<?=$_REQUEST[cCodificacion]?>&cCodTipoDoc=<?=$_REQUEST[cCodTipoDoc]?>&cFlgUrgente=<?=$_REQUEST[cFlgUrgente]?>&cFlgLocal=<?=$_REQUEST[cFlgLocal]?>&cFlgNacional=<?=$_REQUEST[cFlgNacional]?>&cFlgInternacional=<?=$_REQUEST[cFlgInternacional]?>&iCodTrabajadorEnvio=<?=$_REQUEST[iCodTrabajadorEnvio]?>&cNombre=<?=$_REQUEST['cNombre']?>&cDireccion=<?=$_REQUEST[cDireccion]?>&cOrdenServicio=<?=$_REQUEST[cOrdenServicio]?>&ChxfRespuesta=<?=$_REQUEST[ChxfRespuesta]?>&fEntrega=<?=$_REQUEST[fEntrega]?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>&cFlgEstado=<?=$_REQUEST[cFlgEstado]?>&cCodDepartamento=<?=$_REQUEST[cCodDepartamento]?>&cCodProvincia=<?=$_REQUEST[cCodProvincia]?>&cCodDistrito=<?=$_REQUEST[cCodDistrito]?>&orden=<?=$orden?>&campo=<?=$campo?>', '_self'); return false;"
                                              onMouseOver="this.style.cursor='hand'">
                                     <b>a Excel</b>&nbsp
                                      <img src="images/icon_excel.png" width="17" height="17" border="0">
                                  </button>
                           </div>
                       <form/>
                        <form name="frmCargo" method="GET" action="consultaTramiteCargo.php"  >
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td width="68" class="headCellColum">
                                            <a href="<?=$_SERVER['PHP_SELF']?>?campo=Fecha&orden=<?=$cambio?>&cDescTipoDoc=<?=$_GET['cDescTipoDoc']?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Fecha"){ echo "underline"; }Else{ echo "none";}?>">Fecha</a></td>
                                        <td width="119" class="headCellColum">Oficina Origen</td>
                                        <td width="96" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Documento&orden=<?=$cambio?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Documento"){ echo "underline"; }Else{ echo "none";}?>">Documento</a></td>
                                        <td width="137" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Nombre&orden=<?=$cambio?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Nombre"){ echo "underline"; }Else{ echo "none";}?>">Destinatario</a></td>
                                        <td width="167" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Direccion&orden=<?=$cambio?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Direccion"){ echo "underline"; }Else{ echo "none";}?>">Direccion</a></td>

                                        <td width="120" class="headCellColum">
                                            <a href="<?=$_SERVER['PHP_SELF']?>?campo=Trabajador&orden=<?=$cambio?>&cNombresTrabajador=<?=$_GET[cNombresTrabajador]?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&iCodOficina=<?=$_GET['iCodOficina']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"
                                               style=" text-decoration:<?php if($campo=="Trabajador"){ echo "underline"; }Else{ echo "none";}?>">Fecha de aceptacion</a>
                                        </td>

                                        <td width="120" class="headCellColum">
                                            <a href="<?=$_SERVER['PHP_SELF']?>?campo=Trabajador&orden=<?=$cambio?>&cNombresTrabajador=<?=$_GET[cNombresTrabajador]?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&iCodOficina=<?=$_GET['iCodOficina']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"
                                               style=" text-decoration:<?php if($campo=="Trabajador"){ echo "underline"; }Else{ echo "none";}?>">Entrega a Mensajeria</a>
                                        </td>

                                        <td width="146" class="headCellColum"><a href="<?=$_SERVER['PHP_SELF']?>?campo=Estado&orden=<?=$cambio?>&cFlgEstado=<?=$_GET[cFlgEstado]?>&fDesde=<?=(isset($_GET['fDesde'])?$_GET['fDesde']:'')?>&fHasta=<?=(isset($_GET['fHasta'])?$_GET['fHasta']:'')?>&cCodificacion=<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>&iCodOficina=<?=$_GET['iCodOficina']?>&cCodTipoDoc=<?=(isset($_GET['cCodTipoDoc'])?$_GET['cCodTipoDoc']:'')?>&cFlgUrgente=<?=$_GET[cFlgUrgente]?>&cFlgLocal=<?=$_GET[cFlgLocal]?>&cFlgNacional=<?=$_GET[cFlgNacional]?>&iCodTrabajadorEnvio=<?=$_GET[iCodTrabajadorEnvio]?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET[cDireccion]?>&cOrdenServicio=<?=$_GET[cOrdenServicio]?>&ChxfRespuesta=<?=$_GET[ChxfRespuesta]?>"  style=" text-decoration:<?php if($campo=="Estado"){ echo "underline"; }Else{ echo "none";}?>">Estado Cargo</a></td>
                                        <td width="51" class="headCellColum"><input type="checkbox" name="iCodAuto[]"  value="" onclick="funcion(this.checked, this.frmConsultaTramiteCargo, this.name);"/></td>
                                    </tr>

                                </thead>
                            <tbody>
                                <?php
                                if ($fecini!=''){$fecini=date("Ymd", strtotime($fecini));}
                                if( $fecfin!=''){
                                    $fecfin=date("Y-m-d", strtotime($fecfin));
                                    function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                                        $date_r = getdate(strtotime($date));
                                        $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                                        return $date_result;
                                    }
                                    if($_REQUEST[ChxfRespuesta]=="" && $_REQUEST[fEntrega]==""){
                                        $fecfin = dateadd($fecfin,1,0,0,0,0,0); // + 1 dia
                                    }else{
                                        $fecfin = dateadd($fecfin,0,0,0,0,0,0); // + 1 dia
                                    }
                                }
                                $sql.= " SP_CONSULTA_TRAMITE_CARGO '$fecini', '$fecfin','$_REQUEST[ChxfRespuesta]','$_REQUEST[fEntrega]', '%$_REQUEST[cCodificacion]%', '%$_REQUEST['cNombre']%','%$_REQUEST[cDireccion]%', '$_REQUEST[cCodTipoDoc]', '$_REQUEST[cOrdenServicio]', '$_REQUEST[cFlgUrgente]', '$_REQUEST[iCodTrabajadorEnvio]', '$_REQUEST[cFlgLocal]','$_REQUEST[cFlgNacional]','$_REQUEST[cFlgInternacional]','$_REQUEST['iCodOficina']','$_REQUEST[cFlgEstado]','$_REQUEST[cCodDepartamento]','$_REQUEST[cCodProvincia]','$_REQUEST[cCodDistrito]','$campo','$orden'  ";
                                //echo $sql;
                                $rs = sqlsrv_query($cnx,$sql);
                                $total = sqlsrv_has_rows($rs);

                                if( $fecini=="" && $fecfin=="" && $_REQUEST[cCodificacion]=="" && $_REQUEST[cCodTipoDoc]=="" && $_REQUEST['iCodOficina']=="" && $_REQUEST[cFlgUrgente]=="" && $_REQUEST[iCodTrabajadorEnvio]=="" && $_REQUEST['cNombre']=="" && $_REQUEST[cDireccion]=="" && $_REQUEST[cOrdenServicio]=="" && $_REQUEST[ChxfRespuesta]=="" && $_REQUEST[cFlgLocal]=="" && $_REQUEST[cFlgNacional]=="" && $_REQUEST[cFlgEstado]=="" && $_REQUEST[cCodDepartamento]=="" && $_REQUEST[cCodProvincia]=="" && $_REQUEST[cCodDistrito]=="" && $_REQUEST[fEntrega]==""){
                                    $sqlcargo = " SP_CONSULTA_TRAMITE_CARGO_LISTA  ";
                                    $rscargo  = sqlsrv_query($cnx,$sqlcargo);
                                    $numrows  = sqlsrv_has_rows($rscargo);
                                }else{
                                    $numrows = sqlsrv_has_rows($rs);
                                }
                                if ($numrows == 0){
                                    echo "NO SE ENCONTRARON REGISTROS<br>";
                                }else{
                                echo "TOTAL DE REGISTROS : ".$numrows;
                                for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                                for ($h=0;$h<count($_POST[iCodAuto]);$h++){
                                    $iCodAuto= $_POST[iCodAuto];
                                    if ($Rs[iCodAuto] == $iCodAuto[$h]){
                                        $Checkear="checked";
                                    }
                                }
                                sqlsrv_fetch_array($rs, $i);
                                $Rs = sqlsrv_fetch_array($rs);

                                    if ($color == "#DDEDFF"){
                                    $color = "#F9F9F9";
                                }else{
                                    $color = "#DDEDFF";
                                }
                                if ($color == ""){
                                    $color = "#F9F9F9";
                                }
                                ?>

                                    <tr bgcolor="<?php echo $color; ?>" class="fila" data-iCodTramite="<?php echo $Rs['iCodTramite']; ?>"
                                        onMouseOver="this.style.backgroundColor='#BFDEFF'"
                                        OnMouseOut="this.style.backgroundColor='<?php echo $color; ?>'">

                                        <td valign="middle" align="center">
                                            <?php
                                            echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs['fFecRegistro']))."</div>";
                                            echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs['fFecRegistro']))."</div>";
                                            echo $Rs[cFlgTipoMovimiento];
                                            $sqlTra = "SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorRegistro]'";
                                            $rsTra = sqlsrv_query($cnx,$sqlTra);
                                            $RsTra = sqlsrv_fetch_array($rsTra);
                                            echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
                                            ?>
                                        </td>

                                        <td valign="middle" align="left">
                                            <?php
                                            echo $Rs[cNomOficina];
                                            $sqlTra = "SELECT cApellidosTrabajador,cNombresTrabajador FROM Tra_M_Trabajadores WHERE iCodTrabajador='$Rs[iCodTrabajadorSolicitado]'";
                                            $rsTra  = sqlsrv_query($cnx,$sqlTra);
                                            $RsTra  = sqlsrv_fetch_array($rsTra);
                                            echo "<div style=color:#808080;>".$RsTra[cNombresTrabajador]." ".$RsTra[cApellidosTrabajador]."</div>";
                                            ?>
                                        </td>

                                        <td valign="middle" align="left">
                                            <?php
                                            if ($Rs['cFlgUrgente'] == 1) {
                                                echo "<font color='#FF0000'>URGENTE</font>"."<br>";
                                            }

                                            echo $Rs['cDescTipoDoc'];
                                            echo "<div>";
                                            echo "<a style=\"color:#0067CE\" href=\"registroSalidaDetalles.php?iCodTramite=".$Rs[iCodTramite]."\" rel=\"lyteframe\" title=\"Detalle del TRÁMITE\" rev=\"width: 970px; height: 290px; scrolling: auto; border:no\">";
                                            echo $Rs[cCodificacion];
                                            echo "</a>";
                                            echo "</div>";
                                            ?>
                                        </td>

                                        <td valign="middle" align="left">
                                            <?php
                                            echo $Rs['cNombre'];
                                            ?><br>
                                            <?php echo "<div style=text-transform:uppercase;color:#06F>".$Rs[cNomRemite]."</div>";
                                            /*if(trim($Rs[cNomRemite])==""){
                                               echo "<div style=text-transform:uppercase;color:#06F>".$Rs[TRemitente]."</div>";
                                               } */?>  	</td>

                                        <td valign="middle" align="left">
                                            <?php
                                            if(trim($Rs[cDireccion])!=""){
                                                echo $Rs[cDireccion]." - ";
                                            }else{
                                                echo "";
                                            }
                                            if ($Rs[cNomDepartamento]!=""){
                                                echo $Rs[cNomDepartamento]."- ";
                                            }else{
                                                echo "";
                                            }
                                            if ($Rs[cNomProvincia]!=""){
                                                echo $Rs[cNomProvincia]." - ";
                                            }else{
                                                echo "";
                                            }
                                            if($Rs[cDistrito]!=""){
                                                echo $Rs[cNomDistrito];
                                            }else{
                                                echo "";
                                            }
                                            if (isset($Rs['CODIGO_PAIS'])) {
                                                $sqlPais = "SELECT nombrePais FROM Tra_U_Pais WHERE codPais = ".$Rs['CODIGO_PAIS'];
                                                $rsPais  = sqlsrv_query($cnx,$sqlPais);
                                                $RsPais  = sqlsrv_fetch_array($rsPais);
                                                echo $RsPais['nombrePais'];
                                            }
                                            ?>
                                        </td>

                                        <td valign="middle" align="center"> ....
                                            <?php
                                            //echo $Rs['fecha_Acepta_Mensajeria'];
                                            if (isset($Rs['fecha_Acepta_Mensajeria'])) {
                                                echo "<div style=color:#727272>".$Rs['fecha_Acepta_Mensajeria']."</div>";
                                            }
                                            //echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs[FECHA_DOCUMENTO]))."</div>";
                                            //echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs[FECHA_DOCUMENTO]))."</div>";
                                            ?>
                                        </td>

                                        <td valign="middle" align="left"><?php echo $Rs[cNombresTrabajador]." ".$Rs[cApellidosTrabajador];?>
                                            <?php if($Rs[fEntrega]!=''){
                                                echo "<div style=color:#727272>".date("d-m-Y", strtotime($Rs[fEntrega]))."</div>";
                                                echo "<div style=color:#727272;font-size:10px>".date("G:i", strtotime($Rs[fEntrega]))."</div>";
                                            }
                                            if($Rs[cNumGuiaServicio]!=''){
                                                echo "<div style=color:#03F>".$Rs[cNumGuiaServicio]."</div>";
                                            }

                                            ?>
                                        </td>

                                        <td valign="middle" align="left">
                                            <?php
                                            if ($Rs[cFlgEstado] == 1 OR $Rs[cFlgEstado] == 2 ){
                                                if ($Rs[cFlgEstado] == 1){
                                                    $estado = "<div style='color:#FF0000'>NOTIFICADO.</div>";
                                                }else if($Rs[cFlgEstado] == 2){
                                                    $estado = "<div style='color:#FF0000'>DEVUELTO.</div>";
                                                }
                                                $estado_cargo = "".$estado." El ".date("d-m-Y", strtotime($Rs[fRespuesta])).". Recibido por: ".$Rs[cRecibido]." , con Observacion: ".$Rs[cObservaciones]."";
                                                echo $estado_cargo;
                                            }else{
                                                if ($Rs[cFlgEstado] == 3){
                                                    echo  "<div style='color:#FF0000'>PENDIENTE.</div>";
                                                }else{
                                                    echo "";
                                                }
                                            }
                                            ?>
                                        </td>

                                        <td valign="middle" align="center">
                                            <input type="checkbox" name="iCodAuto[]" value="<?php echo $Rs['iCodAuto']; ?>" onClick="setCodTramite(this);"
                                                   data-codTramite="<?php echo $Rs['iCodTramite']; ?>">
                                            <?php
                                            // $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite='$Rs[iCodTramite]'";
                                            // $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite = '$Rs[iCodTramite]'";
                                            //$sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales_Mensajeria WHERE iCodTramite = '$Rs[iCodTramite]'";
                                            $sqlDw = "SELECT * FROM Tra_M_Tramite_Digitales_Mensajeria WHERE iCodTramite = '$Rs[iCodTramite]' 
                                             AND iCodAuto = '$Rs[iCodAuto]' ";
                                            //echo $sqlDw;
                                            $rsDw  = sqlsrv_query($cnx,$sqlDw);
                                            if (sqlsrv_has_rows($rsDw) > 0){
                                                $RsDw = sqlsrv_fetch_array($rsDw);
                                                if ($RsDw['cNombreNuevo'] != ""){
                                                    if (file_exists("../cAlmacenArchivos/".trim($Rs1[nombre_archivo]))){
                                                        echo "<a href=\"download.php?direccion=../cAlmacenArchivos/&file=".trim($RsDw["cNombreNuevo"])."\"><img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($RsDw["cNombreNuevo"])."\"></a>";
                                                    }
                                                }
                                            }else{
                                                echo "<img src=images/space.gif width=16 height=16 border=0>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                }
                                ?>
                            </tbody>

                        </table>

                        </form>

                    </div>
                    <?php
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
                    $tampag = 40;
                    $reg1 = ($pag-1) * $tampag;

                    //invertir orden
                    if($orden=="ASC") $cambio="DESC";
                    if($orden=="DESC") $cambio="ASC";
                    /*
                   if($_GET['fHasta']!=""){
                    $fDesde=date("Ymd", strtotime($_GET['fDesde']));
                    $fHasta=date("m-d-Y", strtotime($_GET['fHasta']));
                    function dateadd($date, $dd=0, $mm=0, $yy=0, $hh=0, $mn=0, $ss=0){
                    $date_r = getdate(strtotime($date));
                    $date_result = date("Ymd", mktime(($date_r["hours"]+$hh),($date_r["minutes"]+$mn),($date_r["seconds"]+$ss),($date_r["mon"]+$mm),($date_r["mday"]+$dd),(    $date_r["year"]+$yy)));
                    return $date_result;
                                }
                    $fHasta=dateadd($fHasta,1,0,0,0,0,0); // + 1 dia
                    }
                */
                    ?>
                    <?php  echo paginar($pag, $total, $tampag, "consultaTramiteCargo.php?fDesde=".$_REQUEST[fDesde]."&fHasta=".$_REQUEST[fHasta]."&cCodificacion=".$_REQUEST[cCodificacion]."&cCodTipoDoc=".$_REQUEST[cCodTipoDoc]."&cFlgUrgente=".$_REQUEST[cFlgUrgente]."&cFlgLocal=".$_REQUEST[cFlgLocal]."&cFlgNacional=".$_REQUEST[cFlgNacional]."&iCodTrabajadorEnvio=".$_REQUEST[iCodTrabajadorEnvio]."&cNombre=".$_REQUEST['cNombre']."&iCodOficina=".$_REQUEST['iCodOficina']."&cDireccion=".$_REQUEST[cDireccion]."&cOrdenServicio=".$_REQUEST[cOrdenServicio]."&ChxfRespuesta=".$_REQUEST[ChxfRespuesta]."&fEntrega=".$_REQUEST[fEntrega]."&pag=");?>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include("includes/userinfo.php"); ?>
<?php include("includes/pie.php"); ?>
<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">
    function setCodTramite(elemento)
    {
        var atributo  = elemento.getAttribute('data-codTramite');
        document.frmConsultaTramiteCargo.codigoTramite.value = atributo;
    }
    function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp=false;
        try{
            xmlhttp=new XMLHttpRequest();
        }
        catch(e)	{
            try{
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e){
                try{
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(e1){
                    xmlhttp=false;
                }
            }
        }

        return xmlhttp;
    }

    function getState(departamentoId) {

        var strURL="iu_provincia.php?departamento="+departamentoId;
        var req = getXMLHTTP();

        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById('statediv').innerHTML=req.responseText;
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }
    }
    function getCity(departamentoId,provinciaId) {
        var strURL="iu_distrito.php?departamento="+departamentoId+"&provincia="+provinciaId;
        var req = getXMLHTTP();

        if (req) {

            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                        document.getElementById('citydiv').innerHTML=req.responseText;
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }

    }


    function funcion(bol, frm, chkbox) {
        for (var i=0;i < frmConsultaTramiteCargo.elements[chkbox].length;i++) { // Dentro de todos los elementos, seleccionamos lo que tengan el mismo nombre que el seleccionado
            elemento = frmConsultaTramiteCargo.elements[chkbox][i]; // Ahora es bidimensional
            elemento.checked = (bol) ? true : false;
        }
    }

    function Entregar()
    {
        cont = 0
        for (i=0;i<document.frmConsultaTramiteCargo.elements.length;i++)
        {
            if(document.frmConsultaTramiteCargo.elements[i].type == "checkbox")
            {
                if(document.frmConsultaTramiteCargo.elements[i].checked == 1)
                {
                    cont = cont + 1;
                }
            }
        }
        if (cont>0){
            document.frmConsultaTramiteCargo.action='iu_entrega_motorizado.php';
            document.frmConsultaTramiteCargo.method='POST';
            document.frmConsultaTramiteCargo.submit();
        }
        else{
            a = " Seleccione un Documento";
            alert( a);
        }
    }

    function Estado()
    {
        cont = 0
        for (i=0;i<document.frmConsultaTramiteCargo.elements.length;i++)
        {
            if(document.frmConsultaTramiteCargo.elements[i].type == "checkbox")
            {
                if(document.frmConsultaTramiteCargo.elements[i].checked == 1)
                {
                    cont = cont + 1;
                }
            }
        }
        if (cont > 0){
            document.frmConsultaTramiteCargo.action = 'iu_estado_multiple.php';
            document.frmConsultaTramiteCargo.method = 'POST';
            document.frmConsultaTramiteCargo.submit();
        }else{
            a = " Seleccione un Documento";
            alert(a);
        }
    }

    function Ubicacion()
    {
        cont = 0
        for (i=0;i<document.frmConsultaTramiteCargo.elements.length;i++)
        {
            if(document.frmConsultaTramiteCargo.elements[i].type == "checkbox")
            {
                if(document.frmConsultaTramiteCargo.elements[i].checked == 1)
                {
                    cont = cont + 1;
                }
            }
        }
        if (cont>0){
            document.frmConsultaTramiteCargo.action='iu_ubicacion_multiple.php';
            document.frmConsultaTramiteCargo.method='POST';
            document.frmConsultaTramiteCargo.submit();
        }
        else{
            a = " Seleccione un Documento";
            alert(a);
        }
    }

    function Buscar()
    {
        document.frmConsultaTramiteCargo.action="<?=$_SERVER['PHP_SELF']?>";
        document.frmConsultaTramiteCargo.submit();
    }

    function releer(){
        document.frmConsultaTramiteCargo.action="<?=$_SERVER['PHP_SELF']?>#area";
        document.frmConsultaTramiteCargo.submit();
    }

    //--></script>
<script>
    $('.mdb-select').material_select();
    // Data Picker Initialization
    $('.datepicker').pickadate({
        monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
    });
  $(document).ready(function(){
    $('#aceptar').click(function(event) {
      $("input:checkbox:checked").each(
        function(){
          var iCodTramite = $(this).attr('data-CodTramite');
          var parametros = {
            "iCodTramite" : iCodTramite
          };

          $.ajax({
              data : parametros,
              url  : 'ajax/aceptarTramite.php',
              type : 'post'
          }).done(function(response) {  
            alert("El tramite ha sido Aceptado");
            location.reload();
          });
        }
      );
    });
  });  
</script>  

</html>

<?php
}else{
  header("Location: ../index-b.php?alter=5");
}
?>