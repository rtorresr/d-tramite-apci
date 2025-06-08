<?php
if (in_array(basename($_SERVER['SCRIPT_NAME']),$_SESSION['Restricciones'])){
    header("Location: ".(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/d-tramite-mp/views/main.php");
}

//--Consulta para obtener Menu--//
$menu_data = array();
$icono_menu_data = array();


include_once("includes/conexion.menu.php");
$sqlBtn = "SELECT * FROM Tra_M_Menu WHERE iCodPerfil='" . $_SESSION['iCodPerfilLogin'] . "' ORDER BY nNombreOrden ASC";
$rsBtn = sqlsrv_query($cnx2,$sqlBtn);
$i = 0;
while ($RsBtn = sqlsrv_fetch_array($rsBtn)) {
    $menu_data[$i]["iCodMenu"] = $RsBtn['iCodMenu'];
    $menu_data[$i]["cNombreMenu"] = trim($RsBtn['cNombreMenu']);
    $icono_menu_data[$i]= trim($RsBtn['cIcono']);
    $sqlSub = "SELECT * FROM Tra_M_Menu_Lista WHERE iCodMenu='" . $RsBtn['iCodMenu'] . "' ORDER BY nOrden ASC";
    $rsSub = sqlsrv_query($cnx2,$sqlSub);
    $j = 0;
    while ($RsSub = sqlsrv_fetch_array($rsSub)) {
        $sqlSubItm = "SELECT * FROM Tra_M_Menu_Items WHERE iCodSubMenu='" . $RsSub['iCodSubMenu'] . "'";
        $rsSubItm = sqlsrv_query($cnx2,$sqlSubItm);
        $RsSubItm = sqlsrv_fetch_array($rsSubItm);
        $menu_data[$i]['data'][$j]['cScriptSubMenu'] = trim($RsSubItm['cScriptSubMenu']);
        $menu_data[$i]['data'][$j]['cNombreSubMenu'] = trim($RsSubItm['cNombreSubMenu']);
        $menu_data[$i]['data'][$j]['cIcono'] = trim($RsSubItm['cIcono']);
        $j++;
    }
    $i++;
}
sqlsrv_close($cnx2);

include_once("../conexion/conexion.php");
$sqlNom = '';
$sqlNom .= 'SELECT A.iCodTrabajador,(RTRIM(B.cNombresTrabajador)+\' \'+RTRIM(B.cApellidosTrabajador)) AS cNombres,A.iCodOficina,C.cSiglaOficina,A.iCodPerfil,D.cDescPerfil FROM Tra_M_Perfil_Ususario A ';
$sqlNom .= 'INNER JOIN Tra_M_Trabajadores B ON A.iCodTrabajador = B.iCodTrabajador ';
$sqlNom .= 'INNER JOIN Tra_M_Oficinas C ON A.iCodOficina = C.iCodOficina ';
$sqlNom .= 'INNER JOIN Tra_M_Perfil D ON A.iCodPerfil = D.iCodPerfil ';
$sqlNom .= 'WHERE A.iCodTrabajador = '.$_SESSION['CODIGO_TRABAJADOR'] .'AND A.iCodOficina = '.$_SESSION['iCodOficinaLogin'].'AND A.iCodPerfil = '.$_SESSION['iCodPerfilLogin'];
$rsNom  = sqlsrv_query($cnx,$sqlNom);
$RsNom  = sqlsrv_fetch_array($rsNom);
 ?>

<header class="mainHeader <?php echo ($navExtended === true) ? 'nav-extended' : ''; ?>">
    <div class="navbar-fixed">
        
        <div class="pageHeaderWrapper">
            <a style="width: auto" class="sidenav-trigger left hide-on-large-onlys" href="#!" data-target="slide-out"><i class="fas fa-bars"></i></a>
            
            <?php if (isset($hasSearch) && $hasSearch) : ?>
                <?php include('searchbox.php'); ?>
            <?php else : ?>
                <h5 style="padding: 0 15px" class="page-header truncate left"><?php echo ($pageTitle) ? $pageTitle : "" ?></h5>
            <?php endif; ?>
        </div>

        <nav class="navbar">
            <div class="nav-wrapper">

                <ul class="right" id="nav-mobile">
                    <?php if($_SESSION['nroPerfiles'] > 1 ){ ?>
                        <li class="switchProfile">
                            <a class="switch-profile  modal-trigger tooltipped" data-position="left" data-tooltip="Cambiar Perfil" href="#modal1"  >
                                <picture>
                                    <img src="../dist/images/switch-user.png" alt="" srcset="" width="26" height="26">
                                </picture>
                            </a>
                        </li>

                    <?php } ?>
                    <li>
                        <a class="profile-trigger modal-trigger" href="#modal1" data-target="dropdownProfile">
                            <div class="profile">
                                <p class="name"><?php echo $RsNom['cNombres']; ?></p>
                                <?php if ($_SESSION['CODIGO_TRABAJADOR'] != 141) {?>
                                    <p class="access"><?php echo rtrim($RsNom['cSiglaOficina']).' ('.rtrim($RsNom['cDescPerfil']).')'; ?></p>
                                <?php } else {?>
                                    <p class="access"><?php echo rtrim($RsNom['cSiglaOficina']).' (Asesor 3)'; ?></p>
                                <?php } ?>
                            </div>
                            <picture>
                                <?php 
                                    $iCodPerfil = $RsNom['iCodPerfil'];

                                    switch ($iCodPerfil) {
                                        case 1:
                                            $iconPerfil = 'user-secret';
                                            break;

                                        case 2:
                                            $iconPerfil = 'user-tag';
                                            break;

                                        case 3:
                                            $iconPerfil = 'user-tie';
                                            break;
                                            
                                        case 18:
                                            $iconPerfil = 'user-tie';
                                            break;

                                        case 19:
                                            $iconPerfil = 'user-edit';
                                            break;

                                        case 20:
                                            $iconPerfil = 'user-tie';
                                            break;
                                        
                                        default:
                                            $iconPerfil = 'user';
                                            break;
                                    }
                                ?>
                                <span class="fa-stack">
                                    <i class="fas fa-square fa-stack-2x"></i>
                                    <i class="fas fa-<?php echo $iconPerfil; ?> fa-stack-1x fa-inverse"></i>
                                </span>
                            </picture>
                        </a>
                        <ul class="dropdown-content" id="dropdownProfile" style="top:100% !important">
                            <li><a href="perfil.php">Configuración</a></li>
                            <li><a href="#modalCambioContrasena" class="modal-trigger tooltipped" data-position="left" data-tooltip="Cambiar Contraseña" >Contraseña</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span style="padding-left:0.5rem">Salir</span></a></li>
                        </ul>
                    </li>
                </ul>
                
            </div>
        </nav>
    </div>
</header>

<aside id="sidebar">
    <ul class="sidenav sidenav-fixed" id="slide-out" style="">
        <li>
            <a class="logo-container" href="./main.php">
                <figure>
                    <svg height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170.2 108.82">
                        <path fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="8px" d="M38.17,40S43,16.42,71,5.94c0,0,22.86-7.12,40.7,5.93,0,0,14,8.51,19.64,28.09,0,0,26.93-1.58,34,24.93,0,0,4.05,14.24-5.26,23.94,0,0-8.1,12.06-20.45,11.47S75.83,74.82,75.83,74.82s-9.72,26.27-36.64,27.46-32.4-18.2-32.4-18.2S-3.74,62.52,16.1,46.89C16.1,46.89,21,41.35,38.17,40Z"/>
                        <path fill="#e09c35" d="M22.35,90.84c3,.61,17.46,3.18,28.72-5.53,6.85-5.31,10.23-13,11.76-16.49a50.38,50.38,0,0,0,3.55-12c23.45,12,46.45,25,71.45,37-11-3.63-56-24.56-66.34-28.93,0,0-7.55,25-28.4,30.1C43.09,95,29.79,97.54,22.35,90.84Z"/>
                        <path fill="#e09c35" d="M49.83,108.82h89c-9.11-2.95-18.56-6.44-28.44-10.1-10.54-3.9-21-8.53-30.54-12.9a43.34,43.34,0,0,1-10,12A61.74,61.74,0,0,1,49.83,108.82Z"/>
                    </svg>
                    <figcaption>
                        <h1>D-Trámite</h1>
                    </figcaption>
                </figure>
            </a>
        </li>
        <li class="<?php if ($activeItem && $activeItem === "main.php") echo 'active ';?>bold">
            <a class="waves-effect waves-primary" href="./main.php" title="Inicio">
                <i class="fa-fw fas fa-home"></i><span>Inicio</span>
            </a>
        </li>
        
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <?php $j=0;?>
                <?php foreach ($menu_data as $tmpdata1): ?>
                    <?php if( trim($tmpdata1['cNombreMenu']) === 'Registro' )  : ?>
                        <?php if ($_SESSION['iCodPerfilLogin'] == 2) { ?>
                            <li class="<?php if ($activeItem && $activeItem === "registroEntrada.php") echo 'active ';?>bold">
                                <a class="waves-effect waves-primary" href="./registroEntrada.php" title="Registro">
                                    <i class="fa-fw fas fa-pencil-alt"></i><span>Registro</span>
                                </a>
                            </li>
                        <?php }else{ ?>
                            <li class="<?php if ($activeItem && $activeItem === "registroOficina.php") echo 'active ';?>bold">
                                <a class="waves-effect waves-primary" href="./registroOficina.php" title="Registro">
                                    <i class="fa-fw fas fa-pencil-alt"></i><span>Registro</span>
                                </a>
                            </li>
                        <?php } ?>
                            
                        <?php $j++ ?>
                        
                        <?php continue; ?>
                    <?php endif; ?>
                    <?php
                        if($tmpdata1['iCodMenu'] == 94 && $_SESSION['iCodOficinaLogin'] != 363){
                            continue;
                        }
                    ?>
                        <li class="bold waves-effect">
                            <a class="collapsible-header waves-effect waves-primary" tabindex="0">
                                <?php echo $icono_menu_data[$j]; ?><span><?php echo trim($tmpdata1['cNombreMenu']) ?></span>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    <?php foreach ($tmpdata1['data'] as $tmpdata2): ?>
                                        <?php
                                            if (in_array(trim($tmpdata2['cScriptSubMenu']),$_SESSION['Restricciones'])){
                                                continue;
                                            }
                                        ?>
                                        <li class="<?php echo ($activeItem === $tmpdata2['cScriptSubMenu']) ? 'active' : ''; ?>">

                                            <a class="truncate" href="<?php echo $tmpdata2['cScriptSubMenu'] ?>">
                                                <?php echo $tmpdata2['cIcono']; ?>
                                                <span style="width:80%"><?php echo trim($tmpdata2['cNombreSubMenu']) ?><?php //echo numeros_totales($tmpdata2['cNombreSubMenu'],$total1,$total2,$total3,$total4,$total5);?></a></span>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        </li>
                    <?php $j++;?>
                <?php endforeach ?>
            </ul>
        </li>    
    </ul>
</aside>