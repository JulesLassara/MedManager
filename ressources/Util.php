<?php

function checkOverlap(RDV $rdv, $timebegin) {
    $timeend = new DateTime($timebegin['date_heure_rdv']);
    $timeend->modify('+'.$timebegin['duree_rdv'].' minutes');

    // Si la date de début du RDV est pendant un RDV déjà existant
    if($rdv->getDateheure() >= new DateTime($timebegin['date_heure_rdv'])
        && $rdv->getDateheure() <= $timeend) {
        return true;
    }

    // Si la date de fin du RDV est pendant un RDV déjà existant
    if($rdv->getDateheureFin() >= new DateTime($timebegin['date_heure_rdv'])
        && $rdv->getDateheureFin() <= $timeend) {
        return true;
    }

    return false;
}