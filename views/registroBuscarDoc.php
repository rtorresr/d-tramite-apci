<?php 
/*header('Content-Type: text/html; charset=UFT-8');*/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>

<form method="GET" name="formulario" action="<?=$_SERVER['PHP_SELF']?>">
<div class="row">
		<div class="col s12">
			<div class="card">
				<?php /*
				Documento: <input type="text" name="cCodificacion" value="<?=(isset($_GET['cCodificacion'])?$_GET['cCodificacion']:'')?>" size="30">
				Todos<input type="radio" name="tipoDoc" value="" checked>&nbsp;&nbsp;&nbsp;
				Entrada<input type="radio" name="tipoDoc" value="1" <?php if(($_GET['tipoDoc']??'')==1) echo "checked"?>>&nbsp;&nbsp;&nbsp;
				Interno<input type="radio" name="tipoDoc" value="2" <?php if(($_GET['tipoDoc']??'')==2) echo "checked"?>>&nbsp;&nbsp;&nbsp;
				Salida<input type="radio" name="tipoDoc" value="3" <?php if(($_GET['tipoDoc']??'')==3) echo "checked"?>>&nbsp;&nbsp;
				<input type="submit" class="btn btn-primary" name="buscar" value="Buscar">*/ 
				?>
				<div class="card-body">
					<fieldset>
						<legend>Seleccione documento</legend>
						<div class="row">
							<div class="col s12">
							<table id="table_ref" class="highlight bordered striped">
								<thead>
									<tr>
										<th>TIPO DOCUMENTO</th>
										<th>REGISTRO N°</th>
										<th>OPCION</th>
									</tr>
								</thead>
								<?php
									include_once("../conexion/conexion.php");
									$sqlRem="SELECT TOP 30 * FROM Tra_M_Tramite ";
									$sqlRem.="WHERE cCodificacion LIKE '%".($_GET['cCodificacion']??'')."%' And cCodTipoDoc!=45 ";
									if(($_GET['tipoDoc']??'')==1){
										$sqlRem.="AND nFlgTipoDoc=1 ";
									}
									if(($_GET['tipoDoc']??'')==2){
										$sqlRem.="AND nFlgTipoDoc=2 ";
									}
									if(($_GET['tipoDoc']??'')==3){
										$sqlRem.="AND nFlgTipoDoc=3 ";
									}
									$sqlRem.="ORDER BY iCodTramite DESC";
									$rsRem=sqlsrv_query($cnx,$sqlRem);
									//echo $sqlRem;
									while ($RsRem=sqlsrv_fetch_array($rsRem)){ ?>
										<tr>
										<td>
											<?php
												$sqlTipDoc="SELECT * FROM Tra_M_Tipo_Documento WHERE cCodTipoDoc='".$RsRem['cCodTipoDoc']."'";
												$rsTipDoc=sqlsrv_query($cnx,$sqlTipDoc);
												$RsTipDoc=sqlsrv_fetch_array($rsTipDoc);
												echo $RsTipDoc['cDescTipoDoc'];
											?>
										</td>
										<td><?=trim($RsRem["cCodificacion"])?></td>
										<td>
											<input name="cReferencia" value="<?=trim($RsRem["cCodificacion"])?>" type="hidden">
											<input name="iCodTramite" value="<?=trim($RsRem["iCodTramite"])?>" type="hidden">
											<input type="button" value="seleccione" class="btn btn-secondary" onClick="AddReferencia('<?=trim($RsRem["cCodificacion"])?>',<?=trim($RsRem["iCodTramite"])?>)">
										</td>
										</tr>
										<?php
									}
									sqlsrv_free_stmt($rsRem);
						
								?>
								</table>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>

</form>
<script>
	//document.formulario.submit();
	$(function(){
		$("#table_ref").dataTable({
			responsive: true,
			scrollY:        "50vh",
			scrollCollapse: true,
			drawCallback: function( settings ) {
				//$(".data_scrollBody").attr("data-simplebar", "");
				$('select[name="table_ref_length"]').formSelect();
			},
			dom: '<"header"f>tr<"footer"l<"paging-info"ip>>',
			"language": {
				"url": "../dist/scripts/datatables-es_ES.json"
			},
		});
	});
</script>
<?php
}else{
   header("Location: ../index-b.php?alter=5");
}
?>