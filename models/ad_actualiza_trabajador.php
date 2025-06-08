<?php
    include('../core/CURLConection.php');
    include('../conexion/srv-Nginx.php');

	$sqlES_EXTERNO = "SELECT ES_EXTERNO FROM Tra_M_Trabajadores WHERE iCodTrabajador = ".$_POST['iCodTrabajador']??'';
	$rsES_EXTERNO  = sqlsrv_query($cnx,$sqlES_EXTERNO);
	$RsES_EXTERNO  = sqlsrv_fetch_array($rsES_EXTERNO);

	if ($RsES_EXTERNO['ES_EXTERNO'] == 0) { // USUARIO INTERNO
        $firma='';
        $vb = '';

	    if($_FILES['firma']['size'] != 0 || $_FILES['VistoBueno']['size'] != 0 ) {

            //$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
            $url_srv = $hostUpload.':'.$port.$path;
            $curl = new CURLConnection($url_srv.$fileUpload);

            $url_f = 'firmas/'.$_POST['cUsuario'].'/';
            $_POST['path'] = $url_f;
            $_POST['name'] = 'firma';
            $_POST['new_name'] = 'firma.png';
            print $curl->uploadFile($_FILES, $_POST);

            $_POST['name'] = 'VistoBueno';
            $_POST['new_name'] = 'vistobueno.png';
            print_r($curl->uploadFile($_FILES, $_POST));

            $curl->closeCurl();

            $firma = $url_srv.$url_f."firma.png";

            $vb = $url_srv.$url_f."vistobueno.png";

        }else{
            $firma = $RsES_EXTERNO["firma"];
            $vb = $RsES_EXTERNO["VistoBueno"];
        }

        $cat = $_POST['iCodCategoria']??'null';
        $encargado  =   $_POST['jf_encargado']??'';
        $nombre     =   $_POST['cNombresTrabajador']??'';
        $apellido   =   $_POST['cApellidosTrabajador']??'';
        $tipo       =   $_POST['cTipoDocIdentidad']??'';
        $num        =   $_POST['cNumDocIdentidad']??'';
        $direccion  =   $_POST['cDireccionTrabajador']??'';
        $tra1       =   $_POST['cTlfTrabajador1']??'';
        $tra2       =   $_POST['cTlfTrabajador2']??'';
        $mail       =   $_POST['cMailTrabajador']??'';
        $oficina    =   $_POST['iCodOficina']??'';
        $categoria  =   $cat==''?'null': $cat;
        $estado     =   $_POST['txtestado']??'';
        $perfil     =   $_POST['iCodPerfil']??'null';
        $usuario    =   $_POST['cUsuario']??'';

        $sql = "SP_TRABAJADORES_UPDATE  '".$oficina."',".$categoria.",".$perfil.",'".$nombre."','".$apellido."','".$tipo."','".$num."','".$direccion."','".$mail."','".$tra1."','".$tra2."','".$estado."','".$usuario."','".$_POST['iCodTrabajador']."','".$firma."','".$vb."','".$encargado."'";

        $rs = sqlsrv_query($cnx,$sql);
		sqlsrv_close($cnx);

        header("Location:../views/iu_trabajadores.php");
	}elseif ($RsES_EXTERNO['ES_EXTERNO'] == 1) {
		$sql = "UPDATE Tra_M_Trabajadores 
				SET nFlgEstado='".$_POST['txtestado']??''."',
					cUsuario='".$_POST['cUsuario']??''."' 
				WHERE iCodTrabajador= '".$_POST['iCodTrabajador']??''."'";
		$rs = sqlsrv_query($cnx,$sql);
		sqlsrv_close($cnx);
		header("Location:../views/iu_trabajadores_externos.php?cNombreTrabajador=" . $_POST['cNombreTrabajadorx']??'' . "&cApellidosTrabajador=" . $_POST['cApellidosTrabajadorx']??'' . "&cTipoDocIdentidad=" . $_POST['cTipoDocIdentidadx']??'' . "&cNumDocIdentidad=" . $_POST['cNumDocIdentidadx']??'' . "&iCodOficina=" . $_POST['iCodOficinax']??'' . "&iCodPerfil=" . $_POST['iCodPerfilx']??'' . "&iCodCategoria=" . $_POST['iCodCategoriax']??'' . "&txtestado=" . $_POST['txtestadox']??'' . "&pag=" . $_POST['pagx']??'' . "");
	}
?>