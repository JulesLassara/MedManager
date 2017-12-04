<?php
echo "Modifier medecin ok";

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$med = new Medecin("Homme", "Heinstein", "Frank");

$rmed = new MedecinDAO($med);

echo $rmed->insert();