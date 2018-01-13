<?php

require('../ressources/RDV.php');
require('../ressources/dao/RDVDAO.php');

$listrdv = new RDVDAO(new RDV(null, null, null, null));
$test = $listrdv->getElementsByIdMedecin("16")->fetchAll(PDO::FETCH_ASSOC);

var_dump($test);

//echo "<br>";
/*
foreach($test as $a) {
    echo $a['date_heure_rdv'];
}*/


$date = "2018-01-21";
$nbconsult = 0;

foreach($test as $rdv) {
    echo $rdv["date_heure_rdv"];
    if(strpos($rdv['date_heure_rdv'], $date) !== false) $nbconsult .= 1;
}

echo $nbconsult;