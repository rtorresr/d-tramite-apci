<?php
 session_start();
date_default_timezone_set('America/Lima');
if (isset ($_POST['GRABAR']))
{
	include_once("../conexion/conexion.php");
	$Tipo=$_POST['Tipo'];
	$tipodocumento=$_POST['tipodocumento'];
	$numdocumento=$_POST['numdocumento'];
	$nombres=$_POST['nombres'];
	$apepaterno=$_POST['apepaterno'];
	$telfijo=$_POST['telfijo'];
	$telcelular=$_POST['telcelular'];
	$email=$_POST['email'];
	$asunto=$_POST['asunto'];
	$DescripcionQueja=$_POST['DescripcionQueja'];
	$tiempo = mktime();
    $fechaDeRegistro=date("Y-m-d");

	$nombreCompleto=$_POST["nombres"].' '.$_POST["apepaterno"];

?> 
<?php
	if($Tipo==2){
        $fechaAtencion=strtotime($fechaDeRegistro."+ 30 days");
        $fechaFin = strtotime($fechaDeRegistro."+ 30 days");
        $fechaFinAtencion= date("Ymd",$fechaFin);
        $tipoSolicitudRegistro=24;
	}

	if( $Tipo==5){
        $fechaAtencion=strtotime($fechaDeRegistro."+ 30 days");
        $fechaFin=strtotime($fechaDeRegistro."+ 30 days");
        $fechaFinAtencion=date("Ymd",$fechaFin);
        $tipoSolicitudRegistro=21;
	}
	if($Tipo==1){
        $fechaAtencion=strtotime($fechaDeRegistro."+ 7 days");
        $fechaFin=strtotime($fechaDeRegistro."+ 7 days");
        $fechaFinAtencion=date("Ymd",$fechaFin);
        $tipoSolicitudRegistro=23;
	}
	if( $Tipo==4){
        $fechaAtencion=strtotime($fechaDeRegistro."+ 7 days");
        $fechaFin=strtotime($fechaDeRegistro."+ 7 days");
        $fechaFinAtencion=date("Ymd",$fechaFin);
        $tipoSolicitudRegistro=25;
	}

	if($Tipo==3){
        $fechaAtencion=strtotime($fechaDeRegistro."+ 7 days");
        $fechaFin=strtotime($fechaDeRegistro."+ 7 days");
        $fechaFinAtencion=date("Ymd",$fechaFin);
        $tipoSolicitudRegistro=22;
		//echo "entro a la denuncia";
	}


    $rsauto= sqlsrv_query($cnx,"select dbo.Autogenerado('$Tipo') from dual");
    $num = sqlsrv_fetch_array($rsauto);



    $sqlagregar = "insert into Tra_M_Tramite(
					cCodificacion,
					cCodTipoDoc,
					cAsunto,
					cObservaciones,
					nFlgEnvio,
					nFlgEstado,
					nFlgTipoDoc,
					cNomRemite,
					fFecRegistro,
					FechaPlazoFinal) 

					values(
					'$num[0]',
					'$tipoSolicitudRegistro',
					'$asunto',
					'$DescripcionQueja	',
					'1',
					'1',
					'1',
					'$nombreCompleto',
					'$fechaDeRegistro',
					'$fechaFinAtencion')";
    //$idTramite = mysql_insert_id();
    $rs = sqlsrv_query($cnx,$sqlagregar);
    $rsT = sqlsrv_query($cnx,"SELECT @@identity AS id");
    if ($row = sqlsrv_fetch_array($rsT)) {
        $idTramite = trim($row[0]);
    }
    $sqlMovimientos="insert into Tra_M_Tramite_Movimientos(
						iCodTramite,
						iCodTrabajadorRegistro,
						iCodOficinaOrigen,
						iCodOficinaDerivar,
						iCodTrabajadorDerivar,
						nEstadoMovimiento,
					    nFlgEnvio,
					    nFlgTipoDoc,
					    cFlgTipoMovimiento) 

					 	values(
					 	'$idTramite',
					 	'151',
					 	'364',
					 	'363',
					 	'151',
					 	'1',
					 	'0',
					 	'1',
					 	'1')";

    $rsMov=sqlsrv_query($cnx,$sqlMovimientos);

    $sqlRegistro="insert into Tra_M_DatosReclamoDenunciaSugerencia(
						iCodTramite,
						tipoRegistro,
						telefonoFijo,
						celular,
						correo,
						numeroDocumento)
						values(
						'$idTramite',
						'$Tipo',
						'$telfijo',
						'$telcelular',
						'$email',
						'$numdocumento'
						)
					";

    $rsDatos=sqlsrv_query($cnx,$sqlRegistro);

    $descripcion="Estimado Usuario: Estamos revissando su consulta, el codigo del registro es el siguiente ".$num[0];
?>
    <!-- JQuery -->
    <script type="text/javascript" src="js_select/jquery-3.3.1.min.js"></script>
    <script>


        $.get('http://192.168.1.88:8000/sendmail',{'subject':"Registro en APCI",'email':'<?= $email;?>','message':"<?= $descripcion;?>"}).done(function (data) {
            document.location.href="http://192.168.1.135:8096/prueba/ProyectoRSD/Formulario_Quejas_Sugerencias.php";
            //console.log("server: ");
            //console.log(data);
        });
    </script>
<?php
    /*inicio del servicio para el correo*/
    exit();
    /*fin dle servicio para el correo*/

    if($Tipo==5 || $Tipo==2) {
        echo "<html>";
        echo "<head>";
        echo "</head>";
        echo "<body OnLoad=\"document.form_envio.submit();\">";
        echo "<form method=POST name=form_envio action=http://192.168.1.135:8096/prueba/ProyectoRSD/Formulario_Quejas_Sugerencias.php>";
        echo "</form>";
        echo "</body>";
        echo "</html>";
        //break;
    }
    if($Tipo==1 || $Tipo==4){
        echo "<html>";
        echo "<head>";
        echo "</head>";
        echo "<body OnLoad=\"document.form_envio.submit();\">";
        echo "<form method=POST name=form_envio action=http://192.168.1.135:8096/prueba/ProyectoRSD/Formulario_Consulta_Sugerencias2.php>";
        echo "</form>";
        echo "</body>";
        echo "</html>";
        //break;
    }
    if($Tipo==3){
        echo "<html>";
        echo "<head>";
        echo "</head>";
        echo "<body OnLoad=\"document.form_envio.submit();\">";
        echo "<form method=POST name=form_envio action=http://192.168.1.135:8096/prueba/ProyectoRSD/Formulario_Denuncias.php>";
        echo "</form>";
        echo "</body>";
        echo "</html>";
       //break;
    }






?>

<?php
}
?>