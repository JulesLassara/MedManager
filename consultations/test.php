<?php

require('../ressources/RDV.php');
require('../ressources/dao/RDVDAO.php');

$a = new DateTime("2018-01-10 11:23:00");
$b = new DateTime("2018-01-11 11:23:00");


if($a >= $b) {
    echo "ok";
}