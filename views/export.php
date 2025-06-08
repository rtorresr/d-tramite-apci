<?php if($_GET[tabla]==""){?>
		<form action="export.php" method="GET" name="form">
		Nombre Tabla: <input type="text" name="tabla" size="">
		<input type="submit" name="mostrar" value="mostrar"> 
		</form>
<?php } else{
	require_once("../conexion/conexion.php");
	$sqlC= "SELECT COUNT(*) AS numero FROM information_schema.columns WHERE table_name='$_GET[tabla]'";
	$rsC=sqlsrv_query($cnx,$sqlC);
	$RsC=sqlsrv_fetch_array($rsC);
	//echo $RsC[numero]."<hr>";
	
	$sqlN="SELECT * FROM information_schema.columns WHERE table_name='$_GET[tabla]'";
	$rsN=sqlsrv_query($cnx,$sqlN);
	$numeracion=1;
	while ($row=sqlsrv_fetch_array($rsN)) {
      if($numeracion>1){
        $columnas.=$row[3];
        if($numeracion<$RsC[numero]){
					$columnas.=", ";
				}
			}
			$numeracion++;
  }

	//echo $columnas."<hr>";
	
	
	$sql= "SELECT * FROM $_GET[tabla]";
	$rs=sqlsrv_query($cnx,$sql);
	while ($Rs=sqlsrv_fetch_array($rs)){
			$numeracion=2;
			echo "INSERT INTO BD_SITD.dbo.".$_GET[tabla]." (".$columnas.") VALUES (";
			for($i=1;$i<$RsC[numero];$i++){
				echo "&#39;".trim($Rs[$i])."&#39";
				if($numeracion<$RsC[numero]){
					echo ", ";
				}
				$numeracion++;
			}
			echo ")";
			echo ";<br>";
	}
}
?>