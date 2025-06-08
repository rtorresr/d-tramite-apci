<style>
    .color{
        color: aliceblue;
        background-color: #bebebe;
    }
</style>
<?php
    include_once("../conexion/conexion.php");
    
    $sql="select * from Tra_M_Trabajadores";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    
    echo "<table border='1'>";
    do{
        //echo $rs['iCodTrabajador']." - ";
        echo "<tr><td>";
        echo $rs['cNombresTrabajador']." - ";
        echo $rs['cApellidosTrabajador'];
        echo "</td>";
            echo "<td>";
        
            $sqlx="select 
                    (select cDescPerfil from Tra_M_Perfil where iCodPerfil =a.iCodPerfil) as perfil,
                    (select cNomOficina from Tra_M_Oficinas where iCodOficina=a.iCodOficina) as oficina,
                    (select cSiglaOficina from Tra_M_Oficinas where iCodOficina=a.iCodOficina) as sigla
                    from Tra_M_Perfil_Ususario a where iCodTrabajador='".$rs['iCodTrabajador']."'";
            $queryx=sqlsrv_query($cnx,$sqlx);
            $rsx=sqlsrv_fetch_array($queryx);
            
            echo "<table width='100%'>";
            echo "<tr class='color'>";
            echo "<td width='30%'>Perfil</td>";
            echo "<td width='20%'>Sigla</td>";
            echo "<td>Oficina</td>";
            echo "</tr>";
            do{
                echo "<tr>";
                    echo "<td>".$rsx['perfil']."</td>";
                    echo "<td>".$rsx['sigla']."</td>";
                    echo "<td>".$rsx['oficina']."</td>";
                echo "</tr>";
            }while($rsx=sqlsrv_fetch_array($queryx));
            echo "</table>";
        
            echo "</td></tr>";
    }while($rs=sqlsrv_fetch_array($query));
    echo "</table>";
?>