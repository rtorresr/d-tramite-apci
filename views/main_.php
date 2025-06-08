<?
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?><style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
-->
</style></head>
<body>

	<?php include("includes/menu.php");?>


<!--Main layout-->
 <main class="mx-lg-5">
     <div class="container-fluid">
          <!--Grid row-->
         <div class="row wow fadeIn">
              <!--Grid column-->
             <div class="col-md-12 mb-12">
                  <!--Card-->
                 <div class="card">
                      <!-- Card header -->
                     <div class="card-header text-center ">
                         >>
                     </div>
                      <!--Card content-->
                     <div class="card-body">

<div class="AreaTitulo">Bienvenido al Sistema</div>
<table class="table">
<tr>
<td class="FondoFormRegistro">
	<br>
	<table border="0" cellpadding="0" cellspacing="0" width="1000" align="center">
	<tr>
	<td valign="top" width="400">

		<font style="font-family:verdana;font-size:16px;color:#8A8A00"><b>
		<?
		include_once("../conexion/conexion.php");
		$sqlUsr="SELECT * FROM Tra_M_Trabajadores WHERE iCodTrabajador='".$_SESSION['CODIGO_TRABAJADOR']."'";
		$rsUsr=sqlsrv_query($cnx,$sqlUsr);
		$RsUsr=sqlsrv_fetch_array($rsUsr);
		$tiempo = date ("G");
		if ($tiempo < 12) echo "BUENOS DIAS!";
		else if ($tiempo < 18) echo "BUENAS TARDES!";
			else echo "BUENAS NOCHES!";
		?>
		</b><br>
		</font>
		<span class="size10"><?=$RsUsr[cNombresTrabajador]?> <?=$RsUsr[cApellidosTrabajador]?> </span>
		<br><br>
		
		<table border="0" cellpadding="0" cellspacing="0">
		<tr><td height="35" valign="top" align="right"><font color="#7B6902" class="size10">Oficina:&nbsp;</td>
				<td class="size10" valign="top" align="left">
				<b>
				<?
				$sqlDep="SELECT * FROM Tra_M_Oficinas ";
        $sqlDep.="WHERE iCodOficina='$RsUsr['iCodOficina']'";
        $rsDep=sqlsrv_query($cnx,$sqlDep);
        $RsDep=sqlsrv_fetch_array($rsDep);
        echo $RsDep[cNomOficina];
				?>
				</b>
				</td>
		</tr>
		<tr><td height="35" valign="top" align="right"><font color="#7B6902" class="size10">Usuario:&nbsp;</td><td class="size10" valign="top" align="left"><b><?=$RsUsr[cUsuario]?></b></td></tr>
		<tr>
				<td height="35" valign="top" align="right"><font color="#7B6902" class="size10">Perfil:&nbsp;</td><td class="size10" valign="top" align="left"><b>
				<?
				$sqlPerf="SELECT * FROM Tra_M_Perfil WHERE iCodPerfil='$_SESSION[iCodPerfilLogin]'"; 
				$rsPerf=sqlsrv_query($cnx,$sqlPerf);
				$RsPerf=sqlsrv_fetch_array($rsPerf);
				echo $RsPerf[cDescPerfil];
				?></b>
				</td>
		</tr>
		<tr><td height="35" valign="top" align="right"><font color="#7B6902" class="size10">�ltimo Acceso:&nbsp;</td><td class="size10" valign="top" align="left"><b><?	
		if(trim($_SESSION['fUltimoAcceso']!="")){ echo date("d-m-Y G:i:s", strtotime($_SESSION['fUltimoAcceso']));}
		else{ echo "";}?></b></td></tr>
		</table>
	</td>
	<td width="250" bgcolor="#ffffff" valign="top">
	</td>
	<td width="400" bgcolor="#ffffff" valign="top">
    <?php if($_SESSION['iCodPerfilLogin']==2){ ?>
			<table>
			<tr>
			<td class="FondoFormBordes" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td height="22" align="center" class="headColumnas"  ><b>SUMARIO</b></td></tr>
					<tr><td align="left">
						<?
						
						/////////////////////
						
			$sqlTra= " SP_BANDEJA_REPORTE_TRAMITE  '$fDesde','$fHasta','".$_GET['Entrada']."','".$_GET['Interno']."','$_GET['Anexo']','%".$_GET['cCodificacion']."%', ";
			$sqlTra.= "'%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','$_GET['iCodTrabajadorDelegado']','".$_GET['iCodTema']."','$_GET['EstadoMov']','$_GET['Aceptado']','$_GET['SAceptado']','".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
        $rsTra=sqlsrv_query($cnx,$sqlTra);
		
        $totalpendientes = sqlsrv_has_rows($rsTra);
		
		///////////////////////////////////////////
		
		
		////////////////////

    			  $sqlPnd=" SELECT * FROM Tra_M_Tramite ";
    			  $sqlPnd.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlPnd.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 ";
    			  $rsPnd=sqlsrv_query($cnx,$sqlPnd);
    			
    			  //en proceso c/Tupa
				  
				  
				  
    			  $sqlCTupa="SELECT * FROM Tra_M_Tramite ";
    			  $sqlCTupa.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlCTupa.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.nFlgClaseDoc=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 AND nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion is null";
    			  $rsCTupa=sqlsrv_query($cnx,$sqlCTupa);
    			  
    			  //en proceso s/Tupa
				  
				  $sqlSTupa="SELECT  
			cDescTipoDoc,		fFecDerivar,		Tra_M_Tramite.iCodTramite as Tramite, * 
	FROM	
			Tra_M_Tramite 
			LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ,
			Tra_M_Tramite_Movimientos 
    WHERE 
			Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite  And (Tra_M_Tramite.nFlgTipoDoc=1)
			
			
			And Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."'
		   						   And Tra_M_Tramite.nFlgEnvio=1  
		   						   And nEstadoMovimiento!=2  
								   And (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=4)
								   And (Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6) AND Tra_M_Tramite_Movimientos.fFecRecepcion is null ";
				  		
    			  
    			  $rsSTupa=sqlsrv_query($cnx,$sqlSTupa);
    			  
    			  //en proceso Interno
				  
				  ///////////////////////
				  
				  	$sqlINTE= " SP_BANDEJA_REPORTE_TRAMITE  '$fDesde','$fHasta','".$_GET['Entrada']."','1','$_GET['Anexo']','%".$_GET['cCodificacion']."%','%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','$_GET['iCodTrabajadorDelegado']','".$_GET['iCodTema']."','$_GET['EstadoMov']','$_GET['Aceptado']','1','".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
        $rsI=sqlsrv_query($cnx,$sqlINTE);
		
		   $numinternos = sqlsrv_has_rows($rsI);
				  
				  ///////////////////////
    			/* $sqlInt="SELECT * FROM Tra_M_Tramite ";
    			  $sqlInt.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlInt.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 AND Tra_M_Tramite.nFlgTipoDoc=2 AND nEstadoMovimiento=1";
    			  $rsInt=sqlsrv_query($cnx,$sqlInt);*/
				  
				  
				  
				  
				   ///////////////////////
				  
				  	  $sqlSAL="SELECT * FROM Tra_M_Tramite ";
    			  $sqlSAL.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlSAL.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=3 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 And (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1  OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=4) AND Tra_M_Tramite_Movimientos.fFecRecepcion is null ";
				  
				  
        $rsS=sqlsrv_query($cnx,$sqlSAL);
		
		   $numSalidas= sqlsrv_has_rows($rsS);
				  
				  ///////////////////////
    			  
    			  function obtend_dias_trasnc($ano1,$mes1,$dia1,$ano2,$mes2,$dia2){
								$Date1=mktime(0,0,0,$mes1,$dia1,$ano1); 
								$Date2=mktime(4,12,0,$mes2,$dia2,$ano2); 
								$segundos_diferencia = $Date2-$Date1; 
								$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
								$dias_diferencia = abs($dias_diferencia); 
								$dias_diferencia = floor($dias_diferencia); 
								return ($dias_diferencia);
						}
    			  
    			  //en proceso c/Tupa
    			  
    			  $sqlVCTupa="SELECT * FROM Tra_M_Tramite ";
    			  $sqlVCTupa.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlVCTupa.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.nFlgClaseDoc=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 AND nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion is not null";
    			  $rsVCTupa=sqlsrv_query($cnx,$sqlVCTupa);
    			  
    			  
    			  //en proceso Vencido s/Tupa
    			
    			  $sqlVSTupa="SELECT  
			cDescTipoDoc,		fFecDerivar,		Tra_M_Tramite.iCodTramite as Tramite, * 
	FROM	
			Tra_M_Tramite 
			LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ,
			Tra_M_Tramite_Movimientos 
    WHERE 
			Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite  And (Tra_M_Tramite.nFlgTipoDoc=1)
			
			
			And Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."'
		    And Tra_M_Tramite.nFlgEnvio=1  
		   	And nEstadoMovimiento!=2  
								   And (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=4)
								   And (Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6) AND Tra_M_Tramite_Movimientos.fFecRecepcion is not null ";
    			  $rsVSTupa=sqlsrv_query($cnx,$sqlVSTupa);
 
    			  
    			  //en proceso Vencido Internos
    			 
    			  $sqlVeInt=" SP_BANDEJA_REPORTE_TRAMITE  '$fDesde','$fHasta','".$_GET['Entrada']."','1','$_GET['Anexo']','%".$_GET['cCodificacion']."%','%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','$_GET['iCodTrabajadorDelegado']','".$_GET['iCodTema']."','$_GET['EstadoMov']','$_GET['SAceptado']','1','".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
    			  $rsVeInt=sqlsrv_query($cnx,$sqlVeInt);
    
	
	 $sqlSALv="SELECT * FROM Tra_M_Tramite ";
    			  $sqlSALv.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlSALv.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=3 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 AND nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion is not null ";
				  
				  
        $rsSv=sqlsrv_query($cnx,$sqlSALv);
	
						?>
						
						<div style="padding-left:3px;padding-right:3px;">A la fecha la oficina<em> <b>
						  <?
				$sqlDep="SELECT * FROM Tra_M_Oficinas ";
        $sqlDep.="WHERE iCodOficina='$RsUsr['iCodOficina']'";
        $rsDep=sqlsrv_query($cnx,$sqlDep);
        $RsDep=sqlsrv_fetch_array($rsDep);
        echo $RsDep[cNomOficina];
				?>
						</b></em>mantiene <span style="color:#ff0000"><b><?=$totalpendientes?></b></span> documento<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> en su Bandeja de Pendiente<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?>.</div>
                        <? /*<div style="padding-left:3px;padding-right:3px;">A la fecha <i><?=trim($RsUsr[cNombresTrabajador])?>, <?=trim($RsUsr[cApellidosTrabajador])?></i> mantiene <span style="color:#ff0000"><b><?=sqlsrv_has_rows($rsPnd);?></b></span> documento<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> Pendiente<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> de Tr�mite.</div>*/ ?>
                        
					</td></tr>
					<tr>
						<td>
								<table border="1" cellpadding="2" cellspacing="2" width="100%">
								<tr>
								<td bgcolor="#AA5500"  > Tipo Documento</td>
								<td bgcolor="#844200"  > Pendientes</td>
								<td bgcolor="#844200"  ><div align="center">En Proceso</div></td>
								<td bgcolor="#4682B4"  ><div align="center"><span class="Estilo2">TOTAL</span></div></td>
								</tr>
								<tr>
								<td>Entradas con Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsCTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVCTupa);?></td>
								<td align="center" style="color:#0154AF"><?=(sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsVCTupa))?></td>
								</tr>
								<tr>
								<td>Entradas sin Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsSTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVSTupa);?></td>
								<td align="center" style="color:#0154AF"><?=(sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsVSTupa))?></td>
								</tr>
								<tr>
                                  <td>Internos</td>
								  <td align="center"><?=$numinternos;?></td>
								  <td align="center"><?=sqlsrv_has_rows($rsVeInt);?></td>
								  <td align="center" style="color:#0154AF"><?=($numinternos+sqlsrv_has_rows($rsVeInt))?></td>
								</tr>
								<tr>
								<td bgcolor="#4682B4"><span class="Estilo2"><strong>TOTAL</strong></span></td>
								<td align="center"><b><?=(sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsI))?></b></td>
								<td align="center"><b><?=(sqlsrv_has_rows($rsVCTupa)+sqlsrv_has_rows($rsVSTupa)+sqlsrv_has_rows($rsVeInt))?></b></td>
								<td align="center" bgcolor="#FFFFFF"><b><?=$totalpendientes?></b></td>
								</tr>
								</table>
						</td>
					</tr>
					</table>
             <? 
	}        ?> 			
       <? 
	 if( $_SESSION['iCodPerfilLogin']==4){
	   ?>     
        <table>
			<tr>
			<td class="FondoFormBordes" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td height="22" align="center" class="headColumnas"  ><b>SUMARIO</b></td></tr>
					<tr><td align="left">
						<?
						
						//////////////////////////
						
						
								$sqlPndPro="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And Tra_M_Tramite.nFlgEnvio=1 AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) OR Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6))  ";
				
        $rsPndPro=sqlsrv_query($cnx,$sqlPndPro);
		
        $totalpendientespro = sqlsrv_has_rows($rsPndPro);
						
						//////////////////////////
						
						
						
				$sqlSTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And Tra_M_Tramite.nFlgEnvio=1 AND 
				((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR
				Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) OR
				Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') AND 
				(Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR 
				Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR
				(Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6 )) AND
				Tra_M_Tramite.nFlgClaseDoc=2 and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is null";
						
						
						/////////////////////////////////
						
    			  $sqlPnd="SELECT * FROM Tra_M_Tramite ";
    			  $sqlPnd.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlPnd.="WHERE Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion=NULL AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 ";
    			  $rsPnd=sqlsrv_query($cnx,$sqlPnd);
    			
    			  //en proceso c/Tupa
    			  $sqlCTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM 
      [dbo].[Tra_M_Tramite],[dbo].[Tra_M_Tramite_Movimientos] WHERE 
       Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite
	   And Tra_M_Tramite.nFlgEnvio=1 
       AND Tra_M_Tramite.nFlgTipoDoc=1 
       and Tra_M_Tramite.nFlgClaseDoc=1 
       and Tra_M_Tramite_Movimientos.fFecDelegado is null
       AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND
       ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado=

'".$_SESSION['CODIGO_TRABAJADOR']."' OR
        Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar=

'".$_SESSION['CODIGO_TRABAJADOR']."'))  OR 
        Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar=

'".$_SESSION['CODIGO_TRABAJADOR']."') AND 
        (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR
         Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR 
         (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND 
         Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsCTupa=sqlsrv_query($cnx,$sqlCTupa);
				  
				  
				  //////con TUPA NUEVO----
				/*  
				  
				  otepa
				  
				  //////
    			  
    			  //en proceso s/Tupa
    			  /*$sqlSTupa="SELECT * FROM Tra_M_Tramite ";
    			  $sqlSTupa.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlSTupa.="WHERE Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion IS NOT NULL AND (Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 ) AND Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.nFlgClaseDoc=2 AND Tra_M_Tramite.nFlgEstado=2";*/
    			  $rsSTupa=sqlsrv_query($cnx,$sqlSTupa);
    			  
    			  //en proceso Interno
    			  $sqlInt="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite And Tra_M_Tramite.nFlgEnvio=1 and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is null AND  Tra_M_Tramite.nFlgTipoDoc=2 AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) OR Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsInt=sqlsrv_query($cnx,$sqlInt);
    			  

    			  
    			  //en proceso Vencido c/Tupa
    			 
    			  $sqlVCTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM 
       [dbo].[Tra_M_Tramite],[dbo].[Tra_M_Tramite_Movimientos] WHERE 
       Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite 
       AND Tra_M_Tramite.nFlgTipoDoc=1 
       and Tra_M_Tramite.nFlgClaseDoc=1 
       and Tra_M_Tramite_Movimientos.fFecDelegado is not null
       AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND
       ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado=

'".$_SESSION['CODIGO_TRABAJADOR']."' OR
        Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar=

'".$_SESSION['CODIGO_TRABAJADOR']."'))  OR 
        Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar=

'".$_SESSION['CODIGO_TRABAJADOR']."') AND 
        (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR
         Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR 
         (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND 
         Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsVCTupa=sqlsrv_query($cnx,$sqlVCTupa);
    			  
    			  
    			  //en proceso Vencido s/Tupa
    			 
    			  $sqlVSTupa="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite AND 
				((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR
				Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) OR
				Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') AND 
				(Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR 
				Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR
				(Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6 )) AND
				Tra_M_Tramite.nFlgClaseDoc=2 and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is not null";
    			  $rsVSTupa=sqlsrv_query($cnx,$sqlVSTupa);

    			  
    			  //en proceso Vencido Internos
    			 
    			  $sqlVeInt="SELECT Tra_M_Tramite.iCodTramite as Tramite, * FROM Tra_M_Tramite,Tra_M_Tramite_Movimientos WHERE Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite and Tra_M_Tramite_Movimientos.fFecDelegadoRecepcion is not null AND  Tra_M_Tramite.nFlgTipoDoc=2 AND ((Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND ( Tra_M_Tramite_Movimientos.iCodTrabajadorDelegado='".$_SESSION['CODIGO_TRABAJADOR']."' OR Tra_M_Tramite_Movimientos.iCodTrabajadorDerivar='".$_SESSION['CODIGO_TRABAJADOR']."')) OR Tra_M_Tramite_Movimientos.iCodTrabajadorEnviar='".$_SESSION['CODIGO_TRABAJADOR']."') AND (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento=6)) ";
    			  $rsVeInt=sqlsrv_query($cnx,$sqlVeInt);
						?>
						
						<div style="padding-left:3px;padding-right:3px;">A la fecha <i><?=trim($RsUsr[cNombresTrabajador])?>, <?=trim($RsUsr[cApellidosTrabajador])?></i> mantiene <span style="color:#ff0000"><b><?=$totalpendientespro;?></b></span> documento<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> en su Bandeja de Pendiente<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?>.</div>
					</td></tr>
					<tr>
						<td>
								<table border="1" cellpadding="2" cellspacing="2" width="100%">
								<tr>
								<td bgcolor="#AA5500"  > Tipo Documento</td>
								<td bgcolor="#844200"  > Pendientes</td>
								<td bgcolor="#844200"  ><div align="center">En Proceso</div></td>
								<td bgcolor="#4682B4"  ><div align="center"><span class="Estilo2">TOTAL</span></div></td>
								</tr>
								<tr>
								<td>Entradas con Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsCTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVCTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsVCTupa);?></td>
								</tr>
								<tr>
								<td>Entradas sin Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsSTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVSTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsVSTupa);?></td>
								</tr>
								<tr>
								<td>Internos</td>
								<td align="center"><?=sqlsrv_has_rows($rsInt);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVeInt);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsInt)+sqlsrv_has_rows($rsVeInt);?></td>
								</tr>
								<tr>
								<td bgcolor="#4682B4"><span class="Estilo2"><strong>TOTAL</strong></span></td>
								<td align="center"><strong>
								  <?=(sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsInt))?>
								</strong></td>
								<td align="center"><strong>
								  <?=(sqlsrv_has_rows($rsVCTupa)+sqlsrv_has_rows($rsVSTupa)+sqlsrv_has_rows($rsVeInt))?>
								</strong></td>
								<td align="center"><b><?=$totalpendientespro;?></b></td>
								</tr>
								</table>
						</td>
					</tr>
					</table>
              <?php } ?>
     <?  if($_SESSION['iCodPerfilLogin']!=4 && $_SESSION['iCodPerfilLogin']!=2 ){ ?>
			<table>
			<tr>
			<td class="FondoFormBordes" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td height="22" align="center" class="headColumnas"  ><b>SUMARIO</b></td></tr>
					<tr><td align="left">
						<?
						
						/////////////////////
						
			$sqlTra= " SP_BANDEJA_PENDIENTES  '$fDesde','$fHasta','".$_GET['Entrada']."','".$_GET['Interno']."','$_GET['Anexo']','%".$_GET['cCodificacion']."%', ";
			$sqlTra.= "'%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','$_GET['iCodTrabajadorResponsable']','$_GET['iCodTrabajadorDelegado']','".$_GET['iCodTema']."','$_GET['EstadoMov']','$_GET['Aceptado']','$_GET['SAceptado']','".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
        $rsTra=sqlsrv_query($cnx,$sqlTra);
		//echo $sqlTra;
        $totalpendientes = sqlsrv_has_rows($rsTra);
		
		///////////////////////////////////////////
		
		
		////////////////////

    			  $sqlPnd=" SELECT * FROM Tra_M_Tramite ";
    			  $sqlPnd.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlPnd.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 ";
    			  $rsPnd=sqlsrv_query($cnx,$sqlPnd);
    			
    			  //en proceso c/Tupa
				  
				  
				  
    			  $sqlCTupa="SELECT * FROM Tra_M_Tramite ";
    			  $sqlCTupa.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlCTupa.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.nFlgClaseDoc=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 AND nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion is null";
    			  $rsCTupa=sqlsrv_query($cnx,$sqlCTupa);
    			  
    			  //en proceso s/Tupa
				  
				  $sqlSTupa="SELECT  
			cDescTipoDoc,		fFecDerivar,		Tra_M_Tramite.iCodTramite as Tramite, * 
	FROM	
			Tra_M_Tramite 
			LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ,
			Tra_M_Tramite_Movimientos 
    WHERE 
			Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite  And (Tra_M_Tramite.nFlgTipoDoc=1)
			
			
			And Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."'
		   						   And Tra_M_Tramite.nFlgEnvio=1  
		   						   And nEstadoMovimiento!=2  
								   And (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=4)
								   And (Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6) AND Tra_M_Tramite_Movimientos.fFecRecepcion is null ";
				  		
    			  
    			  $rsSTupa=sqlsrv_query($cnx,$sqlSTupa);
    			  
    			  //en proceso Interno
				  
				  ///////////////////////
				  
				  	$sqlINTE= " SP_BANDEJA_PENDIENTES  '$fDesde','$fHasta','".$_GET['Entrada']."','1','$_GET['Anexo']','%".$_GET['cCodificacion']."%','%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','$_GET['iCodTrabajadorResponsable']','$_GET['iCodTrabajadorDelegado']','".$_GET['iCodTema']."','$_GET['EstadoMov']','$_GET['Aceptado']','1','".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
        $rsI=sqlsrv_query($cnx,$sqlINTE);
		//echo $sqlINTE;
		   $numinternos = sqlsrv_has_rows($rsI);
				  
				  ///////////////////////
    			/* $sqlInt="SELECT * FROM Tra_M_Tramite ";
    			  $sqlInt.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlInt.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 AND Tra_M_Tramite.nFlgTipoDoc=2 AND nEstadoMovimiento=1";
    			  $rsInt=sqlsrv_query($cnx,$sqlInt);*/
				  
				  
				  
				  
				   ///////////////////////
				  
				  	  $sqlSAL="SELECT * FROM Tra_M_Tramite ";
    			  $sqlSAL.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlSAL.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=3 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 AND nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion is null ";
				  
				  
        $rsS=sqlsrv_query($cnx,$sqlSAL);
		
		   $numSalidas= sqlsrv_has_rows($rsS);
				  
				  ///////////////////////
    			     			  
    			  //en proceso c/Tupa
    			  
    			  $sqlVCTupa="SELECT * FROM Tra_M_Tramite ";
    			  $sqlVCTupa.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlVCTupa.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=1 AND Tra_M_Tramite.nFlgClaseDoc=1 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 AND nEstadoMovimiento=1 AND Tra_M_Tramite_Movimientos.fFecRecepcion is not null";
    			  $rsVCTupa=sqlsrv_query($cnx,$sqlVCTupa);
    			  
    			  
    			  //en proceso Vencido s/Tupa
    			
    			  $sqlVSTupa="SELECT  
			cDescTipoDoc,		fFecDerivar,		Tra_M_Tramite.iCodTramite as Tramite, * 
	FROM	
			Tra_M_Tramite 
			LEFT OUTER JOIN Tra_M_Tipo_Documento ON Tra_M_Tramite.cCodTipoDoc=Tra_M_Tipo_Documento.cCodTipoDoc ,
			Tra_M_Tramite_Movimientos 
    WHERE 
			Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite  And (Tra_M_Tramite.nFlgTipoDoc=1)
			
			
			And Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."'
		    And Tra_M_Tramite.nFlgEnvio=1  
		   	And nEstadoMovimiento!=2  
			And (iCodTupa is NULL or iCodTupa = '')  
								   And (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 
								   OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=4)
								   And (Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6) AND Tra_M_Tramite_Movimientos.fFecRecepcion is not null ";
    			  $rsVSTupa=sqlsrv_query($cnx,$sqlVSTupa);
 
    			  
    			  //en proceso Vencido Internos
    			 
    			  $sqlVeInt=" SP_BANDEJA_PENDIENTES  '$fDesde','$fHasta','".$_GET['Entrada']."','1','$_GET['Anexo']','%".$_GET['cCodificacion']."%','%".$_GET['cAsunto']."%','".$_GET['cCodTipoDoc']."','$_GET['iCodTrabajadorResponsable']','$_GET['iCodTrabajadorDelegado']','".$_GET['iCodTema']."','$_GET['EstadoMov']','1','$_GET['SAceptado']','".$_SESSION['iCodOficinaLogin']."','$campo','$orden' ";
    			  $rsVeInt=sqlsrv_query($cnx,$sqlVeInt);
    
	
	 $sqlSALv="SELECT * FROM Tra_M_Tramite ";
    			  $sqlSALv.="LEFT OUTER JOIN Tra_M_Tramite_Movimientos ON Tra_M_Tramite.iCodTramite=Tra_M_Tramite_Movimientos.iCodTramite ";
    			  $sqlSALv.="WHERE Tra_M_Tramite_Movimientos.iCodOficinaDerivar='".$_SESSION['iCodOficinaLogin']."' AND Tra_M_Tramite.nFlgEnvio=1 AND Tra_M_Tramite.nFlgTipoDoc=3 AND Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=5 and Tra_M_Tramite_Movimientos.cFlgTipoMovimiento!=6 And (Tra_M_Tramite_Movimientos.nEstadoMovimiento=1  OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=3 OR Tra_M_Tramite_Movimientos.nEstadoMovimiento=4) AND Tra_M_Tramite_Movimientos.fFecRecepcion is not null ";
				  
				  
        $rsSv=sqlsrv_query($cnx,$sqlSALv);
	
						?>
						
						<div style="padding-left:3px;padding-right:3px;">A la fecha la oficina<em> <b>
						  <?
				$sqlDep="SELECT * FROM Tra_M_Oficinas ";
        $sqlDep.="WHERE iCodOficina='$RsUsr['iCodOficina']'";
        $rsDep=sqlsrv_query($cnx,$sqlDep);
        $RsDep=sqlsrv_fetch_array($rsDep);
        echo $RsDep[cNomOficina];
				?>
						</b></em>mantiene <span style="color:#ff0000"><b><?=$totalpendientes?></b></span> documento<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> en su Bandeja de Pendiente<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?>.</div>
                        <? /*<div style="padding-left:3px;padding-right:3px;">A la fecha <i><?=trim($RsUsr[cNombresTrabajador])?>, <?=trim($RsUsr[cApellidosTrabajador])?></i> mantiene <span style="color:#ff0000"><b><?=sqlsrv_has_rows($rsPnd);?></b></span> documento<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> Pendiente<?php if(sqlsrv_has_rows($rsPnd)!=1) echo "s"?> de Tr�mite.</div>*/ ?>
                        
					</td></tr>
					<tr>
						<td>
								<table border="1" cellpadding="2" cellspacing="2" width="100%">
								<tr>
								<td bgcolor="#AA5500"  > Tipo Documento</td>
								<td bgcolor="#844200"  > Pendientes</td>
								<td bgcolor="#844200"  ><div align="center">En Proceso</div></td>
								<td bgcolor="#4682B4"  ><div align="center"><span class="Estilo2">TOTAL</span></div></td>
								</tr>
								<tr>
								<td>Entradas con Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsCTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVCTupa);?></td>
								<td align="center" style="color:#0154AF"><?=(sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsVCTupa))?></td>
								</tr>
								<tr>
								<td>Entradas sin Tupa</td>
								<td align="center"><?=sqlsrv_has_rows($rsSTupa);?></td>
								<td align="center"><?=sqlsrv_has_rows($rsVSTupa);?></td>
								<td align="center" style="color:#0154AF"><?=(sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsVSTupa))?></td>
								</tr>
								<tr>
                                  <td>Internos</td>
								  <td align="center"><?=$numinternos;?></td>
								  <td align="center"><?=sqlsrv_has_rows($rsVeInt);?></td>
								  <td align="center" style="color:#0154AF"><?=($numinternos+sqlsrv_has_rows($rsVeInt))?></td>
								</tr>
								<tr>
								<td>Salidas</td>
								<td align="center"><?=$numSalidas?></td>
								<td align="center"><?=sqlsrv_has_rows($rsSv);?></td>
								<td align="center" style="color:#0154AF"><?=($numSalidas+sqlsrv_has_rows($rsSv))?></td>
								</tr>
								<tr>
								<td bgcolor="#4682B4"><span class="Estilo2"><strong>TOTAL</strong></span></td>
								<td align="center"><b><?=(sqlsrv_has_rows($rsCTupa)+sqlsrv_has_rows($rsSTupa)+sqlsrv_has_rows($rsI)+$numSalidas)?></b></td>
								<td align="center"><b><?=(sqlsrv_has_rows($rsVCTupa)+sqlsrv_has_rows($rsVSTupa)+sqlsrv_has_rows($rsVeInt)+sqlsrv_has_rows($rsSv))?></b></td>
								<td align="center" bgcolor="#FFFFFF"><b><?=$totalpendientes?></b></td>
								</tr>
								</table>
						</td>
					</tr>
					</table>
             <? 
	}        ?>    
			</td>
			</tr>
			</table>      
	</td>
	</tr>
	</table>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/userinfo.php");?>

<?php include("includes/pie.php");?>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>