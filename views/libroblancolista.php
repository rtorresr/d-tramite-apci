<?php session_start();
  ini_set('date.timezone', 'America/Lima');
  include_once("../conexion/conexion.php");
        
  $sql   = "SELECT * FROM T_MAE_LIBRO_BLANCO";
  $queryx = sqlsrv_query($cnx,$sql);
  $rsx    = sqlsrv_fetch_array($queryx);
  $id    = $_GET['id'];
?>
<style type="text/css">
    form{
        font-family: 'arial';
        font-size: 10px;
    }
    b{
        ont-family: 'arial';
        font-size: 9px;
    }
</style>

<?php
    // aqui preguntamos si existe ya un tramite con libro blanco de esta oficina (general) para preguntar a los combobox
    $sql_c="select cod_oficina,indice from T_MOV_LIBRO_BLANCO where cod_documento='".$id."'";
    $query_c=sqlsrv_query($cnx,$sql_c);
    $rs_c=sqlsrv_fetch_array($query_c);
    
    do{
        $indice    =   $rs_c['indice'];
        $oficina   =   $rs_c['cod_oficina'];
    }while($rs_c=sqlsrv_fetch_array($query_c));
?>

<form method="post" name="form"  target="_parent">
  <input type="hidden" value="<?php echo $id;?>" name="id">
    <table width='100%'>
      <tr>
       <tr>
        <td>
           <?php
            $sql    = "SELECT * FROM Tra_M_Tramite WHERE iCodTramite='".$id."'";
            $query  = sqlsrv_query($cnx,$sql);
            $rs     = sqlsrv_fetch_array($query);
            do{
                $cod=$rs['cCodificacion'];
            }while($rs=sqlsrv_fetch_array($query));
        ?>
            <b>Cod. Documento:</b> &nbsp; <?php echo $cod;?><br><br>
        </td>
    </tr>
        <td>
           <b>Indice:</b><br>
            <select name="lista">
            <option value="">Seleccione</option>
            <?php
                function detector($num){
                  $mystring = $num;
                  $findme   = '.';
                  $pos = strpos($mystring, $findme);
                  if ($pos !== false) {
                       return "si";
                  } else {
                       return "no";
                  }
                }
                
            do{
                
                if(detector($rsx['codigo'])=='si'){
                    $espacio="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }else{
                    $espacio="";
                }
                
                if($indice==$rsx['cod_auto']){
                    $act='selected';
                }else{
                    $act='';
                }
            ?>
            <option value="<?php echo $rsx['cod_auto'];?>" <?php echo $act;?>><?php echo $espacio;?><?php echo $rsx['codigo'];?> - <?php echo $rsx['seccion'];?></option>
            <?php
            }while($rsx=sqlsrv_fetch_array($queryx));
            ?>
            </select>
            <br><br>
        </td>
    </tr>

    <tr>
        <td>
        <b>Oficina:</b> <br>
        <?php
            $sqlOfVirtual = "SELECT iCodOficina FROM Tra_M_Oficinas WHERE cNomOficina /* LIKE '%VIRTUAL%' */";
            $rsOfVirtual  = sqlsrv_query($cnx,$sqlOfVirtual);
            $RsOfVirtual  = sqlsrv_fetch_array($rsOfVirtual);
            $iCodOficinaVirtual = $RsOfVirtual['iCodOficina'];

            $sqlDep2 = "SELECT * FROM Tra_M_Oficinas 
                        WHERE iFlgEstado != 0 
                              AND iCodOficina != '".$_SESSION['iCodOficinaLogin']."'
                              AND iCodOficina != $iCodOficinaVirtual
                        ORDER BY cNomOficina ASC";

            //$sql= "select * from Tra_M_Oficinas order by cNomOficina asc";
            $query=sqlsrv_query($cnx,$sqlDep2);
            $rs=sqlsrv_fetch_array($query);

            echo "<select name='oficina'>";
            echo "<option value=''>Seleccione</option>";
            do{
                if($oficina==$rs['iCodOficina']){
                    $acto='selected';
                }else{
                    $acto='';
                }
                //echo "<option value='".$rs['iCodOficina']."'>".trim($rs['cNomOficina'])." | ".trim($rs["cSiglaOficina"])."</option>";
                //echo "<option value='".$rs['iCodOficina']."'>".substr($rs['cNomOficina'],0,70)." | ".trim($rs["cSiglaOficina"])."</option>";
                echo "<option value='".$rs['iCodOficina']."' ".$acto.">".substr($rs['cNomOficina'],0,70)."</option>";
            }while($rs=sqlsrv_fetch_array($query));
            echo "</select>";
        ?>
        <br><br>
        </td>
    </tr>

</table>

<input type="button" value="Aceptar" onclick="segurida();">
</form>

<script type="text/javascript">
    function segurida(){
        if (document.form.lista.value.length == "")
        {
            alert("Seleccione un Indice");
            return (false);
        }
        if (document.form.oficina.value.length == "")
        {
            alert("Seleccione una Oficina");
            return (false);
        }
        document.form.action="libroblancodata.php";
        document.form.submit();
    }
</script>  