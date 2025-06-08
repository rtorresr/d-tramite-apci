<?php session_start();
include_once("../conexion/conexion.php");	    
    ini_set('date.timezone', 'America/Lima');

    $sql= "select 
        cCodificacion,
        (select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodRemitente) as iCodRemitente,
        cAsunto,fFecRegistro
        ,* from Tra_M_Tramite m
        where iCodTramite='".$_GET['id']."'";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    do{
        $a=$rs['cCodificacion'];
        $b=$rs['iCodRemitente'];
        $c=$rs['cAsunto'];
        $d=$rs['fFecRegistro'];
    }while($rs=sqlsrv_fetch_array($query));

    $insert="insert into T_MAE_PRESTAMO
(oficina_solicitante,fecha_solicitud,cod_documento,icodtramite,Cod_estado_prestamo,solicitadoPor)
values
('".$_SESSION['iCodOficinaLogin']."',GETDATE(),'".$a."','".$_GET['id']."',1,'".$_SESSION['CODIGO_TRABAJADOR']."')
";
    sqlsrv_query($cnx,$insert);

?>
    <meta http-equiv="refresh" content="0;URL='entradageneralprestamo.php'" />    