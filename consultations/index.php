<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

// Liste des médecins du centre
$listmed = new MedecinDAO(new Medecin(null, null, null, null));
$listmed = $listmed->getElementsByKeyword("");

// Calendar
require('../ressources/Calendar.php');

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

            <?php
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

            <form method="POST" class="form-inline">
                <div class="form-group control searchEntity">
                    <select name="medfilter" class="form-control medfilter">
                        <option value="" disabled selected>Médecin</option>
                        <?php
                        while($data = $listmed->fetch()) { ?>
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
        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
