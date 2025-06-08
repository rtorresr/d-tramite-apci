<?php
session_start();
$pageTitle = "Mantenimiento de Remitentes";
$activeItem = "iu_remitentes.php";
$navExtended = true;

If($_SESSION['CODIGO_TRABAJADOR']!=""){
include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include("includes/head.php");?>
        <script>
            function ConfirmarBorrado()
            {
                if (confirm("Esta seguro de eliminar el registro?")){
                    return true;
                }else{
                    return false;
                }
            }
        </script>
        <script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
        <link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
    </head>
    <body class="theme-default has-fixed-sidenav">
        <?php include("includes/menu.php");?>

        <main>
         <div class="container-fluid">
              <!--Grid row-->
             <div class="row">
                  <!--Grid column-->
                 <div class="col-12">
                      <!--Card-->
                     <div class="card mb-5">
                          <!--Card content-->
                         <div class="card-body d-flex px-4 px-lg-5">
                             <table id="tablaRemitentes" class="display striped highlight bordered" cellspacing="0" width="100%">
                                 <thead>
                                 <tr>
                                     <th></th>
                                     <th>Nombre</th>
                                     <th>Documento</th>
                                     <th>Dirección</th>
                                     <th>Estado</th>
                                     <th data-priority="1">Opciones</th>
                                 </tr>
                                 </thead>
                             </table>


                            <form name="form1" method="GET" action="<?=$_SERVER['PHP_SELF']?>">
                                <table width="1000" border="0" align="center">
                                    <tr>
                                        <td colspan="10">
                                            <fieldset>
                                                <legend>Criterios de Búsqueda</legend>
                                                <table width="900" border="0" align="center">
                                                       <tr>
                                                            <td >Nombre Remitente:</td>
                                                            <td>
                                                                <label><input name="cNombre" class="FormPropertReg form-control" type="text" value="<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>" size="80" /></label>
                                                            </td>
                                                            <td >Nro Documento:</td>
                                                            <td>
                                                                <label><input name="nNumDocumento" class="FormPropertReg form-control" type="text" value="<?=$_GET['nNumDocumento']?>"  onkeypress="if (event.keyCode > 31 && ( event.keyCode < 48 || event.keyCode > 57)) event.returnValue = false;" /></label>
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                        <td height="42" colspan="4">
                                                            <button class="btn btn-primary" type="submit" name="Submit" onMouseOver="this.style.cursor='hand'"> <b>Buscar</b> <img src="images/icon_buscar.png" width="17" height="17" border="0"></button
                                                            <button class="btn btn-primary"  name="Restablecer" onClick="window.open('<?=$_SERVER['PHP_SELF']?>', '_self');" onMouseOver="this.style.cursor='hand'"> <b>Restablecer</b> <img src="images/icon_clear.png" width="17" height="17" border="0"></button>
                                                            <?php // ordenamiento
                                                              if($_GET['campo']==""){$campo="cNombre"; }Else{$campo=$_GET['campo'];}
                                                              if($_GET['orden']==""){$orden="ASC";}Else{$orden=$_GET['orden'];}
                                                            ?>
                                                            <button class="btn btn-primary" onClick="window.open('iu_remitentes_xls.php?cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&nNumDocumento=<?=$_GET['nNumDocumento']?>&campo=<?=$campo?>&orden=<?=$orden?>&traRep=<?=$_SESSION['CODIGO_TRABAJADOR']?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Excel</b> <img src="images/icon_excel.png" width="17" height="17" border="0"> </button>
                                                            <button class="btn btn-primary" onClick="window.open('iu_remitentes_pdf.php?cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&nNumDocumento=<?=$_GET['nNumDocumento']?>&campo=<?=$campo?>&orden=<?=$orden?>', '_blank');" onMouseOver="this.style.cursor='hand'"> <b>a Pdf</b> <img src="images/icon_pdf.png" width="17" height="17" border="0"> </button>
                                                        </td>
                                                      </tr>
                                                </table>
                                            </fieldset>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <table class="table">

                            <?php
                            function paginar($actual, $total, $por_pagina, $enlace, $maxpags=0) {
                                $total_paginas = ceil($total/$por_pagina);
                                //echo $total_paginas;
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
                            $tampag = 25;
                            $reg1 = ($pag-1) * $tampag;

                            //invertir orden
                            if($orden=="ASC") $cambio="DESC";
                            if($orden=="DESC") $cambio="ASC";


                            $sql="select  top 500 * from Tra_M_Remitente ";
                            $sql.=" WHERE iCodRemitente>0 ";
                            if($_GET['cNombre']!=""){
                            $sql.=" AND cNombre like '%'+'%".$_GET['cNombre']."%'+'%' ";
                            }
                            if($_GET['nNumDocumento']!=""){
                            $sql.=" AND nNumDocumento='%'+'%".$_GET['nNumDocumento']."%'+'%' ";
                            }
                            $sql.="ORDER BY  ".$campo." ".$orden."  ";

                            $rs=sqlsrv_query($cnx,$sql);
                            $total = sqlsrv_has_rows($rs);
                            ?>
                            <tr>
                                <td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cNombre"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cNombre&orden=<?=$cambio?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&nNumDocumento=<?=$_GET['nNumDocumento']?>&cDireccion=<?=$_GET['cDireccion']?>&cFlag=<?=$_GET['cFlag']?>">Nombre</a></td>
                                <td class="headCellColum"><a style=" text-decoration:<?php if($campo=="nNumDocumento"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=nNumDocumento&orden=<?=$cambio?>&nNumDocumento=<?=$_GET['nNumDocumento']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&cDireccion=<?=$_GET['cDireccion']?>&cFlag=<?=$_GET['cFlag']?>">Documento</a></td>
                                <td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cDireccion"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cDireccion&orden=<?=$cambio?>&cDireccion=<?=$_GET['cDireccion']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&nNumDocumento=<?=$_GET['nNumDocumento']?>&cFlag=<?=$_GET['cFlag']?>">Direcci�n</a></td>
                                <td class="headCellColum"><a style=" text-decoration:<?php if($campo=="cFlag"){ echo "underline"; }Else{ echo "none";}?>" href="<?=$_SERVER['PHP_SELF']?>?campo=cFlag&orden=<?=$cambio?>&cFlag=<?=$_GET['cFlag']?>&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&nNumDocumento=<?=$_GET['nNumDocumento']?>&cDireccion=<?=$_GET['cDireccion']?>">Estado</a></td>
                                <td class="headCellColum">Opciones</td>
                            </tr>
                            <?php
                            if($_GET['cNombre']=="" && $_GET['nNumDocumento']==""){
                            $sqlre="SP_IU_REMITENTES_CONTEO '".$_GET['cNombre']."', '".$_GET['nNumDocumento']."'";
                            $rsre=sqlsrv_query($cnx,$sqlre);
                            $numrows=sqlsrv_has_rows($rsre);}
                            else{
                            $numrows=sqlsrv_has_rows($rs);
                            }
                              if($numrows==0){
                                    echo "NO SE ENCONTRARON REGISTROS<br>";
                                    echo "TOTAL DE REGISTROS : ".$numrows;
                            }else{
                                     echo "TOTAL DE REGISTROS : ".$numrows;
                                for ($i=$reg1; $i<min($reg1+$tampag, $total); $i++) {
                                sqlsrv_fetch_array($rs, $i);
                                $Rs=sqlsrv_fetch_array($rs);
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
                                <td align="left"><?=$Rs['cNombre']?></td>
                                <td align="left">
                                    <?php
                                    $sqlTDoc="SELECT * FROM Tra_M_Doc_Identidad WHERE cTipoDocIdentidad='$Rs[cTipoDocIdentidad]'";
                                    $rsTDoc=sqlsrv_query($cnx,$sqlTDoc);
                                    $RsTDoc=sqlsrv_fetch_array($rsTDoc);
                                    echo $RsTDoc['cDescDocIdentidad'].":".$Rs['nNumDocumento'];
                                    ?>
                                </td>
                                <td align="left">
                                    <?php
                                    echo $Rs['cDireccion'];
                                  $sqlDep="SELECT cNomDepartamento 	FROM Tra_U_Departamento WHERE cCodDepartamento='$Rs[cDepartamento]'";
                                  $rsDep=sqlsrv_query($cnx,$sqlDep);
                                  $RsDep=sqlsrv_fetch_array($rsDep);
                                  $sqlPro="SELECT cNomProvincia 	FROM Tra_U_Provincia 	WHERE cCodDepartamento='$Rs[cDepartamento]' And cCodProvincia='$Rs[cProvincia]'";
                                  $rsPro=sqlsrv_query($cnx,$sqlPro);
                                  $RsPro=sqlsrv_fetch_array($rsPro);
                                  $sqlDis="SELECT cNomDistrito	 	FROM Tra_U_Distrito 	WHERE cCodDepartamento='$Rs[cDepartamento]' And cCodProvincia='$Rs[cProvincia]' And cCodDistrito='$Rs[cDistrito]'";
                                  $rsDis=sqlsrv_query($cnx,$sqlDis);
                                  $RsDis=sqlsrv_fetch_array($rsDis);
                                  if($Rs['cDepartamento']!=""){ echo $RsDep['cNomDepartamento'];}
                                  if($Rs['cProvincia']!=""){ echo " - ".$RsPro['cNomProvincia'];}
                                  if($Rs['cDistrito']!=""){ echo " - ".$RsDis['cNomDistrito'];}
                                  ?>
                                </td>
                                <td>
                                    <?php
                                    if($Rs['cFlag']==1){?>
                                        <div style="color:#005E2F">Activo</div>
                                        <?php } else {?>
                                        <div style="color:#950000">Inactivo</div>
                                        <?php } ?>
                                </td>
                                    <td>
                                            <a href="iu_remitentes_view.php?iCodRemitente=<?=$Rs['iCodRemitente']?>" rel="lyteframe" title="Detalles Remitentes" rev="width: 583px; height: 390px; scrolling: auto; border:no"><img src="images/icon_view.png" alt="Ver detalles del remitente" width="16" height="16" border="0"></a>
                                            <a href="iu_remitentes_edit.php?iCodRemitente=<?=$Rs['iCodRemitente']?>"><img src="images/icon_edit.png" alt="Editar remitente" width="16" height="16" border="0"></a>
                                            <a href="iu_remitentes_data.php?iCodRemitente=<?=$Rs['iCodRemitente']?>&opcion=3&cNombre=<?=(isset($_GET['cNombre'])?$_GET['cNombre']:'')?>&nNumDocumento=<?=$_GET['nNumDocumento']?>&campo=<?=$campo?>&orden=<?=$orden?>" onClick='return ConfirmarBorrado();'"><img src="images/icon_del.png" alt="Remover remitente" width="16" height="16" border="0"></a>
                                    </td>
                                </tr>

                            <?php
                            }
                            }?>
                            </table>
                            <?php
                            echo paginar($pag, $total, $tampag, "iu_remitentes.php?cNombre=".$_GET['cNombre']."&nNumDocumento=".$_GET['nNumDocumento']."&pag=");
                            echo "<a class='btn btn-primary' href='iu_nuevo_remitente.php'>Nuevo Remitente</a>";
                            ?>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
     </main>

        <?php include("includes/userinfo.php");?>
        <?php include("includes/pie.php");?>

        <script>
            $(document).ready(function () {

                let tablaRemitentes = $('#tablaRemitentes').DataTable({
                    processing: true,
                    serverSide: true,
                    pagingType: 'full_numbers',
                    responsive: true,
                    ajax: 'ajaxtablas/ajaxRemitentes.php',
                    language: {
                        "url": "../dist/scripts/datatables-es_ES.json"
                    },
                    'columnDefs': [
                        {
                            'targets': 0,
                            'checkboxes': {
                                'selectRow': true
                            }
                        }
                    ],
                    'select': {
                        'style': 'multi'
                    },
                    'order': [[1, 'asc']],
                    drawCallback: function( settings ) {
                        $('select[name="tablaRemitentes_length"]').formSelect();
                    },
                    dom: '<"header"fB>tr<"footer"l<"paging-info"ip>>',
                    buttons: [
                        { extend: 'excelHtml5', text: '<i class="fas fa-file-excel"></i> Excel' },
                        { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF' },
                        { extend: 'print', text: '<i class="fas fa-print"></i> Imprimir' }
                    ],
                });


            });
        </script>

    </body>
</html>

<?php
} else{
   header("Location: ../index-b.php?alter=5");
}
?>
