<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
  header('Location: ..');
}

require("../ressources/dao/UsagerDAO.php");
require("../ressources/Usager.php");

require("../ressources/dao/MedecinDAO.php");
require("../ressources/Medecin.php");

require("../ressources/dao/RDVDAO.php");
require("../ressources/RDV.php");

// Liste des usagers
$usa = new UsagerDAO(new Usager(null, null, null, null, null, null, null, null, null));
$listusa = $usa->getElementsByKeyword("");

// Liste des médecins
$med = new MedecinDAO(new Medecin(null, null, null, null));
$listmed = $med->getElementsByKeyword("");

// Rdv
$rdv = new RDVDAO(new RDV(null, null, null, null));

// TRANCHES D'ÂGE

// Femmes
$fnbyoung = 0;
$fnbmid = 0;
$fnbold = 0;

// Hommes
$mnbyoung = 0;
$mnbmid = 0;
$mnbold = 0;

// Autre
$onbyoung = 0;
$onbmid = 0;
$onbold = 0;

// Date du jour
$today = new DateTime(date('Y-m-d', time()));

// Pour chaque usager
while($currentusa = $listusa->fetch(PDO::FETCH_ASSOC)) {
    $datenaissance = new DateTime($currentusa['date_naissance']);
    $age = $today->format("Y") - $datenaissance->format("Y");

    // Selon son sexe
    if($currentusa['civilite'] == "Homme") {
        if($age <= 25) $mnbyoung++;
        elseif($age <= 50) $mnbmid++;
        else $mnbold++;
    } elseif($currentusa['civilite'] == "Femme") {
        if($age <= 25) $fnbyoung++;
        elseif($age <= 50) $fnbmid++;
        else $fnbold++;
    } else {
        if($age <= 25) $onbyoung++;
        elseif($age <= 50) $onbmid++;
        else $onbold++;
    }

}

?>

<!DOCTYPE HTML>
<html>

  <?php include('../ressources/inc/head.html'); ?>

  <body>

  <?php include('../ressources/inc/nav.html'); ?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('../img/statistiques.jpg')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Statistiques</h1>
              <span class="subheading">Quelques chiffres sur l'activité du centre</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            <h4 class="titlestats">Tranches d'âges des usagers en fonction de leur sexe</h4>

            <table class="table table-striped">
                <thead>
                    <th>#</th>
                    <th>Hommes</th>
                    <th>Femmes</th>
                    <th>« Autres »</th>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Moins de 25 ans</th>
                    <td><?php echo $mnbyoung; ?></td>
                    <td><?php echo $fnbyoung; ?></td>
                    <td><?php echo $onbyoung; ?></td>
                </tr>
                <tr>
                    <th scope="row">Entre 25 ans et 50 ans</th>
                    <td><?php echo $mnbmid; ?></td>
                    <td><?php echo $fnbmid; ?></td>
                    <td><?php echo $onbmid; ?></td>
                </tr>
                <tr>
                    <th scope="row">Plus de 50 ans</th>
                    <td><?php echo $mnbold; ?></td>
                    <td><?php echo $fnbold; ?></td>
                    <td><?php echo $onbold; ?></td>
                </tr>
                </tbody>
            </table>

            <br>
            <hr>
            <br>

            <h4 class="titlestats">Durée totale des consultations effectuées par médecins</h4>

            <table class="table table-striped">
                <thead>
                <th>Médecins</th>
                <th>Durée totale</th>
                </thead>
                <tbody>

                <?php while($data = $listmed->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo "Docteur ".$data['nom']; ?></td>
                    <td><?php echo $rdv->getNbHeures($data['id_medecin']); ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
      </div>
    </div>

    <hr>

    <?php include('../ressources/inc/footer.html'); ?>

    <?php include('../ressources/inc/scripts.html'); ?>

  </body>
</html>
