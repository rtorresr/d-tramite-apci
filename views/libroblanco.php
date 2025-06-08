<?php
session_start();
if ($_SESSION['CODIGO_TRABAJADOR']!=""){
 include_once("../conexion/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="content-type" content="text/html; charset=UFT-8">
<?php include("includes/head.php");?>
<script type="text/javascript" language="javascript" src="includes/lytebox.js"></script>
<link type="text/css" rel="stylesheet" href="includes/lytebox.css" media="screen" />
<link type="text/css" rel="stylesheet" href="css/dhtmlgoodies_calendar.css" media="screen"/>
<script type="text/javascript" src="scripts/dhtmlgoodies_calendar.js"></script>
<script Language="JavaScript">

function Buscar()
{
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>";
  document.frmConsultaEntrada.submit();
}
function releer(){
  document.frmConsultaEntrada.action="<?=$_SERVER['PHP_SELF']?>#area";
  document.frmConsultaEntrada.submit();
}
//--></script>

<style>

ul{
    margin: 0px 0px 0px 20px; 
    list-style: none; line-height: 2em; font-family: Arial;
    li{
        font-size: 16px;
        position: relative;
        &:before{
            position: absolute;
            left: -15px;
            top: 0px;
            content: '';
            display: block;
            border-left: 1px solid #ddd;
            height: 1em;
            border-bottom: 1px solid #ddd;
            width: 10px;
        }

        &:after{
            position: absolute;
            left: -15px;
            bottom: -7px;
            content: '';
            display: block;
            border-left: 1px solid #ddd;
            height: 100%;
        }
        
      &.root{
          margin: 0px 0px 0px -20px;
          &:before{
            display: none;
          }

          &:after{
            display: none;
          }


       }


       &:last-child{
          &:after{ display: none }
        }
    }
}
</style>

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

<div class="AreaTitulo">Consulta >> Libro Blanco</div>
<table class="table">
		<tr>
		<td class="FondoFormListados">
	
            
             <?php
                    
                    function detector($num){
                        $mystring = $num;
                        $findme   = '.';
                        $pos = strpos($mystring, $findme);
                        if ($pos !== false) {
                             return "si";
                        } else {
                             return "no";
                        }
                    }
    
               ?>

                
            
            
        <style>
            a{
                color: #404040;
            }    
        </style>
           
           <form action="libroblanco.php" method="get" autocomplete="off">
           <table width='80%' border='0' align='center'>
              <tr>
                  <td><b>Oficinas:</b></td>

              </tr>
               <tr>
                   <td>                    
                       <select name="oficina">
                           <option value="">Seleccione oficina</option>
                           <?php
                            $sql="select * from Tra_M_Oficinas order by cNomOficina asc";
                            $query=sqlsrv_query($cnx,$sql);
                            $rs=sqlsrv_fetch_array($query);
                            do{
                                if($_GET['oficina']==$rs['iCodOficina']){
                                    $act="selected";
                                }else{
                                    $act="";
                                }
                                echo "<option value='".$rs['iCodOficina']."' ".$act.">".substr($rs['cNomOficina'],0,70)." | ".$rs['cSiglaOficina']."</option>";
                            }while($rs=sqlsrv_fetch_array($query));
                           ?>
                       </select>
                   </td>
                   <td>
                       <input type="submit" value="Buscar" class="btn btn-primary">
                   </td>
               </tr>
           </table>
           </form>
           
           <hr>
            
            
            <?php
            if($_GET['oficina']!=''){
            ?>
            
            <table width='80%' align='center' style="border-collapse: collapse;" border="0">
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=1&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">1	Antecedentes</a></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=2&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">2	Descripcion </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=3&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">3	Marco Legal </a> </td>
                </tr>
                <tr>
                    <td>
                       <table border='0' style="border-collapse: collapse;">
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=4&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">3.1	General </a> </td>
                            </tr>
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=5&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">3.2	Especifico </a> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=6&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">4	Aspectos Operativos </a> </td>
                </tr>
                <tr>
                    <td>
                        <table border='0' style="border-collapse: collapse;">
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=7&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">4.1	Equipo de Trabajo </a> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=8&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">5	Aspectos Presupuestales </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=9&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">6	Plan de Promocion de la Inversion Privada </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=10&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">7	Participacion de Consuultoria especializada </a> </td>
                </tr>
                <tr>
                    <td>
                        <table border='0' style="border-collapse: collapse;">
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=11&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">7.1	Proceso de selección de consultores </a> </td>
                            </tr>
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=12&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">7.2	Informe de resultado de consultorias </a> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=13&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">8	Acciones de reestructuracion previas </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=14&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">9	Descripcion de la Sala de Datos </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=15&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">10	Promocion y Publicidad </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=16&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">11	Descripcion de concurso </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=17&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">12	Proceso de Cierre </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=18&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">13	Observaciones, conclusiones y recomendaciones </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=19&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">14	Otros </a> </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td rowspan="2" width='20px' style="background-image: url('images/a0.png');"></td>
                    <td><a href="detallelibroblanco.php?id=20&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15	Anexos </a> </td>
                </tr>
                <tr>
                    <td>
                        <table border='0' style="border-collapse: collapse;">
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=21&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.1	I Aspectos Operativos </a> </td>
                            </tr>
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=22&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.2	II Presupuestos </a> </td>
                            </tr>
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=23&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.3	III Contratacion de Consultorias </a> </td>
                            </tr>
                            <tr>

                                <td>
                                    <table border='0' style="border-collapse: collapse;">
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=24&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.3.1	Convocatoria </a>  </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=25&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.3.2	Bases o Terminos de Referencia </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=26&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.3.3	Acta de Concurso </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=27&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.3.4	Contrato </a> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=28&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.4	IV Sala de datos </a> </td>
                            </tr>
                            <tr>

                                <td>
                                    <table border='0' style="border-collapse: collapse;">
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=29&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.4.1	Indice </a> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                <td><a href="detallelibroblanco.php?id=30&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5	V Concurso </a> </td>
                            </tr>
                            <tr>

                                <td>
                                    <table border='0' style="border-collapse: collapse;">
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=31&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.1	Aviso de convocatoria a concurso </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=32&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.2	Bases de Proceso inversion Publica </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=33&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.3	Circulares </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=34&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.4	Credenciales presentados por los representantes legales de los postores </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=35&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.5	Acta notarial de Precalificacion </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=36&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.6	Actra notarial de presentacion de Propuestas </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=37&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.7	Acta notarial de adjudicacion de Buena Pro </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=38&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.8	Transcripciones de acuerdos del Consejo Directivo y Comites de SITDD </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=39&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
				 rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.9	Contratro suscrito por las partes y sus anexos </a> </td>
                                        </tr>
                                        <tr>
                                            <td width='120px' align='right' style="background-image: url('images/a1.png');"></td>
                                            <td><a href="detallelibroblanco.php?id=40&oficina=<?php echo $_GET['oficina'];?>"  rel="lyteframe" title="Detalle" 
                                                   rev="width: 680px; height: 280px; scrolling: auto; border:no">15.5.10	Acta notarial de eventos de fecha de cierre </a> </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
           <?php
            }
            ?>
            

            
            
            
            
            
            
            
            
            

    </td>
    </tr>
</table>
  
					</div>
                 </div>
             </div>
         </div>
     </div>
 </main>


<?php include("includes/userinfo.php");?> <?php include("includes/pie.php");?>


<map name="Map" id="Map"><area shape="rect" coords="1,4,19,15" href="#" /></map>
<map name="Map2" id="Map2"><area shape="rect" coords="0,5,15,13" href="#" /></map></body>
</html>

<?php } else{
   header("Location: ../index-b.php?alter=5");
}
?>