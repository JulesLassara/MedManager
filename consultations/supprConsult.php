<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/RDV.php');
require('../ressources/dao/RDVDAO.php');

// Si les clés primaires sont passées en paramètre
if(isset($_GET['date']) && isset($_GET['act_id_medecin'])) {
    $rdv = new RDVDAO(new RDV(new DateTime($_GET['date']), null, $_GET['act_id_medecin'], null));
    if($rdv->existsFromIds($_GET['date'], $_GET['act_id_medecin'])) {
        if($rdv->delete()) {
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
