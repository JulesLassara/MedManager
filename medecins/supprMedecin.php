<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

/*
 * SESSION delete :
 *  1 = deleted with success
 *  2 = deleted with errors
 *  3 = doctor doesn't exist
 */


if(isset($_GET['id'])) {
    $rmed = new MedecinDAO(new Medecin($_GET['id'], null, null, null));
    if($rmed->existsFromId()) {
        if($rmed->delete()) {
            $_SESSION['deleted'] = 1;
            header('Location: .');
        } else {
            $_SESSION['deleted'] = 2;
            header('Location: .');
        }
    } else {
        $_SESSION['deleted'] = 3;
        header('Location: .');
    }
} else {
    header('Location: .');
}
