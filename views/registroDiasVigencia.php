<?php
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />

</head>

<?php
     require_once("../conexion/conexion.php");
    $sql= "select nTiempoRespuesta from Tra_M_Tramite where iCodTramite='".$_GET['iCodTramite']."'";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    do{
        $tiempo=$rs['nTiempoRespuesta'];
    }while($rs=sqlsrv_fetch_array($query));
?>

<body>
<table width="355" height="114" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
    <tr>
        <td height="112" align="left" valign="top">
            <div class="AreaTitulo">Plazo de Tramite:</div>
		    <table width="351" border="0" cellpadding="0" cellspacing="3" align="center">
		        <form method="POST" name="frmRegistro" action="registroDias.php" target="_parent">
			    <input type="hidden" name="iCodTramite" value="<?=$_GET[iCodTramite]?>">
		    <tr>
                <td colspan="2">&nbsp;</td>
		        <tr>

		            <td colspan=2>
                    <?php
                       $sql= "select * from Tra_M_Tramite where iCodTramite='".$_GET['iCodTramite']."'";
                       $query=sqlsrv_query($cnx,$sql);
                       $rs=sqlsrv_fetch_array($query);
                       do{
                           $inicio=$rs['fFecRegistro'];
                           $final=$rs['FechaPlazoFinal'];
                           $tipo=$rs['tipoPlazoFinal'];
                       }while($rs=sqlsrv_fetch_array($query));

                        function fecha($fecha){

                            $a=explode(" ",$fecha);
                            $b=$a[0];

                            return $b;
                        }

                        if($tipo==1){
                            $a="";
                            $b="checked";
                        }else{
                            $a="checked";
                            $b="";
                        }
                   ?>
            
		        <table border='0' width='100%'>
		            <tr>
		                <td>Fecha inicial: <b><?php echo fecha($inicio);?></b></td>
		                <td>Fecha final: <b><?php echo fecha($final);?></b></td>
		            </tr>
		            <tr>
		                <td colspan='2'>
                            <input type="radio" value="0" name="tipox" <?php echo $a;?>>Dias calendario
                            <input type="radio" value="1" name="tipox" <?php echo $b;?>>Dias utiles
                        </td>
		            </tr>
		        </table>
		        
		        
		    </td>
		</tr>
		    <tr><td colspan="2">&nbsp;</td>
		<tr>
			<td width="230" align="right">Ingrese cantidad de dias:</td>
			<td width="112"><input type="text" value="<?php echo $tiempo;?>" name="CantDias" style="width:30px;text-align:right" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></td>
		</tr>
        <tr>
			<td colspan="2">
				<input name="button" type="button" class="btn btn-primary" value="Continuar" onclick="Registrar();">
            </td>

        </tr>

          </form>
        </table>

</td>

</tr>

</table>


<script Language="JavaScript">
    function Registrar(){
        if (document.frmRegistro.CantDias.value.length == "")
        {
            alert("Ingrese cantidad de dias");
            document.frmRegistro.CantDias.focus();
            return (false);
        }
        document.frmRegistro.submit();
    }
</script>
</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>