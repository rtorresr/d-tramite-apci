<?php session_start();
    ini_set('date.timezone', 'America/Lima');
    include_once("../conexion/conexion.php");
?>
<style>
    table{
        font-family: 'arial',cursive;
        font-size: 10px;
    }
</style>
<?php
    $sql= "select 
            cod_auto, 
            (select (rtrim(ltrim(cNombresTrabajador))+' '+rtrim(ltrim(cApellidosTrabajador))) as nombre from Tra_M_Trabajadores where iCodTrabajador=a.usuario) as usuario, 
            (select (iCodOficina) as nombre from Tra_M_Oficinas where iCodOficina=a.cod_oficina) as cod_oficina, 
            (select (cSiglaOficina+' '+cNomOficina) as nombre from Tra_M_Oficinas where iCodOficina=a.cod_oficina) as oficina, 
            (select (codigo+' '+seccion) nombre from T_MAE_LIBRO_BLANCO where cod_auto=a.indice) as indicea, indice cod_documento, 
            (select iCodTramite from Tra_M_Tramite where iCodTramite=a.cod_documento) as iCodTramite, 
            (select cCodificacion from Tra_M_Tramite where iCodTramite=a.cod_documento) as cod_tramite, 
            (select descripcion from Tra_M_Tramite where iCodTramite=a.cod_documento) as descripcion, 
            (select cAsunto from Tra_M_Tramite where iCodTramite=a.cod_documento) as asunto, 
            (select ARCHIVO_FISICO from Tra_M_Tramite where iCodTramite=a.cod_documento) as archivo 
        from T_MOV_LIBRO_BLANCO a 
        where indice='".$_GET['id']."' and cod_oficina='".$_GET['oficina']."'
        ";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    //echo $sql;
?>
   <table width='100%'>
       <tr>
           <td style="background:#8e9b9d;color:#fff;" align='center'>
               <b>Codigo</b>
           </td>
           <td style="background:#8e9b9d;color:#fff;" align='center'>
               <b>Asunto</b>
           </td>
           <td style="background:#8e9b9d;color:#fff;" align='center'>
               <b>PDf</b>
           </td>
       </tr>
<?php    
    do{
        echo "<tr>";
        echo "<td>".$rs['cod_tramite']."</td>";
        echo "<td>".$rs['asunto']."</td>";
        echo "<td>";
            if(strlen(rtrim(ltrim($rs['descripcion'])))>0){
                echo "<a href='ver_digital.php?iCodTramite=".$rs['cod_tramite']."'>";
                echo "<img src='images/1471041812_pdf.png'>";
                echo "</a> ";
            }
            
        if($rs[iCodTramite]!=''){
            	$consulta  = "SELECT * FROM Tra_M_Tramite_Digitales WHERE iCodTramite ='".$rs[iCodTramite]."'";
                //echo $consulta."<br>";
            	$resultado = sqlsrv_query($cnx,$consulta);
            	$data      = sqlsrv_fetch_array($resultado);
                //echo $data["iCodDigital"];
            	if ($data["cNombreNuevo"]) {
            		$a = '../cAlmacenArchivos/&file='.trim($data["cNombreNuevo"]);
                    $b = $RsTra['iCodMovimiento'];
                    $c = $RsTra['nFlgEstado'];
            ?>
            <script>
                function url(a,b,c){
                    var URLactual = window.location;
                    window.open('download.php?direccion='+a+'&iCodMovimiento='+b+'&nFlgEstado='+c, '_blank');
                    setTimeout('document.location.reload()',100)
                }
            </script>
            <a href="javascript:url('<?php echo $a;?>','<?php echo $b?>','<?php echo $c?>')" title="Documento Complementario">
            <?php
                echo "<img src=images/icon_download.png border=0 width=16 height=16 alt=\"".trim($data["cNombreNuevo"])."\">";
            ?>
            </a>
 <?php
            	}
        }
        
        echo "</td>";
        echo "</tr>";
    }while($rs=sqlsrv_fetch_array($query));
?>
    </table>  
<?php
    /*
    if(strlen(rtrim(ltrim($RsTramitePDF->descripcion)))>0){
        
    }*/
?>