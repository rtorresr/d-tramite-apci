<?php session_start();
ini_set('date.timezone', 'America/Lima');
ob_start();
//*************************************
include_once("../conexion/conexion.php");    
   	//sqlsrv_query($cnx,"UPDATE Tra_M_Tramite SET descripcion='".str_replace( '\"', '"', $_GET[descripcion])."' WHERE iCodTramite='$_GET[iCodTramite]'");
    
    $tramitePDF=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Tramite WHERE iCodTramite='$_GET[iCodTramite]'");
    $RsTramitePDF=sqlsrv_fetch_object($tramitePDF);

        $rsJefe=sqlsrv_query($cnx,"SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='$RsTramitePDF->iCodTrabajadorRegistro'");
	        $RsJefe=sqlsrv_fetch_array($rsJefe);
	        if (!empty($RsJefe['firma'])) { 
	        	$img=base64_encode($RsJefe['firma']); 
	        	$imgd='<img src="data:image/png;charset=utf8;base64,'.$img.'"/>';
		    }else{
		    	$imgd='';
		    }
	          
	        $sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='$RsTramitePDF->cCodTipoDoc'";
			$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
			$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);

	        $sqlM1="SELECT TOP 1 * FROM Tra_M_Tramite_Movimientos WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 ORDER BY iCodMovimiento ASC";
	        $rsM1=sqlsrv_query($cnx,$sqlM1);

	        if(sqlsrv_has_rows($rsM1)>0){
	            $RsM1=sqlsrv_fetch_object($rsM1);
	            $movFecha=date("d-m-Y h:i:s", strtotime($RsM1->fFecDerivar));
	        }else{
	        	$movFecha='';
	        }

	        $sqlOfDerivar="SELECT * FROM Tra_M_Oficinas WHERE iCodOficina='$RsM1->iCodOficinaDerivar'";
	        $rsOfDerivar=sqlsrv_query($cnx,$sqlOfDerivar);
	        $RsOfDerivar=sqlsrv_fetch_object($rsOfDerivar);

	        //set it to writable location, a place for temp generated PNG files
	        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode\temp'.DIRECTORY_SEPARATOR;

	        //html PNG location prefix
	        $PNG_WEB_DIR = 'phpqrcode/temp/';
            
	        include "phpqrcode/qrlib.php";    
	        
	        //ofcourse we need rights to create temp dir
	        if (!file_exists('c:/STD_DOCUMENTO'))
    			mkdir('c:/STD_DOCUMENTO', 0777, true);

	        if (!file_exists($PNG_TEMP_DIR))
	            mkdir($PNG_TEMP_DIR);
	      
	        //$filename = $PNG_TEMP_DIR.'test.png';

	        $errorCorrectionLevel = 'L';   
	        $matrixPointSize = 2;
	        //$_REQUEST['data']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 

            // Falla < ----------------------------------
	         $_REQUEST['data']=$_SERVER['HTTP_HOST'].'/pro/views/pdf_digital.php?iCodTramite='.$RsTramitePDF->iCodTramite;
            
            //echo $_REQUEST['data'];
	        // user data
	        $codigoQr='test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	        $filename = $PNG_TEMP_DIR.$codigoQr;
            
            //echo $codigoQr;
	         
	        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        $img_logo= "<img style='width:300px' src='images/1.png' alt='Logo'>";
        $img_final="<img src=".$PNG_WEB_DIR.basename($filename)." />";

$query="SELECT TOP 1 *,
(select cNombre from Tra_M_Remitente where iCodRemitente=m.iCodOficinaOrigen) as institucion,
(select cNomRemite from Tra_M_Tramite where iCodTramite=m.iCodTramite) as destinatario,
(select cNomOficina from [dbo].[Tra_M_Oficinas] where iCodOficina=m.iCodOficinaDerivar) as paraOficina,
(select (RTRIM(cNombresTrabajador)+ ', ' +RTRIM(cApellidosTrabajador)) as cNombresTrabajador from [dbo].[Tra_M_Trabajadores] where iCodTrabajador=m.iCodTrabajadorDerivar) as para,
(select cNomOficina from [dbo].[Tra_M_Oficinas] where iCodOficina=m.iCodOficinaOrigen) as deOficina,
(select (RTRIM(cNombresTrabajador)+ ', ' +RTRIM(cApellidosTrabajador)) as cNombresTrabajador from [dbo].[Tra_M_Trabajadores] where iCodTrabajador=m.iCodTrabajadorRegistro) as de
FROM Tra_M_Tramite_Movimientos m
WHERE iCodTramite='$RsTramitePDF->iCodTramite' AND cFlgTipoMovimiento=1 
ORDER BY iCodMovimiento ASC";
$rs = sqlsrv_query($cnx,$query);

while ($x = sqlsrv_fetch_array($rs)){
    $instituto      =   $x['institucion'];
    $destinatario   =   $x['destinatario'];
    $para           =   $x['para'];
    $paraoficina    =   $x['paraOficina'];
    $de             =   $x['de'];
    $deoficina      =   $x['deOficina'];
    $codigoTramite	= 	$x['iCodTramite'];
}

$sqlAprobar = "SELECT iCodJefe, cNomJefe, FECHA_DOCUMENTO FROM Tra_M_Tramite WHERE iCodTramite = ".$codigoTramite;
$rsAprobar  = sqlsrv_query($cnx,$sqlAprobar);
$RsAprobar  = sqlsrv_fetch_object($rsAprobar);
$de         = $RsAprobar->cNomJefe;
$movFecha		= $RsAprobar->FECHA_DOCUMENTO;
/*
    ------------------------------------------------------------------------------
*/
?>
<style>
    body{
        font-family: 'arial',cursive;
    }
    table{
        font-family: 'arial',cursive;
    }
</style>
<?php

$content='


 <div style=" padding-top: 20px; padding-left: 40px; ">'.$img_logo.'</div>
					      <br><br><br>
					      <div style=" text-align: right; ">'.trim($RsTipDoc['cDescTipoDoc']).utf8_decode(" N° ").$RsTramitePDF->cCodificacion.'</div>
					      <br>

					      <table style="width:100%; border: none; font-family:Times;font-size:13.5px;"> <!-- 595px -->
					        <tr>
					          <td style="width:20%">Para:</td><td style="width:80%">: '.$para.'</td>
					        </tr>
					        <tr>
					          <td style="width:20%">Oficina:</td>
					          <td style="width:80%">'.$paraoficina.'</td>
					        </tr>
                            <tr><td colspan=2><br></td></tr>
					        <tr>
					          <td style="width:20%">De:</td><td style="width:80%">: '.$de.'</td>
					        </tr>
					        <tr>
					          <td style="width:20%">Oficina:</td>
					          <td style="width:80%">'.$deoficina.'</td>
					        </tr>
                <tr><td colspan=2><br></td></tr>
					        <tr>
					          <td style="width:20%">Fecha/Aprobacion</td>
					          <td style="width:80%">: '.$movFecha.'</td>
					        </tr>

					        <tr>
					          <td style="width:20%">Asunto</td>
					          <td style="width:80%">: '.$RsTramitePDF->cAsunto.'</td>
					        </tr>
                            <tr><td colspan=2><br></td></tr>
					                      
					      </table>
					      
					      <br><br>
					      <table width=100%><tr><td>
                          ';

        /*
            Maximo de caracteres y no mover es 250
            Solo se puede cambiar la cantidad de numero en el for (20000) a mas
        */
        $num1=1;
        for($xx=0;$xx<=500;$xx++){
            $sql= "select SUBSTRING(descripcion,$num1,250) as descripcion from Tra_M_Tramite where iCodTramite='$_GET[iCodTramite]'";
            $query=sqlsrv_query($cnx,$sql);
            while ($fila = sqlsrv_fetch_array($query)) {
                 $content.=rtrim(ltrim($fila[descripcion]));
            }
            $num1+=250;
            
            if (sqlsrv_has_rows($query)==0) {
                break;
            }
        }
				$content.=' 
									<div align="right" style="width:100%;">
					        	<br><br><br><br><br>
					        	<div style="width: 70%; text-align: center;">'.$imgdx.'<p>Firma</p>
					        		'.$de.'
                    	<br>
                    Con el usuario y clave se da validez al documento emitido.
                    </div>
                    </div>
                   ';
        // $content.=' 
								// 	<div align="right" style="width:100%;">
					   //      	<br><br><br><br><br>
					   //      	<div style="width: 70%; text-align: center;">'.$imgdx.'<p>Firma</p>
					   //      		'.$RsJefe["cNombresTrabajador"].' '.$RsJefe["cApellidosTrabajador"].'
        //             	<br>
        //             Con el usuario y clave se da validez al documento emitido.
        //             </div>
        //             </div>
        //            ';
    		echo $content;
    /*
        ------------------------------------------------------------------------------
    */
	$content = ob_get_clean();  set_time_limit(0);     ini_set('memory_limit', '640M');
?><?php echo $content;?>
         		
