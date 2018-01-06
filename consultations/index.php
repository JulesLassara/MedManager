<?php

require('../ressources/login/logincheck.php');
if(!isConnected()) {
    header('Location: ..');
}

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

            <form method="POST" class="form-inline">
                <div class="form-group floating-label-form-group control searchEntity">
                    <input type="text" class="form-control" placeholder="Exemple : John" name="keyword">
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
        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
