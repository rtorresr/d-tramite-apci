<?php
function validaIngreso($parametro){
	$parametro=trim($parametro);
	
	if(eregi("^[a-zA-Z0-9.@ ]{4,40}$", $parametro)) return TRUE;
	else return FALSE;
}

function validaBusqueda($parametro){
	if(eregi("^[a-zA-Z0-9.@ ]{2,40}$", $parametro)) return TRUE;
	else return FALSE;
}

if(isset($_POST["busqueda"])){
	$valor=$_POST["busqueda"];
	if(validaBusqueda($valor)){
		include_once("../conexion/conexion.php");
		$rsRemit=sqlsrv_query($cnx,"SELECT TOP 22 cNombre FROM Tra_M_Remitente WHERE cNombre LIKE '".$valor."%'");
		sqlsrv_close($cnx);
		
		$cantidad=sqlsrv_has_rows($rsRemit);
		if($cantidad==0){
			echo "0&vacio";
		}else{
			if($cantidad>20) echo "1&"; 
			else echo "0&";
	
			$cantidad=1;
			while(($registro=sqlsrv_fetch_array($rsRemit)) && $cantidad<=20){
				echo "<div onClick=\"clickLista(this);\" onMouseOver=\"mouseDentro(this);\">".$registro[0]."</div>";
				$cantidad++;
			}
		}
	}
}
?>