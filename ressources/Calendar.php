<?php
// Set your timezone!!
date_default_timezone_set('Europe/Paris');

// Get prev & next month
if (isset($_GET['ma'])) {
$ma = $_GET['ma'];
} else {
// This month
$ma = date('Y-m');
}

// Check format
$timestamp = strtotime($ma . '-01');
if ($timestamp === false) {
$timestamp = time();
}

// Today
$today = date('Y-m-j', time());

// For H3 title
$html_title = date('F Y', $timestamp);
$html_title = str_replace(
array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'),
$html_title
);

// Create prev & next month link     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// Number of days in the month
$day_count = date('t', $timestamp);

// 0:Sun 1:Mon 2:Tue ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


// Create Calendar!!
$weeks = array();
$week = '';

// Add empty cell
$week .= str_repeat('<td class="day"></td>', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {

$date = $ma.'-'.$day;

if ($today == $date) {
$week .= '<td class="day today">'.$day;
    } else {
    $week .= '<td class="day">'.$day;
    }
    $week .= '</td>';

// End of the week OR End of the month
if ($str % 7 == 6 || $day == $day_count) {

if($day == $day_count) {
// Add empty cell
$week .= str_repeat('<td class="day"></td>', 6 - ($str % 7));
}

$weeks[] = '<tr>'.$week.'</tr>';

// Prepare for new week
$week = '';

}

}