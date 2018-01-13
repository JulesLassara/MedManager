<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

// Si un id est en paramètre de l'URL
if(isset($_GET['id'])) {
    $rmed = new MedecinDAO(new Medecin($_GET['id'], null, null, null));
    if($rmed->existsFromId()) {
        if($rmed->delete()) {
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
