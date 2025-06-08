<?php
  for ($h=0; $h < count($_POST['iCodAuto']); $h++) {
    $iCodAuto   = $_POST['iCodAuto'];
    $fRespuesta = date("Ymd", strtotime($_REQUEST['fRespuesta']));
    $sql        = "UPDATE Tra_M_Doc_Salidas_Multiples 
                   SET cFlgEstado = '$_POST[cFlgEstado]'
                      ,fRespuesta = '$fRespuesta'
                      , cObservaciones='$_POST[cObservaciones]'
                      ,cRecibido = '$_POST[cRecibido]'
                      ,cNumGuia = '$_POST[cNumGuia]' 
                  WHERE iCodAuto = '$iCodAuto[$h]'";
    $rs = sqlsrv_query($cnx,$sql);

    $sqlCodificacion = "SELECT cCodificacion FROM Tra_M_Tramite WHERE iCodTramite = ".$_POST['codigoTramite'];
    $rsCodificacion  = sqlsrv_query($cnx,$sqlCodificacion);
    $RsCodificacion  = sqlsrv_fetch_array($rsCodificacion);
    $cCodificacion   = $RsCodificacion['cCodificacion'];

    $rutaUpload    = "../cAlmacenArchivos/";

    if ($_FILES['fileUpLoadDigital']['name'] != ""){
      $cNombreOriginal = $_FILES['fileUpLoadDigital']['name'];
      $extension = explode(".",$_FILES['fileUpLoadDigital']['name']);
      $num = count($extension)-1;
      $nombre = count($extension)-2;
      $nombre_en_bruto = $extension[$nombre];
      $nombre_original = ereg_replace(" ", "_", $nombre_en_bruto);
      $nuevo_nombre = "Cargo-".$_POST['codigoTramite'].".".$extension[$num];
      move_uploaded_file($_FILES['fileUpLoadDigital']['tmp_name'], "$rutaUpload$nuevo_nombre");
      
      // $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales (iCodTramite, cNombreOriginal, cNombreNuevo) 
      //             VALUES ('$_POST[codigoTramite]','$cNombreOriginal','$nuevo_nombre')";
      $sqlDigt = "INSERT INTO Tra_M_Tramite_Digitales_Mensajeria (iCodTramite, cNombreOriginal, cNombreNuevo, iCodAuto) 
                  VALUES ('$_POST[codigoTramite]','$cNombreOriginal','$nuevo_nombre','$iCodAuto[$h]')";
      $rsDigt  = sqlsrv_query($cnx,$sqlDigt);
    }
  }

  

  sqlsrv_close($cnx);
  header("Location: ../views/consultaTramiteCargo.php");
?>

