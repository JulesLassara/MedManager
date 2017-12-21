<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

/*
 * SESSION delete :
 *  1 = deleted with success
 *  2 = deleted with errors
 *  3 = doctor doesn't exist
 */


if(isset($_GET['id'])) {
    $rusa = new UsagerDAO(new Usager($_GET['id'], null, null, null, null, null, null, null, null));
    if($rusa->existsFromId()) {
        if($rusa->delete()) {
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
