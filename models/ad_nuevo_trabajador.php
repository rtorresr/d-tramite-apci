<?php
  $contrasena = md5($_POST['cUsuario'] . $_POST['cPassword']);

  $sql1 = "SELECT * FROM Tra_M_Trabajadores WHERE cUsuario='".$_POST['cUsuario']."'";
  $rs1  = sqlsrv_query($cnx,$sql1);

  if (!sqlsrv_has_rows($rs1)){
    // $sqlPerfil = "SELECT cDescPerfil FROM Tra_M_Perfil WHERE iCodPerfil = '".$_POST['iCodPerfil']."'";
    // $rsPerfil  = sqlsrv_query($cnx,$sqlPerfil);
    // $RsPerfil  = sqlsrv_fetch_array($rsPerfil);

    // if ($_POST['iCodPerfil'] == '18') {
    //   // ES_EXTERNO = 1 --> USUARIO EXTERNO QUE TIENE PERFIL 'WEB'.
    //   // ES_EXTERNO = 0 --> TODOS LOS USUARIOS QUE NO SEAN EXTERNOS, ES DECIR, TRABAJADORES INTERNOS, CUYO VALOR POR DEFECTO ES 0.
    //   // CODIGO_SEDE = '01' --> CORRESPONDE A LA SEDE LIMA, Y SER� EL VALOR POR DEFECTO DE TODOS LOS USUARIOS EXTERNOS.
    //   // LOS USUARIOS EXTERNOS TIENEN QUE REGISTRARSE CON SU N�MERO DE TR�MITE (cCodificac�n)
    //   $sqlTipoDoc = "SELECT cTipoDocIdentidad FROM Tra_M_Doc_Identidad WHERE cDescDocIdentidad = '".$_POST['identificacion']."'";
    //   $rsTipoDoc  = sqlsrv_query($cnx,$sqlTipoDoc);
    //   $RsTipoDoc  = sqlsrv_fetch_array($rsTipoDoc);

    //   $sqlPerfil = "SELECT iCodPerfil FROM Tra_M_Perfil WHERE cDescPerfil LIKE 'WEB%'";
    //   $rsPerfil  = sqlsrv_query($cnx,$sqlPerfil);
    //   $RsPerfil  = sqlsrv_fetch_array($rsPerfil);

    //   $sqlVirtual = "SELECT iCodOficina FROM Tra_M_Oficinas WHERE cNomOficina /* LIKE '%VIRTUAL%' */";
    //   $rsVirtual  = sqlsrv_query($cnx,$sqlVirtual);
    //   $RsVirtual  = sqlsrv_fetch_array($rsVirtual);
      
    //   $sql = "SP_TRABAJADORES_INSERT 
    //           '".$RsVirtual['iCodOficina']."'
    //           ,NULL
    //           ,'".$_POST['iCodPerfil']."'
    //           ,'".$_POST['cNombresTrabajador']."'
    //           ,NULL
    //           ,'".$RsTipoDoc['cTipoDocIdentidad']."'
    //           ,'".$_POST['cNumDocIdentidad']."'
    //           ,NULL
    //           ,NULL
    //           ,NULL
    //           ,NULL
    //           ,'".$_POST['cUsuario']."'
    //           ,'$contrasena'
    //           ,'".$_POST['txtestado']."'
    //           ,1 
    //           ,'01'
    //           ,'".$_POST['cCodificacion']."";


    //   $rs = sqlsrv_query($cnx,$sql);

    //   $sqlUltimo = "SELECT TOP 1 iCodTrabajador FROM Tra_M_Trabajadores ORDER BY iCodTrabajador DESC";
    //   $rsUltimo  = sqlsrv_query($cnx,$sqlUltimo);
    //   $RsUltimo  = sqlsrv_fetch_array($rsUltimo);

    //   /*$sqlPerUsu = "INSERT Tra_M_Perfil_Ususario(iCodPerfil,iCodOficina,iCodTrabajador)
    //                 VALUES('".$RsPerfil['iCodPerfil']."','".$RsVirtual['iCodOficina']."','".$RsUltimo['iCodTrabajador']."')";
    //   $rsPerUsu  = sqlsrv_query($cnx,$sqlPerUsu);*/

    //   header("Location:../views/iu_trabajadores_externos.php");
    // } else {
      $idc = $_POST['iCodCategoria']??'null';

      $sql = "SP_TRABAJADORES_INSERT 
              '".($_POST['iCodOficina']??'')."'
              ,".$idc."
              ,'".($_POST['iCodPerfil']??'')."'
              ,'".($_POST['cNombresTrabajador']??'')."'
              ,'".($_POST['cApellidosTrabajador']??'')."'
              ,'".($_POST['cTipoDocIdentidad']??'')."'
              ,'".($_POST['cNumDocIdentidad']??'')."'
              ,'".($_POST['cDireccionTrabajador']??'')."'
              ,'".($_POST['cMailTrabajador']??'')."'
              ,'".($_POST['cTlfTrabajador1']??'')."'
              ,'".($_POST['cTlfTrabajador2']??'')."'
              ,'".($_POST['cUsuario']??'')."'
              ,'$contrasena'
              ,'".($_POST['txtestado']??'')."'
              ,0
              ,'".($_POST['CODIGO_SEDE']??'')."'
              ,NULL";

      $nombres = $_POST['cNombresTrabajador'];
      $usuario = $_POST['cUsuario'];
      $email = $_POST['cMailTrabajador'];
      $password = $_POST['cPassword'];
      $url = 'http://192.168.1.28/sitdd';

      $rs = sqlsrv_query($cnx,$sql);
      //include '../core/email.php';

      header("Location:../views/iu_trabajadores.php");
    // }
  } else {
    if (strcasecmp(($RsPerfil['cDescPerfil']??''), 'WEB')  == 0) {
      header("Location: ../views/iu_nuevo_trabajador_externo.php?cUsuario=" . ($_POST['cUsuario']??'') . "&iCodPerfil=" . ($_POST['iCodPerfil']??'') . "&cNombresTrabajador=" . ($_POST['cNombresTrabajador']??'') . "&cApellidosTrabajador=" . ($_POST['cApellidosTrabajador']??'') . "&=" . cTipoDocIdentidad . "&=" . ($_POST['cTipoDocIdentidad']??'') . "&cNumDocIdentidad=" . ($_POST['cNumDocIdentidad']??'') . "&cDireccionTrabajador=" . ($_POST['cDireccionTrabajador']??'') . "&cMailTrabajador=" . ($_POST['cMailTrabajador']??'') . "&cTlfTrabajador1=" . ($_POST['cTlfTrabajador1']??'') . "&cTlfTrabajador2=" . ($_POST['cTlfTrabajador2']??'') . "&cPassword=" . ($_POST['cPassword']??'') . "&mensaje='1' ");
    }else{
      header("Location: ../views/iu_nuevo_trabajador.php?cUsuario=" . ($_POST['cUsuario']??'') . "&iCodOficina=" . ($_POST['iCodOficina']??'') . "&iCodCategoria=" . ($_POST['iCodCategoria']??'') . "&iCodPerfil=" . ($_POST['iCodPerfil']??'') . "&cNombresTrabajador=" . ($_POST['cNombresTrabajador']??'') . "&cApellidosTrabajador=" . ($_POST['cApellidosTrabajador']??'') . "&=" . cTipoDocIdentidad . "&=" . ($_POST['cTipoDocIdentidad']??'') . "&cNumDocIdentidad=" . ($_POST['cNumDocIdentidad']??'') . "&cDireccionTrabajador=" . ($_POST['cDireccionTrabajador']??'') . "&cMailTrabajador=" . ($_POST['cMailTrabajador']??'') . "&cTlfTrabajador1=" . ($_POST['cTlfTrabajador1']??'') . "&cTlfTrabajador2=" . ($_POST['cTlfTrabajador2']??'') . "&cPassword=" . ($_POST['cPassword']??'') . "&mensaje='1' ");
    }
  }
?>