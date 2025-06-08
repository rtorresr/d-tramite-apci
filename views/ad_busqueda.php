<?php
if(isset($_GET['sw'])){
    if($_GET['sw']==1){
    $sql= "select * from Tra_M_Trabajadores where iCodTrabajador=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==2){
    $sql= "select * from Tra_M_Remitente where iCodRemitente=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==3){
    $sql= "select * from Tra_M_Oficinas where iCodOficina=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==4){
    $sql= "select * from Tra_M_Perfil where iCodPerfil=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==5){
    $sql= "select * from Tra_M_Tipo_Documento where cCodTipoDoc=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==6){
    $sql= "select * from Tra_M_Doc_Identidad where cTipoDocIdentidad=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==7){
    $sql= "select * from Tra_M_Tupa where iCodTupa=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==8){
    $sql= "select * from Tra_M_Tupa_Requisitos where iCodTupa=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==9){
    $sql= "select * from Tra_M_Tupa_Requisitos where iCodTupaRequisito=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==10){
    $sql= "select * from Tra_M_Ubicacion_Oficina where iCodUbicacion=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==11){
    $sql= "SELECT * FROM Tra_M_Indicaciones where iCodIndicacion=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==12){
    $sql= "SELECT * FROM Tra_M_Categoria where iCodCategoria=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
    if($_GET['sw']==13){
    $sql= "SELECT * FROM Tra_M_Grupo_Remitente where iCodGrupo=".$cod;
    $rs=sqlsrv_query($cnx,$sql);
    $Rs=sqlsrv_fetch_array($rs);
    }
}
?>