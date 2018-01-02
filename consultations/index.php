<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
  header('Location: ..');
}

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

?>

<!DOCTYPE HTML>
<html>

  <?php include('../ressources/inc/head.html'); ?>

  <body>

    <?php include('../ressources/inc/nav.html'); ?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
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

            <form method="POST" class="form-inline">
                <div class="form-group floating-label-form-group control searchEntity">
                    <input type="text" class="form-control" placeholder="Exemple : John" name="keyword">
                </div>
                <button type="submit" class="btn btn-primary" name="search">Filtrer</button>
                <div class="addEntity">
                    <a href="#newConsultation" class="btn btn-info" role="button" aria-pressed="true"><i class="fa fa-plus"></i> Nouvelle consultation</a>
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

            <!-- NOUVELLE CONSULTATION -->
            <div id="newConsultation">
                <div class="popup_win">
                    <a class="close" href="#"><i class="fa fa-times-circle close-btn"></i></a>

                    <form method="POST">
                        <div class="control-group">
                            <div class="form-group controls">
                                <?php if(isset($civilitemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <select name="civilite" class="form-control">
                                    <option value="" disabled selected>Select your option</option>
                                    <option value="Homme">Homme</option>
                                    <option value="Femme">Femme</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Nom</label>
                                <?php if(isset($namemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <input name="name" type="text" class="form-control" placeholder="Nom">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="form-group floating-label-form-group controls">
                                <label>Prénom</label>
                                <?php if(isset($surnamemissing)): ?><p class="help-block text-danger"><i class="fa fa-remove"></i> Erreur : Veuillez renseigner ce champs.</p> <?php endif; ?>
                                <input name="surname" type="text" class="form-control" placeholder="Prénom">
                            </div>
                        </div>
                        <br>
                        <div class="form-group submit-right">
                            <button type="submit" class="btn btn-primary" name="addDoc">Ajouter</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
