<?php session_start();
    ini_set('date.timezone', 'America/Lima');
    include_once("../conexion/conexion.php");

    if($_GET['estado']==0){
        $sql= "update T_MAE_CALENDARIO
            set  nutil='1'
            where dfecha_calendario='".$_GET['id']."'";
    }else{
        $sql= "update T_MAE_CALENDARIO
            set  nutil='0'
            where dfecha_calendario='".$_GET['id']."'";
    }
    
    $query=sqlsrv_query($cnx,$sql);
?>
    <meta http-equiv="refresh" content="0;URL='calendario.php?anio=<?php echo $_GET['anio'];?>&mes=<?php echo $_GET['mes'];?>'" />    