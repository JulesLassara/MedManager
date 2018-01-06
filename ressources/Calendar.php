<?php
// Timezone de France
date_default_timezone_set('Europe/Paris');

// Récupération du mois précédant et suivant
if (isset($_GET['ma'])) $ma = $_GET['ma'];
// Le mois courant
else $ma = date('Y-m');

$timestamp = strtotime($ma . '-01');
if ($timestamp === false) $timestamp = time();

// Le jour courant
$today = date('Y-m-j', time());

// Màj du titre
$html_title = date('F Y', $timestamp);
$html_title = str_replace(
array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'),
$html_title
);

// Lien mois précédant/suivant
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// Nombre de jours dans le mois
$day_count = date('t', $timestamp);

// 0 = Dimanche,  1 = Lundi, 2 = Mardi ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


// Création du calendrier
$weeks = array();
$week = '';

// Ajout d'une cellule vide
$week .= str_repeat('<td class="day"></td>', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {

    $date = $ma.'-'.$day;

    if ($today == $date) $week .= '<td class="day today">'.$day;
    else $week .= '<td class="day">'.$day;

    $week .= '</td>';

    // Si fin de semaine ou de mois
    if ($str % 7 == 6 || $day == $day_count) {

        // Ajout d'une cellule vide
        if($day == $day_count) $week .= str_repeat('<td class="day"></td>', 6 - ($str % 7));

        $weeks[] = '<tr>'.$week.'</tr>';

        // Prepare for new week
        $week = '';

    }

}