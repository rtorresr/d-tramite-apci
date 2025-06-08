<?php
date_default_timezone_set('America/Lima');
session_start();
if (isset($_SESSION['CODIGO_TRABAJADOR'])){
	include_once("../conexion/conexion.php");
	$fFecActual=date("Ymd")." ".date("H:i:s");
	$rutaUpload="../cAlmacenArchivos/";
	$nNumAno=date("Y");
	
  function add_ceros($numero,$ceros) {
    	$order_diez = explode(".",$numero);
    	$dif_diez = $ceros - strlen($order_diez[0]);
        $insertar_ceros='';
    	for($m=0; $m<$dif_diez; $m++){
            $insertar_ceros.= 0;
    	}
        $insertar_ceros.= $numero;
    	return $insertar_ceros;
  }	
  switch ($_POST['opcion']) {
  case 2: //registrar flujo de documentos tupa
         For ($i=0;$i<count($_POST['iNumOrden']);$i++){
      	        $iNumOrden=$_POST['iNumOrden'];
 				$iCodMovFlujo = $_POST['iCodMovFlujo'];
				$sql = "UPDATE Tra_M_Mov_Flujo SET iNumOrden='".$iNumOrden[$i]."' WHERE iCodMovFlujo='".$iCodMovFlujo[$i]."'";
				$rs = sqlsrv_query($cnx,$sql);
		}
            echo "<html>";
   			echo "<head>";
   			echo "</head>";
   			echo "<body OnLoad='document.form_envio.submit();'>";
   			echo "<form method=POST name=form_envio action=registroWorkFlow.php#area>";
			echo "<input type=hidden name=iCodTupa value='".$_POST['iCodTupa']."''>";
   			echo "<input type=hidden name=cNomTupa value='".$_POST['cNomTupa']."''>";
   			echo "<input type=hidden name=nDias value='".$_POST['nDias']."''>";
   			echo "<input type=hidden name=iCodOficina value='".$_POST['iCodOficina']."'>";
			echo "<input type=hidden name=cod value='".$_POST['cod']."''>";
   			echo "</form>";
   			echo "</body>";
   			echo "</html>";
	break;
  case 3: //añadir movimiento temporal
       $sql="SELECT TOP (1) iCodOficina FROM Tra_M_Mov_Flujo WHERE iCodOficina='".$_POST['iCodOficinaMovFlujo']."' and iCodTupa='".$_POST['iCodTupa']."'  ORDER BY  iCodOficina DESC";
	   $rs=sqlsrv_query($cnx,$sql,array(),array('Scrollable'=>'Buffered'));
	   $numrows=sqlsrv_num_rows($rs);
	   if($numrows==0){
            $sqlTup="SELECT nDias FROM Tra_M_Tupa WHERE iCodTupa='".$_POST['iCodTupa']."' ";
            $rsTup=sqlsrv_query($cnx,$sqlTup);
            $RsTup=sqlsrv_fetch_array($rsTup)  ;
            $sqlDs="SELECT SUM(nPlazo) as Suma from Tra_M_Mov_Flujo WHERE iCodTupa='".$_POST['iCodTupa']."' ";
            $rsDs=sqlsrv_query($cnx,$sqlDs);
            $RsDs=sqlsrv_fetch_array($rsDs);

            if($RsDs['Suma']=="" or $RsDs['Suma']==NULL){
                $tot=$RsTup['nDias'] - $_POST['nPlazoMovFlujo'];
            }else{
                $tot=$RsTup['nDias'] - ($RsDs['Suma']+trim($_POST['nPlazoMovFlujo']));
            }

            if($tot >= 0){
                $sqlAdd="INSERT INTO Tra_M_Mov_Flujo ";
                $sqlAdd.="(iCodTupa, cActividad, iCodOficina, nPlazo , cDesMovFlujo) ";
                $sqlAdd.=" VALUES ";
                $sqlAdd.="('".$_POST['iCodTupa']."','".$_POST['cActividadMovFlujo']."','".$_POST['iCodOficinaMovFlujo']."','".$_POST['nPlazoMovFlujo']."','".$_POST['cDesMovFlujo']."')";
                $rs=sqlsrv_query($cnx,$sqlAdd);
                $mensaje='';
            }else{
                $mensaje=1;
            }
                echo "<html>";
                echo "<head>";
                echo "</head>";
                echo "<body OnLoad='document.form_envio.submit();'>";
                echo "<form method=POST name=form_envio action=registroWorkFlow.php>";
                echo "<input type=hidden name=iCodTupa value='".$_POST['iCodTupa']."'>";
                echo "<input type=hidden name=cNomTupa value='".$_POST['cNomTupa']."'>";

                if($mensaje==1){
                    echo "<input type=hidden name=Error value='".$mensaje."'>";
                }

                echo "<input type=hidden name=nDias value='".$_POST['nDias']."'>";
                echo "<input type=hidden name=iCodOficina value='".$_POST['iCodOficina']."'>";
                echo "<input type=hidden name=cod value='".$_POST['cod']."'>";
                echo "</form>";
                echo "</body>";
                echo "</html>";
	   }
        else if($numrows > 0){
          header("Location: ../views/registroWorkFlow.php?cod=".$_POST['iCodTupa']."&sw=7&alert=1");
        }
	break;
	}

	if($_GET['opcion']??''==6){ //retirar movimientos oficinas
		$sqlX="DELETE FROM Tra_M_Mov_Flujo WHERE iCodMovFlujo='".$_GET['iCod']."'";
		$rsX=sqlsrv_query($cnx,$sqlX);
		header("Location: ../views/registroWorkFlow.php?cod=".$_GET['iCodTupa']."&sw=7");
        sqlsrv_close($cnx);
	}

}else{
    header("Location: ../index-b.php?alter=5");
}


?>