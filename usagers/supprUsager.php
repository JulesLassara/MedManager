<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

if(isset($_GET['id'])) {
    $rusa = new UsagerDAO(new Usager($_GET['id'], null, null, null, null, null, null, null, null));
    if($rusa->existsFromId()) {
        if($rusa->delete()) {
            $_SESSION['deleted'] = 1; // Succès
            header('Location: .');
        } else {
            $_SESSION['deleted'] = 2; // Erreur
            header('Location: .');
        }
    } else {
        $_SESSION['deleted'] = 3; // Médecin inexistant
        header('Location: .');
    }
} else {
    header('Location: .');
}
