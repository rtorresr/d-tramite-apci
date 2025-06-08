	<?php
		include_once("../conexion/conexion.php");
		function add_ceros($numero,$ceros) {
	    $order_diez = explode(".",$numero);
	    $dif_diez = $ceros - strlen($order_diez[0]);
	    for($m=0; $m<$dif_diez; $m++){
	    	$insertar_ceros= 0;
	    }
	    return $insertar_ceros.= $numero;
	  }
		// comprobar o recoger correlativo
    $sqlCorr = "SELECT * FROM Tra_M_Correlativo_Oficina   WHERE cCodTipoDoc='".$_POST['cCodTipoDoc']."'   AND iCodOficina='".$_POST['iCodOficina']."'  AND nNumAno='".$_POST['nNumAno']."'";
    $rsCorr  = sqlsrv_query($cnx,$sqlCorr);
    
    if (sqlsrv_has_rows($rsCorr) > 0){
    	$RsCorr       = sqlsrv_fetch_array($rsCorr);
    	$nCorrelativo = $RsCorr['nCorrelativo'] + 1;
    }else{
    	$nCorrelativo = 1;
    }
    
    //leer sigla oficina
    $rsSigla = sqlsrv_query($cnx,"SELECT cSiglaOficina FROM Tra_M_Oficinas WHERE iCodOficina='".$_POST['iCodOficina']."'");
    $RsSigla = sqlsrv_fetch_array($rsSigla);
    
    // armar correlativo
    // ORIGINAL
        $cCodificacion = add_ceros($nCorrelativo,5)."-".date("Y")."/".trim($RsSigla['cSiglaOficina']);

    $result = array();
    $result[]= $cCodificacion;
		echo json_encode($result);
	?>