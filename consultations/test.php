<?php

require_once('../ressources/RDV.php');
require_once('../ressources/dao/RDVDAO.php');

$test = DateTime::createFromFormat('d/m/Y H:i:s', '03/10/2017 05:00:00');
echo $test->format('Y-m-d H:i:s');

echo "=====================";

$dateTime = new DateTime('2018-01-11 05:00:45');
$dateTime->modify('+1 day');
//$dateTime->setTime($dateTime->format("H"), 12, $dateTime->format("s"));
echo $dateTime->format("Y-m-d H:i:s");
echo "<br>";

// Jour courant
$today = new DateTime(date('Y-m-d H:i:s', time()));

// Création du premier créneau
if($today->format("i") < 30) {
    $today->setTime($today->format("H"), 30, 0);
} else {
    $today->setTime($today->format("H"), 0, 0);
    $today->modify('+1 hour');
}

// Création du rdv courant
$currentrdv = new RDV($today, null, null, 30);
// Liste des créneaux déjà occupés
$listrdv = new RDVDAO($currentrdv);

// Créneaux dispos (20 premiers)
$rdvs = array();
$a= 1;
// Tant qu'il n'y a pas 20 créneaux disponibles
while (sizeof($rdvs) < 20) {

    $allrdv = $listrdv->getElementsByKeywordInColumn(16);

    // Si l'heure de fin du rdv ne dépasse pas 17h30 et que ce n'est pas dimanche
    // TODO: jours feriés
    if($currentrdv->getDateheureFin()->format("H") <= 17
        && $currentrdv->getDateheure()->format("w") != 0) {
        $overlap = false;

        // Parcours de tous les rendez-vous
        while($data = $allrdv->fetch()) {
            $rdvcheckend = new DateTime($data['date_heure_rdv']);
            $rdvcheckend->modify('+'.$data['duree_rdv'].' minutes');

            // Si le rendez-vous courant est pendant le rendez-vous stocké
            if($currentrdv->getDateheure() >= new DateTime($data['date_heure_rdv'])
            && $currentrdv->getDateheureFin() <= $rdvcheckend) {
                $overlap = true;
                break;
            }
        }
        if(!$overlap) {
            $rdvs[sizeof($rdvs)] = $currentrdv->getDateheure()->format("Y-m-d H:i:s");
        }
        $currentrdv->nextSlot();
    } else {
        $currentrdv->nextDay();
    }

}

for($i = 0; $i < sizeof($rdvs); $i++) {
    echo "Le ".$rdvs[$i];
    echo "<br>";
}