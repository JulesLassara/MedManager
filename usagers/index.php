<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
  header('Location: ..');
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
              <h1>Usagers</h1>
              <span class="subheading">Gestion des usagers</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

          <div class="card" style="width: 20rem;">
            <div class="card-block">
              <h4 class="card-title">Nom Prénom</h4>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><i class="fa fa-venus"></i> Femme</li>
              <li class="list-group-item"><i class="fa fa-map-marker"></i> 10 rue du Moulin - 31400 Toulouse</li>
              <li class="list-group-item"><i class="fa fa-calendar-plus-o"></i> 3 Mars 1987 - Paris</li>
              <li class="list-group-item"><i class="fa fa-id-card-o"></i> 1234 5678 9101</li>
              <li class="list-group-item"><i class="fa fa-user-circle-o"></i> Docteur Nom Prénom</li>
            </ul>
            <div class="card-block">
              <a href="#" class="card-link">Modifier</a>
              <a href="#" class="card-link">Supprimer</a>
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
