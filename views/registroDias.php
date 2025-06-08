<?php
ini_set('date.timezone', 'America/Lima');
require_once("../conexion/conexion.php");

function fecha($fecha)
{
    $a=explode(" ", $fecha);
    $b=$a[0];
    $arreglo = explode('-', $b);
    $fechaNueva = $arreglo[2]."-".$arreglo[1]."-".$arreglo[0];
    return $fechaNueva;
}

function formato_fecha($fecha){
    $newfecha   =   date ( 'Y-m-d' , $fecha);
    return $newfecha;
}

// sacamos que tipo de calendario  es
$sql   = "SELECT * FROM Tra_M_Tramite WHERE icodtramite='".$_POST['iCodTramite']."'";
$query = sqlsrv_query($cnx,$sql);
$rs    = sqlsrv_fetch_array($query);
do{
    $registro=fecha($rs['fFecRegistro']);
}while($rs=sqlsrv_fetch_array($query));

if($_POST['tipox']==0){
    $fecha = $registro;
    $diaa="+".$_POST[CantDias]." day";
    $nuevafecha = strtotime ( $diaa , strtotime ( $fecha ) ) ;
    $nuevafecha=formato_fecha($nuevafecha);
}else{
    // buscamos la fecha sumada mas la cantidad de dias ejemplo lunes 13 + 10 dias es el dia 23.
    $fecha00 = $registro;
    $dia00="+".$_POST[CantDias]." day";
    $nuevafecha00 = strtotime ( $dia00 , strtotime ( $fecha00 ) ) ;
    $nuevafecha00 = formato_fecha($nuevafecha00);

    // buscamos todos los sabados y domingos entre el rando inicial dia 13 y final dia 23 
    // primera ronda
    $sql01   = "  select * from T_MAE_CALENDARIO
    where
    (dfecha_calendario>'".$registro."' and dfecha_calendario<='".$nuevafecha00."')";
    $query01 = sqlsrv_query($cnx,$sql01);
    $rs01    = sqlsrv_fetch_array($query01);
    $acu01=0;
    do{
        if($rs01['nutil']==1){
            $acu01+=1;
        }
    }while($rs01=sqlsrv_fetch_array($query01));
    
    $dia01="+".$acu01." day";
    $nuevafecha01 = strtotime ( $dia01 , strtotime ( $nuevafecha00 ) ) ;
    $nuevafecha01 = formato_fecha($nuevafecha01);
    $nuevafecha01 = $nuevafecha01;

    // si ya se encontro sabado , domingo o fereado entonces descartamos esos dias para agregar los dias 
    // descartados, ejemplo si entre el 13 al 23 encontramos 1 sabado y 1 domingo eso es agregarle 2 dias
    // mas al final final: 23+2 = 25  nuevo dia final.

    // ahora con este nuevo dia verificamos si entre el ultimo dia de la primera ronda 23 al 25 
    // no se encuentre entre ese rango un sabado , domingo  o fereado.
    // repetimos operacion : 2da ronda
    $sql02   = "  select * from T_MAE_CALENDARIO
    where
    (dfecha_calendario>'".$nuevafecha00."' and dfecha_calendario<='".$nuevafecha01."')";
    $query02 = sqlsrv_query($cnx,$sql02);
    $rs02    = sqlsrv_fetch_array($query02);
    $acu02=0;
    do{
        if($rs02['nutil']==1){
            $acu02+=1;
        }
    }while($rs02=sqlsrv_fetch_array($query02));

    $dia02="+".$acu02." day";
    $nuevafecha02 = strtotime ( $dia02 , strtotime ( $nuevafecha01 ) ) ;
    $nuevafecha02 = formato_fecha($nuevafecha02);

    // si se encontro repetir la suma y rango de fecha, pero porsia caso repetimos una ves mas si es que 
    //esta entre dos meses entre fechas encontrar sabado , domingo o fereado pero si no lo hay  
    //sumara +0 asi que no afectara esta ultima ronda de rangos que repetimos.
    // repetimos operacion : 3da ronda
    $sql03   = "  select * from T_MAE_CALENDARIO
    where
    (dfecha_calendario>'".$nuevafecha01."' and dfecha_calendario<='".$nuevafecha02."')";
    $query03 = sqlsrv_query($cnx,$sql03);
    $rs03    = sqlsrv_fetch_array($query03);
    $acu03=0;
    do{
        if($rs03['nutil']==1){
            $acu03+=1;
        }
    }while($rs03=sqlsrv_fetch_array($query03));

    $dia03="+".$acu03." day";
    $nuevafecha03 = strtotime ( $dia03 , strtotime ( $nuevafecha02 ) ) ;
    $nuevafecha03 = formato_fecha($nuevafecha03);
    $nuevafecha = $nuevafecha03;
    
}

$sql = "UPDATE Tra_M_Tramite 
            SET nTiempoRespuesta='".$_POST[CantDias]."', 
                FechaPlazoFinal='$nuevafecha', 
                tipoPlazoFinal='$_POST[tipox]' 
        WHERE iCodTramite='$_POST[iCodTramite]'";

 $rs=sqlsrv_query($cnx,$sql);
//echo "<hr>".$sql;
sqlsrv_close($cnx);
header("Location: ../views/pendientesControl.php");
?>