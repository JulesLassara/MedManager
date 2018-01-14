<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

require('../ressources/Usager.php');
require('../ressources/dao/UsagerDAO.php');

require('../ressources/RDV.php');
require('../ressources/dao/RDVDAO.php');

// Liste des médecins du centre
$listmed = new MedecinDAO(new Medecin(null, null, null, null));
$listmed = $listmed->getElementsByKeyword("")->fetchAll(PDO::FETCH_ASSOC);

// Liste des rendez-vous en fonction de filtre s'il existe
$listrdv = new RDVDAO(new RDV(null, null, null, null));
if(!isset($_GET['medfilter'])) {
    $listrdv = $listrdv->getElementsByKeyword("")->fetchAll(PDO::FETCH_ASSOC);
} else {
    //Vérification que l'id du médecin passé en paramètre existe
    $med = new MedecinDAO(new Medecin($_GET['medfilter'], null, null, null));
    if(!$med->existsFromId()) {
        header('Location: .'); //TODO: message expliquant pq la redirection
    }
    $listrdv = $listrdv->getElementsByIdMedecin($_GET['medfilter'], true)->fetchAll(PDO::FETCH_ASSOC);
}

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

    // Si le jour courant est aujourd'hui
    if ($today == $date) $week .= '<td class="day today">'.$day;
    else $week .= '<td class="day">'.$day;

    // Nombre de consultations sur le jour
    $nbconsult = 0;
    // S'il y a des consultations
    foreach($listrdv as $rdv) {
        $daterdv = new DateTime($rdv["date_heure_rdv"]);
        $dateday = new DateTime($date);
        if($daterdv->format("Y-m-d") == $dateday->format("Y-m-d")) $nbconsult = $nbconsult + 1;
    }

    // Si le nombre de consultations est positif
    if($nbconsult != 0) {
        $valget = "";
        if(isset($_GET['medfilter'])) $valget .= "?medfilter=".$_GET['medfilter']."&";
        else $valget .= "?";
        if(isset($_GET['ma'])) $valget .= "ma=".$_GET['ma']."&";
        $valget .= "date=".$date."#consultations";

        $week .= "<p class=\"nbconsult\"><a title=\"".$nbconsult." consultation(s)\" href=\"".$valget."\">".$nbconsult."</a></p>";
    }
    $week .= '</td>';

    // Si fin de semaine ou de mois
    if ($str % 7 == 6 || $day == $day_count) {

        // Ajout d'une cellule vide
        if($day == $day_count) $week .= str_repeat('<td class="day"></td>', 6 - ($str % 7));

        $weeks[] = '<tr>'.$week.'</tr>';

        // Semaine suivante
        $week = '';

    }

}

?>

<!DOCTYPE HTML>
<html>

  <?php include('../ressources/inc/head.html'); ?>

  <body>

    <?php include('../ressources/inc/nav.html'); ?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('../img/consultations.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Consultations</h1>
              <span class="subheading">Gestion des consultations</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            <!-- Ajouter une consultation -->

            <?php if(isset($_SESSION['updated'])) {
                switch($_SESSION['updated']) {
                    case 0: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Échec de la modification.
                        </div>
                        <?php break;
                    case 1: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> Succès : Modification effectuée.
                        </div>
                        <?php break;
                }
                unset($_SESSION['updated']);
            }

            if(isset($_SESSION['deleted'])) {
                switch($_SESSION['deleted']) {
                    case 1: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> Succès : Suppression effectuée.
                        </div>
                        <?php break;
                    case 2: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Suppression impossible.
                        </div>
                        <?php break;
                    case 3: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Consultation inexistante.
                        </div>
                        <?php break;
                }
                unset($_SESSION['deleted']);
            }

            if(isset($_SESSION['consult_added'])) {
                switch ($_SESSION['consult_added']) {
                    case 0: ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> Erreur : Ajout impossible.
                        </div>
                        <?php break;
                    case 1: ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> Succès : Consultation ajoutée.
                        </div>
                        <?php break;
                }
                unset($_SESSION['consult_added']);
            }
            ?>

            <form method="GET" class="form-inline">
                <div class="form-group control searchEntity">
                    <select name="medfilter" class="form-control medfilter">
                        <option value="" disabled selected>Médecin</option>
                        <?php
                        foreach($listmed as $data) { ?>
                            <option value="<?php echo $data['id_medecin'] ?>"><?php echo "Docteur ".$data['nom']?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="search">Filtrer</button>
                <div class="addEntity">
                    <a href="addConsult1.php" class="btn btn-info" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Nouvelle consultation</a>
                </div>
            </form>

            <br>
            <h3 class="calendartitle"><a href="?ma=<?php echo $prev; ?>"><i class="fa fa-chevron-left"></i></a> <?php echo $html_title; ?> <a href="?ma=<?php echo $next; ?>"><i class="fa fa-chevron-right"></i></a></h3>

            <br>
            <table class="table table-bordered">
                <tr>
                    <th class="headday">Dim</th>
                    <th class="headday">Lun</th>
                    <th class="headday">Mar</th>
                    <th class="headday">Mer</th>
                    <th class="headday">Jeu</th>
                    <th class="headday">Ven</th>
                    <th class="headday">Sam</th>
                </tr>
                <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
                ?>
            </table>

            <p>
                Les médecins travaillants au sein de ce centre médical ont des horaires fixes. Ils travaillent tous les jours, du <i>lundi</i> au <i>samedi</i>,
                de <i>08:00</i> à <i>17:30</i>.
                Si ces horaires sont voués à changer, merci de contacter le webmaster de MedManager.
            </p>

            <!-- Affichage des consultations -->
            <div id="consultations">
                <div class="popup_win">
                    <a class="close" href=""><i class="fa fa-times-circle close-btn"></i></a>
                    <?php if(!isset($_GET['date'])): ?>
                    <p>Erreur : Adresse invalide.</p>
                    <?php else: ?>
                        <h3>Consultations du <?php $datec = new DateTime($_GET['date']); echo $datec->format("d/m/Y"); ?></h3>
                        <?php if(isset($_GET['medfilter'])):
                            $medconsults = new MedecinDAO(new Medecin(null, null, null, null));
                            $medconsults = $medconsults->getElementById($_GET['medfilter']); ?>
                            <h4>Docteur <?php echo $medconsults['nom']." ".$medconsults['prenom']; ?></h4>
                            <ul><?php foreach($listrdv as $rdv) {
                                $usardv = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
                                $usardv = $usardv->getElementById($rdv['id_usager']);
                                $hdebutrdv = new DateTime($rdv['date_heure_rdv']); ?>
                                <li>
                                    <?php echo $hdebutrdv->format("H:i")." - ".$hdebutrdv->modify("+ ".$rdv['duree_rdv']."minutes")->format("H:i"); ?> | <?php echo $usardv['nom']." ".$usardv['prenom']; ?>
                                    <a href="modifConsult1.php?date=<?php echo $rdv['date_heure_rdv']; ?>&id_medecin=<?php echo $rdv['id_medecin']; ?>" class="actionConsult"><i class="fa fa-pencil"></i></a>
                                    <a href="supprConsult.php?id=<?php echo $rdv['date_heure_rdv']; ?>&id_medecin=<?php echo $rdv['id_medecin']; ?>" class="actionConsult"><i class="fa fa-times-circle-o"></i></a>
                                </li>
                            <?php } ?>
                            </ul>
                        <?php else:
                            foreach($listmed as $med) {
                                $nordv = "<li>Aucune consultation.</li>"?>
                                <h4>Docteur <?php echo $med['nom']." ".$med['prenom']; ?></h4>
                                <ul>
                                <?php foreach ($listrdv as $rdv) {
                                    $date_rdv = new DateTime($rdv['date_heure_rdv']);
                                    if ($rdv['id_medecin'] == $med['id_medecin'] && $date_rdv->format("Y-m-d") == $_GET['date']) {
                                        $usardv = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
                                        $usardv = $usardv->getElementById($rdv['id_usager']);
                                        $hdebutrdv = new DateTime($rdv['date_heure_rdv']);
                                        $nordv = "";?>
                                        <li>
                                            <?php echo $hdebutrdv->format("H:i") . " - " . $hdebutrdv->modify("+ " . $rdv['duree_rdv'] . "minutes")->format("H:i"); ?>
                                            | <?php echo $usardv['nom'] . " " . $usardv['prenom']; ?>
                                            <a href="modifConsult1.php?date=<?php echo $rdv['date_heure_rdv']; ?>&act_id_medecin=<?php echo $rdv['id_medecin']; ?>"
                                               class="actionConsult"><i class="fa fa-pencil"></i></a>
                                            <a href="supprConsult.php?date=<?php echo $rdv['date_heure_rdv']; ?>&act_id_medecin=<?php echo $rdv['id_medecin']; ?>"
                                               class="actionConsult"><i class="fa fa-times-circle-o"></i></a>
                                        </li>
                                    <?php }
                                }
                                echo $nordv; ?>
                                </ul>
                            <?php }
                        endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Fin affichage des consultations -->
        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
