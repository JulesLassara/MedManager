<?php
require('../ressources/login/logincheck.php');
if(!isConnected()) {
  header('Location: ..');
}

require('../ressources/Medecin.php');
require('../ressources/dao/MedecinDAO.php');

$med = new MedecinDAO(new Medecin(null, null, null, null));
$updated = -1;

if(isset($_POST['modifDoc']) && isset($_SESSION['id'])) {
    $med->setElement(new Medecin($_SESSION['id'], $_POST['civilite'], $_POST['nom'], $_POST['prenom']));
    if($med->update()) {
        $updated = 1;
        $res = $med->getElementsByKeyword("");
    } else {
        $updated = 0;
        $res = $med->getElementsByKeyword("");
    }
    unset($_SESSION['id']);
} else if(isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
    $valuesmed = $med->getElementById($_GET['id']);
    if($valuesmed == null) {
        header('Location: .');
    } else {
        $med->setElement(new Medecin($_GET['id'], $valuesmed['civilite'], $valuesmed['nom'], $valuesmed['prenom']));
    }
} else if(isset($_POST['search'])) {
    $res = $med->getElementsByKeyword($_POST['keyword']);
} else {
    $res = $med->getElementsByKeyword("");
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
              <h1>Médecins</h1>
              <span class="subheading">Gestion des médecins du centre</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

            <form method="POST" class="form-inline">
                    <div class="form-group floating-label-form-group control searchMed">
                        <input type="text" class="form-control" placeholder="Mot-clé" name="login">
                    </div>
                    <button type="submit" class="btn btn-primary" name="connect">Rechercher</button>
                    <div class="addMed">
                        <a href="addMedecin.php" class="btn btn-info" role="button" aria-pressed="true">Ajouter un médecin</a>
                    </div>
            </form>
            <hr>

            <?php
            $nb = 1;
            while($data = $res->fetch()) {
                if($nb == 1) {
                    $nb++; ?>
                    <div class="card-deck">
                <?php } ?>
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Docteur <?php echo $data['nom']." ".$data['prenom']; ?></h4>
                        <table>
                            <tbody>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-venus"></i>
                                    <span class="popup-text">Civilité</span>
                                </td>
                                <td><?php echo $data['civilite']; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            <a href="index.php?id=<?php echo $data['id_medecin']; ?>" class="card-link"><i class="fa fa-pencil"></i> Modifier</a>
                            <a href="supprMedecin.php?id=<?php echo $data['id_medecin']; ?>" class="card-link"><i class="fa fa-times-circle-o"></i> Supprimer</a>
                        </small>
                    </div>
                </div>
            <?php
                if($nb == 3) { ?>
                    </div>
                    <br>
                <?php $nb = 1;
                } else { $nb ++; }
            } ?>

            <div class="card-deck">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Docteur Nom Prénom</h4>
                        <table>
                            <tbody>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-venus"></i>
                                    <span class="popup-text">Sexe</span>
                                </td>
                                <td>Femme</td>
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
                        <h4 class="card-title">Docteur Nom Prénom</h4>
                        <table>
                            <tbody>
                            <tr>
                                <td class="icon-row-card bull_over">
                                    <i class="fa fa-venus"></i>
                                    <span class="popup-text">Sexe</span>
                                </td>
                                <td>Femme</td>
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
