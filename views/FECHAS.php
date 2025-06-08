<?php

function cero($num){
    if(strlen($num)==1){
        return "0".$num;
    }else{
        return $num;
    }
}

function saber_dia($nombredia) {
    $a=explode("-",$nombredia);
    $b=$a[2]."-".$a[1]."-".$a[0];
    $dias = array('', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');
    $fecha = $dias[date('N', strtotime($b))];
    return $fecha;
}

$anio="2019";
for($mes=1; $mes<=12;$mes++){
    //echo $mes."<br>";
    $dias=cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
    for($ndias=1;$ndias<=$dias;$ndias++){
        //echo $ndias." - ";
        $nmes=cero($mes);
        $nndias=cero($ndias);
        
        //  $anio-$nndias-$nmes o $anio-$nmes-$nndias << año-dia-mes o año-mes-dia
        // depende como este configurado el sql server
        
        //$fecha=$anio."-".$nndias."-".$nmes;
        $fecha=$anio."-".$nmes."-".$nndias;
        
        if(saber_dia($fecha)=="Sabado" or saber_dia($fecha)=="Domingo"){
            echo "insert into T_MAE_CALENDARIO(dfecha_calendario,nutil)values('".$fecha."','1');<br>";
        }else{
            echo "insert into T_MAE_CALENDARIO(dfecha_calendario,nutil)values('".$fecha."','0');<br>";
        }
        
    }
    //echo "<hr>";
}
?>