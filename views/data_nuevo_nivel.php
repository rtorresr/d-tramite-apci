<?php session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
    include_once("../conexion/conexion.php");
    include_once("../conexion/srv-Nginx.php");
    include_once("../core/CURLConection.php");
    require_once('clases/DocDigital.php');
    require_once("clases/Log.php");
    require_once('../vendor/autoload.php');

    $op         =   $_GET['op']??$_POST['op'];
    $id_perfil  =   $_GET['id_perfil']??'';
    $id        =   $_GET['idd']??'';

    // cuando es por url para eliminar
    if($op==2){ 
        $sql    = "DELETE FROM Tra_M_Perfil_Ususario WHERE iCodPerfilUsuario='$id_perfil'";
        $rs     =   sqlsrv_query($cnx,$sql);
    
    // cuando es por el formulario para agregar
    }else{
        $firma='';
        $vb = '';

	    if($_FILES['firma']['size'] != 0 || $_FILES['VistoBueno']['size'] != 0 ) {

            //$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
            $url_srv = $hostUpload.':'.$port.$path;
            $curl = new CURLConnection($url_srv.$fileUpload);

            $url_f = 'firmas/'.$_POST['id'].'/';
            $_POST['path'] = $url_f;
            $_POST['name'] = 'firma';

            $nombreFirma = DocDigital::formatearNombre($_FILES['firma']['name'],true,['/'],'');
            $_POST['new_name'] = $nombreFirma;
            print $curl->uploadFile($_FILES, $_POST);

            $_POST['name'] = 'VistoBueno';

            $nombreVisto = DocDigital::formatearNombre($_FILES['VistoBueno']['name'],true,['/'],'');
            $_POST['new_name'] = $nombreVisto;
            print_r($curl->uploadFile($_FILES, $_POST));

            $curl->closeCurl();

            $firma = $url_srv.$url_f.$nombreFirma;

            $vb = $url_srv.$url_f.$nombreVisto;

        }else{
            $firma = null;
            $vb = null;
        }

        $id = $_POST['id'];
        $oficina = $_POST['oficina'];
        $perfil = $_POST['perfil'];
        $cargo = $_POST['cargo'];
        $delegado = $_POST['delegado']??0;
        $restricciones = json_encode($_POST['restricciones']??[]);
        
        $params = [
            $id,
            $oficina,
            $perfil,
            $cargo,
            $firma,
            $vb,
            $delegado,
            $restricciones,
            $_SESSION['IdSesion']
        ];

        $sql = "{call UP_INSERTAR_PERFIL (?,?,?,?,?,?,?,?,?)}";
        $rs = sqlsrv_query($cnx,$sql,$params);

        // $sql    = "INSERT INTO Tra_M_Perfil_Ususario (iCodPerfil, iCodOficina, iCodTrabajador,iCodCargo,firma,visto,flgDelegacion)VALUES('".$perfil."','".$oficina."','".$id."','".$cargo."','".$firma."','".$vb."',$delegado)";
        // $rs     =   sqlsrv_query($cnx,$sql);
    }
?>
    <meta http-equiv="refresh" content="0;URL='<?php echo "../views/iu_actualiza_trabajadores.php?cod=$id&sw=1";?>'" />
