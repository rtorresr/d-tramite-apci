<!--No realiza busqueda aun 12/10/2018-->

<?php session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] !== ''){
    $tipoDoc = $_GET['tipoDoc']??'';
    ?>


    <form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <!--
                    <div class="card-header">
                        <span class="card-title">
                            Agregar referencia
                        </span>

                         documento de salida
                        <div class="row">
                            <div class="col s12">
                                <label class="form-check-label" for="tipoDoc">
                                    <input type="checkbox" name="tipoDoc" value="3"  class="form-check-input form-control-sm" id="tipoDoc" <?php if($tipoDoc===3){ echo 'checked';}?> >
                                    <span>Salida</span>
                                </label>
                            </div>
                        </div>
                    </div> -->
                    <div class="card-body">
                        <fieldset>
                            <div class="row">
                                <div class="col s12">
                                    <table class="table table-hover" id="table_ref">
                                        <thead>
                                                <tr>
                                                    <th>TIPO DOCUMENTO</th>
                                                    <th>REGISTRO N°</th>
                                                    <th>OPCIÓN</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                                <?php
                                                    include_once '../conexion/conexion.php';
                                                    $sqlRem="SELECT TOP 30 * FROM Tra_M_Tramite ";
                                                    $sqlRem.="ORDER BY fFecDocumento DESC";
                                                    $rsRem = sqlsrv_query($cnx,$sqlRem);
                                                    while ($RsRem = sqlsrv_fetch_array($rsRem)){
                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $sqlTipDoc = "SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsRem[cCodTipoDoc]'";
                                                                $rsTipDoc  = sqlsrv_query($cnx,$sqlTipDoc);
                                                                $RsTipDoc  = sqlsrv_fetch_array($rsTipDoc);
                                                                echo $RsTipDoc['cDescTipoDoc'];
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo trim($RsRem['cCodificacion']);
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <form name="selectform">
                                                                    <input name="cReferencia" value="<?=trim($RsRem['cCodificacion'])?>" type="hidden">
                                                                    <input name="iCodTramite" value="<?=trim($RsRem['iCodTramite'])?>" type="hidden">
                                                                    <input type=button value="seleccione" class="btn btn-secondary" onClick="sendValue(this.form.cReferencia ,this.form.iCodTramite);">
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    sqlsrv_free_stmt($rsRem);
                                                ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </form>
    

        <script>
            $("#table_ref").dataTable({
                responsive: true,
                scrollY:        "50vh",
                scrollCollapse: true,
                drawCallback: function( settings ) {
                    //$(".data_scrollBody").attr("data-simplebar", "");
                    $('select[name="table_ref_length"]').formSelect();
                },
                dom: '<"header"f>tr<"footer"l<"paging-info"ip>>',
                "language": {
                    "url": "../dist/scripts/datatables-es_ES.json"
                },
            });

            function sendValue (s,t){
                var selvalue1 = s.value;
                var selvalue2 = t.value;
                 //window.opener.document.getElementById('cReferencia').value = selvalue1;
                 //window.opener.document.getElementById('iCodTramite').value = selvalue2;
                document.frmRegistro.cReferencia.value = selvalue1;
                document.frmRegistro.iCodTramiteRef.value = selvalue2;
                document.frmRegistro.opcion.value=21;
                document.frmRegistro.action="registroData.php";
                document.frmRegistro.submit();
                //window.opener.focus() ;
            }
        </script>

<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>