<?php  header('Content-Type: text/html; charset=UFT-8');
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Seleccion remitente
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripción
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creación del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("includes/head.php");?>
</head>
<body class="theme-default">
 
<div class="container">
    <form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            Agregar remitente
                        </span>

                        <div class="row">
                            <div class="col s6 input-field">
                                <input type="text" autofocus id="cNombreBuscar" class="form-control form-control-sm" name="cNombreBuscar" value="<?= $_GET['cNombreBuscar']??''?>" >
                                <label for="cNombreBuscar">Nombre</label>
                            </div>
                            <div class="col s6 input-field">
                                <input type="text" id="nNumDocumento" class="form-control form-control-sm" name="nNumDocumento" value="<?=$_GET['nNumDocumento']??''?>" >
                                <label for="nNumDocumento">Nro. Documento: </label>
                                <button type="submit" class="input-field__icon btn btn-link" >
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>NOMBRE REMITENTE / N&ordm; DOCUMENTO</th>
                                            <th>OPCIÓN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            include_once("../conexion/conexion.php");
                                            $buscar=$_GET['buscar']??'';
                                            $nombreBuscar = $_GET['cNombreBuscar']??'';
                                            $numDocumento = $_GET['nNumDocumento']??'';
                                            if($buscar===''){
                                                $sqlRem="SELECT TOP 10 * FROM Tra_M_Remitente ";
                                            }else{
                                                $sqlRem="SELECT TOP 500 * FROM Tra_M_Remitente ";
                                            }

                                            $sqlRem.="WHERE cNombre IS NOT NULL ";
                                        
                                            if($nombreBuscar!=""){
                                                $sqlRem.="AND cNombre LIKE '%$_GET[cNombreBuscar]%' ";
                                            }

                                            if($numDocumento!=""){
                                                $sqlRem.="AND nNumDocumento='$_GET[nNumDocumento]' ";
                                            }
                                            
                                            $sqlRem.="ORDER BY cNombre ASC";

                                            $rsRem=sqlsrv_query($cnx,$sqlRem);

                                            $ii=0;

                                            while ($RsRem=sqlsrv_fetch_array($rsRem)){ $ii++;
                                        ?>
                                        <tr>
                                            <td><?= $ii; ?></td>
                                            <td ><?= utf8_encode(ucwords(strtolower($RsRem['cNombre']))) ?>
                                                <?php if($RsRem['nNumDocumento']!==""){ echo utf8_encode("<span class='badge'>".trim($RsRem['nNumDocumento'])."</span>");}?>
                                            </td>
                                            <td>
                                            <form name="selectform">
                                                        <input  name="cNombreRemitente" value="<?=trim(utf8_encode(ucwords(strtolower($RsRem['cNombre']))))?>" type="hidden">
                                                        <input name="iCodRemitente" value="<?=trim($RsRem['iCodRemitente'])?>" type="hidden">
                                                        <input type="button" value="seleccione" class="btn btn-secondary" onClick="sendValue(this.form.cNombreRemitente,this.form.iCodRemitente);">
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
                    </div>
                </div>
            </div>
        </div>
	</form>
</div>


<?php include("includes/pie.php"); ?>
<script LANGUAGE="JavaScript">
    function sendValue (s,t){
        var selvalue1 = s.value;
        var selvalue2 = t.value;
        window.opener.document.getElementById('cNombreRemitente').value = selvalue1;
        window.opener.document.getElementById('iCodRemitente').value = selvalue2;
        window.opener.document.getElementById('Remitente').value = selvalue2;
        window.close();
    }
</script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>