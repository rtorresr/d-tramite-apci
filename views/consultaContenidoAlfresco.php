<?
/**************************************************************************************
NOMBRE DEL PROGRAMA: consultaContenidoAlfresco.php
SISTEMA: SISTEMA  DE TRÁMITE DOCUMENTARIO DIGITAL
OBJETIVO: Consulta de los Contenidos de los Documentos de Entrada en el Repositorio Alfreso
PROPIETARIO: AGENCIA PERUANA DE COOPERACIÓN INTERNACIONAL
ELABORADO POR: MPLB
 
CONTROL DE VERSIONES:
Ver      Autor             Fecha        Descripción
------------------------------------------------------------------------
1.0   MPLB       09/04/2012                Creación del programa.
 
------------------------------------------------------------------------
*****************************************************************************************/
?><?
session_start();
if ($_SESSION['CODIGO_TRABAJADOR'] != "") {
  include_once("../conexion/conexion.php");
  
  /*
   DOC INTERNO
  DOC ENTRADA (EXPEDIENTES) NR TRAMITE CORRELATIVO UNICO
  DOC SALIDA
  Forma de Busqueda:
  Contiene Todas las Palabras
  Contiene Cualquiera de las Palabras
  No contiene estas Palabras
  Parecido a estas Palabras
  Exacta frase
  Sintaxis Libre (Experto)
  */
  $form = array();
  $form['tiProcess'] = $_REQUEST['tiProcess'];
  $form['tiBusqueda'] = $_REQUEST['tiBusqueda'];
  $form['noBusqueda'] = $_REQUEST['noBusqueda'];
  $form['feDesde'] = $_REQUEST['feDesde'];
  $form['feHasta'] = $_REQUEST['feHasta'];
  $form['lstTiBusqueda'] = array(
          '0' => '[Seleccione]',
          '1' => 'Contiene Todas las Palabras',
          '2' => 'Contiene Cualquiera de las Palabras',
          /*'3' => 'No contiene estas Palabras',*/
          /*'4' => 'Parecido a estas Palabras',*/
          '5' => 'Exacta frase',
          '6' => 'Sintaxis Libre (Experto)',
  );
  $nodes = array();
  
  switch ($form['tiProcess']) {
    case 'processBusqueda':
      //procesar la consulta
      if (intval($form['tiBusqueda']) > 0 && strlen(trim($form['noBusqueda'])) >= 3) {
        $form['noBusqueda'] = trim($form['noBusqueda']);
        $form['noBusqueda'] = preg_replace('/\s\s+/', ' ', $form['noBusqueda']);
        
        $strResult = '';
        
        if ($form['feDesde'] != '') {
            //se espera con el formato yyyy-mm-dd del formulario
            //TODO VALIDAR FORMATO!!
            if ($form['feHasta'] != '') {
                $strResult .= "(@\{http\://www.softwarelibreandino.com/model/pcm/1.0\}ld_fecReg:[" . $form['feDesde'] . "T00:00:00 TO " . $form['feHasta'] . "T00:00:00]) AND ";
            }
            else {
                //$arrFeDesde = split('-', $form['feDesde']);//yyyy-mm-dd
                //$feHasta = date('Y-mm-dd\TH:i:s', mktime(23, 59, 59, $arrFeDesde[1], (int) $arrFeDesde[2], $arrFeDesde[0]));
                $strResult .= "(@\{http\://www.softwarelibreandino.com/model/pcm/1.0\}ld_fecReg:[" . $form['feDesde'] . "T00:00:00 TO NOW]) AND ";
            }
        }
        
        $arrKeywordsTokens = explode(' ', $form['noBusqueda']);
        
        if ($form['tiBusqueda'] == 1) {
          $strResult .= '(';
          for ($i = 0; $i < count($arrKeywordsTokens); $i++) {
            $strResult .= ' TEXT:"' . $arrKeywordsTokens[$i] . '" ';
            if ($i < count($arrKeywordsTokens) - 1) {
              $strResult .= ' AND ';
            }
          }
          $strResult .= ')';
        }
        else if ($form['tiBusqueda'] == 2) {
          $strResult .= '(';
          for ($i = 0; $i < count($arrKeywordsTokens); $i++) {
            $strResult .= ' TEXT:"' . $arrKeywordsTokens[$i] . '" ';
            if ($i < count($arrKeywordsTokens) - 1) {
              $strResult .= ' OR ';
            }
          }
          $strResult .= ')';
        }
        else if ($form['tiBusqueda'] == 3) {
          $strResult .= '(';
          for ($i = 0; $i < count($arrKeywordsTokens); $i++) {
            //$strResult .= ' NOT TEXT:"' . $arrKeywordsTokens[$i] . '" ';
            //$strResult .= ' -' . $arrKeywordsTokens[$i] . ' ';
            //$strResult .= ' NOT TEXT:' . $arrKeywordsTokens[$i] . ' ';
            $strResult .= ' NOT ' . $arrKeywordsTokens[$i] . ' ';
            if ($i < count($arrKeywordsTokens) - 1) {
              $strResult .= ' AND ';
            }
          }
          $strResult .= ')';
        }
        else if ($form['tiBusqueda'] == 4) {
          $strResult .= '(';
          for ($i = 0; $i < count($arrKeywordsTokens); $i++) {
            $strResult .= ' ~TEXT:"' . $arrKeywordsTokens[$i] . '" ';
            if ($i < count($arrKeywordsTokens) - 1) {
              $strResult .= ' AND ';
            }
          }
          $strResult .= ')';
        }
        else if ($form['tiBusqueda'] == 5) {
          $strResult .= '(';
          $strResult .= ' TEXT:"' . $form['noBusqueda'] . '" ';
          $strResult .= ')';
        }
        else if ($form['tiBusqueda'] == 6) {
          $strResult .= '(';
          $strResult .= ' ' . $form['noBusqueda'] . ' ';
          $strResult .= ')';
        }
        
        $rootDir = "../";
        // Include the required Alfresco PHP API objects
        require_once $rootDir . 'Alfresco/Service/WebService/WebServiceFactory.php';
        require_once $rootDir . 'Alfresco/Service/BaseObject.php';
        require_once $rootDir . "Alfresco/Service/Repository.php";
        require_once $rootDir . "Alfresco/Service/Session.php";
        require_once($rootDir . "Alfresco/Service/Functions.php");
        require_once $rootDir . "Alfresco/Service/SpacesStore.php";
        
        // Specify the connection details
        $repositoryUrl = "http://ecm.pcm.gob.pe/alfresco/api";
        $userName = "admin";
        $password = "4lfr3sc0@PCM";
        
        // Authenticate the user and create a session
        $repository = new Repository($repositoryUrl);
        $ticket = $repository->authenticate($userName, $password);
        $session = $repository->createSession($ticket);
        $spacesStore = new SpacesStore($session);
        //error_log("PATH:\"/app:company_home/st:sites/cm:tramite//*\" AND TYPE:\"cm:content\" AND " . $strResult);
        $nodes = $session->query($spacesStore, "PATH:\"/app:company_home/st:sites/cm:tramite//*\" AND TYPE:\"cm:content\" AND " . $strResult);//TEXT:\"*FREDY*\"

        
        if (count($nodes) == 0) {
          $strMensaje = "NO SE ENCONTRARON REGISTROS";
        }
        else {
          $strMensaje = "TOTAL DE REGISTROS : " . count($nodes);
        }
        
      }
      else {
        //mostrar mensaje de error...
        $strMensaje = "Los campos ingresados no son los correctos. Verifique.";
      }
    break;
  
    case 'downloadXls':
      //procesar
    break;
  
    case 'downloadPdf':
      //procesar
    break;
  
    case 'resetBusqueda':
    default:
      $form['tiBusqueda'] = 0;
      $form['noBusqueda'] = '';
      $form['tiProcess'] = '';
      $form['feDesde'] = '';
      $form['feHasta'] = '';
      //presentar la pantalla de consulta
      $strMensaje = "";
    break;
  }

?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">

  function $DomEl(strId) {
	  return document.getElementById(strId);
  }

  function Buscar() {
	  
	  if ($DomEl('tiBusqueda').value == '0') {
		  alert('Debe de seleccionar un tipo de busqueda para el contenido. Verifique.');
		  return false;
	  }
	  
	  if ($DomEl('noBusqueda').value.length < 3) {
		  alert('La palabra de b�squeda debe tener al menos tres caracteres. Verifique.');
		  return false;
	  }
	  
	  $DomEl('tiProcess').value = 'processBusqueda';
	  $DomEl('frmConsultaContenidoAlfresco').submit();
  }

  function Reset() {
	  $DomEl('tiProcess').value = 'resetBusqueda';
	  $DomEl('frmConsultaContenidoAlfresco').submit();
  }

  function DownloadXls() {
	  $DomEl('tiProcess').value = 'downloadXls';
	  $DomEl('frmConsultaContenidoAlfresco').submit();
  }

  function DownloadPdf() {
	  $DomEl('tiProcess').value = 'downloadPdf';
	  $DomEl('frmConsultaContenidoAlfresco').submit();
  }
  
</script>
</head>
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

<div class="AreaTitulo">Consulta >> B�squeda por Contenido</div>

  <table width="1038" cellspacing="0" cellpadding="0" border="0">
    <tbody>
    <tr>
      <td align="center" class="FondoFormListados">
      
      <form action="consultaContenidoAlfresco.php" method="post" name="frmConsultaContenidoAlfresco" id="frmConsultaContenidoAlfresco" onsubmit="return false;">
        <input type="hidden" name="tiProcess"  id="tiProcess" value=""/>
        <table width="960" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr><td>

  	      <table width="1000" cellspacing="3" cellpadding="3" border="0">
  	      <tbody>
          <tr>
            <td colspan="4" align="left">
                <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                <td >Desde:&nbsp;<input type="text" readonly id="feDesde" name="feDesde" value="<?php echo $form['feDesde']?>" style="width:105px" class="FormPropertReg form-control">
                </td>
                <td>
                    <div class="boton" style="width:24px;height:20px">
                        <a href="javascript:;" onclick="displayCalendar(document.forms[0].feDesde,'yyyy-mm-dd', this, true)">
                            <img src="images/icon_calendar.png" width="22" height="20" border="0">
                        </a>
                    </div>
                </td>
                <td width="20"></td>
                <td >Hasta:&nbsp;<input type="text" readonly id="feHasta" name="feHasta" value="<?php echo $form['feHasta']?>" style="width:105px" class="FormPropertReg form-control">
                </td>
                <td>
                    <div class="boton" style="width:24px;height:20px">
                        <a href="javascript:;" onclick="displayCalendar(document.forms[0].feHasta,'yyyy-mm-dd', this, true)">
                            <img src="images/icon_calendar.png" width="22" height="20" border="0">
                        </a>
                    </div>
                </td>
                </tr>
                </table>
            </td>
          </tr>
  	      <tr>
	      <td width="110" >Tipo de B�squeda</td>
	      <td>
	        <select name="tiBusqueda" id="tiBusqueda" class="FormPropertReg form-control" style="width:260px">
	          <?php
foreach ($form['lstTiBusqueda'] as $keyF => $valueF) {
                  if ($keyF == $form['tiBusqueda']) {
                    $selectedF = 'selected';
                  }
                  else {
                    $selectedF = '';
                  }
                  echo "<option value=" . $keyF . " " . $selectedF . ">" . $valueF . "</option>";
                }
	          ?>
	        </select>
	      </td>
	      <td >Palabras de B�squeda</td>
	      <td  width="110" >
	        <input type="text" name="noBusqueda" id="noBusqueda" size="60" value="<?=$form['noBusqueda']?>"/>
	      </td>
          </tr>
          <tr>
            <td colspan="4" align="right">
            
                <button onmouseover="this.style.cursor='hand'" onclick="Buscar();" class="btn btn-primary" style="">
                <table cellspacing="0" cellpadding="0">
                <tbody><tr>
                <td style=" font-size:10px">
                <b>Buscar</b> 
                <img width="17" height="17" border="0" src="images/icon_buscar.png"></td></tr></tbody></table>
                </button>
                              &nbsp;				
                <button onmouseover="this.style.cursor='hand'" onclick="Reset();" class="btn btn-primary" style="">
                <table cellspacing="0" cellpadding="0">
                <tbody><tr>
                <td style=" font-size:10px">
                <b>Restablecer</b> 
                <img width="17" height="17" border="0" src="images/icon_clear.png"></td></tr></tbody></table></button>
                
                              &nbsp;				
                <!-- button onmouseover="this.style.cursor='hand'" onclick="DownloadXls();" class="btn btn-primary" style="">
                <table cellspacing="0" cellpadding="0">
                <tbody><tr>
                <td style=" font-size:10px"><b>a Excel</b> <img width="17" height="17" border="0" src="images/icon_excel.png"></td></tr></tbody></table></button-->
                              &nbsp;
                <!-- button onmouseover="this.style.cursor='hand'" onclick="DownloadPdf();" class="btn btn-primary">
                <table cellspacing="0" cellpadding="0"><tbody><tr><td style=" font-size:10px"><b>a Pdf</b> <img width="17" height="17" border="0" src="images/icon_pdf.png"></td></tr></tbody></table>
                </button-->
            </td>
          </tr>
          </tbody>
          </table>
        </fieldset>
        </td></tr></tbody>
        </table>
      </form>
    
      <br><?=$strMensaje?></br>
      <table width="100%" cellspacing="3" cellpadding="3" border="0" align="center">
      <tbody>
      <tr>
        <td width="30" class="headCellColum">FE. REGISTRO</td>
        <td width="80" class="headCellColum">Nro TRAMITE</td>
        <td width="200" class="headCellColum">TIPO</td>
        <td class="headCellColum">REMITENTE</td>
        <td width="380" class="headCellColum">ASUNTO</td>
        <!-- td class="headCellColum">ARCHIVO</td-->
        <td class="headCellColum">URL</td> 
      </tr>
      <?

      foreach ($nodes as $child)
      {
        $properties = $child->properties;
        $contentUrl = ($child->cm_content != null)? $child->cm_content->getUrl() : null;
        $feRegistro = $properties['{http://www.softwarelibreandino.com/model/pcm/1.0}ld_fecReg'];
        $arrFeRegistro = explode('T', $feRegistro); 
        print '<tr>';
        print '<td align="left">' . $arrFeRegistro[0] . '</td>';
        print '<td align="center">' . $properties['{http://www.softwarelibreandino.com/model/pcm/1.0}ld_numTra'] .'</td>';
        print '<td align="left">' . $properties['{http://www.softwarelibreandino.com/model/pcm/1.0}ld_tipDoc'] . '<br/>' . utf8_decode($properties['{http://www.softwarelibreandino.com/model/pcm/1.0}ld_numDoc']) .'</td>';
        print '<td align="left">' . $properties['{http://www.softwarelibreandino.com/model/pcm/1.0}ld_rem'] .'</td>';
        print '<td align="left">' . utf8_decode($properties['{http://www.softwarelibreandino.com/model/pcm/1.0}ld_sum']) .'</td>';  
        //print '<td align="center">' . $child->cm_name .'</td>';
        print '<td align="center"> <a href="'.$contentUrl.'" target="_blank">Ver Archivo</a></td>';
        print '</tr>';
        
        /*foreach ($properties as $keyp => $valp) {
          error_log("properties:keyp:" . $keyp . " valp:" . $valp);
        }*/
        
      }
      ?>
      <tr>
          <td align="center" colspan="5"><b>�</b><b>1</b><b>�</b>
          </td>
      </tr>
      </tbody>
      </table>
      
      
      </td>
    </tr>
    </tbody>
  </table>



<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>
<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>