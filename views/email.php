<style>
    .body{
        font-size: 12px;
        font-family: 'arial',cursive;
    }
</style>
<?php
ini_set('date.timezone','America/Lima');


if($opc==1){
    $sql= "select cMailTrabajador from Tra_M_Trabajadores where iCodTrabajador='".$responsable."'";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    do{
        $emailx =   $rs['cMailTrabajador'];
    }while($rs=sqlsrv_fetch_array($query));

    $sql1= "select cDescTipoDoc from Tra_M_Tipo_Documento where cCodTipoDoc='".$tipodocumento."'";
    $query1=sqlsrv_query($cnx,$sql1);
    $rs1=sqlsrv_fetch_array($query1);
    do{
        $tipodocumento =   $rs1['cDescTipoDoc'];
    }while($rs1=sqlsrv_fetch_array($query1));
    
    $sql2="select * from Tra_M_Tramite where iCodTramite='".$idtramitenew."'";
    $query2=sqlsrv_query($cnx,$sql2);
    $rs2=sqlsrv_fetch_array($query2);
    
    do{
        $casunto=$rs2['cAsunto'];
    }while($rs2=sqlsrv_fetch_array($query2));

    if(rtrim(ltrim($emailx))!=''){   
    		//if($xemail!=$emailx){

       
        $para  = $emailx; // separas con comas , aqui enviamos a la persona su correo

        // Asunto
        $titulo = 'NOTIFICACION - SISTEMA TRAMITE DOCUMENTARIO DIGITAL ';

        // Cuerpo o mensaje
        $mensaje = '
        <body>
        Usted tiene un <b>Nuevo Documento Pendiente</b> | '.date('d-m-Y H:i:s').'.<br>
        <table>
            <tr>
                <td>
                    <b>Nro Tramite:</b> </td><td> '.$codx.'
                </td>
            </tr>
            <tr>
                <td> 
                    <b>Documento: </b></td><td> '.$tipodocumento.'</td>
            </tr>
            <tr>
                <td> 
                    <b>Asunto: </b></td><td> '.$casunto.'</td>
            </tr>
            <tr>
                <td> 
                    <b>Remitente: </b>
                </td><td> '.$remitente.'</td>
            </tr>
        </table>
        </body>
        ';
        // Cabecera que especifica que es un HMTL
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UFT-8' . "\r\n";

        // Cabeceras adicionales
        $cabeceras .= 'From: Recordatorio <TRAMITEDOCUMENTARIO DIGITAL@SITDD.gob.pe>' . "\r\n";

        // enviamos el correo!
        mail($para, $titulo, $mensaje, $cabeceras);
        //}
    }  
    
}else if($opc==2){

	if(rtrim(ltrim($idtramitenew))!=''){

    $sql= "select * from Tra_M_Tramite where iCodTramite='".$idtramitenew."'";
    $query=sqlsrv_query($cnx,$sql);
    $rs=sqlsrv_fetch_array($query);
    do{
        $codifica   =   $rs['cCodificacion'];
        $asunto     =   $rs['cAsunto'];
    }while($rs=sqlsrv_fetch_array($query));
    
    // buscamos el correo del jefe de la oficina

    
    $sql1= "SELECT * FROM Tra_M_Perfil_Ususario TPU
            INNER JOIN Tra_M_Trabajadores TT ON TPU.iCodTrabajador = TT.iCodTrabajador
            WHERE TPU.iCodPerfil = '3' AND TPU.iCodOficina = '".$_SESSION['iCodOficinaLogin']."'";
    $query1=sqlsrv_query($cnx,$sql1);
    $rs1=sqlsrv_fetch_array($query1);

    do{
        if(rtrim(ltrim($rs1['cMailTrabajador']))!=''){
            
        $para  = $rs1['cMailTrabajador']; // separas con comas , aqui enviamos a la persona su correo

        // Asunto
        $titulo = 'NOTIFICACION - SISTEMA TRAMITE DOCUMENTARIO DIGITAL';

        // Cuerpo o mensaje
        $mensaje = '
        <body>    
            Usted Tiene un Documento <b>Pendiente por Aprobacion</b> | '.date('d-m-Y H:i:s').'.<br>
            <table>
                <tr>
                    <td><b>Documento:</b> </td><td> '.$codifica.'</td>
                </tr>
                <tr>
                    <td><b>Asunto:</b> </td><td> '.$asunto.'</td>
                </tr>
            </table>        
        </body>
        ';

        // Cabecera que especifica que es un HMTL
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UFT-8' . "\r\n";

        // Cabeceras adicionales
        $cabeceras .= 'From: Recordatorio <TRAMITEDOCUMENTARIO DIGITAL@SITDD.gob.pe>' . "\r\n";

        // enviamos el correo!
        mail($para, $titulo, $mensaje, $cabeceras);   
            
        }
    }while($rs1=sqlsrv_fetch_array($query1));
    
    }
}
?>