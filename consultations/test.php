<?php

$dateTime = new DateTime('2011-11-17 05:05');
$dateTime->modify('+5 minutes');
echo $dateTime->format("Y-m-d H:i:s");

// Jour courant
$today = date('Y-m-j', time());

//Créneaux dispos (20 premiers)
$rdvs = array()[20];

