<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: PendienteData.php
SISTEMA: SISTEMA  DE TR�MITE DOCUMENTARIO DIGITAL
OBJETIVO: Seleccion remitente
PROPIETARIO: AGENCIA PERUANA DE COOPERACI�N INTERNACIONAL

 
CONTROL DE VERSIONES:
Ver   Autor                 Fecha          Descripci�n
------------------------------------------------------------------------
1.0   APCI    12/11/2010      Creaci�n del programa.
------------------------------------------------------------------------
*****************************************************************************************/
session_start();
If($_SESSION['CODIGO_TRABAJADOR']!=""){
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8>
<title>SITDD</title>

<link type="text/css" rel="stylesheet" href="css/tramite.css" media="screen" />
</head>
<body>

<table width="500" height="300" cellpadding="0" cellspacing="0" border="1" bgcolor="#ffffff">
<tr>
<td align="left" valign="top">

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

<div class="AreaTitulo">Detalles Remitente:</div>	
<table cellpadding="0" cellspacing="0" border="0" width="520">
<tr>
<td class="FondoFormRegistro">
<?
include_once("../conexion/conexion.php");
$sql= "select * from Tra_M_Remitente where iCodRemitente=".$_GET[iCodRemitente];
$rs=sqlsrv_query($cnx,$sql);
$Rs=sqlsrv_fetch_array($rs);
?>
		<table border="0">
    <tr>
    <td width="100" >Tipo Persona:</td>
    <td align="left">
    			<?php if($Rs['cTipoPersona']==1) echo "Persona Natural";?>
    			<?php if($Rs['cTipoPersona']==2) echo "Persona Juridica";?>		</td>
    </tr>
    
    <tr>
    <td width="100" >Nombre:</td>
    <td align="left"><?=$Rs['cNombre']?></td>
    </tr>
    
    <tr>
      <td >Sigla:</td>
      <td align="left"><?=$Rs[cSiglaRemitente]?></td>
    </tr>
    <tr>
    <td width="100" >Documento:</td>
    <td align="left">
	      <?
	      $sqlDoc="SELECT * FROM Tra_M_Doc_Identidad WHERE cTipoDocIdentidad='$Rs[cTipoDocIdentidad]'";
    		$rsDoc=sqlsrv_query($cnx,$sqlDoc);
	      $RsDoc=sqlsrv_fetch_array($rsDoc);
	  	  echo $RsDoc["cDescDocIdentidad"];
        sqlsrv_free_stmt($rsDoc);
        ?>		</td>
		</tr>
		
    <tr>
    <td >N&ordm; Documento:</td>
    <td  align="left"><?=$Rs['nNumDocumento']?></td>
    </tr>
    
    <tr>
    <td >Direcci�n:</td>
    <td  align="left"><?=$Rs[cDireccion]?></td>
    </tr>
    
    <tr>
    <td >E-mail:</td>
    <td align="left"><?=$Rs[cEmail]?></td>
    </tr>
    
    <tr>
    <td >Telefono:</td>
    <td align="left"><?=$Rs[nTelefono]?></td>
    </tr>
    
    <tr>
    <td >Fax:</td>
    <td align="left"><?=$Rs[nFax]?></td>
    </tr>
    
    <tr>
    <td >Departamento:</td>
    <td align="left">
				<?
        $sqlDep="SELECT * from Tra_U_Departamento WHERE cCodDepartamento='$Rs[cDepartamento]' "; 
        $rsDep=sqlsrv_query($cnx,$sqlDep);
				$RsDep=sqlsrv_fetch_array($rsDep);
				echo $RsDep["cNomDepartamento"];
        sqlsrv_free_stmt($rsDep);
        ?>		</td>
    </tr>
    
    <tr>
    <td >Provincia:</td>
    <td align="left">
    		<?
        $sqlPro="SELECT * from Tra_U_Provincia WHERE cCodDepartamento='$Rs[cDepartamento]' AND cCodProvincia='$Rs[cProvincia]'";
        $rsPro=sqlsrv_query($cnx,$sqlPro);
				$RsPro=sqlsrv_fetch_array($rsPro);
        echo $RsPro["cNomProvincia"];
        sqlsrv_free_stmt($rsPro);
			  ?>		</td>
    </tr>
    
    <tr>
    <td >Distrito:</td>
    <td align="left">
    		<?
        $sqlDis="SELECT * from Tra_U_Distrito WHERE cCodDepartamento='$Rs[cDepartamento]' AND cCodProvincia='$Rs[cProvincia]' AND cCodDistrito='$Rs[cDistrito]'"; 
        $rsDis=sqlsrv_query($cnx,$sqlDis);
				$RsDis=sqlsrv_fetch_array($rsDis);
        echo $RsDis["cNomDistrito"];
				sqlsrv_free_stmt($rsDis);
        ?>		</td>
    </tr>
            
    <tr>
    <td >Representante:</td>
    <td align="left"><?=$Rs[cRepresentante]?></td>
    </tr>
		 
    <tr>
    <td >Estado:</td>
    <td align="left">
    		<?php if($Rs[cFlag]==1) echo "Activo"?>
    		<?php if($Rs[cFlag]==2) echo "Inactivo"?>		</td>
		</tr>
    </table>

					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

<br>
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>

</body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>