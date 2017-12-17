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

          <div class="card-deck">
            <div class="card">
              <div class="card-block">
                <h4 class="card-title">Nom Prénom</h4>
                <table>
                  <tbody>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-venus"></i>
                        <span class="popup-text">Sexe</span>
                      </td>
                      <td>Femme</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-map-marker"></i>
                        <span>Adresse</span>
                      </td>
                      <td>10 rue du Moulin - 31400 Toulouse</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-calendar-plus-o"></i>
                        <span>Date et lieu de naissance</span>
                      </td>
                      <td>3 Mars 1987 - Paris</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-id-card-o"></i>
                        <span>Numéro de sécurité sociale</span>
                      </td>
                      <td>1234 5678 9101</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-user-circle-o"></i>
                        <span>Médecin référent</span>
                      </td>
                      <td>Docteur Nom Prénom</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <a href="#" class="card-link"><i class="fa fa-pencil"></i> Modifier</a>
                  <a href="#" class="card-link"><i class="fa fa-times-circle-o"></i> Supprimer</a>
                </small>
              </div>
            </div>
            <div class="card">
              <div class="card-block">
                <h4 class="card-title">Nom Prénom</h4>
                <table>
                  <tbody>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-venus"></i>
                        <span class="popup-text">Sexe</span>
                      </td>
                      <td>Femme</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-map-marker"></i>
                        <span>Adresse</span>
                      </td>
                      <td>10 rue du Moulin - 31400 Toulouse</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-calendar-plus-o"></i>
                        <span>Date et lieu de naissance</span>
                      </td>
                      <td>3 Mars 1987 - Paris</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-id-card-o"></i>
                        <span>Numéro de sécurité sociale</span>
                      </td>
                      <td>1234 5678 9101</td>
                    </tr>
                    <tr>
                      <td class="icon-row-card bull_over">
                        <i class="fa fa-user-circle-o"></i>
                        <span>Médecin référent</span>
                      </td>
                      <td>Docteur Nom Prénom</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <a href="#" class="card-link"><i class="fa fa-pencil"></i> Modifier</a>
                  <a href="#" class="card-link"><i class="fa fa-times-circle-o"></i> Supprimer</a>
                </small>
              </div>
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
