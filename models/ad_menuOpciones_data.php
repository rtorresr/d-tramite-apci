<?php

require_once("../conexion/conexion.php");
switch ($_GET[opcion]) {
    case 1:
        $sql = "INSERT INTO Tra_M_Menu_Lista (iCodMenu, iCodSubMenu) VALUES ('$_GET[iCodMenu]', '$_GET[iCodSubMenu]')";
        $rs = sqlsrv_query($cnx,$sql, $cnx);
        //echo $sql;
        sqlsrv_close($cnx);
        header("Location: ../views/iu_menuOpciones_edit.php?iCodMenu=" . $_GET[iCodMenu]);
        break;
    case 3:
        $sql = "DELETE FROM Tra_M_Menu_Lista WHERE iCodMenuLista='$_GET[iCodMenuLista]'";
        $rs = sqlsrv_query($cnx,$sql, $cnx);
        //echo $sql;
        sqlsrv_close($cnx);
        header("Location: ../views/iu_menuOpciones_edit.php?iCodMenu=" . $_GET[iCodMenu]);
        break;
    case 6:
        $sql = "DELETE FROM Tra_M_Menu WHERE iCodMenu='$_GET[iCodMenu]'";
        $rs = sqlsrv_query($cnx,$sql, $cnx);
        //echo $sql;
        sqlsrv_close($cnx);
        header("Location: ../views/iu_menuOpciones.php");
        break;
}
switch ($_POST[opcion]) {
    case 4:
        For ($j = 0; $j < count($_POST[nNombreOrden]); $j++) {
            $nNombreOrden = $_POST[nNombreOrden];
            $iCodMenu = $_POST[iCodMenu];
            $sqlU = "UPDATE Tra_M_Menu SET nNombreOrden='$nNombreOrden[$j]' WHERE iCodMenu='$iCodMenu[$j]'";
            $rsU = sqlsrv_query($cnx,$sqlU, $cnx);
        }

        For ($i = 0; $i < count($_POST[nOrden]); $i++) {
            $nOrden = $_POST[nOrden];
            $Quantity = $_POST[Quantity];
            $sql = "UPDATE Tra_M_Menu_Lista SET nOrden='$nOrden[$i]' WHERE iCodMenuLista='$iCodMenuLista[$i]'";
            $rs = sqlsrv_query($cnx,$sql, $cnx);
        }
        header("Location: ../views/iu_menuOpciones.php");
        break;
    case 5:

        $nomMenu=trim($_POST[cNombreMenu]);
        $sqlCon =" select * from Tra_M_Menu where iCodPerfil='$_POST[iCodPerfil]' ";
        $rsCon = sqlsrv_query($cnx,$sqlCon, $cnx);
        while($RsCon=sqlsrv_fetch_array($rsCon)){
            if(trim($RsCon[cNombreMenu])==$nomMenu){$fg=false;break;}
            else{$fg=true;}
        }
        if($fg){
            if($nomMenu=="REGISTRO"){
                $icono="<i class=\"fas fa-pen-nib\"></i>";
            }elseif ($nomMenu=="BANDEJA"){
                $icono="<i class=\"far fa-envelope\"></i>";
            }elseif ($nomMenu=="CONSULTA"){
                $icono="<i class=\"fas fa-search\"></i>";
            }elseif ($nomMenu=="MANTENIMIENTO"){
                $icono="<i class=\"fas fa-wrench\"></i>";
            }

            $sqlMov = "INSERT INTO Tra_M_Menu ";
            $sqlMov.="(iCodPerfil, cNombreMenu, cIcono)";
            $sqlMov.=" VALUES ";
            $sqlMov.="('$_POST[iCodPerfil]', '$nomMenu', '$icono')";
            $rsMov = sqlsrv_query($cnx,$sqlMov, $cnx);
            header("Location: ../views/iu_menuOpciones.php");
        }else{
            header("Location: ../views/iu_menuOpciones.php?error=true");
        }
        break;
}
?>