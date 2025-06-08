<?php session_start();
    ini_set('date.timezone', 'America/Lima');
    include_once("../conexion/conexion.php");

    $usuario=$_SESSION['CODIGO_TRABAJADOR'];
    //$oficina=$_SESSION['iCodOficinaLogin'];
    $lista=$_POST['lista'];
    $oficina=$_POST['oficina'];
    $id=$_POST['id'];

    $sql= "INSERT INTO T_MOV_LIBRO_BLANCO ([usuario],[cod_oficina],[indice],[cod_documento]) VALUES ('".$usuario."','".$oficina."','".$lista."','".$id."')";
    $query=sqlsrv_query($cnx,$sql);
    //echo $sql;
?>
    <meta http-equiv="refresh" content="0;URL='entradagenerallibroblanco.php'" />    